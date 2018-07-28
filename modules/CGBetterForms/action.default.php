<?php
namespace CGBetterForms;
if( !isset($gCms) ) exit;

try {
    $is_submission = function() use( $id ) {
        // a submission for THIS FORM is indicated by a request post
        if( strtolower( $_SERVER['REQUEST_METHOD']) != 'post' ) return FALSE;
        if( !\cge_param::get_string($_POST ,'__guid') ) return FALSE;
        if( ! \cge_param::get_string($_POST , $id.'form') ) return FALSE;
        return TRUE;
    };

    $formname = \cge_param::get_string($params,'form');
    if( !$formname ) throw new \LogicException('Please specify a form name when calling CGBetterForms');

    $form = $this->formstorage->load( $formname );
    if( !$form ) throw new \LogicException('Sorry, could not find a form with the name '.$formname);

    // make sure it's version compatible.
    if( version_compare($form->cgbf_version,$this->GetVersion()) != 0 ) throw new \LogicException($this->Lang('err_form_versionchange'));

    // if template modified since form saved
    $template_obj = \CmsLayoutTemplate::load( $form->template_id );
    if( !\cge_param::get_bool($params,'nodatecheck') ) {
        $mod_time = $template_obj->get_modified();
        if( $form->modified < $mod_time && $form->tpl_modified < $mod_time ) throw new \LogicException($this->Lang('err_form_scanneeded'));
    }

    // create a pre-filled response with some paremters from the call
    $input_data = [];
    $prefix = 'cgbf_';
    foreach( $params as $key => $value ) {
        if( !startswith($key,$prefix) ) continue;
        $key = substr($key,strlen($prefix));
        $input_data[$key] = $value;
    }
    if( !$is_submission() ) {
        // will be a problem with multiple forms on one page.

        // we can modify the input data with variables assigned in the template
        // i.e: {$widget_size='red'}
        if( $form->prerender_logic ) {
            $this->_in_prerender = true;
            $form_fields = $form->get_fieldnames();
            $tpl = $smarty->CreateTemplate('string:'.$form->prerender_logic);
            $tpl->assign('mod',$this);
            $tpl->assign('form',$form);
            $tpl->fetch(); // do the work, but ignore output.
            foreach( $form_fields as $field_name ) {
                if( ! isset($this->_prerender_vars[$field_name]) ) continue;
                $input_data[$field_name] = $this->_prerender_vars[$field_name];
            }
            $this->_in_prerender = null;
            $this->_prerender_vars = null;
        }
    }

    $response = null;
    if( !$is_submission() ) {
        $response = new FormResponse( $this, $form, null, $input_data );
    }
    else {
        // now handle POST.
        try {
            // merge input data with data on the post.
            $guid = \cge_param::get_string($_POST ,'__guid');
            $this->_request_errors = [];

            // check to make sure that the guid is in the session
            // this prevents submitting the form via a post or reload without rendering the form each time.
            if( !get_userid(FALSE) ) {
                if( !isset($_SESSION['CGBF_GUID_TOKEN']) || !isset($_SESSION['CGBF_GUID_TOKEN'][$guid]) ) {
                    throw new Exception($this->Lang('err_security_requestguid'));
                }
            }

            // here we could check if too much time has passed, or some other criteria.
            unset($_SESSION['CGBF_GUID_TOKEN'][$guid]);

            // create a formresponse object
            // merge in data from parameters as default values to the response.
            $response = new FormResponse( $this, $form, $guid, $_POST );

            if( $response->__hpname ) {
                // oops... honeypt isn't empty.
                throw new BotDetectedError( $this->Lang('error_botdetected') );
            }

            //
            // handle validations.
            // todo: validation should probably be in a validator class
            //
            $this->_request_errors = $form->validate_response( $response, $this->translator );
            if( count($this->_request_errors) ) {
                throw new ValidationError( 'validation errors' );
            }

            //
            // and do dispositions
            // todo: dispositions probably should be in their own class
            //
            $form->dispose_response_novalidate( $response );

            // clean up any submission leftovers.
            $form->cleanup_response( $response );

            echo $form->do_final_action( $response );
            return;
        }
        catch( ValidationError $e ) {
            // TODO: Should be ValidationError
            // some kind of validation error.
            // render the form again... smarty will pull the request errors.
            // clean up any submission leftovers.
            $form->cleanup_response( $response );
        }
        catch( DispositionError $e ) {
            // cleanup, set an error to display, and render the form again.
            $this->_request_errors = [ new FieldError( '__', $e->GetMessage() ) ];
            $form->cleanup_response( $response );
        }

    }

    // now render the form
    $captcha_provider = null;
    if( $form->has_captcha ) $captcha_provider = $this->get_captcha_provider();
    $renderer = new FormRenderer( $this, $form, $captcha_provider, $smarty, $id, $returnid, $response );
    echo $renderer->getHTML();
}
catch( \Exception $e ) {
    \cge_utils::log_exception( $e );
    echo $this->DisplayErrorMessage($e->GetMessage());
}
