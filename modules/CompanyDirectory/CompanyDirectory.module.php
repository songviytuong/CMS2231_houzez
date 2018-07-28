<?php  /* -*- Mode: PHP; tab-width: 4; c-basic-offset: 2 -*- */
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: CompanyDirectory (c) 2004-6 by Ted Kulp (ted@cmsmadesimple.org)
#   Copyright 2006 - 2014 by Robert Campbell (calguy1000@cmsmadesimple.org)
#
#  An addon module for CMS Made Simple to allow management of and various ways to display
#  company information for use in directories etc.
#
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2005-2010 by Ted Kulp (wishy@cmsmadesimple.org)
# Visit the CMSMS homepage at: http://www.cmsmadesimple.org
#
#-------------------------------------------------------------------------
#
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# However, as a special exception to the GPL, this software is distributed
# as an addon module to CMS Made Simple.  You may not use this software
# in any Non GPL version of CMS Made simple, or in any version of CMS
# Made simple that does not indicate clearly and obviously in its admin
# section that the site was built with CMS Made simple.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
# Or read it online: http://www.gnu.org/licenses/licenses.html#GPL
#
#-------------------------------------------------------------------------
#END_LICENSE

define('COMPANYDIR_PREF_NEWSUMMARY_TEMPLATE','companydir_pref_newsummary_template');
define('COMPANYDIR_PREF_DFLTSUMMARY_TEMPLATE','companydir_pref_dfltsummary_template');
define('COMPANYDIR_PREF_NEWDETAIL_TEMPLATE','companydir_pref_newdetail_template');
define('COMPANYDIR_PREF_DFLTDETAIL_TEMPLATE','companydir_pref_dfltdetail_template');
define('COMPANYDIR_PREF_NEWCATEGORYLIST_TEMPLATE','companydir_pref_newcategorylist_template');
define('COMPANYDIR_PREF_DFLTCATEGORYLIST_TEMPLATE','companydir_pref_dfltcategorylist_template');
define('COMPANYDIR_PREF_NEWHIERLIST_TEMPLATE','companydir_pref_newhierlist_template');
define('COMPANYDIR_PREF_DFLTHIERLIST_TEMPLATE','companydir_pref_dflthierlist_template');
define('COMPANYDIR_PREF_NEWSEARCHFORM_TEMPLATE','companydir_pref_newsearchform_template');
define('COMPANYDIR_PREF_DFLTSEARCHFORM_TEMPLATE','companydir_pref_dfltsearchform_template');
define('COMPANYDIR_PREF_NEWFRONTENDFORM_TEMPLATE','companydir_pref_newfrontendform_template');
define('COMPANYDIR_PREF_DFLTFRONTENDFORM_TEMPLATE','companydir_pref_dfltfrontendform_template');
define('COMPANYDIR_PREF_NEWFRONTENDALBUM_TEMPLATE','companydir_pref_newfrontendalbum_template');
define('COMPANYDIR_PREF_DFLTFRONTENDALBUM_TEMPLATE','companydir_pref_dfltfrontendalbum_template');
define('COMPANYDIR_PREF_NEWFRONTENDLIST_TEMPLATE','companydir_pref_newfrontendlist_template');
define('COMPANYDIR_PREF_DFLTFRONTENDLIST_TEMPLATE','companydir_pref_dfltfrontendlist_template');
define('COMPANYDIR_PREF_NEWABCLIST_TEMPLATE','companydir_pref_newabclist_template');
define('COMPANYDIR_PREF_DFLTABCLIST_TEMPLATE','companydir_pref_dfltabclist_template');
define('COMPANYDIR_PREF_NEWSTATSSUMMARY_TEMPLATE','companydir_pref_newstatssummary_template');
define('COMPANYDIR_PREF_DFLTSTATSSUMMARY_TEMPLATE','companydir_pref_dfltstatssummary_template');
define('COMPANYDIR_FRONTENDIMPORT_TEMPLATE','companydir_frontendimport_template');

class CompanyDirectoryException extends Exception {}

final class CompanyDirectory extends CGExtensions
{
  var $_company_name_cache;
  private $_category_preload;

  function __construct()
  {
    parent::__construct();
	$this->_company_name_cache = array();
	$this->AddImageDir('icons');

	$smarty = cmsms()->GetSmarty();
    if( !$smarty ) return;
	$smarty->register_function('compdir_initjs',array('cd_utils','smarty_initjs'));
	$smarty->register_function('cd_selcategory',array('cd_utils','smarty_selcategory'));
	$smarty->register_function('cd_selhierarchy',array('cd_utils','smarty_selhierarchy'));
	$smarty->register_function('cd_getcompany',array('cd_utils','smarty_getcompany'));
	$smarty->register_function('cd_searchstats',array('cd_utils','smarty_cdsearchstats'));
    $smarty->register_function('cd_getcategory',array('cd_utils','smarty_getcategory'));
  }

  function GetName() { return 'CompanyDirectory'; }
  function GetFriendlyName() { return $this->Lang('companydirectory'); }
  function IsPluginModule() { return TRUE; }
  function LazyLoadAdmin() { return TRUE; }
  function HasAdmin() {	return TRUE; }
  function GetVersion() { return '1.23.5'; }
  function MinimumCMSVersion() { return '1.12.1'; }
  function GetAdminDescription() { return $this->Lang('moddescription'); }
  function InstallPostMessage() { return $this->Lang('postinstall'); }
  function UninstallPostMessage() { return $this->Lang('postuninstall'); }
  function UninstallPreMessage() { return $this->Lang('preuninstall'); }
  function GetAdminSection() { return 'content'; }
  function AllowAutoInstall() { return FALSE; }
  function AllowAutoUpgrade() { return FALSE; }
  function GetAuthor() { return 'Robert Campbell, Ted Kulp'; }
  function GetAuthorEmail()	{ return 'calguy1000@gmail.com, ted@ten39.com'; }
  function GetEventDescription( $eventname ) { return $this->lang('eventdesc-' . $eventname); }
  function GetEventHelp( $eventname ) {	return $this->lang('eventhelp-' . $eventname);  }

  function GetDependencies()
  {
	return array('CGExtensions'=>'1.53.10','CGSimpleSmarty'=>'1.9','JQueryTools'=>'1.3.9','CGSmartImage'=>'1.21');
  }

  function VisibleToAdminUser()
  {
	return $this->CheckPermission('Modify Company Directory') ||
	  $this->CheckPermission('Modify Templates') ||
	  $this->CheckPermission('Modify Site Preferences');
  }

  function InitializeFrontend()
  {
	$this->RegisterModulePlugin();
	$this->RestrictUnknownParams();

	$detailpage = $this->GetPreference('detailpage',-1);
	if( $detailpage == -1 ) {
	  $contentops = cmsms()->GetContentOperations();
	  $detailpage = $contentops->GetDefaultContent();
	}
	$db = cmsms()->GetDb();
	$parms = array('published','');
	$query = 'SELECT id,url FROM '.cms_db_prefix().'module_compdir_companies WHERE status = ? AND url != ?';

	// todo: don't add routes for records owned by expired FEU's... but we'll let summary and detail views handle this atm.
	$dbr = $db->Execute($query,$parms);
	if( $dbr ) {
	  while( !$dbr->EOF() ) {
		$one = $dbr->fields;
		$parms = array('action'=>'details','returnid'=>$detailpage,'companyid'=>$one['id']);
		$route = new CmsRoute($one['url'],$this->GetName(),$parms,TRUE);
		$res = cms_route_manager::register($route,FALSE);
		$dbr->MoveNext();
	  }
	  $dbr->Close();
	}

	$this->SetParameterType('companyid',CLEAN_INT);
	$this->SetParameterType('detailpage',CLEAN_STRING);
	$this->SetParameterType('summarypage',CLEAN_STRING);
	$this->SetParameterType('categorylisttemplate',CLEAN_STRING);
	$this->SetParameterType('hierlisttemplate',CLEAN_STRING);
	$this->SetParameterType('searchformtemplate',CLEAN_STRING);
	$this->SetParameterType('detailtemplate',CLEAN_STRING);
	$this->SetParameterType('frontendformtemplate',CLEAN_STRING);
	$this->SetParameterType('frontendalbumtemplate',CLEAN_STRING);
	$this->SetParameterType('frontendlisttemplate',CLEAN_STRING);
	$this->SetParameterType('abclisttemplate',CLEAN_STRING);
	$this->SetParameterType('summarytemplate',CLEAN_STRING);
	$this->SetParameterType('searchstatstemplate',CLEAN_STRING);
	$this->SetParameterType('showall',CLEAN_INT);
	$this->SetParameterType('sortby',CLEAN_STRING);
	$this->SetParameterType('sortorder',CLEAN_STRING);
	$this->SetParameterType('searchaddress',CLEAN_INT);
	$this->SetParameterType('postalchars',CLEAN_INT);
	$this->SetParameterType('hier',CLEAN_STRING);
	$this->SetParameterType('phrase',CLEAN_STRING);
	$this->SetParameterType('name',CLEAN_STRING);
	$this->SetParameterType('idlist',CLEAN_STRING);
	$this->SetParameterType('category',CLEAN_STRING);
	$this->SetParameterType('category2',CLEAN_STRING);
	$this->SetParameterType('category3',CLEAN_STRING);
	$this->SetParameterType('inline',CLEAN_INT);
	$this->SetParameterType('pagelimit',CLEAN_INT);
	$this->SetParameterType('categoryid',CLEAN_INT);
	$this->SetParameterType('activityid',CLEAN_INT);
	$this->SetParameterType('activitychildren',CLEAN_INT);
	$this->SetParameterType(CLEAN_REGEXP.'/cdx_.*/',CLEAN_NONE);
	$this->SetParameterType(CLEAN_REGEXP.'/cd_.*/',CLEAN_STRING);
	$this->SetParameterType('page',CLEAN_INT);
	$this->SetParameterType('resultpage',CLEAN_STRING);
	$this->SetParameterType('junk',CLEAN_STRING);
	$this->SetParameterType('origaction',CLEAN_STRING);
	$this->SetParameterType('lat',CLEAN_STRING); // float
	$this->SetParameterType('long',CLEAN_STRING); // float
	$this->SetParameterType('radius',CLEAN_STRING); // float
	$this->SetParameterType('nopretty',CLEAN_INT);
	$this->SetParameterType('nochildren',CLEAN_INT);
	$this->SetParameterType('mastersearch',CLEAN_INT);
	$this->SetParameterType('subsearch',CLEAN_INT);
	$this->SetParameterType('days',CLEAN_INT);
	$this->SetParameterType('phrase',CLEAN_STRING);

	// Friendly URL stuff
	// todo, add defaults here
	if( $this->GetPreference('url_redirectold',0) ) {
	  $this->RegisterRoute('/[cC]ompanies\/(?P<companyid>[0-9]+)\/(?P<returnid>[0-9]+)\/d,(?P<detailtemplate>.*?)$/',
						   array('action'=>'handle_oldroute','origaction'=>'details'));
	  $this->RegisterRoute('/[cC]ompanies\/(?P<companyid>[0-9]+)\/(?P<returnid>[0-9]+)\/(?P<junk>.*?)$/',
						   array('action'=>'handle_oldroute','origaction'=>'details'));
	  $this->RegisterRoute('/[cC]ompanies\/(?P<companyid>[0-9]+)\/(?P<returnid>[0-9]+)$/',
						   array('action'=>'handle_oldroute','origaction'=>'details'));
	  $this->RegisterRoute('/[cC]ompanies\/(?P<companyid>[0-9]+)$/',
						   array('action'=>'handle_oldroute','origaction'=>'details','returnid'=>$detailpage));
	}
	else {
	  $this->RegisterRoute('/[cC]ompanies\/(?P<companyid>[0-9]+)\/(?P<returnid>[0-9]+)\/d,(?P<detailtemplate>.*?)$/'); // deprecated.
	  $this->RegisterRoute('/[cC]ompanies\/(?P<companyid>[0-9]+)\/(?P<returnid>[0-9]+)\/(?P<junk>.*?)$/');
	  $this->RegisterRoute('/[cC]ompanies\/(?P<companyid>[0-9]+)\/(?P<returnid>[0-9]+)$/');
	  $this->RegisterRoute('/[cC]ompanies\/(?P<companyid>[0-9]+)$/');
	}
	// summary views.
	$this->RegisterRoute('/[cC]ompanies\/byhierarchy\/(?P<hier>[0-9]+)\/(?P<returnid>[0-9]+)\/(?P<junk>.*?)$/',
                         array('action'=>'default'));
	$this->RegisterRoute('/[cC]ompanies\/bycategory\/(?P<categoryid>[0-9]+)$/');
	$this->RegisterRoute('/[cC]ompanies\/bycategory\/(?P<categoryid>[0-9]+)\/(?P<returnid>[0-9]+)\/(?P<junk>.*?)$/');
	$this->RegisterRoute('/[cC]ompanies\/bycategory\/(?P<categoryid>[0-9]+)\/(?P<returnid>[0-9]+)$/');

	$smarty = cmsms()->GetSmarty();
	$smarty->register_function('cd_hierbreadcrumb',array('cd_utils','smarty_hierbreadcrumb'));
  }

  function InitializeAdmin()
  {
	$this->CreateParameter('action','default',$this->Lang('param_action'));
	$this->CreateParameter('companyid','',$this->Lang('param_companyid'));
    $this->CreateParameter('summarypage','',$this->Lang('param_summarypage'));
	$this->CreateParameter('detailpage','',$this->Lang('param_detailpage'));
	$this->CreateParameter('categorylisttemplate','',$this->Lang('param_categorylisttemplate'));
	$this->CreateParameter('hierlisttemplate','',$this->Lang('param_hierlisttemplate'));
	$this->CreateParameter('abclisttemplate','',$this->Lang('param_abclisttemplate'));
	$this->CreateParameter('searchformtemplate','',$this->Lang('param_searchformtemplate'));
	$this->CreateParameter('detailtemplate','',$this->Lang('param_detailtemplate'));
	$this->CreateParameter('frontendformtemplate','',$this->Lang('param_frontendformtemplate'));
	$this->CreateParameter('frontendalbumtemplate','',$this->Lang('param_frontendalbumtemplate'));
	$this->CreateParameter('frontendlisttemplate','',$this->Lang('param_frontendlisttemplate'));
	$this->CreateParameter('summarytemplate','',$this->Lang('param_summarytemplate'));
	$this->CreateParameter('searchstatstemplate','',$this->Lang('param_searchstatstemplate'));
	$this->CreateParameter('showall','',$this->Lang('param_showall'));
	$this->CreateParameter('sortby','company_name',$this->Lang('param_sortby'));
	$this->CreateParameter('sortorder','asc',$this->Lang('param_sortorder'));
	$this->CreateParameter('searchaddress','0',$this->Lang('param_searchaddress'));
	$this->CreateParameter('postalchars','0',$this->Lang('param_postalchars'));
	$this->CreateParameter('hier','',$this->Lang('param_hier'));
	$this->CreateParameter('idlist','',$this->Lang('param_idlist'));
	$this->CreateParameter('name','',$this->Lang('param_name'));
	$this->CreateParameter('lat','',$this->Lang('param_lat'));
	$this->CreateParameter('long','',$this->Lang('param_long'));
	$this->CreateParameter('radius','',$this->Lang('param_radius'));
	$this->CreateParameter('categoryid','',$this->Lang('param_categoryid'));
	$this->CreateParameter('activityid','',$this->Lang('param_activityid'));
	$this->CreateParameter('activitychildren','',$this->Lang('param_activitychildren'));
	$this->CreateParameter('category','',$this->Lang('param_category'));
	$this->CreateParameter('category2','',$this->Lang('param_category2'));
	$this->CreateParameter('category3','',$this->Lang('param_category3'));
	$this->CreateParameter('inline',0,$this->Lang('param_inline'));
	$this->CreateParameter('pagelimit','',$this->Lang('param_pagelimit'));
	$this->CreateParameter('resultpage','',$this->Lang('param_resultpage'));
	$this->CreateParameter('nopretty','',$this->Lang('param_nopretty'));
	$this->CreateParameter('nochildren','',$this->Lang('param_nochildren'));
	$this->CreateParameter('mastersearch','',$this->Lang('param_mastersearch'));
	$this->CreateParameter('subsearch','',$this->Lang('param_subsearch'));
	$this->CreateParameter('days',365,$this->Lang('param_days'));
	$this->CreateParameter('phrase','',$this->Lang('param_phrase'));
    $this->CreateParameter('cd_destpage','',$this->Lang('param_cd_destpage'));
  }

  function GetChangeLog()
  {
	$fn = __DIR__.'/changelog.inc';
	if( file_exists($fn) ) {
	  $t = file_get_contents($fn);
	  return $t;
	}
  }

  function GetHeaderHTML()
  {
	$obj = cms_utils::get_module('JQueryTools','1.2');
    $smarty = cmsms()->GetSmarty();
	$txt = '<link rel="stylesheet" href="'.$this->GetModuleURLPath().'/css/admin.css"/>';
    if( is_object($obj) ){
      $tmpl  = "{JQueryTools action='require' lib='tablesorter,jquerytools,fancybox,fileupload'}";
      $tmpl .= "{JQueryTools action='placemarker' no_ready=1}";
    }
    $txt .= $this->ProcessTemplateFromData($tmpl);
    return $txt;
  }

  function GetFieldTypes()
  {
	$arr = array('textbox'  => $this->Lang('field_textbox'), 'checkbox' => $this->Lang('field_checkbox'), 'textarea' => $this->Lang('field_textarea'),
				 'dropdown' => $this->Lang('field_dropdown'),'multiselect' => $this->Lang('field_multiselect'), 'image' => $this->Lang('field_image'),
				 'file' => $this->Lang('field_file'));
	$arr['album'] = $this->Lang('field_album');
	$cgsoc = $this->GetModuleInstance('CGSocialApp');
	if( is_object($cgsoc) ) $arr['activity'] = $this->Lang('field_activity');
	if( cd_utils::can_geolocate() )	$arr['icon'] = $this->Lang('field_icon');
	return $arr;
  }

  function GetCategories($asHash = FALSE,$byName = FALSE)
  {
	return cd_utils::get_categories($asHash,$byName);
  }

  function preloadCategoryData($ids)
  {
	if( !is_array($ids) && is_numeric($ids) ) $ids = array($ids);

	$db = cmsms()->GetDb();
	$config = cmsms()->GetConfig();
	$tmp = array();
	for( $i = 0; $i < count($ids); $i++ ) {
	  $n = (int)$ids[$i];
	  if( $n < 0 ) continue;
	  if( is_array($this->_category_preload) && isset($this->_category_preload[$n]) ) continue;
	  $tmp[] = $n;
	}
	if( !is_array($tmp) || !count($tmp) ) return;
	sort($tmp); // debug... but nice.
	$idlist = array_unique($tmp);

	// initialize the stuff we don't have to empty.
	if( !is_array($this->_category_preload) ) $this->_category_preload = array();
	$categories = $this->GetCategories(TRUE);
	foreach( $idlist as $compid ) {
	  if( isset($this->_category_preload[$compid]) ) continue;

	  $this->_category_preload[$compid] = array();
	  foreach( $categories as $onecat ) {
		$this->_category_preload[$compid][$onecat->id] = clone $onecat;
	  }
	}

	$query = 'SELECT * FROM '.cms_db_prefix().'module_compdir_company_categories C where C.company_id IN ('.implode(',',$idlist).') ORDER BY C.company_id';
	$dbr = $db->Execute($query);
	if( !$dbr ) return;

	while( !$dbr->EOF ) {
	  $compid = $dbr->fields['company_id'];
	  $catid = $dbr->fields['category_id'];
	  if( !isset($categories[$catid]) ) {
		$dbr->MoveNext();
		continue;
	  }

	  $obj =& $this->_category_preload[$compid][$catid];
	  $obj->value = true;
	  $obj->extra1 = $dbr->fields['extra1'];
	  $obj->extra2 = $dbr->fields['extra2'];
	  $obj->extra3 = $dbr->fields['extra3'];
	  if( $obj->image ) {
		$path = cms_join_path($config['uploads_path'],'companydirectory','cat'.$catid);
		if( file_exists(cms_join_path($path,$obj->image)) ) {
		  $obj->image_url = $config['uploads_url']."/companydirectory/cat{$catid}/".$obj->image;
		}
		if( file_exists(cms_join_path($path,'thumb_'.$obj->image)) ) {
		  $obj->thumb_url = $config['uploads_url']."/companydirectory/cat{$catid}/thumb_".$obj->image;
		}
	  }
	  $dbr->MoveNext();
	}
  }

  function GetCategoriesForCompany($id)
  {
	$this->preloadCategoryData($id);
	if( is_array($this->_category_preload) && isset($this->_category_preload[$id]) ) return $this->_category_preload[$id];

	die('Internal Error: GetCategoriesForCompany was not preloaded');
  }

  function GetFieldDefsForCompany($id,$admin = false,$public = true)
  {
	return cd_utils::get_fielddefs_for_company($id,$admin,$public);
  }

  function SearchResultWithParams($returnid, $companyid, $attr = '', $params = array())
  {
	$gCms = cmsms();
	$result = array();

	if ($attr != 'company') return $result;

	$db = $this->GetDb();
	$q = "SELECT company_name FROM ".cms_db_prefix()."module_compdir_companies WHERE id = ? AND status = ?";
	$dbresult = $db->Execute( $q, array( $companyid, 'published' ) );
	if ($dbresult) {
	  $row = $dbresult->FetchRow();

	  $detailpage = $this->GetPreference('detailpage',-1);
	  if( $detailpage > 1 ) $returnid = $detailpage;
	  if( isset($params['detailpage']) ) {
		$tmp = $this->resolve_alias_or_id(trim($params['detailpage']));
		if( $tmp > 0 ) $returnid = $tmp;
	  }

	  //0 position is the prefix displayed in the list results.
	  $result[0] = $this->GetFriendlyName();

	  //1 position is the title
	  $result[1] = $row['company_name'];

	  //2 position is the URL to the title.
	  $url = "companies/$companyid/$returnid/".munge_string_to_url($row['company_name']);

	  if( isset($params['detailtemplate']) ) $url .= '/d,'.trim($params['detailtemplate']);

	  $result[2] = $this->CreateURL('cntnt01','details',$returnid,array('companyid'=>$companyid),false,
									$url);
	}

	return $result;
  }

  function SearchReindex(&$module)
  {
	$page = 1;
	$done = FALSE;
	while( !$done ) {
	  $parms = array('status'=>'published','pagelimit'=>250,'page'=>$page);
	  $filter = new cd_company_filter($parms);
	  cd_company_query::set_result_mode(cd_company_query::RESULTS_CD_COMPANY);
	  $query = new cd_company_query($filter);
	  $items = $query->get_results();
	  if( is_array($items) && count($items) ) {
		foreach( $items as $item ) {
		  $module->AddWords($this->GetName(),$item->id,'company',$item->get_search_words());
		}
	  }
	  $pagination = $query->get_pagination();
	  $npages = $pagination->get_page_count();
	  if( $page == $npages ) {
		$done = TRUE;
		break;
	  }
	  $page++;
	}
  }

  function CreateCompanyPulldown($id,$name,$selected = '')
  {
	$db = $this->GetDb();
	$query = 'SELECT id,company_name FROM '.cms_db_prefix().'module_compdir_companies WHERE status = \'published\'';

	$dbr = $db->Execute( $query );
	$companies = array();
	while( $dbr && ($row = $dbr->FetchRow()) ) {
	  $companies[$row['company_name']] = $row['id'];
	}

	$addtext = '';
	if(count($companies) == 0 ) $addtext='disabled';
	$fld = $this->CreateInputDropdown( $id, $name, $companies, -1, $selected, $addtext );
	return $fld;
  }

  function GetCompanyNameFromId( $id )
  {
	if( !isset( $this->_company_name_cache[$id] ) ) {
	  $db = $this->GetDb();
	  $query = "SELECT company_name FROM ".cms_db_prefix()."module_compdir_companies WHERE id = ?";
	  $name = $db->GetOne( $query, array( $id ) );
	  if(!$name) return FALSE;
	  $this->_company_name_cache[$id] = $name;
	}

	return $this->_company_name_cache[$id];
  }

  // radius in miles.
  function GetBoundingBox($latitude,$longitude,$radius)
  {
	$lng_min = $longitude - $radius / abs(cos(deg2rad($latitude)) * 69);
	$lng_max = $longitude + $radius / abs(cos(deg2rad($latitude)) * 69);
	$lat_min = $latitude - ($radius / 69);
	$lat_max = $latitude + ($radius / 69);

	$tmp = array($lat_min,$lat_max,$lng_min,$lng_max);
	return $tmp;
  }

  function UpdateHierarchyPositions()
  {
	$db = $this->GetDb();
	$query = "SELECT id, name FROM ".cms_db_prefix()."module_compdir_hier";
	$dbresult = $db->Execute($query);
	while ($dbresult && $row = $dbresult->FetchRow()) {
	  $current_hierarchy_position = "";
	  $current_long_name = "";
	  $content_id = $row['id'];
	  $current_parent_id = $row['id'];
	  $count = 0;

	  while ($current_parent_id > -1) {
		$query = "SELECT id, name, parent_id FROM ".cms_db_prefix()."module_compdir_hier WHERE id = ?";
		$row2 = $db->GetRow($query, array($current_parent_id));
		if ($row2) {
		  $current_hierarchy_position = str_pad($row2['id'], 5, '0', STR_PAD_LEFT) . "." . $current_hierarchy_position;
		  $current_long_name = $row2['name'] . ' | ' . $current_long_name;
		  $current_parent_id = $row2['parent_id'];
		  $count++;
		}
		else {
		  $current_parent_id = 0;
		}
	  }

	  if (strlen($current_hierarchy_position) > 0) {
		$current_hierarchy_position = substr($current_hierarchy_position, 0, strlen($current_hierarchy_position) - 1);
	  }

	  if (strlen($current_long_name) > 0) $current_long_name = substr($current_long_name, 0, strlen($current_long_name) - 3);
	  $query = "UPDATE ".cms_db_prefix()."module_compdir_hier SET hierarchy = ?, long_name = ? WHERE id = ?";
	  $db->Execute($query, array($current_hierarchy_position, $current_long_name, $content_id));
	}
  }

  function CreateParentDropdown($id, $catid = -1, $selectedvalue = -1, $name = 'parent')
  {
	$items = cd_utils::get_hierarchy_list($catid);
	return $this->CreateInputDropdown($id, $name, $items, -1, $selectedvalue);
  }

  public function get_pretty_url($id,$action,$returnid='',$params=array(),$inline=false)
  {
	global $CMS_ADMIN_PAGE;
	if( isset($params['nopretty']) ) return '';
	if( isset($params['junk']) ) unset($params['junk']);

	$url = '';
	switch( $action ) {
	case 'detail': // synonym
	case 'details':
	  $the_company = null;
	  if( isset($params['compid']) ) $the_company = (int)$params['compid'];
	  if( isset($params['companyid']) ) $the_company = (int)$params['companyid'];
	  if( !$the_company ) return;

	  // get raw database data out of cache, if we cannot find this data in the cache, we cannot build a pretty url.
	  if( !cge_tmpdata::exists('companydir_'.$the_company) ) return;
	  $rec = cge_tmpdata::get('companydir_'.$the_company);
	  if( is_array($rec) && isset($rec['id']) ) $rec = cge_array::to_object($rec);
	  if( !is_object($rec) || !isset($rec->id) || $rec->id != $the_company ) return;

	  if( isset($rec->url) && $rec->url != '' ) {
		// woot, we have a url.
		$url = $rec->url;
	  }
	  else {
		// old uglier urls
		$url = "companies/{$rec->id}/$returnid/".munge_string_to_url($rec->company_name);
		if( isset($params['detailtemplate']) ) $url .= '/d,'.$params['detailtemplate'];
	  }
	  break;

	case 'default':
      if( !isset($params['radius']) ) {
        if( isset($params['categoryid']) && !isset($params['hier']) ) {
          $url = "companies/bycategory/".(int)$params['categoryid']."/{$returnid}";
          $cats = cd_utils::get_categories(TRUE);
          if( isset($cats[(int)$params['categoryid']]) ) {
            $str = $cats[(int)$params['categoryid']]->long_name;
            $str = str_replace(' | ','-',$str);
            $url .= '/'.munge_string_to_url($str);
          }
        }
        else if( isset($params['hier']) && !isset($params['categoryid']) ) {
          $url = "companies/byhierarchy/".(int)$params['hier']."/{$returnid}";
          $hierlist = cd_utils::get_hierarchy();
          foreach( $hierlist as $row ) {
            if( $row['id'] == (int)$params['hier'] ) {
              $path = str_replace(' | ','-',$row['long_name']);
              $url .= '/'.munge_string_to_url($path);
              break;
            }
          }
        }
	  }
	  break;
	}

	return $url;
  }
} // end of class

# vim:ts=4 sw=4 noet
?>
