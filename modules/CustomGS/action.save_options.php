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

if (!isset($gCms))
  exit;

if (!$this->CheckPermission('Custom Global Settings - Manage'))
  $this->Redirect($id, 'defaultadmin', $returnid);

// Check for xml import
$xmlfield = $id . 'xmlfile';
if (!empty($_FILES[$xmlfield]['name']))
{
  if ($_FILES[$xmlfield]['type'] == 'text/xml')
  {
    $xml = file_get_contents($_FILES[$xmlfield]['tmp_name']);
    $data = new SimpleXMLElement($xml);
    $db = cmsms()->GetDB();

    //fields
    $sql = 'SELECT fieldid, name, type FROM ' . cms_db_prefix() . 'module_customgs ORDER BY fieldid';
    $result = $db->GetAll($sql);
    if (is_array($result))
    {
      $curflds = array();
      foreach ($result as $row)
      {
        $curflds[$row['name']] = array('fieldid' => $row['fieldid'], 'type' => $row['type']);
      }
    }
    foreach ($data->fields->field as $field)
    {
      $fieldname = (string) $field->name;
      if (array_key_exists($fieldname, $curflds))
      {
        $sql = 'UPDATE ' . cms_db_prefix() . 'module_customgs SET 
              name = ?, help = ?, type = ?, properties = ?, clearcache = ?, sortorder = ?, value = ?
            WHERE fieldid = ?';
        $dbr = $db->Execute($sql, array(
            (string) $field->name,
            (string) $field->help,
            (string) $field->type,
            (string) $field->properties,
            (int) $field->clearcache,
            (int) $field->sortorder,
            (string) $field->value,
            $curflds[$fieldname]['fieldid']
        ));
        $fieldref[(int) $field->fieldid] = $curflds[$fieldname]['fieldid'];
      }
      else
      {
        $sql = 'INSERT INTO ' . cms_db_prefix() . 'module_customgs 
              (name, help, type, properties, clearcache, sortorder, value)
            VALUES (?,?,?,?,?,?,?)';
        $dbr = $db->Execute($sql, array(
            (string) $field->name,
            (string) $field->help,
            (string) $field->type,
            (string) $field->properties,
            (int) $field->clearcache,
            (int) $field->sortorder,
            (string) $field->value
        ));
        $fieldref[(int) $field->fieldid] = $db->Insert_ID();
      }
    }

    // tabs
    $sql = 'SELECT tabid, name, sortorder FROM ' . cms_db_prefix() . 'module_customgs_tab ORDER BY sortorder';
    $result = $db->GetAll($sql);
    if (is_array($result))
    {
      $curtabs = array();
      foreach ($result as $row)
      {
        $curtabs[$row['name']] = $row['tabid'];
      }
      $sortmax = $row['sortorder'] + 1;
    }
    foreach ($data->tabs->tab as $tab)
    {
      $tabname = (string) $tab->name;
      if (array_key_exists($tabname, $curtabs))
      {
        // don't update the sortorder of tabs
        $tabref[(int) $tab->tabid] = $curtabs[$tabname];
      }
      else
      {
        $sql = 'INSERT INTO ' . cms_db_prefix() . 'module_customgs_tab 
              (name, sortorder)
            VALUES (?,?)';
        $dbr = $db->Execute($sql, array(
            (string) $tab->name,
            $sortmax++
        ));
        $tabref[(int) $tab->tabid] = $db->Insert_ID();
      }
    }

    // tabfields
    foreach ($data->tabfields->tabfield as $tabfield)
    {
      $sql = 'INSERT INTO ' . cms_db_prefix() . 'module_customgs_tabfield
            (tabid, fieldid)
          VALUES (?,?)';
      $dbr = $db->Execute($sql, array(
          $tabref[(int) $tabfield->tabid],
          $fieldref[(int) $tabfield->fieldid]
      ));
    }
  }
}
				

// Save Parameters Options Tab
if (isset($xml) && !empty((string) $data->custom_modulename) && in_array((string) $data->admin_section, array('main', 'content', 'layout', 'usersgroups', 'extensions', 'admin', 'myprefs')))
{
  $this->SetPreference('input_custom_modulename', (string) $data->custom_modulename);
  $this->SetPreference('admin_section', (string) $data->admin_section);
}
else
{
  if (isset($params['input_custom_modulename']))
    $this->SetPreference('input_custom_modulename', $params['input_custom_modulename']);
  if (isset($params['input_admin_section']))
    $this->SetPreference('admin_section', $params['input_admin_section']);
}

// Touch menu cache files
if (version_compare(CMS_VERSION, '1.99-alpha0', '<'))
{
  foreach (glob(cms_join_path(TMP_CACHE_LOCATION, "themeinfo*.cache")) as $filename)
  {
    @unlink($filename);
  } // 1.11
}
else
{
  foreach (glob(cms_join_path(TMP_CACHE_LOCATION, "cache*.cms")) as $filename)
  {
    @unlink($filename);
  } // 2.0
}


// Show saved parameters in debug mode
debug_display($params);

// Put mention into the admin log
audit('', 'Custom Global Settings - Options tab', 'Saved');

$this->Redirect($id, 'defaultadmin', $returnid, array('module_message' => $this->Lang('settingssaved'), 'active_tab' => 'options'));
?>