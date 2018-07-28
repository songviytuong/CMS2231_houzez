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
if( !isset($gCms) ) return;

$gCms = cmsms();
$contentops = $gCms->GetContentOperations();
$sortorder = $this->GetPreference('sortorder','asc');
$sortby = $this->GetPreference('sortby','company_name');

$smarty->assign('startform',$this->CreateFormStart($id,'admin_saveprefs',$returnid));
$smarty->assign('endform',$this->CreateFormEnd());

$smarty->assign('prompt_detailpage',$this->Lang('prompt_detailpage'));
$smarty->assign('input_detailpage',	$contentops->CreateHierarchyDropdown('',$this->GetPreference('detailpage'),$id.'detailpage'));

$sortorders = array($this->Lang('ascending')=>'asc',$this->Lang('descending')=>'desc');
$smarty->assign('sortorders',array_flip($sortorders));
$smarty->assign('sortorder',$sortorder);

$feu = $this->GetModuleInstance('FrontEndUsers');
if( is_object($feu) ) {
  $smarty->assign('frontendcreate',$this->GetPreference('frontend_create',0));
  $smarty->assign('frontenddelete',$this->GetPreference('frontend_delete',1));
  $smarty->assign('frontendchangestatus',$this->GetPreference('frontend_changestatus',0));

  $nums = array();
  $nums['0'] = '0';
  $nums['1'] = '1';
  $nums['5'] = '5';
  $nums['10'] = '10';
  $nums['25'] = '25';
  $nums['50'] = '50';
  $nums['100'] = '100';
  $nums['150'] = '150';
  $nums['200'] = '200';
  $nums['250'] = '250';
  $nums['500'] = '500';
  $nums['1000'] = '1000';
  $nums['10000'] = '10000';
  $smarty->assign('nums',$nums);
  $smarty->assign('frontendnumrecords',$this->GetPreference('frontend_numrecords',0));

  $statuses = array($this->Lang('published')=>'published',$this->Lang('draft')=>'draft');
  $smarty->assign('statuses',array_flip($statuses));
  $smarty->assign('frontendnewstatus',$this->GetPreference('frontend_newstatus','draft'));
}

$sortings = array($this->Lang('companyname')=>'company_name',
				  $this->Lang('address')=>'address',
				  $this->Lang('telephone')=>'telephone',
				  $this->Lang('fax')=>'fax',
				  $this->Lang('contactemail')=>'contact_email',
				  $this->Lang('website')=>'website',
				  $this->Lang('createddate')=>'create_date',
				  $this->Lang('modifieddate')=>'modified_date',
				  $this->Lang('random')=>'random');
$query = 'SELECT name FROM '.cms_db_prefix().'module_compdir_fielddefs ORDER BY name ASC';
$tmp = $db->GetCol($query);
if( is_array($tmp) ) {
  foreach($tmp as $one) {
	$sortings[$one] = 'f:'.$one;
  }
}
$smarty->assign('sortings',array_flip($sortings));
$smarty->assign('sortby',$sortby);

$smarty->assign('collectstats',$this->GetPreference('collectstats',0));
$smarty->assign('frontendimport',$this->GetPreference('frontend_import',0));
$smarty->assign('frontend_showexpired',$this->GetPreference('frontend_showexpired',0));
$smarty->assign('frontend_emailonadd',$this->GetPreference('frontend_emailonadd',0));
$smarty->assign('frontend_emailonedit',$this->GetPreference('frontend_emailonedit',0));
$smarty->assign('allow_duplicate_companynames',$this->GetPreference('allow_duplicate_companynames',1));
$smarty->assign('prepend_website_http',$this->GetPreference('prepend_website_http',0));
$smarty->assign('adminwysiwyg',$this->GetPreference('adminwysiwyg',1));

$groupops = $gCms->GetGroupOperations();
$allgroups = $groupops->LoadGroups();
$grouplist = array();
$grouplist[-1] = $this->Lang('none');
foreach( $allgroups as $onegroup ) {
  $grouplist[$onegroup->id] = $onegroup->name;
}
$smarty->assign('grouplist',$grouplist);
$smarty->assign('frontend_emailgroup',$this->GetPreference('frontend_emailgroup',-1));

echo $this->ProcessTemplate('prefs.tpl');

// EOF
?>