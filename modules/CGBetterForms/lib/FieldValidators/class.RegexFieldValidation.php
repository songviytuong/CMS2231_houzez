<?php
namespace CGBetterForms\FieldValidators;

class RegexFieldValidation extends Validation
{
    private $_fieldName;
    private $_pattern;

    public function __get( $key )
    {
        switch( $key ) {
        case 'fieldName':
            return trim($this->_fieldName);
        case 'pattern':
            return trim($this->_pattern);
        }
    }

    public function get_display_string( \CGBetterForms\Translator $tr )
    {
        return $tr->translate('display_RegexFieldValidation',$this->fieldName,$this->pattern);
    }

    public function set_fieldName($val)
    {
        $this->_fieldName = trim($val);
    }

    public function set_pattern($val)
    {
        $this->_pattern = trim($val);
    }

    public function validate(\CGBetterForms\Form $form, \CGBetterForms\FormResponse& $response, \CGBetterForms\Translator $translator )
    {
        if( !$this->_fieldName ) return;
        if( !$this->_pattern ) return;

        $val = $response->get_field_value( $this->_fieldName );
        $field = $form->get_field( $this->_fieldName );
	if( $field->novalidate ) return;

        if( !is_array( $val) ) $val = [ $val ];
        foreach( $val as $one_val ) {
            if( !preg_match( $this->_pattern, $one_val) ) throw new ValidationException($this->_fieldName,$translator->translate('err_field_invalidvalue'));
        }
    }
}
