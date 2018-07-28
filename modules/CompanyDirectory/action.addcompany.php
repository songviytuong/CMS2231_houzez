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

if (isset($params['cancel'])) {
  $this->Redirect($id, 'defaultadmin', $returnid);
}

$company_name = '';
if (isset($params['ex_company_name'])) {
  $company_name = $params['ex_company_name'];
}

$url = '';
if (isset($params['url'])) {
  $url = $params['url'];
}

$address = '';
if (isset($params['address'])) {
  $address = $params['address'];
}

$latitude = '';
if (isset($params['latitude'])) {
  $latitude = $params['latitude'];
}

$longitude = '';
if (isset($params['longitude'])) {
  $longitude = $params['longitude'];
}

$hierpos = '';
if( isset($params['hierpos']) ) {
  $hierpos = (int)$params['hierpos'];
}

$telephone = '';
if (isset($params['telephone'])) {
  $telephone = $params['telephone'];
}

$fax = '';
if (isset($params['fax'])) {
  $fax = $params['fax'];
}

$contact_email = '';
if (isset($params['contact_email'])) {
  $contact_email = $params['contact_email'];
}

$website = '';
if (isset($params['website'])) {
  $website = $params['website'];
}

$details = '';
if (isset($params['details'])) {
  $details = $params['details'];
}

$status = '';
if (isset($params['status'])) {
  $status = $params['status'];
}

$owner_id = -1;
if (isset($params['owner_id'])) {
  $owner_id = $params['owner_id'];
}

$use_wysiwyg = (bool) $this->GetPreference('adminwysiwyg',1);
$fielddefs = cd_utils::get_fielddefs(true);

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

function handle_tmp_upload($id, $itemid, $filename)
{
  $gCms = cmsms();
  $config = $gCms->GetConfig();

  if (!is_dir($config['uploads_path'] . DIRECTORY_SEPARATOR . 'companydirectory' . DIRECTORY_SEPARATOR . 'id' . $itemid)) {
	@mkdir($config['uploads_path'] . DIRECTORY_SEPARATOR . 'companydirectory' . DIRECTORY_SEPARATOR . 'id' . $itemid);
  }
  @rename($config['uploads_path'] . DIRECTORY_SEPARATOR . 'companydirectory' . DIRECTORY_SEPARATOR . 'tmp' . DIRECTORY_SEPARATOR . $filename, $config['uploads_path'] . DIRECTORY_SEPARATOR . 'companydirectory' . DIRECTORY_SEPARATOR . 'id' . $itemid . DIRECTORY_SEPARATOR . $filename);
}

$image = '';
if (isset($_FILES[$id . 'imageupload']) && $_FILES[$id . 'imageupload']['tmp_name'] != '') {
  $image = handle_initial_upload($id, 'imageupload');
}
 else if (isset($params['imagecurrent'])) {
   $image = $params['imagecurrent'];
}

$logo = '';
if (isset($_FILES[$id . 'logoupload']) && $_FILES[$id . 'logoupload']['tmp_name'] != '') {
  $logo = handle_initial_upload($id, 'logoupload');
}
else if (isset($params['logocurrent'])) {
  $logo = $params['logocurrent'];
}

$userid = get_userid();

if (isset($params['submit'])) {
  // submit is pressed.
  $error = '';

  if( $company_name == '' ) {
	$error = $this->Lang('nocompanynamegiven');
  }

  if( !$error && !$this->GetPreference('allow_duplicate_companynames') && cd_utils::company_name_exists($company_name) ) {
	$error = $this->Lang('error_duplicate_company',$company_name);
  }

  if( !$error && $url == '' && $this->GetPreference('url_required',0) ) {
	$error = $this->Lang('error_urlrequired');
  }

  if( !$error && $url == '' && $this->GetPreference('url_autocreate',0) ) {
	$url = cd_utils::generate_url($company_name);
	if( !$url ) {
	  $error = $this->Lang('error_invalidname');
	}
  }

  if( !$error && $url != '' ) {
	$res = cd_utils::validate_url($url);
	if( !$res ) {
	  $error = $this->Lang('error_invalidurl');
	}
  }

  try {
	$the_company = new cd_company;
	$the_company->company_name = $company_name;
	$the_company->url = $url;
	$the_company->address = $address;
	$the_company->telephone = $telephone;
	$the_company->fax = $fax;
	$the_company->contact_email = $contact_email;
	$the_company->website = $website;
	$the_company->details = $details;
	$the_company->picture_location = $image;
	$the_company->logo_location = $logo;
	$the_company->status = $status;
	$the_company->latitude = $latitude;
	$the_company->longitude = $longitude;
	$the_company->owner_id = $owner_id;
	$the_company->hier_id = $hierpos;
  }
  catch( Exception $e ) {
	$error = $e->GetMessage();
  }

  if ( $error ) {
	echo $this->ShowErrors($error);
  }
  else {
	$the_company->save(FALSE); // save, but no field data etc. and don't send events
	$cid = $the_company->id;

	$destdir = cms_join_path($gCms->config['uploads_path'],'companydirectory','id'.$cid);
	if( count($fielddefs) ) {
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
		  $tmp = $uploader->handle_upload('customfield','','field-'.$fielddef->id);
		  if( !$tmp ) {
			if( $uploader->get_error() != cg_fileupload::NOFILE ) {
			  $error = $this->GetUploadErrorMessage($uploader->get_error());
			  break;
			}
		  }
		  else {
			$_REQUEST[$id.'customfield']['field-'.$fielddef->id] = $tmp;
		  }
		  break;

		case 'multiselect':
		  if( isset($_REQUEST[$id.'customfield']['field-'.$fielddef->id]) &&
			  is_array($_REQUEST[$id.'customfield']['field-'.$fielddef->id]) ) {
			$_REQUEST[$id.'customfield']['field-'.$fielddef->id] = implode('~~',$_REQUEST[$id.'customfield']['field-'.$fielddef->id]);
		  }
		  break;
		}
	  }
	  if (isset($_REQUEST[$id.'customfield'])) {
		foreach ($_REQUEST[$id.'customfield'] as $k=>$v) {
		  if (startswith($k, 'field-')) {
			$fid = substr($k, 6);
			$the_company->set_field($fid,$v);
		  }
		}
	  }
	} // if count fielddefs

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
	$destdir = cms_join_path($gCms->config['uploads_path'],'companydirectory','id'.$the_company->id);

	if ($image != '') {
	  // deprecated, use the uploader stuff.
	  handle_tmp_upload($id, $cid, $image);
	}

	if ($logo != '') {
	  // deprecated, use the uploader stuff.
	  handle_tmp_upload($id, $cid, $logo);
	}

	//Update search index
	if( $the_company->status == 'published' ) {
	  $module = cms_utils::get_search_module();
	  if ($module) $module->AddWords($this->GetName(),$the_company->id,'company',$the_company->get_search_words());
	}

	audit($cid,$this->GetName(),'Added Company '.$company_name);

	$params = array('tab_message'=> 'companyadded', 'active_tab' => 'companies');
	$this->Redirect($id, 'defaultadmin', $returnid, $params);
  }
}

$fieldarray = array();

if (count($fielddefs) > 0) {
  foreach ($fielddefs as $fielddef) {
	$fielddef = cge_array::to_object($fielddef);
	$field = new stdClass();

	$value = '';
	if (isset($fielddef->value)) {
	  $value = $fielddef->value;
	}

	if (isset($_REQUEST[$id.'customfield']['field-'.$fielddef->id]))
	  $value = $_REQUEST[$id.'customfield']['field-'.$fielddef->id];
	$field->type = $fielddef->type;
	$field->id = $fielddef->id;
	$field->name = $fielddef->name;
	switch ($fielddef->type) {
	case 'dropdown':
	  $field->input_box = $this->CreateInputDropdown($id,'customfield[field-'.$fielddef->id.']',array_flip($fielddef->options),-1,$value);
	  break;

	case 'multiselect':
	  if( !is_array($value) ) $value = explode('~~',$value);
	  $field->input_box = $this->CreateInputSelectList($id,'customfield[field-'.$fielddef->id.'][]',
													   array_flip($fielddef->options),
													   $value,min(5,count($value)));
	  break;

	case 'file':
	case 'image':
	  $field->input_box = '<input type="file" name="'.$id.'customfield[field-'.$fielddef->id.']" value="" size="80"/>';
	  if( $value ) {
		$field->input_box .= "<br/>{$value}:&nbsp;&nbsp;<input type=\"checkbox\" name=\"{$id}deletefile[field-{$fielddef->id}]\" value=\"1\"/>({$this->Lang('delete')})";
	  }
	  break;

	case 'checkbox':
	  $field->input_box = '<input type="hidden" name="' . $id . 'customfield[field-'.$fielddef->id.']' . '" value="false" />'.$this->CreateInputCheckbox($id, 'customfield[field-'.$fielddef->id.']', 'true', $value == 'true');
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

$categories = cd_utils::get_categories();
$catarray = array();
if (count($categories) > 0) {
  foreach ($categories as $onecat) {
	$field = new stdClass();

	$value = 'false';
	if (isset($_REQUEST[$id.'category']['id-'.$onecat->id])) $value = 'true';

	$field->id = $onecat->id;
        $field->depth = count(explode('.',$onecat->hierarchy))-1;
	$field->name = $onecat->name;
	$field->checkbox = $this->CreateInputCheckbox($id, 'category[id-'.$onecat->id.']', $value, 'true');
	$field->extra1 = $this->CreateInputText($id,'category_extra1[id-'.$onecat->id.']', '',60,255);
	$field->extra2 = $this->CreateInputText($id,'category_extra2[id-'.$onecat->id.']', '',60,255);
	$field->extra3 = $this->CreateInputText($id,'category_extra3[id-'.$onecat->id.']', '',60,255);

	$catarray[] = $field;
  }
}

#Display template
$smarty->assign('startform', $this->CreateFormStart($id, 'addcompany', $returnid, 'post', 'multipart/form-data'));
$smarty->assign('endform', $this->CreateFormEnd());
$smarty->assign('nametext', $this->Lang('name'));
$smarty->assign('company_name',$company_name);
$smarty->assign('url',$url);

$smarty->assign('owner_id',$owner_id);
$smarty->assign('addresstext', $this->Lang('address'));
$smarty->assign('address',$address);
$smarty->assign('inputaddress', $this->CreateInputText($id, 'address', $address, 30, 255));
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
$smarty->assign('imageupload', $this->CreateFileUploadInput($id, 'imageupload', '', 80));
$smarty->assign('imagecurrent', $image);
$smarty->assign('imagetext', $this->Lang('imagetext'));
$smarty->assign('imagecurrenthidden', $this->CreateInputHidden($id, 'imagecurrent', $returnid, $image));
$smarty->assign('logoupload', $this->CreateFileUploadInput($id, 'logoupload', '', 80));
$smarty->assign('logocurrent', $logo);
$smarty->assign('logocurrenthidden', $this->CreateInputHidden($id, 'logocurrent', $returnid, $logo));
$smarty->assign('logotext', $this->Lang('logotext'));

$statuses = array($this->Lang('published')=>'published',
		  $this->Lang('draft')=>'draft',
		  $this->Lang('disabled')=>'disabled');
$smarty->assign('statustext',$this->Lang('status'));
$smarty->assign('inputstatus',
		$this->CreateInputDropdown($id,'status',
					   $statuses,-1,$status));
$smarty->assign('hidden', '');
$smarty->assign('submit', $this->CreateInputSubmit($id, 'submit', lang('submit')));
$smarty->assign('cancel', $this->CreateInputSubmit($id, 'cancel', lang('cancel')));

$smarty->assign('customfields', $fieldarray);
$smarty->assign('customfieldscount', count($fieldarray));
$smarty->assign('categories', $catarray);
$smarty->assign('categoriescount', count($catarray));

$smarty->assign('url_required',$this->GetPreference('url_required',0));
$smarty->assign('url_autocreate',$this->GetPreference('url_autocreate',0));
$smarty->assign('can_geocode',cd_utils::can_geolocate());

echo $this->ProcessTemplate('editcompany.tpl');

?>
