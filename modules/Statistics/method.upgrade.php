<?php
if (!cmsms())exit;

$this->SetPreference("hidedonationstab",0);

$current_version = $oldversion;
$db =cmsms()->GetDb();
$taboptarray = array('mysql' => 'TYPE=MyISAM');
$dict = NewDataDictionary($db);
switch ($current_version) {
  case "0.4": // ?
    $this->RemovePermission('Reset Statistics');
    $this->CreatePermission('Administrate Statistics', $this->Lang('permission'));

    $sqlarray = $dict->AddColumnSQL(cms_db_prefix()."module_stat_visitors", "lastpage I");
    $dict->ExecuteSQLArray($sqlarray);
    $current_version = "0.5";
  case "0.5":
  case "0.5.1":
  case "0.6.1":
    $sqlarray = $dict->AlterColumnSQL(cms_db_prefix()."module_stat_data", "seckey C(255)");
    $dict->ExecuteSQLArray($sqlarray);
    $current_version = "0.6.2";
  case "0.7.0": {
    //Log strings, for debugging
    $flds = "
					id I key,
			    time I,
			    info C(255)
				";
    $sqlarray = $dict->CreateTableSQL(cms_db_prefix()."module_stat_logstrings", $flds, $taboptarray);
    $dict->ExecuteSQLArray($sqlarray);
    $db->CreateSequence(cms_db_prefix()."module_stat_logstrings_seq");    
  }
  case "0.8.0b1" :
  case "0.8.0b2" :
  case "0.8.0" : {
  	$this->CreatePermission('View Statistics', $this->Lang('viewpermission'));  
  }
  case "0.8.0b3" : {
  	$flds = "
			id I key,
			time I,
			ip C(32),
			host C(255)
		";
    $sqlarray = $dict->CreateTableSQL(cms_db_prefix()."module_stat_dnscache", $flds, $taboptarray);
    $dict->ExecuteSQLArray($sqlarray);
		$db->CreateSequence(cms_db_prefix()."module_stat_dnscache_seq");
  }
  case "0.9.0b1" : {
    $this->ResetData("count_country");
  }
  case "0.9.0b2" :
  case "0.9.0" : {
    //Visitor track
    $flds = "
			visitorid I,
			accesstime I,
			pageid I,
      info X
			";
    $sqlarray = $dict->CreateTableSQL(cms_db_prefix()."module_stat_visitortrack", $flds, $taboptarray);
    $dict->ExecuteSQLArray($sqlarray);
  }
  case "0.9.1" :
  case "0.9.2" :
  case "0.9.3" :
  case "0.9.9" : {
    $sqlarray = $dict->AddColumnSQL(cms_db_prefix()."module_stat_visitors", "remotehost C(255)");
    $dict->ExecuteSQLArray($sqlarray);

    $sqlarray = $dict->DropTableSQL(cms_db_prefix()."module_stat_ipcache");
    $db->DropSequence(cms_db_prefix()."module_stat_ipcache_seq");
    $dict->ExecuteSQLArray($sqlarray);
  }
  case "1.0" :
  case "1.0.1" :
  case "1.0.2" : {
    $sqlarray = $dict->AddColumnSQL(cms_db_prefix()."module_stat_visitors", "pagecount I");
    $dict->ExecuteSQLArray($sqlarray);
  }
  case "1.1.1" : {
    $sqlarray = $dict->AddColumnSQL(cms_db_prefix()."module_stat_visitors", "referer C(255)");
    $dict->ExecuteSQLArray($sqlarray);
  }
  case '1.2':
  case '1.2.1':
  
    # fixes cases when the default templates were not installed: attempts to avoid overwritting customized templates
    $test = $this->GetPreference("topxtemplate");
    if( empty($test) ) $this->SetPreference("topxtemplate", $this->GetTopXTemplate(true));
    
    $test = $this->GetPreference("emailtemplate");
    if( empty($test) ) $this->SetPreference("emailtemplate", $this->GetEmailTemplate(true));

}
$this->Audit(0, $this->lang('friendlyname'), $this->lang('upgrademessage',$this->GetVersion()));
?>
