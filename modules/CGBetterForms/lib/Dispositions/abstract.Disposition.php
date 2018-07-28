<?php
namespace CGBetterForms\Dispositions;

abstract class Disposition implements IDisposition
{
    private $_guid;

    public function __construct()
    {
        $this->_guid = \cge_utils::create_guid();
    }

    public function get_guid()
    {
        return $this->_guid;
    }
}
