<?php
$lang['admindescription'] = 'En minimalistisk, men likevel kraftig, implementering av TinyMCE WYSIWYG-editoren.';
$lang['browse'] = 'Bla frem';
$lang['cancel'] = 'Avbryt';
$lang['class'] = 'Klasse';
$lang['cmsms_linker'] = 'Link til CMSMS-side';
$lang['css_styles_help'] = 'CSS-stilnavn spesifisert her blir lagt til en nedtrekksmeny i redigereren. Å la dette feltet stå tomt vil medføre at nedtrekksmenyen blir gjemt (standard oppførsel).';
$lang['css_styles_help2'] = 'Stilene kan enten være bare klassenavnet, eller et klassenavn med et nytt navn som skal vises. 
Stilene må separeres med enten komma eller ny linje.
<br/>Eksempel: mystyle1, My style name=mystyle
<br/>Resultat: en nedtrekksmeny som inneholder to valg, \'mystyle1\' og \'My stylename\' som respektivt resulterer i innsetting av mystyl1, og mystyle2.
<br/>Merk: Det gjøres ingen sjekk for at stilnavnene faktisk eksisterer. De benyttes blindt.';
$lang['css_styles_text'] = 'CSS stiler';
$lang['description'] = 'Beskrivelse';
$lang['dimensions'] = 'BxH';
$lang['dimension'] = 'Dimensjon';
$lang['dirinfo'] = 'Endre arbeidsmappe til';
$lang['edit_image'] = 'Rediger bilde';
$lang['edit_profile'] = 'Rediger profil';
$lang['error_cantchangesysprofilename'] = 'Du kan ikke endre navnet til en systemprofil';
$lang['error_missingparam'] = 'En påkrevd parameter mangler';
$lang['error_nopage'] = 'Ingen sidealias valgt';
$lang['example'] = 'MicroTiny eksempel';
$lang['filepickertitle'] = 'Filvelger';
$lang['friendlyname'] = 'MicroTiny WYSIWYG-redigerer';
$lang['fileview'] = 'Filvisning';
$lang['filename'] = 'Filnavn';
$lang['filterby'] = 'Filtrer';
$lang['height'] = 'Høyde';
$lang['help'] = '<h3> Hva gjør dette? </h3>
<p> MicroTiny er en liten, begrenset versjon av TinyMCE-editoren, tidligere WYSIWYG-default av CMS Made Simple. Dette gir noe mer enn grunnleggende redigering, men er fortsatt et kraftig verktøy som tillater enkle endringer til innhold.</p>
<p> Denne modulen gir svært få alternativer og er utformet for å tillate begrenset funksjonalitet til innhold redaktørene uten kunnskap om HTML. Hensikten er at de vil ha svært få muligheter til å være i stand til å rote med oppsettet av en side, eller utseendet og følelsen av et nettsted.</p>
<h3> Hvordan bruker jeg den?</h3>
<p> MicroTiny testområdet skal vises automatisk (for brukere med tilstrekkelige tillatelser) under "Utvidelser >> MicroTiny WYSIWYG Editor" alternativet i CMSMS adminkonsollet.</p>
</p> For MicroTiny å bli brukt som WYSIWYG editor når du redigerer sider, må MicroTiny Wysiwyg Editor velges i brukerens preferanser. Vennligst velg "MicroTiny" i "Select WYSIWYG å Bruke" under "Mine innstillinger >> User Preferences" i CMSMS Adminpanelet. Ekstra valg i forskjellige moduler eller i innhold sidemaler, og innholdssider selv kan selv kontrollere om et tekstområde eller et wysiwyg-felt skal vises i ulike redigeringskjemaer. </p>
<h3>Om stiler og farger</h3>
<p>MicroTiny vil lese stilark knyttet til den aktuelle malen <em>(hvis ingen mal kan fastslås vil standardmalen og dens stilark brukes)</em>. og fjerne bakgrunnsbilder for å visualisere teksten i et miljø så nært som mulig til hva som vil vises på nettsiden. Hvis ditt tema bruker en mørk bakgrunn, sammen med bakgrunnsbilder i dine stiler kan du oppleve problemer. Vi foreslår at du alltid inkluderer en farge i dine bakgrunns spesifikasjoner. i.e:
<pre><code>body {
  color: #eee;
  background: <span style="color: blue;">#ddd</span> url (sti/til/ett/bilde.jpg);
}
</pre></code>
<h3> Hva med frontend Wysiwygs</h3>
<p> Fra tid til annen kan det være nødvendig å gi et wysiwyg tekstområde med begrenset funksjonalitet til frontend redaktører. For å gjøre dette, må du følge to trinn <em>(kan endres i fremtidige versjoner av CMSMS)</em>.
<ul>
  <li> Sett MicroTiny som Frontend Wysiwyg i "Site Admin >> Gobal Settings" side på "General Settings"-fanen.</li>
  <li> Legg til taggen {MicroTiny action = enablewysiwg} kallet til sider der wysiwhg editor ønskes brukt. Dette kan enten gjøres i head-delen av sidemalen i globale metadata, eller i sidespesifikke metadata seksjoner. Denne taggen tar ingen ekstra parametre. </li>
</ul>
</p>

Engelsk:
<h3>What Does This Do?</h3>
<p>MicroTiny is a small, restricted version of the <a href="http://www.tinymce.com" target="_blank">TinyMCE</a> editor. allowing content editors a near WYSIWYG appearance for editing content.  It works with content blocks in CMSMS content pages (when a WYSIWYG has been allowed), in module Admin forms where WYSIWYG editors are allowed, and allows restricted capabilities for editing HTML blocks on frontend pages.</p>
</p>In order for MicroTiny to be used as the WYSIWYG editor in the Admin console the MicroTiny WYSIWYG Editor needs to be selected in the users preferences.  Please select "MicroTiny" in the "Select WYSIWYG to Use" option under "My Preferences >> User Preferences" in the CMSMS Admin panel.  Additional options in various modules or in content page templates, and content pages themselves can control whether a text area or a WYSIWYG field is provided in various edit forms.</p>
<p>For Frontend editing capabilities MicroTiny must be selected as the "Frontend WYSIWYG" in the global settings page of the CMSMS Admin console.</p>
<h3>Features:</h3>
<ul>
  <li>Supports a subset of HTML5 block and inline elements.</li>
  <li>Separate profiles for Admin editors and frontend editors.</li>
  <li>A custom file picker for selecting previously uploaded media.</li>
  <li>Custom plugin for creating links to CMSMS content pages <em>(Admin only)</em>.</li>
  <li>Customizable (somewhat) profiles for Admin behavior and frontend behavior.</li>
  <li>Customizable appearance by specifying a stylesheet to use for the editor.</li>
</ul>
<h3>How do I use it</h3>
  <ul>
    <li>Install and configure the module</li>
    <li>Set MicroTiny as your WYSIWYG editor of choice in "My Preferences"</li>
  </ul>
<h3>About HTML, TinyMCE, and content editing:</h3>
  <ul>
    <li>WYSIWYG-like editor:
       <p>This editor provides the ability to edit content in an environment that is similar <em>(but not necessarily identical to)</em> to the intended output on the website frontend. Numerous factors can influence differences, including:</p>
       <ul>
         <li>Incomplete or incorrect stylesheets</li>
         <li>Use of advanced styling that the editor cannot understand</li>
         <li>Use of HTML elements that the WYSIWYG does not understand.</li>
       </ul>
    </li>

    <li>Subset of HTML elements:
      <p>As a simple content editor this editor does not support all of the HTML elements (particularly the new HTML5 block level elements.  Any elements that the editor does not understand or support will be stripped from the content upon save.  As a general rule of thumb <em>(not including <div>)</em> you can assume that the editor supports only the elements that are directly available via the various menu and toolbar options.<p>
    </li>

    <li>Edit blocks of content, not the entire page:
      <p>As CMS Made Simple is a heavily templated environment using the Smarty template element, it is intended that the WYSIWYG editor is used only for specific blocks of content or data elements (i.e: the main content area of a page, or the description for a News or Blog article).   This module <em>(and CMSMS)</em> do not support full page editing.</p>
    </li>

    <li>Intended for simple content editing not design:
      <p>The intent and purpose of this module is to provide a WYSIWYG-like environment where editors can insert and edit content within specific blocks with limited formatting capabilities that will not interfere with, or override the styling of the page template.  It is not intended and for will not be supported as a general HTML editor or layout manipulator.</p>
      <p>Website developers should understand the points above, assume that content editors can and WILL be editing within a WYSIWYG area and ensure that only simple content is there.  If advanced layout techniques are needed for a specific area, then developers should modify the appropriate templates so that the restricted functionality editor will work properly.</p>
    </li>

    <li>Separation of Logic, Functionality and Design from Content.
      <p>This editor is built with the assumption that content for a specific area of a page (or a blog article, news article, or product description, ...) is data.  The data is styled by the appropriate templates, and should not be mixed with design elements, or functionality of the website.</p>
      <p>As a simple example.  If you are insisting that editors use certain classes for images, layout their images in a certain manner, or insert block elements such as <div> or <section> into their content for proper styling then this is not the editor module for you.  Such styling concerns should be taken care of in stylesheets and templates, such that your editor can enter text without having to remember rules.</p>
      <p>This module is not designed to handle special cases where advanced HTML is required.  In such pages the WYSIWYG editor should be disabled, and editing access to the page restricted to those with the ability to understand and edit HTML code manually.</p>
      <p>As this module is intended to provide a restricted editor for specific blocks, for use by editors without HTML knowledge. Since the WYSIWYG editor does not understand the Smarty logic, you should NOT (as a general rule) mix Smarty logic or module calls within WYSIWYG enabled areas.  It is best to disable the WYSIWYG for these areas/pages and restrict edit access to those pages.</p>
    </li>
  </ul>
<h3>About Images and Media:</h3>
  <p>Each profile has the ability to enable, and disable the ability for the editor to graphically insert image or media elements into the edited content.  This is useful in highly structured environments where images and other media can be included in final output via other means.  Particularly on frontend editing forms, where the identify of the user cannot necessarily be trusted it is recommended that users not have the ability to insert images or other media.</p>
  <p><strong>Note:</strong> This module does not provide the ability to upload or otherwise manipulate files, images or media.  That functionality is handled elsewhere in CMSMS.</p>

<h3>About Frontend Editing:</h3>
  <p>This module provides a unique "profile" for configuring the WYSIWYG editor on frontend requests.  By default the frontend profile is highly limited.</p>
  <p>To enable frontend WYSIWYG editors, the <code>{cms_init_editor}</code> tag must be included in the head part of the template.  Additionally, this module must be set as the "Frontend WYSIWYG" in the global settings page of the CMSMS admin console.</p>

<h3>About Styles and Colors:</h3>
  <p>This module provides the <em>(optional)</em> ability to associate a stylesheet with the profile.  This provides the ability to style the edit portion WYSIWYG editor in a manner similar to the website style.  Providing a more WYSIWYG like experience for the content editor.</p>
  <p>Additionally, in conjunction with the <code>classname</code> parameter of the <code>{cms_textarea}</code> and <code>{content}</code> tags this module allows the content editor module to override the specified stylesheet differently for each content block.  This allows the ability to style each WYSIWYG area differently, if there are multiple WYSIWYG areas on the page.  This functionality is restricted to the Admin interface only.</p>
  <p>For example, in a page template adding the cssname parameter to the {content} tag allows specifying a CMSMS stylesheet to use to customize the appearance of that content block.  i.e: <code>{content block=\'second block\' cssname=\'whiteonblack\'}</code>
  <p>Additionally, a setting in the content editing section of the "Global Settings" page allows automatically supplying the css name parameter with the name of the content block.</p>

  <h4>Styles for the WYSIWYG editor</h4>
    <p>The stylesheet for the WYSIWYG editor area should style everything from the body element downwards. It is only necessary to style the elements available to, and used by the content editor.  Here is a simple example of a stylesheet for a white-on-black theme:</p>
<pre><code>
body {
 background: black;
 color: white;
}
p {
 margin-bottom: 0.5em;
}
h1 {
 color: yellow;
 margin-bottom: 1em;
}
h2 {
 color: cyan;
 margin-bottom: 0.75em;
}
</code></pre>

<h3>FAQ:</h3>
  <dl>
   <dt>Q: Where is the support for <em style="color: red;">"some functionality"</em> in the editor, and how do I activate it?</dt>
      <dd>A: You don\'t.  The version of TinyMCE distributed with MicroTiny is a trimmed down, custom package.  We have added our own custom plugins, but don\'t support the addition of custom plugins or the ability to customize the configuration in any way other than the edit profile form.  If you require additional functionality in a WYSIWYG editor you may have some success in a third party module.</dd>
    <br/>
    <dt>Q: Which HTML/HTML5 tags are supported by this module, and how do I change that?</dt>
      <dd>A: The list of supported elements in the default TinyMCE editor can be found on the TinyMCE website <em>(though we don\'t have a correct link at the moment)</em>.  There is no mechanism in the MicroTiny module to extend that.</dd>
    <br/>
    <dt>Q: I cannot get the MicroTiny editor to work in the Admin interface, what can I do</dt>
      <dd>A: There are a few steps you can follow to diagnose this issue:
        <ol>
          <li>Check the CMSMS Admin log, your PHP error log, and the JavaScript console for indications of a problem.</li>
          <li>Ensure that the example WYSIWYG area works in the MicroTiny Admin panel under "Extensions >> MicroTiny WYSIWYG Editor".  If this does not work, recheck your PHP error log and JavaScript console.</li>
          <li>Ensure that MicroTiny is selected as the "WYSIWYG to use" in your user preferences.</li>
          <li>Check other content pages. If MicroTiny works on one or more of those then that indicates that a flag to disable WYSIWYG editors on all content blocks may be set on some content pages.</li>
          <li>Check the page template(s). The wysiwyg=false parameter may be specified on one or more content blocks in the page template(s) which will disable the WYSIWYG editor.</li>
        </ol>
      </dd>
    <dt>Q: How do I insert a <br/> instead of create new paragraphs?</dt>
      <dd>A: Press [shift]+Enter instead of just the Enter key.</dd>
    <br/>
    <dt>Q: Why is <em style="color: red;">"some functionality"</em> available in the menubar, and not the toolbar?</dt>
      <dd>A: For this most part this is done intentionally to allow web developers the ability to further restrict the functionality of certain editor profiles.  The menubar can be toggled off in different profiles thus denying the user the functionality only available in the menubar.</dd>
  </dl>
<h3>Caching:</h3>
  <p>In an effort to improve performance, MicroTiny will attempt to cache the generated JavaScript files unless something has changed. This functionality can be disabled by setting the special config entry <code>mt_disable_cache</code> to true. i.e: adding <code>$config["mt_disable_cache"] = true;</code> to the config.php file.</p>
<h3>See Also:</h3>
<ul>
  <li><code>{content}</code> tag in "Extensions >> Tags"</li>
  <li><code>{cms_textarea}</code> tag in "Extensions >> Tags"</li>
  <li><code>{cms_init_editor}</code> tag in "Extensions >> Tags"</li>
  <li>The <a href="http://www.tinymce.com" target="_blank">TinyMCE</a> editor itself.</li>
</ul>';
$lang['image'] = 'Bilde';
$lang['info_linker_autocomplete'] = 'Dette er et autofullføringsfelt. Start med å taste inn noen bokstaver fra det ønskede sidealiaset, menyteksten eller tittelen. Alle matchende funn vil vises i en liste';
$lang['loading_info'] = 'Laster...';
$lang['mailto_image'] = 'Opprett et e-post bilde';
$lang['mailto_text'] = 'Lag en e-post med lenke';
$lang['mailto_title'] = 'Lag en e-post med lenke';
$lang['msg_cancelled'] = 'Operasjon avbrutt';
$lang['mthelp_allowcssoverride'] = 'Ved aktivering vil all kode som initialiserer et MicroTiny WYSIWYG-område kunne spesifisere navnet på et stilsett som kan brukes i stedet for standardstilsettet spesifisert over.';
$lang['mthelp_dfltstylesheet'] = 'Knytt et stilark med editoren som bruker denne profilen. Dette gjør at WYSIWYG editoren vil ligne på nettstedets utseende.';
$lang['mthelp_profileallowimages'] = 'Tillat editoren å legge inn bilder og videoer i tekstområdet. For svært kontrollerte design bør innholdsredigerere bare være i stand til å velge bilder eller videoer for bestemte områder i en web-side.';
$lang['mthelp_profileallowtables'] = 'Tillat editoren å legge inn og manipulere tabeller for tabelldata. Merk: Dette bør ikke brukes for å kontrollere layouten, men bare for tabelldata.';
$lang['mthelp_profilelabel'] = 'En beskrivelse for denne profilen. Beskrivelsen kan ikke endres for systemprofiler.';
$lang['mthelp_profilename'] = 'Navnet på denne profilen. Navnet på systemprofiler kan ikke endres.';
$lang['mthelp_profilemenubar'] = 'Indikerer om menylinjen skal være aktiv i visbare profiler. Menylinjen har typisk flere valg enn knapperaden.';
$lang['mthelp_profilestatusbar'] = 'Dette flagget indikerer om statuslinja nederst i WYSIWYG-området bør være aktivert. Statuslinjen viser noen nyttige omfang informasjon for avanserte redaktører, og annen nyttig informasjon';
$lang['mthelp_profileresize'] = 'Dette flagget indikerer om WYSIWYG området kan endre størrelse. For at evnen til å endre størrelse skal fungere så må statuslinja være aktivert';
$lang['newwindow'] = 'Nytt vindu';
$lang['none'] = 'Ingen';
$lang['ok'] = 'OK';
$lang['prompt_linker'] = 'Skriv inn sidetittel';
$lang['prompt_linktext'] = 'Lenke Tekst';
$lang['prompt_profiles'] = 'Profiler';
$lang['prompt_selectedalias'] = 'Valgt sidealias';
$lang['profiledesc___admin__'] = 'Denne profilen brukes av alle brukere som er autorisert til å bruke denne editoren, og har valgt denne editoren som sin WYSIWYG editor';
$lang['profiledesc___frontend__'] = 'Denne profilen brukes for alle frontend forespørsler hvor denne WYSIWYG editor er tillatt';
$lang['profile_admin'] = 'Admin redigerer';
$lang['profile_allowcssoverride'] = 'Tillat blokker å overstyre den valgte stilen';
$lang['profile_allowimages'] = 'Tillat bilder';
$lang['profile_allowresize'] = 'Tillat størrelsesendring';
$lang['profile_allowtables'] = 'Tillat tabeller';
$lang['profile_dfltstylesheet'] = 'Stilark for redigerer';
$lang['profile_frontend'] = 'Frontend redigerer';
$lang['profile_label'] = 'Etikett';
$lang['profile_name'] = 'Profilnavn';
$lang['profile_menubar'] = 'Vis meny';
$lang['profile_showstatusbar'] = 'Vis statuslinje';
$lang['prompt_name'] = 'Navn';
$lang['prompt_target'] = 'Mål';
$lang['prompt_class'] = 'Klasse attributt';
$lang['prompt_email'] = 'Epost-adresse';
$lang['prompt_insertmailto'] = 'Sett inn/rediger en e-post med link';
$lang['prompt_anchortext'] = 'Anker tekst';
$lang['prompt_rel'] = 'Rel attributt';
$lang['prompt_texttodisplay'] = 'Tekst som skal vises';
$lang['savesettings'] = 'Lagre innstillinger';
$lang['settings'] = 'Innstillinger';
$lang['settingssaved'] = 'Innstillinger lagret';
$lang['size'] = 'Størrelse';
$lang['submit'] = 'Send';
$lang['switchgrid'] = 'Bytt til rutenettvisning';
$lang['switchlist'] = 'Bytt til listevisning';
$lang['switchimage'] = 'Vis bildefiler';
$lang['switchvideo'] = 'Vis videofiler';
$lang['switchaudio'] = 'Vis lydfiler';
$lang['switcharchive'] = 'Vis arkivfiler';
$lang['switchfiles'] = 'Vis filer';
$lang['switchreset'] = 'Vis alle';
$lang['tooltip_selectedalias'] = 'Dette feltet er kun lesbart';
$lang['title_cmsms_linker'] = 'Lag en lenke til en CMSMS innholdsside';
$lang['title_cmsms_filebrowser'] = 'Velg en fil';
$lang['title_edit_profile'] = 'Rediger profil';
$lang['tmpnotwritable'] = 'Konfigurasjonen kunne ikke bli skrevet til tmp-mappa! Vennligst fiks dette!';
$lang['tab_general_title'] = 'Generelt';
$lang['tab_advanced_title'] = 'Avansert';
$lang['type'] = 'Type';
$lang['usestaticconfig_help'] = 'Dette genererer en statisk konfigurasjonsfil i stedet for en dynamisk. Dette fungerer bedre på enkelte servere (for eksempel når PHP kjøres som CGI)';
$lang['usestaticconfig_text'] = 'Benytt statisk konfigurasjon';
$lang['width'] = 'Vidde';
$lang['view_source'] = 'Vis kilder';
$lang['youareintext'] = 'Nåværende katalog';
?>