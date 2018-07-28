<?php
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: CGExtensions (c) 2008-2014 by Robert Campbell
#         (calguy1000@cmsmadesimple.org)
#  An addon module for CMS Made Simple to provide useful functions
#  and commonly used gui capabilities to other modules.
#
#-------------------------------------------------------------------------
# CMSMS - CMS Made Simple is (c) 2005 by Ted Kulp (wishy@cmsmadesimple.org)
# Visit the CMSMS Homepage at: http://www.cmsmadesimple.org
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
if (!isset($gCms)) exit();
if (!$this->CheckPermission('Modify Modules')) return;
if( !isset($config['cg_developer_mode']) || !$config['cg_developer_mode'] ) return;

try {
    $act_module = trim(\cge_param::get_string($params,'act_module'));
    $act_generate = \cge_param::get_int($params,'generate');
    if( $act_generate && $act_module ) {
        // get the module
        $mod = \cms_utils::get_module($act_module);
        if( !$mod ) throw new \LogicException("Could not get instance of module $act_module");
        if( !$mod instanceof CGExtensions ) throw new \LogicException("$act_module is not derived from CGExtensions");

        $generator = new \CGExtensions\internal\ModuleIntegrityCodeGenerator($act_module);
        $generator->generate();

        $this->SetMessage($this->Lang('msg_vrfy_checksumgenerated',$act_module));
    }
    unset($act_module,$act_generate);

    // get a list of our modules derived from CGExtensions
    $module_list = array();
    $all_modules = \ModuleOperations::get_instance()->GetInstalledModules();
    foreach( $all_modules as $module_name ) {
        $mod = \cms_utils::get_module($module_name);
        if( !$mod ) continue;
        if( !$mod instanceof CGExtensions ) continue;

        $dir = $mod->GetModulePath();
        $rec = array('name'=>$module_name,'version'=>$mod->GetVersion(),'has_checksum'=>0);
        if( \CGExtensions\internal\ModuleIntegrityTools::has_checksum_data($mod) ) $rec['has_checksum'] = 1;
        $rec['generate_url'] = $this->create_url($id,'generate_module_checksums',$returnid,array('act_module'=>$module_name,'generate'=>1));
        $module_list[] = $rec;
    }

    $tpl = $this->CreateSmartyTemplate('generate_module_checksums.tpl');
    $tpl->assign('return_url',$this->create_url($id,'defaultadmin',$returnid));
    $tpl->assign('module_list',$module_list);
    $tpl->display();
}
catch( \Exception $e ) {
    echo $this->DisplayErrorMessage($e->GetMessage(),'error');
}

#
# EOF
#
?>