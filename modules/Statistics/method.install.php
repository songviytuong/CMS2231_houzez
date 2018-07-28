<?php
if (!cmsms())exit;
$db = cmsms()->GetDb();
$dict = NewDataDictionary($db);
$taboptarray = array('mysql' => 'TYPE=MyISAM');

//Unified datalist
$flds = "
			id I KEY,
			name C(80),
			seckey C(255),
			value I,
			updated I
		";
$sqlarray = $dict->CreateTableSQL(cms_db_prefix()."module_stat_data", $flds, $taboptarray );
$dict->ExecuteSQLArray( $sqlarray );
$db->CreateSequence( cms_db_prefix()."module_stat_data_seq" );

//Visitor tracking
$flds = "
			id I KEY,
			sessionid C(80),      
			remoteaddr C(32),
      remotehost C(255),
			lastpage I,
			lastseen I,
      pagecount I,
      referer C(255)
		";
$sqlarray = $dict->CreateTableSQL(cms_db_prefix()."module_stat_visitors", $flds, $taboptarray);
$dict->ExecuteSQLArray($sqlarray);
$db->CreateSequence(cms_db_prefix()."module_stat_visitors_seq");

//Visitor track
$flds = "
			visitorid I,
			accesstime I,
			pageid I,
      info X
			";
$sqlarray = $dict->CreateTableSQL(cms_db_prefix()."module_stat_visitortrack", $flds, $taboptarray);
$dict->ExecuteSQLArray($sqlarray);


//Log strings, for debugging
$flds = "
			id I key,
			time I,
			info C(255)
		";
$sqlarray = $dict->CreateTableSQL(cms_db_prefix()."module_stat_logstrings", $flds, $taboptarray);
$dict->ExecuteSQLArray($sqlarray);
$db->CreateSequence(cms_db_prefix()."module_stat_logstrings_seq");

//Caching dns-lookups
/*$flds = "
			id I key,
			time I,
			ip C(32),
			host C(255)
		";
$sqlarray = $dict->CreateTableSQL(cms_db_prefix()."module_stat_ipcache", $flds, $taboptarray);
$dict->ExecuteSQLArray($sqlarray);
$db->CreateSequence(cms_db_prefix()."module_stat_ipcache_seq");
*/

$this->CreatePermission('Administrate Statistics', $this->Lang('permission'));
$this->CreatePermission('View Statistics', $this->Lang('viewpermission'));

$this->SetPreference("activelimit",300);
$this->SetPreference("visitorlimit",1800);
$this->SetPreference("showdaylimit",31);
$this->SetPreference("showweeklimit",52);
$this->SetPreference("showmonthlimit",12);
$this->SetPreference("showyearlimit",10);
$this->SetPreference("showbrowserlimit",-1);
$this->SetPreference("showoslimit",-1);
$this->SetPreference("showcountrylimit",-1);
$this->SetPreference("charttype","text");
$this->SetPreference("ignoreips","");
$this->SetPreference("debuglog",1);
$this->SetPreference("last_reset",time());
$this->Audit(0,$this->lang('friendlyname'),$this->Lang('installmessage',$this->GetVersion()));
$this->SetPreference("topxtemplate",$this->GetTopXTemplate(true));
$this->SetPreference("emailtemplate",$this->GetEmailTemplate(true));

?>