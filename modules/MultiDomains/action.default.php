<?php
/*======================================================================================
Module: MultiDomains
======================================================================================*/

// Check authorisation
if (!isset($gCms)) exit;

// Case if page id or parameter was given
if (isset($params['pageid']) || isset($params['pagealias'])) {
	// Get parameters
	$pageid = isset($params['pageid']) ? (int)$params['pageid'] : 0;
	$pagealias = isset($params['pagealias']) ? $params['pagealias'] : '';
	$linkvalue = isset($params['linkvalue']) ? $params['linkvalue'] : '';
	if (!$pageid && $pagealias) $pageid = $db->GetOne('SELECT content_id FROM '.MD_CONTENT_TABLE.' WHERE content_alias = ?', array($pagealias));
	// Get URL
	echo $this->GetURL($pageid,$linkvalue);
} else {
	// Check if module was already used and if filter is ok
	if (!$this->mdused && !$this->mdFilter()) {
		// Set the module used
		$this->mdused = true;
		// Set content id
		$this->mdpageid = (int)cmsms()->variables['content_id'];
		// Log visit
		$log = $this->GetPreference('stats_use') ? $this->PrepareLogVisit() : array();
		// Log debug
		if($this->GetPreference('debug_use')) $this->DebugMD();
		// Look for redirect domains
		$this->RedirectDomain($log);
		// Assign site to smarty template vars
		$smarty->assign('mdsite',$this->mddomain);
		$smarty->assign('mddevsite',$this->mddev ? $this->mddevdomain : '');
	}
}
return '';

// EOF