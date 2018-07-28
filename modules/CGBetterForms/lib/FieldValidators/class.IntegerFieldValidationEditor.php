<?php
namespace CGBetterForms\FieldValidators;
use \CGBetterForms\utils;

class IntegerFieldValidationEditor extends ValidationEditor
{
    private $_validator;
    private $_mod;

    public function __construct( \CGBetterForms $mod )
    {
        $this->_mod = $mod;
        $this->_validator = new IntegerFieldValidation;
    }

    public function get_name()
    {
        return $this->_mod->Lang('name_IntegerFieldValidator');
    }

    public function get_validation()
    {
        return $this->_validator;
    }

    public function set_validation( Validation $in )
    {
        if( ! $in instanceof IntegerFieldValidation ) throw new \LogicException('Invalid validation passed to '.__METHOD__);
        $this->_validator = $in;
    }

    public function get_outputclass()
    {
        return get_class($this->_validator);
    }

    public function get_displaystring()
    {
        return $this->_validator->get_display_string( $this->_mod->get_translator() );
    }

    public function allows_multiple()
    {
        return FALSE;
    }

    public function set_field( $fieldname )
    {
        $fieldname = trim($fieldname);
        if( !$fieldname ) throw new \LogicException('The field name for an IntegerFieldValidation cannot be empty');

        $this->_validator->set_fieldName($fieldname);
    }

    public function set_minValue( $val )
    {
        $val = trim( $val );
        if( strlen($val) ) {
            $this->_validator->set_minValue((int) $val);
        } else {
            $this->_validator->set_minValue(null);
        }
    }

    public function set_maxValue( $val )
    {
        $val = trim( $val );
        if( strlen($val) ) {
            $this->_validator->set_maxValue((int) $val);
        } else {
            $this->_validator->set_maxValue(null);
        }
    }

    public function handle_edit_form( array $params, \CGBetterForms\Form $form, $form_guid, $guid )
    {
        $mod = $this->_mod;

        if( \cge_param::exists($params,'cancel') ) {
            $this->get_helper()->cancel( $form_guid );
        }
        if( \cge_param::exists($params,'submit') ) {
            $this->set_field(\cge_param::get_string($params,'fieldname'));
            $this->set_minValue(\cge_param::get_string($params,'minValue'));
            $this->set_maxValue(\cge_param::get_string($params,'maxValue'));

            // now have the disposition object, store it.
            $this->get_helper()->finish( $form, $form_guid, $this->get_validation(), $guid );
        }

        $tpl = $mod->CreateSmartyTemplate('admin_edit_integerfieldvalidation.tpl');
        $tpl->assign('editor_name',get_class($this));
        $tpl->assign('handler',$this);
        $tpl->assign('form_guid',$form_guid);
        $tpl->assign('guid',$guid);
        $tpl->assign('fields',$form->get_field_list());
        $tpl->assign('validation',$this->get_validation());
        $tpl->assign('tpl_help',utils::get_form_tpl_help( $form) );
        $tpl->display();
    }
} // end of class
