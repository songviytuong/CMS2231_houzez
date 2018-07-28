<?php
namespace CGBetterForms;

class CaptchaModuleProvider implements ICaptchaProvider
{
    private $_captcha_mod;

    public function __construct( \CMSModule $captcha )
    {
        if( !method_exists( $captcha, 'CheckCaptcha' ) || !method_exists( $captcha, 'NeedsInputField') ) {
            throw new \InvalidArgumentException( $captcha->GetName().' is not a valid captcha module');
        }
        $this->_captcha_mod = new ModuleReference( $captcha->GetName() );
    }

    public function get_captcha_inputfield()
    {
        if( $this->_captcha_mod->NeedsInputField() ) {
            return '<input name="cgbf_input_captcha" class="cgbf_input_captcha"/>';
        }
    }

    public function get_captcha_display()
    {
        return $this->_captcha_mod->getCaptcha();
    }

    public function validate_captcha()
    {
        $input = null;
        $mod = $this->_captcha_mod;
        if( $mod->NeedsInputField() ) $input = \cge_param::get_string($_REQUEST,'cgbf_captcha');
        return $mod->CheckCaptcha( $input );
    }
} // class