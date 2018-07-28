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
	$this->Redirect($id, 'defaultadmin', $returnid, array('active_tab' => 'robotstxt'));
	
if (isset($params['reset'])) {
	$default_robotstxt_content = file_get_contents( cms_join_path(dirname(__FILE__), 'templates', 'default_robotstxt.tpl') );
	$default_robotstxt_content = str_replace( 'root_url',$config['root_url'],$default_robotstxt_content );
	$this->SetPreference('robotstxt_content', $default_robotstxt_content);
	
	$this->Redirect($id, 'defaultadmin', $returnid, array('active_tab' => 'robotstxt', 'message' => 'content_reset'));
}
	
$robotstxt_content = isset($params['robotstxt_content']) ? $params['robotstxt_content'] : '';
$this->SetPreference('robotstxt_content', $robotstxt_content);

if ( empty($robotstxt_content) ) {
	@unlink ( cms_join_path( $config['root_path'],'robots.txt' ) );
} else {
	cmsms()->set_content_type('text/plain');
	file_put_contents( cms_join_path( $config['root_path'],'robots.txt' ), $robotstxt_content );
}

// Show saved parameters in debug mode
debug_display($params);

$this->Redirect($id, 'defaultadmin', $returnid, array('active_tab' => 'robotstxt', 'message' => 'changessaved'));

#
# EOF
#
?>