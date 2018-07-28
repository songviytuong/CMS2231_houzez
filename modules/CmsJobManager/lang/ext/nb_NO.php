<?php
$lang['created'] = 'Laget';
$lang['errors'] = 'Feilmeldinger';
$lang['evtdesc_CmsJobManager::OnJobFailed'] = 'Sendt etter at en jobb er fjernet fra jobbkøen etter at den har feilet for mange ganger';
$lang['evthelp_CmsJobManager::OnJobFailed'] = '<h4>Parametere:</h4>
<ul>
  <li>"job" - En referanse til \\CMSMS\\Async\\Job Jobbobjekt som har mislyktes</li>
</ul';
$lang['frequency'] = 'Frekvens';
$lang['friendlyname'] = 'Bakgrunn Jobb Manager';
$lang['info_background_jobs'] = 'Dette panelet viser informasjon om alle tidligere kjente bakgrunns jobber. Det er normalt at jobber vises og forsvinner ofte på denne listen. Hvis en jobb har en høy feil telling ELLER aldri startet, kan det bety at du må undersøke årsakene til feilen.';
$lang['info_no_jobs'] = 'Dette panelet viser informasjon om alle tidligere kjente bakgrunnsjobber. Det er normalt at jobber vises og forsvinner ofte på denne listen. Hvis en jobb har en høy feiltelling ELLER aldri startet, kan det bety at du må undersøke årsakene til feilen.';
$lang['jobs'] = 'Jobber';
$lang['moddescription'] = 'En modul for å håndtere asynkrone behandlings jobber.';
$lang['module'] = 'Modul';
$lang['name'] = 'Navn';
$lang['processing_freq'] = 'Maksimal behandlingsfrekvens (sekunder)';
$lang['recur_120m'] = 'Hver 2 timer';
$lang['recur_15m'] = 'Hvert 15 minutt';
$lang['recur_180m'] = 'Hver 3 timer';
$lang['recur_30m'] = 'Hvert 30 minutt';
$lang['recur_daily'] = 'Daglig';
$lang['recur_hourly'] = 'Hver time';
$lang['recur_monthly'] = 'Hver måned';
$lang['recur_weekly'] = 'Hver uke';
$lang['settings'] = 'Innstillinger';
$lang['start'] = 'Start';
$lang['until'] = 'Inntil';
$lang['help'] = '<h3>Hva gjør denne?</h3>
<p>Dette er en CMSMS-kjernemodul som gir funksjonalitet for å behandle jobber asynkront (i bakgrunnen) da nettstedet svarer på håndteringsforespørsler.</p>
<p>CMSMS og tredjepartsmoduler kan skape jobber for å utføre oppgaver som ikke trenger direkte brukerintervensjon, eller som kan ta litt tid å behandle. Denne modulen gir behandlingskapasiteten for disse jobbene.</p>
<h3>Hvordan bruker jeg det?</h3>
<p>Denne modulen har ingen interaksjon av seg selv. Det gir en enkel jobbrapport som viser jobber som lederen for tiden har i den køen. Jobber kan regelmessig komme seg til, og ut av denne køen som fornyer siden fra tid til annen, kan gi deg en indikasjon på hva som skjer i bakgrunnen for nettstedet ditt.</p>
<p>Denne modulen behandler bare jobber maksimalt hvert minutt, og minst hvert tiende minutt. Selv om standardinnstillingen er 3 minutter. Denne sjeldne behandlingen er å sikre rimelig ytelse på de fleste nettsteder.</p>
<p>Du kan justere frekvensen ved å legge til en cmsjobmgr_asyncfreq Variabel inn i config.php-filen for nettstedet ditt som inneholder et heltall mellom 0 og 10.</p>
<pre>dvs: <code>$config["cmsjobmgr_asyncfreq"] = 5;</code>.</pre>
<p><strong>Merk:</strong> Det er ikke mulig å deaktivere asynkron behandling helt. Dette skyldes at en viss funksjon av CMSMS-kjernen er avhengig av denne funksjonaliteten.</p>

<h3>Hva med problemjobber.</h3>
<p>Noen ganger kan enkelte programmer skape jobber som mislykkes, og avslutter med en eller annen feil. CmsJobManager vil fjerne jobben etter at jobben har feilet flere ganger. På hvilken tid kan opprinnelseskoden gjenskape jobben. Hvis du støter på en problematisk jobb som fortsetter å mislykkes, er dette en feil som skal diagnostiseres, og rapporteres i detalj til de aktuelle utviklerne.</p>';
?>