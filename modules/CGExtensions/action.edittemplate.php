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
if( !$gCms ) exit();

$template_name = \cge_param::get_string($params,'template');
$prefix = \cge_param::get_string($params,'prefix');
$mode = \cge_param::get_string($params,'mode','add');
$title = \cge_param::get_string($params,'title');
$modname = \cge_param::get_string($params,'modname');
$destaction = \cge_param::get_string($params,'destaction','defaultadmin');
$activetab = \cge_param::get_string($params,'activetab');
$info = \cge_param::get_string($params,'info');
$moddesc = \cge_param::get_string($params,'moddesc');
$defaulttemplatepref = \cge_param::get_string($params,'defaulttemplatepref');
$defaultprefname = \cge_param::get_string($params,'defaultprefname');
if( !isset($params['origname']) ) $params['origname'] = $template_name;
$templatecontent = null;

$get_factory_template_content = function($tplname,$module) {
    $content = null;
    if( endswith( $tplname, '.tpl') ) {
        $fn = $module->find_module_file('templates/'.$tplname);
        if( $fn && is_file($fn) ) $content = file_get_contents($fn);
    }
    else {
        $content = $module->GetTemplate($tplname);
        if( !$content ) $content = $module->GetPreference($tplname);
    }
    return $content;
};

try {
    if( !$modname ) throw new \Exception($this->Lang('error_missingparam'));
    $module = $this->GetModuleInstance($modname);
    if( !$module ) throw new \Exception($this->Lang('error_missingparam'));
    if( !$prefix ) throw new \Exception($this->Lang('error_missingparam'));
    if( !$mode || !$title ) throw new \Exception($this->Lang('error_missingparam'));
    switch( $mode ) {
    case 'add':
        $templatecontent = $get_factory_template_content($defaulttemplatepref,$module);
        break;
    case 'edit':
        $templatecontent = $module->GetTemplate($prefix.$template_name);
        break;
    }

    try {
        $module->SetCurrentAction($destaction);
        if( isset($params['cge_cancel']) ) {
            $module->RedirectToTab($activetab);
        }
        else if( isset($params['cge_reset']) ) {
            $templatecontent = $get_factory_template_content($defaulttemplatepref,$module);
            if( !$templatecontent ) $templatecontent = $module->GetPreference($defaulttemplatepref);
            echo $this->ShowMessage($this->Lang('msg_template_reset'));
        }
        if( isset($params['cge_submit']) || isset($params['cge_apply']) ) {
            $template_name = \cge_param::get_string($params,'template',$template_name);
            if( !$template_name ) throw new \Exception($this->Lang('error_templatenamebad'));
            if( !preg_match('/[a-zA-Z0-9\_]*/',$params['template']) ) throw new \Exception($this->Lang('error_templatenamebad'));

            $templatecontent = $params['templatecontent'];
            $origname = \cge_param::get_string($params,'origname');
            $current_dflt = $module->GetPreference($defaultprefname);
            if( $template_name != $origname && $origname ) {
                // template renamed
                $module->DeleteTemplate($prefix.$origname);
                if( $origname && $origname == $current_dflt ) {
                    // we are adjusting the default template
                    $module->SetPreference($defaultprefname,$template_name);
                }
            }
            $module->SetTemplate($prefix.$template_name,$templatecontent);

            if( isset($params['cge_submit']) ) {
                $module->SetMessage($this->Lang('msg_templatesaved'));
                $module->RedirectToTab($activetab);
            } else {
                echo $this->ShowMessage($this->Lang('msg_templatesaved'));
            }
        }
    }
    catch( \Exception $e ) {
        echo $this->ShowErrors($e->GetMessage());
    }
}
catch( \Exception $e ) {
    $this->SetError($e->GetMessage());
    $this->Redirect($id,'defaultadmin',$returnid,$params);
}


// handle errors.
if( isset($params['errors']) ) echo $module->ShowErrors($params['errors']);

unset($params['cge_submit'],$params['cge_apply'],$params['cge_reset'],$params['cge_cancel'],$params['templatecontent']);
$theme = \cms_utils::get_theme_object();
$smarty->assign('title',cms_html_entity_decode($title));
$smarty->assign('formstart', $this->CGCreateFormStart($id, 'edittemplate',$returnid,$params));
$smarty->assign('formend',$this->CreateFormEnd());
$smarty->assign('templatename',$template_name);
$smarty->assign('cge',$this);
$smarty->assign('actionid',$id);
$smarty->assign('mode',$mode);
$smarty->assign('modname',$modname);
$smarty->assign('title',$title);
$smarty->assign('moddesc',$moddesc);
$smarty->assign('info',$info);
$smarty->assign('templatecontent',$templatecontent);
$smarty->assign('prompt_templatename',$this->Lang('prompt_templatename'));
$smarty->assign('prompt_template',$this->Lang('prompt_template'));
echo $this->ProcessTemplate('edittemplate.tpl');
