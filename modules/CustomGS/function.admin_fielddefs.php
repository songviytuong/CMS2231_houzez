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

$trueimage = $admintheme->DisplayImage('icons/system/true.gif', lang('active'), '', '', 'systemicon');
$falseimage = $admintheme->DisplayImage('icons/system/false.gif', lang('inactive'), '', '', 'systemicon');

$tabs = $this->GetTabs(-1);
$tabid = empty($params['tabid']) ? $tabs[0]['tabid'] : $params['tabid'];

if ( count($tabs) > 1 )
{
	// create tab dropdownfield
	foreach ( $tabs as $tab ) 
	{
		$label = $tab['name'];
		$tablist[$label] = $tab['tabid'];
	}
	$smarty->assign('tabselect', $this->CreateInputDropdown($id, 'tabselect', $tablist, -1, $tabid, 'id="' . $id . 'tabselect"'));
	$smarty->assign('tabselectjs', '
		$(\'#' . $id . 'tabselect\').change( function() {
			location.href = "' . str_replace('&amp;','&',$this->CreateLink($id, 'defaultadmin', $returnid, '', array('active_tab' => 'fielddefs'), '', true))  . '&' . $id . 'tabid="+$(this).val();
		});
');
}
else
{
	$smarty->assign('tabselect', lang('status'));
	$smarty->assign('tabselectjs', '');
}

$rowarray = array();

$db = $this->GetDB();
$query = "SELECT
						f.*, tf.tabid AS checked
					FROM
						" . cms_db_prefix() . "module_customgs f
					LEFT JOIN
						" . cms_db_prefix() . "module_customgs_tabfield tf
					ON
						f.fieldid = tf.fieldid AND tf.tabid = ?
					ORDER BY
						f.sortorder ASC";

$result = $db->GetAll($query, array($tabid));
$rowcount = count($result);

if ( $result && $rowcount > 0 )
{
	$rowclass = 'row1';
	foreach ( $result as $key => $def )
	{
		$row = new StdClass();
		$row->fieldid = $def['fieldid'];
		$row->name = $def['type'] == 'fieldsetend' ? $def['name'] : $this->CreateLink($id, 'editfielddef', $returnid, $def['name'], array('fieldid' => $def['fieldid'], 'mode'=>'edit'));
		$alias = str_replace('__', '_', str_replace('-', '_', munge_string_to_url($def['name'])));
		$row->smartyvar = '';	
		if ( $def['type'] != 'fieldsetstart' && $def['type'] != 'fieldsetend' )
		{
			$row->smartyvar = '{$CustomGS.' . $alias . '}';			
		}
		//$row->help = $def['help'];
		$row->type = $this->Lang($def['type']);
		switch ($def['type']) 
		{
			case 'corefilepicker':
				if ( $corefp = cms_utils::get_module('FilePicker') )
				{
					$row->type = $corefp->GetFriendlyName();
				}
				else
				{
					$row->type = 'CMSMS FilePicker (' . lang('notinstalled') . ')';
				}
				break;
			
			case 'gbfilepicker':
				if ( $gbfp = cms_utils::get_module('GBFilePicker') )
				{
					$row->type = $gbfp->GetFriendlyName();
				}
				else
				{
					$row->type = 'GBFilePicker (' . lang('notinstalled') . ')';
				}
				break;
				
			case 'jmfilepicker':
				if ( $jmfp = cms_utils::get_module('JMFilePicker') )
				{
					$row->type = $jmfp->GetFriendlyName();
				}
				else
				{
					$row->type = 'JMFilePicker (' . lang('notinstalled') . ')';
				}
				break;
				
		}
		
		if ( $def['sortorder'] > 1 )
		{
			$row->moveup = $this->CreateLink($id, 'editfielddef', $returnid, $admintheme->DisplayImage('icons/system/arrow-u.gif', lang('up'),'','','systemicon'), array('fieldid' => $def['fieldid'], 'mode'=>'moveup'));
		}
		else
		{
			$row->moveup = '';
		}
		
		if ( $key < $rowcount - 1 && $result[$key+1]['sortorder'] != 1 )
		{
			$row->movedown = $this->CreateLink($id, 'editfielddef', $returnid, $admintheme->DisplayImage('icons/system/arrow-d.gif', lang('down'),'','','systemicon'), array('fieldid' => $def['fieldid'], 'mode'=>'movedown'));
		}
		else
		{
			$row->movedown = '';
		}
		
		$row->assigntab = '';
		$row->editlink = '';
		$row->copylink = '';
		$row->deletelink = '';
		if ( $def['type'] != 'fieldsetend' )
		{
			$row->assigntab = '<a href="' . 
					html_entity_decode($this->create_url($id, 'editfielddef', $returnid, 
					array('mode' => 'assign', 'tabid' => $tabid, 'fieldid' => $def['fieldid']))) . 
					'&showtemplate=false" class="assigntab">' . ($def['checked'] ? $trueimage : $falseimage) . '</a>';
			$row->copylink = $this->CreateLink($id, 'editfielddef', $returnid,
				    $admintheme->DisplayImage('icons/system/copy.gif', lang('copy'), '', '', 'systemicon'),
				    array ('fieldid' => $def['fieldid'], 'mode'=>'copy'));
                        $row->editlink = $this->CreateLink($id, 'editfielddef', $returnid,
				    $admintheme->DisplayImage('icons/system/edit.gif', lang('edit'), '', '', 'systemicon'),
				    array ('fieldid' => $def['fieldid'], 'mode'=>'edit'));
			$row->deletelink = $this->CreateLink($id, 'editfielddef', $returnid,
					  $admintheme->DisplayImage('icons/system/delete.gif', lang('delete'), '', '', 'systemicon'),
					  array ('fieldid' => $def['fieldid'], 'mode'=>'delete'), lang('deleteconfirm',$def['name']));
		}

		array_push ($rowarray, $row);
	}
}
if ( $result === FALSE )
{
	echo 'ERROR: ' . mysql_error();
	exit();
}


$smarty->assign('items', $rowarray );
$smarty->assign('name', lang('name'));
$smarty->assign('smartyvar', $this->Lang('smartyvar'));
$smarty->assign('type', lang('type'));
//$smarty->assign('help', lang('help'));

$smarty->assign('newfielddeflink',
	  $this->CreateLink($id, 'editfielddef', $returnid,
			     $admintheme->DisplayImage('icons/system/newfolder.gif', lang('add'),'','','systemicon'),
			     array('mode' => 'add'), '', false, false, '').' '.

	  $this->CreateLink($id, 'editfielddef', $returnid,
			     lang('add'),
			     array('mode' => 'add')));

$smarty->assign('showontab', $this->Lang('showontab'));
$smarty->assign('trueimage',$trueimage);
$smarty->assign('falseimage',$falseimage);

$smarty->assign('formstart', $this->CreateFormStart ($id, 'editfielddef', $returnid, 'post'));
$smarty->assign('formend',$this->CreateFormEnd());

$smarty->assign('submit', $this->CreateInputSubmit($id, 'submit', lang('submit')));
$smarty->assign('cancel', $this->CreateInputSubmit($id, 'cancel', lang('cancel')));

$smarty->assign('mod_id', $id);
$smarty->assign('ajax_url', html_entity_decode($this->create_url($id, 'editfielddef', $returnid, array('mode' => 'sort'))));
$smarty->assign('refresh_url', html_entity_decode($this->create_url($id, 'defaultadmin', $returnid)));

echo $this->ProcessTemplate('admin_fielddefs.tpl');

?>