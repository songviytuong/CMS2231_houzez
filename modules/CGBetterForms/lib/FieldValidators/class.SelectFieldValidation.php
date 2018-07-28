<?php
namespace CGBetterForms\FieldValidators;

class SelectFieldValidation extends Validation
{
    public function get_display_string( \CGBetterForms\Translator $tr )
    {
        return $tr->translate('display_SelectFieldValidation');
    }

    public function validate(\CGBetterForms\Form $form, \CGBetterForms\FormResponse& $data, \CGBetterForms\Translator $translator )
    {
        $names = $form->get_fieldnames();
        foreach( $names as $name ) {
            $field = $form->get_field( $name );
            if( $field->novalidate ) continue;
            $userval = $data->get_field_value( $name );
            if( ! $userval ) continue;

            switch( $field->type ) {
            case 'select':
            case 'radio':
            case 'checkbox':
            case 'button':
                $valid_values = $field->get_option_values();
                if( is_array($valid_values) ) {
                    if( !is_array($userval) ) $userval = [ $userval ];
                    foreach( $userval as $val ) {
                        // note: empty values are allowed.
                        if( $val && !in_array($val,$valid_values) ) {
                            // probably means that one of the checkboxes etc.  don't have values.
                            throw new ValidationException(\CGBetterForms\FieldError::NONSPECIFIC_FIELD,
                                                          $translator->translate('err_invalid_fieldvalue'));
                        }
                    }
                }
                break;
            }
        }
    }
}
