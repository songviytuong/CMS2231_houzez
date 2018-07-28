<?php
$lang['friendlyname'] = 'Kreator CMS MS navigacionog menija';
$lang['help'] = '<h3>&Scaron;ta ovo radi?</h3>
  <p>&amp;quot;Nav&amp;quot; modul je mehanzam za kreiranje navigacionih menija na osnovu CMSMS stabla sadržaja i smarty &scaron;ablona.  Ovaj modul pruža fleksibilne mogućnosti za filtriranje, kako bi omogućio kreiranje brojnih navigacionih menija na osnovu različitih kriterijuma, i hijerarhijski format podataka koji se jednostavno koristi za kreiranje potpuno prilagodljivih navigacionih menija.</p>
  <p>Ovaj modul nema sopstveni administratorski interfejs, već koristi DizajnMenadžer za upravljanje &scaron;ablonima menija.</p>
<h3>Kako se koristi?</h3>
<p>Najprostiji način upotrebe ovog modula je umetanje <code>{Navigator}</code> taga u &Scaron;ablon.  Modul prihvata brojne parametre kojim se menja njegovo pona&scaron;anje i filtriraju podaci.</p>
<h3>&Scaron;to se mene tiču &Scaron;abloni?</h3>
<p>U tome leži moć CMSMS-a.  Navigacioni meniji mogu biti kreirani automatski, na osnovu hijerarhijskog rasporeda Va&scaron;eg sadržaja i smarty &scaron;ablona.  Nema potrebe da menjate navigacioni meni svaki put kada dodate ili obri&scaron;ete stranicu sa sajta.  Uz to, navigacioni &scaron;abloni lako mogu uključivati JavaScript ili napredne mogućnosti i mogu biti deljeni između sajtova.</p>
<p>Ovaj modul isporučuje se sa nekoliko jednostavnih &scaron;ablona, oni su tu samo kao primer.  Imate slobodu i na&scaron;u toplu preporuku da ih kopirate i prilagodite sopstvenim potrebama.  Vizuelni deo navigacionog menija određuje se u CMSMS Stilu.  Stilovi takođe nisu deo ovog modula (pogledajte DizajnMenadžer).</p>
<h3>Stavka menija:</h3>
  <p>Svaki navigacioni &scaron;ablon dobija od CMS MS sistema niz stavki menija (stranica) koje zadovoljavaju kriterijume određene u <code>{Navigator}</code> tagu. Sledi opis sastavnih delova jedne stavke menija:</p>
<ul>
  <li>$node->id -- Brojčana ID oznaka stavke sadržaja (t.j. stranice).</li>
  <li>$node->url -- URL do stavke sadržaja.  Ovo treba koristiti prilikom kreiranja linkova.</li>
  <li>$node->accesskey -- Pristupni taster, ako je određen.</li>
  <li>$node->tabindex -- Tab indeks, ako je određen.</li>
  <li>$node->titleattribute -- Opis, ili atribit Naslov, ako je određen.</li>
  <li>$node->hierarchy -- Hijerarhijska pozicija.  (npr. 1.3.3)</li>
  <li>$node->default -- TRUE if this node refers to the default content object.</li>
  <li>$node->menutext -- Menu Text</li>
  <li>$node->raw_menutext -- Menu Text without having html entities converted</li>
  <li>$node->alias -- Page alias</li>
  <li>$node->extra1 -- This field contains the value of the extra1 page property, unless the loadprops-parameter is set to NOT load the properties.</li>
  <li>$node->extra2 -- This field contains the value of the extra2 page property, unless the loadprops-parameter is set to NOT load the properties.</li>
  <li>$node->extra3 -- This field contains the value of the extra3 page property, unless the loadprops-parameter is set to NOT load the properties.</li>
  <li>$node->image -- This field contains the value of the image page property (if non empty), unless the loadprops-parameter is set to NOT load the properties.</li>
  <li>$node->thumbnail -- This field contains the value of the thumbnail page property (if non empty), unless the loadprops-parameter is set to NOT load the properties.</li>
  <li>$node->target -- This field contains Target for the link (if non empty), unless the loadprops-parameter is set to NOT load the properties.</li>
  <li>$node->created -- Item creation date</li>
  <li>$node->modified -- Item modified date</li>
  <li>$node->parent -- TRUE if this node is a parent of the currently selected page</li>
  <li>$node->current -- TRUE if this node is the currently selected page</li>
  <li>$node->has_children -- TRUE if this node has any children at all.</li>
  <li>$node->children -- An array of node objects representing the displayable children of this node. Not set if node does not have children to display.</li>
</ul>';
$lang['help_collapse'] = 'Ukoliko je uključena ova opcija, biće prikazane samo stavke koje su direktno povezane sa trenutno aktivnom stranicom';
$lang['help_childrenof'] = 'Ova opcija učiniće da budu prikazane samo stavke koje su potomci stranice sa izabranom ID oznakom ili pseudonimom. Npr. <code>{menu childrenof=$page_alias}</code> će prikazati samo potomke trenutno aktivne stranice.';
$lang['help_excludeprefix'] = 'Isključi sve stranice (i njihove potomke) čiji pseudonim se poklapa sa nekim od ovih (lista vrednosti, odvojene zarezima) prefiksa. Ovaj parametar ne sme se koristiti istovremeno sa parametrom <code>includeprefix</code>.';
$lang['help_includeprefix'] = 'Uključi samo one stranice čiji pseudonim se poklapa sa nekim od ovih (lista vrednosti, odvojene zarezima) prefiksa. Ovaj parametar ne može se koristiti istovremeno sa parametrom <code>excludeprefix</code>.';
$lang['help_items'] = 'Upi&scaron;ite listu pseudonima (razdvojenih zarezom) onih stranica koje treba prikazati u meniju.';
$lang['help_nlevels'] = 'Pseudonim za number_of_levels';
$lang['help_number_of_levels'] = 'Ovo pode&scaron;avanje će ograničiti dubinu menija na određeni broj nivoa. Podrazumevana vrednost ovog parametra je &#039;neograničeno&#039;, osim kada se koristi parametar items, kada je vrednost number_of_levels parametera implicitno postavljena na 1';
$lang['help_show_all'] = 'Ova opcija učiniće da se u meniju prikažu sve stranice, čak i one za koje je pode&scaron;eno da se ne prikazuju u meniju. Međutim, neaktivne stranice ipak neće biti prikazane.';
$lang['help_show_root_siblings'] = 'Ova opcija postaje korisna samo ako su upotrebljeni parametri start_element ili start_page. U su&scaron;tini, prikazaće uporedo sve srodnike izabranog start_element/page.';
$lang['help_start_element'] = 'Započinje prikazivanje menija od zadatog start_element i prikazuje samo taj elemenat i njegove potomke. Kao vrednost prima hijerarhijsku poziciju (npr. 5.1.2).';
$lang['help_start_page'] = 'Započinje prikazivanje menija od zadate start_page i prikazuje samo taj elemenat i njegove potomke. Kao vrednost prima pseudonim stranice.';
$lang['help_template'] = '&Scaron;ablon koji se koristi za prikazivanje menija. Imenovani &scaron;ablon mora postojati u DesignManager-u ili će doći do gre&scaron;ke. Ukoliko ovaj parametar nije određen, biće kori&scaron;ćen podrazumevani &scaron;ablon tipa Navigator::Navigation';
$lang['type_breadcrumbs'] = 'Putanja';
$lang['type_Navigator'] = 'Navigator';
$lang['type_navigation'] = 'Navigacija';
$lang['youarehere'] = 'Nalazite se ovde';
$lang['utma'] = '156861353.114482514.1383506026.1383686623.1383983278.5';
$lang['utmz'] = '156861353.1383506026.1.1.utmcsr=(direct)|utmccn=(direct)|utmcmd=(none)';
$lang['utmb'] = '156861353';
$lang['utmc'] = '156861353';
?>