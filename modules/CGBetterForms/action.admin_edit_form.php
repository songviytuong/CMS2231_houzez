<?php
namespace CGBetterForms;
if( !isset($gCms) ) exit;
if( !$this->VisibleToAdminUser() ) exit;

$make_field_list = function( array $fields ) {
    $out = [];
    foreach( $fields as $field ) {
        $out[$field->name] = "{$field->name} ({$field->type})";
    }
    return $out;
};

$do_scan = function( Form $form, $smarty ) {
    static $tester, $scanner;

    if( !is_object($tester) ) {
        // only do this once per request.
        $template_obj = \CmsLayoutTemplate::load( $form->template_id );
        $scanner = new TemplateFormScanner( $smarty, $template_obj ); // can throw exception for multiple forms etc.
        $tester = new TemplateFormTester( $scanner, $this->get_formtests() );
    }

    $results = new ScannedTemplate( $scanner, $tester );
    return $results;
};


try {
    $scan_needed = false;
    $form = new Form;
    $form_guid = $disp_guid = $validator_guid = null;
    if( \cge_param::exists($params,'cancel') ) $this->RedirectToAdminTab();

    if( ($form_id = \cge_param::get_int($params,'form')) ) {
        $form = $this->formstorage->load_by_id( $form_id );
        $form_guid = $this->store_form( $form );
    }
    else if( ($form_guid = \cge_param::get_string($params,'form_guid')) ) {
        // get it from session.
        $form = $this->get_form( $form_guid );
        $subaction = \cge_param::get_string($params,'subaction');
        if( $subaction && ($guids = \cge_param::get_string($params,'guids')) ) {
            // handle a subaction
            $guids = explode(',',$guids);
            if( count($guids) ) {
                switch( $subaction ) {
                case 'order_dispositions':
                    $form->orderDispositions( $guids );
                    $form_guid = $this->store_form( $form );
                    break;
                case 'order_validations':
                    $form->orderValidations( $guids );
                    $form_guid = $this->store_form( $form );
                    break;
                }
            }
        }
        else if( ($disp_guid = \cge_param::get_string($params,'disp_guid')) ) {
            // handle an updated disposition.
            $disp = utils::retrieve_object($disp_guid);
            $form->setDisposition( $disp );
            $form_guid = $this->store_form( $form );
            // todo: set current tab.
        }
        else if( ($validator_guid = \cge_param::get_string($params,'validator_guid')) ) {
            // handle an updated validation
            $validator = utils::retrieve_object($validator_guid);
            $form->setValidation( $validator );
            $form_guid = $this->store_form( $form );
            // todo: set current tab
        }
    }

    // if we have a template id... do a scan so we can display fields and messages
    if( $form->template_id && !\cge_param::exists($params,'scan') ) {
        $template_obj = \CmsLayoutTemplate::load( $form->template_id );
        $mod_time = $template_obj->get_modified();
        $errs = [];
        if( version_compare($form->cgbf_version,$this->GetVersion()) != 0 ) {
            $errs[] = $this->ShowErrors($this->Lang('err_form_versionchange'));
            $scan_needed = true;
        }
        if( $form->modified < $mod_time && $form->tpl_modified < $mod_time ) {
            $errs[] = $this->ShowErrors($this->Lang('err_form_scanneeded'));
            $scan_needed = true;
        }
        if( count($errs) ) echo $this->ShowErrors($errs);
    }

    if( \cge_param::exists($params,'scan') ) {
        try {
            // fill the form object with a name, template id, description, etc...
            $form = $form->adjustWith( $params );
            $template_obj = \CmsLayoutTemplate::load( $form->template_id );
            $form = $form->adjustWith( ['tpl_modified'=>time() ] );

            // get the messages, and fields and store them in the form
            // todo: filter the fields down to one per name.
            $res = $do_scan( $form, $smarty );
            $form->adjustWith( ['fields'=>$res->get_fields() , 'field_messages'=>$res->get_messages(), 'has_captcha'=>$res->has_captcha() ] );
            $form->adjustWith( [ 'cgbf_version'=>$this->GetVersion() ] );

            // save the form to the session
            $this->SetCurrentTab('messages');
            echo $this->ShowMessage($this->Lang('msg_scanned_saveneeded'));
            $form_guid = $this->store_form( $form );
        }
        catch( FormScannerError $e ) {
            echo $this->ShowErrors($this->Lang($e->GetMessage()));
        }
        catch( \Exception $e ) {
            echo $this->ShowErrors($e->GetMessage());
        }
    }
    else if( \cge_param::exists($params,'auto_validation') ) {
        try {
            $this->SetCurrentTab('validation');
            $scanner = new \CGBetterForms\ValidationScanner( $this, $form, $form->get_fields() );
            $validations = $scanner->get_validations();
            if( count($validations) ) {
                foreach( $validations as $obj ) {
                    $form->setValidation($obj);
                }
                $form_guid = $this->store_form( $form );
            }
        }
        catch( \Exception $e ) {
            echo $this->ShowErrors($e->GetMessage());
        }
    }
    else if( \cge_param::exists($params,'add_validation') ) {
        try {
            // initiate adding a validation
            $editor_class = \cge_param::get_string($params,'validation');
            if( !$editor_class ) throw new \LogicException('Internal error:  No validation specified');
            $editor = $this->get_validation_editor( $editor_class );
            if( !$editor ) throw new \LogicException('Internal error: Validation not found');

            // test if we can have many of these.
            if( !$editor->allows_multiple() && $form->hasValidation( $editor->get_outputclass() )) {
                throw new \LogicException($this->Lang('err_mod_validatiooneonly'));
            }
            if( $editor->has_interface() ) {
                $url = $this->create_url($id,'admin_edit_validation',$returnid, [ 'form_guid'=>$form_guid, 'editor_name'=>$editor_class ]);
                $url = str_replace('&amp;','&',$url);
                redirect($url);
            }
            else {
                // there's no editor.
                $form->setValidation( $editor->get_validation() );
                $form_guid = $this->store_form( $form );
            }
        }
        catch( \Exception $e ) {
            echo $this->ShowErrors($e->GetMessage());
        }
    }
    else if( \cge_param::exists($params,'add_disposition') ) {
        try {
            // initiate adding a disposition
            $editor_class = \cge_param::get_string($params,'disposition');
            if( !$editor_class ) throw new \LogicException('Internal error:  No disposition specified');
            $obj = $this->get_disposition_editor( $editor_class );
            if( !$obj ) throw new \LogicException('Internal error: Disposition not found');

            if( $obj->has_interface() ) {
                $url = $this->create_url($id,'admin_edit_disposition',$returnid, [ 'form_guid'=>$form_guid, 'editor_name'=>$editor_class ]);
                $url = str_replace('&amp;','&',$url);
                redirect($url);
            }
            else {
                $form->setDisposition( $obj->get_disposition() );
                $form_guid = $this->store_form( $form );
            }
        }
        catch( \Exception $e ) {
            echo $this->ShowErrors($e->GetMessage());
        }
    }
    else if( \cge_param::exists($params,'edit_validation') && ($validator_guid = \cge_param::get_string($params,'edit_validation')) >= 0 ) {
        $validator = $form->getValidation($validator_guid);
        if( !$validator ) throw new \LogicException('Invalid validation guid '.$validator_guid);
        $editor = $this->find_editor_by_validation( $validator );
        if( $editor->has_interface() ) {
            $validator_guid = utils::store_object( $validator, $validator->get_guid() );
            $url = $this->create_url($id,'admin_edit_validation',$returnid, [ 'form_guid'=>$form_guid, 'guid'=>$validator_guid ] );
            $url = str_replace('&amp;','&',$url);
            redirect($url);
        }
    }
    else if( \cge_param::exists($params,'edit_disposition') && ($disp_guid = \cge_param::get_string($params,'edit_disposition')) >= 0 ) {
        // initiate editing of a disposition
        $disp = $form->getDisposition($disp_guid);
        if( !$disp ) throw new \LogicException('Invalid disposition guid '.$disp_guid);
        $editor = $this->find_editor_by_disposition( $disp );
        $disp_guid = utils::store_object( $disp, $disp->get_guid() );
        $url = $this->create_url($id,'admin_edit_disposition',$returnid, [ 'form_guid'=>$form_guid, 'disp_guid'=>$disp_guid ]);
        $url = str_replace('&amp;','&',$url);
        redirect($url);
    }
    else if( \cge_param::exists($params,'del_validation') && ($v_guid = \cge_param::get_string($params,'del_validation')) >= 0 ) {
        try {
            $this->SetCurrentTab('validation');
            $disp = $form->getValidation( $v_guid );
            if( !$disp ) throw new \LogicException('Invalid validation guid '.$v_guid);
            $form->removeValidation( $v_guid );
            $form_guid = $this->store_form( $form );
        }
        catch( \Exception $e ) {
            echo $this->ShowErrors($e->GetMessage());
        }
    }
    else if( \cge_param::exists($params,'del_disposition') && ($disp_guid = \cge_param::get_string($params,'del_disposition')) >= 0 ) {
        $disp = $form->getDisposition( $disp_guid );
        if( !$disp ) throw new \LogicException('Invalid disposition guid '.$disp_guid);
        $form->removeDisposition( $disp_guid );
        $form_guid = $this->store_form( $form );
        $this->SetCurrentTab('handlers');
    }
    else if( \cge_param::exists($params,'submit') || \cge_param::exists($params,'apply')) {
        // fill the form
        $form = $form->adjustWith( $params );
        $template_obj = \CmsLayoutTemplate::load( $form->template_id );
        $form = $form->adjustWith( ['tpl_modified'=>$template_obj->get_modified(), 'cgbf_version'=>$this->GetVersion() ] );

        $res = $do_scan( $form, $smarty );
        $form->adjustWith( ['fields'=>$res->get_fields(), 'has_captcha'=>$res->has_captcha() ] );

        // can save in an incomplete state.
        $this->formstorage->Save( $form );

        if( \cge_param::exists($params,'submit') ) {
            $this->SetMessage($this->Lang('msg_formsaved'));
            $this->RedirectToAdminTab();
        }
        else {
            echo $this->ShowMessage($this->Lang('msg_formsaved'));
        }
    }

    $tpl = $this->CreateSmartyTemplate('admin_edit_form.tpl');
    $tpl->assign('form',$form);
    $tpl->assign('form_guid',$form_guid);
    $tpl->assign('field_list',$make_field_list($form->fields));
    $tpl->assign('fields',$form->fields);
    $tpl->assign('scan_needed',$scan_needed);
    $tpl->assign('messages',$form->field_messages);
    $tpl->assign('all_templates',utils::list_suitable_templates());
    $tpl->assign('all_validations',utils::list_validation_editors( $this->get_validation_editors() ) );
    $tpl->assign('all_dispositions',utils::list_disposition_editors( $this->get_disposition_editors() ) );
    $tpl->assign('form_help',utils::get_form_tpl_help( $form ));
    $tpl->display();
}
catch( \Exception $e ) {
    $this->SetError($e->GetMessage());
    $this->RedirectToAdminTab();
}
