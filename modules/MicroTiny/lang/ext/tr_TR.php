<?php
$lang['admindescription'] = 'A stripped down, but still powerfull implementation of the TinyMCE WYSIWYG editor.';
$lang['browse'] = 'Gözat';
$lang['cancel'] = 'İptal';
$lang['class'] = 'Sınıf';
$lang['cmsms_linker'] = 'İç sayfa linki';
$lang['css_styles_help2'] = 'The styles can either be just the class name, or a classname with a new name to show.
Must be sepereated by either commas or newlines.
<br/>Example: mystyle1, My style name=mystyle2
<br/>Result: a dropdown containing 2 entries, \'mystyle1\' and \'My style name\' resulting in the insertion of mystyle1, and mystyle2 respectively.
<br/>Note: No checking for the actual existence of the stylenames is done. They are used blindly.';
$lang['description'] = 'Açıklama';
$lang['dimensions'] = 'GxY';
$lang['dimension'] = 'ölçüler';
$lang['edit_image'] = 'Resim Düzenle';
$lang['edit_profile'] = 'Profil Düzenle';
$lang['filepickertitle'] = 'Dosya Seçici';
$lang['help'] = '<h3>What Does This Do?</h3>
<p>MicroTiny is a small, restricted version of the TinyMCE-editor, formerly the wysiwyg-default of CMS Made Simple. This provides nothing more than the basics of editing, but is still a powerful tool allowing easy changes to content pages.</p>
<p>This module provides very few options and is designed to allow limited functionality to content editors with no knowledge of HTML.  The intent is that they will have very few options to be able to mess with the layout of a page, or the look and feel of a site.</p>
<h3>How Do I Use It?</h3>
<p>The MicroTiny test area should appear automatically (for users with sufficient permission) under the "Extensions >> MicroTiny WYSIWYG Editor" option in the CMSMS admin console.</p>
</p>In order for MicroTiny to be used as the wysiwyg editor when editing pages, the MicroTiny Wysiwyg Editor needs to be selected in the users preferences.  Please select "MicroTiny" in the "Select WYSIWYG to Use" option under "My Preferences >> User Preferences" in the CMSMS Admin panel.  Additional options in various modules or in content page templates, and content pages themselves  can control wether a text area or a wysiwyg field is provided in various edit forms.</p>
<h3>About Styles and Colors</h3>
<p>MicroTiny will read the stylesheets attached to the appropriate template <em>(if no template can be easily determined the default template and its stylesheets are used)</em>. and strip out background images in order to allow visualizing your text in an environment as close as possible to what will appear on the web page.  If your theme uses a dark background, along with background images on your styles you may experience problems.   We suggest that you always include a color on your background specifications.  i.e:
<pre><code>body {
 color: #eee;
 background: <span style="color: blue;">#ddd</span> url(path/to/an/image.jpg);
} 
</pre></code>
<h3>What about Frontend Wysiwygs</h3>
<p>From time to time it may be necessary to provide a wysiwyg text area with limited functionality to frontend editors.   To do this, you will need to follow two steps <em>(subject to change in future versions of CMSMS).</em>:
<ul>
  <li>Set MicroTiny as the Frontend Wysiwyg in the "Site Admin >> Gobal Settings" page on the "General Settings" tab.</li>
  <li>Add the tag {MicroTiny action=enablewysiwg} call to the pages where the wysiwhg editor will be used.  This can either be done in the head section of the page template, in the global metadata, or in the page specific metadata sections.  This tag takes no additional parameters.</li>
</ul>
</p>';
$lang['loading_info'] = 'Yükleniyor...';
$lang['ok'] = 'Tamam';
$lang['profile_label'] = 'Etiket';
$lang['prompt_name'] = 'İsim';
$lang['prompt_target'] = 'Hedef';
$lang['savesettings'] = 'Ayarları Kaydet';
$lang['settings'] = 'Ayarlar';
$lang['settingssaved'] = 'Ayarlar kaydedildi';
$lang['size'] = 'Boyut';
$lang['submit'] = 'Gönder';
$lang['switchgrid'] = 'Tablo Görünümü';
$lang['switchlist'] = 'Liste Görünümü';
$lang['switchimage'] = 'Resimleri göster';
$lang['switchvideo'] = 'Videoları göster';
$lang['switchaudio'] = 'Ses Dosyalarını göster';
$lang['switcharchive'] = 'Arşiv dosyalarını göster';
$lang['switchfiles'] = 'Dosyaları göster';
$lang['switchreset'] = 'Hepsini Göster';
$lang['title_cmsms_filebrowser'] = 'Dosya Seç';
$lang['title_edit_profile'] = 'Profil düzenle';
$lang['tab_general_title'] = 'Genel';
$lang['tab_advanced_title'] = 'Gelişmiş';
$lang['type'] = 'Tip';
$lang['width'] = 'Genişlik';
$lang['view_source'] = 'Kaynağı Göster';
$lang['youareintext'] = 'Geçerli Klasör';
?>