<?php
namespace CGBetterForms;

class FormMultiValueOption
{
    private $_data;

    public function __construct( array $params )
    {
        $this->_data = $params;
    }

    public function __get($key)
    {
        switch( $key ) {
        case 'human':
        case 'hr':
            $val = \cge_param::get_string( $this->_data, 'data-cgbf-human' );
            if( !$val ) $val = $this->_data['text'];
            return trim($val);
        case 'text':
        case 'value':
            return \cge_param::get_string( $this->_data, $key );
        case 'selected':
            return \cge_param::get_bool( $this->_data, $key );
        default:
            if( \cge_param::exists( $this->_data, $key ) ) return \cge_param::get_string( $this->_data, $key );
        }
    }

    public function get_value()
    {
        return $this->value;
    }

    public function __set( $key, $val )
    {
        throw new \LogicException(__CLASS__.' cannot be modified this way');
    }
} // class