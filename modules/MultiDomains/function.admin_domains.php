<?php
/*======================================================================================
Module: MultiDomains
======================================================================================*/

// Check authorisation
if (!isset($gCms)) exit;
if ( !$this->CheckPermission('Manage MultiDomains') ) exit;

// Set Tab name
$tabto = 'domains';

// Check if Domain is given and get Domain ID
$domain = 0;
if (isset($params['domain'])) $domain = (int)$params['domain'];

// Display form for editing a domain
if (isset($params['domain'])) {

	// Get domain info
	$domaininfo = $db->GetRow('SELECT page_id,domain,devdomain,prefix,active,root,notes,created_date,modified_date FROM '.MD_DOMAIN_TABLE.' WHERE id = ?', array($domain));
	if (!is_array($domaininfo)) $domaininfo = array();
	if (!isset($domaininfo['domain'])) $domaininfo['domain'] = '';
	if (!isset($domaininfo['devdomain'])) $domaininfo['devdomain'] = '';
	if (!isset($domaininfo['prefix'])) $domaininfo['prefix'] = false;
	if (!isset($domaininfo['page_id'])) $domaininfo['page_id'] = 0;
	if (!isset($domaininfo['active'])) $domaininfo['active'] = false;
	if (!isset($domaininfo['root'])) $domaininfo['root'] = false;
	if (!isset($domaininfo['notes'])) $domaininfo['notes'] = '';
	// Get extradomains for the current domain
	$extradomains_array = $db->GetCol('SELECT domain FROM '.MD_EXTRADOMAIN_TABLE.' WHERE domain_id = ?', array($domain));
	$extradomains = implode("\n",$extradomains_array);
    // Assign Smarty vars
    $smarty->assign('formstart',$this->CreateFormStart($id,'admin_editdomain',$returnid,'post','multipart/form-data',true,array()));
    $smarty->assign('formend', $this->CreateFormEnd());
    $smarty->assign('submit', $this->CreateInputSubmit($id,$domain ? 'submit': 'add',$this->Lang('submit')));
    $smarty->assign('cache', $this->CreateInputSubmit($id,$domain ? 'cache' : 'cacheadd',$this->Lang('cache')));
    $smarty->assign('reset', $this->CreateInputReset($id,'reset',$this->Lang('reset')));
    $smarty->assign('cancel', $this->CreateInputSubmit($id,'cancel',$this->Lang('cancel')));
    $smarty->assign('tabto', $this->CreateInputHidden($id,'tabto',$tabto));
    $smarty->assign('domain', $this->CreateInputHidden($id,'domain',$domain));
    $smarty->assign('domainedit', $this->Lang('domainedit'));
	$smarty->assign('prompt_domainname', $this->Lang('domainname'));
    $smarty->assign('domain_name', $domaininfo['domain']);
	$smarty->assign('www_notice', $this->Lang('www_notice'));
	$smarty->assign('wwwreplace', $this->GetPreference('www_replace') ? $this->GetPreference('www_replace') : 'www');
	$smarty->assign('check_devdomain', $this->GetPreference('devdomain') ? '1' : '0');
	$smarty->assign('prompt_devdomainname', $this->Lang('devdomain'));
	$smarty->assign('input_devdomainname', $this->CreateInputText($id,'devdomainname',$domaininfo['devdomain'],50,100));
	$smarty->assign('prompt_domainid', $this->Lang('id'));
	$smarty->assign('domainid', $domain ? $domain : $this->Lang('newdomain'));
    $smarty->assign('input_domainname', $this->CreateInputText($id,'domainname',$domaininfo['domain'],50,100));
	$smarty->assign('prompt_prefix', $this->Lang('prefix'));
	$smarty->assign('input_prefix', $this->CreateInputCheckbox($id, 'prefix', 'true', $domaininfo['prefix'] ? 'true' : 'false'));
	$smarty->assign('check_prefix', $domaininfo['prefix'] ? 'true' : 'false');
    $smarty->assign('prompt_page', $this->Lang('page'));
	$smarty->assign('input_page',$contentops->CreateHierarchyDropdown('',$domaininfo['page_id'],$id.'page',0,1,0,1)); // current, parent, parent_id, allowcurrent, use_perms, ignore_current, allow_all
	$smarty->assign('prompt_active', $this->Lang('active'));
	$smarty->assign('input_active', $this->CreateInputCheckbox($id, 'active', 'true', $domaininfo['active'] ? 'true' : 'false'));
	$smarty->assign('prompt_root', $this->Lang('root'));
	$smarty->assign('input_root', $this->CreateInputCheckbox($id, 'root', 'true', $domaininfo['root'] ? 'true' : 'false'));
	$smarty->assign('help_root', $this->Lang('root_help'));
	$smarty->assign('prompt_extradomains', $this->Lang('extradomains'));
	$smarty->assign('description_extradomains', $this->Lang('extradomains_description'));
	$smarty->assign('input_extradomains', $this->CreateTextArea(false, $id, $extradomains, 'extradomains', 'pagesmalltextarea'));
	$smarty->assign('prompt_notes', $this->Lang('notes'));
	$smarty->assign('domain_notes', $this->CreateTextArea(false, $id, $domaininfo['notes'], 'notes', 'pagesmalltextarea'));
    // Display Template
    echo $this->ProcessTemplate('admin_editdomain.tpl');

}

// Display a list with available domains
else {
	// Set vars and images
	$www_rp = $this->GetPreference('www_replace') ? $this->GetPreference('www_replace') : 'www';
	$admintheme = cms_utils::get_theme_object();
	$imageview = $admintheme->DisplayImage('icons/system/view.gif',$this->Lang('view'),'','','systemicon');
	$imagenostandard = $admintheme->DisplayImage('icons/system/false.gif',$this->Lang('makestandard'),'','','systemicon');
	$imageinactive = $admintheme->DisplayImage('icons/system/false.gif',$this->Lang('makeactive'),'','','systemicon');
	$imagestandard = $admintheme->DisplayImage('icons/system/true.gif',$this->Lang('standard'),'','','systemicon');
	$imageactive = $admintheme->DisplayImage('icons/system/true.gif',$this->Lang('makeinactive'),'','','systemicon');
	$imageedit = $admintheme->DisplayImage('icons/system/edit.gif',$this->Lang('edit'),'','','systemicon');
	$imagedelete = $admintheme->DisplayImage('icons/system/delete.gif',$this->Lang('delete'),'','','systemicon');
	$imagenew = $admintheme->DisplayImage('icons/system/newobject.gif',$this->Lang('newtemplate'),'','','systemicon');
	// Get domains
	$alldomains = $db->GetAll('SELECT id,page_id,domain,devdomain,prefix,active,root,notes,created_date,modified_date FROM '.MD_DOMAIN_TABLE);
	if (!is_array($alldomains)) $alldomains = array();
	// Show domain
	$rowarray = array();
	$rowclass = 'row1';
	foreach ( $alldomains as $onedomain ) {
		// Build a new row
		$row = new StdClass();
		$row->rowclass = $rowclass;
		// ID
		$row->id = $onedomain['id'];
		// Help: CreateLink($id, $action, $returnid='', $contents='', $params=array(), $warn_message='', $onlyhref=false, $inline=false, $addttext='', $targetcontentonly=false, $prettyurl='')
		// Build domain with edit link
		$row->name = $this->CreateLink( $id, 'admin_editdomain', $returnid, $onedomain['prefix']?$www_rp.'.'.$onedomain['domain']:$onedomain['domain'], array ( 'tabto'=>$tabto, 'domain'=>$onedomain['id'] ), '', false, false, ' title="'.$this->Lang('edit').'"');
		$row->vurl = $onedomain['prefix']?'http://'.$www_rp.'.'.$onedomain['domain']:'http://'.$onedomain['domain'];
		// Development domain
		$row->devdomain = $this->CreateLink( $id, 'admin_editdomain', $returnid, $onedomain['prefix']?$www_rp.'.'.$onedomain['devdomain']:$onedomain['devdomain'], array ( 'tabto'=>$tabto, 'domain'=>$onedomain['id'] ), '', false, false, ' title="'.$this->Lang('edit').'"');
		$row->vdevurl = $onedomain['prefix']?'http://'.$www_rp.'.'.$onedomain['devdomain']:'http://'.$onedomain['devdomain'];
		// Page
		#echo 'SELECT menu_text,hierarchy,content_alias FROM '.cms_db_prefix().'content WHERE content_id = '.$onedomain['page_id'];
		$pageinfo = $db->GetRow('SELECT menu_text,hierarchy,content_alias FROM '.MD_CONTENT_TABLE.' WHERE content_id = ?', array($onedomain['page_id']));
		$hierarchy = '';
		$calias = '';
		$hierarchy_full = '00001';
		if ($pageinfo) {
			$hierarchy_full = $pageinfo['hierarchy'];
			$hierarchies = explode('.',$pageinfo['hierarchy']);
			foreach ($hierarchies as $k=>$h) $hierarchies[$k]=(int)$h;
			$hierarchy = implode('.',$hierarchies);
			$calias = $pageinfo['content_alias'];
			$row->page = $pageinfo['menu_text'].' <em>('.$hierarchy.':'.$calias.')</em>';
		}
		// Build link for making the domain to the default domain
		$default = ($this->GetPreference('defaultdomain') == $onedomain['id']) ? true : false;
		if ( $default ) { $row->default = $imagestandard; }
		else { $row->default = $this->CreateLink( $id, 'admin_makestandarddomain', $returnid, $imagenostandard, array ( 'tabto'=>$tabto, 'domain'=>$onedomain['id'] ), $this->Lang('reallymakestandard'), false, false, ' title="'.$this->Lang('makestandard').'"'); }
		// Build link for de-/activate the domain
		$active = $onedomain['active'] ? 1 : 0;
		if ( $active ) { $row->active = $this->CreateLink( $id, 'admin_domainactive', $returnid, $imageactive, array ( 'tabto'=>$tabto, 'domain'=>$onedomain['id'], 'active'=>0 ), $this->Lang('reallymakeinactive'), false, false, ' title="'.$this->Lang('makeinactive').'"'); }
		else { $row->active = $this->CreateLink( $id, 'admin_domainactive', $returnid, $imageinactive, array ( 'tabto'=>$tabto, 'domain'=>$onedomain['id'], 'active'=>1 ), $this->Lang('reallymakeactive'), false, false, ' title="'.$this->Lang('makeactive').'"'); }
		
		// Build link for root the domain or not
		$root = $onedomain['root'] ? 1 : 0;
		$row->root = $root ? $imageactive : $imageinactive;
		
		// Build edit icon
		$row->editlink = $this->CreateLink( $id, 'admin_editdomain', $returnid, $imageedit, array ( 'tabto'=>$tabto, 'domain'=>$onedomain['id'] ), '', false, false, ' title="'.$this->Lang('edit').'"');
		// Build delete icon
		#if ( $default ) { $row->deletelink = '&nbsp;'; }
		#else {
			$row->deletelink = $this->CreateLink( $id, 'admin_deletedomain', $returnid, $imagedelete, array ( 'tabto'=>$tabto, 'domain'=>$onedomain['id'] ), $this->Lang('reallydelete'), false, false, ' title="'.$this->Lang('delete').'"');
		#}
		// Add description
		$row->help = $this->Lang('ddescription', $hierarchy.' ('.$calias.')');
		$pages = $db->GetOne('SELECT count(content_id) FROM '.MD_CONTENT_TABLE.' WHERE active=1 AND type!="errorpage" AND type!="separator" AND hierarchy like "'.$hierarchy_full.'%"', array());
		if (!$pages) $pages = '0';
		$row->pages = $pages;
		// Merge new domain to array
		array_push ($rowarray, $row);
		// Alternate row color
		($rowclass == 'row1' ? $rowclass = 'row2' : $rowclass = 'row1');
	}

	// Assign smarty vars
	$smarty->assign('items', $rowarray );
	$smarty->assign('id', $this->Lang('id'));
	$smarty->assign('viewicon', $imageview);
	$smarty->assign('view', $this->Lang('view'));
	$smarty->assign('prefix', $this->Lang('prefix'));
	$smarty->assign('domain', $this->Lang('domain'));
	$smarty->assign('devdomain', $this->Lang('devdomain_short'));
	$smarty->assign('devdomain_active', $this->GetPreference('devdomain') ? '1' : '0');
	$smarty->assign('page', $this->Lang('page'));
	$smarty->assign('active', $this->Lang('active'));
	$smarty->assign('root', $this->Lang('root'));
	$smarty->assign('newdomainlink', $this->CreateLink( $id, 'admin_editdomain', '', $imagenew.' '.$this->Lang('newdomain'), array ( 'tabto'=>$tabto, 'domain'=>'' ), '', false, false, ' title="'.$this->Lang('newdomain').'"'));
	#$smarty->assign($this->CreateFormEnd());
	echo $this->ProcessTemplate('admin_listdomains.tpl');

}

// EOF