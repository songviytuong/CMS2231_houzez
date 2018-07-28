<?php

if (!isset($params['type']))
    throw new LISEException('Missing parameter, this should not happen!');

$type = (string) $params['type'];

$status = LISEFielddefOperations::ToggleActiveSync($params['type']);

$handlers = ob_list_handlers();
for ($cnt = 0; $cnt < sizeof($handlers); $cnt++) {
    ob_end_clean();
}

$admintheme = cms_utils::get_theme_object();
$json = new stdClass;

if ($status) {
    $json->image = $admintheme->DisplayImage('icons/system/true.gif', $this->ModLang('revert'), '', '', 'systemicon');
} else {
    $json->image = $admintheme->DisplayImage('icons/system/false.gif', $this->ModLang('approve'), '', '', 'systemicon');
}

$json->href = $this->CreateLink($id, 'admin_sync', $returnid, '', array('type' => $type), '', true);

// Fix URL for JSON output
$json->href = html_entity_decode($json->href);
$json->message = $this->ModLang('modulecopied');

header("Content-type:application/json; charset=utf-8");

$handlers = ob_list_handlers();
for ($cnt = 0; $cnt < sizeof($handlers); $cnt++) {
    ob_end_clean();
}

echo json_encode($json);
exit();
?>