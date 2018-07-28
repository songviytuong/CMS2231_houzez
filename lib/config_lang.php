<?php

/*******
 SINTAX:
 'KEY' => array(
	'locale_cms' => 'LOCALE LANGUAGE IN CMSMS', //MANDATORY One valid CMSMS locale or near to
	'block' => 'DATABASE KEY', //MANDATORY AND UNIQUE In general 2 chars same of 'parent'
	'parent' => 'PARENT LANGUAGE', //OPTIONAL 2 chars parent language, if you have others set to 5 WITH DASH, ex: en-au
	'flag' => 'HTML IMG TAG FOR LOCALE FLAG', //MANDATORY ABSOLUTE URL PATH
	'text' => 'NATIVE LANGUAGE', //OPTIONAL Use for lang plugin if you don't use flags icon
	'locale' => 'SERVER LOCALE', //OPTIONAL Set for specific locale server if different from 'locale_cms'
 ),
 *******/

$hls = array(
 'en_US' => array(
	'locale_cms'=>'en_US',
	'block'=>'en',
	'parent'=>'en',
	'flag'=>'<img src="http://freme.dev/uploads/lang/en.png" style="border:0;opacity:1;" alt="English" title="English" />',
	'text'=>'English',
	'locale'=>'en_US.UTF-8'
 ),
 'my_MY' => array(
	'locale_cms'=>'my_MY',
	'block'=>'my',
	'parent'=>'my',
	'flag'=>'<img src="http://freme.dev/uploads/lang/my.png" style="border:0;opacity:1;" alt="Malaysia" title="Malaysia" />',
	'text'=>'Vietnamese',
	'locale'=>'my_MY.UTF-8'
 ),
);
?>