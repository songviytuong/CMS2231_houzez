<?php
$lang['addarticle']='Tambah Artikel';
$lang['addcategory']='Tambah kategori';
$lang['addnewsitem']='Tambah berita';
$lang['allcategories']='Seluruh kategori';
$lang['allentries']='Seluruh masukan';
$lang['areyousure']='Anda yakin untuk menghapus?';
$lang['articleadded']='Artikel telah berhasil ditambahkan.';
$lang['articles']='Artikel-artikel';
$lang['author']='Penulis';
$lang['cancel']='Ditunda';
$lang['categories']='Kategori-kategori';
$lang['category']='Kategori';
$lang['categoryadded']='Kategori telah berhasil ditambahkan.';
$lang['categoryupdated']='Kategori telah berhasil diperbaharui.';
$lang['detailtemplate']='Detail Template';
$lang['eventhelp-NewsArticleAdded']='<p>Sent when an article is added.</p>
<h4>Parameters</h4>
<ul>
<li>\&quot;news_id\&quot; - Id of the news article</li>
<li>\&quot;category_id\&quot; - Id of the category for this article</li>
<li>\&quot;title\&quot; - Title of the article</li>
<li>\&quot;content\&quot; - Content of the article</li>
<li>\&quot;summary\&quot; - Summary of the article</li>
<li>\&quot;status\&quot; - Status of the article (&quot;draft&quot; or &quot;publish&quot;)</li>
<li>\&quot;start_time\&quot; - Date the article should start being displayed</li>
<li>\&quot;end_time\&quot; - Date the article should stop being displayed</li>
</ul>
';
$lang['eventhelp-NewsArticleDeleted']='<p>Sent when an article is deleted.</p>
<h4>Parameters</h4>
<ul>
<li>\&quot;news_id\&quot; - Id of the news article</li>
</ul>
';
$lang['eventhelp-NewsArticleEdited']='<p>Sent when an article is edited.</p>
<h4>Parameters</h4>
<ul>
<li>\&quot;news_id\&quot; - Id of the news article</li>
<li>\&quot;category_id\&quot; - Id of the category for this article</li>
<li>\&quot;title\&quot; - Title of the article</li>
<li>\&quot;content\&quot; - Content of the article</li>
<li>\&quot;summary\&quot; - Summary of the article</li>
<li>\&quot;status\&quot; - Status of the article (&quot;draft&quot; or &quot;publish&quot;)</li>
<li>\&quot;start_time\&quot; - Date the article should start being displayed</li>
<li>\&quot;end_time\&quot; - Date the article should stop being displayed</li>
</ul>
';
$lang['eventhelp-NewsCategoryAdded']='<p>Sent when a category is added.</p>
<h4>Parameters</h4>
<ul>
<li>\&quot;category_id\&quot; - Id of the news categpry</li>
<li>\&quot;name\&quot; - Name of the news category</li>
</ul>
';
$lang['eventhelp-NewsCategoryDeleted']='<p>Sent when a category is deleted.</p>
<h4>Parameters</h4>
<ul>
<li>\&quot;category_id\&quot; - Id of the news categpry</li>
</ul>
';
$lang['eventhelp-NewsCategoryEdited']='<p>Sent when a category is edited.</p>
<h4>Parameters</h4>
<ul>
<li>\&quot;category_id\&quot; - Id of the news categpry</li>
<li>\&quot;name\&quot; - Name of the news category</li>
</ul>
';
$lang['expiry']='Expriry';
$lang['help']='	<h3>What does this do?</h3>
	<p>News is a module for displaying news events on your page, similar to a blog style, except with more features!.  When the module is installed, a News admin page is added to administration menu that will allow you to select or add a news category.  Once a news category is created or selected, a list of news items for that category will be displayed.  From here, you can add, edit or delete news items for that category.</p>
	<h3>Template variables</h3>
	<ul>
		<li><b>itemcount</b> - The number of news articles to be shown.</li>
	</ul>
	<h3>Security</h3>
	<p>The user must belong to a group with the &#039;Modify News&#039; permission in order to add, edit, or delete News entries.</p>
	<p>In order to edit the layout templates, the user must belong to a group with the &#039;Modify Templates&#039; permission.</p>
	<p>In order to edit the global news preferences, the user must belong to a group with the &#039;Modify Site Preferences&#039; permission.</p>
	<h3>How do I use it?</h3>
	<p>The easiest way to use it is with the {news} wrapper tag (wraps the module in a tag, to simplify the syntax).  This will insert the module into your template or page anywhere you wish, and display news items.  The code would look something like: <code>{news number=&#039;5&#039;}</code></p>';
$lang['helpcategory']='Only display items for that category. <b>Use * after the name to show children.</b>  Multiple categories can be used if separated with a comma. Leaving empty, will show all categories.';
$lang['helpdetailtemplate']='Use a separate template for displaying the article detail.  It have to live in modules/News/templates.';
$lang['helpmoretext']='Text to display at the end of a news item if it goes over the summary length.  Defaults to &quot;more...&quot;';
$lang['helpnumber']='Maximum number of items to display =- leaving empty will show all items.';
$lang['helpsortby']='Field to sort by.  Options are: &quot;news_date&quot;, &quot;summary&quot;, &quot;news_data&quot;, &quot;news_category&quot;, &quot;news_title&quot;.  Defaults to &quot;news_date&quot;.';
$lang['helpsummarytemplate']='Use a separate template for displaying the article summary.  It have to live in modules/News/templates.';
$lang['needpermission']='You need the &#039;%s&#039; permission to perform that function.';
$lang['note']='<em>Note:</em> Dates must be in a &#039;yyyy-mm-dd hh:mm:ss&#039; format.';
$lang['postinstall']='Make sure to set the &quot;Modify News&quot; permission on users who will be administering News items.';
$lang['restoretodefaultsmsg']='Operasi ini akan mengembalikan isi template ke default sistem. Anda yakin untuk meneruskan proses ini ?';
$lang['summarytemplate']='Summary Template';
$lang['sysdefaults']='Dikembalikan ke bentuk asal';
?>