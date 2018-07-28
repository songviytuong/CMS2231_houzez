<?php
#-------------------------------------------------------------------------
# Module: FAQ
# Author: Jos (josvd@live.nl)
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2008 by Ted Kulp (wishy@cmsmadesimple.org)
# This project's homepage is: http://www.cmsmadesimple.org
# The module's homepage is: http://dev.cmsmadesimple.org/projects/faq/
#-------------------------------------------------------------------------

if (!isset($gCms)) exit;

$lang = cms_current_language();
$smarty->assign('mod_lang', $lang);
	
// Get faq properties
$alias = empty($params['category']) ? '' : $params['category'];
$categories = FAQ_utils::GetCategories('', true, $lang);
$smarty->assign('categories', $categories);

$catentries = 0;
foreach ($categories as $cat)
{
	$catentries += $cat['entries'];
}

// pagination
$entries_page = $this->GetPreference('entries_page');
if ( empty($entries_page) ) $entries_page = 10000;
$params['modpage'] = empty($params['modpage']) ? 1 : $params['modpage'];
$pages = ceil($catentries / $entries_page);
$start = (($params['modpage'] - 1) * $entries_page) + 1;


// get template
$template = $this->GetPreference('default_summary_template');
if ( !empty($params['template']) && $params['template'] != $template )
{
	$template = 'summary_tpl_' . $params['template'];
	$linkparams['template'] = $template;
}


// get cache
$cache_id = '|faq'.md5($alias.'-'.$params['modpage'].'-'.$catentries.'-'.$entries_page);
if( !$smarty->isCached($this->GetDatabaseResource($template),$cache_id) ) 
{
	// get faq entries
	$entries = FAQ_utils::GetEntries($alias, $start, $entries_page, true, $lang, true);
	$smarty->assign('faq_entries', $entries);


	// pagination links
	$prettyurl = 'faq/';
	//$linkparams['alias'] = $alias;
	$pagelinks = array();
	for ($i = 1; $i <= $pages; $i++) {
		$linkparams['modpage'] = $i;
		$pagelinks[$i] = $this->CreateFrontendLink($id, $returnid, 'default', '', $linkparams, '', true, true, '', false); //, $prettyurl . $i . '/' . $returnid);
	}
	$smarty->assign('mod_pagelinks', $pagelinks);
	$smarty->assign('mod_currentpage', $params['modpage']);
	$smarty->assign('mod_entrieslabel', $this->Lang('entries'));
}

echo $smarty->fetch($this->GetDatabaseResource($template),$cache_id);
?>