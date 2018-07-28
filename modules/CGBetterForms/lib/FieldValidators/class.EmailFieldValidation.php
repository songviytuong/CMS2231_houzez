<?php
namespace CGBetterForms\FieldValidators;

class EmailFieldValidation extends Validation
{
    private $_fieldName;

    public function __get( $key )
    {
        switch( $key ) {
        case 'fieldName':
            return trim($this->_fieldName);
        }
    }

    public function get_display_string( \CGBetterForms\Translator $tr )
    {
        return $tr->translate('display_EmailFieldValidation',$this->fieldName);
    }

    public function set_fieldName($val)
    {
        $this->_fieldName = trim($val);
    }

    public function validate(\CGBetterForms\Form $form, \CGBetterForms\FormResponse& $response, \CGBetterForms\Translator $translator )
    {
        if( !$this->_fieldName ) return;

        $val = $response->get_field_value( $this->_fieldName );
        $field = $form->get_field( $this->_fieldName );
        if( $field->novalidate ) return;

        if( !is_array( $val) ) $val = [ $val ];
        foreach( $val as $one_val ) {
            if( !is_email( $one_val ) ) throw new ValidationException($this->_fieldName,$translator->translate('err_field_invalidvalue'));
        }
    }
}
