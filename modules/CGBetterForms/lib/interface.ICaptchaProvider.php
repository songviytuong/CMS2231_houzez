<?php
namespace CGBetterForms;

interface ICaptchaProvider
{
    public function get_captcha_display();
    public function get_captcha_inputfield();
    public function validate_captcha();
}