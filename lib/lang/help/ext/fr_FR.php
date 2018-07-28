<?php
$lang['help_group_permissions'] = '<h4>CMSMS™ Administration des permissions</h4>
<ul>
<li>- CMSMS™ utilise un système d\'autorisations (permissions) nominatives. L\'accès à ces permissions détermine la capacité pour les utilisateurs de réaliser différentes fonctions dans la console d\'administration.</li>
<li>- Le noyau CMSMS™ crée plusieurs permissions lors de l\'installation <em>(occasionnellement des permissions sont ajoutées ou supprimées au cours d\'un processus de mise à jour)</em>. Les modules tiers peuvent créer des permissions supplémentaires.</li>
<li>- Les permissions sont associées à des groupes d\'utilisateurs. Un utilisateur autorisé peut modifier les permissions qui sont associées à certains membres du groupes <em>(y compris l\'autorisation de modifier un groupe complet)</em>. Le groupe "Admin" est un groupe spécial auquel est accordé automatiquement toutes les permissions</strong>.</li>
<li>- Les comptes utilisateurs "Admin" peuvent être membres de zéro ou de plusieurs groupes. Il peut être possible pour un compte utilisateur qui n\'est membre d\'aucun groupe d\'effectuer, malgré tout, différentes actions <em>(lire le paragraphe sur les propriétaires et les rédacteurs supplémentaires dans les aides du Gestionnaire des contenus et de Gestion du design)</em>. Le premier compte utilisateur <em>(UID == 1)</em>, qui est généralement nommé "Admin" est un compte utilisateur spécial et aura toutes les permissions.</li>
</ul>';
$lang['help_cmscontentmanager_help'] = '<h3>Introduction</h3>
<p>Ce document décrit le module CMS Content Manager (Gestionnaire des contenus). Il est destiné principalement au concepteur de site Web ou au développeur et décrit dans les grandes lignes comment fonctionnent les éléments de contenu dans CMS Made Simple.</p>
<p>L\'interface principale du module Content Manager est la liste des contenus. Elle affiche des éléments de contenu sous la forme d\'un tableau et offre des possibilités de recherche, de navigation et de gestion rapide des éléments de contenu.
Il s\'agit d\'une liste dynamique. L\'affichage est ajusté en fonction de certains éléments de la configuration, de certains paramètres globaux, des permissions des utilisateurs et des éléments de contenu. Le texte qui suit décrit les éléments de contenu et comment la liste des éléments de contenu permet de les gérer.</p>
<h3>Hiérarchie des contenus et navigations</h3>
<p>CMS Made Simple construit dynamiquement des navigations (menus) pour la vue de l\'utilisateur du site à partir de la liste des contenus, des différents types d\'éléments de contenu, du contenu de ces éléments et du gabarit de navigation. L\'organisation des navigations est principalement contrôlée par la relation de hiérarchie parent-enfant de vos éléments de contenu, en partant du premier niveau <em>(racine)</em>, puis en descendant dans les niveaux hiérarchiques.</p>
<p>L\'ajout d\'un nouvel élément dans le menu de navigation est aussi simple que de créer un nouvel élément de contenu, de le placer à l\'endroit désiré dans la hiérarchie et <em>(selon le type de contenu)</em> de préciser les différentes propriétés de ce type de contenu.
<h3>Les différents types d\'éléments de contenu</h3>
  <p>CMS Made Simple est distribué avec plusieurs types différents d\'éléments de contenu <em>(plus de types sont disponibles via des modules tiers)</em>. Ces types d\'éléments de contenu servent des objectifs différents quand une navigation est générée. Certains ne contiennent pas de contenu et ne sont utilisés que pour la gestion des navigations. Par exemple, le contenu type "Séparateur" n\'a pas de contenu propre et sert uniquement à organiser les éléments de contenu en fournissant un séparateur visible dans la navigation générée.</p>
  <p>Voici une brève description de chaque type d\'éléments de contenu distribué avec CMS Made Simple :</p>
<ul>
  <li>Contenu de page <!-- /*Content Page-->
 <p>Ce type de contenu est très semblable à une page HTML et est généralement utilisé à cette fin. Quand les utilisateurs éditeurs créent des éléments de contenu de page, ils choisissent un design et un gabarit qui contrôle l\'apparence de la page, indiquent un titre et saisissent le contenu de la page.</p>
<!-- TO DO Jean le Chauve -->
<p>Les éléments de contenu peuvent également contenir, des formulaires, du code, afficher les données dynamiques de modules ou des balises définies par l\'utilisateur (UDT). Cette souplesse permet de créer des applications spécialisées ou des sites Web extrêmement modulables et dynamiques.</p>
  </li>
  <li>Lien de redirection <!-- /*Link-->
    <p>Ce type de contenu est utilisé pour générer un lien vers une page d\'un site Web externe.</p>
  </li>
  <li>Lien de page interne <!--/*Page Link-->
    <p>Ce type de contenu est également utilisé dans la navigation des pages. On l\'utilisera quand le contenu sera accessible depuis de nombreux endroits dans la navigation.</p>
  </li>
  <li>Séparateur <!--/*Separator-->
    <p>Ce type de contenu est également utilisé dans la navigation. Il est généralement utilisé pour générer un diviseur horizontal (ou vertical) entre les éléments de navigation. Certains types de navigations <em>(déterminés par les gabarits)</em> ne peuvent pas afficher les séparateurs.</p>
  </li>
  <li>En-tête de section <!--/*Section Header-->
    <p>L\'en-tête de section est également affiché uniquement dans la navigation. Il est utilisé pour organiser les éléments de contenu. Il fournit le texte de l\'en-tête au-dessus ou entre des éléments de contenu. Ces en-têtes de section ne peuvent pas contenir d\'URLs et sont non cliquables. Certains gabarits de navigation affichent les en-têtes de section différemment des autres éléments de contenu.</p>
  </li>
  <li>Page d\'erreur <!--/*Error Page-->
    <p>La page d\'erreur est un type particulier de contenu. Elle est utilisée lorsqu\'un utilisateur tente d\'accéder à un élément de contenu qui n\'est pas navigable ou n\'existe pas.</p>
  </li>
</ul>
<p>De nombreux modules tiers fournissent plus de types de contenu pour des utilisations différentes. Comme l\'affichage de catalogues de produits ou pour restreindre le contenu aux utilisateurs autorisés.</p>
<h3>la liste du gestionnaire des contenus <!--/*The Content Item List--></h3>
<p>La liste de contenus est la principale interface du module. Cette page est l\'interface de gestion principale de vos contenus. De là, vous pouvez créer, modifier, supprimer, copier, désactiver et organiser vos éléments de contenu. Cet affichage est optimisé pour les grands sites Web. Ses mécanismes de pagination et de recherche permettent d\'afficher une petite quantité de pages à la fois tout en ayant la possibilité de trouver rapidement les éléments à gérer.</p>
<h4>Colonnes <!--/*Columns--></h4>
<p>Chaque élément de contenu est affiché comme une ligne dans une table. Il y a un certain nombre de colonnes pour afficher rapidement les divers attributs de l\'élément de contenu, ainsi que quelques icônes donnant directement accès à des fonctionnalités. Certaines colonnes peuvent être cachées, ou seulement disponibles pour certaines lignes en fonction d\'un certain nombre de facteurs :</p>
  <ul>
    <li>Vos permissions d\'accès et la propriété de la page :
      <p>Selon vos droits d\'accès, certaines colonnes peuvent ne pas être affichées, ou être désactivées.</p>
    </li>
    <li>Préférences du système et configuration du site :
      <p>Certaines préférences du système et des options de configuration du site Web, se traduiront par des colonnes désactivées. Par exemple, la colonne "URL".</p>
    </li>
    <li>Le type de contenu :
      <p>Selon le type contenu, certaines colonnes peuvent être dénuées de sens. Par exemple, il n\'est pas possible pour les "En-têtes de section" ou "Séparateurs" de devenir la page par défaut, de sorte que rien ne sera affiché dans la colonne "Défaut" pour ces éléments de contenu.</p>
    </li>
    <li>Si l\'élément de contenu est en cours d\'édition ;
      <p>Quand d\'autres utilisateurs éditeurs <em>(ou vous-même)</em> sont en train de modifier une page de contenu, alors des colonnes seront cachées dans la ligne pour chaque type de contenu afin d\'empêcher la modification, la suppression ou la copie du contenu de la page.</p>
    </li>
  </ul>
  <h5>Détail liste des colonnes <!--/*Column List--></h5>
<p>Le module Content Manager fournit un mécanisme souple pour cacher ou afficher les différentes colonnes dans la liste de contenu. En outre, certaines colonnes peuvent être masquées en fonction de la configuration du site. Par exemple, la colonne URL est masquée si <em>Créer automatiquement les URLs des pages</em> n\'est pas configuré.</p>
<p>Chaque colonne de la liste de contenu a un but particulier :</p>
   <ul>
     <li>Afficher/Masquer la colonne
      <p>Quand une page de contenu à des enfants cette colonne contiendra une icône qui permet de déployer la liste pour montrer les pages enfants, ou de masquer la liste des pages enfants. L\'état, dans lequel les pages affichées et donc regroupées, est enregistré. De sorte que lorsque vous reviendrez dans le gestionnaire de contenu l\'état déployé/contracté de vos pages restera le même.</p>
     </li>

     <li>Colonne hiérarchie  <!--/* Hierarchy Column-->
<p>La colonne de hiérarchie indique la position de chaque contenu dans l\'arborescence des contenus. La hiérarchie de la première page au niveau de la racine commence à 1 et augmente progressivement pour les autres pages qui sont de même niveau. De la même manière, chaque enfant commence à 1 et augmente progressivement pour les autres pages qui sont à son niveau. Par conséquent, la deuxième page enfant de la troisième page enfant de la première page dans la liste de contenu, aura une hiérarchie de 1.3.2.</p>
<p>Le mécanisme de la hiérarchie est une partie importante qui permet au gestionnaire de contenu d\'organiser les éléments de contenu et à partir de là de construire des menus de navigation.</p>
     </li>
     
<li>Colonne Titre de la page/Texte du menu
      <p>Cette colonne peut afficher le titre de la page ou le texte du menu, en fonction du choix sélectionné dans le menu "Paramètres gestion contenus/Paramètres de la liste des contenus"</p>
      <p>Cette colonne contiendra un lien pour permettre l\'édition du contenu sélectionné <em>(à moins que l\'élément contenu soit verrouillé)</em>. Le survol du texte de cette colonne avec la souris affichera des informations supplémentaires sur l\'élément de contenu tels que le l\'identifiant numérique unique du contenu, et si la page est cachable ou non.</p>
      <p>Si l\'élément de contenu est verrouillé, le survol du texte dans la colonne affiche des informations sur qui a verrouillé l\'article, et quand l\'expiration du verrouillage aura lieu.</p>
	</li>
	
    <li>Colonne URL
	 <p>Si activée (dans Administration du site/Paramètres gestion contenus/Paramètres de la liste des contenus), cette colonne affiche une URL alternative pour cet élément de contenu.<em>(Note : Seuls certains types d\'éléments de contenu supportent cette URL alternative)</em>.</p>
	</li>
     
<li>Colonne Alias de la page
       <p>Cette colonne affiche les alias uniques associés à chaque page. Les alias sont des chaînes de texte qui identifient l\'élément de contenu. Vous utilisez les alias des contenus (ou l\'identifiant numérique Id) lorsque vous avez besoin de vous référer à une page au sein du système. <em>(note : certains types de contenu n\'ont pas d\'alias)</em>.</p>	  
	</li>

     <li>Colonne Gabarit
       <p>Cette colonne affiche le gabarit utilisé pour afficher le contenu de la page.
Consultez l\'aide sur le module "Gestion du design" pour une explication de la façon dont CMSMS™ gère les designs, y compris les feuilles de styles et les gabarits. <em>(Note : Certains types d\'éléments de contenu n\'utilisent pas de design, ou de gabarit)</em></p>
	</li>
     
<li>Colonne Type
       <p>Cette colonne indique le type de contenu (ex: contenu, en-tête de section, séparateur, etc.) .</p>
     </li>
     
<li>Colonne Propriétaire
       <p>Cette colonne affiche le nom du propriétaire de l\'élément de contenu. Le survol du texte de cette colonne avec la souris affichera des informations concernant la date de création ou de dernière édition de l\'élément de contenu.</p>
     </li>
     
<li>Colonne Actif.
     <p>Cette colonne affiche des icônes indiquant l\'état actif de l\'élément de contenu. Les éléments actifs peuvent être parcourus, et apparaîtront dans les menus de navigation sur le site Web (frontend). Si votre compte utilisateur a les privilèges suffisants pour cet éléments de contenu, vous pouvez cliquer sur l\'icône pour basculer entre l\'état actif ou inactif.</p>
     </li>
     
<li>Colonne Défaut.
       <p>Cette colonne affiche si le type de contenu est la page par défaut ou non. L\'élément de contenu par défaut est la page d\'accueil de votre site. Seuls certains types de contenu peuvent prendre la valeur par défaut.</p>
       <p>Si votre compte utilisateur a les privilèges suffisants, et le type de contenu a la possibilité d\'être le contenu par défaut pour le site, vous pouvez cliquer sur l\'icône pour changer la page par défaut.</p>
     </li>
     
<li>Colonne déplacer
       <p>En fonction de vos droits d\'accès, vous pouvez voir les icônes qui permettent de changer l\'ordre des éléments de contenu les uns par rapport aux autres.
	   L\'option "Réordonner les contenus" permet de réorganiser les pages en masse. Lors de la modification vous pouvez affecter rapidement l\'élément de contenu à un parent différent.</p>
     </li>
     
<li>Icônes d\'action.
     <br />Selon vos droits d\'accès, le type de contenu et son état de verrouillage actuel vous pouvez voir les différentes icônes sur chaque ligne de contenu. Elles permettent différentes fonctionnalités :
       <ul>
         <li>Vue de la page - Ouvre une nouvelle fenêtre du navigateur <em>(ou onglet)</em> et affiche l\'élément de contenu tel que vos visiteurs le verront.</li>
         <li>Copier - Copie l\'élément de contenu vers un nouvel élément de contenu.
           <p>Un nouvel élément de contenu sera créé avec un nouveau titre de page un nouvel alias. Il s\'affichera avec la possibilité de modifier la nouvelle page.</p>
         </li>
         <li>Éditer - Édite l\'élément de contenu.
           <p>Permettre l\'édition du contenu sélectionné <em>(à moins que l\'élément contenu soit verrouillé)</em>.</p>
         </li>
         <li>Supprimer - Supprime l\'élément de contenu.
           <p>Selon vos droits d\'accès, et si l\'élément de contenu a des enfants ou non, la possibilité de supprimer l\'élément de contenu peut être masqué ou désactivé.</p>
	</li>
	<li>Enlever le verrou
<p>Pour les éléments de contenu qui sont en cours d\'édition, mais pour lesquels le verrou a expiré <em>(l\'utilisateur éditeur n\'a pas procédé à un changement depuis un certain temps)</em> Cette option permet de "s\'approprier" le verrou.</p>
         </li>
         <li>Case opérations de contenu en série.
           <p>La case à cocher permet de sélectionner plusieurs éléments de contenu pour effectuer des opérations multiples.</p>
         </li>
       </ul> 
     </li>
   </ul>


 <h4>Édition des contenus <!--/*Edit Ability--></h4>
   <p>La possibilité de modifier un élément de contenu est déterminée soit par permissions <em>(voir le menu Permissions des groupes : "Manage All Content-Gérer tous les contenus" et "Modify Any Page-Modifier toutes les Pages")</em>, soit par le fait que vous en êtes le propriétaire ou l\'éditeur additionnel.</p>
 
<h4>Propriétaires</h4>
   <p>Par défaut, le propriétaire d\'un élément de contenu est l\'utilisateur qui l\'a initialement créé. Les propriétaires, ou les utilisateurs disposant d\'une permission "Manage All Content-Gérer tous les contenus" peuvent donner la propriété d\'une page à un autre utilisateur.</p>
 
<h4>Rédacteurs supplémentaires</h4>
    <p>Lors de l\'édition d\'un élément de contenu en tant que propriétaire ou en tant qu\'utilisateur possédant la permission "Manage All Content-Gérer tous les contenus", l\'utilisateur actuel peut choisir d\'autres utilisateurs(rédacteurs), ou des groupes d\'administration qui seront également autorisés à modifier cet élément de contenu.</p>
 
<h4>Permissions nécessaires.<!--/*Relevent Permissions--></h4>
    <p>Il existe quelques permissions qui ont un effet sur les colonnes affichées dans la liste de contenu et sur la capacité à interagir avec la liste de contenu :</p>
    <ul>
      <li>Ajouter des contenus <!--/*Add Pages-->
    <p>Cette permission permet aux utilisateurs de créer de nouveaux éléments de contenu. En outre, les utilisateurs avec cette permission sont en mesure de copier les éléments de contenu qu\'ils ont édité.</p>
      </li>
      <li>Modifier n\'importe quel contenu <!--/*Modify Any Page--> 
        <p>Les utilisateurs disposant de cette permission auront la possibilité de modifier n\'importe quel élément de contenu. Cela correspond à être un "éditeur additionnel" sur tous les éléments de contenu.</p>
      </li>
      <li>Supprimer des contenus <!--/*Remove Pages-->
        <p>Cette permission permet aux utilisateurs de supprimer des éléments de contenu qu\'ils ont édité. Sans cette permission, l\'icône de suppression sur chaque ligne de la liste de contenus sera caché</p>
      </li>
      <li>Réordonner les contenus <!--/*Reorder Pages-->
		<p>Cette permission permet aux utilisateurs qui ont la capacité de modifier tous les éléments de contenu et de réorganiser les éléments les uns par rapport aux autres.</p>
       <p>Exemple : un utilisateur dans un groupe qui a la capacité de modifier l\'élément de contenu avec la hiérarchie 1.3 et tous ces contenus enfants <em>(1.1, 1.2, 1.3, 1.4, etc)</em> sera en mesure de réorganiser ces éléments dans la navigation. Sans cette permission les utilisateurs ne verront pas les icônes de déplacement vers le haut/bas dans la liste.</p>
      </li>
      <li>Gérez tout le contenu <!--/*Manage All Content-->
        <p>Cette permission offre une capacité de super-utilisateur sur tous les éléments de contenu. Les utilisateurs disposant de cette permission peuvent ajouter, modifier, supprimer et réordonner n\'importe quel élément de contenu. Ils ont également la possibilité de définir l\'élément de contenu par défaut et d\'exécuter des actions globales comme le changement de propriétaire qui peuvent ou non être disponibles pour les utilisateurs avec d\'autres permissions.</p>
      </li>
    </ul>
   <p>Il est possible pour un compte utilisateur "Admin" de ne pas être membre d\'un groupe, et pour ce compte d\'utilisateur "Admin" d\'avoir la possibilité <em>(en tant que propriétaire ou éditeur additionnel)</em> de modifier certains éléments de contenu.</p>
 
<h4>Verrouillage (blocage) du contenu <!--/*Content Locking--></h4>
   <p>Le blocage de contenu est un mécanisme qui empêche deux éditeurs d\'éditer le même article en même temps, et donc de détruire le travail de chacun. Les utilisateurs "Admin" bénéficient d\'un accès exclusif à un élément de contenu jusqu\'au moment où ils soumettent les changements.</p>
   <p>Si un élément de contenu est verrouillé, vous ne serez pas en mesure de le modifier jusqu\'à ce que le verrou ait expiré. Voir ci-dessous pour plus d\'informations sur l\'expiration du blocage. Une fois qu\'un verrou a expiré, l\'utilisateur aura la possibilité de "s\'approprier" le verrou de l\'éditeur original et commencer une nouvelle session d\'édition.</p>
   <p>Une icône spéciale apparaît sur la ligne de l\'élément de contenu pour indiquer que le verrouillage peut être volé.</p>
 
<h4>Configuration</h4>
   <p>Certains éléments de configuration affectent la visibilité de certains éléments dans la liste de contenus :</p>
 
<h4>Autre Fonctionnalités <!--/*Other functionality--></h4>
   <ul>
     <li>Affichage des contenus (Limite de page) <!--/*Pagination--->
       <p>La liste de contenu peut être paginée. C\'est un critère de performance pour les grands sites avec beaucoup d\'éléments de contenu. La limite par défaut est de 500 pages, mais cette limite peut être abaissée en ajustant la valeur dans la boîte de dialogue "Options/Paramètres".</p>
     </li>
     <li>Déployer ou Contracter les sections <!--/*Expand/Collapse All-->
       <p>Ces options permettent de développer tous les éléments de contenu afin que les enfants sont visibles. Ou, au contraire, de contracter tous les éléments de contenu afin que les enfants ne soient plus visibles. Cela est utile pour trouver facilement un élément de contenu, ou pour obtenir un aperçu de la structure du site. Chaque élément de contenu avec des enfants peut être déployé ou contracté individuellement.</p>
     </li>
      <li>Recherche <!--/*Searching-->
       <p>La zone de texte "Rechercher" dans le coin supérieur gauche de la liste de contenu permet aux utilisateurs de trouver rapidement et facilement un élément de contenu par son titre ou son texte de menu. Ce formulaire utilise Ajax et s\'autocomplete pour afficher une liste déroulante de tous les éléments correspondants à la chaîne entrée (un minimum de trois caractères est requis).</p>
     </li>
	<li>Actions en séries <!--/*Bulk Actions-->
       <p>Le formulaire "Objets sélectionnés" en bas à droite de la liste de contenu permet aux utilisateurs un accès approprié pour modifier ou interagir en série avec des éléments de contenu. De nombreuses options sont disponibles (en fonction à la fois sur des éléments sélectionnés, et des permissions accordées aux utilisateurs) :</p>
       <ul>
         <li>Supprimer <!--/*Delete-->
           <p>Cette option permet de supprimer plusieurs éléments de contenu (et leurs enfants) en quelques étapes. Tous les éléments de contenu sélectionnés et leurs descendants seront analysés pour leur admissibilité à être supprimés. Les utilisateurs seront ensuite invités  à confirmer l\'action de suppression sur la liste des éléments de contenu qui ont réussi l\'analyse <em>(s\'il y en a)</em>.</p>
	   <p>Seuls les utilisateurs possédant la permission de "Remove pages" et "Modify any page", ou "Manage All Content" peuvent utiliser cette option.</p>
           <p><strong>Note :</strong> Lors de la sélection de nombreux éléments de contenu ou d\'éléments de contenu avec de nombreux descendants, la base de données et la mémoire peuvent être fortement sollicités ce qui peut entraîner un temps de traitement très long.</p>
         </li>
         <li>Rendre actif <!--/*Set Active-->
           <p>Cette option permet de s\'assurer que les éléments de contenu sélectionnés sont marqués comme "Actif". Les utilisateurs seront invités à confirmer l\'opération. Cette opération n\'affecte pas les descendants des pages sélectionnées.</p>
	   <p>Seuls les utilisateurs possédant la permission "Manage All Content" peuvent utiliser cette option.</p>
         </li>
         <li>Rendre inactif <!--/*Set Inactive-->
           <p>cette option analyse les éléments sélectionnés, et activera les éléments de contenu éligibles à l\'état inactif. Les pages inactives ne seront pas affichées dans le menu ce qui peut perturber le site Web. La page par défaut ne peut pas être à l\'état inactif.</p>
	   <p>Seuls les utilisateurs possédant la permission "Manage All Content" peuvent utiliser cette option.</p>
         </li>
         <li>Rendre cachable <!--/*Set Cachable-->
           <p>Cette option définit les éléments de contenu sélectionnés pour être cachables (mis en cache). Cela peut avoir des effets différents en fonction de la configuration du site :<p>
           <p>Si vous avez activé l\'option "Autoriser le navigateur à garder en cache les pages" dans "Administration/Paramètres globaux/Paramètres avancés" alors les éléments de contenu marqués comme "Cachable" (mis en cache) peuvent être mis en cache par le navigateur <em>(ce qui réduit la charge du serveur pour les utilisateurs qui visitent la même page fréquemment).</em></p>
           <p>Il y a aussi dans "Administration/Paramètres globaux/Paramètres Smarty" la possibilité de mise en cache des balises Smarty. Il s\'agit d\'un outil avancé qui met en cache le code HTML généré par et pour un usage répété ce qui peut considérablement réduire la charge du serveur et améliorer les performances. Cependant, il peut agir négativement sur certains éléments de contenu dynamiques.</p>
	   <p>Seuls les utilisateurs possédant la permission "Manage All Content" peuvent utiliser cette option.</p>
         </li>
         <li>Rendre non cachable <!--/*Set Not Cachable-->
           <p>Cette option garantit que les éléments de contenu sélectionnés ne sont pas mis en cache.<p>
         </li>
         <li>Afficher dans le menu <!--/*Show In Menu-->
           <p>Cette option garantit que les éléments de contenu sélectionnés sont visibles dans les menus de navigation du site Web (frontend).</p>
	   <p>Seuls les utilisateurs possédant la permission "Manage All Content" peuvent utiliser cette option.</p>
         </li>
         <li>Masquer dans le menu <!--/*Hide From Menu-->
           <p>Cette option garantit que les éléments de contenu sélectionnés ne seront pas visibles (par défaut) dans les menus de navigation du site Web (frontend). Diverses options de modules de génération de menu de navigation peuvent passer outre le paramètre "Afficher dans le menu".</p>
	   <p>Seuls les utilisateurs possédant la permission "Manage All Content" peuvent utiliser cette option.</p>
         </li>
         <li>Rendre Sécurisé (HTTPS) <!--/*Set Secure (HTTPS)-->
           <p>Cette option permet de s\'assurer que le protocole HTTPS est utilisé lorsque les éléments de contenu sélectionnés sont affichés.</p>
           <p><strong>Note :</strong> Vous devrez peut-être ajuster les paramètres des URLs sécurisées dans le fichier config.php de CMSMS™, et contacter votre hébergeur sur la configuration SSL appropriée.</p>
<p>Seuls les utilisateurs possédant la permission "Manage All Content" peuvent utiliser cette option.</p>
         </li>
         <li>Rendre non sécurisé (HTTP) <!--/*Set Insecure (HTTP)-->
           <p>Cette action supprime l\'option HTTPS à partir des éléments de contenu sélectionnés.</p>
           <p><strong>Note :</strong> Les éléments de contenu sans l\'option sécurisé <em>HTTPS</em> peuvent toujours être affichés via le protocole HTTPS.</p>
	   <p>Seuls les utilisateurs possédant la permission "Manage All Content" peuvent utiliser cette option.</p>
         </li>
         <li>Activer design et gabarit <!--/*Set Design & Template-->
           <p>Ces options permettent d\'afficher une liste déroulante pour définir le design et le gabarit qui seront associés à l\'élément de contenu sélectionné. Seuls certains types d\'éléments de contenu ont un design et une association de gabarit. Exemple : le type "contenu", et ceux fournis par d\'autres modules qui offrent des fonctionnalités similaires.</p>
	   <p>Seuls les utilisateurs possédant la permission "Manage All Content" peuvent utiliser cette option.</p>
         </li>
         <li>Modifier le propriétaire <!--/*Set Owner-->
           <p>Cette option affiche une liste qui permet de changer le propriétaire des éléments de contenu sélectionnés.</p>
	   <p>Seuls les utilisateurs possédant la permission "Manage All Content" peuvent utiliser cette option.</p>
         </li>
       </ul>
     </li>
     <li>Réordonner les contenus <!--/*Reordering--->
       <p>Les utilisateurs disposant de la permission "Manage All Content" ont la possibilité de réorganiser les éléments de contenu en sélectionnant "Réordonner les contenus" dans le menu des options sur la page "Gestionnaire des contenus". Cela donne accès a une page où les éléments de contenu peuvent être réorganisés avec une opération de simple glisser-déplacer.</p>
       <p><strong>Note :</strong> la base de données et la mémoire peuvent être fortement sollicités ce qui peut entraîner un temps de traitement très long sur les sites avec quelques centaines d\'éléments de contenu.</p>
     </li>
   </ul>

<h3>Ajout et modification d\'éléments de contenu <!--/*Adding and Editing Content Items--></h3>
 <p>La possibilité d\'ajouter des éléments de contenu dépend soit de la permission "Manage All Content" ou de la permission "Add Pages". Les utilisateurs disposant de la permission "Manage All Content" seront en mesure de gérer tous les aspects des éléments de contenu. Les utilisateurs ne disposant pas de cette permission auront des possibilités considérablement réduites.</p>
 <p>La page ajout (ou modification) du contenu est divisée en plusieurs onglets. De nombreuses propriétés de l\'élément de contenu seront affichées sur les différents onglets. La liste des onglets visibles et les "propriétés" de ces onglets sont influencées par de nombreux facteurs :</p>
   <ul>
     <li>Type de contenu <!--/*The content item type-->
 <p>Certains types d\'éléments de contenu (tels que Séparateur et En-tête de section) ne nécessitent que très peu d\'informations, donc le nombre d\'onglets et de propriétés affichées seront réduites par rapport aux autres éléments de contenu.</p>
     </li>
     <li>Votre niveau de permission  <!--/*Your permission level-->
       <p>Si votre compte utilisateur n\'a pas la permission "Manage All Content", alors vous ne serez pas autorisé à gérer <em>(par défaut)</em> les propriétés de base de l\'élément de contenu. Vous pourrez modifier le contenu, et choisir une page dans la liste. Vous pouvez également être limité quant à insérer de nouveaux éléments de contenu dans la hiérarchie des contenus.</p>
     </li>
     <li>Les paramètres du site <em>Exemple : les "Propriétés basiques de la page" dans le menu "Paramètres globaux/Paramètres des contenus"</em>.
       <p>Certains paramètres <em>(et même les paramètres de configuration)</em> peuvent influencer l\'affichage des propriétés de cet onglet. Le réglage de "Propriétés basiques de la page" dans le menu "Paramètres globaux/Paramètres des contenus" étend la liste des propriétés de l\'élément contenu que les utilisateurs ayant des permissions restreintes peuvent modifier.</p>
     </li>
     <li>Le gabarit sélectionné  <!--/*The template that has been selected-->
       <p>Les balises dans les gabarits définissent des propriétés supplémentaires <em>(appelées blocs de contenu)</em> que les utilisateurs autorisés peuvent modifier lorsqu\'ils éditent un élément de contenu qui utilise ce gabarit. Ces blocs de contenu peuvent être des zones de texte brut, des zones de texte WYSIWYG, des sélecteurs d\'images ou d\'autres éléments. Les développeurs peuvent spécifier d\'afficher le champ d\'édition dans un onglet pour chaque bloc de contenu.</p>
     </li>
   </ul>
  <h4>Propriétés <!--/*Properties--></h4>
    <p>Ici, nous allons décrire brièvement les propriétés communes pour les types d\'éléments de contenu. Certains types utilisent beaucoup moins de propriétés et certains, fourni par des modules tiers peuvent se comporter de manière totalement différente.</p>
  <ul>
    <li>Principal/Titre de la page <!--/*Title-->
      <p>Ce champ décrit le titre de l\'élément de contenu (le cas échéant). Le titre est généralement affiché dans la balise < title > du "head" de la page HTML, et quelque part dans un endroit bien en vue dans la page HTML du site Web. Le créateur du site a un contrôle complet sur la façon dont cette donnée est utilisée ou affichée.</p>
    </li>

    <li>Options/Alias de page <!--/*Alias-->
      <p>L\'alias de page est une chaîne qui identifie de manière unique un élément de contenu. Il est généralement plus facile à retenir que l\'identifiant numérique ID. L\'alias est utilisé dans de nombreux endroits lors de la création de site Web CMS Made Simple. Il peut être utilisé pour créer des liens vers des éléments de contenu, construire une navigation spécialisée, ou pour guider le comportement d\'autres modules, en indiquant dans quel élément de contenu ils doivent afficher les données.</p>
      <p>Par défaut, les alias de page sont générés uniquement à partir du titre lors de l\'ajout d\'un nouvel élément de contenu, mais l\'utilisateur peut modifier cet alias lorsqu\'il ajoute ou modifie l\'élément de contenu à condition qu\'il soit unique parmi tous les autres éléments de contenu. Certains types d\'éléments de contenu ne nécessitent pas un alias de page.</p>
      <p>Les utilisateurs avec des permissions restreintes peuvent ne pas avoir la possibilité de spécifier l\'alias lors de l\'ajout ou de la modification d\'un élément de contenu.</p>
    </li>

    <li>Navigation/Parent <!--/*Parent-->
      <p>La propriété "Parent" spécifie l\'élément qui est le parent immédiat du contenu en cours de modification dans la hiérarchie des contenus. Les utilisateurs avec des permissions restreintes peuvent ne pas avoir la possibilité de modifier cette propriété, ou pourraient avoir une liste restreinte d\'options.</p>
    </li>

    <li>Principal/Type de contenu <!--/*Content-->
      <p>Chaque gabarit de page doit inclure au moins un contenu par défaut <em>(block)</em>. Toutefois, il est possible de définir d\'autre blocs, et aussi différents types de blocs de contenu. Le bloc par défaut apparaît généralement sous la forme d\'une zone de texte WYSIWYG compatible permettant à l\'utilisateur d\'entrer un contenu par défaut pour la page.</p> A TRADUIRE
      <p>Les développeurs du site ont un contrôle important sur cette propriété et les paramètres qu\'elle affiche comme le label, la longueur maximale du texte et d\'autres attributs qui permettent de contrôler son comportement dans le formulaire d\'édition et le moment où elle sera affichée<p>
      <p>Si l\'éditeur WYSIWYG est activé pour ce bloc de contenu et si l\'utilisateur a sélectionné un éditeur WYSIWYG dans "Préférences/Mon compte/Préférences utilisateur", un éditeur WYSIWYG s\'affichera. Les WYSIWYG ont des capacités différentes pour formater le texte. De plus, la plupart des éditeurs WYSIWYG permettent l\'insertion d\'images, la création des liens vers d\'autres éléments de contenu dans votre site Web.</p>
    </li>

    <li>Navigation/Texte du menu <!--/*Menu Text-->
      <p>Cette propriété est utilisée lors de la construction des menus de navigation. Le contenu de ce champ est utilisé comme le texte à afficher dans le menu pour cet élément de contenu.</p>
    </li>

    <li>Navigation/Afficher dans le menu <!--/*Show in Menu-->
      <p>Souvent, il est utile d\'avoir des éléments de contenu qui seront utilisés à des fins spéciales (par exemple pour afficher un sitemap, des résultats de recherche, un formulaires de login, etc) et de ne pas désirer les voir affichés <em>(par défaut)</em> dans les menus de navigation. Cette propriété permet à un élément de contenu d\'être caché dans les menus, sauf contrordre par ailleurs.</p>
      <p>Les utilisateurs avec des permissions restreintes peuvent ne pas avoir la possibilité de régler ou spécifier cette propriété.</p>
    </li>

    <li>Navigation/Description (attribut title)  <!--/*Title Attribute-->
      <p>Cette propriété définit une chaîne de texte optionnel qui peut être utilisé pour afficher des informations supplémentaires sur l\'élément de contenu dans le menu. Il est généralement utilisé dans l\'attribut "title" pour le lien qui est généré dans les menus de navigation.</p>
      <p>Le créateur du site a la capacité d\'afficher cette donnée différemment, ou de l\'ignorer complètement en modifiant le gabarit menu de navigation approprié. En outre, cette donnée peut être affichées dans le contenu de la page en modifiant le gabarit de page approprié. Cette propriété peut ne pas être importante pour les éléments de contenu de votre site Web.</p>
      <p>Les utilisateurs avec des permissions restreintes peuvent ne pas avoir la possibilité de régler ou spécifier cette propriété.</p>
    </li>

    <li>Navigation/Attribut raccourci clavier (accesskey)  <!--/*Access Key-->
      <p>Cette propriété définit un raccourci clavier facultatif <em>formé habituellement par un ou deux caractères</em> qui peut être utilisé pour accéder rapidement à l\'élément de contenu dans un menu de navigation. Cette fonction est très utile lors de la construction de menus respectant les "Règles d\'accessibilité du Web".</p>
      <p>Le créateur du site a une capacité complète d\'inclure ou d\'exclure l\'utilisation de cette propriété dans ses gabarits de navigation. Et il peut ne pas être nécessaire pour votre site Web.</p>
      <p>Les utilisateurs avec des permissions restreintes peuvent ne pas avoir la possibilité de régler ou spécifier cette propriété.</p>
    </li>

    <li>Navigation/Attribut tabindex (navigation au clavier) <!--/*Tab Index-->
      <p>Cette propriété est utilisée pour spécifier un numéro d\'index (nombre entier) facilitant la navigation au clavier dans les menus. Elle est utile pour créer des sites respectant les "Règles d\'accessibilité du Web".</p>
      <p>Le créateur du site a une capacité complète d\'inclure ou d\'exclure l\'utilisation de cette propriété dans ses modèles de navigation. Elle peut ne pas être nécessaire pour votre site Web.</p>
      <p>Les utilisateurs avec des permissions restreintes peuvent ne pas avoir la possibilité de régler ou spécifier cette propriété.</p>
    </li>

    <li>Navigation/Cible <!--/*Target-->
      <p>Cette propriété est utilisée pour spécifier l\'attribut "target" dans des liens vers des éléments de contenu. Elle permet de créer des liens ouvrant les pages de contenu dans des fenêtres ou onglets différents de la fenêtre ou de l\'onglet d\'origine.</p>
      <p>Le créateur du site a une capacité complète d\'inclure ou d\'exclure l\'utilisation de cette propriété dans ses gabarits de navigation. Elle peut ne pas être nécessaire pour votre site Web.</p>
      <p>Les utilisateurs avec des permissions restreintes peuvent ne pas avoir la possibilité de régler ou spécifier cette propriété.</p>
    </li>

    <li>Navigation/URL de page <!--/*Url-->
      <p>Cette propriété est utilisée pour spécifier une URL principale pour cet élément de contenu. Les utilisateurs peuvent spécifier un chemin complet ou une chaîne simple. <em>(ex: path/to/mypage ou keywordstuffedpageurl)</em>. Cette propriété (si elle est spécifiée) est utilisée lors de la construction de menu de navigations ou de liens vers d\'autres éléments de contenu, lorsque les "Pretty URLs" sont activées dans le fichier config.php. Si cette propriété n\'est pas spécifiée, alors l\'alias de page et les autres paramètres contrôlent la navigation vers l\'élément de contenu.</p>
      <p>Pour des fins de SEO,il est important de noter que ce n\'est qu\'une URL principale  <em>(route)</em> vers les éléments de contenu. Les visiteurs du site peuvent toujours accéder à ce contenu par d\'autres moyens, par exemple : mysite.com/index.php?page=alias ou mysite.com/random/random/alias ou mysite.com/alias. Les sites qui sont concernés par les classements des moteurs de recherche doivent s\'assurer que la balise <link rel="canonical"> est correctement configurée dans leurs gabarit de page.</p>
      <p>Les utilisateurs avec des permissions restreintes peuvent ne pas avoir la possibilité de régler ou spécifier cette propriété.</p>
    </li>

     <li>Options/Actif  <!--/*Active <em>(i.e: disabled)</em>-->
      <p>Cette propriété est utilisée pour indiquer si cet élément de contenu peut être visible par tous sur le  site Web.</p>
      <p>Les utilisateurs avec des permissions restreintes peuvent ne pas avoir la possibilité de régler ou spécifier cette propriété.</p>
    </li

     <li>Options/Utiliser le protocole HTTPS <!--/*Secure (HTTPS)-->
		<p>Cette propriété est utilisée pour indiquer si cet élément de contenu doit être accessible en utilisant le protocole HTTPS. Dans un site configuré correctement pour le protocole HTTPS, si cet attribut est défini pour un élément de contenu, et si une tentative est faite pour accéder à cette page via le protocole HTTP non sécurisé, l\'utilisateur sera redirigé vers la même page en utilisant le protocole HTTPS, plus sécurisé. En outre, si cette option est activée, tous les liens vers cet élément de contenu utiliseront le protocole HTTPS.</p>
        <p>Il est important de savoir que des éléments de contenu sans le HTTPS peuvent encore être parcourus à l\'aide du protocole HTTPS, et qu\'aucune redirection n\'aura lieu. Par conséquent, aux fins de classement des moteurs de recherche la balise <link rel="canonical"> doit être configurée correctement dans chaque gabarit de page.</p>
    </li>

    <li>Options/Cachable  <!--/*Cachable-->
		<p>Cette propriété spécifie si la forme compilée de cet élément de contenu peut être mis en cache sur le serveur afin de réduire la charge de ce dernier <em>(si le cache de Smarty est activé dans les paramètres globaux)</em> ET si le navigateur peut mettre en cache cette page <em>(si la mise en cache du navigateur est activé dans les paramètres globaux)</em>. Pour les sites Web en grande partie statique la mise en cache de Smarty et du navigateur peuvent réduire considérablement la charge du serveur et donc améliorer la performance globale du site.</p>
        <p>Les utilisateurs avec des permissions restreintes peuvent ne pas avoir la possibilité de régler ou spécifier cette propriété.</p>
    </li>

    <li>Options/Image <!--/*Image-->
		<p>Cette propriété permet d\'associer une image, précédemment uploadée, à cet élément de contenu. Les éditeurs peuvent sélectionner un fichier image à partir du dossier uploads/images. Cette image peut être affichée sur la page HTML générée (le cas échéant), ou utilisée lors de la construction du menu de navigation.</p>     
       <p>Les utilisateurs avec des permissions restreintes peuvent ne pas avoir la possibilité de régler ou spécifier cette propriété.</p>
    </li>

    <li>Options/Vignette <!--/*Thumbnail-->
        <p>Cette propriété permet d\'associer une vignette image créée précédemment avec cet élément de contenu. Les éditeurs peuvent sélectionner un fichier de vignette à partir du dossier uploads/images. Cette vignette peut être affichée sur la page HTML générée (le cas échéant), ou utilisée lors de la construction du menu de navigation.</p>
        <p>Les utilisateurs avec des permissions restreintes peuvent ne pas avoir la possibilité de régler ou spécifier cette propriété.</p>
    </li>

    <li>Permissions/Propriétaire  <!--/*Owner-->
        <p>Cette propriété est un champ déroulant qui indique quel compte utilisateur "Admin" a la responsabilité principale de l\'élément de contenu. Par défaut, le propriétaire de l\'élément de contenu est le premier utilisateur qui l\'a créé. Les utilisateurs disposant d\'un niveau de permission suffisant peuvent affecter la propriété d\'un élément à un autre utilisateur.</p>
    </li>

    <li>Permissions/Autres éditeurs  <!--/*Additional Editors-->
        <p>Cette propriété spécifie une liste d\'autres utilisateurs "Admin" ou groupes d\'administration qui sont autorisés à modifier cet élément de contenu. C\'est un champ multi-sélection. Les utilisateurs disposant de permissions restreintes peuvent ne pas avoir la possibilité d\'utiliser cette propriété.</p>
    </li>

     <li>Options/Design <!--/*Design-->
        <p>La propriété permet d\'associer un design à l\'élément de contenu. Un design est utilisé pour déterminer les feuilles de style et les autres éléments qui contribuent à l\'affichage de l\'élément de contenu. Le design est associé à différents gabarits. Une modification de la propriété "Design" peut entraîner automatiquement une modification du gabarit. Par défaut, c\'est le "design par défaut" de la "Gestion du design" (Design Manager) qui est sélectionné. Les utilisateurs disposant de permissions restreintes peuvent ne pas avoir la possibilité d\'utiliser cette propriété.</p>
    </li>

	<li>Options/Gabarit  <!--/*Template-->
        <p>La propriété du gabarit de page est utilisée pour déterminer la disposition générale de l\'élément de contenu (pour les éléments de contenu qui génèrent du HTML). Il détermine également l\'utilisation des balises meta et des blocs de contenu. La modification de ce gabarit actualisera la page et affichera les propriétés de contenu appropriées (blocs) qui sont précisés dans le gabarit nouvellement sélectionné.</p>
        <p>Les utilisateurs avec des permissions restreintes peuvent ne pas avoir la possibilité de régler ou spécifier cette propriété.</p>
    </li>

        <li>Options/Effectuer la recherche  <!--/*Searchable-->
        <p>Cette propriété contrôle si les propriétés de cet élément de contenu peuvent être indexées par le module de recherche.</p>
        <p>Les utilisateurs avec des permissions restreintes peuvent ne pas avoir la possibilité de régler ou spécifier cette propriété.</p>
    </li>

    <li>Options/Désactiver l\'éditeur WYSIWYG <!--/*Disable WYSIWYG-->
        <p>Cette propriété permet de désactiver l\'éditeur WYSIWYG pour tous les blocs de contenu de cet élément. Cela annule tous les réglages sur les blocs de contenu, et tous les réglages de l\'utilisateur. Ceci est utile pour les éléments de contenu qui contiennent de la logique pure dans les blocs de contenu, ou qui sont appelés par d\'autres modules. Cela évite que le code ou les données fournies par des modules ne soient altérés par le style injecté par le WYSIWYG.</p>
        <p>Les utilisateurs avec des permissions restreintes peuvent ne pas avoir la possibilité de régler ou spécifier cette propriété.</p>
    </li>

    <li>Logique/Métadonnées spécifiques  <!--/*Page Metadata-->
        <p>Cette propriété est destinée à injecter des métadonnées dans la section <head> de la page HTML générée. En général, cela injecte une balise meta description.</p>      
        <p>Les utilisateurs avec des permissions restreintes peuvent ne pas avoir la possibilité de régler ou spécifier cette propriété.</p>
    </li>
	
    <li>Logique/Balises Smarty spécifiques  <!--/*Page Data-->
        <p>Cette propriété est principalement utilisée pour insérer des données, ou de la logique Smarty utilisées par le gabarit de la page. C\'est un champ destiné à être utilisé dans des gabarits flexibles avec un comportement dynamique.</p>
        <p>Les utilisateurs avec des permissions restreintes peuvent ne pas avoir la possibilité de régler ou spécifier cette propriété.</p>
    </li>

    <li>Logique/Attribut supplémentaire 1, 2, 3  <!--/*extra1, extra2, and extra3-->
        <p>Champs supplémentaires pour une utilisation dans l\'affichage de données, ou pour agir sur le comportement du gabarit.</p>
    </li>
   </ul>';
$lang['help_designmanager_help'] = '<h3>Quel est ce module&nbsp;?</h3>
<p>La Gestion du design (Design Manager) est un module du noyau (core) <em>(distribué avec CMSMS™)</em>, qui unifie les fonctionnalités de gestion de la mise en page du site Web. Il fournit une solution complète pour la gestion et l\'édition de tout type de gabarit Smarty, et pour l\'organisation de ces gabarits. Ainsi, vous pouvez créer, modifier, supprimer et gérer les feuilles de style et les gabarits et les organiser en "Designs".</p>

<h3>Qu\'est-ce qu\'un "Design" <!--/*What is a "Design" ?--></h3>
<p>Un design (conception) est un conteneur associant feuilles de styles et gabarits. Il permet la gestion de tous les feuilles de styles et gabarits nécessaires pour mettre en œuvre la présentation du site Web. Les designs peuvent être exportés et importés à partir d\'un fichier unique.</p>
<p>Chaque page de contenu HTML est associée à un design pour déterminer quelles feuilles de style doivent être utilisées et dans quel ordre. Par ailleurs, chaque page de contenu HTML est associée à un gabarit, ce gabarit n\'a pas besoin d\'être associé à un design.</p>
<p>Les gabarits et feuilles de style n\'ont pas besoin d\'être associés à un design, toutefois, seuls les gabarits et les feuilles de style qui sont associés à un design sont exportables avec le design.</p>

<h3>Que sont les types de gabarits ?  <!--/*What are Template Types ?--></h3>
  <p>Les gabarit types permettent d\'organiser les gabarits de manière souple. Certaines fonctionnalités peuvent afficher des listes de gabarits qui sont d\'un certain type afin d\'en faciliter la sélection. Par exemple, le contenu édition de la page affiche une liste de gabarits "de page". (le gabarit "Left simple navigation + 1 column" est donc un gabarit de type "Core::Page").</p>
  <p>Le noyau (core) crée quelques types de gabarits standard lors de l\'installation. Les modules tiers vont probablement en créer plus. les définitions de types de gabarits ont normalement deux parties, l\'initiateur <em>(le module ou la fonctionnalité qui les a créés)</em>, et le nom du type lui-même. Exemple : Core::Page [Nom descriptif] indique un gabarit de type page créé par le noyau . Article::Sommaire (News::Summary) est le nom du type de gabarit pour les sommaires des articles. Bien que les développeurs de sites ne puissent pas créer de nouveaux gabarit modèles , ils peuvent spécifier le type lors de l\'ajout ou de la modification d\'un gabarit.</p>
  <p>La plupart des types de gabarit ont un modèle "prototype" utilisé pour un squelette lors de la création d\'un nouveau gabarit de ce type.</p>
  <p>Certains types de gabarits (comme le gabarit "Core::Page") sont des exemples de "gabarit par défaut". Le gabarit-type par défaut est généralement utilisé par des modules dans le cas où un gabarit spécifique ne serait pas défini. De plus, le gabarit par défaut de type "Core::Page" est utilisé comme gabarit par défaut lorsque vous créez un nouvel élément de contenu de type "Contenu de page (Content Page)"</p>
  <p>L\'interface de la "Gestion du design" (Design Manager) permet de filtrer les gabarits par leur type, auteur, design, utilisateur afin de trouver facilement des gabarits pour les modifier ou les gérer.</p>

  <h4>Gabarits génériques <em>(anciens Blocs de contenu globaux)</em> <!--/*Generic Templates <em>(formerly Global Content Blocks</em>--></h4>
    <p>Un type de gabarit standard est appelé "Core::generic". Il s\'agit d\'un modèle générique qui pourra être utilisé pour n\'importe quoi. Il remplace le "Blocs de contenu global" <em>(Global Content Blocks GCB)</em> des versions antérieures de CMSMS™.</p>

<h3>Que sont les catégories ? <!--/*What are "Categories" for ?--></h3>
  <p>Les catégories sont une méthode d\'organisation des gabarits pour les développeurs. Les développeurs de sites peuvent créer, renommer et supprimer des catégories et les différents gabarits associés. Pour gérer les gabarits, les développeurs peuvent filtrer les gabarits par leur catégorie.</p>

<h3>L\'interface principale <!--/*The Primary Interface--></h3>
  <p>Le panneau d\'administration "Gestion du design" (Design Manager) se trouve dans l\'administration de CMS Made Simple dans le menu "Disposition".</p>
  <p>L\'administration de ce module utilise des onglets. Chaque onglet à un but particulier, et peut exiger des privilèges spéciaux. Seul un utilisateur avec l\'une des <em>permissions nécessaires (ou ayant la propriété ou le statut d\'éditeur supplémentaire sur un ou plusieurs gabarits)</em> sera en mesure de voir la  "Gestion du design" (Design Manager) dans la console d\'administration de CMS Made Simple.</p>
  <ul>
    <li>Onglet Gabarits  <!--/*The Templates Tab-->
      <p>L\'onglet des gabarits fournit toutes les fonctionnalités pour créer et gérer des gabarits commodément et facilement. Il est visible pour les utilisateurs possédant la permission "Modify Templates", ou pour ceux qui sont propriétaires ou encore pour les éditeurs supplémentaire d\'un ou plusieurs gabarits.</p>
<p>Cet onglet comprend certaines caractéristiques : </p>
      <ul>
        <li>Un tableau qui affiche des informations sommaires sur chaque gabarit, et fournit des actions pratiques pour travailler sur des gabarits individuellement ou en masse.</li>
        <li>La capacité de s\'approprier un gabarit verrouillé <!--/*The ability to steal a locked template--></li>
        <li>Filtre avancé  <!--/*Advanced filtering--></li>
        <li>Créer un nouveau gabarit <!--/*Pagination--></li>
      </ul>
    </li>

    <li>Onglet Catégories <!--/*The Categories Tab-->
      <p>L\'onglet catégories est visible pour tous les utilisateurs possédant la permission "Modify Templates". Il offre la possibilité d\'ajouter, modifier, supprimer, renommer et réordonner les catégories.</p>
      <p>Lors d\'ajouts ou de modification d\'une catégorie, il est possible de fournir une description de l\'utilisation de la catégorie à titre de référence.</p>
    </li>

    <li>Onglet Gabarits type  <!--/*The Template Types Tab-->
      <p>Cet onglet est visible pour tous les utilisateurs possédant la permission "Modify Templates". Il offre la possibilité d\'éditer des informations sur le type de gabarit, y compris le gabarit prototype. Il sert à créer un nouveau gabarit de chaque type.</p>
    </li>
      
    <li>Onglet Feuilles de style <!--/*The Stylesheets Tab-->
      <p>Cet onglet est visible pour tous les utilisateurs possédant la permission "Manage Stylesheets." Il offre la possibilité de créer, supprimer, modifier et gérer des feuilles de style.<p>
    </li>

    <li>Onglet Designs  <!--/*The Designs Tab-->
      <p>Cet onglet est visible pour tous les utilisateurs possédant la permission  "Manage Designs". <strong>(Remarque : seul les utilisateurs avec cette permission peuvent avoir accès à toutes les fonctions de cet onglet)</strong>.</p>
      <p>Cet onglet permet d\'importer, d\'exporter, de créer, modifier et supprimer des designs.</p>
    </li>
  </ul>
<h3>Gestion des gabarits <!--/*Managing Templates--></h3>
 <p>l\'onglet "Gabarits" affiche une liste de gabarits correspondant au filtre actuel <em>(si appliqué)</em> dans un tableau, avec pagination. Chaque ligne du tableau représente un gabarit unique. Les colonnes du tableau affichent des informations sommaires sur le gabarit et offrent une interaction possible avec les éléments de la ligne.</p>
 <p>Un menu déroulant "Option/Filtre" offre la possibilité de basculer entre les lignes des gabarits qui correspondent au filtre sélectionné, si plus d\'une ligne du gabarit correspondant est affichée. La boîte de dialogue de filtre permet de sélectionner les gabarits affichés sur un certain nombre de critères, changer le nombre de pages (Limite), et trier les gabarits affichés.</p>
 <p>Le menu "Option" offre la possibilité aussi de créer un nouveau gabarit <em>(selon les permissions)</em>.</p>
   <h4>Les colonnes : <!--/*Table Columns:--></h4>
   <ul>
     <li>Id :
       <p>Cette colonne affiche l\'identifiant numérique unique pour le gabarit. En cliquant sur le lien de la ligne dans cette colonne, le gabarit sera édité . En survolant le texte du lien avec la souris, une info-bulle affichera des informations sur le gabarit.</p>
     </li>
     <li>Nom : <!--/*Name:-->
       <p>Cette colonne affiche le nom unique du gabarit.  En cliquant sur le lien de la ligne dans cette colonne, le gabarit sera édité. En survolant le texte du lien avec la souris, une info-bulle affichera des informations sur le gabarit.</p>
     </li>
     <li>Type : <!-- /*Type:-->
       <p>Cette colonne affiche le type de gabarit. En survolant le texte du lien avec la souris, une info-bulle affichera des informations sur le gabarit.</p>
     </li>
     <li>Design :  <!--/*Design:-->
       <p>Cette colonne indique le(s) design(s) auquel(s) le gabarit est associé (le cas échéant). Si le gabarit est associé à plusieurs designs une info-bulle affiche une liste des premiers designs associés.</p>
     </li>
     <li>Défaut	: <!--/*Default:-->
       <p>Cette colonne affiche une icône indiquant si le gabarit a la valeur par défaut pour son type.</p>
     </li>
     <li>Actions :
       <p>Selon les privilèges des utilisateurs, il y aura une ou plusieurs icônes affichées dans cette colonne pour effectuer diverses actions sur, ou avec le gabarit :</p>
       <ul>
          <li>Éditer - Affiche un formulaire pour modifier le contenu et les attributs du gabarit.</li>
          <li>Copier - Affiche un formulaire pour permettre la copie du gabarit sélectionné sous un nouveau nom. Pour plus de commodité un nom par défaut sera fourni.</li> 
          <li>Supprimer - Affiche un formulaire pour permettre la suppression du gabarit sélectionné. Une confirmation supplémentaire sera nécessaire pour cette action car aucun contrôle n\'est possible pour savoir si le gabarit est déjà utilisé par une autre page, ou de manière récursive par tout autre gabarit.</li>
       </ul>
       
     </li>
     <li>Sélection multiple :  <!--/*Multiselect:-->
	  <p>Cette colonne (selon permissions) affiche une case à cocher permettant la sélection de plusieurs gabarits pour effectuer des actions simultanées (en séries).</p>
     </li>
   </ul>
   <h4>Actions en séries :  <!--/*Bulk Actions:--></h4>
    <p>Effectue des actions (supprimer, exporter, importer) sur plusieurs gabarits en même temps. Ces actions sont choisies à partir d\'un menu déroulant situé au bas de la page. Soyez extrêmement prudent lorsque vous effectuez ces actions en série car cela pourrait affecter sévèrement le site Web.</p>
  
  <h4>Éditer un gabarit  <!--/*Editing Templates--></h4>
    <p>La page édition du gabarit est un formulaire complexe qui permet la gestion de l\'ensemble des attributs d\'un gabarit. Par commodité, ce formulaire est divisé en plusieurs onglets.</p>
    <p>Ce formulaire utilise la fonctionnalité "dirtyform" pour réduire la perte accidentellement des données si les modifications n\'ont pas été enregistrées. Si le gabarit n\'a pas été enregistré, les utilisateurs en seront avertis avant de quitter cette page.</p>
    <p>Ce formulaire verrouille le gabarit sélectionné afin que d\'autres éditeurs autorisés n\'aient pas la possibilité de modifier le gabarit en même temps. Cela empêche d\'écraser accidentellement les modifications de l\'utilisateur.</p>
	<p>Voici quelques-uns des attributs du gabarit qui peuvent être édité :</p>
    <ul>
      <li>Nom : <!--/*Name:-->
         <p>Ce texte identifie le gabarit. Le système va générer une erreur lors de la sauvegarde du gabarit si le nom est déjà utilisé par un autre gabarit.</p>
      </li>
      <li>Gabarit :  <!--/*Template Content:-->
        <p>Cette zone de texte affiche le gabarit Smarty. Si un module éditeur de syntaxe colorée est installé et activé et si l\'utilisateur l\'a sélectionné dans "Mes préférences/Mon compte/Préférences utilisateur", il sera alors opérationnel dans cette zone pour fournir des fonctionnalités avancées d\'édition.</p>
      </li>
      <li>Onglet Description :  <!--/*Description:-->
        <p>Cette zone de texte prévoit la possibilité de décrire le but des gabarits, et aussi d\'inclure des notes qui peuvent être utiles aux éditeurs dans l\'avenir.</p>
      </li>
      <li>Onglet Designs : <!--/*Designs:-->
        <p>Selon les niveaux de permissions, cet onglet permet d\'associer le gabarit avec aucun ou plusieurs designs.</p>
      </li>
      <li>Onglet Avancé :  <!--/*Advanced:-->
        <p>Cet onglet affiche les champs qui permettent de spécifier la catégorie du gabarit, son type et s\'il est le gabarit par défaut pour son type. Cet onglet est disponible uniquement avec les permissions appropriées.</p>
      </li>
      <li>Onglet Permissions :
        <p>Si le compte utilisateur est le propriétaire du gabarit, ou a s\'il a la permission "Modify Templates", cet onglet permet de changer le propriétaire du gabarit, et/ou de spécifier des éditeurs supplémentaires.</p>
      </li>
      <li>Activer sur toutes les pages : <!--/*Set All Pages:-->
        <p>Les utilisateurs disposant de la permission "Modify Templates" verront un bouton qui permettra d\'activer ce gabarit sur tous les contenus.</p>
      </li>
    </ul>
<h3>Gestion des catégories  <!--/*Managing Categories--></h3>
  <p>La permission "Modify Templates" est nécessaire pour afficher cet onglet, et ses actions associées.</p>
  <p>L\'onglet Catégories est une interface simple qui permet de créer, éditer, supprimer et réordonner les catégories. Les catégories peuvent être réorganisés par glisser-déposer dans l\'ordre désiré.</p>
  <p>La modification d\'une catégorie permet de spécifier une description pour cette catégorie. La description est utile pour information sur l\'objet de la catégorie.</p>
<h3>Gestion des gabarits <!--/*Managing Template Types--></h3>
  <p>La permission "Modify Templates" est nécessaire pour afficher cet onglet, et ses actions associées.</p>
  <p>Les utilisateurs disposant de privilèges suffisants peuvent ajuster le gabarit prototype et la description pour chaque type de gabarit. Le gabarit prototype sera utilisé comme le contenu par défaut pour le gabarit lors de la création d\'un nouveau gabarit de ce type.</p>
<h3>Gestion des feuilles de style <!--/*Managing Stylesheets--></h3>
    <p>L\'onglet Feuilles de style est disponible pour les utilisateurs disposant de la permission "Manage Stylesheets". Il affiche dans un tableau avec pagination une liste de tous les styles correspondant au filtre actuel <em>(si appliqué)</em>. Chaque ligne du tableau représente une seule feuille de style. Les colonnes du tableau affiche des informations sommaires sur la feuille de style et offre une interaction possible avec les éléments de la ligne.</p>
  
  <p>Le menu "Option" permet de paramétrer le filtre mais aussi de créer une nouvelle feuille de style (selon les permissions).</p>
<p>Un menu déroulant "Option/Filtre" offre la possibilité de n\'afficher que les feuilles de style qui correspondent au filtre sélectionné, si des feuilles de style correspondant à ce filtre existent. La boîte de dialogue de filtre permet également de sélectionner et de trier les feuilles de style affichées sur un certain nombre de critères et de changer le nombre de pages (Limite).</p>
  <h4>Les colonnes : <!--/*Table Columns:--></h4>
  <ul>
    <li>Id :
     <p>Cette colonne affiche l\'identifiant numérique unique pour la feuille de style. En cliquant sur le lien de la ligne dans cette colonne, le feuille de style sera éditée. En survolant le texte du lien avec la souris, une info-bulle affichera des informations sur la feuille de style.</p>
    </li>
    <li>Nom : <!--/*Name:-->
     <p>Cette colonne affiche un texte le nom unique pour la feuille de style. En cliquant sur le lien de la ligne dans cette colonne, la feuille de style sera éditée. En survolant le texte du lien avec la souris, une info-bulle affichera des informations sur la feuille de style.</p>
    </li>
    <li>Design :  <!--/*Design:-->
      <p>Cette colonne indique le(s) design(s) auquel la feuille de style est associée (le cas échéant). Si la feuille de style est associée à plusieurs designs une info-bulle affiche une liste des premiers designs associés.</p>
    </li>
    <li>Date de modification : <!-- /*Modified Date:-->
      <p>Cette colonne affiche la date à laquelle la feuille de style a été modifiée.</p>
    </li>
    <li>Actions :
	<p>Selon les privilèges des utilisateurs, il y aura une ou plusieurs icônes affichées dans cette colonne pour effectuer diverses actions sur, ou avec la feuille de style :</p>
      <ul>
        <li>éditer - Affiche un formulaire pour modifier le contenu et les attributs de la feuille de style.</li>
        <li>Supprimer - Affiche un formulaire pour permettre la suppression de la feuille de style. Une confirmation supplémentaire sera nécessaire pour cette action.</li>
      </ul>
    </li>
    <li>Sélection multiple : <!--/*Multiselect:-->
      <p>Cette colonne (selon permissions) affiche une case à cocher permettant la sélection de plusieurs feuilles de style pour effectuer des actions simultanées (en séries).</p>
    </li>
  </ul>
  <h4>Actions en séries : <!--/*Bulk Actions:--></h4>
    <p>A partir d\'un menu déroulant avec des options (actuellement uniquement Supprimer) effectue des actions sur plusieurs feuilles de style en même temps. Soyez extrêmement prudent lorsque vous effectuez ces actions en séries car cela pourrait affecter sévèrement le site Web.</p>
  <h4>Édition des feuilles de style  <!--/*Editing Stylesheets--></h4>
    <p>La page édition de la feuille de style est un formulaire complexe qui permet la gestion de l\'ensemble des attributs d\'une feuille de style. Par commodité, ce formulaire est divisé en plusieurs onglets. Ce formulaire utilise la fonctionnalité "dirtyform" pour réduire la perte accidentellement des données si les modifications ne sont pas enregistrées, et verrouille la feuilles de style sélectionnée afin que d\'autres éditeurs autorisés n\'aient pas la possibilité de modifier en même temps.</p>    <p>Voici quelques-uns des attributs d\'une feuille de style qui peuvent être édité :</p>
    <ul>
      <li>Nom : <!--/*Name:-->
        <p>Ce texte identifie la feuille de style. Le système va générer une erreur lors de la sauvegarde de la feuille de style si le nom est déjà utilisé par une autre feuille de style.</p>
      </li>
      <li>Feuille de style contenu :  <!--/*Stylesheet Content:-->
        <p>Cette zone de texte affiche le code CSS. Si un module de syntaxe surlignée supportant le CSS est installé et activé, et si l\'utilisateur l\'a sélectionné dans "Mes préférences/Mon compte/Préférences utilisateur", il sera alors opérationnel dans cette zone pour fournir des fonctionnalités avancées d\'édition.</p>
      </li>
      <li>Onglet Type de média  <em style="color: red;">(Obsolète)</em> : <!--/*Media Types <em style="color: red;">(deprecated)</em>:-->
        <p>Cet onglet fournit de nombreuses cases à cocher vous permettant de sélectionner les types de médias à associer à la feuille de style. Il est préférable d\'utiliser Media Query (requêtes de média) en remplacement, cette fonctionnalité sera supprimée à une date ultérieure.</p>
      </li>
      <li>Onglet Media Query (requêtes de media) : <!--/*Media Query:-->
        <p>Cet onglet fournit une zone de texte où une requête de média peut être associée à la feuille de style.</p>
      </li>
      <li>Onglet Description :
        <p>Cette zone de texte prévoit la possibilité de décrire le but des feuilles de style, et d\'inclure des notes qui peuvent être utiles aux éditeurs dans l\'avenir.</p>
      </li>
      <li>Onglet Designs :
        <p>
		Selon les niveaux de permissions, cet onglet permet d\'associer la feuille de style avec un ou plusieurs designs. Si de nouveaux designs sont détectés cette feuille de style sera placé à la fin de la liste pour ce design.</p>
      </li>
    </ul>
<h3>Gestion des designs  <!--/*Managing Designs--></h3>
  <p>L\'onglet "Designs" est disponible pour les utilisateurs disposant de la permission "Manage Designs". Il affiche une liste de tous les designs connus dans un tableau. Chaque ligne du tableau représente un design unique. Les colonnes du tableau affichent des informations sommaires sur le design et offre une interaction possible sur le design.</p>
  <p>Cet onglet ne permet pas le filtrage, la pagination, ou les actions en séries car le nombre de design pour le site Web doit être limité pour être gérable.</p>
  <p>(en version 2.x) Un menu déroulant "Option" offre la possibilité de créer un nouveau design, ou d\'importer un design au format XML.</p>
  <p>(en version 2.2) Un menu offre la possibilité de créer un nouveau design et un autre menu offre la possibilité  d\'importer un design au format XML.</p>
  <h4>Les colonnes <!--/*Table Columns--></h4>
  <ul>
    <li>Id :
      <p>Cette colonne affiche l\'identifiant numérique unique pour le design. En cliquant sur le lien de la ligne dans cette colonne, le design sera édité.</p>
    </li>
    <li>Nom : <!--/*Name:-->
      <p>Cette colonne affiche un texte du nom unique pour le design. En cliquant sur le lien de la ligne dans cette colonne, le design sera édité.</p>
    </li>
    <li>Défaut :	<!--/*Default:-->
      <p>Cette colonne affiche une icône si le design a la valeur par défaut . Le design par défaut est sélectionné en premier lors de la création d\'un nouvel élément de contenu de type "contenu de page" et peut être utilisé à d\'autres fins. Un seul design peut-être a la valeur par défaut.</p>
    </li>
    <li>Actions :
      <p>Selon les privilèges des utilisateurs, il y aura une ou plusieurs icônes affichées dans cette colonne pour effectuer diverses actions sur, ou avec le design :</p>
      <ul>
        <li>Éditer - Affiche un formulaire pour modifier le contenu et les attributs du design.</li>
        <li>Exporter - Exporte le design dans un fichier XML qui peut être importé dans d\'autres sites.</li>
        <li>Supprimer - Affiche un formulaire pour permettre la suppression du design sélectionné. Une confirmation supplémentaire sera nécessaire pour cette action.</li>
      </ul>
    </li>
  </ul>
  <h4>Édition des designs  <!--/*Editing Designs:--></h4>
    <p>La page édition du design est un formulaire complexe qui permet la gestion de l\'ensemble des attributs du design. Par commodité, ce formulaire est divisé en plusieurs onglets. Contrairement à l\'édition des feuilles de style et gabarits, ce formulaire n\'utilise pas les fonctionnalités "dirtyform" et verrouillage.</p>
    <p>Voici quelques-uns des attributs du design qui peuvent être édité :</p>
    <ul>
     <li>Nom : <!--/*Name:-->   
<p>Ce texte identifie le design. Le système va générer une erreur lors de la sauvegarde du design si le nom est déjà utilisé avec un autre design.</p>
      </li>
      <li>Gabarits <!--/*Templates:-->
        <p>Cet onglet permet de sélectionner les différents gabarits à associer au design.Vous avez la possibilité d\'utiliser le glisser-déplacer pour ajouter, ordonner des gabarits dans la liste "Gabarits attachés".  Le nom d\'un gabarit est cliquable et permet d\'accéder directement à son édition (nouveautés de la V 2.2). Actuellement l\'ordre des gabarits dans la liste de gabarits attachés n\'est pas importante.</p>
      </li>
      <li>Onglet Feuilles de style <!--/*Stylesheets:-->
	  <p>Cet onglet permet de sélectionner différents styles à associer au design. Vous avez la possibilité d\'utiliser le glisser-déplacer pour ajouter et ordonner des feuilles de style dans la liste "Feuilles de style attachées". L\'ordre des feuilles de style dans la liste détermine l\'ordre dans lequel elles seront utilisées lors de la mise en forme des éléments de type "contenu de page". Le nom d\'une feuille de style est cliquable et permet d\'accéder directement à son édition (nouveautés de la V 2.2)</p>
      </li>
      <li>Onglet Description :
        <p>Cette zone de texte prévoit la possibilité de décrire le but du design, et d\'inclure des notes qui peuvent être utiles aux utilisateurs partageant ce design.</p>
      </li>
    </ul>
  <h4>Importer des designs  <!--/*Importing Designs--></h4>
     <p>Le module "Gestion du design" (Design Manager) est capable d\'importer des thèmes XML qui ont été exportés à partir de CMSMS™ Design Manager, ou depuis un ancien gestionnaire de thème CMSMS™. Il décompactera le fichier XML uploadé en gabarits, feuilles de style et autres informations utiles au design. Il effectuera également des modifications mineures des données pour tenter de régler des interférences sur les noms, etc... .</p>
     <p>Le processus d\'importation est divisé en 2 étapes :</p>
     <ul>
      <li>Étape 1 : Uploader le fichier  <!--/*Step 1: Upload the file:-->
        <p>Cette étape gère l\'upload quand l\'utilisateur a sélectionné un fichier XML et validé son contenu. Cette étape est liée à la configuration PHP sur les limites de taille fichier, de mémoire et de temps de traitement. Vous devrez peut-être vérifier et augmenter ces limites pour les gros fichiers XML.</p>
        <p>Dès que le fichier XML est validé, il est copié vers un emplacement temporaire pour le traitement de l\'étape 2.</p>
      </li>
     <li>Étape 2 : Vérifications <!--/*Step 2: Verification:-->
        <p>La deuxième étape consiste à vérifier et à prévisualiser le nouveau design créé à partir du fichier XML. A cette étape, vous pouvez afficher et modifier différents aspects du design.  Une confirmation sera nécessaire pour finaliser cette action.</p>
     </ul>
  <h4>Deleting Designs</h4>
<h3>Using Templates</h3>
<h3>Options and Preferences</h3>
<h3>Upgrade Notes</h3>';
$lang['help_myaccount_admincallout'] = 'Si les favoris sont activés <em>(raccourcis)</em> cela permet de gérer une liste d\'actions fréquemment utilisées dans la console d\'administration.';
$lang['help_myaccount_admintheme'] = 'Choisissez un thème d\'administration à utiliser. Certains thèmes de l\'administration ont des menus différents, fonctionnent mieux sur les mobiles et ont des caractéristiques supplémentaires variées.';
$lang['help_myaccount_ce_navdisplay'] = 'Sélectionnez le champ du contenu qui doit être affiché dans les listes de contenu. Les options incluent le titre de la page ou du texte de menu. Si "Aucun" est sélectionné, la préférence du site sera utilisée.';
$lang['help_myaccount_dateformat'] = 'Spécifiez une chaîne pour le format de date affichés. La chaîne utilise le format PHP <a href="https://php.net/manual/fr/function.strftime.php" class="external" target="_blank">strftime</a>. <strong>Note :</strong> Certains modules tiers peuvent ne pas utiliser à ce paramètre.</strong>.';
$lang['help_myaccount_dfltparent'] = 'Spécifiez la page parent par défaut pour la création d\'une nouvelle page de contenu. L\'utilisation de ce paramètre dépend aussi de vos permissions d\'édition de contenu.<br/><br/>Faite défiler la page parent par défaut en sélectionnant le parent le plus élevé, et les pages enfants successives en utilisant les listes déroulantes affichées.<br/><br/>Le champ de texte sur la droite indiquera toujours la page qui est actuellement sélectionnée.';
$lang['help_myaccount_email'] = 'Indiquez une adresse mail.  Elle sera utilisée pour la fonctionnalité mot de passe perdu, et pour tous les messages de notification envoyés par le système (ou modules).';
$lang['help_myaccount_enablenotifications'] = 'Si activé, le système affichera les différentes notifications à propos des éléments pris en charge lors de la navigation.';
$lang['help_myaccount_firstname'] = 'Éventuellement spécifiez votre prénom. Ceci peut être utilisé dans le thème admin, ou pour vous envoyer des mails.';
$lang['help_myaccount_hidehelp'] = 'Si activé, le système permet de masquer les liens d\'aide du module depuis la console d\'administration. Dans la plupart des cas à l\'aide fournie avec les modules est destinée aux développeurs du site et n\'est pas très utile pour les éditeurs de contenu.';
$lang['help_myaccount_homepage'] = 'Vous pouvez sélectionner une page pour vous rediriger automatiquement lorsque vous vous connectez à la console d\'administration de CMSMS™. Cela peut être utile lorsque vous utilisez principalement une seule fonction.';
$lang['help_myaccount_ignoremodules'] = 'Si les notifications d\'administration sont activées, vous pouvez choisir d\'ignorer les notifications provenant de certains modules';
$lang['help_myaccount_indent'] = 'Cette option permet d\'indenter l\'affichage de la liste de contenu pour illustrer la relation page parent/page enfant.';
$lang['help_myaccount_language'] = 'Sélectionnez la langue d\'affichage de l\'interface "Admin". La liste des langues disponibles peut varier pour chaque installation de CMSMS™.';
$lang['help_myaccount_lastname'] = 'Vous pouvez également indiquer votre nom de famille. Ceci peut être utilisé dans le thème administration ou pour vous envoyer des mails.';
$lang['help_myaccount_password'] = 'Entrer un mot de passe unique et sécurisé pour ce site. Le mot de passe doit contenir plus de six caractères, et utiliser une combinaison de majuscules, de minuscules, de caractères non alphanumériques et de chiffres. Laissez ce champ vide si vous ne souhaitez pas changer votre mot de passe.';
$lang['help_myaccount_passwordagain'] = 'Pour réduire les erreurs, entrez de nouveau votre mot de passe. Laissez ce champ vide si vous ne souhaitez pas modifier votre mot de passe.';
$lang['help_myaccount_syntax'] = 'Sélectionnez le module de coloration syntaxique à utiliser lors de l\'édition HTML ou du code Smarty. La liste des modules disponibles peut varier en fonction de ce que l\'administrateur du site a configuré.';
$lang['help_myaccount_username'] = 'Votre nom d\'utilisateur est votre nom unique pour l\'administration de CMSMS™. Utiliser uniquement des caractères alphanumériques et le trait de soulignement (underscore).';
$lang['help_myaccount_wysiwyg'] = 'Sélectionnez le module éditeur WYSIWYG <em>(What You See Is What You Get)</em> à utiliser lors de l\'édition de contenu. Vous pouvez également sélectionner "Aucun" si vous êtes à l\'aise avec le langage HTML. La liste des éditeurs WYSIWYG disponibles peuvent varier en fonction de ce que l\'administrateur du site a configuré.';
$lang['settings_adminlog_lifetime'] = 'Ce paramètre indique le temps maximum de conservation des entrées dans le journal d\'administration.';
$lang['settings_autoclearcache'] = 'Cette option vous permet de spécifier le temps<em>(en jours)</em> au bout duquel les fichiers dans le dossier de cache seront supprimés.<br/><br/>Cette option est utile pour s\'assurer que les fichiers mis en cache soient régénérés périodiquement et que le système de fichiers ne soit pas pollué par des fichiers anciens et inutiles. Une valeur idéale de ce champ est de 14 ou 30 jours.<br/><br/><strong>Note :</strong> Les fichiers mis en cache sont effacées au plus une fois par jour.';
$lang['settings_autocreate_flaturls'] = 'Si les "pretty URLs" sont activés, et la possibilité de créer automatiquement des URLs est activée, cette option indique que les URLS auto-créées devront être <em>courtes(c\'est à dire identiques à la page alias)</em>.<strong> Note : </strong> Les deux valeurs n\'ont pas besoin de rester identiques, la valeur de l\'URL peut être modifiée pour être différente de la page d\'alias dans les éditions ultérieures de la page.';
$lang['settings_autocreate_url'] = 'Créer automatiquement les URLs, lors de l\'édition des pages de contenu. Le  fait de créer automatiquement les URLs n\'aura aucun effet si les "pretty URLs" ne sont pas activées dans le fichier config.php CMSMS™.';
$lang['settings_badtypes'] = 'Sélectionnez les types de contenu à supprimer de la liste des contenus lors de la modification ou de l\'ajout de contenu. Cette fonction est utile si vous ne voulez pas que les éditeurs puissent créer certains types de contenus. Utilisez Ctrl + click pour sélectionner, ou désélectionner. Si aucun élément n\'est sélectionné, tous les types de contenu seront autorisés. <em>(s\'applique à tous les utilisateurs)</em>.';
$lang['settings_basicattribs2'] = 'Ce champ vous permet de spécifier les propriétés de contenu que les utilisateurs n\'ayant pas la permission "Manage All Content"(Gérer tous les contenus) sont autorisés à modifier.<br /> Cette fonctionnalité est utile lorsque vous avez des éditeurs de contenu avec permission restreinte et que vous voulez permettre l\'édition de propriétés de contenu supplémentaires.';
$lang['settings_browsercache'] = 'Applicable uniquement aux pages cachables, ce paramètre indique que les navigateurs seront autorisés à mettre en cache les pages pour un certain laps de temps. Si activé les visiteurs qui reviennent ne pourront pas voir immédiatement les modifications apportées au contenu des pages, mais l\'activation de cette option peut sérieusement améliorer les performances de votre site Web.';
$lang['settings_browsercache_expiry'] = 'Spécifiez le temps <em>(en minutes)</em> pendant lequel les navigateurs doivent mettre les pages en cache. Définir cette valeur à 0 désactive la fonctionnalité. Dans la plupart des cas, vous devez spécifier une valeur supérieure à 30.';
$lang['settings_checkversion'] = 'Si activé, le système effectue un contrôle quotidien pour une nouvelle version de CMSMS™';
$lang['settings_contentimage_path'] = 'Ce paramètre est utilisé quand un gabarit de page contient la balise {content_image}. Le dossier spécifié ici est utilisé pour fournir une sélection d\'images à associer à la balise.<br/>En relatif du chemin /uploads/, indiquez le nom du dossier qui contient les chemins contenant des fichiers pour la balise {content_image}. Cette valeur est utilisée par défaut pour le paramètre dir.';
$lang['settings_cssnameisblockname'] = 'Si activé, le nom bloc de contenu <em>(id)</em> sera utilisé comme une valeur par défaut pour le paramètre "nom de la feuille de style" pour chaque bloc de contenu.<br/><br/>Ceci est utile pour les éditeurs WYSIWYG. La feuille de style (nom du bloc) peut être chargé par l\'éditeur WYSIWYG et fournir une apparence qui est plus proche de celle de la page Web.<br/><br/><strong>Remarque : </strong> les éditeurs WYSIWYG  peuvent ne pas lire les informations à partir des feuilles de style fournies (si elles existent), cela dépend de leurs capacités et paramètres.';
$lang['settings_disablesafemodewarn'] = 'Cette option permet de désactiver un avertissement si CMSMS™ détecte un <a href="https://php.net/manual/fr/features.safe-mode.php" target="_blank">PHP Safe Mode</a> activé<br/><strong> Note :</strong> "PHP Safe Mode" est obsolète à partir de PHP 5.3.0 et PHP 5.4.0 l\'a supprimé. CMSMS™ Ne supporte pas le "PHP Safe Mode", et notre équipe ne fournira d\'assistance technique pour les installations où le "PHP Safe Mode" est actif.';
$lang['settings_enablenotifications'] = 'Cette option permet d\'activer les notifications affichées en haut de la page dans chaque requête d\'administration. Ceci est utile pour les notifications importantes sur le système qui pourraient nécessiter une action de l\'utilisateur. Il est possible pour chaque utilisateur "Admin" de désactiver les notifications dans leurs préférences.';
$lang['settings_enablesitedown'] = 'Cette option vous permet de basculer le site en "en maintenance" pour les visiteurs du site';
$lang['settings_enablewysiwyg'] = 'Activer l\'éditeur WYSIWYG dans la zone de texte ci-dessous';
$lang['settings_imagefield_path'] = 'Ce paramètre est utilisé lors de l\'édition de contenu. Le dossier spécifié ici est utilisé pour fournir une liste d\'images à partir de laquelle on pourra associer une image à la page de contenu.<br/></br/>En relatif du chemin /uploads/images/, spécifier un nom de dossier contenant les fichiers images.';
$lang['settings_lock_timeout'] = 'Entrez une valeur par défaut (en minutes) pour le délais de verrouillage (blocage de contenu). Est utilisée si la fonctionnalité ne fournit pas une valeur de délai de verrouillage personnalisée.';
$lang['settings_mailprefs_from'] = 'Cette option contrôle l\'adresse que CMSMS™ utilisera <em>par défaut</em> pour envoyer des messages électroniques. Cela ne peut pas être n\'importe quelle adresse e-mail. Elle doit correspondre au domaine qui héberge CMSMS™. La spécification d\'une adresse de courriel à partir d\'un domaine différent est indiqué "<a href="https://en.wikipedia.org/wiki/Open_mail_relay">Open mail relay</a>" et peut très probablement entraîner des problèmes d\'envoi de message, ou peut ne pas être acceptée par le serveur de messagerie du destinataire. Un bon exemple pour ce champ est noreply@mydomain.com';
$lang['settings_mailprefs_fromuser'] = 'Ici vous pouvez spécifier un nom devant être associé à l\'adresse email indiquée ci-dessus. Ce nom peut être n\'importe quoi, mais doit correspondre raisonnablement à l\'adresse mail. Exemple : "Ne pas répondre".';
$lang['settings_mailprefs_mailer'] = 'Ce choix détermine comment CMSMS™ va envoyer les mails. Utiliser la fonction PHP mail, Sendmail,  ou communiquer directement avec un serveur SMTP.<br/><br/>Les options mail et sendmail devraient fonctionner sur la plupart des serveurs Gnu-Linux, mais ne fonctionneront sûrement pas sur la plupart serveurs Windows.<br/><br/>L\'option "sendmail" devrait fonctionner sur la plupart des serveurs Gnu-Linux. Cependant, il ne fonctionnera surement pas sur des serveurs partagés.<br/><br/>L\'option SMTP requiert des informations de configuration de votre serveur.';
$lang['settings_mailprefs_sendmail'] = 'Si vous utilisez la méthode "sendmail", vous devez spécifier le chemin complet vers le programme binaire de sendmail. Une valeur typique de ce champ est "/usr/sbin/ sendmail". Cette option n\'est généralement pas utilisé sur les serveurs Windows.<br/><strong>Note : </strong> Si vous utilisez cette option, votre serveur doit permettre les fonctions PHP "popen et pclose" qui sont souvent désactivé sur les serveurs mutualisés.';
$lang['settings_mailprefs_smtpauth'] = 'Lorsque vous utilisez le SMTP, cette option indique que le serveur SMTP requiert une authentification pour envoyer des mails. Vous devez ensuite spécifier <em>(au minimum)</em> un nom d\'utilisateur et un mot de passe. Votre serveur doit indiquer si l\'authentification SMTP est nécessaire et, si oui, vous fournir un nom d\'utilisateur et un mot de passe, et éventuellement une méthode de cryptage.<br/> <strong>Note : </strong> l\'authentification SMTP est nécessaire si votre domaine utilise Google pour les mails.';
$lang['settings_mailprefs_smtphost'] = 'Lorsque vous utilisez le SMTP, cette option spécifie le nom du serveur <em>(ou adresse IP)</em> du serveur SMTP à utiliser lors de l\'envoi de messages. Vous pouvez avoir besoin de contacter votre hébergeur pour avoir la valeur correcte.';
$lang['settings_mailprefs_smtppassword'] = 'C\'est le mot de passe pour se connecter au serveur SMTP si l\'authentification SMTP est activée.';
$lang['settings_mailprefs_smtpport'] = 'Lorsque vous utilisez l\'authentification SMTP, cette option spécifie le numéro de port pour le serveur SMTP. Dans la plupart des cas, cette valeur est 25. Vous pouvez avoir besoin de contacter votre hébergeur pour avoir la valeur correcte.';
$lang['settings_mailprefs_smtpsecure'] = 'Cette option, lorsque vous utilisez l\'authentification SMTP spécifie un mécanisme de chiffrement à utiliser pour communiquer avec le serveur SMTP. Votre serveur devra fournir cette information si l\'authentification SMTP est requise.';
$lang['settings_mailprefs_smtptimeout'] = 'Lorsque vous utilisez le SMTP, cette option spécifie le nombre de secondes avant qu\'une tentative de connexion au serveur SMTP échoue. Une valeur typique de ce paramètre est 60 .<br/><strong>Note : </strong> Si vous avez besoin d\'une plus grande valeur, cela indique probablement un problème de routage DNS ou un problème de pare-feu et vous devrez peut-être contactez votre hébergeur.';
$lang['settings_mailprefs_smtpusername'] = 'C\'est le nom d\'utilisateur pour se connecter au serveur SMTP si l\'authentification SMTP est activée.';
$lang['settings_mailtest_testaddress'] = 'Indiquez une adresse email valide de réception du message de test.';
$lang['settings_mandatory_urls'] = 'Si les "pretty URLs" sont activées, cette option indique si l\'URL de la page est un champ obligatoire dans l\'éditeur de contenu.';
$lang['settings_nosefurl'] = 'Pour configurer les <em>"pretty URLs"</em> vous aurez besoin de modifier quelques lignes dans votre fichier config.php et éventuellement de modifier un fichier .htaccess ou la configuration de votre serveur. Vous pouvez avoir plus d\'information sur la configuration <a href="https://docs.cmsmadesimple.org/configuration/pretty-url" target="_blank">des URLs </a>.';
$lang['settings_pseudocron_granularity'] = 'Ce paramètre indique à quelle fréquence le système va tenter de gérer les tâches régulièrement planifiées.';
$lang['settings_searchmodule'] = 'Sélectionnez le module qui doit être utilisé pour indexer les mots pour la recherche et qui fournira la capacité de recherche sur le site Web.';
$lang['settings_sitedownexcludeadmins'] = 'Montrer le site pour les utilisateurs admin connectés à la console CMSMS';
$lang['settings_sitedownexcludes'] = 'Montrer le site à ces adresses IP';
$lang['settings_sitedownmessage'] = 'Message affiché aux visiteurs du site Web lorsque le site est en maintenance';
$lang['settings_smartycaching'] = 'Si activé, la sortie des plugins sera mise en cache pour améliorer les performances. En outre, la plupart des parties de gabarits compilées seront mis en cache. Cela s\'applique uniquement à la sortie sur les pages de contenu marquées comme cachable, et seulement pour les utilisateurs non-administrateurs. Remarque, cette fonctionnalité peut interférer avec le comportement de certains modules ou plugins qui utilisent des formulaires non-inline. <br/><br/><strong>Remarque :</strong> Lorsque la mise en cache Smarty est activée, les balises définies par l\'utilisateur <em>(UDT)</em> ne sont jamais mises en cache. En outre, les blocs de contenu ne sont jamais mis en cache.';
$lang['settings_smartycompilecheck'] = 'Si désactivé, Smarty ne vérifiera pas les dates de modification des gabarits pour voir s\'ils ont été modifiés. Cela peut améliorer considérablement les performances. Cependant tout changement de gabarit (ou même quelques modifications de contenu) peut exiger une vidange du cache.';
$lang['settings_thumbfield_path'] = 'Ce paramètre est utilisé lors de l\'édition de contenu. Le dossier spécifié ici est utilisé pour fournir une liste des images à partir de laquelle une vignette est associée au contenu de la page<br/><br/>En relatif du chemin /uploads/images/, spécifier un nom de dossier contenant les fichiers vignettes images. Normalement il doit être le même que les fichiers images.';
$lang['settings_umask'] = 'Le "umask" est une valeur octal qui est utilisé pour spécifier l\'autorisation par défaut pour les fichiers nouvellement créés (ceci est utilisé pour les fichiers dans le dossier de cache et les fichiers uploadés. Pour plus d\'informations, voir le cas échéant <a href ="https://fr.wikipedia.org/wiki/Umask" target="_blank">article de wikipedia</a>.';
$lang['siteprefs_lockrefresh'] = 'Ce champ spécifie la fréquence minimum (en minutes) du mécanisme de verrouillage basé sur Ajax. Une valeur idéale de ce champ est 5.';
$lang['siteprefs_locktimeout'] = 'Ce champ indique le nombre de minutes d\'inactivité avant le déverrouillage. Après un temps de verrouillage d\'autres utilisateurs peuvent "s’approprier" le verrou. Un verrou de temporisation ne peut être "retouchée" avant la fin de son expiration. Cela réinitialisera la date d\'expiration du verrou. Dans la plupart des cas, un blocage de 60 minutes est adapté.';
$lang['siteprefs_sitename'] = 'C\'est un nom lisible pour votre site Web, à savoir : une entreprise, un club, ou le nom de l\'organisation.';
$lang['siteprefs_frontendlang'] = 'La langue par défaut affichée sur votre site Web. Elle peut être changée en utilisant différentes balises Smarty. Exemple :  <code>{cms_set_language}</code>';
$lang['siteprefs_frontendwysiwyg'] = 'Quand plusieurs éditeurs WYSIWYG sont installés pour les formulaires du site Web, indiquez lequel doit être utilisé.';
$lang['siteprefs_nogcbwysiwyg'] = 'Cette option permet de désactiver l\'éditeur WYSIWYG sur tous les blocs de contenu globaux indépendamment des paramètres de l\'utilisateur, ou des blocs de contenu globaux individuels.';
$lang['siteprefs_globalmetadata'] = 'Cette zone de texte permet de saisir des informations de métadonnées communes à toutes les pages de contenu. C\'est un endroit idéal pour les balises meta comme "Generator", "Author", etc ..';
$lang['siteprefs_logintheme'] = 'Sélectionnez le thème "Admin" (à partir des thèmes administration installés) qui sera utilisé pour générer le formulaire de connexion de l\'administrateur, ainsi que le thème de connexion par défaut pour les nouveaux comptes "Admin" créés. Les utilisateurs "Admin" seront ensuite en mesure de choisir leur thème préféré d\'administration à partir du panneau des préférences de l\'utilisateur.';
$lang['siteprefs_backendwysiwyg'] = 'Sélectionnez l\'éditeur WYSIWYG pour les comptes utilisateur d\'administration nouvellement créées. Les utilisateurs "Admin" pourront ensuite choisir leur éditeur WYSIWYG préféré à partir du panneau de préférences de l\'utilisateur.';
$lang['siteprefs_dateformat'] = '<p>Spécifiez une chaîne pour le format des dates affichés sur le site Web. La chaîne utilise le format <a href="http://php.net/manual/fr/function.strftime.php" class="external" target="_blank">strftime</a></p><p>Les utilisateurs "Admin" peuvent modifier ces paramètres dans le panneau des préférences de l\'utilisateur.</p><p><strong>Note : </strong> Certains modules peuvent choisir d\'afficher les heures et dates différemment</p>';
$lang['siteprefs_thumbwidth'] = 'Spécifiez une largeur <em>(en pixels)</em> à utiliser par défaut lors de la génération des vignettes à partir des fichiers d\'image uploadées. Les vignettes sont généralement affichées dans le panneau d\'administration du module de FileManager ou lors de la sélection d\'une image à insérer dans le contenu de la page. Cependant, certains modules peuvent utiliser les vignettes sur le site Web.<br/><br/><strong> Note :</strong> Certains modules peuvent avoir des préférences supplémentaires pour générer des vignettes, et vont ignorer ce paramètre.';
$lang['siteprefs_thumbheight'] = 'Spécifiez une hauteur <em>(en pixels)</em> à utiliser par défaut lors de la génération des vignettes à partir des fichiers d\'image uploadées. Les vignettes sont généralement affichées dans le panneau d\'administration du module de FileManager ou lors de la sélection d\'une image à insérer dans le contenu de la page. Cependant, certains modules peuvent utiliser les vignettes sur le site Web.<br/><br/><strong> Note :</strong> Certains modules peuvent avoir des préférences supplémentaires pour générer des vignettes, et vont ignorer ce paramètre.';
?>