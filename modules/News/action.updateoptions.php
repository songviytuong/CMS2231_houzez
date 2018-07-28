<?php

if (!isset($gCms))
    exit;
if (!$this->CheckPermission('Modify Site Preferences'))
    return;

$this->SetPreference('default_category', $params['default_category']);
$this->SetPreference('formsubmit_emailaddress', $params['formsubmit_emailaddress']);
$this->SetPreference('email_subject', trim($params['email_subject']));
$this->SetTemplate('email_template', $params['email_template']);
$this->SetPreference('allowed_upload_types', $params['allowed_upload_types']);
$this->SetPreference('hide_summary_field', (isset($params['hide_summary_field']) ? '1' : '0'));
$this->SetPreference('allow_summary_wysiwyg', (isset($params['allow_summary_wysiwyg']) ? '1' : '0'));
$this->SetPreference('expired_searchable', (isset($params['expired_searchable']) ? '1' : '0'));
$this->SetPreference('expired_viewable', (isset($params['expired_viewable']) ? '1' : '0'));
$this->SetPreference('expiry_interval', $params['expiry_interval']);
$this->SetPreference('fesubmit_status', $params['fesubmit_status']);
$this->SetPreference('fesubmit_redirect', trim($params['fesubmit_redirect']));
$this->SetPreference('detail_returnid', (int) $params['detail_returnid']);
$this->SetPreference('allow_fesubmit', (int) $params['allow_fesubmit']);
$this->SetPreference('alert_drafts', (int) $params['alert_drafts']);

$db = cmsms()->GetDb();
$module_name = $this->GetName();
#+Lee Mle
if (isset($params["allowmle"])) {
    $this->SetPreference("allowmle", $params["allowmle"]);
    $_fields = array(
        'module_news' => array('news_title', 'news_data', 'summary'),
        'module_news_categories' => array('news_category_name', 'long_name'),
    );
    $module_fields = json_encode($_fields);
    $_update = "UPDATE " . cms_db_prefix() . "modules SET sync = 1, sync_target = ? WHERE module_name = ?";
    $db->Execute($_update, array($module_fields, $module_name));
} else {
    $this->SetPreference("allowmle", '0');
    $_delete = "DELETE FROM " . cms_db_prefix() . "module_lise_modules WHERE (`module_name`= ?)";
    $db->Execute($_delete, array($module_name));
    $_update = "UPDATE " . cms_db_prefix() . "modules SET sync = 0, sync_target = '' WHERE module_name = ?";
    $db->Execute($_update, array($module_name));
}
#-Lee

$this->CreateStaticRoutes();
$params = array('tab_message' => 'optionsupdated', 'active_tab' => 'options');
$this->SetMessage($this->Lang('optionsupdated'));
$this->RedirectToAdminTab('options', '', 'admin_settings');
?>
