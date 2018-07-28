<?php
namespace CGBetterForms;

class Translator
{
    private $_mod;

    public function __construct(\CGBetterForms $mod)
    {
        $this->_mod = $mod;
    }

    public function translate(/* var args */)
    {
        $args = func_get_args();
        if( is_array($args) && count($args) == 1 && is_array($args[0]) ) $args = $args[0];
        return call_user_func_array( [ $this->_mod, 'Lang'], $args );
    }

} // class