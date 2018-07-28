<?php
namespace CGBetterForms;

class TemplateFormTester extends FormTester
{
    private $_tpl_text;
    private $_messages;

    public function __construct( TemplateFormScanner $scanner, array $tests = null )
    {
        $this->_tpl_text = $scanner->get_template_contents();
        parent::__construct( $scanner, $tests );
        $this->test();
    }

    protected function test()
    {
        // from here down accumulate messages using the various tests
        $tests = $this->get_tests();
        if( !count($tests) ) return;

        $out = [];
        foreach( $tests as $test ) {
            if( $test instanceof \CGBetterForms\FormValidator\TemplateTesterTest ) {
                $messages = $test->test_template( $this->_tpl_text );
                if( $messages ) $out = array_merge( $out, $messages );
            }
            if( $test instanceof \CGBetterForms\FormValidator\FormTesterTest ) {
                $messages = $test->test_form( $this->get_forms(), $this->get_inputs() );
                if( $messages ) $out = array_merge( $out, $messages );
            }
        }
        $this->_messages = $out;
    }

    public function get_messages()
    {
        return $this->_messages;
    }

    public function get_valid_fields()
    {
        // return only fields that have names, and only the last occurance of that name.
        $inputs = $this->get_inputs();
        $out = [];
        foreach( $inputs as $field ) {
            $name = $field->get_attribute('name');
            if( !$name ) continue;
            $out[$name] = $field;
        }
        return $out;
    }
}
