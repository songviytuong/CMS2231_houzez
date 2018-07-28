<?php
namespace CGBetterForms\FieldValidators;

interface IValidation
{
    public function get_guid();
    public function get_display_string( \CGBetterForms\Translator $tr );
    public function validate(\CGBetterForms\Form $form, \CGBetterForms\FormResponse& $data, \CGBetterForms\Translator $translator );
} // end of interface
