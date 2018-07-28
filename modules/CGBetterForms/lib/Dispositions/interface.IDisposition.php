<?php
namespace CGBetterForms\Dispositions;

interface IDisposition
{
    public function get_guid();
    public function dispose(\CGBetterForms\Form $form, \CGBetterForms\FormResponse& $data);
} // end of interface
