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
if( !isset($gCms) ) exit;
$feu = $this->GetModuleInstance('FrontEndUsers');
if( !is_object($feu) ) return; // no feu module.
$feu_uid = $feu->LoggedInId();
if( $feu_uid <= 0 ) return; // not logged in
if( !$this->GetPreference('frontend_delete',1) ) return; // no permission

if( !isset($params['companyid']) ) return; // no company id.
$companyid = (int)$params['companyid'];

$company = cd_utils::get_company($companyid,$returnid,TRUE);
if( !is_object($company) ) return; // invalid company
if( $company->owner_id != $feu_uid ) return; // invalid owner.

$days = (int)get_parameter_value($params,'days',365);
if( $days < 1 ) return; // no days.

$pagelimit = (int)get_parameter_value($params,'pagelimit',100);
$pagelimit = max(1,min(10000,$pagelimit));
$page = (int)get_parameter_value($params,'page',1);
$page = max(1,$page);
$offset = ($page - 1) * $pagelimit;

// save original params for use in further pagination, once we add it.
$origparams = array('companyid'=>$companyid,'days'=>$days,'pagelimit'=>$pagelimit);

$start_ut = time() - $days * 24 * 3600;
$start_ut = mktime(0,0,0,date('n',$start_ut),date('j',$start_ut),date('Y',$start_ut));
$start_dt = trim($db->DbTimeStamp($start_ut),"'");

$query = 'SELECT S.* FROM '.cms_db_prefix().'module_compdir_searchstats S 
          LEFT JOIN '.cms_db_prefix().'module_compdir_searchstats_res R
          ON S.id = R.search_id WHERE R.company_id = ? AND S.date_searched > ? ORDER BY date_searched DESC';
$dbr = $db->SelectLimit($query,$pagelimit,$offset,array($companyid,$start_dt));
$searches = array();
$search_ids = array();
while( !$dbr->EOF() ) {
  $searches[$dbr->fields['id']] = $dbr->fields;
  $search_ids[] = (int)$dbr->fields['id'];
  $dbr->MoveNext();
}
$search_ids = array_unique($search_ids);

// now get the key/value pairs for each search
if( is_array($searches) && is_array($search_ids) && count($search_ids) ) {
  $query = 'SELECT V.* FROM '.cms_db_prefix().'module_compdir_searchstats_vars V WHERE search_id IN (' . implode(',',$search_ids).')';
  $dbr = $db->Execute($query);
  if( $dbr ) {
    while( !$dbr->EOF() ) {
      $rec = $dbr->fields;
      if( strpos($rec['val'],'^^') !== FALSE ) $rec['val'] = explode('^^',$rec['val']);
      $search_id = $rec['search_id'];
      if( !isset($searches[$search_id]) ) continue;
      if( !isset($searches[$search_id]['vals']) ) $searches[$search_id]['vals'] = array();
      $searches[$search_id]['vals'][$rec['name']] = $rec['val'];
      $dbr->MoveNext();
    }
  }

  $smarty->assign('searches',$searches);
}

$smarty->assign('fields',cd_utils::get_fielddefs_by_name(FALSE));
$smarty->assign('companyid',$companyid);
$smarty->assign('company',$company);
$smarty->assign('hierarchies',cd_utils::get_hierarchy_list(-1,FALSE));
$smarty->assign('categories',cd_utils::get_categories(TRUE));
$template = get_parameter_value($params,'searchstatstemplate',$this->GetPreference(COMPANYDIR_PREF_DFLTSTATSSUMMARY_TEMPLATE));
echo $this->ProcessTemplateFromDatabase('statssummary_'.$template);

#
# EOF
#


?>