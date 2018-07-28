<?php
namespace CGBetterForms;

class ValidationEditorHelperProxy
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
        $this->_mod->Redirect('m1_','admin_edit_form', '', ['form_guid'=>$form_guid, 'cg_activetab'=>'validation'] );
    }

    public function finish( Form $form, $form_guid, FieldValidators\IValidation $validator, $guid )
    {
        if( !$form_guid ) throw new \LogicException('No form_guid passed to '.__METHOD__);
        $form_guid = \CGBetterForms\utils::store_object( $form, $form_guid );
        $guid = \CGBetterForms\utils::store_object( $validator, $guid );
        $this->_mod->SetMessage($this->_mod->Lang('msg_validation_saved'));
        $this->_mod->Redirect( 'm1_', 'admin_edit_form', '', [ 'form_guid'=>$form_guid, 'validator_guid'=>$guid, 'cg_activetab'=>'validation' ] );
    }
}