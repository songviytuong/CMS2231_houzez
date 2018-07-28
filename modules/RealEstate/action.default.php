<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$template = $this->GetPreference("defaulttemplate", "default");
if (isset($params["template"])) {
    $template = $params["template"];
}
$content = $this->GetTemplateContent($template);

$real_items = $this->GetReals();
$showreals = array();
foreach ($real_items as $item) {
    $onerow = new stdClass();
    $onerow->real_id = $item["real_id"];
    $onerow->real_name = $item["title"];
    array_push($showreals, $onerow);
}
$this->smarty->assign('real_items', $showreals);
echo $this->ProcessTemplateFromData($content);

//if (!defined('CMS_VERSION'))
//    exit;
//$query = new RealEstateQuery();
//$realestates = $query->GetMatches();
//$tpl = $smarty->CreateTemplate($this->GetTemplateResource('default.tpl'), null, null, $smarty);
//$tpl->assign('realestates', $realestates);
//$tpl->display();
