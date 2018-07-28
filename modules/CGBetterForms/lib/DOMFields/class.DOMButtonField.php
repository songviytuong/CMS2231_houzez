<?php
namespace CGBetterForms\DOMFields;

class DOMButtonField extends DOMField {
    use DOMLabelFieldTrait;

    public function __construct(\DOMNode $node)
    {
        parent::__construct($node);
        $this->set_label($this->findParentLabel($node));
    }
}
