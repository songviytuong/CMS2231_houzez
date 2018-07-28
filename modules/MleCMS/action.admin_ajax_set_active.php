<?php

if (!isset($gCms))
    exit;

if (!$this->CheckAccess('manage translator_mle')) {
    echo $this->ShowErrors($this->Lang('accessdenied'));
    return;
}
#Active 0|1
if (mle_tools::is_ajax() && $_POST['aAction'] == 'SetActive') {
    Translation::setActive($_POST);
}

#Reset Data Alter Table Drop 
if (mle_tools::is_ajax() && $_POST['aAction'] == 'ResetData') {

    $rest = "";

    $ignored_tables = array(
        'LISE',
        'LISESEO'
    );
    $where = "";
    foreach ($ignored_tables as $item) {
        $where .= "module_name != '$item' AND ";
    }
    $where .= " sync != 1";

    #LISE MODULE
    $LISE_TABLE_QUERY = "SELECT module_name FROM " . cms_db_prefix() . "modules WHERE module_name LIKE '%LISE%' AND $where";
    $LIST_TABLE_ARR = $db->GetAll($LISE_TABLE_QUERY);
    foreach ($LIST_TABLE_ARR as $MODULE) {
        $table = cms_db_prefix() . 'module_' . strtolower($MODULE["module_name"]) . '_item';
        $fields = array(
            'desc',
            'title',
            'key1',
            'key2',
            'key3'
        );

        alter_drop($table, $fields, $_POST["alias"], 'alias');
        $rest .= "- R.TABLE: " . $table . "<br/>";
    }

    foreach ($LIST_TABLE_ARR as $MODULE) {
        $table = cms_db_prefix() . 'module_' . strtolower($MODULE["module_name"]) . '_category';
        $fields = array(
            'category_name',
            'category_description',
            'key1',
            'key2',
            'key3'
        );

        alter_drop($table, $fields, $_POST["alias"], 'category_name');
        $rest .= "- R.TABLE: " . $table . "<br/>";
    }

    $sql_modules_reset = "SELECT * FROM " . cms_db_prefix() . "modules WHERE sync_target IS NOT NULL AND sync != 1";
    $list_modules_reset = $db->GetAll($sql_modules_reset);
    $str = "";
    foreach ($list_modules_reset as $key => $item) {
        $str .= $item['sync_target'];
    }

    $str = str_replace("}{", ",", $str);
    $str = (array) json_decode($str);

    foreach ($str as $key => $item) {
        $table = cms_db_prefix() . $key;
        $fields = $item;
        alter_drop($table, $fields, $_POST["alias"]);
        $rest .= "- R.TABLE: " . $table . "<br/>";
    }

    if ($rest) {
        echo $rest;
    } else {
        echo $this->Lang('nothing');
    }
}

#Sync Data Alter Table Add & Modify
if (mle_tools::is_ajax() && $_POST['aAction'] == 'SyncData') {

    $rest = "";

    $ignored_tables = array(
        'LISE',
        'LISESEO'
    );
    $where = "";
    foreach ($ignored_tables as $item) {
        $where .= "module_name != '$item' AND ";
    }
    $where .= " sync = 1";

    #LISE MODULE
    $LISE_TABLE_QUERY = "SELECT module_name FROM " . cms_db_prefix() . "modules WHERE module_name LIKE '%LISE%' AND $where";
    $LIST_TABLE_ARR = $db->GetAll($LISE_TABLE_QUERY);
    foreach ($LIST_TABLE_ARR as $MODULE) {
        $table = cms_db_prefix() . 'module_' . strtolower($MODULE["module_name"]) . '_item';
        $fields = array(
            'desc',
            'title',
            'key1',
            'key2',
            'key3'
        );

        alter($table, $fields, $_POST["alias"]);
        $rest .= "- TABLE: " . $table . "<br/>";
    }

    foreach ($LIST_TABLE_ARR as $MODULE) {
        $table = cms_db_prefix() . 'module_' . strtolower($MODULE["module_name"]) . '_category';
        $fields = array(
            'category_name',
            'category_description',
            'key1',
            'key2',
            'key3'
        );

        alter($table, $fields, $_POST["alias"], 'category_name');
        $rest .= "- TABLE: " . $table . "<br/>";
    }

    $sql_modules = "SELECT * FROM " . cms_db_prefix() . "module_lise_modules AS l"
            . " INNER JOIN cms_modules AS m ON l.module_name = m.module_name"
            . " WHERE m.sync = 1";
    $list_modules = $db->GetAll($sql_modules);

    $str = "";
    foreach ($list_modules as $modules) {
        $str .= $modules['module_fields'];
    }

    $str = str_replace("}{", ",", $str);
    $str = (array) json_decode($str);

    foreach ($str as $key => $item) {
        $table = cms_db_prefix() . $key;
        $fields = $item;
        alter($table, $fields, $_POST["alias"]);
        $rest .= "- TABLE: " . $table . "<br/>";
    }

    echo $rest;
}

function alter($table, $fields, $post, $alias) {
    $db = cmsms()->GetDb();
    foreach ($fields as $item) {
        $arrText = array(
            'details',
            'desc',
            'value',
            'key1',
            'key2',
            'key3',
        );
        if (in_array($item, $arrText)) {
            $string_type = 'text';
        } else {
            $string_type = 'VARCHAR(255)';
        }
        if ($post == 'en') {
            continue;
        } else {
            if (cms_utils::db_column_exists($table, $item . '_' . $post) == TRUE) {
                $q = 'ALTER TABLE ' . $table . ' MODIFY ' . $item . '_' . $post . ' ' . $string_type;
            } else {
                $q = 'ALTER TABLE ' . $table . ' ADD ' . $item . '_' . $post . ' ' . $string_type . ' AFTER `' . $item . '`';
            }
        }
        $r = $db->Execute($q);
//        if (!$r)
//            throw new Exception($db->ErrorMsg());
    }
}

function alter_drop($table, $fields, $post, $alias) {
    $db = cmsms()->GetDb();
    foreach ($fields as $item) {
        if ($post == 'en' || $table == 'cms_module_liseseo_item') {
            continue;
        } else {
            $q = 'ALTER TABLE ' . $table . ' DROP ' . $item . '_' . $post;
        }
        $r = $db->Execute($q);
//        if (!$r)
//            throw new Exception($db->ErrorMsg());
    }
}

exit;
?>