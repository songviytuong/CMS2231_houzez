<?php
namespace CGBetterForms\DOMFields;

class DOMTextAreaField extends DOMField {
    use DOMLabelField;

    public function __construct(\DOMNode $node)
    {
        parent::__construct($node);
        $this->set_label($this->findParentLabel($node));
    }
}
