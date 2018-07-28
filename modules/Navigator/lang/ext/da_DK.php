<?php
$lang['description'] = 'Med dette modul har man en simpel og let metode til at danne den HTML, som er nødvendig i forbindelse med hjemmesidens navigation direkte og dynamisk inde fra CMSMS\' sidestruktur. Modulet giver adgang til fleksibel filtrering og med skabeloner, kan man bygge robuste, hurtige og attraktive navigationer til hjemmesiden, uden at redaktøren af indholdet behøver at blive involveret.';
$lang['friendlyname'] = 'Opbygning af CMSMS navigation';
$lang['help'] = '<h3>Hvad er dette?</h3>
  <p>"Navigator" modulet er en maskine, som danner navigationer ud fra CMSMS\'s indholdstræ samt en smarty skabelon. Modulet giver mulighed for fleksibel filtrering, så man kan opbygge utallige navigationer baseret på forskellige kriterier samt et brugervenligt hierarkisk dataformat, hvormed man kan danne menuer, der er 100% fleksible.</p>
  <p>Modulet har ikke sin egen administrationsbrugerflade, men anvender i stedet DesignManager til håndtering af menuskabeloner.</p>
<h3>Hvordan bruger jeg det?</h3>
<p>Dette modul anvendes lettest ved at indsætte koden <code>{Navigator}</code> i en skabelon.  Modulet godtager et væld af parametre, som påvirker dets opførsel og filtrerer data.</p>
<h3>Hvorfor skal jeg forholde mig til skabeloner?</h3>
<p>I skabelonerne ligger hele styrken ved CMSMS.  Navigationer kan opbygges automatisk ved at benytte data fra dit hierarki af indhold samt en smarty skabelon. Det er ikke nødvendigt at redigere navigationsobjekter, hver gang en indholdsside tilføjes eller fjernes fra systemet.  Desuden kan navigationsskabeloner sagtens indeholde JavaScript eller avanceret funktionalitet og skabelonerne kan bruges på flere hjemmesider.</p>
<p>Med dette modul følger nogle få simple skabeloner - de er blot eksempler. Det står dig frit for - og du opfordres til - at kopiere og redigere skabelonerne, helt som du lyster. Styling af navigationen foretages ved at redigere et CMSMS typografiark.  Typografiark følger ikke med Navigator modulet.</p>
<h3>Knudeobjektet (node):</h3>
  <p>Hver navigationsskabelon fodres med en liste af knudeobjekter, som svarer til de kriterier, der angives i tagget. Herunder følger en beskrivelse af medlemmerne af knudeopbjektet:</p>
<ul>
  <li>$node->id -- Indholdsobjektets ID (et heltal).</li>
  <li>$node->url -- URL til indholdsobjektet. Dette bør anvendes ved opbygning af henvisninger eller links.</li>
  <li>$node->accesskey -- Genvejstast, i fald en sådan er blevet defineret.</li>
  <li>$node->tabindex -- Det menupunkt, som aktiveres næste gang brugeren trykker på tasten Tab, hvis dette er defineret.</li>
  <li>$node->titleattribute -- Beskrivelses -eller titelattribut (title), hvis defineret.</li>
  <li>$node->hierarchy -- Position i hierarkiet  (f.eks. 1.3.3).</li>
  <li>$node->default -- TRUE, altså SAND, hvis dette knudepunkt henviser til standard startobjektet.</li>
  <li>$node->menutext -- Menutekst</li>
  <li>$node->raw_menutext -- Menutekst uden konvertering af html entities</li>
  <li>$node->alias -- Sidealias</li>
  <li>$node->extra1 -- Værdien af sideegenskaben extra1, med mindre loadprops-parameter er sat til IKKE at indlæse egenskaberne.</li>
  <li>$node->extra2 -- Værdien af sideegenskaben extra2, med mindre loadprops-parameter er sat til IKKE at indlæse egenskaberne.</li>
  <li>$node->extra3 -- Værdien af sideegenskaben extra3, med mindre loadprops-parameter er sat til IKKE at indlæse egenskaberne.</li>
  <li>$node->image -- Værdien af sideegenskaben image (hvis feltet ikke er blankt), med mindre loadprops-parameter er sat til IKKE at indlæse egenskaberne.</li>
  <li>$node->thumbnail -- Værdien af sideegenskaben thumbnail (hvis feltet ikke er blankt), med mindre loadprops-parameter er sat til IKKE at indlæse egenskaberne.</li>
  <li>$node->target -- Værdien af sideegenskaben Target for linket (hvis feltet ikke er blankt), med mindre loadprops-parameter er sat til IKKE at indlæse egenskaberne.</li>
  <li>$node->created -- Emnets oprettelsesdato</li>
  <li>$node->modified -- Dato for emnets seneste redigering</li>
  <li>$node->parent -- TRUE, altså SAND hvis dette knudepunkt er overordnet eller "forælder" til den side, der p.t. er aktiv.</li>
  <li>$node->current -- TRUE, altså SAND hvis dette knudepunkt er den side, der p.t. er valgt.</li>
  <li>$node->has_children -- TRUE, altså SAND hvis dette knudepunkt overhovedet har nogen "børn" eller underpunkter.</li>
  <li>$node->children -- En liste over de underpunkter eller "børn", der tilhører dette knudepunkt og som skal vises i menuen. Anvendes ikke, hvis punktet ikke har underpunkter, som kan vises.</li>
  <li>$node->children_exist -- TRUE, altså SAND hvis dette knudepunkt har underpunkter, som kunne blive vist, men som ikke bliver det grundet andre indstillinger for filtrering (number of levels, etc).</li>
</ul>
<h3>Eksempler:</h3>
<ul>
   <li>En simpel navigation alene bestående af 2 niveauer og med anvendelse af standardskabelonen:<br/>
     <pre><code>{Navigator number_of_levels=2}</code></pre>
   </li>
     <li>Vis en simpel navigation, som er to niveauer dyb og begynd med den aktuelle sides underpunkter. Brug standardskabelonen:</li>
     <pre><code>{Navigator number_of_levels=2 start_page=$page_alias}</code></pre>
   </li>
   <li>Vis en simpel navigation, som er to niveauer dyb og begynd med den aktuelle sides underpunkter. Brug standardskabelonen:</li>
     <pre><code>{Navigator number_of_levels=2 childrenof=$page_alias}</code></pre>
   </li>
   <li>Vis en simpel navigation, som er to niveauer dyb og begynd med den aktuelle side, sider på samme niveau og alt under disse.  Brug standardskabelonen:</li>
     <pre><code>{Navigator number_of_levels=2 start_page=$page_alias show_root_siblings=1}</code></pre>
   </li>
   <li>Vis en navigation bestående af de angivne menupunkter og disse underpunkter. Brug skabelonen med navnet minmenu</li>
     <pre><code>{Navigator items=\'alias1,alias2,alias3\' number_of_levels=3 template=minmenu}</code></pre>
   </li>
</ul>';
$lang['help_action'] = 'Angiv hvilken handling modulet skal udføre. Modulet understøtter to handlinger:
<ul>
<li><em>default</em> - Bruges til at bygge en pimær navigation  (denne handling er underforstået og anvendes, hvis intet andet er angivet).</li>
<li><em>breadcrumbs</em> - Bruges til at bygge en mini navigation bestående af stien fra hjemmesidens rod ned til den aktuelle side.</li>
</ul>';
$lang['help_collapse'] = 'Aktivering af denne indstilling medfører, at kun menupunkter, som er i direkte familie med den aktuelle side, vil blive taget med';
$lang['help_childrenof'] = 'Med denne indstilling viser menuen kun de punkter, som er "efterkommere" af det valgte side-id eller aias. Altså: Koden <code>{menu childrenof=$page_alias}</code> resulterer i, at det kun er "børn" af den aktuelle side, som bliver vist.';
$lang['help_excludeprefix'] = 'Udelad alle punkter hvis sidealias svarer til de angivne (kommaseparerede) præfikser. Dette parameter må ikke benyttes sammen med parameteret includeprefix.';
$lang['help_includeprefix'] = 'Medtag kun de punkter hvis sidealias svarer til de angivne (kommaseparerede) præfikser. Dette parameter kan ikke kombineres med parameteret excludeprefix.';
$lang['help_items'] = 'Angiv en kommasepareret liste over sidealiasser, som denne menu skal vise.';
$lang['help_loadprops'] = 'Anvend dette parameter når du IKKE gør brug af avancerede egenskaber i din menu manager skabelon. Indstillingen forhindrer indlæsning af alle de egenskaber for indholdet, som er knyttet til hvert menupunkt (såsom extra1, image, thumbnail, etc.). Herved reduceres antallet af de forespørgsler, som er nødvendige, når menuen skal bygges, meget betragteligt, hvilket øger kravene til hukommelsen. Til gengæld er der ikke muligt at bygge mere avancerede menuer.';
$lang['help_nlevels'] = 'Alias for number_of_levels';
$lang['help_number_of_levels'] = 'Med denne indstilling begrænses dybden af den menu, som dannes, til det angivne antal niveauer. Som udgangspunkt antages værdien for dette parameter at være ubegrænset med mindre parameteret items tages i brug. I så tilfælde antages parameteret number_of_levels at være lig med 1';
$lang['help_root2'] = 'Kun brugbar i forbindelse med brødkrummer ("breadcrumbs"), hvor dette parameter angiver, at brødkrummerne ikke skal gå højere op i sidens træ, end det angivne side alias. Angives et negativt heltal medfører det, at kun brødkummer op til topniveauet vises, mens standardsiden ignoeres.';
$lang['help_show_all'] = 'Denne option medfører, at menuen viser alle punkter, selvom de er indstillet til ikke at blive vist i menuen. Optionen medtager dog fortsat ikke inaktive sider.';
$lang['help_show_root_siblings'] = 'Denne option er kun nyttig i forbindelse med anvendelse af parameteret start_element eller start_page. Optionen viser i bund og grund menupunktets "søskende" sammen med den/det valgte start-page/element.';
$lang['help_start_element'] = 'Menuen vil begynde ved det angivne start_element og kun dette element og dets underpunkter vil blive vist. Der skal angives en hierarki-position (f.eks. 5.1.2).';
$lang['help_start_level'] = 'Med denne indstilling medtager menuen kun de punkter, som begynder på det angivne niveau relativt til den aktuelle side. Et let eksempel kunne være, hvis du har en menu på siden med number_of_levels=1. Menu nr. 2 vil så have start_level=2. Menu nr. 2 vil nu vise punkter baseret på det, der blev klikket på i den første menu. Minimumsværdien for dette parameter er 2';
$lang['help_start_page'] = 'Menuen vil begynde ved den angivne start_page og viser kun dette element og dets underpunkter. Der skal angives et sidealias.';
$lang['help_template'] = 'Den skabelon som skal bruges ved visning af menuen. Den navngivne skabelon skal forefindes i DesignManager, ellers vil der blive vist en fejlmeddelelse. Hvis dette parameter ikke er angivet, bruges standardskabelonen for typen Navigator::Navigation';
$lang['help_start_text'] = 'Kun brugbar i forbindelse med brødkrummer, hvor dette parameter gør det muligt at angive en tekst, som bliver vist i begyndelsen af brødkrumme-navigationen. Et eksempel kunne være "Her er du!"';
$lang['type_breadcrumbs'] = 'Brødkrummer';
$lang['type_Navigator'] = 'Navigatør';
$lang['type_navigation'] = 'Navigation';
$lang['youarehere'] = 'Her er du!';
?>