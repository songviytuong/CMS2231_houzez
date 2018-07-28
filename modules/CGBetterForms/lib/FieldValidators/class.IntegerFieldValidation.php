<?php
namespace CGBetterForms\FieldValidators;

class IntegerFieldValidation extends Validation
{
    private $_fieldName;
    private $_minVal;
    private $_maxVal;

    public function __get( $key )
    {
        switch( $key ) {
        case 'fieldName':
            return trim($this->_fieldName);

        case 'minVal':
            return $this->_minVal;

        case 'maxVal':
            return $this->_maxVal;
        }
    }

    public function get_display_string( \CGBetterForms\Translator $tr )
    {
        $minV = $this->minVal;
        $maxV = $this->maxVal;
        if( $minV && !$maxV ) {
            return $tr->translate('display_IntegerFieldValidation1',$this->fieldName,$minV);
        }
        else if( $maxV && !$minV ) {
            return $tr->translate('display_IntegerFieldValidation2',$this->fieldName,$maxV);
        }
        else {
            return $tr->translate('display_IntegerFieldValidation3',$this->fieldName,$minV,$maxV);
        }
    }

    public function set_fieldName($val)
    {
        $this->_fieldName = trim($val);
    }

    public function set_minValue($val)
    {
        if( !is_null($val) ) $val = (int) $val;
        $this->_minVal = $val;
    }

    public function set_maxValue($val)
    {
        if( !is_null($val) ) $val = (int) $val;
        $this->_maxVal = $val;
    }

    public function validate(\CGBetterForms\Form $form, \CGBetterForms\FormResponse& $response, \CGBetterForms\Translator $translator )
    {
        if( !$this->_fieldName ) return;
        $val = $response->get_field_value( $this->_fieldName );

        $field = $form->get_field( $this->_fieldName );
        if( $field->novalidate ) return;

        $minV = $this->_minVal;
        $maxV = $this->_maxVal;
        if( strlen($minV) && strlen($maxV) && $minV > $maxV ) {
            $tmp = $maxV;
            $maxV = $minV;
            $minV = $tmp;
        }
        if( !is_array($val) ) $val = [ $val ];
        foreach( $val as $one_val ) {
            $one_val = (int) $one_val;
            if( strlen($minV) && $one_val < (int) $minV ) throw new ValidationException($this->fieldName,
                                                                                        $translator->translate('err_field_invalidvalue',$this->label));
            if( strlen($maxV) && $one_val > (int) $maxV ) throw new ValidationException($this->fieldName,
                                                                                        $translator->translate('err_field_invalidvalue',$this->label));
        }
    }
}
