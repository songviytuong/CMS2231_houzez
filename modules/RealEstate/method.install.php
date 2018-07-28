<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if (!defined('CMS_VERSION'))
    exit;
$this->CreatePermission(RealEstate::MANAGE_PERM, 'Manage RealEstate');
$db = $this->GetDb();
$dict = NewDataDictionary($db);
$taboptarray = array('mysql' => 'TYPE=MyISAM');
$flds = "
   real_id I KEY AUTO,
   title C(255) KEY NOTNULL,
   sanitizetitle C(255),
   lat C(50),
   lng C(50),
   bedrooms I,
   bathrooms I,
   address C(50),
   thumbnail C(255),
   url C(100),
   type I1,
   price DECIMAL(7,2),
   icon C(100)
";
$sqlarray = $dict->CreateTableSQL(CMS_DB_PREFIX . 'houzez_realestate', $flds, $taboptarray);
$dict->ExecuteSQLArray($sqlarray);
