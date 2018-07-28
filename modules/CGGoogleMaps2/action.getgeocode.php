<?php
if( !isset($gCms) ) exit;
if( !isset($params['address']) ) return;

$res = $this->GetCoordsFromAddress($params['address']);
if( !$res ) {
  echo json_encode(array('status'=>'error'));
}
else {
  $res['status'] = 'success';
  echo json_encode($res);
}
exit();

?>