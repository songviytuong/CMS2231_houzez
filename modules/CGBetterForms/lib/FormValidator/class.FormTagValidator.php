<?php
namespace CGBetterForms\FormValidator;
use \CGBetterForms\FormValidationError;

class FormTagValidator extends FormTesterTest
{
    public function test_form( array $forms, array $inputs )
    {
        $out = [];
        if( count($forms) < 1 ) throw new FormValidationError($this->translate('err_noforms'));
        if( count($forms) > 1 ) throw new FormValidationError($this->translate('err_manyforms'));
        if( isset($_SESSION['have_formstart_smartytag']) ) {
            unset($_SESSION['have_formstart_smartytag']);
        } else {
            $form = $forms[0];
            if( $form->has_attribute('action') ) $out[] = $this->translate('err_form_actionattr');
            if( $form->has_attribute('method') ) $out[] = $this->translate('err_form_methodattr');
            if( $form->has_attribute('enctype') ) $out[] = $this->translate('err_form_enctypeattr');
        }
        return $out;
    }
}
