<?php
if (!isset($gCms)) exit;
if (!$this->CheckPermission('Modify Products')) return;

$pid = \cge_param::get_int($params, 'compid');
$hierarchy_alias = \cge_param::get_string($params, 'hierarchy_alias');
if($pid){
    $prod = $db->GetRow("SELECT * FROM " . cms_db_prefix() . "module_products WHERE id = $pid");
    $sku = $prod['sku'];
    $desc = $this->Lang('import_seo_from_product_list');
    $cate = "products";
} else {
    $sku = $hierarchy_alias;
    $desc = $this->Lang('import_seo_from_product_hierarchy');
    $cate = "list";
}

if ($sku) {
    $exists = $db->GetOne("SELECT * FROM " . cms_db_prefix() . "module_liseseo_item WHERE title = '$sku'");
    if ($exists) {
        $msg = "Exist";
    } else {
        $query = "INSERT INTO " . cms_db_prefix() . "module_liseseo_item (`title`,`desc`,`owner`) VALUES ('" . $sku . "', '$desc', " . get_userid() . ")";
        $db->Execute($query);
        $item_category_id = $db->Insert_ID();
        $item_category_name = $db->GetOne("SELECT category_id FROM " . cms_db_prefix() . "module_liseseo_category WHERE category_alias = '$cate'");
        $query_category = "INSERT INTO " . cms_db_prefix() . "module_liseseo_item_categories (`item_id`,`category_id`) VALUES ('" . $item_category_id . "','" . $item_category_name["category_id"] . "')";
        $db->Execute($query_category);
    }
}

$admintheme = cms_utils::get_theme_object();
$json = new stdClass;

$module = \cms_utils::get_module('LISESEO');

$json->image = $admintheme->DisplayImage('icons/system/run.gif', $this->ModLang('revert'), '', '', 'systemicon');
//$json->href = $module->CreateLink($id, 'admin_edititem', $returnid, '', array('item_id' => $item_category_id,'target'=>'_blank'), '', true);

// Fix URL for JSON output
//$json->href = html_entity_decode($json->href);

header("Content-type:application/json; charset=utf-8");

$handlers = ob_list_handlers();
for ($cnt = 0; $cnt < sizeof($handlers); $cnt++) {
    ob_end_clean();
}

echo json_encode($json);
exit();

// give it back via ajax
\cge_utils::send_ajax_and_exit($msg);

#
# EOF
#
?>