<?php
$lang['anonymous']='مجهول';
$lang['approve']='Set Status to &#039;Published&#039;';
$lang['areyousure_deletemultiple']='Are you sure you want to delete all of these news articles?\nThis action cannot be undone!';
$lang['articles']='مقالات';
$lang['author']='الكاتب';
$lang['categories']='الفئات';
$lang['category']='فئة';
$lang['delete']='حذف';
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
<li>\&quot;useexp\&quot; - Whether the expiration date should be ignored or not</li>
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
<li>\&quot;useexp\&quot; - Whether the expiration date should be ignored or not</li>
</ul>
';
$lang['eventhelp-NewsCategoryAdded']='<p>Sent when a category is added.</p>
<h4>Parameters</h4>
<ul>
<li>\&quot;category_id\&quot; - Id of the news category</li>
<li>\&quot;name\&quot; - Name of the news category</li>
</ul>
';
$lang['eventhelp-NewsCategoryDeleted']='<p>Sent when a category is deleted.</p>
<h4>Parameters</h4>
<ul>
<li>\&quot;category_id\&quot; - Id of the deleted category </li>
<li>\&quot;name\&quot; - Name of the deleted category</li>
</ul>
';
$lang['eventhelp-NewsCategoryEdited']='<p>Sent when a category is edited.</p>
<h4>Parameters</h4>
<ul>
<li>\&quot;category_id\&quot; - Id of the news category</li>
<li>\&quot;name\&quot; - Name of the news category</li>
<li>\&quot;origname\&quot; - The original name of the news category</li>
</ul>
';
$lang['firstpage']='<<';
$lang['help']='<h3>Important Notes</h3>
<p>Version 2.9 and greater of News has removed the formatpostdate member from the templates, and has also removed the dateformat parameter.  You should be using the cms_date_format modifier (as indicated in the default templates) to format dates, and should be using entry->postdate instead of entry->formatpostdate in your templates.</p>
<h3>What does this do?</h3>
<p>News is a module for displaying news events on your page, similar to a blog style, except with more features!.  When the module is installed, a News admin page is added to administration menu that will allow you to select or add a news category.  Once a news category is created or selected, a list of news items for that category will be displayed.  From here, you can add, edit or delete news items for that category.</p>
<h4>Numerous display methods</h4>
<p>The parameters supported by the news module, and support for numerous templates of each time mean that your options for displaying news articles are limitless.</p>
<h4>Custom Fields</h4>
<p>The News module allows defining numerous custom fields (including files and images) that will allow you to attach pdf files or numerous images to your articles.</p>
        <h4>Categories</h4>
	<p>News supplies a hierarchical category mechanism for organizing your articles.  A news article can only be in one place in the hierarchy.</p>
	<h4>Expiry and Status</h4>
	<p>Each news article can have an optional expiry date, after which it will not be shown on your web page.  As well, articles can be marked as <em>draft</em> to remove them permanently from your web page.</p>
	<h3>Security</h3>
	<p>The user must belong to a group with the &#039;Modify News&#039; permission in order to add or edit News entries.</p>
        <p>As well, In order to delete news entries, the user must belong to a group with the &#039;Delete News Articles&#039; permission.</p>
	<p>In order to edit the layout templates, the user must belong to a group with the &#039;Modify Templates&#039; permission.</p>
	<p>In order to edit the global news preferences, the user must belong to a group with the &#039;Modify Site Preferences&#039; permission.</p>
	<p>Additionally, to approve news for frontend display the user must belong to a group with the &#039;Approve News&#039; permission.</p>
	<h3>How do I use it?</h3>
	<p>The easiest way to use it is with the {news} wrapper tag (wraps the module in a tag, to simplify the syntax).  This will insert the module into your template or page anywhere you wish, and display news items.  The code would look something like: <code>{news number=&#039;5&#039;}</code></p>
<h3>Templates</h3>
<p>Since version 2.3 News supports multiple database templates, and no longer supports additional file templates.  Users who used the old file template system should follow these steps (for each file template):</p>
<ul>
<li>Copy the file template into the clipboard</li>
<li>Create a new database template <em>(either summary or detailed as required)</em>.  Give the new template the same name (including the .tpl extension) as the old file template, and paste the contents.</li>
<li>Hit Submit</li>
</ul>
<p>Following these steps should solve the problem of your news templates not being found and other similar smarty errors when you upgrade to a version of CMS that has News 2.3 or greater.</p>';
$lang['helpaction']='&#039;Override the default action.  Possible values are:
<ul>
<li>&quot;detail&quot; - to display a specified articleid in detail mode.</li>
<li>&quot;default&quot; - to display the summary view</li>
<li>&quot;fesubmit&quot; - to display the frontend form for allowing users to submit news articles on the front end.</li>
<li>&quot;browsecat&quot; - to display a browseable category list.</li>
</ul>';
$lang['helpmoretext']='Text to display at the end of a news item if it goes over the summary length.  Defaults to &quot;More&quot;';
$lang['helpsortby']='Field to sort by.  Options are: &quot;news_date&quot;, &quot;summary&quot;, &quot;news_data&quot;, &quot;news_category&quot;, &quot;news_title&quot;, &quot;news_extra&quot;, &quot;end_time&quot;, &quot;start_time&quot;, &quot;random&quot;.  Defaults to &quot;news_date&quot;. If &quot;random&quot; is specified, the sortasc param is ignored.';
$lang['info_sysdefault']='<em>(the content used by default when a new template is created)</em>';
$lang['info_sysdefault2']='<strong>Note:</strong> This tab contains text areas to allow you to edit a set of templates that are displayed when you create a &#039;new&#039; summary, detail, or form template.  Changing content in this tab, and clicking &#039;submit&#039; will <strong>not effect any current displays</strong>.';
$lang['lastpage']='>>';
$lang['needpermission']='You need the &#039;%s&#039; permission to perform that function.';
$lang['news']='أخبار';
$lang['nextpage']='>';
$lang['none']='لا شيء';
$lang['note']='<em>Note:</em> Dates must be in a &#039;yyyy-mm-dd hh:mm:ss&#039; format.';
$lang['options']='خيارات';
$lang['postinstall']='Make sure to set the &quot;Modify News&quot; permission on users who will be administering News items.';
$lang['prevpage']='<';
$lang['prompt_page']='صفحة';
$lang['revert']='Set Status to &#039;Draft&#039;';
$lang['submit']='تقديم';
$lang['unknown']='غير معروف';
$lang['unlimited']='غير محدود';
?>