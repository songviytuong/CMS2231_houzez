<?php

$__autoloader = function($classname)
{
    $tmp = str_replace('\\','/',$classname);
    $classname = basename($tmp);
    $fn = dirname(__DIR__)."/lib/class.{$classname}.php";
    if( file_exists($fn) ) require_once($fn);
};

spl_autoload_register($__autoloader);

?>