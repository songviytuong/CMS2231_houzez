<?php
namespace CGBetterForms;
if( !isset($gCms) ) exit;
if( !$this->VisibleToAdminUser() ) exit;

try {
    $form_guid   = \cge_param::get_string($params,'form_guid');
    $guid   = \cge_param::get_string($params,'guid');
    $editor_name = \cge_param::get_string($params,'editor_name');
    $editor = $validation = null;

    $helper = new ValidationEditorHelperProxy( $this );
    $form = $this->get_form( $form_guid );
    if( $guid ) {
        $validation = $form->getValidation( $guid );
        $editor = $this->find_editor_by_validation( $validation );
        $editor->set_validation( $validation );
    }
    else {
        $editor = $this->get_validation_editor( $editor_name );
    }
    $editor->set_helper_proxy( $helper );
    $editor->handle_edit_form($params, $form, $form_guid, $guid);
}
catch( \Exception $e ) {
    debug_display($e);
    die();
}