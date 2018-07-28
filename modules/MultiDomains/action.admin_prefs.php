<?php
/*======================================================================================
Module: Multidomains
======================================================================================*/

// Check authorisation
if (!isset($gCms)) exit;
if ( !$this->CheckPermission('Manage MultiDomains') ) exit;

// Get POST data
$tabto = preg_replace('/[^0-9a-zA-Z_]/','',$params['tabto']);

// Set preferences
$dont_use_event_handler = isset($params['dont_use_event_handler']) ? (int)$params['dont_use_event_handler'] : 0;
if ($dont_use_event_handler != $this->GetPreference('dont_use_event_handler')) {
	if ($dont_use_event_handler) { $this->RemoveEventHandler('Core','ContentPostRender'); }
	else { $this->AddEventHandler('Core','ContentPostRender',false); }
}
$this->SetPreference('dont_use_event_handler',$dont_use_event_handler);
$this->SetPreference('clear_cache',isset($params['clear_cache']) ? (int)$params['clear_cache'] : 0);
$this->SetPreference('debug_use',isset($params['debug_use']) ? (int)$params['debug_use'] : 0);
$this->SetPreference('devdomain',isset($params['devdomain']) ? (int)$params['devdomain'] : 0);
$this->SetPreference('devip',isset($params['devip']) ? trim($params['devip']) : '');
$this->SetPreference('www_replace',isset($params['www_replace']) ? trim($params['www_replace']) : '');
$this->SetPreference('stats_use',isset($params['stats_use']) ? (int)$params['stats_use'] : 0);
$this->SetPreference('stats_daily',isset($params['stats_daily']) ? (int)$params['stats_daily'] : 0);
$this->SetPreference('stats_email',isset($params['stats_email']) ? trim($params['stats_email']) : '');

// Redirect
$this->Redirect($id, 'defaultadmin', $returnid, array( 'tabto'=>$tabto ));

// EOF