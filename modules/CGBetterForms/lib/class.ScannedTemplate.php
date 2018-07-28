<?php
namespace CGBetterForms;

// this class handles the metadata coming from the template tester and the templae scanner
class ScannedTemplate
{
    private $_messages;
    private $_fields;
    private $_has_captcha;

    public function __construct( IFormScanner $scanner, IFormTester $tester )
    {
        $messages = $scanner->get_errors();
        if( !count($messages) ) $messages = [];
        $messages2 = $tester->get_messages();
        if( !count($messages2) ) $messages2 = [];
        $this->_messages = array_merge( $messages, $messages2 );

        $dom_fields = $scanner->get_fields();
        $converter = new FormFieldConverter( $dom_fields );
        $this->_fields = $converter->get_fields();
        $this->_has_captcha = $scanner->has_captcha();
    }

    public function get_messages()
    {
        return $this->_messages;
    }

    public function get_fields()
    {
        return $this->_fields;
    }

    public function has_captcha()
    {
        return $this->_has_captcha;
    }
}