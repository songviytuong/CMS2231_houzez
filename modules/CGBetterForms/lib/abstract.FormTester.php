<?php
namespace CGBetterForms;

abstract class FormTester implements IFormTester
{
    private $_scanner;
    private $_tests;

    public function __construct( FormScanner $scanner, array $tests = null )
    {
        $this->_scanner = $scanner;
        $this->_tests = $tests;
    }

    protected function get_tests()
    {
        return $this->_tests;
    }

    protected function get_forms()
    {
        return $this->_scanner->get_forms();
    }

    protected function get_inputs()
    {
        return $this->_scanner->get_fields();
    }

}