<?php
/*======================================================================================
Module: Multidomains
======================================================================================*/

// Check authorisation
if (!isset($gCms)) exit;
if ( !$this->CheckPermission('Manage MultiDomains') ) exit;

// Get POST data
$tabto = preg_replace('/[^0-9a-zA-Z_]/','',$params['tabto']);
$domain = (int)$params['domain'];
$active = $params['active'] ? 1 : 0;

// De-/Activate Domain
if ($domain) {
	// Get db instance
	$db = cmsms()->GetDb();
	// De-/Activate the domain
	$sql = 'UPDATE '.MD_DOMAIN_TABLE.' SET active=? WHERE id=?';
	$res = $db->Execute($sql,array($active, $domain));
	if ($this->GetPreference('clear_cache')) cmsms()->clear_cached_files();
}

// Redirect
$this->Redirect($id, 'defaultadmin', $returnid, array( 'tabto'=>$tabto ));

// EOF