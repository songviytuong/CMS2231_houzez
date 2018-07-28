<?php
$lang['error_bannerexists'] = 'Banner dengan nama tersebut sudah ada';
$lang['accessdenied'] = 'Akses ditolak. Mohon periksa wewenang Anda.';
$lang['addbanner'] = 'Menambah Banner';
$lang['addcategory'] = 'Menambah Kategori';
$lang['areyousure'] = 'Anda yakin?';
$lang['banners'] = 'Banner-banner';
$lang['cancel'] = 'Tunda';
$lang['categories'] = 'Kategori';
$lang['category'] = 'Kategori';
$lang['created'] = 'Dibuat';
$lang['date'] = 'Tanggal';
$lang['delete'] = 'Hapus';
$lang['description'] = 'Penjelasan';
$lang['edit'] = 'Memperbaiki';
$lang['editcategory'] = 'Memperbaiki kategori';
$lang['error'] = 'Salah !';
$lang['error_banerexists'] = 'Banner dengan nama tersebut sudah ada';
$lang['error_categorynotempty'] = 'Salah: Kategori Tidak Kosong!';
$lang['error_dberror'] = 'Salah: Kesalahan Database !';
$lang['error_emptybannername'] = 'Salah: Nama banner kosong!';
$lang['error_emptycategory'] = 'Salah: Kategori Kosong!';
$lang['error_insufficientparams'] = 'Salah: Masukkan tidak lengkap';
$lang['error_nocategories'] = 'Salah: Kategori tidak ada';
$lang['error_noresults'] = 'Tidak ada banner yang cocok dengan query';
$lang['error_textorimage'] = 'Menentukan URL dan GAMBAR atau TEKS, tidak keduanya';
$lang['expires'] = 'Kehabisan waktu';
$lang['friendlyname'] = 'Mengatur Banner';
$lang['height'] = 'Tinggi';
$lang['hits'] = 'Kunjungan';
$lang['href_text'] = 'Link Teks';
$lang['id'] = 'ID ';
$lang['image'] = 'Gambar';
$lang['image_text'] = 'Teks Untuk Gambar';
$lang['impressions'] = 'Jejak-jejak';
$lang['info_href_text'] = 'Teks tambahan untuk link tag.  Teks ini diletakkan di dalam link tag verbatim';
$lang['info_image'] = 'Tentukan sebuah file yang terkait dengan direktori unggah (uploads) Anda';
$lang['info_image_text'] = 'Teks tambahan untuk tag gambar';
$lang['info_max_hits'] = 'Gunakan 0 untuk kunjungan yang tidak terbatas';
$lang['info_max_impressions'] = 'Gunakan 0 untuk jejak tak terbatas';
$lang['installed'] = 'Modul versi %s terpasang.';
$lang['ipaddress'] = 'Alamat IP';
$lang['max_hits'] = 'Kunjungan Maksimum';
$lang['max_impressions'] = 'Jejak maksimum';
$lang['name'] = 'Nama';
$lang['never'] = 'Tidak pernah';
$lang['postinstall'] = 'Post Install Message, e.g., Be sure to set &quot;Manage Banners&quot; permissions to use this module!';
$lang['postuninstall'] = 'Banners module uninstalled, and all database tables removed.  Sorry to see you leave.&quot;';
$lang['preferences'] = 'Kegemaran';
$lang['prefsupdated'] = 'Modul kegemaran diperbaharui';
$lang['prompt_categorydesc'] = 'Penjelasan Kategori';
$lang['prompt_categoryname'] = 'Nama Kategori';
$lang['prompt_imageheight'] = 'Tinggi gambar';
$lang['prompt_imagewidth'] = 'Lebar gambar';
$lang['prompt_subnet_exclusions'] = 'Keluarkan subnets ini dari kumpulan statistik apapun';
$lang['prompt_upload_category'] = 'Kategori (Modul Unggah)';
$lang['prompt_upload_file'] = 'Gambar (Modul Unggah)';
$lang['selectcategory'] = 'Pilih kategori';
$lang['submit'] = 'Kirim';
$lang['text'] = 'Teks';
$lang['title_mod_admin'] = 'Modul Panel Admin';
$lang['title_mod_prefs'] = 'Kegemaran pada Modul';
$lang['uninstalled'] = 'Modul dilepas';
$lang['upgraded'] = 'Modul ditingkatkan ke versi %s.';
$lang['url'] = 'URL ';
$lang['width'] = 'Lebar';
$lang['title_admin_panel'] = 'Modul Banner';
$lang['moddescription'] = 'Modul untuk mengatur banner berputar';
$lang['welcome_text'] = '<p>Selamat datang di bagian admin dari Modul Pengaturan Banner. Yang lainnya bisa jadi akan menuju ke halaman ini jika modul telah melakukan sesuatu.</p>';
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
<p>To use this module, place the module code in a page or template using the smarty tag {cms_module module=&#039;Banners&#039; category=&quot;<category>&quot;}</p> 
<p>You must also upload banners to a suitable directory within the uploads directory and must use the admin panel interface to add banners to the database.</p><h3>Parameters</h3>
<ul>
<li><em>(REQUIRED)</em> category=&quot;category&quot; = randomly select from all available in this category</li>
<li><em>(optional)</em> name=&quot;name&quot; = select only the banner with this name</li>
</ul>
<h4>Hint</h4>
<p>The uploads module and the banners module work well together.  You can create a &quot;banners&quot; category in the uploads module, and upload your banner images there, then specify &quot;banners/<filename>&quot; when adding a banner in the banners module.</p>';
$lang['utmz'] = '156861353.1158912730.9.4.utmccn=(referral)|utmcsr=dev.cmsmadesimple.org|utmcct=/forum/|utmcmd=referral';
$lang['utma'] = '156861353.1700526072.1155101103.1159932660.1163569724.12';
$lang['utmc'] = '156861353';
?>