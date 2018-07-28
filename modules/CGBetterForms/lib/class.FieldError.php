<?php
namespace CGBetterForms;

class FieldError
{
    const NONSPECIFIC_FIELD = 'NOT-SPECIFIC';

    private $_field_name;
    private $_message;

    public function __construct( $field_name, $message = null )
    {
        $field_name = trim($field_name);
        if( !$field_name ) throw new \LogicException('A field name is required when creating a '.__CLASS__);
        $this->_field_name = $field_name;
        $this->_message = trim($message);
    }

    public function __get($key)
    {
        switch( $key ) {
        case 'field_name':
        case 'field':
        case 'fieldName':
            return $this->_field_name;

        case 'msg':
        case 'message':
            return $this->_message;
        }
        throw new \LogicException("$key is not a gettable member of ".__CLASS__);
    }

    public function __set($key,$val)
    {
        throw new \LogicException("$key is not a settable member of ".__CLASS__);
    }
}