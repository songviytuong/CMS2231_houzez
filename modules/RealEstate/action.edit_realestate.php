<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (!defined('CMS_VERSION'))
    exit;
if (!$this->CheckPermission(RealEstate::MANAGE_PERM))
    return;
$realestate = new RealEstateItem();
if (isset($params['rid'])) {
    $realestate = RealEstateItem::load_by_id((int) $params['rid']);
}
if (isset($params['cancel'])) {
    $this->RedirectToAdminTab();
} else if (isset($params['submit'])) {
    $realestate->title = trim($params['title']);
    $realestate->save();
    $this->SetMessage($this->Lang('realestate_saved'));
    $this->RedirectToAdminTab();
}
$tpl = $smarty->CreateTemplate($this->GetTemplateResource('edit_realestate.tpl'), null, null, $smarty);
$tpl->assign('realestate', $realestate);
$tpl->display();
