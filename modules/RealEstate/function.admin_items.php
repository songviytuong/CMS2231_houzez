<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$query = new RealEstateQuery;
$real_items = $query->GetMatches();

$tpl = $smarty->CreateTemplate($this->GetTemplateResource('items.tpl'), null, null, $smarty);
$tpl->assign('real_items', $real_items);
$tpl->display();
