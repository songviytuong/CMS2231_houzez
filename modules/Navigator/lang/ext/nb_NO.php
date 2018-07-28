<?php
$lang['description'] = 'Denne modulen gir en enkel og lett måte å generere HTML som er nødvendig for et nettsteds navigasjon direkte, og dynamisk fra CMSMS sidestrukturen. Det tilbyr fleksibel filtrering, og malevne for å bygge kraftige, raske, og tiltalende nettside navigasjoner uten interaksjon fra innholdsredigererene.';
$lang['friendlyname'] = 'CMSMS Navigasjonsbygger';
$lang['help_action'] = 'Angi handlingen av modulen. Denne modulen støtter to handlinger:
<ul>
   <li><em>standard</em> - Brukes for å bygge et primær navigasjonen. (denne handlingen er underforstått hvis ingen handling er spesifisert). </li>
   <li>brødsmuler - Brukes for å bygge en mini navigasjon bestående av banen fra roten av området ned til gjeldende side</li>
</ul>';
$lang['help_collapse'] = 'Når aktivert, vil bare elementer som er direkte knyttet til den nåværende aktive siden sendes ut';
$lang['help_childrenof'] = 'Dette alternativet vil gjøre at menyen bare viser elementer som er etterkommere av den valgte sidens id eller alias. dvs: <code>{menu childrenof=$page_alias}</code> vil bare vise barn av den gjeldende siden.';
$lang['help_excludeprefix'] = 'Ekskluder alle elementer (og deres barn) som har side alias som matcher et av de spesifiserte (kommaseparerte) prefikser. Denne parameteren skal ikke benyttes i forbindelse med den includeprefix parameteren.';
$lang['help_includeprefix'] = 'Omfatter bare de elementene som er side alias som matcher et av de spesifiserte (kommaseparerte) prefikser. Denne parameteren kan ikke kombineres med excludeprefix parameteren.';
$lang['help_items'] = 'Angi en kommaseparert liste med side aliaser som denne menyen skal vise.';
$lang['help_loadprops'] = 'Bruk denne parameteren når du ikke bruker avanserte egenskaper i din menymal. Dette deaktiverer lasting av alle innholdsegenskaper for hver node (for eksempel extra1, bilde, miniatyrbilde, etc.). Dette vil dramatisk redusere antall spørringer som kreves for å bygge en meny, og øke minnekrav, men vil fjerne muligheten for veldig avanserte menyer';
$lang['help_nlevels'] = 'Dette er alias for number_of_levels';
$lang['help_number_of_levels'] = 'Denne innstillingen vil begrense dybden av den genererte menyen til spesifisert antall nivåer. Som standard er verdien for denne parameteren underforstått å være ubegrenset, bortsett fra når du bruker items parameteren, i hvilket tilfelle number_of_levels parameteren er antydet å være 1';
$lang['help_root2'] = 'Kun brukt i "brødsmule" handlingen hvor denne parameteren indikerer at brødsmuler bør gå lenger opp på side-treet enn det angitte sidealias. Å angi et negativt heltall vil bare vise brødsmuler opp til øverste nivå, og vil ignorere standardsiden.';
$lang['help_show_all'] = 'Dette alternativet vil føre til at menyen viser alle noder selv om de er satt til å \'ikke vis i meny\'. Den vil fortsatt ikke vise inaktive sider.';
$lang['help_show_root_siblings'] = 'Dette alternativet blir bare nyttig hvis start_element eller start_page brukes. Det vil i utgangspunktet vise søsken langs siden av den valgte start_page/element.';
$lang['help_start_element'] = 'Starter meny som viser på den gitte start_element og viser det elementet og bare dets barn. Tar en hierarki posisjon (f.eks 5.1.2).';
$lang['help_start_level'] = 'Dette alternativet vil vise på menyen bare elementer som starter på et gitt nivå. Et enkelt eksempel ville være hvis du hadde en meny på siden med number_of_levels =\'1\'. Så som en andre meny, har du start_level =\'2 \'. Nå vil din andre meny vise poster basert på hva som er valgt i den første menyen.';
$lang['help_start_page'] = 'Starter menyen som viser den gitte start_page og viser det elementet og bare dets barn. Tar en side alias.';
$lang['help_template'] = 'Malen skal brukes for å vise menyen. Den navngitte malen må eksistere i DesignManager ellers vil en feil vil bli vist. Hvis denne parameteren ikke er angitt så er det standardmalen av typen Navigator::Navigation som vil bli brukt';
$lang['help_start_text'] = 'Nyttig bare i brødsmuler/breadcrumbs handlingen, hvor denne parameteren lar deg spesifisere valgfri tekst som skal vises på begynnelsen av brødsmulenavigasjonen. Et eksempel kan være "Du er her"';
$lang['type_breadcrumbs'] = 'Brødsmuler/breadcrumbs';
$lang['type_Navigator'] = 'Navigator';
$lang['type_navigation'] = 'Navigasjon';
$lang['youarehere'] = 'Du er her';
?>