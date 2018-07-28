<?php
if (!cmsms())exit;
if (!$this->VisibleToAdminUser()) {
  echo $this->lang("nopermission");
  return;
}

$this->ShowIcons($id,$returnid);
$show="summary";
if (isset($params["show"])) $show=$params["show"];
switch($show) {
  case "days" : $this->ShowChart("days");
    break;
  case "weekdays" : $this->ShowChart("weekdays");
    break;
  case "timeofday" : $this->ShowChart("timeofday");
    break;
  case "weeks" : $this->ShowChart("weeks");
    break;
  case "months" : $this->ShowChart("months");
    break;
  case "years" : $this->ShowChart("years");
    break;
  case "browsers" : $this->ShowChart("browsers");
    break;
  case "oses" : $this->ShowChart("oses");
    break;
  case "smartphones" : $this->ShowChart("smartphones");
    break;
  case "countries" : $this->ShowChart("countries");
    break;
  case "pages" : {
      $this->ShowChart("pagesaccess",true);
      $this->ShowChart("pagesfirst",true);
      $this->ShowChart("pageslast",true);
      break;
    }
  case "referers" : $this->ShowChart("referers");
    break;
  case "searchengines" : {
      $this->ShowChart("searchengines",true);
      $this->ShowChart("searchkeywords",true);
      break;
    }
  case "robots" : $this->ShowChart("robots");
    break;
  case "visitors" : $this->ShowVisitors($id);
    break;
  case "resolutions" : {
      $this->ShowChart("screenresolutions",true);
      $this->ShowChart("colordepths",true);
      break;
    }

  default : $this->ShowSummary();
    break;
}

?>
