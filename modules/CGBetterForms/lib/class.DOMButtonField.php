<?php
namespace CGBetterForms;

class DOMButtonField extends DOMField {
    use DOMLabelFieldTrait;

    public function __construct(\DOMNode $node)
    {
        parent::__construct($node);
        $this->set_label($this->findParentLabel($node));
    }

    public function get_attribute($key)
    {
        $res = parent::get_attribute($key);
        if( $res ) return $res;
        if( $key == 'type' ) return 'submit';
    }
}
