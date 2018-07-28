<?php
namespace CGBetterForms\FieldValidators;

class SelectFieldValidationEditor extends ValidationEditor
{
    private $_validator;
    private $_mod;

    public function __construct( \CGBetterForms $mod )
    {
        $this->_mod = $mod;
        $this->_validator = new SelectFieldValidation;
    }

    public function get_name()
    {
        return $this->_mod->Lang('name_SelectFieldValidator');
    }

    public function get_validation()
    {
        return $this->_validator;
    }

    public function set_validation( Validation $in )
    {
        if( ! $in instanceof SelectFieldValidation ) throw new \LogicException('Invalid validation passed to '.__METHOD__);
        $this->_validator = $in;
    }

    public function has_interface() { return FALSE; }
    public function handle_edit_form( array $params, \CGBetterForms\Form $form, $form_guid, $guid ) {}

    public function get_outputclass()
    {
        return get_class($this->_validator);
    }

    public function get_displaystring()
    {
        return $this->_validator->get_display_string( $this->_mod->get_translator() );
    }

    public function allows_multiple()
    {
        return FALSE;
    }
} // end of class
