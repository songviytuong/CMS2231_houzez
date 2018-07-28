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
if (!isset($gCms)) exit;
if (!$this->CheckPermission('Modify Company Directory')) return;

if (isset($params['cancel'])) $this->Redirect($id, 'defaultadmin', $returnid);

$compid = '';
if (isset($params['compid'])) $compid = (int)$params['compid'];

$company_name = '';
if (isset($params['ex_company_name'])) $company_name = $params['ex_company_name'];

$address = '';
if (isset($params['address'])) $address = $params['address'];

$url = '';
if (isset($params['url'])) $url = $params['url'];

$latitude = '';
if (isset($params['latitude'])) $latitude = $params['latitude'];

$longitude = '';
if (isset($params['longitude'])) $longitude = $params['longitude'];

$hierpos = '';
if (isset($params['hierpos'])) $hierpos = $params['hierpos'];

$telephone = '';
if (isset($params['telephone'])) $telephone = $params['telephone'];

$fax = '';
if (isset($params['fax'])) $fax = $params['fax'];

$contact_email = '';
if (isset($params['contact_email'])) $contact_email = $params['contact_email'];

$website = '';
if (isset($params['website'])) $website = $params['website'];

$details = '';
if (isset($params['details'])) $details = $params['details'];

$status = '';
if (isset($params['status'])) $status = $params['status'];

$owner_id = -1;
if (isset($params['owner_id'])) $owner_id = $params['owner_id'];

$origname = '';
if (isset($params['origname'])) $origname = $params['origname'];

$can_cancel = 1;
if( isset($params['nocancel']) ) $can_cancel = 0;


$fielddefs = cd_utils::get_fielddefs_for_company($compid,TRUE);
$destdir = cms_join_path($gCms->config['uploads_path'],'companydirectory','id'.$compid);
$use_wysiwyg = (int)$this->GetPreference('adminwysiwyg',1);

function handle_initial_upload($id, $fieldname)
{
  $gCms = cmsms();
	$config = $gCms->GetConfig();

	if (!is_dir($config['uploads_path'] . DIRECTORY_SEPARATOR . 'companydirectory')) {
		@mkdir($config['uploads_path'] . DIRECTORY_SEPARATOR . 'companydirectory');
	}
	if (!is_dir($config['uploads_path'] . DIRECTORY_SEPARATOR . 'companydirectory' . DIRECTORY_SEPARATOR . 'tmp')) {
		@mkdir($config['uploads_path'] . DIRECTORY_SEPARATOR . 'companydirectory' . DIRECTORY_SEPARATOR . 'tmp');
	}

	@cms_move_uploaded_file($_FILES[$id . $fieldname]['tmp_name'], $config['uploads_path'] . DIRECTORY_SEPARATOR . 'companydirectory' . DIRECTORY_SEPARATOR . 'tmp' . DIRECTORY_SEPARATOR . basename($_FILES[$id . $fieldname]['name']));

	return basename($_FILES[$id . $fieldname]['name']);
}

function handle_tmp_upload($id, $itemid, $filename, $fieldname, &$db)
{
	$gCms = cmsms();
	$config = $gCms->GetConfig();

	if (!is_dir($config['uploads_path'] . DIRECTORY_SEPARATOR . 'companydirectory' . DIRECTORY_SEPARATOR . 'id' . $itemid)) {
	  @mkdir($config['uploads_path'] . DIRECTORY_SEPARATOR . 'companydirectory' . DIRECTORY_SEPARATOR . 'id' . $itemid);
	}
	if ($filename == 'deleteme') {
	  $oldfilename = $db->GetOne('SELECT ' . $fieldname . ' FROM '.cms_db_prefix().'module_compdir_companies WHERE id = ?', array($itemid));
	  if (is_file($config['uploads_path'] . DIRECTORY_SEPARATOR . 'companydirectory' . DIRECTORY_SEPARATOR . 'id' . $itemid . DIRECTORY_SEPARATOR . $oldfilename)) {
		unlink($config['uploads_path'] . DIRECTORY_SEPARATOR . 'companydirectory' . DIRECTORY_SEPARATOR . 'id' . $itemid . DIRECTORY_SEPARATOR . $oldfilename);
	  }
	  $db->Execute('UPDATE '.cms_db_prefix().'module_compdir_companies SET ' . $fieldname . ' = ? WHERE id = ?', array('', $itemid));
	}
	else if (is_file($config['uploads_path'] . DIRECTORY_SEPARATOR . 'companydirectory' . DIRECTORY_SEPARATOR . 'tmp' . DIRECTORY_SEPARATOR . $filename)) {
	  $oldfilename = $db->GetOne('SELECT ' . $fieldname . ' FROM '.cms_db_prefix().'module_compdir_companies WHERE id = ?', array($itemid));
	  if (is_file($config['uploads_path'] . DIRECTORY_SEPARATOR . 'companydirectory' . DIRECTORY_SEPARATOR . 'id' . $itemid . DIRECTORY_SEPARATOR . $oldfilename)) {
		unlink($config['uploads_path'] . DIRECTORY_SEPARATOR . 'companydirectory' . DIRECTORY_SEPARATOR . 'id' . $itemid . DIRECTORY_SEPARATOR . $oldfilename);
	  }
	  @rename($config['uploads_path'] . DIRECTORY_SEPARATOR . 'companydirectory' . DIRECTORY_SEPARATOR . 'tmp' . DIRECTORY_SEPARATOR . $filename, $config['uploads_path'] . DIRECTORY_SEPARATOR . 'companydirectory' . DIRECTORY_SEPARATOR . 'id' . $itemid . DIRECTORY_SEPARATOR . $filename);
	  $db->Execute('UPDATE '.cms_db_prefix().'module_compdir_companies SET ' . $fieldname . ' = ? WHERE id = ?', array($filename, $itemid));
	}
}

$image = '';
if (isset($_FILES[$id . 'imageupload']) && $_FILES[$id . 'imageupload']['tmp_name'] != '') {
  $image = handle_initial_upload($id, 'imageupload');
}
else if (isset($params['deleteimage'])) {
  $image = 'deleteme';
}
else if (isset($params['imagecurrent'])) {
  $image = $params['imagecurrent'];
}

$logo = '';
if (isset($_FILES[$id . 'logoupload']) && $_FILES[$id . 'logoupload']['tmp_name'] != '') {
  $logo = handle_initial_upload($id, 'logoupload');
}
else if (isset($params['deletelogo'])) {
  $logo = 'deleteme';
}
else if (isset($params['logocurrent'])) {
  $logo = $params['logocurrent'];
}

$fieldarray = array();

if (isset($params['submit'])) {
  // submit is pressed.
  $error = '';

  if( $company_name == '' ) $error = $this->Lang('nocompanynamegiven');

  if( !$error && $this->GetPreference('allow_duplicate_companynames') && cd_utils::company_name_exists($company_name,$compid) ) {
	$error = $this->Lang('error_duplicate_company',$company_name);
  }

  if( $error == '' && $url == '' && $this->GetPreference('url_required',0) ) {
	$error = $this->Lang('error_urlrequired');
  }

  if( !$error && $url == '' && $this->GetPreference('url_autocreate',0) ) {
	$url = cd_utils::generate_url($company_name);
	if( !$url ) $error = $this->Lang('error_invalidname');
  }

  if( !$error && $url != '' ) {
	$res = cd_utils::validate_url($url);
	if( !$res ) $error = $this->Lang('error_invalidurl');
  }

  // check file uploads from fielddefs
  if( !$error && count($fielddefs) ) {
	foreach( $fielddefs as $fielddef ) {
	  $fielddef = cge_array::to_object($fielddef);
	  switch( $fielddef->type ) {
	  case 'file':
	  case 'image':
		cge_dir::mkdirr($destdir);
		$uploader = cge_setup::get_uploader($id,$destdir);
		if( isset($fielddef->data) && $fielddef->data != '' ) {
		  $uploader->set_accepted_filetypes($fielddef->data);
		}
		$tmp = $uploader->check_upload('customfield','field-'.$fielddef->id);
		if( !$tmp && $uploader->get_error() != cg_fileupload::NOFILE ) {
		  $error = $this->GetUploadErrorMessage($uploader->get_error());
		  break;
		}
		break;
	  }
	}
  }

  try {
	// get the company
	$the_company = cd_company::load_by_id($compid,TRUE);
	$the_company->company_name = $company_name;
	$the_company->url = $url;
	$the_company->address = $address;
	$the_company->telephone = $telephone;
	$the_company->fax = $fax;
	$the_company->contact_email = $contact_email;
	$the_company->website = $website;
	$the_company->details = $details;
	if( $image ) $the_company->picture_location = $image;
	if( $logo ) $the_company->logo_location = $logo;
	$the_company->status = $status;
	$the_company->latitude = $latitude;
	$the_company->longitude = $longitude;
	$the_company->owner_id = $owner_id;
	$the_company->hier_id = $hierpos;
  }
  catch( Exception $e ) {
	$error = $e->GetMessage();
  }

  // handle errors
  if( $error ) {
	echo $this->ShowErrors($error);
  }
  else {
	// handle file upload custom fields.
	if( count($fielddefs) ) {
	  foreach( $fielddefs as $fielddef ) {
		$fielddef = cge_array::to_object($fielddef);
		switch( $fielddef->type ) {
		case 'file':
		  // handle the possibility that the user has chosen to delete the file.
		  if( isset($params['deletefile']['field-'.$fielddef->id]) && $fielddef->value != '' ) {
			// we've been told to delete the file.
			@unlink(cms_join_path($destdir,$fielddef->value));
			unset($params['customfield']['field_'.$fielddef->id]);
			$_REQUEST[$id.'customfield']['field-'.$fielddef->id] = '__DELETE__';
		  }
		  $uploader = cge_setup::get_uploader($id,$destdir);
		  $tmp = $uploader->handle_upload('customfield','','field-'.$fielddef->id);
		  if( !$tmp ) {
			if( $uploader->get_error() != cg_fileupload::NOFILE ) {
			  $error = $this->GetUploadErrorMessage($uploader->get_error());
			  break;
			}
		  }
		  else {
			// we're uploading a new file so delete the old one.
			@unlink(cms_join_path($destdir,$fielddef->value));
			@unlink(cms_join_path($destdir,'thumb_'.$fielddef->value));
			@unlink(cms_join_path($destdir,'preview_'.$fielddef->value));
			$_REQUEST[$id.'customfield']['field-'.$fielddef->id] = $tmp;
		  }
		  break;

		case 'image':
		  // handle the possibility where the user has chosen to delete a file.
		  if( isset($params['deletefile']['field-'.$fielddef->id]) && $fielddef->value != '' ) {
			// we've been told to delete the file.
			@unlink(cms_join_path($destdir,$fielddef->value));
			@unlink(cms_join_path($destdir,'thumb_'.$fielddef->value));
			@unlink(cms_join_path($destdir,'preview_'.$fielddef->value));
			$_REQUEST[$id.'customfield']['field-'.$fielddef->id] = '__DELETE__';
		  }
		  $uploader = cge_setup::get_uploader($id,$destdir);
		  $tmp = $uploader->handle_upload('customfield','','field-'.$fielddef->id);
		  if( !$tmp ) {
			if( $uploader->get_error() != cg_fileupload::NOFILE ) {
			  $error = $this->GetUploadErrorMessage($uploader->get_error());
			  break;
			}
		  }
		  else {
			// we're uploading a new file so delete the old one.
			@unlink(cms_join_path($destdir,$fielddef->value));
			@unlink(cms_join_path($destdir,'thumb_'.$fielddef->value));
			@unlink(cms_join_path($destdir,'preview_'.$fielddef->value));
			$_REQUEST[$id.'customfield']['field-'.$fielddef->id] = $tmp;
		  }
		  break;

		case 'multiselect':
		  if( isset($_REQUEST[$id.'customfield']['field-'.$fielddef->id]) ) {
            if( is_array($_REQUEST[$id.'customfield']['field-'.$fielddef->id]) ) {
              $_REQUEST[$id.'customfield']['field-'.$fielddef->id] = implode('~~',$_REQUEST[$id.'customfield']['field-'.$fielddef->id]);
            }
          }
          else {
            $_REQUEST[$id.'customfield']['field-'.$fielddef->id] = '';
          }
		  break;
		}
	  }

	  if (isset($_REQUEST[$id.'customfield'])) {
		foreach ($_REQUEST[$id.'customfield'] as $k=>$v) {
		  if (startswith($k, 'field-')) {
			if( $v == '__DELETE__' ) $v = null;
			$fid = substr($k, 6);
			$the_company->set_field($fid,$v);
		  }
		}
	  }
	} // if count fielddefs

	// reset categories to none.
	// and fill them back in based on what's in the form.
	$the_company->reset_categories();

	if (isset($_REQUEST[$id.'category'])) {
	  foreach ($_REQUEST[$id.'category'] as $k=>$v) {
		if (startswith($k, 'id-')) {
		  $fid = substr($k, 3);

		  $extra1 = '';
		  $extra2 = '';
		  $extra3 = '';
		  if( isset($_REQUEST[$id.'category_extra1'][$k]) ) {
			$extra1 = $_REQUEST[$id.'category_extra1'][$k];
		  }
		  if( isset($_REQUEST[$id.'category_extra2'][$k]) ) {
			$extra2 = $_REQUEST[$id.'category_extra2'][$k];
		  }
		  if( isset($_REQUEST[$id.'category_extra3'][$k]) ) {
			$extra3 = $_REQUEST[$id.'category_extra3'][$k];
		  }

		  $the_company->set_category($fid,1,$extra1,$extra2,$extra3);
		}
	  }
	}

	$the_company->save();

	if ($image != '') handle_tmp_upload($id, $compid, $image, 'picture_location', $db);
	  // deprecated, use the uploader stuff.

	if ($logo != '') handle_tmp_upload($id, $compid, $logo, 'logo_location', $db);
	  // deprecated, use the uploader stuff.

	//Update search index
	if( $the_company->status == 'published' ) {
	  $module = cms_utils::get_search_module();
	  if ($module) $module->AddWords($this->GetName(),$the_company->id,'company',$the_company->get_search_words());
	} else {
	  $module = cms_utils::get_search_module();
	  if ($module) $module->DeleteWords($this->GetName(),$the_company->id,'company');
	}

	audit($compid,$this->GetName(),'Edited company '.$company_name);
	$params = array('tab_message'=> 'companyupdated', 'active_tab' => 'companies');
	$this->Redirect($id, 'defaultadmin', $returnid, $params);
  }
}
else {
  $query = 'SELECT * FROM '.cms_db_prefix().'module_compdir_companies WHERE id = ?';
  $row = $db->GetRow($query, array($compid));

  if ($row) {
	$company_name = $row['company_name'];
	$url = $row['url'];
	$address = $row['address'];
	$latitude = $row['latitude'];
	$longitude = $row['longitude'];
	$hierpos = $row['hier_id'];
	$telephone = $row['telephone'];
	$fax = $row['fax'];
	$status = $row['status'];
	$contact_email = $row['contact_email'];
	$website = $row['website'];
	$details = $row['details'];
	$image = $row['picture_location'];
	$logo = $row['logo_location'];
	$origname = $row['company_name'];
	$owner_id = $row['owner_id'];
  }
  else {
	die('row not found');
  }
}

$fieldarray = array();
$imagedir = '';
$imageurl = '';
if( $compid > 0 ) {
  $imagedir = cms_join_path($gCms->config['uploads_path'],'companydirectory','id'.$compid);
  $imageurl = $gCms->config['uploads_url']."/companydirectory/id{$compid}";
}

$need_icons = 0;
if (count($fielddefs) > 0) {
  foreach ($fielddefs as $fielddef) {
	$fielddef = cge_array::to_object($fielddef);
	$field = new stdClass();

	$value = '';
	if (isset($fielddef->value)) $value = $fielddef->value;

	if (isset($_REQUEST[$id.'customfield']['field-'.$fielddef->id])) {
	  $value = $_REQUEST[$id.'customfield']['field-'.$fielddef->id];
	}

	$field->value = $value;
	$field->id = $fielddef->id;
	$field->name = $fielddef->name;
	$field->type = $fielddef->type;

	switch ($fielddef->type) {
	case 'dropdown':
	  $field->input_box = $this->CreateInputDropdown($id,'customfield[field-'.$fielddef->id.']',array_flip($fielddef->options),-1,$value);
	  break;

	case 'multiselect':
	  if( !is_array($value) ) $value = explode('~~',$value);
	  $field->input_box = $this->CreateInputSelectList($id,'customfield[field-'.$fielddef->id.'][]',
													   array_flip($fielddef->options),
													   $value,max(3,min(10,count($value))));
	  break;

	case 'file':
	  $field->input_box = '';
	  if( $value ) {
		$field->input_box .= '<input type="hidden" name="'.$id.'customfield[field-'.$fielddef->id.']" value="'.$value.'"/>';
		$field->input_box .= "<br/>{$value}:&nbsp;&nbsp;<input type=\"checkbox\" name=\"{$id}deletefile[field-{$fielddef->id}]\" value=\"1\"/>({$this->Lang('delete')})";
	  }
	  $field->input_box .= '<input type="file" name="'.$id.'customfield[field-'.$fielddef->id.']" value="" size="80"/>';
	  if( $imagedir ) {
		$fn = cms_join_path($imagedir,$value);
		if( file_exists($fn) ) {
		  $field->file_url = $imageurl.'/'.$value;
		}
	  }
	  break;

	case 'image':
	  $field->input_box = '';
	  if( $value ) {
		$field->input_box .= '<input type="hidden" name="'.$id.'customfield[field-'.$fielddef->id.']" value="'.$value.'"/>';
		$field->input_box .= "<br/>{$value}:&nbsp;&nbsp;<input type=\"checkbox\" name=\"{$id}deletefile[field-{$fielddef->id}]\" value=\"1\"/>({$this->Lang('delete')})";
	  }
	  $field->input_box .= '<input type="file" name="'.$id.'customfield[field-'.$fielddef->id.']" value="" size="80"/>';
	  if( $imagedir ) {
		$fn = cms_join_path($imagedir,'thumb_'.$value);
		if( file_exists($fn) ) $field->thumb_url = $imageurl.'/thumb_'.$value;
		$fn = cms_join_path($imagedir,'preview'.$value);
		if( file_exists($fn) ) $field->preview_url = $imageurl.'/preview_'.$value;
		$fn = cms_join_path($imagedir,$value);
		if( file_exists($fn) ) $field->image_url = $imageurl.'/'.$value;
	  }
	  break;

	case 'checkbox':
	  $field->input_box = '<input type="hidden" name="' . $id . 'customfield[field-'.$fielddef->id.']' . '" value="false" />' . $this->CreateInputCheckbox($id, 'customfield[field-'.$fielddef->id.']', 'true', $value );
	  break;

	case 'textarea':
	  $field->input_box = $this->CreateTextArea($use_wysiwyg, $id, $value, 'customfield[field-'.$fielddef->id.']');
	  break;

	case 'activity':
	  $cgsoc = $this->GetModuleInstance('CGSocialApp');
	  if( is_object($cgsoc) ) {
		$options = cgsa_activity::load_all_as_dropdown(FALSE);
		if( !is_array($value) ) $value = explode('~~',$value);
		$field->input_box = $this->CreateInputSelectList($id,'customfield[field-'.$fielddef->id.'][]',
														 array_flip($options),
														 $value,min(5,count($value)));
	  }
	  break;

	case 'icon':
	  if( ($icons = cd_utils::get_icon_list()) ) {
		$field->input_box = $this->CreateInputDropdown($id,'customfield[field-'.$fielddef->id.']',$icons,'',$value);
		$need_icons = 1;
	  }
	  break;

	case 'textbox':
	default:
	  $maxlength = $fielddef->max_length;
	  $size = min($maxlength,80);
	  $field->input_box = $this->CreateInputText($id, 'customfield[field-'.$fielddef->id.']', $value, $size, $maxlength);
	  break;
	}

	$fieldarray[] = $field;
  }
}

// find all 'orphaned' files in the destdir (files that don't have a value matching them).
$files = glob($destdir.'/*');
if( is_array($files) && count($files) ) {
  $delfiles = array();
  for( $j = 0; $j < count($files); $j++ ) {
	$bn = basename($files[$j]);
	$obn = $bn;
	if( startswith($bn,'thumb_') ) $bn = substr($bn,6);
	if( startswith($bn,'preview_') ) $bn = substr($bn,8);

	$fnd = 0;
	for( $i = 0; $i < count($fieldarray); $i++ ) {
	  $fld = $fieldarray[$i];
	  if( $fld->type != 'image' && $fld->type != 'file' ) continue;
	  if( $fld->value == $bn ) {
		$fnd = 1;
		break;
	  }
	}

	if( !$fnd ) {
	  // check the logo and image stuff.
	  if( $bn == $logo || $bn == $image ) $fnd = 1;
	}

	if( !$fnd ) $delfiles[] = $obn;
  }
  for( $i = 0; $i < count($delfiles); $i++ ) {
	@unlink($destdir.'/'.$delfiles[$i]);
  }
}

// get user information
$feu = $this->GetModuleInstance('FrontEndUsers');
if( is_object($feu) ) {
  $tmp = $feu->GetUsersInGroup();
  if( is_array($tmp) && count($tmp) ) {
	$users = array();
	$users[-1] = $this->Lang('none');
	for( $i = 0; $i < count($tmp); $i++ ) {
	  $users[$tmp[$i]['id']] = $tmp[$i]['username'];
	}
	$smarty->assign('feu_users',$users);
  }
}
$smarty->assign('owner_id',$owner_id);

$categories = $this->GetCategoriesForCompany($compid);
$catarray = array();

if (count($categories) > 0) {
  foreach ($categories as $onecat) {
	$field = new stdClass();

	$value = '';
	if (isset($onecat->value)) $value = $onecat->value;

	if (isset($_REQUEST[$id.'category'])) {
	  if (isset($_REQUEST[$id.'category']['id-'.$onecat->id]))
		$value = 'true';
	  else
		$value = 'false';
	}

	$field->value = $value;
    $field->depth = count(explode('.',$onecat->hierarchy))-1;
	$field->id = $onecat->id;
	$field->name = $onecat->name;
    $field->extra1_val = $onecat->extra1;
    $field->extra2_val = $onecat->extra2;
    $field->extra3_val = $onecat->extra3;
	$field->checkbox = $this->CreateInputCheckbox($id, 'category[id-'.$onecat->id.']', $value, 'true');
	$field->extra1 = $this->CreateInputText($id,'category_extra1[id-'.$onecat->id.']', $onecat->extra1,60,255);
	$field->extra2 = $this->CreateInputText($id,'category_extra2[id-'.$onecat->id.']', $onecat->extra2,60,255);
	$field->extra3 = $this->CreateInputText($id,'category_extra3[id-'.$onecat->id.']', $onecat->extra3,60,255);

	$catarray[] = $field;
  }
}

#Display template
$post_max_size = cge_string::str_to_bytes(ini_get('post_max_size'));
$upload_max_filesize = cge_string::str_to_bytes(ini_get('upload_max_filesize'));
$smarty->assign('max_chunksize',min($upload_max_filesize,$post_max_size-1024));
$smarty->assign('startform', $this->CreateFormStart($id, 'editcompany', $returnid, 'post', 'multipart/form-data'));
$smarty->assign('endform', $this->CreateFormEnd());
$smarty->assign('nametext', $this->Lang('name'));
$smarty->assign('company_name',$company_name);
$smarty->assign('addresstext', $this->Lang('address'));
$smarty->assign('url',$url);
$smarty->assign('address',$address);
$smarty->assign('inputlatitude', $this->CreateInputText($id, 'latitude', $latitude, 30, 255));
$smarty->assign('inputlongitude', $this->CreateInputText($id, 'longitude', $longitude, 30, 255));
$smarty->assign('inputhierpos',$this->CreateParentDropdown($id,-1,$hierpos,'hierpos'));
$smarty->assign('telephonetext', $this->Lang('telephone'));
$smarty->assign('inputtelephone', $this->CreateInputText($id, 'telephone', $telephone, 30, 255));
$smarty->assign('faxtext', $this->Lang('fax'));
$smarty->assign('inputfax', $this->CreateInputText($id, 'fax', $fax, 30, 255));
$smarty->assign('emailtext', $this->Lang('contactemail'));
$smarty->assign('inputemail', $this->CreateInputText($id, 'contact_email', $contact_email, 30, 255));
$smarty->assign('websitetext', $this->Lang('website'));
$smarty->assign('inputwebsite', $this->CreateInputText($id, 'website', $website, 30, 255));
$smarty->assign('detailstext', $this->Lang('details'));
$smarty->assign('inputdetails', $this->CreateTextArea($use_wysiwyg, $id, $details, 'details', '', '', '', '', '80', '8'));
$smarty->assign('imagecurrent', $image);
$smarty->assign('imagecurrenthidden', $this->CreateInputHidden($id, 'imagecurrent', $returnid, $image) . ' -- ' . $this->Lang('delete') . ':' . $this->CreateInputCheckbox($id, 'deleteimage', 'checked', ''));
$smarty->assign('imagetext', $this->Lang('imagetext'));
$smarty->assign('logocurrent', $logo);
$smarty->assign('logocurrenthidden', $this->CreateInputHidden($id, 'logocurrent', $returnid, $logo) . ' -- ' . $this->Lang('delete') . ':' . $this->CreateInputCheckbox($id, 'deletelogo', 'checked', ''));
$smarty->assign('logotext', $this->Lang('logotext'));
$smarty->assign('url_required',$this->GetPreference('url_required',0));

$statuses = array($this->Lang('published')=>'published',
				  $this->Lang('draft')=>'draft',
				  $this->Lang('disabled')=>'disabled');
$smarty->assign('statustext',$this->Lang('status'));
$smarty->assign('inputstatus',$this->CreateInputDropdown($id,'status',$statuses,-1,$status));

$smarty->assign('idtext',$this->Lang('id'));
$smarty->assign('compid',$compid);
$smarty->assign('hidden',
				$this->CreateInputHidden($id, 'compid', $compid).
				$this->CreateInputHidden($id, 'origname', $origname));
$smarty->assign('submit', $this->CreateInputSubmit($id, 'submit', lang('submit')));

if( $can_cancel ) $smarty->assign('cancel', $this->CreateInputSubmit($id, 'cancel', lang('cancel')));
$smarty->assign('customfields', $fieldarray);
$smarty->assign('customfieldscount', count($fieldarray));
$smarty->assign('categories', $catarray);
$smarty->assign('categoriescount', count($catarray));
$smarty->assign('can_geocode',cd_utils::can_geolocate());

$ft = $this->GetFieldTypes();
if( isset($ft['album']) && is_array($fielddefs) && count($fielddefs) ) {
  foreach( $fielddefs as $fdid => $rec ) {
	if( $rec->type == 'album' ) {
	  $smarty->assign('album_field_exists',$fdid);
	  break;
	}
  }
}
echo $this->ProcessTemplate('editcompany.tpl');

?>
