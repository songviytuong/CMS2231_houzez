<?php
/**
* LISE Advanced Configuration
*/
/**
* This file is an advanced configuration file for LISE
* and, if one is created inside the data folder of an instance,
* for any LISE instance independently
* KEEP IN MIND that this is an advanced feature
* with not much documentation; It's use needs CAUTION!
* Misconfigurations can break the modules, have adverse effects,
* impact site speed or otherwise break the whole CMSMS installation.
* So avoid changing any of the settings unless you know what you are doing
* or have been advised to do so by a LISE developer,
* otherwise it's your sole responsibility if anything breaks 
*/

/**
* Set to TRUE if you need LOGGING
*/
$cfg['log'] = FALSE;

/**
* Path of the dir relative
* to the module instance own path
* default is 'data'
* which resolves to <cmsms_root>\modules\<LISEinstance>\data
* or <cmsms_root>\modules\LISE\data in case of the main module
* 
* default: $cfg['log_path'] = 'data'; 
*/
$cfg['log_path'] = 'data';

/**
* name of the file used to LOG
*/
$cfg['log_filename'] = 'LISE.log';

/**
* Sets the LISEQuery page limit globally
*/
$cfg['global_LISEQuery_page_limit'] = 100000;

?>