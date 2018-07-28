<?php
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: CGContentUtils (c) 2009 by Robert Campbell
#         (calguy1000@cmsmadesimple.org)
#  An addon module for CMS Made Simple to provide various additional utilities
#  for dealing with content pages.
#
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2005 by Ted Kulp (wishy@cmsmadesimple.org)
# This project's homepage is: http://www.cmsmadesimple.org
#
#-------------------------------------------------------------------------
#
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# However, as a special exception to the GPL, this software is distributed
# as an addon module to CMS Made Simple.  You may not use this software
# in any Non GPL version of CMS Made simple, or in any version of CMS
# Made simple that does not indicate clearly and obviously in its admin
# section that the site was built with CMS Made simple.
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
#END_LICENSE
if( !isset($gCms) ) exit();

/*
$obj = new \CGExtensions\cge_content_list_builder(array('parent'=>24,'show_navhidden'=>TRUE));
$out = $obj->get_options();
debug_display($out); die();
*/

echo $this->StartTabHeaders();
if( $this->CheckPermission('Modify Templates') ) {
   echo $this->SetTabHeader('blocks',$this->Lang('blocks'));
}
if( $this->CheckPermission('Manage All Content') && $this->CheckPermission('Calguys Content Utilities') ) {
  echo $this->SetTabHeader('import',$this->Lang('import_content'));
}
if( $this->CheckPermission('Manage All Content') && $this->CheckPermission('Calguys Content Utilities') ) {
  echo $this->SetTabHeader('export',$this->Lang('export_content'));
}
if( $this->CheckPermission('Modify Templates') || $this->CheckPermission('Modify User-defined Tags') ||
    $this->CheckPermission('Modify Global Content Blocks') ) {
  echo $this->SetTabHeader('export_code',$this->Lang('export_code'));
  echo $this->SetTabHeader('import_code',$this->Lang('import_code'));
}
echo $this->EndTabHeaders();

echo $this->StartTabContent();

if( $this->CheckPermission('Modify Templates') ) {
    echo $this->StartTab('blocks');
    include(dirname(__FILE__).'/function.admin_blocks_tab.php');
    echo $this->EndTab();
}
if( $this->CheckPermission('Manage All Content') && $this->CheckPermission('Calguys Content Utilities') ) {
  echo $this->StartTab('import');
  include(dirname(__FILE__).'/function.admin_import_tab.php');
  echo $this->EndTab();
}
if( $this->CheckPermission('Manage All Content') && $this->CheckPermission('Calguys Content Utilities') ) {
  echo $this->StartTab('export');
  include(dirname(__FILE__).'/function.admin_export_tab.php');
  echo $this->EndTab();
}
if( $this->CheckPermission('Modify Templates') || $this->CheckPermission('Modify User-defined Tags') ||
    $this->CheckPermission('Modify Global Content Blocks') ) {
  echo $this->StartTab('export_code',$params);
  include(dirname(__FILE__).'/function.admin_export_code_tab.php');
  echo $this->EndTab();

  echo $this->StartTab('import_code',$params);
  include(dirname(__FILE__).'/function.admin_import_code_tab.php');
  echo $this->EndTab();
}

echo $this->EndTabContent();
#
# EOF
#
?>