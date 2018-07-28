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
if( !isset($gCms) ) exit;
$modify_templates = $this->CheckPermission('Modify Templates');
$modify_udt = $this->CheckPermission('Modify User-defined Tags');
if( !$modify_templates && !$modify_udt ) exit;

// get a list of the module templates.
if( $modify_templates ) {
  $module_templates = array();
  $modules = ModuleOperations::get_instance()->GetInstalledModules();
  foreach( $modules as $module_name ) {
    $templates = $this->ListTemplates($module_name);
    if( count($templates) ) {
      $module_templates[$module_name] = $templates;
    }
  }

  $tmp = array_keys($module_templates);
  $module_list = array();
  foreach( $tmp as $one ) {
    $obj = $this->GetModuleInstance($one);
    if( !$obj ) continue;
    $module_list[$one] = $obj->GetFriendlyName();
  }

  $smarty->assign('module_list',$module_list);
  $smarty->assign('num_modules',count($module_list));
 }

if( $modify_udt ) {
  $smarty->assign('modify_udt',1);
}

global $CMS_VERSION;
if( version_compare($CMS_VERSION,'1.98') >= 0 ) $smarty->assign('v2warning',1);
$smarty->assign('formstart',$this->CGCreateFormStart($id,'admin_export_code'));
$smarty->assign('formend',$this->CreateFormEnd());
$smarty->assign('ajax_url',$this->CreateUrl($id,'admin_ajax_gettemplates',$returnid));

echo $this->ProcessTemplate('admin_export_code_tab.tpl');

#
# EOF
#
?>