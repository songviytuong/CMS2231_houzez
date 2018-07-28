<?php
namespace CGBetterForms\FormValidator;

abstract class FormTesterTest
{
    private $_translator;

    public function __construct( \CGBetterForms\Translator $obj )
    {
        $this->_translator = $obj;
    }

    public function translate(/* var args */)
    {
        $args = func_get_args();
        return $this->_translator->translate( $args );
    }

    // returns an array of messages, or null
    abstract public function test_form( array $forms, array $inputs );
}