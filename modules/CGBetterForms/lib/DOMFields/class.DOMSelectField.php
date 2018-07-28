<?php
namespace CGBetterForms\DOMFields;

class DOMSelectField extends DOMField
{
    use DOMLabelFieldTrait;

    private $_options = [];

    public function __construct(\DOMNode $node)
    {
        parent::__construct($node);
        $this->set_label($this->findParentLabel($node));
    }

    public function is_multiselect()
    {
        $multiple = $this->get_attribute('multiple');
        if( $multiple ) return true;
    }

    public function get_value()
    {
        if( $this->is_multiselect() ) {
            $out = [];
            foreach( $this->_options as $option ) {
                if( $option->get_selected() ) $out[] = $option->get_value();
            }
            return $out;
        }

        foreach( $this->_options as $option ) {
            if( $option->get_selected() ) return $option->get_value();
        }

        return $this->_options[0]->get_value();
    }

    public function add_option( DOMSelectOption $option )
    {
        $this->_options[] = $option;
    }

    public function get_options()
    {
        return $this->_options;
    }

    public function has_options()
    {
        return count($this->_options);
    }
}
