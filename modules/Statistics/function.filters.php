<?php
if (!cmsms())exit;
if (!$this->CheckPermission('Administrate Statistics')) {
	echo $this->lang("nopermission");
	return;
}
$smarty->assign('ignorerobotstext',$this->lang("ignorerobots"));
$smarty->assign('ignorerobotsinput',$this->CreateInputCheckBox($id,"ignorerobots","1",$this->ignorerobots));
$smarty->assign('extrarobotstext',$this->lang("extrarobots"));
$smarty->assign('extrarobotshelp',$this->lang("extrarobotshelp"));
$smarty->assign('extrarobotsinput',$this->CreateInputText($id,"extrarobots",$this->extrarobots, 50, 255)." ".$this->lang("semicolonsepsimple"));

$smarty->assign('ignoreiptext',$this->lang("ignoreips"));
$smarty->assign('ignoreipinput',$this->CreateInputText($id,"ignoreips",$this->ignoreips, 50, 255)." ".$this->lang("semicolonsep"));

$smarty->assign('ignorepagestext',$this->lang("ignorepages"));
$smarty->assign('ignorepagesinput',$this->CreateInputText($id,"ignorepages",$this->ignorepages, 50, 255)." ".$this->lang("pagessemicolonsep"));

$smarty->assign('ignorevisitorstext',$this->lang("ignorevisitors"));
$smarty->assign('ignorevisitorshelp',$this->lang("visitorssemicolonsep"));
$smarty->assign('ignorevisitorsinput',$this->CreateInputText($id,"ignorevisitors",$this->ignorevisitors, 50, 255));

$smarty->assign('ignorerefererstext',$this->lang("ignorereferers"));
$smarty->assign('ignorereferershelp',$this->lang("ignorereferershelp"));
$smarty->assign('ignorereferersinput',$this->CreateInputText($id,"ignorereferers",$this->ignorereferers, 50, 255));

$smarty->assign('ignoreadminstext',$this->lang("ignoreadmins"));
$smarty->assign('ignoreadminshelp',$this->lang("ignoreadminshelp"));
$smarty->assign('ignoreadminsinput',$this->CreateInputCheckBox($id,"ignoreadmins","1",$this->ignoreadmins));

$smarty->assign('submitfilters',$this->CreateInputSubmit($id,"savefilters",$this->lang("savefilters")));
if (isset($params["show"])) {
  $smarty->assign('show',$this->CreateInputHidden($id,"show",$params["show"]));
}
$smarty->assign('startform',$this->CreateFormStart($id,"savefilters",$returnid,"post","",true));
$smarty->assign('endform',$this->CreateFormEnd());

echo $this->ProcessTemplate("filters.tpl");

?>

