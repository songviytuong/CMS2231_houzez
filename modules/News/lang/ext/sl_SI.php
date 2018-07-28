<?php
$lang['addarticle']='Dodaj članek';
$lang['addcategory']='Dodaj kategorijo';
$lang['addfielddef']='Dodaj definicijo polja';
$lang['addnewsitem']='Dodaj element novic';
$lang['allcategories']='Vse kategorije';
$lang['allentries']='Vsi zapisi';
$lang['allow_summary_wysiwyg']='Dovoli uporabo WYSIWYG urejevalnika za povzetek novice';
$lang['allowed_upload_types']='Dovoli nalaganje samo datotekam s temi končnicami';
$lang['anonymous']='Anonimen';
$lang['apply']='Potrdi';
$lang['approve']='Nastavi status &#039;Objavljeno&#039;';
$lang['areyousure']='Ste prepričani, da želite izbrisati?';
$lang['areyousure_deletemultiple']='Ste prepričani, da želite izbrisati vse te članke?\nTe akcije ne morete povrniti!';
$lang['article']='Člen';
$lang['articleadded']='Članek je bil uspe&scaron;no dodan.';
$lang['articledeleted']='Članek je bil uspe&scaron;no izbrisan.';
$lang['articles']='Članki';
$lang['articleupdated']='Članek je bil uspe&scaron;no spremenjen.';
$lang['author']='Avtor';
$lang['author_label']='Avtor:';
$lang['auto_create_thumbnails']='Samodejno ustvari pomanj&scaron;ave za datoteke s temi končnicami';
$lang['browsecattemplate']='Pregledovanje kategorije - predloge';
$lang['cancel']='Prekliči';
$lang['categories']='Kategorije';
$lang['category']='Kategorija';
$lang['category_label']='Kategorija:';
$lang['categoryadded']='Kategorija je bila uspe&scaron;no dodana.';
$lang['categorydeleted']='Kategorija je bila uspe&scaron;no izbrisana.';
$lang['categoryupdated']='Kategorija je bila uspe&scaron;no spremenjena.';
$lang['checkbox']='Potrditveno polje';
$lang['content']='Vsebina';
$lang['customfields']='Definicije polj';
$lang['dateformat']='%s ni v veljavnem formatu yyyy-mm-dd hh:mm:ss';
$lang['default_category']='Privzeta kategorija';
$lang['default_templates']='Privzete predloge';
$lang['delete']='Izbri&scaron;i';
$lang['delete_selected']='Izbri&scaron;i izbrane članke';
$lang['deprecated']='nepodprto';
$lang['description']='Dodajanje, urejanje in izbris zapisov novic';
$lang['detail_page']='Stran podrobnosti';
$lang['detail_template']='Predloga podrobnosti';
$lang['detailtemplate']='Podrobnosti - predloge';
$lang['detailtemplateupdated']='Spremenjena predloga za podrobnosti je bila uspe&scaron;no shranjena v bazo.';
$lang['displaytemplate']='Prikaži predlogo';
$lang['down']='Dol';
$lang['draft']='Osnutek';
$lang['edit']='Uredi';
$lang['editfielddef']='Uredi definicijo polja';
$lang['email_subject']='Zadeva odhodnega E-mail sporočila';
$lang['email_template']='Format E-mail sporočila';
$lang['enddate']='Datum konca objave';
$lang['endrequiresstart']='Če vpi&scaron;ete datum konca objave, morate izbrati tudi datum začetka objave';
$lang['entries']='%s zapisov';
$lang['error_duplicatename']='Element s tem imenom že obstaja';
$lang['error_filesize']='Prene&scaron;ena datoteka je večja od dovoljene';
$lang['error_insufficientparams']='Premalo (ali prazni) parametrov';
$lang['error_invaliddates']='Eden ali več datumov je bilo narobe vne&scaron;enih';
$lang['error_invalidfiletype']='Ne morem naložiti datoteke tega tipa';
$lang['error_invalidurl']='Neveljaven URL <em>(Mogoče je že v uporabi, ali pa obstajajo neveljavni znaki)</em>';
$lang['error_mkdir']='Ne morem ustvariti mape: %s';
$lang['error_movefile']='Ne morem ustvariti datoteke: %s';
$lang['error_noarticlesselected']='Noben članek ni bil izbran';
$lang['error_templatenamexists']='Predloga s tem imenom že obstaja';
$lang['error_upload']='Pri&scaron;lo je do napake pri nalaganju datoteke';
$lang['eventdesc-NewsArticleAdded']='Poslano, ko je dodan nov članek.';
$lang['eventdesc-NewsArticleDeleted']='Poslano, ko je članek izbrisan.';
$lang['eventdesc-NewsArticleEdited']='Poslano, ko je članek spremenjen.';
$lang['eventdesc-NewsCategoryAdded']='Poslano, ko je dodana nova kategorija.';
$lang['eventdesc-NewsCategoryDeleted']='Poslano, ko je kategorija izbrisana.';
$lang['eventdesc-NewsCategoryEdited']='Poslano, ko je kategorija spremenjena.';
$lang['eventhelp-NewsArticleAdded']='<p>Sent when an article is added.</p>
<h4>Parameters</h4>
<ul>
<li>\&quot;news_id\&quot; - Id of the news article</li>
<li>\&quot;category_id\&quot; - Id of the category for this article</li>
<li>\&quot;title\&quot; - Title of the article</li>
<li>\&quot;content\&quot; - Content of the article</li>
<li>\&quot;summary\&quot; - Summary of the article</li>
<li>\&quot;status\&quot; - Status of the article (&quot;draft&quot; or &quot;publish&quot;)</li>
<li>\&quot;start_time\&quot; - Date the article should start being displayed</li>
<li>\&quot;end_time\&quot; - Date the article should stop being displayed</li>
<li>\&quot;useexp\&quot; - Whether the expiration date should be ignored or not</li>
</ul>
';
$lang['eventhelp-NewsArticleDeleted']='<p>Sent when an article is deleted.</p>
<h4>Parameters</h4>
<ul>
<li>\&quot;news_id\&quot; - Id of the news article</li>
</ul>
';
$lang['eventhelp-NewsArticleEdited']='<p>Sent when an article is edited.</p>
<h4>Parameters</h4>
<ul>
<li>\&quot;news_id\&quot; - Id of the news article</li>
<li>\&quot;category_id\&quot; - Id of the category for this article</li>
<li>\&quot;title\&quot; - Title of the article</li>
<li>\&quot;content\&quot; - Content of the article</li>
<li>\&quot;summary\&quot; - Summary of the article</li>
<li>\&quot;status\&quot; - Status of the article (&quot;draft&quot; or &quot;publish&quot;)</li>
<li>\&quot;start_time\&quot; - Date the article should start being displayed</li>
<li>\&quot;end_time\&quot; - Date the article should stop being displayed</li>
<li>\&quot;useexp\&quot; - Whether the expiration date should be ignored or not</li>
</ul>
';
$lang['eventhelp-NewsCategoryAdded']='<p>Sent when a category is added.</p>
<h4>Parameters</h4>
<ul>
<li>\&quot;category_id\&quot; - Id of the news category</li>
<li>\&quot;name\&quot; - Name of the news category</li>
</ul>
';
$lang['eventhelp-NewsCategoryDeleted']='<p>Sent when a category is deleted.</p>
<h4>Parameters</h4>
<ul>
<li>\&quot;category_id\&quot; - Id of the deleted category </li>
<li>\&quot;name\&quot; - Name of the deleted category</li>
</ul>
';
$lang['eventhelp-NewsCategoryEdited']='<p>Sent when a category is edited.</p>
<h4>Parameters</h4>
<ul>
<li>\&quot;category_id\&quot; - Id of the news category</li>
<li>\&quot;name\&quot; - Name of the news category</li>
<li>\&quot;origname\&quot; - The original name of the news category</li>
</ul>
';
$lang['expired']='Zapadlo';
$lang['expired_searchable']='Potekli članki se lahko prikažejo v rezultatih iskanja';
$lang['expiry']='Zapadlost';
$lang['expiry_date_asc']='Datum zapada nara&scaron;čajoče';
$lang['expiry_date_desc']='Datum zapada padajoče';
$lang['expiry_interval']='Privzeto &scaron;tevilo dni, preden objava članka zapade (če je omogočeno zapadanje)';
$lang['extra']='Dodatno';
$lang['extra_label']='Dodatno:';
$lang['fesubmit_redirect']='ID ali alias strani za preusmeritev po objavi članka preko akcije fesubmit';
$lang['fesubmit_status']='Status člankov, objavljenih preko front-end strani';
$lang['fielddef']='Definicija polja';
$lang['fielddefadded']='Definicija polja uspe&scaron;no dodana';
$lang['fielddefdeleted']='Definicija polja je bila izbrisana';
$lang['fielddefupdated']='Definicija polja je bila shranjena';
$lang['file']='Datoteka';
$lang['firstpage']='<<';
$lang['formsubmit_emailaddress']='E-mail za prejemanje obvestil o objavi novih člankov';
$lang['formtemplate']='Obrazci - predloge';
$lang['help']='<h3>Important Notes</h3>
<p>Version 2.9 and greater of News has removed the formatpostdate member from the templates, and has also removed the dateformat parameter.  You should be using the cms_date_format modifier (as indicated in the default templates) to format dates, and should be using entry->postdate instead of entry->formatpostdate in your templates.</p>
<h3>What does this do?</h3>
<p>News is a module for displaying news events on your page, similar to a blog style, except with more features!.  When the module is installed, a News admin page is added to administration menu that will allow you to select or add a news category.  Once a news category is created or selected, a list of news items for that category will be displayed.  From here, you can add, edit or delete news items for that category.</p>
<h4>Numerous display methods</h4>
<p>The parameters supported by the news module, and support for numerous templates of each time mean that your options for displaying news articles are limitless.</p>
<h4>Custom Fields</h4>
<p>The News module allows defining numerous custom fields (including files and images) that will allow you to attach pdf files or numerous images to your articles.</p>
        <h4>Categories</h4>
	<p>News supplies a hierarchical category mechanism for organizing your articles.  A news article can only be in one place in the hierarchy.</p>
	<h4>Expiry and Status</h4>
	<p>Each news article can have an optional expiry date, after which it will not be shown on your web page.  As well, articles can be marked as <em>draft</em> to remove them permanently from your web page.</p>
	<h3>Security</h3>
	<p>The user must belong to a group with the &#039;Modify News&#039; permission in order to add or edit News entries.</p>
        <p>As well, In order to delete news entries, the user must belong to a group with the &#039;Delete News Articles&#039; permission.</p>
	<p>In order to edit the layout templates, the user must belong to a group with the &#039;Modify Templates&#039; permission.</p>
	<p>In order to edit the global news preferences, the user must belong to a group with the &#039;Modify Site Preferences&#039; permission.</p>
	<p>Additionally, to approve news for frontend display the user must belong to a group with the &#039;Approve News&#039; permission.</p>
	<h3>How do I use it?</h3>
	<p>The easiest way to use it is with the {news} wrapper tag (wraps the module in a tag, to simplify the syntax).  This will insert the module into your template or page anywhere you wish, and display news items.  The code would look something like: <code>{news number=&#039;5&#039;}</code></p>
<h3>Templates</h3>
<p>Since version 2.3 News supports multiple database templates, and no longer supports additional file templates.  Users who used the old file template system should follow these steps (for each file template):</p>
<ul>
<li>Copy the file template into the clipboard</li>
<li>Create a new database template <em>(either summary or detailed as required)</em>.  Give the new template the same name (including the .tpl extension) as the old file template, and paste the contents.</li>
<li>Hit Submit</li>
</ul>
<p>Following these steps should solve the problem of your news templates not being found and other similar smarty errors when you upgrade to a version of CMS that has News 2.3 or greater.</p>';
$lang['help_articleid']='Parameter se uporablja samo v podrobnem pogledu. Omogoča določevanje katere novice naj se prikažejo v podrobnem pogledu. Če je uporabljena posebna vrednost -1, bo sistem prikazal najnovej&scaron;i objavljen članek.';
$lang['help_pagelimit']='Največje &scaron;tevilo zapisov (na stran) za prikaz. Če parameter ni nastavljen, bodo prikazani vsi zapisi. Če je zapisov več od te vrednosti, bo prikazana navigacija za premikanje med rezultati.';
$lang['helpaction']='&#039;Override the default action.  Possible values are:
<ul>
<li>&amp;quot;detail&amp;quot; - to display a specified articleid in detail mode.</li>
<li>&amp;quot;default&amp;quot; - to display the summary view</li>
<li>&amp;quot;fesubmit&amp;quot; - to display the frontend form for allowing users to submit news articles on the front end. Add the <code>{cms_init_editor}</code> tag in the metadata section to initialize the selected wysiwyg editor. (Site Admin >> Global Settings)</li>
<li>&amp;quot;browsecat&amp;quot; - to display a browseable category list.</li>
</ul>';
$lang['helpbrowsecat']='Prikaže seznam kategorij za pregledovanje.';
$lang['helpbrowsecattemplate']='Uporabi ločeno predlogo baze za prikaz pregledovanja kategorij. Ta predloga mora obstajati in biti vidna v zavihku za predloge pregledovanja kategorij v administraciji novic, ni pa potrebno, da je nastavljena za privzeto predlogo. Če parameter ni določen, bo uporabljena predloga, ki je izbrana kot privzeta predloga.';
$lang['helpcategory']='Uporabljeno v prikazu povzetkov za prikaz zapisov samo določene kategorije.<b>Uporabite * za imenom, če želite prikazati tudi vse podrejene zapise.</b>  Če želite uporabiti več kategorij, jih ločite med seboj z vejico. Če pustite polje prazno, bodo prikazane vse kategorije. Ta parameter deluje tudi pri front-end objavi, vendar je podprto samo ime ene kategorije.';
$lang['helpdetailpage']='Stran za prikaz podrobnosti novic. To je lahko psevdonim strani ali pa ID strani. Uporabno za omogočanje prikaza podrobnosti novice v drugačni predlogi kot povzetek.';
$lang['helpdetailtemplate']='Uporabi ločeno predlogo baze za prikaz podrobnosti članka. Ta predloga mora obstajati in biti vidna v zavihku za predloge podrobnosti člankov v administraciji novic, ni pa potrebno, da je nastavljena za privzeto predlogo. Če parameter ni določen, bo uporabljena predloga, ki je izbrana kot privzeta predloga.';
$lang['helpformtemplate']='Uporabi ločeno predlogo baze za prikaz obrazca za objavo članka. Ta predloga mora obstajati in biti vidna v zavihku za predloge obrazcev v administraciji novic, ni pa potrebno, da je nastavljena za privzeto predlogo. Če parameter ni določen, bo uporabljena predloga, ki je izbrana kot privzeta predloga.';
$lang['helpmoretext']='Besedilo za prikaz na koncu članka, če je dolžina dalj&scaron;a od dolžine povzetka. Privzeto &quot;več...&quot;';
$lang['helpnumber']='Največje &scaron;tevilo zapisov za prikaz -- če pustite prazno, bodo prikazani vsi zapisi.';
$lang['helpshowall']='Prikaži vse članke, ne glede na datum zaključka objave';
$lang['helpshowarchive']='Prikaži samo zapadle članke.';
$lang['helpsortasc']='Razvrsti zapise nara&scaron;čajoče namesto padajoče.';
$lang['helpsortby']='Polje za razvrstitev.  Možnosti na voljo: &quot;news_date&quot;, &quot;summary&quot;, &quot;news_data&quot;, &quot;news_category&quot;, &quot;news_title&quot;, &quot;news_extra&quot;, &quot;end_time&quot;, &quot;start_time&quot;, &quot;random&quot;.  Privzeta vrednost je &quot;news_date&quot;. Če izberete &quot;random&quot;, ne bo uporabljen parameter sortasc.';
$lang['helpstart']='Začni prikaz pri n-tem zapisu -- če pustite prazno, bo prikaz začel pri prvem zapisu.';
$lang['helpsummarytemplate']='Uporabi ločeno predlogo baze za prikaz povzetka članka. Ta predloga mora obstajati in biti vidna v zavihku za predloge povzetkov v administracij novic, ni pa potrebno, da je nastavljena za privzeto predlogo. Če parameter ni določen, bo uporabljena predloga, ki je izbrana kot privzeta predloga.';
$lang['hide_summary_field']='Skrij polje za povzetek pri dodajanju ali urejanju člankov';
$lang['info_detail_returnid']='Ta nastavitev se uporablja za določanje strani (in zato predlogo) za uporabo v podrobnem ogledu strani. Posebni URL-ji za podroben ogled novic ne bodo delovali, če ta parameter ni nastavljen na veljavno stran. Poleg tega, če je ta nastavljen, in noben detailpage parameter ni dodeljen v news tagu, nato bo ta vrednost uporabljena za linke do ogleda podrobnosti';
$lang['info_maxlength']='Največja dolžina veljavna samo pri poljih za tekstovni vnos';
$lang['info_sysdefault']='<em>(vsebina, ki bo privzeto uporabljena, ko ustvarite novo predlogo)</em>';
$lang['info_sysdefault2']='<strong>V vednost:</strong> V tem zavihku lahko urejate nabor predlog, ki bodo prikazane, ko ustvarite &#039;novo&#039; predlogo za povzetek, podrobnosti ali obrazec. Spreminjanje vsebin v tem zavihku <strong>ne bo spremenilo obstoječih prikazov novic</strong>.';
$lang['lastpage']='>>';
$lang['maxlength']='Največja dolžina';
$lang['more']='Več';
$lang['moretext']='Več besedila';
$lang['msg_contenttype_removed']='Vsebina tipa novice je bila izbrisana. Prosimo vstavite oznake {news} z ustreznimi parametri v predlogo va&scaron;e spletne strani za nadomestilo te funkcionalnosti.';
$lang['name']='Ime';
$lang['nameexists']='Polje s tem imenom že obstaja';
$lang['needpermission']='Imeti morate pravico &#039;%s&#039;, če želite izvesti to funkcijo.';
$lang['newcategory']='Nova kategorija';
$lang['news']='Novice';
$lang['news_return']='Nazaj';
$lang['nextpage']='>';
$lang['nocategorygiven']='Nobena kategorija ni podana';
$lang['nocontentgiven']='Vsebina ni podana';
$lang['noitemsfound']='<strong>Nobenih</strong> zapisov v kategoriji: %s';
$lang['nonamegiven']='Ime ni podano';
$lang['none']='Noben';
$lang['nopostdategiven']='Datum objave ni podan';
$lang['notanumber']='Največja dolžina ni &scaron;tevilo';
$lang['note']='<em>V vednost:</em> Datumi naj bodo v formatu &#039;llll-mm-dd hh:mm:ss&#039;.';
$lang['notify_n_draft_items']='Imate %s, ki ni(so) objavljen(i)';
$lang['notify_n_draft_items_sub']='%d člankov';
$lang['notitlegiven']='Naziv ni podan';
$lang['numbertodisplay']='&Scaron;tevilo za prikaz (prazno prikaže vse zapise)';
$lang['options']='Možnosti';
$lang['optionsupdated']='Možnosti so bile uspe&scaron;no spremenjene.';
$lang['post_date_asc']='Datum objave nara&scaron;čajoče';
$lang['post_date_desc']='Datum objave padajoče';
$lang['postdate']='Datum objave';
$lang['postinstall']='Prepričajte se, da nastavite pravice za urejanje novic (&quot;Modify News&quot;) uporabnikom, ki bodo administrirali članke.';
$lang['preview']='predogled';
$lang['prevpage']='<';
$lang['print']='Tiskanje';
$lang['prompt_default']='Privzeto';
$lang['prompt_name']='Naziv';
$lang['prompt_newtemplate']='Ustvari novo predlogo';
$lang['prompt_of']='od';
$lang['prompt_page']='Stran';
$lang['prompt_pagelimit']='Omejitev strani';
$lang['prompt_sorting']='Razvrsti po';
$lang['prompt_template']='Izvorna koda predloge';
$lang['prompt_templatename']='Naziv predloge';
$lang['public']='Javno';
$lang['published']='Objavljeno';
$lang['reassign_category']='Spremeni kategorijo v';
$lang['removed']='Izbrisano';
$lang['resettodefault']='Ponastavi na izvirno različico';
$lang['restoretodefaultsmsg']='Operacija bo povrnila vsebino predloge na sistemske privzete vrednosti. Ste prepričani, da želite nadaljevati?';
$lang['revert']='Nastavi status &#039;Osnutek&#039;';
$lang['select']='Izberi';
$lang['selectcategory']='Izberite kategorijo';
$lang['showchildcategories']='Prikaži podrejene kategorije';
$lang['sortascending']='Razvrsti nara&scaron;čajoče';
$lang['startdate']='Datum začetka objave';
$lang['startdatetoolate']='Datum začetka objave je prepozen (po datumu konca?)';
$lang['startoffset']='Začni prikaz pri n-tem zapisu';
$lang['startrequiresend']='Vnos začetka objave zahteva tudi vnos datuma konca objave';
$lang['status_asc']='Status nara&scaron;čajoč';
$lang['status_desc']='Status padajoč';
$lang['subject_newnews']='Nov članek je bil objavljen v novicah';
$lang['submit']='Po&scaron;lji';
$lang['summary']='Povzetek';
$lang['summarytemplate']='Povzetek - predloge';
$lang['summarytemplateupdated']='Predloga za povzetek novice je bila uspe&scaron;no shranjena.';
$lang['sysdefaults']='Povrni na privzeto';
$lang['template']='Predloga';
$lang['textarea']='Tekstovno področje';
$lang['textbox']='Tekstovni vnos';
$lang['title']='Naziv';
$lang['title_asc']='Naziv nara&scaron;čajoče';
$lang['title_available_templates']='Predloge na voljo';
$lang['title_browsecat_sysdefault']='Pregledovanje kategorije - privzeta predloga';
$lang['title_browsecat_template']='Pregledovanje kategorije - urejanje predloge';
$lang['title_desc']='Naziv padajoče';
$lang['title_detail_returnid']='Predstavljena stran, za uporabo podrobnega ogleda novic';
$lang['title_detail_settings']='Nastavitve za ogled podrobnosti';
$lang['title_detail_sysdefault']='Privzeta predloga podrobnosti';
$lang['title_detail_template']='Urejevalnik predloge podrobnosti';
$lang['title_fesubmit_settings']='Nastavitve za Frontend predložitev';
$lang['title_filter']='Filtri';
$lang['title_form_sysdefault']='Privzeta predloga obrazca';
$lang['title_form_template']='Urejevalnik predloge obrazca';
$lang['title_notification_settings']='Nastavitve za obvestilo';
$lang['title_submission_settings']='Nastavitve za predložitev novic';
$lang['title_summary_sysdefault']='Privzeta predloga povzetka';
$lang['title_summary_template']='Urejevalnik predloge povzetka';
$lang['type']='Tip';
$lang['unknown']='Neznano';
$lang['unlimited']='Neomejeno';
$lang['up']='Gor';
$lang['uploadscategory']='Kategorija za nalaganje datotek';
$lang['useexpiration']='Uporabi datum zapadlosti';
?>