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
if (isset($params['rid']) && $params['rid'] > 1) {
    $realestate = RealEstateItem::load_by_id((int) $params['rid']);
    $realestate->delete();
    $this->SetMessage($this->Lang('realestate_deleted'));
    $this->RedirectToAdminTab();
}
