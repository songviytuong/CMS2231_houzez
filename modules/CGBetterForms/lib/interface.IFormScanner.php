<?php
namespace CGBetterForms;

interface IFormScanner
{
    public function get_forms();
    public function get_fields();
    public function has_captcha();
}