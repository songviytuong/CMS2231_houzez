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
if( !isset($gCms) ) exit;
if( !$this->CheckPermission('Manage Maps') ) return;

$maplist = array();
$query = 'SELECT * FROM '.cms_db_prefix().'module_cggooglemaps2';
$dbr = $db->Execute( $query );
$dflt_map = $this->GetPreference('default_map',0);
while( $dbr && ($row = $dbr->FetchRow() ) ) {
  $obj = cge_array::to_object($row);
  if( $this->CheckPermission('Manage Maps') ) {
    if( $obj->map_id != $dflt_map ) {
      $obj->delete_link = $this->CreateImageLink($id,'admin_deletemap',$returnid,
						 $this->Lang('delete_map'),
						 'icons/system/delete.gif',
						 array('map_id'=>$obj->map_id));
    }
    else {
      $obj->delete_link = '&nbsp;';
    }
    $obj->edit_url = $this->CreateURL($id,'admin_add_map',$returnid, array('map_id'=>$obj->map_id));
    $obj->edit_link = $this->CreateImageLink($id,'admin_add_map',$returnid, $this->Lang('edit_map'),
						 'icons/system/edit.gif', array('map_id'=>$obj->map_id));
    if( $obj->map_id != $dflt_map ) {
      $obj->default_link = $this->CreateImageLink($id,'admin_setdfltmap',$returnid,
						  $this->Lang('set_dflt_map'),
						  'icons/system/false.gif',
						  array('map_id'=>$obj->map_id));
    }
    else {
      $obj->default_link = $this->DisplayImage('icons/system/true.gif','systemicon');
    }
  }
    
  if( $this->CheckPermission('Manage Map Locations') ) {
    $obj->points_link = $this->CreateImageLink($id,'admin_editmappoints',
					       $returnid,
					       $this->Lang('edit_map_points'),
					       'dd-end-small.png',
					       array('map_id'=>$obj->map_id));
  }

  $maplist[] = $obj;
}

$smarty->assign('idtext',$this->Lang('id'));
$smarty->assign('nametext',$this->Lang('name'));
$smarty->assign('defaulttext',$this->Lang('default'));
$smarty->assign('maplist',$maplist);
$smarty->assign('add_link',
		$this->CreateImageLink($id,'admin_add_map',$returnid,
				       $this->Lang('add_map'),
				       'icons/system/newobject.gif',
				       array(),'','',false));

echo $this->ProcessTemplate('maps_tab.tpl');
// EOF
?>