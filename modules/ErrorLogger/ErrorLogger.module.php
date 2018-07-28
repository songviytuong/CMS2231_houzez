<?php
#-------------------------------------------------------------------------
# Module: ErrorLogger - Provides different ErrorLogger to find out what's going on
# Version: 1.0, Oliver Jooß
#
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2012 by Ted Kulp (wishy@cmsmadesimple.org)
# This project's homepage is: http://www.cmsmadesimple.org
#
# This file originally created by ModuleMaker module, version 0.3.2
# Copyright (c) 2012 by Samuel Goldstein (sjg@cmsmadesimple.org)
#
#-------------------------------------------------------------------------
#
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
# Or read it online: http://www.gnu.org/licenses/licenses.html#GPL
#
#-------------------------------------------------------------------------

#-------------------------------------------------------------------------
# For Help building modules:
# - Read the Documentation as it becomes available at
#   http://dev.cmsmadesimple.org/
# - Check out the Skeleton Module for a commented example
# - Look at other modules, and learn from the source
# - Check out the forums at http://forums.cmsmadesimple.org
# - Chat with developers on the #cms IRC channel
#-------------------------------------------------------------------------

require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'settings.inc.php');

class ErrorLogger extends CMSModule
{

   protected $strModuleId   = null;
   protected $strReturnId   = null;
   protected $strActionName = null;
   protected $arrParams     = null;
   protected $intCurrentPage  = 1;
   protected $strSort         = 'log_ID|desc';

   public function GetName() { return 'ErrorLogger'; }
   public function GetFriendlyName() { return $this->Lang('friendlyname'); }
   public function GetVersion() { return '1.5.1'; }
   public function GetHelp() { return $this->Lang('help'); }
   public function GetAuthor() { return 'Oliver Joo&szlig;'; }
   public function GetAuthorEmail() { return ''; }
   public function GetChangeLog() { return $this->Lang('changelog'); }
   public function IsPluginModule() { return false; }
   public function HasAdmin() { return true; }
   public function GetAdminSection() { return 'siteadmin'; }
   public function GetAdminDescription() { return $this->Lang('admindescription'); }
   public function VisibleToAdminUser()   { return true; }
   public function MinimumCMSVersion() { return "1.9"; }
   public function GetDependencies() { return array(); }
   public function InitializeAdmin() { $this->RestrictUnknownParams(); }
   public function InitializeFrontend() { $this->RestrictUnknownParams(); }
   public function UninstallPreMessage() { return $this->Lang('really_uninstall'); }

   public function InstallPostMessage() {
      if (!defined('MOD_ERROR_LOGGER')) {
         return 'The module is ready to use, ' .
                '<br />' .
                '<br />' .
                '<img src="'.$this->GetModuleURLPath().DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'warning.gif" /> ' .
                'but the CMS config.php could not be changed (maybe write protected)!' .
                '<br />' .
                'Please add this lines of code by yourself: ' .
                '<br />'.
                '<pre>'.$this->getConfigContent().'</pre>';
      }
      else {
         return 'The module is ready to use!';
      }
   }

   /**
    * @return ErrorLogger
    */
   public function __construct() {
      parent::__construct();
      $this->writLogToDB();
   }

   public function __destruct() {
      $this->writLogToDB();
   }

   protected function writLogToDB() {
      //display errors if not
      $strTmpFile = TMP_CACHE_LOCATION . DIRECTORY_SEPARATOR . 'ErrorLogger.tmp';
      if (file_exists($strTmpFile)) {
         $objCMS = cmsms();
         $objADOConnection = $objCMS->GetDb();
         if (!$objADOConnection->IsConnected()) {
            return; //we have to save next time
         }
         $arrBuffer = unserialize(file_get_contents($strTmpFile));
         foreach($arrBuffer as $arrLog) {
            $query = 'INSERT INTO '.cms_db_prefix().'module_errorlogger_log (log_ID, log_time, log_type, log_message, log_location) VALUES (?,?,?,?,?)';
            $newid = $objADOConnection->GenID(cms_db_prefix()."module_errorlogger_log_seq");
            $res = $objADOConnection->Execute($query, array($newid,$arrLog['time'],$arrLog['type'],$arrLog['message'],$arrLog['file'].':'.$arrLog['line']));
            if ( (is_numeric($res) && $res != 2) || $res === false) die(basename(__FILE__).':'.__LINE__." DB-Error: " . $objADOConnection->ErrorMsg());
         }
         unlink($strTmpFile);
      }
   }

   /**
    * getter for CMS Object
    * @return CmsObject
    */
   public static function getCMS() {
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
         die(__METHOD__.' failed!');
      }
   }

   /**
    * getter for config file code
    *
    * @return String
    */
   protected function getConfigContent() {
      return PHP_EOL.
             "/// ".$this->GetName().PHP_EOL.
             "require_once('".dirname(__FILE__)."/ErrorLogger.handler.php');".PHP_EOL.
             PHP_EOL;
   }

   /* before calling parent, we store the params */
   function DoAction($name,$id,$params,$returnId='') {

      //save params
      if (isset($_POST['page']) && (int)$_POST['page'] > 0) {
         $this->intCurrentPage = (int)$_POST['page'];
      }

      if (isset($_POST['sort']) && is_array($_POST['sort'])) {
         $this->strSort = key($_POST['sort']);
      }
      elseif (isset($_POST['hidden_sort']) && strlen($_POST['hidden_sort'])>0) {
         $this->strSort = $_POST['hidden_sort'];
      }

      //pimp smarty
      $objCMS = $this->getCMS();
      $smarty = cmsms()->GetSmarty();
      $smarty->register_function('errorlogger_sortbutton', array($this, 'smartyFunctionSortButton'));

      //now call the parent function
      parent::DoAction($name,$id,$params,$returnId);
   }

   /* get sort image button within smarty template */
   public function smartyFunctionSortButton($params,&$smarty=null) {

      if (!isset($params['field'])) throw new Exception("Missing param 'field' for " . __METHOD__);

      $strReturn = '';

      $strSort = $params['field'].'|asc';
      if ($this->strSort == $strSort) $strImage = 'icon_sort_asc_act.gif';
      else $strImage = 'icon_sort_asc.gif';
      $strReturn .= '<input type="image" style="border:0; background:none;" name="sort['.$strSort.']" src="'.$this->GetModuleURLPath().DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.$strImage.'" />';

      $strReturn .= '<br />';

      $strSort = $params['field'].'|desc';
      if ($this->strSort == $strSort) $strImage = 'icon_sort_desc_act.gif';
      else $strImage = 'icon_sort_desc.gif';
      $strReturn .= '<input type="image" style="border:0; background:none;" name="sort['.$strSort.']" src="'.$this->GetModuleURLPath().DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.$strImage.'" />';

      return $strReturn;
   }

}

?>