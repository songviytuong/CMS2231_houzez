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

$this->SetCurrentTab('fielddefs');

if (isset($params['cancel'])) $this->RedirectToTab($id,'','','admin_settings');

$name = get_parameter_value($params,'name');
$type = get_parameter_value($params,'type');
$max_length = get_parameter_value($params,'max_length',255);
$adminonly = get_parameter_value($params,'adminonly',0);
$public = get_parameter_value($params,'public',1);

$dropdown_data = '';
if( ($type == 'dropdown' || $type == 'multiselect') && isset($params['dropdown_options']) ) {
  $dropdown_data = trim($params['dropdown_options']);
}
$data = '';
if( ($type == 'file' || $type == 'image' || $type == 'album') && isset($params['extensions']) ) {
  $data = trim($params['extensions']);
}

$userid = get_userid();

$status = '';
if (isset($params['submit'])) {
  if( empty($name) ) $status = $this->Lang('nonamgiven');
  if( empty($status) && $type == 'textbox' && !is_numeric($max_length) ) {
	$status = $this->Lang('error_nolength');
  }

  if( empty($status) && ($type == 'dropdown' || $type == 'multiselect') && empty($dropdown_data) ) {
	$status = $this->Lang('error_nodropdownoptions');
  }

  if( empty($status) && $type == 'album' ) {
	$fd = cd_utils::get_fielddefs_by_name(TRUE,TRUE);
	$fnd = false;
	if(is_array($fd) && count($fd) ) {
	  foreach( $fd as $the_id => $the_rec ) {
		if( $the_rec['type'] == 'album' ) {
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
	$max = (int)$db->GetOne('SELECT MAX(item_order) FROM ' . cms_db_prefix() . 'module_compdir_fielddefs');
	$max++;
	$query = 'INSERT INTO '.cms_db_prefix().'module_compdir_fielddefs 
              (name, type, max_length, item_order, create_date, modified_date, 
               admin_only, public, dropdown_data, data) 
              VALUES (?,?,?,?,?,?,?,?,?,?)';
	$parms = array($name, $type, $max_length, $max, 
					 trim($db->DBTimeStamp(time()), "'"), 
					 trim($db->DBTimeStamp(time()), "'"),
					 $adminonly, $public, $dropdown_data, $data);
	$dbr = $db->Execute($query, $parms );
	if( !$dbr ) die($db->sql.' - '.$db->ErrorMsg());

	audit('',$this->GetName(),'Added field definition '.$name.' of type '.$type);
	$this->SetMessage($this->Lang('fielddefadded'));
	$this->RedirectToTab($id,'','','admin_settings');
  }

  echo $this->ShowErrors($status);
}

$smarty->assign('startform', $this->CreateFormStart($id, 'addfielddef', $returnid));
$smarty->assign('endform', $this->CreateFormEnd());
$smarty->assign('nametext', $this->Lang('name'));
$smarty->assign('typetext', $this->Lang('type'));
$smarty->assign('maxlengthtext', $this->Lang('maxlength'));
$smarty->assign('inputname', $this->CreateInputText($id, 'name', $name, 30, 255));
$smarty->assign('fieldtypes',$this->GetFieldTypes());
$smarty->assign('inputmaxlength', $this->CreateInputText($id, 'max_length', $max_length, 30, 255));
$smarty->assign('useredittext',$this->Lang('admin_only'));
$smarty->assign('userviewtext',$this->Lang('public'));
$smarty->assign('input_useredit',$this->CreateInputCheckbox($id, 'adminonly', 1, $adminonly));
$smarty->assign('input_userview',$this->CreateInputcheckbox($id, 'public', 1, $public));
$smarty->assign('fldtype',$type);
$smarty->assign('dropdown_data',$dropdown_data);
$smarty->assign('valid_extensions',$data);

$smarty->assign('hidden', '');
$smarty->assign('submit', $this->CreateInputSubmit($id, 'submit', lang('submit')));
$smarty->assign('cancel', $this->CreateInputSubmit($id, 'cancel', lang('cancel')));

echo $this->ProcessTemplate('editfielddef.tpl');

?>