<?php
$lang['help_function_html_blob'] = '<h3>Hva gjør denne?</h3>
	<p>Se hjelpen for global_content for en beskrivelse.</p>';
$lang['help_function_uploads_url'] = '<h3>Hva gjør denne?</h3>
	<p>Skriver ut opplastinger url stedet for området.</p>
	<h3>Hvordan bruker jeg det?</h3>
	<p>Bare sett inn koden i malen/siden som: <code>{uploads_url}</code></p>
	<h3>Hvilke parametere tar det?</h3>
	<p><em>(optional)</em> assign (string) - Tilordne resultatene til en smarty-variabel med det navnet.</p>';
$lang['help_function_contact_form'] = '<h2>MERK: Denne plugin er foreldet</h2>
  <h3>Dette programtillegget er fjernet fra og CMS Made Simple versjon 1.5</h3>
  <p>Du kan bruke modulen FormBuilder i stedet.</p>';
$lang['help_function_breadcrumbs'] = '<h3 style="font-weight:bold;color:#f00;">FJERNET - Bruk nå &#123nav_breadcrumbs&#125 or &#123Navigator action=\'breadcrumbs\'&#125</h3>';
$lang['help_function_anchor'] = '<h3>Hva gjør denne?</h3>
	<p>Gjør et skikkelig anker link.</p>
	<h3>Hvordan bruker jeg det?</h3>
	<p>Bare sett inn koden i malen/siden som: <code>{anchor anchor=\'here\' text=\'Scroll Down\'}</code></p>
	<h3>Hvilke parametere tar det?</h3>
	<ul>
	<li><tt>anchor</tt> - Hvor vi knytter til. Delen etter #.</li>
	<li><tt>text</tt> - Teksten som skal vises i lenken.</li>
	<li><tt>class</tt> - Klassen for lenken, hvis noen</li>
	<li><tt>title</tt> - Tittelen som skal vises for linken, hvis noen.</li>
	<li><tt>tabindex</tt> - Den numeriske tabindex for lenken, hvis noen.</li>
	<li><tt>accesskey</tt> - Accesskey for linken, hvis noen.</li>
	<li><em>(optional)</em> <tt>onlyhref</tt> - Vis bare href og ikke hele lenken. Ingen andre alternativer vil fungere</li>
	<li><em>(optional)</em> <tt>assign</tt> - Tilordne resultatene til den navngitte smarty-variabelen.</li>
	</ul>';
$lang['help_function_site_mapper'] = '<h3>Hva gjør denne?</h3>
  <p>Dette er egentlig bare en wrapper-tag for menyen Manager-modulen for å gjøre taggens syntaks enklere, og for å forenkle opprettelsen av et nettstedkart.</p>
<h3>Hvordan bruker jeg det?</h3>
  <p>Bare Putt <code>{site_mapper}</code> på en side eller i en mal. For hjelp om menymanagermodulen, hvilke parametere det krever etc., vennligst se menystyringsmodulhjelpen.</p>
  <p>Som standard, hvis ikke noe malalternativ er angitt, vil filen minimal_menu.tpl bli brukt.</p>
  <p>Eventuelle parametrene som brukes i kode er tilgjengelige i menumanager malen som <code>{$menuparams.paramname}</code></p>';
$lang['help_function_redirect_url'] = '<h3>Hva gjør denne?</h3>
  <p>Dette programtillegget kan du enkelt omdirigere til en spesifisert url. Det er praktisk innsiden av Smarty betinget logikk (for eksempel viderekoble til en splash-side hvis området ikke er lever ennå).</p>
<h3>vordan bruker jeg det?</h3>
<p>Bare å sette denne Tagen inn i siden eller malen: <code>{redirect_url to=\'http://www.cmsmadesimple.org\'}</code></p>';
$lang['help_function_redirect_page'] = '<h3>Hva gjør denne?</h3>
 <p>Dette programtillegget kan du enkelt omdirigere til en annen side. Det er praktisk innsiden av Smarty betinget logikk (for eksempel viderekoble til en innloggingsside hvis brukeren ikke er logget inn.)</p>
<h3>Hvordan bruker jeg det?</h3>
<p>Bare å sette denne Tagen inn i siden eller malen:<code>{redirect_page page=\'some-page-alias\'}</code></p>';
$lang['help_function_thumbnail_url'] = '<h3>Hva gjør denne?</h3>
<p>Denne taggen genererer en URL til en fil i opplastingsbanen til CMSMS-installasjonen.</p>
<p>Denne taggen returnerer en tom streng hvis filen som er oppgitt, ikke eksisterer, eller det er tillatelse problemer.</p>
<h3>Bruk:</h3>
<ul>
  <li>file - <strong>nødvendig</strong> - Filnavnet og banen i forhold til opplastingsmappen.</li>
  <li>dir - <em>(valgfri)</em> - En valgfri katalog prefiks til foran til filnavnet.</li>
  <li>assign - <em>(valgfri)</em> - Tilordne eventuelt utgangen til den navngitte smarty-variabelen.</li>
</ul>
<h3>Eksempel:</h3>
<pre><code><a href="{file_url file=\'images/noen-ting.jpg\'}">view file</a></code></pre>
<h3>Tips:</h3>
<p>Det er en triviell prosess å lage en generisk mal eller smarty-funksjon som vil bruke <code>{file_url}</code> og <code>{thumbnail_url}</code> plugins for å generere et miniatyrbilde og lenke til et større bilde.</p>';
$lang['help_function_file_url'] = '<h3>Hva gjør denne?</h3>
<p>Denne taggen genererer en URL til en fil i opplastingsbanen til CMSMS-installasjonen.</p>
<p>Denne taggen returnerer en tom streng hvis filen som er oppgitt ikke eksisterer eller det er tillatelser propblems.</p>
<h3>Bruk:</h3>
<ul>
  <li>file - <strong>nødvendig</strong> - Filnavnet og banen i forhold til opplastingsmappen.</li>
  <li>dir - <em>(valgfri)</em> - Et valgfritt katalog prefiks for å prepend til filnavnet.</li>
  <li>assign - <em>(valgfri)</em> - Eventuelt tildele utgangen til den navngitte smarty variabel.</li>
</ul>
<h3>Eksempel:</h3>
<pre><code><a href="{file_url file=\'images/noe.jpg\'}">view file</a></code></pre>
<h3>Tip:</h3>
<p>Det er en triviell prosess å lage en generisk mal eller smarty-funksjon som vil bruke <code>{file_url}</code> og <code>{thumbnail_url}</code> plugins for å generere et miniatyrbilde og lenke til et større bilde.</p>';
$lang['help_function_form_end'] = '<h3>Hva gjør denne?</h3>
<p>Denne tagen skaper en slutt form tag.</p>
<h3>Hvilke parametere tar det?</p>
<ul>
  <li>tildel - <em>(optional)</em> - Tildel resultatene av denne koden til den navngitte smarty variabel.</li>
</ul>
<h3>Bruk:</h3>
<pre><code>{form_end}</code></pre>
<h3>Se Også:</h3>
<p>Se {form_start} tag som er supplement til denne koden.</p>';
$lang['function'] = 'Funksjoner kan utføre en oppgave, eller søke i databasen, og vanligvis vise utdata. De kan bli kalt ut {tagname [attribute=value...]}';
$lang['modifier'] = 'Modifiers ta resultatet av en smarty variabel og endre den. De kalles ut: {$variable|modifier[:arg:...]}';
$lang['postfilter'] = 'Postfiltere kalles automatisk av Smarty etter utarbeidelsen av hver mal. De kan ikke kalles manuelt.';
$lang['prefilter'] = 'Pre-Filter kalles automatisk av Smarty før utarbeidelsen av hver mal. De kan ikke kalles manuelt.';
$lang['tag_about'] = 'Vis historie og forfatterinformasjon for denne plugin, er tilgjengelig';
$lang['tag_adminplugin'] = 'Indikerer at koden er tilgjengelig i admin-grensesnittet, og blir vanligvis brukt i modulmaler';
$lang['tag_cachable'] = 'Angir om produksjonen av plugin kan bli lagret (når Smarty mellomlagring er aktivert). Admin plugins, og modifikatorer kan ikke bli lagret.';
$lang['tag_help'] = 'Vise hjelp (hvis noen finnes) for denne koden';
$lang['tag_name'] = 'Dette er navnet på koden';
$lang['tag_type'] = 'Kode type (funksjon, modifier, eller en pre eller post filter)';
$lang['title_admin'] = 'Dette programtillegget er kun tilgjengelig fra CMSMS administrasjonskonsoll..';
$lang['title_notadmin'] = 'Dette programtillegget kan brukes i både administrasjonskonsollen og på nettsidens frontend.';
$lang['title_cachable'] = 'Denne programtillegget kan bufres';
$lang['title_notcachable'] = 'Dette programtillegget kan ikke bufres';
$lang['viewabout'] = 'Vis historie og forfatterinformasjon for denne modulen';
$lang['viewhelp'] = 'Vis hjelp for denne modulen';
?>