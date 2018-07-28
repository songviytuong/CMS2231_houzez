<?php
namespace CGBetterForms\FieldValidators;
use \CGBetterForms\utils;

class ComputedValue extends Validation
{
    private $_fieldName;
    private $_template;

    public function __get( $key )
    {
        switch( $key ) {
        case 'fieldName':
            return trim($this->_fieldName);
        case 'template':
            return trim($this->_template);
        }
    }

    public function get_display_string( \CGBetterForms\Translator $tr )
    {
        return $tr->translate('display_ComputedValue',$this->fieldName);
    }

    public function set_fieldName($val)
    {
        $this->_fieldName = trim($val);
    }

    public function set_template($val)
    {
        $this->_template = trim($val);
    }

    public function validate(\CGBetterForms\Form $form, \CGBetterForms\FormResponse& $response, \CGBetterForms\Translator $translator )
    {
        if( !$this->_fieldName ) return;
        $out = utils::process_template( $this->_template, $form, $response );
        $response->modify_value( $this->_fieldName, $out );
    }
}
