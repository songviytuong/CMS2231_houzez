<?php

$lang['friendlyname'] = 'Languages & translations';
$lang['postinstall'] = 'Mle CMS was successful installed';
$lang['postuninstall'] = 'Mle CMS was successful uninstalled';
$lang['really_uninstall'] = 'Really? Are you sure
you want to unsinstall this fine module?';
$lang['uninstalled'] = 'Module Uninstalled.';
$lang['installed'] = 'Module version %s installed.';
$lang['upgraded'] = 'Module upgraded to version %s.';
$lang['moddescription'] = 'This module add multilanguage solutions to you CMS Made Simple';
$lang['info_success'] = 'Succes';
$lang['viewfilter'] = 'Filter';
$lang['alert_reset'] = 'Reset Data';
$lang['alert_sync'] = 'Sync Data';
$lang['nothing'] = 'Nothing.';

$lang['optionsupdated'] = 'Options updated';
$lang['module_missing'] = 'Please, instal module %s';

$lang['error'] = 'Error!';
$land['admin_title'] = 'Admin Panel';
$lang['admindescription'] = '';
$lang['accessdenied'] = 'Access Denied. Please check your permissions.';
$lang['postinstall'] = 'Post Install Message, (e.g., Be sure to set "manage mle_cms" permissions to use this module!)';

// Mle config
$lang['mle_config'] = 'Languages';
$lang['sync'] = 'Sync Data';
$lang['default'] = 'Default';
$lang['active'] = 'Active';
$lang['idtext'] = 'ID';
$lang['alias'] = 'Root alias';
$lang['name'] = 'Name';
$lang['extra'] = 'Extra';
$lang['canonical'] = 'Canonical URL';
$lang['par_template'] = 'Smarty parameter in template';

$lang['locale'] = 'Locale for CMSMS';
$lang['documentation'] = 'Documentation';
$lang['example'] = 'Example';
$lang['flag'] = 'Flag';
$lang['mle_init'] = 'Multilanguage detection';
$lang['default_root_base'] = 'Default (based on root alias identification)';

// Snippets

$lang['manage_snippets'] = 'Snippets';
$lang['unknown'] = 'Error: Unknown';
$lang['delete'] = 'Delete';
$lang['areyousure'] = 'Are you sure ?';
$lang['areyousure_setdefaultmle'] = 'Are you sure set default language for FrontEnd ?';
$lang['areyousure_reset'] = 'Are you sure Reset to original Field?';
$lang['edit'] = 'Edit';
$lang['add'] = 'Add';
$lang['source'] = 'Source';
$lang['submit'] = 'Submit';
$lang['title_filter'] = 'Filter';
$lang['cancel'] = 'Cancel';
$lang['reset'] = 'Reset';
$lang['apply'] = 'Apply';
$lang['tag'] = 'Tag';
$lang['content'] = 'Content';

$lang['prompt_page'] = 'Page';
$lang['prompt_page_default'] = 'Default';
$lang['prompt_page_enablelanguage'] = 'Enable Language';
$lang['prompt_page_disablelanguage'] = 'Disable Language';
$lang['prompt_pagelimit'] = 'Page Limit';
$lang['prompt_translate'] = 'Translate';

// Blocks
$lang['manage_blocks'] = 'Blocks';

// Options
$lang['options'] = 'Options';
$lang['mle_template'] = 'Language choice template';
$lang['addedit_mle_template'] = 'Add/Edit a language choice template';
$lang['mle_hierarchy_switch'] = 'Switch beetwen language in each hierarchy';
$lang['mle_search_restriction'] = 'Search MLE restriction (only for search in pages)';
$lang['mle_auto_redirect'] = 'Language detection';
$lang['none'] = 'None';
$lang['root_redirect'] = 'Redirect in the root directory';
$lang['hierarchy_redirect'] = 'Redirect on each level of hierarchy';

// Translator
$lang['mle_translator'] = 'Translator';
$lang['mle_translator_example'] = 'Put to your template: {translate text="anything"}, return to the translator tab and edit it.';

$lang['help_name'] = 'snippet or block name';
$lang['help_template'] = 'template (default Flags)';
$lang['help_excludeprefix'] = 'exclude prefix (for langs action) ';
$lang['help_includeprefix'] = 'include prefix (for langs action) ';


$lang['help'] = '
<h3>What Does This Do?</h3>
<p>This module add multilanguage solution to your CMS Made Simple.</p>
<h3>How Do I Use It</h3>
<p>In short terms:</p>
<ol>
<li>Install the missing languages through the CMS Made Simple install script (you must choose <em>freshen installation</em> to add new languages)</li>
<li>Create one pages tree per lang</li>
<li>Configure the Languages module in the Content section</li>
<li>Add <code>{MleCMS action=init}</code> on the very top of your pages templates</li>
<li>Add <code>{MleCMS action=langs}</code> if and where you want you languages switch box to be.</li>
</ol>

<p>If you want more informations, check installation guide <a href="http://cmsmadesimple.sk/modules/MleCMS/installation-guide.html">Installation Guide</a></p>
<p>or</p>
<p><a target="_blank" href="http://blog.arvixe.com/creating-a-multilingual-cmsms-site-using-mlecms-module/">Creating a Multilingual CMSMS Site Using MleCMS Module</a></p>
<h3>Plugins</h3>
<p><strong>Translate</strong> - <code>{translate text=\'some text\'}</code> or <code>{translator}some text{/translator}</code> or <code>{\'some text\'|translate}</code></p>
<p>Parameters:</p>
<ul>
<li>text (required) - text for translate</li>
<li>assign (optional)  - smarty assign</li>
</ul>
<br />
<p><strong>mle_assign</strong> - (news example: {mle_assign object=$entry par="title" assign="entry"}) </p>
<p>Parameters:</p>
<ul>
<li>object or array (required) - object/array for mle assign</li>
<li>par (required)  - parameter for find mutlilangue string (example: title and mle version  are  title_sk, title_de, title_fr, where title is default string for default language. Great MLE solution in templates!!)</li>
<li>assign (optional)  - assign to object</li>
</ul>
<br />
<p><strong>mle_selflink</strong> - ({mle_selfink page="alias"}) </p>
<p>Parameters:</p>
<p>Params</p>
<ul>
<li>page/href - same like for cms_selflink</li>
<li>assign (optional)</li>
</ul>
<br />
<h3>Do you like my work? </h3>
<p><a href="http://cmsmadesimple.sk/donate-card/?utm_source=cmsmadesimple&utm_medium=link&utm_campaign=help" target="_blank">Give me five or feel free to donate me</a></p>    
';
?>
