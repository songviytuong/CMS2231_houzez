<?php
$lang['addarticle'] = 'Haber Ekle';
$lang['addcategory'] = 'Kategori Ekle';
$lang['addfielddef'] = 'Alan Ekle';
$lang['addnewsitem'] = 'Haber Öğesi Ekle';
$lang['allcategories'] = 'Tüm Kategoriler';
$lang['allentries'] = 'Tüm Girdiler';
$lang['allow_summary_wysiwyg'] = 'Özet alanında WYSIWYG editore izin ver';
$lang['anonymous'] = 'Anonim';
$lang['apply'] = 'Uygula';
$lang['approve'] = 'Durumu \'Yayınlandı\' olarak değiştir';
$lang['areyousure'] = 'Silmek istediğinizden emin misiniz?';
$lang['areyousure_deletemultiple'] = 'Seçilen haberleri kalıcı olarak silmek istediğinize emin misiniz? Bu durum geri alınamaz!';
$lang['article'] = 'Makale';
$lang['articleadded'] = 'Haber başarılı olarak eklendi.';
$lang['articledeleted'] = 'Haber başarılı olarak silindi.';
$lang['articles'] = 'Haberler';
$lang['articleupdated'] = 'Haber başarılı olarak güncellendi.';
$lang['author'] = 'Yazar';
$lang['author_label'] = 'Gönderen:';
$lang['bulk_delete'] = 'Sil';
$lang['bulk_setcategory'] = 'Kategori Belirle';
$lang['bulk_setdraft'] = 'İncelemede';
$lang['bulk_setpublished'] = 'Yayınlandı';
$lang['browsecattemplate'] = 'Kategori şablonları';
$lang['cancel'] = 'Vazgeç';
$lang['categories'] = 'Kategoriler';
$lang['category'] = 'Kategori';
$lang['categoryadded'] = 'Kategori başarılı olarak eklendi.';
$lang['categorydeleted'] = 'Kategori başarılı olarak silindi.';
$lang['categoryupdated'] = 'Kategori başarılı olarak güncellendi.';
$lang['category_label'] = 'Kategori:';
$lang['checkbox'] = 'Checkbox';
$lang['close'] = 'Kapat';
$lang['content'] = 'İçerik';
$lang['customfields'] = 'Alan Tanımlamaları';
$lang['dateformat'] = '%s geçerli bir yyyy-mm-dd hh:mm:ss biçimi değil';
$lang['default_category'] = 'Varsayılan kategori';
$lang['default_templates'] = 'Varsayılan Şablonlar';
$lang['delete'] = 'Sil';
$lang['delete_article'] = 'Makaleyi Sil';
$lang['delete_selected'] = 'Seçilen Haberleri Sil';
$lang['deprecated'] = 'desteklenmiyor';
$lang['description'] = 'Haber girdileri ekle, düzenle ve sil';
$lang['desc_news_settings'] = 'Haberler Modülü Ayarları';
$lang['detailtemplate'] = 'Ayrıntı Şablonu';
$lang['detailtemplateupdated'] = 'Düzenlenen Ayrıntı Şablonu başarılı olarak veritabanına kaydedildi.';
$lang['detail_page'] = 'Ayrıntı Sayfası';
$lang['detail_template'] = 'Ayrıntı Şablonu';
$lang['displaytemplate'] = 'Şablonu Göster';
$lang['down'] = 'Aşağı';
$lang['draft'] = 'Taslak';
$lang['edit'] = 'Düzenle';
$lang['editarticle'] = 'Makale Düzenle';
$lang['editcategory'] = 'Kategori Düzenle';
$lang['editfielddef'] = 'Alan Tanımı Düzenle';
$lang['enddate'] = 'Bitiş Tarihi';
$lang['endrequiresstart'] = 'Bitiş tarihihi girmek başlangıç tarihini girmeyi de gerektirir';
$lang['entries'] = '%s Girdi';
$lang['error_duplicatename'] = 'Bu ada sahip bir öğe zaten var';
$lang['error_filesize'] = 'Yüklenen dosyanın boyutu izin verilen dosya boyutundan fazla';
$lang['error_insufficientparams'] = 'Yetersiz (veya boş) parametre';
$lang['error_invaliddates'] = 'Bir yada daha fazla tarih yanlış girirldi';
$lang['error_invalidfiletype'] = 'Bu dosya tipini yükleyemezsiniz';
$lang['error_invalidurl'] = 'Geçersiz URL <em> (zaten kullanılmış veya geçersiz karakter içeriyor) </ em>';
$lang['error_mkdir'] = 'Klasör oluşturulamadı: %s';
$lang['error_movefile'] = 'Dosya oluşturulamadı: %s';
$lang['error_noarticlesselected'] = 'Hiç Haber Seçilmedi';
$lang['error_templatenamexists'] = 'Şablon adı zaten var';
$lang['error_upload'] = 'Dosya yükleme hatası oluştu';
$lang['eventdesc-NewsArticleAdded'] = 'Haber eklendiğinde gönderildi.';
$lang['eventhelp-NewsArticleAdded'] = '<p>Sent when an article is added.</p>
<h4>Parameters</h4>
<ul>
<li>\\"news_id\\" - Id of the news article</li>
<li>\\"category_id\\" - Id of the category for this article</li>
<li>\\"title\\" - Title of the article</li>
<li>\\"content\\" - Content of the article</li>
<li>\\"summary\\" - Summary of the article</li>
<li>\\"status\\" - Status of the article ("draft" or "publish")</li>
<li>\\"start_time\\" - Date the article should start being displayed</li>
<li>\\"end_time\\" - Date the article should stop being displayed</li>
<li>\\"useexp\\" - Whether the expiration date should be ignored or not</li>
</ul>';
$lang['eventdesc-NewsArticleDeleted'] = 'Haber silindiğinde gönderildi.';
$lang['eventhelp-NewsArticleDeleted'] = '<p>Sent when an article is deleted.</p>
<h4>Parameters</h4>
<ul>
<li>\\"news_id\\" - Id of the news article</li>
</ul>';
$lang['eventdesc-NewsArticleEdited'] = 'Haber düzenlendiğinde gönderildi.';
$lang['eventhelp-NewsArticleEdited'] = '<p>Sent when an article is edited.</p>
<h4>Parameters</h4>
<ul>
<li>\\"news_id\\" - Id of the news article</li>
<li>\\"category_id\\" - Id of the category for this article</li>
<li>\\"title\\" - Title of the article</li>
<li>\\"content\\" - Content of the article</li>
<li>\\"summary\\" - Summary of the article</li>
<li>\\"status\\" - Status of the article ("draft" or "publish")</li>
<li>\\"start_time\\" - Date the article should start being displayed</li>
<li>\\"end_time\\" - Date the article should stop being displayed</li>
<li>\\"useexp\\" - Whether the expiration date should be ignored or not</li>
</ul>';
$lang['eventdesc-NewsCategoryAdded'] = 'Kategori eklendiğinde gönderildi.';
$lang['eventhelp-NewsCategoryAdded'] = '<p>Sent when a category is added.</p>
<h4>Parameters</h4>
<ul>
<li>\\"category_id\\" - Id of the news category</li>
<li>\\"name\\" - Name of the news category</li>
</ul>';
$lang['eventdesc-NewsCategoryDeleted'] = 'Kategori silindiğinde gönderildi.';
$lang['eventhelp-NewsCategoryDeleted'] = '<p>Sent when a category is deleted.</p>
<h4>Parameters</h4>
<ul>
<li>\\"category_id\\" - Id of the deleted category </li>
<li>\\"name\\" - Name of the deleted category</li>
</ul>';
$lang['eventdesc-NewsCategoryEdited'] = 'Kategori düzenlendiğinde gönderildi.';
$lang['eventhelp-NewsCategoryEdited'] = '<p>Sent when a category is edited.</p>
<h4>Parameters</h4>
<ul>
<li>\\"category_id\\" - Id of the news category</li>
<li>\\"name\\" - Name of the news category</li>
<li>\\"origname\\" - The original name of the news category</li>
</ul>';
$lang['expired'] = 'Süresi Dolmuş';
$lang['expired_searchable'] = 'Süresi bitmiş haberler arama sonuçlarında çıkabilsin';
$lang['expiry'] = 'Süresi';
$lang['expiry_date_asc'] = 'Gerçerlilik Tarihi Artan';
$lang['expiry_date_desc'] = 'Geçerlilik Tarihi Azalan';
$lang['extra'] = 'Ekstra';
$lang['extra_label'] = 'Ekstra:';
$lang['fielddef'] = 'Alan Tanımlama';
$lang['fielddefadded'] = 'Alan Tanımı Eklendi';
$lang['fielddefdeleted'] = 'Tanımlanan Alan Silindi';
$lang['fielddefupdated'] = 'Alan Tanımı Güncellendi';
$lang['file'] = 'Dosya';
$lang['filter'] = 'Süz';
$lang['firstpage'] = '<<';
$lang['formtemplate'] = 'Form Şablonları';
$lang['help'] = '<h3>What does this do?</h3>
	<p>News is a module for displaying news events on your page, similar to a blog style, except with more features!.  When the module is installed, a News admin page is added to administration menu that will allow you to select or add a news category.  Once a news category is created or selected, a list of news items for that category will be displayed.  From here, you can add, edit or delete news items for that category.</p>
	<h3>Template variables</h3>
	<ul>
		<li><b>itemcount</b> - The number of news articles to be shown.</li>
		<li><b>entry->authorname</b> - The full name of the the author including First and Last name.</li>
	</ul>
	<h3>Security</h3>
	<p>The user must belong to a group with the \'Modify News\' permission in order to add, edit, or delete News entries.</p>
	<p>In order to edit the layout templates, the user must belong to a group with the \'Modify Templates\' permission.</p>
	<p>In order to edit the global news preferences, the user must belong to a group with the \'Modify Site Preferences\' permission.</p>
	<h3>How do I use it?</h3>
	<p>The easiest way to use it is with the {news} wrapper tag (wraps the module in a tag, to simplify the syntax).  This will insert the module into your template or page anywhere you wish, and display news items.  The code would look something like: <code>{news number=\'5\'}</code></p>';
$lang['helpaction'] = 'Override the default action.  Possible values are \'default\' to display the summary view, and \'fesubmit\' to display the frontend form for allowing users to submit news articles on the front end.';
$lang['helpbrowsecat'] = 'Taranabilir kategori listesini göster.';
$lang['helpcategory'] = 'Only display items for that category. <b>Use * after the name to show children.</b>  Multiple categories can be used if separated with a comma. Leaving empty, will show all categories.';
$lang['helpdetailtemplate'] = 'Use a separate template for displaying the article detail.  It have to live in modules/News/templates.';
$lang['helpmoretext'] = 'Text to display at the end of a news item if it goes over the summary length.  Defaults to "more..."';
$lang['helpnumber'] = 'Gösterilecek öğe sayısı =- boş bırakılırsa tüm öğeler gösterilir.';
$lang['helpshowall'] = 'Bitiş tarihine bakılmaksızın tüm haberleri göster';
$lang['helpshowarchive'] = 'Sadece süresi geçmiş haberleri göster.';
$lang['helpsortby'] = 'Field to sort by.  Options are: "news_date", "summary", "news_data", "news_category", "news_title".  Defaults to "news_date".';
$lang['helpstart'] = 'Başlangıç öğe sayısı -- boş bırakılırsa ilk öğeden başlanır.';
$lang['helpsummarytemplate'] = 'Use a separate template for displaying the article summary.  It have to live in modules/News/templates.';
$lang['help_pagelimit'] = 'Maximum number of items to display (per page).  If this parameter is not supplied all matching items will be displayed.  If it is, and there are more items available than specified in the pararamter, text and links will be supplied to allow scrolling through the results';
$lang['info_maxlength'] = 'Maksimum uzunluğu yalnızca metin giriş alanları için geçerlidir.';
$lang['info_sysdefault'] = '<em>(the content used by default when a new template is created)</em>';
$lang['info_sysdefault2'] = '<strong>Note:</strong> This tab contains text areas to allow you to edit a set of templates that are displayed when you create a \'new\' summary, detail, or form template.  Changing content in this tab, and clicking \'submit\' will <strong>not effect any current displays</strong>.';
$lang['lastpage'] = '>>';
$lang['maxlength'] = 'Maksimum Uzunluk';
$lang['more'] = 'Devamı';
$lang['moretext'] = 'Fazla yazı';
$lang['name'] = 'İsim';
$lang['nameexists'] = 'Tanımlı alan adı zaten var';
$lang['needpermission'] = 'Bu işlemi yapmak için \'%s\' yetkinizin olması gerekir.';
$lang['newcategory'] = 'Yeni Kategori';
$lang['news'] = 'Haberler';
$lang['news_return'] = 'Geri dön';
$lang['nextpage'] = '>';
$lang['nocategorygiven'] = 'Kategori girilmemiş';
$lang['nocontentgiven'] = 'İçerik girilmemiş';
$lang['noitemsfound'] = 'Kategori için <strong>hiç</strong> öğe bulunamadı: %s';
$lang['nonamegiven'] = 'İsim girilmemiş';
$lang['none'] = 'Yok';
$lang['nopostdategiven'] = 'Gönderme Tarihi girilmemiş';
$lang['notanumber'] = 'Maksimum Uzunluk Sayı Değil';
$lang['note'] = '<em>Not:</em> Tarihler \'yyyy-mm-dd hh:mm:ss\' biçiminde olmalıdır.';
$lang['notify_n_draft_items'] = '%s sayıda yayınalnmamış haber var';
$lang['notify_n_draft_items_sub'] = '%d Haber Yazıları(s)';
$lang['notitlegiven'] = 'Başlık girilmemiş';
$lang['numbertodisplay'] = 'Gösterilecek adet (boş bırakılırsa tüm kayıtlar gösterilir)';
$lang['options'] = 'Seçenekler';
$lang['optionsupdated'] = 'Seçenekler başarılı olarak güncellendi.';
$lang['postdate'] = 'Gönderme Tarihi';
$lang['postinstall'] = 'Make sure to set the "Modify News" permission on users who will be administering News items.';
$lang['post_date_asc'] = 'Gönderim Tarihi Artan';
$lang['post_date_desc'] = 'Gönderim Tarihi Azalan';
$lang['preview'] = 'Önizleme';
$lang['prevpage'] = '<';
$lang['print'] = 'Yazdır';
$lang['prompt_default'] = 'Varsayılan';
$lang['prompt_name'] = 'Adı';
$lang['prompt_newtemplate'] = 'Yeni Şablon Yarat';
$lang['prompt_of'] = '-';
$lang['prompt_page'] = 'Sayfa';
$lang['prompt_pagelimit'] = 'Sayfa Limiti';
$lang['prompt_sorting'] = 'Sırala';
$lang['prompt_template'] = 'Şablon Kaynağı';
$lang['prompt_templatename'] = 'Şablon Adı';
$lang['public'] = 'Genel';
$lang['published'] = 'Yayınlandı';
$lang['reassign_category'] = 'Kategori değiştir';
$lang['removed'] = 'Geri Alındı';
$lang['reorder'] = 'Sırala';
$lang['reorder_categories'] = 'Kategorileri Sırala';
$lang['reset'] = 'Sıfırla';
$lang['resettodefault'] = 'Varsayılan Ayarlara Geri Dön';
$lang['restoretodefaultsmsg'] = 'Bu işlem şablon içeriğini sistem varsayılanlarına çevirecektir. Devam etmek istediğinizden emin misiniz?';
$lang['revert'] = 'Durumu \'Taslak\' olarak değiştir';
$lang['searchable'] = 'Aranabilir';
$lang['select'] = 'Seçiniz';
$lang['select_option'] = 'Seçiniz';
$lang['selectall'] = 'Hepisini Seç';
$lang['selectcategory'] = 'Kategori Seçin';
$lang['showchildcategories'] = 'Alt kategorileri göster';
$lang['sortascending'] = 'Büyükten küçüğe sırala';
$lang['startdate'] = 'Başlangıç Tarihi';
$lang['startdatetoolate'] = 'Başlangıç ​​Tarihi bitiş tarihinden sonra olamaz';
$lang['startoffset'] = 'n\'inci öğeden başlayarak göster';
$lang['startrequiresend'] = 'Başlangıç tarihini girmek bitiş tarihini de girmeyi gerektirir';
$lang['status'] = 'Durum';
$lang['status_asc'] = 'Duruma Göre Azalan';
$lang['status_desc'] = 'Duruma Göre Azalan';
$lang['subject_newnews'] = 'Yeni bir haber makalesi gönderildi';
$lang['submit'] = 'Gönder';
$lang['summary'] = 'Özet';
$lang['summarytemplate'] = 'Özet Şablonu';
$lang['summarytemplateupdated'] = 'Haber Özet Şablonu başarılı olarak güncellendi.';
$lang['sysdefaults'] = 'Varsayılanlara dön';
$lang['template'] = 'Şablon';
$lang['title'] = 'Başlık';
$lang['title_asc'] = 'Başlığa Göre Artan';
$lang['title_available_templates'] = 'Kullanılabilir Şablonlar';
$lang['title_desc'] = 'Başlığa Göre Azalan';
$lang['title_detail_returnid'] = 'Ayrıntılı görünüm için varsayılan sayfa';
$lang['title_detail_settings'] = 'Ayrıntılı Görünüm Ayarları';
$lang['title_detail_sysdefault'] = 'Varsayılan Ayrıntı Şablonu';
$lang['title_detail_template'] = 'Ayrıntı Şablon Editörü';
$lang['title_fesubmit_settings'] = 'Ön sayfa ekleme ayarları';
$lang['title_filter'] = 'Filtreler';
$lang['title_form_sysdefault'] = 'Varsayılan Form Şablonu';
$lang['title_form_template'] = 'Form Şablonu Editörü';
$lang['title_notification_settings'] = 'Bilgilendirme Ayarları';
$lang['title_submission_settings'] = 'Haber Giriş Ayarları';
$lang['title_summary_sysdefault'] = 'Varsayılan Özet Şablonu';
$lang['title_summary_template'] = 'Özet Şablon Editörü';
$lang['type'] = 'Tip';
$lang['type_browsecat'] = 'Kategoriler';
$lang['type_detail'] = 'Ayrıntı';
$lang['type_News'] = 'Haberler';
$lang['type_summary'] = 'Özet';
$lang['unknown'] = 'Bilinmiyor';
$lang['unlimited'] = 'Limitsiz';
$lang['up'] = 'Yukarı';
$lang['uploadscategory'] = 'Yüklemeler Kategorisi';
$lang['url'] = 'URL';
$lang['useexpiration'] = 'Süresi geçme tarihini kullan';
$lang['viewfilter'] = 'Filtre';
$lang['ga'] = 'GA1.2.1213517334.1478519479';
?>