<?php
#-------------------------------------------------------------------------
# Module: FAQ
# Author: Jos (josvd@live.nl)
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2008 by Ted Kulp (wishy@cmsmadesimple.org)
# This project's homepage is: http://www.cmsmadesimple.org
# The module's homepage is: http://dev.cmsmadesimple.org/projects/faq/
#-------------------------------------------------------------------------


$smarty->assign('startform', $this->CreateFormStart ($id, 'updateoptions', $returnid));
$smarty->assign('endform', $this->CreateFormEnd ());

$smarty->assign('title_custom_modulename', $this->Lang('title_custom_modulename'));	
$smarty->assign('help_custom_modulename', $this->Lang('help_custom_modulename'));
$smarty->assign('input_custom_modulename',$this->CreateInputText($id, 'input_custom_modulename',$this->GetPreference('custom_modulename',''),50,255));

$smarty->assign('title_admin_section', $this->Lang('title_admin_section'));	
$smarty->assign('help_admin_section', $this->Lang('help_admin_section'));
$smarty->assign('input_admin_section', $this->CreateInputDropdown($id, 'input_admin_section',
				array(lang('main') => 'main',
							lang('content') => 'content',
							lang('layout') => 'layout',
							lang('usersgroups') => 'usersgroups',
							lang('extensions') => 'extensions',
							lang('myprefs') => 'myprefs'),
				-1,
				$this->GetPreference('admin_section', 'content')
));

$smarty->assign('use_question_wysiwyg',$this->Lang('use_question_wysiwyg'));
$smarty->assign('input_use_question_wysiwyg', $this->CreateInputCheckbox($id, 'use_question_wysiwyg', '1', $this->GetPreference('use_question_wysiwyg',1)));

$smarty->assign('use_answer_wysiwyg',$this->Lang('use_answer_wysiwyg'));
$smarty->assign('input_use_answer_wysiwyg', $this->CreateInputCheckbox($id, 'use_answer_wysiwyg', '1', $this->GetPreference('use_answer_wysiwyg',1)));

$smarty->assign('title_entries_page', $this->Lang('title_entries_page'));	
$smarty->assign('input_entries_page',$this->CreateInputText($id, 'input_entries_page', $this->GetPreference('entries_page',''),5,5));

$smarty->assign('submit', $this->CreateInputSubmit ($id, 'optionssubmitbutton', lang('submit')));

// Display the populated template
echo $this->ProcessTemplate ('adminoptions.tpl');

?>