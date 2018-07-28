<?php
if (!cmsms())exit;
if (!$this->CheckPermission('Administrate Statistics')) {
  echo $this->lang("nopermission");
  return;
}

$smarty->assign('dateformattext',$this->lang("dateformat"));
$smarty->assign('dateformathelp',$this->lang("dateformathelp"));
$smarty->assign('dateformatinput',$this->CreateInputText($id,"dateformat",$this->dateformat, 50, 255));


$smarty->assign('charttypetext',$this->lang("charttype"));
//$charttypes=array($this->Lang("textcharts")=>"text",$this->Lang("graphiccharts")=>"graphic",$this->Lang("flashchart")=>"flash");
$charttypes=array($this->Lang("textcharts")=>"text",$this->Lang("graphiccharts")=>"graphics",$this->Lang("jqplotchart")=>"jqplot"/*,$this->Lang("pchartcharts")=>"pchart"*/);
$hc=$this->GetModuleInstance("ChartsMadeSimple");
if ($hc) $charttypes[$this->Lang("highcharts")]="highcharts";
$smarty->assign('charttypeinput',$this->CreateInputDropDown($id,"charttype",$charttypes,-1,$this->charttype));

$smarty->assign('gfxnumberstext',$this->lang("gfxnumberstype"));
$gfxnumberstypes=array($this->Lang("digidisplayer")=>"digidisplayer");
$smarty->assign('gfxnumbersinput',$this->CreateInputDropDown($id,"gfxnumbers",$gfxnumberstypes,-1,$this->gfxnumbers));

$smarty->assign('iftextchartuse',$this->lang("iftextchartuse"));
$smarty->assign('ifjqplotsize',$this->lang("ifjqplotsize"));
$smarty->assign('jqplotxinput',$this->CreateInputText($id,"jqplotx",$this->jqplotx, 5, 3));
$smarty->assign('jqplotyinput',$this->CreateInputText($id,"jqploty",$this->jqploty, 5, 3));

$smarty->assign('maxdotsinput',$this->CreateInputText($id,"maxdots",$this->GetPreference("maxdots",32), 4,4));
$smarty->assign('times',$this->lang("times"));

$smarty->assign('dotcharinput',$this->CreateInputText($id,"dotchar",$this->GetPreference("dotchar","&#8226;"), 12,12));

$smarty->assign('statemailtext',$this->lang("statemail"));
$smarty->assign('statemailinput',$this->CreateInputText($id,"statemail",$this->statemail, 50, 255));

$iconsets=array("crystalclear"=>"crystalclear","crystalcleargrey"=>"crystalcleargrey");
$smarty->assign('iconsettext',$this->lang("iconset"));
$smarty->assign('iconsetinput',$this->CreateInputDropDown($id,"iconset",$iconsets,-1,$this->iconset));

$smarty->assign('submitvisuals',$this->CreateInputSubmit($id,"savevisuals",$this->lang("savevisuals")));
if (isset($params["show"])) {
  $smarty->assign('show',$this->CreateInputHidden($id,"show",$params["show"]));
}
$smarty->assign('startform',$this->CreateFormStart($id,"savevisuals",$returnid,"post","",true));
$smarty->assign('endform',$this->CreateFormEnd());


echo $this->ProcessTemplate("visuals.tpl");
?>
