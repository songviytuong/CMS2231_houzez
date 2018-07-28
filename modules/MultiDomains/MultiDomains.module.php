<?php
/*======================================================================================
Module:		MultiDomains
Title:		Main class
Version:	2.2.3
Descript.:	An addon module for CMS Made Simple to use different domains with one installation.
Last Mod.:	24.02.2016
Author:		Andi Petzoldt
Profile:	https://plus.google.com/113580733838250075244
Notes:
Licence:	This program is free software; you can redistribute it and/or modify
			it under the terms of the GNU General Public License as published by
			the Free Software Foundation; either version 2 of the License, or
			(at your option) any later version.
			However, as a special exception to the GPL, this software is distributed
			as an addon module to CMS Made Simple.  You may not use this software
			in any Non GPL version of CMS Made simple, or in any version of CMS
			Made Simple that does not indicate clearly and obviously in its admin
			section that the site was built with CMS Made Simple.
			Find more information about CMS Made Simple on its website:
			http://www.cmsmadesimple.org/
			This program is distributed in the hope that it will be useful,
			but WITHOUT ANY WARRANTY; without even the implied warranty of
			MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
			GNU General Public License for more details.
			You should have received a copy of the GNU General Public License
			along with this program; if not, write to the Free Software
			Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
			Or read it online: http://www.gnu.org/licenses/licenses.html#GPL
======================================================================================*/


/*===== Notizen Start =====

Aktuelle Seiten-ID ermitteln ueber cms_utils::get_current_pageid();
siehe http://forum.cmsmadesimple.org/viewtopic.php?f=6&t=62383

======= Notizen Ende ====*/


// Includes
#require_once(__DIR__.'/function.utils.php');
require_once(__DIR__.'/defines.php');


/**
 * Class MultiDomains.
 *
 * This class provides basic functions for the CMSms addon "MultiDomains"
 *
 */
class MultiDomains extends CMSModule {

	// class vars
	private $mdgCms;
	private $mddb;
	private $mdsmarty;
	public $mdpageid;
	public $mddomain;
	public $mddevdomain;
	private $mddev;
	private $mdlogging;
	public $mdused;
	private $mdhttp;
	private $mdreferer;
	private $mdomains;
	private $mdversion;
	private $mdevents;
	private $mddebugid;
	protected $donate;

	/*
	* Constructor function
	*/
	public final function __construct() {
		// Set gCms
		$this->mdgCms = cmsms();
		// Set db
		$this->mddb = $this->mdgCms->GetDb();
		// Set smarty
		$this->mdsmarty = $this->mdgCms->GetSmarty();
		// Check version
		if (!$this->mdversion) $this->mdversion = $this->mddb->GetOne('SELECT version FROM '.cms_db_prefix().'modules WHERE module_name="MultiDomains"', array());
		// Prepare vars
		$this->mddev = false;
		if ($_SERVER['SERVER_ADDR']==$this->GetPreference('devip') && $this->GetPreference('devdomain')) { $this->mddev = true; }
		$this->mdwwwrp = $this->GetPreference('www_replace') ? $this->GetPreference('www_replace') : 'www';
		$this->mdpageid = 0;
		$this->mddomain = $_SERVER['HTTP_HOST'];
		if (substr($this->mddomain,0,4)==$this->mdwwwrp.'.') $this->mddomain = substr($this->mddomain,4);
		if ($this->mddev) {
			$rdomain = $this->mddb->GetOne('SELECT domain FROM '.MD_DOMAIN_TABLE.' WHERE devdomain = ?', array($this->mddomain));
			if ($rdomain) {
				$this->mddevdomain = $this->mddomain;
				$this->mddomain = $rdomain;
			}
		}
		$this->mdlogging = false;
		$this->mdused = false;
		$this->mdomains = array();
		$this->mdhttp = $_SERVER['SERVER_PORT']==443 ? 'https://' : 'http://';
		$this->mdreferer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
		$this->mdevents = $this->GetPreference('dont_use_event_handler') ? 0 : 1;
		$this->mddebugid = 0;
		$this->donate = $this->Lang('donate');
		$this->SetParameters();
		parent::__construct();
	}

	/**
	* Get the real name of this module.
	* @return string
	*/
	public final function GetName() {
		return 'MultiDomains';
	}

	/**
	* Get a friendly (translated) name of this module.
	* @return string
	*/
	public final function GetFriendlyName() {
		return $this->Lang('friendlyname');
	}

	/**
	* Get the version of this module.
	* @return string
	*/
	public final function GetVersion() {
		return '2.2.3';
	}

	/**
	* Is this an module only for the CMSms backend?.
	* @return bloolean
	*/
	public final function IsAdminOnly() {
		return false;
	}

	/**
	* Gets a help text for this module.
	* @return string
	*/
	public final function GetHelp() {
		return $this->donate.$this->Lang('help');
	}

	/**
	* Gets the author of this module
	* @return string
	*/
	public final function GetAuthor() {
		return 'Andi Petzoldt';
	}

	/**
	* Gets the module authors email address.
	* @return string
	*/
	public final function GetAuthorEmail() {
		return 'andi@petzoldt.net';
	}

	/**
	* Get the changelog of this module
	* @return string
	*/
	public final function GetChangeLog() {
		return $this->donate.$this->Lang('changelog');
	}

	/**
	* Get the dependencies for this module.
	* @return array
	*/
	public final function GetDependencies() {
		return array();
	}

	/**
	* Is this an optional module for CMSms?
	* @return boolean
	*/
	public final function IsPluginModule() {
		return true;
	}

	/**
	* Has this module an admin
	* @return boolean
	*/
	public final function HasAdmin() {
		return true;
	}

	/**
	* Shall this module handle events?
	* @return boolean
	*/
	public final function HandlesEvents() {
		return $this->mdevents ? true : false;
	}

	/**
	* Register Event
	*/
	public final function RegisterEvents(){
		if (!$this->GetPreference('dont_use_event_handler')) {
			$this->AddEventHandler( 'Core', 'ContentPostRender', false );
			#$this->AddEventHandler( 'Core', 'ContentPreCompile', false );   --> doesn't work
		}
	}

	/**
	* Run Event
	*/
	public final function DoEvent($originator, $eventname, &$params) {
		if ($this->mdevents) {
			// Check event
			if($originator=='Core' && $eventname=='ContentPostRender'){
				// Check if module was already used and if filter is ok
				if (!$this->mdused && !$this->mdFilter()) {
					// Set the module used
					$this->mdused = true;
					// Set content id
					$this->mdpageid = (int)$this->mdgCms->variables['content_id'];
					// Log visit
					$log = $this->GetPreference('stats_use') ? $this->PrepareLogVisit() : array();
					// Log debug
					if($this->GetPreference('debug_use')) $this->DebugMD();
					// Look for redirect domains
					$this->RedirectDomain($log);
					// Assign site to smarty template vars
					$this->mdsmarty->assign('mdsite',$this->mddomain);
					$this->mdsmarty->assign('mddevsite',$this->mddev ? $this->mddevdomain : '');
				}
			}
		}
	}

	/**
	* In which main menu of the backend shall this module be?
	* @return string
	*/
	public final function GetAdminSection() {
		return 'extensions';
	}

	/**
	* Get an module description for the backend.
	* @return string
	*/
	public final function GetAdminDescription() {
		return $this->Lang('moddescription');
	}

	/**
	* Sets the permission for this module.
	* @return string
	*/
	public final function VisibleToAdminUser() {
		return $this->CheckPermission('Manage MultiDomains');
	}

	/**
	* What is the minimum version of CMSms for this module?
	* @return string
	*/
	public final function MinimumCMSVersion() {
		return '2.01';
	}

	/**
	* Set parameters for this module.
	*/
	public final function SetParameters() {
		$this->InitializeAdmin();
      	$this->InitializeFrontend();
		###$this->RegisterModulePlugin();
		#$this->RegisterEvents();

		###$this->RestrictUnknownParams();
		#$this->RegisterRoute('/[sS]itemap.xml\/(?P<mode>[0-9]+)$/');

		// Module params
		// $this->CreateParameter('paramName','defaultValue','HelpDescription');
		###$this->CreateParameter('pageid', 0, $this->lang('pageid'));
		###$this->CreateParameter('pagealias', '', $this->lang('pagealias'));
		###$this->CreateParameter('linkvalue', '', $this->lang('linkvalue'));

		// Form params
		// $this->SetParameterType('paramName',CLEAN_TYPE);
		// CLEAN_TYPE could be CLEAN_NONE / CLEAN_STRING / CLEAN_INT / CLEAN_FLOAT / CLEAN_FILE
		###$this->SetParameterType('pageid',CLEAN_INT);
		###$this->SetParameterType('pagealias',CLEAN_STRING);
		###$this->SetParameterType('linkvalue',CLEAN_STRING);

	}
	
	/**
	* Set parameter types for frontend.
	*/
	function InitializeFrontend() {
		$this->RestrictUnknownParams();
		$this->SetParameterType('pageid',CLEAN_INT);
		$this->SetParameterType('pagealias',CLEAN_STRING);
		$this->SetParameterType('linkvalue',CLEAN_STRING);
	}
	
	/**
	* Set parameter types for backend.
	*/
	function InitializeAdmin() {
		$this->CreateParameter('pageid', 0, $this->lang('pageid'));
		$this->CreateParameter('pagealias', '', $this->lang('pagealias'));
		$this->CreateParameter('linkvalue', '', $this->lang('linkvalue'));
	}

	/**
	* Gets a message to display after installing the module
	* @return string
	*/
	public final function InstallPostMessage() {
		return $this->Lang('postinstall');
	}

	/**
	* Gets a message to disply after uninstalling this module.
	* @return string
	*/
	public final function UninstallPostMessage() {
		return $this->Lang('postuninstall');
	}

	/**
	* Gets a message before uninstalling this module
	* @return string
	*/
	public final function UninstallPreMessage() {
		return $this->Lang('preuninstall');
	}

	/**
	* Filter problem URL's
	* @return boolean
	*/
	public final function mdFilter() {
		// Set return value
		$filter = false;
		// Filter function
		if (preg_match('/mact=NMS/',$_SERVER['REQUEST_URI'])) $filter = true;
		// return value
		return $filter;
	}

	/**
	* Builds a summary log and writes it to database
	* @param array $data The log data as array.
	* @param string $period The period to log (day, month or year).
	* @param int $pvalue The day, month or year as integer (e.g. december would be 12)
	*/
	public final function LogSum($data,$period,$pvalue) {

		// Build sum arrays
		$domlog = array();
		$urllog = array();

		// Check data array
		if (is_array($data)) {

			// Build sql insert query
			$sql = 'INSERT INTO '.MD_LOGSUM_TABLE.' (period, value, type, url, page_id, visits, searchengine, keyword, referer, created_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())';
			#echo $sql.'<hr />';

			// Set mail arrays
			$maildomains = array();
			$mailurls = array();

			// Walk through log and build a summary of the values
			foreach ($data as $d) {
				// Set type
				$d['domain'] = $d['url'];
				$d['url'] = '';
				// Set visits
				$visits = isset($d['visits']) ? $d['visits'] : 1;
				// Log to domain summary
				if (!isset($domlog[$d['domain']])) {
					$domlog[$d['domain']] = array (	'referer' => '',
													'searchengine' => '',
													'keyword' => '',
													'page_id' =>  0,
													'visits' =>  0,
													'areferer' => array(),
													'asearchengine' => array(),
													'akeyword' => array(),
													'apage_id' =>  array() );
				}
				if (!isset($domlog[$d['domain']]['areferer'][$d['referer']])) $domlog[$d['domain']]['areferer'][$d['referer']]=0;
				if (!isset($domlog[$d['domain']]['asearchengine'][$d['searchengine']])) $domlog[$d['domain']]['asearchengine'][$d['searchengine']]=0;
				if (!isset($domlog[$d['domain']]['akeyword'][$d['keyword']])) $domlog[$d['domain']]['akeyword'][$d['keyword']]=0;
				if (!isset($domlog[$d['domain']]['apage_id'][$d['page_id']])) $domlog[$d['domain']]['apage_id'][$d['page_id']]=0;
				if ($d['referer']) $domlog[$d['domain']]['areferer'][$d['referer']]++;
				if ($d['searchengine']) $domlog[$d['domain']]['asearchengine'][$d['searchengine']]++;
				if ($d['keyword']) $domlog[$d['domain']]['akeyword'][$d['keyword']]++;
				if ($d['page_id']>0) $domlog[$d['domain']]['apage_id'][$d['page_id']]++;
				$domlog[$d['domain']]['visits']+= $visits;
			}

			// Build domain summary
			foreach ($domlog as $key=>$value) {
				// Get best referer
				if (is_array($value['areferer'])) {
					$mdsum = 0;
					foreach ($value['areferer'] as $key2=>$value2) {
						if ($value2 > $mdsum) {
							$domlog[$key]['referer'] = $key2;
							$mdsum = $value2;
						}
					}
				}
				// Get best searchengine
				if (is_array($value['asearchengine'])) {
					$mdsum = 0;
					foreach ($value['asearchengine'] as $key2=>$value2) {
						if ($value2 > $mdsum) {
							$domlog[$key]['searchengine'] = $key2;
							$mdsum = $value2;
						}
					}
				}
				// Get best keyword
				if (is_array($value['akeyword'])) {
					$mdsum = 0;
					foreach ($value['akeyword'] as $key2=>$value2) {
						if ($value2 > $mdsum) {
							$domlog[$key]['keyword'] = $key2;
							$mdsum = $value2;
						}
					}
				}
				// Get best page_id
				if (is_array($value['apage_id'])) {
					$mdsum = 0;
					foreach ($value['apage_id'] as $key2=>$value2) {
						if ($value2 > $mdsum) {
							$domlog[$key]['page_id'] = $key2;
							$mdsum = $value2;
						}
					}
				}
				// Insert values to database table
				# period, value, type, url, page_id, visits, searchengine, keyword, referer
				#echo $period.','.$pvalue.',1,'.$key.','.$domlog[$key]['page_id'].','.$domlog[$key]['visits'].','.$domlog[$key]['searchengine'].','.$domlog[$key]['keyword'].','.$domlog[$key]['referer'];exit;
				$res = $this->mddb->Execute($sql,array($period,$pvalue,1,$key,$domlog[$key]['page_id'],$domlog[$key]['visits'],$domlog[$key]['searchengine'],$domlog[$key]['keyword'],$domlog[$key]['referer']));
				// Add data to mail array
				$maildomains[] = array (	'value'			=> $pvalue,
											'url'	 		=> $key,
											'page'			=> $domlog[$key]['page_id'],
											'visits'		=> $domlog[$key]['visits'],
											'searchengine'	=> $domlog[$key]['searchengine'],
											'keyword'		=> $domlog[$key]['keyword'],
											'referer'		=> $domlog[$key]['referer']
									);
			}

			// Mail monthly stats
			if ($period == 'month') {
				$email = trim($this->GetPreference('stats_email'));
				if ($email) {
					// Assign smarty vars
					$this->mdsmarty->assign('month',$this->Lang('month'));
					$this->mdsmarty->assign('domain',$this->Lang('domain'));
					$this->mdsmarty->assign('url',$this->Lang('url'));
					$this->mdsmarty->assign('page',$this->Lang('page'));
					$this->mdsmarty->assign('visits',$this->Lang('visits'));
					$this->mdsmarty->assign('searchengine',$this->Lang('searchengine'));
					$this->mdsmarty->assign('keyword',$this->Lang('keyword'));
					$this->mdsmarty->assign('referer',$this->Lang('referer'));
					$this->mdsmarty->assign('domains',$maildomains);
					// Build month and year
					$year = $pvalue==12 ? date("Y")-1 : date("Y");
					$month = sprintf("%02d / %04d", $pvalue, $year);
					// Get subject
					$subject = $this->Lang('stats_email_subject');
					$subject = str_replace ('%u',$_SERVER['HTTP_HOST'],$subject);
					$subject = str_replace ('%m',$month,$subject);
					// Get body
					$body = $this->ProcessTemplate('stats_email.tpl');
					// Get CMSMailer
					$cmsmailer = $this->GetModuleInstance('CMSMailer');
					$cmsmailer->AddAddress($email,'');
					$cmsmailer->SetSubject($subject);
					$cmsmailer->IsHTML(true);
					$cmsmailer->SetBody($body);
					$cmsmailer->Send();
				}
			}

		}

	}

	/**
	* Prepares Visit Data for Logging and returns it as array.
	* @return array
	*/
	public final function PrepareLogVisit() {

		// Set return array
		$data = array();

		// Prepare input params
		#$this->SetPreference('day','20100523');
		$mdday = $this->GetPreference('day');
		$mdmonth = $this->GetPreference('month');
		$mdyear = $this->GetPreference('year');
		$data['bot'] = '';
		$trackUserAgent = strtolower($_SERVER['HTTP_USER_AGENT']);
		if (stristr($trackUserAgent,'archiver')) $data['bot']='Alexa';
		if (stristr($trackUserAgent,'exabot')) $data['bot']='Exalead';
		if (stristr($trackUserAgent,'fast')) $data['bot']='Fast';
		if (stristr($trackUserAgent,'firefly')) $data['bot']='Fireball';
		if (stristr($trackUserAgent,'googlebot')) $data['bot']='Google';
		if (stristr($trackUserAgent,'msnbot')) $data['bot']='Bing';
		if (stristr($trackUserAgent,'scooter')) $data['bot']='AltaVista';
		if (stristr($trackUserAgent,'yahoo-mmcrawler')) $data['bot']='Yahoo';
		if (stristr($trackUserAgent,'gigabot')) $data['bot']='Gigabot';

		// Check, whether visit should be logged
		if (!$data['bot'] && !$this->mddev) $this->mdlogging = true;
		#$this->mdlogging = true;

		// Get more data and update visit if it isn't a new visitor
		if ($this->mdlogging) {
			// Check, whether this is a new visit
			$mdvisit = $this->mddb->GetOne('SELECT id FROM '.MD_LOG_TABLE.' WHERE sessionid = ? LIMIT 1', array(session_id()));
			if ($mdvisit) {
				$sql = 'UPDATE '.MD_LOG_TABLE.' SET visittime=NOW() WHERE id=?';
				$res = $this->mddb->Execute($sql,array($mdvisit));
				$this->mdlogging = false;
			// Get referer, keywords and searchengine
			} else {
				// Get Referer
				preg_match ('/^\w+\/\/([^\/]*)(.*)?$/i',$this->mdreferer,$mdkey);
				/* Abfrage wegen PHP Notice: Undefined offset: 1 - muss n�her gepr�ft werden */if (!isset($mdkey[1])) $mdkey[1] = '';
				$data['referer'] = $mdkey[1]!=$_SERVER['HTTP_HOST'] ? $this->mdreferer : '';
				#$data['referer'] = 'http://www.google.com/search?hl=de&safe=off&client=firefox-a&rls=org.mozilla%3Ade%3Aofficial&q=test+t%C3%A4st&aq=f&aqi=&aql=&oq=&gs_rfai=';
				#$data['referer'] = 'https://www.google.com?hl=de&safe=off&client=firefox-a&rls=org.mozilla%3Ade%3Aofficial&q=test+t%C3%A4st';
				$data['searchengine'] = '';
				$data['keyword'] = '';
				$mdref = $data['referer'] ? parse_url($data['referer']) : '';
				#echo '<pre>';print_r($mdref);echo '</pre>';exit;
				if (is_array($mdref)) {
					// Get Search Engine and Keyword
					$mdtemp = explode('.',$mdref['host']);
					#echo $mdtemp[count($mdtemp)-2];exit;
					if (count($mdtemp)>1) {
						switch ($mdtemp[count($mdtemp)-2]) {
							case 'google':	$data['searchengine'] = 'Google';
											preg_match ('/^.*(\?|&)q=([^&]*)(.*)?$/i',$data['referer'],$mdkey);
											$data['keyword'] = urldecode($mdkey[2]);
											$data['referer'] = '';
											break;
							case 'bing':	$data['searchengine'] = 'Bing';
											preg_match ('/^.*(\?|&)q=([^&]*)(.*)?$/i',$data['referer'],$mdkey);
											$data['keyword'] = urldecode($mdkey[2]);
											$data['referer'] = '';
											break;
							case 'yahoo':	$data['searchengine'] = 'Yahoo';
											preg_match ('/^.*p=([^&]*)(.*)?$/i',$data['referer'],$mdkey);
											$data['keyword'] = urldecode($mdkey[1]);
											$data['referer'] = '';
											break;
							default:		$data['searchengine'] = '';
											$data['keyword'] = '';
						}
					}
				}
			}
		}

		// Calculate and save statistic summary if new year
		if (date("Y") > $mdyear) {
			// Get old month
			$mdoldyear = $this->GetPreference('year');
			// Delete old row from database
			$res = $this->mddb->Execute('DELETE FROM '.MD_LOGSUM_TABLE.' WHERE period = ? AND value = ?',array('year',$mdoldyear));
			// Calculate log summary
			$mdlog = $this->mddb->GetAll('SELECT type,url,page_id,visits,searchengine,keyword,referer FROM '.MD_LOGSUM_TABLE.' WHERE period = ?', array('month'));
			if ($mdlog) $this->LogSum($mdlog,'year',$mdoldyear);
			// Delete old months from database
			$res = $this->mddb->Execute('DELETE FROM '.MD_LOGSUM_TABLE.' WHERE period = ?',array('month'));
			// Set new year
			$this->SetPreference('year',date("Y"));
		}

		// Calculate and save statistic summary if new month
		if (date("Ym") > $mdmonth) {
			// Get old month
			$mdoldmonth = substr($this->GetPreference('month'),-2);
			// Delete old row from database
			$res = $this->mddb->Execute('DELETE FROM '.MD_LOGSUM_TABLE.' WHERE period = ? AND value = ?',array('month',$mdoldmonth));
			// Calculate log summary
			$mdlog = $this->mddb->GetAll('SELECT type,url,page_id,visits,searchengine,keyword,referer FROM '.MD_LOGSUM_TABLE.' WHERE period = ?', array('day'));
			if ($mdlog) $this->LogSum($mdlog,'month',$mdoldmonth);
			// Delete old days from database
			$res = $this->mddb->Execute('DELETE FROM '.MD_LOGSUM_TABLE.' WHERE period = ?',array('day'));
			// Set new month
			$this->SetPreference('month',date("Ym"));
		}

		// Calculate and save statistic summary if new day
		if (date("Ymd") > $mdday) {
			// Get old month
			$mdoldday = substr($this->GetPreference('day'),-2);
			// Delete old row from database
			$res = $this->mddb->Execute('DELETE FROM '.MD_LOGSUM_TABLE.' WHERE period = ? AND value = ?',array('day',$mdoldday));
			// Calculate log summary
			$mdlog = $this->mddb->GetAll('SELECT domain,url,page_id,searchengine,keyword,referer,DATE(visittime) as visitdate FROM '.MD_LOG_TABLE.'',array());
			if ($mdlog) {
				foreach ($mdlog as $k=>$v) {
					$mdlog[$k]['url'] = $v['domain'];
					$mdlog[$k]['type'] = 1;
				}
				$this->LogSum($mdlog,'day',$mdoldday);
			}
			// Clear log table
			$res = $this->mddb->Execute('DELETE FROM '.MD_LOG_TABLE.'',array());
			// Set new day
			$this->SetPreference('day',date("Ymd"));
		}

		// Return data
		return $data;

	}

	/**
	* Log Visit to Database (data were prepared in PrepareLogVisit)
	* @param array $data Array with logging data.
	*/
	public final function LogVisit($data,$url='',$type='domain',$page=0) {

		// Check main input fields
		if (!is_array($data) || !trim($url)) return false;
		// Check array values
		$page = (int)$page;
		if (!isset($data['referer'])) $data['referer'] = '';
		if (!isset($data['searchengine'])) $data['searchengine'] = '';
		if (!isset($data['bot'])) $data['bot'] = '';
		if (!isset($data['keyword'])) $data['keyword'] = '';

		// Log visit for domain
		$sql = 'INSERT INTO '.MD_LOG_TABLE.' (domain, page_id, referer, searchengine, bot, keyword, sessionid, visittime) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())';
		$res = $this->mddb->Execute($sql,array($url, $page, $data['referer'], $data['searchengine'], $data['bot'], $data['keyword'], session_id()));

	}

	/**
	* Logging visits to debug issues
	* @return array
	*/
	public final function DebugMD(){
		// Get referer (fromurl) and target url (tourl)
		$fromurl = $this->mdreferer;
		$tourl = $GLOBALS['config']['root_url'].$_SERVER['REQUEST_URI'];
		// Insert a new debug
		$sql = 'INSERT INTO '.MD_DEBUG_TABLE.' (ip,session_id,fromurl,tourl,status,created_date,modified_date) VALUES (?,?,?,?,?,NOW(),NOW())';
		$res = $this->mddb->Execute($sql,array($_SERVER['REMOTE_ADDR'],session_id(),$fromurl,$tourl,'ok'));
		// Get ID from last debug entry
		if ($res) $this->mddebugid = (int)$this->mddb->GetOne('SELECT id FROM '.MD_DEBUG_TABLE.' WHERE session_id=? ORDER BY modified_date DESC LIMIT 1', array(session_id()));
		// Delete old debug messages
		$countdid = (int)$this->mddb->GetOne('SELECT count(id) as anzahl FROM '.MD_DEBUG_TABLE.'',array());
		if ($countdid>100) {
			$maxdid = (int)$this->mddb->GetOne('SELECT id FROM '.MD_DEBUG_TABLE.' ORDER BY modified_date DESC LIMIT 99,1', array());
			$res = $this->mddb->Execute('DELETE FROM '.MD_DEBUG_TABLE.' WHERE id<?',array($maxdid));
		}
	}

	/**
	* Get domains from the MultiDomain database
	* @return array
	*/
	public final function GetDomains() {
		// Get domains
		if (!$this->mdomains) { $this->mdomains = $this->mddb->GetAssoc('SELECT page_id,id,domain,devdomain,prefix,root FROM '.MD_DOMAIN_TABLE.' WHERE active=1', array()); }
		return $this->mdomains;
	}

	/**
	* Build a domain name from a given page id
	* @param integer $pageid Page ID (from content).
	* @return string
	*/
	public final function GetDomain($pageid) {
		if (!$this->mdomains) $this->GetDomains();
		foreach ($this->mdomains as $k=>$v) {
			if ($k==$pageid) {
				$d = $v['prefix'] ? $this->mdwwwrp.'.' : '';
				$d.= $this->mddev ? $v['devdomain'] : $v['domain'];
				return $d;
			}
		}
		return '';
	}

	/**
	* Build an url with a page alias or page id
	* @param integer $pageid Page ID (from content).
	* @param string $linkvalue Type of return value.
	* @return string
	*/
	public final function GetURL($pageid,$linkvalue='') {
		
		// Set variables
		$pageid = (int)$pageid;
		if (!$pageid) return false;
		$default = $pageid==$this->mdgCms->GetContentOperations()->GetDefaultContent() ? true : false;

		// Get data for page
		$page = $this->mddb->GetRow('SELECT id_hierarchy,page_url,content_alias,content_name,menu_text,titleattribute FROM '.cms_db_prefix().'content WHERE active=1 AND content_id=?', array($pageid));
		if (!$page) return false;
		$ha = explode('.',$page['id_hierarchy']);
		$title = $page['content_name'];
		$menutext = $page['menu_text'];
		$titleattribute = $page['titleattribute'];

		// Check for return value
		if ($linkvalue && $linkvalue!='url') {
			switch ($linkvalue) {
				case 'title': return $title;
				case 'menutext': return $menutext;
				case 'titleattribute': return $titleattribute;
			}
		}

		// Build domain
		$ah = array_reverse($ha);
		$d = '';
		if ($ah) {
			foreach ($ah as $v) {
				$d = $this->GetDomain($v);
				if ($d) break;
			}
		}
		if ($d) { $d = $this->mdhttp.$d; }

		// Set ending
		$ending = '';
		$ending = $GLOBALS['config']['page_extension'];
		if (!$ending) $ending = '/';

		// Check for standard url
		if ($default) return $d.'/';

		// Check for page_url
		if ($page['page_url']) return $d.'/'.$page['page_url'].$ending;

		// Build the url using page alias (and hierarchy)
		$hierarchy = '';
		if ($GLOBALS['config']['use_hierarchy']) {
			array_pop($ha);
			if ($ha) {
				foreach ($ha as $h) {
					$hierarchy.= '/'.$this->mddb->GetOne('SELECT content_alias FROM '.cms_db_prefix().'content WHERE active=1 AND type!="errorpage" AND type!="separator" AND content_id = ?', array($h));
				}
			}
		}
		$hierarchy.= '/'.$page['content_alias'];
		return $d.$hierarchy.$ending;

	}

	/**
	* Redirects a wrong Domain/URL to an specified page (selectable in the module backend).
	* @param array $log Prepared log data.
	*/
	public final function RedirectDomain($log) {

		// Set variables
		$id = (int)$this->mdgCms->variables['content_id'];
		$redirect = false;
		$domain = $vdomain = $_SERVER['HTTP_HOST'];
		if (substr($vdomain,0,4)==$this->mdwwwrp.'.') $vdomain = substr($vdomain,4);
		$url = $vurl = $_SERVER['REQUEST_URI'];
		while (substr($vurl,-1) == '/') { $vurl = substr($vurl,0,-1); }

		// Log current visit
		if ($this->mdlogging) $this->LogVisit($log,$_SERVER['HTTP_HOST'],'domain',$id);

		// Look for redirect domains
		$domains = $this->GetDomains();
		if ($domains) {

			// Get out, if alias is empty
			$empty_alias = $vurl ? false : true;
			// Change page id by different domains if the domain is a root domain
			if ($empty_alias) {
				$oldid = $id;
				// Look for matching domain
				$tdomain = $vdomain;
				foreach ($domains as $k=>$d) {
					if ($d['root']==1) {
						$tempdomain = $this->mddev ? $d['devdomain'] : $d['domain'];
						if (substr($tempdomain,0,4)==$this->mdwwwrp.'.') $tempdomain = substr($tempdomain,4);
						if ($tdomain==$tempdomain) {
							cmsms()->variables['content_id'] = $this->mdgCms->variables['content_id'] = $id = $k;
							break;
						} else {
							$textradomain = $this->mddb->GetOne('SELECT domain_id FROM '.MD_EXTRADOMAIN_TABLE.' WHERE domain = ? OR domain = ?', array($tdomain,$this->mdwwwrp.'.'.$tdomain));
							if ($textradomain) {
								foreach ($domains as $k2=>$d2) {
									if ($textradomain==$d2['id']) {
										cmsms()->variables['content_id'] = $this->mdgCms->variables['content_id'] = $id = $k2;
										break;
									}
								}
							}
						}
					}
				}
			}

			// Check, if requested page is standard page
			$default = false;
			if ($id>0) {
				$default = $id==$this->mdgCms->GetContentOperations()->GetDefaultContent() ? true : false;
				if ($default && $vurl) {
					// Build url from standard page
					$page = $this->mddb->GetRow('SELECT id_hierarchy,page_url,content_alias FROM '.cms_db_prefix().'content WHERE active=1 AND content_id=?', array($id));
					if ($page) {
						$dh = '';
						// Check for page_url
						if ($page['page_url']) { $dh = '/'.$page['page_url']; }
						// Build the url using page alias (and hierarchy)
						else {
							if ($GLOBALS['config']['use_hierarchy']) {
								$ha = explode('.',$page['id_hierarchy']);
								array_pop($ha);
								if ($ha) {
									foreach ($ha as $h) {
										$dh.= '/'.$this->mddb->GetOne('SELECT content_alias FROM '.cms_db_prefix().'content WHERE active=1 AND type!="errorpage" AND type!="separator" AND content_id = ?', array($h));
									}
								}
							}
							$dh.= '/'.$page['content_alias'];
							// Set ending
							$ending = $GLOBALS['config']['page_extension']!='/' ? $GLOBALS['config']['page_extension'] : '';
							$dh.= $ending;
						}
					}
					// Build domain
					$t2domain = $domains[$id]['prefix'] ? $this->mdwwwrp.'.' : '';
					$t2domain.= $this->mddev	? $domains[$id]['devdomain']
												: $domains[$id]['domain'];
					#echo '<strong>Page Matching:</strong>'.$domain.$vurl.'=='.$t2domain.$dh.'<hr />';exit;
					if ($domain!=$t2domain || $vurl==$dh) {
						if ($this->mddebugid) {
							$sql = 'UPDATE '.MD_DEBUG_TABLE.' SET modified_date=NOW(), status=? WHERE id=?';
							$res = $this->mddb->Execute($sql,array('301:'.$this->mdhttp.$t2domain.'/',$this->mddebugid));
						}
						$this->RedirectNow($this->mdhttp.$t2domain.'/');
					}
				}
			}

			// Look for content page parents
			$parents = array();
			if ($id>0) {
				// Add current page to parents
				$parents[] = $id;
				// Get parent pages of current page
				$parenttemp = $this->mddb->GetOne('SELECT parent_id FROM '.cms_db_prefix().'content WHERE active=1 AND parent_id>0 AND type!="errorpage" AND type!="separator" AND content_id = ?', array($id));
				while ($parenttemp > 0) {
					$parents[] = $parenttemp;
					$parenttemp = $this->mddb->GetOne('SELECT parent_id FROM '.cms_db_prefix().'content WHERE active=1 AND type!="errorpage" AND type!="separator" AND content_id = ?', array($parenttemp));
				}
			}

			// Case, if alias is empty
			if ($empty_alias && !$default) {

				// Get domain name
				$domain = substr($_SERVER['HTTP_HOST'],0,4)==$this->mdwwwrp.'.' ? substr($_SERVER['HTTP_HOST'],4) : $_SERVER['HTTP_HOST'];
				
				// Set redirect domain
				$todomain = array();

				// Find domain
				foreach ($domains as $k=>$d) {
					if ($domain==$d['domain'] || ($this->mddev && $domain==$d['devdomain'])) {
						$todomain['page_id'] = $k;
						$todomain['prefix'] = $d['prefix'];
					}
				}

				// If no matches, check for extra domain
				if (!$todomain && !$this->mddev) {
					$extradomain = $this->mddb->GetOne('SELECT domain_id FROM '.MD_EXTRADOMAIN_TABLE.' WHERE domain = ? OR domain = ?', array($domain,$this->mdwwwrp.'.'.$domain));
					if ($extradomain) {
						foreach ($domains as $k2=>$d2) {
							if ($extradomain==$d2['id']) {
								$todomain['page_id'] = $k2;
								$todomain['prefix'] = $d2['prefix'];
							}
						}
					}
				}

				if ($todomain) {
					// Get domain
					$domain = $todomain['prefix'] ? $this->mdwwwrp.'.'.$domain : $domain;
					// Get page data
					$newurl = '';
					$newurl = $this->mddb->GetOne('SELECT page_url FROM '.cms_db_prefix().'content WHERE active=1 AND type!="errorpage" AND type!="separator" AND content_id = ?', array($todomain['page_id']));
					if ($newurl && !$default) $newurl.= '/';
					if (!$newurl) {
						// Get alias
						$alias = $this->mddb->GetOne('SELECT content_alias FROM '.cms_db_prefix().'content WHERE active=1 AND type!="errorpage" AND type!="separator" AND content_id = ?', array($todomain['page_id']));
						// Get hierarchy
						$hierarchy = '';
						if ($GLOBALS['config']['use_hierarchy'] && !$default) {
							foreach ($parents as $p) {
								$hierarchy = $this->mddb->GetOne('SELECT content_alias FROM '.cms_db_prefix().'content WHERE active=1 AND type!="errorpage" AND type!="separator" AND content_id = ?', array($p)).'/'.$hierarchy;
							}
						}
						// Test hierarchy
						if ($hierarchy) {
							// Remove last / from hierarchy
							while (substr($hierarchy,-1) == '/') { $hierarchy = substr($hierarchy,0,-1); }
						}
						// Set ending
						$ending = '';
						if ($hierarchy && !$default) $ending = $GLOBALS['config']['page_extension'];
						if ($hierarchy && !$ending && !$default) $ending = '/';
						$newurl = $hierarchy.$ending;
					}
					// Redirect
					$vnewurl = $newurl;
					while (substr($vnewurl,-1) == '/') { $vnewurl = substr($vnewurl,0,-1); }
					if ($_SERVER['HTTP_HOST']!=$domain || ($vurl!=$vnewurl)) {
						#echo '<strong>Domain Matching:</strong>'.$this->mdhttp.$domain.'/'.$newurl.'<hr />';exit;
						if ($this->mddebugid) {
							$sql = 'UPDATE '.MD_DEBUG_TABLE.' SET modified_date=NOW(), status=? WHERE id=?';
							$res = $this->mddb->Execute($sql,array('301:'.$this->mdhttp.$domain.'/'.$newurl,$this->mddebugid));
						}
						$this->RedirectNow($this->mdhttp.$domain.'/'.$newurl);
					}
					if (!$vurl) {
						cmsms()->variables['page'] = $id;
						cmsms()->variables['page_id'] = $id;
					}
				}

			}

			// Domain redirect
			foreach ($parents as $p) {
				if (array_key_exists($p,$domains)) {
					// Get domain name
					$domain = $domains[$p]['prefix'] ? $this->mdwwwrp.'.' : '';
					$domain.= $this->mddev	? $domains[$p]['devdomain']
											: $domains[$p]['domain'];
					// Redirect
					if ($domain != $_SERVER['HTTP_HOST']) {
						#echo '<br /><strong>Page Matching ('.$p.'):</strong><br />'.$domain.$_SERVER['REQUEST_URI'].'<br />'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'<hr />';exit;
						if ($this->mddebugid) {
							$sql = 'UPDATE '.MD_DEBUG_TABLE.' SET modified_date=NOW(), status=? WHERE id=?';
							$res = $this->mddb->Execute($sql,array($default ? '301:'.$this->mdhttp.$domain.'/' : '301:'.$this->mdhttp.$domain.$_SERVER['REQUEST_URI'],$this->mddebugid));
						}
						$this->RedirectNow($default ? $this->mdhttp.$domain.'/' : $this->mdhttp.$domain.$_SERVER['REQUEST_URI']);
					} else { break; }
				}
			}

			// Redirect if neccesary
			#if ($redirect) echo 'Domain redirect: '.$this->mdhttp.$domain.$url;exit;
			if ($redirect) {
				if ($this->mddebugid) {
					$sql = 'UPDATE '.MD_DEBUG_TABLE.' SET modified_date=NOW(), status=? WHERE id=?';
					$res = $this->mddb->Execute($sql,array('301:'.$this->mdhttp.$domain.$url,$this->mddebugid));
				}
				$this->RedirectNow($this->mdhttp.$domain.$url);
			}

			// Log errors (404) to debug table
			$e404 = $this->mddb->GetOne('SELECT content_id FROM '.cms_db_prefix().'content WHERE type="errorpage"', array());
			// Log errors if it is one
			if ($id<0 || ($e404 && $id==$e404)) {
				// Set Debug message status to 404
				if ($this->mddebugid) {
					$sql = 'UPDATE '.MD_DEBUG_TABLE.' SET modified_date=NOW(), status=? WHERE id=?';
					$res = $this->mddb->Execute($sql,array('404',$this->mddebugid));
				}
			}

		}

	}

	/**
	* Redirects to a new URL and aborts the script.
	* @param string $url URL to redirect to ...
	*/
	public final function RedirectNow($url) {
		if (trim($url)) {
			header('HTTP/1.1 301 Moved Permanently');
			header('Location: '.trim($url));
			exit();
		}
	}


} // End of class


// EOF