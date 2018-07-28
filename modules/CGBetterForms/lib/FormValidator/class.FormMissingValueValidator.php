<?php
namespace CGBetterForms\FormValidator;
use \CGBetterForms\FormValidationError;

class FormMissingValueValidator extends FormTesterTest
{
    public function test_form( array $forms, array $inputs )
    {
        $out = [];
        foreach( $inputs as $input ) {
            if( $input instanceof \CGBetterForms\DOMInputField ) {
                $type = $input->get_attribute('type');
                if( $type == 'radio' || $type == 'checkbox' ) {
                    $val = $input->get_attribute('value');
                    $type = $input->get_attribute('type');
                    $name = $input->get_attribute('name');
                    if( !$name ) $name = '??';
                    if( !$val && $type != 'hidden' ) $out[] = $this->translate('err_input_missingvalue',$type,$name,$input->get_line());
                }
            }
        }
        return $out;
    }
}
