<?php
if (!cmsms())exit;
$smarty->assign("module",$this);

$smarty->assign("formstart",$this->CreateFormStart($id,"defaultadmin"));
$smarty->assign("formend",$this->CreateFormEnd());
$smarty->assign("hidesubmit",$this->CreateInputSubmit($id,"hidedonationssubmit",$this->Lang("hidedonationssubmit")));
$smarty->assign("donationstext",$this->Lang("donationstext"));
$smarty->assign("sponsorstext",$this->Lang("sponsors"));

echo $this->ProcessTemplate("donations.tpl");

?>
