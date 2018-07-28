<?php
$lang['friendlyname'] = 'Gestion multi-langues';
$lang['postinstall'] = 'Module installé, (Note : pensez à ajouter la permission "manage xxx_mle" pour pouvoir utiliser ce module !)';
$lang['postuninstall'] = 'Le module Mle CMS a été désinstallé';
$lang['really_uninstall'] = 'R\u00E9ellement ?\n\u00CAtes-vous s\u00FBr(e) de vouloir d\u00E9sinstaller ce chouette module ?';
$lang['uninstalled'] = 'Module désinstallé.';
$lang['installed'] = 'Module version %s installé.';
$lang['upgraded'] = 'Le module a été mis à jour à la version %s.';
$lang['moddescription'] = 'Ce module apporte une solution multilangues pour votre CmsMadeSimple';
$lang['info_success'] = 'Succès';
$lang['optionsupdated'] = 'Options mises à jour';
$lang['module_missing'] = 'SVP, installer le module %s';
$lang['error'] = 'Erreur !';
$lang['admindescription'] = 'Le module MleCMS est une solution pour réaliser un site web multilangues pour CMS Made Simple, sans modification du code du noyau du CMS';
$lang['accessdenied'] = 'Accès refusé. Veuillez vérifier vos permissions.';
$lang['mle_config'] = 'Configuration multilangues';
$lang['idtext'] = 'ID&nbsp;';
$lang['alias'] = 'Alias racine&nbsp;';
$lang['name'] = 'Nom&nbsp;';
$lang['extra'] = 'Extra&nbsp;';
$lang['canonical'] = 'URL canonique';
$lang['par_template'] = 'Paramètre de Smarty dans les gabarits&nbsp;';
$lang['locale'] = 'Locale pour CMSMS&nbsp;';
$lang['documentation'] = 'Documentation&nbsp;';
$lang['example'] = 'Exemple&nbsp;';
$lang['flag'] = 'Drapeau&nbsp;';
$lang['mle_init'] = 'Détection multilangues&nbsp;';
$lang['default_root_base'] = 'Défaut (basé sur identification de l\'alias de la racine)';
$lang['manage_snippets'] = 'Snippets&nbsp;';
$lang['unknown'] = 'Erreur : inconnue';
$lang['delete'] = 'Supprimer&nbsp;';
$lang['areyousure'] = '\u00CAtes-vous s\u00FBr(e) ?';
$lang['edit'] = 'Editer';
$lang['add'] = 'Ajouter';
$lang['source'] = 'Source&nbsp;';
$lang['submit'] = 'Envoyer';
$lang['cancel'] = 'Annuler';
$lang['apply'] = 'Appliquer';
$lang['tag'] = 'Balise';
$lang['manage_blocks'] = 'Blocs';
$lang['options'] = 'Options&nbsp;';
$lang['mle_template'] = 'Gabarit multilangues';
$lang['addedit_mle_template'] = 'Ajouter/Editer le gabarit multilangues';
$lang['mle_hierarchy_switch'] = 'Basculer les langues dans chaque hiérarchie&nbsp;';
$lang['mle_search_restriction'] = 'Restriction de la recherche MLE (uniquement pour la recherche dans les pages)&nbsp;';
$lang['mle_auto_redirect'] = 'Détection de la langue&nbsp;';
$lang['none'] = 'Aucun';
$lang['root_redirect'] = 'Rediriger vers le répertoire racine';
$lang['hierarchy_redirect'] = 'Rediriger à chaque niveau de la hiérarchie';
$lang['mle_translator'] = 'Traducteur';
$lang['mle_translator_example'] = 'Indiquer dans votre gabarit : {translate text="mon_mot"}, puis retourner dans l\'onglet traducteur et éditer le texte.';
$lang['help_name'] = 'Snippet ou nom du bloc';
$lang['help_template'] = 'gabarit (default Flags)';
$lang['help_excludeprefix'] = 'exclude prefix (pour action sur paramètre "lang")';
$lang['help_includeprefix'] = 'include prefix (pour action sur paramètre "lang")';
$lang['help'] = '<h3>Que fait ce module ?</h3>
<p>Ce module ajoute une solution multilingue pour CMS Made Simple.</p>
<h3>Comment l\'utiliser ?</h3>
<p>Vérifier le <a href="http://cmsmadesimple.sk/modules/MleCMS/installation-guide.html"title="MleCMS - installation guide 1.1">guide d\'installation</a> ou <a target="_blank" href="http://blog.arvixe.com/creating-a-multilingual-cmsms-site-using-mlecms-module/" title="Creating a Multilingual CMSMS Site Using MleCMS Module par Goran Ilic" >Creating a Multilingual CMSMS Site Using MleCMS Module</a></p>
<p>ou <a target="_blank" href="http://wiki.cmsmadesimple.fr/wiki/MleCMS_(Module)" title="Wiki cmsmadesimple.fr">MleCMS (Module) sur le Wiki cmsmadesimple.fr</a></p>

<h3>Plugins</h3>
<p><strong>Translate</strong> {translate text="un_texte"} or {translator}sun_texte{/translator}</p>
<p>Paramètres</p>
<ul>
<li>text (requis) - texte à traduire</li>
<li>assign (option)  - smarty assign</li>
</ul>
<br />
<p><strong>mle_assign</strong> - (news example: {mle_assign object=$entry par="title" assign="entry"}) </p>
<p>Paramètres</p>
<ul>
<li>object or array (requis) - object/array for mle assign</li>
<li>par (requis)  - pour trouver une chaîne de multilingue (par exemple : les titres sont title_sk, title_de, title_fr, où le titre est une chaîne par défaut pour la langue par défaut. Super solution MLE dans les gabarits)</li>
<li>assign (option)  - assign to object</li>
</ul>
<br />

<p><strong>mle_selflink</strong> - ({mle_selfink page="alias"}) </p>
<p>Paramètres</p>
<ul>
<li>page/href - comme la balise cms_selflink</li>
<li>assign (option)</li>
</ul>
<br />

<h3>Aimez-vous mon travail ?  </h3>
<p><a href="http://cmsmadesimple.sk/donate-card/?utm_source=cmsmadesimple&utm_medium=link&utm_campaign=help" target="_blank">Give me five or feel free to donate me</a></p>';
?>