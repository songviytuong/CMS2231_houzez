<?php
namespace CGBetterForms;
if( !isset($gCms) ) exit;
if( !$this->VisibleToAdminUser() ) exit;

try {
    if( \cge_param::exists($params,'submit') ) {
        try {
            if( !isset($_FILES['cgbf_file']) ) throw new \RuntimeException($this->Lang('err_noupload'));
            if( $_FILES['cgbf_file']['size'] == 0 || $_FILES['cgbf_file']['error'] > 0 ) {
                throw new \RuntimeException($this->Lang('err_badupload'));
            }

            $data = file_get_contents( $_FILES['cgbf_file']['tmp_name'] );
            $importer = new FormImporter( $this, $this->formstorage, $data );
            $form = $importer->import();
            $this->formstorage->save( $form );

            // and done.
            $this->SetMessage($this->Lang('msg_imported'));
            $this->RedirectToAdminTab();
        }
        catch( \RuntimeException $e ) {
            echo $this->ShowErrors( $e->GetMessage() );
        }
    }

    $tpl = $this->CreateSmartyTemplate('admin_import_form.tpl');
    $tpl->display();
}
catch( \Exception $e ) {
    $this->SetError($e->GetMessage());
    $this->RedirectToAdminTab();
}