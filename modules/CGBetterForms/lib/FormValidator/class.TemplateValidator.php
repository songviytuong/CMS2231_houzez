<?php
namespace CGBetterForms\FormValidator;
use \CGBetterForms\FormValidationError;

class TemplateValidator extends TemplateTesterTest
{
    public function test_template( $str )
    {
        // return an array of messages
        // check for {form_start} or <form (exception)
        if( strpos($str,'{form_start') !== FALSE ) $_SESSION['have_formstart_smartytag'] = 1;
        if( strpos($str,'{form_start') === FALSE && stripos($str,'<form') === FALSE ) throw new FormValidationError($this->translate('err_missing_formstart'));

        $out = null;
        // check for {form_end} or </form (message)
        if( strpos($str,'{form_end') === FALSE && !stripos($str,'</form') ) $out[] = $this->translate('err_missing_formend');

        if( strpos($str,'{cgbf_form_errors') === FALSE ) $out[] = $this->translate('err_missing_messagestring');
        return $out;
        // check for {cgbf_form_error} tag.(message)
    }
}