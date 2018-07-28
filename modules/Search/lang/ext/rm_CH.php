<?php
$lang['clear']='Stizzar';
$lang['confirm_clearstats']='Ès ti segir che ti vuls stizzar definitivamain tut la statistica?';
$lang['count']='Dumber';
$lang['eventhelp-SearchAllItemsDeleted']='<p>Sent when all items are deleted from the index.</p>
<h4>Parameters</h4>
<ul>
<li>None</li>
</ul>
';
$lang['eventhelp-SearchCompleted']='<p>Sent when a search is completed.</p>
<h4>Parameters</h4>
<ol>
<li>Text that was searched for.</li>
<li>Array of the completed results.</li>
</ol>
';
$lang['eventhelp-SearchInitiated']='<p>Sent when a search is started.</p>
<h4>Parameters</h4>
<ol>
<li>Text that was searched for.</li>
</ol>
';
$lang['eventhelp-SearchItemAdded']='<p>Sent when a new item is indexed.</p>
<h4>Parameters</h4>
<ol>
<li>Module name.</li>
<li>Id of the item.</li>
<li>Additional Attribute.</li>
<li>Content to index and add.</li>
</ol>
';
$lang['eventhelp-SearchItemDeleted']='<p>Sent when an item is deleted from the index.</p>
<h4>Parameters</h4>
<ol>
<li>Module name.</li>
<li>Id of the item.</li>
<li>Additional Attribute.</li>
</ol>
';
$lang['export_to_csv']='Exportar a CSV';
$lang['help']='<h3>What does this do?</h3>
<p>Search is a module for searching "core" content along with certain registered modules.  You put in a word or two and it gives you back matching, relevent results.</p>
<h3>How do I use it?</h3>
<p>The easiest way to use it is with the {search} wrapper tag (wraps the module in a tag, to simplify the syntax). This will insert the module into your template or page anywhere you wish, and display the search form.  The code would look something like: <code>{search}</code></p>
<h4>How do i prevent certain content from being indexed</h4>
<p>The search module will not search any "inactive" pages. However on occasion, when you are using the CustomContent module, or other smarty logic to show different content to different groups of users, it may be advisiable to prevent the entire page from being indexed even when it is live.  To do this include the following tag anywhere on the page <em><!-- pageAttribute: NotSearchable --></em> When the search module sees this tag in the page it will not index any content for that page.</p>
<p>The <em><!-- pageAttribute: NotSearchable --></em> tag can be placed in the template as well.  if this is done, none of the pages attached to that template will be indexed.  Those pages will be re-indexed if the tag is removed</p>
';
$lang['noresultsfound']='Chattà nagut!';
$lang['options']='Opziuns';
$lang['param_searchtext']='Text da plazzar en il champ da tschertgar';
$lang['param_submit']='Text da plazzar sin il buttun da tschertgar';
$lang['prompt_alpharesults']='Zavrar ils resultats tenor alfabet enstagl tenor paisa';
$lang['prompt_savephrases']='Observar construcziuns tschertgadas, betg singuls pleds';
$lang['prompt_searchtext']='Text da tschertgar da standart';
$lang['reindexallcontent']='Reindexar tut il cuntegn';
$lang['reindexcomplete']='Reindexà l'entir cuntegn';
$lang['resulttemplate']='Template da resultats';
$lang['resulttemplateupdated']='Actualisà il template da restultats';
$lang['search']='Tschertgar';
$lang['searchresultsfor']='Resultads da tschertga per';
$lang['searchsubmit']='Trametter';
$lang['searchtemplate']='Template da tschertgar';
$lang['searchtemplateupdated']='Actualisà il template da tschertgar';
$lang['statistics']='Statistica';
$lang['stopwords']='Pleds che vegnan betg tschertgads';
$lang['submit']='Trametter';
$lang['sysdefaults']='Restituir il standart';
$lang['timetaken']='Temps duvrà';
$lang['word']='Pled';
?>