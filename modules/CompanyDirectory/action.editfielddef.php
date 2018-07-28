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
$this->SetCurrentTab('fielddefs');
if (!$this->CheckPermission('Modify Company Directory')) {
  echo $this->ShowErrors($this->Lang('needpermission', array('Modify Company Directory')));
  return;
}


//
// Initialization
//
$name = '';
$type = '';
$max_length = 255;
$origname = '';
$admin_only = 0;
$public = 0;
$dropdown_data = '';
$data = '';

//
// Setup
//
$fdid = '';
if (isset($params['cancel'])) $this->RedirectToTab($id,'','','admin_settings');
if (isset($params['fdid'])) $fdid = $params['fdid'];


//
// Get Data
//
$query = 'SELECT * FROM '.cms_db_prefix().'module_compdir_fielddefs WHERE id = ?';
$row = $db->GetRow($query, array($fdid));
if ($row) {
  $name = $row['name'];
  $type = $row['type'];
  $max_length = $row['max_length'];
  $origname = $row['name'];
  $admin_only = $row['admin_only'];
  $public = $row['public'];
  $dropdown_data = $row['dropdown_data'];
  $data = $row['data'];
}

if (isset($params['name'])) $name = $params['name'];
if (isset($params['type'])) $type = $params['type'];
if (isset($params['max_length'])) $max_length = (int)$params['max_length'];
if (isset($params['origname'])) $origname = $params['origname'];
if( isset($params['admin_only']) ) $admin_only = (int)$params['admin_only'];
if( isset($params['public']) ) $public = (int)$params['public'];
if( ($type == 'dropdown' || $type == 'multiselect') && isset($params['dropdown_options']) ) $dropdown_data = trim($params['dropdown_options']);
if( ($type == 'file' || $type == 'image' || $type == 'album') && isset($params['extensions']) ) $data = trim($params['extensions']);

$status = '';
if (isset($params['submit'])) {
  if( empty($name) ) $status = $this->Lang('nonamgiven');
  if( empty($status) && $type == 'textbox' && !is_numeric($max_length) ) $status = $this->Lang('error_nolength');
  if( empty($status) && ($type == 'dropdown' || $type == 'multiselect') && empty($dropdown_data) ) {
	$status = $this->Lang('error_nodropdownoptions');
  }
  
  if( empty($status) && $type == 'album' ) {
	$fd = cd_utils::get_fielddefs_by_name(TRUE,TRUE);
	$fnd = false;
	if(is_array($fd) && count($fd) ) {
	  foreach( $fd as $the_id => $the_rec ) {
		if( $the_rec['type'] == 'album' && $the_rec['id'] != $fdid ) {
		  $fnd = true;
		  break;
		}
	  }
	}
	if( $fnd ) {
      $status = $this->Lang('error_albumfieldexists');
	}
  }
  if( empty($status) ) {
	$query = 'UPDATE '.cms_db_prefix().'module_compdir_fielddefs 
              SET name = ?, type = ?, max_length = ?, modified_date = '.$db->DBTimeStamp(time()).', 
                  admin_only = ?, public = ?, dropdown_data = ?, data = ?
              WHERE id = ?';
	$res = $db->Execute($query, array($name, $type, $max_length, $admin_only, $public, $dropdown_data, $data, $fdid));
	if( !$res ) die( $db->ErrorMsg() );

	audit($fdid,$this->GetName(),'Edited field definition '.$name.' of type '.$type);
	$this->SetMessage($this->Lang('fielddefupdated'));
	$this->RedirectToTab($id,'','','admin_settings');
  }
  
  echo $this->ShowErrors($status);
}


#Display template
$this->smarty->assign('startform', $this->CreateFormStart($id, 'editfielddef', $returnid));
$this->smarty->assign('endform', $this->CreateFormEnd());
$this->smarty->assign('nametext', $this->Lang('name'));
$this->smarty->assign('typetext', $this->Lang('type'));
$this->smarty->assign('maxlengthtext', $this->Lang('max_length'));
$this->smarty->assign('inputname', $this->CreateInputText($id, 'name', $name, 20, 255));
$this->smarty->assign('inputmaxlength', $this->CreateInputText($id, 'max_length', $max_length, 20, 255));
$smarty->assign('useredittext',$this->Lang('admin_only'));
$smarty->assign('userviewtext',$this->Lang('public'));
$smarty->assign('input_useredit',
		$this->CreateInputHidden($id,'admin_only',0).
		$this->CreateInputCheckbox($id, 'admin_only', 1, $admin_only));
$smarty->assign('input_userview',
		$this->CreateInputHidden($id,'public',0).
		$this->CreateInputcheckbox($id, 'public', 1, $public));
$smarty->assign('fieldtypes',$this->GetFieldTypes());
$smarty->assign('fldtype',$type);
$smarty->assign('dropdown_data',$dropdown_data);
$smarty->assign('extensions',$data);

$this->smarty->assign('hidden', 
		      $this->CreateInputHidden($id, 'fdid', $fdid).
		      $this->CreateInputHidden($id, 'origname', $origname));
$this->smarty->assign('submit', $this->CreateInputSubmit($id, 'submit', lang('submit')));
$this->smarty->assign('cancel', $this->CreateInputSubmit($id, 'cancel', lang('cancel')));
echo $this->ProcessTemplate('editfielddef.tpl');
?>
