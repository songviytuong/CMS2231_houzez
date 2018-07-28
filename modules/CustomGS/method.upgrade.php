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

$db = $this->GetDb();
$taboptarray = array('mysql' => 'ENGINE=MyISAM');
$dict = NewDataDictionary($db);

switch($oldversion)
{
	case "1.0":

		$flds = "
			fieldid I KEY AUTO,
			name C(255),
			help X,
			type C(20),
			properties X,
			sortorder I,
			value X
		";

		$sqlarray = $dict->CreateTableSQL(cms_db_prefix()."module_customgs", $flds, $taboptarray);
		$dict->ExecuteSQLArray($sqlarray);

		$idx = 1;
		for ($i = 1; $i <= 7; $i++)
		{
			// transfer checkboxes to database
			$fieldname = $this->GetPreference('input_title_checkbox_'.$i);
			if ( !empty($fieldname) )
			{
				$query = "INSERT INTO " . cms_db_prefix() . "module_customgs (name, help, type, sortorder, value) VALUES (?,?,?,?,?)";
				$db->Execute($query, array(
					$this->GetPreference('input_title_checkbox_'.$i),
					$this->GetPreference('input_help_checkbox_'.$i),
					'checkbox',
					$idx,
					$this->GetPreference('input_checkbox_'.$i)
				));
				$idx++;
			}
			$this->RemovePreference('input_checkbox_'.$i);
			$this->RemovePreference('input_title_checkbox_'.$i);
			$this->RemovePreference('input_help_checkbox_'.$i);
		}
		for ($i = 1; $i <= 5; $i++)
		{
			// transfer textfields to database
			$fieldname = $this->GetPreference('input_title_textfield_'.$i);
			if ( !empty($fieldname) )
			{
				$query = "INSERT INTO " . cms_db_prefix() . "module_customgs (name, help, type, sortorder, value) VALUES (?,?,?,?,?)";
				$db->Execute($query, array(
					$this->GetPreference('input_title_textfield_'.$i),
					$this->GetPreference('input_help_textfield_'.$i),
					'textfield',
					$idx,
					$this->GetPreference('input_textfield_'.$i)
				));
				$idx++;
			}
			$this->RemovePreference('input_textfield_'.$i);
			$this->RemovePreference('input_title_textfield_'.$i);
			$this->RemovePreference('input_help_textfield_'.$i);
		}
		// reset permissions
		$this->RemovePermission('Custom Global Settings - Settings');
		$this->CreatePermission('Custom Global Settings - Use', 'Custom Global Settings - Use');
		// create event
		$this->CreateEvent('OnSettingChange');
		// delete files
		$deletefiles = array ('function.admin_checkboxes.php', 'function.admin_textfields.php', 'function.admin_settings',
													'action.save_checkboxes.php', 'action.save_textfields.php', 'action.save_settings.php',
													'templates/admin_checkboxes.tpl', 'templates/admin_textfields.tpl', 'templates/admin_settings.tpl');
		foreach ($deletefiles as $deletefile) @unlink($deletefile);

		// current version: 1.1

	case "1.1":

		$this->SetPreference('admin_section', 'extensions');
		$sqlarray = $dict->AddColumnSQL(cms_db_prefix()."module_customgs", "clearcache I");
		$dict->ExecuteSQLArray($sqlarray);

		// current version: 1.2
		
	case "1.4":

		$sqlarray = $dict->AddColumnSQL(cms_db_prefix()."module_customgs", "editors C(255)");
		$dict->ExecuteSQLArray($sqlarray);

		// current version: 1.5
		
	case "1.5":
	case "1.6":
	case "2.0":
	case "2.1":
	case "2.2":

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
		$sqlarray = $dict->CreateIndexSQL(cms_db_prefix()."module_customgs_tabfield_idx", cms_db_prefix()."module_customgs_tabfield", "tabid,fieldid", array("UNIQUE"));
		$dict->ExecuteSQLArray($sqlarray);
	
		$query = "INSERT INTO " . cms_db_prefix() . "module_customgs_tab (tabid, name, sortorder) VALUES (?,?,?)";
		$db->Execute($query, array(1, $this->Lang("title_general"), 1));

		$query = "INSERT INTO " . cms_db_prefix() . "module_customgs_tabfield (tabid, fieldid)
					SELECT 1 AS tabid, fieldid FROM " . cms_db_prefix() . "module_customgs";
		$db->Execute($query);

	case "3.0":
	case "3.1":
		$query = "UPDATE " . cms_db_prefix() . "module_customgs SET name=CONCAT(name,'.') WHERE type='fieldsetend' AND RIGHT(name,1) <> '.'";
		$db->Execute($query);
    $query = "DELETE tf FROM " . cms_db_prefix() . "module_customgs_tabfield tf LEFT JOIN " . cms_db_prefix() . "module_customgs f ON tf.fieldid=f.fieldid WHERE f.fieldid IS NULL";
    $db->Execute($query);
    
		// current version: 3.2

}
?>