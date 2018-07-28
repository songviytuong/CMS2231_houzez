<?php
$lang['admindescription'] = 'Ce module permet principalement de gérer le contenu, avec un éditeur WYSIWYG très simplifié, basé sur le projet TinyMCE.';
$lang['browse'] = 'Parcourir';
$lang['cancel'] = 'Annuler';
$lang['class'] = 'Classe';
$lang['cmsms_linker'] = 'Lien vers une page CMSMS';
$lang['css_styles_help'] = 'Les styles CSS mentionnés ici seront ajoutés à une boite de sélection déroulante dans l\'éditeur. Laisser le champ de saisie vide ne permettra pas l\'apparition de la boîte déroulante (par défaut).';
$lang['css_styles_help2'] = 'Les styles peuvent être simplement le nom de la classe, ou une classe avec un nouveau nom à afficher.
Ils doivent être séparés soit par des virgules soit par des sauts de ligne.
<br/>Exemple : monstyle1, Mon nom de style=monstyle2
<br/>Résultat : une boite de sélection avec 2 entrées, \'monstyle1\' et \'Mon nom de style\' résultant de l\'insertion de monstyle1, et monstyle2 respectivement.
<br/>Note : il n\'y a PAS de vérification de l\'existence effective des styles. Ils sont utilisés sans contrôle.';
$lang['css_styles_text'] = 'Styles CSS&nbsp;';
$lang['description'] = 'Description&nbsp;';
$lang['dimensions'] = 'L x H';
$lang['dimension'] = 'Dimensions';
$lang['dirinfo'] = 'Changer ce dossier de travail par&nbsp;';
$lang['edit_image'] = 'Éditer image';
$lang['edit_profile'] = 'Éditer le profil&nbsp;';
$lang['error_cantchangesysprofilename'] = 'Vous ne pouvez pas changer le nom d\'un profil du système';
$lang['error_missingparam'] = 'Un paramètre requis était manquant';
$lang['error_nopage'] = 'Aucune page alias sélectionnée';
$lang['example'] = 'Démo éditeur MicroTiny';
$lang['filepickertitle'] = 'Fichiers CMSMS';
$lang['friendlyname'] = 'Éditeur WYSIWYG MicroTiny';
$lang['fileview'] = 'Vue fichiers&nbsp;';
$lang['filename'] = 'Nom des fichiers';
$lang['filterby'] = 'Filtrer par&nbsp;';
$lang['height'] = 'Hauteur';
$lang['help'] = '<strong>Que fait ce module ?</strong>
<p>MicroTiny est une version restreinte de l\'éditeur <a href="http://www.tinymce.com" target="_blank">TinyMCE</a> permettant l\'édition de contenus avec l\'apparence proche d\'un WYSIWYG.
Il fonctionne avec les blocs de contenu dans les pages de contenu de CMSMS (quand un WYSIWYG est autorisé), sur les pages d\'administration où les éditeurs WYSIWYG sont autorisés et permet des utilisations restreintes pour l\'édition de blocs HTML sur les pages du site Web (frontend).</p>
<p>Pour que MicroTiny puisse être utilisé comme éditeur WYSIWYG dans l\'administration, cet éditeur WYSIWYG doit être sélectionné dans la console d\'administration de CMSMS dans"Mon compte/Préférences utilisateur/Sélection du WYSIWYG à utiliser". Des options supplémentaires, dans différents modules ou dans des pages de contenu, peuvent contrôler si une zone de texte ou un champ WYSIWYG est fourni sous diverses formes d\'édition.</p>
<p>Une possibilité d\'édition sur le site Web (frontend) de l\'éditeur MicroTiny doit être sélectionnée comme "WYSIWYG de la partie publique" dans "Paramètres globaux/Paramètres généraux" de la console d\'administration de CMSMS. </p>
<h3>Caractéristiques :</h3>
<ul>
  <li>Prend en charge une partie du bloc HTML5 et des éléments en ligne.</li>
  <li>Profils distincts pour les éditeurs d\'administration et les éditeurs du site Web (frontend).</li>
  <li>Un sélecteur de fichiers médias personnalisé utilisant des fichiers déjà uploadés.</li>
  <li>Plugin personnalisé pour créer des liens internes CMSMS <em>(administrateur uniquement)</em>.</li>
  <li>Personnalisation (sommaire) du profil d\'administration et du profil utilisateur du site Web (frontend).</li>
  <li>Apparence personnalisable en spécifiant une feuille de style à utiliser pour l\'éditeur.</li>
</ul>
 <h3>Comment l\'utiliser ? </h3>
  <ul>
    <li>Installer et configurer le module</li>
    <li>Choisir MicroTiny comme éditeur WYSIWYG dans "Mon compte/Préférences utilisateur/Sélection du WYSIWYG à utiliser"</li>
  </ul>
<h3>À propos de HTML, TinyMCE, et l\'édition de contenu :</h3>
  <ul>
    <li>Éditeur WYSIWYG :
       <p>Cet éditeur permet de modifier le contenu dans un environnement qui est similaire <em>(mais pas nécessairement identique)</em> à la vue sur le site Web (frontend). De nombreux facteurs peuvent influer sur les différences, y compris :</p>
       <ul>
         <li>L\'utilisation de feuilles de style incomplètes ou incorrectes,</li>
         <li>L\'utilisation de style avancé que l\'éditeur WYSIWYG ne peut pas comprendre,</li>
         <li>L\'utilisation d\'éléments HTML que le WYSIWYG ne peut pas comprendre.</li>
       </ul>
    </li>

    <li>Sous-ensemble d\'éléments HTML :
      <p>Comme tout éditeur de contenu simplifié, cet éditeur ne prend pas en charge tous les éléments HTML (en particulier les nouveaux éléments de niveau bloc de HTML5). Tous les éléments que l\'éditeur ne comprend pas ou ne supporte pas seront supprimés du contenu et non sauvegardés. D\'une manière générale <em>(non compris les div)</em> vous pouvez supposer que l\'éditeur prend en charge uniquement les éléments qui sont directement disponibles via les différents menus et options de la barre d\'outils. <p>
    </li>

    <li>Modifier des blocs de contenu, et non la page entière :
      <p>Comme CMSMS™ est un environnement fortement basé sur un modèle en utilisant les balises Smarty, il est prévu que l\'éditeur WYSIWYG soit utilisé uniquement pour des blocs de contenu spécifique ou des éléments de données (exemple : la zone de contenu principal d\'une page, ou la description d\'un article (news) ou d\'un billet de blog). Ce module <em>(et CMSMS™)</em> ne prend pas en charge l\'édition complète de la page.</p>
    </li>

    <li>Destiné à l\'édition simple de contenu et non à la conception de design :
      <p>L\'intention et le but de ce module est de fournir un environnement de type WYSIWYG où les utilisateurs peuvent insérer et éditer du contenu dans des blocs spécifiques avec des capacités limitées de mise en forme. Ce module ne pourra pas interférer avec, ou remplacer, le style du gabarit de page. Il n\'est pas prévu qu\'il se comporte comme un éditeur HTML général ou comme un éditeur généraliste.</p>
      <p>Les concepteurs de sites Web doivent comprendre les points ci-après : les utilisateurs du contenu peuvent et doivent éditer dans une zone WYSIWYG et veiller à ce que le contenu soit simple. Si les techniques de mise en page avancées sont nécessaires pour une zone spécifique, les concepteurs doivent modifier les gabarits appropriés de sorte que l\'éditeur WYSIWYG avec des fonctionnalités restreintes puisse fonctionner correctement.</p>
    </li>
  
    <li>Séparation de la logique, de la fonctionnalité et du design de contenu :
      <p>Cet éditeur est construit sur l\'hypothèse que le contenu d\'une zone spécifique d\'une page (un article de blog ou de News (Articles), ou la description du produit, ...) sont des données. Les données sont organisées grâce à des gabarits appropriés et ne doivent pas être mélangées avec des éléments de design, ou des fonctionnalités du site Web.</p>
      <p>Un exemple simple : si vous définissez que les utilisateurs utilisent certaines classes pour les images, ou pour la mise en page de leurs images, ou encore insèrent des éléments de bloc tels que < div > ou < section > dans leur contenu pour avoir un style correct, <strong>ce n\'est pas le module de l\'éditeur WYSIWYG qui le fera pour vous</strong>. Ces fonctions de styles devraient être prises en charge dans les feuilles de style et par des gabarits. Votre éditeur WYSIWYG doit saisir du texte sans avoir à mémoriser ces règles de style.</p>
      <p>Ce module n\'est pas conçu pour gérer les cas spéciaux où le HTML avancé est nécessaire. Pour ces pages ou blocs, l\'éditeur WYSIWYG doit être désactivé, et l\'accès à l\'édition de la page doit être restreint à ceux qui ont la capacité de comprendre et de modifier le code HTML manuellement.</p>
      <p>Ce module est destiné à fournir un éditeur restreint WYSIWYG pour des blocs spécifiques et pour une utilisation par des utilisateurs sans connaissances HTML. L\'éditeur WYSIWYG ne comprenant pas la logique Smarty, vous ne devriez pas (en règle générale) mélanger des balises Smarty ou les appels de modules dans les zones où le WYSIWYG est disponible. Il sera préférable de désactiver cet éditeur WYSIWYG pour ces zones/pages/blocs et donc de restreindre l\'accès d\'édition à ces pages.</p>
    </li>
  </ul>
<h3>À propos des images et des médias :</h3>
<p>Chaque profil a la possibilité d\'activer et/ou de désactiver la possibilité pour l\'éditeur d\'insérer des images ou des médias dans le contenu édité. Ceci est utile dans des environnements très structurés où les images et autres médias peuvent être inclus dans la vue finale par d\'autres moyens. Particulièrement sur les formulaires du site Web (frontend) (où l\'identité de l\'utilisateur peut être douteuse), il est recommandé que les utilisateurs n\'aient pas la possibilité d\'insérer des images ou autres médias.</p>
  <p><strong>Note :</strong> Ce module ne fournit pas la possibilité de télécharger ou de manipuler des fichiers, des images ou des médias. Cette fonctionnalité est gérée ailleurs dans CMSMS™ (Voir le Gestionnaire de fichiers ou la dépose des fichiers en haut à droite de la page).</p>

<h3>À propos de l\'éditeur du site Web (Frontend) :</h3>
<p>Ce module fournit un profil unique pour la configuration de l\'éditeur WYSIWYG sur les demandes du site Web (frontend). Par défaut, le profil "__frontend__" est très limité.</p>
  <p>Pour activer l\'éditeur WYSIWYG du site web (frontend), le <code>{cms_init_editor}</code> doit être inclus dans la partie "head" du gabarit. En outre, ce module doit être défini comme "WYSIWYG de la partie publique" dans "Paramètres globaux/Paramètres généraux" de la console d\'administration de CMSMS™.</p>

<h3>À propos des styles et des couleurs :</h3>
  <p>Ce module fournit la possibilité <em>(facultative)</em> d\'associer une feuille de style au profil de l\'éditeur. Ainsi le contenu de l\'éditeur suivra les règles de mise en forme de la feuille de style.</p>
<p>En outre, ce module permet au module de gestion de contenu de définir une classe CSS spécifique à l\'éditeur WYSIWYG grâce au paramètre <code>classname</code> des balises <code>{content}</code> et <code>{cms_textarea}</code>. Cette fonction permet la personnalisation avancée de l\'éditeur de chaque bloc de contenu. Celle-ci est disponible uniquement dans la console d\'administration.</p>
  <p>Par exemple, dans un gabarit de page en ajouter le paramètre "cssname" à la balise {content}, permet de spécifier une feuille de CMSMS™ à utiliser pour personnaliser l\'apparence de ce bloc de contenu. Exemple : <code>{content block=\'second block\' cssname=\'whiteonblack\'}</code>
  <p>En outre, un paramètre "Utilisez le bloc Id ..." dans "Paramètres globaux/Paramètres des contenus" permet de fournir automatiquement le paramètre de "cssname" avec le nom du bloc de contenu.</p>

  <h4>Styles pour l\'éditeur WYSIWYG</h4>
    <p>La feuille de style pour la zone de l\'éditeur WYSIWYG "devrait" configurer tout l\'élément du contenu du haut vers le bas. Il est seulement nécessaire de configurer le style des éléments disponibles utilisés par l\'éditeur de contenu. Voici un exemple simple d\'une feuille de style pour un thème blanc sur noir :</p>
<pre><code>
body {
 background: black;
 color: white;
}
p {
 margin-bottom: 0.5em;
}
h1 {
 color: yellow;
 margin-bottom: 1em;
}
h2 {
 color: cyan;
 margin-bottom: 0.75em;
}
</code></pre>

<h3>FAQ :</h3>
  <dl>
   <dt>Q : Où se trouve le support pour <em style="color: red";>"certaines fonctionnalités"</em> dans l\'éditeur, et comment puis-je l\'activer ?</dt>
      <dd>R : La version de TinyMCE distribué avec MicroTiny est un package personnalisé minimum. Nous avons ajouté nos propres plugins personnalisés, mais nous ne supportons pas les ajouts de plugins personnalisés ou les possibilités de personnaliser la configuration autre que le formulaire de modification du profil utilisateur. Si vous avez besoin des fonctionnalités supplémentaires pour un éditeur WYSIWYG, vous pouvez utiliser un module tiers de <a href="http://dev.cmsmadesimple.org/" target="_blank">CMS Made Simple - Forge</a>.</dd>
    
    <dt>Q : Quelles balises HTML/HTML5 sont pris en charge par ce module, et comment changer cela ?</dt>
      <dd>R : La liste des éléments pris en charge par défaut dans l\'éditeur TinyMCE se trouvent sur le <a href="http://www.tinymce.com/wiki.php/Configuration" target="_blank">site de TinyMCE</a>. Ces extensions ne sont pas prévu dans le module MicroTiny..</dd>
    
    <dt>Q : Je ne vois pas l\'éditeur MicroTiny dans l\'interface administration, que puis-je faire ?</dt>
      <dd>R : Il y a quelques étapes que vous pouvez suivre pour diagnostiquer ce problème :
        <ol>
          <li>Vérifiez, le journal d\'administration de CMSMS, le journal des erreurs PHP et la console JavaScript pour avoir des indications du problème.</li>
          <li>Vérifier que l\'exemple fonctionne dans l\'onglet "MicroTiny exemple" du menu "Extensions/Éditeur MicroTiny WYSIWYG". Si cela ne fonctionne pas, vérifiez à nouveau le journal des erreurs PHP et la console JavaScript.</li>
          <li>Vérifiez que MicroTiny est sélectionné dans "Sélection du WYSIWYG à utiliser" dans le menu "Mes préférences/Mon compte/Préférences utilisateur".</li>
          <li>Consultez les autres pages de contenu. Si MicroTiny s\'affiche sur une ou plusieurs des pages, cela indique qu\'un paramètre est utilisé pour désactiver les éditeurs WYSIWYG sur des blocs de contenus sur certaines pages.</li>
          <li>Vérifier le gabarit de(s) page(s). Le paramètre wysiwyg=false peut être spécifié sur un ou plusieurs blocs de contenu dans les gabarits de page permettant de désactiver l\'éditeur WYSIWYG.</li>
        </ol>
      </dd>
    <dt>Q :Comment puis-je insérer un <br/> au lieu de créer un nouveau paragraphe ?</dt>
      <dd>R : Presser [shift]+Entrée au lieu de la touche Entrée seule.</dd>
    
    <dt>Q : Pourquoi <em style="color: red";>"certaines fonctionnalités"</em> sont disponibles dans la barre de menu et non dans la barre d\'outils ?</dt>
      <dd>R : Afin de permettre aux développeurs Web de restreindre davantage les fonctionnalités de certains profils de l\'éditeur, la barre de menu peut être affichée ou non dans des profils différents, privant ainsi l\'utilisateur de la fonctionnalité uniquement disponible dans la barre de menu.</dd>
  </dl>
<h3>La mise en cache :</h3>
  <p>Pour améliorer les performances, MicroTiny va tenter de mettre en cache les fichiers JavaScript générés à moins que quelque chose ait changé. Cette fonctionnalité peut être désactivée en définissant une ligne spéciale <code> mt_disable_cache </code> à "true" dans la configuration. Exemple ajout de : <strong><code>$config["mt_disable_cache"] = true;</code></strong> dans le fichier config.php.</p>
<h3>Voir aussi :</h3>
<ul>
  <li><code>{content}</code> Détails dans "Extensions /Balises"</li>
  <li><code>{cms_textarea}</code> Détails dans "Extensions/Balises"</li>
  <li><code>{cms_init_editor}</code> Détails dans "Extensions /Balises"</li>
  <li>Le site Web de l\'éditeur <a href="http://www.tinymce.com" target="_blank">TinyMCE</a>.</li>
</ul>';
$lang['image'] = 'Image&nbsp;';
$lang['info_linker_autocomplete'] = 'Commencez par taper quelques caractères de la page alias, texte du menu ou titre désiré. Tous les noms correspondants seront affichés dans une liste.';
$lang['loading_info'] = 'Chargement ...';
$lang['mailto_image'] = 'Créer une image email';
$lang['mailto_text'] = 'Insérer/Modifier un lien email';
$lang['mailto_title'] = 'Insérer/Modifier un lien email';
$lang['msg_cancelled'] = 'Opération annulée';
$lang['mthelp_allowcssoverride'] = 'Si activé, spécifiera le nom d\'une feuille de style à utiliser (pour le WYSIWYG MicroTiny ) à la place de la feuille de style par défaut indiqué ci-dessus';
$lang['mthelp_dfltstylesheet'] = 'Associer une feuille de style avec l\'éditeur utilisant ce profil. Permet au contenu de l\'éditeur WYSIWYG d\'avoir un rendu proche de l\'aspect du site.';
$lang['mthelp_profileallowimages'] = 'Laisser l\'éditeur intégrer des images et des vidéos dans la zone de texte. Avec certains gabarits, les éditeurs de contenu peuvent ne pas être en mesure de sélectionner des images ou vidéos pour les zones spécifiques d\'une page Web';
$lang['mthelp_profileallowtables'] = 'Laisser l\'éditeur intégrer et manipuler les tableaux. Remarque : ne devrait pas être utilisé pour contrôler la mise en page, mais uniquement pour les données organisées sous forme de tableaux.';
$lang['mthelp_profilelabel'] = 'Une description de ce profil. La description ne peut être modifiée pour des profils système.';
$lang['mthelp_profilename'] = 'Le nom de ce profil. Le nom des profils système ne peut pas être modifié.';
$lang['mthelp_profilemenubar'] = 'Indique si la barre de menu doit être activée dans les profils visibles. La barre de menus a généralement plus d\'options que la barre d\'outils.';
$lang['mthelp_profilestatusbar'] = 'Cette sélection indique si la barre d\'état au bas de la zone WYSIWYG doit être activée. La barre d\'état affiche des informations importantes pour les éditeurs avancés, ainsi que d\'autres informations utiles.';
$lang['mthelp_profileresize'] = 'Cette sélection indique si la zone WYSIWYG peut être redimensionnée. Pour pouvoir redimensionner la barre d\'état doit être activée.';
$lang['newwindow'] = 'Nouvelle fenêtre';
$lang['none'] = 'Aucun';
$lang['ok'] = 'OK&nbsp;';
$lang['prompt_linker'] = 'Entrer le titre de la page';
$lang['prompt_linktext'] = 'Texte du lien';
$lang['prompt_profiles'] = 'Profils utilisateurs';
$lang['prompt_selectedalias'] = 'Alias de page sélectionné';
$lang['profiledesc___admin__'] = 'Ce profil est utilisé par tous les utilisateurs autorisés qui ont choisi d\'utiliser cet éditeur';
$lang['profiledesc___frontend__'] = 'Ce profil est utilisé pour l\'éditeur WYSIWYG autorisé sur site Web (Frontend)';
$lang['profile_admin'] = 'Utilisateurs de l’administration';
$lang['profile_allowcssoverride'] = 'Permettre aux blocs de passer outre la feuille de style sélectionnée&nbsp;';
$lang['profile_allowimages'] = 'Autoriser les images&nbsp;';
$lang['profile_allowresize'] = 'Autoriser le redimensionnement&nbsp;';
$lang['profile_allowtables'] = 'Autoriser les tableaux&nbsp;';
$lang['profile_dfltstylesheet'] = 'Feuille de style pour l\'éditeur&nbsp;';
$lang['profile_frontend'] = 'Utilisateurs sur le site Web (Frontend)';
$lang['profile_label'] = 'Label&nbsp;';
$lang['profile_name'] = 'Nom du Profil&nbsp;';
$lang['profile_menubar'] = 'Affiche une barre de menu&nbsp;';
$lang['profile_showstatusbar'] = 'Affiche une barre d\'état&nbsp;';
$lang['prompt_name'] = 'Nom&nbsp;';
$lang['prompt_target'] = 'Cible';
$lang['prompt_class'] = 'Attribut de classe';
$lang['prompt_email'] = 'Adresse email';
$lang['prompt_insertmailto'] = 'Insérer/Modifier un lien email';
$lang['prompt_anchortext'] = 'Texte à afficher';
$lang['prompt_rel'] = 'Attribut rel (type de relation)';
$lang['prompt_texttodisplay'] = 'Texte à afficher';
$lang['savesettings'] = 'Sauvegarder les ajustements';
$lang['settings'] = 'Paramètres';
$lang['settingssaved'] = 'Ajustements sauvegardés';
$lang['size'] = 'Taille';
$lang['submit'] = 'Soumettre';
$lang['switchgrid'] = 'Basculer l\'affichage en grille';
$lang['switchlist'] = 'Basculer l\'affichage en liste';
$lang['switchimage'] = 'Montrer les fichiers image';
$lang['switchvideo'] = 'Montrer les fichiers vidéo';
$lang['switchaudio'] = 'Montrer les fichiers audio';
$lang['switcharchive'] = 'Montrer les fichiers archive';
$lang['switchfiles'] = 'Montrer les fichiers';
$lang['switchreset'] = 'Montrer tous les fichiers';
$lang['tooltip_selectedalias'] = 'Ce champ est en lecture seule';
$lang['title_cmsms_linker'] = 'Créer un lien vers une page de contenu CMSMS';
$lang['title_cmsms_filebrowser'] = 'Sélectionner un fichier';
$lang['title_edit_profile'] = 'Éditer le profil';
$lang['tmpnotwritable'] = 'La configuration n\'a pas pu être sauvegardée dans le dossier tmp ! Merci de corriger !';
$lang['tab_general_title'] = 'Général';
$lang['tab_advanced_title'] = 'Avancé';
$lang['type'] = 'Type&nbsp;';
$lang['usestaticconfig_help'] = 'Génère un fichier de configuration statique. Fonctionnera mieux sur certains serveurs (par exemple lors de l\'exécution de PHP avec CGI)';
$lang['usestaticconfig_text'] = 'Utiliser le fichier de configuration statique&nbsp;';
$lang['width'] = 'Largeur';
$lang['view_source'] = 'Vue source HTML';
$lang['youareintext'] = 'Dossier actuel&nbsp;';
?>