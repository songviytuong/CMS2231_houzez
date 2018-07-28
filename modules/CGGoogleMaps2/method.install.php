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
if (!isset($gCms)) exit;

if( version_compare(phpversion(),'5.4.3') < 0 ) {
    return "Minimum PHP version of 5.4.3 required";
}

// mysql-specific, but ignored by other database
$taboptarray = array('mysql' => 'TYPE=MyISAM');

$dict = NewDataDictionary($db);

// table schema description
$flds = "
	map_id I AUTO KEY,
        name C(80) KEY NOTNULL,
        data X,
        owner_id I
        ";
$sqlarray = $dict->CreateTableSQL(cms_db_prefix()."module_cggooglemaps2", $flds, $taboptarray);
$dict->ExecuteSQLArray($sqlarray);

//index for maps
$sqlarray = $dict->CreateIndexSQL('i_name', cms_db_prefix()."module_cggooglemaps2", 'name');

// Markers
$flds = "
        marker_id I AUTO KEY,
        map_id I,
        name C(80),
        info X,
        tooltip X,
        address C(255),
        lat C(100),
        lon C(100),
        icon C(100)
        ";
$sqlarray = $dict->CreateTableSQL(cms_db_prefix()."module_cggooglemaps2_points", $flds, $taboptarray);
$dict->ExecuteSQLArray($sqlarray);
// create a sequence

// Cache
$flds = "
        address C(255) KEY DEFAULT '',
        lon F,
        lat F
        ";
$sqlarray = $dict->CreateTableSQL(cms_db_prefix()."module_cggooglemaps2_cache", $flds, $taboptarray);
$dict->ExecuteSQLArray($sqlarray);

// Icons
$flds = "
        id I KEY AUTO,
        name C(20) NOT NULL,
        url  C(255) NOT NULL,
        anchor_x I,
        anchor_y I
        ";
// info_anchor_x and info_anchor_y are no longer used.
$sqlarray = $dict->CreateTableSQL(cms_db_prefix()."module_cggooglemaps2_icons", $flds, $taboptarray);
$dict->ExecuteSQLArray($sqlarray);

// Create some original icons
$query = 'INSERT INTO '.cms_db_prefix().'module_cggooglemaps2_icons (name,url, anchor_x, anchor_y) VALUES (?,?,?,?)';
$path = __DIR__.'/icons/';
$urlbase = 'modules/'.$this->GetName().'/icons/';
$icons = glob($path.'/*png');
$icons = get_matching_files($path,'png');
foreach( $icons as $one ) {
  $res = getimagesize($path.'/'.$one);
  $one = basename($one);
  if( $res !== FALSE ) {
    $name = substr($one,0,strlen($one)-4);
    $db->Execute($query,array($name,$urlbase.$one,(int)$res[0]/2,(int)$res[1]/2));
  }
}

# Permissions
$this->CreatePermission('Manage Maps','Manage Maps');
$this->CreatePermission('Manage Map Locations','Manage Map Locations');

# Preferences
$this->SetPreference('default_marker','dd-end');
// EOF
?>