<?php
namespace CGBetterForms;
if( !isset($gCms) ) exit;
if( !$this->VisibleToAdminUser() ) exit;

try {
    $form = null;
    if( ($form_id = \cge_param::get_int($params,'form')) ) {
        $form = $this->formstorage->load_by_id( $form_id );
    }

    if( !$form ) throw new \LogicException('Cannot delete form (invalid form id)');

    $exporter = new FormExporter( $form );
    $exporter->download();

    $this->SetMessage($this->Lang('msg_formexported'));
    $this->RedirectToAdminTab();
}
catch( \Exception $e ) {
    $this->SetError($e->GetMessage());
    $this->RedirectToAdminTab();
}