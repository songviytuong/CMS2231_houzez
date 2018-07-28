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
  $this->SetCurrentTab($this->Lang('op_cancelled'));
  $this->RedirectToTab($id, '', '', 'admin_settings');
}

$catid = '';
if (isset($params['catid'])) {
  $catid = $params['catid'];
}

$parentid = '-1';
if (isset($params['parent'])) {
  $parentid = $params['parent'];
}

$origname = '';
if (isset($params['origname'])) {
  $origname = $params['origname'];
}

$name = '';
if (isset($params['name'])) {
  $name = $params['name'];
  if ($name != '') {
	$query = 'UPDATE '.cms_db_prefix().'module_compdir_hier SET name = ?, parent_id = ? WHERE id = ?';
	$parms = array($name,$parentid, $catid);
	$db->Execute($query, $parms);
	$this->UpdateHierarchyPositions();

	$this->SetMessage($this->Lang('msg_hierupdated'));
	$this->RedirectToTab($id, '', '', 'admin_settings');
  }
  else {
	echo $this->ShowErrors($this->Lang('nonamegiven'));
  }
}
else {
   $query = 'SELECT * FROM '.cms_db_prefix().'module_compdir_hier WHERE id = ?';
   $row = $db->GetRow($query, array($catid));

   if ($row) {
	 $name = $row['name'];
	 $parentid = $row['parent_id'];
   }
}

#Display template
$smarty->assign('startform', $this->CreateFormStart($id, 'admin_edithier', $returnid));
$smarty->assign('endform', $this->CreateFormEnd());
$smarty->assign('nametext', $this->Lang('name'));
$smarty->assign('inputname', $this->CreateInputText($id, 'name', $name, 20, 255));
$smarty->assign('parentdropdown', $this->CreateParentDropdown($id, $catid, $parentid));
$smarty->assign('hidden', 
		      $this->CreateInputHidden($id, 'catid', $catid).
		      $this->CreateInputHidden($id,'origname',$name));
$smarty->assign('submit', $this->CreateInputSubmit($id, 'submit', lang('submit')));
$smarty->assign('cancel', $this->CreateInputSubmit($id, 'cancel', lang('cancel')));
$smarty->assign('parenttext', lang('parent'));
echo $this->ProcessTemplate('edithier.tpl');


#
# EOF
#
?>