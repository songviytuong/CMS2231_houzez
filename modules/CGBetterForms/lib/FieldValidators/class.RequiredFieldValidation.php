<?php
namespace CGBetterForms\FieldValidators;

class RequiredFieldValidation extends Validation
{
    public function get_display_string( \CGBetterForms\Translator $tr )
    {
        return $tr->translate('display_RequiredFieldValidator');
    }

    public function validate(\CGBetterForms\Form $form, \CGBetterForms\FormResponse& $data, \CGBetterForms\Translator $translator )
    {
        $names = $form->get_fieldnames();
        foreach( $names as $name ) {
            $field = $form->get_field( $name );
            if( $field->novalidate ) continue;
            if( !$field->required ) continue;
            $userval = $data->get_field_value( $name );
            if( ! $userval ) throw new ValidationException($field->name,$translator->translate('err_input_missingrequiredvalue',$field->name));
        }
    }
}
