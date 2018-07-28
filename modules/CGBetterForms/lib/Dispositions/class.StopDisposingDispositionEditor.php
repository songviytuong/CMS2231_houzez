<?php
namespace CGBetterForms\Dispositions;
use \CGBetterForms\Form;

class StopDisposingDispositionEditor extends DispositionEditor
{
    private $_disp;
    private $_mod;

    public function __construct(\CGBetterForms $mod )
    {
        $this->_mod = $mod;
        $this->_disp = new StopDisposingDisposition;
    }

    public function __get($key)
    {
        switch( $key ) {
        case 'tpl':
        case 'template':
            return $this->_disp->template;
        }
    }

    public function set_template( $str )
    {
        $this->_disp->set_template( $str );
    }

    public function get_name()
    {
        return $this->_mod->Lang('name_StopDisposingDisposition');
    }

    public function get_displaystring()
    {
        return $this->_mod->Lang('display_StopDisposingDisposition');
    }

    public function get_settings_form_url(array $params = null)
    {
        return $this->_mod->create_url( 'm1_', 'admin_edit_ddfile_disposition', '', $params);
    }

    public function get_disposition()
    {
        return $this->_disp;
    }

    public function set_disposition( Disposition $disp )
    {
        if( ! $disp instanceof StopDisposingDisposition ) throw new \LogicException('object of type '.get_class($disp).' passed to '.__METHOD__);
        $this->_disp = $disp;
    }

    public function get_outputclass()
    {
        return 'CGBetterForms\\Dispositions\\StopDisposingDisposition';
    }

    public function handle_edit_form(array $params, \CGBetterForms\Form $form, $form_guid, $disp_guid)
    {
        $mod = $this->_mod;

        if( \cge_param::exists($params,'cancel') ) {
            $this->get_helper()->cancel( $form_guid );
        }
        if( \cge_param::exists($params,'submit') ) {
            $this->set_template(\cge_param::get_string($params,'template'));

            // now have the disposition object, store it.
            // todo: $this->finish_editing_session();
            $this->get_helper()->finish( $form, $form_guid, $this->get_disposition(), $disp_guid );
        }

        $tpl = $mod->CreateSmartyTemplate('admin_edit_stopdisposing_disposition.tpl');
        $tpl->assign('editor_name',get_class($this));
        $tpl->assign('handler',$this->_disp);
        $tpl->assign('form_guid',$form_guid);
        $tpl->assign('guid',$disp_guid);
        $tpl->assign('tpl_help',\CGBetterForms\utils::get_form_tpl_help( $form ));
        $tpl->display();
    }
} // end of class
