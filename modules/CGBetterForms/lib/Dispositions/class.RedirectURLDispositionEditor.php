<?php
namespace CGBetterForms\Dispositions;
use \CGBetterForms\Form;

class RedirectURLDispositionEditor extends DispositionEditor
{
    private $_disp;
    private $_mod;

    public function __construct(\CGBetterForms $mod )
    {
        $this->_mod = $mod;
        $this->_disp = new RedirectURLDisposition;
    }

    public function __get($key)
    {
        switch( $key ) {
        case 'tpl':
            return $this->_disp->tpl;
        }
    }

    public function set_tpl( $tpl )
    {
        return $this->_disp->set_tpl( $tpl );
    }

    public function get_name()
    {
        return $this->_mod->Lang('name_RedirectURLDisposition');
    }

    public function get_displaystring()
    {
        return $this->_mod->Lang('display_RedirectURLDisposition',$this->url);
    }

    public function get_disposition()
    {
        return $this->_disp;
    }

    public function set_disposition( Disposition $disp )
    {
        if( ! $disp instanceof RedirectURLDisposition ) throw new \LogicException('object of type '.get_class($disp).' passed to '.__METHOD__);
        $this->_disp = $disp;
    }

    public function get_outputclass()
    {
        return 'CGBetterForms\\Dispositions\\RedirectURLDisposition';
    }

    public function handle_edit_form(array $params, \CGBetterForms\Form $form, $form_guid, $disp_guid )
    {
        $mod = $this->_mod;

        if( \cge_param::exists( $params, 'cancel' ) ) {
            $this->get_helper()->cancel( $form_guid );
        }
        if( \cge_param::exists($params,'submit') ) {
            $this->set_tpl(\cge_param::get_string($params,'tpl'));
            $this->get_helper()->finish( $form, $form_guid, $this->get_disposition(), $disp_guid );
        }

        $tpl = $mod->CreateSmartyTemplate('admin_edit_redirecturl_disposition.tpl');
        $tpl->assign('editor_name',get_class($this));
        $tpl->assign('handler',$this);
        $tpl->assign('form_guid',$form_guid);
        $tpl->assign('guid',$disp_guid);
        $tpl->assign('tpl_help',\CGBetterForms\utils::get_form_tpl_help( $form ));
        $tpl->display();
    }
} // end of class
