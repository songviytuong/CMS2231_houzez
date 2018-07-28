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

if( !$this->CheckPermission('Custom Global Settings - Manage') )
{
	echo $this->ShowErrors(lang('needpermissionto', 'Custom Global Settings - Manage'));
	return;
}

if ( isset($params['cancel']) )
{
	$params = array('active_tab' => 'fielddefs');
	$this->Redirect($id, 'defaultadmin', '', $params);
}

if( !isset($params['mode']) )
{
	$params = array('module_error' => lang('missingparams'), 'active_tab' => 'fielddefs');
	$this->Redirect($id, 'defaultadmin', '', $params);
	return;
}

$db = $this->GetDB();

switch ($params['mode'])
{
	case 'add':
		if( $_SERVER['REQUEST_METHOD'] == 'POST' )
		{
			// check if name is empty
			if ( empty($params['name']) ) $params['name'] = $params['type'] . "1";
			// check if name already exists
			while ( $this->GetField($params['name']) !== FALSE )
			{
				if ( is_numeric(substr($params['name'], -1)) )
				{
					$params['name'] = is_numeric(substr($params['name'], -2)) ? substr($params['name'],0 , -2) . (substr($params['name'], -2) + 1) : substr($params['name'],0 , -1) . (substr($params['name'], -1) + 1);
				}
				else
				{
					$params['name'] .= "1";
				}
			}
			// find maximum value for sortorder
			$query = "SELECT MAX(sortorder) AS maxsortorder FROM ".cms_db_prefix()."module_customgs";
			$result = $db->Execute($query);
			if( $result )
			{
				$field = $result->FetchRow();
				// set properties, depending on fieldtype
				if( $params['type'] == 'textfield' )
				{
					$params['properties'] = is_numeric($params['maxlength']) ? $params['maxlength'] : 255;
				}
				elseif ( $params['type'] == 'textarea' || $params['type'] == 'wysiwyg' )
				{
					$params['properties'] = isset($params['parsesmarty']);
				}
				elseif ( $params['type'] != 'pulldown' && $params['type'] != 'radiobuttons' )
				{
					$params['properties'] = '';
				}
				elseif ( $params['type'] == 'fieldsetstart' )
				{
					$params['type'] = 'fieldsetstart';
					$params['properties'] = '';
				}
				$params['clearcache'] = isset($params['clearcache']);
				
				$editors = empty($params['editors']) ? '' : implode(';', $params['editors']);
				
				// save fielddefinition
				$query = "INSERT INTO ".cms_db_prefix()."module_customgs (name, help, type, properties, clearcache, sortorder, editors) VALUES (?,?,?,?,?,?,?)";
				$result = $db->Execute($query, array($params['name'], $params['help'], $params['type'], $params['properties'], $params['clearcache'], $field['maxsortorder'] + 1, $editors));
			}
			if( isset($result) && $result )
			{
				$fieldid = $db->Insert_ID();

				// add also fieldsetend if fieldsetstart was added
				if ( $params['type'] == 'fieldsetstart' )
				{
					$result = $db->Execute($query, array($params['name'] . '.', '', 'fieldsetend', '', $params['clearcache'], $field['maxsortorder'] + 2, $editors));
					$fieldid2 = $db->Insert_ID();
				}

				// save tab assignments
				foreach ($params['tabs'] as $tabid => $tabselect)
				{
					if ( $tabselect == 1 )
					{
						$query = "INSERT INTO ".cms_db_prefix()."module_customgs_tabfield (tabid, fieldid) VALUES (?,?)";
						$result = $db->Execute($query, array($tabid, $fieldid));
						if ( $params['type'] == 'fieldsetstart' )
						{
							$query = "INSERT INTO ".cms_db_prefix()."module_customgs_tabfield (tabid, fieldid) VALUES (?,?)";
							$result = $db->Execute($query, array($tabid, $fieldid2));
						}
					}
				}
				
				// Put mention into the admin log
				audit($fieldid, 'Custom Global Settings - Fielddefinition', 'Added: ' . $params['name']);
				$params = array('tab_message'=> 'fielddefadded', 'active_tab' => 'fielddefs');
			}
			else
			{
				$params = array('module_error'=> 'updatefailed', 'active_tab' => 'fielddefs');
			}

			$this->Redirect($id, 'defaultadmin', '', $params);
		}
		$field = array('name' => '', 'help' => '', 'type' => '', 'maxlength' => '', 'properties' => '', 'parsesmarty' => '', 'clearcache' => 0, 'editors' => '');
		$smarty->assign('title',lang('add'));
		$smarty->assign('hidden', $this->CreateInputHidden($id, 'mode', 'add'));
		break;


	case 'delete':
		if( !is_numeric($params['fieldid']) )
		{
			$params = array('module_error' => lang('missingparams'), 'active_tab' => 'fielddefs');
			$this->Redirect($id, 'defaultadmin', '', $params);
			return;
		}
		
		$field = $this->GetField($params['fieldid']);
		if( $field === FALSE )
		{
			$params = array('module_error'=> 'updatefailed', 'active_tab' => 'fielddefs');
			$this->Redirect($id, 'defaultadmin', '', $params);
		}
		$query = "DELETE FROM " . cms_db_prefix() . "module_customgs WHERE fieldid = ?";
		$db->Execute($query, array($params['fieldid']));
		// Put mention into the admin log
		audit($params['fieldid'], 'Custom Global Settings - Fielddefinition', 'Deleted: ' . $field['name']);

		// update the sortorder
		$query = "UPDATE " . cms_db_prefix() . "module_customgs SET sortorder = sortorder - 1 WHERE sortorder > ?";
		$result = $db->Execute($query, array($field['sortorder']));
		
    // delete all tab-assignments
    $query = "DELETE FROM " . cms_db_prefix() . "module_customgs_tabfield WHERE fieldid = ?";
    $result = $db->Execute($query, array($params['fieldid']));

		// delete fieldsetend
		if ( $field['type'] == 'fieldsetstart' )
		{
			$field2 = $this->GetField($field['name']);
			if( $field2 !== FALSE )
			{
				$query = "DELETE FROM " . cms_db_prefix() . "module_customgs WHERE fieldid = ?";
				$db->Execute($query, array($field2['fieldid']));
				$query = "UPDATE " . cms_db_prefix() . "module_customgs SET sortorder = sortorder - 1 WHERE sortorder > ?";
				$result = $db->Execute($query, array($field2['sortorder']));
			}
		}

		$params = array('tab_message'=> 'fielddefsupdated', 'active_tab' => 'fielddefs');
		$this->Redirect($id, 'defaultadmin', '', $params);
		break;


	case 'edit':
		if( !is_numeric($params['fieldid']) )
		{
			$params = array('module_error' => lang('missingparams'), 'active_tab' => 'fielddefs');
			$this->Redirect($id, 'defaultadmin', '', $params);
			return;
		}

		$field = $this->GetField($params['fieldid']);

		if( $_SERVER['REQUEST_METHOD'] == 'POST' )
		{
			// check if name is empty
			if ( empty($params['name']) ) $params['name'] = $params['type'] . "1";
			// check if name already exists
			$checkfieldname = $field['type'] == 'fieldsetstart' ? FALSE : $this->GetField($params['name']);
			While ( $checkfieldname !== FALSE && $params['fieldid'] != $checkfieldname['fieldid'] )
			{
				if ( is_numeric(substr($params['name'], -1)) )
				{
					$params['name'] = is_numeric(substr($params['name'], -2)) ? substr($params['name'],0 , -2) . (substr($params['name'], -2) + 1) : substr($params['name'],0 , -1) . (substr($params['name'], -1) + 1);
				}
				else
				{
					$params['name'] .= "1";
				}
				$checkfieldname = $this->GetField($params['name']);
			}
			// set properties, depending on fieldtype
			if( $params['type'] == 'textfield' )
			{
				$params['properties'] = is_numeric($params['maxlength']) ? $params['maxlength'] : 255;
			}
			elseif ( $params['type'] == 'textarea' || $params['type'] == 'wysiwyg' )
			{
				$params['properties'] = $params['parsesmarty'];
			}
			elseif ( $params['type'] != 'pulldown' && $params['type'] != 'radiobuttons' )
			{
				$params['properties'] = '';
			}
			
			$params['clearcache'] = isset($params['clearcache']);
			
			$editors = empty($params['editors']) ? '' : implode(';', $params['editors']);
			
			// save fielddefinition
			$query = "UPDATE " . cms_db_prefix() . "module_customgs SET name = ?, help = ?, type = ?, properties = ?, clearcache = ?, editors = ? WHERE fieldid = ?";
			$result = $db->Execute($query, array($params['name'], $params['help'], $params['type'], $params['properties'], $params['clearcache'], $editors, $params['fieldid']));

			// delete all tab-assignments
			$query = "DELETE FROM " . cms_db_prefix() . "module_customgs_tabfield WHERE fieldid = ?";
			$result = $db->Execute($query, array($params['fieldid']));
			
			// save fieldsetend
			if ( $field['type'] == 'fieldsetstart' )
			{
				$fieldend = $this->GetField($field['name'] . '.');
				$result = $db->Execute($query, array($fieldend['fieldid']));
				$query = "UPDATE " . cms_db_prefix() . "module_customgs SET name = ?, editors = ? WHERE fieldid = ?";
				$result = $db->Execute($query, array($params['name'] . '.', $editors, $fieldend['fieldid']));
			}
			
			// save tab-assignments
			if ( isset($params['tabs']) ) {
			
				foreach ($params['tabs'] as $tabid => $tabselect)
				{
					if ( $tabselect == 1 )
					{
						$query = "INSERT INTO ".cms_db_prefix()."module_customgs_tabfield (tabid, fieldid) VALUES (?,?)";
						$result = $db->Execute($query, array($tabid, $params['fieldid']));
						if ( $field['type'] == 'fieldsetstart' )
						{
							$result = $db->Execute($query, array($tabid, $fieldend['fieldid']));
						}
					}
				}
				
			}
			

			// Put mention into the admin log
			audit($params['fieldid'], 'Custom Global Settings - Fielddefinition', 'Edited: ' . $params['name']);

			$params = array('tab_message'=> 'fielddefsupdated', 'active_tab' => 'fielddefs');
			$this->Redirect($id, 'defaultadmin', '', $params);
		}

		$smarty->assign('title',lang('edit'));
		$smarty->assign('hidden', $this->CreateInputHidden($id, 'fieldid', $params['fieldid']) .
						$this->CreateInputHidden($id, 'mode', 'edit'));
		break;


	case 'moveup':
	case 'movedown':
		$field = $this->GetField($params['fieldid']);
		if( $field === FALSE )		 
		{
			$params = array('module_error'=> 'updatefailed', 'active_tab' => 'fielddefs');
			$this->Redirect($id, 'defaultadmin', '', $params);
		}

		$query = "UPDATE " . cms_db_prefix() . "module_customgs SET sortorder = " . ($params['mode'] == 'moveup' ? 'sortorder + 1' : 'sortorder - 1') . " WHERE sortorder = ?";
		$result = $db->Execute($query, array($params['mode'] == 'moveup' ? $field['sortorder'] - 1 : $field['sortorder'] + 1));

		$query = "UPDATE " . cms_db_prefix() . "module_customgs SET sortorder = " . ($params['mode'] == 'moveup' ? 'sortorder - 1' : 'sortorder + 1') . " WHERE fieldid = ?";
		$result = $db->Execute($query, array($params['fieldid']));

		$params = array('active_tab' => 'fielddefs');
		$this->Redirect($id, 'defaultadmin', '', $params);
		break;

		
	case 'sort':
		if ( !empty($params['sortseq']) )
		{
			$sortseq = str_replace('i', '', $params['sortseq']);
			$sortentries = explode(',', $sortseq);
			foreach ( $sortentries as $key => $fieldid )
			{
				$query = "UPDATE " . cms_db_prefix() . "module_customgs SET sortorder = ? WHERE fieldid = ?";
				$db->Execute($query, array($key + 1, $fieldid));
			}
		}
		exit();
		break;

		
	case 'assign':
		if ( !empty($params['fieldid']) && !empty($params['tabid']) )
		{
			$db = $this->GetDB();
			$query = "SELECT f.name, f.type, tf.* FROM " . cms_db_prefix() . "module_customgs f
						LEFT JOIN " . cms_db_prefix() . "module_customgs_tabfield tf ON f.fieldid = tf.fieldid AND tf.tabid = ?
						WHERE f.fieldid = ?";
			$rows = $db->GetAll($query, array($params['tabid'], $params['fieldid']));
			$rowcount = count($rows);
			
			if ( $rows && $rowcount > 0 && !empty($rows[0]['tabid']) )
			{
				$query = "DELETE FROM " . cms_db_prefix() . "module_customgs_tabfield WHERE tabid = ? AND fieldid = ?";
				$result = $db->Execute($query, array($params['tabid'], $params['fieldid']));
				if ( $rows[0]['type'] == 'fieldsetstart' )
				{
					$fieldend = $this->GetField($rows[0]['name']);
					$result = $db->Execute($query, array($params['tabid'], $fieldend['fieldid']));
				}
				echo 0;
			}
			else
			{
				$query = "INSERT INTO " . cms_db_prefix() . "module_customgs_tabfield (tabid, fieldid) VALUES (?,?)";
				$result = $db->Execute($query, array($params['tabid'], $params['fieldid']));
				if ( $rows[0]['type'] == 'fieldsetstart' )
				{
					$fieldend = $this->GetField($rows[0]['name']);
					$result = $db->Execute($query, array($params['tabid'], $fieldend['fieldid']));
				}
				echo 1;
			}
		}
		exit();
		break;

}


$typelist = array(
	$this->Lang('textfield') => 'textfield',
	$this->Lang('pulldown') => 'pulldown',
	$this->Lang('checkbox') => 'checkbox',
	$this->Lang('radiobuttons') => 'radiobuttons',
	$this->Lang('datepicker') => 'datepicker',
	$this->Lang('datetimepicker') => 'datetimepicker',
	$this->Lang('timepicker') => 'timepicker',
	$this->Lang('textarea') => 'textarea',
	$this->Lang('wysiwyg') => 'wysiwyg',
	$this->Lang('colorpicker') => 'colorpicker',
	$this->Lang('pageselect') => 'pageselect',
	$this->Lang('fieldsetstart') => 'fieldsetstart',
	$this->Lang('button') => 'button'
);

$disabled = $field['type'] == 'fieldsetstart' ? ' disabled="disabled"' : '';

$corefp = cms_utils::get_module('FilePicker');
if( $corefp )
{
	$corefp_name = $corefp->GetFriendlyName();
	$typelist[$corefp_name] = 'corefilepicker';
}

$gbfp = cms_utils::get_module('GBFilePicker');
if( $gbfp )
{
	$gbfp_name = $gbfp->GetFriendlyName();
	$typelist[$gbfp_name] = 'gbfilepicker';
}

$jmfp = cms_utils::get_module('JMFilePicker');
if( $jmfp )
{
	$jmfp_name = $jmfp->GetFriendlyName();
	$typelist[$jmfp_name] = 'jmfilepicker';
}


$smarty->assign('prompt_name', lang('name'));
$smarty->assign('name', $this->CreateInputText($id, 'name', $field['name'], 40 ));

$smarty->assign('prompt_type', lang('type'));
$smarty->assign('type', $this->CreateInputDropdown($id, 'type' . ($disabled ? '_' : ''), $typelist, -1, $field['type'], 'id="fieldtype"' . $disabled) . ($disabled ? $this->CreateInputHidden($id, 'type', $field['type']) : ''));

$smarty->assign('prompt_maxlength', $this->Lang('maxlength'));
$smarty->assign('maxlength', $this->CreateInputText($id, 'maxlength', $field['type'] == 'textfield' ? $field['properties'] : '', 5, 5));

$smarty->assign('prompt_properties', $this->Lang('properties'));
$smarty->assign('help_properties', $this->Lang('properties_help1'));
$smarty->assign('properties', $this->CreateTextArea(FALSE, $id, $field['type'] == 'pulldown' || $field['type'] == 'radiobuttons' ? $field['properties'] : '', 'properties', '', '' , '' , '', 20, 6, '', '', 'style="width:20em; height:6em;"'));

$smarty->assign('prompt_parsesmarty', $this->Lang('parsesmarty'));
$smarty->assign('parsesmarty', $this->CreateInputCheckbox($id, 'parsesmarty', '1', $field['type'] == 'textarea' || $field['type'] == 'wysiwyg' ? $field['properties'] : ''));

$smarty->assign('prompt_help', lang('help'));
$smarty->assign('help', $this->CreateInputText($id, 'help', $field['help'], 80 ));

$smarty->assign('prompt_clearcache', $this->Lang('clearstylesheetcache'));
$smarty->assign('help_clearcache', $this->Lang('clearstylesheetcache_help'));
$smarty->assign('clearcache', $this->CreateInputCheckbox($id, 'clearcache', '1', $field['clearcache']));

$editorslist = array();
$disabled = '';
$groupops = $gCms->GetGroupOperations();
$groups = $groupops->LoadGroups();
foreach ($groups as $onegroup)
{
	$editorslist[lang('group') . ': ' . $onegroup->name] = $onegroup->id;
}
$selectededitors = explode(';', $field['editors']);
$smarty->assign('prompt_editors', lang('grouppermissions'));
$smarty->assign('editors', $this->CreateInputSelectList($id, 'editors[]', $editorslist, $selectededitors, 4, $disabled));

$fieldid = empty($params['fieldid']) ? -1 : $params['fieldid'];
$tabs = $this->GetTabs($fieldid);
if ( $params['mode'] == 'add' ) $tabs[0]['checked'] = 1; // select first tab by default
$tabslist = array();
foreach ($tabs as $tab)
{
	$tabslist[] = $this->CreateInputCheckbox($id, 'tabs[' . $tab['tabid'] . ']', '1', ($tab['checked'] !== NULL)) . $tab['name'];
}
$smarty->assign('prompt_tabs', $this->Lang('showontab'));
$smarty->assign('tabs', $tabslist);

$smarty->assign('submit', $this->CreateInputSubmit($id, 'submitbutton', lang('submit')));
$smarty->assign('cancel', $this->CreateInputSubmit($id, 'cancel', lang('cancel')));

$smarty->assign('formstart', $this->CreateFormStart($id, 'editfielddef', $returnid));
$smarty->assign('formend', $this->CreateFormEnd());

echo $this->ProcessTemplate('editfielddef.tpl');

?>