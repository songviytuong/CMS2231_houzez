<?php
namespace CGBetterForms\FieldValidators;

class HtmlDetectionValidation extends Validation
{
    public function get_display_string( \CGBetterForms\Translator $tr )
    {
        return $tr->translate('display_HtmlDetectionValidation');
    }

    public function validate(\CGBetterForms\Form $form, \CGBetterForms\FormResponse& $data, \CGBetterForms\Translator $translator )
    {
        $names = $form->get_fieldnames();
        foreach( $names as $name ) {
            $field = $form->get_field( $name );
            $userval = $data->get_field_value( $name );
            if( ! $userval ) continue;

            if( !is_array( $userval) ) $userval = [ $userval ];
            foreach( $userval as $one_val ) {
                $tmp = strip_tags( $one_val );
                if( $tmp != $one_val ) throw new ValidationException($field->name,
                                                                     $translator->translate('err_input_htmldetected'));
            }
        }
    }
}
