<?php
$lang['error_bannerexists'] = 'Et banner med det navn eksisterer allerede';
$lang['accessdenied'] = 'Adgang n&aelig;gtet. Kontroll&eacute;r venligst dine adgangs-tilladelser.';
$lang['addbanner'] = 'Tilf&oslash;j banner';
$lang['addcategory'] = 'Tilf&oslash;j kategori';
$lang['areyousure'] = 'Er du sikkert?';
$lang['banners'] = 'Bannere';
$lang['cancel'] = 'Fortryd';
$lang['categories'] = 'Katogorier';
$lang['category'] = 'Kategori';
$lang['created'] = 'Oprettet';
$lang['date'] = 'Dato';
$lang['delete'] = 'Slet';
$lang['description'] = 'Beskrivelse';
$lang['edit'] = 'Ret';
$lang['editcategory'] = 'Ret kategori';
$lang['error'] = 'Fejl!';
$lang['error_banerexists'] = 'Et banner med det navn eksisterer allerede';
$lang['error_categorynotempty'] = 'Fejl: kategori ikke tom!';
$lang['error_dberror'] = 'Fejl: database-fejl!';
$lang['error_emptybannername'] = 'Fejl: tomt banner-navn!';
$lang['error_emptycategory'] = 'Fejl: tom kategori!';
$lang['error_insufficientparams'] = 'Fejl: utilstr&aelig;kkeligt input';
$lang['error_nocategories'] = 'Fejl: ingen kategorier fundet';
$lang['error_noresults'] = 'Ingen bannere svarer til den foresp&oslash;rgsel';
$lang['error_textorimage'] = 'Specific&eacute;r URL og IMAGE eller TEXT, ikke begge';
$lang['expires'] = 'Udl&oslash;ber';
$lang['friendlyname'] = 'H&aring;ndt&eacute;r bannere';
$lang['height'] = 'H&oslash;jde';
$lang['hits'] = 'Hits';
$lang['href_text'] = 'Link tekst';
$lang['id'] = 'ID';
$lang['image'] = 'Billede';
$lang['image_text'] = 'Billed-tekst';
$lang['impressions'] = 'Fremvisninger';
$lang['info_href_text'] = 'Yderligere tekst for link&#039;et';
$lang['info_image'] = 'Specific&eacute;r et link relativt til dit uploads-dir';
$lang['info_image_text'] = 'Yderligere tekst for image-tag&#039;et';
$lang['info_max_hits'] = 'Angiv 0 for ubegr&aelig;nsede hits';
$lang['info_max_impressions'] = 'Angiv 0 for ubegr&aelig;nsede fremvisninger';
$lang['installed'] = 'Modul version %s installeret.';
$lang['ipaddress'] = 'IP Adresse';
$lang['max_hits'] = 'Maksimalt antal hits';
$lang['max_impressions'] = 'Maksimalt antal fremvisninger';
$lang['name'] = 'Navn';
$lang['never'] = 'Aldrig';
$lang['postinstall'] = 'Sl&aring; tilladelsen &quot;Manage Banners&quot; til for at benytte dette modul!';
$lang['postuninstall'] = 'Post Uninstall Message, e.g., &quot;Curses! Foiled Again!&quot;';
$lang['preferences'] = 'Indstillinger';
$lang['prefsupdated'] = 'Modul indstillinger opdateret.';
$lang['prompt_categorydesc'] = 'Kategori beskrivelse';
$lang['prompt_categoryname'] = 'Kategori navn';
$lang['prompt_imageheight'] = 'Billed h&oslash;jde';
$lang['prompt_imagewidth'] = 'Billed bredde';
$lang['prompt_subnet_exclusions'] = 'Udeluk disse subnets fra indhentning af statistik';
$lang['prompt_upload_category'] = 'Kategori (uploads modulet)';
$lang['prompt_upload_file'] = 'Billed (uploads modulet)';
$lang['selectcategory'] = 'V&aelig;lg kategori';
$lang['submit'] = 'Send';
$lang['text'] = 'Tekst';
$lang['title_mod_admin'] = 'Model administrations panel';
$lang['title_mod_prefs'] = 'Modul indstillinger';
$lang['uninstalled'] = 'Modul afinstalleret.';
$lang['upgraded'] = 'Modul opgraderet til version %s.';
$lang['url'] = 'URL';
$lang['width'] = 'Bredde';
$lang['title_admin_panel'] = 'Banner modul';
$lang['moddescription'] = 'Et modul der h&aring;ndterer skiftende bannere';
$lang['welcome_text'] = '<p>Velkommen til administrationen af Banner Modulet</p>';
$lang['changelog'] = '<ul>
<li>Version 1.0. 6 August 2005. Initial Release.</li>
<li>Version 2.0. September 2005. Initial Release for 0.1..</li>
<li>Version 2.0.1. September 2005. Display sample banner in the edit banner page, added name= parameter, and made subnet exclusions work.  Also changed the definition of the database to allow for additional text in the link and image tags.</li>
<li>Version 2.0.2. September 2005. Added integration with the uploads module (1.0.6) so that we can get lits of files for banners, etc.  The banners module is still optional though.</li>
<li>Version 2.0.3. September 2005. Fixed a very minor issue with never expires..</li>
<li>Version 2.0.4. September 2005. Fixed a very minor issue with module dependencies, and a big bug in the database spec if you did a scratch install.</li>
<li>Version 2.0.5. October 2005. Add coments around the output</li>
<li>Version 2.0.6. December 2005. Minor validation fixes, description is now output between the <img>and</img> tags, and an alt attribute is in the img tag.</li>
</ul>';
$lang['help'] = '<h3>What Does This Do?</h3>
<p>This banner manages numerous categories of banners, tracks hits, impressions, and expiry dates, and randomly selects from all available and valid banners for one to display</p>
<h3>How Do I Use It</h3>
<p>To use this module, place the module code in a page or template using the smarty tag {cms_module module=&#039;Banners&#039; category=&quot;<category>&quot;}</p> 
<p>You must also upload banners to a suitable directory within the uploads directory and must use the admin panel interface to add banners to the database.</p
<h3>Parameters</h3>
<ul>
<li><em>(REQUIRED)</em> category=&quot;category&quot; = randomly select from all available in this category</li>
<li><em>(optional)</em> name=&quot;name&quot; = select only the banner with this name</li>
</ul>
<h4>Hint</h4>
<p>The uploads module and the banners module work well together.  You can create a &quot;banners&quot; category in the uploads module, and upload your banner images there, then specify &quot;banners/<filename>&quot; when adding a banner in the banners module.</p>';
$lang['utma'] = '156861353.425260485.1153391933.1174568295.1175095712.83';
$lang['utmz'] = '156861353.1173708191.79.12.utmccn=(referral)|utmcsr=wiki.cmsmadesimple.org|utmcct=/index.php/User_Handbook/Installation/Quick_Install|utmcmd=referral';
?>