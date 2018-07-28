<?php
namespace CGBetterForms\Dispositions;
use \CGBetterForms\Form;

class EmailUserAddressDispositionEditor extends DispositionEditor
{
    private $_disp;
    private $_mod;

    public function __construct(\CGBetterForms $mod )
    {
        $this->_mod = $mod;
        $this->_disp = new EmailUserAddressDisposition;
    }

    public function __get($key)
    {
        switch( $key ) {
        case 'fieldname':
        case 'subjecttemplate':
        case 'bodytemplate':
            return $this->_disp->$key;
        }
    }

    public function set_fieldname( $str )
    {
        return $this->_disp->set_fieldname( $str );
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
        return $this->_mod->Lang('name_EmailUserAddressDisposition');
    }

    public function get_displaystring()
    {
        $fieldname = $this->_disp->get_fieldname();
        return $this->_mod->Lang('display_EmailUserAddressDisposition',$fieldname);
    }

    public function get_disposition()
    {
        return $this->_disp;
    }

    public function set_disposition( Disposition $disp )
    {
        if( ! $disp instanceof EmailUserAddressDisposition ) throw new \LogicException('object of type '.get_class($disp).' passed to '.__METHOD__);
        $this->_disp = $disp;
    }

    public function get_outputclass()
    {
        return 'CGBetterForms\\Dispositions\\EmailUserAddressDisposition';
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
            $this->set_fieldname(\cge_param::get_string($params,'fieldname'));
            $this->set_subjecttemplate(\cge_param::get_string($params,'subjecttemplate'));
            $this->set_bodytemplate(\cge_utils::get_param($params,'bodytemplate'));
            $this->get_helper()->finish( $form, $form_guid, $this->get_disposition(), $disp_guid );
        }

        $tpl = $mod->CreateSmartyTemplate('admin_edit_emailuseraddress_disposition.tpl');
        $tpl->assign('editor_name',get_class($this));
        $tpl->assign('field_list',$form->list_fields_by_type_or_primitive('email','email'));
        $tpl->assign('handler',$this);
        $tpl->assign('form_guid',$form_guid);
        $tpl->assign('guid',$disp_guid);
        $tpl->assign('tpl_help',\CGBetterForms\utils::get_form_tpl_help( $form ));
        $tpl->display();
    }
} // end of class
