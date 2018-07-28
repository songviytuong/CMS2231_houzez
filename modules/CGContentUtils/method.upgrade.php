<?php
if( !isset($gCms) ) exit;
if( version_compare(CMS_VERSION,'1.99') < 0 ) {
  return "ERROR: This module is not compatible with this version of CMSMS";
}

?>