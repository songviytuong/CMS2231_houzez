<?php
namespace CGBetterForms\Dispositions;
use \CGBetterForms\Form;

class DropdownEmailDispositionEditor extends DispositionEditor
{
    private $_disp;
    private $_mod;

    public function __construct(\CGBetterForms $mod )
    {
        $this->_mod = $mod;
        $this->_disp = new DropdownEmailDisposition;
    }

    public function __get($key)
    {
        switch( $key ) {
        case 'field':
        case 'dflt_address':
        case 'subjecttemplate':
        case 'value_map':
        case 'bodytemplate':
            return $this->_disp->$key;
        case 'value_map_array':
            return $this->from_text($this->value_map);
        }
    }

    protected function from_text($map_text)
    {
        $out = [];
        $lines = explode("\n",$map_text);
        foreach( $lines as $line ) {
            $line = trim($line);
            if( !$line ) continue;
            $parts = explode("|",$line,2);
            if( count($parts) != 2 ) continue;
            $key = trim($parts[0]);
            $val = trim($parts[1]);
            $out[$key] = $val;
        }
        return $out;
    }

    public function set_field( $fieldname )
    {
        $this->_disp->set_field( $fieldname );
    }

    public function set_dflt_address( $data )
    {
        $this->_disp->set_dflt_address( $data );
    }

    public function set_value_map( $data )
    {
        $this->_disp->set_value_map( $data );
    }

    public function set_subjecttemplate( $data )
    {
        $this->_disp->set_subjecttemplate( $data );
    }

    public function set_bodytemplate( $data )
    {
        $this->_disp->set_bodytemplate( $data );
    }

    public function reset_templates( Form $form )
    {
        $tmp = null;
        foreach( $form->fields as $field ) {
            $name = $field->name;
            $label = $field->label;
            if( !$label ) $label = $name;

            $valstr = null;
            if( $field->multiple ) {
                $valstr = "\"{if !empty(\$$name)}{implode('+',\$$name)}{/if}\"\n";
            } else {
                $valstr = '"{$'.$name.'|default:\'\'}"'."\n";
            }
            $tmp .= "<p><strong>{$label}</strong> <span>{$valstr}</span></p>\n";
        }
        $this->set_subjecttemplate( 'New form submission');
        $this->set_bodytemplate( "{strip}{$tmp}{/strip}" );
    }

    public function get_name()
    {
        return $this->_mod->Lang('name_DropdownEmailDisposition');
    }

    public function get_displaystring()
    {
        return $this->_mod->Lang('display_DropdownEmailDisposition',$this->field);
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
        if( ! $disp instanceof DropdownEmailDisposition ) throw new \LogicException('object of type '.get_class($disp).' passed to '.__METHOD__);
        $this->_disp = $disp;
    }

    public function get_outputclass()
    {
        return 'CGBetterForms\\Dispositions\\DropdownEmailDisposition';
    }

    public function handle_edit_form(array $params, \CGBetterForms\Form $form, $form_guid, $disp_guid)
    {
        $mod = $this->_mod;

        if( !$disp_guid ) $this->reset_templates( $form );

        if( \cge_param::exists($params,'cancel') ) {
            $this->get_helper()->cancel( $form_guid );
        }
        if( \cge_param::exists($params,'reset_tpl') ) {
            $this->reset_templates( $form );
        }
        if( \cge_param::exists($params,'submit') ) {
            $this->set_field(\cge_param::get_string($params,'field'));
            $this->set_dflt_address(\cge_param::get_string($params,'dflt_address'));
            $this->set_value_map(\cge_param::get_string($params,'value_map'));
            $this->set_subjecttemplate(\cge_utils::get_param($params,'subjecttemplate'));
            $this->set_bodytemplate(\cge_utils::get_param($params,'bodytemplate'));

            // now have the disposition object, store it.
            // todo: $this->finish_editing_session();
            $this->get_helper()->finish( $form, $form_guid, $this->get_disposition(), $disp_guid );
        }

        $tpl = $mod->CreateSmartyTemplate('admin_edit_ddemail_disposition.tpl');
        $tpl->assign('select_fields',$form->get_multioption_fields(TRUE));
        $tpl->assign('editor_name',get_class($this));
        $tpl->assign('handler',$this);
        $tpl->assign('form_guid',$form_guid);
        $tpl->assign('guid',$disp_guid);
        $tpl->assign('tpl_help',\CGBetterForms\utils::get_form_tpl_help( $form ));
        $tpl->display();
    }
} // end of class
