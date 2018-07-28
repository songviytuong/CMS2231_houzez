<?php

//log everything here
error_reporting(E_ALL);

define('MOD_ERROR_LOGGER',  true);

require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'settings.inc.php');

/**
 * write log messages into tmp file.
 * Module will write them to database as soon as possible
 *
 * @param String $sType
 * @param String $sMessage
 * @param String $sFile
 * @param Integer $iLine
 */
function ErrorLogger_log($sType, $sMessage, $sFile, $iLine) {

   //check if user wants to log the current type
   if (!preg_match('~ErrorLogger~i', $sMessage)) {
      if (preg_match('~notice~i', $sType) && MOD_ERROR_LOGGER_INFO == false) return true;
      if (preg_match('~warn~i', $sType) && MOD_ERROR_LOGGER_WARNING == false) return true;
      if (preg_match('~error~i', $sType) && MOD_ERROR_LOGGER_ERROR == false) return false;
      if (preg_match('~exception~i', $sType) && MOD_ERROR_LOGGER_EXCEPTION == false) return false;
   }
   $strTmpFile = TMP_CACHE_LOCATION . DIRECTORY_SEPARATOR . 'ErrorLogger.tmp';
   //load old messages
   if (file_exists($strTmpFile)) {
      $arrBuffer = unserialize(file_get_contents($strTmpFile));
   }
/*
   /// just for debug
   $tmp = debug_backtrace();
   $arrTrace = array();
   foreach($tmp as $tmp2) {
      if (isset($tmp2['file']))   $arrTrace[] = $tmp2['file'].':'.$tmp2['line'];
   }
   echo '<pre>'.$sMessage.(print_r($arrTrace,true)).'</pre>';
*/
   //add new message
   $arrBuffer[] = array('time'    => date("Y-m-d H:i:s"),
                        'type'    => $sType,
                        'message' => $sMessage,
                        'file'    => basename($sFile), //remove path for security reasons
                        'line'    => $iLine);
   //save to tmp file
   $tmp = file_put_contents($strTmpFile, serialize($arrBuffer));
   return ((int)$tmp > 0);
}

/**
 * Put an event into the audit (admin) log.  This should be
 * done on most admin events for consistency.
 *
 * @since 0.3
 * @param integer The item id (perhaps a content id, or a record id from a module)
 * @param string  The item name (perhaps Content, or the module name)
 * @param string  The action that needs to be audited
 * @return void

 function audit($itemid, $itemname, $action)

*/



/**
 * converts a errorcode to string
 * @param Integer $code
 * @return String
 */
function ErrorLogger_ErrorCodeToString($code) {
   switch ($code) {
      case E_ERROR:        return "ERROR";
      case E_USER_ERROR:   return "USER_ERROR";
      case E_WARNING:      return "WARNING";
      case E_USER_WARNING: return "USER_WARNING";
      case E_NOTICE:       return "NOTICE";
      case E_USER_NOTICE:  return "USER_NOTICE";
      case E_STRICT:       return "STRICT_WARNING";
      case E_DEPRECATED:   return "DEPRECATED_WARNING";
      default:             return "UNKNOWN_ERROR (".$code.")";
   }
}

function ErrorLogger_ErrorHandler($errorcode, $errortext, $errorfile, $errorline) {
   $sType = ErrorLogger_ErrorCodeToString($errorcode);
   return ErrorLogger_log($sType, $errortext, $errorfile, $errorline);
}
set_error_handler('ErrorLogger_ErrorHandler');


function ErrorLogger_ExceptionHandler($exception) {
   echo "PHP Fatal error:  Uncaught exception '".get_class($exception)."' with message '".$exception->getMessage()."' in ".$exception->getFile().":".$exception->getLine();
   return ErrorLogger_log(get_class($exception), $exception->getMessage(), $exception->getFile(), $exception->getLine());
}
set_exception_handler("ErrorLogger_ExceptionHandler");


function ErrorLogger_ShutdownFunction() {
   $error = error_get_last();
   if( $error['type'] == E_ERROR || $error['type'] == E_USER_ERROR ) {
      $sType = ErrorLogger_ErrorCodeToString($error['type']);
      ErrorLogger_log($sType, $error['message'], $error['file'], $error['line']);
   }
}
register_shutdown_function('ErrorLogger_ShutdownFunction');



/*
audit($itemid,$itemname,$action);

 */

?>