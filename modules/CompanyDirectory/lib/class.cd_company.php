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

class cd_company
{
  private static $_rwkeys = array('company_name','address','telephone','fax','contact_email','website','details','picture_location',
				  'logo_location','latitude','longitude','hier_id','status','url','owner_id');
  private static $_rokeys = array('id','logo_path','owner_id','create_date','modified_date');
  private static $_metakeys = array('picture_path','picture_dir','logo_path','logo_dir','fields','categories','image_location');
  private $_data = array('status'=>'draft');
  private $_fields = array();
  private $_cats = array();
  private $_dirty;
  private $_deep;
  private $_ro;

  public function set_readonly($flag = TRUE)
  {
	// cannot be undone...
	$this->_ro = $flag;
  }

  public function __get($key)
  {
	$ret = null;
    $key = strtolower($key);
    if( in_array($key,self::$_rokeys) ) {
	  if( !isset($this->_data[$key]) ) return $ret;
	  return $this->_data[$key];
	}
    if( in_array($key,self::$_rwkeys) ) {
	  if( !isset($this->_data[$key]) ) return $ret;
	  return $this->_data[$key];
	}
    if( in_array($key,self::$_metakeys) ) {
	  $config = cmsms()->GetConfig();
	  switch( $key ) {
	  case 'fields':
		die('not done');
		break;

	  case 'categories':
		die('not done');
		break;

	  case 'image_location': // alias for picture location
		if( !isset($this->_data['picture_location']) ) return $ret;
		return $this->_data['picture_location'];

	  case 'picture_path':
		if( isset($this->_data['id']) && isset($this->_data['picture_location']) && $this->_data['picture_location'] != '' ) {
		  return $config['uploads_url'].'/uploads/companydirectory/id'.$this->_data['id'].'/'.$this->_data['picture_location'];
		}
		break;

	  case 'logo_path':
		if( isset($this->_data['id']) && isset($this->_data['logo_location']) && $this->_data['logo_location'] != '' ) {
		  return $config['uploads_url'].'/uploads/companydirectory/id'.$this->_data['id'].'/'.$this->_data['logo_location'];
		}
		break;

	  case 'picture_dir':
	  case 'logo_dir':
		if( isset($this->_data['id']) ) {
		  return cms_join_path($config['uploads_path'],'companydirectory/id'.$this->_data['id']);
		}
		break;
	  }
	}
    throw new CompanyDirectoryException('Attempt to retrieve invalid value from a Company record: '.$key);
  }


  public function __set($key,$value)
  {
	if( $this->_ro ) throw new CompanyDirectoryException('Attempt to modify a company record in readonly mode.');
    $key = strtolower($key);
    if( in_array($key,self::$_rwkeys) ) {
	  switch( $key ) {
	  case 'company_name':
	  case 'address':
	  case 'telephone':
	  case 'fax':
		if( empty($value) ) {
		  unset($this->_data[$key]);
		}
		else {
		  $x = $value;
		  if( cmsms()->is_frontend_request() ) $x = filter_var(trim($value),FILTER_SANITIZE_STRING);
		  $this->_data[$key] = $x;
		}
		$this->_dirty = TRUE;
		return;

	  case 'details':
        $value = trim(html_entity_decode($value));
        $value = cge_utils::clean_input_html($value);
		$this->_data[$key] = $value;
		$this->_dirty = TRUE;
		return;

	  case 'url':
	  case 'website':
		if( empty($value) ) {
		  unset($this->_data[$key]);
		}
		else {
		  $this->_data[$key] = filter_var(trim($value),FILTER_SANITIZE_STRING);
		}
		$this->_dirty = TRUE;
		return;

	  case 'contact_email':
		if( empty($value) ) {
		  unset($this->_data[$key]);
		}
		else {
		  if( !is_email($value) ) throw new CompanyDirectoryException('value for field '.$key.' is invalid');
		  $this->_data[$key] = trim($value);
		}
		$this->_dirty = TRUE;
		return;

	  case 'picture_location':
	  case 'logo_location':
		// get the picture file location
		// see if it is there.
		$this->_data[$key] = trim($value);
		$this->_dirty = TRUE;
		return;

	  case 'latitude':
	  case 'longitude':
		if( empty($value) ) {
		  unset($this->_data[$key]);
		}
		else {
		  if( !is_numeric($value) )	throw new CompanyDirectoryException('value for field '.$key.' is invalid');
		  if( $value < -180 || $value > 180 ) throw new CompanyDirectoryException('value for field '.$key.' is invalid');
		  $this->_data[$key] = $value;
		}
		$this->_dirty = TRUE;
		return;

	  case 'status':
		$value = strtolower(trim($value));
		if( !in_array($value,array('draft','published','disabled')) )
		  throw new CompanyDirectoryException('value '.$value.' for field '.$key.' is invalid');
		$this->_data[$key] = $value;
		$this->_dirty = TRUE;
		return;

	  case 'hier_id':
	  case 'owner_id':
		if( !is_numeric($value) ) throw new CompanyDirectoryException('value: '.$value.' for field '.$key.' is invalid');
		$value = (int)trim($value);
		$this->_data[$key] = $value;
		$this->_dirty = TRUE;
		return;

	  default:
		// should never get here.
	  }
	}

    throw new CompanyDirectoryException('Attempt to set invalid value '.$key.' into a company record');
  }


  public function setup_fields_and_cats()
  {
	if( $this->_deep || (is_array($this->_fields) && count($this->_fields)) ) return;

	$tmp = cd_utils::get_fielddefs(TRUE,TRUE);
	if( is_array($tmp) && count($tmp) ) {
	  $this->_fields = array();
	  for( $i = 0; $i < count($tmp); $i++ ) {
		$this->_fields[] = cge_array::to_object($tmp[$i]);
	  }
	}

	$cats = cd_utils::get_categories();
	if( is_array($cats) && count($cats) ) {
	  $this->_cats = array();
	  foreach( $cats as $one ) {
		$one->value = false;
		$this->_cats[] = $one;
	  }
	}

	$this->_deep = true;
  }

  public function get_field($key)
  {
    if( !$this->_deep && isset($this->_data['id']) && $this->_data['id'] > 0 ) $this->_load_deep();

	if( is_array($this->_fields) && count($this->_fields) ) {
	  if( is_numeric($key) ) {
		foreach( $this->_fields as $rec ) {
		  if( $rec->id == $key ) return $rec;
		}
	  }
	  else {
		foreach( $this->_fields as $rec ) {
		  if( $rec->name == $key ) return $rec;
		}
	  }

	  throw new CompanyDirectoryException('Attempt to retrieve value from unknown field '.$key);
	}
  }

  public function get_field_value($key)
  {
    $field = $this->get_field($key);
    if( isset($field->value) ) return $field->value;
  }

  public function list_fields()
  {
    if( !$this->_deep && isset($this->_data['id']) && $this->_data['id'] > 0 ) $this->_load_deep();

	$out = array();
	if( is_array($this->_fields) && count($this->_fields) ) {
	  foreach( $this->_fields as $rec ) {
		$out[] = $rec->name;
	  }
	}
	return $out;
  }

  public function get_fields()
  {
    if( !$this->_deep && isset($this->_data['id']) && $this->_data['id'] > 0 ) $this->_load_deep();
	if( is_array($this->_fields) && count($this->_fields) ) return $this->_fields;
  }

  /*
  public function delete_field($key,$delete_files = TRUE)
  {
	if( $this->_ro ) {
	  throw new CompanyDirectoryException('Attempt to modify a company record in readonly mode.');
	}

    if( !$this->_deep && $this->_data['id'] > 0 ) {
	  $this->_load_deep();
	}

	if( count($this->_fields) == 0 )
	  throw new CompanyDirectoryException('Attempt to set value for a field '.$key.' that does not exist');

	foreach( $this->_fields as $fkey => &$frec ) {
	  if( is_numeric($key) ) {
		if( $frec->id == $key ) {
		  // if it's a file field unlink the file(s)
		  if( $frec->type == 'file' || $frec->type == 'image' ) {
			@unlink(cms_join_path($this->logo_dir,'preview_'.$frec->value));
			@unlink(cms_join_path($this->logo_dir,'thumb_'.$frec->value));
			@unlink(cms_join_path($this->logo_dir,$frec->value));
		  }
		  // erase the record
		  unset($this->_fields[$fkey]);
		  $this->_dirty = true;
		  return;
		}
	  }
	  else {
		if( $frec->name == $key ) {
		  // if its a file field unlink the file(s)
		  if( $frec->type == 'file' || $frec->type == 'image' ) {
			@unlink(cms_join_path($this->logo_dir,'preview_'.$frec->value));
			@unlink(cms_join_path($this->logo_dir,'thumb_'.$frec->value));
			@unlink(cms_join_path($this->logo_dir,$frec->value));
		  }
		  // erase the record
		  unset($this->_fields[$fkey]);
		  $this->_dirty = true;
		  return;
		}
	  }
	}

	throw new CompanyDirectoryException('Attempt to set value for a field '.$key.' that does not exist');
  }
  */


  public function set_file_field($fldkey,$value,$tmp_fs)
  {
	if( $this->_ro ) throw new CompanyDirectoryException('Attempt to modify a company record in readonly mode.');
	if( !$this->id ) throw new CompanyDirectoryException('Attempt to set a file field in a company without an id.');

	if( !file_exists($tmp_fs) ) {
	  throw new CompanyDirectoryException('Attempt to set value for a file field '.$key.' and file does not exist');
	}

    if( !$this->_deep ) $this->_load_deep();
	if( count($this->_fields) == 0 ) throw new CompanyDirectoryException('Attempt to set value for a field '.$key.' that does not exist');

	foreach( $this->_fields as $fkey => &$frec ) {
	  if( is_numeric($key) ) {
		if( $frec->id == $key ) {
		  if( file_exists($tmp_fs) ) {
			// move the file to its perm location
			// should we play with extensions here?
			@cms_move_uploaded_file($tmp_fs,cms_join_path($this->logo_dir,$value));
			// generate thumbs and crap?
			$frec->value = $value;
			$this->_dirty = true;
		  }
		  return;
		}
	  }
	  else {
		if( $frec->name == $key ) {
		  if( file_exists($tmp_fs) ) {
			// move the file to its perm location
			// should we play with extensions here?
			@cms_move_uploaded_file($tmp_fs,cms_join_path($this->logo_dir,$value));
			// generate thumbs and crap?
			$frec->value = $value;
			$this->_dirty = true;
		  }
		  return;
		}
	  }
	}

	throw new CompanyDirectoryException('Attempt to set value for a field '.$key.' that does not exist');
  }

  public function set_field($key,$value)
  {
	if( $this->_ro ) throw new CompanyDirectoryException('Attempt to modify a company record in readonly mode.');
    if( !$this->_deep && isset($this->_data['id']) && $this->_data['id'] > 0 ) $this->_load_deep();
	if( count($this->_fields) == 0 )  throw new CompanyDirectoryException('Attempt to set value for a field '.$key.' that does not exist');

	foreach( $this->_fields as $fkey => &$frec ) {
	  if( is_numeric($key) ) {
		if( $frec->id == $key ) {
		  if( is_array($value) ) {
			if( $frec->type != 'multiselect' && $frec->type != 'activity' ) {
			  throw new CompanyDirectoryExcecption('Attempt to set an array value into an improper field');
			}
			$value = implode('~~',$value);
		  }
          if( $frec->type == 'textbox' && cmsms()->is_frontend_request() ) $value = filter_var(trim($value),FILTER_SANITIZE_STRING);
          if( $frec->type == 'textarea' ) {
            $value = html_entity_decode(trim($value));
            $value = cge_utils::clean_input_html($value);
          }
		  $frec->value = $value;
		  $this->_dirty = true;
		  return;
		}
	  }
	  else {
		if( $frec->name == $key ) {
		  if( is_array($value) ) {
			if( $frec->type != 'multiselect' && $frec->type != 'activity' ) throw new CompanyDirectoryExcecption('Attempt to set an array value into an improper field');
			$value = implode('~~',$value);
		  }
          if( $frec->type == 'textarea' ) {
            $value = html_entity_decode(trim($value));
            $value = cge_utils::clean_input_html($value);
          }
		  $frec->value = $value;
		  $this->_dirty = true;
		  return;
		}
	  }
	}

	throw new CompanyDirectoryException('Attempt to set value for a field '.$key.' that does not exist');
  }


  public function get_category($key)
  {
    if( !$this->_deep && isset($this->_data['id']) && $this->_data['id'] > 0 ) $this->_load_deep();
	if( count($this->_cats) == 0 ) throw new CompanyDirectoryException('Attempt1 to get value for invalid category '.$key);

	foreach( $this->_cats as $one ) {
	  if( is_numeric($key) ) {
		if( $one->id == $key ) return $one;
	  }
	  else {
		if( $one->name == $key ) return $one;
	  }
	}

	throw new CompanyDirectoryException('Attempt to get value for invalid category '.$key);
  }

  public function list_categories($names = TRUE)
  {
    if( !$this->_deep && isset($this->_data['id']) && $this->_data['id'] > 0 ) $this->_load_deep();

	$out = array();
	if( is_array($this->_cats) && count($this->_cats) ) {
	  foreach( $this->_cats as $rec ) {
		if( !isset($rec->value) || !$rec->value ) continue;
		if( $names ) {
		  $out[] = $rec->name;
		}
		else {
		  $out[] = $rec->id;
		}
	  }
	}
	return $out;
  }

  public function reset_categories()
  {
	if( $this->_ro ) throw new CompanyDirectoryException('Attempt to modify a company record in readonly mode.');
    if( !$this->_deep && isset($this->_data['id']) && $this->_data['id'] > 0 ) $this->_load_deep();
	if( !count($this->_cats) ) return;

	foreach( $this->_cats as &$onecat ) {
	  $onecat->value = 0;
	}
	$this->_dirty = TRUE;
  }


  public function set_category($key,$value = 1,$extra1 = '',$extra2 = '',$extra3 = '')
  {
	if( $this->_ro ) {
	  throw new CompanyDirectoryException('Attempt to modify a company record in readonly mode.');
	}

    if( !$this->_deep && isset($this->_data['id']) && $this->_data['id'] > 0 ) $this->_load_deep();
	if( !count($this->_cats) ) throw new CompanyDirectoryException('Attempt to get value for invalid category '.$key);

	$value = ($value)?1:0;
	foreach( $this->_cats as &$rec ) {
	  if( is_numeric($key) ) {
		if( $rec->id == $key ) {
		  $rec->value = $value;
		  $rec->extra1 = $extra1;
		  $rec->extra2 = $extra2;
		  $rec->extra3 = $extra3;
		  $this->_dirty = true;
		  return;
		}
	  }
	  else {
		if( $rec->id == $key ) {
		  $rec->value = $value;
		  $rec->extra1 = $extra1;
		  $rec->extra2 = $extra2;
		  $rec->extra3 = $extra3;
		  $this->_dirty = true;
		  return;
		}
	  }
	}

	throw new CompanyDirectoryException('Attempt to get value for invalid category '.$key);
  }


  public static function is_valid_key($key,$type = 'any')
  {
    $type = strtolower($type);
    if( $type == 'any' ) {
	  if( in_array($key,self::$_rwkeys) ) return TRUE;
	  if( in_array($key,self::$_rokeys) ) return TRUE;
	  if( in_array($key,self::$_metakeys) ) return TRUE;
	}
    else if( $type == 'rw' ) {
	  if( in_array($key,self::$_rwkeys) ) return TRUE;
	}
    else if( $type == 'ro' ) {
	  if( in_array($key,self::$_rokeys) ) return TRUE;
	}
    else if( $type == 'meta' ) {
	  if( in_array($key,self::$_metakeys) ) return TRUE;
	}
    return FALSE;
  }


  public static function is_valid_field($key)
  {
	$fields = cd_utils::get_fielddefs(TRUE,TRUE);
	if( !is_array($fields) ) return FALSE;

	for( $i = 0; $i < count($fields); $i++ ) {
	  if( is_numeric($key) ) {
		if( $fields[$ii]->id == $key ) return TRUE;
	  }
	  else {
		if( $fields[$i]->name == $kkey ) return TRUE;
	  }
	}
	return FALSE;
  }


  public static function is_valid_category($key)
  {
	$cats = cd_utils::get_categories();
	if( !is_array($cats) || count($cats) == 0 ) return FALSE;

	for( $i = 0; $i < count($cats); $i++ ) {
	  if( is_numeric($key) ) {
		if( $cats[$i]->id == $key ) return TRUE;
	  }
	  else {
		if( $cats[$i]->name == $key ) return TRUE;
	  }
	}
	return FALSE;
  }


  public static function delete($compid)
  {
	if( $compid <= 0 ) throw new CompanyDirectoryException('Invalid Company id specified');
	$db = cmsms()->GetDb();

	// Get the category details
	$query = 'SELECT * FROM '.cms_db_prefix().'module_compdir_companies WHERE id = ?';
	$row = $db->GetRow($query, array($compid));
	if( !is_array($row) || count($row) == 0 ) throw new CompanyDirectoryException('Invalid Company id specified');

	// send an event
	$cdmod = cms_utils::get_module('CompanyDirectory');
	$candelete = TRUE;
	$cdmod->SendEvent('OnDeleteCompany',array('who'=>get_userid(FALSE),'cid'=>$compid,'candelete'=>&$candelete));
	if( $candelete == FALSE ) return FALSE;

	//Now remove the company
	$query = "DELETE FROM ".cms_db_prefix()."module_compdir_companies WHERE id = ?";
	$db->Execute($query, array($compid));

	//And remove it from any entries
	$query = "DELETE FROM ".cms_db_prefix()."module_compdir_fieldvals WHERE company_id = ?";
	$db->Execute($query, array($compid));

	//And remove it from any categories
	$query = "DELETE FROM ".cms_db_prefix()."module_compdir_company_categories WHERE company_id = ?";
	$db->Execute($query, array($compid));

	// and from any searchs
	$query = 'DELETE FROM '.cms_db_prefix().'module_compdir_searchstats_res WHERE company_id = ?';
	$db->Execute($query, array($compid));

	// Remove the files
	$dir = cms_join_path($gCms->config['uploads_path'],'companydirectory','id'.$compid);
	cge_dir::recursive_remove_directory($dir);

	//Update search index
	$cdmod = cms_utils::get_module('CompanyDirectory');
	$module = cms_utils::get_search_module();
	if( $module ) $module->DeleteWords($cdmod->GetName(), $compid, 'company');

	audit($compid,$cdmod->GetName(),'Deleted Company');
	return TRUE;
  }


  public static function &load_by_id($id,$deep = FALSE)
  {
	if( $id <= 0 ) throw new CompanyDirectoryException('Invalid Company id specified');

	$db = cmsms()->GetDb();
	$query = 'SELECT * FROM '.cms_db_prefix().'module_compdir_companies WHERE id = ?';
	$data = $db->GetRow($query,array((int)$id));
	if( !is_array($data) ) throw new CompanyDirectoryException('Invalid Company id specified');

	return self::load_from_data($data,$deep);
  }


  public static function &load_from_data($data,$deep = FALSE)
  {
	$obj = new cd_company;
	foreach( $data as $key => $value ) {
	  if( in_array($key,self::$_rwkeys) || in_array($key,self::$_rokeys) ) $obj->_data[$key] = $value;
	}

	if( $deep ) $obj->_load_deep();
	return $obj;
  }


  public function validate($deep = TRUE)
  {
	$cdmod = cms_utils::get_module('CompanyDirectory');

	if( !isset($this->_data['owner_id']) ) throw new CompanyDirectoryException($cdmod->Lang('error_noowner'));

	if( !isset($this->_data['company_name']) || $this->_data['company_name'] == '' ) {
	  throw new CompanyDirectoryException($cdmod->Lang('nocompanynamegiven'));
	}

	if( (!isset($this->_data['url']) || $this->_data['url'] == '') && $cdmod->GetPreference('url_required',0) ) {
	  throw new CompanyDirectoryException($cdmod->Lang('error_urlrequired'));
	}

	if( (!isset($this->_data['url']) || $this->_data['url'] == '') && $cdmod->GetPreference('url_autocreate',0) ) {
	  $url = cd_utils::generate_url($this->_data['company_name']);
	  if( !$url ) throw new CompanyDirectoryException($cdmod->Lang('error_invalidname'));
	}

	if( isset($this->_data['website']) && $this->_data['website'] != '' && $cdmod->GetPreference('prepend_website_http') ) {
	  if( !startswith($this->_data['website'],'http') && !startswith($this->_data['website'],'ftp') ) {
		$this->_data['website'] = 'http://'.$this->_data['website'];
	  }
	}

	if( isset($this->_data['id']) && $this->_data['id'] > 0 ) {
	  // validate existing record.
	  if( $cdmod->GetPreference('allow_duplicate_companynames') &&
		  cd_utils::company_name_exists($this->_data['company_name'],$this->_data['id']) ) {
		throw new CompanyDirectoryException($cdmod->Lang('error_duplicate_company',$this->_data['company_name']));
	  }

	  if( isset($this->_data['url']) && $this->_data['url'] ) {
		if( !cd_utils::validate_url($this->_data['url'],TRUE,$this->_data['id']) ) {
		  throw new CompanyDirectoryException($cdmod->Lang('error_invalidurl'));
		}
	  }
	}
	else {
	  // validate new record.
	  if( $cdmod->GetPreference('allow_duplicate_companynames') && cd_utils::company_name_exists($this->_data['company_name']) ) {
		throw new CompanyDirectoryException($cdmod->Lang('error_duplicate_company',$this->_data['company_name']));
	  }

	  if( isset($this->_data['url']) && $this->_data['url'] ) {
		if( !cd_utils::validate_url($this->_data['url'],TRUE) ) throw new CompanyDirectoryException($cdmod->Lang('error_invalidurl'));
	  }
	}
  }

  public function save($deep = TRUE)
  {
	if( $this->_ro ) throw new CompanyDirectoryException('Attempt to modify a company record in readonly mode.');
    if( !$this->_dirty ) return;
	if( !$this->_deep ) $deep = FALSE;
	$this->validate($deep);

	$is_insert = FALSE;
    if( isset($this->_data['id']) && $this->_data['id'] > 0 ) {
	  $this->_update($deep);
	}
	else {
	  $this->_insert($deep);
	  $is_insert = TRUE;
	}
	if( $this->_deep ) {
	  $this->_save_deep();
    }

    $cdmod = cms_utils::get_module(MOD_COMPANYDIRECTORY);
    $this->set_readonly();
    if( $is_insert ) {
      $cdmod->SendEvent('OnAddCompany',array('who'=>get_userid(FALSE),'object'=>$this));
    }
    else {
      $cdmod->SendEvent('OnEditCompany',array('who'=>get_userid(FALSE),'object'=>$this));
    }
    $this->set_readonly(FALSE);
	$this->_dirty = FALSE;
  }


  protected function _insert($deep = TRUE)
  {
	$db = cmsms()->GetDb();
	$query = 'INSERT INTO '.cms_db_prefix().'module_compdir_companies
              (company_name,address,telephone,fax,contact_email,website,details,picture_location,
               logo_location,create_date,modified_date,status,latitude,longitude,owner_id,hier_id,url)
              VALUES (?,?,?,?,?,?,?,?,?,NOW(),NOW(),?,?,?,?,?,?)';
	$dbr = $db->Execute($query,array($this->_data['company_name'],
									 (isset($this->_data['address']))?$this->_data['address']:'',
									 (isset($this->_data['telephone']))?$this->_data['telephone']:'',
									 (isset($this->_data['fax']))?$this->_data['fax']:'',
									 (isset($this->_data['contact_email']))?$this->_data['contact_email']:'',
									 (isset($this->_data['website']))?$this->_data['website']:'',
									 (isset($this->_data['details']))?$this->_data['details']:'',
									 (isset($this->_data['picture_location']))?$this->_data['picture_location']:'',
									 (isset($this->_data['logo_location']))?$this->_data['logo_location']:'',
									 (isset($this->_data['status']))?$this->_data['status']:'',
									 (isset($this->_data['latitude']))?$this->_data['latitude']:null,
									 (isset($this->_data['longitude']))?$this->_data['longitude']:null,
									 (isset($this->_data['owner_id']))?$this->_data['owner_id']:null,
									 (isset($this->_data['hier_id']))?$this->_data['hier_id']:null,
									 (isset($this->_data['url']))?$this->_data['url']:''));
	if( !$dbr ) throw new CompanyDirectoryException('Error Inserting company data '.$db->sql.' --- '.$db->ErrorMsg());
	$this->_data['id'] = $db->Insert_ID();
  }

  protected function _update($deep = TRUE)
  {
	$db = cmsms()->GetDb();

	$query = 'UPDATE '.cms_db_prefix().'module_compdir_companies
              SET company_name = ?, address = ?, telephone = ?, fax = ?, contact_email = ?,
              website = ?, details = ?, picture_location = ?,
              logo_location = ?, status = ?, latitude = ?, longitude = ?, owner_id = ?,
              hier_id = ?, url = ?, modified_date = NOW() WHERE id = ?';
	$dbr = $db->Execute($query,array($this->_data['company_name'],
									 (isset($this->_data['address']))?$this->_data['address']:null,
									 (isset($this->_data['telephone']))?$this->_data['telephone']:null,
									 (isset($this->_data['fax']))?$this->_data['fax']:null,
									 (isset($this->_data['contact_email']))?$this->_data['contact_email']:null,
									 (isset($this->_data['website']))?$this->_data['website']:null,
									 (isset($this->_data['details']))?$this->_data['details']:null,
									 (isset($this->_data['picture_location']))?$this->_data['picture_location']:null,
									 (isset($this->_data['logo_location']))?$this->_data['logo_location']:null,
									 (isset($this->_data['status']))?$this->_data['status']:null,
									 (isset($this->_data['latitude']))?$this->_data['latitude']:null,
									 (isset($this->_data['longitude']))?$this->_data['longitude']:null,
									 (isset($this->_data['owner_id']))?$this->_data['owner_id']:null,
									 (isset($this->_data['hier_id']))?$this->_data['hier_id']:null,
									 (isset($this->_data['url']))?$this->_data['url']:null,
									 $this->_data['id']));

	if( !$dbr ) throw new CompanyDirectoryException('Error updating company data '.$db->sql.' --- '.$db->ErrorMsg());
  }

  private function _load_deep()
  {
	if( !isset($this->_data['id']) || $this->_data['id'] <= 0 ) return;

	$cdmod = cms_utils::get_module('CompanyDirectory');
	$this->_fields = cd_utils::get_fielddefs_for_company($this->_data['id'],true,true);
	$this->_cats = $cdmod->GetCategoriesForCompany($this->_data['id']);
	$this->_deep = TRUE;
  }

  private function _save_deep()
  {
	$db = cmsms()->GetDb();
	if( count($this->_fields) ) {
	  // clear field data
	  $query = 'DELETE FROM '.cms_db_prefix().'module_compdir_fieldvals
                WHERE company_id = ?';
	  $dbr = $db->Execute($query,array($this->_data['id']));
	  // ignore this error... as there may be no fields in the database yet.

	  $query = 'INSERT INTO '.cms_db_prefix().'module_compdir_fieldvals
                (company_id,fielddef_id,value,create_date,modified_date)
                VALUES (?,?,?,NOW(),NOW())';
	  foreach( $this->_fields as $rec ) {
		if( !isset($rec->value) || empty($rec->value) ) continue;
		$dbr = $db->Execute($query,array($this->_data['id'],$rec->id,$rec->value));
		if( !$dbr ) throw new CompanyDirectoryException('Error writing custom field data');
	  }
	}

	if( count($this->_cats) ) {
	  $query = 'DELETE FROM '.cms_db_prefix().'module_compdir_company_categories
                WHERE company_id = ?';
	  $dbr = $db->Execute($query,array($this->_data['id']));
	  // ignore this error... as there may be no fields in the database yet.

	  $query = 'INSERT INTO '.cms_db_prefix().'module_compdir_company_categories
                (company_id,category_id,extra1,extra2,extra3,create_date,modified_date)
                VALUES (?,?,?,?,?,NOW(),NOW())';
	  foreach( $this->_cats as $rec ) {
		if( !$rec->value ) continue;
		$dbr = $db->Execute($query,array($this->_data['id'],
										 $rec->id,
										 $rec->extra1,
										 $rec->extra2,
										 $rec->extra3));
		if( !$dbr ) throw new CompanyDirectoryException('Error writing custom field data');
	  }
	}
  }

  protected function get_hierarchy($id)
  {
    $all_hiers = cd_utils::get_hierarchy(FALSE);
    if( !$all_hiers ) return;

    foreach( $all_hiers as $row ) {
      if( $row['id'] == $id ) return $row;
    }
  }

  public function get_search_words($parms = array())
  {
	$terms = array();
	$terms[] = $this->company_name;
	$terms[] = $this->company_name; // yes, twice ... increased score.
	$terms[] = $this->address;
	$terms[] = $this->telephone;
	$terms[] = $this->fax;
	$terms[] = $this->details;
	$terms[] = $this->fax;

    if( $this->hier_id > 0 ) {
      $hier = $this->get_hierarchy($this->hier_id);
      if( $hier ) {
        $terms[] = $hier['long_name'];
      }
    }

	if( !isset($parms['exclude_fields']) ) {
	  $fields = cd_utils::get_fielddefs_by_name(TRUE,TRUE);
	  if( is_array($fields) && count($fields) ) {
		foreach( $fields as $key => $fld ) {
		  if( ($fld['type'] == 'textbox' || $fld['type'] == 'textarea') && $fld['public'] == 1 && $fld['admin_only'] == 0 ) {
			$tmp = $this->get_field($fld['id']);
			if( is_object($tmp) && isset($tmp->value) && $tmp->value ) $terms[] = $tmp->value;
		  }
		}
	  }
	}

	if( !isset($parms['exclude_category_extra']) ) {
	  $cats = $this->list_categories();
	  if( is_array($cats) && count($cats) ) {
		foreach( $cats as $onecat ) {
		  $obj = $this->get_category($onecat);
		  if( !is_object($obj) ) continue;
          $terms[] = $obj->long_name;
		  $terms[] = $obj->extra1;
		  $terms[] = $obj->extra2;
		  $terms[] = $obj->extra3;
		}
	  }
	}

	$out = '';
	foreach( $terms as $one ) {
	  $out .= $one.' ';
	}
	return $out;
  }

  public function delete_album_file($fdid,$filename)
  {
	if( $this->_ro ) throw new CompanyDirectoryException('Attempt to modify a company record in readonly mode.');
    if( !$this->_deep && isset($this->_data['id']) && $this->_data['id'] > 0 ) $this->_load_deep();
	if( !is_array($this->_fields) || count($this->_fields) == 0 ) return FALSE;

	foreach( $this->_fields as $rec ) {
	  if( $rec->id == $fdid && $rec->type == 'album' ) {
		if( isset($rec->value) && $rec->value ) {
		  $files = unserialize($rec->value);
		  if( in_array($filename,$files) ) {
			$config = cmsms()->GetConfig();
			$fn = cms_join_path($config['uploads_path'],'companydirectory','id'.$this->id,'album_'.$fdid,$filename);
			if( !file_exists($fn) ) audit($this->id,'CompanyDirectory','File '.$filename.' does not exist for album');
			@unlink($fn);

			$t = array();
			foreach( $files as $o ) {
			  if( $o != $filename ) $t[] = $o;
			}
			$rec->value = '';
			if( count($t) ) $rec->value = serialize($t);
			$this->set_field($fdid,$rec->value);
			return TRUE;
		  }
		}
		break;
	  }
	}
	return FALSE;
  }
} // end of class

#
# EOF
#
