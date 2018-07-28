<?php
/*======================================================================================
Module: MultiDomains
======================================================================================*/

// Check authorisation
if (!isset($gCms)) exit;
if ( !$this->CheckPermission('Manage MultiDomains') ) exit;

// Set Tab name
$tabto = 'stats';

// Datum ermitteln
$lday = (int)date('d', time() - 86400);
$lmonth = (int)date('m',strtotime('-1 month'));
$lyear = (int)date('Y',strtotime('-1 year'));

// Assign Smarty vars
$smarty->assign('tabto',$this->CreateInputHidden($id,'tabto',$tabto));
$smarty->assign('days_domains', getLogSum($lday,'day') );
$smarty->assign('months_domains', getLogSum($lmonth,'month') );
$smarty->assign('years_domains', getLogSum($lyear,'year') );
$smarty->assign('domain',$this->Lang('domain'));
$smarty->assign('domains',$this->Lang('domains'));
$smarty->assign('page',$this->Lang('page'));
$smarty->assign('visits',$this->Lang('visits'));
$smarty->assign('searchengine',$this->Lang('searchengine'));
$smarty->assign('keyword',$this->Lang('keyword'));
$smarty->assign('referer',$this->Lang('referer'));
$smarty->assign('day',$this->Lang('day'));
$smarty->assign('days',$this->Lang('days'));
$smarty->assign('month',$this->Lang('month'));
$smarty->assign('months',$this->Lang('months'));
$smarty->assign('year',$this->Lang('year'));
$smarty->assign('years',$this->Lang('years'));
$smarty->assign('last_day',$this->Lang('last_day'));
$smarty->assign('last_month',$this->Lang('last_month'));
$smarty->assign('last_year',$this->Lang('last_year'));
$smarty->assign('stats_daily',$this->GetPreference('stats_daily') ? 1 : 0);

// Display Template
echo $this->ProcessTemplate('admin_stats.tpl');

function getLogSum ($v,$period) {
	// Set db
	$db = cmsms()->GetDb();
	// Get data
	$data = $db->GetAll('SELECT url,page_id,visits,searchengine,keyword,referer FROM '.MD_LOGSUM_TABLE.' WHERE type=1 AND period=? AND value=? ORDER BY url',array($period,(int)$v));
	if (!is_array($data)) $data = array();
	// List data
	$result = array();
	$rowclass = 'row1';
	foreach ( $data as $d ) {
		// Build a new row
		$row = new StdClass();
		$row->rowclass = $rowclass;
		// URL
		$row->url = $d['url'];
		// Page
		$row->page_id = $d['page_id'];
		if ($row->page_id) $pageinfo = $db->GetRow('SELECT menu_text,hierarchy,content_alias FROM '.MD_CONTENT_TABLE.' WHERE content_id = ?', array($d['page_id'])); else $pageinfo = array();
		if ($pageinfo) {
			$hierarchies = explode('.',$pageinfo['hierarchy']);
			foreach ($hierarchies as $k=>$h) $hierarchies[$k]=(int)$h;
			$row->page = $pageinfo['menu_text'].' <em>('.implode('.',$hierarchies).':'.$pageinfo['content_alias'].')</em>';
		}
		// Visits
		$row->visits = $d['visits'];
		// Search Engine
		$row->searchengine = $d['searchengine'];
		// Keyword
		$row->keyword = $d['keyword'];
		// Referer
		$row->referer = $d['referer'];
		// Merge new redirect to array
		array_push ($result, $row);
		// Alternate row color
		($rowclass == 'row1' ? $rowclass = 'row2' : $rowclass = 'row1');
	}
	return $result;
}

// EOF