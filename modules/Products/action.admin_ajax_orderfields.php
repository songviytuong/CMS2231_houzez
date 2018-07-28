<?php
if( !isset($gCms) ) exit;
if( !$this->CheckPermission('Modify Products') ) exit;

try {
    $idlist = \cge_utils::get_param($params,'idlist');

    $sql = 'UPDATE '.cms_db_prefix().'module_products_fielddefs SET item_order = ?, modified_date = NOW()  WHERE id = ?';
    $item_order = 1;
    foreach( $idlist as $id ) {
        $db->Execute( $sql, [ $item_order, (int) $id ] );
        $item_order++;
    }
    // nothong to output.
}
catch( \Exception $e ) {
    header('HTTP/1.0 500 '.$e->GetMessage());
}
exit;
