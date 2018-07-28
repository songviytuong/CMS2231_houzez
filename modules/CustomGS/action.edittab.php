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
	$params = array('active_tab' => 'tabs');
	$this->Redirect($id, 'defaultadmin', '', $params);
}

if( !isset($params['mode']) )
{
	$params = array('module_error' => lang('missingparams'), 'active_tab' => 'tabs');
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
			if ( empty($params['name']) )
			{
				$params = array('module_error' => lang('missingparams'));
				$this->Redirect($id, 'edittab', '', $params);
				return;
			}
			// check if name already exists
			While ( $this->GetTab($params['name']) !== FALSE )
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
			$query = "SELECT MAX(sortorder) AS maxsortorder FROM ".cms_db_prefix()."module_customgs_tab";
			$result = $db->Execute($query);
			if( $result )
			{
				$tab = $result->FetchRow();
				$editors = empty($params['editors']) ? '' : implode(';', $params['editors']);
				
				// save tab
				$query = "INSERT INTO ".cms_db_prefix()."module_customgs_tab (name, sortorder, editors) VALUES (?,?,?)";
				$result = $db->Execute($query, array($params['name'], $tab['maxsortorder'] + 1, $editors));
			}
			if( isset($result) && $result )
			{
				// Put mention into the admin log
				audit($db->Insert_ID(), 'Custom Global Settings - Tab', 'Added: ' . $params['name']);
				$params = array('tab_message'=> 'tabadded', 'active_tab' => 'tabs');
			}
			else
			{
				$params = array('module_error'=> 'updatefailed', 'active_tab' => 'tabs');
			}

			$this->Redirect($id, 'defaultadmin', '', $params);
		}
		$tab = array('name' => '', 'editors' => '');
		$smarty->assign('title',lang('add'));
		$smarty->assign('hidden', $this->CreateInputHidden($id, 'mode', 'add'));
		break;


	case 'delete':
		if( !is_numeric($params['tabid']) )
		{
			$params = array('module_error' => lang('missingparams'), 'active_tab' => 'tabs');
			$this->Redirect($id, 'defaultadmin', '', $params);
			return;
		}
		
		$tab = $this->GetTab($params['tabid']);
		if( $tab === FALSE )
		{
			$params = array('module_error'=> 'updatefailed', 'active_tab' => 'tabs');
			$this->Redirect($id, 'defaultadmin', '', $params);
		}
		$query = "DELETE FROM " . cms_db_prefix() . "module_customgs_tab WHERE tabid = ?";
		$db->Execute($query, array($params['tabid']));
		$query = "DELETE FROM " . cms_db_prefix() . "module_customgs_tabfield WHERE tabid = ?";
		$db->Execute($query, array($params['tabid']));
		// Put mention into the admin log
		audit($params['tabid'], 'Custom Global Settings - Tab', 'Deleted: ' . $tab['name']);

		// update the sortorder
		$query = "UPDATE " . cms_db_prefix() . "module_customgs_tab SET sortorder = sortorder - 1 WHERE sortorder > ?";
		$result = $db->Execute($query, array($tab['sortorder']));

		$params = array('tab_message'=> 'tabupdated', 'active_tab' => 'tabs');
		$this->Redirect($id, 'defaultadmin', '', $params);
		break;


	case 'edit':
		if( !is_numeric($params['tabid']) )
		{
			$params = array('module_error' => lang('missingparams'), 'active_tab' => 'tabs');
			$this->Redirect($id, 'defaultadmin', '', $params);
			return;
		}

		$tab = $this->GetTab($params['tabid']);

		if( $_SERVER['REQUEST_METHOD'] == 'POST' )
		{
			// check if name is empty
			if ( empty($params['name']) )
			{
				$params = array('module_error' => lang('missingparams'));
				$this->Redirect($id, 'edittab', '', $params);
				return;
			}
			// check if name already exists
			$checktabname = $this->GetTab($params['name']);
			While ( $checktabname !== FALSE && $params['tabid'] != $checktabname['tabid'] )
			{
				if ( is_numeric(substr($params['name'], -1)) )
				{
					$params['name'] = is_numeric(substr($params['name'], -2)) ? substr($params['name'],0 , -2) . (substr($params['name'], -2) + 1) : substr($params['name'],0 , -1) . (substr($params['name'], -1) + 1);
				}
				else
				{
					$params['name'] .= "1";
				}
				$checktabname = $this->GetTab($params['name']);
			}
			$editors = empty($params['editors']) ? '' : implode(';', $params['editors']);

			// save tab
			$query = "UPDATE " . cms_db_prefix() . "module_customgs_tab SET name = ?, editors = ? WHERE tabid = ?";
			$result = $db->Execute($query, array($params['name'], $editors, $params['tabid']));

			// Put mention into the admin log
			audit($params['tabid'], 'Custom Global Settings - Tab', 'Edited: ' . $params['name']);

			$params = array('tab_message'=> 'tabupdated', 'active_tab' => 'tabs');
			$this->Redirect($id, 'defaultadmin', '', $params);
		}

		$smarty->assign('title',lang('edit'));
		$smarty->assign('hidden', $this->CreateInputHidden($id, 'tabid', $params['tabid']) .
						$this->CreateInputHidden($id, 'mode', 'edit'));
		break;


	case 'moveup':
	case 'movedown':
		$tab = $this->GetTab($params['tabid']);
		if( $tab === FALSE )		 
		{
			$params = array('module_error'=> 'updatefailed', 'active_tab' => 'tabs');
			$this->Redirect($id, 'defaultadmin', '', $params);
		}

		$query = "UPDATE " . cms_db_prefix() . "module_customgs_tab SET sortorder = " . ($params['mode'] == 'moveup' ? 'sortorder + 1' : 'sortorder - 1') . " WHERE sortorder = ?";
		$result = $db->Execute($query, array($params['mode'] == 'moveup' ? $tab['sortorder'] - 1 : $tab['sortorder'] + 1));

		$query = "UPDATE " . cms_db_prefix() . "module_customgs_tab SET sortorder = " . ($params['mode'] == 'moveup' ? 'sortorder - 1' : 'sortorder + 1') . " WHERE tabid = ?";
		$result = $db->Execute($query, array($params['tabid']));

		$params = array('active_tab' => 'tabs');
		$this->Redirect($id, 'defaultadmin', '', $params);
		break;

		
	case 'sort':
		if ( !empty($params['sortseq']) )
		{
			$sortseq = str_replace('i', '', $params['sortseq']);
			$sortentries = explode(',', $sortseq);
			foreach ( $sortentries as $key => $tabid )
			{
				$query = "UPDATE " . cms_db_prefix() . "module_customgs_tab SET sortorder = ? WHERE tabid = ?";
				$db->Execute($query, array($key + 1, $tabid));
			}
		}
		exit();
		break;

}


$smarty->assign('prompt_name', lang('name'));
$smarty->assign('name', $this->CreateInputText($id, 'name', $tab['name'], 40 ));

$editorslist = array();
$disabled = '';
$groupops = $gCms->GetGroupOperations();
$groups = $groupops->LoadGroups();
foreach ($groups as $onegroup)
{
	//if( $onegroup->id == 1 ) continue;
	$editorslist[lang('group') . ': ' . $onegroup->name] = $onegroup->id;
}
$selectededitors = explode(';', $tab['editors']);
$smarty->assign('prompt_editors', lang('grouppermissions'));
$smarty->assign('editors', $this->CreateInputSelectList($id, 'editors[]', $editorslist, $selectededitors, 4, $disabled));

$smarty->assign('submit', $this->CreateInputSubmit($id, 'submitbutton', lang('submit')));
$smarty->assign('cancel', $this->CreateInputSubmit($id, 'cancel', lang('cancel')));

$smarty->assign('formstart', $this->CreateFormStart($id, 'edittab', $returnid));
$smarty->assign('formend', $this->CreateFormEnd());

echo $this->ProcessTemplate('edittab.tpl');

?>