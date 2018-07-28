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

if (isset($params['cancel'])) 
	$this->Redirect($id, 'defaultadmin', $returnid, array('active_tab' => 'sitemaps'));

$db = cmsms()->GetDb();

if ( $params['create_new_sitemap'] ) {
	if( !empty($params['new_sitemap_name']) ) {
		
		$new_sitemap_name = trim($params['new_sitemap_name']);
		$new_sitemap_type = trim($params['new_sitemap_type']);
		
		// is module installed?
		$the_modules = array (
			'CMSContentManager' => 'sitemap_pages', 'News' => 'sitemap_news', 'CGBlog' => 'sitemap_cgblog',
			'CGCalendar' => 'sitemap_cgcalendar', 'CompanyDirectory' => 'sitemap_compdir', 'LISE' => 'sitemap_liseinstance',
			'Products' =>  'sitemap_products'
		);
		
		$module = '';
		$installed_modules = array();
		
		foreach ( $the_modules as $name => $sitemap_type ) {
			$module = cms_utils::get_module( $name );
			if ( $module ) $installed_modules[] = $sitemap_type;
		}
		
		if ( !in_array( $new_sitemap_type , $installed_modules ) ) {
			$this->Redirect($id, 'defaultadmin', $returnid, array('active_tab' => 'sitemaps', 'errors' => $this->Lang('error_module_not_installed')));
		}
		
		if ( preg_match('/^[A-Za-z0-9-]+$/', $new_sitemap_name) == 0 ) {
			$this->Redirect($id, 'defaultadmin', $returnid, array('active_tab' => 'sitemaps', 'errors' => $this->Lang('error_illegal_characters')));
		}
		
		$double = $db->GetOne("SELECT count(*) FROM `" . CMS_DB_PREFIX . "module_sitemapmgr` WHERE sitemap_name = '" . $new_sitemap_name . "'");
		if ( $double != 0 ) $new_sitemap_name = $new_sitemap_name . '-2';
		$double = $db->GetOne("SELECT count(*) FROM `" . CMS_DB_PREFIX . "module_sitemapmgr` WHERE sitemap_name = '" . $new_sitemap_name . "'");
		if ( $double != 0 ) $new_sitemap_name = $new_sitemap_name . '-2';
		
		$designmgr = TRUE;
		$new_sitemap_tag = null;
		
		switch( $new_sitemap_type ) {
			case 'sitemap_cgblog':
				$new_sitemap_tag = "{CGBlog summarytemplate='cms_template:Sitemap CGBlog' number=1000}";
				break;
			
			case 'sitemap_cgcalendar':
				$new_sitemap_tag = "{CGCalendar display='upcominglist' listtemplate='cms_template:Sitemap CGCalendar'}";
				break;
			
			case 'sitemap_compdir':
				$designmgr = FALSE;
				$new_sitemap_tag = "{CompanyDirectory summarytemplate='Sitemap Company Directory'}";
				break;
			
			case 'sitemap_liseinstance':
				$designmgr = FALSE;
				$new_sitemap_tag = "{LISE[instance name] template_summary='Sitemap LISE[instance name]'}";
				break;
			
			case 'sitemap_news':
				$new_sitemap_tag = "{News summarytemplate='cms_template:Sitemap News'}";
				break;
			
			case 'sitemap_pages':
				$new_sitemap_tag = "{Navigator template='cms_template:Sitemap Pages'}";
				break;
			
			case 'sitemap_products':
				$new_sitemap_tag = "{Products summarytemplate='cms_template:Sitemap Products'}";
				break;
			
			case 'sitemap_custom':
				$designmgr = FALSE;
				$new_sitemap_tag = "";
		}
		
		$query = "INSERT INTO " . CMS_DB_PREFIX . "module_sitemapmgr (`sitemap_name`, `sitemap_type`, `sitemap_tag`) VALUES (?,?,?)";
		$dbresult = $db->Execute($query, array($new_sitemap_name,$new_sitemap_type,$new_sitemap_tag));
		if ( !$dbresult ) {
			$this->Redirect($id, 'defaultadmin', $returnid, array('active_tab' => 'sitemaps', 'errors' => $this->Lang('error_updating_database')));
		} else {
			
			if ( $designmgr == TRUE )
			{
				// get new sitemap_id
				$query = "SELECT sitemap_id FROM " . CMS_DB_PREFIX . "module_sitemapmgr WHERE sitemap_name='" . $new_sitemap_name."'";
				
				// show query in debug mode
				debug_display( $query );
				
				$dbresult = $db->Execute($query);
				
				while( $row = $dbresult->FetchRow() )
				{
					$sitemap_id = $row['sitemap_id'];
				}
				
				debug_display( 'Sitemap ID: '. $sitemap_id );
				
				if ( $sitemap_id != '' ) {
					// create sitemap file
					$this->CreateSitemap( $sitemap_id );
					
					// update sitemap index file
					$this->CreateSitemapIndex();
				}
			}
			
			// put mention in admin log
			audit('', $this->Lang('friendlyname'), $this->Lang('sitemap_created'));
			
			$this->Redirect($id, 'defaultadmin', $returnid, array('active_tab' => 'sitemaps', 'message' => 'sitemap_created'));
		}
		
	} else {
		$this->Redirect($id, 'defaultadmin', $returnid, array('active_tab' => 'sitemaps', 'errors' => $this->Lang('error_required_fields')));
	}
}

// show saved parameters in debug mode
debug_display( $params );

$this->Redirect($id, 'defaultadmin', $returnid, array('active_tab' => 'sitemaps', 'errors' => $this->Lang('nothing_to_do')));

#
# EOF
#
?>