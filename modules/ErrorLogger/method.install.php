<?php

   //create table
   $objADOConnection =& $this->GetDb();
   $objDataDictionary = NewDataDictionary($objADOConnection);
   $arrDatabaseDefinition = array('mysql' => 'TYPE=MyISAM');
   $arrFieldDefinition = "log_ID I KEY NOTNULL,
                          log_time C(19) NOTNULL,
                          log_type C(32) NOTNULL,
                          log_message C(255) NOTNULL,
                          log_location C(128)";
   $sqlarray = $objDataDictionary->CreateTableSQL(cms_db_prefix().'module_errorlogger_log', $arrFieldDefinition, $arrDatabaseDefinition);
   $res = $objDataDictionary->ExecuteSQLArray($sqlarray);
   if ($res != 2) die(basename(__FILE__).':'.__LINE__." DB-Error: " . $objADOConnection->ErrorMsg());
   //index
   $indexCount=1;
   $arrFields=array('log_ID');
   $sqlarray = $objDataDictionary->CreateIndexSQL('workshops_'.$indexCount, cms_db_prefix().'module_errorlogger_log', $arrFields);
   $res = $objDataDictionary->ExecuteSQLArray($sqlarray);
   if ($res != 2) die(basename(__FILE__).':'.__LINE__." DB-Error: " . $objADOConnection->ErrorMsg());
   $indexCount++;
   $arrFields=array('log_time');
   $sqlarray = $objDataDictionary->CreateIndexSQL('workshops_'.$indexCount, cms_db_prefix().'module_errorlogger_log', $arrFields);
   $res = $objDataDictionary->ExecuteSQLArray($sqlarray);
   if ($res != 2) die(basename(__FILE__).':'.__LINE__." DB-Error: " . $objADOConnection->ErrorMsg());
   $indexCount++;
   $arrFields=array('log_type');
   $sqlarray = $objDataDictionary->CreateIndexSQL('workshops_'.$indexCount, cms_db_prefix().'module_errorlogger_log', $arrFields);
   $res = $objDataDictionary->ExecuteSQLArray($sqlarray);
   if ($res != 2) die(basename(__FILE__).':'.__LINE__." DB-Error: " . $objADOConnection->ErrorMsg());
   $indexCount++;
   $arrFields=array('log_message');
   $sqlarray = $objDataDictionary->CreateIndexSQL('workshops_'.$indexCount, cms_db_prefix().'module_errorlogger_log', $arrFields);
   $res = $objDataDictionary->ExecuteSQLArray($sqlarray);
   if ($res != 2) die(basename(__FILE__).':'.__LINE__." DB-Error: " . $objADOConnection->ErrorMsg());
   $indexCount++;
   $arrFields=array('log_location');
   $sqlarray = $objDataDictionary->CreateIndexSQL('workshops_'.$indexCount, cms_db_prefix().'module_errorlogger_log', $arrFields);
   $res = $objDataDictionary->ExecuteSQLArray($sqlarray);
   if ($res != 2) die(basename(__FILE__).':'.__LINE__." DB-Error: " . $objADOConnection->ErrorMsg());
   //sequence
   $res = $objADOConnection->CreateSequence(cms_db_prefix().'module_errorlogger_log_seq');
   if (!$res) die(basename(__FILE__).':'.__LINE__." DB-Error: " . $objADOConnection->ErrorMsg());

   // permissions
   $this->CreatePermission('ErrorLogger_View','ErrorLogger - View');
   $this->CreatePermission('ErrorLogger_Edit','ErrorLogger - Edit');


   //insert error handler to config file
   $arrConfig = \cms_config::get_instance();
   $strConfigFile = $arrConfig['root_path'] . DIRECTORY_SEPARATOR . 'config.php';
   $strContent = file_get_contents($strConfigFile);
   $strContent = str_replace('?>', $this->getConfigContent().'?>', $strContent);

   if (is_writable($strConfigFile)) {
      $res = file_put_contents($strConfigFile, $strContent);
      if ($res === false) {
         trigger_error($this->GetName().' - Config file could not be changed', E_USER_ERROR);
      }
   }
   else {
      trigger_error($this->GetName().' - Config file is not write able', E_USER_WARNING);
   }

   //save default settings.inc.php
   $strContent = "<?php".PHP_EOL.
                 "//saved at ".date("Y-m-d H:i:s").PHP_EOL.
                 "define('MOD_ERROR_LOGGER_INFO',           false);".PHP_EOL.
                 "define('MOD_ERROR_LOGGER_WARNING',        false);".PHP_EOL.
                 "define('MOD_ERROR_LOGGER_ERROR',          true);".PHP_EOL.
                 "define('MOD_ERROR_LOGGER_EXCEPTION',      true);".PHP_EOL.
                 "define('MOD_ERROR_LOGGER_ITEMS_PER_PAGE', 10);".PHP_EOL.
                 "?>";
   file_put_contents(dirname(__FILE__).DIRECTORY_SEPARATOR.'settings.inc.php', $strContent);


   // put mention into the admin log
   $this->Audit( 0, $this->Lang('friendlyname'), $this->Lang('installed',$this->GetVersion()));
   trigger_error($this->GetName().' - log has been installed', E_USER_NOTICE);

?>