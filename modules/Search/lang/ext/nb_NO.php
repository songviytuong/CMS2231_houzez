<?php
$lang['clear'] = 'Tøm';
$lang['confirm_clearstats'] = 'Er du sikker på at du permanent vil tømme statistikken?';
$lang['confirm_reindex'] = 'Denne operasjonen kan ta litt tid, og/eller kreve en omfattende mengde PHP minne. Er du sikker på at du ønsker å re-indeksere alt innhold?';
$lang['count'] = 'Antall';
$lang['default_stopwords'] = 'jeg, meg, min, megselv, oss, vår, våre, selv, deg, din, dine, degselv, dereselv, han, hans, hanselv, hun, henne, hennes, henneselv, det, dets, detselv, de, dem, dere, deres, demselv, hva, hvilken, hvem, dette, det, disse, er, var, er, bli, blir, blitt, har, hadde, hatt, gjør, gjorde, gjøre, en, og, men, om, eller, fordi, som, til, mens, av, på, av, for, med, om, mot, mellom, i, gjennom, mens, får, etter, over, under, til, fra, opp, ned, inne, ute, på, av, over, under, igjen, videre, da, engang, her, der, når, hvor, hvorfor, hvordan, alle, ingen, begge, hver, få, flere, meste, andre, noen, slik, nei, eller, ikke, bare, egen, samme, så, enn, også, veldig';
$lang['description'] = 'Modul for søk på nettstedet og enkelte modulers innhold.';
$lang['eventdesc-SearchAllItemsDeleted'] = 'Sendt når alle artikler er slettet fra indeksen.';
$lang['eventhelp-SearchAllItemsDeleted'] = '<p>Sendt når et søk startes.</p>
<h4>Parametere</h4>
<ul>
<li>Ingen</li>
</ul>';
$lang['eventdesc-SearchCompleted'] = 'Sendt når et søk er ferdig.';
$lang['eventhelp-SearchCompleted'] = '<p>Sendt når et søk er ferdig.</p>
<h4>Parametere</h4>
<ol>
<li>Tekst det ble søkt etter.</li>
<li>Listing av det ferdige resultatet.</li>
</ol>';
$lang['eventdesc-SearchInitiated'] = 'Sendt når et søk startes.';
$lang['eventhelp-SearchInitiated'] = '<p>Sendt når et søk startes.</p>
<h4>Parametere</h4>
<ol>
<li>Tekst det ble søkt etter.</li>
</ol>';
$lang['eventdesc-SearchItemAdded'] = 'Sendt når en ny artikkel er indeksert.';
$lang['eventhelp-SearchItemAdded'] = '<p>Sendt når en ny artikkel er indeksert.</p>
<h4>Parametere</h4>
<ol>
<li>Modul navn.</li>
<li>ID for artikkelen.</li>
<li>Tilleggsattributt.</li>
<li>Innhold til indeks og tillegg.</li>
</ol>';
$lang['eventdesc-SearchItemDeleted'] = 'Sendt når en artikkel ble slettet fra indeksen.';
$lang['eventhelp-SearchItemDeleted'] = '<p>Sendt når en artikkel ble slettet fra indeksen.</p>
<h4>Parametere</h4>
<ol>
<li>Modul navn.</li>
<li>ID for artikkelen.</li>
<li>Tilleggsattributt.</li>
</ol>';
$lang['export_to_csv'] = 'Eksporter til CSV';
$lang['help'] = '<h3>Hva gjør denne?</h3>
	<p>Søk er en modul for å søke i \'core\' innhold og bestemte registrerte moduler.  Du skriver inn et ord eller to og den gir deg passende, relevante resultater.</p>
	<h3>Hvordan bruker jeg den?</h3>
<p>Den enkleste måten er å bruke den med {search} innpaknings-taggen (pakker modulen i en tagg, for å forenkle syntaksen). Dette vil sette modulen inn i din mal eller side hvor du ønsker, og vise søke skjemaet.  Koden vil se ut som dette: <code>{search}</code></p>
<h4>Hvordan unngår jeg at noe innhold blir indeksert</h4>
<p>Søk modulen vill ikke søke i inaktive sider. Men i tilfelle, når du f.eks. benytter CustomContent modulen, eller andre smarty logikker for å vise forskjellig innhold til ulike grupper med brukere, kan det vare anbefalt å hindre hele siden fra å bli indeksert selv om den er live.  For å gjøre dette  - inkluder følgende tagg hvor som helst på siden <em><!-- pageAttribute: NotSearchable --> (< = tegnet mindre enn, > = tegnet større enn) </em> Når søkemodulen ser denne taggen på siden vil den ikke indeksere noe innhold fra den siden.</p>
<p>Taggen <em><!-- pageAttribute: NotSearchable --></em> kan også plasseres i malen.  Om dette gjøres vil ingen av sidene som er tilknyttet denne malen bli indeksert.  Disse sidene vil bli reindeksert om taggen fjernes.</p>';
$lang['input_resetstopwords'] = 'Last';
$lang['noresultsfound'] = 'Ingen treff!';
$lang['nostatistics'] = 'Ingen statistikk funnet!';
$lang['options'] = 'Valg';
$lang['param_action'] = 'Spesifiser modusen for bruk av modulen. Gyldige verdier er \'default\', og \'keywords\'. Keywords handling kan benyttes for å generere en kommaseparert liste med ord egnet til bruk i en keywords metatagg.';
$lang['param_count'] = 'Benyttet med keywords handlingen vil denne parameteren begrense utdata til et visst antall ord';
$lang['param_detailpage'] = 'Kun benyttet for tilsvarende resultater fra modulene, denne parameter tillater å spesifisere en annen detaljside for resultatene. Dette er nyttig om, du f eks. alltid viser detaljvisning på en side med en annen mal. <em>(<strong>Merk:</strong> moduler har mulighet til å overstyre denne parameteren.)</em>';
$lang['param_formtemplate'] = 'Brukes kun for standardhandlingen, denne parameteren kan spesifisere navnet på en ikke standardmal.';
$lang['param_inline'] = 'Om satt til sann, vil resultatet fra søkeskjemaet erstatte det originale innholdet av \'søk\'-taggen i den opprinnelige innholdblokken. Benytt denne parameteren om din mal har flere innholdblokker og du ikke vil at resultatet skal erstatte standard innholdsblokk.';
$lang['param_modules'] = 'Begrens søkeresultater til verdier indeksert fra den spesifiserte (komma separerte) listen med moduler';
$lang['param_pageid'] = 'Denne parameter kan benyttes til å spesifisere en annen pageid å returnere resultatene til';
$lang['param_passthru'] = 'Send bestemte parametere ned til spesifiserte moduler. Formatet for hver av disse parameterne er: "passtru_MODULENAME_PARAMNAME=\'value\'" f.eks.: passthru_News_detailpage=\'newsdetails\'"';
$lang['param_resultpage'] = 'Side å vise søkeresultater på.  Dette kan enten være en side-alias eller en id.  Brukes for å tillate søkeresultater å bli vist med en annen mal enn søke skjemaet';
$lang['param_resulttemplate'] = 'Denne parameteren kan angi navnet på en ikke standard mal som skal brukes for å vise søkeresultatene.';
$lang['param_searchtext'] = 'Tekst å plassere i søke-boksen';
$lang['param_submit'] = 'Tekst å plassere på Utfør-knappen';
$lang['param_useor'] = 'Endre standard sammenheng fra en OR forhold til et AND forhold';
$lang['prompt_alpharesults'] = 'Sorter resultater alfabetisk i stedet for etter relevans';
$lang['prompt_resetstopwords'] = 'Last standard stopp-ord fra språk';
$lang['prompt_resultpage'] = 'Side for individuelle modulresultater <em>(Merk moduler kan muligens overstyre dette)</em>';
$lang['prompt_savephrases'] = 'Spor søkefraser, ikke enkle søkeord';
$lang['prompt_searchtext'] = 'Standard søketekst';
$lang['reindexallcontent'] = 'Reindekser alt innhold';
$lang['reindexcomplete'] = 'Reindeksering ferdig!';
$lang['restoretodefaultsmsg'] = 'Denne handlingen vil gjenopprette malens innhold til dens system standard. Er du sikker på at du vil fortsette?';
$lang['resulttemplate'] = 'Resultat mal';
$lang['resulttemplateupdated'] = 'Resultat mal oppdatert';
$lang['search'] = 'Søk';
$lang['searchresultsfor'] = 'Søkeresultat for';
$lang['searchsubmit'] = 'Utfør';
$lang['searchtemplate'] = 'Søk mal';
$lang['searchtemplateupdated'] = 'Søk mal oppdatert';
$lang['search_method'] = 'Vakre url\'er støtte via Method POST, standard verdi er alltid GET. For å få dette til å fungere kaller du søk opp slik {search search_method="post"}';
$lang['statistics'] = 'Statistikk';
$lang['stopwords'] = 'Stopp ord';
$lang['submit'] = 'Lagre';
$lang['sysdefaults'] = 'Gjenopprett til Standard';
$lang['timetaken'] = 'Søket brukte';
$lang['type_Search'] = 'Søk';
$lang['type_searchform'] = 'Søkeskjema';
$lang['type_searchresults'] = 'Søkeresultat';
$lang['usestemming'] = 'Bruk ordstammer (kun Engelsk)';
$lang['use_or'] = 'Finn resultater som passer ALLE ordene (ANY)';
$lang['word'] = 'Ord';
?>