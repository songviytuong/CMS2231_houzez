<?php
#-------------------------------------------------------------------------
# Module: Custom Global Settings
# Author: Rolf Tjassens, Jos
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2011 by Ted Kulp (wishy@cmsmadesimple.org)
# This project's homepage is: http://www.cmsmadesimple.org
# The module's homepage is: http://dev.cmsmadesimple.org/projects/customgs
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

if (!isset($gCms)) exit;

/** 
 * Install module
 */

$this->CreatePermission('Custom Global Settings - Use', 'Custom Global Settings - Use');
$this->CreatePermission('Custom Global Settings - Manage', 'Custom Global Settings - Manage');
		
$this->SetPreference('input_custom_modulename', 'Custom Global Settings');
$this->SetPreference('admin_section', 'extensions');


$db = $this->GetDb();

// mysql-specific, but ignored by other database
$taboptarray = array('mysql' => 'ENGINE=MyISAM');
$dict = NewDataDictionary($db);

$flds = "
	fieldid I KEY AUTO,
	name C(255),
	help X,
	type C(20),
	properties X,
	clearcache I,
	sortorder I,
	value X,
	editors C(255)
";
$sqlarray = $dict->CreateTableSQL(cms_db_prefix()."module_customgs", $flds, $taboptarray);
$dict->ExecuteSQLArray($sqlarray);

$flds = "
	tabid I KEY AUTO,
	name C(255),
	sortorder I,
	editors C(255)
";
$sqlarray = $dict->CreateTableSQL(cms_db_prefix()."module_customgs_tab", $flds, $taboptarray);
$dict->ExecuteSQLArray($sqlarray);

$flds = "
	tabid I,
	fieldid I
";
$sqlarray = $dict->CreateTableSQL(cms_db_prefix()."module_customgs_tabfield", $flds, $taboptarray);
$dict->ExecuteSQLArray($sqlarray);
$sqlarray = $dict->CreateIndexSQL(cms_db_prefix()."module_customgs_tabfield", cms_db_prefix()."module_customgs_tabfield", "tabid,fieldid", array("UNIQUE"));
$dict->ExecuteSQLArray($sqlarray);

$query = "INSERT INTO " . cms_db_prefix() . "module_customgs (name, help, type, sortorder, value) VALUES (?,?,?,?,?)";
$db->Execute($query, array('Sample textfield', 'Sample help text for this textfield', 'textfield', 1, 'Sample value'));

$query = "INSERT INTO " . cms_db_prefix() . "module_customgs_tab (name, sortorder) VALUES (?,?)";
$db->Execute($query, array($this->Lang("title_general"), 1));

$query = "INSERT INTO " . cms_db_prefix() . "module_customgs_tabfield (fieldid, tabid) VALUES (?,?)";
$db->Execute($query, array(1, 1));

// register an event that CustomGS will issue.
$this->CreateEvent('OnSettingChange');
?>