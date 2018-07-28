<?php
if (!cmsms())exit;
if (!$this->CheckPermission('Administrate Statistics')) {
	echo $this->lang("nopermission");
	return;
}
$message=$this->Lang("templatesaved");
if (isset($params["resettopxtemplate"])) {
  $this->SetPreference("topxtemplate",$this->GetTopXTemplate(true));
  $message=$this->Lang("templatereset");
} else {
  if (isset($params["topxtemplate"])) {
    $this->SetPreference("topxtemplate",$params["topxtemplate"]);
  }
}
if (isset($params["resetemailtemplate"])) {
  $this->SetPreference("emailtemplate",$this->GetEmailTemplate(true));
  $message=$this->Lang("templatereset");
} else {
  if (isset($params["emailtemplate"])) $this->SetPreference("emailtemplate",$params["emailtemplate"]);
}

$show="";if (isset($params["show"])) $show=$params["show"];
$this->Redirect($id, 'defaultadmin', '', array("module_message"=>$message,"activetab"=>"templates","show"=>$show));
?>