<?php
namespace CGBetterForms\FieldValidators;

class EmailPrimitiveValidation extends Validation
{
    public function get_display_string( \CGBetterForms\Translator $tr )
    {
        return $tr->translate('display_EmailPrimitiveValidator');
    }

    public function validate(\CGBetterForms\Form $form, \CGBetterForms\FormResponse& $data, \CGBetterForms\Translator $translator )
    {
        $names = $form->get_fieldnames();
        foreach( $names as $name ) {
            $field = $form->get_field( $name );
	    if( $field->novalidate ) continue;
            if( $field->type != 'email' && $field->primitive != 'email' ) continue;
            $userval = $data->get_field_value( $name );
            if( !$userval ) continue; // required is checked elsewhere
            if( !is_array($userval) ) $userval = [ $userval ];
            foreach( $userval as $one ) {
                if( ! is_email($one) ) throw new ValidationException($field->name,$translator->translate('err_input_notemail',$field->name));
            }
        }
    }
}
