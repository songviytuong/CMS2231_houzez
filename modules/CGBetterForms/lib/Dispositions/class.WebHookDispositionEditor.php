<?php
namespace CGBetterForms\Dispositions;
use \CGBetterForms\Form;

class WebHookDispositionEditor extends DispositionEditor
{
    private $_disp;
    private $_mod;

    public function __construct(\CGBetterForms $mod )
    {
        $this->_mod = $mod;
        $this->_disp = new WebHookDisposition;
    }

    public function __get($key)
    {
        switch( $key ) {
        case 'url':
        case 'extrapostvars':
            return $this->_disp->$key;
        }
    }

    public function set_url( $str )
    {
        return $this->_disp->set_url( $str );
    }

    public function set_extrapostvars( $data )
    {
        return $this->_disp->set_extrapostvars( $data );
    }

    public function get_name()
    {
        return $this->_mod->Lang('name_WebHookDisposition');
    }

    public function get_displaystring()
    {
        return $this->_mod->Lang('display_WebHookDisposition',$this->url);
    }

    public function get_disposition()
    {
        return $this->_disp;
    }

    public function set_disposition( Disposition $disp )
    {
        if( ! $disp instanceof WebHookDisposition ) throw new \LogicException('object of type '.get_class($disp).' passed to '.__METHOD__);
        $this->_disp = $disp;
    }

    public function get_outputclass()
    {
        return 'CGBetterForms\\Dispositions\\WebHookDisposition';
    }

    public function handle_edit_form(array $params, \CGBetterForms\Form $form, $form_guid, $disp_guid )
    {
        $mod = $this->_mod;

        if( \cge_param::exists( $params, 'cancel' ) ) {
            $this->get_helper()->cancel( $form_guid );
        }
        if( \cge_param::exists($params,'submit') ) {
            $this->set_url(\cge_param::get_string($params,'url'));
            $this->set_extrapostvars(\cge_param::get_string($params,'extrapostvars'));
            $this->get_helper()->finish( $form, $form_guid, $this->get_disposition(), $disp_guid );
        }

        $tpl = $mod->CreateSmartyTemplate('admin_edit_webhook_disposition.tpl');
        $tpl->assign('editor_name',get_class($this));
        $tpl->assign('handler',$this);
        $tpl->assign('form_guid',$form_guid);
        $tpl->assign('guid',$disp_guid);
        $tpl->display();
    }
} // end of class
