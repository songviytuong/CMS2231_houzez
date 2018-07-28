<?php

require_once('../../../include.php');

$map = array(0=>'yearID',1=>'teamID',2=>'lgID',3=>'playerID',4=>'salary');
$query = new \CGExtensions\query\csvfilequery(array('filename'=>'test_data/baseball_salaries.csv','offset'=>150,'map'=>$map));
$rs = $query->execute();
while( !$rs->EOF() ) {
    $obj = $rs->get_object();
    print_r($obj);
    $rs->MoveNext();
}
?>
