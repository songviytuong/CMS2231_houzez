<?php  /* -*- Mode: PHP; tab-width: 4; c-basic-offset: 2 -*- */
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: CompanyDirectory (c) 2004-6 by Ted Kulp (ted@cmsmadesimple.org)
#   Copyright 2006 - 2014 by Robert Campbell (calguy1000@cmsmadesimple.org)
#
#  An addon module for CMS Made Simple to allow management of and various ways to display
#  company information for use in directories etc.
#
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2005-2010 by Ted Kulp (wishy@cmsmadesimple.org)
# Visit the CMSMS homepage at: http://www.cmsmadesimple.org
#
#-------------------------------------------------------------------------
#
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# However, as a special exception to the GPL, this software is distributed
# as an addon module to CMS Made Simple.  You may not use this software
# in any Non GPL version of CMS Made simple, or in any version of CMS
# Made simple that does not indicate clearly and obviously in its admin
# section that the site was built with CMS Made simple.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
# Or read it online: http://www.gnu.org/licenses/licenses.html#GPL
#
#-------------------------------------------------------------------------
#END_LICENSE

class cd_company_query
{
  private $_filter;
  private $_queried;
  private $_count;
  private $_resultset;

  const RESULTS_CD_COMPANY = 1;
  const RESULTS_STDCLASS   = 2;
  const RESULTS_ARRAY      = 3;

  private static $_nopretty = 0;
  private static $_result_mode = self::RESULTS_STDCLASS;
  private static $_categorynamestoids;

  public function __construct(cd_company_filter $filter)
  {
    $this->_filter = $filter;
	if( $filter['nopretty'] ) self::$_nopretty = 1;
  }

  public static function set_nopretty($flag)
  {
	self::$_nopretty = $flag;
  }

  public static function set_result_mode($mode)
  {
	switch( $mode ) {
	case self::RESULTS_CD_COMPANY:
	case self::RESULTS_STDCLASS:
	case self::RESULTS_ARRAY:
	  self::$_result_mode = $mode;
	}
  }

  private function _query()
  {
    $db = cmsms()->GetDb();
    $query = 'FROM '.cms_db_prefix().'module_compdir_companies C';
    $query2 = 'FROM '.cms_db_prefix().'module_compdir_companies C';

	$this->_filter->validate();

	$req_where = array();
	$columns = array('C.*');
    $where = array();
	$having = array();
	$hcolumns = array();
    $parms = array();
    $sortby = $this->_filter->get_sortby();
    $sortorder = $this->_filter->get_sortorder();
	global $CMS_ADMIN_PAGE;

	if( $this->_filter['showall'] ) {
	  global $CMS_ADMIN_PAGE;
	  if( !isset($CMS_ADMIN_PAGE) ) {
		$req_where[] = 'C.status != ?';
		$parms[] = 'disabled';
	  }
	}
	else {
	  if( isset($CMS_ADMIN_PAGE) ) {
		// admin only, you can filter by whatever status.
		if( $this->_filter['status'] != -1 ) {
		  $req_where[] = 'C.status = ?';
		  $parms[] = $this->_filter['status'];
		}
	  }
	  else {
		// frontend, you can only show draft, or anything but disabled.
		if( $this->_filter['status'] == 'draft' ) {
		  $req_where[] = 'C.status = ?';
		  $parms[] = 'draft';
		}
		else {
		  $req_where[] = 'C.status = ?';
		  $parms[] = 'published';
		}
	  }
	}

	if( isset($this->_filter['idlist']) ) {
	  $tmp = $this->_filter['idlist'];
	  if( !is_array($tmp) ) $tmp = explode(',',$tmp);
	  $out = array();
	  for( $i = 0; $i < count($tmp); $i++ ) {
		$n = (int)$tmp[$i];
		if( $n < 1 ) continue;
	    if( !in_array($n,$out) ) $out[] = $n;
	  }
	  $req_where[] = 'C.id IN ('.implode(',',$out).')';
	}

	if( isset($this->_filter['ownerlist']) ) {
	  $tmp = $this->_filter['ownerlist'];
	  if( !is_array($tmp) ) $tmp = explode(',',$tmp);
	  $out = array();
	  for( $i = 0; $i < count($tmp); $i++ ) {
		$n = (int)$tmp[$i];
		if( $n < 1 ) continue;
	    if( !in_array($n,$out) ) $out[] = $n;
	  }
	  $req_where[] = 'C.owner_id IN ('.implode(',',$out).')';
	}
	else if( $this->_filter['owner_id'] ) {
	  $req_where[] = 'C.owner_id = ?';
	  $parms[] = (int)$this->_filter['owner_id'];
	}

	if( $this->_filter['modified_since'] ) $req_where[] = 'C.modified_date >= '.$db->DbTimeStamp($this->_filter['modified_since']);

    if( !$this->_filter['expiredowners'] ) {
	  $feu = cms_utils::get_module('FrontEndUsers');
	  if( $feu ) {
		$str = ' LEFT OUTER JOIN '.cms_db_prefix().'module_feusers_users fu ON fu.id = C.owner_id';
		$query .=  $str;
		$query2 .= $str;
		$str = '';
		$req_where[] = '(COALESCE(C.owner_id,-1) < 0 OR fu.expires > NOW())';
	  }
	}

	if( $this->_filter->have_coords() ) {
	  $rad = $this->_filter->get_radius_miles();
	  $coords = $this->_filter->get_coords();

	  $str = '(SELECT 3959 * acos(cos(radians('.$coords['lat'].'))
                 * cos(radians(C.latitude))
                 * cos(radians(C.longitude) - radians('.$coords['long'].'))
                 + sin(radians('.$coords['lat'].'))
                 * sin(radians(C.latitude)))) AS distance';
	  $columns[] = $str;
	  $hcolumns[] = $str;
	  $having[] = 'distance <= '.(int)$rad;
	}

	if( isset($this->_filter['phrase']) && $this->_filter['phrase'] != '' ) {
	  $str = ' LEFT JOIN '.cms_db_prefix().'module_compdir_fieldvals FV_A ON C.id = FV_A.company_id';
	  $query .= $str;
	  $query2 .= $str;
	  $where[] = '(MATCH(C.company_name,C.address,C.website,C.details) AGAINST (? IN BOOLEAN MODE) OR MATCH(FV_A.value) AGAINST (? IN BOOLEAN MODE))';
	  $parms[] = trim($this->_filter['phrase']);
	  $parms[] = trim($this->_filter['phrase']);
	}

    if( isset($this->_filter['name']) && $this->_filter['name'] != '') {
	  $str = $this->_filter['name'];
	  if( startswith($str,'::') ) {
		$str = substr($str,2);
		$where[] = 'C.company_name REGEXP ?';
	  }
	  else if( strpos($str,'*') !== FALSE ) {
		$str = trim(str_replace('*','%',$str));
		$where[] = 'C.company_name LIKE ?';
	  }
	  else {
		// error here?
		$str = substr($str,2);
		$where[] = 'C.company_name REGEXP ?';
	  }
	  $parms[] = $str;
	}

    if( isset($this->_filter['address']) && $this->_filter['address'] != '') {
	  $str = $this->_filter['address'];
	  $str = str_replace('*','%',$str);
	  $where[] = 'C.address LIKE ?';
	  $parms[] = $str;
	}

    if( isset($this->_filter['address2']) && $this->_filter['address2'] != '') {
	  $str = $this->_filter['address2'];
	  $str = str_replace('*','%',$str);
	  $where[] = 'C.address LIKE ?';
	  $parms[] = $str;
	}

    $sort_fld = $this->_filter->get_sort_fld();
    if( is_array($sort_fld) ) {
	  // sort by custom field.
	  $str = ' LEFT JOIN '.cms_db_prefix().'module_compdir_fieldvals FVA ON C.id = FVA.company_id AND FVA.fielddef_id = '.$db->qstr($sort_fld['id']);
	  $query .= $str;
	  $query2 .= $str;
	  $sortby = 'FVA.value';
	}

    if( isset($this->_filter['hier']) && $this->_filter['hier'] != '' ) {
	  $hierarchy = $this->_filter['hier'];
	  if( (is_numeric($hierarchy) && $hierarchy > 0) ) {
        // it's numeric.
        $list = array($hierarchy);
        if( !isset($this->_filter['nochildren']) && !$this->_filter['nochildren'] ) {
          $list = cd_utils::expand_hierarchies($list);
        }
        if( !is_array($list) ) $list = array();
        $where[] = 'C.hier_id IN ('.implode(',',$list).')';
      }
      else {
        // it's a string
        $list = cd_utils::get_hierarchy_ids($hierarchy);
        if( !isset($this->_filter['nochildren']) && $this->_filter['nochildren'] ) {
          $list = cd_utils::expand_hierarchies($list);
        }
        if( !is_array($list) ) $list = array($list);
        $where[] = 'C.hier_id IN ('.implode(',',$list).')';
      }
	}

	if( isset($this->_filter['activityid']) && $this->_filter['activityid'] > 0 ) {
	  $cgsoc = cms_utils::get_module(MOD_CGSOCIALAPP);
	  if( is_object($cgsoc) ) {
		$str = ' LEFT JOIN '.CGSOCIAL_TABLE_CHECKINS.' cgc ON C.id = cgc.location';
		$query .= $str;
		$query2 .= $str;
		if( isset($this->_filter['activitychildren']) && $this->_filter['activitychildren'] ) {
		  $tmp = 'SELECT hierarchy FROM '.CGSOCIAL_TABLE_ACTIVITIES.' WHERE id = ?';
		  $tmp = $db->GetOne($tmp,array((int)$this->_filter['activityid']));
		  if( $tmp ) {
			$tmp2 = 'SELECT id FROM '.CGSOCIAL_TABLE_ACTIVITIES.' WHERE hierarchy LIKE ?';
			$col = $db->GetCol($tmp2,array($tmp.'%'));
			if( is_array($col) && count($col) ) $where[] = 'cgc.activity IN ('.implode(',',$col).')';
		  }
		}
		else {
		  $where[] = 'cgc.activity = ?';
		  $parms[] = (int)$this->_filter['activityid'];
		}
	  }
	}

    if( isset($this->_filter['categoryid']) && $this->_filter['categoryid'] > 0 ) {
      $category_list = array($this->_filter['categoryid']);
      if( !isset($this->_filter['nochildren']) && !$this->_filter['nochildren'] ) {
        $category_list = cd_utils::expand_categories($category_list);
      }
	  $str = ' INNER JOIN '.cms_db_prefix().'module_compdir_company_categories CC ON CC.company_id = C.id';
	  $query .= $str;
	  $query2 .= $str;
      if( !is_array($category_list) ) $category_list = array();
	  $where[] = 'CC.category_id IN ('.implode(',',$category_list).')';
	}
    else if( isset($this->_filter['category']) && $this->_filter['category'] != '' ) {
	  // get the list of categories.
	  $ids = cd_utils::get_category_ids($this->_filter['category']);
      if( !isset($this->_filter['nochildren']) && !$this->_filter['nochildren'] ) {
        $ids = cd_utils::expand_categories($ids);
      }
      if( !is_array($ids) ) $ids = array();
      $str = ' INNER JOIN '.cms_db_prefix().'module_compdir_company_categories CC ON CC.company_id = C.id AND CC.category_id IN ('.implode(',',$ids).')';
      $query .= $str;
      $query2 .= $str;

      if( isset($this->_filter['category2']) && $this->_filter['category2'] != '' ) {
        // specify an and operation for categories.
        $ids2 = cd_utils::get_category_ids($this->_filter['category2']);
        if( !isset($this->_filter['nochildren']) && !$this->_filter['nochildren'] ) {
          $ids2 = cd_utils::expand_categories($ids2);
        }
        if( !is_array($ids2) ) $ids2 = array();
        $str = ' INNER JOIN '.cms_db_prefix().'module_compdir_company_categories CC2 ON CC2.company_id = C.id AND CC2.category_id IN ('.implode(',',$ids2).')';
        $query .= $str;
        $query2 .= $str;

        if( isset($this->_filter['category3']) && $this->_filter['category3'] != '' ) {
          // an and on more categories
          $ids3 = cd_utils::get_category_ids($this->_filter['category3']);
          if( !isset($this->_filter['nochildren']) && !$this->_filter['nochildren'] ) {
            $ids3 = cd_utils::expand_categories($ids3);
          }
          if( !is_array($ids3) ) $ids3 = array();
          $str = ' INNER JOIN '.cms_db_prefix().'module_compdir_company_categories CC3 ON CC3.company_id = C.id AND CC3.category_id IN ('.implode(',',$ids3).')';
          $query .= $str;
          $query2 .= $str;
		}
	  }
	}

	// other sortings that require additional joins.
	if( $sortby == 'mostcheckins' ) {
	  $cgsoc = cms_utils::get_module(MOD_CGSOCIALAPP);
	  if( is_object($cgsoc) ) {
  	    $str = ' LEFT JOIN (SELECT location,COUNT(id) AS cnt FROM '.CGSOCIAL_TABLE_CHECKINS.' GROUP BY location) cgc ON C.id = cgc.location';
		$query .= $str;
		$query2 .= $str;
		$columns[] = 'cgc.cnt AS checkins';
		$sortby = 'cgc.cnt';
	  }
	}
	else if( $sortby == 'mostfavorite' || $sortby == 'mostfavorites' ) {
	  $cgsoc = cms_utils::get_module(MOD_CGSOCIALAPP);
	  if( is_object($cgsoc) ) {
  	    $str = ' LEFT JOIN (SELECT location,COUNT(fuid) AS cnt FROM '.CGSOCIAL_TABLE_FAVORITES.' GROUP BY location) cgf ON C.id = cgf.location';
		$sortby = 'cgf.cnt';
		$columns[] = 'cgf.cnt AS favorites';
		$query .= $str;
		$query2 .= $str;
	  }
	}

	// field expressions should go as late as possible... to allow for better use of indexes.
	$field_exprs = $this->_filter->get_field_exprs();
	if( is_array($field_exprs) && count($field_exprs) ) {
	  $fielddefs = cd_utils::get_fielddefs(TRUE,TRUE);
	  if( is_array($fielddefs) && count($fielddefs) ) {
		$fielddefsbyname = cge_array::to_hash($fielddefs,'name');
		$sfx = 1;

		foreach( $field_exprs as $one_expr ) {
                  $tname = 'FV'.$sfx;

		  // get the fielddef id.
		  if( !isset($fielddefsbyname[$one_expr['fldname']]) ) {
			throw new Exception('invalid custom field name '.$one_expr['fldname'].' specified in query');
			continue;
		  }

		  $fid = (int)$fielddefsbyname[$one_expr['fldname']]['id'];
		  $ftype = $fielddefsbyname[$one_expr['fldname']]['type'];

		  $good = FALSE;
		  if( strtoupper($one_expr['expr']) == 'AUTO' && !is_array($one_expr['fldval'])) {
			switch( $ftype ) {
			case 'activity':
			case 'multiselect':
			case 'image':
			case 'file':
			  $one_expr['fldval'] = '%'.$one_expr['fldval'].'%';
			  $one_expr['expr'] = 'LIKE';
			  break;
			default:
			  $one_expr['expr'] = 'eq';
			  break;
			}
		  }

		  if( $one_expr['type'] != null ) {
			$one_expr['type'] = strtoupper($one_expr['type']);
			switch( $one_expr['type'] ) {
			case 'FLOAT':
            case 'REAL':
			case 'DECIMAL':
			  $one_expr['type'] = 'DECIMAL';
			  break;

			case 'INT':
			case 'INTEGER':
			case 'UNSIGNED':
			  $one_expr['type'] = 'UNSIGNED';
			  break;

			case 'SIGNED':
			  $one_expr['type'] = 'SIGNED';
			  break;

			default:
			  // invalid value, ignore it.
			  $one_expr['type'] = null;
			  break;
			}
		  }

		  if( is_array($one_expr['fldval']) ) {
			// an array... have to use LIKE because of the way multiselects are encoded in the database.
			$tmp = array();
			foreach( $one_expr['fldval'] as $one ) {
			  $tmp[] = $tname.'.value LIKE '.$db->qstr('%'.$one.'%');
			}
			$where[] = '('.implode(' OR ',$tmp).')';
			$good = true;
		  }
		  else {
			switch( strtoupper($one_expr['expr']) ) {
			case 'LIKE':
			  $good = TRUE;
			  $where[] = $tname.'.value LIKE ?';
			  $parms[] = '%'.$one_expr['fldval'].'%';
			  break;
			case 'SW':
			case 'STARTSWITH':
			  $good = TRUE;
			  $where[] = $tname.'.value LIKE ?';
			  $parms[] = $one_expr['fldval'].'%';
			  break;
			case 'EW':
			case 'ENDSWITH':
			  $good = TRUE;
			  $where[] = $tname.'.value LIKE ?';
			  $parms[] = '%'.$one_expr['fldval'];
			  break;
			case '<':
			case 'LT':
			  if( $one_expr['type'] ) {
				$where[] = 'CAST('.$tname.'.value AS '.$one_expr['type'].') < ?';
			  }
			  else {
				$where[] = $tname.'.value < ?';
			  }
			  $parms[] = $one_expr['fldval'];
			  $good = TRUE;
			  break;
			case '>':
			case 'GT':
			  if( $one_expr['type'] ) {
				$where[] = 'CAST('.$tname.'.value AS '.$one_expr['type'].') > ?';
			  }
			  else {
				$where[] = $tname.'.value < ?';
			  }
			  $parms[] = $one_expr['fldval'];
			  $good = TRUE;
			  break;
			case '<=':
			case 'LTE':
			case 'LE':
			  if( $one_expr['type'] ) {
				$where[] = 'CAST('.$tname.'.value AS '.$one_expr['type'].') <= ?';
			  }
			  else {
				$where[] = $tname.'.value < ?';
			  }
			  $parms[] = $one_expr['fldval'];
			  $good = TRUE;
			  break;
			case '>=':
			case 'GTE':
			case 'GE':
			  if( $one_expr['type'] ) {
				$where[] = 'CAST('.$tname.'.value AS '.$one_expr['type'].') >= ?';
			  }
			  else {
				$where[] = $tname.'.value < ?';
			  }
			  $parms[] = $one_expr['fldval'];
			  $good = TRUE;
			  break;
			case '=':
			case 'EQ':
			  if( $one_expr['type'] ) {
				$where[] = 'CAST('.$tname.'.value AS '.$one_expr['type'].') = ?';
			  }
			  else {
				$where[] = $tname.'.value = ?';
			  }
			  $parms[] = $one_expr['fldval'];
			  $good = TRUE;
			  break;
			case '!=':
			case 'ne':
			  if( $one_expr['type'] ) {
				$where[] = 'CAST('.$tname.'.value AS '.$one_expr['type'].') != ?';
			  }
			  else {
				$where[] = $tname.'.value < ?';
			  }
			  $parms[] = $one_expr['fldval'];
			  $good = TRUE;
			  break;
			}
		  }

		  if( $good ) {
			$str = ' LEFT JOIN '.cms_db_prefix().'module_compdir_fieldvals '.$tname.' ON C.id = '.$tname.'.company_id
                   AND '.$tname.'.fielddef_id = '.$db->qstr($fid);
			$query .= $str;
			$query2 .= $str;
		  }
		  $sfx++;
		}
	  }
	}

	// build the query
	$query = 'SELECT DISTINCT '.implode(',',$columns).' '.$query;
	$q2 = 'SELECT COUNT(DISTINCT C.id) AS count';
	if( count($hcolumns) > 0 ) $q2 .= ','.implode(',',$hcolumns);
	$query2 = $q2.' '.$query2;

	// build the post filter conditions.
	if( count($req_where) || count($where) ) {
	  $query = $query . ' WHERE ';
	  $query2 = $query2 . ' WHERE ';

	  if( count($req_where) ) {
		$query = $query . '('.implode(' AND ',$req_where).')';
		$query2 = $query2 . '('. implode(' AND ',$req_where).')';
	  }

	  if( count($where) ) {
		if( count($req_where) ) {
		  $query = $query . ' AND ';
		  $query2 = $query2 . ' AND ';
		}
		$expr = ' AND ';
		if( !$this->_filter['matchall'] ) $expr = ' OR ';
		$query = $query . '('.implode($expr,$where).')';
		$query2 = $query2 . '(' . implode($expr,$where).')';
	  }
	}

	// now do having stuff..
	if( count($having) ) {
	  $query .= ' HAVING '.implode(' AND ',$having);
	  $query2 .= ' HAVING '.implode(' AND ',$having);
	}

    // now do sorting stuff.
    $cast = '';
    if( is_object($sort_fld) ) {
	  list($junk,$field,$sort_type) = explode(':',$sortby);
	  if( $sort_type == 'i' ) {
		$cast = 'SIGNED INTEGER';
	  }
	  else if( $sort_type == 'f' ) {
		$cast = 'DECIMAL';
	  }
	}
	if( startswith($sortby,'f:') ) $sortby = 'company_name';

    if( $cast ) {
	  $query .= " ORDER BY CAST({$sortby} AS {$cast} $sortorder";
	}
    else {
	  $sorting = "$sortby $sortorder";
	  if( $sortby != 'company_name' ) {
		if( $this->_filter['sortbool'] ) {
		  $sorting = "$sortby DESC,company_name ASC";
		}
		else {
		  $sorting = "$sortby $sortorder,company_name ASC";
		}
	  }
	  $query .= " ORDER BY $sorting";
	}

	$tmp = $db->GetRow($query2,$parms);
	if( is_array($tmp) && count($tmp) && isset($tmp['count']) ) $this->_count = (int)$tmp['count'];
    $this->_queried = TRUE;
    if( !$this->_filter['onlycount'] ) {
	  $offset = ($this->_filter['page']-1)*$this->_filter['pagelimit'];
	  $this->_resultset = $db->SelectLimit($query, $this->_filter['pagelimit'], $offset, $parms);
	}
  }

  public function RecordCount()
  {
    if( !$this->_queried ) $this->_query();
	if( $this->_resultset ) return $this->_resultset->RecordCount();
  }

  public function MoveNext()
  {
    if( !$this->_queried ) $this->_query();
	if( $this->_resultset ) return $this->_resultset->MoveNext();
	return FALSE;
  }

  public function MoveFirst()
  {
    if( !$this->_queried ) $this->_query();
	if( $this->_resultset ) return $this->_resultset->MoveFirst();
	return FALSE;
  }

  public function Rewind()
  {
	return $this->MoveFirst();
  }

  public function MoveLast()
  {
    if( !$this->_queried ) $this->_query();
	if( $this->_resultset ) return $this->_resultset->MoveLast();
	return FALSE;
  }

  public function EOF()
  {
    if( !$this->_queried ) $this->_query();
	if( $this->_resultset ) return $this->_resultset->EOF();
	return TRUE;
  }

  public function Close()
  {
    if( !$this->_queried ) $this->_query();
	if( $this->_resultset ) return $this->_resultset->Close();
	return TRUE;
  }

  public function __get($key)
  {
	if( $key == 'EOF' ) return $this->EOF();
	if( $key == 'fields' && $this->_resultset && !$this->_resultset->EOF() ) return $this->_resultset->fields;
  }

  public function get_total_matches()
  {
    if( !$this->_queried ) $this->_query();
    return $this->_count;
  }

  public static function &get_company($data,$detailpage,$deep = FALSE,$summarypage = '')
  {
	switch( self::$_result_mode ) {
	case self::RESULTS_CD_COMPANY:
	  return self::get_cd_company($data,$deep);
	case self::RESULTS_STDCLASS:
	  return self::get_stdclass_company($data,$detailpage,$deep,$summarypage);
	case self::RESULTS_ARRAY:
	  $r = self::get_array_company($data,$detailpage);
	  return $r;
	}
  }

  private static function &get_cd_company($data,$deep = FALSE)
  {
	return cd_company::load_from_data($data,$deep);
  }

  private static function get_array_company($data,$detailpage,$deep = FALSE,$summarypage = '')
  {
	$obj = self::get_stdclass_company($data,$detailpage,$deep,$summarypage);
	$ndata = get_object_vars($obj);
	return $ndata;
  }

  private static function &get_stdclass_company($data,$detailpage,$deep = FALSE,$summarypage = '')
  {
	// todo: it'd be nice if this was a cd_company ... sometimes
	// but not for the default or detail views.
	$config = cmsms()->GetConfig();
	$cdmod = cms_utils::get_module('CompanyDirectory');
	if( $summarypage <= 0 ) $summarypage = cmsms()->GetContentOperations()->GetDefaultContent();

	$row = cge_array::to_object($data);
	$imagedir = cms_join_path($config['uploads_path'].'/companydirectory','id'.$row->id);
	$imageurl = $config['uploads_url']."/companydirectory/id{$row->id}";
	$parms = array();
	$parms['companyid'] = $row->id;
	cge_tmpdata::set('companydir_'.$row->id,$data);
	if( $detailpage < 1 ) $detailpage = $cdmod->GetPreference('detailpage',-1);
	if( $detailpage > 0 ) $row->canonical = $row->detail_url = $cdmod->create_url('cd_','details',$detailpage,$parms);
	$row->picture_path = $config['uploads_url'].'/companydirectory/id'.$row->id.'/'.$row->picture_location;
	$row->logo_path = $config['uploads_url'].'/companydirectory/id'.$row->id.'/'.$row->logo_location;
	if( !$deep ) return $row;

	$fielddefs = cd_utils::get_fielddefs_for_company($row->id,FALSE,TRUE);
	if( is_array($fielddefs) && count($fielddefs) ) {
	  $fdarray = array();
	  foreach( $fielddefs as $fid => $onedef ) {
		if( isset($onedef->value) && $onedef->value ) {
		  $value = $onedef->value;
		  if( $onedef->type == 'image' ) {
			$tmp = array('thumb_','preview_','');
			foreach( $tmp as $one ) {
			  $fn = cms_join_path($imagedir,$one.$value);
			  if( file_exists($fn) ) {
				$xx = $one.'url';
				$onedef->$xx = $imageurl.'/'.$one.$value;
			  }
			}
		  }
		  elseif( $onedef->type == 'file' ) {
			$fn = cms_join_path($imagedir,$value);
			if( file_exists($fn) ) $onedef->file_url = $imageurl.'/'.$value;
		  }
		  elseif( $onedef->type == 'dropdown' ) {
			if( isset($onedef->options[$onedef->value]) ) $onedef->dropdown_value = $onedef->options[$onedef->value];
		  }
		  elseif( $onedef->type == 'multiselect' ) {
			$vals = explode('~~',$onedef->value);
			if( is_array($vals) && count($vals) ) {
			  $tmp = array();
			  foreach( $vals as $one ) {
                if( isset($onedef->options[$one]) )	$tmp[$one] = $onedef->options[$one];
			  }
			  $onedef->printable = implode(', ',array_values($tmp));
			  $onedef->selected = $tmp;
			}
		  }
		  elseif( $onedef->type == 'album' ) {
			if( isset($onedef->value) && is_string($onedef->value) ) {
			  $onedef->value = unserialize($onedef->value);
			  $onedef->picture_path = $config['uploads_url'].'/companydirectory/id'.$row->id.'/album_'.$onedef->id.'/';
			}
		  }
		  elseif( $onedef->type == 'icon' ) {
			$icons = cd_utils::get_icons_full();
			if( is_array($icons) && isset($icons[$onedef->value]) ) $onedef->url = $icons[$onedef->value]['url'];
		  }
		  $fdarray[$onedef->name] = $onedef;
		}
	  }
	  $row->fields = $fdarray;
	}

	// get the categories.
	$categories = $cdmod->GetCategoriesForCompany($row->id);
	if( count($categories) > 0 ) {
	  $res = array();
	  foreach( $categories as $onecat ) {
		if( !isset($onecat->value) || !$onecat->value ) continue;

		$parms = array();
		$parms['categoryid'] = $onecat->id;
		if( self::$_nopretty ) $parms['nopretty'] = 1;
		$onecat->url = $cdmod->create_url('cntnt01','default',$summarypage,$parms);
		$res[$onecat->name] = $onecat;
	  }
	  if( count($res) ) $row->categories = $res;
	}
	return $row;
  }

  public function get_results($id = 'cd_',$summarypage = '',$detailpage = '')
  {
    if( !$this->_queried ) $this->_query();
    if( is_null($this->_resultset) ) throw new Exception('Result set does not exist');

	$cdmod = cms_utils::get_module('CompanyDirectory');
	if( (int)$summarypage < 1 ) {
	  $summarypage = cmsms()->GetContentOperations()->GetDefaultContent();
	  if( isset($this->_filter['returnid']) ) $summarypage = (int)$this->_filter['returnid'];
	}

	global $CMS_ADMIN_PAGE;
	if( (int)$detailpage < 1 && !isset($CMS_ADMIN_PAGE) ) {
	  if( $this->_filter['detailpage'] > 0 ) {
		$detailpage = (int)$this->_filter['detailpage'];
	  }
	  else {
		$detailpage = cmsms()->GetContentOperations()->GetDefaultContent();
		$tmp = (int) $cdmod->GetPreference('detailpage',-1);
		if( $tmp > 0) $detailpage = $tmp;
	  }
	}

	$config = cmsms()->GetConfig();
	$result = array();
	if( !$this->_resultset ) {
	  audit('','CompanyDirectory','WARNING: CD Query returned no results');
	  return $result;
	}

	if( !$this->_filter['deep'] ) {
	  while( $this->_resultset && !$this->_resultset->EOF ) {
		$data = $this->_resultset->fields;
		$result[$data['id']] = self::get_company($data,$detailpage,FALSE,$summarypage);
		$this->_resultset->MoveNext();
	  }
	}
	else {
	  $ids = array();
	  while( $this->_resultset && !$this->_resultset->EOF ) {
		$data = $this->_resultset->fields;
		$ids[] = $data['id'];
		$this->_resultset->MoveNext();
	  }
	  $this->_resultset->MoveFirst();

	  if( count($ids) ) {
		cd_utils::preloadFieldData($ids);
		$cdmod->preloadCategoryData($ids);

		while( !$this->_resultset->EOF ) {
		  $data = $this->_resultset->fields;
		  $result[$data['id']] = self::get_company($data,$detailpage,TRUE,$summarypage);
		  $this->_resultset->MoveNext();
		}
	  }
	}

    return $result;
  }


  public function get_result_count()
  {
	if( !$this->_queried ) $this->_query();
	if( !$this->_resultset ) return 0;
	return $this->_resultset->RecordCount();
  }


  public function &get_pagination()
  {
	if( !$this->_queried ) $this->_query();

	$pagination = new cd_summary_pagination($this->_filter,$this);
	return $pagination;
  }
} // end of class

#
# EOF
#
?>
