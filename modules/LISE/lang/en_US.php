<?php
#-------------------------------------------------------------------------
# LISE - List It Special Edition
# Version 1.2
# A fork of ListI2
# maintained by Fernando Morgado AKA Jo Morg
# since 2015
#-------------------------------------------------------------------------
#
# Original Author: Ben Malen, <ben@conceptfactory.com.au>
# Co-Maintainer: Simon Radford, <simon@conceptfactory.com.au>
# Web: www.conceptfactory.com.au
#
#-------------------------------------------------------------------------
#
# Maintainer since 2011 up to 2014: Jonathan Schmid, <hi@jonathanschmid.de>
# Web: www.jonathanschmid.de
#
#-------------------------------------------------------------------------
#
# Some wackos started destroying stuff since 2012 and stopped at 2014:
#
# Tapio Löytty, <tapsa@orange-media.fi>
# Web: www.orange-media.fi
#
# Goran Ilic, <uniqu3e@gmail.com>
# Web: www.ich-mach-das.at
#
#-------------------------------------------------------------------------
#
# LISE is a CMS Made Simple module that enables the web developer to create
# multiple lists throughout a site. It can be duplicated and given friendly
# names for easier client maintenance.
#
#-------------------------------------------------------------------------
# BEGIN_LICENSE
#-------------------------------------------------------------------------
# This file is part of LISE
# LISE program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# LISE program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
# Or read it online: http://www.gnu.org/licenses/licenses.html#GPL
#
#-------------------------------------------------------------------------
# END_LICENSE
#-------------------------------------------------------------------------

/* --- do not edit ------------------------------------------------------ */
/* Only necessary in the English lang file, because it's always loaded first, even if English is not the user's language.
*/
$module_name = '';
if( isset($modinstance) && is_object($modinstance) ) $module_name = $modinstance->GetName();

/* -- end of do not edit ------------------------------------------------ */

// global
$lang['invalid_characters'] = 'Characters, such: %s not allowed with field: %s';
$lang['green'] = 'Green';
$lang['yellow'] = 'Yellow';
$lang['red'] = 'Red';
$lang['desc'] = 'Description';
$lang['sent'] = 'Sent';
$lang['sent_email'] = 'Sent Email';
$lang['prompt_sent_email'] = 'Allow system to Sent Email';

$lang['time_control'] = 'Active Time Control';
$lang['prompt_time_control'] = 'Allow system to Active Time Control';

$lang['extra1_enabled'] = 'Enabled Extra1';
$lang['prompt_extra1_enabled'] = 'Allow system to Enabled Extra 1';
$lang['prompt_extra1_enabled_wysiwyg'] = 'Enable WYSIWYG';
$lang['extra2_enabled'] = 'Enabled Extra2';
$lang['prompt_extra2_enabled'] = 'Allow system to Enabled Extra 2';
$lang['prompt_extra2_enabled_wysiwyg'] = 'Enable WYSIWYG';
$lang['extra3_enabled'] = 'Enabled Extra3';
$lang['prompt_extra3_enabled'] = 'Allow system to Enabled Extra 3';
$lang['prompt_extra3_enabled_wysiwyg'] = 'Enable WYSIWYG';

$lang['sync_languages'] = 'Sync';
$lang['sync'] = 'Sync';

// tabs
$lang['item'] = 'Item';
$lang['items'] = 'Items';
$lang['fielddef'] = 'Field Definition';
$lang['fielddefs'] = 'Field Definitions';
$lang['template'] = 'Template';
$lang['templates'] = 'Templates';
$lang['category'] = 'Category';
$lang['categories'] = 'Categories';
$lang['option'] = 'Option';
$lang['options'] = 'Options';
$lang['maintenance'] = 'Maintenance';
$lang['back'] = 'Go one page back';
$lang['about'] = 'About';
$lang['whatsnew'] = 'What\'s New';

// maintenance
$lang['prompt_fix_fielddefs'] = 'Attempt to repair field definition database tables';
$lang['message_fielddefs_fixed'] = 'Field Definitions on all instances repaired.';
$lang['message_instances_copied'] = 'All instances have been cloned.';

// items
$lang['help_fieldid'] = 'Field ID';
$lang['help_fieldval'] = 'Field Val';
$lang['item_title'] = 'Title';
$lang['prompt_item_title'] = 'Item title';
$lang['prompt_of'] = 'of';
$lang['active'] = 'Active';
$lang['create_time'] = 'Date created';
$lang['modified_time'] = 'Date modified';
$lang['time_control'] = 'Use time control';
$lang['start_time'] = 'Start time';
$lang['end_time'] = 'End time';
$lang['item_title_empty'] = 'Item title is empty';
$lang['required_field_empty'] = 'Required field is empty';
$lang['too_long'] = 'Field value exceeds max length';
$lang['approve'] = 'Set Status to \'Active\'';
$lang['revert'] = 'Set Status to \'Inactive\'';
$lang['toggle_status'] = 'Toggle Status';
$lang['select_item'] = 'Select item';
$lang['submit_order'] = 'Save order';
$lang['delete_selected'] = 'Delete Selected %s';
$lang['areyousure_deletemultiple'] = 'Are you sure you want to delete all of these %s?';
$lang['select_all'] = 'Select all';
$lang['error_startgreaterend'] = 'Start date is greater than end date.';
$lang['item_alias_exists'] = 'Item alias already exists. Alias must be unique.';
$lang['return_url'] = 'Return';
$lang['pathcontainsvars'] = 'This field can be edited after first saving this %s'; // <- unused.
$lang['url'] = 'Choose a custom URL for this item or accept the generated one';

// Item static variable helps
$lang['item_var_help_item_id'] = 'If item_id is given, items are expected to be existing ones in database. If you\'re importing new items, ignore this field.';
$lang['item_var_help_category_id'] = 'If category_id is given, the item will be set into this category. If category_id is given but doesn\'t exist, it is ignored and the default category is used instead.';
$lang['item_var_help_title'] = 'Item title that is shown in URL and describes item.';
$lang['item_var_help_alias'] = 'Item alias determines friendly computer acceptable name of item. Alias is unique for each item.';
$lang['item_var_help_url'] = 'Item custom URL. Must be unique for each item and system wide.';
$lang['item_var_help_position'] = 'You can set the position of items which determines their order of display.';
$lang['item_var_help_active'] = 'This option will set the item as either active or inactive.';
$lang['item_var_help_start_time'] = 'Set the time when you want to show this item.';
$lang['item_var_help_end_time'] = 'Set the time when you want to hide this item.';
$lang['item_var_help_owner'] = 'Set admin user ID for this item, to set owner.';
$lang['item_var_help_key1'] = 'Set additional identifier \'key1\' for this item.';
$lang['item_var_help_key2'] = 'Set additional identifier \'key2\' for this item.';
$lang['item_var_help_key3'] = 'Set additional identifier \'key3\' for this item.';

// field definitions
$lang['main_settings'] = 'Main Settings';
$lang['editfielddef'] = 'Edit Field Definition';
$lang['fielddef_name'] = 'Name';
$lang['fielddef_help'] = 'Helpful tip';
$lang['fielddef_type'] = 'Type';
$lang['fielddef_deps'] = 'Module Dependencies';
$lang['fielddef_deps_missing'] = 'One or more module dependencies are missing. Please install all required modules to start using this field.';
$lang['fielddef_scan'] = 'Scan Field Definitions';
$lang['fielddef_scanned'] = 'Field Definitions scanned';
$lang['fielddef_type_notset'] = 'Field Definitions type is not set';
$lang['fielddef_friendlytype'] = 'Friendly Type';
$lang['fielddef_originator'] = 'Originator';
$lang['fielddef_max_length'] = 'Maximum length';
$lang['fielddef_required'] = 'Required';
$lang['registered_fielddefs'] = 'Registered Field Definitions';
$lang['fielddef_name_empty'] = 'Field definition name is empty';
$lang['fielddef_name_exists'] = 'Field definition name already exists';
$lang['fielddef_alias_exists'] = 'Field definition alias already exists. Alias must be unique.';
$lang['fielddef_is_unique'] = 'Field definition is unique, you can\'t have more than one of these.';
$lang['fielddef_image'] = 'Expected to be image';
$lang['fielddef_CoreFilePicker'] = 'Core File Picker';
$lang['invalid'] = 'Field value is invalid';
$lang['status_required'] = 'Set status to \'required\'';
$lang['status_optional'] = 'Set status to \'optional\'';
$lang['is_default'] = 'Is set to \'Default\'';
$lang['status_default'] = 'Set to \'Default\'';
$lang['helptext_title'] = 'Possible Field Definition instructions for Extra field:';
$lang['fielddef_template'] = 'Template';
$lang['field_search_index'] = 'Allow this field to be indexed by global search';
$lang['prompt_reindex_do_search'] = 'Re-index search on submit (or remove words if the above is unchecked)';
$lang['fielddef_search_index_help'] = 'Checking this box will mark this field to be indexed by global search, when creating new items, editing items, or re-indexing all content from the selected search module.';
$lang['warning_reindex_search_now'] = 'Please note this can be slow, depending on the number of records.';
$lang['warning_reindex_search'] = 'Please note that while this module was not designed to support a large number of items, it has been known to be used, in certain server configurations, with tens of thousands of records together with a high number of custom fields per instance all with a reasonable performance. As such please be advised that indexing this module with the search module can only be effective with items in the order of the hundreds of records, not thousands. If you plan to use a huge number records, keep in mind that the indexing and the search itself can be slow to the extreme of being unusable, so you should stick to the module own search feature as it is optimized for these cases.';

// fields deffs

// TextInput
$lang['fielddef_TextInput'] = 'Text Input';
// CheckBox
$lang['fielddef_Checkbox'] = 'Checkbox';
// TextArea
$lang['fielddef_TextArea'] = 'Text Area';
// Select Date (deprecated)
$lang['fielddef_SelectDate'] = 'Select Date';
// Select DateTime
$lang['fielddef_SelectDateTime'] = 'Select DateTime';
$lang['fielddef_dt_backwards_compatibility'] = 'Backwards Compatibility';
$lang['fielddef_dt_fielddef_backwards_compatibility_help'] = 'Check this field to keep using old DateTime db storage';
//Dropdown
$lang['fielddef_Dropdown'] = 'Dropdown';
// Content Pages
$lang['fielddef_ContentPages'] = 'Content Pages';
// Select File
$lang['fielddef_SelectFile'] = 'Select File';
// Radio Group
$lang['fielddef_RadioGroup'] = 'Radio Group';
$lang['enable_jqui'] = 'Use jQueryUI Buttons';
// Slider
$lang['fielddef_Slider'] = 'Slider';
// Multi Select
$lang['fielddef_MultiSelect'] = 'Multi Select';
// Checkbox Group
$lang['fielddef_CheckboxGroup'] = 'Checkbox Group';
// File Upload
$lang['fielddef_FileUpload'] = 'File Upload';
// Color Picker
$lang['fielddef_ColorPicker'] = 'Color Picker';
// Tags
$lang['fielddef_Tags'] = 'Tags';
// Tabs
$lang['fielddef_Tabs'] = 'Tab';

# BackendText
$lang['fielddef_BackendText'] = 'Backend Text';
$lang['fielddef_BT_container_div'] = 'Container DIV Type';
$lang['fielddef_BT_container_div_help'] = 'These are CMSMS core backend css styles';
$lang['fielddef_BT_container_text'] = 'Text';
$lang['fielddef_BT_container_text_help'] = 'The text to display on the backend';
$lang['fielddef_BT_information'] = 'Information';
$lang['fielddef_BT_warning'] = 'Warning';

# FEUDropdown
$lang['fielddef_FEUDropdown'] = 'FrontEndUsers Dropdown';
$lang['fielddef_feu_options'] = 'FEU Groups';
$lang['fielddef_feu_dropdown_help'] = 'Please select one of available FrontEndUsers Groups';

# GalleryDropdown
$lang['fielddef_GalleryDropdown'] = 'Gallery Dropdown';

# GBFilePicker
$lang['fielddef_GBFilePicker'] = 'GBFilePicker Upload File';
$lang['fielddef_GBFilePicker_filebrowser'] = 'Enable Filebrowser';
$lang['fielddef_GBFilePicker_image'] = 'Expected to be image';
$lang['fielddef_GBFilePicker_create_dirs'] = 'Allow directory creation';
$lang['fielddef_GBFilePicker_delete'] = 'Allow delete';
$lang['fielddef_GBFilePicker_show_subdirs'] = 'Allow sub directories';

$lang['fielddef_GBFP_allow_help'] = 'Specify a comma separated list of file extensions that are allowed. For example: pdf,gif,jpeg,jpg (keep lowercase)';
$lang['fielddef_GBFP_dir_help'] = 'Directory path that will be appended to $config[\'uploads_url\'] . No slash at the end.';
$lang['fielddef_GBFP_exclude_prefix_help'] = 'Specify comma separated list of prefixes to exclude files that starts with the set prefix. For example: thumb_, foo_';
$lang['fielddef_GBFP_filebrowser_help'] = 'By default a dropdown will be used. Enable filebrowser if user may browse the files.';
$lang['fielddef_GBFP_media_type_help'] = 'Allows you to specify images as media type to be displayed. By default all files will be shown.';
$lang['fielddef_GBFP_delete_help'] = 'If enabled you can grant deleting files or directories for this field even to users without appropriate permission.';
$lang['fielddef_GBFP_create_dirs_help'] = 'If enabled you can grant creation of directories for this field even to users without appropriate permission.';
$lang['fielddef_GBFP_show_subdirs_help'] = 'If enabled user may browse subdirectories.';

# JMFilePicker
$lang['fielddef_JMFilePicker'] = 'JMFilePicker Upload File';
$lang['fielddef_JMFilePicker_filebrowser'] = 'Enable Filebrowser';
$lang['fielddef_JMFilePicker_image'] = 'Expected to be image';
$lang['fielddef_JMFilePicker_create_dirs'] = 'Allow directory creation';
$lang['fielddef_JMFilePicker_delete'] = 'Allow delete';
$lang['fielddef_JMFilePicker_show_subdirs'] = 'Allow sub directories';

$lang['fielddef_JMFP_allow_help'] = 'Specify a comma separated list of file extensions that are allowed. For example: pdf,gif,jpeg,jpg (keep lowercase)';
$lang['fielddef_JMFP_dir_help'] = 'Directory path that will be appended to $config[\'uploads_url\'] . No slash at the end.';
$lang['fielddef_JMFP_exclude_prefix_help'] = 'Specify comma separated list of prefixes to exclude files that starts with the set prefix. For example: thumb_, foo_';
$lang['fielddef_JMFP_filebrowser_help'] = 'By default a dropdown will be used. Enable filebrowser if user may browse the files.';
$lang['fielddef_JMFP_media_type_help'] = 'Allows you to specify images as media type to be displayed. By default all files will be shown.';
$lang['fielddef_JMFP_delete_help'] = 'If enabled you can grant deleting files or directories for this field even to users without appropriate permission.';
$lang['fielddef_JMFP_create_dirs_help'] = 'If enabled you can grant creation of directories for this field even to users without appropriate permission.';
$lang['fielddef_JMFP_show_subdirs_help'] = 'If enabled user may browse subdirectories.';

# ColorPicker
$lang['fielddef_ColorPicker'] = 'Color Picker';

// CustomFromUDT
$lang['fielddef_CustomFromUDT'] = 'Custom Field From UDT';
$lang['fielddef_type'] = 'Type';
$lang['fielddef_type_help'] = 'Select the type of this field';
$lang['fielddef_source_udt'] = 'Source UDT';
$lang['fielddef_source_UDT_help'] = 'Select the source UDT';
$lang['fielddef_validation_udt'] = 'Validation UDT';
$lang['fielddef_validation_UDT_help'] = 'Select the validation UDT (optional)';
$lang['fielddef_render_for_admin_listing_udt'] = 'Select the Administrator Listing UDT';
$lang['fielddef_render_for_admin_listing_UDT_help'] = 'Select the validation UDT (optional)';

// LISEInstance
$lang['fielddef_LISEInstance'] = 'LISE Instance';

// LISEInstanceItem
$lang['fielddef_LISEInstanceItem'] = 'LISE Instance Item';
$lang['fielddef_instance_help'] = 'Select instance';
$lang['fielddef_identifier_help'] = 'Select database identifier';
$lang['instance'] = 'Instance';
$lang['identifier'] = 'Identifier';


//FEUMultiSelect
$lang['fielddef_FEUMultiSelect'] = 'FEU Multi Select';
$lang['fielddef_JQueryMultiSelect'] = 'JQuery MultiSelect';
$lang['fielddef_feu_multiselect_help'] = 'Please select one or more of the available FrontEndUsers Groups';
$lang['fielddef_feu_fields_help'] = 'Please select the custom field from FEU from which to draw the values that will be shown on the select field.<br>Note that the selected field should have unique values across all FEU users entries.';
$lang['fielddef_feu_fields'] = 'Select 1st FEU Field';
$lang['fielddef_feu_fields2'] = 'Select 2nd FEU Field';
$lang['fielddef_users'] = 'Users';
$lang['fielddef_use_username'] = 'Use Username Field';
$lang['fielddef_use_uid'] = 'Prepend User ID';
$lang['fielddef_use_uid_help'] = 'Prepend user id to the options in [n] format.';
$lang['fielddef_use_username_help'] = 'If you check this option, the custom fields below will not be used.';
$lang['fielddef_separator_chr'] = 'Separator Character';
$lang['fielddef_separator_chr_help'] = 'Character used to separate field 1 and field 2 on the options text. Default is a space character.';

//FEUSingleSelect
$lang['fielddef_FEUSingleSelect'] = 'FEU Single Select';

//Core FilePicker
$lang['fielddef_CoreFilePicker'] = 'File Picker';
$lang['fielddef_core_fp_profiles'] = 'Profile';
$lang['fielddef_core_fp_profiles_help'] = 'Choose a File Picker profile. It must exist! Choosing none or a non existing one will reset to default profile or default values.';

/* Instructions */
$lang['fielddef_allow_help'] = 'Specify a comma separated list of file extensions that are allowed. For example: pdf,gif,jpeg,jpg (keep lowercase)';
$lang['fielddef_dir_help'] = 'Directory path that will be appended to $config[\'uploads_url\'] . No slash at the end. {$item_id} and {$field_id} will be replaced.';
$lang['fielddef_exclude_prefix_help'] = 'Specify a comma separated list of prefixes to exclude files that start with those prefixes. For example: thumb_, foo_';
$lang['fielddef_multioptions_help'] = 'Options separated by line breaks. Values can be separated from text with a = character. For example: Banana=banana';
$lang['fielddef_separator_help'] = 'Can be empty, single character or HTML entity.';
$lang['fielddef_size_help'] = 'Specify size of input field. For example: 20';
$lang['fielddef_max_length_help'] = 'Specify maximum length of the field. For example: 255';
$lang['fielddef_date_format_help'] = 'Specify date format used by jQuery Datepicker. Try <em>googling<\em> \'jquery formatDate\'. For example: dd-mm-yy';
$lang['fielddef_format_type_help'] = 'Specify output format for this field.';
$lang['fielddef_show_seconds_help'] = 'Specify whether the seconds scroller should be shown. NOTICE, second scroller has no effect if time format is wrong. Try HH:mm:ss';
$lang['fielddef_time_format_help'] = 'Specify date format used by jQuery timepicker. Try googling \'jquery formatTime\'. For example: HH:mm';
$lang['fielddef_wysiwyg_help'] = 'If checked, a WYSIWYG Editor will be enabled for this field.';
$lang['fielddef_min_value_help'] = 'Specify minimum value for this field.';
$lang['fielddef_max_value_help'] = 'Specify maximum value for this field.';
$lang['fielddef_increment_by_help'] = 'Increment slider values , commonly a dividend of the slider\'s maximum value. The default increment is 1.';
$lang['fielddef_width_help'] = 'Specify width of element. Can be a percentage or pixel value. This is used as the CSS value.';
$lang['fielddef_subtype_help'] = 'Select Sub Type for this field to determine its behavior.';
$lang['fielddef_showall_help'] = 'Show all, regardless of system permissions.';
$lang['fielddef_columns_help'] = 'Number of columns. Divide this field into multiple columns for a better user experience.';
$lang['fielddef_media_type_help'] = 'Allows you to specify images as media type to be displayed. By default all files will be shown.';
$lang['fielddef_enable_jqui_help'] = 'Enhances standard form elements to themeable buttons with appropriate hover and active styles.';

// category
$lang['reorder_categories'] = 'Reorder Categories';
$lang['edit_category'] = 'Edit Category';
$lang['category_name'] = 'Category name';
$lang['category_description'] = 'Category Description';
$lang['category_name_empty'] = 'Category name is empty';
$lang['category_alias_exists'] = 'Category alias already exists. Alias must be unique.';

// templates
$lang['archivetemplate'] = 'Archive Template';
$lang['archivetemplates'] = 'Archive Templates';
$lang['categorytemplate'] = 'Category Template';
$lang['categorytemplates'] = 'Category Templates';
$lang['summarytemplate'] = 'Summary Template';
$lang['summarytemplates'] = 'Summary Templates';
$lang['detailtemplate'] = 'Detail Template';
$lang['detailtemplates'] = 'Detail Templates';
$lang['searchtemplate'] = 'Search Template';
$lang['searchtemplates'] = 'Search Templates';
$lang['filtertemplate'] = 'Filter Template';
$lang['filtertemplates'] = 'Filter Templates';
$lang['edittemplate'] = 'Edit Template';
$lang['template_name'] = 'Template name';
$lang['template_name_empty'] = 'Template name is empty';
$lang['template_content_empty'] = 'Template content is empty';
$lang['default_templates'] = 'Default templates';

// options
$lang['module_options'] = 'Module Options';
$lang['url_options'] = 'URL Options';
$lang['default_options'] = 'Module defaults';
$lang['xmodule_options'] = 'Cross Module Options';
$lang['prompt_friendlyname'] = 'Module friendly name';
$lang['prompt_moddescription'] = 'Module Admin description';
$lang['prompt_adminsection'] = 'Module Admin Section';
$lang['items_options'] = 'Items Options';
$lang['prompt_item_singular'] = 'Item singular';
$lang['prompt_item_plural'] = 'Item plural';
$lang['prompt_url_prefix'] = 'URL Prefix';
$lang['prompt_url_template'] = 'URL Template';
$lang['prompt_display_inline'] = 'Display details inline (replaces module tag instead of {content})';
$lang['prompt_subcategory'] = 'Enable subcategory option, will show inherited items in category and its children';
$lang['prompt_item_cols'] = 'Display these fields in item overview';
$lang['prompt_items_per_page'] = 'Display items per page';
$lang['prompt_create_date'] = 'Display item created date in Item edit mode?';
$lang['prompt_detailpage'] = 'Detail page';
$lang['prompt_summarypage'] = 'Summary page';
$lang['prompt_reindex_search'] = 'Items searchable by Search module';
$lang['text_sortorder'] = 'Default Items sortorder';
$lang['options_notice'] = 'After changing module friendly name or Admin section, you may need to clear the cache for your changes to take effect.';
$lang['prompt_allow_autoscan'] = 'Allow system to scan field definitions automatically';
$lang['notice_allow_autoscan'] = 'Allowing automatic scan on ModuleInstalled, ModuleUpgraded, ModuleUninstalled and ContentPostCompile events, might have some strange behavior with some core versions.';
$lang['prompt_allow_autoinstall'] = 'Allow system to install instances automatically';
$lang['prompt_allow_autoupdate'] = 'Allow system to upgrade instances automatically when LISE is upgraded';
$lang['misc_options'] = 'Miscellaneous';
$lang['prompt_auto_upgrade'] = 'Allow system to upgrade this instance automatically when LISE is upgraded';

// instances
$lang['notice'] = 'Notice';
$lang['instances'] = 'Instances';
$lang['modules'] = 'Other Modules';
$lang['installed_instances_warning'] = 'Below is a list of duplicated module instances.<br />Make sure to backup your site (Database and Files) before "update" action';
$lang['clone_instances_warning'] = 'All settings will be copied except for permissions which will have to be set manually.';
$lang['installed_instances'] = 'Installed instances';
$lang['installed_modules'] = 'Installed modules';
$lang['duplicate_table'] = '(*) Require: Duplicate table cms_module_lise_instances = cms_module_lise_modules';
$lang['duplicate_button'] = 'Verify';
$lang['instance_name'] = 'Instance name';
$lang['instance_friendlyname'] = 'Friendly name';
$lang['instance_smarty'] = 'Smarty tag';
$lang['instance_version'] = 'Version';
$lang['instance_upgrade'] = 'Upgrade';
$lang['instance_uptodate'] = 'Up';
$lang['instance_moduleupgraded'] = 'Module upgraded';
//$lang['duplicate_instance'] = 'Duplicate module';
//$lang['duplicate_description'] = $module_name . ' can be easily duplicated to multiple module instances with duplicate button.<br /> Install newly copied module from "Extensions &raquo; Modules".';
$lang['copy_title'] = 'Duplicate module';
$lang['import_from_LI2_title'] = 'Import Instances From LI2';
$lang['prompt_import_from_LI2'] = 'Import from existing LI2 instances';
$lang['button_import_from_LI2'] = 'Import!';
$lang['fix_import_from_LI2_title'] = 'Fix ListIt2 Imported Tables';
$lang['fix_LI2_instances_warning'] = 'Use only if you have problems with adding or editing items or field definitions on instances imported from ListIt2!';
$lang['prompt_fix_import_from_LI2'] = 'Try to fix tables imported from LI2 instances';
$lang['button_fix_import_from_LI2'] = 'Fix!';

// global
$lang['submit'] = 'Submit';
$lang['default'] = 'Default';
$lang['cancel'] = 'Cancel';
$lang['update'] = 'Update';
$lang['repair'] = 'Repair';
$lang['save_create'] = 'Save &amp; Create';
$lang['reset'] = 'Reset Default';
$lang['duplicate'] = 'Create instance';
$lang['changessaved'] = 'Your changes have been successfully saved.';
$lang['changessaved_create'] = 'Your previous item has been successfully saved. Create new item?';
$lang['templaterestored'] = 'Default Template has been restored.';
$lang['areyousure'] = 'Are you sure you want to delete?';
$lang['up'] = 'Up';
$lang['down'] = 'Down';
$lang['edit'] = 'Edit';
$lang['copy'] = 'Copy';
$lang['delete'] = 'Delete';
$lang['nosuchid'] = 'No such ID';
$lang['deleted'] = 'The item(s) have been successfully deleted.';
$lang['add'] = 'Add %s';
$lang['import'] = 'Import %s';
$lang['export'] = 'Export %s';
$lang['clone'] = 'Clone %s';
$lang['export_title'] = 'Export';
$lang['import_title'] = 'Import';
$lang['clone_title'] = 'Clone';
$lang['alias'] = 'Alias';
$lang['alias_duplicate'] = 'Alias is invalid. Each alias must be unique';
$lang['alias_invalid'] = 'Alias is invalid. It must start with a letter and only include letters, numbers and underscores';
$lang['search'] = 'Search';
$lang['searchfor'] = 'Search for';
$lang['searchresultsfor'] = 'Search results for';
$lang['firstpage'] = '&lt;&lt;';
$lang['prevpage'] = '&lt;';
$lang['nextpage'] = '&gt;';
$lang['lastpage'] = '&gt;&gt;';
$lang['module_name'] = 'Module name';
$lang['module_name_empty'] = 'Module name is empty';
$lang['module_name_invalid'] = 'Module name contains invalid characters';
$lang['modulecopied'] = 'Module copied successfully';
$lang['select_one'] = 'Select One';
$lang['size'] = 'Size';
$lang['max_length'] = 'Max Length';
$lang['wysiwyg'] = 'WYSIWYG';
$lang['date_format'] = 'Date Format';
$lang['time_format'] = 'Time Format';
$lang['format_type'] = 'Format Type';
$lang['dir'] = 'Directory';
$lang['allowed'] = 'Allowed';
$lang['exclude_prefix'] = 'Exclude prefix';
$lang['image'] = 'Image';
$lang['file'] = 'File';
$lang['required'] = 'Required';
$lang['ascending'] = 'Ascending';
$lang['descending'] = 'Descending';
$lang['extra'] = 'Extra';
$lang['combined'] = 'Combined';
$lang['show_seconds'] = 'Show Seconds';
$lang['value'] = 'Value';
$lang['width'] = 'Width';
$lang['min_value'] = 'Minimum Value';
$lang['max_value'] = 'Maximum Value';
$lang['increment_by'] = 'Increment by';
$lang['subtype'] = 'Sub Type';
$lang['showall'] = 'Show All';
$lang['columns'] = 'Columns';
$lang['owner'] = 'Owner';
$lang['untitled'] = 'untitled';

// csv import/export
$lang['filename'] = 'File name';
$lang['enclosure'] = 'Enclosure';
$lang['separator'] = 'Separator';
$lang['values'] = 'Values';
$lang['import_alias'] = 'Item/Fielddef alias';
$lang['file_alias'] = 'File header/alias';

// errors
$lang['error_optionrequired'] = 'Option %s is required';
$lang['error_bad_extension'] = 'File you trying to upload has bad extension';
$lang['error_file_permissions'] = 'There was problem with file permissions';
$lang['error_file_empty'] = 'No file given';
$lang['error_file_nocsv'] = 'File is not CSV file';

// filter
$lang['filter'] = 'Filter';
$lang['filterprompt'] = 'Filter %s';
$lang['param_filter_missing'] = 'Parameter <em>filter</em> is required in filter mode.';
$lang['all'] = 'All';

// Event descriptions
$lang['eventdesc_PreItemSave'] = 'Sent before item save process begins. Possible to manipulate item object data.';
$lang['eventdesc_PostItemSave'] = 'Sent after item save process has completed. Possible to manipulate item object data.';
$lang['eventdesc_PreItemDelete'] = 'Sent before item delete process begins. Possible to manipulate item object data.';
$lang['eventdesc_PostItemDelete'] = 'Sent after item delete process has completed. Possible to manipulate item object data.';
$lang['eventdesc_PreItemLoad'] = 'Sent before item load process begins. Possible to manipulate item object data.';
$lang['eventdesc_PostItemLoad'] = 'Sent after item load process has completed. Possible to manipulate item object data.';
$lang['eventdesc_PreRenderAction'] = 'Sent on action execute. Possible to manipulate item query data.';

#Event help
$lang['eventhelp_PreItemSave'] = "<p>".$lang['eventdesc_PreItemSave']."</p>
<h4>Parameters</h4>
<ul>
<li>'item_object' - Reference to affected item object.</li>
</ul>";

$lang['eventhelp_PostItemSave'] = "<p>".$lang['eventdesc_PostItemSave']."</p>
<h4>Parameters</h4>
<ul>
<li>'item_object' - Reference to affected item object.</li>
</ul>";

$lang['eventhelp_PreItemDelete'] = "<p>".$lang['eventdesc_PreItemDelete']."</p>
<h4>Parameters</h4>
<ul>
<li>'item_object' - Reference to affected item object.</li>
</ul>";

$lang['eventhelp_PostItemDelete'] = "<p>".$lang['eventdesc_PostItemDelete']."</p>
<h4>Parameters</h4>
<ul>
<li>'item_object' - Reference to affected item object.</li>
</ul>";

$lang['eventhelp_PreItemLoad'] = "<p>".$lang['eventdesc_PreItemLoad']."</p>
<h4>Parameters</h4>
<ul>
<li>'item_object' - Reference to affected item object.</li>
</ul>";

$lang['eventhelp_PostItemLoad'] = "<p>".$lang['eventdesc_PostItemLoad']."</p>
<h4>Parameters</h4>
<ul>
<li>'item_object' - Reference to affected item object.</li>
</ul>";

$lang['eventhelp_PreRenderAction'] = "<p>".$lang['eventdesc_PreRenderAction']."</p>
<h4>Parameters</h4>
<ul>
<li>'action_name' - Name of executed action.</li>
<li>'query_object' - Reference to affected query object.</li>
</ul>";

// module
$lang['moddescription'] = 'LISE allows you to create lists that you can display throughout your website.';
$lang['postinstall'] = $module_name . ' has successfully been installed';
$lang['postuninstall'] = $module_name . ' has successfully been uninstalled';
$lang['duplicated'] = 'Table has successfully been duplicated';
$lang['scan_moduled'] = 'Modules has successfully been scaned';
$lang['scan_modules'] = 'Scan Modules';

// module help
$lang['general'] = 'General';
$lang['usage'] = 'Usage';
$lang['permissions'] = 'Permissions';
$lang['duplicating'] = 'Creating Instances';
$lang['upgrading'] = 'Upgrading';
$lang['importing'] = 'Importing From ListItExtended Installations';
$lang['smarty_plugins'] = 'Smarty plugins';
//$lang['about'] = 'About';
$lang['upgrade_from'] = 'Upgrading from';
$lang['importing_from_li2'] = 'Importing From LI2 Instances';
$lang['team'] = 'Team';
//$lang['contributors'] = 'Contributors';

$lang['help_general'] = '<h3>General Info</h3>
    <p>Simply put, LISE allows you to create lists that you can display throughout your website. You can make a simple FAQ or Testimonials feature with this module. The web developer can define fields to constrain what data the client can enter. A number of field types can be specified - text input, checkbox, text area, select date, upload file, select file, dropdown - and additional instructions can be set for each type, for example, input field size, max length, WYSIWYG editor, possible drop down values, possible file extensions, directory paths for file selections, date formats, etc..</p>
    <p>An important note of warning - This is not a content construction kit, such as in Drupal. It is meant for small listings, not to store thousands of records. This is because of the database model used (EAV). Also, each bit of data you enter is stored as TEXT data type, regardless of whether it is varchar, boolean, timestamp, etc.</p>
    <div class="red">You can import instances from ListItExtended. If you have it installed you will see a tab, <strong>Importing From ListItExtended Installations</strong>, with more help...</div>
    ';

$lang['help_usage'] = '<h3>Usage</h3>
    
    <p>You can configure {$module_name} here: Content &raquo; {$module_name}</p>
    <p>Place this tag in your page: {{$module_name}}</p><br />';

$lang['help_usage_options'] = 'After installing the module the next thing to do is set the options.
    <ol>
        <li>To change the name of the module in the menu change the "Module Friendly Name".</li>
        <li>To change the name of the item tab change the "Item Plural".</li>
    </ol>';

$lang['help_usage_fielddefs'] = 'Next - set the Field Definitions.
    <ol>
        <li>Choose from "Text Input", "Checkbox", "Text Area", "Select Date", "Select File", "Content Pages"  &amp; "Dropdown".</li>
        <li>For each field definition, you can specify or choose additional settings<br /> from available options which depend on field definition type.</li>
        <li>Each item in each list has three default fields. <br />All Field Definitions set here are additional to them.</li>
    </ol>';

$lang['help_usage_categories'] = 'To be able to use Categories with your LISE instance you will have to create a
	 Field definition with type of "Category".<br /> Once a Field definition was create new Tab with name "Categories" will become available in your LISE module instance.<br />
	 Now you can start adding categories.';

$lang['help_usage_items'] = 'Now we move on to the item list itself. In this example it says "Add Box", this was renamed in the "Options" tab.
    <ol>
        <li>The first field is the default "Title" field.</li>
        <li>The "Category" dropdown is also a default field, and if unchanged, will be set to "General".</li>
        <li>The third default field is the checkbox called "Active". This allows you to toggle a list entry without deleting it.</li>
    </ol>';

$lang['help_permissions'] = '<h3>Permissions</h3>
    <p>You can specify the following permissions under Users &amp; Groups &rarr; Group Permissions</p>
    <ul>
        <li>{$module_name}: Modify Items</li>
        <li>{$module_name}: Modify all items</li>
        <li>{$module_name}: Remove items</li>
        <li>{$module_name}: Approve items</li>
        <li>{$module_name}: Modify Categories</li>
        <li>{$module_name}: Modify Options</li>
    </ul>
    <p>To allow non-admin users to upload files, please go to Extensions > GBFilePicker and tick that first checkbox "Show filemanagement options".</p>';

$lang['help_fielddefs'] = '<h3>Field Definitions</h3>
    <p>The first thing you should configure are your field definitions.</p>
    <p>For each field definition, you can specify additional settings by choosing from available options.</p>
    
    <h3>Default Field Definitions by type</h3>
    <ul>
      <li>BackendText - <strong>Backend Text</strong>;</li>
      <li>Categories - <strong>Categories</strong>;</li>
      <li>Checkbox - <strong>Checkbox</strong>;</li>
      <li>CheckboxGroup - <strong>Checkbox Group</strong>;</li>
      <li>ColorPicker - <strong>ColorPicker</strong>;</li>
      <li>ContentPages - <strong>Content Pages</strong>;</li>
      <li>CoreFilePicker - <strong>File Picker (1) <span style="color:green">(new)</span></strong>;</li>
      <li>CustomFromUDT - <strong>Custom Field From UDT</strong>;</li>
      <li>Dropdown - <strong>Dropdown</strong>;</li>
      <li>FEUDropdown - <strong>FrontEndUsers Dropdown (2)(6) <span style="color:orange">(deprecated)</span></strong>;</li>
      <li>FEUMultiSelect - <strong>FEU Multi Select (2)</strong>;</li>
      <li>FEUSingleSelect - <strong>FEU Single Select (2)</strong>;</li>
      <li>FileUpload - <strong>File Upload</strong>;</li>
      <li>GalleryDropdown - <strong>Gallery Dropdown (3)</strong>;</li>
      <li>GBFilePicker - <strong>GBFilePicker Upload File (4)(6) <span style="color:orange">(deprecated)</span></strong>;</li>
      <li>JMFilePicker - <strong>JMFilePicker Upload File (5)</strong>;</li>
      <li>JQueryMultiSelect - <strong>JQuery MultiSelect</strong>;</li>
      <li>LISEInstance - <strong>LISE Instance</strong>;</li>
      <li>LISEInstanceItem - <strong>LISE Instance Item</strong>;</li>
      <li>MultiSelect - <strong>Multi Select</strong>;</li>
      <li>RadioGroup - <strong>Radio Group</strong>;</li>
      <li>SelectDateTime - <strong>Select DateTime</strong>;</li>
      <li>SelectFile - <strong>Select File</strong>;</li>
      <li>Slider - <strong>Slider</strong>;</li>
      <li>Tabs - <strong>Tabs</strong>;</li>
      <li>Tags - <strong>Tags</strong>;</li>
      <li>TextArea - <strong>Text Area</strong>;</li>
      <li>TextInput - <strong>Text Input</strong>;</li>
    </ul>
    <div class="information"><strong>Note: this list does not include additional field definitions that may be registered by external modules.</strong></div>
    <div class="information"><strong>Note: after upgrading LISE or installing a module which could register additional field definitions, re-scan field definitions for them to appear on the list of available field definitions.</strong></div>
    <p>(1) Has dependencies: <strong>File Picker (core)</strong>;</p>
    <p>(2) Has dependencies: <strong>FrontEndUser</strong>s and <strong>CGExtensions</strong>;</p>
    <p>(3) Has dependencies: <strong>Gallery</strong>;</p>
    <p>(4) Has dependencies: <strong>GBFilePicker</strong>. <em>Note: It only works with CMSMS 1.x branch</em>;</p>
    <p>(5) Has dependencies: <strong>JMFilePicker</strong>.</p>
    <p>(6) Deprecated: <strong>will be removed in a near future, use the replacements ASAP</strong>.</p>
    ';

$lang['help_importing_from_li2'] = '
    <div class="red">
      <ul>
        <li>
          This tab will only be visible if there is a valid ListItExtended installation on the current site.
        </li>
        <li>
          <strong>Make sure you create a full backup or your site and database before taking any further actions.</strong>
        </li>
      </ul>
    </div>
    <h4>Step One</h4>
    <p>If there are valid ListItExtended instances on the system LISE will be able to detect them and there will appear a button on LISE master module, under the Maintenance tab inside Import Instances From LI2 form. This import button should make a copy of all currently installed LI2 instances, without changing the original ones. However, at this point LISE will not copy the users permissions from LI2, given the lack of a CMSMS Core API to do so. That should be done manually.</p>
    <p>Templates may have to be adjusted to work with LISE.</p>
    <h4>Step Two</h4>
    <p>After you are satisfied with the LISE instance copies you will need to change the calling tags from <strong>{ListIt2&lsaquo;instance_name&rsaquo;}</strong> to <strong>{LISE&lsaquo;instance_name&rsaquo;}</strong> on every template where they are being called.</p>
    <h4>Step Three</h4>
    Ideally your Field definitions should work again, if that is not the case you should try to repair Field definitions database table by clicking on "Repair" button under "Maintenance" tab.</p><br />
    <p><strong>If you have followed above steps, you should now have a fully functional and upgraded LISE Module and all created Instances.</strong></p>
    <p><strong>After this point you should be able to uninstall LI2 Instances and ListItExtended itself (make sure you keep a full backup just in case).</strong></p>';

$lang['help_categories'] = '
	<h3>Categories</h3>
    <p>Categories are part of Field definitions and disabled by default.<br />
    If you need Categories with this instance you will have to create a new Field definition of type "Category".<br />
    Once a Field definition was created, a news tab named "Categories" will become available in module Instance.</p>
    <p>Categories support multiple levels and created Items may belong to multiple categories, depending on your selected options while creating Category Field defintion.</p><br />
    <p>There are two sample templates included to demonstrate how categories within LISE Module instance work, this should give you a starting idea on how to create your personalizied and custom<br />
    Templates for your next project.</p>
    <h4>Using Categories</h4>
    <p>For detailed usage and available parameters, have a look below at "Parameters" Help section</p>
    <pre><code>{{$module_name} action=\'category\'}</code></pre>';

$lang['help_templates'] = '<h3>Templates</h3>
    <p>If you are not sure what variables are available to use in your templates, try debugging:</p>
    <p>{{$module_name} debug=1}</p>
    <p>You can access any field directly when looping through items using its alias, for example, to if you created a field definition with an alias "position", you can do one of the following:</p>';

$lang['help_duplicating'] = '<h3>Creating Module Instances</h3>
    <p>This module is a Control Panel for creating LISE Module Instances. To create a LISE module Instance, simply go to "Instances" tab and click on "Create Instance" button.<br />
    Make sure you follow the CMSMS module naming conventions, a-z with no punctuation characters or spaces to be safe :)<br />
    You can set the instance <strong>Friendly Name</strong>, <strong>Module Admin Description</strong> and <strong>Module Admin Section</strong> on the <strong>Create Instance</strong> form.<br />
    After the module has been created a new instance will be installed and listed in original LISE module under "Instances" tab.</p><br />
    <p>You can always change the module friendly name once installed under "Options" (Content &raquo; LISENameOfDuplicate).<br />
    To change the icon, replace /modules/LISENameOfDuplicate/images/icon.gif.<br />
    To change Admin section of the module, simply select appropriate section from Dropdown. Make sure you clear the cache after these changes.</p>';


$lang['help_smarty_plugins'] = '
	<h4>What does this do?</h4>
	 <p>This plugin allows you to load LISE item and category object by certain criteria, anywhere in the system.</p>
	 
	<h4>How do I use it?</h4>
	<p>Simply insert this tag into your page or template:</p>
	<pre><code>{LISELoader item=\'item\' identifier=\'alias\' instance=\'LISEInstance\' value=\'myalias\' assign=\'tmp\'}</code></pre>
	
	<p>&nbsp;</p>
	
	<p>Following line will load item object from instance \'LISEInstance\' by alias \'myalias\' and assign it to variable &dollar;tmp. <br />
	After this you can use it in similar way, just like in regular LISE templates:</p>
	<pre><code>{&dollar;tmp->title}</code></pre>
	
	<p>&nbsp;</p>
	
	<p>If multiple items are being loaded, this function returns array of objects, else it returns single item/category object</p>

	<h4>What parameters does it take?</h4>
	<ul>
		<li><em>(required) </em><tt>instance</tt> - Name of instance that holds items. <i>(If used inside LISE templates, this parameter is optional)</i></li>
		<li><em>(required) </em><tt>value</tt> - Comma separated list of identifier values: \'alias1,alias2,alias3\' or \'1,2,3\'</li>
		<li><em>(optional) </em><tt>item="item"</tt> - Wanted item type, either: item/category</li>
		<li><em>(optional) </em><tt>identifier="item_id/category_id"</tt> - Wanted identifier, one of following: item_id, category_id, alias</li>
		<li><em>(optional) </em><tt>force_array="false"</tt> - Force output value as array</li>
	</ul>
';

$lang['help_param_action'] = '
    Override the default action. Possible values are:
    <ul>
        <li>&quot;default&quot; - displays the summary view.</li>
        <li>&quot;detail&quot; - displays a specified entry in detail mode.</li>
        <li>&quot;search&quot; - displays the search form. Optional parameters that affect to this action only: <em>filter.</em></li>
        <li>&quot;category&quot; - displays the categories. Optional parameters that affect to this action only: <em>show_items, collapse, number_of_levels.</em></li>
        <li>&quot;archive&quot; - displays the archives. </li>
    </ul>';
$lang['help_param_showall'] = 'Show all items, irrespective of end date.';
$lang['help_param_category'] = 'Specify an alias or comma separated aliases of the category/categories displayed items must be a member of.';
$lang['help_param_exclude_category'] = 'Specify an alias or comma separated aliases of the category/categories displayed items must not be a member of.';
$lang['help_param_subcategory'] = 'If parameter \'category\' is specified, this parameter set to <em>true</em> will make allowance for subcategories\' items. It is set to false by default.';
$lang['help_param_detailtemplate'] = 'The detail template you wish to use.';
$lang['help_param_summarytemplate'] = 'The summary template you wish to use.';
$lang['help_param_searchtemplate'] = 'The search template you wish to use.';
$lang['help_param_categorytemplate'] = 'The category template you wish to use.';
$lang['help_param_orderby'] = 'You can order by any of the following columns: item_id, item_title, item_position, item_created, category_id, category_name, category_position, category_hierarchy, rand and also by custom fields with custom_* (* would be field definition alias).
<p>For example:</p>
    <ul>
        <li>orderby=\'category_name, item_title\'</li>
        <li>
          <p>With fielddef values:</p>
          orderby=\'custom_[fielddef alias]\'
        </li>
        <li>
          <p>You can also specify ascending or descending for any column, for example:</p>
          orderby=\'category_name|ASC, item_title|DESC\'
        </li>
    </ul>';
$lang['help_param_pagelimit'] = 'Maximum number of items to display (per page).  If this parameter is not supplied all matching items will be displayed.  If it is, and there are more items available than specified in the parameter, text and links will be supplied to allow scrolling through the results';
$lang['help_param_start'] = 'Start at the nth item -- leaving empty will start at the first item.';
$lang['help_param_number'] = 'Maximum number of items to display (per page) -- leaving empty will show all items. This is a synonym for the pagelimit parameter.';
$lang['help_param_detailpage'] = 'Page to display item details in. Must be a page alias/id. Used to allow details to be displayed in a different page than summary.';
$lang['help_param_summarypage'] = 'Page to display item summary in. Must be a page alias/id. Used to allow summaries to be displayed in a different page than initiator.';
$lang['help_param_item'] = 'This parameter is only applicable to the detail view. It allows specifying which item to display in detail mode. Must be an item alias.';
$lang['help_param_search'] = 'Search all fields. Uses <strong>fulltext</strong> search. Can be combined with filter search.';
$lang['help_param_search_'] = 'Search a particular field. You can use \'title\' or the alias of a field definition, e.g. search_title. Can be combined with fulltext search. Multiple search_* params can be combined.';
$lang['help_param_filter'] = 'Applies only to action: <em>search</em>. Specify the fields whose values should be offered as filter options by listing the field\'s aliases comma separated.';
$lang['help_param_filter_order_by'] = 'When filtering in a search action you can order by any of the following columns: value, item_id, alias, title, position, create_time and modified_time.
<p>The use is similar to the one used in the <em>orderby</em> parameter. Also for this to have any effect, the <em>filter</em> parameter is required.</p>
<p>There order of the comma separated list of filter aliases is used to determnine the order by which the <em>filterorderby</em> is applied.</p>
<p>For example:</p>
    <ul>
      <li>filter=\'[fielddef alias]\' filterorderby=\'value|ASC\' (default behaviour so <em>filterorderby</em> can be omited in this case)</li>
      <li>
        <p>With multiple aliases to sort differently:</p>
        <p>filter=\'[fielddef alias],[another fielddef alias]\' filterorderby=\'title,value|DESC\' (ASC is default so can be ommited)</p>
        <p>This will sort the filter dropdowns or multiselect fields by title ASC and by value DESC respectively</p>
      </li>
    </ul>';
//$lang['help_param_returnpage'] = 'Used for filter or search mode only. Page to display search results respectivly filtered items in. Must be a page alias. Used to allow summary to be displayed in a different page than filter / search mask.';
$lang['help_param_debug'] = 'Enables debug mode, printing out all the objects, arrays, variables available for current action.';
$lang['help_param_collapse'] = 'Applies only to action: <em>category</em>. Toggle collapse categories.';
$lang['help_param_show_items'] = 'Applies only to action: <em>category</em>. Append items to category tree.';
$lang['help_param_number_of_levels'] = 'Applies only to action: <em>category</em>. Number of of category levels to show.';
$lang['help_param_include_items'] = 'Specify an id/alias or comma separated ids/aliases of the items you want to display.';
$lang['help_param_exclude_items'] = 'Specify an id/alias or comma separated ids/aliases of the items you want to exclude from list.';
$lang['help_param_year'] = 'Filter items by year.';
$lang['help_param_month'] = 'Filter items by month.';

// this is for importing from LI2
$lang['importing_warning'] = '<h3>Important Information</h3>
    <p><strong>Read this carefully!</strong></p>
    <p>You need to have a ListItExtended installation updated up to it\'s latest known version (1.4.1).<br />
    Don\'t attempt to import ListItExtended instances without upgrading as it may result in incomplete LISE instances.</p>';

// errors and exceptions
// Note: keep placeholders in the same number as you find them in each line when translating
$lang['00000'] = '%s: Unknown LISE error!';
$lang['00001'] = '%s: Discrete LISE error: %s!';
$lang['00002'] = '%s: Discrete LISE Database error: %s!';
$lang['00010'] = '%s: Attempt to write to configuration; LISE configuration variables are READ ONLY!';
?>