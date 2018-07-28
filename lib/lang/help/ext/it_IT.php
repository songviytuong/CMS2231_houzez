<?php
$lang['help_group_permissions'] = '<h4>Modello Permessi di Amministrazione di CMSMS</h4>
<ul>
<li>CMSMS usa un sistema di permessi basato su nomi. L\'accesso a questi permessi permette agli utenti di effettuare funzioni differenti nel pannello di Amministrazione di CMSMS.</li>
<li>Il core di CMSMS genera diversi permessi in fase di installazione <em>(permessi occasionali sono aggiunti o eliminati durante un processo di aggiornamento)</em>. Moduli di Terze Parti possono cvreare permessi aggiuntivi.</li>
<li>I permessi sono associati ai gruppi di utenti. Un utente autorizzato può modificare i permessi associati a determinati gruppi di membri <em>(inclusa la possibilità di cambiare i permessi di un gruppo)</em>.  Il gruppo <strong>Admin</strong> è un gruppo speciale. I membri di questo gruppo avranno tutti i permessi.</li>
<li>Gli account utente di amministrazione possono essere membri di zero o più gruppi. Potrebbe essere possibile per un account utente non associato a nessun gruppo eseguire comunque varie funzioni <em>(leggere le informazioni relative alla proprietà ed agli editori-aggiuntivi nell\'help di Content Manager e di Design Manager).</em>.  Il primo account utente <em>(uid == 1)</em>, di solito chiamato "Admin" è un account utente speciale ed avrà tutti i permessi.</li>
</ul>';
$lang['help_cmscontentmanager_help'] = '<h3>Introduzione</h3>
<p>Questo documento descrive il modulo CMS Gestore Contenuto. È rivolto principalmente al designer del sito o allo sviluppatore e descrive a grandi linee come funzionano gli elementi di contenuto in CMS Made Simple.</p>
<p>L\'interfaccia principale del modulo Gestore Contenuto è l\'elenco dei contenuti. Mostra gli elementi di contenuto in un formato tabulare e permette di ricercare, navigare e gestire velocemente più elementi di contenuto. Questa è una lista dinamica. La visualizzazione è adattata in base ad alcuni elementi di configurazione, ad alcune impostazioni globali, ai permessi dell\'utente ed ai singoli elementi di contenuto. Il testo seguente descrive cosa sono gli elementi di contenuto, e in che modo l\'elenco di contenuto interagisce con essi.</p>
<h3>Gerarchia dei Contenuti e Navigazioni</h3>
<p>CMS Made Simple genera dinamicamente le navigazioni del frontend basandosi sull\'elenco dei contenuti, sui singoli tipi di elementi di contenuto, sul contenuto presente in quegli elementi di contenuto, e sui template di navigazione. L\'organizzazione delle navigazioni è controllata principalmente dalla relazione gerarchica padre-figlio dei tuoi elementi di contenuto. Partendo dal livello superiore <em>(root)</em>, verso il basso.</p>
<p>Aggiungere un nuovo elemento al menu di navigazione è semplice quanto creare un nuovo elemento di contenuto, stabilendone la posizione gerarchica, e <em>(in base al tipo di elemento di contenuto)</em> specificando le differenti proprietà disponibili per quel tipo di elemento di contenuto.</p>
<h3>Tipi di Elemento di Contenuto:</h3>
<p>CMSMS è distribuito con diversi tipi di elemento di contenuto differenti <em>(ed altri sono disponibili mediante moduli aggiuntivi di terze parti)</em>. Questi elementi di contenuto hanno scopi diversi quando viene generata la navigazione. Alcuni non hanno contenuto, ma vengono usati solo per gestire le navigazioni. Ad esempio, il tipo di elemento di contenuto separatore di per sé non possiede contenuto, ed esiste soltanto per organizzare gli elementi di contenuto e fornire un separatore visibile nella navigazione generata.</p>
<p>Di seguito è riportata una breve descrizione di ogni tipo di elemento di contenuto distribuito con CMS Made Simple</p>
<ul>
  <li>Pagina di Contenuto
  <p>Questo tipo di elemento di contenuto è più simile a una pagina HTML, e viene generalmente usato per quello scopo. Quando gli editori creano un elemento pagina di contenuto, selezionano design e template che controllano l\'aspetto della pagina, specificano un titolo, ed inseriscono il contenuto per quella pagina.</p>
    <p>Gli elementi di contenuto possono anche contenere moduli, logica, visualizzare dati dinamici dai moduli, o tag definiti dall\'utente (UDTs). Questa flessibilità permette la creazione di applicazioni specializzate, o siti web estremamente flessibili e dinamici.</p>
  </li>
  <li>Link
    <p>Questo tipo di elemento di contenuto è utilizzato nelle navigazioni per generare un link a una pagina o a un sito esterno.</p>
  </li>
  <li>Link di Pagina
  <p>Anche questo tipo di elemento di contenuto è utilizzato nelle navigazioni. Genera link secondary ad una pagina di contenuto esistente. Questo tipo di elemento di contenuto può essere usato nel caso in cui si possa accedere al medesimo elemento di contenuto da più punti della navigazione.</p>
  </li>
  <li>Separatore
  <p>Anche questo tipo di elemento di contenuto è utilizzato nelle navigazioni. Di solito viene usato per generare un divisore orizzontale (o verticale) tra gli elementi di navigazione. Alcuni tipi di navigazioni <em>(determinati dal template di navigazione)</em> potrebbero non visualizzare affatto i separatori.</p>
  </li>
  <li>Intestazione di Sezione
    <p>L\'intestazione di sezione è anch\'essa visualizzata soltanto nelle navigazioni. È usata per organizzare gli elementi di contenuto. Fornisce una intestazione testuale sopra o tra altri elementi di contenuto. Le intestazioni di sezione non hanno URLS e non è di solito possibile cliccarci sopra. Alcuni template di navigazione potrebbero mostrare le intestazioni di sezione in modo diverso rispetto ad altri elementi di contenuto.</p>
  </li>
  <li>Pagina di Errore
    <p>La Pagina di Errore è uno speciale tipo di elemento di contenuto. Viene usato quando un utente richiede un elemento di contenuto che non è navigabile o non esiste.</p>
  </li>
</ul> 
<p>Many third party modules provide more content types to serve different purposes.  Such as displaying catalogues of products, or restricting the content to authorized users.</p><p> Molti moduli di terze parti forniscono più tipi di contenuto per scopi diversi. Come ad esempio la visualizzazione di cataloghi di prodotti, o la limitazione del contenuto agli utenti autorizzati.</p>
<h3>L\'Elenco degli Elementi di Contenuto</h3>
<p>L\'elenco del contenuto è l\'interfaccia principale del modulo. Questo form fornisce l\'interfaccia principale per la gestione dei tuoi contenuti. Da qui puoi creare, modificare, eliminare, copiare, disabilitare ed organizzare i tuoi elementi di contenuto. Questa schermata è fortemente ottimizzata per siti di grandi dimensioni, e mette a disposizione meccanismi di paginazione e di ricerca per mostrare solo una parte delle pagine esistenti, permettendo di trovare velocemente gli elementi da gestire.</p>
 <h4>Colonne</h4>
<p>Ciascun elemento di contenuto è visualizzato come riga di una tabella. Ci sono numerose colonne per visualizzare velocemente i vari attributi di ogni elemento di contenuto, ed alcune utili icone attive. Alcune colonne potrebbero essere nascoste interamente alla vista, o solo per alcune righe secondo una serie di fattori:</p>
<ul>
    <li>I Tuoi Permessi di Accesso ed il Proprietario della Pagina:
      <p>Se il tuo è un account ha determinate restrizioni, alcune colonne potrebbero non essere visibili oppure disabilitate.</p>
    </li>
    <li>Preferenze di Sistema e Configurazione del Sito
      <p>Alcune preferenze di sistema e opzioni di configurazione del sito disabilitano alcune colonne. Ad esempio, la colonna "url"</p>
    </li>
    <li>Il tipo di elemento di contenuto
      <p>A seconda del tipo di elemento di contenuto, alcune colonne potrebbero essere superflue. Ad esempio, non è possibile impostare "Intestazioni di Sezione" o "Separatori" come pagine predefinite, quindi la colonna "default" rimarrà vuota per questi elementi di contenuto.</p>
    </li>
    <li>Se l\'elemento di contenuto è in corso di modifica
      <p>Quando altri utenti <em>(o anche tu stesso)</em> stanno modificando un elemento di contenuto, alcune colonne della riga non saranno visibili per ciascun tipo di contenuto, al fine di evitare la modifica, la cancellazione o la copia della pagina di contenuto.</p>
    </li>
</ul>
<h5>Colonna Elenco</h5>
<p>Il modulo Gestore Contenuto fornisce un meccanismo flessibile per nascondere e mostrare colonne diverse nell\'elenco dei contenuti.  Inoltre, alcune colonne possono essere nascoste in base alla configurazione del sito. Ad esempio, la colonna URL è nascosta se le pretty URLS <em>(Ottimizzate per i Motori di Ricerca)</em> non sono configurate.</p>
<p>Ciascuna colonna dell\'elenco dei contenuti ha una funzione speciale:</p>
   <ul>
     <li>Colonna Espandi/Comprimi
      <p>Quando un elemento di contenuto ha dei figli questa colonna conterrà un\'icona che permette di espandere la l\'elenco per visualizzare gli elementi figlio, o collassare la lista per nasconderli. La visualizzazione o meno di ciascun elemento è memorizzata su base utente. In questo modo, quando ritorni nel gestore contenuto lo stato di espansione/compressione delle tue pagine rimarrà invariato.</p>
     </li>
     <li>Colonna Gerarchia
      <p>La colonna gerarchia mostra in modo numerico la posizione di ogni elemento di contenuto all\'interno della gerarchia. La gerarchia della pagina del primo livello principale inizia con 1 ed aumenta in modo incrementale per ogni sua pari. Ogni figlio inizia con 1, ed i suoi pari aumentano in modo incrementale. Pertanto, il secondo nipote del terzo figlio del primo elemento nell\'elenco dei contenuti avrebbe una gerarchia uguale a 1.3.2.</p>
      <p>Il meccanismo della gerarchia è una parte importante di ciò che permette a CMS Gestore Contenuto di organizzare gli elementi di contenuto, e quindi generare sistemi di navigazioine per essi.</p>
     </li>

     <li>Titolo di Pagina / Colonna Testo Menu
      <p>Questa colonna può visualizzare il titolo della pagina oppure il testo del menu. Ciò dipende da una impostazione presente nella pagina "Amministrazione Sito » Impostazioni Gestore Contenuto".</p>
      <p>Questa colonna conterrà un link per consentire la modifica dell\'elemento di contenuto <em>(se l\'elemento di contenuto non è bloccato)</em>. Il passaggio del mouse su questa colonna mostrerà informazioni aggiuntive sull\'elemento di contenuto come il l\'id numerico univoco, e se la pagina è memorizzabile o meno nella cache.</p>
      <p>Se l\'elemento di contenuto è bloccato, passando con il mouse sul testo nella colonna verrà mostrata l\'informazione sul blocco dell\'elemento, e quando il blocco terminerà.</p>
     </li>

     <li>Colonna URL
      <p>Se abilitata, questa colonna mostrerà ogni URL alternativo per questo elemento di contenuto. <em>(Nota: Solo alcuni tipi di elemento di contenuto sono compatibili con URL alternativi).</em></p>
     </li>

     <li>Colonna Alias di Pagina
      <p>Questa colonna mostra l\'alias univoco associato ad ogni pagina. Gli alias sono stringhe di testo che identificano in modo univoco l\'elemento di contenuto. Si usano gli alias (o gli id numerici) degli elementi di contenuto quando è necessario fare riferimento ad una pagina all\'interno del sistema. <em>(Nota: Alcuni tipi di contenuto non hanno alias).</em></p>
     </li>

     <li>Colonna Template (modelli)
      <p>Questa colonna mostra il design e template utilizzato per visualizzare il contenuto dell\'elemento. Vedi la pagina di aiuto del modulo "Gestore Design" per una spiegazione su come CMSMS gestisce i design, compresi i fogli di stile ed i template. <em>(Nota: Alcuni tipi di elemento di contenuto non usano un design o un template.)</em></p>
     </li>

     <li>Colonna Tipo
       <p>Questa colonna indica il tipo di contenuto (esempio: Contenuto, Intestazione di Sezione, Separatore ecc.).<p>
     </li>

     <li>Colonna Proprietario
       <p>La colonna proprietario mostra il nome utente del proprietario dell\'elemento di contenuto. Passando sul testo di questa colonna verranno mostrate informazioni come la data di creazione e di modifica dell\'elemento di contenuto.</p>
     </li>

     <li>Colonna Attiva
       <p>Questa colonna visualizza delle icone che indicano lo stato attivo dell\'elemento di contenuto. Gli elementi attivi sono accessibili ed appariranno nei menu di navigazione del frontend. Se il tuo account utente ha privilegi sufficienti per l\'elemento di contenuto, puoi cliccare sull\'icona per cambiare il suo stato attivo.</p>
     </li>

     <li>Colonna Predefinito
       <p>Questa colonna mostra se l\'elemento di contenuto è la pagina predefinita o no. L\'elemento di contenuto predefinito è l\'home page del tuo sito web. Solo alcuni tipi di contenuto possono essere impostati come predefinito.</p>
       <p>Se il tuo account utente ha privilegi sufficienti, ed il tipo di contenuto può essere impostato come predefinito per il sito web, puoi cliccare sull\'icona per cambiare il segno predefinito a una pagina differente.</p>
     </li>

     <li>La Colonna "Muovi"
       <p>A seconda dei tuoi privilegi di accesso, potresti vedere delle icone che permettono di cambiare l\'ordine degli elòementi di contenuto rispetto ai loro immediati vicini. Questo è un semplice meccanismo per riordinare velocemente gli elementi di contenuto tra di loro. L\'opzione "Riordina Pagine" consente una riorganizzazione di massa delle pagine, e durante la modifica di un elemento di contenuto puoi velocemente assegnare l\'elemento ad un genitore diverso.</p>
     </li>

     <li>Icone Azione
       <p>A seconda dei tuoi privilegi di accesso, il tipo di contenuto ed il suo stato di blocco corrente, potresti vedere icone diverse in ciascuna riga di contenuto che permettono differenti funzionalità:</p>
       <ul>
         <li>Visualizza - Apre una nuova finestra del browser <em>(o scheda)</em>e visualizza l\'elemento di contenuto così come lo vedranno i tuoi visitatori.</li>
         <li>Copia - Copia l\'elemento di contenuto in un nuovo elemento di contenuto.
           <p>Verrà creato un nuovo elemento di contenuto con un nuovo titolo di pagina e nuovo alias, e avrai la possibilità di modificare la nuova pagina.</p>
         </li>
         <li>Elimina - Elimina l\'elemento di contenuto
           <p>A seconda dei tuoi privilegi di accesso ed al fatto che l\'elemento di contenuto abbia figli o meno, l\'opzione di eliminare l\'elemento di contenuto potrebbe essere nascosta o disabilitata.</p>
         </li>
         <li>Sblocca
           <p>Questa opzione permette di sbloccare quegli elementi di contenuto in corso di modifica il cui blocco è scaduto <em>(l\'editore non ha fatto modifiche al form da un po\' di tempo)</em>.</p>
         </li>
         <li>Checkbox operazioni di massa
           <p>La checkbox operazioni di massa permette di selezionare elementi di contenuto multipli per operarvi in modo massivo.</p>
         </li>
       </ul>
     </li>
   </ul>

 <h4>Capacità di Modifica</h4>
   <p>La possibilità di modificare un elemento di contenuto è determinata dai permessi <em> (vedi sotto i permessi Gestisci Tutto il Contenuto e Modifica Ogni Pagina)</em>, oppure dall\'essere il proprietario o l\'editore aggiunto di un elemento di contenuto.</p>

 <h4>Proprietari</h4>
   <p>Per impostazione predefinita, il proprietario di un elemento di contenuto è l\'utente che lo ha creato all\'inizio. I proprietari, o gli utenti con il permesso "Gestisci Tutto il Contenuto" possono attribuire la proprietà di una pagina ad un altro utente.</p>

 <h4>Additional Editors</h4>
    <p>When editing a content item as an owner or as a user with "Manage All Content" permission, the user can select other administrative users, or Admin groups that are also allowed to edit that content item.</p>

 <h4>Relevant Permissions.</h4>
    <p>There are a few permissions that effect what columns are displayed in the content list and the ability to interact with the content list:</p>
    <ul>
      <li>Add Pages
    <p>This permission allows users to create new content items. Additionally, users with this permission are able to copy content items that they have edit ability on.</p>
      </li>
      <li>Modify Any Page
        <p>Users with this position will have the ability to edit any content item.  It is similar to being an "Additional Editor" on all content items.</p>
      </li>
      <li>Remove Pages
        <p>This permission allows users to remove content items that they have edit ability on.  Without this permission, the delete icon on each content item row in the content list will be hidden.</p>
      </li>
      <li>Reorder Pages
        <p>This permission allows users who have edit ability to all siblings of a content item to re-arrange content items amongst their peers.</p>
        <p>i.e: A user in a group who has edit ability to the content item with hierarchy 1.3 and all of its direct siblings <em>(1.1, 1.2, 1.3, 1.4, etc).</em> will be able to re-arrange those items in the navigation.  Users without this permission will not see the move up/down icons in listcontent.</p>
      </li>
      <li>Manage All Content
        <p>This permission provides super-user capability on all content items.  Users with this permission can add, edit, delete, and re-order any content item.  They also have the ability to set the default content item, and perform bulk actions like change ownership that may or may not be available to users with other permissions.</p>
      </li>
    </ul>
   <p>It is possible for an Admin user account to not be a member of any groups, and for that Admin user account still have the ability <em>(as an owner or additional editor)</p> to edit some content items.</p>

 <h4>Content Locking</h4>
   <p>Content locking is a mechanism that prevents two editors from editing the same item at the same time, and therefore destroying each others work.  Admin users are given exclusive access to a content item until such time as they submit the changes.</p>
   <p>If a content item is locked, you will not be able to edit it until the lock has expired.  See below for information on lock expiring.  Once a lock has expired, a user will have the option of stealing the lock from the original editor and beginning a new edit session.</p>
   <p>A special icon is displayed on the content item row to indicate that the lock can be stolen.</p>

 <h4>Configuration</h4>
   <p>Some configuration items effect the visibility of certain items in the content list:</p>

 <h4>Other functionality</h4>
   <ul>
     <li>Pagination
       <p>The content list can be paginated.  This is a performance feature for large sites with a great deal of content items.  The default limit is 500 items, however this limit can be lowered by adjusting the value in the options dialogue.</p>
     </li>
     <li>Expand/Collapse All
       <p>These options allow expanding all content items with children so that the children are visible.  Or, conversely collapsing all content items with children so that the children are not visible.  It is useful to easily find a content item, or to get an overview of the website structure.  Each content item with children can still be expanded, or collapsed individually.</p>
     </li>
     <li>Searching
       <p>The "Find" textbox in the top left corner of the content list allows users to quickly and easily find a content item by its title, or menu text.  This form uses ajax and autocomplete to display a dropdown list of all items matching the string entered (a minimum of three characters is required).</p>
     </li>
     <li>Bulk Actions
       <p>The "With Selected" form at the bottom right of the content list allows users with appropriate access to modify, or interact with content items en-masse.  Numerous options are available (depending both on the selected items, and the users access permission):</p>
       <ul>
         <li>Delete
           <p>This option allows deleting multiple content items (and their children) in few steps.  All of the selected content items and their descendants will be analysed for the their eligibility to be deleted.  Users will then be prompted with a list of the content items that passed the analysis <em>(if any)</em> and to confirm the action.</p>
	   <p>Only users with the permission to remove pages and modify any page, or Manage All Content can use this option.</p>
           <p><strong>Note:</strong> When selecting many content items, or content items with many descendants, this can be a very memory, database and time intensive operation.</p>
         </li>
         <li>Set Active
           <p>This option will ensure that the content items selected are marked as "Active".  Users will be asked to confirm the operation. This operation does not work on descendent of the selected pages.</p>
	   <p>Only users with the "Manage All Content" permission can use this option.</p>
         </li>
         <li>Set Inactive
           <p>this option analyses the selected items for eligibility, and will set all of the eligible content items to inactive.  Inactive pages cannot be navigated to, and may break a working website.  The default page cannot be set to inactive.</p>
	   <p>Only users with the "Manage All Content" permission can use this option.</p>
         </li>
         <li>Set Cachable
           <p>This option sets the selected content items to &quoc;cachable".  This may have different effects based on the site configuration:<p>
           <p>If enabled in "Site Admin >> Global Settings" then content items marked as "cachable" can be cached by the browser <em>(this reduces load on your webserver for users visiting the same page frequently).</em>
           <p>Also in "Site Admin >> Global Settings" Smarty caching effects cachable pages.  This is an advanced tool that will cache the generated html code of a for repeated use, and can dramatically reduce server load and improve performance.  However, it is an advanced topic and may negatively the dynamic nature of some content items.</p>
	   <p>Only users with the "Manage All Content" permission can use this option.</p>
         </li>
         <li>Set Not Cachable
           <p>This option ensures that the selected content items are not cachable.<p>
         </li>
         <li>Show In Menu
           <p>This option ensures that the selected content items are visible in frontend navigation menus.</p>
	   <p>Only users with the "Manage All Content" permission can use this option.</p>
         </li>
         <li>Hide From Menu
           <p>This option ensures that the selected content items will not be visible (by default) in frontend navigation menus.  Various options of navigation generation modules may override the "Show In Menu" setting.</p>
	   <p>Only users with the "Manage All Content" permission can use this option.</p>
         </li>
         <li>Set Secure (HTTPS)
           <p>This option will ensure that HTTPS will be used when the selected content items are displayed.</p>
           <p><strong>Note:</strong> You may need to adjust the secure URL settings in the CMSMS config.php file, and to contact your host about proper SSL configuration.</p>
	   <p>Only users with the "Manage All Content" permission can use this option.</p>
         </li>
         <li>Set Insecure (HTTP)
           <p>This option removes the HTTPS flag from the selected content items.</p>
           <p><strong>Note:</strong> Content items without the secure <em>(HTTPS)</em> may still be accessed via the HTTPS protocol.</p>
	   <p>Only users with the "Manage All Content" permission can use this option.</p>
         </li>
         <li>Set Design & Template
           <p>This option will display a form to set the design and template that are associated with the selected content items.  Only some content item types have a design and template association. i.e: the "content" item type, and those provided by other modules that provide similar functionality.</p>
	   <p>Only users with the "Manage All Content" permission can use this option.</p>
         </li>
         <li>Set Owner
           <p>This option displays a form that allows changing the ownership of the selected content items.</p>
	   <p>Only users with the "Manage All Content" permission can use this option.</p>
         </li>
       </ul>
     </li>
     <li>Reordering
       <p>Users with the "Manage All Content" permission have the ability to re-organize content items en-masse by selecting the "Reorder Pages" item from the options menu on the content list display.   This provides a form where content items can be re-ordered with simple drag and drop operations.</p>
       <p><strong>Note:</strong> This can be a very memory and database intensive operation, and we do not suggest using this option on websites with more than a few hundred content items.</p>
     </li>
   </ul>

<h3>Adding and Editing Content Items</h3>
 <p>The ability to add content items depends on having either the "Manage All Content" permission, or the "Add Pages" permission.  Users with "Manage All Content"  permission will be able to manage all aspects  of the content item.  Users without this permission will have considerably less abilities.</p>
 <p>The add (or edit) content page form is divided into numerous tabs; numerous properties of the content item will appear on different tabs.  The list of tabs that are visible, and the "properties" on those tabs is influenced by numerous factors:</p>
   <ul>
     <li>The content item type
 <p>Some content item types (such as separators, and section headers) do not require much information, therefore very few tabs and properties will be displayed.</p>
     </li>
     <li>Your permission level
       <p>If your user account does not have the "Manage All Content" permission level, then you are only permitted to manage <em>(by default)</em> the basic properties of the content item.  Enough to edit content, and pick a page in its navigation.  You may also be restricted as to where new content items can be placed in the content hierarchy.</p>
     </li>
     <li>Site settings <em>(i.e.: the "Basic Properties" field in the "Global Settings" window, and others)</em>.
       <p>Some site settings <em>(and even config settings)</em> can influence what properties are displayed on what tab.  The "Basic Properties" setting in the "Site Admin >> Global Settings" page extends the list of content item properties that users with restricted permissions can edit.</p>
     </li>
     <li>The template that has been selected.
       <p>Tags in templates define additional properties <em>(called content blocks)</em> that authorized users can edit when editing a content item that uses that templates.   These content blocks can be plain text areas, WYSIWYG test areas, image selectors, or other items.  Template developers can specify the tab that the edit field for each content block appears on.</p>
     </li>
   </ul>
  <h4>Properties</h4>
    <p>Here we will briefly describe the common properties for the "Content" content item type.  Some content item types use significantly fewer properties, and some content item types supplied by third party modules may behave completely differently.</p>
  <ul>
    <li>Title
      <p>This field describes the title for the content item (if applicable).  The title is usually displayed in the <title> tag in the HTML page head, and somewhere in a prominent place in the HTML page content.  The site developer has complete control over how this data is used or displayed.</p>
    </li>

    <li>Alias
      <p>The page alias is a string that uniquely identifies this content item, and is usually easier to remember than the integer page id.  The alias is used in numerous locations when building CMSMS website.  It can be used to create links to content items, to build specialized navigations, or as behavioural hints to other modules indicating on what content item they should display data.</p>
      <p>By default the page alias is uniquely generated from the title when adding a new content item, however users can specify their own page alias when adding or editing the content item so long as it is unique amongst all other content items.  Some content item types do not require a page alias.</p>
      <p>Users with restricted permissions may not have the ability to specify the alias when adding or editing a content item.</p>
    </li>

    <li>Parent
      <p>The parent property specifies the content item that is the immediate parent of the content item being edited in the content hierarchy.  Users with restricted permissions may not have the ability to edit this property, or may have a restricted list of options for this property.</p>
    </li>

    <li>Content
      <p>Each page template is required to include at least the default content property <em>(a.k.a block)</em>.  However they can define many more, and different types of content blocks.  The default block usually appears in the edit content form as a wWYSIWYG enabled text area allowing the editor to specify some default content for the page.</p>
      <p>Site developers have significant control over the tab that this is displayed in, the label, maxlength, required, and other attributes to control the behaviour of this property in the edit form, and when it is displayed.</p>
      <p>If the WYSIWYG editor is enabled for this content block and content item <em>(see below)</em>, and one or more WYSIWYG editor modules are enabled, and the user has selected a WYSIWYG editor in his preferences then a WYSIWYG editor will be displayed.  Different WYSIWYG editors have different abilities, but most provide the ability to format text in different ways.  Additionally, most WYSIWYG editors allow inserting images and creating links to other content items in your website.</p>
    </li>

    <li>Menu Text
      <p>This property is used when building navigations.  The contents of this field are used as the text to display for this content item in the navigation.</p>
    </li>

    <li>Show in Menu
      <p>Often, it is useful to have content items for special purposes (such as to display sitemaps, search results, login forms, etc.) that are not displayed <em>(by default)</em> in navigation menus.  This property allows each content item to be hidden from navigation items unless overridden elsewhere.</p>
      <p>Users with restricted permissions may not have the ability to adjust or specify this property.</p>
    </li>

    <li>Title Attribute
      <p>This property defines an optional text string that can be used to display additional information for the content item in the navigation.  It is typically used in the "title" attribute for the link that is generated in navigation menus.</p>
      <p>The site developer has the ability to display this data differently, or ignore it completely by modifying the appropriate navigation menu template.  Additionally, this data can be displayed in the page content by modifying the appropriate page template.  This property may not be important for content items in your website.</p>
      <p>Users with restricted permissions may not have the ability to adjust or specify this property.</p>
    </li>

    <li>Access Key
      <p>This property defines an optional access key character <em>usually only one or two characters</em> that can be used in navigation menus to quickly access this content item in the navigation.  This is a useful feature when building accessible navigations.</p>
      <p>The site developer has complete ability to include, or exclude the use of this property in his navigation templates.  And it may not be required for your website.</p>
      <p>Users with restricted permissions may not have the ability to adjust or specify this property.</p>
    </li>

    <li>Tab Index
      <p>This property is used to specify an integer index to aide in navigation to this content item in menus.  It is useful when creating accessible websites.</p>
      <p>The site developer has complete ability to include, or exclude the use of this property in his navigation templates.  And it may not be required for your website.</p>
      <p>Users with restricted permissions may not have the ability to adjust or specify this property.</p>
    </li>

    <li>Target
      <p>This property is used to specify the "target" attribute in links to content items.  It allows creating navigations that can open content pages in different browser windows or tabs.</p>
      <p>The site developer has complete ability to include, or exclude the use of this property in his navigation templates.  And it may not be required for your website.</p>
      <p>Users with restricted permissions may not have the ability to adjust or specify this property.</p>
    </li>

    <li>Url
      <p>This property is used to specify a primary URL to this content item. Users can specify a complete path or a simple flat string.  <em>(i.e.: path/to/mypage or keywordstuffedpageurl)</em>.  This property (if specified) is used when building navigations and other links to this content item, when "pretty urls" are enabled in the config.php.  If not specified, then the page alias and other settings control the primary route to the content item.</p>
      <p>It is important to note for SEO purposes that this is only a primary URL <em>(route)</em> to the content items.  Site visitors can still navigate to this content item via other means, i.e:  mysite.com/index.php?page=alias or mysite.com/random/random/alias or mysite.com/alias.  Sites that are concerned with search engine rankings should ensure that the <link rel="canonical"> tag is properly configured in their page templates.</p>
      <p>Users with restricted permissions may not have the ability to adjust or specify this property.</p>
    </li>

    <li>Active <em>(i.e: disabled)</em>
      <p>This property is used to indicate whether this content item can be navigated to at all.</p>
      <p>Users with restricted permissions may not have the ability to adjust or specify this property.</p>
    </li>

    <li>Secure (HTTPS)
	<p>This property is used to indicate whether this content item should be accessed using the HTTPS protocol.  In a site configured properly for HTTPS, if this attribute is set for a content item, and an attempt is made to access this page via the insecure HTTP protocol, the user will be redirected to the same page using the more secure HTTPS protocol.  Additionally, if this flag is set then any links to this content item will specify the HTTPS protocol.</p>
        <p>It is important to know that content items without the secure flag set can still be navigated to using the HTTPS protocol, and no redirection will take place.  Therefore, for search engine ranking purposes the canonical link should be configured properly in each page template.</p>
    </li>

    <li>Cachable
	<p>This property specifies whether the compiled form of this content item can be cached on the server to reduce server load <em>(if smarty caching is enabled in global settings)</em> AND whether the browser can cache this page <em>(if browser caching is enabled in global settings)</em>.  For largely static websites enabling smarty caching and browser caching can significantly reduce server load and improve overall website performance.</p>
        <p>Users with restricted permissions may not have the ability to adjust or specify this property.</p>
    </li>

    <li>Image
	<p>This property allows associating a previously uploaded image with your this content item.  Editors can select an image file from the uploads/images directory.  This image may be displayed on the generated HTML page (if applicable), or used when building the navigation.</p>
        <p>Users with restricted permissions may not have the ability to adjust or specify this property.</p>
    </li>

    <li>Thumbnail
        <p>This property allows associating a previously created thumbnail image with this content item.  Editors can select a thumbnail file from the uploads/images directory.  This thumbnail may be displayed on the generated HTMLO page, or used when building the navigation.</p>
        <p>Users with restricted permissions may not have the ability to adjust or specify this property.</p>
    </li>

    <li>Owner
        <p>The owner property is a dropdown field that indicates which admin user account has primary responsibility for the content item.  By default the owner of the content item is the user who first created it.  Users with significant permission can assign the ownership of an item to another user.</p>
    </li>

    <li>Additional Editors
        <p>This property specifies a list of other admin users or admin groups that are allowed to edit this content item.  It is implemented as a multi-select field.  Again, users with restricted permissions may not have the ability to adjust this property.</p>
    </li>

    <li>Design
        <p>The property allows associating a design with the content item.  A design is used to determine the stylesheets and other items that contribute to the appearance of content items.  The design is associated with different templates.  Changing the design property may result in the template property automatically changing.  By default the "default design" selected in the Design Manager is selected here.  Some restricted editors may not have the ability to adjust this property.</p>
    </li>

    <li>Template
        <p>The page template property is used to determine the overall layout of the content item (for those content items that generate HTML).  It also determines the use of meta tags and content blocks.  Changing this template will refresh the page and display the appropriate content properties (blocks) that are specified  in the newly selected template.</p>
        <p>Users with restricted permissions may not have the ability to adjust or specify this property.</p>
    </li>

    <li>Searchable
        <p>This property controls whether the content properties on this content item can be indexed by the search module.</p>
        <p>Users with restricted permissions may not have the ability to adjust or specify this property.</p>
    </li>

    <li>Disable WYSIWYG
        <p>This property will disable the WYSIWYG editor for all content blocks on this content item.  This overrides all settings on the content blocks, and any user setting.  This is useful for content items that contain pure logic in the content blocks, or strictly call other modules.  This prevents the logic or output from the modules from being effected by the styling injected by the WYSIWYG.</p>
        <p>Users with restricted permissions may not have the ability to adjust or specify this property.</p>
    </li>

    <li>Page Metadata
        <p>The primary purpose of this property is for injecting meta properties into the <head> section of the rendered HTML page.  Typically it is useful for injecting a meta description tag.</p>
        <p>Users with restricted permissions may not have the ability to adjust or specify this property.</p>
    </li>

    <li>Page Data
        <p>This property is primarily used for inserting data, or logic into the smarty process for use by the page template.  It is an advanced field for usage in flexible layouts that change their behaviour dynamically.</p>
        <p>Users with restricted permissions may not have the ability to adjust or specify this property.</p>
    </li>

    <li>extra1, extra2, and extra3</li>
        <p>Additional properties for use in either displaying data, or influencing the behaviour of the page template.</p>
    </li>
  </ul>';
?>