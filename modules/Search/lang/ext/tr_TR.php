<?php
$lang['clear'] = 'Temizle';
$lang['confirm_clearstats'] = 'İstatistikleri kalıcı olarak silmek istediğinizden emin misiniz?';
$lang['count'] = 'Say';
$lang['description'] = 'Module for search site and other module\'s contents.';
$lang['eventdesc-SearchAllItemsDeleted'] = 'Tüm öğeler dizinden silindiğinde gönderildi.';
$lang['eventhelp-SearchAllItemsDeleted'] = '<p>Tüm öğeler dizinden silindiğinde gönderildi.</p>
<h4>Parametreler</h4>
<ul>
<li>None</li>
</ul>';
$lang['eventdesc-SearchCompleted'] = 'Arama bittiğinde gönderildi.';
$lang['eventhelp-SearchCompleted'] = '<p>Arama bittiğinde gönderildi.</p>
<h4>Parametreler</h4>
<ol>
<li>Aranan yazı.</li>
<li>Tamamlanan sonuçlar dizisi.</li>
</ol>';
$lang['eventdesc-SearchInitiated'] = 'Arama başlatıldığında gönderildi.';
$lang['eventhelp-SearchInitiated'] = '<p>Arama başlatıldığında gönderildi.</p>
<h4>Parametreler</h4>
<ol>
<li>Aranan yazı.</li>
</ol>';
$lang['eventdesc-SearchItemAdded'] = 'Yeni bir öğe dizinlendiğinde gönderildi.';
$lang['eventhelp-SearchItemAdded'] = '<p>Yeni bir öğe dizinlendiğinde gönderildi.</p>
<h4>Parametreler</h4>
<ol>
<li>Module name.</li>
<li>Id of the item.</li>
<li>Additional Attribute.</li>
<li>Content to index and add.</li>
</ol>';
$lang['eventdesc-SearchItemDeleted'] = 'Öğe dizinden silindiğinde gönderildi.';
$lang['eventhelp-SearchItemDeleted'] = '<p>Bir öğe dizinden silindiğinde gönderildi.</p>
<h4>Parametreler</h4>
<ol>
<li>Module name.</li>
<li>Id of the item.</li>
<li>Additional Attribute.</li>
</ol>';
$lang['export_to_csv'] = 'Export CVS';
$lang['help'] = '<h3>What does this do?</h3>
<p>Search is a module for searching "core" content along with certain registered modules.  You put in a word or two and it gives you back matching, relevent results.</p>
<h3>How do I use it?</h3>
<p>The easiest way to use it is with the {search} wrapper tag (wraps the module in a tag, to simplify the syntax). This will insert the module into your template or page anywhere you wish, and display the search form.  The code would look something like: <code>{search}</code></p>
<h4>How do i prevent certain content from being indexed</h4>
<p>The search module will not search any "inactive" pages. However on occasion, when you are using the CustomContent module, or other smarty logic to show different content to different groups of users, it may be advisiable to prevent the entire page from being indexed even when it is live.  To do this include the following tag anywhere on the page <em><!-- pageAttribute: NotSearchable --></em> When the search module sees this tag in the page it will not index any content for that page.</p>
<p>The <em><!-- pageAttribute: NotSearchable --></em> tag can be placed in the template as well.  if this is done, none of the pages attached to that template will be indexed.  Those pages will be re-indexed if the tag is removed</p>';
$lang['noresultsfound'] = 'Hiçbir sonuç bulunamadı!';
$lang['options'] = 'Seçenekler';
$lang['param_action'] = 'Specify the mode of operation for the module.  Acceptable values are \'default\', and \'keywords\'.  The keywords action can be used to generate a comma seperated list of words suitable for use in a keywords meta tag.';
$lang['param_inline'] = 'If true, the output from the search form will replace the original content of the \'search\' tag in the originating content block.  Use this parameter if your template has multiple content blocks, and you do not want the output of the search to replace the default content block';
$lang['param_passthru'] = 'Pass named parameters down to specified modules.  The format of each of these parameters is: "passtru_MODULENAME_PARAMNAME=\'value\'" i.e.: passthru_News_detailpage=\'newsdetails\'"';
$lang['param_resultpage'] = 'Arama sonuçlarının gösterileceği sayfa.  This can either be a page alias or an id.  Used to allow search results to be displayed in a different template from the search form';
$lang['param_searchtext'] = 'Arama kutusuna konulacak yazı';
$lang['param_submit'] = 'Gönder düğmesine konulacak yazı';
$lang['prompt_alpharesults'] = 'Arama sonuçlarını alfabetik olarak sırala';
$lang['prompt_searchtext'] = 'Varsayılan Arama Yazısı';
$lang['reindexallcontent'] = 'Tüm içeriği yeniden dizinle';
$lang['reindexcomplete'] = 'Dizinleme Tamamlandı!';
$lang['restoretodefaultsmsg'] = 'Bu işlem şablon içeriklerini sistem varsayılanlarına döndürür.  Devam etmek istediğinizden emin misiniz?';
$lang['resulttemplate'] = 'Sonuç Şablonu';
$lang['resulttemplateupdated'] = 'Sonuç Şablonu Güncellendi';
$lang['search'] = 'Arama';
$lang['searchresultsfor'] = 'Arama Sonuçları';
$lang['searchsubmit'] = 'Gönder';
$lang['searchtemplate'] = 'Arama Şablonu';
$lang['searchtemplateupdated'] = 'Arama Şablonu Güncellendi';
$lang['search_method'] = 'Pretty Urls Compatibility via Method POST, default value is always GET, to make this work just put {search search_method="post"}';
$lang['statistics'] = 'İstatistikler';
$lang['stopwords'] = 'Durma sözcükleri';
$lang['submit'] = 'Gönder';
$lang['sysdefaults'] = 'Varsayılanlara dön';
$lang['timetaken'] = 'Geçen süre';
$lang['type_Search'] = 'Arama';
$lang['type_searchform'] = 'Arama Formu';
$lang['use_or'] = 'HERHANGİ kelime eşleşen sonuçları bul';
$lang['word'] = 'Kelime';
?>