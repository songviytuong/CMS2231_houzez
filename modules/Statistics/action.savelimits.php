<?php
if (!isset($gCms)) exit;if (!cmsms())exit;if (!$this->CheckPermission('Administrate Statistics')) {
	echo $this->lang("nopermission");
	return;
}
$show="";if (isset($params["show"])) $show=$params["show"];
if (isset($params["activelimit"])) $this->SetPreference("activelimit",$params["activelimit"]);
if (isset($params["visitorlimit"])) $this->SetPreference("visitorlimit",$params["visitorlimit"]);
if (isset($params["gonetokeep"])) $this->SetPreference("gonetokeep",$params["gonetokeep"]);
if (isset($params["showdaylimit"])) $this->SetPreference("showdaylimit",$params["showdaylimit"]);
if (isset($params["showweeklimit"])) $this->SetPreference("showweeklimit",$params["showweeklimit"]);
if (isset($params["showmonthlimit"])) $this->SetPreference("showmonthlimit",$params["showmonthlimit"]);
if (isset($params["showyearlimit"])) $this->SetPreference("showyearlimit",$params["showyearlimit"]);
if (isset($params["showbrowserlimit"])) $this->SetPreference("showbrowserlimit",$params["showbrowserlimit"]);
if (isset($params["showoslimit"])) $this->SetPreference("showoslimit",$params["showoslimit"]);
if (isset($params["showsmartphoneslimit"])) $this->SetPreference("showsmartphoneslimit",$params["showsmartphoneslimit"]);
if (isset($params["showcountrylimit"])) $this->SetPreference("showcountrylimit",$params["showcountrylimit"]);
if (isset($params["showpageslimit"])) $this->SetPreference("showpageslimit",$params["showpageslimit"]);
if (isset($params["showrefererlimit"])) $this->SetPreference("showrefererlimit",$params["showrefererlimit"]);
if (isset($params["keywordlimit"])) $this->SetPreference("keywordlimit",$params["keywordlimit"]);
if (isset($params["expirytime"])) $this->SetPreference("expirytime",$params["expirytime"]);

$this->Redirect($id, 'defaultadmin', '', array("module_message"=>$this->Lang("limitssaved"),"activetab"=>"limits","show"=>$show));

?>
