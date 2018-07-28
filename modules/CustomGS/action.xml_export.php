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

if( !$this->CheckPermission('Custom Global Settings - Manage') ) $this->Redirect($id, 'defaultadmin', $returnid);

$xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><data/>');
$xml->addChild('module', $this->GetName());
$xml->addChild('version', $this->GetVersion());
$xml->addChild('custom_modulename', $this->GetPreference('input_custom_modulename'));
$xml->addChild('admin_section', $this->GetPreference('admin_section', 'extensions'));
global $CMS_VERSION;
$xml->addChild('cmsversion', $CMS_VERSION);
$xml->addChild('exportdate', date('Y-m-d H:i:s'));

$db = cmsms()->GetDB();

$fields = $xml->addChild('fields');
$sql = 'SELECT * FROM ' . cms_db_prefix() . 'module_customgs ORDER BY sortorder';
$result = $db->GetAll($sql);
if (is_array($result))
{
  foreach ($result as $row)
  {
    $field = $fields->addChild('field');
    foreach ($row as $key => $val)
    {
      $field->{$key} = $val;
    }
  }
}

$tabs = $xml->addChild('tabs');
$sql = 'SELECT * FROM ' . cms_db_prefix() . 'module_customgs_tab ORDER BY sortorder';
$result = $db->GetAll($sql);
if (is_array($result))
{
  foreach ($result as $row)
  {
    $tab = $tabs->addChild('tab');
    foreach ($row as $key => $val)
    {
      $tab->{$key} = $val;
    }
  }
}

$tabfields = $xml->addChild('tabfields');
$sql = 'SELECT * FROM ' . cms_db_prefix() . 'module_customgs_tabfield ORDER BY tabid';
$result = $db->GetAll($sql);
if (is_array($result))
{
  foreach ($result as $row)
  {
    $tabfield = $tabfields->addChild('tabfield');
    foreach ($row as $key => $val)
    {
      $tabfield->{$key} = $val;
    }
  }
}

header('Pragma: public');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Cache-Control: private',false);
header('Content-Description: Export');
header('Content-Description: File Transfer');
header('Content-Type: application/force-download');
header('Content-Disposition: attachment; filename=CustomGlobalSettings_export.xml');
header('Content-Type: text/xml; charset=utf-8'); 

echo $xml->asXML();



/*
$this->Redirect($id, 'defaultadmin', $returnid, array('module_message' => $this->Lang('xmlcreated'), 'active_tab' => 'options'));
*/
?>