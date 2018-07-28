<?php
#-------------------------------------------------------------------------
# Module: CGGoogleMaps - A simple module for creating google maps.
# Version: 1.0, calguy1000 <calguy1000@hotmail.com>
#
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2005 by Ted Kulp (wishy@cmsmadesimple.org)
# This project's homepage is: http://www.cmsmadesimple.org
# The module's homepage is: http://dev.cmsmadesimple.org/projects/skeleton/
#
#-------------------------------------------------------------------------
#
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
#
#-------------------------------------------------------------------------
if( !isset($gCms) ) exit();
if( !$this->CheckPermission('Manage Map Locations') ) {
    echo $this->ShowErrors($this->Lang('error_permissiondenied'));
    return;
}
if( !isset($params['map_id']) ) {
    echo $this->ShowErrors($this->Lang('error_invalidparams'));
    return;
}
$map_id = (int)$params['map_id'];
$this->SetCurrentTab('maps');

// Get the details about the map
$query = 'SELECT * FROM '.cms_db_prefix().'module_cggooglemaps2 WHERE map_id = ?';
$mapinfo = $db->GetRow( $query, array( $map_id ) );
if( !$mapinfo ) {
    echo $this->ShowErrors($this->Lang('error_invalidparams'));
    return;
}

$smarty->assign('title',$this->Lang('edit_points_for_map',$mapinfo['name']));
$smarty->assign('mapinfo',cge_array::to_object($mapinfo));

// Get the list of points and send it to smarty
$query = 'SELECT * FROM '.cms_db_prefix().'module_cggooglemaps2_points WHERE map_id = ?';
$dbr = $db->Execute( $query, array( $map_id ) );

$pointlist = array();
while( $dbr && ($row = $dbr->FetchRow()) ) {
    $obj = cge_array::to_object($row);
    $obj->edit_url = $this->create_url($id,'admin_addmappoint',$returnid,array('map_id'=>$map_id,'marker_id'=>$obj->marker_id));
    $obj->edit_link = $this->CreateImageLink($id,'admin_addmappoint',$returnid,
					     $this->Lang('edit_map_point'),'icons/system/edit.gif',
					     array('map_id'=>$map_id,'marker_id'=>$obj->marker_id));
    $obj->delete_link = $this->CreateImageLink($id,'admin_deletemappoint',$returnid,
					     $this->Lang('delete_map_point'),'icons/system/delete.gif',
					     array('map_id'=>$map_id,'marker_id'=>$obj->marker_id));
    $pointlist[] = $obj;
}

// add items for the table to smarty
$smarty->assign('pointlist',$pointlist);
$smarty->assign('idtext',$this->Lang('id'));
$smarty->assign('nametext',$this->Lang('name'));
$smarty->assign('locationtext',$this->Lang('location'));

// Add the add point link
$smarty->assign('add_link',
		$this->CreateImageLink($id,'admin_addmappoint',$returnid,
				       $this->Lang('add_map_point'),
				       'icons/system/newobject.gif',
				       array('map_id'=>$map_id),'','',false));

// process the template
echo $this->ProcessTemplate('editmappoints.tpl');

// EOF
?>