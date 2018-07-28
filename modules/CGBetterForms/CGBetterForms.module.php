<?php
use \CGBetterForms\Dispositions\Disposition;
use \CGBetterForms\Dispositions\DispositionEditor;
use \CGBetterForms\FieldValidators\Validation;
use \CGBetterForms\FieldValidators\ValidationEditor;

final class CGBetterForms extends \CGExtensions
{
    const MANAGE_PERM = 'CGBetterForms::MANAGE_PERM';
    private $_early_formtests = [];
    private $_formtests = [];
    private $_validation_editors = [];
    private $_disp_editors = [];
    private $_captcha_provider;
    protected $_request_errors;
    protected $formstorage;
    protected $translator;
    protected $_in_prerender;
    protected $_prerender_vars;

    public function __construct()
    {
        parent::__construct();

        $smarty = \CmsApp::get_instance()->GetSmarty();
        if( !$smarty ) return;

        $this->formstorage = new \CGBetterForms\FormDAO( $this->GetDb() );
        $this->translator = new \CGBetterForms\Translator( $this );
        $this->register_builtin_form_tests();
        $this->register_builtin_disp_editors();
        $this->register_builtin_validation_editors();
        \CGBetterForms\utils::set_translator( $this->translator );
    }

    public function GetFriendlyName() { return $this->Lang('friendlyname'); }
    public function GetDescription() { return $this->Lang('moddescription'); }
    public function GetVersion() { return '1.3'; }
    public function IsPluginModule() { return TRUE; }
    public function HasAdmin() { return TRUE; }
    public function VisibleToAdminUser() { return $this->CheckPermission(self::MANAGE_PERM); }
    public function MinimumCmsVersion() { return '2.2-beta3'; }
    public function GetDependencies() { return [ 'CGExtensions' => '1.56' ]; }

    public function InitializeAdmin()
    {
        $smarty = CmsApp::get_instance()->GetSmarty();
        $smarty->register_function('cgbf_form_errors', [ $this, 'smarty_cgbf_get_errors'], false );
        $this->CreateParameter('form',null,$this->Lang('param_form'));
        $this->CreateParameter('nodatecheck',0,$this->Lang('param_nodatecheck'));
    }

    public function InitializeFrontend()
    {
        $this->RegisterModulePlugin();
        $this->SetParameterType('form',CLEAN_STRING);
        $this->SetParameterType('nodatecheck',CLEAN_INT);

        $smarty = CmsApp::get_instance()->GetSmarty();
        $smarty->register_function('cgbf_form_errors', [ $this, 'smarty_cgbf_get_errors'], false );
        $smarty->register_function('cgbf_set', [ $this, 'smarty_cgbf_set'], false );
        if( !defined('CGBF_GUID_TOKEN') ) define('CGBF_GUID_TOKEN',md5(__FILE__));

        \CMSMS\Hookmanager::add_hook( 'CGBetterForms::cleanup', function( \CGBetterForms\FormResponse $resp ){
                $guid = $resp->guid;
                $tmp_dir = TMP_CACHE_LOCATION.'/'.$guid;
                if( is_dir( $tmp_dir ) ) recursive_delete( $tmp_dir );
            });
    }

    public function get_translator()
    {
        return $this->translator;
    }

    public function load_form( $name_or_id )
    {
        // accepts int or string
        if( is_int( $name_or_id ) ) return $this->formstorage->load_by_id( $name_or_id );
        return $this->formstorage->load( $name_or_id );
    }

    public function register_formtest( \CGBetterForms\FormValidator\FormTesterTest $test )
    {
        $this->_formtests[] = $test;
    }

    protected function register_early_formtest( \CGBetterForms\FormValidator\FormTesterTest $test )
    {
        $this->_early_formtests[] = $test;
    }

    protected function get_formtests()
    {
        return array_merge( $this->_early_formtests, $this->_formtests );
    }

    public function register_validation_editor( ValidationEditor $obj )
    {
        $class = get_class($obj);
        foreach( $this->_validation_editors as $one ) {
            $class2 = get_class($one);
            if( $class == $class2 ) throw new \LogicException('Each validation editor class can only be registered once');
        }
        $this->_validation_editors[$class] = $obj;
    }

    public function get_validation_editor( $classname )
    {
        if( isset($this->_validation_editors[$classname]) ) return $this->_validation_editors[$classname];
        throw new \LogicException('Could not find a field validation editor of type '.$classname);
    }

    protected function get_validation_editors()
    {
        return $this->_validation_editors;
    }

    public function register_disposition_editor( DispositionEditor $obj )
    {
        $class = get_class($obj);
        foreach( $this->_disp_editors as $one ) {
            $class2 = get_class($one);
            if( $class == $class2 ) throw new \LogicException('Each disposition editor class can only be registered once');
        }
        $this->_disp_editors[$class] = $obj;
    }

    protected function get_disposition_editors()
    {
        return $this->_disp_editors;
    }

    protected function get_disposition_editor( $classname )
    {
        if( isset($this->_disp_editors[$classname]) ) return $this->_disp_editors[$classname];
        throw new \LogicException('Could not find a disposition editor of type '.$classname);
    }

    protected function register_builtin_form_tests()
    {
        $this->register_early_formtest( new \CGBetterForms\FormValidator\TemplateValidator( $this->translator ) );
        $this->register_early_formtest( new \CGBetterForms\FormValidator\FormTagValidator( $this->translator ) );
        $this->register_early_formtest( new \CGBetterForms\FormValidator\FormMissingNameValidator( $this->translator ) );
        $this->register_early_formtest( new \CGBetterForms\FormValidator\FormMissingLabelValidator( $this->translator ) );
        $this->register_early_formtest( new \CGBetterForms\FormValidator\FormMissingValueValidator( $this->translator ) );
        $this->register_early_formtest( new \CGBetterForms\FormValidator\FormDuplicateIdValidator( $this->translator ) );
        $this->register_early_formtest( new \CGBetterForms\FormValidator\FormDuplicateNameValidator( $this->translator ) );
    }

    protected function register_builtin_validation_editors()
    {
        // computed field (outputs a string)
        $this->register_validation_editor( new \CGBetterForms\FieldValidators\HtmlDetectionValidationEditor( $this ) );
        $this->register_validation_editor( new \CGBetterForms\FieldValidators\RequiredFieldValidationEditor( $this ) );
        $this->register_validation_editor( new \CGBetterForms\FieldValidators\SelectFieldValidationEditor( $this ) );
        $this->register_validation_editor( new \CGBetterForms\FieldValidators\FileValidationEditor( $this ) );
        $this->register_validation_editor( new \CGBetterForms\FieldValidators\IntegerFieldValidationEditor( $this ) );
        $this->register_validation_editor( new \CGBetterForms\FieldValidators\FloatFieldValidationEditor( $this ) );
        $this->register_validation_editor( new \CGBetterForms\FieldValidators\EmailPrimitiveValidationEditor( $this ) );
        $this->register_validation_editor( new \CGBetterForms\FieldValidators\DatePrimitiveValidationEditor( $this ) );
        $this->register_validation_editor( new \CGBetterForms\FieldValidators\RegexFieldValidationEditor( $this ) );
        $this->register_validation_editor( new \CGBetterForms\FieldValidators\EmailFieldValidationEditor( $this ) );
        $this->register_validation_editor( new \CGBetterForms\FieldValidators\TemplateValidationEditor( $this ) );
        $this->register_validation_editor( new \CGBetterForms\FieldValidators\ComputedValueEditor( $this ) );
    }

    protected function register_builtin_disp_editors()
    {
        // add dispose to session
        // add redirect based on dropdown
        $this->register_disposition_editor( new \CGBetterForms\Dispositions\DropdownFileDispositionEditor( $this ) );
        $this->register_disposition_editor( new \CGBetterForms\Dispositions\UniqueFileDispositionEditor( $this ) );
        $this->register_disposition_editor( new \CGBetterForms\Dispositions\DropdownEmailDispositionEditor( $this ) );
        $this->register_disposition_editor( new \CGBetterForms\Dispositions\FlatFileDispositionEditor( $this ) );
        $this->register_disposition_editor( new \CGBetterForms\Dispositions\EmailFixedAddressesDispositionEditor( $this ) );
        $this->register_disposition_editor( new \CGBetterForms\Dispositions\EmailAdminWithReplyToEditor( $this ) );
        $this->register_disposition_editor( new \CGBetterForms\Dispositions\EmailUserAddressDispositionEditor( $this ) );
        $this->register_disposition_editor( new \CGBetterForms\Dispositions\RedirectURLDispositionEditor( $this ) );
        $this->register_disposition_editor( new \CGBetterForms\Dispositions\ComputedPageDispositionEditor( $this ) );
        $this->register_disposition_editor( new \CGBetterForms\Dispositions\WebHookDispositionEditor( $this ) );
        $this->register_disposition_editor( new \CGBetterForms\Dispositions\SessionDispositionEditor( $this ) );
        $this->register_disposition_editor( new \CGBetterForms\Dispositions\StopDisposingDispositionEditor( $this ) );
    }

    protected function find_editor_by_disposition( Disposition $disp )
    {
        $class = get_class($disp);
        foreach( $this->_disp_editors as $editor ) {
            if( $editor->get_outputclass() == $class ) return $editor;
        }
        throw new \LogicException('Unable to find an editor for dispositions of type '.$class);
    }

    protected function find_editor_by_validation( Validation $obj )
    {
        $class = get_class($obj);
        foreach( $this->_validation_editors as $editor ) {
            if( $editor->get_outputclass() == $class ) return $editor;
        }
        throw new \LogicException('Unable to find an editor for a validation of type '.$class);
    }

    public function validation_has_editor( Validation $obj )
    {
        try {
            $editor = $this->find_editor_by_validation($obj);
            return $editor->has_interface();
        }
        catch( \LogicException $e ) {
            // do nothing
        }
    }

    public function get_disposition_displaystring( Disposition $disp )
    {
        $editor = $this->find_editor_by_disposition( $disp );
        $editor->set_disposition( $disp );
        return $editor->get_displaystring();
    }

    public function get_validation_displaystring( Validation $obj )
    {
        $out = $obj->get_display_string( $this->translator );
        if( $this->validation_has_editor( $obj ) ) {
            $editor = $this->find_editor_by_validation( $obj );
            $editor->set_validation( $obj );
            $out = $editor->get_displaystring();
        }
        return $out;
    }

    public function set_captcha_provider( ICaptchaProvider $provider )
    {
        $this->_captcha_provider = $provider;
    }

    public function get_captcha_provider()
    {
        if( $this->_captcha_provider ) return $this->_captcha_provider;
        $mod = \cms_utils::get_module('Captcha');
        if( $mod ) {
            $provider = new \CGBetterForms\CaptchaModuleProvider( $mod );
            return $provider;
        }
    }

    protected function get_form( $guid )
    {
        // retrieves form object from session.
        $out = \CGBetterForms\utils::retrieve_object( $guid );
        if( ! $out instanceof \CGBetterForms\Form ) throw new \LogicException( 'Could not retrieve form object' );
        return $out;
    }

    protected function store_form( \CGBetterForms\Form $form, $guid = null )
    {
        // stores form object to session.
        return \CGBetterForms\utils::store_object( $form, $guid );
    }

    protected function finish_editing_validation( \CGBetterForms\Form $form, $form_guid, Validation $validator, $validator_guid )
    {
        $form_guid = $this->store_form( $form, $form_guid );
        $validator_guid = \CGBetterForms\utils::store_object( $validator, $validator_guid );
        $this->SetCurrentTab('validators');
        $this->Redirect( 'm1_', 'admin_edit_form', '', [ 'form_guid'=>$form_guid, 'validator_guid'=>$validator_guid ] );
    }

    protected function finish_editing_disposition( \CGBetterForms\Form $form, $form_guid, Disposition $disp, $disp_guid )
    {
        $form_guid = $this->store_form( $form, $form_guid );
        $disp_guid = \CGBetterForms\utils::store_object( $disp, $disp_guid );
        $this->SetCurrentTab( 'handlers' );
        $this->Redirect( 'm1_', 'admin_edit_form', '', [ 'form_guid'=>$form_guid, 'disp_guid'=>$disp_guid ] );
    }

    /**
     * @ignore
     */
    public function smarty_cgbf_set( $params, $template )
    {
        if( !$this->_in_prerender ) throw new \RuntimeException('cgbf_set is only valid when used in the prerender logic field.');

        $key = \cge_param::get_string($params,'k');
        $key = \cge_param::get_string($params,'key',$key);
        $key = \cge_param::get_string($params,'fld',$key);
        $key = \cge_param::get_string($params,'field',$key);

        $val = \cge_utils::get_param($params,'v');
        $val = \cge_utils::get_param($params,'val',$val);
        $val = \cge_utils::get_param($params,'value',$val);
        $this->_prerender_vars[$key] = $val;
    }

    /**
     * @ignore
     */
    public function smarty_cgbf_get_errors( $params, $template )
    {
        $assign = \cge_param::get_string($params,'assign');
        if( !$assign ) {
            trigger_error('cgbf_form_errors called without assign attribute');
            return;
        }

        $out = [];
        if( \cge_param::exists($params,'full') ) {
            $out = $this->_request_errors;
        }
        else {
            for( $i = 0; $i < count($this->_request_errors); $i++ ) {
                $obj = $this->_request_errors[$i];
                $out[] = $obj->msg;
            }
        }

        $template->assign($assign,$out);
    }

    /**
     * @ignore
     */
    public static function tpl_type_lang_callback($str)
    {
        $mod = cms_utils::get_module('CGBetterForms');
        $str = str_replace(' ','_',$str);
        if( is_object($mod) ) return $mod->Lang('type_'.$str);
    }

    /**
     * @ignore
     */
    public static function tpl_type_help_callback()
    {
        return file_get_contents(__DIR__.'/doc/template_help.inc');
    }
} // end of class
