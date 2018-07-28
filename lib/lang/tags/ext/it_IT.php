<?php
$lang['help_function_cms_html_options'] = '<h3>Che cosa fa?</h3>
<p>È un plugin potente che rende le option di elementi select in tag html <option> e <optgroup>. Ciascuna option può avere elementi figli, il proprio tag title e il proprio atttributo di classe.</p>
<h3>Utilizzo:</h3>
<pre><code>{cms_html_options options=$options [selected=valore]}</code></pre>
<h3>Quali parametri assume?</h3>
<ul>
  <li>options - <em>(array)</em> - Un array di definizioni di option.</li>
  <li>selected - <em>(string)</em> - Il valore selezionato automaticamente nel menu a discesa. Deve corrispondere al valore di una delle option.</li>
</ul>
<h4>Option</h4>
<p>Ogni option è un array asssociativo con uno o più dei seguenti membri:</p>
<ul>
  <li>label - <em>(<strong>rrichiesto</strong> stringa)</em> Un\'etichetta per l\'option (è ciò che vede l\'utente)</li>
  <li>value - <em>(<strong>rrichiesto</strong> misto)</em> Un valore stringa per l\'option, oppure un array di definizioni di option.
    <p>Se il valore di una definizione di option è esso stesso un array di option, l\'etichetta verrà mostrata come un optgroup con figli.</p>
  </li>
  <li>title - <em>(stringa)</em> Un attributo title per l\'option.</li>
  <li>class - <em>(stringa)</em> Un nome di classe per l\'option.</li>
</ul>

<h3>Esempio:</h3>
<pre><code>
{$opts[]=[\'label\'=>\'Capra\',\'value\'=>\'cp\',\'title\'=>\'Ho una capra\']}
{$opts[]=[\'label\'=>\'Pesce\',\'value\'=>\'p\']}
{$sub[]=[\'label\'=>\'Piccolo Cane\',\'value\'=>\'pc\']}
{$sub[]=[\'label\'=>\'Cane Medio\',\'value\'=>\'cm\']}
{$sub[]=[\'label\'=>\'Cane Grande\',\'value\'=>\'cg\']}
{$opts[]=[\'label\'=>\'Cane\',\'value\'=>$sub]}
{$opts[]=[\'label\'=>\'Gatto\',\'value\'=>\'g\',\'class\'=>\'gatto\']}
<select name="animali">
  {cms_html_options options=$opts selected=\'cm\'}
</select></code></pre>';
$lang['help_modifier_cms_date_format'] = '<h3>Che cosa fa?</h3>
<p>Questo modificatore è utilizzato per formattare le date in modo appropriato. Usa i parametri strftime standard. Se non viene specificata nessun formato stringa, il sistema userà il formato stringa impostato nelle preferenze dell\'utente (per gli utenti autenticati) opure il formato data specificato a livello di sistema.</p>
<p>Questo modificatore è in grado di interpretare le date in molti formati. Ovvero: stringhe data-ora provenienti dal database o interi timestamp generati dalla funzione time().</p>
<h3>Utilizzo:</h3>
<pre><code>{$una_variabile_data|cms_date_format[:<formato stringa>]}</code></pre>
<h3>Esempio:</h3>
<pre><code>{\'24-03-2012 22:44:22\'|cms_date_format}</code></pre>';
$lang['help_modifier_cms_escape'] = '<h3>Che cosa fa?</h3>
<p>Questo modificatore è utilizzato per effettuare l\'escape di una stringa, scegliendone uno tra i molti modi disponibili. Può essere usato per convertire la stringa in molteplici formati differenti di visualizzazione, o per visualizzare correttamente in una pagina web standard i dati contenenti caratteri speciali inseriti dall\'utente.</p>
<h3>Utilizzo:</h3>
<pre><code>{$una_variabile_con_testo|cms_escape[:<tipo di escape>|[<set di caratteri>]]}</code></pre>
<h4>Tipi di escape validi:</h4>
<ul>
<li>html <em>(predefinito)</em> - usa htmlspecialchars.</li>
<li>htmlall - usa htmlentities.</li>
<li>url - codifica come url grezze tutte le entità.</li>
<li>urlpathinfo - Simile al tipo di escape url, ma in più codifica /.</li>
<li>quotes - Effettua l\'escape degli apici, se già non lo sono.</li>
<li>hex - Effettua l\'escape di ogni carattere in esadecimale.</li>
<li>hexentity - Codifica in esadecimale ogni carattere.</li>
<li>decentity - Codifica decimale di ogni carattere.</li>
<li>javascript - Effettua l\'escape di virgolette, backslashe, ritorni a capo ecc.</li>
<li>mail - Codifica un indirizzo email rendendolo sicuro per la visualizzazione.</li>
<li>nonstd - Effettua l\'escape di caratteri non standard, come ad esempio le citazioni di documenti.</li>
</ul>
<h4>Set di Caratteri::</h4>
<p>Se il set di caratteri non è specificato, viene adottato utf-8. Il set di caratteri è applicabile solo ai tipi di escape "html" e "htmlall".</p>';
$lang['help_modifier_relative_time'] = '<h3>Che cosa fa?</h3>
  <p>Questo modificatore converte un intero timestamp, o una stringa ora/data in una rappresentazione temporale comprensibile, a partire da o a ora. Cioè: "3 ore fa."</p>
<h3>Quali parametri assume?</h3>
 <p>Questo modificatore non accetta nessun parametro opzionale.</p>
<h3>Esempio:</h3>
  <code><pre>{$un_timestamp|relative_time}</code></pre>';
$lang['help_modifier_summarize'] = '<h3>Che cosa fa?</h3>
<p>Questo modificatore è usato per troncare una lunga sequenza di testo, limitandolo al numero specificato di "parole".</p>
<h3>Utilizzo:</h3>
<pre><code>{$variabile_con_testo_lungo|summarize:<numero>}</code></pre>
<h3>Esempio:</h3>
<p>Il seguente esempio rimuove tutti i tag html dal content e lo interrompe dopo 50 parole.</p>
<pre><code>{conten|strip_tags|summarize:50}</code></pre>';
$lang['help_function_admin_icon'] = '<h3>Che cosa fa?</h3>
<p>È un plugin riservato alla parte amministrativa per permettere ai moduli di visualizzare le icone del tema di amministrazione corrente. Queste icone sono utili nella costruzione dei link o per mostrare informazioni di stato.</p>
<h3>Quali parametri assume?</h3>
<ul>
  <li>icon - <strong>(richiesto)</strong> - Il nome del file dell\'icona. Es.: run.gif</li>
  <li>height - <em>(opzionale)</em> - L\'altezza (in pixel) dell\'icona.</li>
  <li>width - <em>(opzionale)</em> - La larghezza (in pixel) dell\'icona.</li>
  <li>alt - <em>(opzionale)</em> - Testo opzionale per il tag img se il nome del file specificato non è disponibile.</li>
  <li>rel - <em>(opzionale)</em> - Un attributo rel opzionale per il tag img.</li>
  <li>class - <em>(opzionale)</em> - Un attributo di classe opzionale per il tag img.</li>
  <li>id - <em>(opzionale)</em> - Un attributo id opzionale per il tag img.</li>
  <li>title - <em>(opzionale)</em> - Un attributo title opzionale per il tag img.</li>
  <li>accesskey - <em>(opzionale)</em> - Un carattere opzionale per la chiave di accesso per il tag img.</li>
  <li>assign - <em>(opzionale)</em> - Assegna l\'output del tag alla variable smarty specificata.</li>
</ul>
<h3>Esempio:</h3>
<pre><code>{admin_icon icon=\'edit.gif\' class=\'editicon\'}</code></pre>';
$lang['help_function_cms_action_url'] = '<h3>Che cosa fa?</h3>
<p>Questo è plugin intelligente ed utile per generare un URL ad una azione di un modulo. È un plugin utile agli sviluppatori di moduli quando devono generare link (sia in Ajax o nell\'interfaccia di amministrazione) per effettuare funzionalità diverse o visualizzare dati differenti.</p>
<h3>Quali parametri assume?</h3>
<ul>
  <li>module - <em>(opzionale)</em> - Il nome del modulo per il quale generare l\'URL. Questo parametro non è necessario se si sta generando un URL da una action di un modulo diretta ad un\'altra action dello stesso modulo.</li>
  <li>action - <strong>(richiesto)</strong> - Il nome dell\'action a cui generare l\'URL.</li>
  <li>returnid - <em>(opzionale)</em> - L\'intero numerico dell\'id di pagina in cui visualizzare i risultati dell\'action. Questo parametro non è necessario se l\'action deve essere visualizzata nella pagina corrente, oppure se l\'URL è diretta ad una action di amministrazione partendo da una action di amministrazione.</li>
  <li>mid - <em>(opzionale)</em> - L\'action id del modulo. Per impostazione predefinita è "m1_" per le action di amministrazione, e "cntnt01" per le action della parte pubblica.</li>
  <li>forjs - <em>(opzionale)</em> - Un intero opzionale che indica che l\'URL generato dovrebbe essere compatibile con l\'uso di JavaScript.</li>
  <li>assign - <em>(opzionale)</em> - Assegna l\'output dell\'URL alla variabile smarty specificata.</li>
</ul>
<p><strong>Nota:</strong> Tutti i parametri non accettati da questo plugin vengono automaticamente passati alla action del modulo chiamata nell\'URL generato.</p>
<h3>Esempio:</h3>
<pre><code>{cms_action_url module=News action=defaultadmin}</code><pre>';
?>