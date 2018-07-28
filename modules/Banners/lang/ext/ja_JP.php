<?php
$lang['error_bannerexists'] = 'すでにある名前がつけられたバナー';
$lang['accessdenied'] = 'アクセスが拒否されました。パーミッションを確認してください。';
$lang['addbanner'] = 'バナーを追加';
$lang['addcategory'] = 'カテゴリを追加';
$lang['areyousure'] = 'よろしいですか？';
$lang['banners'] = 'バナー';
$lang['cancel'] = 'キャンセル';
$lang['categories'] = 'カテゴリ';
$lang['category'] = 'カテゴリ';
$lang['created'] = 'Created';
$lang['date'] = '日付';
$lang['delete'] = '削除';
$lang['description'] = 'Description';
$lang['edit'] = '編集';
$lang['editcategory'] = 'カテゴリを編集';
$lang['error'] = 'エラー!';
$lang['error_banerexists'] = 'すでにある名前がつけられたバナー';
$lang['error_categorynotempty'] = 'エラー：カテゴリは空ではありません!';
$lang['error_dberror'] = 'エラー：データベースエラー!';
$lang['error_emptybannername'] = 'エラー：バナー名がありません!';
$lang['error_emptycategory'] = 'エラー：カテゴリが空です!';
$lang['error_insufficientparams'] = 'エラー：入力不足';
$lang['error_nocategories'] = 'エラー：カテゴリが見つかりません。';
$lang['error_noresults'] = 'クエリにあうバナーが見つかりません。';
$lang['error_textorimage'] = 'URLと、画像かテキスト(両方は不可)を指定';
$lang['expires'] = '期限切れ';
$lang['friendlyname'] = 'バナーを管理';
$lang['height'] = '高さ';
$lang['hits'] = 'ヒット';
$lang['href_text'] = 'リンクテキスト';
$lang['id'] = 'ID';
$lang['image'] = '画像';
$lang['image_text'] = 'Alt画像テキスト';
$lang['impressions'] = 'Impressions';
$lang['info_href_text'] = 'Additional text for the link tag.  This text is placed in the link tag verbatim';
$lang['info_image'] = 'Specify a file relative to your uploads directory';
$lang['info_image_text'] = 'Additional text for the image tag';
$lang['info_max_hits'] = 'Use 0 for unlimited hits';
$lang['info_max_impressions'] = 'Use 0 for unlimited impressions';
$lang['installed'] = 'Module version %s installed.';
$lang['ipaddress'] = 'IPアドレス';
$lang['max_hits'] = '最大ヒット数';
$lang['max_impressions'] = 'Maximum Impressions';
$lang['name'] = 'Name';
$lang['never'] = 'Never';
$lang['postinstall'] = 'Post Install Message, e.g., Be sure to set "Manage Banners" permissions to use this module!';
$lang['postuninstall'] = 'Banners module uninstalled, and all database tables removed.  Sorry to see you leave."';
$lang['preferences'] = 'プレファレンス';
$lang['prefsupdated'] = 'モジュールプレファレンスが更新されました。';
$lang['prompt_categorydesc'] = 'Category Description';
$lang['prompt_categoryname'] = 'カテゴリ名';
$lang['prompt_imageheight'] = '画像高さ';
$lang['prompt_imagewidth'] = '画像幅';
$lang['prompt_subnet_exclusions'] = 'Exclude these subnets from any statistics gathering';
$lang['prompt_upload_category'] = 'カテゴリ(アップロードモジュール)';
$lang['prompt_upload_file'] = '画像(アップロードモジュール)';
$lang['selectcategory'] = 'カテゴリを選択';
$lang['submit'] = '送信';
$lang['text'] = 'テキスト';
$lang['title_mod_admin'] = 'モジュール管理パネル';
$lang['title_mod_prefs'] = 'モジュールプレファレンス';
$lang['uninstalled'] = 'モジュールがアンインストールされました。';
$lang['upgraded'] = 'モジュールがバージョン%sにアップグレードされました。';
$lang['url'] = 'URL';
$lang['width'] = '幅';
$lang['title_admin_panel'] = 'バナーモジュール';
$lang['moddescription'] = 'A module to manage rotating banners';
$lang['welcome_text'] = '<p>Welcome to the Banner Management Module admin section. Something else would probably go here if the module actually did something.</p>';
$lang['changelog'] = '<ul>
<li>Version 1.0. 6 August 2005. Initial Release.</li>
<li>Version 2.0. September 2005. Initial Release for 0.1..</li>
<li>Version 2.0.1. September 2005. Display sample banner in the edit banner page, added name= parameter, and made subnet exclusions work.  Also changed the definition of the database to allow for additional text in the link and image tags.</li>
<li>Version 2.0.2. September 2005. Added integration with the uploads module (1.0.6) so that we can get lits of files for banners, etc.  The banners module is still optional though.</li>
<li>Version 2.0.3. September 2005. Fixed a very minor issue with never expires..</li>
<li>Version 2.0.4. September 2005. Fixed a very minor issue with module dependencies, and a big bug in the database spec if you did a scratch install.</li>
<li>Version 2.0.5. October 2005. Add coments around the output</li>
<li>Version 2.0.6. December 2005. Minor validation fixes, description is now output between the <img>and</img> tags, and an alt attribute is in the img tag.</li>
<li>Version 2.0.7. January 2006. More validation fixes, Moved the admin tabs around, fixed an issue where you could almost create a banner without defining a category, and... fixed the expiry date issue for good (hopefully).</li>
</ul>';
$lang['help'] = '<h3>What Does This Do?</h3>
<p>This banner manages numerous categories of banners, tracks hits, impressions, and expiry dates, and randomly selects from all available and valid banners for one to display</p>
<h3>How Do I Use It</h3>
<p>To use this module, place the module code in a page or template using the smarty tag {cms_module module=\'Banners\' category="<category>"}</p> 
<p>You must also upload banners to a suitable directory within the uploads directory and must use the admin panel interface to add banners to the database.</p
<h3>Parameters</h3>
<ul>
<li><em>(REQUIRED)</em> category="category" = randomly select from all available in this category</li>
<li><em>(optional)</em> name="name" = select only the banner with this name</li>
</ul>
<h4>Hint</h4>
<p>The uploads module and the banners module work well together.  You can create a "banners" category in the uploads module, and upload your banner images there, then specify "banners/<filename>" when adding a banner in the banners module.</p>';
?>