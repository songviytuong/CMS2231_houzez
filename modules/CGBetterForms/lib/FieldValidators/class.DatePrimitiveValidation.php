<?php
namespace CGBetterForms\FieldValidators;

class DatePrimitiveValidation extends Validation
{
    public function get_display_string( \CGBetterForms\Translator $tr )
    {
        return $tr->translate('display_DatePrimitiveValidator');
    }

    public function validate(\CGBetterForms\Form $form, \CGBetterForms\FormResponse& $data, \CGBetterForms\Translator $translator )
    {
        $is_date = function( $in ) {
            if( ! preg_match( '/[0-9]{4}-[0-9]{2}-[0-9]{2}/',$in) ) return;
            return strtotime( $in );
        };

        $names = $form->get_fieldnames();
        foreach( $names as $name ) {
            $field = $form->get_field( $name );
	    if( $field->novalidate ) continue;
            if( $field->type != 'date' && $field->primitive != 'date' ) continue;
            $userval = $data->get_field_value( $name );
            if( !is_array($userval) ) $userval = [ $userval ];
            foreach( $userval as $one ) {
                $ts = $is_date($one);
                if( !$ts ) throw new ValidationException($field->name,$translator->translate('err_input_notdate',$field->name));
                if( $field->min && ($min_ts = $is_date($field->min)) && $ts < $min_ts ) {
                    throw new ValidationException($field->name,$translator->translate('err_input_outofrange',$field->name));
                }
                if( $field->max && ($max_ts = $is_date($field->max)) && $ts > $max_ts ) {
                    throw new ValidationException($field->name,$translator->translate('err_input_outofrange',$field->name));
                }
            }
        }
    }
}
