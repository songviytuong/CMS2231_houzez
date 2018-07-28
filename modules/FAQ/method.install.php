<?php
#-------------------------------------------------------------------------
# Module: FAQ
# Author: Jos (josvd@live.nl)
# Method: Install
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2008 by Ted Kulp (wishy@cmsmadesimple.org)
# This project's homepage is: http://www.cmsmadesimple.org
# The module's homepage is: http://dev.cmsmadesimple.org/projects/faq/
#-------------------------------------------------------------------------

if (!isset($gCms)) exit;

$db = cmsms()->GetDB();

$taboptarray = array( 'mysql' => 'ENGINE=MyISAM' );

$dict = NewDataDictionary( $db );

// create tables
$flds = "
	category_id I KEY AUTO,
	category C(255),
	alias C(255),
	lang C(5),
	sort I,
	active L
";

$sqlarray = $dict->CreateTableSQL(cms_db_prefix()."module_faq_categories", $flds, $taboptarray);
$dict->ExecuteSQLArray($sqlarray);

$flds = "
	entry_id I KEY AUTO,
	question X,
	answer X,
	active L
";

$sqlarray = $dict->CreateTableSQL(cms_db_prefix()."module_faq_entries", $flds, $taboptarray);
$dict->ExecuteSQLArray($sqlarray);

$flds = "
	category_id I,
	entry_id I,
	sort I
";

$sqlarray = $dict->CreateTableSQL(cms_db_prefix()."module_faq_catentries", $flds, $taboptarray);
$dict->ExecuteSQLArray($sqlarray);
$sqlarray = $dict->CreateIndexSQL(cms_db_prefix()."module_faq_categoryidx", cms_db_prefix()."module_faq_catentries", array("category_id","entry_id"), array("UNIQUE"));
$dict->ExecuteSQLArray($sqlarray);
$sqlarray = $dict->CreateIndexSQL(cms_db_prefix()."module_faq_entryidx", cms_db_prefix()."module_faq_catentries", "entry_id");
$dict->ExecuteSQLArray($sqlarray);


// create default Category
$query = "INSERT INTO ".cms_db_prefix()."module_faq_categories (
						category, 
						alias, 
						lang, 
						sort, 
						active) 
					VALUES
						(?,?,?,?,?)";
$result = $db->Execute($query, array(
						'General', 
						'general', 
						'', 
						1, 
						1));


// create a permission
$this->CreatePermission('FAQ: Use', 'FAQ: Use');
$this->CreatePermission('FAQ: Modify', 'FAQ: Modify');


// setup templates
$templates = array('summary_tpl_list', 'detail_tpl_entry');

foreach ( $templates as $template )
{
	$fn = cms_join_path(dirname(__FILE__), 'templates', $template . '.txt');
	if( file_exists($fn) )
	{
		$templatecode = @file_get_contents($fn);
		$this->SetTemplate($template, $templatecode);
		list($tpl_type, $tpl_name) = explode('_tpl_', $template, 2);
		$this->SetPreference('default_' . $tpl_type . '_template', $template);
	}
}


// setup sample stylesheet
$fn = cms_join_path(dirname(__FILE__), 'templates', 'stylesheet.css');
$txt = file_get_contents($fn);
if (version_compare(CMS_VERSION, '1.99-alpha0', '<'))
{
    $stylesheetops = cmsms()->GetStylesheetOperations();
    if( !$stylesheetops->CheckExistingStylesheetName('FAQ module') )
    {
        $stylesheet = new Stylesheet();
        $stylesheet->name = 'FAQ module';
        $stylesheet->value = $txt;
        $stylesheet->media_type = 'screen';
        $stylesheetops->InsertStylesheet($stylesheet);
    }
}
else
{
    $css = new CmsLayoutStylesheet;
    $css->set_name('FAQ module');
    $css->set_description('sample stylesheet for FAQ module');
    $css->set_content($txt);
    $css->save();
}

    
// create preferences
$this->SetPreference('custom_modulename', $this->Lang('friendlyname'));
$this->SetPreference('admin_section', 'content');
$this->SetPreference('use_question_wysiwyg',0);
$this->SetPreference('use_answer_wysiwyg',1);
$this->SetPreference('defaultcategory', 1);
$this->SetPreference('entries_page','');

// register events 
$this->CreateEvent('FAQ_entry_added');
$this->CreateEvent('FAQ_entry_edited');


$this->RegisterModulePlugin(TRUE);
/*
$route = new CmsRoute('/[Ff][Aa][Qq]\/(?P<alias>[0-9]+)-(?P<gbpage>[0-9]+)\/(?P<returnid>[0-9]+)$/', $this->GetName());
cms_route_manager::add_static($route);
$route = new CmsRoute('/[Ff][Aa][Qq]\/(?P<entryid>[0-9]+)\/(?P<returnid>[0-9]+)$/', $this->GetName());
cms_route_manager::add_static($route);
*/


?>