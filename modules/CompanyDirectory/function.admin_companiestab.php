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

$theme = cms_utils::get_theme_object();
$uid = get_userid();
$filter = array();
$filter['name'] = '';
$filter['address'] = '';
$filter['pagelimit'] = 50;
$filter['page'] = 1;
$filter['sortby'] = 'company_name';
$filter['sortorder'] = 'asc';
$filter['status'] = -1;
$filter['hier'] = '';
$filter['categoryid'] = -1;

if( isset($params['filter_submit']) ) {
  $filter['name'] = trim($params['filter_name']);
  $filter['address'] = trim($params['filter_address']);
  $filter['pagelimit'] = (int)$params['filter_pagelimit'];
  $filter['sortby'] = trim($params['filter_sortby']);
  $filter['sortorder'] = trim($params['filter_sortorder']);
  if( isset($params['filter_categoryid']) ) $filter['categoryid'] = (int)$params['filter_categoryid'];
  $filter['status'] = trim($params['filter_status']);
  $filter['hier'] = trim($params['filter_hierarchy']);
  if( $filter['name'] != '' || $filter['address'] != '' ||
	  $filter['categoryid'] > 0 || $filter['hier'] > 0 ) {
	$filter['applied'] = 1;
  }
  else {
	unset($filter['applied']);
  }
  $filter['page'] = 1;
  set_preference($uid,'companyd_filter',serialize($filter));
}
elseif( isset($params['filter_reset']) ) {
  unset($filter['applied']);
  set_preference($uid,'companyd_filter',serialize($filter));
}
else {
  // get it from the preference.
  $tmp = get_preference($uid,'companyd_filter');
  if( $tmp ) $filter = unserialize($tmp);
  if( isset($params['page']) ) $filter['page'] = (int)$params['page'];
  if( isset($params['cd_page']) ) $filter['page'] = (int)$params['cd_page'];
}

$filter_ob = new cd_company_filter($filter);
$filter_ob['deep'] = 0;
$filter_ob['expiredowners'] = 1;
$query = new cd_company_query($filter_ob);
$pagination = $query->get_pagination();
$pagination->set_action('defaultadmin');
$theme = cms_utils::get_theme_object();
$feu = $this->GetModuleInstance('FrontEndUsers');
$entryarray = $query->get_results($id,$returnid);
if( is_array($entryarray) && count($entryarray) ) {
  $keys = array_keys($entryarray);
  for( $i = 0; $i < count($keys); $i++ ) {
	$row =& $entryarray[$keys[$i]];
	$row->plain_company_name = $row->company_name;
	$row->company_name = $this->CreateLink($id, 'editcompany', $returnid, $row->plain_company_name, array('compid'=>$row->id));
	if( is_object($feu) && $row->owner_id > 0 ) $row->owner = $feu->GetUserName($row->owner_id);
	$row->copylink = $this->CreateLink($id,'copycompany',$returnid,$theme->DisplayImage('icons/system/copy.gif',$this->Lang('copy'),'','','systemicon'),array('compid'=>$row->id));
	$row->editlink = $this->CreateLink($id, 'editcompany', $returnid, $theme->DisplayImage('icons/system/edit.gif', $this->Lang('edit'),'','','systemicon'), array('compid'=>$row->id));

	$row->deletelink = $this->CreateLink($id, 'deletecompany', $returnid,
										 $theme->DisplayImage('icons/system/delete.gif', $this->Lang('delete'),'','','systemicon'),
										 array('compid'=>$row->id), $this->Lang('areyousure'));
  }
}


$smarty->assign_by_ref('items', $entryarray);
$smarty->assign('itemcount', count($entryarray));
$smarty->assign('addlink', $this->CreateLink($id, 'addcompany', $returnid, $theme->DisplayImage('icons/system/newobject.gif', $this->Lang('addcompany'),'','','systemicon'), array(), '', false, false, '') .' '. $this->CreateLink($id, 'addcompany', $returnid, $this->Lang('addcompany'), array(), '', false, false, 'class="pageoptions"'));
if( count($entryarray) ) {
  $smarty->assign('exportcsv', $this->CreateImageLink($id,'exportcsv',$returnid,$this->Lang('exportcsv'),'icons/system/export.gif',array(),'','',false));
}
$smarty->assign('importcsv', $this->CreateImageLink($id,'importcsv',$returnid,$this->Lang('importcsv'),'icons/system/import.gif',array(),'','',false));
$smarty->assign('importkml', $this->CreateImageLink($id,'importkml',$returnid,$this->Lang('importkml'),'icons/system/import.gif',array(),'','',false));
$smarty->assign('idtext',$this->Lang('id'));
$smarty->assign('companytext', $this->Lang('company'));
$smarty->assign('websitetext', $this->Lang('website'));
$smarty->assign('filter_formstart',$this->CGCreateFormStart($id,'defaultadmin'));
$smarty->assign('filter_formend',$this->CreateFormEnd());
$smarty->assign('bulk_formstart',$this->CGCreateFormStart($id,'admin_bulk'));
$smarty->assign('bulk_formend',$this->CreateFormEnd());
$smarty->assign('filter',$filter);

$sortby = array();
$sortby['id'] = $this->Lang('id');
$sortby['company_name'] = $this->Lang('companyname');
$sortby['phone'] = $this->Lang('telephone');
$sortby['fax'] = $this->Lang('fax');
$sortby['email'] = $this->Lang('contactemail');
$sortby['website'] = $this->Lang('website');
$sortby['address'] = $this->Lang('address');
$sortby['created'] = $this->Lang('createddate');
$sortby['modified'] = $this->Lang('modifieddate');
$smarty->assign('sortings',$sortby);
$sortorders = array();
$sortorders['asc'] = $this->Lang('ascending');
$sortorders['desc'] = $this->Lang('descending');
$smarty->assign('sortorders',$sortorders);
$smarty->assign('pagelimits',array(5=>5,25=>25,50=>50,100=>100,250=>250,1000=>1000));
$statuses = array();
$statuses['-1'] = $this->Lang('any');
$statuses['draft'] = $this->Lang('draft');
$statuses['published'] = $this->Lang('published');
$statuses['disabled'] = $this->Lang('disabled');
$smarty->assign('statuses',$statuses);
{
  $tmp = $this->GetCategories();
  if( is_array($tmp) && count($tmp) ) {
	$cats = array();
	$cats[-1] = $this->Lang('any');
	for( $i = 0; $i < count($tmp); $i++ ) {
	  $row =& $tmp[$i];
	  $cats[$row->id] = $row->name;
	}
	$smarty->assign('categories',$cats);
  }
}

if( $pagination->get_page_count() > 1 ) $smarty->assign('nav',$pagination);

#Display template
echo $this->ProcessTemplate('companylist.tpl');

#
# EOF
#
?>