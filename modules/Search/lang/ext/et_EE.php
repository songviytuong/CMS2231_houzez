<?php
$lang['clear']='Puhasta';
$lang['confirm_clearstats']='Oled sa kindel, et soovid alatiseks puhastada kogu statistika?';
$lang['count']='Arv';
$lang['description']='Moodul, millega saab otsida saidi ja teiste moodulite sisu.';
$lang['eventdesc-SearchAllItemsDeleted']='Saadetakse k&otilde;ikide objektide kustutamisel indeksist.';
$lang['eventdesc-SearchCompleted']='Saadetakse otsingu l&otilde;petamisel.';
$lang['eventdesc-SearchInitiated']='Saadetakse otsingu alustamisel.';
$lang['eventdesc-SearchItemAdded']='Saadetakse uue objekti indekseerimisel.';
$lang['eventdesc-SearchItemDeleted']='Saadetakse objekti kustutamisel indeksist.';
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
$lang['export_to_csv']='Eksprodi CSV-i';
$lang['help']='<h3>What does this do?</h3>
<p>Search is a module for searching &quot;core&quot; content along with certain registered modules.  You put in a word or two and it gives you back matching, relevent results.</p>
<h3>How do I use it?</h3>
<p>The easiest way to use it is with the {search} wrapper tag (wraps the module in a tag, to simplify the syntax). This will insert the module into your template or page anywhere you wish, and display the search form.  The code would look something like: <code>{search}</code></p>
<h4>How do i prevent certain content from being indexed</h4>
<p>The search module will not search any &quot;inactive&quot; pages. However on occasion, when you are using the CustomContent module, or other smarty logic to show different content to different groups of users, it may be advisiable to prevent the entire page from being indexed even when it is live.  To do this include the following tag anywhere on the page <em>&amp;lt;!-- pageAttribute: NotSearchable --&amp;gt;</em> When the search module sees this tag in the page it will not index any content for that page.</p>
<p>The <em>&amp;lt;!-- pageAttribute: NotSearchable --&amp;gt;</em> tag can be placed in the template as well.  if this is done, none of the pages attached to that template will be indexed.  Those pages will be re-indexed if the tag is removed</p>
';
$lang['noresultsfound']='Vasteid ei leitud!';
$lang['options']='Valikud';
$lang['param_action']='Specify the mode of operation for the module.  Acceptable values are &#039;default&#039;, and &#039;keywords&#039;.  The keywords action can be used to generate a comma seperated list of words suitable for use in a keywords meta tag.';
$lang['param_inline']='If true, the output from the search form will replace the original content of the &#039;search&#039; tag in the originating content block.  Use this parameter if your template has multiple content blocks, and you do not want the output of the search to replace the default content block';
$lang['param_passthru']='Pass named parameters down to specified modules.  The format of each of these parameters is: &quot;passtru_MODULENAME_PARAMNAME=&#039;value&#039;&quot; i.e.: passthru_News_detailpage=&#039;newsdetails&#039;&quot;';
$lang['param_resultpage']='Leht, millel n&auml;idata otsingu tulemusi.  See v&otilde;ib olla nii lehe alias kui ka id. V&otilde;imaldab kuvada otsingu tulemusi otsingu vormist erineva malliga.';
$lang['param_searchtext']='Tekst, mis paigutatakse otsingukasti';
$lang['param_submit']='Tekst, mis paigutatakse otsingunupule';
$lang['prompt_alpharesults']='Sorteeri tulemused t&auml;hestiku j&auml;rjekorras kaalu asemel';
$lang['prompt_savephrases']='J&auml;lgi otsingu lauseid, mitte individuaalseid s&otilde;nu';
$lang['prompt_searchtext']='Algne otsingutekst';
$lang['reindexallcontent']='Reindekseeri Kogu Sisu';
$lang['reindexcomplete']='Reindekseerimine Valmis!';
$lang['restoretodefaultsmsg']='See operatsioon taastab mallide algseaded. Oled kindel, et soovid j&auml;tkata?';
$lang['resulttemplate']='Tulemuste Mall';
$lang['resulttemplateupdated']='Tulemuste Mall uuendatud';
$lang['search']='Otsing';
$lang['search_method']='Pretty Urls Compatibility via Method POST, default value is always GET, to make this work just put {search search_method=&quot;post&quot;} ';
$lang['searchresultsfor']='Otsingu tulemused';
$lang['searchsubmit']='Otsi';
$lang['searchtemplate']='Otsingu Mall';
$lang['searchtemplateupdated']='Otsingu Mall Uuendatud';
$lang['statistics']='Statistika';
$lang['stopwords']='Stop-s&otilde;nad';
$lang['submit']='Saada';
$lang['sysdefaults']='Taasta algseaded';
$lang['timetaken']='Ajakulu';
$lang['usestemming']='Use Word Stemming (English Only):';
$lang['word']='S&otilde;na';
?>