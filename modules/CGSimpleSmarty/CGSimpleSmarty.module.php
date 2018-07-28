<?php
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: CGSimpleSmarty (c) 2008 by Robert Campbell
#         (calguy1000@cmsmadesimple.org)
#  An addon module for CMS Made Simple that provides simple smarty
#  methods and functions to ease developing CMS Made simple powered
#  websites.
#
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2005 by Ted Kulp (wishy@cmsmadesimple.org)
# This projects homepage is: http://www.cmsmadesimple.org
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

$fn = cms_join_path(__DIR__,'function.module_action.php'); require_once($fn);
$fn = cms_join_path(__DIR__,'function.repeat.php'); require_once($fn);
$fn = cms_join_path(__DIR__,'function.session_put.php'); require_once($fn);

class CGSimpleSmarty extends CMSModule
{
    const C_UNSET = '_unset_';

    public function __construct()
    {
        global $CMS_INSTALL_PAGE, $CMS_PHAR_INSTALL;
        if( isset($CMS_INSTALL_PAGE) || isset($CMS_PHAR_INSTALL) ) return;
        $smarty = cmsms()->GetSmarty();
        if( !$smarty ) return;

        $fn = __DIR__.'/class.cgsimple.php';
        require_once($fn);

        $smarty->registerClass('cgsimple','cgsimple');
        $smarty->register_function('module_action_link','module_action_link');
        $smarty->register_function('module_action_url','module_action_url');
        $smarty->register_function('cgrepeat','smarty_function_cgrepeat');
        $smarty->register_function('session_put','smarty_function_session_put');
        $smarty->register_function('session_erase','smarty_function_session_erase');
        $smarty->register_function('anchor_link',array($this,'plugin_anchorlink'));
        $smarty->register_function('setvar',array($this,'plugin_setvar'));
        $smarty->register_function('unsetvar',array($this,'plugin_unsetvar'));
        $smarty->register_function('getvar',array($this,'plugin_getvar'));
    }

    function GetName() { return 'CGSimpleSmarty'; }
    function GetFriendlyName() { return $this->Lang('friendlyname'); }
    function GetVersion() { return '2.1.7'; }
    function MinimumCMSVersion() { return '2.1.4'; }
    function GetHelp() { return file_get_contents(__DIR__.'/help.inc'); }
    function GetAuthor() { return 'calguy1000'; }
    function GetAuthorEmail() { return 'calguy1000@cmsmadesimple.org'; }
    function GetChangeLog() { return @file_get_contents(__DIR__.'/changelog.inc'); }
    function IsPluginModule() { return false; }
    function GetAdminDescription() { return $this->Lang('moddescription'); }
    function HasAdmin() { return false; }
    function HandlesEvents () { return false; }
    function InstallPostMessage() { return $this->Lang('postinstall'); }
    function UninstallPostMessage() { return $this->Lang('postuninstall'); }

    /*
     * Create a link to an anchor further down the page.
     */
    function plugin_anchorlink($params,&$smarty)
    {
        $name = get_parameter_value($params,'n');
        $name = get_parameter_value($params,'name',$name);
        $assign = trim(get_parameter_value($params,'assign'));
        $urlonly = get_parameter_value($params,'u');
        $urlonly = cms_to_bool(get_parameter_value($params,'urlonly',$urlonly));
        $text = get_parameter_value($params,'text',$name);
        unset($params['name'],$params['n'],$params['assign'],$params['u'],$params['urlonly'],$params['text']);

        // start the work
        $out = $url = null;
        if( $name ) $url = cgsimple::anchor_url($name);

        if( $urlonly ) {
            $out = $url;
        }
        else {
            // build a link with all the leftover params (don't filter them, there are lots of valid params for a link).
            $tpl = " %s=\"%s\"";
            $out = '<a';
            $out .= sprintf($tpl,'href',$url);
            foreach( $params as $key => $val ) {
                $out .= " $key=\"$val\"";
            }
            $out .= '>'.$text.'</a>';
        }

        if( $assign ) {
            $smarty->assign($assign,$out);
        } else {
            return $out;
        }
    }

    function plugin_setvar($params,&$samrty)
    {
        foreach( $params as $key => $val ) {
            $key = trim($key);
            if( !$key ) continue;
            if( $val == self::C_UNSET ) {
                cge_tmpdata::erase($key);
            } else {
                cge_tmpdata::set($key,$val);
            }
        }
    }

    function plugin_unsetvar($params,&$smarty)
    {
        foreach( $params as $key => $val ) {
            $key = trim($key);
            if( !$key ) continue;
            if( $key == 'unset' ) {
                if( $val ) {
                    $list = explode(',',$val);
                    foreach( $list as $one ) {
                        $one = trim($one);
                        if( !$one ) continue;
                        cge_tmpdata::erase($one);
                    }
                }
            }
            else {
                cge_tmpdata::erase($key);
            }
        }
    }

    function plugin_getvar($params,&$smarty)
    {
        $key = \cge_param::get_string($params,'v');
        $key = \cge_param::get_string($params,'var',$key);
        $dflt = (isset($params['dflt']))?$params['dflt']:null;

        $val = null;
        if( $key ) $val = cge_tmpdata::get($key,$dflt);
        $assign = \cge_param::get_string($params,'assign');
        $scope = strtolower(\cge_param::get_string($params,'scope','local'));
        if( $assign ) {
            $smarty->assign($assign,$val);
            if( $scope == 'global' ) $smarty->assignGlobal($assign,$val);
            return;
        }
        return $val;
    }
}
