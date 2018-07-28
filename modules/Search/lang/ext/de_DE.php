<?php
$lang['clear'] = 'Löschen';
$lang['confirm_clearstats'] = 'Wollen Sie wirklich alle Statistiken unwiderruflich löschen?';
$lang['count'] = 'Zähler';
$lang['default_stopwords'] = 'aber, alle, als, am, an, andere, anderen, anderes, auch, auf, aus, bei, beide, bevor, bin, bis, bist, da, dadurch, daher, danach, dann, darum, das, daß, dass, dein, deine, deinen, deines, dem, den, der, deren, des, deshalb, dessen, die, dies, dieser, dieses, doch, dort, du, durch, ein, eine, einem, einen, einer, eines, einige, einigen, einiger, er, es, euer, eure, euren, eurer, eures, ferner, für, gegen, gewesen, habe, haben, hat, hatte, hatten, hattest, hattet, hier, hinter, hoch, ich, ihnen, ihr, ihre, ihren, ihres, im, in, irgend, ist, ja, jede, jedem, jeden, jeder, jedes, jemand, jener, jenes, jetzt, kann, kannst, können, könnt, machen, mal, mehr, mein, meine, meinen, meisten, mich, mir, mit, muß, müssen, mußt, musst, müßt, nach, nachdem, nein, nicht, nun, nur, oberhalb, oder, runter, sehr, seid, sein, seine, seinen, seines, selbe, selben, selber, selbst, sich, sie, sind, so, solche, solchen, solcher, soll, sollen, sollst, sollt, sonst, soweit, sowie, tat, tun, tut, über, und, unser, unsere, unseren, unserer, unseres, unter, unterhalb, vom, von, vor, während, wann, war, waren, warst, warum, was, weil, weiter, weitere, welche, welcher, wenn, wer, werde, werden, werdet, weshalb, wessen, wie, wieder, wieso, wir, wird, wirst, wo, woher, wohin, zu, zum, zur, zwischen';
$lang['description'] = 'Modul für die Suche in den Inhalten der Webseite und den Modulen.';
$lang['eventdesc-SearchAllItemsDeleted'] = 'Ausführen, wenn alle Einträge aus dem Index gelöscht wurden.';
$lang['eventhelp-SearchAllItemsDeleted'] = '<h4>Parameter</h4>
<ul>
<li>Keine</li>
</ul>';
$lang['eventdesc-SearchCompleted'] = 'Ausführen, wenn eine Suche beendet wurde.';
$lang['eventhelp-SearchCompleted'] = '<h4>Parameter</h4>
<ol>
<li>Text, nach dem gesucht wurde.</li>
<li>Array mit den kompletten Ergebnissen.</li>
</ol>';
$lang['eventdesc-SearchInitiated'] = 'Ausführen, wenn eine Suche gestartet wurde.';
$lang['eventhelp-SearchInitiated'] = '<h4>Parameter</h4>
<ol>
<li>Text, nach dem gesucht wurde.</li>
</ol>';
$lang['eventdesc-SearchItemAdded'] = 'Ausführen, wenn ein neuer Eintrag indiziert wurde.';
$lang['eventhelp-SearchItemAdded'] = '<h4>Parameter</h4>
<ol>
<li>Modulname.</li>
<li>ID des Eintrags.</li>
<li>Weitere Attribute.</li>
<li>zu indizierender und hinzugefügter Inhalt.</li>
</ol>';
$lang['eventdesc-SearchItemDeleted'] = 'Ausführen, wenn ein Eintrag aus dem Index gelöscht wurde.';
$lang['eventhelp-SearchItemDeleted'] = '<h4>Parameter</h4>
<ol>
<li>Modulname.</li>
<li>ID des Eintrages.</li>
<li>Weitere Attribute.</li>
</ol>';
$lang['export_to_csv'] = 'Als CSV-Datei exportieren';
$lang['help'] = '<h3>Was macht dieses Modul?</h3>
<p>Search ist ein Modul für die Suche in den Inhalten der mit CMSMS erstellten Seiten sowie denen aller registrierten Module. Sie geben ein oder zwei Wörter ein und erhalten die relevanten Ergebnisse zurück.</p>
<h3>Wie wird es eingesetzt?</h3>
<p>Am einfachsten lässt sich das Modul mit dem {search}-Tag verwenden, der den Aufruf des Moduls zur Vereinfachung des Syntax in einen Tag umformt. Damit können Sie das Modul entweder in Ihr Template oder eine Seite oder wo immer Sie wollen einfügen und das Suchformular anzeigen. Der Aufruf des Moduls erfolgt mit:</p> <code>{search}</code>
<h4>Wie kann ich Inhalte von der Indizierung ausschließen?</h4>
<p>Das Search-Modul durchsucht grundsätzlich keine "inaktiven" Seiten. Wenn Sie (aus welchen Gründen auch immer) das CustomContent-Modul oder andere Smarty-Logik verwenden, um verschiedenen Nutzergruppen verschiedene Inhalte anzuzeigen, kann es erforderlich sein, die gesamte Seite von der Indizierung auszuschließen.</p>
<p>Dafür müssen Sie lediglich den folgenden Tag irgendwo in Ihrer Seite aufrufen <em><!-- pageAttribute: NotSearchable --></em></p>
<p>Wenn das Search-Modul diesen Tag auf einer Seite findet, wird deren Inhalt nicht indiziert. Dieser Tag kann auch in Templates eingesetzt werden. In diesem Fall werden diejenigen Seiten, die dieses Template verwenden, nicht indiziert. Wird der Tag entfernt, erfolgt eine Neuindizierung dieser Seiten.</p>';
$lang['input_resetstopwords'] = 'Laden';
$lang['noresultsfound'] = 'Keine Ergebnisse gefunden!';
$lang['nostatistics'] = 'Keine Statistik-daten gefunden!';
$lang['options'] = 'Optionen';
$lang['param_action'] = 'Legt den verwendeten Modus des Moduls fest. Akzeptierte Werte sind \'default\' und \'keywords\'.  \'keywords\' kann verwendet werden, um eine durch Kommata getrennte Liste der am meisten verwendeten Wörter zu erzeugen (nützlich für die Verwendung im Keyword-Metatag).';
$lang['param_count'] = 'In Verbindung mit \'keywords\' kann über diesen Parameter die Anzahl der ausgegebenen Wörter festgelegt werden.';
$lang['param_detailpage'] = 'Kann nur für Ergebnisse von Modulen verwendet werden. Mit diesem Parameter kann eine abweichende Detailseite für die Ergebnisse festgelegt werden. Dies ist zum Beispiel dann nützlich, wenn die Detailansicht auf einer Seite mit einem anderen Template angezeigt werden soll. <em>(<strong>Hinweis:</strong> Module haben die Möglichkeit, diesen Parameter zu überschreiben.)</em>';
$lang['param_formtemplate'] = 'Wird nur für die Default-Aktion benutzt, dieser Parameter erlaubt die Angabe eines nicht Default-Templates.';
$lang['param_inline'] = 'Ist dieser Wert true, wird der Standard-Inhaltsblock durch die Suchergebnisse des Such-Moduls ersetzt. Verwenden Sie diesen Parameter, wenn Ihr Template mehrere Inhaltsblöcke enthält und Sie nicht möchten, dass die Suchergebnisse den Standard-Inhaltsblock ersetzen.';
$lang['param_modules'] = 'Beschränkt die Suchergebnisse auf die festgelegte (durch Kommata getrennte) Liste von Modulen';
$lang['param_pageid'] = 'Funktioniert nur bei Verwendung von \'keywords\'. Dieser Parameter kann verwendet werden, um für die Ausgabe der Ergebnisse eine andere Seite festzulegen. Hier muss die jeweilige Seiten-ID angegeben werden.';
$lang['param_passthru'] = 'Gibt die benannten Parameter an die festgelegten Module weiter. Das Format für jeden dieser Parameter lautet: "passtru_MODULENAME_PARAMNAME=\'value\'", zum Beispiel "passthru_News_detailpage=\'newsdetails\'"';
$lang['param_resultpage'] = 'Die Seite, auf der die Suchergebnisse angezeigt werden sollen. Dies kann entweder ein Seiten-Alias oder eine Seiten-ID sein. Damit können die Suchergebnisse in einem anderem Template als das Suchformular angezeigt werden.';
$lang['param_resulttemplate'] = 'Dieser Parameter erlaubt die Angabe eines nicht Default-Templates zur Darstellung der Suchergebnisse.';
$lang['param_searchtext'] = 'Im Suchfeld angezeigter Text';
$lang['param_submit'] = 'Text für den Knopf "Absenden"';
$lang['param_useor'] = 'Ändern Sie die voreingestellte Einstellung ODER zu einem UND Verhältnis';
$lang['prompt_alpharesults'] = 'Die Suchergebnisse alphabetisch anstatt nach deren Gewicht sortieren';
$lang['prompt_resetstopwords'] = 'Nicht zu indizierende Wörter aus Sprachdatei laden';
$lang['prompt_resultpage'] = 'Die Seite für individuelle Modul-Ergebnisse <em>(Hinweis: Diese Einstellung kann optional von Modulen überschrieben werden)</em>';
$lang['prompt_savephrases'] = 'Nach Wortgruppen suchen (nicht nach einzelnen Wörtern)';
$lang['prompt_searchtext'] = 'Voreingestellter Text für das Suchfeld';
$lang['reindexallcontent'] = 'Die Webseite neu indizieren';
$lang['reindexcomplete'] = 'Neuindizierung komplett!';
$lang['restoretodefaultsmsg'] = 'Diese Aktion setzt den Inhalt der Templates auf die programmseitigen Vorgaben zurück. Wollen Sie dies wirklich?';
$lang['resulttemplate'] = 'Ergebnis-Template';
$lang['resulttemplateupdated'] = 'Ergebnis-Template wurde aktualisiert';
$lang['search'] = 'Suche';
$lang['searchresultsfor'] = 'Suchergebnisse für';
$lang['searchsubmit'] = 'Suchen';
$lang['searchtemplate'] = 'Such-Template';
$lang['searchtemplateupdated'] = 'Such-Template wurde aktualisiert';
$lang['search_method'] = 'Kompatibilität für Pretty URLs für die POST-Methode, der voreingestellte Wert ist immer GET, damit dies funktioniert, verwenden Sie <code>{search search_method=\'post\'}</code>';
$lang['statistics'] = 'Statistiken';
$lang['stopwords'] = 'Nicht zu indizierende Wörter';
$lang['submit'] = 'Absenden';
$lang['sysdefaults'] = 'Auf die programmseitigen Voreinstellungen zurücksetzen';
$lang['timetaken'] = 'Benötigte Zeit';
$lang['type_Search'] = 'Suche';
$lang['type_searchform'] = 'Suchformular';
$lang['type_searchresults'] = 'Suchergebnisse';
$lang['usestemming'] = 'Wortstammsuche aktivieren';
$lang['use_or'] = 'Ergebnisse finden, in denen irgend eines der Wörter enthalten ist';
$lang['word'] = 'Wort';
?>