<?php
if (!cmsms())exit;
if (!$this->CheckPermission('Administrate Statistics')) {
  echo $this->lang("nopermission");
  return;
}

$smarty->assign('startform',$this->CreateFormStart($id,"resetdata",$returnid,"post","",true));
$smarty->assign('endform',$this->CreateFormEnd());
if (isset($params["show"])) {
  $smarty->assign('show',$this->CreateInputHidden($id,"show",$params["show"]));
}
$smarty->assign('submitresetall',$this->CreateInputSubmit($id,"resetall",$this->lang("resetall"),"","",$this->Lang("confirmresetall")));
$smarty->assign('submitresetdata',$this->CreateInputSubmit($id,"resetdata",$this->lang("resetdata"),"","",$this->Lang("confirmresetdata")));
$smarty->assign('submitresetvisitors',$this->CreateInputSubmit($id,"resetvisitors",$this->lang("resetvisitors"),"","",$this->Lang("confirmresetvisitors")));

$smarty->assign('forcepageviews',$this->CreateInputText($id,"forcepageviews",""));
$smarty->assign('forcevisitors',$this->CreateInputText($id,"forcevisitors",""));

$smarty->assign('currentvisitors',$this->lang('currently')." ".$this->GetValue("count_total","",0));
$smarty->assign('currentpageviews',$this->lang('currently')." ".$this->GetValue("count_total_pageviews","",0));

$smarty->assign('forcepageviewstext',$this->lang('forcepageviews'));
$smarty->assign('forcevisitorstext',$this->lang('forcevisitors'));
$smarty->assign('resetdatatext',$this->lang('resetdata'));
$smarty->assign('resetdatahelp',$this->lang('resetdatahelp'));
$smarty->assign('resetvisitorshelp',$this->lang('resetvisitorshelp'));
$smarty->assign('resetallhelp',$this->lang('resetallhelp'));
echo $this->ProcessTemplate("resetdata.tpl");

?>
