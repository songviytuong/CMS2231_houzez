<?php
$lang['clear']='清除';
$lang['confirm_clearstats']='你確定要永久清除所有統計嗎?';
$lang['count']='計算';
$lang['default_stopwords']='i, me, my, myself, we, our, ours, ourselves, you, your, yours, 
yourself, yourselves, he, him, his, himself, she, her, hers, 
herself, it, its, itself, they, them, their, theirs, themselves, 
what, which, who, whom, this, that, these, those, am, is, are, 
was, were, be, been, being, have, has, had, having, do, does, 
did, doing, a, an, the, and, but, if, or, because, as, until, 
while, of, at, by, for, with, about, against, between, into, 
through, during, before, after, above, below, to, from, up, down, 
in, out, on, off, over, under, again, further, then, once, here, 
there, when, where, why, how, all, any, both, each, few, more, 
most, other, some, such, no, nor, not, only, own, same, so, 
than, too, very';
$lang['eventdesc-SearchAllItemsDeleted']='當所有索引被刪除時發送。';
$lang['eventdesc-SearchCompleted']='搜尋完成時發送。';
$lang['eventdesc-SearchInitiated']='搜尋開始時發送。';
$lang['eventdesc-SearchItemAdded']='當一個新的項目被索引時發送。';
$lang['eventdesc-SearchItemDeleted']='當一個索引被刪除時發送。';
$lang['eventhelp-SearchAllItemsDeleted']='<p>當所有索引被刪除時發送。</p>
<h4>參數</h4>
<ul>
<li>無</li>
</ul>';
$lang['eventhelp-SearchCompleted']='<p>搜尋完成時發送。</p>
<h4>參數</h4>
<ol>
<li>被搜尋的文字。</li>
<li>完成結果的陣列。</li>
</ol>';
$lang['eventhelp-SearchInitiated']='<p>搜尋開始時發送。</p>
<h4>參數</h4>
<ol>
<li>被搜尋的文字。</li>
</ol>';
$lang['eventhelp-SearchItemAdded']='<p>當一個新的項目被索引時發送。</p>
<h4>參數</h4>
<ol>
<li>模組名稱。</li>
<li>這個項目的Id。</li>
<li>額外的屬性。</li>
<li>內容索引和添加。</li>
</ol>';
$lang['eventhelp-SearchItemDeleted']='<p>當一個索引被刪除時發送。</p>
<h4>參數</h4>
<ol>
<li>模組名稱。</li>
<li>這個項目的Id。</li>
<li>額外的屬性。</li>
</ol>';
$lang['export_to_csv']='匯出至 CSV';
$lang['help']='<h3>What does this do?</h3>
<p>Search is a module for searching "core" content along with certain registered modules.  You put in a word or two and it gives you back matching, relevant results.</p>
<h3>How do I use it?</h3>
<p>The easiest way to use it is with the {search} wrapper tag (wraps the module in a tag, to simplify the syntax). This will insert the module into your template or page anywhere you wish, and display the search form.  The code would look something like: <code>{search}</code></p>
<h4>How do i prevent certain content from being indexed</h4>
<p>The search module will not search any "inactive" pages. However on occasion, when you are using the CustomContent module, or other smarty logic to show different content to different groups of users, it may be advisiable to prevent the entire page from being indexed even when it is live.  To do this include the following tag anywhere on the page <em><!-- pageAttribute: NotSearchable --></em> When the search module sees this tag in the page it will not index any content for that page.</p>
<p>The <em><!-- pageAttribute: NotSearchable --></em> tag can be placed in the template as well.  if this is done, none of the pages attached to that template will be indexed.  Those pages will be re-indexed if the tag is removed</p>
';
$lang['input_resetstopwords']='載入';
$lang['noresultsfound']='沒有資料！';
$lang['options']='選項';
$lang['param_searchtext']='搜尋欄位中顯示的文字';
$lang['param_submit']='提交按鈕中顯示的文字';
$lang['prompt_resetstopwords']='從以下語言載入預設的停止詞';
$lang['prompt_searchtext']='預設搜尋文字';
$lang['reindexallcontent']='重建所有內容';
$lang['reindexcomplete']='重新建立完成！';
$lang['resulttemplate']='結果模板';
$lang['resulttemplateupdated']='結果模板更新';
$lang['search']='搜尋';
$lang['searchresultsfor']='搜尋結果';
$lang['searchsubmit']='提交';
$lang['searchtemplate']='搜尋模板';
$lang['searchtemplateupdated']='搜索模板更新';
$lang['statistics']='統計';
$lang['stopwords']='停止詞';
$lang['submit']='提交';
$lang['sysdefaults']='還原為預設值';
$lang['timetaken']='拍攝搜尋到資料';
$lang['usestemming']='使用詞幹 (只有英文)';
$lang['word']='搜尋文字';
?>