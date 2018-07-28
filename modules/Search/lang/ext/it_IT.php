<?php
$lang['clear'] = 'Pulisci';
$lang['confirm_clearstats'] = 'Siete sicuri di volere eliminare tutte le statistiche?';
$lang['confirm_reindex'] = 'Questa operazione potrebbe richiedere un lungo periodo di tempo, e/o richiedere una grande quantità di memoria PHP. Sei sicuro di voler reindicizzare tutti i contenuti?';
$lang['count'] = 'Contatore';
$lang['default_stopwords'] = 'io, me, mio, noi, nostro, nostri, tu, voi, tuo, vostro, tuoi, vostri,  
lui, lei, egli, ella, suo, sua, suoi, sue, essi, loro, 
cosa, come, chi, quale, quali, questo, quello, questi, quelli, 
sono, sei, ero, eri, essere, 
avere, ho, ha, hanno, ebbero, ebbe, ebbi, avesti
fare, fa, fanno, feci, fece, fecero, facendo, 
un, uno, una, il, lo, le, la, gli, i, e, ma, se, o, oppure, perchè, come, fino, sino, mentre, di, a, da, con, su, per, tra, fra, contro, nel, nello, nella, nei, 
attraverso, durante, prima, dopo, sopra, sotto, giù
dentro, fuori, acceso, spento, ancora, oltre, poi, qui, qua, lì, là, quando, dove, perché, come, tutto, tutti, qualsiasi, entrambe, entrambi, ogni, più, altro, no, nessuno, nessuna, nessun, non, solo, quindi, anche, molto';
$lang['description'] = 'Modulo per ricercare nel sito e nel contenuto di altri moduli.';
$lang['eventdesc-SearchAllItemsDeleted'] = 'Mandato quando tutti i termini sono cancellati dall\'indice.';
$lang['eventhelp-SearchAllItemsDeleted'] = '<p>Sent when all items are deleted from the index.</p>
<h4>Parameters</h4>
<ul>
<li>None</li>
</ul>';
$lang['eventdesc-SearchCompleted'] = 'Mandato quando la ricerca è completata.';
$lang['eventhelp-SearchCompleted'] = '<p>Mandato quando la ricerca è completata.</p>
<h4>Parametri</h4>
<ol>
<li>Testo da ricercare.</li>
<li>Array dei risultati completi.</li>
</ol>';
$lang['eventdesc-SearchInitiated'] = 'Mandato quando la ricerca è iniziata.';
$lang['eventhelp-SearchInitiated'] = '<p>Mandato quando la ricerca è iniziata.</p>
<h4>Parametri</h4>
<ol>
<li>Testo da ricercare.</li>
</ol>';
$lang['eventdesc-SearchItemAdded'] = 'Mandato quando un nuovo termine è indicizzato.';
$lang['eventhelp-SearchItemAdded'] = '<h4>Parametri</h4>
<ol>
<li>Nome modulo.</li>
<li>Id dell\'elemento.</li>
<li>Attributo Aggiuntivo.</li>
<li>Contenuto da indicizzare e aggiungere.</li>
</ol>';
$lang['eventdesc-SearchItemDeleted'] = 'Mandato quando un nuovo termine è cancellato dall\'indice.';
$lang['eventhelp-SearchItemDeleted'] = '<h4>Parametri</h4>
<ol>
<li>Nome modulo.</li>
<li>Id dell\'elemento.</li>
<li>Attributo Aggiuntivo.</li>
<li>Contenuto da indicizzare e aggiungere.</li>
</ol>';
$lang['export_to_csv'] = 'Esporta in CSV';
$lang['help'] = '<h3>Che cosa fa?</h3>
<p>Search è un modulo
Search è un modulo per la ricerca di contenuti "core" insieme con alcuni moduli registrati.  Inserisci una o due parole e ti restituisce risultati corrispondenti e pertinenti.</p>
<h3>Come si usa?</h3>
<p>Il modo più semplice di usarlo è mediante il tag  {search}  (include il modulo in un tag, per semplificare la sintassi).
Questo inserirà il modulo nel tuo template o pagina, dovunque vorrai, e visualizzerà il form di ricerca. Il codice sarà simile a questo: <code>{search}</code></p>

<h4>Come posso evitare l\'indicizzazione di determinati contenuti</h4>
<p>Il modulo search non cercherà nessuna pagina "non attiva". Comunque a volte, quando usi il modulo CustomContent, o altre logiche smarty per mostrare contenuti diversi a gruppi diversi di utenti, può essere consigliabile evitare l\'indicizzazione dell\'intera pagine anche quando è attiva. Per farlo, includi il seguente tag da qualche parte nella pagina <em><!-- pageAttribute: NotSearchable --></em> Quando il modulo search incontra questo tag nella pagina non indicizza nessun contenuto di quella pagina.</p>
<p>Il tag <em><!-- pageAttribute: NotSearchable --></em> può essere anche inserito nel template. In questo caso, nessuna delle pagine associate al quel template sarà indicizzata. Quelle pagine verrano reindicizzate se il tag viene rimosso</p>';
$lang['input_resetstopwords'] = 'Carica';
$lang['noresultsfound'] = 'Nessun risultato trovato!';
$lang['nostatistics'] = 'Nessuna statistica trovata!';
$lang['options'] = 'Opzioni';
$lang['param_action'] = 'Specifica il modo operativo del modulo. Valori accettabili sono \'default\' e \'keywords\'. La azione keywords può essere usata per generare una lista separata da virgola di parole da usare nel meta tag keywords.';
$lang['param_count'] = 'Usata con l\'azione keywords, questo parametro limita l\'uscita al numero specificato di parole';
$lang['param_detailpage'] = 'Usato solo per combinare risultati dai moduli, questo parametro permette specificare una differente pagina per i risultati. Questo è utile se, per esempio, mostrate sempre le viste di dettaglio in una pagina con un template diverso.  <em>(<strong>Nota:</strong> i moduli hanno la possibilità di sovrascrivere questo parametro.)</em>';
$lang['param_formtemplate'] = 'Utilizzato solo con l\'azione predefinita, questo parametro permette di specificare il nome di un modello non predefinito.';
$lang['param_inline'] = 'Se vero, l\'uscita dal search sostituisce il contenuto originale del tag "search" tag nel dato blocco. Usa questo parametro se il Vostro template ha multipli blocchi e non volete visualizzare la ricerca nel blocco predefinito';
$lang['param_modules'] = 'Limita i risultati della ricerca ai valori indicizzati dalla specifica lista (separati da virgola) di moduli';
$lang['param_pageid'] = 'Applicabile solo con l\'azione keywords, questo parametro può essere usato per specificare un differente ID di pagina per il ritorno dei risultati';
$lang['param_passthru'] = 'Passa i parametri nominati ai moduli specificati. Il formato di ciascun di questi parametri è: "passtru_MODULENAME_PARAMNAME=\'value\'" i.e.: passthru_News_detailpage=\'newsdetails\'"';
$lang['param_resultpage'] = 'Pagina che visualizza i risultati della ricerca. Questa può essere un alias di pagina o un id. Usato per permettere che i risultati siano visualizzati in un diverso Modello di quello della ricerca';
$lang['param_resulttemplate'] = 'Questo parametro permette di specificare il nome di un modello non predefinito da usare per visualizzare i risultati della ricerca.';
$lang['param_searchtext'] = 'Testo da posizionare nel box di ricerca';
$lang['param_submit'] = 'Testo da posizionare nel pulsante Invio';
$lang['param_useor'] = 'Cambia la relazione predefinita da OR a AND';
$lang['prompt_alpharesults'] = 'Ordina i risultati alfabeticamente invece che per peso';
$lang['prompt_resetstopwords'] = 'Carica Parole di Interruzione predefinite dal linguaggio';
$lang['prompt_resultpage'] = 'Pagina per risultati di moduli individuali <em>(Nota che i moduli possono opzionalmente sovrascrive questo)</em>';
$lang['prompt_savephrases'] = 'Traccia Frasi ricercate, non Parole Individuali';
$lang['prompt_searchtext'] = 'Testo di ricerca predefinito';
$lang['reindexallcontent'] = 'Reindicizza tutto il contenuto';
$lang['reindexcomplete'] = 'Reindicizzazione completata!';
$lang['restoretodefaultsmsg'] = 'Questa operazione riporta il contenuto del Modello nella condizione  originale. Siete sicuri di voler procedere?';
$lang['resulttemplate'] = 'Modello Risultato';
$lang['resulttemplateupdated'] = 'Modello Risultato aggiornato';
$lang['search'] = 'Cerca';
$lang['searchresultsfor'] = 'Risultati della ricerca per';
$lang['searchsubmit'] = 'Invia';
$lang['searchtemplate'] = 'Modello Ricerca';
$lang['searchtemplateupdated'] = 'Modello Ricerca aggiornato';
$lang['search_method'] = 'Compatibilità Pretty Urls via metodo POST, valore predefinito è sempre GET, per utilizzarlo dovete mettere {search search_method="post"}';
$lang['statistics'] = 'Statistiche';
$lang['stopwords'] = 'Parole di Stop';
$lang['submit'] = 'Inoltra';
$lang['sysdefaults'] = 'Riporta al defaults';
$lang['timetaken'] = 'Tempo impiegato';
$lang['type_Search'] = 'Cerca';
$lang['type_searchform'] = 'Form di Ricerca';
$lang['type_searchresults'] = 'Risultati della Ricerca';
$lang['usestemming'] = 'Usa Word Stemming (solo Inglese)';
$lang['use_or'] = 'Trova corrispondenze su QUALSIASI parola';
$lang['word'] = 'Parola';
?>