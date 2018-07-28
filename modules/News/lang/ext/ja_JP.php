<?php
$lang['addarticle']='記事の追加';
$lang['addcategory']='カテゴリの追加';
$lang['addnewsitem']='ニュース項目の追加';
$lang['allcategories']='全カテゴリ';
$lang['allentries']='全エントリー';
$lang['approve']='ステータスを「公開」に設定しました。';
$lang['areyousure']='削除しますか?';
$lang['areyousure_deletemultiple']='Are you sure you want to delete all of these news articles?\nThis action cannot be undone!';
$lang['articleadded']='記事を追加しました。';
$lang['articledeleted']='記事を削除しました。';
$lang['articles']='記事';
$lang['articleupdated']='記事を更新しました。';
$lang['author']='作成者';
$lang['author_label']='投稿者:';
$lang['browsecattemplate']='カテゴリ・テンプレートを見る。';
$lang['cancel']='キャンセル';
$lang['categories']='カテゴリ';
$lang['category']='カテゴリ';
$lang['category_label']='カテゴリ:';
$lang['categoryadded']='カテゴリを追加しました。';
$lang['categorydeleted']='カテゴリを削除しました。';
$lang['categoryupdated']='カテゴリを更新しました。';
$lang['checkbox']='チェックボックス';
$lang['content']='コンテンツ';
$lang['dateformat']='%sは有効なフォーマットではありません。「yyyy-mm-dd hh:mm:ss」の必要があります。';
$lang['default_category']='デフォルトカテゴリ';
$lang['default_templates']='デフォルト・テンプレート';
$lang['delete']='削除';
$lang['delete_selected']='選択した項目を削除しました。';
$lang['description']='ニュースエントリーの追加、編集、削除';
$lang['detailtemplate']='テンプレートの詳細';
$lang['detailtemplateupdated']='更新された詳細テンプレートは正常にデータベースに保存されました。';
$lang['displaytemplate']='テンプレートの表示';
$lang['down']='下';
$lang['draft']='ドラフト';
$lang['edit']='編集';
$lang['editfielddef']='項目定義の編集';
$lang['enddate']='終了日';
$lang['endrequiresstart']='終了日を入力する際に開始日も必要';
$lang['entries']='%sのエントリー';
$lang['eventdesc-NewsArticleAdded']='記事の追加時に送信';
$lang['eventdesc-NewsArticleDeleted']='記事の削除時に送信';
$lang['eventdesc-NewsArticleEdited']='記事の編集時に送信';
$lang['eventdesc-NewsCategoryAdded']='カテゴリーの追加時に送信';
$lang['eventdesc-NewsCategoryDeleted']='カテゴリの削除時に送信';
$lang['eventdesc-NewsCategoryEdited']='カテゴリの編集時に送信';
$lang['eventhelp-NewsArticleAdded']='<p>記事の追加時に送信</p>
<h4>パラメーター</h4>
<ul>
<li>\"news_id\" - ニュース記事のID</li>
<li>\"category_id\" -  該当記事に対するカテゴリーのID</li>
<li>\"title\" - 記事のタイトル</li>
<li>\"content\" - 記事の内容</li>
<li>\"summary\" - 記事の要約</li>
<li>\"status\" - 記事の状態 ("ドラフト" 又は "公開")</li>
<li>\"start_time\" - 記事の公開開始日</li>
<li>\"end_time\" - 記事の公開終了日</li>
</ul>
';
$lang['eventhelp-NewsArticleDeleted']='<p>記事の削除時に送信</p>
<h4>パラメーター</h4>
<ul>
<li>\"news_id\" - ニュース記事のID</li>
</ul>
';
$lang['eventhelp-NewsArticleEdited']='<p>記事の編集時に送信</p>
<h4>パラメーター</h4>
<ul>
<li>\"news_id\" - ニュース記事のID</li>
<li>\"category_id\" - 該当記事に対するカテゴリーのID</li>
<li>\"title\" - 記事のタイトル</li>
<li>\"content\" - 記事の内容</li>
<li>\"summary\" - 記事の要約</li>
<li>\"status\" - 記事の状態 ("ドラフト" 又は "公開")</li>
<li>\"start_time\" - 記事の公開開始日</li>
<li>\"end_time\" - 記事の公開終了日</li>
</ul>
';
$lang['eventhelp-NewsCategoryAdded']='<p>カテゴリーの追加時に送信</p>
<h4>パラメーター</h4>
<ul>
<li>\"category_id\" - ニュースカテゴリーのID</li>
<li>\"name\" - ニュースカテゴリーの名前</li>
</ul>
';
$lang['eventhelp-NewsCategoryDeleted']='<p>カテゴリの削除時に送信</p>
<h4>パラメーター</h4>
<ul>
<li>\"category_id\" - ニュースのID</li>
</ul>
';
$lang['eventhelp-NewsCategoryEdited']='<p>カテゴリの編集時に送信</p>
<h4>パラメーター</h4>
<ul>
<li>\"category_id\" - ニュースカテゴリーのID</li>
<li>\"name\" - ニュースカテゴリーの名前</li>
</ul>
';
$lang['expiry']='有効期限';
$lang['fielddef']='項目定義';
$lang['fielddefadded']='項目定義を追加しました。';
$lang['fielddefupdated']='項目定義を更新しました。';
$lang['file']='ファイル';
$lang['filter']='フィルター';
$lang['firstpage']='<<';
$lang['help']='	<h3>何ができるのでしょうか?</h3>
	<p>ニュースはページにニュースイベントを表示するモジュールで、多くの機能があり、例えばブログのような利用ができます。モジュールがインストールされると、ニュース管理ページが管理メニューに追加され、ニュースの管理はメニューから利用できます。ニュースカテゴリーが一旦作成、選択されると、該当カテゴリーのニュース項目がリスト表示されます。そこから、そのニュース項目の追加、編集、削除等が行えます。</p>
	<h3>セキュリティ</h3>
	<p>利用ユーザーは、入力や編集等の作業を行う為に、必ず\'ニュースの修正\'パーミッションを持ったグループに所属する必要があります。</p>
	<h3>使用方法</h3>
	<p>もっとも簡単な利用方法はcms_moduleタグと合わて使うことです。この方法はモジュールをテンプレートやページのどこかニュース項目を表示したい場所に挿入することです。コードの形式は以下のようになります： <code>{cms_module module="news" number="5" category="beer"}</code></p>';
$lang['help_pagelimit']='Maximum number of items to display (per page).  If this parameter is not supplied all matching items will be displayed.  If it is, and there are more items available than specified in the pararamter, text and links will be supplied to allow scrolling through the results';
$lang['helpaction']='Override the default action.  Possible values are \'default\' to display the summary view, and \'fesubmit\' to display the frontend form for allowing users to submit news articles on the front end.';
$lang['helpcategory']='該当カテゴリとその子カテゴリの項目だけを表示。空欄の場合は全カテゴリを表示。';
$lang['helpdetailpage']='ニュース詳細を表示するページ。ページのエイリアスまたはIDを使用できます。記事概要と異なるテンプレートで表示させる場合に使います。';
$lang['helpdetailtemplate']='記事詳細の表示に別のテンプレートを使用。ファイルはmodules/News/templatesに置く必要があります。';
$lang['helpmoretext']='要約のサイズを超えている場合に、ニュース項目を最後まで表示します。デフォルトは"さらに表示..."。';
$lang['helpnumber']='表示できる項目の最大数の値 -- 空欄の場合は全項目を表示';
$lang['helpsortasc']='ニュース項目を昇順に並べ替え。';
$lang['helpsortby']='並び替えの優先項目。項目は: "news_date"、"summary"、"news_data"、"news_category"、"news_title"。デフォルトは"news_date"。';
$lang['helpstart']='○番目の項目からスタート -- 空欄の場合は最初からスタート';
$lang['helpsummarytemplate']='要約記事の表示に別のテンプレートを利用。 ファイルはmodules/News/templatesに置く必要があります。';
$lang['info_sysdefault']='<em>(the content used by default when a new template is created)</em>';
$lang['lastpage']='>>';
$lang['maxlength']='最大長さ';
$lang['more']='さらに表示';
$lang['moretext']='さらにテキストを表示';
$lang['name']='名前';
$lang['needpermission']='この機能を利用するには\'%s\'パーミッションが必要です。';
$lang['newcategory']='新規カテゴリ';
$lang['news']='ニュース';
$lang['news_return']='戻る';
$lang['nextpage']='>';
$lang['nocategorygiven']='カテゴリが存在しません。';
$lang['nocontentgiven']='コンテンツが存在しません。';
$lang['noitemsfound']='カテゴリ%sに対する項目がありません。';
$lang['nonamegiven']='名前が存在しません。';
$lang['none']='なし';
$lang['nopostdategiven']='投稿日付がありません。';
$lang['note']='<em>注意:</em> 日付は\'yyyy-mm-dd hh:mm:ss\'フォーマットの必要があります。';
$lang['notitlegiven']='タイトルが存在しません。';
$lang['numbertodisplay']='表示数(空欄の場合は全てのレコードが表示されます)';
$lang['options']='オプション';
$lang['optionsupdated']='オプションは正常に更新されました。';
$lang['postdate']='投稿日';
$lang['postinstall']='ニュース項目を管理するユーザーには"ニュースを修正"パーミッションを設定する必要があります。';
$lang['prevpage']='<';
$lang['print']='印刷';
$lang['prompt_default']='デフォルト';
$lang['prompt_name']='名';
$lang['prompt_newtemplate']='テンプレートを作成する。';
$lang['prompt_page']='ページ';
$lang['prompt_sorting']='ソート';
$lang['prompt_template']='テンプレート・ソース';
$lang['prompt_templatename']='テンプレート名';
$lang['public']='公開';
$lang['published']='公開';
$lang['removed']='削除しました。';
$lang['restoretodefaultsmsg']='テンプレートの設定をデフォルトに戻します。本当に実行しますか？';
$lang['revert']='ステータスを「ドラフト」に設定しました。';
$lang['select']='選択';
$lang['selectcategory']='カテゴリの選択';
$lang['showchildcategories']='子カテゴリを表示';
$lang['sortascending']='昇順並び替え';
$lang['startdate']='開始日';
$lang['startoffset']='○番目の項目から表示';
$lang['startrequiresend']='開始日を入力する際に終了日も必要';
$lang['status']='ステータス';
$lang['status_asc']='ステータス昇順';
$lang['status_desc']='ステータス降順';
$lang['submit']='送信';
$lang['summary']='要約';
$lang['summarytemplate']='要約テンプレート';
$lang['summarytemplateupdated']='ニュース要約テンプレートは正常に更新されました。';
$lang['sysdefaults']='デフォルトに戻す';
$lang['template']='テンプレート';
$lang['textarea']='テキストエリア';
$lang['textbox']='テキスト';
$lang['title']='タイトル';
$lang['title_asc']='タイトル昇順';
$lang['title_desc']='タイトル降順';
$lang['title_detail_settings']='詳細表示設定';
$lang['title_filter']='フィルタ';
$lang['title_notification_settings']='通知設定';
$lang['type']='タイプ';
$lang['unknown']='知らない。';
$lang['unlimited']='上限値なし';
$lang['up']='上';
$lang['uploadscategory']='カテゴリのアップロード';
$lang['useexpiration']='期限切れ日付を使用';
?>
