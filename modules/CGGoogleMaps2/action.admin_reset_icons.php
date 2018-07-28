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

# Delete existing icons
$query = 'DELETE FROM '.cms_db_prefix().'module_cggooglemaps2_icons';
$db->Execute($query);

# Add New ones
$query = 'INSERT INTO '.cms_db_prefix().'module_cggooglemaps2_icons (name,url, anchor_x, anchor_y) VALUES (?,?,?,?)';
$path = __DIR__.'/icons/';
$urlbase = 'modules/'.$this->GetName().'/icons/';
$icons = get_matching_files($path,'png');
foreach( $icons as $one ) {
  $res = getimagesize($path.'/'.$one);
  if( $res !== FALSE ) {
    $name = substr($one,0,strlen($one)-4);
    $db->Execute($query,array($name,$urlbase.$one,(int)$res[0]/2,(int)$res[1]/2));
  }
}

$this->SetMessage($this->Lang('msg_icons_reset'));
$this->RedirectToTab($id);

// EOF
?>