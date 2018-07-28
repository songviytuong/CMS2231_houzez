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

class cd_company_filter implements ArrayAccess
{
  private $_origparams;
  private $_data = array();
  private static $_keys = array('returnid','name','phrase','sortby','sortorder','category','category2','category3','categoryid','hier', 'page','pagelimit','expiredowners','deep','onlycount','inline','detailpage','detailtemplate','showall','matchall','address','address2','lat','long','radius','id','status','sortbool','owner_id','modified_since','idlist','ownerlist','activityid','activitychildren','nopretty','nochildren');
  private $_sortby_fld = null;

  public function __construct($data = array())
  {
	if( isset($data['cd_encoded']) && isset($data['cd_sig']) ) {
	  // got encoded parameters
	  if( md5($data['cd_encoded'].__FILE__) != $data['cd_sig'] ) throw new CompanyDirectoryException('Invalid data signature');
	  $tmp = unserialize(base64_decode($data['cd_encoded']));
	  unset($data['cd_encoded'],$data['cd_sig']);
	  $data = array_merge($tmp,$data);
	}
	else if( isset($data['searchkey']) ) {
	  $tmp = $_SESSION['cd_'.$data['searchkey']];
	  $data = array_merge($tmp,$data);
	}

    unset($data['action'],$data['module']);
	$this->_origparams = $data;
    $cdmod = cms_utils::get_module('CompanyDirectory');
	$this->_data['id'] = 'cd'; // used in links.
    $this->_data['sortby'] = $cdmod->GetPreference('sortby','company_name');
    $this->_data['sortorder'] = $cdmod->GetPreference('sortorder','asc');
    $this->_data['pagelimit'] = 250;
    $this->_data['page'] = 1;
    $this->_data['expiredowners'] = $cdmod->GetPreference('frontend_showexpired',0);
    $this->_data['deep'] = 1;
    $this->_data['onlycount'] = 0;
	$this->_data['inline'] = 0;
	$this->_data['showall'] = 0;
	$this->_data['matchall'] = 1;
	$this->_data['status'] = -1;

    foreach( $data as $key => $value ) {
	  if( startswith($key,'cd_') ) $key = substr($key,3);
	  if( in_array($key,self::$_keys) ) $this[$key] = $value;
	  if( $key == 'fields' && is_array($value) ) {
		foreach( $value as $rec ) {
		  if( !is_array($rec) ) continue;
		  if( !isset($rec['fldname']) || !isset($rec['fldval']) ) continue;
		  $this->add_field_expr($rec['fldname'],$rec['fldval'],(isset($rec['expr']))?$rec['expr']:'AUTO',(isset($rec['type']))?$rec['type']:null);
		}
	  }
	}
  }


  public function offsetGet($key)
  {
    if( !in_array($key,self::$_keys) ) throw new CompanyDirectoryException('Get invalid key '.$key.' specified for cd_company_filter');

    if( isset($this->_data[$key]) ) return $this->_data[$key];

    $cdmod = cms_utils::get_module('CompanyDirectory');
	switch( $key ) {
	case 'detailpage':
	  $x = $cdmod->GetPreference('detailpage');
	  if( $x < 1 ) $x = cms_utils::get_current_pageid();
	  return $x;
	}
  }


  public function offsetSet($key,$value)
  {
    $cdmod = cms_utils::get_module('CompanyDirectory');

    if( !in_array($key,self::$_keys) ) throw new CompanyDirectoryException('Set: Invalid Key '.$key.'  specified for cd_company_filter');

    // validate data.
    switch( $key ) {
	case 'status':
	  $value = trim(strtolower($value));
	  break;

	case 'sortby':
	  $v2 = strtolower(trim($value));
	  switch( $v2 ) {
	  case 'name':
		$value = 'company_name';
		break;

	  case 'distance':
		if( !$this->have_coords() ) throw new CompanyDirectoryException('Invalid sortby for cd_company_filter (no coordinates set)');
		$value = 'distance';
		break;

	  case 'id':
	  case 'address':
	  case 'owner':
	  case 'company_name':
	  case 'phone':
	  case 'fax':
	  case 'email':
	  case 'website':
	  case 'created':
	  case 'modified':
	  case 'random':
	  case 'phrase':
		break;

	  case 'mostcheckins':
	  case 'mostfavorite':
	  case 'mostfavorites':
		$cgsoc = cms_utils::get_module(MOD_CGSOCIALAPP);
		if( !is_object($cgsoc) ) throw new CompanyDirectoryException('Invalid sortby for cd_company_filter (no cgsocialapp module)');
		break;

	  default:
		$good = false;
		if( startswith($value,'f:') ) {
		  list($junk,$fname,$ftype) = @explode(':',$value.'::::',3);
		  $fielddefs = cd_utils::get_fielddefs();
		  for( $i = 0; $i < count($fielddefs); $i++ ) {
			if( $fielddefs[$i]['name'] == $fname ) {
			  $this->_sortby_fld = $fielddefs[$i];
			  if( $fielddefs[$i]['type'] == 'checkbox' ) $this->_data['sortbool'] = 1;
			  $good = true;
			  break;
			}
		  }
		  if( $ftype[0] == ':' ) $ftype = '';
		  if( $good && $ftype != '' && $ftype != 'i' && $ftype != 'f') $good = false;
		}
		if( !$good ) throw new CompanyDirectoryException('Invalid Sortby Field');
		break;
	  }
	  break;

	case 'sortorder':
	  $value = strtolower(trim($value));
	  if( $value == '' ) $value = $cdmod->GetPreference('sortorder','asc');
	  if( $value != 'asc' && $value != 'desc' ) throw new CompanyDirectoryException('Invalid Sortby Value: '.$value);
	  break;

	case 'category':
	case 'category2':
	case 'category3':
	  // todo: check if it's a valid category.
	  break;

	case 'categoryid':
	  // todo: check if its a valid category id.
	  break;

	case 'activityid':
	case 'activitychildren':
	  $cgsoc = cms_utils::get_module(MOD_CGSOCIALAPP);
	  if( !is_object($cgsoc) ) throw new CompanyDirectoryException('Invalid sortby for cd_company_filter (no cgsocialapp module)');
	  break;

	case 'hier':
	  // todo: check if it's a valid hierarchy
	  break;

	case 'address':
	case 'address2':
	case 'id':
	  $value = trim($value);
	  break;

	case 'name':
	  // name..
	  break;

	case 'lat':
	case 'long':
	case 'radius':
	  // validation should handle this.
	  $value = (float)$value;
	  break;

	case 'detailtemplate':
	  // don't bother checking it
	  break;

	case 'detailpage':
	  if( !is_numeric($value) ) {
		// resolve the value to a page id... or use -1
		$value = $cdmod->resolve_alias_or_id($value);
		if( !$value ) $value = -1;
	  }
	  break;

	case 'showall':
	case 'returnid':
	case 'inline':
	case 'onlycount':
	case 'deep':
	case 'expiredowners':
	case 'matchall':
	case 'owner_id':
	case 'modified_since':
	  $value = (int)$value;
	  break;

	case 'page':
	case 'pagelimit':
	  $value = (int)$value;
	  $value = max(1,$value);
	  break;

	case 'idlist':
	  if( !is_array($value) ) $value = explode(',',$value);
	  $tmp = array();
	  foreach( $value as $one ) {
		$tmp2 = (int)$one;
		if( $tmp2 <= 0 ) continue;
		$tmp[] = $tmp2;
	  }
	  $value = array_unique($value);
	  break;

	case 'ownerlist':
	  if( !is_array($value) ) $value = explode(',',$value);
	  $tmp = array();
	  foreach( $value as $one ) {
		$tmp2 = (int)$one;
		if( $tmp2 <= 0 ) continue;
		$tmp[] = $tmp2;
	  }
	  $value = array_unique($value);
	  break;

    case 'nochildren':
	case 'nopretty':
	  $value = cms_to_bool($value);
	  break;

	default:
	  if( startswith($key,'f:') ) {
		list($fn,$fv,$expr) = explode(':',substr($key,2));
		$this->add_field_expr($fn,$fv,$expr);
	  }
	  break;
	}

    $this->_data[$key] = $value;
  }


  public function offsetExists($key)
  {
    if( !in_array($key,self::$_keys) ) throw new CompanyDirectoryException('Exists: Invalid Key '.$key.' specified for cd_company_filter');
    return isset($this->_data[$key]);
  }


  public function offsetUnset($key)
  {
    if( !in_array($key,self::$_keys) ) throw new CompanyDirectoryException('Unset: Invalid Key '.$key.' specified for cd_company_filter');
    return FALSE;
  }


  public function validate()
  {
	// check sortby against coords
	if( $this->_data['sortby'] == 'distance' && !$this->have_coords() ) {
	  throw new CompanyDirectoryException('Cannot sortby distance without specifying coordinates');
	}

	// todo: here we should validate hierarchy, and categorie(s)
  }


  public function &get_sort_fld()
  {
	$ret = null;
	$data = $this->get_sortby();
	if( startswith($data,'f:') ) {
	  list($junk,$fname,$ftype) = @explode(':',$data.'::::',3);
	  $fielddefs = cd_utils::get_fielddefs();
	  for( $i = 0; $i < count($fielddefs); $i++ ) {
		if( $fielddefs[$i]['name'] == $fname ) {
		  $ret = $fielddefs[$i];
		  break;
		}
	  }
	}
	return $ret;
  }


  public function get_sortby()
  {
    switch( $this->_data['sortby'] ) {
	case 'email':
	  return 'contact_email';
	case 'phone':
	  return 'telephone';
	case 'created':
	  return 'create_date';
	case 'modified':
	  return 'modified_date';
	case 'random':
	  return 'RAND()';
	case 'id':
	case 'company_name':
	case 'fax':
	case 'website':
	case 'status':
	case 'distance':
	default:
	  return $this->_data['sortby'];
	}
  }

  public function get_sortorder()
  {
    if( $this->_data['sortby'] == 'random' ) return '';
    return $this->_data['sortorder'];
  }

  public function get_params($serialize = TRUE)
  {
	if( !$serialize ) return $this->_origparams;

	$tmp = base64_encode(serialize($this->_origparams));
	$out = array('cd_encoded'=>$tmp,'cd_sig'=>md5($tmp.__FILE__));
	return $out;
  }

  public function have_coords()
  {
	if( !isset($this->_data['lat']) || !isset($this->_data['long']) ) return FALSE;
	if( !is_numeric($this->_data['lat']) || !is_numeric($this->_data['long']) ) return FALSE;

	return TRUE;
  }

  public function get_radius_miles()
  {
	$tmp = '';
	$val = 1;
	$suffix = 'mi';
	$str = $this->_data['radius'];

	if( preg_match('/^([0-9\.\,]+)(.*)$/',$str,$tmp) ) {
	  $val = (float)$tmp[1];
	  if( $tmp[2] ) $suffix = trim($tmp[2]);
	}

	$suffix = strtolower($suffix);
	switch( $suffix ) {
	case 'mi':
	case 'mile':
	case 'miles':
	  break;

	case 'km':
	case 'k':
	  $val = (float)$val * 0.621371192;
	  break;

	default:
	  if( $suffix ) {
		throw new CompanyDirectoryException('Invalid value specified for company search radius '.$this->_data['radius']." : $suffix");
	  }
	}

	return $val;
  }

  public function get_coords()
  {
	$res = array();
	$res['lat'] = floatval($this->_data['lat']);
	$res['long'] = floatval($this->_data['long']);

	return $res;
  }

  public function add_field_expr($fieldname,$fieldval,$expr = 'AUTO',$type = null)
  {
	if( !isset($this->_data['__field_expr__']) ) $this->_data['__field_expr__'] = array();

	if( !$fieldname || !$fieldval ) return;
	$this->_data['__field_expr__'][] = array('fldname'=>$fieldname, 'fldval'=>$fieldval, 'expr'=>$expr, 'type'=>$type);
  }

  public function get_field_exprs()
  {
	if( !isset($this->_data['__field_expr__']) ) return;
	return $this->_data['__field_expr__'];
  }

  public function clear_field_exprs()
  {
	if( !isset($this->_data['__field_expr__']) ) return;
	unset($this->_data['__field_expr__']);
  }
} // end of class

#
# EOF
#
?>