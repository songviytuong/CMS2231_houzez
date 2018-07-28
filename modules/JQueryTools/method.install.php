<?php

if( version_compare(phpversion(),'5.4.11') < 0 ) {
    return "Minimum PHP version of 5.4.11 required";
}

$this->RegisterLibraries();

?>