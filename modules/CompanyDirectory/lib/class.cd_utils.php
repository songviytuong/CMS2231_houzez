<?php
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

final class cd_utils
{
  private static $_routes_loaded = FALSE;
  private static $_categories;
  private static $_fielddefs;
  private static $_fieldinfo_preload;
  private static $_geolocator;
  private static $_hierarchy;

  private function __construct() {}

  private static function load_routes()
  {
	if( self::$_routes_loaded ) return;

	cms_route_manager::load_routes();
	self::$_routes_loaded = TRUE;
  }


  public static function company_name_exists($name,$id = null)
  {
	$mod = cms_utils::get_module('CompanyDirectory');
	if( $mod->GetPreference('allow_duplicate_companynames',1) ) return FALSE;

	$db = cmsms()->GetDb();
	$query = 'SELECT id FROM '.cms_db_prefix().'module_compdir_companies WHERE company_name = ?';
	$parms = array($name);
	if( $id ) {
	  $query .= ' AND id != ?';
	  $parms[] = $id;
	}
	$tmp = $db->GetOne($query,$parms);
	if( $tmp ) return TRUE;
	return FALSE;
  }

  public static function generate_url($tname)
  {
      $turl = '';
      if( $tname == '' ) return $turl;

      $suffix = '';
      $count = 1;
      self::load_routes();
      $tname = munge_string_to_url($tname,false,true);
      while( $turl == '' && $count < 100 ) {
          $tmp = strtolower($tname);
          $tmp .= $suffix;
          $tmp = trim($tmp," /\t\r\n\0\x08");

          // make sure this url isn't taken.
          $route = cms_route_manager::find_match($tmp);
          if( $route ) {
              $count++;
              $suffix = '-'.$count;
          }
          else {
              // found one.
              $turl = $tmp;
              break;
          }
      }

      return $turl;
  }


  public static function validate_url($turl,$check_exists = false,$company_id = FALSE)
  {
      // check the provided/generated url.
      $turl = trim($turl," /\t\r\n\0\x08");
      if( empty($turl) || startswith($turl,'/') || endswith($turl,'/') ) return FALSE;

      // check for invalid chars.
      $translated = munge_string_to_url($turl,false,true);
      if( strtolower($translated) != strtolower($turl) ) return FALSE;

      if( $check_exists ) {
          $route = cms_route_manager::find_match($turl,TRUE);
          if( is_object($route) && $company_id ) {
              // found a matching url, just gotta confirm that the route doesn't match this company
              $def = $route->get_defaults();
              if( $route->get_dest() != 'CompanyDirectory' || !isset($def['companyid']) || $def['companyid'] != $company_id ) return FALSE;
          }
      }
      return TRUE;
  }


  private static function decode_dropdown_data($str)
  {
	if( !is_array($str) ) {
	  $tmp = explode("\n",$str);
	}
	else {
	  return $str;
	}

	$tmp2 = array();
    for( $i = 0; $i < count($tmp); $i++ ) {
	  if( strpos($tmp[$i],'=') === FALSE ) {
		$tmp2[trim($tmp[$i])] = trim($tmp[$i]);
	  }
	  else {
		list($okey,$ovalue) = explode('=',$tmp[$i],2);
		$okey = trim($okey);
		$ovalue = trim($ovalue);
		if( $okey && !$ovalue ) $ovalue = $okey;
		//if( !$okey && $ovalue ) $okey = $ovalue;
		$tmp2[$okey] = $ovalue;
	  }
	}
	array_flip($tmp2);
	return $tmp2;
  }


  public static function get_hierarchy($as_tree = FALSE,$parent_id = -1,$depth = 1)
  {
	$db = cmsms()->GetDb();

	if( !is_array(self::$_hierarchy) ) {
	  $query = 'SELECT * FROM '.cms_db_prefix().'module_compdir_hier ORDER BY hierarchy';
	  $tmp = $db->GetArray($query);
	  self::$_hierarchy = $tmp;
	}

	if( !$as_tree ) return self::$_hierarchy;
	if( !is_array(self::$_hierarchy) || count(self::$_hierarchy) == 0 ) return;

	$data = array();
	$hier = self::$_hierarchy;
	$get_tree = function($parent_id = -1,$depth = 0) use ($hier,&$data,&$get_tree) {
	  $out = array();
	  foreach( $hier as $one ) {
		if( $one['parent_id'] != $parent_id ) continue;

		$tmp = $get_tree($one['id'],$depth+1);
		if( is_array($tmp) && count($tmp) ) {
		  $one['children'] = $tmp;
		}
		$one['depth'] = $depth;
		$out[] = $one;
	  }
	  return $out;
	};
	$tree = $get_tree($parent_id);
	return $tree;
  }


  /**
   * Test if hierarchy id A exists in the tree and is equal to or a child of item B
   */
  public static function hierarchy_match_parent($A,$B)
  {
	if( $A == -1 ) return FALSE;
	if( $A == $B ) return TRUE;

	$list = self::get_hierarchy();
	if( !is_array($list) || count($list) == 0 ) return FALSE;

	$cur = $A;
	$n = 0;
	while( $cur != -1 && $n < 100 ) {
	  $n++;
	  foreach( $list as $item ) {
		if( $item['id'] == $cur ) {
		  $cur = $item['parent_id'];
		  break;
		}
	  }
	  if( $cur == $B ) return TRUE;
	}
	return FALSE;
  }

  public static function get_company($company_id,$detailpage = '',$deep = FALSE,$as_stdclass = TRUE,$summarypage = null)
  {
	$company_id = (int)$company_id;
	if( $company_id <= 0 ) return;

	$data = null;
	if( cge_tmpdata::exists('companydir_'.$company_id) ) {
	  $data = cge_tmpdata::get('companydir_'.$company_id);
	}
	else {
	  $db = cmsms()->GetDb();
	  $query = 'SELECT * FROM '.cms_db_prefix().'module_compdir_companies WHERE id = ?';
	  $data = $db->GetRow($query,array($company_id));
	  cge_tmpdata::set('companydir_'.$company_id,$data);
	}

	if( is_array($data) && count($data) ) {
	  if( !$as_stdclass ) cd_company_query::set_result_mode(cd_company_query::RESULTS_CD_COMPANY);
	  $obj = cd_company_query::get_company($data,$detailpage,$deep,$summarypage);
	  if( !$as_stdclass ) cd_company_query::set_result_mode(cd_company_query::RESULTS_STDCLASS);

	  return $obj;
	}
  }


  public static function get_hierarchy_list($hierid = -1,$none = TRUE)
  {
	$db = cmsms()->GetDb();
	$cdmod = cms_utils::get_module('CompanyDirectory');

	$items = array();
	if( $none ) $items['('.$cdmod->Lang('none').')'] = '-1';

	$hier = self::get_hierarchy();
	if( is_array($hier) && count($hier) > 0 ) {
	  $longname = null;
	  if( $hierid > 0 ) {
		// don't want this item, or any of its children.
		foreach( $hier as $one ) {
		  if( $one['id'] == $hierid ) {
			$longname = $one['long_name'];
			break;
		  }
		}
	  }

	  foreach( $hier as $one ) {
		if( $longname && startswith($one['long_name'],$longname) ) continue;
        $depth = (int) count(explode('|',$one['long_name'])) - 1;
        $str = str_repeat('&nbsp;&nbsp;',$depth).$one['name'];
        $items[$str] = $one['id'];
	  }
	}

	return $items;
  }


  public static function get_categories($asHash = FALSE,$byName = FALSE)
  {
	if( !self::$_categories ) {
	  $entryarray = array();
	  $db = cmsms()->GetDb();

	  $query = 'SELECT * FROM '.cms_db_prefix().'module_compdir_categories ORDER BY hierarchy ASC';
	  $dbresult = $db->Execute($query);
      if( $dbresult ) {
        while( !$dbresult->EOF ) {
          $onerow = cge_array::to_object($dbresult->fields);
          $entryarray[] = $onerow;
          $dbresult->MoveNext();
        }
      }

	  self::$_categories = $entryarray;
	}

	if( $asHash ) {
	  $tmp = array();
	  foreach( self::$_categories as $one ) {
		if( $byName ) {
		  $tmp[$one->name] = $one;
		}
		else {
		  $tmp[$one->id] = $one;
		}
	  }
	  return $tmp;
	}

	return self::$_categories;
  }

  public static function expand_categories($list)
  {
    if( !is_array($list) || count($list) == 0 ) return;
    $categories = self::get_categories();
    if( !is_array($categories) || count($categories) == 0 ) return;

    $_find_children = function($id,$idx = 0) use ($categories,&$_find_children) {
      $out = array();
      for( $i = $idx; $i < count($categories); $i++) {
        $cat = $categories[$i];
        if( $cat->parent_id != $id ) continue;
        $out[] = $cat->id;
        $children = $_find_children($cat->id,$i+1);
        if( is_array($children) && count($children) ) $out = array_merge($out,$children);
      }

      if( count($out) ) return $out;
    };

    $out = array();
    foreach( $list as $id ) {
      $id = (int)$id;
      if( $id < 1 ) continue;

      $out[] = $id;
      $children = $_find_children($id);
      if( is_array($children) && count($children) ) $out = array_merge($out,$children);
    }
    if( count($out) ) return $out;
  }

  public static function get_category_ids($names)
  {
	if( !is_array($names) )	$names = explode(',',$names);
	if( !is_array($names) || count($names) == 0 ) return;

    $categories = self::get_categories();
    if( !is_array($categories) || count($categories) == 0 ) return;

    $out = array();
    foreach( $names as $name ) {
      $name = trim($name);
      if( !$name ) continue;
      if( is_numeric($name) && (int)$name == $name ) {
        $out[] = (int)$name;
      }
      else {
        // look by long name... first fix it up to correct silly errors.
        $name = str_replace('|',' | ',$name);
        $name = str_replace('  ',' ',$name);
        foreach( $categories as $one ) {
          if( fnmatch($name,$one->long_name,FNM_CASEFOLD) && !in_array($one->id,$out) ) $out[] = $one->id;
          if( !strcasecmp($name,$one->name) && !in_array($one->id,$out) ) $out[] = $one->id;
        }
      }
    }
    if( count($out) ) return $out;
  }

  public static function expand_hierarchies($list)
  {
    if( !is_array($list) || count($list) == 0 ) return;
	$hierdata = self::get_hierarchy();
    if( !is_array($hierdata) || count($hierdata) == 0 ) return;

    $_find_children = function($id,$idx = 0) use ($hierdata,&$_find_children) {
      $out = array();
      for( $i = $idx; $i < count($hierdata); $i++) {
        $hier = $hierdata[$i];
        if( $hier['parent_id'] != $id ) continue;
        $out[] = $hier['id'];
        $children = $_find_children($hier['id'],$i+1);
        if( is_array($children) && count($children) ) $out = array_merge($out,$children);
      }

      if( count($out) ) return $out;
    };

    $out = array();
    foreach( $list as $id ) {
      $id = (int)$id;
      if( $id < 1 ) continue;

      $out[] = $id;
      $children = $_find_children($id);
      if( is_array($children) && count($children) ) $out = array_merge($out,$children);
    }
    if( count($out) ) return $out;
  }

  public static function get_hierarchy_ids($names)
  {
	if( !is_array($names) )	$names = explode(',',$names);
	if( !is_array($names) || count($names) == 0 ) return;

	$hierdata = self::get_hierarchy();
    if( !is_array($hierdata) || count($hierdata) == 0 ) return;

    $out = array();
    foreach( $names as $name ) {
      $name = trim($name);
      if( !$name ) continue;
      if( is_numeric($name) && (int)$name == $name ) {
        $out[] = (int)$name;
      }
      else {
        // gonna use the long name
        $name = str_replace('|',' | ',$name);
        $name = str_replace('  ',' ',$name);
        foreach( $hierdata as $one ) {
          if( fnmatch($name,$one['long_name'],FNM_CASEFOLD) && !in_array($one['id'],$out) ) $out[] = $one['id'];
          if( !strcasecmp($name,$one['name']) && !in_array($one['id'],$out) ) $out[] = $one->id;
        }
      }
    }
    if( count($out) ) return $out;
  }

  public static function get_fielddefs_by_id($admin = FALSE,$public = TRUE)
  {
	$tmp = self::get_fielddefs($admin,$public);
	if( is_array($tmp) && count($tmp) ) {
	  $data = array();
	  for( $i = 0; $i < count($tmp); $i++ ) {
		$row = $tmp[$i];
		$data[$row['id']] = $row;
	  }
	  return $data;
	}
  }

  public static function get_fielddefs_by_name($admin = FALSE,$public = TRUE)
  {
	$tmp = self::get_fielddefs($admin,$public);
	if( is_array($tmp) && count($tmp) ) {
	  $data = array();
	  for( $i = 0; $i < count($tmp); $i++ ) {
		$row = $tmp[$i];
		$data[$row['name']] = $row;
	  }
	  return $data;
	}
  }

  public static function get_fielddefs($admin = false,$public = true,$as_object = FALSE)
  {
	if( !is_array(self::$_fielddefs) ) {
		$db = cmsms()->GetDb();

		$query = 'SELECT * FROM '.cms_db_prefix().'module_compdir_fielddefs ORDER BY item_order';
		$dbr = $db->GetArray($query);
		if( is_array($dbr) ) {
		  for( $i = 0; $i < count($dbr); $i++ ) {
			switch( $dbr[$i]['type'] ) {
			case 'dropdown':
			case 'multiselect':
			  if( isset($dbr[$i]['dropdown_data']) && $dbr[$i]['dropdown_data'] ) {
				$dbr[$i]['options'] = cd_utils::decode_dropdown_data($dbr[$i]['dropdown_data']);
			  }
			  break;
			case 'icon':
			  if( self::can_geolocate() ) $dbr[$i]['options'] = self::get_icon_list();
			  break;
			}
		  }
		  self::$_fielddefs = $dbr;
		}
	}

	if( $admin == true && $public == true ) return self::$_fielddefs; // all fields.

	$result = array();
	for( $i = 0; $i < count(self::$_fielddefs); $i++ ) {
	  $row = self::$_fielddefs[$i];
	  if( $public == TRUE && $row['public'] > 0 ) {
		// publicly viewable
		$result[] = $row;
	  }
	  else if( $admin == TRUE && $row['admin_only'] > 0 ) {
		// only an administrator (not owner can modify these fields)
		$result[] = $row;
	  }
	  else if( $public == FALSE && $row['public'] <= 0 && $admin == FALSE && $row['admin_only'] <= 0 ) {
		// administrator or owner can modify these fields, but not publicly viewable
		$result[] = $row;
	  }
	}
	return $result;
  }

  public static function get_fielddefs_for_company($id,$admin = false,$public = true)
  {
	$fielddefs = self::get_fielddefs($admin,$public);
	if( count($fielddefs) == 0 ) return;
	self::preloadFieldData($id);
	if( !isset(self::$_fieldinfo_preload[$id]) ) return;

	$tmp = self::$_fieldinfo_preload[$id];
	$out = array();

	// do a cross reference... only return the fielddefs that match the criteria.
	$tmp2 = array_keys($tmp);
	foreach( $fielddefs as $k1 => $rec1 ) {
	  if( in_array($rec1['id'],$tmp2) ) $out[$rec1['id']] = $tmp[$rec1['id']];
	}
	return $out;
  }

  public static function preloadFieldData($ids)
  {
	if( !is_array($ids) && is_numeric($ids) ) $ids = array($ids);
	$tmp = array();
	for( $i = 0; $i < count($ids); $i++ ) {
	  $n = (int)$ids[$i];
	  if( $n < 0 ) continue;
	  if( is_array(self::$_fieldinfo_preload) && isset(self::$_fieldinfo_preload[$n]) ) continue;
	  $tmp[] = $n;
	}
	if( !is_array($tmp) || !count($tmp) ) return;
	sort($tmp);
	$idlist = array_unique($tmp);

	$db = cmsms()->GetDb();
	$query = 'SELECT fv.* FROM '.cms_db_prefix().'module_compdir_fieldvals fv WHERE fv.company_id IN ('.implode(',',$idlist).') ORDER BY fv.company_id,fv.fielddef_id';
	$dbr = $db->Execute($query);
	if( !$dbr ) return;

	if( !is_array(self::$_fieldinfo_preload) ) self::$_fieldinfo_preload = array();
	$fielddefs = self::get_fielddefs(true,true);

	// initialization
	foreach( $idlist as $compid ) {
	  if( isset(self::$_fieldinfo_preload[$compid]) ) continue;

	  self::$_fieldinfo_preload[$compid] = array();
	  foreach( $fielddefs as $field ) {
		$one = cge_array::to_object($field);
		$one->fielddef_id = $field['id'];
		self::$_fieldinfo_preload[$compid][$field['id']] = $one;
	  }
	}

	// fill with values.
	while( !$dbr->EOF ) {
	  $compid = $dbr->fields['company_id'];
	  $flddefid = $dbr->fields['fielddef_id'];
	  $value = $dbr->fields['value'];

	  if( self::$_fieldinfo_preload[$compid][$flddefid]->type == 'multiselect' ) {
		self::$_fieldinfo_preload[$compid][$flddefid]->selected = explode('~~',$value);
	  }
	  self::$_fieldinfo_preload[$compid][$flddefid]->value = $value;
	  $dbr->MoveNext();
	}
  }

  public static function smarty_getcategory($params,$smarty)
  {
      $out = null;

      if( isset($params['category']) ) {
          $val = (int) trim(cge_utils::get_param($params,'category'));
          if( $val > 0 ) {
              try {
                  $out = cd_category::load($val);
              }
              catch( \Exception $e ) {
                  // do nothing
              }
          }
      }

      if( isset($params['assign']) ) {
          $smarty->assign($params['assign'],$out);
          return;
      }
      return $out;
  }

  public static function smarty_selcategory($params,$smarty)
  {
      $prefix = '';
      $id = '';
      $name = 'cd_selcategory';
      $class = 'cd_selcategory';
      $multiple = '';
      $size = '';
      $selected = array();

      if( isset($params['prefix']) ) $prefix = trim($params['prefix']);
      if( isset($params['id']) ) $id = trim($params['id']);
      if( isset($params['name']) ) $name = trim($params['name']);
      if( isset($params['selected']) ) {
          $dat = $params['selected'];
          if( !is_array($dat) ) $dat = explode(',',$dat);
          $dat2 = array();
          foreach( $dat as $one ) {
              $one = (int)$one;
              if( $one > 0 ) $dat2[] = $one;
          }
          $selected = $dat2;
      }
      if( isset($params['class']) ) $class .= ' '.trim($params['class']);
      if( isset($params['multiple']) ) {
          $multiple = 'multiple';
          if( isset($params['size']) ) {
              $size = (int)trim($params['size']);
              if( $size <= 0 ) $size = '';
          }
      }

      // get the categories.
      $cats = self::get_categories(TRUE);
      if( !is_array($cats) || count($cats) == 0 ) return;

      // adjustments
      if( $size != '' ) $size = min($size,count($cats));

      $outname = $prefix.$name;
      if( $multiple != '' ) $outname .= '[]';

      // build the output.
      $out = '<select name="'.$outname.'"';
      if( $class ) $out .= ' class="'.$class.'"';
      if( $id ) $out .= ' id="'.$id.'"';
      if( $multiple != '' ) {
          $out .= ' multiple="multiple"';
          if( $size ) $out .= ' size="'.$size.'"';
      }
      $out .= '>';
      foreach( $cats as $id => $rec ) {
          $depth = max(0,count(implode('.',$rec->hierarchy))-1);
          $out .= '<option value="'.$id.'"';
          if( in_array($id,$selected) ) $out .= ' selected="selected"';
          $out .= '>'.str_repeat('&nbsp;&nbsp;',$depth).$rec->name.'</option>';
      }
      $out .= '</select>';

      if( isset($params['assign']) ) {
          $smarty->assign($params['assign'],$out);
          return;
      }
      return $out;
  }

  public static function smarty_selhierarchy($params,$smarty)
  {
	$prefix = '';
	$id = '';
	$name = 'cd_selhierarchy';
	$class = 'cd_selhierarchy';
	$selected = '';
	$none = 1;

	if( isset($params['prefix']) ) $prefix = trim($params['prefix']);
	if( isset($params['id']) ) $id = trim($params['id']);
	if( isset($params['name']) ) $name = trim($params['name']);
	if( isset($params['selected']) ) $selected = trim($params['selected']);
	if( isset($params['none']) ) $none = (int)$params['none'];

	// get the hierarchy as a flat list.
	$items = self::get_hierarchy_list(-1,$none);
	if( !is_array($items) || count($items) == 0 ) return;
	$items = array_flip($items);

	// build the output.
	$out = '<select name="'.$prefix.$name.'"';
    if( $class ) $out .= ' class="'.$class.'"';
    if( $id ) $out .= ' id="'.$id.'"';
	$out .= '>';
	foreach( $items as $id => $label ) {
	  $out .= '<option value="'.$id.'"';
	  if( $id == $selected ) $out .= ' selected="selected"';
	  $out .= '>'.$label.'</option>';
	}
	$out .= '</select>';

	if( isset($params['assign']) ) {
	  $smarty->assign($params['assign'],$out);
	  return;
	}
	return $out;
  }

  public static function smarty_initjs($params,$smarty)
  {
	static $cnt = 0;

	if( $cnt == 0 ) {
	  $cnt++;
	  $compdir = cms_utils::get_module('CompanyDirectory');
	  $scripturl = $compdir->GetModuleURLPath().'/lib/jquery.compdir.js';
	  $ajax_url = $compdir->create_url('cntnt01','ajax_selcompany').'&amp;showtemplate=false';
	  $ajax_url = str_replace('&amp;','&',$ajax_url);

	  $txt = '<script type="text/javascript">var compdir_choosecompany_ajax_url = "'.$ajax_url.'";</script>'."\n";
	  $txt .= '<script type="text/javascript" src="'.$scripturl.'"></script>'."\n";

	  if( isset($params['assign']) ) {
		$smarty->assign($params['assign'],$txt);
		return;
	  }
	  return $txt;
	}
  }

  public static function smarty_getcompany($params,$smarty)
  {
	if( !isset($params['id']) ) return;

	$detailpage = -1;
	if( isset($params['detailpage']) ) {
	  $cdmod = cms_utils::get_module('CompanyDirectory');
	  $tmp = $cdmod->resolve_alias_or_id($params['detailpage']);
	  if( $tmp > 0 ) $detailpage = $tmp;
	}
	$company = cd_utils::get_company((int)$params['id'],$detailpage,TRUE);
	if( is_object($company) ) {
	  if( isset($params['assign']) ) {
		$smarty->assign(trim($params['assign']),$company);
		return;
	  }
	  return $company;
	}
  }

  public static function smarty_hierbreadcrumb($params,$smarty)
  {
	$mod = cms_utils::get_module(MOD_COMPANYDIRECTORY);
	$delimiter = ' | ';
	$raw = 0;
	$hier = -1;
	$page = $smarty->get_template_vars('page_id');
	$class = null;
	$assign = null;
	$urlparms = array();

	foreach( $params as $key => $value ) {
	  switch( $key ) {
	  case 'raw':
		$raw = cms_to_bool($value);
		break;
	  case 'hier':
		$hier = (int)$value;
		break;
	  case 'delim':
		$delimiter = $value;
		break;
	  case 'class':
		$class = $value;
		break;
	  case 'assign':
		$assign = $value;
		break;
	  case 'page':
        $page = (int)$mod->resolve_alias_or_id($value,$page);
		break;
	  default:
		$urlparms[$key] = $value;
		break;
	  }
	}

	if( $hier < 1 ) return;
    if( $page < 1 ) return; // nothing to link to.

	// get the complete path to this hierarchy.
	$hierdata = self::get_hierarchy();
	if( !is_array($hierdata) || count($hierdata) == 0 ) return;

	$data = array();
	$fn = function($id) use ($hierdata,&$data,&$fn,&$mod,$page,$urlparms) {
	  foreach( $hierdata as $one ) {
		if( $one['id'] == $id ) {
		  // found the item.. build the url
		  $urlparms['hier'] = $id;
		  $one['url'] = $mod->create_url('cntnt01','default',$page,$urlparms);
		  array_unshift($data,$one); // push this item to the front of the list.
		  if( $one['parent_id'] != -1 ) $fn($one['parent_id']);
		}
	  }
	};
	$fn($hier);

	if( count($data) == 0 ) return;

	// now have to decide on output format.
	$out = null;
	if( $raw == FALSE ) {
	  // have to build links.
	  $addtext = '';
	  if( $class ) $addtext=' class="'.$class.'"';
	  $tmp = array();
	  foreach( $data as $one ) {
		$tmp[] = '<a href="'.$one['url'].'"'.$addtext.'>'.$one['name'].'</a>';
	  }
	  $out = implode($delimiter,$tmp);
	}
	else {
	  $out = $data;
	}

	if( $assign ) {
	  $smarty->assign($assign,$out);
	  return;
	}
	return $out;
  }

  private static function get_geolocator()
  {
	if( self::$_geolocator != null ) return self::$_geolocator;

	$module_list = ModuleOperations::get_modules_with_capability('geolocate');
	if( is_array($module_list) && count($module_list) ) {
	  foreach( $module_list as $mname ) {
		$res = cms_utils::get_module($mname);
		if( is_object($res) && method_exists($res,'GetIconList') && method_exists($res,'GetIconsFull') ) {
		  self::$_geolocator = $res;
		  return $res;
		}
	  }
	}
  }

  public static function can_geolocate()
  {
	$obj = self::get_geolocator();
	return is_object($obj);
  }

  public static function get_icon_list()
  {
	$obj = self::get_geolocator();
	if( !is_object($obj) ) return;

	return $obj->GetIconList();
  }

  public static function get_icons_full()
  {
	$obj = self::get_geolocator();
	if( !is_object($obj) ) return;

	return $obj->GetIconsFull();
  }

  public static function geolocate($address)
  {
	if( !$address ) return;
	$obj = self::get_geolocator();
	if( !is_object($obj) ) return;

	return $obj->GetCoordsFromAddress($address);
  }

  public static function update_hierarchy_positions()
  {
	self::$_hierarchy = null;
	$db = cms_utils::get_db();
	$query = 'SELECT id,iorder,parent_id,name FROM '.cms_db_prefix().'module_compdir_hier ORDER BY parent_id,iorder';
	$hier = $db->GetArray($query);

	$update_hier = function(&$hier,$parent_id = -1,$longname = '',$hierarchy = '') use (&$update_hier) {
	  foreach( $hier as &$row ) {
		if( $row['parent_id'] == $parent_id ) {
		  $row['longname'] = ($longname) ? $longname.' | '.$row['name'] : $row['name'];
		  $tmp = str_pad($row['iorder'],5,'0',STR_PAD_LEFT);
		  $row['hierarchy'] = ($hierarchy) ? $hierarchy.'.'.$tmp : $tmp;
		  $update_hier($hier,$row['id'],$row['longname'],$row['hierarchy']);
		}
	  }
	};

	$update_hier($hier);

	$query = 'UPDATE '.cms_db_prefix().'module_compdir_hier SET hierarchy = ?, long_name = ? WHERE id = ?';
	foreach( $hier as $row ) {
	  $dbr = $db->Execute($query,array($row['hierarchy'],$row['longname'],(int)$row['id']));
	}
  }

  public static function save_search_to_stats(cd_company_filter $filter,$results)
  {
	if( !is_array($results) || count($results) == 0 ) throw new CompanyDirectoryException('Error no search results');

	$db = cms_utils::get_db();
	$query = 'INSERT INTO '.cms_db_prefix().'module_compdir_searchstats (date_searched, ip_address, feu_uid) VALUES (NOW(),?,?)';
	$feu_uid = null;
	$feu = cms_utils::get_module('FrontEndUsers');
	if( $feu ) $feu_uid = $feu->LoggedInId();
	$ip_address = cge_utils::get_real_ip();
	$dbr = $db->Execute($query,array($ip_address,$feu_uid));
	if( !$dbr ) throw new CompanyDirectoryException('Error inserting search data');
	$search_id = $db->Insert_ID();

	$query = 'INSERT INTO '.cms_db_prefix().'module_compdir_searchstats_vars (search_id,name,val) VALUES (?,?,?)';
	$data = $filter->get_params(FALSE);
	foreach( $data as $key => $val ) {
	  if( in_array($key,array('pagelimit','page','deep','onlycount','inline','detailpage','detailtemplate','nopretty','returnid',
							  'sortby','sortorder')) ) {
		continue;
	  }

	  if( $key == 'fields' ) {
		foreach( $data['fields'] as $rec ) {
		  $key = 'field_'.$rec['fldname'];
		  $val = $rec['fldval'];
		  if( is_array($val) ) $val = implode('^^',$val);
		  $dbr = $db->Execute($query,array($search_id,$key,$val));
		}
		continue;
	  }

	  if( is_array($val) ) $val = implode('^^',$val);
	  $dbr = $db->Execute($query,array($search_id,$key,$val));
	}

	$query = 'INSERT INTO '.cms_db_prefix().'module_compdir_searchstats_res (search_id,company_id) VALUES (?,?)';
	foreach( $results as $num ) {
	  $num = (int)$num;
	  if( $num < 1 ) continue;
	  $dbr = $db->Execute($query,array($search_id,$num));
	}
  }

  public static function smarty_cdsearchstats($params,$smarty)
  {
	$out = null;
	$list = get_parameter_value($params,'list');
	if( is_array($list) && count($list) > 0 ) {
	  $tmp = array();
	  foreach( $list as $one ) {
		if( (int)$one > 0 ) $tmp[] = (int)$one;
	  }

	  $tmp = array_unique($tmp);
	  if( count($tmp) ) {
		$list = $tmp;
		$days = (int)get_parameter_value($params,'days',365);
		if( $days > 0 ) {

		  $db = cmsms()->GetDb();
		  $query = 'SELECT R.company_id,COUNT(DISTINCT R.search_id) AS count FROM '.cms_db_prefix().'module_compdir_searchstats_res R
                    LEFT JOIN '.cms_db_prefix().'module_compdir_searchstats S ON R.search_id = S.id
                    WHERE S.date_searched BETWEEN ? AND NOW()
                    AND R.company_id IN ('.implode(',',$list).')
                    GROUP BY R.company_id';
		  $start_ut = time() - $days * 24 * 3600;
		  $start_ut = mktime(0,0,0,date('n',$start_ut),date('j',$start_ut),date('Y',$start_ut));
		  $start_dt = trim($db->DbTimeStamp($start_ut),"'");

		  $tmp = $db->GetArray($query,array($start_dt));
		  if( is_array($tmp) && count($tmp) ) {
			$out = array();
			foreach( $tmp as $rec ) {
			  $out[$rec['company_id']] = $rec['count'];
			}
		  }
		}
	  }
	}

	if( isset($params['assign']) ) {
	  $smarty->assign(trim($params['assign']),$out);
	  return;
	}
	return $out;
  }

  public static function create_fulltext_index()
  {
	$db = cmsms()->GetDb();
	$dict = NewDataDictionary($db);

	// first, drop the index(es) if they exist
	$sqlarray = $dict->DropIndexSQL('cd_ft',cms_db_prefix().'module_compdir_companies');
	$dict->ExecuteSQLArray($sqlarray);
	$sqlarray = $dict->DropIndexSQL('cd_ft_fv',cms_db_prefix().'module_compdir_fieldvals');
	$dict->ExecuteSQLArray($sqlarray);

	// now create the index(es)
	$db->Execute('ALTER TABLE '.cms_db_prefix().'module_compdir_companies ADD FULLTEXT INDEX cd_ft (company_name,address,website,details)');
	$db->Execute('ALTER TABLE '.cms_db_prefix().'module_compdir_fieldvals ADD FULLTEXT INDEX cd_ft_fv (value)');
  }
} // end of class

#
# EOF
#
?>
