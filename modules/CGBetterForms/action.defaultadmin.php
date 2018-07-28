<?php
namespace CGBetterForms;
if( !isset($gCms) ) exit;
if( !$this->VisibleToAdminUser() ) exit;

$tpl = $this->CreateSmartyTemplate('defaultadmin.tpl');
$tpl->assign('forms',$this->formstorage->list_all());
$tpl->display();