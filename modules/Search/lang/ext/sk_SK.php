<?php
$lang['clear'] = 'Vyčistiť';
$lang['confirm_clearstats'] = 'Naozaj chcete natrvalo vyčistiť všetky štatistiky?';
$lang['confirm_reindex'] = 'Tento úkon môže trvať dlhší čas, a/alebo si vyžiadať mimoriadne veľké množstvo pamäte PHP. Naozaj chcete znovu indexovať všetok obsah?';
$lang['count'] = 'Počet';
$lang['default_stopwords'] = 'Ja, ja, moja, mne, my, naše, naše, my, vy, váš, vy, sami, sami, on, on, jeho, sám, ona, jej, jej, Sama to jeho, sám, oni, je, ich, oni samy, čo, ktorý, kto, koho, to, že to, ty, ja, je, sú;, bolo, bolo, je, bol, je, že sa musel, ktorá má robiť, robí, to, robiť,,,, a, ale, ak je, alebo preto, as, až do doby, zatiaľ čo o, u, o, u, s, o, pred, medzi, do, až v priebehu, pred, po, nad, pod, na, od, hore, dole, in, out, zapnutý, vypnutý, nad, pod, znovu, ďalej potom, raz, tu, tam, kedy, kde, prečo, ako, všetci, každý, ako každý, málo, viac, najviac, ostatné, niektoré, ako napríklad, nie, ani nie, len, vlastné, rovnako tak, ako, tiež, veľmi';
$lang['description'] = 'Modul na vyhľadávanie stránky a iných obsahov modulov';
$lang['eventdesc-SearchAllItemsDeleted'] = 'Spustené po vymazaní všetkých položiek indexu.';
$lang['eventhelp-SearchAllItemsDeleted'] = '<h4>Parametre</h4>
<ul>
<li>Žiadne</li>
</ul>';
$lang['eventdesc-SearchCompleted'] = 'Spustené po dokončení vyhľadávania.';
$lang['eventhelp-SearchCompleted'] = '<h4>Parametre</h4>
<ol>
<li>Hľadaný text.</li>
<li>Zoznam výsledkov vyhľadávania.</li>
</ol>';
$lang['eventdesc-SearchInitiated'] = 'Odoslané po spustení vyhľadávania.';
$lang['eventhelp-SearchInitiated'] = '<h4>Parametre</h4>
<ol>
<li>Hľadaný text.</li>
</ol>';
$lang['eventdesc-SearchItemAdded'] = 'Odoslané po indexovaní novej položky.';
$lang['eventhelp-SearchItemAdded'] = '<h4>Parametre</h4>
<ol>
<li>Názov modulu.</li>
<li>ID položky.</li>
<li>Dodatočný atribút.</li>
<li>Obsah na indexovanie a pridanie.</li>
</ol>';
$lang['eventdesc-SearchItemDeleted'] = 'Odoslané po vymazaní položky z indexu.';
$lang['eventhelp-SearchItemDeleted'] = '<h4>Parametre</h4>
<ol>
<li>Názov modulu.</li>
<li>ID položky.</li>
<li>Dodatočný atribút.</li>
</ol>';
$lang['export_to_csv'] = 'Export do CSV';
$lang['help'] = '<h3>Ako to funguje?</h3>
<p>Vyhľadávanie je modul pre prehľadávanie obsahu "jadra" a určitých registrovaných modulov. Zadáte text a vrátia sa relevantné, zhodujúce sa výsledky.</p>
<h3>Ako to používať?</h3>
<p>Najjednoduchší spôsob je s použitím {search} tagu (zaobaľuje module tag pre zjednodušenie zápisu). Týmto sa umiestni modul buď do šablóny, alebo na stránku a zobrazí vyhľadávací formulár. Kód môže vyzerať takto: <code>{search}</code></p>
<h4>Ako zakázať indexovanie určitého obsahu?</h4>
<p>Vyhľadávací modul nebude prehľadávať "neaktívne" stránky. Napriek tomu, v prípade, že používate modul CustomContent, alebo iný inteligentný spôsob pre zobrazenie rôzneho obsahu pre rôzne skupiny používateľov, je odporúčané zakázať prehľadávanie takýchto živých stránok. Môžete to spraviť použitím tagu <em><!-- pageAttribute: NotSearchable --></em> hocikde na stránke. Pokiaľ vyhľadávací modul nájde takýto tag na stránke, nebude indexovať jej obsah.</p>
<p>Tag <em><!-- pageAttribute: NotSearchable --></em> môže byť umiestnený aj v šablóne. V takomto prípade, žiadna zo stránok používajúca danú šablónu nebude indexovaná. Po odstránení tagu budú takéto stránky preindexované.</p>';
$lang['input_resetstopwords'] = 'Načítať';
$lang['noresultsfound'] = 'Žiadne výsledky!';
$lang['nostatistics'] = 'Nenašli sa žiadne štatistiky';
$lang['options'] = 'Nastavenia';
$lang['param_action'] = 'Specify the mode of operation for the module.  Acceptable values are \'default\', and \'keywords\'.  The keywords action can be used to generate a comma seperated list of words suitable for use in a keywords meta tag.';
$lang['param_count'] = 'Pri použití keywords, tento parameter obmedzuje výstup na zadaný počet slov.';
$lang['param_detailpage'] = 'Použitie iba v prípade modulov, parameter povoľuje špecifikovať odlišnú stránku detailu pre výsledky.   Použiteľné napríklad keď zobrazujete detail na inej stránke ako výsledky vyhľadávania <em>(<strong>Poznámka:</strong> moduly toto môžu prepísať.)</em>';
$lang['param_inline'] = 'Ak je toto nastavené, prepíšu výsledky vyhľadávania pôvodný obsah \'search\' tagu v pôvodnom bloku. Použite toto nastavenie, ak Vaša šablóna obsahuje viacero blokov s obsahom a nechcete aby výsledky vyhľadávania prepísali preddefinovaný blok';
$lang['param_modules'] = 'Obmedzí výsledky vyhľadávania na hodnoty indexované v zadanom zozname modulov (oddelených čiarkov)';
$lang['param_pageid'] = 'Používa sa  iba s keywords, paramtere slúži na zobrazenie výsledkov na inej stránke (pageid) ako je formulár.';
$lang['param_passthru'] = 'Predá vymenované parametre zadaným modulom. Formát každého z parametrov je: "passtru_MODULENAME_PARAMNAME=\'value\'" napríklad: passthru_News_detailpage=\'newsdetails\'"';
$lang['param_resultpage'] = 'Stránka pre zobrazenie výsledkov hľadania. Môže to byť buď alias stránky alebo id. Používa sa nato, aby bolo možné zobraziť výsledky vyhľadávania v inej šablóne v akej je vyhľadávací formulár';
$lang['param_searchtext'] = 'Text zobrazený v políčku pre vyhľadávanie';
$lang['param_submit'] = 'Text zobrazený na tlačítku pre spustenie vyhľadávania';
$lang['prompt_alpharesults'] = 'Triedenie výsledkov podľa abecedy, nie na základe správnosti ako zvyčajne.';
$lang['prompt_resetstopwords'] = 'Nahrať';
$lang['prompt_resultpage'] = 'Stránka pre individuálne výsledky modulu <em>(poznámka: moduly môžu toto prepísať)</em>';
$lang['prompt_savephrases'] = 'Sledovanie vyhľadávacích fráz, nie samozných slov';
$lang['prompt_searchtext'] = 'Výchdzí text pre vyhľadávanie';
$lang['reindexallcontent'] = 'Preindexovať všetok obsah';
$lang['reindexcomplete'] = 'Preindexovanie dokončené!';
$lang['restoretodefaultsmsg'] = 'Táto akcia obnoví východzie nastavenie šablón. Naozaj ju chete vykonať?';
$lang['resulttemplate'] = 'šablóna pre výsledky';
$lang['resulttemplateupdated'] = 'šablóna pre výsledky bola aktualizovaná';
$lang['search'] = 'Vyhľadávanie';
$lang['searchresultsfor'] = 'Výsledky vyhľadávania textu';
$lang['searchsubmit'] = 'Odoslať';
$lang['searchtemplate'] = 'šablóna pre vyhľadávanie';
$lang['searchtemplateupdated'] = 'šablóna pre vyhľadávanie bola aktualizovaná';
$lang['search_method'] = 'Kompatibilita čitateľný adries cez metódu POST, prednastavená hodnota je GET, pre zmenu vložte do stránok značku {search search_method="post"}';
$lang['statistics'] = 'Štatistiky';
$lang['stopwords'] = 'Stop-slová';
$lang['submit'] = 'Odoslať';
$lang['sysdefaults'] = 'Obnoviť predvolené';
$lang['timetaken'] = 'Potrebný čas';
$lang['type_Search'] = 'Vyhľadať';
$lang['type_searchform'] = 'Formulár vyhľadávania';
$lang['type_searchresults'] = 'Výsledky vyhľadávania';
$lang['usestemming'] = 'Použiť korene slov (iba v angličtine)';
$lang['use_or'] = 'Nájsť výsledky, ktoré zodpovedajú AKÉMUKOĽVEK slovu';
$lang['word'] = 'Slovo';
?>