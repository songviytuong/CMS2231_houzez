<?php
/*======================================================================================
Module: MultiDomains
======================================================================================*/

// Check authorisation
if (!isset($gCms)) exit;
if ( !$this->CheckPermission('Manage MultiDomains') ) exit;

// Set Tab name
$tabto = 'prefs';

// Assign Smarty vars
$smarty->assign('formstart',$this->CreateFormStart($id,'admin_prefs',$returnid,'post','multipart/form-data',true,array()));
$smarty->assign('formend',$this->CreateFormEnd());
$smarty->assign('submit',$this->CreateInputSubmit($id,'submit',$this->Lang('submit')));
$smarty->assign('tabto',$this->CreateInputHidden($id,'tabto',$tabto));

$smarty->assign('prompt_dont_use_event_handler',$this->Lang('dont_use_event_handler'));
$smarty->assign('input_dont_use_event_handler',$this->CreateInputCheckbox($id,'dont_use_event_handler','1',$this->GetPreference('dont_use_event_handler'),'0'));
$smarty->assign('help_dont_use_event_handler',$this->Lang('dont_use_event_handler_help'));

$smarty->assign('prompt_clear_cache',$this->Lang('clear_cache'));
$smarty->assign('input_clear_cache',$this->CreateInputCheckbox($id,'clear_cache','1',$this->GetPreference('clear_cache'),'0'));
$smarty->assign('help_clear_cache',$this->Lang('clear_cache_help'));

$smarty->assign('prompt_debug_use',$this->Lang('debug_use'));
$smarty->assign('input_debug_use',$this->CreateInputCheckbox($id,'debug_use','1',$this->GetPreference('debug_use'),'0'));

$smarty->assign('prompt_devdomain',$this->Lang('devdomain_activate'));
$smarty->assign('input_devdomain',$this->CreateInputCheckbox($id,'devdomain','1',$this->GetPreference('devdomain'),'0'));
$smarty->assign('prompt_devip',$this->Lang('devip'));
$smarty->assign('input_devip',$this->CreateInputText($id,'devip',$this->GetPreference('devip'),15,50));

$smarty->assign('prompt_replace_www',$this->Lang('www_replace'));
$smarty->assign('input_replace_www',$this->CreateInputText($id,'www_replace',$this->GetPreference('www_replace'),15,50));

$smarty->assign('prompt_stats_use',$this->Lang('stats_use'));
$smarty->assign('input_stats_use',$this->CreateInputCheckbox($id,'stats_use','1',$this->GetPreference('stats_use'),'0'));
$smarty->assign('prompt_stats_daily',$this->Lang('stats_daily'));
$smarty->assign('input_stats_daily',$this->CreateInputCheckbox($id,'stats_daily','1',$this->GetPreference('stats_daily'),'0'));
$smarty->assign('prompt_stats_email',$this->Lang('stats_email'));
$smarty->assign('input_stats_email',$this->CreateInputText($id,'stats_email',$this->GetPreference('stats_email'),30,100));
$smarty->assign('help_stats_email',$this->Lang('stats_email_help'));

// Display Template
echo $this->ProcessTemplate('admin_prefs.tpl');

// EOF