<?php
   /**
    * @author Oliver Jooss
    * @copyright 2013
    */

   //start CMS
   $CMS_ADMIN_PAGE=1;
   $path = dirname(dirname(dirname(__FILE__)));
   require_once($path . DIRECTORY_SEPARATOR . 'include.php');

   header("Pragma: public");
   header("Expires: 0");
   header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
   header("Cache-Control: private", false); // required for certain browsers
   header("Content-Type: application/csv");
   header("Content-Disposition: attachment; filename=\"ErrorLogger.csv\";" );
   header("Content-Transfer-Encoding: binary");
   ob_clean();

   //headline
   $arrHeadline = array('ID','time','type','message','location');
   echo '"'.implode('";"', $arrHeadline).'"' . PHP_EOL;

   // get CMS Object
   if (isset($GLOBALS['gCms'])) {
      return $GLOBALS['gCms'];
   }
   elseif(method_exists('CmsApp','get_instance')) {
      return CmsApp::get_instance();
   }
   elseif(method_exists('CmsObject','get_instance')) {
      return CmsObject::get_instance();
   }
   else {
      die('No CMS Object found');
   }
   $objADOConnection = $objCMS->GetDb();
   $query = "SELECT * FROM ".cms_db_prefix()."module_errorlogger_log";
   $dbresult = $objADOConnection->Execute($query);
   if ($dbresult === false) die( 'DB-ERROR ('.basename(__FILE__).':'.__LINE__.'): '.$objADOConnection->ErrorMsg() );
   while ($row = $dbresult->FetchRow()) {
      echo '"'.implode('";"', $row).'"' . PHP_EOL;
   }
   exit();

?>