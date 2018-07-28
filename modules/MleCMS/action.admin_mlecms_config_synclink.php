<?php

if (!isset($gCms)) exit;

if (! $this->CheckAccess())
{
	echo $this->ShowErrors($this->Lang('accessdenied')); return;
}

$alias = '';
if (isset($params['compid'])) {
    $alias = $params['compid'];
}

if ($alias)
{
    #Products Modules
    $tablename_products = cms_db_prefix() . 'module_products';
    if (!cms_utils::db_column_exists($tablename_products, 'product_name_' . $alias)) {
        $q = 'ALTER TABLE ' . $tablename_products . ' ADD product_name_' . $alias . ' VARCHAR(250) AFTER product_name';
        $r = $db->Execute($q);
    }
    
    if (!cms_utils::db_column_exists($tablename_products, 'details_' . $alias)) {
        $q = 'ALTER TABLE ' . $tablename_products . ' ADD details_' . $alias . ' VARCHAR(250) AFTER details';
        $r = $db->Execute($q);
    }
    
    if (!cms_utils::db_column_exists($tablename_products, 'pack_includes_' . $alias)) {
        $q = 'ALTER TABLE ' . $tablename_products . ' ADD pack_includes_' . $alias . ' text AFTER price';
        $r = $db->Execute($q);
    }
    
    if (!cms_utils::db_column_exists($tablename_products, 'pack_excludes_' . $alias)) {
        $q = 'ALTER TABLE ' . $tablename_products . ' ADD pack_excludes_' . $alias . ' text AFTER price';
        $r = $db->Execute($q);
    }
    
    if (!cms_utils::db_column_exists($tablename_products, 'price_' . $alias)) {
        $q = 'ALTER TABLE ' . $tablename_products . ' ADD price_' . $alias . ' VARCHAR(250) AFTER price';
        $r = $db->Execute($q);
    }

    //$dbr = $db->Execute($query, array($params['compid']));
}

$this->RedirectToTab($id, "mle_config");
?>