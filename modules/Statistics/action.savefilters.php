<?php
if (!cmsms())exit;

if (!$this->CheckPermission('Administrate Statistics')) {
	echo $this->lang("nopermission");
	return;
}
$show="";if (isset($params["show"])) $show=$params["show"];
if (isset($params["ignoreips"])) $this->SetPreference("ignoreips",$params["ignoreips"]);

if (isset($params["ignorepages"])) $this->SetPreference("ignorepages",$params["ignorepages"]);
if (isset($params["ignorevisitors"])) $this->SetPreference("ignorevisitors",$params["ignorevisitors"]);
if (isset($params["ignorereferers"])) $this->SetPreference("ignorereferers",$params["ignorereferers"]);

if (isset($params["ignorerobots"])) {
	$this->SetPreference("ignorerobots","1");
} else {
	$this->SetPreference("ignorerobots","0");
}
if (isset($params["extrarobots"])) $this->SetPreference("extrarobots",$params["extrarobots"]);

if (isset($params["ignoreadmins"])) {
	$this->SetPreference("ignoreadmins","1");
} else {
	$this->SetPreference("ignoreadmins","0");
  $this->SetPreference("adminips","");
}

if (isset($params["additionalrobots"])) $this->SetPreference("additionalrobots",$params["additionalrobots"]);

$this->Redirect($id, 'defaultadmin', '', array("module_message"=>$this->Lang("filterssaved"),"activetab"=>"filters","show"=>$show));
?>
