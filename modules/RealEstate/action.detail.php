<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if (!defined('CMS_VERSION')) exit;
if (!isset($params['rid'])) return;

$detailtemplate = (isset($params['detailtemplate'])) ? trim($params['detailtemplate']) :
'detail.tpl';
$realestate = RealEstateItem::load_by_id((int) $params['rid']);
$tpl = $smarty->CreateTemplate($this->GetTemplateResource($detailtemplate),null,null,$smarty);
$tpl->assign('realestate', $realestate);
$tpl->display();
