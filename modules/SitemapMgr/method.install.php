<?php
#-------------------------------------------------------------------------
# Module: SitemapMgr
# Author: Rolf Tjassens
#-------------------------------------------------------------------------
# CMS Made Simple is (c) 2004 - 2011 by Ted Kulp (wishy@cmsmadesimple.org)
# CMS Made Simple is (c) 2011 - 2017 by The CMSMS Dev Team
# This project's homepage is: http://www.cmsmadesimple.org
# The module's homepage is: http://dev.cmsmadesimple.org/projects/sitemapmgr
#-------------------------------------------------------------------------
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
# Or read it online: http://www.gnu.org/licenses/licenses.html#GPL
#-------------------------------------------------------------------------

if ( !cmsms() ) exit;

if ( !$this->CheckPermission('Modify Modules') ) {
  echo $this->ShowErrors($this->Lang('accessdenied'));
  return;
}

// Create database tables
$db = cmsms()->GetDb();

$dict = NewDataDictionary( $db );
$taboptarray = array( 'mysqli' => 'TYPE=MyISAM' );

$flds = "sitemap_id		I KEY AUTOINCREMENT,
		sitemap_type	C(100),
        sitemap_name	C(100),
		sitemap_tag		C(255)";

$sqlarray = $dict->CreateTableSQL( CMS_DB_PREFIX . 'module_sitemapmgr', $flds, $taboptarray );
$dict->ExecuteSQLArray($sqlarray);

$query = "INSERT INTO " . CMS_DB_PREFIX . "module_sitemapmgr 
          (`sitemap_type`, `sitemap_name`, `sitemap_tag`)
          VALUES (?,?,?)";

$sitemap_type = 'sitemap_pages';
$sitemap_name = 'Pages';
$sitemap_tag = "{Navigator template='cms_template:Sitemap Pages'}";

$dbresult = $db->Execute( $query, array( $sitemap_type, $sitemap_name, $sitemap_tag ) );

// Set preferences
if ( file_exists( cms_join_path( $config['root_path'], 'humans.txt') ) ) {
	$default_humanstxt_content = file_get_contents( cms_join_path($config['root_path'], 'humans.txt') );
} else {
	$default_humanstxt_content = file_get_contents( cms_join_path(dirname(__FILE__), 'templates', 'default_humanstxt.tpl') );
}
$this->SetPreference('humanstxt_content', $default_humanstxt_content);

if ( file_exists( cms_join_path( $config['root_path'], 'robots.txt') ) ) {
	$default_robotstxt_content = file_get_contents( cms_join_path($config['root_path'], 'robots.txt') );
} else {
	$default_robotstxt_content = file_get_contents( cms_join_path(dirname(__FILE__), 'templates', 'default_robotstxt.tpl') );
	$default_robotstxt_content = str_replace( 'root_url',$config['root_url'],$default_robotstxt_content );
	
	// create robots.txt file
	cmsms()->set_content_type('text/plain');
	file_put_contents( cms_join_path( $config['root_path'],'robots.txt' ), $default_robotstxt_content );
}
$this->SetPreference('robotstxt_content', $default_robotstxt_content);

// Create directory for sitemaps and a dummy index.html file
if ( !is_dir( cms_join_path( $config['root_path'], 'assets' ) ) )
	@mkdir( cms_join_path( $config['root_path'], 'assets' ) );
	
$assets_path = cms_join_path( $config['root_path'] , 'assets' );
if ( !is_dir( cms_join_path( $assets_path, 'sitemaps' ) ) )
	@mkdir( cms_join_path( $assets_path, 'sitemaps' ) );

file_put_contents( ( cms_join_path( $assets_path, 'sitemaps', 'index.html' ) ), '' );

// +++ Create Template Types and Templates in the Design Manager +++
$uid = get_userid();

// Sitemap Custom - type
try {
	$sitemap_custom_template_type = new CmsLayoutTemplateType();
	$sitemap_custom_template_type->set_originator($this->GetName());
	$sitemap_custom_template_type->set_name('sitemap_custom');
	$sitemap_custom_template_type->set_dflt_flag(TRUE);
	$sitemap_custom_template_type->set_lang_callback('SitemapMgr::page_type_lang_callback');
	$sitemap_custom_template_type->set_content_callback('SitemapMgr::reset_page_type_defaults');
	$sitemap_custom_template_type->reset_content_to_factory();
	$sitemap_custom_template_type->save();
}

catch( CmsException $e ) {
	debug_to_log(__FILE__.':'.__LINE__.' '.$e->GetMessage());
	audit('',$this->GetName(),'Installation Error: '.$e->GetMessage());
}

// Sitemap Pages - type and template
try {
	$sitemap_pages_template_type = new CmsLayoutTemplateType();
	$sitemap_pages_template_type->set_originator($this->GetName());
	$sitemap_pages_template_type->set_name('sitemap_pages');
	$sitemap_pages_template_type->set_dflt_flag(TRUE);
	$sitemap_pages_template_type->set_lang_callback('SitemapMgr::page_type_lang_callback');
	$sitemap_pages_template_type->set_content_callback('SitemapMgr::reset_page_type_defaults');
	$sitemap_pages_template_type->reset_content_to_factory();
	$sitemap_pages_template_type->save();
}

catch( CmsException $e ) {
	debug_to_log(__FILE__.':'.__LINE__.' '.$e->GetMessage());
	audit('',$this->GetName(),'Installation Error: '.$e->GetMessage());
}

try {
	$fn = cms_join_path(dirname(__FILE__), 'templates', 'default_sitemap_pages.tpl');
	
	if ( file_exists( $fn ) )
	{
		$template = @file_get_contents($fn);
		$tpl = new CmsLayoutTemplate();
		$tpl->set_name('Sitemap Pages');
		$tpl->set_owner($uid);
		$tpl->set_content($template);
		$tpl->set_type($sitemap_pages_template_type);
		$tpl->set_type_dflt(TRUE);
		$tpl->save();
	}
}

catch( CmsException $e ) {
	debug_to_log(__FILE__.':'.__LINE__.' '.$e->GetMessage());
	audit('',$this->GetName(),'Installation Error: '.$e->GetMessage());
}

// Sitemap News - type and template
try {
	$sitemap_news_template_type = new CmsLayoutTemplateType();
	$sitemap_news_template_type->set_originator($this->GetName());
	$sitemap_news_template_type->set_name('sitemap_news');
	$sitemap_news_template_type->set_dflt_flag(TRUE);
	$sitemap_news_template_type->set_lang_callback('SitemapMgr::page_type_lang_callback');
	$sitemap_news_template_type->set_content_callback('SitemapMgr::reset_page_type_defaults');
	$sitemap_news_template_type->reset_content_to_factory();
	$sitemap_news_template_type->save();
}

catch( CmsException $e ) {
	debug_to_log(__FILE__.':'.__LINE__.' '.$e->GetMessage());
	audit('',$this->GetName(),'Installation Error: '.$e->GetMessage());
}

try {
	$fn = cms_join_path(dirname(__FILE__), 'templates', 'default_sitemap_news.tpl');
	
	if ( file_exists( $fn ) )
	{
		$template = @file_get_contents($fn);
		$tpl = new CmsLayoutTemplate();
		$tpl->set_name('Sitemap News');
		$tpl->set_owner($uid);
		$tpl->set_content($template);
		$tpl->set_type($sitemap_news_template_type);
		$tpl->set_type_dflt(TRUE);
		$tpl->save();
	}
}

catch( CmsException $e ) {
	debug_to_log(__FILE__.':'.__LINE__.' '.$e->GetMessage());
	audit('',$this->GetName(),'Installation Error: '.$e->GetMessage());
}

// Sitemap CGBlog - type and template
try {
	$sitemap_cgblog_template_type = new CmsLayoutTemplateType();
	$sitemap_cgblog_template_type->set_originator($this->GetName());
	$sitemap_cgblog_template_type->set_name('sitemap_cgblog');
	$sitemap_cgblog_template_type->set_dflt_flag(TRUE);
	$sitemap_cgblog_template_type->set_lang_callback('SitemapMgr::page_type_lang_callback');
	$sitemap_cgblog_template_type->set_content_callback('SitemapMgr::reset_page_type_defaults');
	$sitemap_cgblog_template_type->reset_content_to_factory();
	$sitemap_cgblog_template_type->save();
}

catch( CmsException $e ) {
	debug_to_log(__FILE__.':'.__LINE__.' '.$e->GetMessage());
	audit('',$this->GetName(),'Installation Error: '.$e->GetMessage());
}

try {
	$fn = cms_join_path(dirname(__FILE__), 'templates', 'default_sitemap_cgblog.tpl');
	
	if ( file_exists( $fn ) )
	{
		$template = @file_get_contents($fn);
		$tpl = new CmsLayoutTemplate();
		$tpl->set_name('Sitemap CGBlog');
		$tpl->set_owner($uid);
		$tpl->set_content($template);
		$tpl->set_type($sitemap_cgblog_template_type);
		$tpl->set_type_dflt(TRUE);
		$tpl->save();
	}
}

catch( CmsException $e ) {
	debug_to_log(__FILE__.':'.__LINE__.' '.$e->GetMessage());
	audit('',$this->GetName(),'Installation Error: '.$e->GetMessage());
}

// Sitemap CGCalendar - type and template
try {
	$sitemap_cgcalendar_template_type = new CmsLayoutTemplateType();
	$sitemap_cgcalendar_template_type->set_originator($this->GetName());
	$sitemap_cgcalendar_template_type->set_name('sitemap_cgcalendar');
	$sitemap_cgcalendar_template_type->set_dflt_flag(TRUE);
	$sitemap_cgcalendar_template_type->set_lang_callback('SitemapMgr::page_type_lang_callback');
	$sitemap_cgcalendar_template_type->set_content_callback('SitemapMgr::reset_page_type_defaults');
	$sitemap_cgcalendar_template_type->reset_content_to_factory();
	$sitemap_cgcalendar_template_type->save();
}

catch( CmsException $e ) {
	debug_to_log(__FILE__.':'.__LINE__.' '.$e->GetMessage());
	audit('',$this->GetName(),'Installation Error: '.$e->GetMessage());
}

try {
	$fn = cms_join_path(dirname(__FILE__), 'templates', 'default_sitemap_cgcalendar.tpl');
	
	if ( file_exists( $fn ) )
	{
		$template = @file_get_contents($fn);
		$tpl = new CmsLayoutTemplate();
		$tpl->set_name('Sitemap CGCalendar');
		$tpl->set_owner($uid);
		$tpl->set_content($template);
		$tpl->set_type($sitemap_cgcalendar_template_type);
		$tpl->set_type_dflt(TRUE);
		$tpl->save();
	}
}

catch( CmsException $e ) {
	debug_to_log(__FILE__.':'.__LINE__.' '.$e->GetMessage());
	audit('',$this->GetName(),'Installation Error: '.$e->GetMessage());
}

// Sitemap Company Directory - type and template
try {
	$sitemap_compdir_template_type = new CmsLayoutTemplateType();
	$sitemap_compdir_template_type->set_originator($this->GetName());
	$sitemap_compdir_template_type->set_name('sitemap_compdir');
	$sitemap_compdir_template_type->set_dflt_flag(TRUE);
	$sitemap_compdir_template_type->set_lang_callback('SitemapMgr::page_type_lang_callback');
	$sitemap_compdir_template_type->set_content_callback('SitemapMgr::reset_page_type_defaults');
	$sitemap_compdir_template_type->reset_content_to_factory();
	$sitemap_compdir_template_type->save();
}

catch( CmsException $e ) {
	debug_to_log(__FILE__.':'.__LINE__.' '.$e->GetMessage());
	audit('',$this->GetName(),'Installation Error: '.$e->GetMessage());
}

try {
	$fn = cms_join_path(dirname(__FILE__), 'templates', 'default_sitemap_compdir.tpl');
	
	if ( file_exists( $fn ) )
	{
		$template = @file_get_contents($fn);
		$tpl = new CmsLayoutTemplate();
		$tpl->set_name('Sitemap Company Directory');
		$tpl->set_owner($uid);
		$tpl->set_content($template);
		$tpl->set_type($sitemap_compdir_template_type);
		$tpl->set_type_dflt(TRUE);
		$tpl->save();
	}
}

catch( CmsException $e ) {
	debug_to_log(__FILE__.':'.__LINE__.' '.$e->GetMessage());
	audit('',$this->GetName(),'Installation Error: '.$e->GetMessage());
}

// Sitemap Products - type and template
try {
	$sitemap_products_template_type = new CmsLayoutTemplateType();
	$sitemap_products_template_type->set_originator($this->GetName());
	$sitemap_products_template_type->set_name('sitemap_products');
	$sitemap_products_template_type->set_dflt_flag(TRUE);
	$sitemap_products_template_type->set_lang_callback('SitemapMgr::page_type_lang_callback');
	$sitemap_products_template_type->set_content_callback('SitemapMgr::reset_page_type_defaults');
	$sitemap_products_template_type->reset_content_to_factory();
	$sitemap_products_template_type->save();
}

catch( CmsException $e ) {
	debug_to_log(__FILE__.':'.__LINE__.' '.$e->GetMessage());
	audit('',$this->GetName(),'Installation Error: '.$e->GetMessage());
}

try {
	$fn = cms_join_path(dirname(__FILE__), 'templates', 'default_sitemap_products.tpl');
	
	if ( file_exists( $fn ) )
	{
		$template = @file_get_contents($fn);
		$tpl = new CmsLayoutTemplate();
		$tpl->set_name('Sitemap Products');
		$tpl->set_owner($uid);
		$tpl->set_content($template);
		$tpl->set_type($sitemap_products_template_type);
		$tpl->set_type_dflt(TRUE);
		$tpl->save();
	}
}

catch( CmsException $e ) {
	debug_to_log(__FILE__.':'.__LINE__.' '.$e->GetMessage());
	audit('',$this->GetName(),'Installation Error: '.$e->GetMessage());
}

$this->SetPreference('updatesitemapstask_lastrun', time() );
$this->SetPreference('sitemapmgr_firstrun', 'true');

#
# EOF
#
?>