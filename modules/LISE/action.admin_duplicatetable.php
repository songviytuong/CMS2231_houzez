<?php


if( !defined('CMS_VERSION') ) exit;

$db = cmsms()->GetDb();

#---------------------
# Submit
#---------------------
if (isset($params['duplicate_table'])) 
{
	$errors = array();
//	
//	if(empty($module_name)) 
//        {
//		$errors[] = $this->ModLang('module_name_empty');
//	}

    if (empty($errors)) {
        $sql = "CREATE TABLE cms_module_lise_modules LIKE cms_module_lise_instances";
        $db->Execute($sql);
        
        $params = array('message' => 'duplicated', 'active_tab' => 'modulestab');
        $this->Redirect($id, 'defaultadmin', '', $params);
    }
}

if (isset($params['scan_modules'])) 
{
	$errors = array();
//	
//	if(empty($module_name)) 
//        {
//		$errors[] = $this->ModLang('module_name_empty');
//	}

    if (empty($errors)) {
        
        #All Modules
        $modops = ModuleOperations::get_instance();
        $module_list = $modops->GetInstalledModules(FALSE);
        
        $results = array();
        
        foreach( $module_list as $module_name ) {
            $inst = $modops->get_module_instance($module_name);
            $details = array();
            $details['name'] = $inst->GetName();
            $details['description'] = $inst->GetDescription();
            $details['version'] = $inst->GetVersion();
            $details['active'] = $modops->IsModuleActive($module_name);
            $results[$module_name] = $details;
        }
        
        

        $res = array();
        foreach($results as $mod){
            $ml = \cms_utils::get_module($mod['name'])->GetPreference('allowmle',0);
            if($ml != 0){
                $res[] = $mod;
            }
        }
        
        foreach($res as $module_name){
            $sql = "SELECT * FROM " . cms_db_prefix() . "modules WHERE module_name = ?";
            $result = $db->GetRow($sql, array($module_name['name']));

            $_exists = "SELECT count(*) as cnt FROM " . cms_db_prefix() . "module_lise_modules WHERE module_name = ?";
            $_ex = $db->GetOne($_exists, array($module_name['name']));
            if ($_ex == 0) {
                $q = "INSERT INTO " . cms_db_prefix() . "module_lise_modules (module_name,module_fields) VALUES (?,?)";
                $db->Execute($q, array($module_name['name'], $result['sync_target']));
            }
        }

//        $sql = "CREATE TABLE cms_module_lise_modules LIKE cms_module_lise_instances";

//        $db->Execute($sql);
        
        $params = array('message' => 'scan_moduled', 'active_tab' => 'modulestab');
        $this->Redirect($id, 'defaultadmin', '', $params);
    }
}

#---------------------
# Error handling
#---------------------
if (!empty($errors))
{
  echo $this->ShowErrors($errors);
}
?>