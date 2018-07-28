<?php

if (!defined('CMS_VERSION'))
    exit;
if (!$this->CheckPermission($this->_GetModuleAlias() . '_modify_item'))
    return;

if (!isset($params['mode']) || !isset($params['item_id'])) {
    die('missing parameter, this should not happen');
}

$gCms = CmsApp::get_instance();
$config = $gCms->GetConfig();

$item_id = (int) $params['item_id'];
$email = $params['email'];
$brochure = $params['brochure'];
$booking_date = $params['booking_date'];
$booking_code = $params['booking_code'];
$mode = (bool) $params['mode'];

$to = $email;

$content = 'Booking Code: '.$booking_code.'<br/><a href="'.$config["root_url"].'/check-code/?token='.$booking_code.'">Click here</a> to accept your booking information.';
$cmsmailer = cms_utils::get_module('CMSMailer');
// Receiver
$cmsmailer->AddAddress($to, "Customer");
// Sender
$cmsmailer->SetFrom('noreply@website.com');
$cmsmailer->SetFromName('CMS Webmaster');
// Subject
$ipaddress = cms_utils::get_real_ip();
$cmsmailer->SetSubject('Booking from: ' . $ipaddress);
// Content
$cmsmailer->SetBody($content);
$cmsmailer->IsHTML(true);
//$cmsmailer->Send();


if ($cmsmailer->Send()) {
    $query = 'UPDATE ' . cms_db_prefix() . 'module_' . $this->_GetModuleAlias() . '_item SET modified_time = NOW(), desc_en = ? WHERE item_id = ?';
    $db->Execute($query, array($booking_code,$item_id));
}

$handlers = ob_list_handlers();
for ($cnt = 0; $cnt < sizeof($handlers); $cnt++) {
    ob_end_clean();
}

$admintheme = cms_utils::get_theme_object();
$json = new stdClass;

$json->image = $admintheme->DisplayImage('icons/system/sent.png', $this->ModLang('revert'), '', '', 'systemicon');
$json->href = $this->CreateLink($id, 'admin_sentitem', $returnid, '', array('mode' => 'sent', 'item_id' => $item_id), '', true);

// Fix URL for JSON output
$json->href = html_entity_decode($json->href);

header("Content-type:application/json; charset=utf-8");

$handlers = ob_list_handlers();
for ($cnt = 0; $cnt < sizeof($handlers); $cnt++) {
    ob_end_clean();
}

echo json_encode($json);
exit();
?>

