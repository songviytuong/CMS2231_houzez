<?php
#-------------------------------------------------------------------------
# Module: FAQ
# Author: Jos (josvd@live.nl)
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2008 by Ted Kulp (wishy@cmsmadesimple.org)
# This project's homepage is: http://www.cmsmadesimple.org
# The module's homepage is: http://dev.cmsmadesimple.org/projects/faq/
#-------------------------------------------------------------------------

if (!isset($gCms)) exit;

if( !$this->CheckPermission('Modify Site Preferences') )
{
	echo $this->ShowErrors(lang('needpermissionto', 'Modify Site Preferences'));
	return;
}

$this->SetPreference('custom_modulename', $params['input_custom_modulename']);
$this->SetPreference('admin_section', $params['input_admin_section']);

// Clear admin menu cache
if (version_compare(CMS_VERSION, '1.99-alpha0', '<')) {
	foreach (glob(cms_join_path(TMP_CACHE_LOCATION, "themeinfo*.cache")) as $filename) { @unlink($filename); } // 1.11
} else {
	foreach (glob(cms_join_path(TMP_CACHE_LOCATION, "cache*.cms")) as $filename) { @unlink($filename); } // 2.0
}

$this->SetPreference('use_question_wysiwyg', isset($params['use_question_wysiwyg']) ? $params['use_question_wysiwyg'] : 0);
$this->SetPreference('use_answer_wysiwyg', isset($params['use_answer_wysiwyg']) ? $params['use_answer_wysiwyg'] : 0);

if (empty($params['input_entries_page']) || ctype_digit($params['input_entries_page'])) $this->SetPreference('entries_page', $params['input_entries_page']);

// Put mention into the admin log
audit('', 'FAQ - Options tab', 'Saved');

$params = array('tab_message'=> 'optionsupdated', 'active_tab' => 'options');
$this->Redirect($id, 'defaultadmin', '', $params);
?>
