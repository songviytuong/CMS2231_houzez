<?php
$lang['friendlyname'] = 'Veelgestelde Vragen';
$lang['moddescription'] = 'Creëer en beheer een gecategorizeerde lijst van Vragen en Antwoorden';
$lang['description'] = 'Beheer een lijst met vragen en antwoorden';
$lang['postinstall'] = 'De FAQ module is succesvol geïnstalleerd. Zie de admin Content sectie: \'%s\'.';
$lang['areyousure'] = 'Weet u zeker dat u dit wilt verwijderen?';
$lang['areyousuremulti'] = 'Weet u zeker dat u deze bulk-actie wilt uitvoeren?';
$lang['category'] = 'Categorie';
$lang['categories'] = 'Categorieën';
$lang['addcategory'] = 'Voeg Categorie toe';
$lang['categoryadded'] = 'Categorie is toegevoegd';
$lang['editcategory'] = 'Bewerk Categorie';
$lang['categoryupdated'] = 'Categorie is bijgewerkt';
$lang['categorydeleted'] = 'Categorie is verwijderd';
$lang['entries_page'] = 'Aantal items per pagina';
$lang['import_csv'] = 'Importeer items via csv';
$lang['csv_format'] = 'csv formaat: "question"[string];"answer"[string]';
$lang['id'] = 'id';
$lang['entries'] = 'Items';
$lang['additem'] = 'Voeg item toe';
$lang['itemadded'] = 'Item is toegevoegd';
$lang['edititem'] = 'Bewerk item';
$lang['itemupdated'] = 'Item is bijgewerkt';
$lang['itemdeleted'] = 'Item is verwijderd';
$lang['summary_tpl'] = 'lijst weergave';
$lang['detail_tpl'] = 'detail weergave';
$lang['default_summary_template'] = 'Standaard lijst sjabloon';
$lang['default_detail_template'] = 'Standaard detail sjabloon';
$lang['resetdefault'] = 'Laad/reset standaard sjabloon';
$lang['resetwarning'] = 'Weet u zeker dat u de sjabloon code wilt resetten naar de standaard?';
$lang['title_custom_modulename'] = 'Eigen Modulenaam';
$lang['help_custom_modulename'] = 'U kunt hier de Modulenaam naar eigen wens aanpassen. Het zal gebruikt worden als titel op de module beheerpagina en als menu tekst.';
$lang['title_admin_section'] = 'Admin Sectie';
$lang['help_admin_section'] = 'Kies de Admin Sectie (van het Admin topmenu) waar deze module moet worden getoond.';
$lang['use_question_wysiwyg'] = 'Gebruik een WYSIWYG editor voor het vraag veld';
$lang['use_answer_wysiwyg'] = 'Gebruik een WYSIWYG editor voor het antwoord veld';
$lang['title_entries_page'] = 'Aantal items per pagina (Frontend)';
$lang['optionsupdated'] = 'De opties zijn succesvol bijgewerkt.';
$lang['question'] = 'Vraag';
$lang['answer'] = 'Antwoord';
$lang['help_action'] = 'Possible values:  <ul><li>\'default\' - for displaying the FAQ entries</li><li>\'detail\' - for displaying a single entry, e.g. as search result</li></ul>';
$lang['help_category'] = 'Filter the output on category. Use the category alias.  Check the Categories-tab, column \'Tags\', to see which aliases can be used. For multiple categories, use comma as separator between the aliasses.';
$lang['help_entryid'] = 'Use this parameter along with <code>action=\'detail\'</code> if you want to display only one FAQ entry.  To get the latest entry, use <code>entryid=-1</code>';
$lang['help_template'] = 'Use another template than the default one.  Note that templates must be of the proper type, in accordance with the action parameter.';
$lang['help'] = '<h3>What Does This Do?</h3>
<p>The FAQ module provides your site visitors a categorized list with Frequently Asked Questions and their answers. </p>
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
<p>If you enjoy this module, use it on a commercial website or would like to encourage future development, you might consider just a small donation.<br />Or leave a message in the <a href="http://forum.cmsmadesimple.org/">FAQ forum topic</a>. Any kind of feedback will be much appreciated.</p>';
?>