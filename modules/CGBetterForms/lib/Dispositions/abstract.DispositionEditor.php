<?php
namespace CGBetterForms\Dispositions;

abstract class DispositionEditor
{
    private $_helper;

    abstract public function get_name();
    abstract public function get_disposition();
    abstract public function set_disposition( Disposition $in );
    abstract public function get_outputclass();
    abstract public function handle_edit_form( array $params, \CGBetterForms\Form $form, $form_guid, $disp_guid );

    public function has_interface() { return TRUE; }

    public function set_helper_proxy( \CGBetterForms\DispositionEditorHelperProxy $proxy )
    {
        $this->_helper = $proxy;
    }

    protected function get_helper()
    {
        return $this->_helper;
    }
} // end of interface
