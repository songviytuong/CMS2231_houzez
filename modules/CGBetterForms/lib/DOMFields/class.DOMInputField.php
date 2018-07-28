<?php
namespace CGBetterForms\DOMFields;

class DOMInputField extends DOMField {
    use DOMLabelFieldTrait;

    public function __construct(\DOMNode $node)
    {
        parent::__construct($node);
        $this->set_label($this->findParentLabel($node));
    }

    public function get_value()
    {
        return $this->get_attribute('value');
    }
}
