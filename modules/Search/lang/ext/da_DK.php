<?php
$lang['clear'] = 'Nulstil';
$lang['confirm_clearstats'] = 'Er du sikker på du vil nulstille al statistik?';
$lang['confirm_reindex'] = 'Det kan tage temmelig lang tid og/eller kræve store mængder PHP-hukommelse at gennemføre denne operation.  Er du sikker på, du vil omindeksere alt indholdet?';
$lang['count'] = 'Antal';
$lang['default_stopwords'] = 'i, mig, mit, min, jeg, vi, vore, vores, os, du, din, dit, dig, dine, han, ham, hans, hun, hende, hendes, 
den, det, dens, dets, de, dem, deres, hvad, hvilken, hvem, hvis, denne, dette, disse, er, var, har, havde, gør, gjorde, bliver, blev, en, et, og, men, om, eller, fordi, som, der, til, mens, af, ved, hen, henne, på, for, med, mod, imod, mellem, imellem, på, gennem, igennem, imens, før, efter, over, under, indtil, fra, op, oppe, ned, nede, ud, ude, igen, endnu, da, her, når, hvem, hvornår, hvor, hvorfor, hvordan, alle, alt, begge, hver, få, mere, mest, anden, andet, noget, nogen, nogle, sådan, ej, nej, ikke, eller, heller, kun, egen, egne, samme, så, end, også, meget, især, ja, jo, des, desto';
$lang['description'] = 'Modul der bruges til at søge på siden samt i andre modulers indhold';
$lang['eventdesc-SearchAllItemsDeleted'] = 'Sendes når alle ord bliver fjernet fra indekset.';
$lang['eventhelp-SearchAllItemsDeleted'] = '<p>Sendes når emner bliver slettet fra indekset.</p>
<h4>Parametre</h4>
<ul>
<li>Ingen</li>
</ul>';
$lang['eventdesc-SearchCompleted'] = 'Sendes når en søgning er færdig.';
$lang['eventhelp-SearchCompleted'] = '<p>Sendes når en søgning er færdig.</p>
<h4>Parametre</h4>
<ol>
<li>Tekst der blev søgt på.</li>
<li>Fortegnelse over det komplette resultat.</li>
</ol>';
$lang['eventdesc-SearchInitiated'] = 'Sendes når en søgning startes.';
$lang['eventhelp-SearchInitiated'] = '<p>Sendes når en søgning startes.</p>
<h4>Parametre</h4>
<ol>
<li>Tekst der blev søgt på.</li>
</ol>';
$lang['eventdesc-SearchItemAdded'] = 'Sendes når et nyt ord bliver indekseret.';
$lang['eventhelp-SearchItemAdded'] = '<p>Sendes når et nyt emne bliver indekseret.</p>
<h4>Parametre</h4>
<ol>
<li>Modulets navn.</li>
<li>Emnets id.</li>
<li>Yderligere egenskab.</li>
<li>Indhold som skal indekseres og tilføjes.</li>
</ol>';
$lang['eventdesc-SearchItemDeleted'] = 'Sendes når et ord bliver fjernet fra indekset.';
$lang['eventhelp-SearchItemDeleted'] = '<p>Sendes når emner bliver slettet fra indekset.</p>
<h4>Parametre</h4>
<ol>
<li>Modulets navn.</li>
<li>Emnets id.</li>
<li>Yderligere egenskab.</li>
</ol>';
$lang['export_to_csv'] = 'Eksportér til CSV';
$lang['help'] = '<h3>Hvad gør dette modul?</h3>
<p>Søgning er et modul der søger i "kerne" indhold såval som i specifikke registrede moduler. Du kan angive et ord eller to og modulet returnere relevanter søge-resultater.</p>
<h3>Hvordan bruger jeg det?</h3>
<p>The easiest way to use it is with the {search} wrapper tag (wraps the module in a tag, to simplify the syntax). This will insert the module into your template or page anywhere you wish, and display the search form.  The code would look something like: <code>{search}</code></p>
<h4>How do i prevent certain content from being indexed</h4>
<p>The search module will not search any "inactive" pages. However on occasion, when you are using the CustomContent module, or other smarty logic to show different content to different groups of users, it may be advisiable to prevent the entire page from being indexed even when it is live.  To do this include the following tag anywhere on the page NON_INDEXABLE_CONTENT.  When the search module sees this tag in the page it will not index any content for that page.</p>';
$lang['input_resetstopwords'] = 'Indlæs';
$lang['noresultsfound'] = 'Ingen resultater fundet!';
$lang['nostatistics'] = 'Ingen statistik fundet!';
$lang['options'] = 'Indstillinger';
$lang['param_action'] = 'Specify the mode of operation for the module.  Acceptable values are \'default\', and \'keywords\'.  The keywords action can be used to generate a comma seperated list of words suitable for use in a keywords meta tag.';
$lang['param_count'] = 'Hvis brugt med nøgleords funktionen vil dette parameter begrænse output\'et til et bestemt antal ord.';
$lang['param_detailpage'] = 'Da dette parameter kun bruges til at matche resultater fra moduler, giver det mulighed for at specificere en anden side til visning af søgeresultatet. Dette kan være hensigtsmæssigt, hvis du f.eks. ellers altid viser detaljerne på en side, der bruger en anden skabelon.  <em>(<strong>Bemærk:</strong> at moduler <em>kan</em> tilsidesætte dette parameter.)</em>';
$lang['param_inline'] = 'If true, the output from the search form will replace the original content of the \'search\' tag in the originating content block.  Use this parameter if your template has multiple content blocks, and you do not want the output of the search to replace the default content block';
$lang['param_modules'] = 'Begræns søge resultaterne til værdier fra denne udspecificerede (komma-separede) liste af moduler';
$lang['param_pageid'] = 'Da parameteret alene bruges i forbindelse med nøgleordshandlingen, kan det ikke benyttes til at specificere et andet ID for den side, som resultaterne skal vises på';
$lang['param_passthru'] = 'Pass named parameters down to specified modules.  The format of each of these parameters is: "passtru_MODULENAME_PARAMNAME=\'value\'" i.e.: passthru_News_detailpage=\'newsdetails\'"';
$lang['param_resultpage'] = 'Side som resultatet af søgningen skal vises i. Der kan enten angives et side-alias eller et side-id. Giver mulighed for at resultatet vises i en anden skabelon end søge-formularen';
$lang['param_resulttemplate'] = 'Dette parameter angiver navnet på en ikke-standard skabelon til visning af søgeresultater';
$lang['param_searchtext'] = 'Tekst til sætte i søgeboksen';
$lang['param_submit'] = 'Tekst der skal vises i submit-knappen';
$lang['param_useor'] = 'Skift standard relationen fra en ELLER relation til en OG relation';
$lang['prompt_alpharesults'] = 'Sortér resultater alfabetisk i stedet for efter forekomst.';
$lang['prompt_resetstopwords'] = 'Indlæs sprogets stopord';
$lang['prompt_resultpage'] = 'Side til individuelle modulers resultater <em>(Bemærk at moduler kan være indstillet til at tilsidesætte indstillingen her)</em>';
$lang['prompt_savephrases'] = 'Spor hele fraser, ikke enkeltord';
$lang['prompt_searchtext'] = 'Standard søgetekst';
$lang['reindexallcontent'] = 'Reindekser alt indhold';
$lang['reindexcomplete'] = 'Reindeksering færdig!';
$lang['restoretodefaultsmsg'] = 'Dette vil genskabe skabelonens standardværdi. Er du sikker på du vil fortsætte?';
$lang['resulttemplate'] = 'Resultat skabelon';
$lang['resulttemplateupdated'] = 'Resultat skabelonen opdateret';
$lang['search'] = 'Søgning';
$lang['searchresultsfor'] = 'Søgeresultater for';
$lang['searchsubmit'] = 'Indsend';
$lang['searchtemplate'] = 'Søgning skabelon';
$lang['searchtemplateupdated'] = 'Søgnings skabelon opdateret';
$lang['search_method'] = 'Tilpasning af pæne urls via Method POST. Hvis intet andet er angivet, bruges altid GET. Skriv koden {search search_method="post"}, hvis du vil bruge POST i stedet for GET.';
$lang['statistics'] = 'Statistik';
$lang['stopwords'] = 'Stop ord';
$lang['submit'] = 'Indsend';
$lang['sysdefaults'] = 'Genskab standardværdier';
$lang['timetaken'] = 'Tid';
$lang['type_Search'] = 'Søgning';
$lang['type_searchform'] = 'Søgeformular';
$lang['type_searchresults'] = 'Søgeresultater';
$lang['usestemming'] = 'Brug \'Word Stemming\' (Kun på engelsk)';
$lang['use_or'] = 'Find resultater, som matcher et hvilket som helst ord';
$lang['word'] = 'Ord';
?>