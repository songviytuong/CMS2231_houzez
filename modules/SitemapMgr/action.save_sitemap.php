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

$sitemap_id = $params['sitemap_id'];
$sitemap_name = trim($params['sitemap_name']);
$sitemap_name_existing = trim($params['sitemap_name_existing']);
$sitemap_tag = trim($params['sitemap_tag']);

if (isset($params['cancel'])) 
	$this->Redirect($id, 'defaultadmin', $returnid, array('active_tab' => 'sitemap' . $sitemap_id));

$db = cmsms()->GetDb();

if ( isset( $params['delete_sitemap'] ) ) {
	// delete sitemap
	$query = "DELETE FROM `" . CMS_DB_PREFIX . "module_sitemapmgr` WHERE `sitemap_id`=?";
	$dbresult = $db->Execute( $query, array($sitemap_id) );
	
	@unlink ( cms_join_path( $config['root_path'], 'assets', 'sitemaps', 'sitemap-' . strtolower($sitemap_name) . '.xml' ) );
	
	// (re)create sitemap index file
	$this->CreateSitemapIndex();
	
	// show saved parameters in debug mode
	debug_display( $params );
	
	if (!$dbresult) {
		$this->Redirect($id, 'defaultadmin', $returnid, array('active_tab' => 'sitemap' . $sitemap_id, 'message' => 'error_deleting_sitemap'));
	} else {
		$this->Redirect($id, 'defaultadmin', $returnid, array('active_tab' => 'sitemaps', 'message' => 'sitemap_deleted'));
		
		// put mention in admin log
		audit('', $this->Lang('friendlyname'), $this->Lang('sitemap_deleted'));
	}
}

if ( isset( $params['submit'] ) ) {
	// update fields and (re)create sitemap file
	
	if ( preg_match('/^[A-Za-z0-9-]+$/', $sitemap_name) == 0 ) {
		$this->Redirect($id, 'defaultadmin', $returnid, array('active_tab' => 'sitemap' . $sitemap_id, 'errors' => $this->Lang('error_illegal_characters')));
	}
	
	if ( $sitemap_name != $sitemap_name_existing ) {
		$double = $db->GetOne("SELECT count(*) FROM `" . CMS_DB_PREFIX . "module_sitemapmgr` WHERE sitemap_name = '" . $sitemap_name . "'");
		if ( $double != 0 ) $sitemap_name = $sitemap_name . '-2';
		$double = $db->GetOne("SELECT count(*) FROM `" . CMS_DB_PREFIX . "module_sitemapmgr` WHERE sitemap_name = '" . $sitemap_name . "'");
		if ( $double != 0 ) $sitemap_name = $sitemap_name . '-2';
	}
	
	// TODO - Add some code here to test the Smarty tag...
	
	$query = "UPDATE " . CMS_DB_PREFIX . "module_sitemapmgr SET `sitemap_name`=?, `sitemap_tag`=? WHERE `sitemap_id`=?";
	$dbresult = $db->Execute($query, array($sitemap_name, $sitemap_tag, $sitemap_id));
	
	// show saved parameters in debug mode
	debug_display( $params );
	
	if (!$dbresult) {
		$this->Redirect($id, 'defaultadmin', $returnid, array('active_tab' => 'sitemap' . $sitemap_id, 'message' => 'error_updating_database'));
	} else {
		// (re)create sitemap file
		$this->CreateSitemap( $sitemap_id );
		
		// refresh sitemap index file
		$this->CreateSitemapIndex();
		
		// put mention in admin log
		audit('', $this->Lang('friendlyname'), $this->Lang('sitemap_updated'). ': ' . $sitemap_name);
		
		$this->Redirect($id, 'defaultadmin', $returnid, array('active_tab' => 'sitemap' . $sitemap_id, 'message' => 'changessaved'));
	}
}

$this->Redirect($id, 'defaultadmin', $returnid, array('active_tab' => 'sitemap' . $sitemap_id, 'errors' => $this->Lang('nothing_to_do')));

#
# EOF
#
?>