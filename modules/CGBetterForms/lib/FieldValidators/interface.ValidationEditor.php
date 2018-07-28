<?php
namespace CGBetterForms\FieldValidators;

abstract class ValidationEditor
{
    abstract public function get_name();
    abstract public function get_settings_form_url(array $params = null);
    abstract public function get_validator();
    abstract public function set_validator( IValidation $in );
    abstract public function get_outputclass();
} // end of interface
