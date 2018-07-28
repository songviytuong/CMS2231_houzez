<?php
namespace CGBetterForms;

abstract class Field
{
    private $_attribs = [];

    public function __construct( $nodename, array $attributes )
    {
        $this->_nodename = strtolower(trim($nodename));
        foreach( $attributes as $key => $val ) {
            $key = strtolower($key);
            $this->_attribs[$key] = $val;
        }
        if( !isset($this->_attribs['type']) ) {
            if( $this->_nodename == 'input' ) $this->_attribs['type'] = 'text';
            if( $this->_nodename == 'button' ) $this->_attribs['type'] = 'submit';
        } else {
            $this->_attribs['type'] = strtolower($this->_attribs['type']);
        }
    }

    public function get_name()
    {
        return $this->get_attribute('name');
    }

    public function get_nodename()
    {
        return $this->_nodename;
    }

    public function has_attribute( $key )
    {
        $key = strtolower(trim($key));
        if( !$key ) return;
        return array_key_exists($key, $this->_attribs);
    }

    public function get_attribute($key)
    {
        $key = strtolower(trim($key));
        if( !$key ) return;
        if( isset($this->_attribs[$key]) ) return $this->_attribs[$key];
    }

    public function get_signature()
    {
        return md5(__CLASS__.$this->_type.$this->_nodename);
    }

    public function get_attributes()
    {
        return $this->_attribs;
    }

    public function get_attributes_by_prefix( $prefix )
    {
        $prefix = strtolower(trim($prefix));
        $out = [];
        foreach( $this->_attribs as $key => $val ) {
            if( startswith( $key, $prefix) ) $out[$key] = $val;
        }
        if( count($out) ) return $out;
    }
} // end of class