<?php

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

$modules = $this->ListAllModules();

#Check Table
$config = \cms_config::get_instance();
$db_name = $config['db_name'];
$_sql = "SELECT * FROM information_schema.tables WHERE table_schema = '" . $db_name . "' AND table_name = 'cms_module_lise_modules' LIMIT 1";
$db = cmsms()->GetDb();
$_exists = $db->GetRow($_sql);
if (count($_exists) == 0) {
    echo $this->ModLang('duplicate_table');
    $smarty->assign('duplicate_table', $this->CreateInputSubmit($id, 'duplicate_table', $this->ModLang('duplicate_button')));
} else {
    $smarty->assign('scan_modules', $this->CreateInputSubmit($id, 'scan_modules', $this->ModLang('scan_modules')));
}

foreach ($modules as $module) {

    $mod = $modops->get_module_instance($module->module_name, '', true);
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
$smarty->assign('startform', $this->CreateFormStart($id, 'admin_duplicatetable', $returnid));
$smarty->assign('endform', $this->CreateFormEnd());


echo $this->ProcessTemplate('modulestab.tpl');
?>