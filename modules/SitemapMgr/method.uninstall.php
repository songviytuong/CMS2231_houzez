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

// remove the database tables
$db = cmsms()->GetDb();
$dict = NewDataDictionary( $db );

$sqlarray = $dict->DropTableSQL( CMS_DB_PREFIX . 'module_sitemapmgr' );
$dict->ExecuteSQLArray($sqlarray);

// remove all preferences
$this->RemovePreference();

// and template preferences
$this->DeleteTemplate();

// remove all templates and template types
try {
	$types = CmsLayoutTemplateType::load_all_by_originator($this->GetName());
	foreach( $types as $type ) {
		try {
			$templates = $type->get_template_list();
			if( is_array($templates) && count($templates) ) {
				foreach( $templates as $tpl ) {
					$tpl->delete();
				}
			}
		}
		
		catch( Exception $e ) {
			debug_to_log(__FILE__.':'.__LINE__.' '.$e->GetMessage());
			audit('',$this->GetName(),'Uninstall Error: '.$e->GetMessage());
		}
		
		$type->delete();
	}
}

catch( CmsException $e ) {
	debug_to_log(__FILE__.':'.__LINE__.' '.$e->GetMessage());
    audit('',$this->GetName(),'Uninstall Error: '.$e->GetMessage());
    return FALSE;
}

#
# EOF
#
?>