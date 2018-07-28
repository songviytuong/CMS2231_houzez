<?php
if (!cmsms())exit;
if (!$this->CheckPermission('Administrate Statistics')) {
	echo $this->lang("nopermission");
	return;
}



if (isset($params["countrydetection"])) {
  $currentsetting=$this->GetPreference("countrydetection","superdomain");
  if ($params["countrydetection"]!=$currentsetting) {
    $this->ResetData("count_country");
    $this->SetPreference("countrydetection",$params["countrydetection"]);
  }
}

if (isset($params["iphandling"])) $this->SetPreference("iphandling",$params["iphandling"]);

if (isset($params["maxlogage"])) $this->SetPreference("maxlogage",$params["maxlogage"]);
if (isset($params["loglinesperpage"])) $this->SetPreference("loglinesperpage",$params["loglinesperpage"]);
if (isset($params["emailinterval"])) {
	if ($params["emailinterval"]!=-1) {
		$this->SetPreference("lastemailtime",time());
	}
	$this->SetPreference("emailinterval",$params["emailinterval"]);
}
if (isset($params["statemail"])) $this->SetPreference("statemail",$params["statemail"]);
if (isset($params["emailsubject"])) $this->SetPreference("emailsubject",$params["emailsubject"]);
if (isset($params["adminsection"])) $this->SetPreference("adminsection",$params["adminsection"]);

$message=$this->Lang("settingssaved");
if (isset($params["savesettingsemail"])) {
   $this->SendEmailStats(true);
  $message=$this->Lang("settingssavedemail");
}

if (isset($params["keywordreplacements"])) $this->SetPreference("keywordreplacements",$params["keywordreplacements"]);

if (isset($params["singlekeywords"])) {
	$this->SetPreference("singlekeywords","1");
} else {
	$this->SetPreference("singlekeywords","0");
}

if (isset($params["jsdetects"])) {
	$this->SetPreference("jsdetects","1");
} else {
	$this->SetPreference("jsdetects","0");
}

if (isset($params["visitortracking"])) {
	$this->SetPreference("visitortracking","1");
} else {
	$this->SetPreference("visitortracking","0");
}

if (isset($params["counturlaccess"])) {
	$this->SetPreference("counturlaccess","1");
} else {
	$this->SetPreference("counturlaccess","0");
}

if (isset($params["debugloglevel"])) $this->SetPreference("debugloglevel",$params["debugloglevel"]);

if (isset($params["debuglog"])) {
	$this->SetPreference("debuglog","1");
} else {
	$this->SetPreference("debuglog","0");
	$db=cmsms()->GetDb();
	$sql="DELETE FROM ".cms_db_prefix()."module_stat_logstrings";
	$db->Execute($sql);
}
/*$this->ReadSettings();
 $this->ShowMessage($this->Lang("settingssaved"));
 */

//$this->SaveSettings($id,$params);
//$this->ShowStat($id,$returnid,99);

$show="";if (isset($params["show"])) $show=$params["show"];
$this->Redirect($id, 'defaultadmin', '', array("module_message"=>$message,"activetab"=>"settings","show"=>$show));
?>