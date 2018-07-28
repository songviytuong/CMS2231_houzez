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
if (!$this->CheckPermission('Modify Company Directory')) exit;

if (isset($params['cancel'])) $this->Redirect($id, 'admin_settings', $returnid);

$config = cmsms()->GetConfig();
$userid = get_userid();
$catid = '';
$tmpdir = '';
$destdir = '';
$image = '';
$description = '';
$name = trim(cge_utils::get_param($params,'name'));
$description = cge_utils::get_param($params,'description');
$extra1 = cge_utils::get_param($params,'extra1');
$extra2 = cge_utils::get_param($params,'extra2');
$extra3 = cge_utils::get_param($params,'extra3');

if (isset($params['submit'])) {
  $error = '';
  if( $name == '' ) $error = $this->Lang('nonamegiven');
  if( $error == '' && preg_match('/[^\w ]/',$name) ) $error = $this->Lang('badnamegiven');

  if( !$error ) {
	// handle image upload.
	$tmpdir = cms_join_path($config['uploads_path'],'companydirectory','u'.$userid);
	$uploader = cge_setup::get_uploader($id,$tmpdir);
	$tmp = $uploader->check_upload('image',FALSE,FALSE);
	if( !$tmp && $uploader->get_error() != cg_fileupload::NOFILE ) {
	  $error = $this->GetUploadErrorMessage($uploader->get_error());
	}
	else {
	  cge_dir::mkdirr($tmpdir);
	  $image = $uploader->handle_upload('image');
	  if( !$image && $uploader->get_error() != cg_fileupload::NOFILE ) $error = $this->GetUploadErrorMessage($uploader->get_error());
	}
	if( $image === 0 ) $image = '';
  }

  if( !$error ) {
	$query = 'SELECT COALESCE(MAX(iorder),0) FROM '.cms_db_prefix().'module_compdir_categories';
	$iorder = (int)$db->GetOne($query);
	$iorder++;
	$query = 'INSERT INTO '.cms_db_prefix().'module_compdir_categories
              (name, image, description, extra1, extra2, extra3, create_date, modified_date, iorder)
              VALUES (?,?,?,?,?,?,NOW(),NOW(),?)';
	$dbr = $db->Execute($query, array($name, $image, $description, $extra1, $extra2, $extra3, $iorder) );

	if( !$dbr )
	  $error = $db->ErrorMsg().' -- '.$db->sql;
	else
	  $catid = $db->Insert_ID();
  }

  // move images into final destinations
  if( !$error && $catid && $image && $tmpdir && is_dir($tmpdir)) {
	$destdir = cms_join_path($config['uploads_path'],'companydirectory','cat'.$catid);
	cge_dir::mkdirr($destdir);

	$files = glob($tmpdir.'/*.*');
	foreach( $files as $file ) {
	  $bn = basename($file);
	  @rename($file,cms_join_path($destdir,$bn));
	}
	cge_dir::recursive_rmdir($tmpdir);
	$tmpdir = '';
  }

  if( !$error ) {
	audit($catid,$this->GetName(),'Added category '.$name);
	// no errors, get outa here.
	$params = array('tab_message'=> 'categoryadded', 'active_tab' => 'categories');
	$this->Redirect($id, 'admin_settings', $returnid, $params);
  }

  // display errors
  if( $tmpdir && is_dir($tmpdir) ) cge_dir::recursive_rmdir($tmpdir);
  echo $this->ShowErrors($error);
}

#Display template
$smarty->assign('startform', $this->CreateFormStart($id, 'addcategory', $returnid,'post','multipart/form-data'));
$smarty->assign('endform', $this->CreateFormEnd());
$smarty->assign('nametext', $this->Lang('name'));
$smarty->assign('image',$image);
$smarty->assign('description',$description);
$smarty->assign('inputname', $this->CreateInputText($id, 'name', $name, 30, 255));
$smarty->assign('inputextra1', $this->CreateInputText($id, 'extra1', $extra1, 30, 255));
$smarty->assign('inputextra2', $this->CreateInputText($id, 'extra2', $extra2, 30, 255));
$smarty->assign('inputextra3', $this->CreateInputText($id, 'extra3', $extra3, 30, 255));
$smarty->assign('hidden', '');
$smarty->assign('submit', $this->CreateInputSubmit($id, 'submit', lang('submit')));
$smarty->assign('cancel', $this->CreateInputSubmit($id, 'cancel', lang('cancel')));
$smarty->assign('can_geocode',cd_utils::can_geolocate());

echo $this->ProcessTemplate('editcategory.tpl');

?>