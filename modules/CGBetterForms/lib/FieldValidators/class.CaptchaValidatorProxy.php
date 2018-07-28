<?php
namespace CGBetterForms\FieldValidators;
use \CGBetterForms\ICaptchaProvider;

class CaptchaValidatorProxy extends Validation
{
    private $_provider;

    public function __construct( ICaptchaProvider $provider = null )
    {
        $this->_provider = $provider;
    }

    public function get_display_string( \CGBetterForms\Translator $tr )
    {
        return $tr->translate('validate_captcha');
    }

    public function validate(\CGBetterForms\Form $form, \CGBetterForms\FormResponse& $data, \CGBetterForms\Translator $tr )
    {
        if( ! $form->has_captcha ) return;
        if( $this->_provider && ! $this->_provider->validate_captcha() ) throw new ValidationException('CAPTCHA',$tr->translate('err_captcha_mismatch'));
    }
}