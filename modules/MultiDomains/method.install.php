<?php
/*======================================================================================
Module: MultiDomains
======================================================================================*/

// Check authorisation
if (!isset($gCms)) exit;

// Get db handle
$dict = NewDataDictionary($db);
$taboptarray = array('mysql' => 'TYPE=MyISAM');

// Create domain table
$flds = 'id I KEY AUTO,page_id I,domain C(100),devdomain C(100),prefix I(1),active I(1),root I(1),notes X,created_date '.CMS_ADODB_DT.',modified_date '.CMS_ADODB_DT;
$sqlarray = $dict->CreateTableSQL(MD_DOMAIN_TABLE, $flds, $taboptarray);
$dict->ExecuteSQLArray($sqlarray);

// Create extra domain table
$flds = 'id I KEY AUTO,domain_id I,domain C(100),created_date '.CMS_ADODB_DT.',modified_date '.CMS_ADODB_DT;
$sqlarray = $dict->CreateTableSQL(MD_EXTRADOMAIN_TABLE, $flds, $taboptarray);
$dict->ExecuteSQLArray($sqlarray);

// Create debug table
$flds = 'id I KEY AUTO,session_id C(250),ip C(25),fromurl C(250),tourl C(250),status C(250),created_date '.CMS_ADODB_DT.',modified_date '.CMS_ADODB_DT;
$sqlarray = $dict->CreateTableSQL(MD_DEBUG_TABLE, $flds, $taboptarray);
$dict->ExecuteSQLArray($sqlarray);

// Create domain log table
$flds = 'id I KEY AUTO,page_id I,domain C(100),url C(200),referer C(200),searchengine C(50),bot C(50),keyword C(100),sessionid C(50),visittime '.CMS_ADODB_DT;
$sqlarray = $dict->CreateTableSQL(MD_LOG_TABLE, $flds, $taboptarray);
$dict->ExecuteSQLArray($sqlarray);

// Create log summary table
$flds = 'id I KEY AUTO,period C(5),value I(4),type I(1),url C(200),visits I,page_id I,searchengine C(50),keyword C(100),referer C(200),created_date '.CMS_ADODB_DT;
$sqlarray = $dict->CreateTableSQL(MD_LOGSUM_TABLE, $flds, $taboptarray);
$dict->ExecuteSQLArray($sqlarray);

// Set permission
$this->CreatePermission('Manage MultiDomains', 'Manage MultiDomains');

// Preferences
$this->SetPreference('defaultdomain',0);
$this->SetPreference('dont_use_event_handler',0);
$this->SetPreference('clear_cache',0);
$this->SetPreference('system_check',0);
$this->SetPreference('debug_use',0);
$this->SetPreference('devdomain',0);
$this->SetPreference('devip','');
$this->SetPreference('www_replace','');
$this->SetPreference('stats_use',0);
$this->SetPreference('stats_daily',0);
$this->SetPreference('stats_email','');
$this->SetPreference('day',date("Ymd"));
$this->SetPreference('month',date("Ym"));
$this->SetPreference('year',date("Y"));

// Events
$this->RegisterEvents();

// Register Plugin
$this->RegisterModulePlugin(TRUE);
$this->RegisterSmartyPlugin('MultiDomains','function','function_plugin');

// Create Routes
$this->CreateStaticRoutes();

// Write message to admin log
$this->Audit( 0, $this->Lang('friendlyname'), $this->Lang('installed',$this->GetVersion()));

// EOF