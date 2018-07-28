<?php

if (!cmsms() || !$this->VisibleToAdminUser()) {
    echo $this->Lang("accessdenied");
    return;
}

$db = cmsms()->GetDb();
$config = \cms_config::get_instance();
$module_name = $this->GetName();

if (isset($params["allowwysiwyg"])) {
    $this->SetPreference("allowwysiwyg", $params["allowwysiwyg"]);
} else {
    $this->SetPreference("allowwysiwyg", '0');
}

if (isset($params["allowmle"])) {
    $this->SetPreference("allowmle", $params["allowmle"]);

    $_fields = array(
        'module_quoteprops' => array('value')
    );
    $module_fields = json_encode($_fields);

    $db_name = $config['db_name'];
    $_sql = "SELECT * FROM information_schema.tables WHERE table_schema = '" . $db_name . "' AND table_name = '" . cms_db_prefix() . "module_lise_modules' LIMIT 1";
    $_exists = $db->GetRow($_sql);
    if (count($_exists) == 0) {
        $sql = "CREATE TABLE " . cms_db_prefix() . "module_lise_modules LIKE cms_module_lise_instances";
        $result = $db->Execute($sql);
        if ($result) {
            $q = "INSERT INTO " . cms_db_prefix() . "module_lise_modules (module_name,module_fields) VALUES (?,?)";
            $db->Execute($q, array($module_name, $module_fields));
        }
    } else {
        $s = "SELECT module_fields FROM " . cms_db_prefix() . "module_lise_modules WHERE module_name = ?";
        $_s = $db->GetOne($s, array($module_name));
        if ($_s == NULL) {
            $q = "INSERT INTO " . cms_db_prefix() . "module_lise_modules (module_fields,module_name) VALUES (?,?)";
        } else {
            $q = "UPDATE " . cms_db_prefix() . "module_lise_modules SET module_fields = ? WHERE module_name = ?";
        }
        $db->Execute($q, array($module_fields, $module_name));
    }

    $_update = "UPDATE " . cms_db_prefix() . "modules SET sync = 1, sync_target = ? WHERE module_name = ?";
    $db->Execute($_update, array($module_fields, $module_name));
} else {
    $this->SetPreference("allowmle", '0');
    $_delete = "DELETE FROM " . cms_db_prefix() . "module_lise_modules WHERE (`module_name`= ?)";
    $db->Execute($_delete, array($module_name));

    $_update = "UPDATE " . cms_db_prefix() . "modules SET sync = 0, sync_target = '' WHERE module_name = ?";
    $db->Execute($_update, array($module_name));
}

$this->Redirect($id, 'defaultadmin', $returnid, array("module_message" => $this->Lang("settingssaved"), "tab" => "settings"));

#
# EOF
#
?>