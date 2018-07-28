<?php
if (!cmsms())exit;

if (!$this->CheckPermission('Administrate Statistics')) {
  echo $this->lang("nopermission");
  return;
}
$show="";if (isset($params["show"])) $show=$params["show"];
if (isset($params["resetall"])) {
  $this->ResetData();
  if (isset($params["forcepageviews"]) && is_numeric($params["forcepageviews"])) {
    $this->SetValue("count_total_pageviews","",$params["forcepageviews"]);
  }
  if (isset($params["forcevisitors"]) && is_numeric($params["forcevisitors"])) {
    $this->SetValue("count_total","",$params["forcevisitors"]);
  }
  $this->ResetVisitors();
  $this->ResetDebugLog();
  $this->Redirect($id, 'defaultadmin', '', array("module_message"=>$this->Lang("everythingreset"),"activetab"=>"resetdata","show"=>$show));
}

if (isset($params["resetdata"])) {
  $this->ResetData();
  if (isset($params["forcepageviews"]) && is_numeric($params["forcepageviews"])) {
    $this->SetValue("count_total_pageviews","",$params["forcepageviews"]);
  }
  if (isset($params["forcevisitors"]) && is_numeric($params["forcevisitors"])) {    
     $this->SetValue("count_total","",$params["forcevisitors"]);
  }  
  $this->Redirect($id, 'defaultadmin', '', array("module_message"=>$this->Lang("datareset"),"activetab"=>"resetdata","show"=>$show));
}

if (isset($params["resetvisitors"])) {
  $this->ResetVisitors();  
  $this->Redirect($id, 'defaultadmin', '', array("module_message"=>$this->Lang("visitorsreset"),"activetab"=>"resetdata","show"=>$show));
}

if (isset($params["resetloglines"])) {
  $this->ResetDebugLog();  
  $this->Redirect($id, 'defaultadmin', '', array("module_message"=>$this->Lang("loglinesreset"),"activetab"=>"debuglog","show"=>$show));
}


?>