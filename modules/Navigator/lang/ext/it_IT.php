<?php
$lang['description'] = 'Questo modulo offre un modo semplice e facile per generare l\'HTML necessario per la navigazione di un sito web direttamente e dinamicamente dalla struttura delle pagine di CMSMS. Fornisce un flessibile sistema di filtri e di gestione di template per creare menu di navigazione potenti, veloci ed accattivanti senza nessuna interazione con l\'editor di contenuti.';
$lang['friendlyname'] = 'CMSMS Navigation Builder';
$lang['help'] = '<h3>Che cosa fa?</h3>
  <p>Il modulo "Navigator" è un motore per generare menu di navigazione partendo dai contenuti di CMSMS e da un template smarty. Questo modulo fornisce capacità di filtraggio che permettono la creazione di numerosi modelli di navigazione basati su criteri differenti, ed una formattazione dei dati gerarchica semplice da usare per generare navigazioni con flessibilità completa.</p>
  <p>Questo modulo non ha una propria interfaccia di amministrazione ma usa il DesignManager per gestire i template dei menu.</p>
<h3>Come si usa?</h3>
<p>Il modo più semplice per usare questo modulo è l\'insertimento del tag <code>{Navigator}</code> nel template. Il modulo accetta numerosi parametri per modificare il proprio comportamento e per filtrare i dati.</p>
<h3>Perché devo usare i template?</h3>
<p>Questo è il punto di forza di CMSMS. I sistemi di navigazione possono essere generati automaticamente usando i dati della tua gerarchia di contenuti ed un template smarty. Non c\'è alcun bisogno di modificare un oggetto della navigazione ogni volta che una pagina viene aggiunta o rimossa dal sistema. Inoltre, i template di navigazione possono facilmente includere JavaScript o funzionalità avanzate e possono essere condivisi tra siti web diversi.</p>

<p>Questo modulo è distribuito con alcuni template di esempio, e sono semplicemente di esempio. Sei libero ed esortato a copiarli e modificarli a tuo piacimento. La formattazione della navigazione è ottenuta modificando un foglio di stile di CMSMS. I fogli di stile non sono inclusi nel modulo Navigator.</p>
<h3>L\'oggetto nodo:</h3>
  <p>Ogni template nav è provvisto di un array di oggetti nodo che corrispondono ai criteri specificati nel tag. Di seguito, una descrizione dei membri dell\'oggetto nodo:</p>
<ul>
  <li>$node->id -- L\'ID intero dell\'oggetto contenut.</li>
  <li>$node->url -- L\'URL all\'oggetto contenuto. Questo dovrebbe essere usato nella creazione dei link.</li>
  <li>$node->accesskey -- Chiave di accesso, se definita.</li>
  <li>$node->tabindex -- Indice di tabulazione,se definito.</li>
  <li>$node->titleattribute -- Descrizione o attributo Titolo (title), se definito.</li>
  <li>$node->hierarchy -- Posizione gerarchica.  (i.e. 1.3.3)</li>
  <li>$node->default -- TRUE se questo nodo si riferisce all\'oggetto contenuto predefinito.</li>
  <li>$node->menutext -- Testo del Menu</li>
  <li>$node->raw_menutext -- Testo del Menu senza la conversione delle entità html</li>
  <li>$node->alias -- Alias di pagina</li>
  <li>$node->extra1 -- Questo campo contiene il valore della proprietà di pagina extra1, a meno che il parametro loadprops non sia impostato a NON caricare le proprietà.</li>
  <li>$node->extra2 -- Questo campo contiene il valore della proprietà di pagina extra2, a meno che il parametro loadprops non sia impostato a NON caricare le proprietà.</li>
  <li>$node->extra3 -- Questo campo contiene il valore della proprietà di pagina extra3, a meno che il parametro loadprops non sia impostato a NON caricare le proprietà.</li>
  <li>$node->image -- Questo campo contiene il valore della proprietà di pagina image (se non è vuoto), a meno che il parametro loadprops non sia impostato a NON caricare le proprietà.</li>
  <li>$node->thumbnail -- Questo campo contiene il valore della proprietà di pagina thumbnail (se non è vuoto), a meno che il parametro loadprops non sia impostato a NON caricare le proprietà.</li>
  <li>$node->target -- Questo campo contiene il Target del link  (se non è vuoto), a meno che il parametro loadprops non sia impostato a NON caricare le proprietà.</li>
  <li>$node->created -- Data di creazione dell\'elemento</li>
  <li>$node->modified -- Data di modifica dell\'elemento</li>
  <li>$node->parent -- TRUE se questo nodo è il genitore della pagina attualmente selezionata</li>
  <li>$node->current -- TRUE se questo nodo è la pagina attualmente selezionata</li>
  <li>$node->has_children -- TRUE se questo nodo ha dei figli.</li>
  <li>$node->children -- Un array di oggetti nodo contenente i figli di questo nodo visualizzabili. Non impostato se il nodo non ha figli da visualizzare.</li>
  <li>$node->children_exist -- TRUE se questo nodo ha figli che potrebbero essere visualizzati ma non lo sono a causa di altri parametri di filtraggio (numero dei livelli, ecc.).</li>
</ul>
<h3>Esempi:</h3>
<ul>
   <li>Una semplice navigazione con soli 2 livelli di profondità, utilizzando il template predefinito:<br/>
     <pre><code>{Navigator number_of_levels=2}</code></pre>
   </li>
     <li>Mostra una semplice navigazione con 2 livelli di profondità partendo dai figli della pagina corrente. Usa  il template predefinito:</li>
     <pre><code>{Navigator number_of_levels=2 start_page=$page_alias}</code></pre>
   </li>
   <li>Mostra una semplice navigazione con 2 livelli di profondità partendo dai figli della pagina corrente. Usa  il template predefinito:</li>
     <pre><code>{Navigator number_of_levels=2 childrenof=$page_alias}</code></pre>
   </li>
   <li>Mostra una navigazione con 2 livelli di profondità partendo dalla pagina corrente, i suoi pari livello, ed ogni cosa sotto di essi. Usa  il template predefinito:</li>
     <pre><code>{Navigator number_of_levels=2 start_page=$page_alias show_root_siblings=1}</code></pre>
   </li>
   <li>Mostra una navigazione degli elementi del menu specificati ed i loro figli. Usa il template chiamato mymenu</li>
     <pre><code>{Navigator items=\'alias1,alias2,alias3\' number_of_levels=3 template=mymenu}</code></pre>
   </li>
</ul>';
$lang['help_action'] = 'Specifica l\'azione del modulo. Questo modulo supporta due azioni:
<ul>
  <li><em>default</em> - Usata per creare una navigazione primaria. (è l\'azione predefinita se non viene specificato nessuna altra azione).</li>
  <li>breadcrumbs - Usata per creare una mini navigazione consistente nel percorso dalla radice del sito fino alla pagina corrente.</li>
</ul>';
$lang['help_collapse'] = 'Se abilitato, saranno restituiti solo gli elementi relativi alla attuale pagina attiva';
$lang['help_childrenof'] = 'Questa opzione indurrà il menu a mostrare solo gli elementi discendenti dell\'id o alias di pagina selezionato. Ovvero: <code>{menu childrenof=$page_alias}</code> visualizzarà solo i figli della pagina corrente.';
$lang['help_excludeprefix'] = 'Esclude tutti gli elementi (ed i loro figli) l\'alias dei quali corrisponde ad uno dei prefissi specificati (separati da virgola). Questo parametro non deve essere usato insieme al parametro includeprefix.';
$lang['help_includeprefix'] = 'Include solo quegli elementi il cui alias corrisponde ad uno dei prefissi specificati (separati da virgola). Questo parametro non può essere usato insieme al parametro excludeprefix.';
$lang['help_items'] = 'Specificare un elenco di alias di pagina, separati da virgola, che questo menu dovrebbe visualizzare.';
$lang['help_loadprops'] = 'Utilizza questo parametro quando nel template del gestore di menu NON sono usate proprietà avanzate. Questo disabiliterà il caricamento di tutte le proprietà del contenuto per ciascun nodo (quindi per extra1, immagine, miniatura ecc.). Questo diminuirà drasticamente il numero di query necessarie per costruire un menu, ed aumenterà la memoria richiesta, ma non consentirà menu più avanzati';
$lang['help_nlevels'] = 'Alias di number_of_levels';
$lang['help_number_of_levels'] = 'Questa impostazione limiterà la profondità del menu generato al numero di livelli specificato. Per impostazione predefinita il valore di questo parametro si intende illimitato, tranne quando si usa il parametro items; in questo caso il parametro number_of_levels ha implicitamente valore 1';
$lang['help_root2'] = 'Usato solo nell\'azione "breadcrumbs", questo parametro indica che le breadcrumbs non dovrebbero andare oltre l\'albero della pagina specificata con l\'alias. Impostando un valore intero negativo visualizzerà solo le breadcrumb relative al livello principale ed ignorerà la pagina predefinita.';
$lang['help_show_all'] = 'Questa opzione farà in modo che il menu visualizzi tutti i nodi anche se questi sono impostati per non essere mostrati nel menu. Non mostrerà comunque le pagine inattive.';
$lang['help_show_root_siblings'] = 'Questa opzione è utile solo nel caso in cui vengono utilizzati start_element o start_page. Fondamentalmente visualizzerà i fratelli al fianco dello start_page/element selezionato.';
$lang['help_start_element'] = 'Inizia la visualizzazione del menu partendo dallo start_element selezionato, mostrando solo quell\'elemento ed i suoi figli. Assume una posizione gerarchica (es. 5.1.2).';
$lang['help_start_level'] = 'Questa opzione visualizzerà nel menu soltanto gli elementi che partono dal livello specificato relativo alla pagina corrente. Un esempio semplice potrebbe essere il caso in cui si ha nella pagina un menu con number_of_levels=1. Quindi un secondo menu in cui si abbia start_level=2. Il secondo menu mostrerà gli elementi relativi a ciò che è selezionato nel primo menu. Il valore minimo per questo parametro è 2';
$lang['help_start_page'] = 'La visualizzazione del menu parte dalla start_page specificata, mostrando solo quell\'elemento ed i suoi figli. Assume un alias di pagina.';
$lang['help_template'] = 'Il template da usare per la visualizzazione del menu. Il template specificato deve esistere nel DesignManager o verrà mostrato un errore. Se questo parametro non viene specificato sarà usato il template predefinito di tipo Navigator::Navigation';
$lang['help_start_text'] = 'Utile solo nell\'azione breadcrumbs, questo parametro consente di specificare del testo opzionale da mostrare all\'inizio della navigazione breadcrumb. Un esempio potrebbe essere "Voi Siete Qui"';
$lang['type_breadcrumbs'] = 'Breadcrumb';
$lang['type_Navigator'] = 'Navigatore';
$lang['type_navigation'] = 'Navigazione';
$lang['youarehere'] = 'Voi Siete Qui';
?>