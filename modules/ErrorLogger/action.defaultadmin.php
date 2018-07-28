<?php

   if (! $this->CheckPermission("ErrorLogger_View")) {
      echo '<h3>'.$this->Lang('accessdenied').'</h3>';
      return false;
   }

   /********************************* setup *********************************/

   $objCMS = $this->getCMS();
   $objADOConnection = $this->GetDb();

   /********************************* actions *********************************/

   if (isset($_POST['el_clear'])) {
      $objADOConnection =& $this->GetDb();
      $query = "DELETE FROM ".cms_db_prefix()."module_errorlogger_log";
      $objADOConnection->Execute($query);
      $query = "UPDATE ".cms_db_prefix()."module_errorlogger_log_seq SET id=1";
      $objADOConnection->Execute($query);
      trigger_error($this->GetName().' - log has been cleared', E_USER_NOTICE);
      echo '<div style="width:300px; border:none; padding:3px; margin-bottom:15px; color:#1E8A00; font-weight:bold; ">log has been cleared</div>';
   }

   /**************************** select data from db ****************************/

   $strSort = "";
   if (strlen($this->strSort) > 0) {
       $strSort = str_replace('|', " ", $this->strSort);
      $strSort = str_replace('__', ".", $strSort);
      $strSort = " ORDER BY ".$strSort;
      $this->smarty->assign('SORT', $this->strSort);
   }
   $strFilter = "";
   if (isset($_POST['filter'])) {
      foreach((array)$_POST['filter'] as $strField => $strValue) {
         //ignore empty fields
         if (strlen(trim($strValue)) == 0) continue;
         //enable wildcard
         $strValue = str_replace("*", "%", $strValue);
         $strFilter .= " AND ".mysql_real_escape_string($strField)." LIKE '%".mysql_real_escape_string($strValue)."%' ";
      }
      $strFilter = preg_replace("~^[ ]*AND~", " WHERE ", $strFilter);
      $this->smarty->assign('FILTER', $_POST['filter']);
   }
   $strLimit = " LIMIT " . (($this->intCurrentPage-1)*MOD_ERROR_LOGGER_ITEMS_PER_PAGE) . ", " . MOD_ERROR_LOGGER_ITEMS_PER_PAGE;
   $query = "SELECT * FROM ".cms_db_prefix()."module_errorlogger_log ".$strFilter.$strSort.$strLimit;
   $dbresult = $objADOConnection->Execute($query);
   if ($dbresult === false) {
      die( 'DB-ERROR ('.basename(__FILE__).':'.__LINE__.'): '.$objADOConnection->ErrorMsg() . '<br />Query: ' . $query );
   }
   $arrData = array();
   while ($row = $dbresult->FetchRow()) {
      $arrData[] = $row;
   }
   $this->smarty->assign('LOG_MESSAGES', $arrData);

   /********************************* count data sets *********************************/

   $query = "SELECT count(*) AS amount FROM ".cms_db_prefix()."module_errorlogger_log ".$strFilter;
   $dbresult = $objADOConnection->Execute($query);
   if ($dbresult === false) {
      die( 'DB-ERROR ('.basename(__FILE__).':'.__LINE__.'): '.$objADOConnection->ErrorMsg() . '<br />Query: ' . $query );
   }
   $arrData = array();
   $intCount = 0;
   if ($row = $dbresult->FetchRow()) {
      $intCount = $row['amount'];
   }
   $this->smarty->assign('PAGE',  $this->intCurrentPage);
   $this->smarty->assign('PAGES', ceil($intCount / MOD_ERROR_LOGGER_ITEMS_PER_PAGE));

   /********************************* display *********************************/

   #$this->smarty->display(dirname(__FILE__).'/loglist.tpl');
   echo $this->ProcessTemplate('loglist.tpl');

   echo '<hr />'.
        '<a href="'.$this->GetModuleURLPath() . DIRECTORY_SEPARATOR . 'dump.php">Download CSV</a>' .
        ' | '.
        $this->CreateLink($id, 'settings', '', 'Module settings').
        ' | '.
        $this->CreateLink($id, 'test', '', 'Run module test').
        '<p>&nbsp;</p>';


?>