<?php
$lang['addtemplate'] = 'Pridať šablónu';
$lang['areyousure'] = 'Ste si istý, že to chcete odstrániť?';
$lang['cachable'] = 'kešovateľné';
$lang['dbtemplates'] = 'Šablóny v databáze';
$lang['default'] = 'Prednastavená';
$lang['delete'] = 'Odstrániť';
$lang['deletetemplate'] = 'Odstrániť šablónu';
$lang['description'] = 'Správa šablón pre menu a zobrazovanie menu na stránkach.';
$lang['edit'] = 'Úprava';
$lang['edittemplate'] = 'Upraviť šablónu';
$lang['error_templatename'] = 'Nemôžete zadať  názov šablóny s koncovkou tpl.';
$lang['filename'] = 'Názov súboru';
$lang['filetemplates'] = 'Šablóny zo  súboru';
$lang['help'] = '<h3>Čo to robí?</h3>
	<p>Menu generátor  je modul pre správu a zobrazenie menu zo stránok v systéme.</p>
	<h3>Ako sa používa?</h3>
	<p>Vložením značky: <code>{menu}</code> do stránok.  Parametre pre špecifické zobrazenie menu si pozrite nižšie.</p>
	<h3>Why do I care about templates?</h3>
	<p>Menu Manager uses templates for display logic.  It comes with three default templates called cssmenu.tpl, minimal_menu.tpl and simple_navigation.tpl. They all basically create a simple unordered list of pages, using different classes and ID\'s for styling with CSS.</p>
	<p>Note that you style the look of the menus with CSS. Stylesheets are not included with Menu Manager, but must be attached to the page template separately. For the cssmenu.tpl template to work in IE you must also insert a link to the JavaScript in the head section of the page template, which is necessary for the hover effect to work in IE.</p>
	<p>If you would like to make a specialized version of a template, you can easily import into the database and then edit it directly inside the CMSMS admin.  To do this:
		<ol>
			<li>Click on the Menu Manager admin.</li>
			<li>Click on the File Templates tab, and click the Import Template to Database button next to i.e. simple_navigation.tpl.</li>
			<li>Give the template copy a name.  We\'ll call it "Test Template".</li>
			<li>You should now see the "Test Template" in your list of Database Templates.</li>
		</ol>
	</p>
	<p>Now you can easily modify the template to your needs for this site.  Put in classes, id\'s and other tags so that the formatting is exactly what you want.  Now, you can insert it into your site with {menu template=\'Test Template\'}. Note that the .tpl extension must be included if a file template is used.</p>
	<p>The parameters for the $node object used in the template are as follows:
		<ul>
			<li>$node->id -- Content ID</li>
			<li>$node->url -- URL of the Content</li>
			<li>$node->accesskey -- Access Key, if defined</li>
			<li>$node->tabindex -- Tab Index, if defined</li>
			<li>$node->titleattribute -- Description or Title Attribute (title), if defined</li>
			<li>$node->hierarchy -- Hierarchy position, (e.g. 1.3.3)</li>
			<li>$node->depth -- Depth (level) of this node in the current menu</li>
			<li>$node->prevdepth -- Depth (level) of the node that was right before this one</li>
			<li>$node->haschildren -- Returns true if this node has child nodes to be displayed</li>
			<li>$node->menutext -- Menu Text</li>
			<li>$node->alias -- Page alias</li>
			<li>$node->target -- Target for the link.  Will be empty if content doesn\'t set it.</li>
			<li>$node->index -- Count of this node in the whole menu</li>
			<li>$node->parent -- True if this node is a parent of the currently selected page</li>
		</ul>
	</p>';
$lang['help_action'] = 'Dva parametre
<ul>
  <li>default<em>(default)</em> - prednastavená, zobrazuje menu</li>
  <li>breadcrumbs - zobrazuje drobečkovú navigáciu  <strong>Poznámka: {cms_breadcrumbs}</strong> možete použiť aj túto značku pre zobrazenie</li>
</ul>';
$lang['help_childrenof'] = 'Nastavenie, ktoré zobrazí iba podradené prvky položky (môže byť id stránky, alias).  príklad: <code>{menu childrenof=$page_alias}</code>';
$lang['help_collapse'] = 'Povoľte (nastavte na 1) pre skrytie položiek, ktoré nie sú súvisiace s aktívnou položkou.';
$lang['help_excludeprefix'] = 'Nezobrazí položky, ktoré obsahujú jeden zo zadaných, čiarkov oddelených prefixov. Tento parameter nemôže byť použitý v kombinácii s  includeprefix .';
$lang['help_includeprefix'] = 'Zobrazí iba tie položky, ktoré obsahujú jeden zo zadaných,  čiarkov oddelených prefixov. Tento parameter nemôže byť použitý v kombinácii s excludeprefix.';
$lang['help_items'] = 'Použite pre zoznam stránok, ktoré majú byť  vmenu zobrazené.   Hodnota parametra musí obsahovať čiarkov oddelené aliasy stránok.';
$lang['help_loadprops'] = 'Use this parameter when using advanced properties in your menu manager template.  This parameeter will force the loading of all content properties for each node (such as extra1, image, thumbnail, etc).  and will dramatically increase the number of queries required to build a menu, and increase memory requirements, but will allow for much more advanced menus';
$lang['help_number_of_levels'] = 'Nastavenie povolí zobrazenie menu iba do určitej hĺbky.';
$lang['help_root'] = 'Aplikovateľné iba pri použití Breadcrumbs (drobečková navigácia), povoľuje nastaviť začiatok navigácia, pokiaľ to nie je prednastavená stránka';
$lang['help_show_all'] = 'Nastavuje zobrazenie pre všetky stránky, vrátane stránok, ktoré sú označené ako "nezobrazovať v menu". Avšak strále nebudú zobrazené neaktívne stránky.';
$lang['help_show_root_siblings'] = 'Nastavenie sa používa iba pri použití start_element alebo  start_page. Zobrazuje iba podriadené stránky.';
$lang['help_start_element'] = 'Začiatok menu od start_element, vrátane tejto položky a jeho podradených položiek. Vypĺňajte pozíciu v hierarchii  (napr. 5.1.2)';
$lang['help_start_level'] = 'Nastavenie zobrazí menu iba od určitej úrovne. Napríklad menu prvej úrovne zobrazíte ak nastavíte number_of_levels=\'1\'.  Menu druhej úrovne nastavíte pridaním parametra start_level=\'2\'.';
$lang['help_start_page'] = 'Začiatok menu od start_page, vrátane tejto položky a jeho podradených položiek.';
$lang['help_template'] = 'Šablóna pre zobrazenie menu. Šablónu si môžete vytvoriť, alebo naimportovať zo predpripravených súborov a potom modifikovať.  Prednastavená šablóna je simple_navigation.tpl.';
$lang['import'] = 'Import';
$lang['importtemplate'] = 'Imporotvať šablóny do databázy';
$lang['menumanager'] = 'Menu generátor';
$lang['newtemplate'] = 'Nový názov šablóny';
$lang['nocontent'] = 'Nezadaný obsah';
$lang['notemplatefiles'] = 'Žiadny súbor šablón v  %s';
$lang['notemplatename'] = 'Nezadaný názov šablóny.';
$lang['readonly'] = 'iba na čítanie';
$lang['set_as_default'] = 'Nastaviť ako prednastavenú šablónu pre menu';
$lang['set_cachable'] = 'Nastaviť šablónu ako kešovateľnú';
$lang['templatenameexists'] = 'Šablóna s týmto názvom existuje';
$lang['templates'] = 'Šablóny';
$lang['this_is_default'] = 'Prednastavená šablóna pre menu';
$lang['usage'] = 'Použitie';
$lang['youarehere'] = 'Navigácia';
?>