<?php

#-------------------------------------------------------------------------
# LISE - List It Special Edition
# Version 1.2
# A fork of ListI2
# maintained by Fernando Morgado AKA Jo Morg
# since 2015
#-------------------------------------------------------------------------
#
# Original Author: Ben Malen, <ben@conceptfactory.com.au>
# Co-Maintainer: Simon Radford, <simon@conceptfactory.com.au>
# Web: www.conceptfactory.com.au
#
#-------------------------------------------------------------------------
#
# Maintainer since 2011 up to 2014: Jonathan Schmid, <hi@jonathanschmid.de>
# Web: www.jonathanschmid.de
#
#-------------------------------------------------------------------------
#
# Some wackos started destroying stuff since 2012 and stopped at 2014:
#
# Tapio Löytty, <tapsa@orange-media.fi>
# Web: www.orange-media.fi
#
# Goran Ilic, <uniqu3e@gmail.com>
# Web: www.ich-mach-das.at
#
#-------------------------------------------------------------------------
#
# LISE is a CMS Made Simple module that enables the web developer to create
# multiple lists throughout a site. It can be duplicated and given friendly
# names for easier client maintenance.
#
#-------------------------------------------------------------------------
# BEGIN_LICENSE
#-------------------------------------------------------------------------
# This file is part of LISE
# LISE program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# LISE program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
# Or read it online: http://www.gnu.org/licenses/licenses.html#GPL
#
#-------------------------------------------------------------------------
# END_LICENSE
#-------------------------------------------------------------------------

if (!defined('CMS_VERSION'))
    exit;

$GLOBALS['CMS_FORCE_MODULE_LOAD'] = 1;
$admintheme = cms_utils::get_theme_object();

#---------------------
# Load modules
#---------------------

$modops = cmsms()->GetModuleOperations();
$allmodules = $modops->GetAllModuleNames();

if (count($allmodules) > 0) {
    $query = "SELECT * FROM " . cms_db_prefix() . "modules ORDER BY module_name";
    $result = $db->Execute($query);

    while ($result && $row = $result->FetchRow()) {
        $dbm[$row['module_name']]['Status'] = $row['status'];
        $dbm[$row['module_name']]['Version'] = $row['version'];
        $dbm[$row['module_name']]['Active'] = ($row['active'] == 1 ? true : false);
    }
}

$modules = $this->ListModules();

foreach ($modules as $module) {

    $mod = $modops->get_module_instance($module->module_name, '', true);
    $module->synclink = '';
    $module->clonelink = '';
    
    if (is_object($mod)) {
        $module->friendlyname = $mod->GetFriendlyName();
        $module->version = $dbm[$module->module_name]['Version'];

        if (version_compare($mod->GetVersion(), $dbm[$module->module_name]['Version']) > 0) {
            $module->exportlink = '';
            $module->clonelink = '';
            $module->upgradelink = $this->CreateLink(
                    $id, 'admin_upgrademodule', $returnid, $themeObject->DisplayImage(
                            'icons/system/false.gif', $this->ModLang('instance_upgrade'), '', '', 'systemicon'
                    ), array('module_id' => $module->module_id)
            );

            $test = $themeObject->DisplayImage(
                    'icons/system/false.gif', $this->ModLang('instance_upgrade'), '', '', 'systemicon'
            );
        } else {
            if ($module->sync) {
                $module->synclink = $this->CreateLink($id, 'admin_sync', $returnid, $themeObject->DisplayImage('icons/system/true.gif', '', '', '', 'systemicon'), array(
                    'type' => $module->module_name
                ));
            } else {
                if ($module->module_name != 'LISESEO') {
                    $module->synclink = $this->CreateLink($id, 'admin_sync', $returnid, $themeObject->DisplayImage('icons/system/false.gif', '', '', '', 'systemicon'), array(
                        'type' => $module->module_name
                    ));
                }
            }
            if ($module->module_name != 'LISESEO') {
                $module->clonelink = $this->CreateLink(
                        $id, 'admin_clonemodule', $returnid, $themeObject->DisplayImage(
                                'icons/system/copy.gif', $this->ModLang('clone', $module->friendlyname), '', '', 'systemicon'
                        ), array('module_id' => $module->module_id)
                );
            }
            $module->exportlink = $this->CreateLink(
                    $id, 'admin_exportmodule', $returnid, lise_utils::DisplayImage(
                            lise_utils::UIgif('xml_rss'), $this->ModLang('export', $module->friendlyname), '', '', 'systemicon'
                    ), array('module_id' => $module->module_id)
            );

            $module->upgradelink = $themeObject->DisplayImage('icons/system/true.gif', $this->ModLang('instance_uptodate'), '', '', 'systemicon');
        }
    }
}

#---------------------
# Smarty processing
#---------------------

$smarty->assign('modules', $modules);

$smarty->assign('startform', $this->CreateFormStart($id, 'admin_copymodule', $returnid));
$smarty->assign('endform', $this->CreateFormEnd());
$smarty->assign('duplicate', $this->CreateInputSubmit($id, 'duplicate', $this->ModLang('duplicate')));

$smarty->assign('startuploadform', $this->CreateFormStart($id, 'admin_uploadmodule', $returnid, 'post', 'multipart/form-data'));
$smarty->assign('enduploadform', $this->CreateFormEnd());
$smarty->assign('filenameinput', $this->CreateInputFile($id, 'filename', $this->ModLang('filename')));
$smarty->assign('upload', $this->CreateInputSubmit($id, 'upload', $this->ModLang('import_title')));

echo $this->ProcessTemplate('instancestab.tpl');
?>