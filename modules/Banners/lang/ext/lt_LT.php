<?php
$lang['error_bannerexists'] = 'Reklaminis skydelis tokiu pavadinimu jau egzistuoja';
$lang['accessdenied'] = 'Priėjimas uždraustas. Patikrinkite savo administravimo teises.';
$lang['addbanner'] = 'Pridėti reklaminį skydelį.';
$lang['addcategory'] = 'Pridėti kategoriją';
$lang['areyousure'] = 'Ar esate isitikinęs?';
$lang['banners'] = 'Reklaminiai skydeliai';
$lang['cancel'] = 'At&scaron;aukti';
$lang['categories'] = 'Kategorijos';
$lang['category'] = 'kategorija';
$lang['created'] = 'Sukurtas';
$lang['date'] = 'Data';
$lang['delete'] = 'I&scaron;trinti';
$lang['description'] = 'Apra&scaron;ymas';
$lang['edit'] = 'Redaguoti';
$lang['editcategory'] = 'Redaguoti kategoriją';
$lang['error'] = 'Klaida!';
$lang['error_banerexists'] = 'Reklaminis skydelis tokiu vardu jau egzistuoja';
$lang['error_categorynotempty'] = 'Klaida: kategorija ne tu&scaron;čia!';
$lang['error_dberror'] = 'Klaida: duomenų bazės klaida!';
$lang['error_emptybannername'] = 'Klaida: Nenurodytas skydelio pavadinimas!';
$lang['error_emptycategory'] = 'Klaida: Tu&scaron;čia kategorija!';
$lang['error_insufficientparams'] = 'Klaida: Nepakanka duomenų!';
$lang['error_nocategories'] = 'Klaida: Kategorijos nerastos!';
$lang['error_noresults'] = 'Nei vienas reklaminis skydelis neatitiko užklausos';
$lang['error_textorimage'] = 'Nurodykite URL ir PAVEIKSLĖLĮ  arba TEKSTĄ, ne abu';
$lang['expires'] = 'Baigia galioti';
$lang['friendlyname'] = 'Reklaminių skydelių valdymas';
$lang['height'] = 'Auk&scaron;tis';
$lang['hits'] = 'Paspaudimų skaičius';
$lang['href_text'] = 'Nuorodos tekstas';
$lang['id'] = 'ID';
$lang['image'] = 'paveikslėlis';
$lang['image_text'] = 'Alternatyvus paveikslėlio tekstas';
$lang['impressions'] = 'Parodymų skaičius';
$lang['info_href_text'] = 'Papildomas tekstas prie nuorodos.  &Scaron;is tekstas pridedamas prie nuorodos žymės';
$lang['info_image'] = 'Nurodykite failą, kuris bus katalogo &quot;uploads&quot; viduje';
$lang['info_image_text'] = 'Papildomas tekstas paveikslėlio žymei';
$lang['info_max_hits'] = 'Naudokite 0 norėdami nurodyti neribotą paspaudimų skaičių';
$lang['info_max_impressions'] = 'Naudokite 0 norėdami nurodyti neribotą parodymų skaičių';
$lang['installed'] = 'Modulio versija %s įdiegta.';
$lang['ipaddress'] = 'IP adresas';
$lang['max_hits'] = 'Maksimalus paspaudimų skaičius';
$lang['max_impressions'] = 'Maksimalus parodymų skaičius';
$lang['name'] = 'Pavadinimas';
$lang['never'] = 'Niekada';
$lang['postinstall'] = 'Nepamir&scaron;kite nustatyti reikiamų teisių norėdami naudoti reklaminių skydelių modulį.';
$lang['postuninstall'] = 'Modulis pa&scaron;alintas. Visi duomenys pa&scaron;alinti.';
$lang['preferences'] = 'Nustatymai';
$lang['prefsupdated'] = 'Modulio nustatymai atnaujinti';
$lang['prompt_categorydesc'] = 'Kategorijos apra&scaron;ymas';
$lang['prompt_categoryname'] = 'Kategorijos pavadinimas';
$lang['prompt_imageheight'] = 'Paveikslėlio auk&scaron;tis';
$lang['prompt_imagewidth'] = 'Paveikslėlio plotis';
$lang['prompt_subnet_exclusions'] = 'Neįtraukti &scaron;ių potinklių į statistiką';
$lang['prompt_upload_category'] = 'Kategorijos (Uploads modulis)';
$lang['prompt_upload_file'] = 'Paveikslėlis (Uploads modulis)';
$lang['selectcategory'] = 'Pasirinkite kategoriją';
$lang['submit'] = 'Pateikti';
$lang['text'] = 'Tekstas';
$lang['title_mod_admin'] = 'Modulio administravimas';
$lang['title_mod_prefs'] = 'Modulio nustatymai';
$lang['uninstalled'] = 'Modulis pa&scaron;alintas.';
$lang['upgraded'] = 'Modulis atnaujintas į versiją %s.';
$lang['url'] = 'URL';
$lang['width'] = 'Plotis';
$lang['title_admin_panel'] = 'Reklaminių skydelių modulis';
$lang['moddescription'] = 'Modulis skirtas valdyti reklaminius skydelius';
$lang['welcome_text'] = '<p>Reklaminių skydelių modulio administravimas.</p>';
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
<p>You must also upload banners to a suitable directory within the uploads directory and must use the admin panel interface to add banners to the database.</p
<h3>Parameters</h3>
<ul>
<li><em>(REQUIRED)</em> category=&quot;category&quot; = randomly select from all available in this category</li>
<li><em>(optional)</em> name=&quot;name&quot; = select only the banner with this name</li>
</ul>
<h4>Hint</h4>
<p>The uploads module and the banners module work well together.  You can create a &quot;banners&quot; category in the uploads module, and upload your banner images there, then specify &quot;banners/<filename>&quot; when adding a banner in the banners module.</p>';
?>