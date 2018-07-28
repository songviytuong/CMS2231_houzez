<?php
$lang['addarticle']='新增文章';
$lang['addcategory']='新增類別';
$lang['addnewsitem']='新增項目';
$lang['allcategories']='所有類別';
$lang['allentries']='所有記錄';
$lang['anonymous']='匿名';
$lang['apply']='採用';
$lang['approve']='設定狀態為“發佈”';
$lang['areyousure']='確定刪除?';
$lang['areyousure_deletemultiple']='Are you sure you want to delete all of these news articles?\nThis action cannot be undone!';
$lang['article']='文章';
$lang['articleadded']='已成功添加文章。';
$lang['articledeleted']='文章被成功刪除。';
$lang['articles']='文章';
$lang['articleupdated']='已成功更新的文章。';
$lang['author']='作者';
$lang['author_label']='發表者:';
$lang['cancel']='取消';
$lang['categories']='類別';
$lang['category']='類別';
$lang['category_label']='目錄:';
$lang['categoryadded']='已成功加入該類別。';
$lang['categorydeleted']='類別已成功刪除。';
$lang['categoryupdated']='類別已成功更新。';
$lang['checkbox']='複選框';
$lang['content']='內容';
$lang['dateformat']='%s 不是有效的 yyyy-mm-dd hh:mm:ss 格式';
$lang['default_category']='預設分類';
$lang['default_templates']='預設模板';
$lang['delete']='刪除';
$lang['delete_selected']='刪除所選的文章';
$lang['description']='新增, 編輯和刪除新聞項目';
$lang['detail_page']='詳細頁面';
$lang['detailtemplate']='詳細模板';
$lang['detailtemplateupdated']='更新的詳細信息模板成功地儲存到資料庫中。';
$lang['displaytemplate']='顯示模板';
$lang['down']='下';
$lang['draft']='草案';
$lang['edit']='編輯';
$lang['enddate']='結束日期';
$lang['endrequiresstart']='輸入結束日期同時需要開始日期';
$lang['entries']='%s 項目';
$lang['error_duplicatename']='該項目的名稱已經存在';
$lang['error_insufficientparams']='不足（或空）參數';
$lang['error_invalidfiletype']='不能上傳這種類型的檔案';
$lang['error_mkdir']='無法建立目錄: %s';
$lang['error_movefile']='無法建立檔案: %s';
$lang['error_noarticlesselected']='沒有文章被選取';
$lang['eventdesc-NewsArticleAdded']='添加文章時發送。';
$lang['eventdesc-NewsArticleDeleted']='刪除文章後發送。';
$lang['eventdesc-NewsArticleEdited']='編緝文章後發送。';
$lang['eventhelp-NewsArticleAdded']='<p>Sent when an article is added.</p>
<h4>Parameters</h4>
<ul>
<li>"news_id" - Id of the news article</li>
<li>"category_id" - Id of the category for this article</li>
<li>"title" - Title of the article</li>
<li>"content" - Content of the article</li>
<li>"summary" - Summary of the article</li>
<li>"status" - Status of the article ("draft" or "publish")</li>
<li>"start_time" - Date the article should start being displayed</li>
<li>"end_time" - Date the article should stop being displayed</li>
<li>"useexp" - Whether the expiration date should be ignored or not</li>
</ul>
';
$lang['eventhelp-NewsArticleDeleted']='<p>Sent when an article is deleted.</p>
<h4>Parameters</h4>
<ul>
<li>"news_id" - Id of the news article</li>
</ul>
';
$lang['eventhelp-NewsArticleEdited']='<p>Sent when an article is edited.</p>
<h4>Parameters</h4>
<ul>
<li>"news_id" - Id of the news article</li>
<li>"category_id" - Id of the category for this article</li>
<li>"title" - Title of the article</li>
<li>"content" - Content of the article</li>
<li>"summary" - Summary of the article</li>
<li>"status" - Status of the article ("draft" or "publish")</li>
<li>"start_time" - Date the article should start being displayed</li>
<li>"end_time" - Date the article should stop being displayed</li>
<li>"useexp" - Whether the expiration date should be ignored or not</li>
</ul>
';
$lang['eventhelp-NewsCategoryAdded']='<p>Sent when a category is added.</p>
<h4>Parameters</h4>
<ul>
<li>"category_id" - Id of the news category</li>
<li>"name" - Name of the news category</li>
</ul>
';
$lang['eventhelp-NewsCategoryDeleted']='<p>Sent when a category is deleted.</p>
<h4>Parameters</h4>
<ul>
<li>"category_id" - Id of the deleted category </li>
<li>"name" - Name of the deleted category</li>
</ul>
';
$lang['eventhelp-NewsCategoryEdited']='<p>Sent when a category is edited.</p>
<h4>Parameters</h4>
<ul>
<li>"category_id" - Id of the news category</li>
<li>"name" - Name of the news category</li>
<li>"origname" - The original name of the news category</li>
</ul>
';
$lang['expired']='過期';
$lang['expiry']='過期';
$lang['expiry_interval']='文章期滿前天數 (預設)（如果有選擇期滿）';
$lang['extra_label']='額外:';
$lang['file']='檔案';
$lang['filter']='過濾';
$lang['firstpage']='<<';
$lang['help']='	<h3>What does this do?</h3>
	<p>News is a module for displaying news events on your page, similar to a blog style, except with more features!.  When the module is installed, a News admin page is added to administration menu that will allow you to select or add a news category.  Once a news category is created or selected, a list of news items for that category will be displayed.  From here, you can add, edit or delete news items for that category.</p>
	<h3>Security</h3>
	<p>The user must belong to a group with the \'Modify News\' permission in order to add, edit, or delete News entries.</p>
	<p>In order to edit the layout templates, the user must belong to a group with the \'Modify Templates\' permission.</p>
	<p>In order to edit the global news preferences, the user must belong to a group with the \'Modify Site Preferences\' permission.</p>
	<h3>How do I use it?</h3>
	<p>The easiest way to use it is in conjunction with the cms_module tag.  This will insert the module into your template or page anywhere you wish, and display news items.  The code would look something like: <code>{cms_module module="news" number="5" category="beer"}</code></p>';
$lang['helpaction']='Override the default action.  Possible values are:
<ul>
<li>"detail" - to display a specified articleid in detail mode.</li>
<li>"default" - to display the summary view</li>
<li>"fesubmit" - to display the frontend form for allowing users to submit news articles on the front end. Add the <code>{cms_init_editor}</code> tag in the metadata section to initialize the selected wysiwyg editor. (Site Admin >> Global Settings)</li>
<li>"browsecat" - to display a browseable category list.</li>
</ul>';
$lang['helpcategory']='只顯示該類別的項目。名稱前加*顯示子類別。多類別請用逗號分隔.不填將顯示所有類別。';
$lang['helpdetailpage']='顯示新聞內容的詳細內容的頁面。 可以是頁面別名,也可以是id。 用來使詳細內容能夠以不同模板顯示。';
$lang['helpdetailtemplate']='用獨立的模板顯示文章內容. 模板必須位於 modules/News/templates.';
$lang['helpmoretext']='項目超過摘要長度時顯示的文字。 預設 "more..."';
$lang['helpnumber']='最大顯示項目數(不填顯示所有項目)。';
$lang['helpsortasc']='使用遞增列新聞項目。';
$lang['helpsortby']='排序欄位. 選項: "新聞日期","摘要","新聞內容","新聞類別","新聞標題". 預設為 "新聞日期"。';
$lang['helpstart']='從 nth 條開始顯示(不填從第一條顯示)。';
$lang['helpsummarytemplate']='用獨立的模板顯示文章摘要. 模板必須位於 modules/News/templates.';
$lang['hide_summary_field']='添加或編輯文章時，隱藏的匯總欄位';
$lang['lastpage']='>>';
$lang['more']='更多';
$lang['moretext']='更多文字';
$lang['name']='名稱';
$lang['needpermission']='你需要 \'%s\' 權限來執行這項操作。';
$lang['newcategory']='新類別';
$lang['news']='新聞';
$lang['news_return']='返回';
$lang['nextpage']='>';
$lang['nocategorygiven']='沒有指定類別';
$lang['nocontentgiven']='沒有指定內容';
$lang['noitemsfound']='<strong>沒有</strong> 找到該類別的項目:%s';
$lang['nonamegiven']='沒有給名稱';
$lang['none']='無';
$lang['nopostdategiven']='沒有指定發佈日期';
$lang['note']='<em>注意:</em> 日期必須是 \'yyyy-mm-dd hh:mm:ss\' 格式。';
$lang['notitlegiven']='沒有指定標題';
$lang['numbertodisplay']='顯示數目(不填顯示所有內容)';
$lang['options']='選項';
$lang['optionsupdated']='這選項已成功更新。';
$lang['postdate']='發佈日期';
$lang['postinstall']='確認賦予管理新聞項目的用戶"修改新聞"的權限。';
$lang['preview']='預覽';
$lang['prevpage']='<';
$lang['print']='列印';
$lang['prompt_default']='預設';
$lang['prompt_name']='名稱';
$lang['prompt_page']='頁';
$lang['prompt_sorting']='排序、依';
$lang['reassign_category']='更改類別至';
$lang['removed']='刪除';
$lang['restoretodefaultsmsg']='該操作將把模板內容恢復到系統預設值.是否繼續?';
$lang['revert']='設定狀態為“草稿”';
$lang['select']='選取';
$lang['selectcategory']='選擇類別';
$lang['showchildcategories']='顯示子類別';
$lang['sortascending']='遞增排列';
$lang['startdate']='開始日期';
$lang['startdatetoolate']='開始日期已經為時已晚（在結束日期之後？）';
$lang['startoffset']='從 nth 項目開始顯示';
$lang['startrequiresend']='輸入開始日期同時需要結束日期';
$lang['status']='狀態';
$lang['status_asc']='狀態遞增';
$lang['status_desc']='狀態遞減';
$lang['submit']='提交';
$lang['summary']='摘要';
$lang['summarytemplate']='摘要模板';
$lang['summarytemplateupdated']='新聞摘要模板已成功更新。';
$lang['sysdefaults']='恢復到預設值';
$lang['textarea']='文本區域';
$lang['textbox']='文字輸入';
$lang['title']='標題';
$lang['title_asc']='標題遞增';
$lang['title_desc']='標題遞減';
$lang['title_detail_returnid']='預設頁面使用的詳細意見';
$lang['title_detail_settings']='詳細查看設定';
$lang['title_fesubmit_settings']='前台提交設定';
$lang['title_notification_settings']='通知設定';
$lang['title_submission_settings']='新聞投稿設定';
$lang['unknown']='未知';
$lang['unlimited']='無限的';
$lang['up']='上';
$lang['useexpiration']='使用過期日期';
$lang['warning_preview']='警告: This preview panel behaves much like a browser window allowing you to navigate away from the initially previewed page. However, if you do that, you may experience unexpected behaviour.  Navigating away from the initial page and returning will not give the expected results.<br/><strong>Note:</strong> The preview does not upload files you may have selected for upload.';
?>
