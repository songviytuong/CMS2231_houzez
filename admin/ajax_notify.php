<?php

$CMS_ADMIN_PAGE = 1;
require_once("../lib/include.php");

$gCms = CmsApp::get_instance();
$db = $gCms->GetDb();

$owner = get_userid(FALSE);
$out = array();

if (isset($_REQUEST["module"]))
    $module = trim(cleanValue($_REQUEST["module"]));

$p = "SELECT id,item_id,module,msg FROM " . cms_db_prefix() . 'histories ORDER BY id DESC LIMIT 0,1';
$history = $db->GetRow($p);

if ($_REQUEST['action'] == 'update') {
    $up = "UPDATE " . cms_db_prefix() . "histories_seq SET id = " . $history["id"] . " WHERE module = ?";
    $db->Execute($up, array($module));
} else {
    /*+290617*/
    $delete = "DELETE FROM " . cms_db_prefix() . "histories WHERE (`id` < ? and module = ?)";
    $db->Execute($delete, array($history["id"],$history["module"]));
    switch ($history["module"]) {
        case "Products":
            $pd = "SELECT id,sku,owner,modified_date FROM " . cms_db_prefix() . "module_products WHERE id = ?";
            $mod_products = $db->GetRow($pd, array($history["item_id"]));
            if($history["msg"]){
                $msg = "Sản phẩm: ".$mod_products["sku"]." ".$history["msg"]." lúc: ".$db->DBTimeStamp(time());
            } else {
                $msg = 'User: ' . $uname . ' mới update sản phẩm: ' . $mod_products["sku"] . ' lúc: ' . $db->DBTimeStamp(time());
            }
            $owner = $mod_products["owner"];
            $out["msg"] = array(
                'icon' => 'themes/OneEleven/images/icons/system/notify.png?v=1',
                'message' => $msg
            );
            break;
        case "SEO":
            $seo = "SELECT item_id,title,modified_time,owner FROM " . cms_db_prefix() . "module_liseseo_item WHERE item_id = ?";
            $mod_seo = $db->GetRow($seo, array($history["item_id"]));
            $owner = $mod_seo["owner"];
            $out["msg"] = array(
                'icon' => 'themes/OneEleven/images/icons/system/notify.png?v=1',
                'message' => 'User: ' . $uname . ' mới update SEO: ' . $mod_seo["title"] . ' lúc: ' . $mod_seo["modified_time"]
            );
            break;
        case "CallBack":
            $out["msg"] = array(
                'icon' => 'themes/OneEleven/images/icons/system/notify.png?v=1',
                'message' => $history["msg"]
            );
            break;
        default:
            $out["msg"] = array(
                'icon' => 'themes/OneEleven/images/icons/system/notify.png?v=1',
                'message' => 'Hiện không có thông báo gì đáng chú ý :)'
            );
            break;
    }

    $u = "SELECT username FROM " . cms_db_prefix() . 'users WHERE user_id = ?';
    $uname = $db->GetOne($u, array($owner));

    $mod = \cms_utils::get_module("Products");

    // Get counter
    $plast= "SELECT id FROM " . cms_db_prefix() . 'histories ORDER BY id DESC LIMIT 0,1';
    $rlast = $db->GetRow($plast);
    
    $q = "SELECT id FROM " . cms_db_prefix() . 'histories_seq WHERE module = ?';
    $number = $db->GetOne($q, array($history["module"]));
    $number = ($number == null) ? 0 : $number;

    if ($number == 0) {
        $insert = "INSERT INTO " . cms_db_prefix() . 'histories_seq SET id= ?, module = ?';
        $db->Execute($insert, array($rlast["id"], $history["module"]));
    }

    if ($history["id"] > $number) {
        $out["status"] = "OK";
        $out["owner"] = $uname;
        $out["module"] = $history["module"];
    }
}

header("Content-type:application/json; charset=utf-8");

if ($_REQUEST[CMS_SECURE_PARAM_NAME] != $_SESSION[CMS_USER_KEY]) {
    check_login();
} else {
    
}

$handlers = ob_list_handlers();
for ($cnt = 0; $cnt < sizeof($handlers); $cnt++) {
    ob_end_clean();
}

echo json_encode($out);
exit;
