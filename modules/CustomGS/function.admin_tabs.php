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


$rowarray = array();

$rows = $this->GetTabs();
$rowcount = count($rows);

if ( !empty($rows) && $rowcount > 0 )
{
	$rowclass = 'row1';
	foreach ( $rows as $key => $item )
	{
		$row = new StdClass();
		$row->tabid = $item['tabid'];
		$row->name = $this->CreateLink($id, 'edittab', $returnid, $item['name'], array('tabid' => $item['tabid'], 'mode'=>'edit'));
		
		if ( $item['sortorder'] > 1 )
		{
			$row->moveup = $this->CreateLink($id, 'edittab', $returnid, $admintheme->DisplayImage('icons/system/arrow-u.gif', lang('up'),'','','systemicon'), array('tabid' => $item['tabid'], 'mode'=>'moveup'));
		}
		else
		{
			$row->moveup = '';
		}
		
		if ( $key < $rowcount - 1 && $rows[$key+1]['sortorder'] != 1 )
		{
			$row->movedown = $this->CreateLink($id, 'edittab', $returnid, $admintheme->DisplayImage('icons/system/arrow-d.gif', lang('down'),'','','systemicon'), array('tabid' => $item['tabid'], 'mode'=>'movedown'));
		}
		else
		{
			$row->movedown = '';
		}
		
		$row->editlink = $this->CreateLink($id, 'edittab', $returnid,
							$admintheme->DisplayImage('icons/system/edit.gif', lang ('edit'), '', '', 'systemicon'),
							array ('tabid' => $item['tabid'], 'mode'=>'edit'));
		$row->deletelink = $rowcount > 1 ? $this->CreateLink($id, 'edittab', $returnid,
							$admintheme->DisplayImage('icons/system/delete.gif', lang ('delete'), '', '', 'systemicon'),
							array ('tabid' => $item['tabid'], 'mode'=>'delete'), lang ('deleteconfirm',$item['name']))
							: '';

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

$smarty->assign('newtablink',
	  $this->CreateLink($id, 'edittab', $returnid,
			     $admintheme->DisplayImage('icons/system/newfolder.gif', lang('add'),'','','systemicon'),
			     array('mode' => 'add'), '', false, false, '').' '.

	  $this->CreateLink($id, 'edittab', $returnid,
			     lang('add'),
			     array('mode' => 'add')));

$smarty->assign('formstart', $this->CreateFormStart ($id, 'edittab', $returnid, 'post'));
$smarty->assign('formend',$this->CreateFormEnd());

$smarty->assign('submit', $this->CreateInputSubmit($id, 'submit', lang('submit')));
$smarty->assign('cancel', $this->CreateInputSubmit($id, 'cancel', lang ('cancel')));

$smarty->assign('mod_id', $id);
$smarty->assign('ajax_url', html_entity_decode($this->create_url($id, 'edittab', $returnid, array('mode' => 'sort'))));

echo $this->ProcessTemplate('admin_tabs.tpl');

?>