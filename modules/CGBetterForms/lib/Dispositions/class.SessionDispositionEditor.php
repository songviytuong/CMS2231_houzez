<?php
namespace CGBetterForms\Dispositions;
use \CGBetterForms\Form;

class SessionDispositionEditor extends DispositionEditor
{
    private $_disp;

    public function __construct(\CGBetterForms $mod )
    {
        $this->_mod = $mod;
        $this->_disp = new SessionDisposition;
    }

    public function get_name()
    {
        return $this->_mod->Lang('name_SessionDisposition');
    }

    public function get_displaystring()
    {
        return $this->_mod->Lang('name_SessionDisposition');
    }

    public function get_disposition()
    {
        return $this->_disp;
    }

    public function set_disposition( Disposition $disp )
    {
        if( ! $disp instanceof SessionDisposition ) throw new \LogicException('object of type '.get_class($disp).' passed to '.__METHOD__);
        $this->_disp = $disp;
    }

    public function get_outputclass()
    {
        return get_class($this->_disp);
    }

    public function has_interface()
    {
        return FALSE;
    }

    public function handle_edit_form( array $params, \CGBetterForms\Form $form, $form_guid, $disp_guid )
    {
        // do nothing, no interface.
    }
} // end of class.