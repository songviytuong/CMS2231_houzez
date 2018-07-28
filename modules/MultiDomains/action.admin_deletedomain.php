<?php
/*======================================================================================
Module: MultiDomains
======================================================================================*/

// Check authorisation
if (!isset($gCms)) exit;
if ( !$this->CheckPermission('Manage MultiDomains') ) exit;

// Get POST data
$tabto = preg_replace('/[^0-9a-zA-Z_]/','',$params['tabto']);
$domain = (int)$params['domain'];

// Delete the domain
if ($domain) {
	// Get db instance
	$db = cmsms()->GetDb();
	// Delete the domain
	$sql = 'DELETE FROM '.MD_DOMAIN_TABLE.' WHERE id=?';
	$res = $db->Execute($sql,array($domain));
	if ($this->GetPreference('clear_cache')) cmsms()->clear_cached_files();
}

// Redirect
$this->Redirect($id, 'defaultadmin', $returnid, array( 'tabto'=>$tabto ));

// EOF