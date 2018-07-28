<?php
/*============================================================================ 
Module: MultiDomains
============================================================================*/

// Check authorisation
if (!isset($gCms)) exit;

// Get var
$current_version = $oldversion;

// Get db handle
$dict = NewDataDictionary($db);
$taboptarray = array('mysql' => 'TYPE=MyISAM');

switch ($current_version) {
	case '1.0':
		// Create extra domain table
		$flds = "id I KEY AUTO,domain_id I,domain C(100),created_date ".CMS_ADODB_DT.",modified_date ".CMS_ADODB_DT;
		$sqlarray = $dict->CreateTableSQL(cms_db_prefix()."module_multidomains_extradomains", $flds, $taboptarray);
		$dict->ExecuteSQLArray($sqlarray);
		// Create domain log table
		$flds = "id I KEY AUTO,domain C(100),referer C(200),keyword C(100),sessionid C(50),visittime ".CMS_ADODB_DT;
		$sqlarray = $dict->CreateTableSQL(cms_db_prefix()."module_multidomains_log", $flds, $taboptarray);
		$dict->ExecuteSQLArray($sqlarray);
		// Set preference for development domain
		$this->SetPreference('devdomain',0);
		$this->SetPreference('devip','');
		// Add column for development domain
		$sqlarray = $dict->AddColumnSQL(cms_db_prefix()."module_multidomains", "devdomain C(100)");
		$dict->ExecuteSQLArray($sqlarray);
		// Set new current version
		$current_version = '1.1';
	case '1.1':
		// Create url redirect table
		$flds = "id I KEY AUTO,page_id I,url C(200),devurl C(200),active I(1),notes X,created_date ".CMS_ADODB_DT.",modified_date ".CMS_ADODB_DT;
		$sqlarray = $dict->CreateTableSQL(cms_db_prefix()."module_multidomains_redirect", $flds, $taboptarray);
		$dict->ExecuteSQLArray($sqlarray);
		// Add column for development domain
		$sqlarray = $dict->AddColumnSQL(cms_db_prefix()."module_multidomains_log","url C(200)","page_id I","searchengine C(50)","bot C(50)");
		$dict->ExecuteSQLArray($sqlarray);
		// Create log summary table
		$flds = "id I KEY AUTO,period C(5) NOT NULL,value I(4),type I(1),url C(200),page_id I,visits I,searchengine C(50),keyword C(100),referer C(200),created_date ".CMS_ADODB_DT;
		$sqlarray = $dict->CreateTableSQL(cms_db_prefix()."module_multidomains_logsum", $flds, $taboptarray);
		$dict->ExecuteSQLArray($sqlarray);
		// Set current date in the global preferences
		$this->SetPreference('day',date("Ymd"));
		$this->SetPreference('month',date("Ym"));
		$this->SetPreference('year',date("Y"));
		$current_version = '1.2';
	case '1.2':
		// Set current date in the global preferences
		$this->SetPreference('day',date("Ymd"));
		$this->SetPreference('month',date("Ym"));
		$current_version = '1.2.1';
	case '1.2.1':
		$current_version = '1.2.2';
	case '1.2.2':
		$this->RegisterEvents();
		$this->SetPreference('stats_use',0);
		$this->SetPreference('stats_daily',0);
		$this->SetPreference('stats_email','');
		$this->SetPreference('oldurl_use',1);
		$current_version = '1.3';
	case '1.3':
		$current_version = '1.3.1';
	case '1.3.1':
	case '1.3.2':
	case '1.3.3':
		$this->SetPreference('stats_404',0);
		// Create error (404) table
		$flds = 'id I KEY AUTO,fromurl C(250),tourl C(250),visits I(8),created_date '.CMS_ADODB_DT.',modified_date '.CMS_ADODB_DT;
		$sqlarray = $dict->CreateTableSQL(cms_db_prefix().'module_multidomains_errors', $flds, $taboptarray);
		$dict->ExecuteSQLArray($sqlarray);
		$db->Execute('UPDATE '.cms_db_prefix().'modules SET active = 1 WHERE module_name="MultiDomains"',array());
		// Increase version
		$current_version = '1.4';
	case '1.4':
		// Add column for development domain
		$sqlarray = $dict->AddColumnSQL(cms_db_prefix().'module_multidomains_redirect','tourl C(250)');
		$dict->ExecuteSQLArray($sqlarray);
		// Create error (404) ignore table
		$flds = 'id I KEY AUTO,iurl C(250),iregexp I(1),created_date '.CMS_ADODB_DT.',modified_date '.CMS_ADODB_DT;
		$sqlarray = $dict->CreateTableSQL(cms_db_prefix().'module_multidomains_errors_ignore', $flds, $taboptarray);
		$dict->ExecuteSQLArray($sqlarray);
		// Set max log errors
		$this->SetPreference('max_404',100);
		// Increase version
		$current_version = '1.4.1';
	case '1.4.1':
		// Add column for development domain
		$sqlarray = $dict->AddColumnSQL(cms_db_prefix().'module_multidomains_redirect','url_regexp I(1)');
		$dict->ExecuteSQLArray($sqlarray);
		// Set preference for the debug tab
		$this->SetPreference('debug_use',0);
		// Create debug table
		$flds = 'id I KEY AUTO,session_id C(250),ip C(25),fromurl C(250),tourl C(250),status C(250),created_date '.CMS_ADODB_DT.',modified_date '.CMS_ADODB_DT;
		$sqlarray = $dict->CreateTableSQL(cms_db_prefix().'module_multidomains_debug', $flds, $taboptarray);
		$dict->ExecuteSQLArray($sqlarray);
		// Activate module
		$db->Execute('UPDATE '.cms_db_prefix().'modules SET active = 1 WHERE module_name="MultiDomains"',array());
		// Increase version
		$current_version = '1.5';
	case '1.5':
		// Activate module
		$db->Execute('UPDATE '.cms_db_prefix().'modules SET active = 1 WHERE module_name="MultiDomains"',array());
		// Increase version
		$current_version = '1.5.1';
	case '1.5.1':
		// Increase version
		$current_version = '1.5.2';
	case '1.5.2':
		// Add option to de-activate event handling
		$this->SetPreference('dont_use_event_handler',0);
		// Increase version
		$current_version = '1.5.3';
	case '1.5.3':
		// Delete db tables
		#$sqlarray = $dict->DropTableSQL( cms_db_prefix().'module_multidomains_redirect' );
		#$dict->ExecuteSQLArray($sqlarray);
		#$sqlarray = $dict->DropTableSQL( cms_db_prefix().'module_multidomains_errors' );
		#$dict->ExecuteSQLArray($sqlarray);
		#$sqlarray = $dict->DropTableSQL( cms_db_prefix().'module_multidomains_errors_ignore' );
		#$dict->ExecuteSQLArray($sqlarray);
		// Add more settings
		$this->SetPreference('clear_cache',0);
		$this->SetPreference('system_check',0);
		// Increase version
		$current_version = '2.0';
	case '2.0':
		// Increase version
		$current_version = '2.0.1';
	case '2.0.1':
		// Add column for root domain
		$sqlarray = $dict->AddColumnSQL(cms_db_prefix()."module_multidomains", "root I(1)");
		$dict->ExecuteSQLArray($sqlarray);
		// Increase version
		$current_version = '2.1';
	case '2.1':
		// Increase version
		$current_version = '2.1.1';
	case '2.1.1':
		// Increase version
		$current_version = '2.1.2';
	case '2.1.2':
		// Increase version
		$this->SetPreference('www_replace','');
		$this->RegisterModulePlugin(TRUE);
		$this->RegisterSmartyPlugin('MultiDomains','function','function_plugin');
		$this->CreateStaticRoutes();
		$current_version = '2.2.1';
	case '2.2.1':
		// Increase version
		$current_version = '2.2.2';
	case '2.2.2':
		// Increase version
		$current_version = '2.2.3';
}

// EOF