<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if (!isset($gCms))
    exit;

if (!defined('CMS_VERSION'))
    exit;
if (!$this->CheckPermission(RealEstate::MANAGE_PERM))
    return;


#The tabs
echo $this->StartTabHeaders();
if ($this->CheckPermission('Modify Templates')) {
    echo $this->SetTabHeader('items', $this->Lang('tabs_items'));
    echo $this->SetTabHeader('templates', $this->Lang('tabs_templates'));
    echo $this->SetTabHeader('settings', $this->Lang('tabs_settings'));
}
echo $this->EndTabHeaders();

#The content of the tabs
echo $this->StartTabContent();


if ($this->CheckPermission('Modify Templates')) {
    echo $this->StartTab('items', $params);
    include(__DIR__ . '/function.admin_items.php');
    echo $this->StartTab('templates', $params);
    include(__DIR__ . '/function.admin_templates.php');
    echo $this->EndTab();
}

echo $this->EndTabContent();
