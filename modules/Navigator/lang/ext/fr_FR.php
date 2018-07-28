<?php
$lang['description'] = 'Ce module fournit un moyen simple et facile de générer le code HTML nécessaire pour une navigation de site Web direct et dynamique à partir de la structure des pages de CMSMS™. Il fournit un filtrage flexible et des capacités de création de gabarits pour construire des navigations de site Web puissant, rapide et attrayant sans interaction avec l\'éditeur de contenu.';
$lang['friendlyname'] = 'CMSMS™ Navigation Builder';
$lang['help'] = '<h3>Que fait ce module&nbsp;?</h3>
  <p>Le module "Navigator" permet de générer des menus de navigation à partir d\'une hiérarchie de contenus et d\'un gabarit smarty. Ce module fournit des fonctionnalités de filtrage étendues pour permettre la construction de nombreuses navigations sur la base de différents critères et un format de données hiérarchisées simple à utiliser pour générer des navigations avec une flexibilité totale.</p>
  <p>Ce module n\'a pas d\'interface d\'administration propre, il utilise donc le DesignManager pour générer les gabarits des menus.</p>
<h3>Comment l\'utiliser ?</h3>
<p>Insérez simplement la balise dans votre gabarit <code>{Navigator}</code>. Le module accepte de nombreux paramètres pour modifier son comportement et filtrer les données.</p>
<h3>Que dois-je faire sur les gabarits ?</h3>
<p>C\'est la puissance de CMSMS™. Les menus de navigations peuvent être construits automatiquement en utilisant les données de votre hiérarchie de contenu et un gabarit Smarty. Il n\'est pas nécessaire de modifier un objet de navigation à chaque fois qu\'une page de contenu est ajoutée ou supprimée du système. En outre, les gabarits de navigation peuvent facilement inclure du code JavaScript ou des fonctionnalités avancées et peuvent être utilisés dans d\'autres sites Web.</p>
<p>Le module est distribué avec quelques gabarits modèles en exemple. Vous êtes libre et encouragé à copier et modifier ces gabarits selon vos besoins. Les feuilles de styles ne sont pas incluses dans le module Navigator.</p>
<h3>L\'objet node :</h3>
  <p>Chaque gabarit Navigator inclut un tableau d\'objets node qui correspondent aux critères spécifiés dans la balise. Ci-dessous une description des membres de l\'objet node :</p>
<ul>
			<li>$node->id -- ID de l\'élément</li>
                        <li>$node->type -- le type du node. Exemple : content, link, pagelink, etc.</li>
			<li>$node->url -- URL de l\'élément</li>
			<li>$node->accesskey -- Access Key, si défini</li>
			<li>$node->tabindex -- Tab Index, si défini</li>
			<li>$node->titleattribute -- Description ou attribut titre, si défini</li>
			<li>$node->hierarchy -- Position hiérarchique (exemple : 1.3.3)</li>
  <li>$node->default -- TRUE si ce node se réfère à l\'objet de contenu par défaut.</li>
			<li>$node->menutext -- Texte du menu</li>
			<li>$node->raw_menutext -- Texte du menu sans convertion des entités HTML</li>
			<li>$node->alias -- Alias de la page</li>
			<li>$node->extra1 -- Ce champ contient la valeur de la propriété de page extra1 sauf si le paramètre loadprops, contenu dans la balise (tag) menu, est réglé pour ne PAS charger les propriétés.</li>
			<li>$node->extra2 -- Ce champ contient la valeur de la propriété de page extra2 sauf si le paramètre loadprops , contenu dans la balise (tag) menu, est réglé pour ne PAS charger les propriétés.</li>
			<li>$node->extra3 -- Ce champ contient la valeur de la propriété de page extra3 sauf si le paramètre loadprops , contenu dans la balise (tag) menu, est réglé pour ne PAS charger les propriétés.</li>
			<li>$node->image -- Ce champ contient la valeur de la propriété de l\'image dans la page (si non vide) sauf si le paramètre loadprops, contenu dans la balise (tag) menu, est réglé pour ne PAS charger les propriétés.</li>
			<li>$node->thumbnail -- Ce champ contient la valeur de la propriété de page de la vignette de l\'image(si non vide) sauf si le paramètre loadprops, contenu dans la balise (tag) menu, est réglé pour ne PAS charger les propriétés.</li>
			<li>$node->target -- Cette zone contient la cible du lien (si non vide) sauf si le paramètre loadprops, contenu dans la balise (tag) menu, est réglé pour ne PAS charger les propriétés.</li>
  <li>$node->created -- Date de création de l\'élément</li>
  <li>$node->modified -- Date de modification de l\'élément</li>
			<li>$node->parent -- Renvoie TRUE  (vrai) si cet élément est le parent de la page actuelle</li>
			<li>$node->current -- Renvoie TRUE  (vrai) si cet élément est la page sélectionnée</li>
	<li>$node->children_exist -- Renvoie TRUE (vrai) si le node a au moins un enfant</li>
	<li>$node->children -- Un tableau d\'objets représentant les enfants affichables de ce node. Non défini si le node n\'a pas d\'enfant à afficher.</li>
<li>$node->has_children -- Renvoie  TRUE si le node a des enfants qui pourraient être affichées, mais qui ne sont pas affichés en raison des paramètres de filtrage (nombre de niveaux, etc.).</li>
</ul>
<h3>Exemples :</h3>
   <br />- Affiche une navigation simple à seulement 2 niveaux, en utilisant le modèle par défaut :<br />
     <pre><code>{Navigator number_of_levels=2}</code></pre>
   
     <br />- Affiche une navigation simple à deux niveaux en commençant par les enfants de la page en cours, en utilisant le modèle par défaut :<br />
     <pre><code>{Navigator number_of_levels=2 start_page=$page_alias}</code></pre>
  
   <br />- Affiche une navigation simple à deux niveaux en commençant par les enfants de la page courante, en utilisant le modèle par défaut :<br />
     <pre><code>{Navigator number_of_levels=2 childrenof=$page_alias}</code></pre>
  
   <br />- Affiche une navigation à deux niveaux à partir de la page en cours, et les pages suivantes, en utilisant le modèle par défaut :<br />
     <pre><code>{Navigator number_of_levels=2 start_page=$page_alias show_root_siblings=1}</code></pre>

   <br />- Affiche une navigation des éléments spécifiés et de leurs enfants. Utilise le gabarit "mymenu" :<br />
     <pre><code>{Navigator items=\'alias1,alias2,alias3\' number_of_levels=3 template=mymenu}</code></pre>';
$lang['help_action'] = 'Spécifier l\'action du module. Ce module prend en charge deux actions :
<ul>
<li><em>default</em> - Utilisé pour construire une navigation principale (cette action est implicite si aucune action n\'est spécifié).</li>
<li>breadcrumbs - Utilisé pour construire une mini navigation (fil d\'Ariane) consistant en un chemin depuis la racine du site jusqu\'à la page en cours.</li>
</ul>';
$lang['help_collapse'] = 'Si activée, seuls les éléments directement liés à la page courante active seront en sortie.';
$lang['help_childrenof'] = 'Cette option n\'affichera que les éléments descendants (enfants) de l\'ID ou de l\'alias de la page indiqué. Exemple : <code>{Navigator childrenof=$page_alias}</code> affichera uniquement les enfants de la page courante.';
$lang['help_excludeprefix'] = 'Exclut tous les éléments (et leurs enfants) dont l\'alias de page correspond à l\'un des préfixes spécifiés (séparés par des virgules). Ce paramètre ne doit pas être combiné avec le paramètre includeprefix.';
$lang['help_includeprefix'] = 'Inclut seulement les éléments dont l\'alias de page correspond à l\'un des préfixes spécifiés (séparés par des virgules). Ce paramètre ne peut pas être combiné avec le paramètre excludeprefix.';
$lang['help_items'] = 'Spécifie une liste des alias de pages (séparés par des virgules) que la navigation doit afficher.';
$lang['help_loadprops'] = 'Vous pouvez utiliser ce paramètre lorsque vous n\'utilisez PAS les propriétés avancées dans votre gabarit de navigation. Ce paramètre permet de désactiver le chargement des propriétés des contenus pour chaque nœuds (ex.: extra1, image, thumbnail, etc). Cette opération réduira considérablement le nombre de requêtes nécessaires à la construction d\'une navigation tout en demandant une augmentation de la configuration de la mémoire minimale, mais enlève des possibilités pour la construction d\'affichage plus complexes.';
$lang['help_nlevels'] = 'Alias de number_of_levels (nombre de niveaux)';
$lang['help_number_of_levels'] = 'Ce réglage limite la profondeur de la navigation générée au nombre spécifié de niveaux. Par défaut la valeur de ce paramètre est illimité pour montrer tous les niveaux enfants sauf si vous utilisez le paramètre "items", dans ce cas number_of_levels sera égal à 1';
$lang['help_root2'] = 'Utilisé uniquement dans l\'action breadcrumbs ce paramètre indique que le fil d\'Ariane n\'ira pas plus loin vers le haut de l\'arborescence de pages que l\'alias de page spécifié. La spécification d\'un nombre de valeur négative affichera le fil d\'Ariane jusqu\'au niveau supérieur et ignorera la page par défaut.';
$lang['help_show_all'] = 'Cette option affichera tous les noeuds même s\'ils sont configurés pour ne pas être affichés dans le menu. Cependant, il continuera à ne pas afficher les pages inactives.';
$lang['help_show_root_siblings'] = 'Cette option n\'est utile que lorsque start_element ou start_page est utilisé. Les autres éléments du même niveau que l\'élément sélectionné seront affichés.';
$lang['help_start_element'] = 'Démarre le menu à un élément donné (start_element) et n\'affiche que cet élément et ses enfants. Utilise la position hiérarchique (exemple : 5.1.2).';
$lang['help_start_level'] = 'Grâce à cette option le menu n\'affichera des éléments qu\'à partir d\'un niveau donné par rapport à la page courante. Prenons un exemple simple : vous avez un premier menu sur une page avec le paramètre number_of_level=1. Puis un deuxième menu avec start_level=2. Maintenant, votre second menu affichera ses éléments en fonction de ce qui est sélectionné sur le premier menu. La valeur minimale de ce paramètre est 2.';
$lang['help_start_page'] = 'Cette option permet d\'afficher uniquement les éléments à partir d\'une page donnée (start_page), ainsi que les niveaux en-dessous de cet élément. la valeur doit être égale à l\'alias de l\'élément.';
$lang['help_template'] = 'Le gabarit à utiliser pour l\'affichage du menu. Le gabarit doit exister dans le module DesignManager sinon une erreur sera affichée. Si ce paramètre n\'est pas spécifié le gabarit par défaut de type Navigator::Navigation sera utilisé.';
$lang['help_start_text'] = 'Utile seulement avec l\'action breadcrumbs, ce paramètre permet de spécifier un texte facultatif à afficher au début du fil d\'ariane. Un exemple serait "Vous êtes ici".';
$lang['type_breadcrumbs'] = 'Fil d\'Ariane';
$lang['type_Navigator'] = 'Navigator&nbsp;';
$lang['type_navigation'] = 'Navigation&nbsp;';
$lang['youarehere'] = 'Vous êtes ici&nbsp;';
?>