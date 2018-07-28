<?php

if( version_compare(phpversion(),'5.4.11') < 0 ) {
    return "Minimum PHP version of 5.4.11 required";
}

$cache_path = $this->GetPreference('cache_path');
$test = cms_join_path('uploads','_'.$this->GetName());
if( $cache_path == $test || $cache_path == 'uploads/_CGSmartImage' ) {
    $this->SetPreference('cache_path','');
    audit('',$this->GetName(),'Invalid cache path reset to uploads/_CGSmartImage on upgrade');
}
?>