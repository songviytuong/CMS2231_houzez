<?php
/*======================================================================================
Module: MultiDomains
======================================================================================*/

// Check authorisation
if (!isset($gCms)) exit;

// Set needed objects
#$db = cmsms()->GetDb();
#$smarty = cmsms()->GetSmarty();

// Insert content operations class
#$contentops =& cmsms()->GetContentOperations();
$contentops = \ContentOperations::get_instance();

// Get Tab Redirect action
$tabto = isset($params['tabto']) ? preg_replace('/[^0-9a-zA-Z_]/','',$params['tabto']) : 'domains';

echo $this->donate;

if (isset($params['message'])) {
	if ($params['message']) echo '<br /><br /><div style="border:3px solid #ff3333; margin:5px; padding:5px; font-weight:bold;">'.$params['message'].'</div><br />';
}

// Displays the Tabs
echo $this->StartTabHeaders();
if ( $this->CheckPermission('Manage MultiDomains') ) {
	echo $this->SetTabHeader('domains',$this->Lang('domains'),$tabto=='domains'?true:false);
}
if ( $this->CheckPermission('Manage MultiDomains') && $this->GetPreference('stats_use') ) {
	echo $this->SetTabHeader('stats',$this->Lang('stats'),$tabto=='stats'?true:false);
}
if ( $this->CheckPermission('Manage MultiDomains') ) {
	echo $this->SetTabHeader('prefs',$this->Lang('preferences'),$tabto=='prefs'?true:false);
}
if ( $this->CheckPermission('Manage MultiDomains') && $this->GetPreference('debug_use') ) {
	echo $this->SetTabHeader('debug','<span style="color:red;font-weight:bold;text-decoration:blink;">'.$this->Lang('debug').'</span>',$tabto=='debug'?true:false);
}
echo $this->EndTabHeaders();

// Display the content of the tabs
echo $this->StartTabContent();
if ( $this->CheckPermission('Manage MultiDomains') ) {
	echo $this->StartTab('domains');
	include(__DIR__.'/function.admin_domains.php');
	echo $this->EndTab();
}
if ( $this->CheckPermission('Manage MultiDomains') && $this->GetPreference('stats_use') ) {
	echo $this->StartTab('stats');
	include(dirname(__FILE__).'/function.admin_stats.php');
	echo $this->EndTab();
}
if ( $this->CheckPermission('Manage MultiDomains') ) {
	echo $this->StartTab('prefs');
	include(dirname(__FILE__).'/function.admin_prefs.php');
	echo $this->EndTab();
}
if ( $this->CheckPermission('Manage MultiDomains') && $this->GetPreference('debug_use') ) {
	echo $this->StartTab('debug');
	include(dirname(__FILE__).'/function.admin_debug.php');
	echo $this->EndTab();
}
echo $this->EndTabContent();

// EOF