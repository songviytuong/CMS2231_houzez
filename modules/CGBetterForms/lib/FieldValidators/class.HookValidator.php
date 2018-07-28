<?php
namespace CGBetterForms\FieldValidators;

class HookValidator extends Validation
{
    public function get_display_string( \CGBetterForms\Translator $tr )
    {
        return 'Hook Validator (internal)';
    }

    public function Validate(\CGBetterForms\Form $form, \CGBetterForms\FormResponse& $response, \CGBetterForms\Translator $tr )
    {
        $res = \CMSMS\HookManager::do_hook( 'CGBetterForms::validateForm', $response );
        if( $res && $res instanceof \CGBetterForms\FormResponse ) $response = $res;
    }

} // end of class
