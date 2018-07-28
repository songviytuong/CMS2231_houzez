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
if( !$this->CheckPermission('Manage Map Locations') ) return;
if( !isset($params['map_id']) ) {
  echo $this->ShowErrors($this->Lang('error_invalidparams'));
  return;
}
$map_id = (int)$params['map_id'];

#
# Setup
#
$query = 'SELECT name,url FROM '.cms_db_prefix().'module_cggooglemaps2_icons ORDER BY name';
$tmp = $db->GetArray($query);
$icons = array();
$iconsbyname = array();
if( is_array($tmp) ) {
  for( $i = 0; $i < count($tmp); $i++ ) {
    $icons[$tmp[$i]['name']] = $tmp[$i]['name'];
    $iconsbyname[$tmp[$i]['name']] = $tmp[$i]['url'];
  }
}

// Get the details about the map
$map = cggm2_map_operations::load_by_id($map_id,true);
if( !$map ) {
  echo $this->ShowErrors($this->Lang('error_invalidparams'));
  return;
}

// default variables
$marker = new cggm2_marker;
$marker->set_icon($this->GetPreference('default_marker'));

if( isset($params['marker_id']) ) {
  $marker = $map->get_marker_by_id((int)$params['marker_id']);
  if( !$marker ) {
    echo $this->ShowErrors($this->Lang('error_invalidparams'));
    return;
  }
}


// handle form actions
if( isset($params['cancel']) ) {
    $this->Redirect($id,'admin_editmappoints',$returnid,array('map_id'=>$map_id));
    return;
}
else if( isset($params['submit']) ) {
    //
    // handle the submit
    //
    $marker = cggm2_marker_operations::load_marker_from_data($params);

    if( $marker->get_title() == '' || $marker->get_icon() == '' ||
        ($marker->get_address() == '' && ($marker->get_latitude() == '' || $marker->get_longitude() == '' )) ) {
        echo $this->ShowErrors($this->Lang('error_invalidparams'));
    }
    else {
        // map info is valid
        $marker->set_map_id($map->get_id());
        if( isset($params['marker_id']) ) $marker->set_marker_id($params['marker_id']);
        $res = $marker->save();
        if( !$res ) {
            echo "DEBUG: error = ".$db->ErrorMsg().'<br/>'.$db->sql;
            die();
        }

        $this->Redirect($id,'admin_editmappoints',$returnid,array('map_id'=>$map_id));
    }
}

// build the form
if( isset($params['marker_id']) ) $smarty->assign('hidden',$this->CreateInputHidden($id,'marker_id',$params['marker_id']));
if( count($icons) ) {
  $smarty->assign('icons',$icons);
  $smarty->assign('iconsbyname',$iconsbyname);
  $smarty->assign('sel_icon',$marker->get_icon());
}

$smarty->assign('marker',$marker);
$address = $marker->get_address();
if( $address || $marker->get_marker_id() < 1 ) $smarty->assign('point_address',$address);
$smarty->assign('formstart',$this->CGCreateFormStart($id,'admin_addmappoint',$returnid,array('map_id'=>$map_id)));
$smarty->assign('formend',$this->CreateFormEnd());
$smarty->assign('title',$this->Lang('add_point_for_map',$map->get_name()));

// process the template
echo $this->ProcessTemplate('addmappoint.tpl');

// EOF
?>