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
if( !$this->CheckPermission('Manage Map Locations') )
  {
    echo $this->ShowErrors($this->Lang('error_permissiondenied'));
    return;
  }
if( !isset($params['map_id']) )
  {
    echo $this->ShowErrors($this->Lang('error_invalidparams'));
    return;
  }
$map_id = (int)$params['map_id'];
if( !isset($params['marker_id']) )
  {
    echo $this->ShowErrors($this->Lang('error_invalidparams'));
    return;
  }
$marker_id = (int)$params['marker_id'];

$query = 'DELETE FROM '.cms_db_prefix().'module_cggooglemaps2_points
           WHERE marker_id = ? AND map_id = ?';
$db->Execute( $query, array( $marker_id, $map_id ) );

$this->Redirect($id,'admin_editmappoints',$returnid,array('map_id'=>$map_id));
// EOF
?>