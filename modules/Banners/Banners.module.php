<?php
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: Banners (c) 2008 by Robert Campbell
#         (calguy1000@cmsmadesimple.org)
#  An addon module for CMS Made Simple to allow management, display,
#  and tracking of banner images.
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

class Banners extends CGExtensions
{
    public function __construct()
    {
        parent::__construct();
        $this->AddImageDir('images');
    }

    protected function _testip($range,$ip)
    {
        if( !$range || !$ip ) return 0;
        $result = 1;

        # IP Pattern Matcher
        # J.Adams <jna@retina.net>
        #
        # Matches:
        #
        # xxx.xxx.xxx.xxx        (exact)
        # xxx.xxx.xxx.[yyy-zzz]  (range)
        # xxx.xxx.xxx.xxx/nn    (nn = # bits, cisco style -- i.e. /24 = class C)
        #
        # Does not match:
        # xxx.xxx.xxx.xx[yyy-zzz]  (range, partial octets not supported)

        if (preg_match("/([0-9]+)\.([0-9]+)\.([0-9]+)\.([0-9]+)\/([0-9]+)/",$range,$regs)) {

            # perform a mask match
            $ipl = ip2long($ip);
            $rangel = ip2long($regs[1] . "." . $regs[2] . "." . $regs[3] . "." . $regs[4]);

            $maskl = 0;

            for ($i = 0; $i< 31; $i++) {
                if ($i < $regs[5]-1) $maskl = $maskl + pow(2,(30-$i));
            }

            if (($maskl & $rangel) == ($maskl & $ipl)) {
                return 1;
            } else {
                return 0;
            }
        } else {

            # range based
            $maskocts = explode("\.",$range);
            $ipocts = explode("\.",$ip);

            # perform a range match
            for ($i=0; $i<4; $i++) {
                if (preg_match("/\[([0-9]+)\-([0-9]+)\]/",$maskocts[$i],$regs)) {
                    if ( ($ipocts[$i] > $regs[2]) || ($ipocts[$i] < $regs[1])) {
                        $result = 0;
                    }
                }
                else {
                    if ($maskocts[$i] <> $ipocts[$i]) $result = 0;
                }
            }
        }
        return $result;
    }

    public function GetName() { return 'Banners'; }
    public function GetFriendlyName() { return $this->Lang('friendlyname'); }
    public function MinimumCMSVersion() { return '2.2.2'; }
    public function GetVersion() { return '2.10'; }
    public function GetHelp() { return @file_get_contents(dirname(__FILE__).'/help.inc'); }
    public function AllowAutoInstall() { return FALSE; }
    public function AllowAutoUpgrade() { return FALSE; }
    public function LazyLoadAdmin() { return TRUE; }
    public function GetAuthor() { return 'calguy1000'; }
    public function GetAuthorEmail() { return 'calguy1000@cmsmadesimple.org'; }
    public function GetChangeLog() { return @file_get_contents(dirname(__FILE__).'/changelog.inc'); }
    public function IsPluginModule() { return TRUE; }
    public function HasAdmin() { return TRUE; }
    public function GetAdminSection() { return 'content'; }
    public function GetAdminDescription() { return $this->Lang('moddescription'); }
    public function VisibleToAdminUser()
    {
        return $this->CheckPermission('Banners Manager') ||
            $this->CheckPermission('Modify Site Preferences') ||
            $this->CheckPermission('Modify Templates');
    }

    public function GetDependencies() { return array('CGExtensions'=>'1.53.10','CGSimpleSmarty'=>'1.9'); }
    public function InstallPostMessage() { return $this->Lang('postinstall'); }
    public function UninstallPostMessage() { return $this->Lang('postuninstall'); }

    public function InitializeAdmin()
    {
        $this->CreateParameter('action','default',$this->Lang('help_param_action'));
        $this->CreateParameter('category','',$this->Lang('help_param_category'));
        $this->CreateParameter('mode','',$this->Lang('help_param_mode'));
        $this->CreateParameter('name','',$this->Lang('help_param_name'));
        $this->CreateParameter('docount','1',$this->Lang('help_param_docount'));
        $this->CreateParameter('listtemplate','',$this->Lang('help_param_listtemplate'));
    }

    public function InitializeFrontend()
    {
        $this->RegisterModulePlugin();
        $this->RestrictUnknownParams();

        $this->SetParameterType('category',CLEAN_STRING);
        $this->SetParameterType('mode',CLEAN_STRING);
        $this->SetParameterType('name',CLEAN_STRING);
        $this->SetParameterType('category_id',CLEAN_INT);
        $this->SetParameterType('banner_id',CLEAN_INT);
        $this->SetParameterType('docount',CLEAN_STRING);
        $this->SetParameterType('listtemplate',CLEAN_STRING);

        // routes
        $returnid = cmsms()->GetContentOperations()->GetDefaultContent();
        $this->RegisterRoute('/banner\/byname\/(?P<name>.*)$/',
                             array('action'=>'default','showtemplate'=>'false','returnid'=>$returnid));
        $this->RegisterRoute('/banner\/random\/(?P<category>.*)$/',
                             array('action'=>'default','showtemplate'=>'false','returnid'=>$returnid));
        $this->RegisterRoute('/banner\/sequential\/(?P<category>.*)$/',
                             array('action'=>'default','mode'=>'sequential','showtemplate'=>'false','returnid'=>$returnid));
    }

    protected function _DisplayErrorPage($id, &$params, $returnid, $message='')
    {
        $smarty = cmsms()->GetSmarty();
        $smarty->assign('title_error', $this->Lang('error'));
        if ($message != '') $smarty->assign('message', $message);

        // Display the populated template
        echo $this->ProcessTemplate('error.tpl');
    }

    protected function &_getUploadsModule()
    {
        $module = $this->getModuleInstance("Uploads");
        if( $module ) {
            $ver = $module->GetVersion();
            if( version_compare( "1.8", $ver ) <= 0 ) return $module;
        }
        $tmp = null;
        return $tmp;
    }

} // end of class
