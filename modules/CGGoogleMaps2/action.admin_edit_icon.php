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
$this->SetCurrentTab('icons');

#
# Initialization
#
$iconid = -1;
$error = '';
$icon_data = array();
$icon_data['name'] = '';
$icon_data['url'] = '';
$icon_data['anchor_x'] = '';
$icon_data['anchor_y'] = '';

#
# Setup
#
if( isset($params['icon']) ) {
  // we must be editing
  $iconid = (int)$params['icon'];
}
else {
  // adding a new icon.
  $params['icon'] = $iconid;
}



#
# Get The Data
#
if( $iconid >= 0 ) {
  $query = 'SELECT * FROM '.cms_db_prefix().'module_cggooglemaps2_icons
            WHERE id = ?';
  $icon_data = $db->GetRow($query,array($iconid));
  if( !$icon_data ) {
    $this->SetError($this->Lang('error_notfound'));
    $this->RedirectToTab($id);
  }
}

#
# Handle Form Submission
#
if( isset($params['cancel']) ) {
  $this->RedirectToTab($id);
}
else if( isset($params['submit']) ) {
  if( !isset($params['name']) || trim($params['name']) == '' ) $error = $this->Lang('error_invalidparams');
  $icon_data['name'] = trim($params['name']);

  if( !isset($params['url']) || trim($params['url']) == '' ) $error = $this->Lang('error_invalidparams');
  $icon_data['url'] = trim($params['url']);

  $icon_data['anchor_x'] = (int)$params['anchor_x'];
  $icon_data['anchor_y'] = (int)$params['anchor_y'];
  $icon_data['info_anchor_x'] = (int)$params['info_anchor_x'];
  $icon_data['info_anchor_y'] = (int)$params['info_anchor_y'];

  if( empty($error) ) {
    // Check for a duplicate name
    $query = 'SELECT id FROM '.cms_db_prefix().'module_cggooglemaps2_icons WHERE name = ? AND id != ?';
    $tmp = $db->GetOne($query,array($icon_data['name'],$iconid));
    if( $tmp ) $error = $this->Lang('error_nameexists');
  }

  if( empty($error) ) {
    if( $iconid > 0 ) {
      // do the update
      $query = 'UPDATE '.cms_db_prefix().'module_cggooglemaps2_icons
                SET name = ?, url = ?, anchor_x = ?, anchor_y = ?
                WHERE id = ?';
      $db->Execute($query,array($icon_data['name'],
				$icon_data['url'],
				$icon_data['anchor_x'],
				$icon_data['anchor_y'],
				$iconid));
    }
    else {
      // do the insert
      $query = 'INSERT INTO '.cms_db_prefix().'module_cggooglemaps2_icons
                (name, url, anchor_x, anchor_y) VALUES (?,?,?,?)';
      $db->Execute($query,array($icon_data['name'],
				$icon_data['url'],
				$icon_data['anchor_x'],
				$icon_data['anchor_y']));
    }

    // all done
    $this->SetMessage($this->Lang('msg_icon_updated'));
    $this->RedirectToTab($id);
  }
}


# 
# Give Everything to Smarty
#
$smarty->assign('formstart',$this->CGCreateFormStart($id,'admin_edit_icon',$returnid,$params));
$smarty->assign('formend',$this->CreateFormEnd());
$smarty->assign('icon_data',$icon_data);

#
# Process The Template
#
echo $this->ProcessTemplate('admin_edit_icon.tpl');
// EOF
?>