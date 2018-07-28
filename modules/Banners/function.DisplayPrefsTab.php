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

function _DisplayPrefsTab( &$module, $id, &$params, $returnid )
{
    $tpl = $module->CreateSmartyTemplate('adminprefs.tpl');
    $tpl->assign('statreport_linesperpage', $module->GetPreference('statreport_linesperpage',40));
    $tpl->assign('startform', $module->CreateFormStart ($id,'save_admin_prefs', $returnid));
    $tpl->assign('endform', $module->CreateFormEnd ());
    $tpl->assign('submit', $module->CreateInputSubmit ($id, 'submit', $module->Lang('submit')));
    $tpl->assign('cancel', $module->CreateInputSubmit ($id, 'cancel', $module->Lang('cancel')));

    $tpl->assign('prompt_subnet_exclusions', $module->Lang('prompt_subnet_exclusions'));
    $tpl->assign('input_subnet_exclusions', $module->CreateInputText( $id, 'subnet_exclusions',
                                                                         $module->GetPreference('subnet_exclusions',""),50,255));

    $tpl->assign('prompt_dflt_template',$module->Lang('default_template'));
    $tpl->assign('input_dflt_template',
                    $module->CreateSyntaxArea($id,
                                              $module->GetPreference('default_template'),'default_template'));
    $tpl->assign('prompt_reset', $module->Lang('reset_template'));
    $tpl->assign('input_reset', $module->CreateInputCheckbox($id,'reset_template',1));
    $tpl->assign('hide_from_bots',$module->GetPreference('hide_from_bots'));
    $tpl->display();
}

?>
