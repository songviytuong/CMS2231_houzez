<?php
if (!cmsms())exit;
if (!$this->CheckPermission('Administrate Statistics')) {
	echo $this->lang("nopermission");
	return;
}

if (isset($params["dateformat"])) $this->SetPreference("dateformat",$params["dateformat"]);
if (isset($params["maxdots"])) $this->SetPreference("maxdots",$params["maxdots"]);
if (isset($params["dotschar"])) $this->SetPreference("dotschar",$params["dotschar"]);
if (isset($params["jqplotx"])) $this->SetPreference("jqplotx",$params["jqplotx"]);
if (isset($params["jqploty"])) $this->SetPreference("jqploty",$params["jqploty"]);

if (isset($params["gfxnumbers"])) $this->SetPreference("gfxnumbers",$params["gfxnumbers"]);

if (isset($params["charttype"])) $this->SetPreference("charttype",$params["charttype"]);
if (isset($params["iconset"])) $this->SetPreference("iconset",$params["iconset"]);

//$this->ResetPCharts();

$show="";if (isset($params["show"])) $show=$params["show"];
$this->Redirect($id, 'defaultadmin', '', array("module_message"=>$this->Lang("visualssaved"),"activetab"=>"visuals","show"=>$show));
?>