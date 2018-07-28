<?php

if (!cmsms())exit;
if (!$this->VisibleToAdminUser()) {
  echo $this->lang("nopermission");
  return;
}

if (isset($params["hidedonationssubmit"])) {
  $this->SetPreference("hidedonationstab",$this->GetVersion());
}

$this->ReadSettings();
$this->CleanVisitors();
$this->CleanReferers();

//$this->FireDebug("We're into Firedebugging!","trace");
if (!$this->VisibleToAdminUser()) {
  $this->ShowError($this->Lang("accessdenied"));
  return;
}
/*$this->Log("level1",1);
$this->Log("level2",2);
$this->Log("level3",3);*/
//Check the adminip-function
if ($this->ignoreadmins=="1") {
  $adminips=$this->GetPreference("adminips");
  if (($adminips=="") /*|| (eregi($_SERVER["REMOTE_ADDR"],$adminips)===false)*/) {
    $adminips.=$_SERVER["REMOTE_ADDR"].";";
    $this->SetPreference("adminips", $adminips);
  }
//echo "Ignoring: ".$adminips;
}

//Check for the geoip
if ($this->countrydetection=="geoip") {
  if (!file_exists(dirname(__FILE__)."/geoip/GeoIP.dat")) {
    echo $this->ShowErrors($this->lang("missinggeoipdata",array($this->geoipurl,$this->geoipurl)));
  }
}

$activetab="";
if (isset($params["activetab"])) $activetab=$params["activetab"];


echo $this->StartTabHeaders();
if ($this->CheckPermission('View Statistics')) {
  echo $this->SetTabHeader("statistics",$this->lang("statistics"));
  if ($this->visitortracking=="1" && isset($params["trackid"])) {
    echo $this->SetTabHeader("tracking",$this->lang("tracking"),($activetab=="tracking"));
  }
}
if ($this->CheckPermission('Administrate Statistics')) {
  echo $this->SetTabHeader("limits",$this->lang("limits"),($activetab=="limits"));
  echo $this->SetTabHeader("filters",$this->lang("filters"),($activetab=="filters"));
  echo $this->SetTabHeader("settings",$this->lang("settings"),($activetab=="settings"));
  echo $this->SetTabHeader("visuals",$this->lang("visuals"),($activetab=="visuals"));
  echo $this->SetTabHeader("templates",$this->lang("templates"),($activetab=="templates"));
  echo $this->SetTabHeader("resetdata",$this->lang("resetdata"),($activetab=="resetdata"));
  if ($this->debuglog==1) echo $this->SetTabHeader("debuglog","Debug log",($activetab=="debuglog"));
}
if ($this->ShowDonationsTab()) {
  echo $this->SetTabHeader("donations",$this->lang("donationstab"),($activetab=="donations"));
}
echo $this->EndTabHeaders();
echo $this->StartTabContent();
if ($this->CheckPermission('View Statistics')) {
  echo $this->StartTab("statistics");
  include(dirname(__FILE__)."/function.statistics.php");
  echo $this->EndTab();

  if ($this->visitortracking=="1" && isset($params["trackid"])) {
    echo $this->StartTab("tracking");
    include(dirname(__FILE__)."/function.tracking.php");
    echo $this->EndTab();
  }
}
if ($this->CheckPermission('Administrate Statistics')) {
  echo $this->StartTab("limits");
  include(dirname(__FILE__)."/function.limits.php");
  echo $this->EndTab();

  echo $this->StartTab("filters");
  include(dirname(__FILE__)."/function.filters.php");
  echo $this->EndTab();

  echo $this->StartTab("settings");
  include(dirname(__FILE__)."/function.settings.php");
  echo $this->EndTab();

  echo $this->StartTab("visuals");
  include(dirname(__FILE__)."/function.visuals.php");
  echo $this->EndTab();

  echo $this->StartTab("templates");
  include(dirname(__FILE__)."/function.templates.php");
  echo $this->EndTab();

  echo $this->StartTab("resetdata");
  include(dirname(__FILE__)."/function.resetdata.php");
  echo $this->EndTab();

  if ($this->debuglog==1) {
    echo $this->StartTab("debuglog");
    echo $this->ShowDebuglines($id,$returnid,$params);
    echo $this->EndTab();
  }

}
if ($this->ShowDonationsTab()) {
  echo $this->StartTab("donations");
  include(dirname(__FILE__)."/function.donations.php");
  echo $this->EndTab();
}
echo $this->EndTabContent();
?>