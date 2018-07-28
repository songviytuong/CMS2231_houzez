<?php
namespace CGBetterForms;

class FormField
{
    private $_data = [ 'node'=>null, 'name'=>null, 'type'=>null, 'options'=>null, 'id'=>null, 'class'=>null, 'multiple'=>false, 'label'=>null,
                       'required'=>null, 'min'=>null, 'max'=>null, 'pattern'=>null, 'novalidate'=>null, 'primitive'=>null, 'extra'=>null ];
    private $_values = [];
    private $_extra_attribs = [];

    public function __construct( array $in )
    {
        foreach( $in as $key => $val ) {
            if( $key == 'extra' ) {
                if( is_array($val) && count($val) ) $this->_data[$key] = $val;
                continue;
            }
            if( $key == 'extra_attribs' ) {
                if( is_array($val) && count($val) ) $this->_extra_attribs = $val;
                continue;
            }
            // remove [] from end of names.
            if( $key == 'name' && endswith( $val, '[]') ) $val = substr($val,0,-2);
            if( array_key_exists($key, $this->_data) ) $this->_data[$key] = $val;
        }
    }

    public function __get($key)
    {
        if( array_key_exists($key, $this->_data) ) return $this->_data[$key];
        throw new \LogicException($key.' is not a gettable member of '.__CLASS__);
    }

    public function add_value( $val ) {
        if( is_array($val) ) {
            foreach( $val as $one ) {
                $this->add_value( $one );
            }
            return;
        }
        if( strlen($val) ) $this->_values[] = $val;
    }

    public function get_value()
    {
        if( $this->multiple ) return $this->_values;
        if( count($this->_values) ) return $this->_values[0];
    }

    public function add_option( FormMultiValueOption $opt )
    {
        if( !is_array($this->_data['options']) ) $this->_data['options'] = [];
        $this->_data['options'][] = $opt;
    }

    public function has_multiple_options()
    {
        return (count($this->options) > 1 || count($this->_values) > 1)?TRUE:FALSE;
    }

    public function get_options()
    {
        if( $this->options ) return $this->options;
    }

    public function get_option_values()
    {
        if( !$this->has_multiple_options() ) return;
        $out = [];
        foreach( $this->options as $opt ) {
            $out[] = $opt->get_value();
        }
        return $out;
    }

    public function get_option_by_value( $val )
    {
        if( !$this->has_multiple_options() ) return;

        $val = trim($val);
        if( !$val ) return;

        // find the first option in options that has this value.
        for( $i = 0; $i < count($this->options); $i++ ) {
            $opt = $this->options[$i];
            if( $opt->get_value() == $val ) return $opt;
        }
    }

    public function add_extra_attribute( $key, $val )
    {
        // stores string keys, and string values.
        $key = trim($key);
        $val = trim($val);
        if( !$key ) return;
        if( is_null( $val ) && array_key_exists( $key, $this->_extra_attribs ) ) {
            unset( $this->_extra_attribs[ $key ] );
            return;
        }
        $this->_extra_attribs[ $key ] = $val;
    }

    public function get_extra_attribute( $key )
    {
        $key = trim( $key );
        if( !$key ) return;
        if( array_key_exists( $key, $this->_extra_attribs ) ) return $this->_extra_attribs[ $key ];
    }
} // end of class