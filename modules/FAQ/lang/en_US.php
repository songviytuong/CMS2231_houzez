<?php
#-------------------------------------------------------------------------
# Module: FAQ
# Author: Jos (josvd@live.nl)
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2008 by Ted Kulp (wishy@cmsmadesimple.org)
# This project's homepage is: http://www.cmsmadesimple.org
# The module's homepage is: http://dev.cmsmadesimple.org/projects/faq/
#-------------------------------------------------------------------------

$lang['friendlyname'] = 'Frequently Asked Questions';
$lang['moddescription'] = 'Create and manage a categorized list of Questions and Answers';
$lang['description'] = 'Manage a list of Questions and Answers';
$lang['postinstall'] = 'The FAQ module was successfully installed. Check the admin Content section for \'%s\'.';

$lang['areyousure'] = 'Are you sure you want to delete?';
$lang['areyousuremulti'] = 'Are you sure you want to execute this bulk action?';


$lang['category'] = 'Category';
$lang['categories'] = 'Categories';
$lang['addcategory'] = 'Add Category';
$lang['categoryadded'] = 'Category is added';
$lang['editcategory'] = 'Edit Category';
$lang['categoryupdated'] = 'Category is updated';
$lang['categorydeleted'] = 'Category is deleted';
$lang['entries_page'] = 'Number of entries per page';
$lang['import_csv'] = 'Import entries by csv';
$lang['csv_format'] = 'csv format: "question"[string];"answer"[string]';



$lang['id'] = 'ID';
$lang['entries'] = 'Entries';
$lang['additem'] = 'Add Entry';
$lang['itemadded'] = 'Entry is added';
$lang['edititem'] = 'Edit Entry';
$lang['itemupdated'] = 'Entry is updated';
$lang['itemdeleted'] = 'Entry is deleted';


//Templates
$lang['summary_tpl'] = 'summary view';
$lang['detail_tpl'] = 'detail view';
$lang['default_summary_template'] = 'Default summary template';
$lang['default_detail_template'] = 'Default detail template';
$lang['resetdefault'] = 'Load/reset default template';
$lang['resetwarning'] = 'Are you sure you want to reset the template code to default?';
//$lang['availablevariables'] = 'Available Template Smarty Variables';


//Options
$lang['title_custom_modulename'] = 'Custom Modulename';
$lang['help_custom_modulename'] = 'You can change the Modulename here as you wish. It will be used as the title on the module admin pages and as menu text.';
$lang['title_admin_section'] = 'Admin Section';
$lang['help_admin_section'] = 'Choose the Admin Section (or top-level Admin Menu) this module belongs to.';
$lang['use_question_wysiwyg'] = 'Use a WYSIWYG editor on the question field';
$lang['use_answer_wysiwyg'] = 'Use a WYSIWYG editor on the answer field';
$lang['title_entries_page'] = 'Frontend number of entries per page';
$lang['optionsupdated'] = 'The options were successfully updated.';


//Frontend
$lang['question'] = 'Question';
$lang['answer'] = 'Answer';


//Help
$lang['help_action'] = 'Possible values: <ul><li>\'default\' - for displaying the FAQ entries</li><li>\'detail\' - for displaying a single entry, e.g. as search result</li></ul>';
$lang['help_category'] = 'Filter the output on category. Use the category alias. Check the Categories-tab, column \'Tags\', to see which aliases can be used. For multiple categories, use comma as separator between the aliasses.';
$lang['help_entryid'] = 'Use this parameter along with <code>action=\'detail\'</code> if you want to display only one FAQ entry. To get the latest entry, use <code>entryid=-1</code>';
$lang['help_template'] = 'Use another template than the default one. Note that templates must be of the proper type, in accordance with the action parameter.';
$lang['help'] = '<h3>What Does This Do?</h3>
<p>The FAQ module provides your site visitors a categorized list with Frequently Asked Questions and their answers.</p>
<h3>How Do I Use It</h3>
<p>To show the FAQ entries, just insert the module with the<code> {FAQ} </code>tag into the content section of a page.</p>
<p>To get a quick start, a sample stylesheet has been installed which corresponds with the default module templates. Attach the stylesheet \'FAQ module\' to your page template(s) to give your FAQ list a first good look.</p>
<p>Note that entries are filtered on categories that correspond to the Frontend language.</p>

<h3>Add/Edit Entries</h3>
<p>Users with the \'FAQ: Use\' permission can edit questions and answers in the backend.</p>

<h3>Add/Edit Categories</h3>
<p>Users must belong to a group with the \'FAQ: Modify\' permission to be able to create and edit categories.</p>

<h3>Import FAQ Entries</h3>
<p>If you are migrating your site from another CMS or from another FAQ system, you probably might want to create a csv file containing all entries you have entered in the past.</p>
<p>This csv file can easily be imported to the FAQ module, when it is formatted with fields in a specific order, separated by semicolons and enclosed by double quotes, like this:<br />
<code>"question";"answer"</code></p>
<p>Both fields are of type [string]. All double quotes in the data need to be escaped with a backslash.</p>

<h3>Edit FAQ templates</h3>
<p>In order to edit templates, the user must belong to a group with the \'Modify Templates\' permission.</p>

<h3>Global FAQ Options</h3>
<p>To edit the global FAQ options, the user must belong to a group with the \'Modify Site Preferences\' permission.</p>

<h3>Support</h3>
<p>This module does not include commercial support. However, there are a number of resources available to help you with it:</p>
<ul>
<li>FAQs, extended module help and Troubleshooting can be found in the <a href="http://wiki.cmsms.nl/index.php/FAQ">FAQ Wiki Documentation</a>.</li>
<li>For the latest version of this module or to file a Feature Request or Bug Report, please visit the Module Forge
<a href="http://dev.cmsmadesimple.org/projects/faq/">FAQ Page</a>.</li>
<li>Additional discussion of this module may also be found in the <a href="http://forum.cmsmadesimple.org">CMS Made Simple Forums</a>. You are warmly invited to open a new topic if you didn\'t find an answer to your question.</li>
<li>Lastly, you may have some success emailing the author directly.</li>
</ul>

<h3>Feedback</h3>
<p>If you enjoy this module, use it on a commercial website or would like to encourage future development, you might consider just a small donation.<br />Or leave a message in the <a href="http://forum.cmsmadesimple.org/">FAQ forum topic</a>. Any kind of feedback will be much appreciated.</p>
';
?>
