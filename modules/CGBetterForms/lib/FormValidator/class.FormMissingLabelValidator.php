<?php
namespace CGBetterForms\FormValidator;
use \CGBetterForms\FormValidationError;

class FormMissingLabelValidator extends FormTesterTest
{
    public function test_form( array $forms, array $inputs )
    {
        $out = [];
        foreach( $inputs as $input ) {
            if( !$input->get_label() ) {
                $name = $input->get_attribute('name');
                if( !$name ) continue;
                $type = $input->get_attribute('type');
                if( $type == 'reset' || $type == 'submit' || $type == 'hidden' ) continue;
                if( $input instanceof \CGBetterForms\DOMButtonField ) continue; // not needed
                $out[] = $this->translate('err_input_missinglabel',$name,$input->get_line());
            }
        }
        return $out;
    }
}
