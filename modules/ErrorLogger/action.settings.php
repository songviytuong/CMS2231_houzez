<?php



   if (! $this->CheckPermission("ErrorLogger_Edit")) {
      echo '<h3>'.$this->Lang('accessdenied').'</h3>';
      return false;
   }

   $MOD_ERROR_LOGGER_INFO           = MOD_ERROR_LOGGER_INFO;
   $MOD_ERROR_LOGGER_WARNING        = MOD_ERROR_LOGGER_WARNING;
   $MOD_ERROR_LOGGER_ERROR          = MOD_ERROR_LOGGER_ERROR;
   $MOD_ERROR_LOGGER_EXCEPTION      = MOD_ERROR_LOGGER_EXCEPTION;
   $MOD_ERROR_LOGGER_ITEMS_PER_PAGE = MOD_ERROR_LOGGER_ITEMS_PER_PAGE;

   echo '<h2>Module settings</h2>';

   if (isset($_POST['el_settings'])) {
      $MOD_ERROR_LOGGER_INFO           = ($_POST['el_notices']=='true');
      $MOD_ERROR_LOGGER_WARNING        = ($_POST['el_warnings']=='true');
      $MOD_ERROR_LOGGER_ERROR          = ($_POST['el_errors']=='true');
      $MOD_ERROR_LOGGER_EXCEPTION      = ($_POST['el_exceptions']=='true');
      $MOD_ERROR_LOGGER_ITEMS_PER_PAGE = $_POST['el_ipp'];

      //save to settings.inc.php
      $strContent = "<?php".PHP_EOL.
                    "//saved at ".date("Y-m-d H:i:s").PHP_EOL.
                    "define('MOD_ERROR_LOGGER_INFO',           ".$_POST['el_notices'].");".PHP_EOL.
                    "define('MOD_ERROR_LOGGER_WARNING',        ".$_POST['el_warnings'].");".PHP_EOL.
                    "define('MOD_ERROR_LOGGER_ERROR',          ".$_POST['el_errors'].");".PHP_EOL.
                    "define('MOD_ERROR_LOGGER_EXCEPTION',      ".$_POST['el_exceptions'].");".PHP_EOL.
                    "define('MOD_ERROR_LOGGER_ITEMS_PER_PAGE', ".$_POST['el_ipp'].");".PHP_EOL.
                    "?>";
      file_put_contents(dirname(__FILE__).DIRECTORY_SEPARATOR.'settings.inc.php', $strContent);
      trigger_error($this->GetName().' - changes have been saved', E_USER_NOTICE);
      echo '<div style="width:300px; border:none; padding:3px; margin-bottom:15px; color:#1E8A00; font-weight:bold; ">changes have been saved</div>';
   }

   if (isset($_POST['el_clear'])) {
      $objADOConnection =& $this->GetDb();
      $query = "DELETE FROM ".cms_db_prefix()."module_errorlogger_log";
      $objADOConnection->Execute($query);
      $query = "UPDATE ".cms_db_prefix()."module_errorlogger_log_seq SET id=1";
      $objADOConnection->Execute($query);
      trigger_error($this->GetName().' - log has been cleared', E_USER_NOTICE);
      echo '<div style="width:300px; border:none; padding:3px; margin-bottom:15px; color:#1E8A00; font-weight:bold; ">log has been cleared</div>';
   }

   $this->smarty->assign('MOD_ERROR_LOGGER_INFO',           $MOD_ERROR_LOGGER_INFO);
   $this->smarty->assign('MOD_ERROR_LOGGER_WARNING',        $MOD_ERROR_LOGGER_WARNING);
   $this->smarty->assign('MOD_ERROR_LOGGER_ERROR',          $MOD_ERROR_LOGGER_ERROR);
   $this->smarty->assign('MOD_ERROR_LOGGER_EXCEPTION',      $MOD_ERROR_LOGGER_EXCEPTION);
   $this->smarty->assign('MOD_ERROR_LOGGER_ITEMS_PER_PAGE', $MOD_ERROR_LOGGER_ITEMS_PER_PAGE);
   #$this->smarty->display(dirname(__FILE__).'/templates/settings.tpl');
   echo $this->ProcessTemplate('settings.tpl');

   echo '<hr />'.$this->CreateLink($id, 'defaultadmin', '', ' &laquo; go back to list');
   echo '<p>&nbsp;</p>';


?>