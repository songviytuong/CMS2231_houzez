<?php
namespace CGBetterForms;

class FormImporter
{
    private $_mod;
    private $_storage;
    private $_must_create_template;
    private $_validation_list;
    private $_disposition_list;
    private $_name_data;
    private $_template_data;
    private $_template_name_data;
    private $_form_data;

    public function __construct( \CGBetterForms $mod, FormStorageInterface $storage, $data )
    {
        $this->_mod = $mod;
        $this->_storage = $storage;
        if( !$this->expand( $data ) ) throw new \RuntimeException($this->_mod->Lang('err_import_format'));
    }

    public function set_create_template_flag( $flag = true )
    {
        $this->_always_create_template = (bool) $flag;
    }

    public function set_replace_form_flag( $flag = true )
    {
        $this->_replace_existing_form = (bool) $flag;
    }

    protected function expand( $data )
    {
        if( !is_string($data) ) return FALSE;
        $delim = '~~~';
        if( !startswith( $data, 'CGBF'.$delim ) ) return FALSE;
        $parts = explode( $delim, $data );
        if( count($parts) != 10 ) return FALSE;
        if( (int) $parts[1] != 1 ) return FALSE;

        $tpl_name_data = $parts[9];
        $disposition_list_data = $parts[8];
        $validation_list_data = $parts[7];
        $template_data = $parts[6];
        $form_data = $parts[5];
        $cksum_form = $parts[4];
        $cksum_template = $parts[3];
        $name_data = $parts[2];

        $salt_form = md5($template_data);
        $salt_template = md5($form_data);
        if( $cksum_template != md5($template_data.$salt_template) ) return FALSE;
        if( $cksum_form != md5($form_data.$salt_form) ) return FALSE;

        $this->_name_data = $name_data;
        $this->_disposition_list = unserialize( base64_decode( $disposition_list_data ) );
        $this->_validation_list = unserialize( base64_decode( $validation_list_data ) );
        $this->_template_name_data = base64_decode( $tpl_name_data );
        $this->_template_data = base64_decode( $template_data );
        $this->_form_data = unserialize( base64_decode( $form_data ) );
        return TRUE;
    }

    protected function validate_dependencies()
    {
        // given the disposition list, and the validation list
        // makes ure we have all of those classes.
        foreach( $this->_validation_list as $class_name ) {
            if( !class_exists( $class_name ) ) throw new \RuntimeException($this->Lang('err_import_validation_notfound',$class_name) );
        }
        foreach( $this->_disposition_list as $class_name ) {
            if( !class_exists( $class_name ) ) throw new \RuntimeException($this->Lang('err_import_disposition_notfound',$class_name) );
        }
    }

    protected function form_template_exists( $in_tpl_name )
    {
        // check if a template by this name exists and is of the same type.
        try {
            $tpl = \CmsLayoutTemplate::load( $in_tpl_name );
            $type = \CmsLayoutTemplateType::load('CGBetterForms::Form');
            if( $tpl->get_type_id() != $type->get_id() ) return false;
        }
        catch( \CmsDataNotFoundException $e ) {
            // template name does not exist.
            return false;
        }
        return true;
    }

    protected function import_template()
    {
        // check if the template name exists.
        // if it does, then depending on the type our flag, we can import new or overwrite
        $in_tpl_name = $this->_template_name_data;

        // have to create a new template.
        $type = \CmsLayoutTemplateType::load('CGBetterForms::Form');
        $new_name = \CmsLayoutTemplate::generate_unique_name( $in_tpl_name );
        $tpl = new \CmsLayoutTemplate;
        $tpl->set_name( $new_name );
        $tpl->set_type( $type );
        $tpl->set_content( $this->_template_data );
        $tpl->save();
        return $tpl->get_id();
    }

    public function import()
    {
        $this->validate_dependencies();

        $existing_tpl_id = null;
        $in_form_name = base64_decode( $this->_name_data );

        $i = 1;
        $name = null;
        while( $i < 100 ) {
            $name = $in_form_name;
            if( $i > 1 ) $name = $in_form_name.' '.$i;
            if( !$this->_storage->exists( $name ) ) break;
            $i++;
        }

        // next create the template, and import
        //$tpl_id = $this->import_template();
        $tpl_id = $this->import_template();

        // find a new form name.
        $newform = clone $this->_form_data;
        unset( $form );
        $newform->adjustWith( ['name'=>$name, 'template_id'=>$tpl_id ] );
        return $newform;
    }
} // class