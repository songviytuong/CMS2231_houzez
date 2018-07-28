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
if( !isset($gCms) ) exit;
if( !$this->CheckPermission('Modify Site Preferences') ) exit;

$this->SetCurrentTab('hier');

if (isset($params['cancel'])) {
  $this->SetMessage($this->Lang('op_cancelled'));
  $this->RedirectToTab($id, '', '', 'admin_settings');
}

$parent = (int)cge_utils::get_param($params,'parent',-1);

$name = '';
if (isset($params['submit'])) {
  $name = trim(cge_utils::get_param($params,'name'));
  if( $name != '' ) {
    $query = 'SELECT COALESCE(MAX(iorder),0) + 1 FROM '.cms_db_prefix().'module_compdir_hier WHERE parent_id = ?';
    $num = (int) $db->GetOne($query,array($parent));

	$query = 'INSERT INTO '.cms_db_prefix().'module_compdir_hier (name, parent_id, iorder) VALUES (?,?,?)';
	$parms = array($name,intval($parent),$num);
	$dbr = $db->Execute($query, $parms);
	if( !$dbr ) {
	  die($db->sql.'<br/>'.$db->ErrorMsg());
	}

	$this->UpdateHierarchyPositions();
	$this->SetMessage($this->Lang('msg_hieradded'));
	$this->RedirectToTab($id, '', '', 'admin_settings');
  }
  else {
	echo $this->ShowErrors($this->Lang('nonamegiven'));
  }
}

#Display template
$this->smarty->assign('startform', $this->CreateFormStart($id, 'admin_addhier', $returnid));
$this->smarty->assign('endform', $this->CreateFormEnd());
$this->smarty->assign('nametext', $this->Lang('name'));
$this->smarty->assign('inputname', $this->CreateInputText($id, 'name', $name, 20, 255));
$this->smarty->assign('parentdropdown', $this->CreateParentDropdown($id, -1, -1));
$this->smarty->assign('hidden', '');
$this->smarty->assign('submit', $this->CreateInputSubmit($id, 'submit', lang('submit')));
$this->smarty->assign('cancel', $this->CreateInputSubmit($id, 'cancel', lang('cancel')));
$this->smarty->assign('parenttext', lang('parent'));
echo $this->ProcessTemplate('edithier.tpl');


#
# EOF
#
?>