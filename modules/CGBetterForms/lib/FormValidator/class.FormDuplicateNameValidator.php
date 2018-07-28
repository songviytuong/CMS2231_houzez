<?php
namespace CGBetterForms\FormValidator;
use \CGBetterForms\FormValidationError;

class FormDuplicateNameValidator extends FormTesterTest
{
    public function test_form( array $forms, array $inputs )
    {
        $map = $out = [];
        foreach( $inputs as $input ) {
            $name = $input->get_attribute('name');
            if( !$name ) continue; // already check for this
            $type = strtolower($input->get_attribute('type'));
            if( $type == 'hidden' ) continue; // we don't care about hidden fields.
            $line = $input->get_line();
            $is_multiple = endswith($name,'[]');
            if( ! array_key_exists($name,$map) ) {
                $map[$name] = [$type,$line];
            } else if( $type != $map[$name][0] ) {
                // change of field type
                // but if the previous type was hidden, we accept that.
                $out[] = $this->translate('err_duplicate_fieldname',$line,$map[$name][1]);
            } else if( !$is_multiple && $type != 'radio' && $type != 'checkbox' ) {
                // radio and checkbox fields can validly occur multiple times with the same name.
                $out[] = $this->translate('err_duplicate_fieldname',$line,$map[$name][1]);
            }
        }
        return $out;
    }
}
