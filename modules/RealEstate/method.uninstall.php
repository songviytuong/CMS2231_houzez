<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (!defined('CMS_VERSION'))
    exit;
$this->RemovePermission(RealEstate::MANAGE_PERM);
$db = $this->GetDb();
$dict = NewDataDictionary($db);
$sqlarray = $dict->DropTableSQL(CMS_DB_PREFIX . 'houzez_realestate');
$dict->ExecuteSQLArray($sqlarray);
