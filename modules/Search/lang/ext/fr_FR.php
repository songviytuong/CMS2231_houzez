<?php
$lang['clear'] = 'Effacer';
$lang['confirm_clearstats'] = 'Êtes-vous sûr(e) de vouloir effacer toutes les statistiques ?';
$lang['confirm_reindex'] = 'Cette opération peut prendre un certain temps et/ou exiger une grande quantité de mémoire PHP. Êtes-vous sûr(e) de vouloir ré-indexer tout le contenu ?';
$lang['count'] = 'Nombre';
$lang['default_stopwords'] = 'à, ai, aie, aient, aies, ait, alors, as, au, aucuns, aura, aurai, auraient, aurais, aurait, auras, aurez, auriez, aurions, aurons, auront, aussi, autre, aux, avaient, avais, avait, avant, avec, avez, aviez, avions, avoir, avons, ayant, ayez, ayons, bon, ça, car, ce, ceci, cela, ces, cet, cette, ceux, chaque, ci, comme, comment, dans, de, début, dedans, dehors, depuis, des, deux, devrait, doit, donc, dos, droite, du, elle, elles, en, encore, es, essai, est, et, étaient, étais, était, étant, état, été, êtes, étions, être, eu, eue, eues, eûmes, eurent, eus, eusse, eussent, eusses, eussiez, eussions, eut, eût, eûtes, eux, fait, faites, fois, font, force, fûmes, furent, fus, fusse, fussent, fusses, fussiez, fussions, fut, fût, fûtes, haut, hors, ici, il, ils, je, juste, la, là, le, les, leur, leurs, lui, ma, maintenant, mais, me, même, mes, mine, moi, moins, mon, mot, ne, ni, nommés, nos, notre, nous, nouveaux, on, ont, ou, où, par, parce, parole, pas, personnes, peu, peut, pièce, plupart, pour, pourquoi, qu, quand, que, quel, quelle, quelles, quels, qui, sa, sans, se, sera, serai, seraient, serais, serait, seras, serez, seriez, serions, serons, seront, ses, seulement, si, sien, soi, soient, sois, soit, sommes, son, sont, sous, soyez, soyons, suis, sujet, sur, ta, tandis, te, tellement, tels, tes, toi, ton, tous, tout, très, trop, tu, un, une, valeur, voie, voient, vont, vos, votre, vous, vu';
$lang['description'] = 'Module de recherche du site et des contenus d\'autres modules';
$lang['eventdesc-SearchAllItemsDeleted'] = 'Envoyé quand tous les objets sont supprimés de l\'index';
$lang['eventhelp-SearchAllItemsDeleted'] = '<h4>Paramètres</h4>
<ul>
<li>Aucun</li>
</ul>';
$lang['eventdesc-SearchCompleted'] = 'Envoyé quand une recherche est terminée';
$lang['eventhelp-SearchCompleted'] = '<h4>Paramètres</h4>
<ol>
<li>Texte qui était recherché</li>
<li>Tableau des résultats complets</li>
</ol>';
$lang['eventdesc-SearchInitiated'] = 'Envoyé quand une recherche est débutée';
$lang['eventhelp-SearchInitiated'] = '<h4>Paramètres</h4>
<ol>
<li>Texte qui était recherché</li>
</ol>';
$lang['eventdesc-SearchItemAdded'] = 'Envoyé quand un nouvel objet est indexé';
$lang['eventhelp-SearchItemAdded'] = '<h4>Paramètres</h4>
<ol>
<li>Nom du module.</li>
<li>Id de l\'objet.</li>
<li>Attribut additionnel.</li>
<li>Contenu à indexer et ajouter.</li>
</ol>';
$lang['eventdesc-SearchItemDeleted'] = 'Envoyé quand un objet est supprimé de l\'index';
$lang['eventhelp-SearchItemDeleted'] = '<h4>Paramètres</h4>
<ol>
<li>Nom du module.</li>
<li>Id de l\'objet.</li>
<li>Attribut additionnel.</li>
</ol>';
$lang['export_to_csv'] = 'Exporter sous CSV';
$lang['help'] = '<h3>Que fait ce module&nbsp;?</h3>
	<p>Le module de recherche (Search) permet d\'effectuer des recherches dans le contenu du "noyau" du site, ainsi que dans certains modules enregistrés. Vous donnez un ou deux mots et le module vous renvoie les résultats correspondants et pertinents.</p>
	<h3>Comment l\'utiliser&nbsp;?</h3>
	<p>La façon la plus simple est d\'utiliser la balise {search}. C\'est une balise wrapper (qui englobe le module dans une balise pour en simplifier la syntaxe). Ceci va insérer le module dans votre gabarit ou votre page à l\'endroit désiré, et afficher le formulaire de recherche. Le code ressemble à ceci&nbsp;: <code>{search}</code></p>
<h4>Comment empêcher certains contenus d\'être indexés</h4>
<p>Le module Recherche (Search) ne cherchera pas dans les page inactives. Cependant, si vous utilisez le module CustomContent, ou d\'autres logiques Smarty pour afficher des contenus différents à différents utilisateurs, il est conseillé d\'empêcher l\'indexation de toute la page, même si elle est active. Pour cela, ajoutez la balise suivante n\'importe où dans la page <em>< !-- pageAttribute: NotSearchable -- ></em>. Quand le module de recherche verra ce code dans la page, il n\'indexera rien de ce qui se trouve sur cette page.</p>
<p>La balise <em>< !-- pageAttribute: NotSearchable -- ></em> peut également être placée dans un gabarit. Si c\'est le cas, aucune des pages utilisant ce gabarit ne sera indexée. Ces pages seront réindexées si la balise est supprimée.</p>';
$lang['input_resetstopwords'] = 'Chargez';
$lang['noresultsfound'] = 'Aucun résultat trouvé&nbsp;!';
$lang['nostatistics'] = 'Aucune statistique trouvée&nbsp;!';
$lang['options'] = 'Options&nbsp;';
$lang['param_action'] = 'Spécifie le mode de recherche du module. Les valeurs acceptées sont \'default\', et \'keywords\'. L\'action \'keywords\' peut être utilisée pour générer une liste de mots (séparés par une virgule) utilisables dans le meta tag \'keywords\'.';
$lang['param_count'] = 'Utilisé avec l\'action \'keywords\', ce paramètre limitera la recherche au nombre indiqué de mots';
$lang['param_detailpage'] = 'Utilisé uniquement pour donner les résultats à partir de modules, ce paramètre permet de spécifier une page de détail différentes pour les résultats. Ceci est utile si, par exemple, vous affichez toujours vos points de vue en détail dans une page avec un gabarit différent. <em> (<strong> Remarque : </strong> les modules ont la possibilité de désactiver ce paramètre.) </em>';
$lang['param_formtemplate'] = 'Utilisé uniquement pour l\'action par défaut, ce paramètre permet de spécifier le nom d\'un gabarit autre que celui par défaut.';
$lang['param_inline'] = 'Si \'true\', le résultat de la recherche remplacera le contenu originel de la balise {search} dans le contenu du bloc originel. Utilisez ce paramètre si votre gabarit contient plusieurs blocs de contenu, et que vous ne désirez pas que l\'affichage de la recherche remplace le contenu du bloc par défaut';
$lang['param_modules'] = 'Limite les résultats de la recherche aux valeurs indexées dans la liste des modules spécifiés (séparés par une virgule)';
$lang['param_pageid'] = 'Applicable seulement avec l\'action \'keywords\', ce paramètre peut être utilisé pour spécifier une page différente (pageid) d\'affichage des résultats de la recherche';
$lang['param_passthru'] = 'Transmet des paramètres nommés à des modules spécifiques. Le format de ces paramètres est : "passtru_MODULENAME_PARAMNAME=\'value\'" Exemple : passthru_News_detailpage=\'newsdetails\'"';
$lang['param_resultpage'] = 'Page pour l\'affichage des résultats. Ceci peut être soit un alias de page, soit l\'ID de la page. Utilisé pour permettre aux résultats de recherche d\'être affichés dans un gabarit différent du formulaire de recherche';
$lang['param_resulttemplate'] = 'Ce paramètre permet de spécifier le nom d\'un gabarit autre que celui par défaut, à utiliser pour l\'affichage des résultats de recherche.';
$lang['param_searchtext'] = 'Texte à placer dans le champ de recherche';
$lang['param_submit'] = 'Texte à placer dans le bouton \'OK\'';
$lang['param_useor'] = 'Changer la relation par défaut OR par AND';
$lang['prompt_alpharesults'] = 'Trier les résultats de recherche par ordre alphabétique et non par pertinence&nbsp;';
$lang['prompt_resetstopwords'] = 'Chargez les mots exclus de la recherche par défaut pour la langue&nbsp;';
$lang['prompt_resultpage'] = 'Page de résultats individuels pour module <em>(Note : les modules peuvent effacer ceci)</em>&nbsp;';
$lang['prompt_savephrases'] = 'Recherche de morceau de phrases, pas des mots&nbsp;';
$lang['prompt_searchtext'] = 'Texte de recherche par défaut&nbsp;';
$lang['reindexallcontent'] = 'Réindexer tout le contenu';
$lang['reindexcomplete'] = 'Réindexation terminée&nbsp;!';
$lang['restoretodefaultsmsg'] = 'Cette opération va restaurer le contenu du gabarit au défaut du système. Êtes-vous sûr de vouloir continuer&nbsp;?';
$lang['resulttemplate'] = 'Gabarit de résultat';
$lang['resulttemplateupdated'] = 'Gabarit de résultat mis à jour';
$lang['search'] = 'Recherche';
$lang['searchresultsfor'] = 'Résultats pour la recherche';
$lang['searchsubmit'] = 'Envoyer';
$lang['searchtemplate'] = 'Gabarit de recherche';
$lang['searchtemplateupdated'] = 'Gabarit de recherche mis à jour';
$lang['search_method'] = 'Compatibilité via la méthode POST des Pretty URLs, la valeur par défaut est toujours la méthode GET, pour utiliser cette recherche mettre (search_method = "post")';
$lang['statistics'] = 'Statistiques';
$lang['stopwords'] = 'Mots exclus de la recherche&nbsp;';
$lang['submit'] = 'Soumettre';
$lang['sysdefaults'] = 'Restaurer les paramètres par défaut';
$lang['timetaken'] = 'Temps nécessaire';
$lang['type_Search'] = 'Recherche&nbsp;';
$lang['type_searchform'] = '&nbsp;Formulaire de recherche';
$lang['type_searchresults'] = '&nbsp;Résultats de la recherche';
$lang['usestemming'] = 'Utiliser la liste de mots exclus&nbsp;';
$lang['use_or'] = 'Trouver des résultats qui correspondent à au moins un mot';
$lang['word'] = 'Mots';
?>