<?php
/*======================================================================================
Module: MultiDomains
======================================================================================*/

// Check authorisation
if (!isset($gCms)) exit;
if ( !$this->CheckPermission('Manage MultiDomains') ) exit;

// Get POST data
$tabto = preg_replace('/[^0-9a-zA-Z_]/','',$params['tabto']);
$debug = (int)$params['debug'];

// Delete the domain
if ($debug) {	
	// Get db instance
	$db = cmsms()->GetDb();
	// Delete the domain
	$sql = 'DELETE FROM '.MD_DEBUG_TABLE.' WHERE id=?';
	$res = $db->Execute($sql,array($debug));
}

// Redirect
$this->Redirect($id, 'defaultadmin', $returnid, array( 'tabto'=>$tabto ));

// EOF