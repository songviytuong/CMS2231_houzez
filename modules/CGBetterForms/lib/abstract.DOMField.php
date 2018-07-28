<?php
namespace CGBetterForms;

abstract class DOMField extends Field
{
    private $_line;
    private $_value;

    public function __construct(\DOMNode $node)
    {
        $nodename = $node->nodeName;
        $attribs = $this->getAttributesArray($node->attributes);
        $this->_line = $node->getLineNo();
        $this->_value = $node->nodeValue;
        parent::__construct( $nodename, $attribs );
    }

    protected function getAttributesArray(\DOMNamedNodeMap $map)
    {
        $out = [];
        foreach( $map as $attr ) {
            $out[$attr->nodeName] = $attr->nodeValue;
        }
        return $out;
    }

    public function get_short_attribute( $key )
    {
        $val = $this->has_attribute( $key );
        $str = $this->get_attribute( $key );
        if( strlen($str) ) $val = $str;
        return $val;
    }

    public function get_value()
    {
        return $this->_value;
    }

    public function get_line()
    {
        return $this->_line;
    }
}