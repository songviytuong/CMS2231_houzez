<?php
if (!cmsms())exit;
$db = cmsms()->GetDb();
$dict = NewDataDictionary($db);
$sqlarray = $dict->DropTableSQL(cms_db_prefix()."module_stat_data");
$dict->ExecuteSQLArray($sqlarray);
$db->DropSequence(cms_db_prefix()."module_stat_data_seq");

$sqlarray = $dict->DropTableSQL(cms_db_prefix()."module_stat_visitors");
$dict->ExecuteSQLArray($sqlarray);
$db->DropSequence(cms_db_prefix()."module_stat_visitors_seq");

$sqlarray = $dict->DropTableSQL(cms_db_prefix()."module_stat_visitortrack");
$dict->ExecuteSQLArray($sqlarray);

$sqlarray = $dict->DropTableSQL(cms_db_prefix()."module_stat_logstrings");
$db->DropSequence(cms_db_prefix()."module_stat_logstrings_seq");
$dict->ExecuteSQLArray($sqlarray);

$sqlarray = $dict->DropTableSQL(cms_db_prefix()."module_stat_ipcache");
$db->DropSequence(cms_db_prefix()."module_stat_ipcache_seq");
$dict->ExecuteSQLArray($sqlarray);

$this->RemovePermission('Administrate Statistics');
$this->RemovePermission('View Statistics');

$this->RemovePreference();

$this->Audit(0, $this->lang('friendlyname'), $this->lang('uninstallmessage',$this->GetVersion()));

?>