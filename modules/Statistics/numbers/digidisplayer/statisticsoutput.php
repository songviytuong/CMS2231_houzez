<?php
include(dirname(__FILE__)."/digidisplayer.php");
$counter = new DigiDisplayer($_REQUEST["value"]);
$counter->display_digit();
die();
?>
