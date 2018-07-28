<?php
$lang['help_param_action'] = 'Specificati comportamentul modulului. Valori posibile sunt &quot;default&quot; si &quot;list&quot;. Actiunea default este folosita pentru afisarea unui singur banner conform criteriilor specificate. Actilunea list se foloseste pentru afisarea tuturor bannerelor unei categorii specificate sau id categorie';
$lang['help_param_category'] = 'In actiunea default, acest parametru este folosit pentru a specifica numele categoriei de unde un singur banner va fi afisat. In actiunea list acest parametru este cerut pentru a specifica numele categoriei de unde toate bannerele vor fi afisate';
$lang['help_param_mode'] = 'Acest parametru este folosit numai in actiunea default, el specifica modul in care bannerele sunt selectate din categoria specificata. Singura valoare este &quot;sequential&quot; care indica faptul ca modulul ar trebui sa aleaga urmatorul banner non-exiprat cu numarul cel mai mic de afisari. Daca nu se specifica acest parametru va rezulta in afisarea unui banner ales la intamplare';
$lang['help_param_name'] = 'Acest parametru se foloseste numai in actiunea default. El specifica un nume absolut al unui banner de incarcat.  Totusi, daca bannerul este invalid (numarul de afisari a fost atins, SAU a expirat), nimic nu se va afisa.';
$lang['bannerlist_template'] = 'Template lista bannere';
$lang['info_bannerlist_template'] = 'Folosit impreuna cu actiunea lista, acest template controleaza afisarea tuturor banner-elor in categoria selectata';
$lang['none'] = 'Nimic';
$lang['error_invalid_dates'] = 'Eroare - Date invalide';
$lang['editbanner'] = 'Editare banner';
$lang['start_date'] = 'Data start';
$lang['atttext'] = 'la';
$lang['template'] = 'Template ';
$lang['default_template'] = 'Template implicit categorie';
$lang['reset_template'] = 'Resetare template la valorile implicite';
$lang['error_banners'] = 'Nu sunt bannere';
$lang['error_bannerexists'] = 'Banner-ul cu acest nume exista deja';
$lang['accessdenied'] = 'Acces interzis. Va rog sa verificati permisiunile dumneavoastra.';
$lang['addbanner'] = 'Adaugare banner';
$lang['addcategory'] = 'Adaugare categorie';
$lang['areyousure'] = 'Sunteti sigur(a)?';
$lang['banners'] = 'Bannere';
$lang['cancel'] = 'Anuleaza';
$lang['categories'] = 'Categorii';
$lang['category'] = 'Categorie';
$lang['created'] = 'Creat';
$lang['date'] = 'Data';
$lang['delete'] = 'Stergere';
$lang['description'] = 'Descriere';
$lang['edit'] = 'Editare';
$lang['editcategory'] = 'Editare categorie';
$lang['error'] = 'Eroare!';
$lang['error_banerexists'] = 'Banner-ul cu acest nume exista deja';
$lang['error_categorynotempty'] = 'Eroare: Categoria nu este goala!';
$lang['error_dberror'] = 'Eroare: Eroare a bazei de date!';
$lang['error_emptybannername'] = 'Eroare: Nume banner gol!';
$lang['error_emptycategory'] = 'Eroare: Categorie goala!';
$lang['error_insufficientparams'] = 'Eroare: Insuficiente date introduse';
$lang['error_nocategories'] = 'Eroare: Nici o categorie gasita';
$lang['error_noresults'] = 'Nici un banner nu s-a potrivit interogarii';
$lang['error_textorimage'] = 'Specificati URL-ul si Imaginea sau Textul nu ambele';
$lang['expires'] = 'Expira';
$lang['friendlyname'] = 'Gestionare bannere';
$lang['height'] = 'Inaltime';
$lang['hits'] = 'Click-uri';
$lang['href_text'] = 'Text link';
$lang['id'] = 'Id';
$lang['image'] = 'Imagine';
$lang['image_text'] = 'Text imagine alternativ';
$lang['impressions'] = 'Afisari';
$lang['info_href_text'] = 'Text aditional pentru eticheta legatura.  Acest text este plasat exact in eticheta legaturii';
$lang['info_image'] = 'Specifica un fisier relativ la directorul pentru incarcari';
$lang['info_image_text'] = 'Text aditional pentru eticheta imaginii';
$lang['info_max_hits'] = 'Folositi 0 pentru click-uri nelimitate';
$lang['info_max_impressions'] = 'Folositi 0 pentru afisari nelimitate';
$lang['installed'] = 'Versiunea %s instalata.';
$lang['ipaddress'] = 'Adresa IP';
$lang['max_hits'] = 'Maximum click-uri';
$lang['max_impressions'] = 'Maximum afisari';
$lang['name'] = 'Nume';
$lang['never'] = 'Niciodata';
$lang['postinstall'] = 'Mesaj post instalare, ex., Fiti sigur(a) sa setati permisiunile &quot;Gestionare bannere&quot; pentru a folosi acest modul!';
$lang['postuninstall'] = 'Modulul bannere dezinstalat, si toate tabelele din baza de date eliminate.  Imi pare rau ca plecati.&quot;';
$lang['preferences'] = 'Preferinte';
$lang['prefsupdated'] = 'Preferintele modulului au fost actualizate.';
$lang['prompt_categorydesc'] = 'Descriere categorie';
$lang['prompt_categoryname'] = 'Nume categorie';
$lang['prompt_imageheight'] = 'Inaltime imagine';
$lang['prompt_imagewidth'] = 'Latime imagine';
$lang['prompt_subnet_exclusions'] = 'Exclude aceste sub-noduri din achizitia oricarei statistici';
$lang['prompt_upload_category'] = 'Categorie (Modul incarcari)';
$lang['prompt_upload_file'] = 'Imagine (Modul incarcari)';
$lang['selectcategory'] = 'Selecteaza categoria';
$lang['submit'] = 'Trimite';
$lang['text'] = 'Textul';
$lang['title_mod_admin'] = 'Panoul de comanda al modulului';
$lang['title_mod_prefs'] = 'Preferintele modulului';
$lang['uninstalled'] = 'Modul dezinstalat.';
$lang['upgraded'] = 'Modulul a fost actualizat la versiunea %s.';
$lang['url'] = 'URL (legatura URL)';
$lang['width'] = 'Latime';
$lang['title_admin_panel'] = 'Modul bannere';
$lang['moddescription'] = 'Un modul care gestioneaza bannere rotative';
$lang['welcome_text'] = '<p>Bun venit in sectiunea de administrare a modulului de gestinue a banerelor. Orice altceva va ajunge probail aici daca modulul chiar a facut ceva.</p>';
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
<li>Version 2.1.0. August 2006. Prepared for 1.0 compatibility, split into multiple files, used references where possible, improved messages, and a general cleanup.</li>
</ul>';
$lang['help'] = '<h3>Ce realizeaza acest modul?</h3>
<p>Acest modul gestioneaza numeroase categorii de banere, urmareste reusitele, impresiile, si data de expirare, si selecteaza aleator un baner pentru afisare dintre toate banerele valide si disponibile</p>
<h3>Cum il folosesc</h3>
<p>Pentru a folosi acest modul, plaseaza codul modulului intr-o pagina sau un sablon folosind eticheta smarty {cms_module module=&#039;Banners&#039; category=&quot;<category>&quot;}</p> 
<p>De asemenea trebuie sa incarcati banerele intr-un director corespunzator din directorul incarcari si trebuie sa folosit interfata panoului de administrare pentru a adauga banere in baza de date.</p
<h3>Parameteri</h3>
<ul>
<li><em>(necesar)</em> category=&quot;category&quot; = selecteaza aleator din toate banerele disponibile din aceasta categorie</li>
<li><em>(optional)</em> name=&quot;name&quot; = selecteaza doar banerul cu acest nume</li>
<li><em>(optional)</em> mode=&quot;sequential&quot; = in loc de selectarea aleatoare a unui baner vald, selecteaza unul cu cele mai putine impresii.</li>
</ul>
<h4>Sugestie</h4>
<p>Modulul de incarcari si cel de banere conlucreaza bine impreuna.  Puteti crea o categorie &quot;banere&quot; in modulul de incarcari si puteti incarca acolo imaginile baner ale dumneavoastra, dupa care puteti specifica &quot;banere/<numefisier>&quot; cand adaugati un baner in modulul banere.</p>';
$lang['utma'] = '156861353.378419758.1252047740.1252047740.1252047740.1';
$lang['utmb'] = '156861353';
$lang['utmc'] = '156861353';
$lang['utmz'] = '156861353.1252047740.1.1.utmccn=(direct)|utmcsr=(direct)|utmcmd=(none)';
?>