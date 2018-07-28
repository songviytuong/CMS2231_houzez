<?php
namespace CGBetterForms\FormValidator;
use \CGBetterForms\FormValidationError;

class FormDuplicateIdValidator extends FormTesterTest
{
    public function test_form( array $forms, array $inputs )
    {
        $map = $out = [];
        foreach( $inputs as $input ) {
            $id = trim($input->get_attribute('id'));
            if( !$id ) continue;
            $line = $input->get_line();
            if( ! array_key_exists($id,$map) ) {
                $map[$id] = $line;
            } else {
                $out[] = $this->translate('err_duplicate_fieldid',$line,$id,$map[$id]);
            }
        }
        return $out;
    }
}
