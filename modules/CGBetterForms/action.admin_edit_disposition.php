<?php
namespace CGBetterForms;
if( !isset($gCms) ) exit;
if( !$this->VisibleToAdminUser() ) exit;

try {
    $form_guid   = \cge_param::get_string($params,'form_guid');
    $disp_guid   = \cge_param::get_string($params,'disp_guid');
    $editor_name = \cge_param::get_string($params,'editor_name');
    $editor = $disposition = null;

    $helper = new DispositionEditorHelperProxy( $this );
    $form = $this->get_form( $form_guid );
    if( $disp_guid ) {
        $disposition = $form->getDisposition( $disp_guid );
        $editor = $this->find_editor_by_disposition( $disposition );
        $editor->set_disposition( $disposition );
    }
    else {
        $editor = $this->get_disposition_editor( $editor_name );
    }
    $editor->set_helper_proxy( $helper );
    $editor->handle_edit_form($params, $form, $form_guid, $disp_guid);
}
catch( \Exception $e ) {
    debug_display($e);
    die();
}