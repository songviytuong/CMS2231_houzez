<?php
namespace CGBetterForms;

final class utils
{
    private static $_translator;
    private function __construct() {}

    public static function set_translator(Translator $tr)
    {
        self::$_translator = $tr;
    }

    private static function tr(/* var args */)
    {
        $args = func_get_args();
        if( is_array($args) && count($args) == 1 && is_array($args[0]) ) $args = $args[0];
        return self::$_translator->translate( $args );
    }

    public static function mkdir($dir)
    {
        if( !self::is_cmsms_relative( $dir ) ) throw new SecurityException(self::tr('err_security_mkdir_notrelative'));

        if( is_file( $dir ) ) throw new \LogicException(self::tr('err_security_mkdir_fileexists'));
        if( !is_dir( $dir ) ) {
            $res = mkdir( $dir );
            if( !$res ) throw new \LogicException('SYSTEM ERROR: Could not create directory '.$dir);
        }
        if( !is_file($dir.'/index.html') && !is_file($dir.'/index.php') ) file_put_contents( $dir.'/index.html','<!-- DUMMY HTML -->');
    }

    private static function mkdir_parent($dir)
    {
        $parent = dirname($dir);
        if( !is_dir($parent) ) {
            self::mkdir_parent($parent);
        } else {
            if( !is_writable( $parent ) ) throw new \LogicException('SYSTEM ERROR: Could not create directory in '.$parent);
        }
        self::mkdir( $dir );
    }

    public static function mkdirr($dir)
    {
        if( !self::is_cmsms_relative( $dir ) ) throw new SecurityException(self::tr('err_security_mkdir_notrelative'));
        if( is_file( $dir ) ) throw new \LogicException(self::tr('err_security_mkdir_fileexists'));
        self::mkdir_parent( $dir );
    }

    public static function list_suitable_templates()
    {
        // get the generic template type
        $type = \CmsLayoutTemplateType::load('CGBetterForms::Form');
        $qry = new \CmsLayoutTemplateQuery(['t:'.$type->get_id()]);
        $tmp = $qry->GetMatches();
        if( !count($tmp) ) return;

        $out = [];
        foreach( $tmp as $obj ) {
            $out[$obj->get_id()] = $obj->get_name();
        }
        return $out;
    }

    public static function list_validation_editors(array $editors)
    {
        $out = [];
        foreach( $editors as $class => $one ) {
            if( ! $one instanceof FieldValidators\ValidationEditor ) continue;
            $out[$class] = $one->get_name();
        }
        return $out;
    }

    public static function list_disposition_editors(array $dispositions)
    {
        $out = [];
        foreach( $dispositions as $class => $one ) {
            if( ! $one instanceof Dispositions\DispositionEditor ) continue;
            $out[$class] = $one->get_name();
        }
        return $out;
    }

    public static function store_object( $data, $key = null )
    {
        if( !$key ) $key = \cge_utils::create_guid();
        $_SESSION[$key] = serialize($data);
        return $key;
    }

    public static function retrieve_object( $key )
    {
        $obj = null;
        if( isset($_SESSION[$key]) ) $obj = unserialize($_SESSION[$key]);
        return $obj;
    }

    public static function remove_stored_object( $key )
    {
        if( isset($_SESSION[$key]) ) unset($_SESSION[$key]);
    }

    public static function is_cmsms_relative( $file )
    {
        $file = trim($file);
        if( !$file ) return;
        $config = \cms_config::get_instance();

        if( startswith( $file, $config['root_path'] ) ) return TRUE;
    }

    public static function can_write_file( $file )
    {
        $file = trim($file);
        if( !$file ) return;

        if( is_file($file) ) {
            if( is_writable( $file) ) return TRUE;
            return FALSE;
        }
        $dir = dirname($file);
        if( !is_dir( $dir) ) return FALSE;
        if( !is_writable( $dir ) ) return FALSE;
        return TRUE;
    }

    public static function process_template( $template_text, Form $form, FormResponse $response )
    {
        $template_text = trim($template_text);
        if( !$template_text ) return;

        $smarty = \cms_utils::get_smarty();
        $mod = \cms_utils::get_module(MOD_CGBETTERFORMS);
        $tpl = $smarty->CreateTemplate('string:'.$template_text);
        $tpl->assign('mod',$mod);
        $tpl->assign('form',$form);
        $tpl->assign('response',$response);
        $tpl->assign('EOL',PHP_EOL);
        $tpl->assign('LF',"\n");
        $tpl->assign('TAB',"\t");
        foreach( $response->list_fields() as $field_name ) {
            if( $form->is_file_field( $field_name) ) {
                $val = $response->get_file_as_url( $field_name );
                $tpl->assign($field_name,$val);
            }
            else {
                $val = $response->get_field_value( $field_name );
                $tpl->assign('_'.$field_name, $val);
                $val = $form->get_human_readable_field_value( $field_name, $val );
                $tpl->assign($field_name, $val);
            }
        }
        return $tpl->fetch();
    }

    public static function get_form_tpl_help( Form $form )
    {
        $mod = \cms_utils::get_module(MOD_CGBETTERFORMS);
        $field_names = $form->get_fieldnames();
        $vars = [];

        foreach( $field_names as $name ) {
            $field = $form->get_field($name);
            $obj = new \StdClass;
            $obj->key = $name;
            $obj->type = $field->primitive;
            if( $field->multiple ) $obj->type .= '[]';
            $vars[] = $obj;

            $obj = new \StdClass;
            $obj->key = '_'.$name;
            $obj->type = $field->primitive;
            $obj->desc = "Raw submitted value for the $name field";
            $vars[] = $obj;
        }

        $obj = new \StdClass;
        $obj->key = 'cgbf_submit_time';
        $obj->type = 'int';
        $obj->desc = $mod->Lang('varhelp_cgbf_submit_time');
        $vars[] = $obj;

        $obj = new \StdClass;
        $obj->key = 'cgbf_submit_ip';
        $obj->type = 'string';
        $obj->desc = $mod->Lang('varhelp_cgbf_submit_ip');
        $vars[] = $obj;

        $obj = new \StdClass;
        $obj->key = 'cgbf_version';
        $obj->type = 'string';
        $obj->desc = $mod->Lang('varhelp_cgbf_version');

        $obj = new \StdClass;
        $obj->key = 'cgbf_formname';
        $obj->type = 'string';
        $obj->desc = $mod->Lang('varhelp_cgbf_formname');
        $vars[] = $obj;

        $obj = new \StdClass;
        $obj->key = 'cgbf_formdesn';
        $obj->type = 'string';
        $obj->desc = $mod->Lang('varhelp_cgbf_formdesc');
        $vars[] = $obj;

        $obj = new \StdClass;
        $obj->key = 'cgbf_requestid';
        $obj->type = 'string';
        $obj->desc = $mod->Lang('varhelp_cgbf_requestid');
        $vars[] = $obj;

        $obj = new \StdClass;
        $obj->key = 'response';
        $obj->type = 'object';
        $obj->desc = $mod->Lang('varhelp_response');
        $vars[] = $obj;

        $obj = new \StdClass;
        $obj->key = 'form';
        $obj->type = 'object';
        $obj->desc = $mod->Lang('varhelp_form');
        $vars[] = $obj;

        $obj = new \StdClass;
        $obj->key = 'EOL';
        $obj->type = 'string';
        $obj->desc = $mod->Lang('varhelp_cgbf_EOL');
        $vars[] = $obj;

        $obj = new \StdClass;
        $obj->key = 'LF';
        $obj->type = 'string';
        $obj->desc = $mod->Lang('varhelp_cgbf_LF');
        $vars[] = $obj;

        $obj = new \StdClass;
        $obj->key = 'TAB';
        $obj->type = 'string';
        $obj->desc = $mod->Lang('varhelp_cgbf_TAB');
        $vars[] = $obj;

        $tpl = $mod->CreateSmartyTemplate('admin_varhelp.tpl');
        $tpl->assign('vars',$vars);
        return $tpl->fetch();
    }

    public static function get_mailer( Form $form )
    {
        $mailer = new \cms_mailer;
        $mailer->IsHTML(TRUE);
        $addr = $form->email_from_addr;
        $name = $form->email_from_name;
        if( $addr ) {
            $mailer->AddReplyTo( $addr, $name );
        }
        return $mailer;
    }
} // end of class
