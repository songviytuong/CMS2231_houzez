<?php
if (!cmsms())exit;
if (!$this->CheckPermission('Administrate Statistics')) {
  echo $this->lang("nopermission");
  return;
}
if ($this->topxtemplate=="") {
  $this->topxtemplate=$this->GetTopXTemplate(true);
  $this->SetPreference($this->topxtemplate);
}
if ($this->emailtemplate=="") {
  $this->emailtemplate=$this->GetEmailTemplate(true);
  $this->SetPreference($this->emailtemplate);
}


$smarty->assign('topxtemplatetext',$this->lang("topxtemplate"));
$smarty->assign('topxtemplateinput',$this->CreateTextArea(false,$id,$this->topxtemplate,"topxtemplate","pagesmalltextarea"));
$smarty->assign('topxtemplatehelp',$this->lang("topxtemplatehelp"));
$smarty->assign('topxtemplateparams',"{\$entry->index} {\$entry->fulllink} {\$entry->href} {\$entry->title} {\$entry->menutitle}  {\$entry->alias}");
$smarty->assign('emailtemplatetext',$this->lang("emailtemplate"));
$smarty->assign('emailtemplateinput',$this->CreateTextArea(false,$id,$this->emailtemplate,"emailtemplate","pagesmalltextarea"));
$smarty->assign('emailtemplatehelp',$this->lang("emailtemplatehelp"));
$smarty->assign('emailtemplateparams',"{\$total}, {\$pageviews}, {\$today}, {\$thisweek}, {\$thismonth}, {\$thisyear}, {\$topbrowser}, {\$topos}, {\$topcountry}, {\$totalsinceemail}, {\$pageviewssinceemail}");

$smarty->assign('submittopx',$this->CreateInputSubmit($id,"savetopxtemplate",$this->lang("savetopx")));
$smarty->assign('submitemail',$this->CreateInputSubmit($id,"saveemailtemplate",$this->lang("saveemail")));

$smarty->assign('resetemail',$this->CreateInputSubmit($id,"resetemailtemplate",$this->lang("resetemail"),"","",$this->Lang("confirmresetemail")));
$smarty->assign('resettopx',$this->CreateInputSubmit($id,"resettopxtemplate",$this->lang("resettopx"),"","",$this->Lang("confirmresettopx")));

if (isset($params["show"])) {
  $smarty->assign('show',$this->CreateInputHidden($id,"show",$params["show"]));
}
$smarty->assign('startform1',$this->CreateFormStart($id,"savetemplates",$returnid,"post","",true));
$smarty->assign('endform1',$this->CreateFormEnd());
$smarty->assign('startform2',$this->CreateFormStart($id,"savetemplates",$returnid,"post","",true));
$smarty->assign('endform2',$this->CreateFormEnd());


echo $this->ProcessTemplate("templates.tpl");
?>