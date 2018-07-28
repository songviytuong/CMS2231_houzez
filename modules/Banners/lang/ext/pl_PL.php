<?php
$lang['error_banners'] = 'Brak banner&oacute;w';
$lang['error_bannerexists'] = 'Banner z taką nazwą już istnieje';
$lang['accessdenied'] = 'Dostęp zabroniony. Sprawdź swoje uprawnienia.';
$lang['addbanner'] = 'Dodaj banner';
$lang['addcategory'] = 'Dodaj kategorię';
$lang['areyousure'] = 'Jesteś pewny?';
$lang['banners'] = 'Bannery';
$lang['cancel'] = 'Anuluj';
$lang['categories'] = 'Kategorie';
$lang['category'] = 'Kategoria';
$lang['created'] = 'Stworzono';
$lang['date'] = 'Data';
$lang['delete'] = 'Skasuj';
$lang['description'] = 'Opis';
$lang['edit'] = 'Edytuj';
$lang['editcategory'] = 'Edytuj kategorię';
$lang['error'] = 'Błąd!';
$lang['error_banerexists'] = 'Banner z taką nazwą już istnieje';
$lang['error_categorynotempty'] = 'Błąd: kategoria nie jest pusta!';
$lang['error_dberror'] = 'Błąd bazy danych!';
$lang['error_emptybannername'] = 'Błąd: pusta nazwa bannera!';
$lang['error_emptycategory'] = 'Błąd: pusta kategoria!';
$lang['error_insufficientparams'] = 'Błąd: Niewystarczający wpis!';
$lang['error_nocategories'] = 'Błąd: Nie znaleziono kategorii!';
$lang['error_noresults'] = 'Żaden z banner&oacute;w nie pasuje do warunk&oacute;w wyszukiwania';
$lang['error_textorimage'] = 'Podaj URL oraz OBRAZEK lub tekst, nie obydwa';
$lang['expires'] = 'Wygasa';
$lang['friendlyname'] = 'Bannery';
$lang['height'] = 'Wysokość';
$lang['hits'] = 'Kliknięć';
$lang['href_text'] = 'Tekst do tagu linku';
$lang['id'] = 'ID';
$lang['image'] = 'Obrazek';
$lang['image_text'] = 'Podpis do obrazka (alt)';
$lang['impressions'] = 'Wyświetleń';
$lang['info_href_text'] = 'Dodatkowy tekst do tagu linku. Ten tekst jest wstawiany w dokładnie takiej formie jak tu wpiszesz';
$lang['info_image'] = 'Podaj plik w katalogu /uploads';
$lang['info_image_text'] = 'Alternatywny tekst, kt&oacute;ry pojawi się w wypadku problem&oacute;w z załadowaniem obrazka';
$lang['info_max_hits'] = 'Użyj zera dla nielimitowanej ilości kliknięć';
$lang['info_max_impressions'] = 'Użyj zera dla nielimitowanej ilości wyświetleń';
$lang['installed'] = 'Moduł w wersji %s został zainstalowany.';
$lang['ipaddress'] = 'Adres IP';
$lang['max_hits'] = 'Maksymalna ilość kliknięć';
$lang['max_impressions'] = 'Maksymalna ilość wyświetleń';
$lang['name'] = 'Nazwa';
$lang['never'] = 'Nigdy';
$lang['postinstall'] = 'Pamiętaj aby nadać prawo &quot;Manage Banners&quot; osobom, kt&oacute;re mają zarządzać tym modułem.';
$lang['postuninstall'] = 'Moduł został odinstalowany pomyślnie, wszystkie tablice z nim związane zostały usunięte z bazy danych.';
$lang['preferences'] = 'Ustawienia';
$lang['prefsupdated'] = 'Ustawienia modułu zostały zapisane.';
$lang['prompt_categorydesc'] = 'Opis kategorii';
$lang['prompt_categoryname'] = 'Nazwa kategorii';
$lang['prompt_imageheight'] = 'Wysokość obrazka';
$lang['prompt_imagewidth'] = 'Szerokość obrazka';
$lang['prompt_subnet_exclusions'] = 'Wyklucz te podsieci ze statystyk';
$lang['prompt_upload_category'] = 'Kategoria (modułu Uploads)';
$lang['prompt_upload_file'] = 'Obrazek (modułu Uploads)';
$lang['selectcategory'] = 'Wybierz kategorię';
$lang['submit'] = 'Zapisz';
$lang['text'] = 'Tekst';
$lang['title_mod_admin'] = 'Panel administracyjny modułu';
$lang['title_mod_prefs'] = 'Ustawienia modułu';
$lang['uninstalled'] = 'Moduł został odinstalowany.';
$lang['upgraded'] = 'Moduł został uaktualniony do wersji %s.';
$lang['url'] = 'URL';
$lang['width'] = 'Szerokość';
$lang['title_admin_panel'] = 'Bannery';
$lang['moddescription'] = 'Moduł do zarządzania bannerami';
$lang['welcome_text'] = '<p>Witaj w panelu administracyjnym modułu Banney.</p>';
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
<li>Version 2.2. March 2008. 
    <p>The first release in a long while this fixes issues with the date fields, and the expiry date.  Also integrates changes so that the active tab is maintaned (DeeEye) and changes the license.</p>
    <p>Now require CMS 1.2.3 or greater</p>
</li>
<li>Version 2.2.1. April 2008.
    <p>Minor fixes.</p>
</li>
</ul>';
$lang['help'] = '<h3>What Does This Do?</h3>
<p>This banner manages numerous categories of banners, tracks hits, impressions, and expiry dates, and randomly selects from all available and valid banners for one to display</p>
<h3>How Do I Use It</h3>
<p>To use this module, place the module code in a page or template using the smarty tag {Banners category=&quot;categoryname&quot;}</p> 
<p>You must also upload banners to a suitable directory within the uploads directory and must use the admin panel interface to add banners to the database.</p
<h3>Parameters</h3>
<ul>
<li><em>(REQUIRED)</em> category=&quot;category&quot; = randomly select from all available in this category</li>
<li><em>(optional)</em> name=&quot;name&quot; = select only the banner with this name</li>
<li><em>(optional)</em> mode=&quot;sequential&quot; = Instead of randomly selecting a valid banner, select the one with the least impressions.</li>
</ul>
<h4>Hint</h4>
<p>The uploads module and the banners module work well together.  You can create a &quot;banners&quot; category in the uploads module, and upload your banner images there, then specify &quot;banners/<filename>&quot; when adding a banner in the banners module.</p>
<h3>Support</h3>
<p>This module does not include commercial support. However, there are a number of resources available to help you with it:</p>
<ul>
<li>For the latest version of this module, FAQs, or to file a Bug Report or buy commercial support, please visit calguy&#039;s
module homepage at <a href="http://techcom.dyndns.org">techcom.dyndns.org</a>.</li>
<li>Additional discussion of this module may also be found in the <a href="http://forum.cmsmadesimple.org">CMS Made Simple Forums</a>.</li>
<li>The author, calguy1000, can often be found in the <a href="irc://irc.freenode.net/#cms">CMS IRC Channel</a>.</li>
<li>Lastly, you may have some success emailing the author directly.</li>  
</ul>
<h3>Copyright and License</h3>
<p>Copyright &copy; 2008, Robert Campbel <a href="mailto:calguy1000@cmsmadesimple.org"><calguy1000@cmsmadesimple.org></a>. All Rights Are Reserved.</p>
<p>This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.</p>
<p>However, as a special exception to the GPL, this software is distributed
as an addon module to CMS Made Simple.  You may not use this software
in any Non GPL version of CMS Made simple, or in any version of CMS
Made simple that does not indicate clearly and obviously in its admin 
section that the site was built with CMS Made simple.</p>
<p>This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
Or read it <a href="http://www.gnu.org/licenses/licenses.html#GPL">online</a></p>';
$lang['utma'] = '156861353.2359145497878676500.1213200278.1219177789.1219266170.93';
$lang['utmz'] = '156861353.1219266170.93.18.utmccn=(referral)|utmcsr=dev.cmsmadesimple.org|utmcct=/softwaremap/trove_list.php|utmcmd=referral';
$lang['utmb'] = '156861353';
$lang['utmc'] = '156861353';
?>