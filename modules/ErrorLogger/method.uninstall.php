<?php

   // remove the database tables
   $objADOConnection =& $this->GetDb();
   $objDataDictionary = NewDataDictionary($objADOConnection);
   $arrSQL = $objDataDictionary->DropTableSQL(cms_db_prefix().'module_errorlogger_log');
   $objDataDictionary->ExecuteSQLArray($arrSQL);
   $objADOConnection->DropSequence(cms_db_prefix().'module_errorlogger_log_seq');


   // remove the permissions
   $this->RemovePermission('ErrorLogger_View');
   $this->RemovePermission('ErrorLogger_Edit');


   //remove error handler to config file
   $arrConfig = \cms_config::get_instance();
   $strConfigFile = $arrConfig['root_path'] . DIRECTORY_SEPARATOR . 'config.php';
   $strContent = file_get_contents($strConfigFile);
   $strContent = str_replace($this->getConfigContent(), '', $strContent);
   file_put_contents($strConfigFile, $strContent);


   // put mention into the admin log
   $this->Audit( 0, $this->Lang('friendlyname'), $this->Lang('uninstalled'));

?>