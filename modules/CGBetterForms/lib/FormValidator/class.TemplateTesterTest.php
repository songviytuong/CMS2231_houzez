<?php
namespace CGBetterForms\FormValidator;

abstract class TemplateTesterTest extends FormTesterTest
{
    // returns an array of messages or null
    abstract public function test_template( $str );

    public function test_form( array $forms, array $inputs ) {} // do nothing
}