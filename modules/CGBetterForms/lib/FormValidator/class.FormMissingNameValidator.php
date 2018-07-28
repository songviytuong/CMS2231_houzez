<?php
namespace CGBetterForms\FormValidator;
use \CGBetterForms\FormValidationError;

class FormMissingNameValidator extends FormTesterTest
{
    public function test_form( array $forms, array $inputs )
    {
        $out = [];
        foreach( $inputs as $input ) {
            $name = $input->get_attribute('name');
            $type = strtolower($input->get_attribute('type'));
            if( !$type ) $type = strtolower($input->get_nodename());
            if( $type == 'reset' || $type == 'submit' ) continue;
            if( !$type ) $type = '??';

            if( !$name ) {
                $out[] = $this->translate('err_input_missingname',$type,$input->get_line());
            } else {
                // also check for invalid names.
                $regex = '/^[_a-z0-9][_a-z0-9\[\]]*$/i';
                if( !preg_match( $regex, $name) ) {
                    $out[] = $this->translate('err_input_invalidname',$type,$input->get_line(),$name);
                }
            }
        }
        return $out;
    }
}
