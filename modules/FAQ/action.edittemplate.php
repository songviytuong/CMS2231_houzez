<?php
#-------------------------------------------------------------------------
# Module: FAQ
# Author: Jos (josvd@live.nl)
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2008 by Ted Kulp (wishy@cmsmadesimple.org)
# This project's homepage is: http://www.cmsmadesimple.org
# The module's homepage is: http://dev.cmsmadesimple.org/projects/faq/
#-------------------------------------------------------------------------

if( !$gCms ) exit();

if( isset($params['cancel']) )
{
	$params = array('active_tab' => 'templates');
	$this->Redirect($id, 'defaultadmin', '', $params);
}

if( ! $this->CheckPermission('Modify Templates') )
{
	echo $this->ShowErrors(lang('needpermissionto', 'Modify Templates'));
	return;
}

if( !isset($params['mode']) )
{
	$params['module_error'] = lang('missingparams');
	$this->Redirect($id,'defaultadmin','',$params);
	return;
}

if( !isset($params['template']) && ($params['mode'] != 'add' || $_SERVER['REQUEST_METHOD'] == 'POST') )
{
	$params['module_error'] = lang('missingparams');
	$this->Redirect($id,'defaultadmin','',$params);
	return;
}

$tpl_name = '';
$tpl_type = '';
$contents = '';
$templatetypes = array(
		$this->Lang('summary_tpl') => 'summary',
		$this->Lang('detail_tpl') => 'detail');

switch ($params['mode'])
{
	case 'add':
		if( $_SERVER['REQUEST_METHOD'] == 'POST' )
		{
			$params['template'] = trim($params['template']);

			// check if this template already exists
			$txt = trim($this->GetTemplate($params['type'] . '_' . $params['template']));
			if( $txt == "" )
			{
				// save template
				$this->SetTemplate($params['type'] . '_tpl_' . $params['template'], $params['templatecontent']);

				$params = array('module_message' => lang('added_template'), 'active_tab' => 'templates');
				$this->Redirect($id, 'defaultadmin', '', $params);
			}

			$params['module_error'] = lang('templateexists');
			$this->Redirect($id, 'edittemplate', '', $params);
		}

		if ( isset($params['template']) )
		{
			list($tpl_type, $tpl_name) = explode('_tpl_', $params['template'], 2);
			$contents = $params['templatecontent'];
		}
		$smarty->assign('templatename', $this->CreateInputText( $id, 'template', $tpl_name, 40 ));
		$smarty->assign('type', $this->CreateInputDropdown($id, 'type', $templatetypes, -1, $tpl_type, 'id="' . $id . 'type"'));
		break;


	case 'copy':
		list($tpl_type, $tpl_name) = explode('_tpl_', $params['template'], 2);
		$smarty->assign('templatename', $this->CreateInputText( $id, 'template', '', 40 ));
		$smarty->assign('type', $this->CreateInputDropdown($id, 'type', $templatetypes, -1, $tpl_type));
		$contents = $this->GetTemplate($params['template']);
		$params['mode'] = 'add';
		break;


	case 'delete':
		$template = cms_html_entity_decode($params['template']);
		$this->DeleteTemplate($template);

		$params = array('module_message' => lang('deleted_template'), 'active_tab' => 'templates');
		$this->Redirect($id, 'defaultadmin', '', $params);
		break;


	case 'edit':
		if( $_SERVER['REQUEST_METHOD'] == 'POST' )
		{
			// save template
			$this->SetTemplate($params['template'], $params['templatecontent']);

			if ( isset($params['applybutton']) || isset($params['resetbutton']) )
			{
				$params = array('template' => $params['template'], 'mode' => "edit", 'module_message' => lang('edittemplatesuccess'));
				$this->Redirect($id, 'edittemplate', '', $params);
			}
			else
			{
				$params = array('module_message' => lang('edittemplatesuccess'), 'active_tab' => 'templates');
				$this->Redirect($id, 'defaultadmin', '', $params);
			}
		}

		list($tpl_type, $tpl_name) = explode('_tpl_', $params['template'], 2);
		$smarty->assign('templatename', $tpl_name);
		$smarty->assign('type', $this->Lang($tpl_type . '_tpl')); // . $this->CreateInputHidden ($id, 'type', $tpl_type));
		$contents = $this->GetTemplate($params['template']);
		break;

	case 'switchdefault':
		list($tpl_type, $tpl_name) = explode('_tpl_', $params['template'], 2);
		$this->SetPreference('default_' . $tpl_type . '_template', $params['template']);
		$this->Redirect($id, 'defaultadmin' , $returnid, array('active_tab' => 'templates'));
		break;
}

$smarty->assign('title', lang('template'));

$smarty->assign('prompt_templatename', lang('name'));
$smarty->assign('prompt_type', lang('type'));

$smarty->assign('prompt_template', lang('code'));
$smarty->assign('template', $this->CreateSyntaxArea ($id, $contents, 'templatecontent'));
/*
$smarty->assign('availablevariables', $this->Lang('availablevariables'));
$smarty->assign('availablevariableslist', $this->Lang('availablevariableslist'));
$smarty->assign('availablevariableslink', $gCms->variables['admintheme']->DisplayImage('icons/system/info.gif', $this->Lang('availablevariables'),'','','systemicon'));
*/
$smarty->assign('submit', $this->CreateInputSubmit ($id, 'submitbutton', lang('submit')));
$smarty->assign('apply', $params['mode'] == 'add' ? '' : $this->CreateInputSubmit($id, 'applybutton', lang('apply')));
$smarty->assign('cancel', $this->CreateInputSubmit ($id, 'cancel', lang('cancel')));
$smarty->assign('reset', $this->CreateLink($id, 'edittemplate', $returnid, $this->Lang('resetdefault'), array(), '', false, false, 'id="resetlink"'));
$template = 'summary_tpl_list';
$smarty->assign('javascript', '
<script type="text/javascript">
$(function() {  
	$("#resetlink").click(function(){
		if (confirm(\'' . $this->Lang('resetwarning') . '\')){
			var tpl_type=' . ($params['mode'] == 'add' ? '$("#' . $id . 'type").val();' : '"' .  $tpl_type . '";') . '
			switch (tpl_type)
			{
			case "summary":
				template="summary_tpl_list";
				break;
			case "detail":
				template="detail_tpl_entry";
				break;
			} 
			$.get("../modules/FAQ/templates/"+template+".txt",function(data){
				$("textarea").val(data);
			});
		}
		return false;
	});
});
</script>');

$smarty->assign('formstart', $this->CreateFormStart ($id, 'edittemplate', $returnid, 'post', '', false, '', $params));
$smarty->assign('formend', $this->CreateFormEnd());

echo $this->ProcessTemplate('edittemplate.tpl');

?>