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

class SitemapMgr extends CMSModule {

	function GetName() { return 'SitemapMgr'; }
	function GetFriendlyName() { return 'SitemapMgr'; }
	function GetVersion() { return '1.5.3'; }
	function GetHelp() { return file_get_contents(dirname(__FILE__).'/help_text.inc'); }
	function GetAuthor() { return 'Rolf Tjassens'; }
	function GetAuthorEmail() { return 'info (at) cmscanbesimple (dot) org'; }
	function GetChangeLog() { return file_get_contents(dirname(__FILE__).'/changelog.inc'); }
	function HasAdmin() { return true; }
	function GetAdminSection() { return 'siteadmin'; }
	function GetAdminDescription() { return $this->Lang('moddescription'); }
	function VisibleToAdminUser() { return $this->CheckPermission('Modify Modules'); }
	function GetDependencies() { return array(); }
	function MinimumCMSVersion() { return '2.0'; }
	function InstallPostMessage() { return $this->Lang('postinstall'); }
	function UninstallPostMessage() { return $this->Lang('postuninstall'); }
	
	function IsPluginModule() { return true; }
	function InitializeFrontend() {
		$this->RestrictUnknownParams();
		$this->SetParameterType('sitemap_id',CLEAN_STRING);
	}
	function SetParameters() { $this->RestrictUnknownParams(); }


	/**
	 * initiate design manager
	 */
	public static function page_type_lang_callback($str)
	{
		$mod = cms_utils::get_module('SitemapMgr');
		if( is_object($mod) ) return $mod->Lang('type_'.$str);
	}

	public static function reset_page_type_defaults(CmsLayoutTemplateType $type)
	{
		if( $type->get_originator() != 'SitemapMgr' ) throw new CmsLogicException('Cannot reset contents for this template type');
		
		$fn = null;
		switch( $type->get_name() ) {
			case 'sitemap_cgblog':
				$fn = 'default_sitemap_cgblog.tpl';
				break;
				
			case 'sitemap_compdir':
				$fn = 'default_sitemap_compdir.tpl';
				break;
				
			case 'sitemap_news':
				$fn = 'default_sitemap_news.tpl';
				break;
				
			case 'sitemap_pages':
				$fn = 'default_sitemap_pages.tpl';
				break;
				
			case 'sitemap_products':
				$fn = 'default_sitemap_products.tpl';
				break;
				
			case 'sitemap_custom':
				$fn = 'default_sitemap_custom.tpl';
		}
		
		$fn = cms_join_path(__DIR__,'templates',$fn);
		if( file_exists($fn) ) return @file_get_contents($fn);
	}


	/**
	 * initiate pseudo cron
	 */
	public function HasCapability($capability,$params = array())
	{
		if( $capability == 'tasks' ) return TRUE;
		return FALSE;
	}

	public function get_tasks()
	{
		$out = array();
		$out[] = new UpdateSitemapsTask();
		return $out;
	}


	/**
	 * global module functions
	 */
	function CreateSitemap( $sitemap_id ) {
		$config = cmsms()->GetConfig();
		
		// perform a frontend request
		$url = $config['root_url'] . '/index.php?mact=SitemapMgr,cntnt01,update_sitemap,0&cntnt01sitemap_id=' . $sitemap_id;
		
		// show url in developer/debug mode
		if ( !empty ( $config['developer_mode']) )
			debug_display( 'URL SitemapMgr frontend request: ' . $url );
		
		$req = new cms_http_request();
		$req->setTimeout(10);
		$req->setReferrer('');
		$req->execute( $url );
	}

	function CreateSitemapIndex() {
		$config = cmsms()->GetConfig();
		$db = cmsms()->GetDb();
		$smarty = cmsms()->GetSmarty();
		
		$query = "SELECT * FROM " . CMS_DB_PREFIX . "module_sitemapmgr ORDER BY sitemap_name";
		$dbresult = $db->Execute($query);
		
		$items = Array();
		while( $row = $dbresult->FetchRow() )
		{
			$i = count($items);
			$items[$i]['sitemap_name'] = $row['sitemap_name'];
		}
		$smarty->assign('items', $items);
		
		$fn = cms_join_path(__DIR__,'templates','default_sitemap_index.tpl');
		$file_data = $smarty->fetch($fn);
		
		cmsms()->set_content_type('text/xml');
		file_put_contents( cms_join_path( $config['root_path'],'sitemap.xml' ), $file_data );
	}
}

#
# EOF
#
?>