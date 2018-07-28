<?php
#CMS - CMS Made Simple
#(c)2004 by Ted Kulp (ted@cmsmadesimple.org)
#Visit our homepage at: http://www.cmsmadesimple.org
#
#This program is free software; you can redistribute it and/or modify
#it under the terms of the GNU General Public License as published by
#the Free Software Foundation; either version 2 of the License, or
#(at your option) any later version.
#
#This program is distributed in the hope that it will be useful,
#but WITHOUT ANY WARRANTY; without even the implied warranty of
#MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#GNU General Public License for more details.
#You should have received a copy of the GNU General Public License
#along with this program; if not, write to the Free Software
#Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
#
if( !isset($gCms) ) exit;


$db = $this->GetDb();



// Profiles *******************************
$dict = NewDataDictionary($db);
$flds = "
	id_profile I KEY AUTO,
	id_template I,
	name C(255),
	priority I,
	resize C(20),
	autoresize I,
	plugins X,
	enable_linker I,
	show_menubar I,
	menubar C(255),
	use_advanced_menu I,
	advanced_menu X,
	show_toolbar I,
	toolbar1 X,
	toolbar2 X,
	enable_contextmenu I,
	contextmenu X,
	show_statusbar I,
	id_design I,
	link_classes X,
	image_classes X,
	style_formats X,
	use_custom_block_formats I,
	block_formats C(255),
	enable_user_templates I,
	enable_custom_dropdown I,
	custom_dropdown_title C(100),
	custom_dropdown X,
	extra_js X,
	external_modules X,
	external_modules_show_menutext I,
	filemanager_use I,
	filemanager_delete_files I,
	filemanager_create_folders I,
	filemanager_delete_folders I,
	filemanager_upload_files I,
	filemanager_rename_files I,
	filemanager_rename_folders I,
	filemanager_duplicate_files I,
	filemanager_copy_cut_files I,
	filemanager_copy_cut_dirs I,
	filemanager_chmod_files I,
	filemanager_chmod_dirs I,
	filemanager_preview_text_files I,
	filemanager_create_text_files I,
	filemanager_edit_text_files I,
	filemanager_image_resizing I,
	filemanager_image_resizing_width I,
	filemanager_image_resizing_height I,
	filemanager_aviary_active I,
	filemanager_aviary_apiKey C(60),
	forced_root_block I,
	relative_urls I,
	image_advtab I
";
$taboptarray = array('mysql' => 'TYPE=MyISAM');
$sqlarray = $dict->CreateTableSQL(CMS_DB_PREFIX.TinyMCE::TINYMCE_PROFILES_TABLE, $flds, $taboptarray);
$dict->ExecuteSQLArray($sqlarray);


// Profile_group **************************
$flds = "
	id_profile I KEY,
	id_group I KEY
";
$taboptarray = array('mysql' => 'TYPE=MyISAM');
$sqlarray = $dict->CreateTableSQL(CMS_DB_PREFIX.TinyMCE::TINYMCE_PROFILEGROUP_TABLE, $flds, $taboptarray);
$dict->ExecuteSQLArray($sqlarray);







// CREATE TEMPLATE TYPES

// JS
try {
	$js_template_type = new CmsLayoutTemplateType();
	$js_template_type->set_originator($this->GetName());
	$js_template_type->set_dflt_flag(true);
	$js_template_type->set_lang_callback('TinyMCE::page_type_lang_callback');
	$js_template_type->set_content_callback('TinyMCE::reset_page_type_defaults');
	$js_template_type->set_name('js');
	$js_template_type->set_description($this->Lang('type_js_description'));
	$js_template_type->reset_content_to_factory();
	$js_template_type->save();
}
catch (CmsException $e) {
	// log it
	debug_to_log(__FILE__.':'.__LINE__.' '.$e->GetMessage());
	audit('',$this->GetName(),'Installation Error: '.$e->GetMessage());
}



// TINYMCETEMPLATE ; for the template plugin
try {
	$tinytpl_template_type = new CmsLayoutTemplateType();
	$tinytpl_template_type->set_originator($this->GetName());
	$tinytpl_template_type->set_dflt_flag(true);
	$tinytpl_template_type->set_lang_callback('TinyMCE::page_type_lang_callback');
	$tinytpl_template_type->set_content_callback('TinyMCE::reset_page_type_defaults');
	$tinytpl_template_type->set_name('usertemplate');
	$tinytpl_template_type->set_description($this->Lang('type_usertemplate_description'));
	$tinytpl_template_type->reset_content_to_factory();
	$tinytpl_template_type->save();
}
catch (CmsException $e) {
	// log it
	debug_to_log(__FILE__.':'.__LINE__.' '.$e->GetMessage());
	audit('',$this->GetName(),'Installation Error: '.$e->GetMessage());
}








// CREATE SAMPLE / DEFAULT TEMPLATES
/*$uid = get_userid();
try {
	$fn = dirname(__FILE__).DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'orig_js_template.tpl';
	if( file_exists( $fn ) ) {
    $template = @file_get_contents($fn);
    $sample_tpl = new CmsLayoutTemplate();
    $sample_tpl->set_name('TinyMCE default Javascript');
    $sample_tpl->set_owner($uid);
    $sample_tpl->set_content($template);
    $sample_tpl->set_type($js_template_type);
    $sample_tpl->set_type_dflt(TRUE);
    $sample_tpl->save();
  }
}
catch( CmsException $e ) {
  // log it
  debug_to_log(__FILE__.':'.__LINE__.' '.$e->GetMessage());
  audit('',$this->GetName(),'Installation Error: '.$e->GetMessage());
}*/



// INITIAL PROFILES
// MINIMAL
$mini_profile = new tinymce_profile();
$mini_profile->name = $this->Lang('install_profile_minimal');;
$mini_profile->show_menubar = false;
$mini_profile->resize = false;
$mini_profile->toolbar1 = 'formatselect | bold italic underline | cmsms_linker link image';
$mini_profile->save();
$this->SetPreference('id_default_profile', $mini_profile->id_profile);

// ADVANCED
$advanced_profile = new tinymce_profile();
$advanced_profile->name = $this->Lang('install_profile_advanced');
$advanced_profile->save();



// PERMISSIONS
$this->CreatePermission('Manage TinyMCE profiles', 'Manage TinyMCE profiles');


// SALT FOR ACCESS KEY FOR RESPONSIVE FILE MANAGER
$this->SetPreference('filemanager_salt', substr(md5(rand()), 0, 10));


?>
