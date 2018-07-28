<?php
$dict = NewDataDictionary($db);
$taboptarray = array( 'mysqli' => 'ENGINE=InnoDB' );

$sqlarr = $dict->DropTableSQL( \CGBetterForms\FormDAO::table_name() );
$dict->ExecuteSQLArray($sqlarr);

$this->RemovePermission(CGBetterForms::MANAGE_PERM);

// template stuff
try {
    $types = \CmsLayoutTemplateType::load_all_by_originator($this->GetName());
    if( is_array($types) && count($types) ) {
        foreach( $types as $type ) {
            $templates = $type->get_template_list();
            if( is_array($templates) && count($templates) ) {
                foreach( $templates as $template ) {
                    $template->delete();
                }
            }
            $type->delete();
        }
    }
}
catch( \Exception $e ) {
    \cge_utils::log_exception( $e );
    audit('',$this->GetName(),'Uninstal error: '.$e->GetMessage());
}
