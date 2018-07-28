<?php
#-------------------------------------------------------------------------
# Module: FAQ
# Author: Jos (josvd@live.nl)
# Method: Uninstall
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2008 by Ted Kulp (wishy@cmsmadesimple.org)
# This project's homepage is: http://www.cmsmadesimple.org
# The module's homepage is: http://dev.cmsmadesimple.org/projects/faq/
#-------------------------------------------------------------------------

if (!isset($gCms)) exit;

$db = cmsms()->GetDB();

// remove the database tables
$dict = NewDataDictionary( $db );
$sqlarray = $dict->DropTableSQL( cms_db_prefix()."module_faq_catentries" );
$dict->ExecuteSQLArray($sqlarray);

$sqlarray = $dict->DropTableSQL( cms_db_prefix()."module_faq_entries" );
$dict->ExecuteSQLArray($sqlarray);

$sqlarray = $dict->DropTableSQL( cms_db_prefix()."module_faq_categories" );
$dict->ExecuteSQLArray($sqlarray);


// remove the permissions
$this->RemovePermission('FAQ: Use');
$this->RemovePermission('FAQ: Modify');

// remove all templates
$this->DeleteTemplate();

// remove stylesheet
if (version_compare(CMS_VERSION, '1.99-alpha0', '<'))
{
    $stylesheetops = cmsms()->GetStylesheetOperations();
    $stylesheetops->DeleteStylesheetByName('FAQ module');
}
else
{
    $css_ob = CmsLayoutStylesheet::load('FAQ module');
    $css_ob->delete();
}

// remove all preferences
$this->RemovePreference();

// remove the events
$this->RemoveEvent('FAQ_entry_added');
$this->RemoveEvent('FAQ_entry_edited');


$this->RemoveSmartyPlugin();

cms_route_manager::del_static('',$this->GetName());


?>