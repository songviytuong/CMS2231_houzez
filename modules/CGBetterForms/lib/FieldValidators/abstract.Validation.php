<?php
namespace CGBetterForms\FieldValidators;

abstract class Validation implements IValidation
{
    private $_guid;

    public function __construct()
    {
        $this->_guid = \cge_utils::create_guid();
    }

    public function __set( $key, $val )
    {
        throw new \LogicException("$key is not a settable member of ".get_class($this));
    }

    public function get_guid()
    {
        return $this->_guid;
    }
}
