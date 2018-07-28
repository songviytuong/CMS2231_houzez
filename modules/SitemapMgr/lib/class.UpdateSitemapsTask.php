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

class UpdateSitemapsTask implements CmsRegularTask
{
    public function get_name() { return 'SitemapMgr: Update sitemaps'; }

    public function get_description()
    {
		$mod = cms_utils::get_module('SitemapMgr');
		return $mod->Lang('updatesitemapstask_description');
    }

    public function test($time = '')
    {
		if( !$time ) $time = time();
		$mod = cms_utils::get_module('SitemapMgr');
		$lastrun = $mod->GetPreference('updatesitemapstask_lastrun');
		
		// every 24 hours
		if( ($time - 24 * 60 * 60) >= $lastrun )
		{
			// to prevent multiple hits, set time here (too)
			$mod = cms_utils::get_module('SitemapMgr');
			$mod->SetPreference('updatesitemapstask_lastrun',$time);
			
			return TRUE;
		}
		
		return FALSE;
	}

	public function execute($time = '')
	{
		if( !$time ) $time = time();
		
		$config = cmsms()->GetConfig();
		$dir = cms_join_path( $config['root_path'], 'assets', 'sitemaps' );
		
		// clean out directory
		$files = glob( $dir . '*' );
		foreach ( $files as $file )
		{
			if ( is_file( $file ) ) unlink($file);
		}
		
		// put back index.html
		file_put_contents( ( cms_join_path( $dir, 'index.html' ) ), '' );
		
		// create new sitemap files
		$db = cmsms()->GetDb();
		$smarty = cmsms()->GetSmarty();
		
		$query = "SELECT * FROM " . CMS_DB_PREFIX . "module_sitemapmgr";
		$dbresult = $db->Execute($query);
		
		while( $row = $dbresult->FetchRow() )
		{
			$sitemap_id = $row['sitemap_id'];
			
			// (re)create sitemap file
			$mod = cms_utils::get_module('SitemapMgr');
			$mod->CreateSitemap( $sitemap_id );
		}
		
		// (re)create sitemap index file
		$mod->CreateSitemapIndex();
		
		// put mention in admin log
		audit('', 'SitemapMgr', 'Sitemaps automatically updated');
		
		return TRUE;
    }

	public function on_success($time = '')
	{
		if( !$time ) $time = time();
		$mod = cms_utils::get_module('SitemapMgr');
		$mod->SetPreference('updatesitemapstask_lastrun',$time);
	}

	public function on_failure($time = '') 
	{
		if( !$time ) $time = time();
		
		// put mention in admin log
		audit('', 'SitemapMgr', 'Automatic sitemap update failed');
	}
}

#
# EOF
#
?>