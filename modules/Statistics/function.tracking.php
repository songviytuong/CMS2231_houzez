<?php
if (!isset($gCms)) exit;
if (!$this->VisibleToAdminUser()) {
  $this->ShowError($this->Lang("accessdenied"));
  return;
}

$data=$this->GetTrackingData($params["trackid"]);

$visitorinfo=$this->GetVisitorInfo($params["trackid"]);
//print_r($visitorinfo);

$visitorshowing=$this->Lang("trackingvisitor")." ".$this->GetHostFromIP($visitorinfo["remoteaddr"])." (".$visitorinfo["remoteaddr"].")";
$smarty->assign("visitorshowing",$visitorshowing);

if (!$data) {
  echo "Internal error, no tracking data available";
  return;
}
$lasttime=0;
$rows=array();
$count=1;
foreach($data as $step) {
  $row = new stdClass();
  $row->page=$this->GetPageTitle($step["pageid"]);
  $row->count=$count;
  $row->time=date("H:i:s",$step["accesstime"]);
  if ($lasttime!=0) {
    $viewtime=$step["accesstime"]-$lasttime;

    if ($viewtime < 60) {
      $viewtime=$viewtime."&nbsp;".$this->lang("Seconds");
    } elseif ($viewtime < 3600) {
      $minutesago=floor($viewtime/60);
      $secondsago=$viewtime-($minutesago*60);
      if ($minutesago == 1) {
        $viewtime=$minutesago."&nbsp;".$this->lang("Minute")."&nbsp;".$secondsago."&nbsp;".$this->lang("Seconds");
      } else {
        $viewtime=$minutesago."&nbsp;".$this->lang("Minutes")."&nbsp;".$secondsago."&nbsp;".$this->lang("Seconds");
      }
    } else {

      $hoursago=floor($viewtime/3600);
      $minutesago=floor(($viewtime-($hoursago*3600))/60);
      $secondsago=$viewtime-(($hoursago*3600)+($minutesago*60));
      if ($hoursago == 1) {
        if ($minutesago == 1) {
          $viewtime=$hoursago."&nbsp;".$this->lang("Hour")."&nbsp;".$minutesago."&nbsp;".$this->lang("Minute")."&nbsp;".$secondsago."&nbsp;".$this->lang("Seconds");
        } else {
          $viewtime=$hoursago."&nbsp;".$this->lang("Hour")."&nbsp;".$minutesago."&nbsp;".$this->lang("Minutes")."&nbsp;".$secondsago."&nbsp;".$this->lang("Seconds");
        }
      } else {
        if ($minutesago == 1) {
          $viewtime=$hoursago."&nbsp;".$this->lang("Hours")."&nbsp;".$minutesago."&nbsp;".$this->lang("Minute")."&nbsp;".$secondsago."&nbsp;".$this->lang("Seconds");
        } else {
          $viewtime=$hoursago."&nbsp;".$this->lang("Hours")."&nbsp;".$minutesago."&nbsp;".$this->lang("Minutes")."&nbsp;".$secondsago."&nbsp;".$this->lang("Seconds");
        }
      }
    }
    $rows[count($rows)-1]->viewtime=$viewtime;
  }
  $count++;
  $lasttime=$step["accesstime"];
  $rows[]=$row;
}
$smarty->assign("rows",$rows);
$smarty->assign("headers",
  array($this->Lang("step"),
    $this->Lang("page"),
  $this->Lang("accesstime"),
  $this->Lang("viewtime")));
echo $this->ProcessTemplate("tracking.tpl");
?>
