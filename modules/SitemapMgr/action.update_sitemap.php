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

$sitemap_id = trim($params['sitemap_id']);

// only allow numbers
if ( !is_numeric( $sitemap_id ) ) die;

$config = cmsms()->GetConfig();
$db = cmsms()->GetDb();
$smarty = cmsms()->GetSmarty();

if ( !empty ( $sitemap_id ) ) {
	// check if the sitemap id is available, if not someone might be trying to do bad things...
	$available = $db->GetOne("SELECT count(*) FROM `" . CMS_DB_PREFIX . "module_sitemapmgr` WHERE sitemap_id = '" . $sitemap_id . "'");
	if ( $available == 0 ) die;
	
	// get sitemap name and tag matching the sitemap id
	$query = "SELECT * FROM " . CMS_DB_PREFIX . "module_sitemapmgr WHERE sitemap_id = '" . $sitemap_id . "'";
	$dbresult = $db->Execute($query);
	
	while( $row = $dbresult->FetchRow() )
	{
		$sitemap_name = $row['sitemap_name'];
		$sitemap_tag = $row['sitemap_tag'];
	}
}

// generate the sitemap content
$smarty_data = $smarty->fetch('string:'.$sitemap_tag);

// all ready, lets create the sitemap file
cmsms()->set_content_type('text/xml');
file_put_contents( ( cms_join_path( $config['root_path'], 'assets', 'sitemaps', 'sitemap-' . strtolower($sitemap_name) . '.xml' ) ), $smarty_data );

if ( !empty ( $config['developer_mode']) )
	echo 'Frontend request received and processed, exiting...';

exit;

#
# EOF
#
?>