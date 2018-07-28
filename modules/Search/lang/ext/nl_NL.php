<?php
$lang['clear'] = 'Opschonen';
$lang['confirm_clearstats'] = 'Weet je zeker dat je alle statistieken definitief wilt verwijderen?';
$lang['confirm_reindex'] = 'Deze procedure kost veel tijd en gebruikt een groot deel van het PHP geheugen van de webserver. Weet u zeker dat u deze bewerking wilt uitvoeren?';
$lang['count'] = 'Telling';
$lang['default_stopwords'] = 'aan, achter, af, afd, al, alle, alles, als, altijd, andere, behalve, ben, bent, bij, daar, daardoor, daarom, dan, dat, de, den, der, derhalve, des, deze, die, dit, dl, doch, doen, door, dr, dus, echter, ed, een, eens, elk, elke, en, enige, enkele, enz, er, etc, ge, geen, geweest, haar, had, hadden, heb, hebben, hebt, heeft, hem, hen, het, hier, hierin, hij, hoe, hun, ieder, iedere, iemand, iets, ik, in, inzake, is, ja, je, jij, jouw, jullie, kan, kon, kunnen, maak, maakt, maar, maken, me, meer, men, met, mij, mijn, mits, moest, moet, moeten, na, naar, nee, niemand, niet, niets, no, noch, nog, nu, of, om, omdat, onder, ons, onze, ook, op, over, overige, prof, publ, reeds, sinds, sl, st, te, tegen, ten, ter, toch, toen, tot, totdat, tussen, u, uit, uitg, uw, vakgr, van, vanaf, veel, verder, vert, vol, voor, voorts, waar, waarom, wanneer, want, waren, was, wat, we, wederom, weer, wel, welk, welke, werd, werden, wezen, wie, wij, wil, word, worden, wordt, zal, ze, zei, zelf, zich, zij, zijn, zo, zoals, zonder, zou, zouden, zullen';
$lang['description'] = 'Module voor het zoeken in de inhoud van de site en in de inhoud van andere modules.';
$lang['eventdesc-SearchAllItemsDeleted'] = 'Een tag die wordt aangeroepen als alle items zijn verwijderd uit de index.';
$lang['eventhelp-SearchAllItemsDeleted'] = '<h4>Parameters</h4>
<ul>
<li>Geen</li>
</ul>';
$lang['eventdesc-SearchCompleted'] = 'Een tag die wordt aangeroepen als een zoekopdracht is afgerond.';
$lang['eventhelp-SearchCompleted'] = '<h4>Parameters</h4>
<ol>
<li>Tekst waarop is gezocht.</li>
<li>Lijst met afgeronde resultaten.</li>
</ol>';
$lang['eventdesc-SearchInitiated'] = 'Een tag die wordt aangeroepen als een zoekopdracht is gestart.';
$lang['eventhelp-SearchInitiated'] = '<h4>Parameters</h4>
<ol>
<li>Tekst waarop is gezocht.</li>
</ol>';
$lang['eventdesc-SearchItemAdded'] = 'Een tag die wordt aangeroepen als een nieuw item is geïndexeerd.';
$lang['eventhelp-SearchItemAdded'] = '<h4>Parameters</h4>
<ol>
<li>Module naam.</li>
<li>Id van het item.</li>
<li>Additionele attributen.</li>
<li>Inhoud om te indexeren en toe te voegen.</li>
</ol>';
$lang['eventdesc-SearchItemDeleted'] = 'Een tag die wordt aangeroepen als een item is verwijderd uit de index.';
$lang['eventhelp-SearchItemDeleted'] = '<h4>Parameters</h4>
<ol>
<li>Modulenaam.</li>
<li>Id van het item.</li>
<li>Additionele attributen.</li>
</ol>';
$lang['export_to_csv'] = 'Exporteer naar CSV';
$lang['help'] = '<h3>Wat doet het?</h3>
<p>Search is een module om de "core" inhoud te doorzoeken samen met enkele geregistreerde modulen. U geeft één of twee woorden op en krijgt passende en relevante resultaten terug.</p>
<h3>Hoe gebruikt u het?</h3>
<p>De makkelijkste manier om het te gebruiken is de {search} tag in een sjabloon of pagina te plaatsen, waarna het zoekformulier wordt getoond. De code kan eruit zien als: <code>{search}</code></p>
<h4>Hoe voorkomt u dat bepaalde inhoud geïndexeerd wordt?</h4>
<p>De zoekmodule zal geen "inactieve" pagina\'s doorzoeken. Echter, als u gebruik maakt van de CustomContent module of van een andere smarty logica om bepaalde inhoud aan bepaalde gebruikersgroepen te tonen, of dit juiste te blokkeren, dan kan het de voorkeur hebben om te voorkomen dat volledige pagina\'s geïndexeerd worden. Om dit te bereiken kunt u de volgende tag willekeurig op de pagina plaatsen: <code><! -- pageAttribute: NotSearchable -- ></code> (let op: deze string moet letterlijk overgenomen worden, inclusief de drie losse spaties). Als de zoekmodule deze tag op een pagina tegenkomt zal het de inhoud niet indexeren.</p>
<p>De <code><! -- pageAttribute: NotSearchable -- ></code> tag kan ook in een sjabloon worden geplaatst.  In dit geval zullen geen van de pagina\'s die met deze sjabloon gekoppeld zijn worden geïndexeerd.  Deze pagina\'s worden opnieuw geïndexeerd als de tag verwijderd is.</p>';
$lang['input_resetstopwords'] = 'Laden';
$lang['noresultsfound'] = 'Geen resultaten gevonden!';
$lang['nostatistics'] = 'Geen statistieken gevonden!';
$lang['options'] = 'Opties';
$lang['param_action'] = 'Specificeer de werkingsmodus voor de module. Correcte waarden zijn \'default\' en \'keywords\'. De keyword-waarde kan gebruikt worden om een kommagescheiden lijst van woorden te genereren, geschikt voor het gebruik in een keywords meta tag.';
$lang['param_count'] = 'Gebruikt in combinatie met de keywords-waarde, beperkt deze parameter de uitvoer tot het opgegeven aantal woorden.';
$lang['param_detailpage'] = 'Alleen gebruikt voor gevonden resultaten van modules, met deze parameter kunt u een andere detail pagina benoemen voor deze zoekresultaten. Deze toepassing is nuttig bij bijvoorbeeld het tonen van de resultaten in een pagina met een ander sjabloon.  <em>(<strong>Opm.:</strong> Modules kunnen deze parameter mogelijk negeren.)</em>';
$lang['param_inline'] = 'Als waar, dan zal de uitvoer van het zoekformulier de oorspronkelijke inhoud van de \'search\' tag in het verwijzende \'HTML Blok\' vervangen. Gebruik deze parameter als uw sjabloon meerdere \'HTML Blokken\' heeft en u niet wilt dat de uitvoer van de zoekactie het standaard \'HTML Blok\' vervangt.';
$lang['param_modules'] = 'Beperk de zoekresultaten tot waarden die geïndexeerd zijn uit de opgegeven (komma-gescheiden) lijst van modules.';
$lang['param_pageid'] = 'Samen met de keyword-waarde, kan deze parameter gebruikt worden om een andere pagina-id op te geven voor het tonen van de resultaten';
$lang['param_passthru'] = 'Geef de benoemde parameters door aan de gespecificeerde modules. Het formaat van elke parameter is: passthru_MODULENAME_PARAMNAME=\'value\' bijvoorbeeld passthru_news_detailpage=\'newsdetails\'';
$lang['param_resultpage'] = 'Pagina om de resultaten in te tonen. Dit kan een pagina alias of id zijn. Wordt gebruikt om de resultaten in een ander sjabloon te tonen dan het zoekformulier.';
$lang['param_searchtext'] = 'Tekst die in het zoekveld staat';
$lang['param_submit'] = 'Tekst die in de verstuurknop komt';
$lang['prompt_alpharesults'] = 'Sorteer resultaten alfabetisch in plaats van \'gewicht\'';
$lang['prompt_resetstopwords'] = 'Laadt een lijst met Nederlandstalige stop woorden';
$lang['prompt_resultpage'] = 'Pagina voor individuele module resultaten <em>(Opm. modules kunnen dit mogelijk negeren)</em>';
$lang['prompt_savephrases'] = 'Track Zoek Termen, geen Individuele Woorden';
$lang['prompt_searchtext'] = 'Standaard zoektekst';
$lang['reindexallcontent'] = 'Herindexeer alle inhoud';
$lang['reindexcomplete'] = 'Herindexeren gereed!';
$lang['restoretodefaultsmsg'] = 'Deze optie herstelt de sjabloon inhoud naar de standaardwaarden. Weet je zeker dat je wilt doorgaan?';
$lang['resulttemplate'] = 'Resultaatsjabloon';
$lang['resulttemplateupdated'] = 'Resultaatsjabloon bijgewerkt';
$lang['search'] = 'Zoeken - Frontend';
$lang['searchresultsfor'] = 'Zoekresultaten voor';
$lang['searchsubmit'] = 'Versturen';
$lang['searchtemplate'] = 'Zoeksjabloon';
$lang['searchtemplateupdated'] = 'Zoeksjabloon bijgewerkt';
$lang['search_method'] = 'Pretty URLs Compatibiliteit via de POST methode, standaard waarde is GET. Om dit te laten functioneren moet u {search search_method=\'post\'} in het sjabloon plaatsen.';
$lang['statistics'] = 'Statistieken';
$lang['stopwords'] = 'Stop woorden';
$lang['submit'] = 'Versturen';
$lang['sysdefaults'] = 'Herstel standaardwaarden';
$lang['timetaken'] = 'Benodigde zoektijd';
$lang['type_Search'] = 'Zoeken';
$lang['type_searchform'] = 'Zoek formulier';
$lang['type_searchresults'] = 'Zoek resultaten';
$lang['usestemming'] = 'Gebruik de stam van het woord (alleen Engels)';
$lang['use_or'] = 'Toon resultaten die voldoen aan tenminste één woord';
$lang['word'] = 'Woord';
?>