<?php
$lang['add_profile'] = 'Legg til en ny Profil';
$lang['can_delete'] = 'Tillat Sletting';
$lang['can_mkdir'] = 'Tillat å opprette katalog';
$lang['can_upload'] = 'Ppplastinger Tillatt';
$lang['changedir'] = 'Endre katalog til';
$lang['clear'] = 'Rens';
$lang['confirm_delete'] = 'Er du sikker på at du vil slette denne?';
$lang['create_dir'] = 'Opprett en ny mappe';
$lang['dimension'] = 'Dimensjoner';
$lang['delete'] = 'Slett';
$lang['delete_profile'] = 'Slett Profil';
$lang['edit_profile'] = 'Rediger Profil';
$lang['error_ajax_invalidfilename'] = 'Beklager, det filnavnet er ikke gyldig';
$lang['error_ajax_fileexists'] = 'Beklager, en fil eller katalog med det navnet eksiterer allerede';
$lang['error_ajax_mkdir'] = 'Et problem oppstod ved opprettelse av katalogen %s';
$lang['error_ajax_writepermission'] = 'Beklager, du har ikke rettighet til å skrive i denne katalogen';
$lang['error_failed_ajax'] = 'Et problem oppstod med en ajax forespørsel';
$lang['error_problem_upload'] = 'Beklager, et problem oppstod med opplasting';
$lang['error_upload_acceptFileTypes'] = 'Filer av denne type er ikke godtatt i denne sammenhengen';
$lang['error_upload_maxFileSize'] = 'Filen er for stor';
$lang['error_upload_minFileSize'] = 'Filen er for liten';
$lang['error_upload_maxNumberOfFiles'] = 'Du laster opp for mange filer på en gang';
$lang['err_profile_topdir'] = 'Topp-katalogen som er spesifisert eksisterer ikke';
$lang['filename'] = 'Filnavn';
$lang['filterby'] = 'Filtrer etter';
$lang['filepickertitle'] = 'CMSMS filvelger';
$lang['fileview'] = 'Fil visning';
$lang['friendlyname'] = 'Filvelger';
$lang['hdr_add_profile'] = 'Legg til profil';
$lang['hdr_edit_profile'] = 'Rediger profil';
$lang['HelpPopupTitle_ProfileName'] = 'Profil navn';
$lang['HelpPopup_ProfileName'] = 'Hver profil bør ha et enkelt, unikt navn. Navn skal kun inneholde alfanumeriske tegn, og/eller understrek tegnet _';
$lang['HelpPopupTitle_ProfileCan_Delete'] = 'Tillat sletting av filer';
$lang['HelpPopup_ProfileCan_Delete'] = 'Alternativt tillate brukere å slette filer under en valgprosess';
$lang['HelpPopupTitle_ProfileCan_Mkdir'] = 'Tillat å slette filer';
$lang['HelpPopup_ProfileCan_Mkdir'] = 'Alternativt tillate brukere å opprette nye kataloger (nedenfor den spesifiserte topp-katalogen) under valgprosessen.';
$lang['HelpPopupTitle_ProfileCan_Upload'] = 'Tillat opplasting';
$lang['HelpPopup_ProfileCan_Upload'] = 'Alternativt tillat brukere å laste opp filer under valgprosessen';
$lang['HelpPopupTitle_ProfileDir'] = 'Topp-katalog';
$lang['HelpPopup_ProfileDir'] = 'Alternativt angi den relative banen til en katalog (relativt til uploads banen) for å begrense operasjoner til denne.';
$lang['HelpPopupTitle_ProfileShowthumbs'] = 'Vis miniatyrbilder';
$lang['HelpPopup_ProfileShowthumbs'] = 'Om aktivert, så vil miniatyrbilder være synlige for bildefiler for de filer hvor miniatyrbilder er generert.';
$lang['name'] = 'Navn';
$lang['no_profiles'] = 'Ingen profiler er definerte ennå. du kan legge til nye ved å klikke knappen nedenfor.';
$lang['ok'] = 'OK';
$lang['select_an_audio_file'] = 'Velg en lydfil';
$lang['select_a_video_file'] = 'Velg en videofil';
$lang['select_a_media_file'] = 'Velg en midafil';
$lang['select_a_document'] = 'Velg et dokument';
$lang['select_an_archive_file'] = 'Velg en arkivfil';
$lang['select_a_file'] = 'Velg en fil';
$lang['select_an_image'] = 'Velg et bilde';
$lang['select_upload_files'] = 'Velg filer å laste opp';
$lang['show_thumbs'] = 'Vis miniatyrbilder';
$lang['size'] = 'Størrelse';
$lang['switcharchive'] = 'Vis kun arkivfiler';
$lang['switchaudio'] = 'Vis kun lydfiler';
$lang['switchfiles'] = 'Vis kun vanlige filer';
$lang['switchgrid'] = 'Vis filer i rutenett';
$lang['switchimage'] = 'Vis kun bildefiler';
$lang['switchlist'] = 'Vis filer i en liste';
$lang['switchreset'] = 'Vis alle filer';
$lang['switchvideo'] = 'Vis kun videofiler';
$lang['th_created'] = 'Laget';
$lang['th_default'] = 'Standard';
$lang['th_id'] = 'ID';
$lang['th_last_edited'] = 'Sist Endret';
$lang['th_name'] = 'Navn';
$lang['th_reltop'] = 'Top Katalog';
$lang['title_mkdir'] = 'Opprett Katalog';
$lang['topdir'] = 'Top Katalog';
$lang['type'] = 'Type';
$lang['upload'] = 'Last opp';
$lang['youareintext'] = 'Nåværende arbeidskatalog (relativt til toppen av installasjonen)';
$lang['help'] = '<h3>Hva gjør denne?</h3>
<p>Denne modulen tilbyr generelt å la en autorisert admin editor å velge en fil. I.e: å velge et bilde for bruk i et WYSIWYG-felt, eller for å knytte et bilde eller miniatyrbilde med en side, eller legge ved en PDF-fil til en nyhetsartikkel. Modulen har også tilleggsfunksjonalitet som tillater autoriserte brukere å laste opp og slette filer, eller å opprette og fjerne underkataloger.</p>
<p>Denne modulen tillater også opprettelse av flere profiler med forskjellige funksjoner. Profiler kan brukes av<code>{cms_filepicker}</code>Plugin eller av modulens "velg" Handling når du definerer hvordan plukkeren skal oppføre seg. Andre modulparametere, eller brukerrettigheter, kan overstyre innstillingene som er definert i profilen.</p>

<h3>Hvordan bruker jeg det</h3>
<p>Denne modulen er ment å bli brukt i kjerne- eller tredjepartsmodulene via ulike kjerne-APIer. Og via {cms_filepicker} plugin.</p>
<p>I tillegg kan denne modulen kalles direkte via <code>{cms_module module=FilePicker action=select name=string [profile=string] [type=string] [value=string]}</code> tag, men dette anbefales ikke.   Se {cms_filepicker} tagg for informasjon om typen og andre parametere.</p>

<h3>Hjelp</h3>
<p>I henhold til GPL er denne programvaren gitt som-er. Vennligst les teksten til lisensen for hele ansvarsfraskrivelsen.</p>

<h3>Opphavsrett og lisens</h3>
<p>Opphavsrett © 2017, JoMorg and calguy1000. Alle rettigheter er reservert.</p>
<p>Denne modulen er utgitt under <a href="http://www.gnu.org/licenses/licenses.html#GPL">GNU Public License</a>. Du må godta denne lisensen før du bruker modulen.</p>';
?>