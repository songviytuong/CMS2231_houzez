<?php
/*======================================================================================
Module: MultiDomains
======================================================================================*/

// Check authorisation
if (!isset($gCms)) exit;

define('MD_DOMAIN_TABLE',cms_db_prefix().'module_multidomains');
define('MD_DEBUG_TABLE',cms_db_prefix().'module_multidomains_debug');
define('MD_EXTRADOMAIN_TABLE',cms_db_prefix().'module_multidomains_extradomains');
define('MD_LOG_TABLE',cms_db_prefix().'module_multidomains_log');
define('MD_LOGSUM_TABLE',cms_db_prefix().'module_multidomains_logsum');
define('MD_CONTENT_TABLE',cms_db_prefix().'content');

// EOF