<?php

#-------------------------------------------------------------------------
# Module: SimpleSiteInfo
# Author: Noel McGran, Rolf Tjassens
#-------------------------------------------------------------------------
# CMS Made Simple is (c) 2004 - 2011 by Ted Kulp (wishy@cmsmadesimple.org)
# CMS Made Simple is (c) 2011 - 2016 by The CMSMS Dev Team
# This project's homepage is: http://www.cmsmadesimple.org
# The module's homepage is: http://dev.cmsmadesimple.org/projects/simplesiteinfo
#-------------------------------------------------------------------------
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
#-------------------------------------------------------------------------

if (!cmsms())
    exit;
if (!$this->CheckAccess())
    return false;

// Display status messages passed here by other pages as message parameter
if (isset($params['message']))
    echo $this->ShowMessage($this->Lang($params['message']));

if (isset($params['submit'])) {
    cmsms_valid('Execute This Action');
    audit('', 'Simple Site Info', 'Created New Password');

    $this->Redirect($id, 'defaultadmin', $returnid, array('message' => 'pwdchanged'));
}

$smarty->assign('startform', $this->CreateFormStart($id, 'defaultadmin', $returnid));
$smarty->assign('endform', $this->CreateFormEnd());

$smarty->assign('moddescription', $this->Lang('moddescription'));

$smarty->assign('prompt_current_pwd', $this->Lang('prompt_current_pwd'));
$smarty->assign('current_pwd', $this->GetPreference('SimpleSiteInfoPwd'));

$smarty->assign('cdkeytext', $this->Lang("cdkeytext"));
$smarty->assign('inputcdkey1', $this->CreateInputText($id,'cdkey1','LPK',3,3, "readonly=readonly style='background-color:#ccc;'"));
$smarty->assign('inputcdkey2', $this->CreateInputText($id,'cdkey2','',10,10));

$smarty->assign('create_new_pwd', $this->Lang('create_new_pwd'));
$smarty->assign('confirm_change_pwd', $this->Lang('confirm_change_pwd'));

// Add some little checks to help you during debug mode
$smarty->assign('debug_mode', '');
$smarty->assign('open_file', '');

if (!empty(cmsms()->config['debug'])) {

    $smarty->assign('debug_mode', 'true');

    $version_file_pwd = $this->getPreference('SimpleSiteInfoPwd');
    $local_key = substr($version_file_pwd, 20);
    $file_path = cmsms()->config['root_path'] . '/tmp/templates_c/SimpleSiteInfo^' . md5($local_key) . '.txt';
    $file_url = cmsms()->config['root_url'] . '/tmp/templates_c/SimpleSiteInfo^' . md5($local_key) . '.txt';
    if (file_exists($file_path))
        $smarty->assign('open_file', $file_url);
}

echo $this->ProcessTemplate('editpwd.tpl');
?>