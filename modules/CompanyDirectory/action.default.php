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

$tpl = $this->GetPreference(COMPANYDIR_PREF_DFLTSUMMARY_TEMPLATE);
if( isset($params['summarytemplate']) )	$tpl = trim($params['summarytemplate']);
if( !$tpl ) return;
$the_template = 'summary_'.$tpl;

$cache_id = '|cgs'.md5(serialize($params));
$compile_id = '';

try {
  if( !$smarty->isCached($this->GetDatabaseResource($the_template),$cache_id,$compile_id) ) {
	$filter = new cd_company_filter($params);
	$filter['returnid'] = $returnid;
	$filter['id'] = $id;
	$query = new cd_company_query($filter);
	$pagination = $query->get_pagination();
	$page = $pagination->get_current_page();

	$smarty->assign('items',$query->get_results($id,$returnid));
	$smarty->assign('itemcount',$query->get_result_count());
	$smarty->assign('totalmatches',$query->get_total_matches());
	$smarty->assign('pagination',$pagination);

	$smarty->assign('pagetext',$this->Lang('page'));
	$smarty->assign('oftext',$this->Lang('of'));
	$smarty->assign('pagecount',$pagination->get_page_count());
	$smarty->assign('curpage',$page);
    $smarty->assign('filter',$filter);
	$smarty->assign('hierarchy_list',array_flip(cd_utils::get_hierarchy_list()));
	if( $pagination->get_page_count() > 1 ) {
	  if( $page == 1 ) {
		$smarty->assign('firstlink',$this->Lang('firstpage'));
		$smarty->assign('prevlink',$this->Lang('prevpage'));
	  }
	  else {
		$smarty->assign('firstlink',$pagination->get_page_link(1,$this->Lang('firstpage')));
		$smarty->assign('prevlink',$pagination->get_page_link($pagination->get_current_page()-1,$this->Lang('prevpage')));
	  }
	  if( $page == $pagination->get_page_count() ) {
		$smarty->assign('lastlink',$this->Lang('lastpage'));
		$smarty->assign('nextlink',$this->Lang('nextpage'));
	  }
	  else {
		$smarty->assign('lastlink',$pagination->get_page_link($pagination->get_page_count(),$this->Lang('lastpage')));
		$smarty->assign('nextlink',$pagination->get_page_link($pagination->get_current_page()+1,$this->Lang('nextpage')));
	  }
	}
  }

  echo $smarty->fetch($this->GetDatabaseResource($the_template),$cache_id,$compile_id);
}
catch( Exception $e ) {
  echo '<!-- '.$this->GetName().' ERROR: '.$e->Getmessage().' -->';
  throw $e;
}

?>