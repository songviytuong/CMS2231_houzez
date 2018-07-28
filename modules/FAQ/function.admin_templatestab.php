<?php
#-------------------------------------------------------------------------
# Module: FAQ
# Author: Jos (josvd@live.nl)
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2008 by Ted Kulp (wishy@cmsmadesimple.org)
# This project's homepage is: http://www.cmsmadesimple.org
# The module's homepage is: http://dev.cmsmadesimple.org/projects/faq/
#-------------------------------------------------------------------------


$falseimage1 = $admintheme->DisplayImage('icons/system/false.gif', lang('settrue'),'','','systemicon');
$trueimage1 = $admintheme->DisplayImage('icons/system/true.gif', lang('default'),'','','systemicon');

$alltemplates = $this->ListTemplates();

$rowarray = array();
$rowclass = 'row1';

foreach( $alltemplates as $onetemplate )
{
	$tpl = $onetemplate;
	list($tpl_type, $tpl_name) = explode('_tpl_', $onetemplate, 2);
	$row = new StdClass();
	$row->name = $this->CreateLink($id, 'edittemplate', $returnid, $tpl_name, array('template' => $tpl, 'mode'=>'edit'));
	$row->type = $this->Lang($tpl_type . '_tpl');
	$row->rowclass = $rowclass;

	$default = $this->GetPreference('default_' . $tpl_type . '_template') == $tpl ? true : false;
	if( $default )
	{
		$row->default = $trueimage1;
		$row->deletelink = '&nbsp;';
	}
	else
	{
		$row->default = $this->CreateLink($id, 'edittemplate', $returnid,
				       $falseimage1,
				       array('template' => $tpl, 'mode'=>'switchdefault'));
		$row->deletelink = $this->CreateLink($id, 'edittemplate', $returnid,
					  $admintheme->DisplayImage('icons/system/delete.gif', lang ('delete'), '', '', 'systemicon'),
					  array ('template' => $tpl, 'mode'=>'delete'), $this->Lang ('areyousure'));
	}

	$row->editlink = $this->CreateLink($id, 'edittemplate', $returnid,
				    $admintheme->DisplayImage('icons/system/edit.gif', lang ('edit'), '', '', 'systemicon'),
				    array ('template' => $tpl, 'mode'=>'edit'));
	
	$row->copylink = $this->CreateLink($id, 'edittemplate', $returnid,
				    $admintheme->DisplayImage('icons/system/copy.gif', lang ('copy'), '', '', 'systemicon'),
				    array ('template' => $tpl, 'mode'=>'copy'));

	array_push ($rowarray, $row);
	($rowclass == "row1" ? $rowclass = "row2" : $rowclass = "row1");
}

$smarty->assign('items', $rowarray );
$smarty->assign('nameprompt', lang('name'));
$smarty->assign('typeprompt', lang('type'));
$smarty->assign('defaultprompt', lang('default'));

$smarty->assign('newtemplatelink',
	  $this->CreateLink($id, 'edittemplate', $returnid,
			     $admintheme->DisplayImage('icons/system/newobject.gif', lang('addtemplate'),'','','systemicon'),
			     array('mode' => 'add', 'defaulttemplatepref' => 'default_template_contents'), '', false, false, '').' '.

	  $this->CreateLink($id, 'edittemplate', $returnid,
			     lang('addtemplate'),
			     array('mode' => 'add', 'defaulttemplatepref' => 'default_template_contents')));

echo $this->ProcessTemplate('admintemplates.tpl');

?>