<?php
#CMS - CMS Made Simple
#(c)2004 by Ted Kulp (ted@cmsmadesimple.org)
#Visit our homepage at: http://www.cmsmadesimple.org
#
#This program is free software; you can redistribute it and/or modify
#it under the terms of the GNU General Public License as published by
#the Free Software Foundation; either version 2 of the License, or
#(at your option) any later version.
#
#This program is distributed in the hope that it will be useful,
#but WITHOUT ANY WARRANTY; without even the implied warranty of
#MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#GNU General Public License for more details.
#You should have received a copy of the GNU General Public License
#along with this program; if not, write to the Free Software
#Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
#
if (!isset($gCms)) exit;

tinymce_utils::clear_tinymce_cache();

$db = $this->GetDb();
$dict = NewDataDictionary( $db );


$sqlarray = $dict->DropTableSQL( CMS_DB_PREFIX.TinyMCE::TINYMCE_PROFILES_TABLE);
$dict->ExecuteSQLArray($sqlarray);

$sqlarray = $dict->DropTableSQL( CMS_DB_PREFIX.TinyMCE::TINYMCE_PROFILEGROUP_TABLE);
$dict->ExecuteSQLArray($sqlarray);


$this->RemovePermission('Manage TinyMCE profiles');
$this->RemovePreference();


$this->DeleteTemplate();

#
# EOF
#
?>
