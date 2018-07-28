<?php
if (!cmsms())exit;

$db = cmsms()->GetDb();
$this->ReadSettings();

if (isset($params["file"])) {
  if (file_exists($file)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename='.basename($file));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    ob_clean();
    flush();
    readfile($file);
    exit;
}
}


$what="";
if (isset($params["what"])) {
  $what=$params["what"];
}

$how="dont";
if (isset($params["how"])) {
  $how=$params["how"];
}
 

$ignored=false;
$value=$this->Execute($what,$params,$ignored);

if (!$ignored && ($this->jsdetects=="1")) { //Prevent js-inserts for users that were ignored
  if(!isset($_SESSION["cmsms_statistics_javascript_checked"])) {
  ?> 
<script type="text/javascript">
/* <![CDATA[ */

writeJavaScriptCookie();

function writeJavaScriptCookie() {
  var date = new Date();
  date.setTime(date.getTime()+(60*60*1000));
  var the_cookie_date = date;
  var the_cookie = "cmsms_statistics_javascript_detected=true";
  the_cookie = the_cookie + ";expires=" + the_cookie_date;
  document.cookie=the_cookie;
}
/* ]]> */
</script>
    
      
    <?php
      $_SESSION["cmsms_statistics_javascript_checked"] = "done";
   }
   
  
  
  
  if(!isset($_COOKIE["cmsms_statistics_module_resolution"])) {
    ?>
<script type="text/javascript">

/* <![CDATA[ */

writeResolutionCookie();

function writeResolutionCookie() {
  var date = new Date();
  date.setTime(date.getTime()+(60*60*1000));
  var the_cookie_date = date;
  var the_cookie = "cmsms_statistics_module_resolution="+ screen.width +"x"+ screen.height;
  var the_cookie = the_cookie + ";expires=" + the_cookie_date;
  document.cookie=the_cookie;

  var bn=navigator.appName;    // Browser Name
  if (bn.substring(0,9)=="Microsoft") {
     bn="MSIE";            // browser name, cont'd
  };         
  var cd=(bn=="MSIE")?screen.colorDepth:screen.pixelDepth; // Color depth
  if (cd!="undefined") {
    var the_depthcookie="cmsms_statistics_module_colordepth=";
    the_depthcookie=the_depthcookie+cd;
    the_depthcookie = the_depthcookie + ";expires=" + the_cookie_date;
    document.cookie=the_depthcookie;
  }
}
/* ]]> */
</script>
    
    <?php
  }
}

//echo $value;

switch ($how) {
  case "gfx" : {
    
    echo $this->OutputGfxText($value);
    break;
  }
  case "text" :
  case "txt" : {
    echo $value;
    break;
  }
  default : break;
}
?>