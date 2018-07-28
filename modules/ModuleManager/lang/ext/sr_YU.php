<?php
$lang['admin_title'] = 'Administratorska konzola Modul Menadžera';
$lang['abouttxt'] = 'O modulu';
$lang['accessdenied'] = 'Pristup odbijen. Molimo proverite Va&scaron;e dozvole.';
$lang['action_activated'] = 'Modul %s je aktiviran.';
$lang['action_installed'] = 'Modul %s je instaliran uz sledeću/e poruku/e: %s';
$lang['action_upgraded'] = 'Modul %s je ažuriran';
$lang['admindescription'] = 'Alat za preuzimanje i instaliranje modula sa udaljenih servera.';
$lang['advancedsearch_help'] = 'Navedite reči koje treba uključiti ili isključiti iz pretrage koristeći &quot;+&quot; ili &quot;-&quot;; okružite tačne fraze navodnicima, npr:  +crvena -jabuka +&quot;neki tekst&quot;';
$lang['all_modules_up_to_date'] = 'Nema novijih modula u repozitorijumu';
$lang['availablemodules'] = 'Trenutni status modula sa tekućeg repozitorijuma';
$lang['available_updates'] = 'Ima novijih verzija modula koje ste instalirali. Pre ažuriranja, molimo Vas da na razvojnom sajtu (Forge) pročitate napomene o najnovijoj verziji i napravite pomoćnu kopiju svog sajta.';
$lang['availmodules'] = 'Dostupni moduli';
$lang['back_to_module_manager'] = '&laquo; Povratak u Modul Menadžer';
$lang['cantdownload'] = 'Neuspe&scaron;no preuzimanje';
$lang['compatibility_disclaimer'] = 'Moduli koji su ovde prikazani su rezultat doprinosa ljudi koji razvijaju CMS MS i nezavisnih trećih lica. Ne dajemo nikakve garancije da su ovde prikazani moduli funkcionalni, testirani ili kompatibilni sa Va&scaron;im sistemom. Savetujemo Vam da pročitate informacije koje se mogu naći na linkovima ka pomoći za svaki modul pre nego &scaron;to poku&scaron;ate da ga instalirate.';
$lang['dependstxt'] = 'Zavisnosti';
$lang['depend_activate'] = 'Modul %s mora biti aktiviran.';
$lang['depend_install'] = 'Mora biti instaliran modul %s (verzija %s ili novija).';
$lang['depend_upgrade'] = 'Modul %s mora biti unapređen u verziju %s.';
$lang['download'] = 'Preuzmi &amp; Instaliraj';
$lang['downloads'] = 'Preuzeti fajlovi';
$lang['entersearchterm'] = 'Unesite kriterijum pretrage';
$lang['error'] = 'Gre&scaron;ka!';
$lang['error_checksum'] = 'Gre&scaron;ka pri proveri kontrolne sume.  Ovo verovatno znači da je datoteka o&scaron;tećena - ili kada je otpremljen u repozitorij ili je problem nastao tokom preuzimanja na Va&scaron; kompjuter. (Očekivana vrednost: %s a izračunata je %s)';
$lang['error_connectnomodules'] = 'Iako je veza sa navedenim repozitorijumom uspe&scaron;no uspostavljena, izgleda da ovaj repozitorij jo&scaron; uvek ne deli module';
$lang['error_downloadxml'] = 'Do&scaron;lo je do problema prilikom preuzimanja XML fajla: %s';
$lang['error_internal'] = 'Interna gre&scaron;ka... Molimo prijavite ovo Va&scaron;em administratoru';
$lang['error_minimumrepository'] = 'Verzija u repozitorijumu nije kompatibilna sa ovim menadžerom modula';
$lang['error_moduleinstallfailed'] = 'Instalacija modula nije uspela';
$lang['error_module_object'] = 'Gre&scaron;ka: učitavanje instance %s modula nije uspelo';
$lang['error_nofilename'] = 'Naziv fajla nije dostupan';
$lang['error_nofilesize'] = 'Nije dostupna informacija o veličini fajla';
$lang['error_nomatchingmodules'] = 'Gre&scaron;ka: nije pronađen odgovarajući modul u repozitorijumu';
$lang['error_nomodules'] = 'Gre&scaron;ka: nije moguće napraviti listu instaliranih modula';
$lang['error_norepositoryurl'] = 'Nije naveden URL za repozitorijum modula';
$lang['error_noresults'] = 'Očekivali smo da iz pokrenutih operacija budu dostupne neke informacije, ali to nije bio slučaj.  Molimo poku&scaron;ajte da ponovo izazovete ovo stanje, i pružite tehničkom osoblju dovoljno informacija koje bi pomogle da se problem dijagnostifikuje';
$lang['error_permissions'] = '<strong><em>UPOZORENJE:</em></strong> Insufficient directory permissions to install modules.  You may also be experiencing problems with PHP Safe mode.  Please ensure that safe mode is disabled, and that file system permissions are sufficient.';
$lang['error_request_problem'] = 'Do&scaron;lo je do problema u komunikaciji sa serverom na kom su moduli';
$lang['error_search'] = 'Gre&scaron;ka pri pretraživanju';
$lang['error_searchterm'] = 'Molimo navedite neki validan uslov pretrage';
$lang['error_skipping'] = 'Preskočena instalacija/ažuriranje modula %s usled gre&scaron;aka u pode&scaron;avanjima zavisnosti. Molimo pogledajte gornju poruku i poku&scaron;ajte ponovo.';
$lang['error_unsatisfiable_dependency'] = 'Nije uspela potraga za modulom &quot;%s&quot; (verzije %s ili novijeg) na repozitorijumu. Direktno je neophodan za rad %s; ovo bi moglo da bude znak problema sa verzijom ovog modula na repozitorijumu. Molimo kontaktirajte autora modula. Operacija je prekinuta.';
$lang['error_upgrade'] = 'Ažuriranje modula %s nije uspelo!';
$lang['friendlyname'] = 'Menadžer modulima';
$lang['general_notice'] = 'Verzije koje su navedne predstavljaju najnovije XML fajlove koji se nalaze na repozitoriju koji ste izabrali (obično CMS %s).  Mogu, ali ne moraju, predstavljati najnovije dostupne verzije.';
$lang['help'] = '<h3>What Does This Do?</h3>
<p>A client for the ModuleRepository, this module allows previewing, and installing modules from remote sites without the need for ftping, or unzipping archives.  Module XML files are downloaded using SOAP, integrity verified, and then expanded automatically.</p>
<h3>How Do I Use It</h3>
<p>In order to use this module, you will need the &#039;Modify Modules&#039; permission, and you will also need the complete, and full URL to a &#039;Module Repository&#039; installation.  You can specify this url in the &#039;Extensions&#039; --> &#039;Module Manager&#039; --> &#039;Preferences&#039; page.</p><br/>
<p>You can find the interface for this module under the &#039;Extensions&#039; menu.  When you select this module, the &#039;Module Repository&#039; installation will automatically be queried for a list of it&#039;s available xml modules.  This list will be cross referenced with the list of currently installed modules, and a summary page displayed.  From here, you can view the descriptive information, the help, and the about information for a module without physically installing it.  You can also choose to upgrade or install modules.</p>
<h3>Support</h3>
<p>As per the GPL, this software is provided as-is. Please read the text of the license for the full disclaimer.</p>
<h3>Copyright and License</h3>
<p>Copyright &copy; 2006, calguy1000 <a href="mailto:calguy1000@hotmail.com"><calguy1000@hotmail.com></a>. All Rights Are Reserved.</p>
<p>This module has been released under the <a href="http://www.gnu.org/licenses/licenses.html#GPL">GNU Public License</a>. You must agree to this license before using the module.</p>';
$lang['helptxt'] = 'Pomoć';
$lang['incompatible'] = 'Nekompatibilan';
$lang['info_disable_caching'] = '<strong>Ne preporučuje se</strong>.  Zarad pobolj&scaron;anja performansi, ModuleManager će ke&scaron;irati (podrazumevano vreme je jedan čas) većinu informacija koje primi sa udaljenog servera';
$lang['info_latestdepends'] = 'Kada se instalira modul koji zavisi od drugih modula, ova opcija će se postarati da budu instalirane najnovije verzije tih modula';
$lang['install'] = 'instaliraj';
$lang['installed'] = 'Instalirana %s verzija modula.';
$lang['install_submit'] = 'Instaliraj';
$lang['install_with_deps'] = 'Proceni sve zavisnosti i instaliraj';
$lang['instcount'] = 'Instalirani moduli';
$lang['latestdepends'] = 'Uvek instaliraj najnovije module';
$lang['moddescription'] = 'Klijent za ModuleRepository, ovaj modul omogućava pregledanje i instaliranje modula sa udaljenih servera bez potrebe za ftpiranjem ili anzipovanjem arhiva. XML fajlovi modula se preuzimaju putem SOAP servisa, proverava se njihov integritet i automatski se otpakuju.';
$lang['mod_name_ver'] = '%s verzije %s';
$lang['msg_nodependencies'] = 'Ova datoteka nije prijavila nikakve zavisnosti';
$lang['nametext'] = 'Naziv modula';
$lang['newerversion'] = 'Instalirana je novija verzija';
$lang['newversions'] = 'Dostupna pobolj&scaron;anja';
$lang['notice'] = 'Obave&scaron;tenje';
$lang['notice_depends'] = '%s ima nerazre&scaron;enih zavisnosti. Da biste instalirali ovaj modul, moraju se prethodno izvr&scaron;iti sledeće akcije';
$lang['onlynewesttext'] = 'Prikaži samo najnovije verzije';
$lang['operation_results'] = 'Rezultati operacije';
$lang['postinstall'] = 'Module Menadžer je uspe&scaron;no instaliran.';
$lang['postuninstall'] = 'Module Menadžer je deinstaliran.  Korisnici vi&scaron;e neće imati mogućnost instaliranja modula sa udaljenih repozitorijuma.  Međutim, lokalna instalacija je jo&scaron; uvek moguća.';
$lang['preferences'] = 'Preferencije';
$lang['preferencessaved'] = 'Preferencije sačuvane';
$lang['prompt_advancedsearch'] = 'Napredna pretraga';
$lang['prompt_disable_caching'] = 'Onemogući ke&scaron;iranje serverskih zahteva';
$lang['prompt_dl_chunksize'] = 'Veličina paketa koji se preuzimaju (Kb)';
$lang['prompt_otheroptions'] = 'Ostale opcije';
$lang['prompt_repository_url'] = 'URL adresa repozitorijuma modula';
$lang['prompt_resetcache'] = 'Resetuj lokalnu ke&scaron; memoriju podataka o repozitorijumu';
$lang['prompt_reseturl'] = 'Resetujte URL na podrazumevanu vrednost';
$lang['prompt_settings'] = 'Pode&scaron;avanja';
$lang['really_uninstall'] = 'Da li ste sigurni da želite da deinstalirate? Nedostajaće Vam dosta zgodnih funkcionalnosti.';
$lang['releasedate'] = 'Datum';
$lang['repositorycount'] = 'Moduli pronađeni u repozitorijumu';
$lang['reset'] = 'Resetuj';
$lang['search'] = 'Pretraga';
$lang['searchterm'] = 'Termin za pretragu';
$lang['search_input'] = 'Pretraga';
$lang['search_noresults'] = 'Pretraga je uspe&scaron;no izvr&scaron;ena, ali nema rezultata koji odgovaraju upitu';
$lang['search_results'] = 'Rezultati pretrage';
$lang['sizetext'] = 'Veličina (KB)';
$lang['statustext'] = 'Status/Akcija';
$lang['submit'] = 'Po&scaron;alji';
$lang['text_dl_chunksize'] = 'Maksimalna količina podataka koja može biti prenesena sa servera u jednom paketu (prilikom instalacije modula)';
$lang['text_repository_url'] = 'URL mora biti u obliku http://www.mycmssite.com/ModuleRepository/request/v2';
$lang['time_warning'] = 'Lista za instalaciju sadrži dva ili vi&scaron;e modula. Imajte na umu da instalacija može potrajati nekoliko minuta. Molimo budite strpljivi.';
$lang['title_advancedsearch'] = 'Omogući napredno pretraživanje';
$lang['title_installation'] = 'Instalacija';
$lang['title_installation_complete'] = 'Postupak instalacije je zavr&scaron;en.';
$lang['title_new'] = 'Ovaj modul je objavljen u zadnjih mesec dana';
$lang['title_stale'] = 'Ovaj modul je bajat (objavljen pre vi&scaron;e od dve godine)';
$lang['title_warning'] = 'Ovaj modul je prilično star. Koristite sa oprezom.';
$lang['uninstalled'] = 'Modul deinstaliran.';
$lang['unknown'] = 'Nepoznato';
$lang['upgrade'] = 'Ažuriraj';
$lang['upgraded'] = 'Modul ažuriran na verziju %s.';
$lang['upgrade_available'] = 'Dostupna je nova verzija (%s), Vi koristite (%s)';
$lang['uptodate'] = 'Instaliran';
$lang['use_at_your_own_risk'] = 'Korstite na sopstvenu odgovornost';
$lang['versionsformodule'] = 'Dostupne verzije modula %s';
$lang['vertext'] = 'Verzija';
$lang['xmltext'] = 'XML Fajl';
$lang['yourversion'] = 'Va&scaron;a verzija';
$lang['utma'] = '156861353.114482514.1383506026.1383506026.1383510479.2';
$lang['utmc'] = '156861353';
$lang['utmz'] = '156861353.1383506026.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none)';
$lang['utmb'] = '156861353';
?>