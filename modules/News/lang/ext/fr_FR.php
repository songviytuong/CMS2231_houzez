<?php
$lang['addarticle'] = 'Ajouter un article';
$lang['addcategory'] = 'Ajouter une catégorie';
$lang['addfielddef'] = 'Ajouter une définition de champ';
$lang['addnewsitem'] = 'Ajouter un article';
$lang['allcategories'] = 'Toutes les catégories';
$lang['allentries'] = 'Toutes les entrées';
$lang['allowed_upload_types'] = 'Autoriser seulement le téléchargement des fichiers avec ces extensions&nbsp;';
$lang['allow_summary_wysiwyg'] = 'Autoriser l\'utilisation de l\'éditeur WYSIWYG dans le sommaire&nbsp;';
$lang['anonymous'] = 'Anonyme';
$lang['apply'] = 'Appliquer';
$lang['approve'] = 'Mettre le statut à \'Publié\'';
$lang['areyousure'] = 'Êtes-vous sûr(e) de vouloir supprimer ?';
$lang['areyousure_deletemultiple'] = 'Êtes-vous sûr de que vouloir supprimer plusieurs articles';
$lang['areyousure_multiple'] = 'Êtes-vous sûr(e) de vouloir effectuer cette action sur plusieurs articles ?';
$lang['article'] = 'Article&nbsp;';
$lang['articleadded'] = 'L\'article a été ajouté avec succès.';
$lang['articledeleted'] = 'L\'article a été supprimé avec succès.';
$lang['articles'] = 'Articles&nbsp;';
$lang['articlesubmitted'] = 'L\'article a été soumis avec succès.';
$lang['articleupdated'] = 'L\'article a été mis à jour avec succès.';
$lang['author'] = 'Auteur&nbsp;';
$lang['author_label'] = 'Posté par&nbsp;:';
$lang['auto_create_thumbnails'] = 'Création automatique de fichiers "vignettes" pour les fichiers avec ces extensions';
$lang['bulk_delete'] = 'Supprimer';
$lang['bulk_setcategory'] = 'Activer la catégorie';
$lang['bulk_setdraft'] = 'Vers ébauche';
$lang['bulk_setpublished'] = 'Bon à publier';
$lang['browsecattemplate'] = 'Gabarit de catégories';
$lang['cancel'] = 'Annuler';
$lang['categories'] = 'Catégories';
$lang['category'] = 'Catégorie&nbsp;';
$lang['categoryadded'] = 'La catégorie a été ajoutée avec succès.';
$lang['categorydeleted'] = 'La catégorie a été supprimée avec succès.';
$lang['categoryupdated'] = 'La catégorie a été mise à jour avec succès.';
$lang['category_label'] = 'Catégorie&nbsp;:';
$lang['checkbox'] = 'Case à cocher';
$lang['close'] = 'Fermer';
$lang['content'] = 'Contenu&nbsp;';
$lang['customfields'] = 'Définition des champs';
$lang['dateformat'] = '%s pas dans un format valide yyyy-mm-dd hh:mm:ss';
$lang['default_category'] = 'Catégorie par défaut&nbsp;';
$lang['default_templates'] = 'Gabarits par défaut';
$lang['delete'] = 'Effacer';
$lang['delete_article'] = 'Effacer l\'article';
$lang['delete_selected'] = 'Supprimer les articles sélectionnés';
$lang['deprecated'] = 'Non supporté';
$lang['description'] = 'Ajout, édition et suppression des articles';
$lang['desc_adminsearch'] = 'Recherche tous les articles (indépendamment du statut ou de l\'expiration)';
$lang['desc_news_settings'] = 'Paramètres du module News (Articles)';
$lang['detailtemplate'] = 'Gabarit du détail article';
$lang['detailtemplateupdated'] = 'Le gabarit de l\'affichage du détail de l\'article a été sauvegardé dans la base de données.';
$lang['detail_page'] = 'Page de détail&nbsp;';
$lang['detail_template'] = 'Gabarit du détail&nbsp;';
$lang['displaytemplate'] = 'Afficher le gabarit';
$lang['down'] = 'Bas';
$lang['draft'] = 'Ébauche';
$lang['dropdown'] = 'Liste déroulante';
$lang['edit'] = 'Éditer';
$lang['editarticle'] = 'Éditer un article';
$lang['editcategory'] = 'Éditer une catégorie';
$lang['editfielddef'] = 'Éditer la définition du champ';
$lang['email_subject'] = 'Le sujet du mail de notification&nbsp;';
$lang['email_template'] = 'Le format du message par email&nbsp;';
$lang['enddate'] = 'Date de fin&nbsp;';
$lang['endrequiresstart'] = 'Entrer une date de fin nécessite qu\'une date de début soit également entrée';
$lang['entries'] = '%s entrées';
$lang['error_categorynotfoun'] = 'La catégorie spécifiée est introuvable';
$lang['error_categoryparent'] = 'Catégorie parent invalide';
$lang['error_duplicatename'] = 'Un élément avec ce nom existe déjà';
$lang['error_filesize'] = 'Un fichier uploadé excède la taille maximum autorisée';
$lang['error_insufficientparams'] = 'Paramètres insuffisant (ou vide)';
$lang['error_invaliddates'] = 'Une ou plusieurs dates entrées sont invalides';
$lang['error_invalidfiletype'] = 'Impossible de télécharger ce type de fichier';
$lang['error_invalidurl'] = 'URL incorrecte <em>(peut-être déjà utilisée, ou il y a des caractères non valides)</em>';
$lang['error_mkdir'] = 'Impossible de créer ce répertoire : %s';
$lang['error_movefile'] = 'Impossible de créer ce fichier : %s';
$lang['error_noarticlesselected'] = 'Aucun article sélectionné';
$lang['error_nooptions'] = 'Pas options spécifiées pour la définition du champ';
$lang['error_templatenamexists'] = 'Un gabarit de ce nom existe déjà';
$lang['error_upload'] = 'Il y a eu un problème lors du téléchargement d\'un fichier';
$lang['eventdesc-NewsArticleAdded'] = 'Envoyé quand un article est ajouté';
$lang['eventhelp-NewsArticleAdded'] = '<p>Envoyé quand un article est ajouté</p>
<h4>Paramètres</h4>
<ul>
<li>"news_id" - Id de l\'article</li>
<li>"category_id" - Id de la catégorie de cet article</li>
<li>"title" - Titre de l\'article</li>
<li>"content" - Contenu de l\'article</li>
<li>"summary" - Sommaire de l\'article</li>
<li>"status" - Statut de l\'article ("draft" or "published")</li>
<li>"start_time" - Date de début de publication de l\'article</li>
<li>"end_time" - Date de fin de publication de l\'article</li>
<li>"useexp" - Si la date d\'expiration doit être ignorée ou pas</li>
</ul>';
$lang['eventdesc-NewsArticleDeleted'] = 'Envoyé quand un article est supprimé';
$lang['eventhelp-NewsArticleDeleted'] = '<h4>Paramètres</h4>
<ul>
<li>"news_id" - Id de l\'article</li>
</ul>';
$lang['eventdesc-NewsArticleEdited'] = 'Envoyé quand un article est édité';
$lang['eventhelp-NewsArticleEdited'] = '<h4>Paramètres</h4>
<ul>
<li>"news_id" - Id de l\'article</li>
<li>"category_id" - Id de la catégorie de cet article</li>
<li>"title" - Titre de l\'article</li>
<li>"content" - Contenu de l\'article</li>
<li>"summary" - Sommaire de l\'article</li>
<li>"status" - Statut de l\'article ("draft" or "published")</li>
<li>"start_time" - Date de début de publication de l\'article</li>
<li>"end_time" - Date de fin de publication de l\'article</li>
<li>"useexp" - Si la date d\'expiration doit être ignorée ou pas</li>
</ul>
<p><strong>Note :</strong> Tous les paramètres peuvent ne pas être présents lorsque cet événement est envoyé..</p>';
$lang['eventdesc-NewsCategoryAdded'] = 'Envoyé quand une catégorie est ajoutée';
$lang['eventhelp-NewsCategoryAdded'] = '<h4>Paramètres</h4>
<ul>
<li>"category_id" - Id de la catégorie</li>
<li>"name" - Nom de la catégorie</li>
</ul>';
$lang['eventdesc-NewsCategoryDeleted'] = 'Envoyé quand une catégorie est supprimée';
$lang['eventhelp-NewsCategoryDeleted'] = '<h4>Paramètres</h4>
<ul>
<li>"category_id" - Id de la catégorie</li>
<li>"name" - Nom de la catégorie supprimée</li>
</ul>';
$lang['eventdesc-NewsCategoryEdited'] = 'Envoyé quand une catégorie est éditée';
$lang['eventhelp-NewsCategoryEdited'] = '<h4>Paramètres</h4>
<ul>
<li>"category_id" - Id de la catégorie</li>
<li>"name" - Nom de la catégorie</li>
<li>"origname" - Nom original de la catégorie</li>
</ul>';
$lang['expired'] = 'Expiré';
$lang['expired_searchable'] = 'Les articles expirés peuvent apparaître dans les résultats de recherche&nbsp;';
$lang['expired_viewable'] = 'Articles expirés peuvent être consultés dans la vue de détail';
$lang['expiry'] = 'Expiration';
$lang['expiry_date_asc'] = 'Date expiration ascendante';
$lang['expiry_date_desc'] = 'Date expiration descendante';
$lang['expiry_interval'] = 'Le nombre de jours (par défaut) avant qu\'un article expire (si "Utiliser la date d\'expiration" est sélectionnée)&nbsp;';
$lang['extra'] = 'Extra&nbsp;';
$lang['extra_label'] = 'Extra :&nbsp;';
$lang['fesubmit_redirect'] = 'PageID ou alias où se fera la redirection après qu\'un article ait été soumis via l\'action fesubmit&nbsp;';
$lang['fesubmit_status'] = 'Le statut des articles soumis via les pages du site Web (frontend)&nbsp;';
$lang['fielddef'] = 'Définition champ';
$lang['fielddefadded'] = 'La définition du champ a été ajoutée avec succès.';
$lang['fielddefdeleted'] = 'La définition du champ a été supprimée avec succès.';
$lang['fielddefupdated'] = 'La définition du champ a été mise à jour avec succès.';
$lang['file'] = 'Fichier';
$lang['filter'] = 'Filtre';
$lang['firstpage'] = '<<';
$lang['formsubmit_emailaddress'] = 'Adresse email pour recevoir les notifications des articles soumis&nbsp;';
$lang['formtemplate'] = 'Gabarit soumission article';
$lang['help'] = '<h3>Notes Importantes</h3>
<p>la Version 2.9 a supprimé le format "formatpostdate" des gabarits, et a également supprimé le paramètre "dateformat". Vous devez utiliser le paramètre "cms_date_format" (comme indiqué dans les gabarits par défaut) pour les formats des dates et entry->postdate au lieu de entry->formatpostdate dans vos gabarits.</p>
<h3>Que fait ce module ?</h3>
	<p>Le module News (menu Contenu/Articles), est un module qui sert à afficher des articles dans vos pages, de façon similaire à un blog, mais avec plus de fonctions ! Dès que le module est installé, une page de gestion des articles est ajoutée au menu d\'administration qui vous permettra de sélectionner ou d\'ajouter des catégories d\'articles. Dès qu\'une catégorie d\'article est sélectionnée ou créée, une liste des articles associés à cette catégorie est affichée. À partir de là, vous pouvez ajouter, éditer ou supprimer des articles dans cette catégorie.</p>
<h4>Champs personnalisés</h4>
<p>Le module permet de définir de nombreux champs personnalisés (y compris des fichiers et des images) qui vous permettront de joindre des fichiers PDF ou de nombreuses images à vos articles.</p>
            <h4>Catégories</h4>
	<p>Le module News (Articles) fournit un mécanisme de catégories hiérarchiques pour l\'organisation de vos articles. Un article ne peut être qu\'en un seul endroit dans la hiérarchie.</p>
	<h4>Date d\'expiration et statut</h4>
	<p>Chaque article peut avoir une option de date d\'expiration au-delà de laquelle il ne s\'affichera plus sur votre page Web. En outre, les articles peuvent être marqués comme <em>brouillon</em> pour ne pas les afficher sur votre page Web.</p>
	<h3>Sécurité</h3>
	<p>L\'utilisateur doit faire partie d\'un groupe avec la permission \'Modify News\' pour pouvoir, ajouter, éditer ou supprimer des articles.</p>
<p>Pour supprimer les articles, l\'utilisateur doit faire partie d\'un groupe avec la permission \'Delete News Articles\'.</p>
	<p>Pour modifier la présentation des gabarits, l\'utilisateur doit faire partie d\'un groupe avec la permission "Modify Templates"</p>
	<p>Pour modifier les préférences globales du module, l\'utilisateur doit faire partie d\'un groupe avec la permission \'Modify Site Preferences\'.</p>
	<p>En plus, pour approuver les articles soumis par un visiteur sur la page du site Web (frontend) l\'utilisateur doit appartenir à un groupe avec la permission \'Approve News\'.</p>
	<h3>Comment l\'utiliser&nbsp;?</h3>
	<p>La façon la plus facile de l\'utiliser est avec la balise wrapper {news} (englobe le module dans une simple balise pour simplifier la syntaxe). Cela insérera votre module dans votre gabarit ou votre page à l\'endroit désiré, et y affichera les articles. Exemple de syntaxe : <code>{news number=\'5\'}</code></p>
<h3>Gabarits</h3>
	<p>Depuis la version 2.3 le module News utilise différents gabarits en base de données, et donc n\'utilise plus les fichiers de "templates". Les utilisateurs qui avaient d\'anciens fichiers gabarits doivent faire les modifications suivantes (pour chaque fichier gabarit) :</p>
<ul>
<li>Copier le fichier dans le presse papier</li>
<li>Créer un nouveau gabarit <em>(sommaire ou détail suivant le besoin)</em>. Donner le même nom au gabarit que l\'ancien nom du gabarit (<strong>sans</strong> l\'extension .tpl), et coller le contenu depuis le presse papier.</li>
<li>Cliquer sur le bouton Envoyer</li>
</ul>
<p>Ces différentes étapes résolvent le problème de ces nouveaux gabarits afin d\'éviter les différentes erreurs de Smarty quand vous mettez à jour vers une version de CMS avec un module de News version 2.3 ou supérieure.</p>';
$lang['helpaction'] = 'Outrepasse l\'action par défaut. Les valeurs possibles sont :
<ul>
<li>"detail" - pour afficher l\'article en mode détail.</li>
<li>"default" - pour afficher le sommaire de l\'article</li>
<li>"fesubmit" - <strong>Obsolète </strong>pour afficher le gabarit de soumission (frontend) d\'articles des utilisateurs dans les pages du site Web. Ajouter le <code>{cms_init_editor}</code> dans la section des méta-données pour initialiser l\'éditeur WYSIWYG sélectionné (Administration du site/Paramètres globaux/WYSIWYG de la partie publique).</li>
<li>"browsecat" - pour afficher une liste de catégories.</li>
</ul>';
$lang['helpbrowsecat'] = 'Afficher une liste navigable de catégories';
$lang['helpbrowsecattemplate'] = 'Utilise la base de données pour afficher les gabarits de catégories. Ce gabarit doit exister dans la Gestion du design avec le type Article::Parcourir la catégorie. Si ce paramètre n\'est pas spécifié le gabarit par défaut est utilisé.';
$lang['helpcategory'] = 'Affiche les articles de cette catégorie seulement. Utiliser * pour afficher les sous-catégories. Des catégories multiples peuvent être affichées en les séparant par une virgule. Laisser ce paramètre vide affichera tous les articles.';
$lang['helpdetailpage'] = 'Page dans laquelle afficher le détail des articles. Vous pouvez entrer soit un alias, soit un ID de page. Utile pour permettre d\'afficher le détail de l\'article dans un gabarit de page différent de celui du sommaire. Ce paramètre n\'a aucun effet pour les articles qui ont des URLs personnalisées.';
$lang['helpdetailtemplate'] = 'Utilise la base de données pour afficher le formulaire de soumission du détail des articles. Ce gabarit doit exister dans la Gestion du design avec le type Article::Détail. Si ce paramètre n\'est pas spécifié le gabarit par défaut est utilisé. Ce paramètre n\'est pas utilisé lors de la génération des URLs si vous avez défini une URL personnalisée.';
$lang['helpformtemplate'] = 'Utilise la base de données pour afficher le formulaire de soumission de l\'article. Ce gabarit doit exister dans la Gestion du design avec le type Article::Formulaire du site Web (Frontend). Si ce paramètre n\'est pas spécifié le gabarit par défaut est utilisé.';
$lang['helpmoretext'] = 'Texte à afficher à la fin d\'un article qui dépasse la longueur définie du sommaire. Par défaut = "Plus"';
$lang['helpnumber'] = 'Le nombre maximal d\'articles à afficher -- laisser ce paramètre vide affichera tous les articles. C\'est identique au paramètre "pagelimit".';
$lang['helpshowall'] = 'Si positionné à 1 : affiche tous les articles, quelle que soit la date de fin';
$lang['helpshowarchive'] = 'Afficher seulement les articles expirés.';
$lang['helpsortasc'] = 'Trie les articles dans un ordre de date ascendant plutôt que descendant. Par défaut : descendant.';
$lang['helpsortby'] = 'Champ sur lequel trier les articles. Les options sont : "news_date", "summary", "news_data", "news_category", "news_title", "news_extra", "end_time", "start_time", "random". Par défaut : "news_date". Si "random" est spécifié, le critère de tri est ignoré.';
$lang['helpstart'] = 'Commence au énième article -- laisser ce paramètre vide commencera l\'affichage au premier article';
$lang['helpsummarytemplate'] = 'Utilise la base de donnée pour afficher le formulaire de soumission du sommaire des articles. Ce gabarit doit exister dans la Gestion du design avec le type Article::Sommaire. Si ce paramètre n\'est pas spécifié le gabarit par défaut est utilisé.';
$lang['help_articleid'] = 'Ce paramètre est applicable uniquement à la vue de détail. Il permet de spécifier que l\'article sera afficher en mode détail. Si la valeur utilisée est -1, le système affichera l\'article le plus récemment, publié, mais non expiré.';
$lang['help_article_title'] = 'Entrez le titre de l\'article. Il doit être court et ne pas inclure des balises HTML.';
$lang['help_article_category'] = 'Aux fins de l\'organisation, vous pouvez sélectionner une catégorie.';
$lang['help_article_content'] = 'Entrer le contenu détaillé de l\'article ici';
$lang['help_article_enddate'] = 'Si "Utiliser la date d\'expiration" est activée, cette date (Date de fin) spécifie quand l\'article ne sera plus affiché sur le site Web.';
$lang['help_article_extra'] = 'Il s\'agit de données supplémentaires à associer à l\'article. Elles peuvent être utilisées pour un ordre de tri ou autre comportement. Quant à l\'utilisation de ce champ (ou pas), vous devez consulter votre développeur du site.';
$lang['help_article_searchable'] = 'Ce champ indique si cet article devrait être indexé par le module de recherche.';
$lang['help_article_postdate'] = 'La date à laquelle l\'article sera posté <em>(généralement la date actuelle pour de nouveaux articles)</em> est celle qui sera utilisé comme la date de publication de l\'article. Il est également utilisé dans le tri.';
$lang['help_article_summary'] = 'Entrer un bref paragraphe pour décrire l\'article. Ce résumé peut être utilisé lors de l\'affichage des vues d\'un certain nombre d\'articles.';
$lang['help_article_startdate'] = 'Si "Utiliser la date d\'expiration" est activée, cette date (Date de début) spécifie la date de laquelle l\'article sera visible sur le site Web.';
$lang['help_article_status'] = 'Si vous souhaitez que l\'article soit immédiatement visible par les autres, sélectionnez le statut "Publié". Si vous souhaitez continuer à travailler sur cet article pendant un certain temps, puis sélectionnez le statut "Ébauche".';
$lang['help_article_url'] = 'L\'URL facultatif pour un article <em>(certaines autres plates-formes appellent cela un slug)</em> est un suffixe d\'URL unique pour accéder à cet article. Les utilisateurs peuvent naviguer depuis racine_du_site/votre_url pour consulter cet article.';
$lang['help_article_useexpiry'] = 'Cette case à cocher active/désactive le comportement de date d\'expiration. Le comportement de "Utiliser la date d\'expiration" indique quand un article devient visible sur le site Web, et lorsqu\'il s\'avère par la suite invisible sur le site Web.';
$lang['help_articles_filtercategory'] = 'Éventuellement filtrer la liste des articles affichés dans cette liste de ceux qui appartiennent à la catégorie sélectionnée.';
$lang['help_articles_filterchildcats'] = 'Si activé, les articles dans la catégorie sélectionnée et leurs catégories enfants seront affichés.';
$lang['help_articles_pagelimit'] = 'Sélectionnez le nombre d\'articles à afficher dans une page. Pour les sites avec un grand nombre d\'articles en spécifiant une limite de page compris entre 10 et 100 améliorera sensiblement les performances.';
$lang['help_articles_sortby'] = 'Sélectionnez comment les articles seront initialement triés.';
$lang['help_category_name'] = 'Entrez un nom pour cette catégorie. Le nom doit être valide pour les URLs et ne contenir aucuns caractères spéciaux.';
$lang['help_category_parent'] = 'Spécifiez éventuellement une catégorie parent pour créer une hiérarchie de catégories.';
$lang['help_fesubmit_redirect'] = 'ID de la page ou alias de redirection après une soumission réussie depuis le site Web (frontend)';
$lang['help_fielddef_maxlen'] = 'Pour les champs texte, vous pouvez spécifier la longueur maximale à entrer par l\'utilisateur (en caractères).';
$lang['help_fielddef_name'] = 'Chaque définition de champ doit avoir un nom. Bien que cela ne soit pas strictement nécessaire, le nom du champ doit contenir uniquement des caractères alphanumériques et le caractère underscore. Ne pas d\'utiliser des espaces dans le nom du champ.';
$lang['help_fielddef_options'] = 'Ici vous pouvez spécifier les options valides pour les champs de la liste déroulante.';
$lang['help_fielddef_public'] = 'Spécifiez si la définition du champ est publique ou non. Les définitions de champ public sont visualisables dans le site Web et peuvent être saisies par l\'action fesubmit. Les Champs personnalisés qui ne sont pas publiques, ne sont modifiables uniquement que dans l\'interface d\'administration par les utilisateurs autorisés.';
$lang['help_fielddef_type'] = 'Chaque champ personnalisé peut être d\'un type différent pour différentes utilisations. Sélectionnez le type de champ qui correspond le mieux à la demande.';
$lang['help_idlist'] = 'Applicable uniquement à l\'action par défaut (Affiche le sommaire). Ce paramètre accepte une liste séparée par des virgules des ID numériques des articles et permet de filtrer davantage d\'articles que "articleid". La sortie de la liste actuelle des articles est toujours soumise à l\'état de l\'article, à sa date d\'expiration et à d\'autres paramètres.';
$lang['help_opt_alert_drafts'] = 'Si activé, vous recevrez des notifications (alertes), indiquant qu\'un ou plusieurs articles doivent être examinés et publiés.';
$lang['help_opt_allowed_upload_types'] = 'Pour les champs personnalisés de type "file", ce paramètre indique une liste, séparée par des virgules, des extensions de fichier valides pour l\'upload';
$lang['help_opt_dflt_category'] = 'Cette option permet de spécifier la catégorie par défaut pour les nouveaux articles.';
$lang['help_opt_hide_summary'] = 'Cette option permet de désactiver le champ sommaire lors de l\'ajout et/ou édition d\'un article <em>(y compris avec l\'action fesubmit)</em>';
$lang['help_opt_allow_summary_wysiwyg'] = 'Ce champ indique qu\'un éditeur WYSIWYG doit être activé pour le champ sommaire lorsque vous éditez un article. Dans bien des cas, le champ sommaire est un texte simple, mais cela est facultatif. <br/>Ce paramètre est ignoré si le champ sommaire est désactivé complètement <em>(voir ci-dessus)</em>';
$lang['help_opt_expiry_interval'] = 'Définissez le nombre de jours par défaut (minimum 1) auquel l\'article expirera, si la date d\'expiration est activée. La date d\'expiration peut être ajustée lorsque vous ajoutez ou éditez d\'un article.';
$lang['help_pagelimit'] = 'Nombre maximal d\'articles affichés (par page). Si ce paramètre n\'est pas défini, tous les articles sont affichés. Si ce paramètre est défini, et que le nombre d\'articles est supérieur, les textes et les liens seront affichés pour permettre le défilement des résultats. La valeur maximale pour ce paramètre est 1000.';
$lang['hide_summary_field'] = 'Cacher le champ sommaire lors de l\'ajout ou de la modification d\'articles&nbsp;';
$lang['info_allow_fesubmit'] = 'Cette option contrôle si l\'action "fesubmit" sera autorisé à fonctionner pour tout le site Web. Soyez prudent lorsque vous l\'activez.';
$lang['info_categories'] = 'À des fins d\'organisation, les articles peuvent être organisés en catégories hiérarchiques.';
$lang['info_detail_returnid'] = 'Cette préférence est utilisée pour déterminer si une page (et donc un gabarit) sert pour l\'affichage des pages de détails. Les URLs personnalisées ne fonctionneront pas si ce paramètre n\'est pas défini pour une page valide. En outre, si cette préférence est activée et aucun paramètre de page de détails n\'est fourni sur la balise {news}, alors cette valeur sera utilisée pour des liens pages de détails.';
$lang['info_expired_searchable'] = 'Si activé, les articles périmés peuvent continuer à être indexés par le module de recherche et apparaissent dans les résultats de la recherche.';
$lang['info_expired_viewable'] = 'Si activés, les articles périmés peuvent être visualisés en mode détail (ce qui est l\'ancienne fonctionnalité). Le paramètre "showall" peut être utilisé avec l\'URL (si vous n\'utilisez pas les pretty URLs) pour indiquer également que les articles périmés peuvent être consultés.';
$lang['info_fesubmit_notification'] = 'Vous pouvez éventuellement envoyer un email à une adresse email unique lorsqu\'un nouvel article est soumis par l\'intermédiaire de l\'action fesubmit.';
$lang['info_maxlength'] = 'Longueur maximale uniquement pour champ de texte.';
$lang['info_public'] = 'Seuls les champs publics sont disponibles pour l\'édition sur le site Web (frontend), et/ou dans les vues de résumé ou de détail.';
$lang['info_reorder_categories'] = 'Faites glisser-déplacer chaque élément dans le bon ordre pour changer les relations entre catégories';
$lang['info_searchable'] = 'Ce champ indique que cet article doit être indexé par le module de recherche';
$lang['info_sysdefault'] = '(le gabarit utilisé par défaut quand un nouveau gabarit est sélectionné)';
$lang['info_sysdefault2'] = '<strong>Note :</strong> cette page contient des zones d\'édition des gabarits qui sont disponibles quand vous créez un \'Nouveau\' gabarit Sommaire, Détail ou Soumission d\'article. Le fait de cliquer sur \'Envoyer\' les données de cette page <strong>n\'aura aucun effet immédiat sur l\'affichage déjà existant</strong>.';
$lang['lastpage'] = '>>';
$lang['lbl_adminsearch'] = 'Recherche les articles';
$lang['linkedfile'] = 'Fichier lié';
$lang['maxlength'] = 'Longueur maximale&nbsp;';
$lang['msg_cancelled'] = 'Opération annulée';
$lang['msg_categoriesreordered'] = 'Ordre des catégories mise à jour';
$lang['msg_contenttype_removed'] = 'Le type de contenu News a été supprimé. Merci de remplacer les tags {news} avec les paramètres appropriés dans vos gabarits ou vos pages pour remplacer cette fonctionnalité.';
$lang['msg_success'] = 'Opération réussie';
$lang['more'] = 'Plus';
$lang['moretext'] = 'Texte pour&nbsp;';
$lang['name'] = 'Nom&nbsp;';
$lang['nameexists'] = 'Un champ de ce nom existe déjà';
$lang['needpermission'] = 'Vous devez avoir la permission \'%s\' pour exécuter cette action.';
$lang['newcategory'] = 'Nouvelle catégorie';
$lang['news'] = 'Articles';
$lang['news_return'] = 'Retour';
$lang['nextpage'] = '>';
$lang['noarticles'] = 'Aucun article n\'a pour l\'instant été crée';
$lang['noarticlesinfilter'] = 'Aucun article ne répond aux critères de filtre';
$lang['nocategorygiven'] = 'Aucune catégorie entrée';
$lang['nocontentgiven'] = 'Aucun contenu entré';
$lang['noitemsfound'] = '<strong>Aucun</strong> objet trouvé pour cette catégorie : %s';
$lang['nonamegiven'] = 'Aucun nom n\'a été donné';
$lang['none'] = 'Aucun';
$lang['nopostdategiven'] = 'Il manque la date à laquelle l\'article sera posté';
$lang['notanumber'] = 'La longueur maximale n\'est PAS un nombre';
$lang['note'] = '<em>Note :</em> les dates doivent être entrées dans ce format \'yyyy-mm-dd hh:mm:ss\'.';
$lang['notify_n_draft_items'] = 'Vous avez %s article(s) non publié(s)';
$lang['notify_n_draft_items_sub'] = '%d article(s)';
$lang['notitlegiven'] = 'Aucun titre n\'est entré';
$lang['numbertodisplay'] = 'Nombre à afficher (vide = toutes les entrées)&nbsp;';
$lang['options'] = 'Options&nbsp;';
$lang['optionsupdated'] = 'Les options ont été mises à jour avec succès';
$lang['parent'] = 'Parent&nbsp;';
$lang['postdate'] = 'Date de l\'article ';
$lang['postinstall'] = 'Assurez-vous que les utilisateurs qui administreront les articles aient la permission "Modify News".';
$lang['post_date_asc'] = 'Date de l\'article ascendante';
$lang['post_date_desc'] = 'Date de l\'article descendante';
$lang['preview'] = 'Aperçu';
$lang['prevpage'] = '<';
$lang['print'] = 'Imprimer';
$lang['prompt_alert_drafts'] = 'Alerte sur les articles non approuvés&nbsp;';
$lang['prompt_allow_fesubmit'] = 'Autoriser les articles soumis par le site Web (frontend)&nbsp;';
$lang['prompt_default'] = 'Défaut';
$lang['prompt_go'] = 'Aller';
$lang['prompt_name'] = 'Nom';
$lang['prompt_newtemplate'] = 'Créer un nouveau gabarit';
$lang['prompt_of'] = 'sur';
$lang['prompt_page'] = 'Page&nbsp;';
$lang['prompt_pagelimit'] = 'Nombre d\'articles par page&nbsp;';
$lang['prompt_redirecttocontent'] = 'Retourner à la page';
$lang['prompt_sorting'] = 'Ordre de tri ';
$lang['prompt_template'] = 'Source du gabarit&nbsp;';
$lang['prompt_templatename'] = 'Nom du gabarit&nbsp;';
$lang['public'] = 'Publique&nbsp;';
$lang['published'] = 'Publié';
$lang['reassign_category'] = 'Changer la catégorie par&nbsp;';
$lang['removed'] = 'Supprimé';
$lang['reorder'] = 'Réordonner';
$lang['reorder_categories'] = 'Réordonner les catégories';
$lang['reset'] = 'Remise à zéro';
$lang['resettodefault'] = 'Restaurer les paramètres par défaut';
$lang['restoretodefaultsmsg'] = 'Cette opération restaurera les gabarits par défaut. Êtes-vous sûr(e) de vouloir continuer&nbsp;?';
$lang['revert'] = 'Mettre le statut à \'Ébauche\'';
$lang['searchable'] = 'Effectuer la recherche dans cet article&nbsp;';
$lang['select'] = 'Sélectionner';
$lang['select_option'] = 'Sélectionnez l\'option';
$lang['selectall'] = 'Sélectionner tout';
$lang['selectcategory'] = 'Sélection de catégorie';
$lang['showchildcategories'] = 'Afficher les sous-catégories&nbsp;';
$lang['sortascending'] = 'Tri ascendant&nbsp;';
$lang['startdate'] = 'Date de début&nbsp;';
$lang['startdatetoolate'] = 'la date de début est passée (après la date de fin ?)';
$lang['startoffset'] = 'Commence l\'affichage au énième article&nbsp;';
$lang['startrequiresend'] = 'Entrer une date de début nécessite qu\'une date de fin soit également entrée';
$lang['status'] = 'Statut';
$lang['status_asc'] = 'Statut ascendant';
$lang['status_desc'] = 'Statut descendant';
$lang['subject_newnews'] = 'Un nouvel article a été posté';
$lang['submit'] = 'Envoyer';
$lang['summary'] = 'Sommaire&nbsp;';
$lang['summarytemplate'] = 'Gabarit du sommaire article';
$lang['summarytemplateupdated'] = 'Le gabarit de l\'affichage du sommaire de l\'article a été mis à jour avec succès';
$lang['sysdefaults'] = 'Restaurer les paramètres par défaut';
$lang['template'] = 'Gabarit&nbsp;';
$lang['textarea'] = 'Zone de texte';
$lang['textbox'] = 'Champ de texte';
$lang['title'] = 'Titre&nbsp;';
$lang['title_asc'] = 'Titre ascendant';
$lang['title_available_templates'] = 'Gabarits disponibles';
$lang['title_browsecat_sysdefault'] = 'Gabarit de catégories par défaut';
$lang['title_browsecat_template'] = 'Gabarit de catégories';
$lang['title_desc'] = 'Titre descendant';
$lang['title_detail_returnid'] = 'Page par défaut à utiliser pour des vues de détail&nbsp;';
$lang['title_detail_settings'] = 'Paramètres d\'affichage des détails';
$lang['title_detail_sysdefault'] = 'Gabarit du détail par défaut';
$lang['title_detail_template'] = 'Éditeur du gabarit du détail';
$lang['title_draft_entries'] = 'Articles (News) non approuvés';
$lang['title_fesubmit_form'] = 'Soumettre un article';
$lang['title_fesubmit_settings'] = 'Paramètres de soumission via le Frontend';
$lang['title_filter'] = 'Filtres';
$lang['title_form_sysdefault'] = 'Gabarit de soumission article par défaut (frontend)';
$lang['title_form_template'] = 'Éditeur du gabarit soumission d\'article via les pages du site Web (frontend)';
$lang['title_news_settings'] = 'Paramètres des articles';
$lang['title_notification_settings'] = 'Paramètres des notifications';
$lang['title_submission_settings'] = 'Paramètres de soumission des articles';
$lang['title_summary_sysdefault'] = 'Gabarit du sommaire par défaut';
$lang['title_summary_template'] = 'Éditeur du gabarit du sommaire';
$lang['toggle_bulk'] = 'Sélectionner cet article pour une opération en série';
$lang['type'] = 'Type&nbsp;';
$lang['type_browsecat'] = 'Parcourir la catégorie';
$lang['type_form'] = 'Formulaire du site Web (Frontend)';
$lang['type_detail'] = 'Détail';
$lang['type_News'] = 'Article';
$lang['type_summary'] = 'Sommaire';
$lang['unknown'] = 'Inconnu';
$lang['unlimited'] = 'Sans limite';
$lang['up'] = 'Haut';
$lang['uploadscategory'] = 'Catégorie uploads';
$lang['url'] = 'URL (slug)&nbsp;';
$lang['useexpiration'] = 'Utiliser la date d\'expiration&nbsp;';
$lang['viewfilter'] = 'Afficher le filtre';
$lang['warning_preview'] = 'Attention : cette page d\'aperçu se comporte comme une fenêtre permettant de naviguer loin de cette page aperçu originale. Toutefois, si vous faites cela, attention aux comportements inattendus ! <strong>Note : </strong>La prévisualisation ne pas uploader les fichiers que vous avez sélectionnés.';
$lang['with_selected'] = 'Avec la sélection';
?>