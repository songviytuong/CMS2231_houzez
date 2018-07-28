<?php

if( !defined('CMS_VERSION') ) exit;

if (isset($params['message'])) {
	echo $this->ShowMessage($this->ModLang($params['message']));
}

if (isset($params['errors']) && count($params['errors'])) {
	echo $this->ShowErrors($params['errors']);
}

if (!empty($params['active_tab'])) {
	$tab = $params['active_tab'];
} else {
	$tab = 'instancestab';
}

echo $this->StartTabHeaders();
echo $this->SetTabHeader('instancestab', $this->ModLang('instances'), ($tab == 'instancestab'));
echo $this->SetTabHeader('modulestab', $this->ModLang('modules'), ($tab == 'modulestab'));
echo $this->SetTabHeader('fielddefstab', $this->ModLang('fielddefs'), ($tab == 'fielddefstab'));
echo $this->SetTabHeader('maintenancetab', $this->ModLang('maintenance'), ($tab == 'maintenancetab'));
echo $this->SetTabHeader('optionstab', $this->ModLang('options'), ($tab == 'optionstab'));
echo $this->EndTabHeaders();

echo $this->StartTabContent();

echo $this->StartTab('instancestab', $params);
include dirname(__FILE__) . '/tabcontent.admin_instancestab.php';
echo $this->EndTab();

echo $this->StartTab('modulestab', $params);
include dirname(__FILE__) . '/tabcontent.admin_modulestab.php';
echo $this->EndTab();

echo $this->StartTab('fielddefstab', $params);
include dirname(__FILE__) . '/tabcontent.admin_fielddefstab.php';
echo $this->EndTab();

echo $this->StartTab('maintenancetab', $params);
include dirname(__FILE__) . '/tabcontent.admin_maintenancetab.php';
echo $this->EndTab();

echo $this->StartTab('optionstab', $params);
include dirname(__FILE__) . '/tabcontent.admin_optionstab.php';
echo $this->EndTab();
    
echo $this->EndTabContent();

?>