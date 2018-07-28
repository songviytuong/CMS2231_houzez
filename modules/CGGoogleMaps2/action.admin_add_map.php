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
if( !$this->CheckPermission('Manage Maps') ) return;
$this->SetCurrentTab('maps');

$map = new cggm2_map;

if( isset($params['map_id'] ) ) $map = cggm2_map_operations::load_by_id($params['map_id']);
if( isset($params['cancel']) ) $this->RedirectToTab($id);

if( isset($params['edit_map_points']) && isset($params['map_id']) ) {
  $this->Redirect($id,'admin_editmappoints',$returnid,array('map_id'=>$params['map_id']));
}
if( isset($params['reset_map_template']) ) {
  cggm2_map_operations::update_from_formdata($map,$params);
  $map->set_map_template($params['map_template']);

  $this->SetCurrentTab('map template');
  $file = __DIR__.'/templates/orig_map_template.tpl';
  $map->set_map_template(@file_get_contents($file));
}
if( isset($params['reset_directions_template']) ) {
  cggm2_map_operations::update_from_formdata($map,$params);
  $map->set_directions_template($params['directions_template']);

  $this->SetCurrentTab('directions template');
  $file = __DIR__.'/templates/orig_directions_template.tpl';
  $map->set_directions_template(@file_get_contents($file));
}
else if( isset($params['submit']) || isset($params['apply']) ) {
  cggm2_map_operations::update_from_formdata($map,$params);
  $map->set_map_template($params['map_template']);
  $map->set_directions_template($params['directions_template']);

  // make sure that height, width, and name are specified
  if( $map->get_name() == '' ) {
    echo $this->ShowErrors($this->Lang('error_invalidparams'));
  }
  else {
    $res = $map->save();
    // todo, check for errors.
  }

  if( isset($params['submit']) ) {
    // redirect
    $this->RedirectToTab($id);
  }
}


//
// display the map form
//
$smarty->assign('map',$map);
$smarty->assign('formstart',$this->CGCreateFormStart($id,'admin_add_map',$returnid));
if( isset($params['map_id']) ) $smarty->assign('hidden',$this->CreateInputHidden($id,'map_id',$params['map_id']));
$smarty->assign('formend',$this->CreateFormEnd());
$smarty->assign('prompt_name',$this->Lang('map_name'));
$smarty->assign('input_name',$this->CreateInputText($id,'name',$map->get_name(),40,80));
$smarty->assign('input_description',$this->CreateTextArea(true,$id,$map->description,'description'));

$query = 'SELECT name,url FROM '.cms_db_prefix().'module_cggooglemaps2_icons ORDER BY name';
$tmp = $db->GetArray($query);
$all_icons = array();
$iconsbyname = array();
for( $i = 0; $i < count($tmp); $i++ ) {
  $row = $tmp[$i];
  $all_icons[$row['name']] = $row['url'];
  $iconsbyname[$row['name']] = $row['name'];
}
$smarty->assign('iconsbyname',$iconsbyname);
$smarty->assign('all_icons',$all_icons);

$field_tabs = array();
$fields = array();
foreach( $map->get_fields() as $key => $rec ) {
  $rec['value'] = $map->$key;
  $tab = 'basics';
  if( isset($rec['tab']) ) $tab = $rec['tab'];
  if( !in_array($tab,$field_tabs) ) $field_tabs[] = $tab;

  if( !isset($fields[$tab]) ) $fields[$tab] = array();
  $fields[$tab][$key] = $rec;
}
if( !in_array('map template',$field_tabs) ) $field_tabs[] = 'map template';
$fields['map template']['map_template'] = array(
  'prompt_key'=>'map_template',
  'type'=>'TEXTAREA',
  'wysiwyg'=>0,
  'value'=>$map->get_map_template(),
  'extrafields'=>array('reset_map_template' => array('type'=>'BUTTON',
						     'name'=>'reset_map_template',
						     'value'=>$this->Lang('reset')))
);

if( !in_array('directions template',$field_tabs) ) $field_tabs[] = 'directions template';
$fields['directions template']['directions_template'] = array(
  'prompt_key'=>'directions_template',
  'type'=>'TEXTAREA',
  'wysiwyg'=>0,
  'value'=>$map->get_directions_template(),
  'extrafields'=>array('reset_directions_template' => array('type'=>'BUTTON',
						     'name'=>'reset_directions_template',
						     'value'=>$this->Lang('reset')))
);

$smarty->assign('fields',$fields);
$smarty->assign('field_tabs',$field_tabs);

echo $this->ProcessTemplate('add_map.tpl');
// EOF
?>