<?php
if (!isset($gCms)) exit;
if (!$this->CheckPermission('Administrate Statistics')) {
  echo $this->lang("nopermission");
  return;
}
$smarty->assign('jsdetectstext',$this->lang("jsdetects"));
$smarty->assign('jsdetectshelp',$this->lang("jsdetectshelp"));
$smarty->assign('jsdetectsinput',$this->CreateInputCheckBox($id,"jsdetects","1",$this->jsdetects));

$smarty->assign('visitortrackingtext',$this->lang("visitortracking"));
$smarty->assign('visitortrackinghelp',$this->lang("visitortrackinghelp"));
$smarty->assign('visitortrackinginput',$this->CreateInputCheckBox($id,"visitortracking","1",$this->visitortracking));

$smarty->assign('iphandlingtext',$this->lang("iphandling"));
$smarty->assign('iphandlinghelp',$this->lang("iphandlinghelp"));
$iphandlings=array($this->Lang("iphandlingwhole")=>"whole", $this->Lang("iphandlinghalf")=>"half", $this->Lang("iphandlingnone")=>"none");
$smarty->assign('iphandlinginput',$this->CreateInputDropdown($id,"iphandling",$iphandlings,"",$this->iphandling));


$smarty->assign('keywordreplacementstext',$this->lang("keywordreplacements"));
$smarty->assign('keywordreplacementshelp',$this->lang("keywordreplacementshelp"));
$smarty->assign('keywordreplacementsinput',$this->CreateInputText($id,"keywordreplacements",$this->keywordreplacements,80,255));

$smarty->assign('singlekeywordstext',$this->lang("singlekeywords"));
$smarty->assign('singlekeywordshelp',$this->lang("singlekeywordshelp"));
$smarty->assign('singlekeywordsinput',$this->CreateInputCheckbox($id,"singlekeywords","1",$this->singlekeywords));

$smarty->assign('counturlaccesstext',$this->lang("counturlaccess"));
$smarty->assign('counturlaccesshelp',$this->lang("counturlaccesshelp"));
$smarty->assign('counturlaccessinput',$this->CreateInputCheckBox($id,"counturlaccess","1",$this->counturlaccess));


$smarty->assign('debuglogtext',$this->lang("debuglog"));
$smarty->assign('debugloginput',$this->CreateInputCheckBox($id,"debuglog","1",$this->debuglog));

$smarty->assign('debuglogleveltext',$this->lang("debugloglevel"));
$loglevels=array($this->Lang("logsparse")=>1, $this->Lang("logverbose")=>2, $this->Lang("logeverything")=>3);
$smarty->assign('debugloglevelinput',$this->CreateInputDropdown($id,"debugloglevel",$loglevels,"",$this->debugloglevel));

$smarty->assign('maxlogagetext',$this->lang("maxlogage"));
//$smarty->assign('lines',$this->lang("lines"));
//$sizes=array("100"=>100,"500"=>500,"1000"=>1000,"5000"=>5000,$this->Lang("unlimited")=>-1);
$ages=array("1 ".$this->Lang("minute")=>(60),"1 ".$this->Lang("hour")=>(3600),"6 ".$this->Lang("hours")=>(3600*6),"12 ".$this->Lang("hours")=>(3600*12),"1 ".$this->Lang("day")=>(3600*24),"2 ".$this->Lang("day")=>(3600*48),"1 ".$this->Lang("week")=>(3600*24*7),$this->Lang("unlimited")=>-1);
$smarty->assign('maxlogagetext',$this->lang("maxlogage"));
$smarty->assign('maxlogageinput',$this->CreateInputDropDown($id,"maxlogage",$ages,-1,$this->GetPreference("maxlogage",(60*60*24*7))));


$smarty->assign('countrydetectiontext',$this->lang("countrydetection"));
$smarty->assign('countrydetectionhelp',$this->lang("countrydetectionhelp",array($this->geoipurl,$this->geoipurl)));
$countrydetections=array($this->Lang("superdomain")=>"superdomain",
  $this->Lang("geoip")=>"geoip",
  $this->Lang("disablecountrydetection")=>"disabled");
$smarty->assign('countrydetectioninput',$this->CreateInputDropDown($id,"countrydetection",$countrydetections,-1,$this->countrydetection));

$smarty->assign('adminsectiontext',$this->lang("adminsection"));
//$smarty->assign('dateformathelp',$this->lang("dateformathelp"));
$adminsections=array(
  $this->Lang("siteadmin")=>"siteadmin",
  $this->Lang("extensions")=>"extensions"
);
$smarty->assign('adminsectioninput',$this->CreateInputDropDown($id,"adminsection",$adminsections,-1,$this->adminsection));

$smarty->assign('dateformattext',$this->lang("dateformat"));
$smarty->assign('dateformathelp',$this->lang("dateformathelp"));
$smarty->assign('dateformatinput',$this->CreateInputText($id,"dateformat",$this->dateformat, 50, 255));

$smarty->assign('statemailtext',$this->lang("statemail"));
$smarty->assign('statemailinput',$this->CreateInputText($id,"statemail",$this->statemail, 50, 255));

$smarty->assign('emailsubjecttext',$this->lang("emailsubject"));
$smarty->assign('emailsubjectinput',$this->CreateInputText($id,"emailsubject",$this->emailsubject, 50, 255));
$smarty->assign('emailsubjecthelp',$this->lang("emailsubjecthelp"));

$smarty->assign('topxtemplatetext',$this->lang("topxtemplate"));
$smarty->assign('topxtemplateinput',$this->CreateTextArea(false,$id,$this->topxtemplate,"topxtemplate","pagesmalltextarea"));
$smarty->assign('topxtemplatehelp',$this->lang("topxtemplatehelp"));

$emailintervals=array(
  $this->Lang("never")=>-1,
  $this->Lang("everyminute")=>(60),
  $this->Lang("everyhour")=>(2600),
  $this->Lang("onceaday")=>(3600*24),
  $this->Lang("onceaweek")=>(3600*24*7),
  $this->Lang("every2weeks")=>(3600*24*14),
  $this->Lang("onceamonth")=>(3600*24*31),
);
$smarty->assign('emailintervaltext',$this->lang("emailinterval"));
$smarty->assign('emailintervalinput',$this->CreateInputDropDown($id,"emailinterval",$emailintervals,-1,$this->emailinterval));

$smarty->assign('submitsettings',$this->CreateInputSubmit($id,"savesettings",$this->lang("savesettings")));
$smarty->assign('submitsettingsemail',$this->CreateInputSubmit($id,"savesettingsemail",$this->lang("savesettingsemail")));
if (isset($params["show"])) {
  $smarty->assign('show',$this->CreateInputHidden($id,"show",$params["show"]));
}
$smarty->assign('startform',$this->CreateFormStart($id,"savesettings",$returnid,"post","",true));
$smarty->assign('endform',$this->CreateFormEnd());
$smarty->assign('module',$this);


echo $this->ProcessTemplate("settings.tpl");
?>
