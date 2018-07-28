<?php
class statistics_utils
{
  static private $_initialized = FALSE;
  static private $_mod;
  static private $_cms;
  static private $_cop;
  static private $_current_content;
  
  static private function _initialize()
  {
    if(!self::$_initialized)
    {
      self::$_cms = cmsms();
      self::$_mod = self::$_cms->GetModuleInstance('Statistics');
      self::$_cop = self::$_cms->GetContentOperations();
      self::$_initialized = TRUE;
    }   
  }
  
  static public function GetCurremtContentObj()
  {
    if( is_null(self::$_current_content) )
    {
      self::_initialize();
      self::$_current_content = self::$_cop->getContentObject();
    }
    
    return self::$_current_content;
  }
  
  public static function isCMS2()
  {
    return (bool)(version_compare(CMS_VERSION, '2.0') > -1);
  }
  
}
?>
