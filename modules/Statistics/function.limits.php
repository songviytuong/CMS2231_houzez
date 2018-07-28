<?php
if (!cmsms())exit;
if (!$this->CheckPermission('Administrate Statistics')) {
	echo $this->lang("nopermission");
	return;
}
$timevalues=array("30 ".$this->lang("seconds")=>"30",
      "1 ".$this->lang("minute")=>"60",
      "2 ".$this->lang("minutes")=>"120",
      "5 ".$this->lang("minutes")=>"300",
      "10 ".$this->lang("minutes")=>"600",
      "30 ".$this->lang("minutes")=>"1800",
      "1 ".$this->lang("hour")=>"3600",
      "2 ".$this->lang("hours")=>"7200",
      "4 ".$this->lang("hours")=>"14400",
      "8 ".$this->lang("hours")=>"28800",
      "16 ".$this->lang("hours")=>"57600",
      "24 ".$this->lang("hours")=>"86400",
  $this->lang("never")=>"-1");
$dayvalues=array($this->lang("all")=>"-1");
for ($i=1; $i<52; $i++) $dayvalues=array_merge($dayvalues,array("$i"=>"$i"));

$smarty->assign('startform',$this->CreateFormStart($id,"savesettings",$returnid,"post","",true));
$smarty->assign('endform',$this->CreateFormEnd());

$smarty->assign('activelimittext',$this->lang("timeinactive"));
$smarty->assign('activelimitinput',$this->CreateInputDropdown($id,"activelimit",$timevalues,-1,$this->activelimit));

$gonetokeepvalues=array("10"=>10,"20"=>20,"50"=>50,"100"=>100);//$this->lang("all")=>"-1");
//for ($i=10; $i<100; $i+=10) $gonetokeepvalues=array_merge($gonetokeepvalues,array($i=>$i));

$smarty->assign('gonetokeeptext',$this->lang("gonetokeep"));
$smarty->assign('gonetokeepinput',$this->CreateInputDropdown($id,"gonetokeep",$gonetokeepvalues,-1,$this->gonetokeep));

$smarty->assign('visitorlimittext',$this->lang("timegone"));
$smarty->assign('visitorlimitinput',$this->CreateInputDropdown($id,"visitorlimit",$timevalues,-1,$this->visitorlimit));

$smarty->assign('daylimittext',$this->lang("daysinstatistic"));
$smarty->assign('daylimitinput',$this->CreateInputDropdown($id,"showdaylimit",$dayvalues,-1,$this->showdaylimit));

$smarty->assign('weeklimittext',$this->lang("weeksinstatistic"));
$smarty->assign('weeklimitinput',$this->CreateInputDropdown($id,"showweeklimit",$dayvalues,-1,$this->showweeklimit));

$smarty->assign('monthlimittext',$this->lang("monthsinstatistic"));
$smarty->assign('monthlimitinput',$this->CreateInputDropdown($id,"showyearlimit",$dayvalues,-1,$this->showyearlimit));

$smarty->assign('yearlimittext',$this->lang("yearsinstatistic"));
$smarty->assign('yearlimitinput',$this->CreateInputDropdown($id,"showmonthlimit",$dayvalues,-1,$this->showmonthlimit));

$smarty->assign('browserlimittext',$this->lang("browsersinstatistic"));
$smarty->assign('browserlimitinput',$this->CreateInputDropdown($id,"showbrowserlimit",$gonetokeepvalues,-1,$this->showbrowserlimit));

$smarty->assign('oslimittext',$this->lang("osesinstatistic"));
$smarty->assign('oslimitinput',$this->CreateInputDropdown($id,"showoslimit",$gonetokeepvalues,-1,$this->showoslimit));


$smarty->assign('countrylimittext',$this->lang("countriesinstatistic"));
$smarty->assign('countrylimitinput',$this->CreateInputDropdown($id,"showcountrylimit",$gonetokeepvalues,-1,$this->showcountrylimit));

$smarty->assign('pagelimittext',$this->lang("pagesinstatistic"));
$smarty->assign('pagelimitinput',$this->CreateInputDropdown($id,"showpageslimit",$gonetokeepvalues,-1,$this->showpageslimit));

$smarty->assign('refererlimittext',$this->lang("referersinstatistic"));
$smarty->assign('refererlimitinput',$this->CreateInputDropdown($id,"showrefererlimit",$gonetokeepvalues,-1,$this->showrefererlimit));
$smarty->assign('keywordlimittext',$this->lang("keywordsinstatistic"));
$smarty->assign('keywordlimitinput',$this->CreateInputDropdown($id,"keywordlimit",$gonetokeepvalues,-1,$this->keywordlimit));

$expirytimes=array(
  $this->Lang("never")=>-1,
  $this->Lang("oneday")=>(3600*24),
  $this->Lang("twodays")=>(3600*24*2),
  $this->Lang("oneweek")=>(3600*24*7),
  $this->Lang("twoweeks")=>(3600*24*14),
  $this->Lang("onemonth")=>(3600*24*31),
  $this->Lang("twomonths")=>(3600*24*62),
  $this->Lang("halfyear")=>(3600*24*31*6),
  $this->Lang("oneyearyear")=>(3600*24*365),
);


$smarty->assign('expirytimetext',$this->lang("expirytime"));
$smarty->assign('expirytimehelp',$this->lang("expirytimehelp"));
$smarty->assign('expirytimeinput',$this->CreateInputDropdown($id,"expirytime",$expirytimes,-1,$this->expirytime));
if (isset($params["show"])) {
  $smarty->assign('show',$this->CreateInputHidden($id,"show",$params["show"]));
}
$smarty->assign('startform',$this->CreateFormStart($id,"savelimits",$returnid,"post","",true));
  $smarty->assign('endform',$this->CreateFormEnd());


$smarty->assign('submitsettings',$this->CreateInputSubmit($id,"savelimits",$this->lang("savelimits")));
echo $this->ProcessTemplate("limits.tpl");

?>
