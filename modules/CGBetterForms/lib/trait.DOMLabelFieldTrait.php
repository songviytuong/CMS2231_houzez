<?php
namespace CGBetterForms;

trait DOMLabelFieldTrait
{
    private $_label;

    protected function findParentLabel(\DOMNode $node)
    {
        $node = $node->parentNode;
        if( !$node ) return;

        $name = strtolower($node->nodeName);
        if( $name != 'label' ) return;
        if( ! $node->hasChildNodes() ) return $node->nodeValue;

        return $node->firstChild->textContent;
    }

    public function get_label()
    {
        return $this->_label;
    }

    public function set_label($str)
    {
        $this->_label = trim($str);
    }
} // end of trait