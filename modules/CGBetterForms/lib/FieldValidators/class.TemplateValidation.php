<?php
namespace CGBetterForms\FieldValidators;
use \CGBetterForms\utils;

class TemplateValidation extends Validation
{
    private $_template;

    public function __get( $key )
    {
        switch( $key ) {
        case 'template':
            return trim($this->_template);
        }
    }

    public function get_display_string( \CGBetterForms\Translator $tr )
    {
        return $tr->translate('display_TemplateValidation');
    }

    public function set_template($val)
    {
        $this->_template = trim($val);
    }

    public function validate(\CGBetterForms\Form $form, \CGBetterForms\FormResponse& $response, \CGBetterForms\Translator $translator )
    {
        if( !$this->_template ) return;
        $out = utils::process_template( $this->_template, $form, $response );
        $out = trim($out);
        if( $out ) throw new ValidationException(\CGBetterForms\FieldError::NONSPECIFIC_FIELD,$out);
    }
}
