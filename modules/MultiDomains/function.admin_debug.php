<?php
/*======================================================================================
Module: MultiDomains
======================================================================================*/

// Check authorisation
if (!isset($gCms)) exit;
if ( !$this->CheckPermission('Manage MultiDomains') ) exit;

// Set Tab name
$tabto = 'debug';

// Set vars and images
$admintheme = cms_utils::get_theme_object();
$imagedelete = $admintheme->DisplayImage('icons/system/delete.gif',$this->Lang('delete'),'','','systemicon');

// Get debug
$alldebug = $db->GetAll('SELECT id,session_id,ip,fromurl,tourl,status,created_date,modified_date FROM '.MD_DEBUG_TABLE.' ORDER BY modified_date DESC');
if (!is_array($alldebug)) $alldebug = array();

// Walk through errors
$debugarray = array();
$rowclass = 'row1';
foreach ( $alldebug as $onedebug ) {
	// Build a new row
	$row = new StdClass();
	$row->rowclass = $rowclass;
	// ID
	$row->id = $onedebug['id'];
	// Status
	$row->ip = $onedebug['ip'];
	// Status
	$row->session_id = $onedebug['session_id'];
	// Icon
	$icon = '<img src="/modules/MultiDomains/images/DIRicon.gif" />';
	if (preg_match('/.*\.htm(l)?(\/)?$/i',$onedebug['tourl'])) $icon = '<img src="/modules/MultiDomains/images/HTMLicon.gif" />';
	if (preg_match('/.*\.css(\/)?$/i',$onedebug['tourl'])) $icon = '<img src="/modules/MultiDomains/images/CSSicon.gif" />';
	if (preg_match('/.*\.php(\/)?$/i',$onedebug['tourl'])) $icon = '<img src="/modules/MultiDomains/images/PHPicon.gif" />';
	if (preg_match('/.*\.txt(\/)?$/i',$onedebug['tourl'])) $icon = '<img src="/modules/MultiDomains/images/TXTicon.gif" />';
	if (preg_match('/.*\.zip(\/)?$/i',$onedebug['tourl'])) $icon = '<img src="/modules/MultiDomains/images/ZIPicon.gif" />';
	if (preg_match('/.*\.gif(\/)?$/i',$onedebug['tourl'])) $icon = '<img src="/modules/MultiDomains/images/GIFicon.gif" />';
	if (preg_match('/.*\.png(\/)?$/i',$onedebug['tourl'])) $icon = '<img src="/modules/MultiDomains/images/JPGicon.gif" />';
	if (preg_match('/.*\.jpg(\/)?$/i',$onedebug['tourl'])) $icon = '<img src="/modules/MultiDomains/images/JPGicon.gif" />';
	if (preg_match('/.*\.mp3(\/)?$/i',$onedebug['tourl'])) $icon = '<img src="/modules/MultiDomains/images/MP3icon.gif" />';
	if (preg_match('/.*\.wav(\/)?$/i',$onedebug['tourl'])) $icon = '<img src="/modules/MultiDomains/images/MP3icon.gif" />';
	if (preg_match('/.*\.avi(\/)?$/i',$onedebug['tourl'])) $icon = '<img src="/modules/MultiDomains/images/AVIicon.gif" />';
	if (preg_match('/.*\.flv(\/)?$/i',$onedebug['tourl'])) $icon = '<img src="/modules/MultiDomains/images/FLVicon.gif" />';
	if (preg_match('/.*\.pdf(\/)?$/i',$onedebug['tourl'])) $icon = '<img src="/modules/MultiDomains/images/PDFicon.gif" />';
	if (preg_match('/.*\.doc(\/)?$/i',$onedebug['tourl'])) $icon = '<img src="/modules/MultiDomains/images/DOCicon.gif" />';
	if (preg_match('/.*\.xls(\/)?$/i',$onedebug['tourl'])) $icon = '<img src="/modules/MultiDomains/images/XLSicon.gif" />';
	if (preg_match('/.*\.ppt(\/)?$/i',$onedebug['tourl'])) $icon = '<img src="/modules/MultiDomains/images/PPTicon.gif" />';
	// From URL
	$row->fromurl = strlen($onedebug['fromurl'])<=30 	? '<a href="'.$onedebug['fromurl'].'" title="'.$onedebug['fromurl'].'" target="_blank">'.preg_replace('/^http(s)?:\/\//','',$onedebug['fromurl']).'</a>'
														: '<a href="'.$onedebug['fromurl'].'" title="'.$onedebug['fromurl'].'" target="_blank">'.substr(preg_replace('/^http(s)?:\/\//','',$onedebug['fromurl']),0,15).'....'.substr($onedebug['fromurl'],-15).'</a>';
	// To URL
	$row->tourl = '<a href="'.$onedebug['tourl'].'" target="_blank">'.$onedebug['tourl'].'</a>';
	$row->tourl = strlen($onedebug['tourl'])<=30 	? '<a href="'.$onedebug['tourl'].'" title="'.$onedebug['tourl'].'" target="_blank">'.$icon.' '.preg_replace('/^http(s)?:\/\//','',$onedebug['tourl']).'</a>'
													: '<a href="'.$onedebug['tourl'].'" title="'.$onedebug['tourl'].'" target="_blank">'.$icon.' '.substr(preg_replace('/^http(s)?:\/\//','',$onedebug['tourl']),0,15).'....'.substr($onedebug['tourl'],-15).'</a>';
	// Status
	$status = $onedebug['status']=='ok' ? '<span style="font-weight:bold;color:#0a0;">'.$onedebug['status'].'</span>' : $onedebug['status'];
	if (substr($onedebug['status'],0,3)=='404') $status = '<span style="font-weight:bold;color:#a00;">'.$onedebug['status'].'</span>';
	if (substr($onedebug['status'],0,3)=='301') $status = '<span style="font-weight:bold;color:#960;">'.substr($onedebug['status'],0,3).'</span>'.substr($onedebug['status'],3);
	$row->status = $status;
	// Created date
	$row->created = $onedebug['created_date'];
	// Modified date
	$row->modified = $onedebug['modified_date'];
	// Build delete icon
	$row->deletelink = $this->CreateLink( $id, 'admin_deletedebug', $returnid, $imagedelete, array ( 'tabto'=>$tabto, 'debug'=>$onedebug['id'] ), $this->Lang('reallydelete'), false, false, ' title="'.$this->Lang('delete').'"');
	// Merge new domain to array
	array_push ($debugarray, $row);
	// Alternate row color
	($rowclass == 'row1' ? $rowclass = 'row2' : $rowclass = 'row1');
}

// Assign smarty vars
$smarty->assign('debugs', $debugarray );
$smarty->assign('id', $this->Lang('id'));
$smarty->assign('ip', $this->Lang('ip'));
$smarty->assign('session_id', $this->Lang('session_id'));
$smarty->assign('fromurl', $this->Lang('fromurl'));
$smarty->assign('tourl', $this->Lang('targeturl'));
$smarty->assign('status', $this->Lang('status'));
$smarty->assign('created', $this->Lang('created'));
$smarty->assign('modified', $this->Lang('modified'));
$smarty->assign('time', $this->Lang('time'));
$smarty->assign('debug', $this->Lang('debug'));
$smarty->assign('debug_log', $this->Lang('debug_log'));
$smarty->assign('deletealllink', $this->CreateLink( $id, 'admin_deletedebugs', $returnid, $imagedelete.' '.$this->Lang('deleteall'), array ( 'tabto'=>$tabto ), $this->Lang('reallydelete'), false, false, ' title="'.$this->Lang('deleteall').'"'));
$smarty->assign('tabto', $this->CreateInputHidden($id,'tabto',$tabto));

// Display Template
echo $this->ProcessTemplate('admin_debug.tpl');

// EOF