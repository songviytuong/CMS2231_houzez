<?php
$lang['addarticle']='Artikulua Gehitu';
$lang['addcategory']='Kategoria Gehitu';
$lang['addnewsitem']='Berri bat Gehitu';
$lang['allcategories']='Kategoria Guztiak';
$lang['allentries']='Sarrera Guztiak';
$lang['areyousure']='Ezabatu nahi duzula zihur al zaude?';
$lang['articleadded']='Artikulua zuzenki gehitua izan da.';
$lang['articledeleted']='Artikulua zuzenki ezabatua izan da.';
$lang['articles']='Artikuluak';
$lang['articleupdated']='Artikulua zuzenki eguneratua izan da.';
$lang['author']='Egilea';
$lang['author_label']='Nork bidalia:';
$lang['cancel']='Ezeztatu';
$lang['categories']='Kategoriak';
$lang['category']='Kategoria';
$lang['category_label']='Kategoria:';
$lang['categoryadded']='Kategoria zuzenki gehitua izan da.';
$lang['categorydeleted']='Kategoria zuzenki ezabatua izan da.';
$lang['categoryupdated']='Kategoria zuzenki eguneratua izan da.';
$lang['content']='Edukia';
$lang['dateformat']='%s-k ez dauka yyyy-mm-dd hh:mm:ss formatu baliagarria';
$lang['default_category']='Kategori Lehenetsia';
$lang['delete']='Ezabatu';
$lang['description']='Gehitu, editatu eta ezabatu Berrien sarrerak';
$lang['detailtemplate']='Xehetasun Txantiloia';
$lang['detailtemplateupdated']='Eguneratutako Xehetasun Txantiloia datubasean arazorik gabe gorde da.';
$lang['displaytemplate']='Txantiloia erakutsi';
$lang['edit']='Editatu';
$lang['enddate']='Amaiera Eguna';
$lang['endrequiresstart']='Amaiera egun baten sarrerak hasiera egun bat ere behar du';
$lang['entries']='%s Sarrera';
$lang['eventdesc-NewsArticleAdded']='Artikulu bat gehitzen denean bidalia.';
$lang['eventdesc-NewsArticleDeleted']='Artikulu bat ezabatzen denean bidalia.';
$lang['eventdesc-NewsArticleEdited']='Artikulu bat editatzen denean bidalia.';
$lang['eventdesc-NewsCategoryAdded']='Kategoria bat gehitzen denean bidalia.';
$lang['eventdesc-NewsCategoryDeleted']='Kategoria bat ezabatzen denean bidalia.';
$lang['eventdesc-NewsCategoryEdited']='Kategoria bat editatzen denean bidalia.';
$lang['eventhelp-NewsArticleAdded']='<p>Artikulu bat gehitzen denean bidalia.</p>
<h4>Parametroak</h4>
<ul>
<li>\&quot;news_id\&quot; - Berriaren Id-a</li>
<li>\&quot;category_id\&quot; - Artikulu honen kategoriaren Id-a</li>
<li>\&quot;title\&quot; - Artikuluaren titulua</li>
<li>\&quot;content\&quot; - Artikuluaren edukia</li>
<li>\&quot;summary\&quot; - Artikuluaren laburpena</li>
<li>\&quot;status\&quot; - Artikuluaren egoera (&quot;zirriborroa&quot; edo &quot;argitaragarria&quot;)</li>
<li>\&quot;start_time\&quot; - Artikulua bistaratua izaten hasiko den data</li>
<li>\&quot;end_time\&quot; - Artikulua bistaratua izatetik gelditu beharko den data</li>
<li>\&quot;useexp\&quot; - Amaiera data kontuan hartu behar den ala ez</li>
</ul>
';
$lang['eventhelp-NewsArticleDeleted']='<p>Artikulu bat ezabatzen denean bidalia.</p>
<h4>Parametroak</h4>
<ul>
<li>\&quot;news_id\&quot; - Berriaren Id-a</li>
</ul>
';
$lang['eventhelp-NewsArticleEdited']='<p>Artikulu bat editatzen denean bidalia.</p>
<h4>Parametroak</h4>
<ul>
<li>\&quot;news_id\&quot; - Berriaren Id-a</li>
<li>\&quot;category_id\&quot; - Artikulu honen kategoriaren Id-a</li>
<li>\&quot;title\&quot; - Artikuluaren titulua</li>
<li>\&quot;content\&quot; - Artikuluaren edukia</li>
<li>\&quot;summary\&quot; - Artikuluaren laburpena</li>
<li>\&quot;status\&quot; - Artikuluaren egoera (&quot;zirriborroa&quot; edo &quot;argitaragarria&quot;)</li>
<li>\&quot;start_time\&quot; - Artikulua bistaratua izaten hasiko den data</li>
<li>\&quot;end_time\&quot; - Artikulua bistaratua izatetik gelditu beharko den data</li>
<li>\&quot;useexp\&quot; - Amaiera data kontuan hartu behar den ala ez</li>
</ul>

';
$lang['eventhelp-NewsCategoryAdded']='<p>Kategoria bat gehitzen denean bidalia.</p>
<h4>Parametroak</h4>
<ul>
<li>\&quot;category_id\&quot; - Berrien kategoriaren Id-a</li>
<li>\&quot;name\&quot; - Berrien kategoriaren izena</li>
</ul>
';
$lang['eventhelp-NewsCategoryDeleted']='<p>Kategoria bat ezabatzen denean bidalia.</p>
<h4>Parameters</h4>
<ul>
<li>\&quot;category_id\&quot; - Ezabatutako kategoriaren Id-a </li>
<li>\&quot;name\&quot; - Ezabatutako kategoriaren izena</li>
</ul>
';
$lang['eventhelp-NewsCategoryEdited']='<p>Kategoria bat editatzen denean bidalia.</p>
<h4>Parametroak</h4>
<ul>
<li>\&quot;category_id\&quot; - Berrien kategoriaren Id-a</li>
<li>\&quot;name\&quot; - Berrien kategoriaren izena</li>
<li>\&quot;origname\&quot; - Berrien kategoriaren jatorrizko izena</li>
</ul>
';
$lang['expiry']='Amaiera';
$lang['filter']='Filtroa';
$lang['help']='	<h3>What does this do?</h3>
	<p>News is a module for displaying news events on your page, similar to a blog style, except with more features!.  When the module is installed, a News admin page is added to administration menu that will allow you to select or add a news category.  Once a news category is created or selected, a list of news items for that category will be displayed.  From here, you can add, edit or delete news items for that category.</p>
	<h3>Template variables</h3>
	<ul>
		<li><b>itemcount</b> - The number of news articles to be shown.</li>
		<li><b>entry->authorname</b> - The full name of the the author including First and Last name.</li>
	</ul>
	<h3>Security</h3>
	<p>The user must belong to a group with the &#039;Modify News&#039; permission in order to add, edit, or delete News entries.</p>
	<p>In order to edit the layout templates, the user must belong to a group with the &#039;Modify Templates&#039; permission.</p>
	<p>In order to edit the global news preferences, the user must belong to a group with the &#039;Modify Site Preferences&#039; permission.</p>
	<h3>How do I use it?</h3>
	<p>The easiest way to use it is with the {news} wrapper tag (wraps the module in a tag, to simplify the syntax).  This will insert the module into your template or page anywhere you wish, and display news items.  The code would look something like: <code>{news number=&#039;5&#039;}</code></p>';
$lang['helpbrowsecat']='Erakutsi nabigagarria den kategori lista bat.';
$lang['helpcategory']='Kategori horretako elementuak bakarrik erakutsi. <b> Erabili * izenaren ostean, honen umeak erakusteko.</b> Kategoria ugari erabili ahal daitezke komekin separatuez gero. Utzik mantenduz gero, kategoria guztiak erakutsiko ditu.';
$lang['helpdetailpage']='Berrien xehetasunak erakusteko erabiliko den orrialdea. Alias bat edo id bat izan ahal da. Berrien xehetasunak, laburpenerako erabiltzen den txantiloi ezberdin baten bitartez erakusteko erabiltzen da.';
$lang['helpdetailtemplate']='Artikuluaren xehetasunak erakusteko aparteko txantiloi bat erabili. Hau modules/News/templates direktoriopean egon behar da.';
$lang['helpmoretext']='Laburpena baino luzeagoak diren berrien amaieran erakutsi beharreko textua. &quot;gehiago...&quot; dago lehenetsi moduan.
';
$lang['helpnumber']='Erakutsi beharreko elementu kopuru maximoa =- Utzik, elementu guztiak erakutsiko dira.';
$lang['helpshowarchive']='Iraungitako berriak besterik ez erakutsi.';
$lang['helpsortasc']='Berriak zaharrenetik berrirenera ordenatu.';
$lang['helpsortby']='Zein eremugatik ordenatu .  Aukerak: &quot;news_date&quot;, &quot;summary&quot;, &quot;news_data&quot;, &quot;news_category&quot;, &quot;news_title&quot;.  Lehenetsitzat: &quot;news_date&quot;.';
$lang['helpstart']='Hasi Ngarren elementuan -- Utzik, lehenengo elementuan hasiko da.';
$lang['helpsummarytemplate']='Artikuluaren laburpena erakusteko aparteko txantiloi bat erabili. Hau modules/News/templates direktoriopean egon behar da.';
$lang['more']='Gehiago';
$lang['moretext']='Textu Gehiago';
$lang['name']='Izena';
$lang['needpermission']=' &#039;%s&#039; baimena behar duzu funtzio hori egi ahal izateko.';
$lang['newcategory']='Kategoria Berria';
$lang['news']='Berriak';
$lang['news_return']='Itzuli';
$lang['nocategorygiven']='Ez da Kategoriarik Zehaztu';
$lang['nocontentgiven']='Ez da Edukirik Zehaztu';
$lang['noitemsfound']='<strong>Ez</strong> da %s kategoriarentzako elementurik topatu.';
$lang['nonamegiven']='Ez da Izenik Zehaztu';
$lang['nopostdategiven']='Ez da Bialketa Datarik Zehaztu';
$lang['note']='<em>Oharra:</em> Datak &#039;yyyy-mm-dd hh:mm:ss&#039; formatuan egon behar dira.';
$lang['notitlegiven']='Ez da Titulurik Zehaztu';
$lang['numbertodisplay']='Erakutsi Beharreko Kopurua (utzik, elementu denak erakusten ditu)';
$lang['options']='Hautapenak';
$lang['optionsupdated']='Aukerak arazorik gabe eguneratuak izan dira.';
$lang['postdate']='Igorpen Data';
$lang['postinstall']='Zihurtatu Berriak administratu behar dituzten erabiltzaile guztiek &quot;Berriak Aldatu&quot; baimena  aktibatuta dutela.';
$lang['print']='Inprimatu';
$lang['restoretodefaultsmsg']='Eragiketa honek sistemak lehenetsitakotara berrezarriko ditu txantiloiaren edukiak. Zihur al zaude aurrera jarraitu nahi duzula?';
$lang['selectcategory']='Kategoria Ahutatu';
$lang['showchildcategories']='Ume-kategoriak erakutsi';
$lang['sortascending']='Goranzka Antolatu';
$lang['startdate']='Hasiera Data';
$lang['startoffset']='N-garren elementuan hasi';
$lang['startrequiresend']='Hasiera data sartuez gero amaiera data beharrezkoa da';
$lang['status']='Egoera';
$lang['submit']='Onartu';
$lang['summary']='Laburpena';
$lang['summarytemplate']='Laburpenaren Txantiloia';
$lang['summarytemplateupdated']='Berrien Laburpen Txantiloia arazorik gabe eguneratu da.';
$lang['sysdefaults']='Lehenetsiak berrezarri';
$lang['title']='Titulua';
$lang['useexpiration']='Erabili Amaiera Data';
?>