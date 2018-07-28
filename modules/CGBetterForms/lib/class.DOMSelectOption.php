<?php
namespace CGBetterForms;

class DOMSelectOption
{
    private $_attribs = null;

    public function __construct(\DOMNode $node)
    {
        $name = strtolower($node->nodeName);
        if( $name != 'option' ) throw new \LogicException('Cannot create a '.__CLASS__.' from a '.$name.' node');

        $this->_attribs = $this->getAttributesArray($node->attributes);
        $this->_attribs['text'] = $node->textContent;
    }

    protected function getAttributesArray(\DOMNamedNodeMap $map)
    {
        $out = [];
        foreach( $map as $attr ) {
            $out[$attr->nodeName] = $attr->nodeValue;
        }
        return $out;
    }

    public function get_attribs()
    {
        return $this->_attribs;
    }

    public function get_humanReadable()
    {
        $val = \cge_param::get_string( $this->_attribs, 'data-cgbf-human');
        if( $val ) return $val;
        return $this->text;
    }

    public function get_hrRaw()
    {
        return \cge_param::get_string( $this->_attribs, 'data-cgbf-human');
    }

    public function get_textRaw()
    {
        return \cge_param::get_string( $this->_attribs, 'text');
    }

    public function get_valueRaw()
    {
        return \cge_param::get_string( $this->_attribs, 'value' );
    }

    public function get_value()
    {
        $val = $this->get_valueRaw();
        if( $val ) return $val;
        return $this->get_textRaw();
    }

    public function get_selected()
    {
        return \cge_param::get_string( $this->_attribs, 'selected' );
    }

    public function __set( $key, $val )
    {
        throw new \LogicException(__CLASS__.' cannot be modified this way');
    }

} // class