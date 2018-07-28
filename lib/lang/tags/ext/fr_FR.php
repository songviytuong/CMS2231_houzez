<?php
$lang['help_function_page_selector'] = '<h3>Que fait cette balise ?</h3>
<p>C\'est un plugin administration qui fournit un contrôle pour permettre la sélection d\'une page de contenu, ou un autre élément. Ceci est approprié pour permettre à un administrateur du site de sélectionner une page qui sera stockée dans une préférence..</p>
<h3>Comment l\'utiliser ?</h3>
<pre><code>{page_selector name=dfltpage value=$currentpage}</code></pre>
<h3>Quels paramètres ?</h3>
<ul>
  <li>name - <em>(string)</em> - Le nom du champ de saisie.</p>
  <li>value - <em>(int)</em> - L\'id de la page sélectionnée.</p>
  <li>allowcurrent - <em>(bool)</em> - Permettre ou ne pas permettre à l\'élément sélectionné d\'être à nouveau sélectionné. La valeur par défaut est false.</li>
  <li>allow_all - <em>(bool)</em> - Permettre ou ne pas permettre de sélectionner des éléments de contenu inactifs, ou les éléments de contenu qui ne disposent pas de liens utilisables. La valeur par défaut est false.</li>
  <li>for_child - <em>(bool)</em> - Indique que nous sélectionnons une page parent pour un nouvel élément de contenu. La valeur par défaut est false.</p>
  </li>
</ul>';
$lang['help_function_cms_html_options'] = '<h3>Que fait cette balise ?</h3>
<p>C\'est un plugin pour afficher les éléments balises HTML < option > et < optgroup >. Chaque option peut avoir des éléments enfant, sa propre étiquette de titre, et si besoin son propre attribut de classe.</p>
<h3>Usage:</h3>
<pre><code>{cms_html_options options=$options [selected=value]}</code></pre>
<h3>Comment l\'utiliser ?</h3>
<ul>
  <li>options - <em>(array)</em> - Un tableau de définitions des options.</li>
  <li>selected - <em>(string)</em> - La valeur de sélection automatique dans la liste déroulante. Elle doit correspondre à la valeur de l\'une des options.</li>
</ul>
<h4>Options</h4>
<p>Chaque option est un tableau associatif avec deux ou plus des membres suivants :</p>
<ul>
  <li>label - <em>(<strong>requis</strong> string)</em> Un label pour l\'option (celui ci est présenté à l\'utilisateur)</li>
  <li>value - <em>(<strong>requis</strong> mixed)</em>Soit une valeur de chaîne pour l\'option, ou un tableau de définitions des options.
    <p>Si la valeur d\'une définition de l\'option est lui-même un tableau d\'options, alors le label sera affiché comme une optgroup avec ses enfants.</p>
  </li>
  <li>title - <em>(string)</em> Un attribut de titre pour l\'option.</li>
  <li>class - <em>(string)</em> Un nom de classe pour l\'option.</li>
</ul>

<h3>Exemple :</h3>
<pre><code>
{$opts[]=[\'label\'=>\'Bird\',\'value\'=>\'b\',\'title\'=>\'I have a pet bird\']}
{$opts[]=[\'label\'=>\'Fish\',\'value\'=>\'f\']}
{$sub[]=[\'label\'=>\'Small Dog\',\'value\'=>\'sd\']}
{$sub[]=[\'label\'=>\'Medium Dog\',\'value\'=>\'md\']}
{$sub[]=[\'label\'=>\'Large Dog\',\'value\'=>\'ld\']}
{$opts[]=[\'label\'=>\'Dog\',\'value\'=>$sub]}
{$opts[]=[\'label\'=>\'Cat\',\'value\'=>\'c\',\'class\'=>\'cat\']}
< select name="pet" >
  {cms_html_options options=$opts selected=\'md\'}
< /select ></code></pre>';
$lang['help_modifier_cms_date_format'] = '<h3>Que fait cette balise ?</h3>
 <p>Ce modificateur est utilisé pour formater des dates dans un format adapté. Il utilise les paramètres standard de "strftime". Si aucune chaîne de format n\'est spécifiée, le système utilisera le "Format de la date" de "Mon compte/Préférences utilisateur" (pour les utilisateurs connectés) ou le format des dates du système.</p>
 <p>Ce modificateur est capable de comprendre les dates dans de nombreux formats. Exemple : chaînes de sortie date-heure de la base de données ou timestamps (entier) généré par la fonction time().</p>
<h3>Comment l\'utiliser ?</h3>
<pre><code>{$une_variable_date|cms_date_format[format de chaîne]}</code></pre>
<h3>Exemple :</h3>
<pre><code>{\'2012-03-24 22:44:22\'|cms_date_format}</code></pre>';
$lang['help_modifier_cms_escape'] = '<h3>Que fait cette balise ?</h3>
<p>Ce modificateur est utilisé pour échapper la chaîne par un des nombreux types énumérés ci-dessous. Ceci peut être utilisé pour convertir la chaîne en plusieurs formats d\'affichage différents ou, pour les données entrées par l\'utilisateur, avec des caractères spéciaux affichables sur une page Web standard.</p>
<h3>Comment l\'utiliser ?</h3>
<pre><code>{$une_variable_avec_texte|cms_escape[Type_échappement|[Jeu_de_caractères]}</code></pre>
<h4>Types d\'échappement valides : Note traduction à valider</h4>
<ul>
	<li>html <em>(defaut)</em> - use htmlspecialchars - utilise htmlspecialchars (échappe les caractères <pre><code>& " \' < ></code></pre>).</li>
	<li>htmlall - use htmlentities - échappe toutes les entités html.</li>
	<li>url - raw URL encode all entities - Pour coder toutes les entités d\'une URL brute.</li>
	<li>urlpathinfo - identique à url, mais encode également les /.</li>
	<li>quotes - Escape unescaped single quotes - échappe les apostrophes simples.</li>
	<li>hex - Escape every character into hex - échappe chaque caractère en hexadécimal (ex : cryptage adresse email).</li>
	<li>hexentity - Hex encode every character - encode chaque caractères en entités hexadécimales (ex : adresse email).</li>
	<li>decentity - Decimal encode every character - encode chaque caractères en entités décimales (ex : adresse email).</li>
	<li>javascript - Escape quotes, backslashes, newlines etc - échappe les apostrophes, backslashes, saut de lignes...</li>
	<li>mail - Encode an email address into something that is safe to display - encode une adresse email dans une chaîne sûre pour l\'affichage (info [AT] exemple [DOT] com). </li>
	<li>nonstd - Escape non standard characters, such as document quotes - encode des caractères non standard.</li>
</ul>
<h4>Jeu de caractères</h4>
<p>Si le jeu de caractères n\'est pas spécifié, UTF-8 est utilisé. Le jeu de caractères est seulement applicable au "html" et au type d\'échappement "htmlall".</p>';
$lang['help_modifier_relative_time'] = '<h3>Que fait cette balise ?</h3>
  <p>Ce modificateur convertit un entier timestamp ou la chaîne time/date vers une durée de temps compréhensible par un être humain : temps écoulé depuis une certaine date ou jusqu\'à maintenant. Ex. : "3 hours ago." (il y a 3 heures)</p>
<h3>Comment l\'utiliser ?</h3>
 <p>Ce modificateur n\'accepte pas les paramètres optionnels.</p>
<h3>Exemple :</h3>
  <pre><code>{$some_timestamp|relative_time}</code></pre>';
$lang['help_modifier_summarize'] = '<h3>Que fait cette balise ?</h3>
<p>Ce modificateur est utilisé pour tronquer une longue séquence de texte à un nombre limité de "mots".</p>
<h3>Comment l\'utiliser ?</h3>
<pre><code>{$une_variable_avec_long_texte|summarize:nombre}</code></pre>
<h3>Exemple :</h3>
<p>L\'exemple suivant supprime toutes les balises html du contenu et le tronque après 50 mots.</p>
<pre><code>{content|strip_tags|summarize:50}</code></pre>';
$lang['help_function_admin_icon'] = '<h3>Que fait cette balise ?</h3>
<p>C\'est un plugin d\'administration uniquement, permettant aux modules d\'afficher facilement les icônes du thème d\'administration actuel. Ces icônes sont utiles dans la construction des liens ou pour afficher des informations d\'état.</p>
<h3>Quels paramètres ?</h3>
<ul>
  <li>icon - <strong>(requis)</strong> - Le nom du fichier icône. ex : run.gif</li>
  <li>height - <em>(option)</em> - La hauteur (en pixels) de l\'icône.</li>
  <li>width - <em>(option)</em> - La largeur (in pixels) de l\'icône.</li>
  <li>alt - <em>(option)</em> - Le texte optionnel pour la balise img, si le nom de fichier spécifié n\'est pas disponible.</li>
  <li>rel - <em>(option)</em> - Un attribut optionnel "rel" pour la balise img.</li>
  <li>class - <em>(option)</em> - Un attribut de classe optionnel pour la balise img.</li>
  <li>id - <em>(option)</em> - Un attribut optionnel Id pour la balise img.</li>
  <li>title - <em>(option)</em> - Un attribut optionnel de titre pour la balise img.</li>
  <li>accesskey - <em>(option)</em> - Attribut optionnel "accesskey" pour la balise img.</li>
  <li>assign - <em>(option)</em> - Affecte (Assigne) le résultat de la balise à la variable Smarty ainsi nommée.</li>
</ul>
<h3>Exemple :</h3>
<pre><code>{admin_icon icon=\'edit.gif\' class=\'editicon\'}</code></pre>';
$lang['help_function_cms_action_url'] = '<h3>Que fait cette balise ?</h3>
<p>Ceci est un plugin intelligent utile pour générer une URL sous l\'action d\'un module. Ce plugin est utile pour les développeurs de modules qui génèrent des liens (que ce soit pour Ajax ou dans l\'interface administration) pour réaliser des fonctionnalités différentes ou afficher des données différentes.</p>
<h3>Quels paramètres ?</h3>
<ul>
  <li>module - <em>(option)</em> - Le nom du module pour générer une URL. Ce paramètre n\'est pas nécessaire si l\'URL produite sous l\'action du module est utilisée dans le même module.</li>
  <li>action - <strong>(requis)</strong> - Le nom de l\'action qui génère une URL.</li>
  <li>returnid - <em>(option)</em> - Entier (integer) correspondant à la PageId de la page où il faut afficher les résultats de l\'action. Ce paramètre n\'est pas nécessaire si l\'action doit être affiché sur la page courante, ou si l\'URL est destinée à une action d\'administration depuis une action d\'administration.</li>
  <li>mid - <em>(option)</em> - Id de l\'action du module. Par défaut, c\'est "m1_" pour des actions d\'administration, et "cntnt01" pour les actions sur le site Web (frontend).</li>
  <li>forjs - <em>(option)</em> - Entier (integer) facultatif qui indique que l\'URL générée doit être adaptée pour une utilisation en JavaScript.</li>
  <li>assign - <em>(option)</em> -  Affecte (Assigne)la sortie URL de la balise à la variable Smarty ainsi nommée.</li>
</ul>
<p><strong>Note :</strong> Tous les autres paramètres qui ne sont pas acceptés par ce plugin sont automatiquement transmis à l\'action du module par l\'URL générée.</p>
<h3>Exemple :</h3>
<pre><code>{cms_action_url module=News action=defaultadmin}</code><pre>';
$lang['help_function_cms_admin_user'] = '<h3>Que fait cette balise ?</h3>
<p>Ce plugin administrateur donne une information sur l\'utilisateur "Admin" à partir de son Id.</p>
<h3>Quels paramètres ?</h3>
<ul>
  <li>uid - <strong>requis</strong> - Un Id utilisateur entier, représentant un compte admin valide.</li>
  <li>mode - <em>(option)</em> - Le mode de fonctionnement. Les valeurs possibles sont :
    <ul>
      <li>username <strong>default</strong> - retourne le nom d\'utilisateur pour l\'UID spécifié.</li>
      <li>email - retourne l\'adresse email de l\'UID indiqué.</li>
      <li>firstname - retourne le prénom de l\'UID indiqué.</li>
      <li>lastname - retourne le nom de famille de l\'UID indiqué.</li>
      <li>fullname - donner le nom complet de l\'UID indiqué.</li>
    </ul>
  </li>
  <li>assign - <em>(option)</em> - Affecte (Assigne) le résultat de la balise à la variable Smarty ainsi nommée.</li>
</ul>
<h3>Exemple :</h3>
<pre><code>{cms_admin_user uid=1 mode=email}</code></pre>';
$lang['help_function_cms_get_language'] = '<h3>Que fait cette balise ?</h3>
<p>Cette balise retourne le nom du langage courant CMSMS™. La langue est utilisée pour les chaînes de traduction et de mise en forme de la date.</p>
<h3>Comment l\'utiliser ?</h3>
<ul>
	<li><em>(option)</em> assign - Affecte (Assigne) le résultat de la balise à la variable Smarty ainsi nommée.</li>
</ul>';
$lang['help_function_cms_help'] = '<h3>Que fait cette balise ?</h3>
<p>C\'est un plugin d\'administration uniquement, utilisé pour générer un lien qui lorsqu\'il est cliqué va afficher une aide contextuelle pour un élément particulier.</p>
<p>Ce plugin est généralement utilisé à partir des gabarits module d\'administration pour afficher un popup d\'aide utilisateur pour un champ de saisie, une colonne ou autres renseignements importants.</p>
<h3>Quels paramètres ?</h3>
<ul>
  <li>key - <strong>requis string</strong> - La deuxième partie d\'une clé unique pour identifier la chaîne d\'aide à afficher. C\'est généralement la clé du fichier de langue appropriée.</li>
  <li>realm - <em>(option string)</em> - La première partie d\'une clé unique pour identifier la chaîne d\'aide. Si ce paramètre n\'est pas précisé et si ce plugin est appelé à partir d\'une action de module alors le nom du module en cours est utilisé. Si aucun nom de module ne peut être trouvé alors "help" utilise la langue utilisateur.</li>
  <li>title - <em>(option string)</em> - Le titre de la fenêtre Aide</ li>
<li><em>(option)</em> assign - Affecte (Assigne) le résultat de la balise à la variable Smarty ainsi nommée.</li>
</ul>
<h3>Exemple :</h3>
<pre><code>{cms_help key2=\'help_field_username\' title=$foo}</code></pre>';
$lang['help_function_cms_init_editor'] = '<h3>Que fait cette balise ?</h3>
  <p>Cette balise est utilisée pour initialiser les fonctionnalités WYSIWYG de l\'éditeur WYSIWYG pour la soumission des données du site Web (frontend). Ce module sélectionnera le WYSIWYG du site Web (frontend) <em>(Menu Paramètres globaux/Paramètres généraux )</em>, déterminera s\'il a été demandé, et générera le <em>code HTML approprié (les liens JavaScript)</em> pour que l\'affichage WYSIWYG se fasse correctement lorsque la page est chargée. Si aucun éditeur WYSIWYG n\'est demandé cette balise n\'aura aucun effet.</p>
<h3>Comment l\'utiliser ?</h3>
<p>La première chose que vous devez faire est de sélectionner l\'éditeur WYSIWYG à utiliser sur le site Web (frontend),dans la page "Administration du site/Paramètres globaux/Paramètres généraux". Ensuite si vous utilisez l\'éditeur WYSIWYG sur de nombreuses pages, il peut être préférable de placer la balise {cms_init_editor} directement dans le gabarit des page. Si vous avez besoin de l\'éditeur WYSIWYG dans un nombre limité de pages, vous pouvez juste placer la balise dans la page grâce à l\'onglet Options "Métadonnées spécifiques pour cette page"</p>
<h3>Quels paramètres ?</h3>
<ul>
	<li><em>(option)</em> assign - Affecte (Assigne) le résultat de la balise à la variable Smarty ainsi nommée.</li>
</ul>';
$lang['help_function_cms_lang_info'] = '<h3>Que fait cette balise ?</h3>
<p>Cette balise retourne un objet contenant les informations sur la langue sélectionnée dont CMSMS™ dispose. Cela peut inclure des informations de localisation, les codages, la langue, alias, etc...</p>
<h3>Comment l\'utiliser ?</h3>
<ul>
	<li><em>(option)</em> lang - La langue dans laquelle retourner les informations. Si le paramètre "lang" n\'est pas spécifié alors l\'information pour le langage courant CMSMS™ est utilisé.</li>
	<li><em>(option)</em> assign - Affecte (Assigne) le résultat de la balise à la variable Smarty ainsi nommée.</li>
</ul>
<h3>Exemple :</h3>
<pre>{cms_lang_info assign=\'nls\'}{$nls->locale()}</pre>
<h3>Voir aussi :</h3>
<p>La documentation de la classe CmsNls.</p>';
$lang['help_function_cms_pageoptions'] = '<h3>Que fait cette balise ?</h3>
 <p>C\'est un simple plugin qui génère une séquence de balises "Option" pour une liste déroulante de pagination qui représente les numéros de page.</p>
 <p>En fonction du nombre de pages et de la page actuelle ce plugin va générer une liste de numéros de pages qui permettent une navigation rapide vers un sous-ensemble des pages.</p>
<h3>Quels paramètres ?</h3>
  <ul>
    <li>numpages - <strong>requis integer</strong> - le nombre total de pages disponibles à afficher.</li>
    <li>curpage - <strong>requis integer</strong> - Le numéro de la page en cours (doit être supérieur à 0 et inférieur ou égal à "numpages"</li>
    <li>surround - <em>(option integer)</em> - Le nombre d\'élément pour entourer la page courante. La valeur par défaut de ce paramètre est 3.</li>
<li>bare - <em>(option boolean)</em> - Pas d\'option de sortie, donne juste un simple "array" pour une manipulation dans Smarty.</li>
  </ul>
<h3>Exemple :</h3>
<pre><code><select name="{$actionid}pagenum">{cms_pageoptions numpages=50 curpage=14}</select></code></pre>';
$lang['help_function_share_data'] = '<h3>Que fait cette balise ?</h3>
 	<p>Cette balise permet de copier une ou plusieurs variables Smarty actives vers le parent ou pour une étendue plus globale.</p>
 	<h3>Quels paramètres ?</h3>
 	<ul>
 	<li>scope - <em>(option string)</em> - La portée de la cible pour copier les variables. Les valeurs possibles sont "parent" <em>(par défaut)</em> ou "global" pour copier les données vers la variable Smarty pour une utilisation ultérieure dans toute la page.</li>
 	<li>vars - <strong>requis mixed</strong> - Soit un tableau de "string" des noms de variables, soit une liste de "string" de noms de variables séparés par des virgules.</li>
 	</ul>
 	<h3>Exemple :</h3>
 	<pre><code>{share_data scope=global data=\'title,canonical\'}</code></pre>
 	<h3>Note :</h3>
 	<p>Cette balise n\'acceptera pas de "array accessors" ou "object members" comme noms de variable. Exemple : <code>{$foo[1]}</code> ou <code>{$foo->bar}</code> ne fonctionnera pas.</p>';
$lang['help_function_cms_yesno'] = '<h3>Que fait cette balise ?</h3>
<p>C\'est un plugin simple, utilisé dans la génération de formulaire pour créer un ensemble d\'options < select > représentant un choix Oui/Non.</p>
<p>Ce plugin va traduire le choix Oui/Non en une valeur préalablement choisie.</p>
<h3>Quels paramètres ?</h3>
<ul>
  <li>selected - <em>(option integer)</em> - soit 0 <em>(no)</em> ou 1 <em>(yes)</em></li>
  <li>assign - <em>(option string)</em> - Affecte (Assigne) le résultat de la balise à la variable Smarty ainsi nommée.</li>
</ul>
<h3>Exemple :</h3>
<pre><code>< select name="{$actionid}opt" >{cms_yesno selected=$opt}< /select ></code></pre>';
$lang['help_function_module_available'] = '<h3>Que fait cette balise ?</h3>
Une balise pour tester si un module donné (par son nom) est installé
<h3>Comment l\'utiliser ?</h3>
<ul>
	<li><strong>(requis)</strong> module - (string) Le nom du module.</li>
	<li><em>(option)</em> assign - Affecte (Assigne) le résultat de la balise à la variable Smarty ainsi nommée.</li>
</ul>
<h3>Exemple :</h3>
{module_available module=\'News\' assign=\'havenews\'}{if $havenews}{cms_module module=News}{/if}
<h3>Note :</h3>
<p>Dans cette expression, vous ne pouvez pas utiliser la balise du module appelé, dans notre exemple. Ex : <em>{News}</em> dans cette expression.</p>';
$lang['help_function_cms_set_language'] = '<h3>Que fait cette balise ?</h3>
<p>Cette balise défini le langage courant pour une utilisation des chaînes de traduction et la mise en forme de la date correspondant à la langue désirée. La langue spécifiée doit être connue de CMSMS™ (Le fichier nls doit exister ). Lorsque cette fonction est appelée, (et à moins de substitution dans le fichier config.php) une tentative sera faite pour définir les paramètres régionaux depuis la variable PHP "locale" associée à la langue. La localisation de la langue doit être installée sur le serveur.</p>
<h3>Comment l\'utiliser ?</h3>
<ul>
	<li><strong>(requis)</strong> lang - La langue souhaitée. La langue doit être connue à l\'installation de CMSMS™ (Le fichier nls doit exister).</li>
</ul>';
$lang['help_function_browser_lang'] = '<h3>Que fait cette balise ?</h3>
<p>Cette balise détecte et donne la langue que le navigateur utilisé accepte, et la compare à une liste des langues autorisées pour déterminer la langue de la session.</p>
<h3>Comment l\'utiliser ?</h3>
<p>Insérer la balise dans votre gabarit : <em>(elle peut être au-dessus de la section < head > si vous voulez)</em> et indiquez lui le nom de la langue par défaut, et les langues acceptées (seul deux caractères de noms de langue sont acceptés), puis utilisez le résultat. Exemple :</p>
<pre><code>{browser_lang accepted="de,fr,en,es" default=en assign=tmp}{session_put var=lang val=$tmp}</code></pre>
<p><em>ATTENTION {session_put} est une balise fournie par le module CGSimpleSmarty</em></p>
<h3>Quels paramètres </h3>
<ul>
 	<li><strong>(requis)</strong> accepted - Une virgule comme séparateur de liste pour les deux caractères de noms de langues acceptées.</li>
	<li><em>(option)</em> default - une langue par défaut, si aucune langue acceptée n\'a été prise en charge par le navigateur. "en" est utilisée si aucune valeur n\'est spécifiée.</li>
	<li><em>(option)</em> assign - Affecte (Assigne) le résultat de la balise à la variable Smarty ainsi nommée. Si non spécifié les résultats de cette fonction sont retournés.</li>
</ul>';
$lang['help_function_content_module'] = '<h3>Que fait cette balise ?</h3>
<p>Ce type de bloc de contenu permet d\'interagir avec différents modules pour créer des blocs de contenu différents.</p>
<p>Certains modules peuvent définir des types de bloc de contenu qui seront utilisés dans les gabarits des modules. Par exemple, le module FrontEndUsers pourrait déterminer un type de bloc de contenu pour la liste des groupes. Il vous sera alors indiqué comment vous pourrez utiliser la balise content_module pour insérer ce type de bloc de contenu à l\'intérieur de vos gabarits.</p>
<p><strong>Note :</strong> ce type de bloc doit être utilisé uniquement avec les modules compatibles. Vous ne devriez l\'utiliser en aucune façon sauf si cela est expressément indiqué par un module.</p>
	<p>Cette balise accepte quelques paramètres, et passe tous les autres paramètres par le module.</p>
 	<p>Paramètres :
 	 <ul>
 	 <li><strong>(requis)</strong> module - Le nom du module qui offrira ce bloc de contenu. Ce module doit être installé et disponible</li>
 	 <li><strong>(requis</strong> block - Le nom du bloc de contenu.</li>
 	 <li><em>(option)</em> label - Un label pour le bloc de contenu pour une utilisation lors de l\'édition de la page.</li>
	 <li><em>(option)</em> requis - Permet de spécifier que le bloc de contenu doit contenir du texte.</em></li>
	 <li><em>(option)</em> tab - L\'onglet désiré pour afficher ce champ dans le formulaire d\'édition.</li>
<li><em>(option)</em> priority (integer) - Permet de spécifier un entier "priority" pour le bloc dans l\'onglet.</li>
 	 <li><em>(option)</em> assign (string) - Affecte (Assigne) le résultat de la balise à la variable Smarty ainsi nommée.</li>
 	 </ul>
        </p>';
$lang['help_function_cms_stylesheet'] = '<h3>Que fait cette balise ?</h3>
 	  <p>C\'est un remplacement de la balise {stylesheet}. Cette nouvelle balise permet la mise en cache des fichiers CSS en générant des fichiers statiques dans le dossier tmp/cache, ainsi que le traitement des balises Smarty dans les feuilles de style.</p>
 	  <p>Cette balise récupère les informations des feuilles de style du système. Par défaut, elle prend toutes celles qui sont liées au gabarit en cours, et les combine en une seule balise de feuille de style.</p>
 	  <p>Les feuilles de styles créés sont nommées en fonction de la date de dernière modification dans la base de données et ne sont générées que si la feuille de style a changé.</p>
 	  <p> Cette balise est le remplacement de {stylesheet} qui est désormais obsolète.</p>
 	  <h3>Comment l\'utiliser ?</h3>
 	  <p>Insérer la balise dans votre page ou votre gabarit dans l\'entête :<code>{cms_stylesheet} </code></p>
 	  <h3>Quels paramètres ?</h3>
<ul>
	<li><em>(option)</em> name - Au lieu d\'avoir toutes les feuilles de style pour la page donnée, il n\'y aura que celle nommée spécifiquement, qu\'elle soit liée au gabarit en cours ou non.</li>
	<li><em>(option)</em> nocombine - (boolean, par défaut false) si activé, et s\'il y a plusieurs feuilles de style associées au gabarit, les feuilles de style seront séparées au lieu d\'être combinées en une seule balise de feuille de style.</li>
	<li><em>(option)</em> nolinks - (boolean, par défaut false) si activé, les feuilles de style auront une sortie comme une URL sans la balise "link".</li>
	<li><em>(option)</em> https - (boolean, par défaut false) si activé, indique, dans le cas où paramètre "ssl_url" du config.php est activé, de préfixer les URLs des feuilles de style. S\'il n\'est pas spécifié, le système va tenter de déterminer l\'URL racine appropriée fondée sur la sécurité de la page affichée.</li>
	<li><em>(option)</em> designid - Si designid est défini, la balise retournera les feuilles de style associées à ce gabarit au lieu de celui en cours.</li>
	<li><em>(option)</em> media - <strong>[obsolète]</strong> - Si utilisé avec le paramètre "name", ce paramètre modifiera le type de média pour la feuille de style. Utilisé avec le paramètre "templateid", le paramètre média ne produira des balises de feuilles de style que pour les feuilles de style compatibles avec le type de media spécifié.</li>
</ul>
 	  <h3>Processus Smarty </h3>
  <p>Lors de la génération des fichiers CSS, ce système passe les feuilles de style extraites de la base de données grâce à Smarty. Les délimiteurs Smarty standard CMSMS™ { et } ont été changés en [[ et ]] pour faciliter la transition dans les feuilles de styles. Cela permet la création de variables Smarty comme : [[assign var=\'red\' value=\'#900\']] en haut de la feuille de styles, puis d\'utiliser ces variables plus loin dans la feuille de style. Exemple : </p>
<pre>
<code>
h3 .error { color: [[$red]]; }<br/>
</code>
</pre>
<p>Comme les fichiers mis en cache sont générés dans le dossier tmp/cache de l\'installation de CMSMS™, le dossier de travail des CSS n\'est pas la racine du site. Par conséquent, toutes les images, ou d\'autres balises qui nécessitent une URL doivent utiliser la balise [[root_url]]  pour la forcer à être une URL absolue. Exemple : </p>
<pre>
<code>
h3 .error { background: url([[root_url]]/uploads/images/error_background.gif); }<br/>
</code>
</pre>
<p><strong>Note :</strong> Étant donné que les balises sont mise en cache, les variables Smarty doivent être placées au sommet de CHAQUE feuille de style, qui est attaché à un gabarit.</p>';
$lang['help_function_page_attr'] = '<h3>Que fait cette balise ?</h3>
<p>Cette balise peut être utilisée pour renvoyer la valeur des attributs d\'une page déterminée.</p>
<h3>Comment l\'utiliser ?</h3>
<p>Insérer la balise dans votre gabarit : <code>{page_attr key="extra1"}</code>.</p>
<h3>Quels paramètres ?</h3>
<ul>
  <li><em>(option)</em> page (int|string) - Une id de page optionnelle ou un alias pour récupérer du contenu. Si non spécifié, la page actuelle est affichée.</li>
  <li><strong>key (requis)</strong> La clé de l\'attribut retournée.
    <p> La clé peut être soit un nom de bloc, ou un ensemble de propriétés standard associées à une page de contenu. Quelques-unes des propriétés standard acceptées sont :</p>
    <ul>
      <li>_dflt_ - (string) La valeur pour le bloc de contenu par défaut (un alias de content_en).</li>
      <li>title</li>
      <li>description</li>
      <li>alias - (string) Les alias de pages uniques.</li>
      <li>id - (int) Id unique de la page.</li>
      <li>created_date - (string date) Date de la création du contenu.</li>
      <li>modified_date - (string date) Date de la dernière modification du contenu.</li>
      <li>last_modified_by - (int) UID de l\'utilisateur qui a modifié la page.</li>
      <li>owner - (int) UID du propriétaire de la page.</li>
      <li>image - (string) Le chemin vers l\'image associée avec le contenu de la page.</li>
      <li>thumbnail - (string) Le chemin de la vignette associée avec le contenu de la page.</li>
      <li>extra1 - (string) La valeur de l\'attribut extra1</li>
      <li>extra2 - (string) La valeur de l\'attribut extra2.</li>
      <li>extra3 - (string) La valeur de l\'attribut extra3.</li>
      <li>pageattr - (string) La valeur de la donnée attribut Smarty spécifique à la page.</li>
     </ul>
<p><strong>Note :</strong> La liste ci-dessus n\'est pas exhaustive. Vous pouvez également récupérer les contenus non traités des blocs de contenu supplémentaires ou des propriétés ajoutées par des modules tiers. La sortie est toujours une chaîne de caractères.</p>
  <li><em>(option)</em> assign (string) - Affecte (Assigne) le résultat de la balise à la variable Smarty ainsi nommée.</li>
</ul>
<h3>Retours :</h3>
<p><strong>string</strong> - La valeur réelle du bloc de contenu à partir de la base de données pour le bloc et la page spécifiés.</p>
<p><strong>Note :</strong> - La sortie de ce plugin ne passe pas par Smarty et n\'est pas nettoyé pour l\'affichage. Pour l\'affichage des données, vous devez convertir les chaînes de données en entités, et/ou les passer par Smarty.</p>';
$lang['help_function_page_image'] = '<h3>Que fait cette balise ?</h3>
<p>Cette balise peut être utilisée pour renvoyer la valeur du champ image ou vignette d\'une certaine page</p>
<h3>Comment l\'utiliser ?</h3>
<p>Insérer la balise dans votre gabarit : <code>{page_image}</code>.</p>
<h3>Quels paramètres ?</h3>
<ul>
  <li><em>(option)</em> thumbnail (bool) - Affiche la valeur de la propriété de la vignette au lieu de celle de l\'image.</li>
  <li><em>(option)</em> full (bool) - Affiche également l\'URL complète de l\'image par rapport au chemin relatif d\'importation des images.</li>
  <li><em>(option)</em> tag (bool) - Affiche éventuellement une étiquette d\'image complète, si la valeur de la propriété n\'est pas vide. Si l\'argument tag est activé, full est implicite.</li>
  <li><em>(option)</em> assign (string) - Affecte (Assigne) le résultat de la balise à la variable Smarty ainsi nommée.</li>
</ul>
<h3>Plus...</h3>
<p>Si l\'argument tag est activé et que la valeur de la propriété n\'est pas vide, cela déclenchera une balise HTML img complète à afficher. Tous les arguments du plugin non listés ci-dessus seront automatiquement inclus dans la balise img résultante. Exemple : <code>{page_image tag=true class="pageimage" id="someid" title="testing"}</code>.</p>
<p>Si le plugin produit une balise img complète et que l\'argument alt n\'a pas été fourni, la valeur de la propriété sera utilisée pour l\'attribut alt de la balise img.</p>';
$lang['help_function_dump'] = '<h3>Que fait cette balise ?</h3>
  <p>Cette balise peut être utilisée pour lire (dump) le contenu de toute variable Smarty dans un format plus lisible. Ceci est utile pour le débogage et l\'édition des gabarits, afin de connaître le format et le type de données disponibles.</p>
<h3>Comment l\'utiliser ?</h3>
<p>Insérer la balise dans votre gabarit :<code>{dump item=\'the_smarty_variable_to_dump\'}</code>.</p>
<h3>Quels paramètres ?</h3>
<ul>
	<li><strong>item (requis)</strong> - La variable Smarty pour lire (dump) le contenu</li>
	<li>maxlevel - Le nombre maximum de niveaux récursifs (applicable uniquement si "recurse" est également donné). La valeur par défaut pour ce paramètre est 3</li>
	<li>nomethods - Évite les methods from objets.</li>
	<li>novars - Évite les object members.</li>
	<li>recurse - Fait une récursion d\'un nombre maximum de niveaux jusqu\'à ce que le nombre maximal soit atteint. Ce qui donne une sortie détaillée pour chaque item. </li>
	<li><em>(option)</em> assign (string) - Affecte (Assigne) le résultat de la balise à la variable Smarty ainsi nommée.</li>
</ul>';
$lang['help_function_content_image'] = '<h3>Que fait cette balise ?</h3>
<p>Cette balise permet aux concepteurs de gabarits d\'inciter les utilisateurs à sélectionner un fichier image lors de l\'édition du contenu d\'une page. Elle se comporte de façon similaire à la balise {content}, pour ajouter d\'autres blocs de contenu.</p>
<h3>Comment l\'utiliser ?</h3>
<p>Insérer la balise dans votre page ou votre gabarit : <code>{content_image block=\'image1\'}</code>.</p>
<h3>Quels paramètres ?</h3>
<ul>
  <li><strong>(requis)</strong> block (string) - Le nom du bloc de contenu supplémentaire.
  <p>Exemple :</p>
  <pre>{content_image block=\'image1\'}</pre><br/>
  </li>
  <li><em>(option)</em> label (string) - Un label ou l\'invite pour ce contenu dans la page de contenu. Si non spécifié, le nom du bloc sera utilisé.</li>
  <li><em>(option)</em> dir (string) - Le nom d\'un dossier (par rapport au dossier /uploads), à partir duquel seront sélectionnés les fichiers images. Si le paramètre n\'est pas spécifié, la préférence "Chemin pour les champs images" dans la page Paramètres globaux/Paramètres des contenus sera utilisée. Sinon, le dossier /uploads sera utilisé.
  <p>Exemple : utilisation des images du dossier uploads/images</p>
  <pre>{content_image block=\'image1\' dir=\'images\'}</pre>
  </li>
  <li><em>(option)</em> default (string) - Utilisé pour définir une image par défaut lorsque aucune image n\'est sélectionnée.</li>
  <li><em>(option)</em> urlonly (bool) - affiche uniquement l\'URL de l\'image, en ignorant tous les paramètres comme Id, nom, largeur, hauteur, etc.</li>
  <li><em>(option)</em> tab (string) - L\'onglet désiré pour afficher ce champ dans le formulaire d\'édition.</li>
  <li><em>(option)</em> exclude (string) - Spécifie un préfixe de fichiers à exclure. Exemple : thumb_</li>
  <li><em>(option)</em> sort (bool) - éventuellement trier les options. Par défaut : Ne pas trier.</li>
  <li><em>(option)</em> priority (integer) - Permet de spécifier un entier "priority" pour le bloc dans l\'onglet.</li>
  <li><em>(option)</em> assign (string) - Affecte (Assigne) le résultat de la balise à la variable Smarty ainsi nommée.</li>
</ul>
<h3>Plus...</h3>
<p><strong>Note :</strong> A partir de la version 2.2, si ce bloc de contenu ne contient aucune valeur, aucune sortie n\'est générée.</p>
<p>En plus des arguments énumérés ci-dessus, ce plugin acceptera tout arguments supplémentaires et les transmettra directement à la balise img générée, le cas échéant. Exemple : <code>{content_image block=\'img1\' id="id_img1" class="page-image" title=\'an image block\' data-foo=bar}</code>';
$lang['help_function_process_pagedata'] = '<h3>Que fait cette balise ?</h3>
<p>Cette balise va traiter les données contenues dans le bloc "pagedata" des pages de contenu à travers Smarty. Elle permet de spécifier des données spécifiques pour chaque page via Smarty sans avoir à changer le gabarit de chaque page.</p>
<h3>Comment l\'utiliser ?</h3>
<ol>
  <li>Insérer les variables Smarty assignées et autres logiques Smarty dans le champ contenu de la page (pagedata) sur les pages en question.</li>
  <li>Insérer la balise <code>{process_pagedata}</code> au plus haut de votre page de gabarit.</li>
</ol>
<br/>
<h3>Quels paramètres ?</h3>
<p><em>(option)</em> assign (string) - Affecte (Assigne) le résultat de la balise à la variable Smarty ainsi nommée.</p>';
$lang['help_function_current_date'] = '<h3 style="color: red;">ATTENTION cette balise est obsolète.</h3>
<p>Nous recommandons d\'utiliser la balise <code>{$smarty.now|cms_date_format}</code></p>
<h3>Que fait cette balise ?</h3>
<p>Affiche la date et l\'heure actuelle. Si aucun format n\'est donné, l\'affichage par défaut sera \'Jan 01, 2004\'.</p>
<h3>Comment l\'utiliser ?</h3>
<p>Insérer la balise dans votre page ou votre gabarit : <code>{current_date format="%A %d-%b-%y %T %Z"}</code></p>
<h3>Quels paramètres ?</h3>
<ul>
	<li><em>(option)</em> format - Date/Time utilise le format de la fonction PHP strftime. Voir <a href="http://php.net/strftime" target="_blank">ici</a> pour une liste des paramètres et plus d\'information.</li>
	<li><em>(option)</em> ucword - Si "true" affiche en majuscule la première lettre de chaque mot.</li>	
	<li><em>(option)</em> assign (string) - Affecte (Assigne) le résultat de la balise à la variable Smarty ainsi nommée.</li>
</ul>';
$lang['help_function_tab_end'] = '<h3>Que fait cette balise ?</h3>
  <p>Ce plugin génère le code HTML pour indiquer la fin d\'une zone de contenu avec des onglets.</p>
<h3>Comment l\'utiliser ?</h3>
<p>Le code suivant crée une zone de contenu à onglets avec deux onglets.</p>
<pre><code>{tab_header name=\'tab1\' label=\'Tab One\'}
{tab_header name=\'tab2\' label=\'Tab Two\'}
{tab_start name=\'tab1\'}
<p>This is tab One</p>
{tab_start name=\'tab2\'}
<p>This is tab Two</p>
<span style="color: blue;">{tab_end}</span></code></pre>
<h3>Quels paramètres ?</h3>
<ul>
   <li>assign - <em>(option)</em> - Affecte (Assigne) le résultat de la balise à la variable Smarty ainsi nommée.</li>
</ul>
<h3>Voir Aussi :</h3>
  <ul>
    <li>{tab_header}</li>
    <li>{tab_start}</li>
  </ul>';
$lang['help_function_tab_header'] = '<h3>Que fait cette balise ?</h3>
  <p>Ce plugin génère le code HTML pour l\'entête d\'un onglet dans une zone de contenu à onglets.</p>
<h3>Comment l\'utiliser ?</h3>
<p>Le code suivant crée une zone de contenu à onglets avec deux onglets.</p>
<pre><code><span style="color: blue;">{tab_header name=\'tab1\' label=\'Tab One\'}</span>
<span style="color: blue;">{tab_header name=\'tab2\' label=\'Tab Two\'}</span>
{tab_start name=\'tab1\'}
<p>This is tab One</p>
{tab_start name=\'tab2\'}
<p>This is tab Two</p>
{tab_end}</code></pre>
<p><strong>Note:</strong> <code>{tab_start}</code> doit être appelé avec les noms dans le même ordre qu\'ils ont été fournis à <code>{tab_header}</code></p>
<h3>Quels paramètres ?</h3>
<ul>
   <li><strong>name - requis string</strong> - Le nom de l\'onglet. Doit correspondre au nom d\'un onglet passé à {tab_header}</li>
   <li>label - <em>option string</em> - Le label lisible pour l\'onglet. S\'il n\'est pas spécifié, le nom de l\'onglet sera utilisé.</li>
   <li>active - <em>option mixed</em> - Indique s\'il s\'agit de l\'onglet actif ou non. Vous pouvez donner le nom (string) de l\'onglet actif dans la séquence d\'onglets "headers" ou une valeur booléenne.</li>
   <li>assign - <em>(option)</em> - Affecte (Assigne) le résultat de la balise à la variable Smarty ainsi nommée.</li>
</ul>
<h3>Voir Aussi :</h3>
  <ul>
    <li>{tab_start}</li>
    <li>{tab_end}</li>
  </ul>';
$lang['help_function_tab_start'] = '<h3>Que fait cette balise ?</h3>
  <p>Ce plugin fournit le code HTMLl pour marquer le début du contenu d\'un onglet spécifique dans une zone de contenu à onglets.</p>
<h3>Comment l\'utiliser ?</h3>
<p>Le code suivant crée une zone de contenu à onglets avec deux onglets.</p>
<pre><code>{tab_header name=\'tab1\' label=\'Tab One\'}
{tab_header name=\'tab2\' label=\'Tab Two\'}
<span style="color: blue;">{tab_start name=\'tab1\'}</span>
<p>This is tab One</p>
<span style="color: blue;">{tab_start name=\'tab2\'}</span>
<p>This is tab Two</p>
{tab_end}</code></pre>
<p><strong>Note :</strong> <code>{tab_start}</code> doit être appelé avec les noms dans le même ordre qu\'ils ont été fournis à <code>{tab_header}</code></p>
<h3>Quels paramètres ?</h3>
<ul>
   <li><strong>name - requis</strong> - Le nom de l\'onglet. Doit correspondre au nom d\'un onglet passé à {tab_header}</li>
   <li>assign - <em>(option)</em> - Affecte (Assigne) le résultat de la balise à la variable Smarty ainsi nommée.</li>
</ul>
<h3>Voir Aussi :</h3>
  <ul>
    <li>{tab_header}</li>
    <li>{tab_end}</li>
  </ul>';
$lang['help_function_title'] = '<h3>Que fait cette balise ?</h3>
<p>Affiche le titre de la page.</p>
<h3>Comment l\'utiliser ?</h3>
<p>Insérer la balise dans votre page ou votre gabarit : <code>{title}</code></p>
<h3>Quels paramètres ?</h3>
<p><em>(option)</em> assign (string) - Affecte (Assigne) le résultat de la balise à la variable Smarty ainsi nommée.</p>';
$lang['help_function_stylesheet'] = '<h3>Que fait cette balise ?</h3>
<p><span style="color: #ff0000;">ATTENTION cette balise est obsolète</span> et sera supprimé des versions futures de CMSMS™.</p>
<p>Récupère les données des feuilles de style du système. Par défaut, elle prend toutes les feuilles de style liées au gabarit en cours.</p>
<h3>Comment l\'utiliser ?</h3>
<p>Insérer la balise dans votre page ou votre gabarit dans l\'entête : <code>{stylesheet}</code></p>	<h3>Quels paramètres ?</h3>
<ul>
	<li><em>(option)</em> name - Au lieu d\'avoir toutes les feuilles de style pour la page donnée, il n\'y aura que celle nommée spécifiquement, qu\'elle soit liée au gabarit en cours ou non.</li>
	<li><em>(option)</em> media - Si le nom est défini, ce paramètre permet de changer de type de média pour cette feuille de style.</li>
	<li><em>(option)</em> templateid - Si templateid est défini, les feuilles de style seront associées uniquement à ce gabarit, au lieu de celui en cours.</li>
	<li><em>(option)</em> assign (string) - Affecte (Assigne) le résultat de la balise à la variable Smarty ainsi nommée.</li>
</ul>';
$lang['help_function_sitename'] = '<h3>Que fait cette balise ?</h3>
<p>Affiche le nom du site. Ce paramètre est défini lors de l\'installation et peut être modifié via les Paramètres Globaux du panneau d\'administration.</p>
<h3>Comment l\'utiliser ?</h3>
<p>Insérer la balise dans votre page ou votre gabarit : <code>{sitename}</code></p>
<h3>Quels paramètres ?</h3>
<p><em>(option)</em> assign (string) - Affecte (Assigne) le résultat de la balise à la variable Smarty ainsi nommée.</p>';
$lang['help_function_search'] = '<h3>Que fait cette balise ?</h3>
<p>C\'est une balise pour le module de recherche afin de rendre la syntaxe de balise plus aisée.
Au lieu d\'avoir à utiliser <code>{cms_module module=\'Search\'}</code> vous pouvez maintenant utiliser <code>{search}</code> pour insérer le module dans un gabarit.
</p>
<h3>Comment l\'utiliser ?</h3>
<p>Insérer la balise <code>{search}</code> dans votre gabarit où la boîte de recherche devra apparaître. Pour de l\'aide à propos du module de recherche, référez-vous à l\'aide du module Recherche.</p>';
$lang['help_function_cms_textarea'] = '<h3>Que fait cette balise ?</h3>
  <p>Ce plugin Smarty est utilisé lors de la construction des formulaires d\'administration pour générer un champ textarea. Il dispose de plusieurs paramètres qui permettent de vérifier si un plugin WYSIWYG <em>(si disponible)</em> ou un éditeur de syntaxe colorée sont utilisés , de contrôler le comportement de ces modules et la taille et l\'apparence du textarea.</p>
  <h3>Comment l\'utiliser ?</h3>
    <p>La façon la plus simple d\'utiliser ce plugin est de spécifier <code>{cms_textarea name = "quelque_chose"}</code>. Cela va créer une zone de texte simple portant le nom spécifié, sans WYSIWYG ni syntaxe colorée.</p>
    <p>Ensuite, vous pouvez spécifier la valeur par défaut de la zone de texte en utilisant les paramètres "text" ou "value".</p>
  <h3>Quels paramètres ?</h3>
  <ul>
    <li>name - requis string : attribut de nom pour l\'élément textarea.</li>
    <li>prefix - option string : préfixe optionnel pour l\'attribut "name".</li>
    <li>class - option string : attribut "class" de l\'élément textarea. Des classes supplémentaires peuvent être ajoutés automatiquement.</li>
    <li>classname - alias pour le paramètre "class".</li>
    <li>forcemodule - option string : utilisé pour spécifier et activer le module WYSIWYG ou la syntaxe colorée . Si spécifié et disponible, le nom du module sera ajouté à l\'attribut de classe.</li>
    <li>enablewysiwyg - option boolean : utilisé pour spécifier si un textarea WYSIWYG est nécessaire. Définit le codage à "HTML".</li>
    <li>wantedsyntax - option string : utilisé pour indiquer le codage (HTML, CSS, PHP, Smarty ...) à utiliser. Si non vide indique qu\'un module de coloration syntaxique est demandé.</li>
    <li>type - alias pour le paramètre de syntaxe recherché.</li>
    <li>cols - option integer : les colonnes de la zone de texte (peut être ignoré par le thème CSS admin ou le module de syntaxe/WYSIWYG).</li>
    <li>width - alias pour le paramètre "cols".</li>
    <li>rows - option integer : les lignes de la zone de texte (peut être ignoré par le thème CSS admin ou le module de syntaxe/WYSIWYG).</li>
    <li>height - alias pour le paramètre "rows".</li>
    <li>maxlength - option integer : attribut maxlength du textarea (peut être ignoré par le thème CSS admin ou le module de syntaxe/WYSIWYG).</li>
    <li>requis - option boolean : indique un champ obligatoire.</li>
    <li>placeholder - option string : attribut de l\'espace réservé du textarea (peut être ignoré par le thème CSS admin ou le module de syntaxe/WYSIWYG).</li>
    <li>value - option string : texte par défaut pour la zone de texte, va subir une conversion en HTML.</li>
    <li>text - pour le paramètre "value".</li>
<li>cssname - option string : Passe le nom de cette feuille de style pour le module WYSIWYG, si un module WYSIWYG est activé.</li>
    <li>addtext - option string : Texte supplémentaire à ajouter à la balise textarea.</li>
    <li>assign - option string : Affecte (Assigne) le résultat en HTML de la balise à la variable Smarty ainsi nommée.</li>
  </ul';
$lang['help_function_root_url'] = '<h3>Que fait cette balise ?</h3>
<p>Affiche l\'URL de la racine du site.</p>
<h3>Comment l\'utiliser ?</h3>
<p>Insérer la balise dans votre page ou votre gabarit : <code>{root_url}</code></p>	<h3>Quels paramètres ?</h3>
<p><em>(option)</em> autossl=1 - Activé par défaut, cette option permet de détecter si la demande faite au serveur était sur SSL, et si l\'url retournée a été correctement configurée en SSL. Pour désactiver cette fonction préciser autossl = 0.</p>
<p><em>(option)</em> assign (string) - Affecte (Assigne) le résultat de la balise à la variable Smarty ainsi nommée.</p>';
$lang['help_function_repeat'] = '<h3>Que fait cette balise ?</h3>
<p>Répète une séquence spécifiée de caractères, un nombre défini de fois.</p>
<h3>Comment l\'utiliser ?</h3>
<p>Insérer la balise dans votre page ou votre gabarit : <code>{repeat string=\'répéter cela \' times=\'3\'}</code></p>
<h3>Quels paramètres ?</h3>
<ul>
	<li>string=\'text\' - La séquence à répéter</li>
 	<li>times=\'num\' - Le nombre de répétition de cette séquence.</li>
	<li><em>(option)</em> assign (string) - Affecte (Assigne) le résultat de la balise à la variable Smarty ainsi nommée.</li>
</ul>';
$lang['help_function_recently_updated'] = '<h3>Que fait cette balise ?</h3>
<p>Affiche une liste des pages récemment modifiées.</p>
<h3>Comment l\'utiliser ?</h3>
<p>Insérer la balise dans votre page ou votre gabarit : <code>{recently_updated}</code></p>
<h3>Quels paramètres ?</h3>
<ul>
	 <li><p><em>(option</em> number=\'10\' - Nombre des pages à afficher.</p><p>Exemple : {recently_updated number=\'15\'} affichera 15 pages...</p></li>
 	 <li><p><em>(option)</em> leadin=\'Last changed\' - Texte à afficher à gauche de la date de modification.</p><p>Exemple : {recently_updated leadin=\'Dernière Modification\'}</p></li>
 	 <li><p><em>(option)</em> showtitle=\'true\' - Affiche l\'attribut titre si défini (true|false).</p><p>Exemple : {recently_updated showtitle=\'true\'}</p></li>	
	 <li><p><em>(option)</em> css_class=\'some_name\' - Ajoute une balise div définie avec cette classe autour de la liste.</p><p>Exemple : {recently_updated css_class=\'nom_de_classe\'}</p></li>
	 <li><p><em>(option)</em> dateformat=\'d.m.y h:m\' - Par défaut d.m.y h:m , utilisez le format de votre choix (voir php -date- format)</p><p>Exemple : {recently_updated dateformat=\'D M j G:i:s T Y\'}</p></li>
	<li><em>(option)</em> assign (string) - Assigne le résultat à une variable Smarty portant ce nom.</li>
</ul>
<p>ou une combinaison :</p>
<pre>{recently_updated number=\'15\' showtitle=\'false\' leadin=\'Dernière Modification : \' css_class=\'nom_de_classe\' dateformat=\'D M j G:i:s T Y\'}</pre>';
$lang['help_function_print'] = '<h3>Que fait cette balise ?</h3>
<p>C\'est simplement une balise pour le module d\'impression afin de rendre la syntaxe de balise plus aisée.
Au lieu d\'utiliser <code>{cms_module module=\'CMSPrinting\'}</code> vous pouvez aussi utiliser <code>{print}</code> pour insérer ce module sur vos pages/gabarits
</p>
<h3>Comment l\'utiliser ?</h3>
<p>Insérer la balise dans votre page ou votre gabarit : <code>{print}</code>. Pour plus de détails sur les options et paramètres, merci de consulter l\'aide personnalisée du module d\'impression.</p>';
$lang['help_function_news'] = '<h3>Que fait cette balise ?</h3>
<p>C\'est simplement une balise pour le module de news afin de rendre la syntaxe de balise plus aisée.
Au lieu de devoir utiliser <code>{cms_module module=\'News\'}</code>, vous pouvez insérer le module dans les pages et gabarits en utilisant <code>{news}</code>.
</p>
<h3>Comment l\'utiliser ?</h3>
<p>Insérez la balise dans votre page ou votre gabarit : <code>{news}</code>. Pour de l\'aide à propos du module news/articles, ses paramètres etc..., merci de se référer à l\'aide du module News</p>';
$lang['help_function_modified_date'] = '<h3>Que fait cette balise ?</h3>
<p>Montre la date et l\'heure de la dernière modification de la page. Si aucun format n\'est défini, l\'affichage par défaut sera du type \'Jan 01, 2004\'.</p>
<h3>Comment l\'utiliser ?</h3>
<p>Insérer la balise dans votre page ou votre gabarit : <code>{modified_date format="%A %d-%b-%y %T %Z"}</code></p>
<h3>Quels paramètres ?</h3>
<ul>
	<li><em>(option)</em> format - Date/Time utilise le format de la fonction PHP strftime. Voir <a href="http://php.net/strftime" target="_blank">ici</a> pour une liste des paramètres et plus d\'information.</li>
	<li><em>(option)</em> assign - Affecte (Assigne) le résultat de la balise à la variable Smarty ainsi nommée.</li>
</ul>';
$lang['help_function_metadata'] = '<h3>Que fait cette balise ?</h3>
<p>Affiche les metadata pour cette page. Les metadata de la page de paramètres globaux et ceux spécifiques à chaque page seront affichés.</p>
<h3>Comment l\'utiliser ?</h3>
<p>Insérer la balise dans votre page ou votre gabarit : <code>{metadata}</code></p>
<h3>Quels paramètres ?</h3>
<ul>
	<li><em>(option)</em> showbase (true/false) - Si défini à false, la balise de base ne sera pas envoyée.</li>
	<li><em>(option)</em> assign (string) - Affecte (Assigne) le résultat de la balise à la variable Smarty ainsi nommée.</li>
</ul>';
$lang['help_function_menu_text'] = '<h3>Que fait cette balise ?</h3>
<p>Imprime le texte de menu de la page.</p>
<h3>Comment l\'utiliser ?</h3>
<p>Insérer la balise dans votre page ou votre gabarit : <code>{menu_text}</code></p>
<h3>Quels paramètres ?</h3>
<p><em>(option)</em> assign (string) - Affecte (Assigne) le résultat de la balise à la variable Smarty ainsi nommée.</p>';
$lang['help_function_menu'] = '<h3>Que fait cette balise ?</h3>
<p>C\'est une balise pour le module MenuManager pour simplifier la syntaxe.
Au lieu d\'utiliser la balise <code>{cms_module module=\'MenuManager\'}</code> vous pouvez utiliser <code>{menu}</code> pour insérer le module dans des pages et gabarits.
</p>
<h3>Comment l\'utiliser ?</h3>
<p>Insérer la balise dans votre page ou votre gabarit : <code>{menu}</code>. Pour de l\'aide à propos du module MenuManager, les paramètres etc..., merci de se référer à l\'aide sur le module MenuManager.</p>';
$lang['help_function_last_modified_by'] = '<h3>Que fait cette balise ?</h3>
<p>Montre la dernière personne qui a modifié la page. Si aucun format n\'est spécifié, l\'ID de l\'utilisateur sera affiché par défaut.</p>
<h3>Comment l\'utiliser ?</h3>
<p>Insérer la balise dans votre page ou votre gabarit : <code>{last_modified_by format="fullname"}</code></p>
<h3>Quels paramètres ?</h3>
<ul>
	<li><em>(option)</em> format - Id, nom d\'utilisateur, nom complet</li>
	<li><em>(option)</em> assign (string) - Affecte (Assigne) le résultat de la balise à la variable Smarty ainsi nommée.</li>
</ul>';
$lang['help_function_image'] = '<h3>Que fait cette balise ?</h3>
<p>Crée une balise image pour une image stockée dans votre dossier /uploads/images</p>
<h3>Comment l\'utiliser ?</h3>
<p class="warning">Cette balise est obsolète et sera supprimée du core à une date ultérieure.</p>
<p>Insérer la balise dans votre page ou votre gabarit : <code>{image src="mon_image.jpg"}</code></p>
<h3>Quels paramètres ?</h3>
<ul>
	<li><strong>(requis)</strong> <tt>src</tt> - fichier image dans votre dossier d\'images.</li>
	<li><em>(option)</em> <tt>width</tt> - Largeur de l\'image dans la page. La valeur par défaut est la taille réelle.</li>
	<li><em>(option)</em> <tt>height</tt> - Hauteur de l\'image dans la page. La valeur par défaut est la taille réelle.</li>
     <li><em>(option)</em> <tt>alt</tt> - texte "alt "de l\'image - nécessaire pour une meilleure compatibilité XHTML. La valeur par défaut est le nom de fichier.</li>
    <li><em>(option)</em> <tt>class</tt> - La classe CSS de l\'image.</li>
     <li><em>(option)</em> <tt>title</tt> - Infobulle au passage la souris sur le texte de l\'image. La valeur par défaut est le texte "alt "de l\'image.</li>
     <li><em>(option)</em> <tt>addtext</tt> - Texte supplémentaire à mettre dans la balise.</li>
	<li><em>(option)</em> <tt>assign (string)</tt> - Affecte (Assigne) le résultat de la balise à la variable Smarty ainsi nommée.</li>
</ul>';
$lang['help_function_html_blob'] = '<h3>Que fait cette balise ?</h3>
<p>Voir l\'aide sur global_content pour la description.</p>';
$lang['help_function_google_search'] = '<h3>Que fait cette balise ?</h3>
<p>Recherche dans votre site Web à l\'aide du moteur de recherche Google.</p>
<h3>Comment l\'utiliser ?</h3>
<p>Insérer la balise dans votre page ou votre gabarit : <code>{google_search}</code></p>
<p>Note : Google a besoin d\'avoir indexé votre site Web indexé pour que cela fonctionne. Vous pouvez soumettre votre site à Google <a href="http://www.google.com/addurl.html">ici</a>.</p>
<h3>Que faire si je veux changer l\'apparence de la zone de texte ou un bouton ?</h3>
<p>Le look de la zone de texte et le bouton peuvent être modifiés via les CSS. On modifie la textbox en utilisant l\'Id TextSearch et le bouton l\'Id buttonSearch.</p>

<h3>Quels paramètres ?</h3>
<ul>
	<li><em>(option)</em> domain - Cela indique à Google le domaine du site Web pour la recherche. Ce script essaie de le déterminer automatiquement.</li>
	<li><em>(option)</em> buttonText - Le texte que vous souhaitez afficher sur le bouton de recherche. La valeur par défaut est "Search Site".</li>
	<li><em>(option)</em> assign (string) - Affecte (Assigne) le résultat de la balise à la variable Smarty ainsi nommée.</li>
</ul>';
$lang['help_function_global_content'] = '<h3>Que fait cette balise ?</h3>
<p>Insère un bloc de contenu (global_content) dans votre gabarit ou page. Le bloc de contenu est maintenant créé dans le menu Disposition/Gestion du design</p>
<h3>Comment l\'utiliser ?</h3>
<p>Insérer la balise dans votre page ou votre gabarit : <code>{global_content name=\'myblock\'}</code>, où name est le nom du bloc de contenu que vous avez créé.</p>
<h3>Quels paramètres ?</h3>
<ul>
	<li>name - Le nom du bloc de contenu à afficher.</li>
        <li><em>(option)</em> assign - Le nom d\'une variable Smarty auquel le bloc de contenu global doit être attribué.</li>
</ul>';
$lang['help_function_get_template_vars'] = '<h3>Que fait cette balise ?</h3>
<p>Sauvegarde toutes les variables Smarty connues dans votre page</p>
<h3>Comment l\'utiliser ?</h3>
<p>Insérer la balise dans votre page ou votre gabarit : <code>{get_template_vars}</code></p>
<h3>Quels paramètres ?</h3>
<p><em>(option)</em> assign (string) - Affecte (Assigne) le résultat de la balise à la variable Smarty ainsi nommée.</p>';
$lang['help_function_page_error'] = '<h3>Que fait cette balise ?</h3>
<p>C\'est une balise d\'administration qui affiche une erreur dans une page CMS Made Simple.</p>
<h3>Comment l\'utiliser ?</h3>
<ul>
  <li>msg - <strong>requis string</strong> - le message d\'erreur à afficher.</li>
  <li>assign - <em>(option)</em> - Affecte (Assigne) le résultat de la balise à la variable Smarty ainsi nommée.</li>
</ul>
<h3>Exemple :</h3>
<pre><code>{page_error msg=\'Une erreur s\'est produite\'}</code></pre>';
$lang['help_function_page_warning'] = '<h3>Que fait cette balise ?</h3>
<p>C\'est une balise d\'administration qui affiche un message d\'alerte dans une page d’administration.</p>
<h3>Quels paramètres ?</h3>
<ul>
  <li>msg - <strong>requis string</strong> - Le message d\'alerte à afficher.</li>
  <li>assign - <em>(option)</em> - Affecte (Assigne) le résultat de la balise à la variable Smarty ainsi nommée.</li>
</ul>
<h3>Exemple :</h3>
<pre><code>{page_warning msg=\'ah ! petit problème\'}</code></pre>';
$lang['help_function_uploads_url'] = '<h3>Que fait cette balise ?</h3>
<p>Imprime l\'URL de l\'emplacement du dossier uploads du site.</p>
<h3>Comment l\'utiliser ?</h3>
<p>Insérer la balise dans votre page ou votre gabarit : <code>{uploads_url}</code></p>
<h3>Quels paramètres ?</h3>
<ul>
	<li><em>(option)</em> assign (string) - Affecte (Assigne) le résultat de la balise à la variable Smarty ainsi nommée.</li>
</ul>';
$lang['help_function_embed'] = '<h3>Que fait cette balise ?</h3>
<p>Inclut une autre application dans votre CMS. Le plus utilisé est par exemple un forum .
Cette application utilise IFRAMES ce qui fait que les anciens navigateurs peuvent avoir des problèmes. Désolé mais c\'est la seule manière de fonctionner sans modifier l\'application externe.</p>
<h3>Comment l\'utiliser ?</h3>
<ul>
    <li>a) Ajouter la balise <code>{embed header=true}</code> dans la section "Head" de votre gabarit de page, ou dans la section "Métadonnées spécifiques pour cette page" dans l\'onglet option de votre page. Cela permettra de s\'assurer que le JavaScript est inclus. Si vous insérez cette balise dans la section des "Métadonnées" dans l\'onglet option de votre page, vous devez vous assurer que la balise
<code>{metadata}</code> est bien dans votre gabarit de page.</li>
        <li>b) Ajouter la balise <code>{embed url="http://www.google.com"}</code> dans votre page ou dans le corps du gabarit de la page.</li>
</ul>
<br/>
<h4>Exemple pour une iframe plus large</h4>
<p>Ajouter le code suivant dans votre feuille de style CSS :</p>
<pre>#myframe { height: 600px; }</pre>
<br/>
<h3>Quels paramètres ?</h3>
<ul>
	<li><strong>(requis)</strong> url - l\'URL à inclure</li>
    <li><strong>(requis)</strong> header=true - Cela générera le code pour le redimensionnement de l\'IFRAME.</li>
    <li>(option) name - Un nom optionnel pour l\'iframe (au lieu de myframe).<p>Si cette option est utilisée, elle doit être identique dans les deux appels, ex : {embed header=true name=foo} and {embed name=foo url=http://www.google.com}.</p></li>
</ul>';
$lang['help_function_description'] = '<h3>Que fait cette balise ?</h3>
<p>Imprime la description (attribut title) de la page.</p>
<h3>Comment l\'utiliser ?</h3>
<p>Insérer la balise dans votre page ou votre gabarit : <code>{description}</code></p>
<h3>Quels paramètres ?</h3>
<p><em>(option)</em> assign (string) - Affecte (Assigne) le résultat de la balise à la variable Smarty ainsi nommée.</p>';
$lang['help_function_created_date'] = '<h3>Que fait cette balise ?</h3>
<p>Affiche la date et l\'heure de création de la page. Si aucun format n\'est défini l\'affichage par défaut sera comme par exemple \'Jan 01, 2004\'.</p>
<h3>Comment l\'utiliser ?</h3>
<p>Insérer la balise dans votre page ou votre gabarit : <code>{created_date format="%A %d-%b-%y %T %Z"}</code></p>
<h3>Quels paramètres ?</h3>
<ul>
	<li><em>(option)</em> format - Date/Time utilise le format de la fonction PHP strftime. Voir <a href="http://php.net/strftime" target="_blank">ici</a> pour un paramètre et les informations.</li>
	<li><em>(option)</em> assign - Affecte (Assigne) le résultat de la balise à la variable Smarty ainsi nommée.</li>
</ul>';
$lang['help_function_content'] = '<h3>Que fait cette balise ?</h3>
<p>C\'est l\'endroit où le contenu de votre page sera affiché. Il sera inséré dans le gabarit de la page pour affichage.</p>
<h3>Comment l\'utiliser ?</h3>
<p>Insérer la balise dans votre gabarit : <code>{content}</code>.</p>
<p><strong>La balise par défaut <code>{content}</code> (sans les paramètres) est nécessaire pour le bon fonctionnement. </strong> Pour donner à la balise un nom spécifique, utiliser l\'étiquette label (exemple {content label="Mon_Contenu"}). Des blocs de contenus supplémentaires peuvent être ajoutées en utilisant les paramètres ci-dessous. </p>
<h3>Quels paramètres ?</h3>
<ul>
	<li><em>(option)</em> block - Vous permet d\'avoir plus d\'un bloc de contenu par page. Lorsque plusieurs balises "content" sont mises dans un gabarit, il y aura autant de zones d\'édition affichées lorsque la page sera éditée.
<p>Exemple :</p>
<pre>{content block="second_content_block" label="Second Content Block"}</pre>
<p>Maintenant, lorsque vous éditez une page, il y aura un texte intitulé "Second Content Block".</p></li>
	<li><em>(option)</em> wysiwyg (true/false) - Si false, alors un éditeur WYSIWYG ne sera jamais utilisé lors de l\'édition de ce bloc. Si true, alors agit comme d\'habitude. Ne fonctionne que lorsque le paramètre "block" est utilisé.</li>
	<li><em>(option)</em> oneline (true/false) - Si true, alors une seule ligne d\'édition sera montrée lors de l\'édition de ce bloc. Si false, alors agit comme d\'habitude. Ne fonctionne que lorsque le paramètre "block" est utilisé.</li>
	<li><em>(option)</em> size (positive integer) - Applicable uniquement lorsque l\'option "oneline" est utilisée, ce paramètre optionnel vous permet de spécifier la taille de la zone. La valeur par défaut est de 50.</li>
	<li><em>(option) </em>maxlength (positive integer) - Applicable uniquement lorsque l\'option "oneline" est utilisée ce paramètre optionnel permet de spécifier la longueur maximale d\'entrée pour le champ d\'édition. La valeur par défaut est de 255.</li>
	<li><em>(option)</em> default (string) - Vous permet de préciser le contenu par défaut pour le contenu des blocs (content blocks additionnels seulement).</li>
	<li><em>(option)</em> label (string) - Permet de spécifier un label pour afficher dans la page d\'édition de contenu.</li>
	<li><em>(option)</em> requis (true/false) - Permet de spécifier que le bloc de contenu doit contenir du texte.</li>
	<li><em>(option)</em> placeholder (string) - Permet de spécifier un texte de substitution.</li>
<li><em>(option)</em> priority (integer) - Permet de spécifier un entier "priority" pour le bloc dans l\'onglet.</li>
	<li><em>(option)</em> tab (string) - L\'onglet désiré pour afficher ce champ dans le formulaire d\'édition.</li>
<li><em>(option)</em> cssname (string) - Nom de la feuille de styles que l\'éditeur WYSIWYG doit utiliser pour les styles étendus.</li>
<li><em>(option)</em> noedit (true/false) - Si true, alors le bloc de contenu ne sera pas disponible pour le formulaire d\'édition du contenu. Ceci est utile pour l\'affichage d\'un bloc de contenu qui a été créé via un module de tierce partie.</li>
<li><em>(option)</em> data-xxxx (string) - Permet de transmettre des attributs de données au textarea généré pour une utilisation par la syntaxe surligneur et modules WYSIWYG.
    <p>Exemple : </p>
    <pre><code>{content data-foo="bar"}</code></pre></li>
<li><em>(option)</em> adminonly (true/false) - Si true, seuls les membres du groupe "Admin" (gid == 1) seront en mesure de modifier ce bloc de contenu.</li>
	<li><em>(option)</em> assign - Attribue le contenu à un paramètre Smarty que vous pouvez ensuite utiliser dans d\'autres zones de la page ou pour tester si le contenu existe ou non.
<p>Exemple de passage d\'une page de contenu à des balises (tags) définies par l\'utilisateur comme un paramètre :</p>
		
<pre>	
{content assign=pagecontent}
{table_of_contents thepagecontent="$pagecontent"}
</pre>
</li>
</ul>';
$lang['help_function_contact_form'] = '<h2 style="color: red;">ATTENTION cette balise est obsolète.</h2>
<h3>Cette balise est obsolète et supprimée depuis la version CMS Made Simple™ 1.5. </h3>
<p>Vous pouvez utiliser le module FormBuilder et son formulaire de contact.</p>';
$lang['help_function_cms_versionname'] = '<h3>Que fait cette balise ?</h3>
<p>Cette balise est utilisée pour insérer le nom de version du CMS dans votre gabarit ou votre page. Elle n\'affiche rien d\'autre que le nom de la version.</p>
<h3>Comment l\'utiliser ?</h3>
<p>Insérer la balise dans votre page ou votre gabarit : <code>{cms_versionname}</code></p>
<h3>Quels paramètres ?</h3>
<p><em>(option)</em> assign (string) - Affecte (Assigne) le résultat de la balise à la variable Smarty ainsi nommée.</p>';
$lang['help_function_cms_version'] = '<h3>Que fait cette balise ?</h3>
<p>Cette balise est utilisée pour insérer le numéro de la version courante du CMS dans votre page ou votre gabarit. Il n\'affiche rien d\'autre que le numéro de version.</p>
<h3>Comment l\'utiliser ?</h3>
<p>C\'est une balise basique. Insérez la balise dans votre page ou votre gabarit : <code>{cms_version}</code></p>
<h3>Quels paramètres ?</h3>
<p><em>(option)</em> assign (string) - Affecte (Assigne) le résultat de la balise à la variable Smarty ainsi nommée.</p>';
$lang['help_function_cms_selflink'] = '<h3>Que fait cette balise ?</h3>
<p>Crée un lien vers une autre page de contenu de CMSMS™ à l\'intérieur de votre gabarit ou de votre contenu.</p>
<h3>Comment l\'utiliser ?</h3>
<p>Insérer la balise dans votre page ou votre gabarit : <code>{cms_selflink page="1"}</code> or <code>{cms_selflink page="alias"}</code></p>
<h3>Quels paramètres ?</h3>
		
<ul>
	<li><em>(option)</em> <tt>page</tt> - Id ou alias de la page du lien.</li>
	<li><em>(option)</em> <tt>anchorlink</tt> - Spécifie une ancre à ajouter à une URL générée.</li>
	<li><em>(option)</em> <tt>urlparam</tt> - Spécifie des paramètres avec l\'URL. <strong>Ne pas utiliser ce paramètre avec <em>"anchorlink"</em>
</strong></li>
	<li><em>(option)</em> <tt>tabindex ="a value"</tt> - Défini un tabindex pour le lien.</li> <!-- Russ - 22-06-2005 -->
	<li><em>(option)</em> <tt>dir start/next/prev/up (previous)</tt> - Lien vers la page de démarrage par défaut ou la page suivante ou précédente, ou la page parent (up). Si utilisé <tt>page</tt> ne doit pas être donné.
<strong>Note :</strong> Seule une des options peut être utilisée dans la même déclaration "cms_selflink" !</li>
	<li><em>(option)</em> <tt>text</tt> - Texte à afficher pour le lien. S\'il n\'est pas fourni, le nom de la page est utilisé à la place.</li>
	<li><em>(option)</em> <tt>menu 1/0</tt> - Si 1, le texte du menu est utilisé pour le texte du lien au lieu du Nom de la page.</li>
	<li><em>(option)</em> <tt>target</tt> - Option pour la cible d\'un lien vers. Utiliser pour une frame et du JavaScript.</li>
	<li><em>(option)</em> <tt>class</tt> - Classe CSS pour le lien < a >lien< /a >. Utile pour le style du lien.</li>
	<li><em>(option)</em> <tt>id</tt> - Option css_id pour le lien < a >lien< /a >.</li>
	<li><em>(option)</em> <tt>more</tt> - ajoute des options supplémentaires dans le lien < a >lien< /a >.</li>
	<li><em>(option)</em> <tt>label</tt> - Label pour l\'utilisation dans le lien, si applicable.</li>
	<li><em>(option)</em> <tt>label_side left/right</tt> - Position du label dans le lien (par défaut à "gauche").</li>
	<li><em>(option)</em> <tt>title</tt> - Texte à utiliser dans l\'attribut title. Si non donné, alors le titre de la page sera utilisé pour l\'attribut title.</li>
	<li><em>(option)</em> <tt>rellink 1/0</tt> - Faire un lien relationnel accessible pour la navigation. Ne fonctionne que si le paramètre "dir" est donné et ne devrait être placé que dans la section "Head" du gabarit.</li>
	<li><em>(option)</em> <tt>href</tt> - Indique que seul le résultat de l\'URL avec l\'alias de page spécifié sera retourné. Ceci est sensiblement égale à {cms_selflink page="alias" urlonly=1}. <strong>Exemple :</strong> < a href = "(cms_selflink href =" alias ")"> < img src = "xx" > < /a></li>
	<li><em>(option)</em> <tt>urlonly</tt> - Indique que seul l\'url obtenue doit être affichée. Tous les paramètres des liens générés sont ignorés.</li>
	<li><em>(option)</em> <tt>image</tt> - Une url de l\'image à utiliser dans le lien. <strong>Exemple :</strong> (cms_selflink dir = "next" image = "next.png" text = "Next").</li>
	<li><em>(option)</em> <tt>alt</tt> - Variante pour être utilisée avec l\'image (alt = "" sera utilisée si aucun paramètre n\'est donné alt).</li>
	<li><em>(option)</em> <tt>width</tt> - Largeur pour être utilisé avec l\'image (aucun attribut de largeur ne sera utilisé sur la sortie balise img s\'il n\'est pas fourni.).</li>
	<li><em>(option)</em> <tt>height</tt> - Hauteur pour être utilisé avec l\'image (aucun attribut de hauteur sera utilisé sur la sortie balise img s\'il n\'est pas fourni.).</li>
	<li><em>(option)</em> <tt>imageonly</tt> - Si vous utilisez une image, cela supprime l\'affichage de lien texte. Si vous ne voulez pas de texte du tout dans les liens, mettre lang = 0 pour supprimer le label. <strong>Exemple :</strong> (cms_selflink dir = "next" image = "next.png" text = "Next" imageonly = 1)</li>
	<li><em>(option)</em> <tt>assign</tt> - Affecte (Assigne) le résultat de la balise à la variable Smarty ainsi nommée.</li>
</ul>';
$lang['help_function_cms_module'] = '<h3>Que fait cette balise ?</h3>
<p>Cette balise sert à insérer des modules dans vos pages ou vos gabarits. Si un module est créé pour être utilisé comme une balise (Vérifier les détails dans l\'aide), vous avez la possibilité de l\'insérer à l\'aide de cette balise.</p>
<h3>Comment l\'utiliser ?</h3>
<p>C\'est une balise basique. Insérer la balise dans votre page ou votre gabarit : <code>{cms_module module="nom_du_module"}</code></p>
<h3>Quels paramètres ?</h3>
<p>Un seul paramètre est requis. Tous les autres paramètres sont transmis par le module.</p>
<ul>
	<li>module - Nom du module à insérer. Non sensible à la casse.</li>
</ul>';
$lang['help_function_cms_module_hint'] = '<h3>Que fait cette balise ?</h3>
<p>Ce plugin de fonction peut être utilisé pour fournir des instructions complémentaires (hint) pour contrôler le comportement du module si différents paramètres ne peuvent pas être indiqués sur l\'URL. Ex : Dans une situation où un site est configuré pour utiliser des "pretty" URLs pour le référencement, il est souvent impossible de fournir les paramètres supplémentaires des modules, comme un detailtemplate ou un ordre de tri sur une URL. Ce plugin peut être utilisé dans les gabarits de page, blocs de contenu ou d\'une manière spécifique à la page pour donner des informations complémentaires quant à la façon dont les modules devraient se comporter.</p>
<p><strong>Note :</strong> Tous les paramètres qui sont spécifiés dans l\'URL remplaceront les instructions du module hints. Ex : Lorsque vous utilisez Articles (News) et qu\'un paramètre "detailtemplate" est dans l\'URL, toutes les informations de "detailtemplate" transmises par cms_module_hint n\'auront aucun effet.</p>
<p><strong>Note :</strong> Afin d\'assurer un comportement correct, les instructions complémentaires de cms_module_hint doivent être créés avant que la balise {content} soit exécutée dans le gabarit de la page CMSMS™. Par conséquent, elles devraient (normalement) être créés très tôt dans le processus de gabarit de la page. Un endroit idéal serait la zone de texte "Balises Smarty spécifiques pour cette page" de l\'onglet "Logique" sur le formulaire "Éditer le contenu de la page".</p>
<h3>Quels paramètres ?</h3>
<ul>
  <li>module - <strong>requis string</strong> - Le nom du module auquel vous ajoutez l\'instruction complémentaire.</li>
</ul>
<p>Les autres paramètres de cette balise stockés sous forme d\'instructions complémentaires.</p>
<h3>Exemple :</h3>
<p>Lorsque vous utilisez le module Articles (News), avec des "pretty" URLs configurées, vous souhaitez afficher les articles d\'une catégorie spécifique sur une page et vous voulez utiliser un gabarit de détail non standard pour afficher les articles individuels sur une page différente. Ex : sur votre page "Sport" vous appelez News de cette façon : <code>{News category=sports detailpage=sports_detail}</code>. Cependant, en utilisant des "pretty" URLs, il peut être impossible de spécifier un "detailtemplate" sur les liens qui permettront de générer les vues de détail. La solution est d\'utiliser la balise {cms_module_hint} sur <u>sports_detail</u> pour fournir des indications sur la façon dont doit se comporter News sur cette page.</p>
<p>Lors de l\'édition de la page <u>sports_detail</u> sur l\'onglet Options, dans la zone de texte "Balises Smarty spécifiques pour cette page" de l\'onglet "Logique" spécifique à cette page vous pouvez entrer une balise comme : <code>{cms_module_hint module=News detailtemplate=sports}</code>. Désormais, lorsqu\'un utilisateur clique sur un lien à partir du résumé de l\'articles (News) sur votre page "sports", il sera dirigé vers la page de <u>sports_detail</u>, et le gabarit de détail ( detailtemplate) d\'Articles (News) intitulé «sport» sera utilisé pour afficher l\'article.</p>
<h3>Usage :</h3>
<p><code>{cms_module_hint module=ModuleName paramname=value ...}</code></p>
<p><strong>Note :</strong> Il est possible de spécifier plusieurs paramètres à un seul module dans un appel de ce plugin.</p>
<p><strong>Note :</strong> Il est possible d\'appeler ce module plusieurs fois pour fournir des conseils aux différents modules.</p>';
$lang['help_function_breadcrumbs'] = '<h3 style="font-weight:bold;color:#f00;">Supprimée - Utiliser maintenant {nav_breadcrumbs} ou {Navigator action=\'breadcrumbs\'}</h3>';
$lang['help_function_anchor'] = '<h3>Que fait cette balise ?</h3>
<p>Cette balise sert à insérer un lien interne à une page (ancre).</p>
<h3>Comment l\'utiliser ?</h3>
<p>Insérer la balise dans votre page ou votre gabarit : <code>{anchor anchor=\'here\' text=\'Scroll Down\'}</code></p>
<h3>Quels paramètres ?</h3>
<ul>
	<li><tt>anchor</tt> - Vers où se dirige le lien dans la page cible. La partie après le #.</li>
	<li><tt>text</tt> - Le texte à afficher dans le lien.</li>
	<li><tt>class</tt> - La classe pour le lien, si elle existe</li>
	<li><tt>title</tt> - Le titre à afficher pour le lien, s\'il existe.</li>
	<li><tt>tabindex</tt> - Le tabindex numérique pour le lien, s\'il existe.</li>
	<li><tt>accesskey</tt> - L\' accesskey pour le lien, s\'il existe.</li>
	<li><em>(option)</em> <tt>onlyhref</tt> - Affiche seulement le href et non le lien entier. Aucune autre option ne fonctionnera.</li>
	<li><em>(option)</em> <tt>assign (string)</tt> - Affecte (Assigne) le résultat de la balise à la variable Smarty ainsi nommée.</li>
</ul>';
$lang['help_function_site_mapper'] = '<h3>Que fait cette balise ?</h3>
 <p>C\'est une balise pour le module Menu Manager afin de rendre la syntaxe de balise plus aisée, et ainsi de simplifier la création d\'un plan de site.</p>
<h3>Comment l\'utiliser ?</h3>
 <p>Insérer la balise <code>{site_mapper}</code> dans votre page ou votre gabarit. Pour l\'aide sur le module "Menu Manager", quels paramètres utiliser, se référer à l\'aide sur le module Menu Manager.</p>
<p>Par défaut, si aucun gabarit n\'est spécifié, le fichier gabarit minimal_menu.tpl est utilisé.</p>
<p>Tous les paramètres utilisés dans la balise sont valables dans le gabarit "Menu Manager" comme <code>{$menuparams.paramname}</code></p>';
$lang['help_function_redirect_url'] = '<h3>Que fait cette balise ?</h3>
<p>Cette balise vous permet de faire une redirection vers une URL spécifique. (par exemple faire une redirection vers une page, si votre site n\'est pas encore ouvert)</p>
<h3>Comment l\'utiliser ?</h3>
<p>Insérer la balise dans votre page ou votre gabarit : <code>{redirect_url to=\'http://www.cmsmadesimple.org\'}</code></p>';
$lang['help_function_redirect_page'] = '<h3>Que fait cette balise ?</h3>
<p>Cette balise vous permet de faire une redirection vers une autre page (par exemple, rediriger vers la page d\'identification si l\'utilisateur n\'est pas connecté).</p>
<h3>Comment l\'utiliser ?</h3>
<p>Insérer la balise dans votre page ou votre gabarit : <code>{redirect_page page=\'alias_page\'}</code></p>';
$lang['help_function_cms_jquery'] = '<h3>Que fait cette balise ?</h3>
<p>Cette balise vous permet d\'utiliser les librairies JavaScript et les balises utilisées pour l\'administration.</p>
<h3>Comment l\'utiliser ?</h3>
<p>Insérer la balise dans votre page ou votre gabarit : <code>{cms_jquery}</code></p>

<h3>Exemple</h3>
<pre><code>{cms_jquery cdn=\'true\' exclude=\'jquery-ui\' append=\'uploads/NCleanBlue/js/ie6fix.js\' include_css=0}</code></pre>
<h4><em>Outputs</em></h4>
<pre><code>< script type="text/javascript" src= "https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js">< /script>
< script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.21/jquery-ui.min.js">< /script>
< script type="text/javascript" src="http://localhost/1.10.x/lib/jquery/js/jquery.json-2.3.js">< /script>
< script type="text/javascript" src="uploads/NCleanBlue/js/ie6fix.js">< /script>
</code></pre>

<h3><em>Inclus par défaut</em></h3>
<ul>
	<li><tt>jQuery</tt></li>
	<li><tt>jQuery-UI</tt></li>
	<li><tt>nestedSortable</tt></li>
	<li><tt>json</tt></li>
        <li><tt>migrate</tt></li>
</ul>
    
<h3>Quels paramètres ?</h3>
<ul>
	<li><em>(option) </em><tt>exclude</tt> - Utiliser une liste séparée par des virgules (CSV) pour la liste des scripts que vous souhaitez exclure. <code>\'jquery-ui,migrate\'</code></li>
	<li><em>(option) </em><tt>append</tt> - Utiliser une liste séparée par des virgules (CSV) pour la liste des chemins des scripts que vous souhaitez ajouter.<code>\'/uploads/jquery.ui.nestedSortable.js,http://code.jquery.com/jquery-1.7.1.min.js\'</code></li>
    	<li><em>(option) </em><tt>cdn</tt> - cdn=\'true\' permet d\'insérer jQuery et jQueryUI en utilisant le réseau Google "Content Delivery Network". Par défaut à "false"</li>
    	<li><em>(option) </em><tt>ssl</tt> - Utilisé pour ssl_url comme chemin de base souhaité.</li>
     	<li><em>(option) </em><tt>custom_root</tt> - Utilisé pour définir un chemin de base souhaité. <code>custom_root=\'http://test.domain.com/\'</code> <br/>NOTE : Écrase l\'option SSL et fonctionne avec l\'option cdn</li>
<li><em>(option) </em><tt>include_css <em>(boolean)</em></tt> - Utilisé pour empêcher le CSS d\'être inclus à la sortie. Par défaut "true".</li>	
	<li><em>(option)</em> <tt>assign (string)</tt> - Affecte (Assigne) le résultat de la balise à la variable Smarty ainsi nommée.</li>
</ul>';
$lang['help_function_cms_filepicker'] = '<h3>Que fait cette balise ?</h3>
<p>Cette balise crée un champ de saisie contrôlé par le module <em>(courant)</em> "File Picker" pour permettre la sélection d\'un fichier. C\'est un plugin Admin uniquement utile pour les gabarits des modules et aussi pour d\'autres formulaires d\'administration.</p>
<p>Cette balise doit être utilisée dans un gabarit de module en administration. La sortie créée doit sélectionner un fichier traité de la manière habituelle dans le module.</p>
<p>Note : Ce plugin détectera (par des mécanismes internes) le module "File Picker" qui peut être différent du module "Gestionnaire des fichiers" de CMSMS. Le module File Picker peut donc ignorer certains des paramètres du module "Gestionnaire des fichiers".</p>
<h3>Comment l\'utiliser ?</h3>
<ul>
  <li>name - <strong>requis</strong> string - Le nom du champ de saisie.</li>
  <li>prefix - <em>(option)</em> string - Un préfixe pour le nom du champ de saisie.</li>
  <li>value - <em>(option)</em> string - la valeur actuelle du champ de saisie.</li>
  <li>profile - <em>(option)</em> string - Le nom du profil à utiliser. Le profil doit exister dans le module "File Picker" sélectionné ou un profil par défaut peut être utilisé.</li>
  <li>top - <em>(option)</em> string - Un dossier racine, relatif au dossier uploads. Cela devrait remplacer toute valeur de dossier racine déjà spécifiée dans le profil.</li>
  <li>type - <em>(option)</em> string - Indique le type de fichier pouvant être sélectionné..
      <p> Les valeurs possibles sont : image,audio,video,media,xml,document,archive,any</p>
  </li>
  <li>required - <em>(option)</em> boolean - Indique si le champ de saisie est obligatoire ou non.</li>
</ul>
<h3>Exemple :</h3>
<p>Créez un champ filepicker pour permettre la sélection des images dans le dossier images/pommes.</p>
<pre><code>{cms_filepicker prefix=$actionid name=article_image top=\'images/pommes\' type=\'image\'}</code></pre>';
$lang['help_function_thumbnail_url'] = '<h3>Que fait cette balise ?</h3>
<p>Cette balise génère une URL pour une vignette image quand un fichier image réel est spécifié. Cette image est contenue dans le dossier uploads ou un sous-dossier.</p>
<p>Cette balise renvoie une chaîne vide si le fichier spécifié n\'existe pas ou si la vignette n\'existe pas ou s\'il y a des problèmes de permissions.</p>
<h3Comment l\'utiliser ?</h3>
<ul>
  <li>file - <strong>requis</strong> - Le nom de fichier et le chemin d\'accès relatifs au répertoire uploads.</li>
  <li>dir - <em>(option)</em> - Un préfixe facultatif du dossier à ajouter au nom de fichier.</li>
  <li>assign - <em>(option)</em> - Affecte (Assigne) le résultat de la balise à la variable Smarty ainsi nommée.</li>
</ul>
<h3>Exemple :</h3>
<pre><code><img src="{thumbnail_url file=\'images/something.jpg\'}" alt="something.jpg"/></code></pre>
<h3>Conseil :</h3>
<p>C\'est un processus simple pour créer un gabarit générique ou une fonction Smarty qui utilisera le code <code>{file_url}</code> et <code>{thumbnail_url}</code> afin de créer une vignette et un lien vers une image plus grande.</p>';
$lang['help_function_file_url'] = '<h3>Que fait cette balise ?</h3>
<p>Cette balise génère une URL vers un fichier ayant pour chemin le dossier uploads de CMSMS.</p>
<p>Cette balise renvoie une chaîne vide si le fichier spécifié n\'existe pas ou s\'il y a des problèmes de permissions.</p>
<h3>Comment l\'utiliser ?</h3>
<ul>
  <li>file - <strong>requis</strong> - Le nom de fichier et le chemin d\'accès relatifs au dossier uploads.</li>
  <li>dir - <em>(option)</em> - Un préfixe facultatif du dossier à ajouter au nom de fichier.</li>
  <li>assign - <em>(option)</em> - Affecte (Assigne) le résultat de la balise à la variable Smarty ainsi nommée.</li>
</ul>
<h3>Exemple :</h3>
<pre><code><a href="{file_url file=\'images/something.jpg\'}">view file</a></code></pre>
<h3>Conseil :</h3>
<p>C\'est un processus simple pour créer un gabarit générique ou une fonction Smarty qui utilisera le code <code>{file_url}</code> et <code>{thumbnail_url}</code> afin de créer une vignette et un lien vers une image plus grande.</p>';
$lang['help_function_form_end'] = '<h3>Que fait cette balise ?</h3>
<p>Cette balise crée une balise de fin de formulaire .</p>
<h3>Quels paramètres ?</h3>
<ul>
  <li>assign - <em>(option)</em> - Affecte (Assigne) le résultat de la balise à la variable Smarty ainsi nommée.</li>
</ul>
<h3>Usage:</h3>
<pre><code>{form_end}</code></pre>
<h3>Voir aussi :</h3>
<p>Voir la balise {form_start} qui est le complément de cette balise.</p>';
$lang['help_function_form_start'] = '<h3>Que fait cette balise ?</h3>
  <p>Elle crée une balise "form" pour une action de module. Cela est utile dans les gabarits de modules et s\'inscrit dans le cadre de la séparation de la conception de la logique, principe qui est au cœur de CMSMS.</p>
  <p>Cette balise accepte de nombreux paramètres qui peuvent utiliser la balise "form" et affecte son style.</p>
<h3>Quels paramètres ?</h3>
<ul>
  <li>module - <em>(option string)</em>
    <p>Le module qui est la destination des données de formulaire. Si ce paramètre n\'est pas spécifié, une tentative est faite pour déterminer le module courant.<p>
  </li>
  <li>action - <em>(option string)</em>
    <p>L\'action du module qui est la destination des données du formulaire. S\'il n\'est pas spécifié, "default" est supposé pour une demande coté site Web( frontend), et "defaultadmin" pour une demande côté administration.</p>
  </li>
  <li>mid = <em>(option string)</em>
    <p>L\'actionId du module qui est la destination des données de formulaire. S\'il n\'est pas spécifié, une valeur est automatiquement calculée.</p>
  </li>
  <li>returnid = <em>(option integer)</em>
    <p>L\'Id de la page de contenu auquel le formulaire doit être soumis. S\'il n\'est pas spécifié, la page actuelle Id est utilisée pour les demandes du site Web (frontend). Pour les demandes d\'administration cet attribut n\'est pas nécessaire.</p>
  </li>
  <li>inline = <em>(option integer)</em>
    <p>Une valeur booléenne qui indique que le formulaire doit être soumis en ligne (le traitement du formulaire remplace la balise originale) ou non (le traitement du formulaire remplace la balise contenu {content}). Ce paramètre s\'applique uniquement aux demandes du site Web (frontend), et sa valeur est par défaut à false pour les demandes du site Web (frontend).</p>
  </li>
  <li>method = <em>(option string)</em>
    <p>Les valeurs possibles pour ce champ sont GET et POST. La valeur par défaut est POST.</p>
  </li>
  <li>url = <em>(option string)</em>
    <p>Permet de spécifier l\'attribut action de la balise du formulaire. Ceci est utile pour construire des formulaires qui ne sont pas destinés à une action de module. Une adresse URL complète est nécessaire.</p>
  </li>
  <li>enctype = <em>(option string)</em>
    <p>Permet de spécifier le type de codage pour la balise formulaire. La valeur par défaut de ce champ est multipart/form-data..</p>
  </li>
  <li>id = <em>(option string)</em>
    <p>Permet de spécifier l\'attribut Id de la balise formulaire.</p>
  </li>
  <li>class = <em>(option string)</em>
    <p>Permet de spécifier l\'attribut de classe de la balise formulaire.</p>
  </li>
  <li>extraparms = <em>(option associative array)</em>
    <p>Permet de spécifier un tableau associatif (clé/valeur) avec des paramètres supplémentaires pour la balise formulaire.</p>
  </li>
  <li>assign = <em>(option string)</em>
    <p>Affecte (Assigne) le résultat de la balise à la variable Smarty ainsi nommée.</p>
  </li>
</ul>
<p>Vous pouvez également fournir des attributs supplémentaires à la balise "form" en précisant l\'attribut avec le préfixe "form-". Exemple :</p>
<pre><code>{form_start form-data-foo="bar" form-novalidate=""}</code></pre>
<p><strong>Remarque :</strong> Les balises Smarty ne sont pas autorisées. Chaque attribut fourni doit avoir une valeur, même s\'il est vide.</p>
<h3>Utilisation :</h3>
<p>Dans un gabarit de module le code suivant génère une balise de formulaire pour l\'action en cours.</p>
<pre><code>{form_start}</code></pre>
<p>Ce code, dans un gabarit de module va générer une balise de formulaire pour l\'action nommée.</p>
<pre><code>{form_start action=myaction}</code></pre>
<p>Ce code va générer une balise de formulaire pour l\'action nommée dans le module nommé.</p>
<pre><code>{form_start module=News action=default}</code></pre>
<p>Ce code va générer une balise de formulaire pour la même action, mais avec une Id et une classe.</p>
<pre><code>{form_start id="myform" class="form-inline"}</code></pre>
<p>Ce code va générer une balise de formulaire à l\'URL nommée, et avec une Id et une classe.</p>
<pre><code>{form_start url="/products" class="form-inline"}</code></pre>
<h3>Voir aussi :</h3>
<p>La balise {form_end} qui est un complément de la balise {form_start}.</p>
<h3>Exemple 1:</h3>
<p>Ce qui suit est un exemple de formulaire pour une utilisation dans un module. Ce formulaire soumettra une action qui permettra à l\'utilisateur de spécifier un nombre entier "pagelimit".</p>
<pre><code>{form_start}
<select name="{$actionid}pagelimit">
<option value="10">10</option>
<option value="25">25</option>
<option value="50">50</option>
<select>
<input type="submit" name="{$actionid}submit" value="Submit">
{form_end}</code></pre>
<h3>Exemple 2:</h3>
<p>Ce qui suit est un exemple de formulaire pour une utilisation dans l\'interface d\'un site web. Ajouté dans le contenu de la page, ce formulaire recueille une "pagelimit", pour le soumettre au module Articles (News).</p>
<pre><code>{form_start method="GET" class="form-inline"}
<select name="pagelimit">
<option value="10">10</option>
<option value="25">25</option>
<option value="50">50</option>
<select>
<input type="submit" name="submit" value="Submit"/>
{form_end}
{$pagelimit=25}
{if isset($smarty.get.pagelimit)}{$pagelimit=$smarty.get.pagelimit}{/if}
{News pagelimit=$pagelimit}</code></pre>';
$lang['function'] = 'Les balises "function" peuvent effectuer une tâche, ou interroger la base de données et afficher les résultats. Elles peuvent être appelés comme ; {tagname [attribute=value...]}';
$lang['modifier'] = 'Les balises "modifier" peuvent modifier la sortie d\'une variable Smarty. Elles sont appelées comme :{$variable|modifier[:arg:...]}';
$lang['postfilter'] = 'Les balises "postfilters" sont appelées automatiquement par Smarty après la compilation de chaque gabarit. Elles ne peuvent pas être appelées manuellement.';
$lang['prefilter'] = 'Les balises "prefilters" sont appelées automatiquement par Smarty avant la compilation de chaque gabarit. Elles ne peuvent pas être appelées manuellement.';
$lang['tag_about'] = 'Affiche des informations sur l\'historique et l\'auteur de ce plugin (si disponible).';
$lang['tag_adminplugin'] = 'Indique que la balise est disponible uniquement dans l\'interface d\'administration, et est généralement utilisée dans les gabarits de modules.';
$lang['tag_cachable'] = 'Indique si la sortie du plugin peut être mis en cache (lorsque le cache Smarty est activé). Les plugins administration et les balises "modifier " ne peuvent pas être mis en cache.';
$lang['tag_help'] = 'Affiche l\'aide (si existante) pour cette balise';
$lang['tag_name'] = 'Nom de la balise';
$lang['tag_type'] = 'Type de balise (function, modifier, ou prefilter, postfilter)';
$lang['title_admin'] = 'Ce plugin est disponible uniquement à partir de la console d\'administration de CMS Made Simple.';
$lang['title_notadmin'] = 'Ce plugin est utilisable à la fois dans la console d\'administration et sur le site Web (frontend).';
$lang['title_cachable'] = 'Ce plugin est mis en cache';
$lang['title_notcachable'] = 'Ce plugin n\'est pas mis en cache';
$lang['viewabout'] = 'Affiche des informations sur l\'historique et l\'auteur de cette balise';
$lang['viewhelp'] = 'Affiche l\'aide pour cette balise';
?>