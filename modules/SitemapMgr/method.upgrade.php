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

$uid = get_userid();

if ( version_compare( $oldversion, '1.1' ) < 0 ) {
	$this->CreateSitemapIndex();
}

if ( version_compare( $oldversion, '1.2' ) < 0 ) {
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
}

if ( version_compare( $oldversion, '1.3.1' ) < 0 ) {
	$this->CreateSitemapIndex();
}

#
# EOF
#
?>