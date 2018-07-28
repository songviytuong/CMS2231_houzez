<?php

   switch($oldversion) {

      case "1.0":
         //nothing to do

      case "1.0.1":
         $arrFilesToDelete = array('setting.inc.php','CreateXMLPackage.filter.log','.buildpath','.project',
                                   '.settings'.DIRECTORY_SEPARATOR.'org.eclipse.php.core.prefs',
                                   '_releases'.DIRECTORY_SEPARATOR.'ErrorLogger-1.0.xml',
                                   '_releases'.DIRECTORY_SEPARATOR.'ErrorLogger-1.0.1.xml');
         foreach($arrFilesToDelete as $strFile) {
            if (file_exists(dirname(__FILE__).DIRECTORY_SEPARATOR.$strFile)) {
              unlink(dirname(__FILE__).DIRECTORY_SEPARATOR.$strFile);
            }
         }
         rmdir(dirname(__FILE__).DIRECTORY_SEPARATOR.'_releases');
         rmdir(dirname(__FILE__).DIRECTORY_SEPARATOR.'.settings');

   }

   // put mention into the admin log
   $this->Audit( 0, $this->Lang('friendlyname'), $this->Lang('upgraded',$this->GetVersion()));

?>