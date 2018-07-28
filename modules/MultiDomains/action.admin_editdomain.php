<?php
/*======================================================================================
Module: MultiDomains
======================================================================================*/

// Check authorisation
if (!isset($gCms)) exit;
if ( !$this->CheckPermission('Manage MultiDomains') ) exit;

// Get POST data
$tabto = preg_replace('/[^0-9a-zA-Z_]/','',$params['tabto']);
$edomain = array();
$edomain['id'] = isset($params['domain']) ? (int)$params['domain'] : 0;
if (isset($params['prefix'])) $edomain['prefix'] = $params['prefix'] ? 1 : 0; else $edomain['prefix'] = 0;
$edomain['domain'] = isset($params['domainname']) ? trim($params['domainname']) : '';
if (substr($edomain['domain'],0,8)=='https://') $edomain['domain'] = substr($edomain['domain'],8);
if (substr($edomain['domain'],0,7)=='http://') $edomain['domain'] = substr($edomain['domain'],7);
if (substr($edomain['domain'],0,4)=='www.') $edomain['domain'] = substr($edomain['domain'],4);
$edomain['devdomain'] = isset($params['devdomainname']) ? trim($params['devdomainname']) : '';
if (substr($edomain['devdomain'],0,8)=='https://') $edomain['devdomain'] = substr($edomain['devdomain'],8);
if (substr($edomain['devdomain'],0,7)=='http://') $edomain['devdomain'] = substr($edomain['devdomain'],7);
$edomain['page'] = isset($params['page']) ? preg_replace('/[^0-9]/','',$params['page']) : 0;
if (isset($params['active'])) $edomain['active'] = $params['active'] ? 1 : 0; else $edomain['active'] = 0;
if (isset($params['root'])) $edomain['root'] = $params['root'] ? 1 : 0; else $edomain['root'] = 0;
$edomain['extradomains'] = isset($params['extradomains']) ? $params['extradomains'] : '';
$edomain['notes'] = isset($params['notes']) ? $params['notes'] : '';

// Save domain changes
if (isset($params['submit']) || isset($params['cache']) || isset($params['add']) || isset($params['cacheadd'])) {
	// Edit domain
	if ($edomain['id']) {
		$sql = 'UPDATE '.MD_DOMAIN_TABLE.' SET page_id=?, domain=?, devdomain=?, prefix=?, active=?, root=?, notes=?, modified_date=NOW() WHERE id=?';
		$res = $db->Execute($sql,array($edomain['page'], $edomain['domain'], $edomain['devdomain'], $edomain['prefix'], $edomain['active'], $edomain['root'], $edomain['notes'], $edomain['id']));
	// Insert news domain
	} else {
		$sql = 'INSERT INTO '.MD_DOMAIN_TABLE.' (page_id, domain, devdomain, prefix, active, root, notes, created_date, modified_date) VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), NOW())';
		$res = $db->Execute($sql,array($edomain['page'], $edomain['domain'], $edomain['devdomain'], $edomain['prefix'], $edomain['active'], $edomain['root'], $edomain['notes']));
		$edomain['id'] = $db->GetOne('SELECT id FROM '.MD_DOMAIN_TABLE.' WHERE domain = ?', array($edomain['domain']));
	}
	// Build extradomain array
	$extradomains = array();
	if (trim($params['extradomains'])) {
		$extradomains_temp = explode("\n",$params['extradomains']);
		foreach ($extradomains_temp as $edt) {
			if (trim($edt)) $extradomains[] = trim($edt);		
		}
	}
	// Get existing extra domains
	$existing_extradomains = $db->GetCol('SELECT domain FROM '.MD_EXTRADOMAIN_TABLE.' WHERE domain_id = ?', array($edomain['id']));
	// Delete extra domains
	if (!is_array($existing_extradomains)) $existing_extradomains = array();
	if ($existing_extradomains) {
		$res = $db->Execute('DELETE FROM '.MD_EXTRADOMAIN_TABLE.' WHERE domain_id=?',array($edomain['id']));
		#foreach ($existing_extradomains as $ed) {
		#	if (!in_array($ed,$existing_extradomains)) $db->Execute('DELETE FROM '.cms_db_prefix().'module_multidomains_extradomains WHERE domain_id=?, domain = ?',array($edomains['id'],$ed));
		#}
	}
	// Add or update extra domains
	foreach ($extradomains as $ed) {
		// Update extra domain
		#if (in_array($ed,$existing_extradomains)) {
		#	$sql = 'UPDATE '.cms_db_prefix().'module_multidomains_extradomains SET domain_id=?, domain=?, modified_date=NOW() WHERE domain=?';
		#	$res = $db->Execute($sql,array($edomain['id'], $ed, $edomain['id']));
		// Add extra domain
		#} else {
			$sql = 'INSERT INTO '.MD_EXTRADOMAIN_TABLE.' (domain_id, domain, created_date, modified_date) VALUES (?, ?, NOW(), NOW())';
			$res = $db->Execute($sql,array($edomain['id'], $ed));
		#}
	}
	// Clear CMS cache
	if ($this->GetPreference('clear_cache')) cmsms()->clear_cached_files();
}

// Redirect
if (isset($params['submit']) || isset($params['cancel']) || isset($params['add'])) $this->Redirect($id, 'defaultadmin', $returnid, array( 'tabto'=>$tabto ));
else $this->Redirect($id, 'defaultadmin', $returnid, array( 'tabto'=>$tabto, 'domain'=>$edomain['id'] ));

// EOF