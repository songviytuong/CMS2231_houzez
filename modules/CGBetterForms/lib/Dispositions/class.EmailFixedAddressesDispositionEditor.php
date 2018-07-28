<?php
namespace CGBetterForms\Dispositions;
use \CGBetterForms\Form;

class EmailFixedAddressesDispositionEditor extends DispositionEditor
{
    private $_disp;
    private $_mod;

    public function __construct(\CGBetterForms $mod )
    {
        $this->_mod = $mod;
        $this->_disp = new EmailFixedAddressesDisposition;
    }

    public function __get($key)
    {
        switch( $key ) {
        case 'addresses':
        case 'subjecttemplate':
        case 'bodytemplate':
            return $this->_disp->$key;
        }
    }

    public function set_addresses( $str )
    {
        return $this->_disp->set_addresses( $str );
    }

    public function set_subjecttemplate( $data )
    {
        return $this->_disp->set_subjecttemplate( $data );
    }

    public function set_bodytemplate( $data )
    {
        return $this->_disp->set_bodytemplate( $data );
    }

    public function reset_templates( Form $form )
    {
        $this->set_subjecttemplate('Submission from {$response->form_name} form');
        $out = null;
        foreach( $form->fields as $field ) {
            $name = $field->name;
            $label = $field->label;
            if( !$label ) $label = $name;

            if( $field->multiple ) {
                $out .= "{if !empty(\$$name)}<p><strong>$label:</strong> {implode(' + ',\$$name)}</p>{/if}\n";
            } else {
                $out .= "{if !empty(\$$name)}<p><strong>$label:</strong> {\$$name}</p>{/if}\n";
            }
        }
        $this->set_bodytemplate("{strip}\n".$out."{/strip}");
    }

    public function get_name()
    {
        return $this->_mod->Lang('name_EmailFixedAddressesDisposition');
    }

    public function get_displaystring()
    {
        $addresses = $this->_disp->get_addresses();
        if( count($addresses) == 1 ) {
            return $this->_mod->Lang('display_EmailFixedAddressesDisposition1',$addresses[0]);
        } else {
            return $this->_mod->Lang('display_EmailFixedAddressesDisposition2',count($addresses));
        }
    }

    public function get_disposition()
    {
        return $this->_disp;
    }

    public function set_disposition( Disposition $disp )
    {
        if( ! $disp instanceof EmailFixedAddressesDisposition ) throw new \LogicException('object of type '.get_class($disp).' passed to '.__METHOD__);
        $this->_disp = $disp;
    }

    public function get_outputclass()
    {
        return 'CGBetterForms\\Dispositions\\EmailFixedAddressesDisposition';
    }

    public function handle_edit_form(array $params, \CGBetterForms\Form $form, $form_guid, $disp_guid )
    {
        $mod = $this->_mod;

        if( !$disp_guid ) $this->reset_templates( $form );

        if( \cge_param::exists( $params, 'cancel' ) ) {
            $this->get_helper()->cancel( $form_guid );
        }
        if( \cge_param::exists($params,'reset_tpl') ) {
            $this->reset_templates( $form );
        }
        if( \cge_param::exists($params,'submit') ) {
            $this->set_addresses(\cge_param::get_string($params,'addresses'));
            $this->set_subjecttemplate(\cge_param::get_string($params,'subjecttemplate'));
            $this->set_bodytemplate(\cge_utils::get_param($params,'bodytemplate'));
            $this->get_helper()->finish( $form, $form_guid, $this->get_disposition(), $disp_guid );
        }

        $tpl = $mod->CreateSmartyTemplate('admin_edit_emailfixedaddresses_disposition.tpl');
        $tpl->assign('editor_name',get_class($this));
        $tpl->assign('handler',$this);
        $tpl->assign('form_guid',$form_guid);
        $tpl->assign('guid',$disp_guid);
        $tpl->assign('tpl_help',\CGBetterForms\utils::get_form_tpl_help( $form ));
        $tpl->display();
    }
} // end of class
