<?php
$lang['moddescription'] = 'A module to extend the Global Settings with some customized parameters. You can define an unlimited number of fields which can be used as smarty-variable in templates or pages.';

$lang['postinstall'] = 'CustomGS module successfully installed!';
$lang['uninstall_confirm'] = 'Do your really want to uninstall the CustomGS module?';
$lang['postuninstall'] = 'CustomGS module successful uninstalled!';


/**
 * Admin General Tab
 */
$lang['now'] = 'now';
$lang['title_general'] = 'General';
$lang['choosetime'] = 'Choose time';
$lang['time'] = 'time';


/**
 * Admin Fielddefs Tab
 */
$lang['title_fielddefs'] = 'Field Definitions';
$lang['smartyvar'] = 'Smarty variable';
$lang['textfield'] = 'Textfield';
$lang['pulldown'] = 'Pulldown';
$lang['checkbox'] = 'Checkbox';
$lang['radiobuttons'] = 'Radiobutton group';
$lang['datepicker'] = 'Datepicker';
$lang['datetimepicker'] = 'DateTimepicker';
$lang['timepicker'] = 'Timepicker';
$lang['colorpicker'] = 'Colorpicker';
$lang['textarea'] = 'Text Area';
$lang['pageselect'] = 'Page selector';
$lang['wysiwyg'] = 'WYSIWYG';
$lang['fieldsetstart'] = 'Fieldgroup start';
$lang['fieldsetend'] = 'Fieldgroup end';
$lang['button'] = 'Button';
$lang['maxlength'] = 'Maximum Length';
$lang['properties'] = 'Properties';
$lang['properties_help1'] = 'Enter the choice values, each one on a new line. Also supports Value|OptionName pairs and/or Smarty tags';
$lang['parsesmarty'] = 'Parse data by Smarty';
$lang['clearstylesheetcache'] = 'Clear stylesheet cache';
$lang['clearstylesheetcache_help'] = 'Automatically clear stylesheet cache after changing this setting. USE WITH CAUTION!';
$lang['showontab'] = 'Show on tab';
$lang['fielddefadded'] = 'Field Definition is added';
$lang['fielddefsupdated'] = 'Field Definition list is updated';


/**
 * Admin Tabs Tab
 */
$lang['title_tabs'] = 'Tabs';
$lang['tabadded'] = 'Tab is added';
$lang['tabupdated'] = 'Tab is updated';


/**
 * Admin Options Tab
 */ 
$lang['title_custom_modulename'] = 'Custom Modulename';
$lang['help_custom_modulename'] = 'You can change the Modulename here as you wish. It will be used as the title on the module admin pages and as menu text.';

$lang['title_admin_section'] = 'Admin Section';
$lang['help_admin_section'] = 'Choose the Admin Section (or top-level Admin Menu) this module belongs to. <b>Note</b>: Users with Editor permissions don\'t have access to the Site Admin section!';

$lang['xml_export'] = 'Export settings to XML';
$lang['xml_import'] = 'Import settings from XML';


/**
 * Saving
 */ 
$lang['settingssaved'] = 'Settings successfully saved!';
$lang['updatefailed'] = 'Update failed!';


/**
 * Events
 */
$lang['event_info_OnSettingChange'] = 'Event triggered when a setting is edited.';
$lang['event_help_OnSettingChange'] = '<h4>Parameters</h4>
<ul>
<li>fieldid</li>
<li>name</li>
<li>alias</li>
<li>value</li>
<li>clearcache</li>
</ul>
';
?>