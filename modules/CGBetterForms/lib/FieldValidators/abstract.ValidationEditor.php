<?php
namespace CGBetterForms\FieldValidators;

abstract class ValidationEditor
{
    private $_helper;

    abstract public function get_name();
    abstract public function get_validation();
    abstract public function set_validation( Validation $in );
    abstract public function get_outputclass();
    abstract public function get_displaystring();
    public function allows_multiple() { return TRUE; }
    public function has_interface() { return TRUE; }
    abstract public function handle_edit_form( array $params, \CGBetterForms\Form $form, $form_guid, $guid );

    public function set_helper_proxy( \CGBetterForms\ValidationEditorHelperProxy $proxy )
    {
        $this->_helper = $proxy;
    }

    protected function get_helper()
    {
        return $this->_helper;
    }
} // end of interface
