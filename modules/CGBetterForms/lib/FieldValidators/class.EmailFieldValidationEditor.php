<?php
namespace CGBetterForms\FieldValidators;

class EmailFieldValidationEditor extends ValidationEditor
{
    private $_validator;
    private $_mod;

    public function __construct( \CGBetterForms $mod )
    {
        $this->_mod = $mod;
        $this->_validator = new EmailFieldValidation;
    }

    public function get_name()
    {
        return $this->_mod->Lang('name_EmailFieldValidator');
    }

    public function get_validation()
    {
        return $this->_validator;
    }

    public function set_validation( Validation $in )
    {
        if( ! $in instanceof EmailFieldValidation ) throw new \LogicException('Invalid validation passed to '.__METHOD__);
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
        if( !$fieldname ) throw new \LogicException('The field name for a EmailFieldValidation cannot be empty');

        $this->_validator->set_fieldName($fieldname);
    }

    public function handle_edit_form( array $params, \CGBetterForms\Form $form, $form_guid, $guid )
    {
        $mod = $this->_mod;

        if( \cge_param::exists($params,'cancel') ) {
            $this->get_helper()->cancel( $form_guid );
        }
        if( \cge_param::exists($params,'submit') ) {
            $this->set_field(\cge_param::get_string($params,'fieldname'));

            // now have the disposition object, store it.
            $this->get_helper()->finish( $form, $form_guid, $this->get_validation(), $guid );
        }

        $tpl = $mod->CreateSmartyTemplate('admin_edit_emailfieldvalidation.tpl');
        $tpl->assign('editor_name',get_class($this));
        $tpl->assign('handler',$this);
        $tpl->assign('form_guid',$form_guid);
        $tpl->assign('guid',$guid);
        $tpl->assign('fields',$form->get_field_list());
        $tpl->assign('validation',$this->get_validation());
        $tpl->display();
    }
} // end of class
