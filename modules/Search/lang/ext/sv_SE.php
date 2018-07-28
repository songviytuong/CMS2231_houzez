<?php
$lang['clear'] = 'Rensa';
$lang['confirm_clearstats'] = 'Är du säker på att du vill rensa all statistik permanent?';
$lang['confirm_reindex'] = 'Denna operation kan ta en längre tid, och / eller kräva en omfattande PHP minne. Är du säker på att du vill indexera allt innehåll?';
$lang['count'] = 'Antal';
$lang['default_stopwords'] = 'i, me, my, myself, we, our, ours, ourselves, you, your, yours, 
yourself, yourselves, he, him, his, himself, she, her, hers, 
herself, it, its, itself, they, them, their, theirs, themselves, 
what, which, who, whom, this, that, these, those, am, is, are, 
was, were, be, been, being, have, has, had, having, do, does, 
did, doing, a, an, the, and, but, if, or, because, as, until, 
while, of, at, by, for, with, about, against, between, into, 
through, during, before, after, above, below, to, from, up, down, 
in, out, on, off, over, under, again, further, then, once, here, 
there, when, where, why, how, all, any, both, each, few, more, 
most, other, some, such, no, nor, not, only, own, same, so, 
than, too, very';
$lang['description'] = 'Modul för att söka en webbplats och andra modulers innehåll';
$lang['eventdesc-SearchAllItemsDeleted'] = 'Skickas när alla poster tas bort från indexet.';
$lang['eventhelp-SearchAllItemsDeleted'] = '<p>Skickas när en sökning påbörjas.</p>
<h4>Parametrar</h4>
<ul>
<li>Inga</li>
</ul>';
$lang['eventdesc-SearchCompleted'] = 'Skickas när en sökning är avslutad.';
$lang['eventhelp-SearchCompleted'] = '<p>Skickas när en sökning är avslutad.</p>
<h4>Parametrar</h4>
<ol>
<li>Text som söktes efter.</li>
<li>Array med de färdiga resultaten av sökningen.</li>
</ol>';
$lang['eventdesc-SearchInitiated'] = 'Skickas när en sökning påbörjas.';
$lang['eventhelp-SearchInitiated'] = '<p>Skickas när en sökning påbörjas.</p>
<h4>Parametrar</h4>
<ol>
<li>Text som söktes efter.</li>
</ol>';
$lang['eventdesc-SearchItemAdded'] = 'Skickas när en ny post indexeras.';
$lang['eventhelp-SearchItemAdded'] = '<p>Skickas när en ny post indexeras.</p>
<h4>Parametrar</h4>
<ol>
<li>Modulnamn.</li>
<li>Pstens ID.</li>
<li>Övriga attribut.</li>
<li>Innehåll att indexera och lägga till.</li>
</ol>';
$lang['eventdesc-SearchItemDeleted'] = 'Skickas när en ny post tas bort från indexet.';
$lang['eventhelp-SearchItemDeleted'] = '<p>Skickas när en ny post tas bort från indexet.</p>
<h4>Parametrar</h4>
<ol>
<li>Modulnamn.</li>
<li>Postens ID.</li>
<li>Övriga attribut.</li>
</ol>';
$lang['export_to_csv'] = 'Exportera till CSV';
$lang['help'] = '<h3>Vad gör den här modulen?</h3>
<p>Sök är en modul för att söka innehåll på sidor, samt vissa registrerade moduler. Du skriver in ett ord eller två och du får upp matchande, relevanta resultat.</p>
<h3>Hur använder jag den?</h3>
<p>Det enklaste sättet att använda modulen är med "omslagstaggen" {search} (omger modulen i en tagg, för att göra syntaxet enklare). Denna tagg lägger till din modul i mallen eller på sidan, där du vill, och visar sökformuläret. Koden kan t.ex. se ut så här: <code>{search}</code></p>
<h4>Hur förhindrar jag visst innehåll från att indexeras?</h4>
<p>Sökmodulen söker inte några "inaktiva" sidor. Men ibland, om du använder modulen CustomContent, eller annan smarty-logik för att visa olika innehåll för olika grupper av användare, rekommenderas att förhindra hela sidan från att indexeras även när den är aktiv. För att göra detta, lägg till följande tagg var som helst på sidan: <em><!-- pageAttribute: NotSearchable --></em>. När sökmodulen ser den taggen på sidan kommer den inte att indexera något innehåll för den sidan.</p>
<p>Taggen <em><!-- pageAttribute: NotSearchable --></em> kan även användas i mallen. I så fall kommer inga sidor som använder den mallen att indexeras. De sidorna omindexeras om taggen tas bort.</p>';
$lang['input_resetstopwords'] = 'Starta';
$lang['noresultsfound'] = 'Inga resultat funna!';
$lang['nostatistics'] = 'Ingen statistik hittas!';
$lang['options'] = 'Inställningar';
$lang['param_action'] = 'Ange vilket sätt som modulen ska användas på. Accepterade värden är \'default\' (standard) och \'keywords\' (nyckelord). Nyckelord kan användas för att generera en kommaseparerad lista med ord som är användbara som nyckelord i metataggar.';
$lang['param_count'] = 'Denna parameter används tillsammans med nyckelord (keywords) för att begränsa resultatet till det angivna antalet ord.';
$lang['param_detailpage'] = 'Används endast för matchande resultat från moduler, den här parametern låter specificera en annan detaljsida för resultaten. Det här är användbart om, exempelvis, du alltid har dina detaljvisningar på en sida med en avvikande mall. <em>(<strong>Notera:</strong> moduler har möjligheten att åsidosätta den här parametern.)</em>';
$lang['param_formtemplate'] = 'Används endast för standardåtgärden,denna parameter speciferar namnet på en icke standardmall.';
$lang['param_inline'] = 'Om sant kommer utdatat från sökformuläret ersätta det ursprungliga innehållet från \'search\'-taggen i det ursprungliga innehållsblocket. Använd den här parametern om din mall har flera innehållsblock, och om du inte vill att utdatat från sökningen ska ersätta det förvalda innehållsblocket';
$lang['param_modules'] = 'Begränsa sökresultatet till värden som indexerats i den specificerade modullistan (kommaseparerad).';
$lang['param_pageid'] = 'Denna parameter används endast tillsammans med nyckelord (keywords) för att ange ett annat sid-ID att returnera resultaten för.';
$lang['param_passthru'] = 'Skicka namnsatta parametrar till specifika moduler. Formatat på respektive parameter är : "passtru_MODULENAME_PARAMNAME=\'value\'". Exempel: passthru_News_detailpage=\'newsdetails\'"';
$lang['param_resultpage'] = 'Sida att visa sökresultaten på. Detta kan antingen vara ett sidalias eller ett id. Används för att sökresultaten ska visas med en annan mall än den där sökformuläret finns.';
$lang['param_resulttemplate'] = 'Med denna parameter kan man ange namnet på en icke standardmall som ska användas för att visa sökresultat.';
$lang['param_searchtext'] = 'Text inne i sökfältet';
$lang['param_submit'] = 'Text för skicka-knappen';
$lang['param_useor'] = 'Ändra standardrelation från en OR relation till en AND relation';
$lang['prompt_alpharesults'] = 'Sortera resultatet alfabetiskt istället för storlek';
$lang['prompt_resetstopwords'] = 'Starta standard orden';
$lang['prompt_resultpage'] = 'Sida för individuella modulresultat <em>(Notera att moduler frivilligt kan åsidosätta detta)</em>';
$lang['prompt_savephrases'] = 'Spåra Sök fraser, inte individuella ord';
$lang['prompt_searchtext'] = 'Standardsöktext';
$lang['reindexallcontent'] = 'Omindexera allt innehåll';
$lang['reindexcomplete'] = 'Omindexering utförd!';
$lang['restoretodefaultsmsg'] = 'Denna åtgärd kommer att återställa mallinnehållet till standardinställningarna. Är du säker på att du vill fortsätta?';
$lang['resulttemplate'] = 'Resultatmall';
$lang['resulttemplateupdated'] = 'Resultatmall uppdaterad';
$lang['search'] = 'Sök';
$lang['searchresultsfor'] = 'Sök resultat efter';
$lang['searchsubmit'] = 'Skicka';
$lang['searchtemplate'] = 'Sökmall';
$lang['searchtemplateupdated'] = 'Sökmall uppdaterad';
$lang['search_method'] = 'Pretty Urls kompabilitet via POST metoden, grundinställningen är alltid GET, för att få detta att fungera använd bara {search search_method="post"}';
$lang['statistics'] = 'Statistik';
$lang['stopwords'] = 'Stoppord (som inte kommer med i sökningen)';
$lang['submit'] = 'Skicka';
$lang['sysdefaults'] = 'Återställ standardinställningar';
$lang['timetaken'] = 'Tid för sökning';
$lang['type_Search'] = 'Sök';
$lang['type_searchform'] = 'Sökformulär';
$lang['type_searchresults'] = 'Sökresultat';
$lang['usestemming'] = 'Ta bort ordändelser (enbart engelska)';
$lang['use_or'] = 'Visa resultat som matchar något ord';
$lang['word'] = 'Ord';
?>