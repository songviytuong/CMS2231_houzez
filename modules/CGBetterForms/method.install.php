<?php
$dict = NewDataDictionary($db);
$taboptarray = array( 'mysqli' => 'ENGINE=InnoDB' );

$flds = "id I KEY AUTO,
         name C(255) KEY NOTNULL,
         data X2,
         created I,
         modified I
         ";
$sqlarr = $dict->CreateTableSQL( \CGBetterForms\FormDAO::table_name(), $flds, $taboptarray );
$dict->ExecuteSQLArray( $sqlarr );

$this->CreatePermission(CGBetterForms::MANAGE_PERM,'Manage CGBetterForms');

// template stuff
try {
    $tpl_type = new \CmsLayoutTemplateType();
    $tpl_type->set_originator('CGBetterForms');
    $tpl_type->set_name('Form');
    $tpl_type->set_help_callback('CGBetterForms::tpl_type_help_callback');
    $tpl_type->set_lang_callback('CGBetterForms::tpl_type_lang_callback');
    $tpl_type->save();
}
catch( \CmsException $e ) {
    \cge_utils::log_exception($e);
    audit('','CGBetterForms','Install error: '.$e->GetMessage());
}

$tpl_type = \CmsLayoutTemplateType::load('CGBetterForms::Form');

$create_template_of_type = function($type_ob,$name,$contents,$dflt = false) {
    $ob = new \CmsLayoutTemplate();
    $ob->set_type( $type_ob );
    $ob->set_content( $contents );
    $ob->set_owner( get_userid() );
    $new_name = $ob->generate_unique_name( $name );
    $ob->set_name( $new_name );
    $ob->save();
    return $ob;
};

$do_form_scan = function( \CGBetterForms\Form $form, $smarty ) {
    // only do this once per request.
    $template_obj = \CmsLayoutTemplate::load( $form->template_id );
    $scanner = new \CGBetterForms\TemplateFormScanner( $smarty, $template_obj ); // can throw exception for multiple forms etc.
    $tester = new \CGBetterForms\TemplateFormTester( $scanner, $this->get_formtests() );
    $results = new \CGBetterForms\ScannedTemplate( $scanner, $tester );
    return $results;
};

// create a sample contact form.
// $smarty = \CmsApp::get_instance()->GetSmarty();
$contents = file_get_contents(__DIR__.'/templates/orig_contact_form.tpl');
$tpl = $create_template_of_type( $tpl_type, 'Contact Form', $contents );
$data = [];
$data['name'] = 'Sample contact form';
$data['description'] = 'Sample contact form';
$data['template_id'] = $tpl->get_id();
$data['finalmsg'] = 'Your input is valuable to us.  We will get back to you soon';
$data['cgbf_version'] = $this->GetVersion();
$form = new \CGBetterForms\Form($data);
$res = $do_form_scan( $form, $smarty );
$form->adjustWith( ['fields'=>$res->get_fields() , 'field_messages'=>$res->get_messages(), 'has_captcha'=>$res->has_captcha() ] );
$validation = new \CGBetterForms\FieldValidators\HtmlDetectionValidation();
$form->setValidation( $validation );
$validation = new \CGBetterForms\FieldValidators\EmailFieldValidation();
$validation->set_fieldName( 'email' );
$form->setValidation( $validation );
$editor = new \CGBetterForms\Dispositions\UniqueFileDispositionEditor( $this );
$editor->reset_templates( $form );
$form->setDisposition( $editor->get_disposition() );
$this->formstorage->Save( $form );

// create a sample advanced contact form
$contents = file_get_contents(__DIR__.'/templates/orig_advanced_contact_form.tpl');
$tpl = $create_template_of_type( $tpl_type, 'More advanced contact form', $contents );
$data = [];
$data['name'] = 'More advanced contact form';
$data['description'] = 'More advanced contact form.  This form demonstrates required fields, HTML5 input types, and data attributes.';
$data['template_id'] = $tpl->get_id();
$data['finalmsg'] = 'Your input is valuable to us.  We will get back to you soon';
$data['cgbf_version'] = $this->GetVersion();
$form = new \CGBetterForms\Form($data);
$res = $do_form_scan( $form, $smarty );
$form->adjustWith( ['fields'=>$res->get_fields() , 'field_messages'=>$res->get_messages(), 'has_captcha'=>$res->has_captcha() ] );
// now automatically add validations
$scanner = new \CGBetterForms\ValidationScanner( $this, $form, $res->get_fields() );
$validations = $scanner->get_validations();
if( count($validations) ) {
    foreach( $validations as $obj ) {
        $form->setValidation($obj);
    }
}
$editor = new \CGBetterForms\Dispositions\UniqueFileDispositionEditor( $this );
$editor->reset_templates( $form );
$form->setDisposition( $editor->get_disposition() );
$editor = new \CGBetterForms\Dispositions\EmailFixedAddressesDispositionEditor( $this );
$editor->set_addresses( 'your_email_address_here@localhost.localdomain' );
$editor->reset_templates( $form );
$form->setDisposition( $editor->get_disposition() );
$this->formstorage->Save( $form );

// create sample trivial widget builder.
$contents = file_get_contents(__DIR__.'/templates/orig_trivial_widget_builder.tpl');
$tpl = $create_template_of_type( $tpl_type, 'Trivial Widget Builder', $contents );
$data = [];
$data['name'] = 'Trivial Widget Builder';
$data['description'] = 'A trivial widget builder.  This form demonstrates using jquery to perform calculations, and the data-cgbf-selected attribute.';
$data['template_id'] = $tpl->get_id();
$data['finalmsg'] = '<p>Thank you for your submission</p>';
$data['cgbf_version'] = $this->GetVersion();
$form = new \CGBetterForms\Form($data);
$res = $do_form_scan( $form, $smarty );
$form->adjustWith( ['fields'=>$res->get_fields() , 'field_messages'=>$res->get_messages(), 'has_captcha'=>$res->has_captcha() ] );
// now  manually add a validation
$editor = new \CGBetterForms\FieldValidators\TemplateValidationEditor( $this );
$editor->set_template("{if \$response->widget_size == 'medium' && \$response->widget_color == 'red'}Sorry, we do not have that in stock{/if}");
$form->setValidation($editor->get_validation());
$this->formstorage->Save( $form );
