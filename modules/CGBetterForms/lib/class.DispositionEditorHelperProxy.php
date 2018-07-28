<?php
namespace CGBetterForms;

class DispositionEditorHelperProxy
{
    private $_mod;

    public function __construct( \CGBetterForms $mod )
    {
        $this->_mod = $mod;
    }

    public function cancel( $form_guid )
    {
        if( !$form_guid ) throw new \LogicException('No form_guid passed to '.__METHOD__);
        $this->_mod->SetMessage($this->_mod->Lang('msg_cancelled'));
        $this->_mod->Redirect('m1_','admin_edit_form', '', ['form_guid'=>$form_guid, 'cg_activetab'=>'handlers'] );
    }

    public function finish( Form $form, $form_guid, Dispositions\IDisposition $disp, $disp_guid )
    {
        if( !$form_guid ) throw new \LogicException('No form_guid passed to '.__METHOD__);
        $form_guid = \CGBetterForms\utils::store_object( $form, $form_guid );
        $disp_guid = \CGBetterForms\utils::store_object( $disp, $disp_guid );
        $this->_mod->SetMessage($this->_mod->Lang('msg_handler_saved'));
        $this->_mod->Redirect( 'm1_', 'admin_edit_form', '', [ 'form_guid'=>$form_guid, 'disp_guid'=>$disp_guid, 'cg_activetab'=>'handlers'] );
    }
}