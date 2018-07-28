<?php
namespace CGBetterForms;

class FormFileField extends FormField
{
    private $_data = ['accept'=>null, 'max_size'=>null, 'extensions'=>null, 'novalidate'=>null ];

    public function __construct( array $in )
    {
        foreach( $in as $key => $val ) {
            switch( $key ) {
            case 'accept':
            case 'extensions':
                $this->_data[$key] = trim($val);
                break;
            case 'max_size':
                $this->_data[$key] = (int) max(0,(int) $val);
                break;
            }
        }
        parent::__construct( $in );
    }

    public function __get($key)
    {
        if( array_key_exists($key, $this->_data) ) return $this->_data[$key];
        return parent::__get( $key );
    }
}
