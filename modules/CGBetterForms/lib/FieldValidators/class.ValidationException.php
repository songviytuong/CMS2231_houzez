<?php
namespace CGBetterForms\FieldValidators;

class ValidationException extends \CGBetterForms\ValidationError
{
    private $_field_error;

    public function __construct( $field_name, $message = null )
    {
        $this->_field_error = new \CGBetterForms\FieldError( $field_name, $message );
        parent::__construct( $message );
    }

    public function GetFieldError()
    {
        return $this->_field_error;
    }
}
