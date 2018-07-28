<?php
/*======================================================================================
Module: MultiDomains
======================================================================================*/

// Check authorisation
if (!isset($gCms)) exit;

// Get DB instance and make DB settings
$dict = NewDataDictionary($db);

// Delete db tables
$sqlarray = $dict->DropTableSQL( MD_DOMAIN_TABLE );
$dict->ExecuteSQLArray($sqlarray);
$sqlarray = $dict->DropTableSQL( MD_EXTRADOMAIN_TABLE );
$dict->ExecuteSQLArray($sqlarray);
$sqlarray = $dict->DropTableSQL( MD_LOG_TABLE );
$dict->ExecuteSQLArray($sqlarray);
$sqlarray = $dict->DropTableSQL( MD_LOGSUM_TABLE );
$dict->ExecuteSQLArray($sqlarray);
$sqlarray = $dict->DropTableSQL( MD_DEBUG_TABLE );
$dict->ExecuteSQLArray($sqlarray);

// Remove module permissions
$this->RemovePermission('Manage MultiDomains');

// Remove Events
$this->RemoveEventHandler('Core','ContentPostRender');

// Remove Smarty Plugin
$this->RemoveSmartyPlugin();

// Remove Routes
cms_route_manager::del_static('',$this->GetName());

// Remove module preferences
$this->RemovePreference();

// EOF