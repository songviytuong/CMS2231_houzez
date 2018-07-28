<?php
$lang['addarticle']='Afegir article';
$lang['addcategory']='Afegeix categoria';
$lang['addfielddef']='Afegeix una definici&oacute; de camp';
$lang['addnewsitem']='Afegeix un element de not&iacute;cies';
$lang['allcategories']='Totes les categories';
$lang['allentries']='Totes les entrades';
$lang['allow_summary_wysiwyg']='Permetre utilitzar un editor WYSIWYG en el camp de resum';
$lang['allowed_upload_types']='Permet pujar arxius amb nom&eacute;s aquestes extensions';
$lang['anonymous']='An&ograve;nim';
$lang['approve']='Fixa l&#039;estat a &#039;Publicat&#039;';
$lang['areyousure']='N&#039;est&agrave;s segur que vols esborrar?';
$lang['areyousure_deletemultiple']='N&#039;est&agrave;s segur que vols esborrar tots aquests articles de not&iacute;cies? \nAquesta acci&oacute; no es pot tirar enrere';
$lang['articleadded']='L&#039;article s&#039;ha afegit correctament';
$lang['articledeleted']='L&#039;article s&#039;ha esborrat correctament';
$lang['articleupdated']='L&#039;article s&#039;ha modificat correctament';
$lang['author']='Autor';
$lang['author_label']='Penjat per:';
$lang['auto_create_thumbnails']='Crear autom&agrave;ticament arxius de contactes pels arxius amb aquestes extensions';
$lang['browsecattemplate']='Plantilles de Navegar categoria';
$lang['cancel']='Cancel.la';
$lang['category']='Categoria';
$lang['category_label']='Categoria:';
$lang['categoryadded']='La categoria s&#039;ha afegfit correctament';
$lang['categorydeleted']='La categoria s&#039;ha esborrat correctament';
$lang['categoryupdated']='La categoria s&#039;ha modificat correctament';
$lang['checkbox']='Casella';
$lang['content']='Contingut';
$lang['customfields']='Definicions de camp';
$lang['dateformat']='%s no est&agrave; en un format v&agrave;lid com yyyy-mm-dd hh:mm:ss';
$lang['default_category']='Categoria per defecte';
$lang['default_templates']='Planxetes per defecte';
$lang['delete']='Esborrar';
$lang['delete_selected']='Esborra els articles seleccionats';
$lang['deprecated']='No suportat';
$lang['description']='Afegeix, modifica i esborra articles de Not&iacute;cies';
$lang['detailtemplate']='Planxetes de Detalls';
$lang['detailtemplateupdated']='La Plantilla de detall actualitzada s&#039;ha desat correctament a la base de dades';
$lang['displaytemplate']='Mostra plantilla';
$lang['down']='Avall';
$lang['draft']='Borrador';
$lang['edit']='Modifica';
$lang['editfielddef']='Edita la definici&oacute; del Camp';
$lang['email_subject']='El tema del correu de sortida';
$lang['email_template']='El format del missatge de correu electr&ograve;nic';
$lang['enddate']='Data final';
$lang['endrequiresstart']='Posant una data de finalitzaci&oacute; cal posar tamb&eacute; una datra d&#039;inici';
$lang['entries']='%s Entrades';
$lang['error_filesize']='Un arxiu pujat excedeix la mida m&agrave;xima permesa';
$lang['error_invaliddates']='Una o m&eacute;s de les dates entrades era inv&agrave;lida';
$lang['error_invalidfiletype']='No es pot pujar aquest tipus d&#039;arxiu';
$lang['error_mkdir']='No s&#039;ha pogut crear el directori: %s';
$lang['error_movefile']='No s&#039;ha pogut crear l&#039;arxiu: %s';
$lang['error_noarticlesselected']='No s&#039;han triat articles';
$lang['error_templatenamexists']='Ja existeix una plantilla amb aquest nom';
$lang['error_upload']='Hi ha hagut un problema pujant l&#039;arxiu';
$lang['eventdesc-NewsArticleAdded']='Enviat quan s&#039;afegeix un article';
$lang['eventdesc-NewsArticleDeleted']='Enviat quan s&#039;esborra un article';
$lang['eventdesc-NewsArticleEdited']='Enviat quan es modifica un article';
$lang['eventdesc-NewsCategoryAdded']='Enviat quan s&#039;afegeix una categoria';
$lang['eventdesc-NewsCategoryDeleted']='Enviat quan s&#039;esborra una categoria';
$lang['eventdesc-NewsCategoryEdited']='Enviat quan es modifica una categoria';
$lang['eventhelp-NewsArticleAdded']='<p>Sent when an article is added.</p>
<h4>Parameters</h4>
<ul>
<li>\&quot;news_id\&quot; - Id of the news article</li>
<li>\&quot;category_id\&quot; - Id of the category for this article</li>
<li>\&quot;title\&quot; - Title of the article</li>
<li>\&quot;content\&quot; - Content of the article</li>
<li>\&quot;summary\&quot; - Summary of the article</li>
<li>\&quot;status\&quot; - Status of the article (&quot;draft&quot; or &quot;publish&quot;)</li>
<li>\&quot;start_time\&quot; - Date the article should start being displayed</li>
<li>\&quot;end_time\&quot; - Date the article should stop being displayed</li>
<li>\&quot;useexp\&quot; - Whether the expiration date should be ignored or not</li>
</ul>
';
$lang['eventhelp-NewsArticleDeleted']='<p>Sent when an article is deleted.</p>
<h4>Parameters</h4>
<ul>
<li>\&quot;news_id\&quot; - Id of the news article</li>
</ul>
';
$lang['eventhelp-NewsArticleEdited']='<p>Sent when an article is edited.</p>
<h4>Parameters</h4>
<ul>
<li>\&quot;news_id\&quot; - Id of the news article</li>
<li>\&quot;category_id\&quot; - Id of the category for this article</li>
<li>\&quot;title\&quot; - Title of the article</li>
<li>\&quot;content\&quot; - Content of the article</li>
<li>\&quot;summary\&quot; - Summary of the article</li>
<li>\&quot;status\&quot; - Status of the article (&quot;draft&quot; or &quot;publish&quot;)</li>
<li>\&quot;start_time\&quot; - Date the article should start being displayed</li>
<li>\&quot;end_time\&quot; - Date the article should stop being displayed</li>
<li>\&quot;useexp\&quot; - Whether the expiration date should be ignored or not</li>
</ul>
';
$lang['eventhelp-NewsCategoryAdded']='<p>Sent when a category is added.</p>
<h4>Parameters</h4>
<ul>
<li>\&quot;category_id\&quot; - Id of the news category</li>
<li>\&quot;name\&quot; - Name of the news category</li>
</ul>
';
$lang['eventhelp-NewsCategoryDeleted']='<p>Sent when a category is deleted.</p>
<h4>Parameters</h4>
<ul>
<li>\&quot;category_id\&quot; - Id of the deleted category </li>
<li>\&quot;name\&quot; - Name of the deleted category</li>
</ul>
';
$lang['eventhelp-NewsCategoryEdited']='<p>Sent when a category is edited.</p>
<h4>Parameters</h4>
<ul>
<li>\&quot;category_id\&quot; - Id of the news category</li>
<li>\&quot;name\&quot; - Name of the news category</li>
<li>\&quot;origname\&quot; - The original name of the news category</li>
</ul>
';
$lang['expired']='Caducat';
$lang['expired_searchable']='Articles caducats poden apar&egrave;ixer en resultats de cerca';
$lang['expiry']='Caducitat';
$lang['expiry_date_asc']='Data de caducitat Ascendent';
$lang['expiry_date_desc']='Data de caducitat Descendent';
$lang['expiry_interval']='Nombre de dies (per defecte) abans que caduqui un article (si la caducitat est&agrave; activada)';
$lang['fesubmit_redirect']='Identificador o &agrave;lies de p&agrave;gina per redirigir-s&#039;hi despr&eacute;s d&#039;enviar un article de Not&iacute;cies a trav&eacute;s de l&#039;acci&oacute; de &#039;fesubmit&#039; ';
$lang['fesubmit_status']='Estat dels articles de not&iacute;cies enviats vi en frontend';
$lang['fielddef']='Definici&oacute; de camp';
$lang['fielddefadded']='Definici&oacute; de camp afegit amb &egrave;xit';
$lang['fielddefdeleted']='Definici&oacute; de camp eliminada';
$lang['fielddefupdated']='Definici&oacute; del camp actualitzada';
$lang['file']='Arxiu';
$lang['filter']='Filtre';
$lang['firstpage']='<<';
$lang['formsubmit_emailaddress']='Adre&ccedil;a de correu electr&ograve;nic per rebre notificacions de not&iacute;cies enviades';
$lang['formtemplate']='Planxetes de Formularis';
$lang['help']='<h3>Important Notes</h3>
<p>This version of News is greater than the one supplied with the 1.1 branch of CMS Made Simple.  If you use this version of News you must use extreme caution when upgrading CMS Made Simple to ensure that nothing in the modules/News directory is overwritten.</p>
	<h3>What does this do?</h3>
	<p>News is a module for displaying news events on your page, similar to a blog style, except with more features!.  When the module is installed, a News admin page is added to administration menu that will allow you to select or add a news category.  Once a news category is created or selected, a list of news items for that category will be displayed.  From here, you can add, edit or delete news items for that category.</p>
	<h3>Template variables</h3>
	<ul>
		<li><b>itemcount</b> - The number of news articles to be shown.</li>
		<li><b>entry->authorname</b> - The full name of the the author including First and Last name.</li>
	</ul>
	<h3>Security</h3>
	<p>The user must belong to a group with the &#039;Modify News&#039; permission in order to add or edit News entries.</p>
        <p>As well, In order to delete news entries, the user must belong to a group with the &#039;Delete News Articles&#039; permission.</p>
	<p>In order to edit the layout templates, the user must belong to a group with the &#039;Modify Templates&#039; permission.</p>
	<p>In order to edit the global news preferences, the user must belong to a group with the &#039;Modify Site Preferences&#039; permission.</p>
	<p>Additionally, to approve news for frontend display the user must belong to a group with the &#039;Approve News&#039; permission.</p>
	<h3>How do I use it?</h3>
	<p>The easiest way to use it is with the {news} wrapper tag (wraps the module in a tag, to simplify the syntax).  This will insert the module into your template or page anywhere you wish, and display news items.  The code would look something like: <code>{news number=&#039;5&#039;}</code></p>
<h3>Templates</h3>
	<p>Since version 2.3 News supports multiple database templates, and no longer supports additional file templates.  Users who used the old file template system should follow these steps (for each file template):
<ul>
<li>Copy the file template into the clipboard</li>
<li>Create a new database template <em>(either summary or detailed as required)</em>.  Give the new template the same name (including the .tpl extension) as the old file template, and paste the contents.</li>
<li>Hit Submit</li>
</ul>
Following these steps should solve the problem of your news templates not being found and other similar smarty errors when you upgrade to a version of CMS that has News 2.3 or greater.</p>';
$lang['help_pagelimit']='Maximum number of items to display (per page).  If this parameter is not supplied all matching items will be displayed.  If it is, and there are more items available than specified in the pararamter, text and links will be supplied to allow scrolling through the results';
$lang['helpaction']='Override the default action.  Possible values are &#039;default&#039; to display the summary view, and &#039;fesubmit&#039; to display the frontend form for allowing users to submit news articles on the front end.';
$lang['helpbrowsecat']='Mostra una llista navegable de categories';
$lang['helpdetailpage']='P&agrave;gina per mostrar-hi detalls de not&iacute;cies. Aix&ograve; pot ser un &agrave;lies de p&agrave;gina o un ID. Utilitzat per permetre mostrar detalls en una plantilla diferent del resum';
$lang['helpmoretext']='Text per mostrar al final d&#039;un element de not&iacute;cies si est&agrave; per damunt la llargada del resum. El valor per fedecte &eacute;s &quot;m&eacute;s...&quot;';
$lang['helpnumber']='Nombre m&agrave;xim d&#039;elements a mostrar =- en blanc per mostrar tots els elements';
$lang['helpshowall']='Mostra tots els articles, independentment de la data de finalitzaci&oacute;';
$lang['helpshowarchive']='Mostra nom&eacute;s articles caducats';
$lang['helpsortasc']='Ordena els elements de not&iacute;cies per data i ordre ascendent enlloc de descendent';
$lang['helpsortby']='Camp ordenat per .  Les opcions s&oacute;n: &quot;news_date&quot;, &quot;summary&quot;, &quot;news_data&quot;, &quot;news_category&quot;, &quot;news_title&quot;, &quot;news_extra&quot;, &quot;end_time&quot;, &quot;start_time&quot;, &quot;random&quot;.  El camp per defecte &eacute;s &quot;news_date&quot;. Si s&#039;especifica &quot;random&quot;, el par&agrave;metre sortasc &eacute;s ignorat.';
$lang['helpstart']='Comen&ccedil;a a l&#039;en&egrave;ssim element -- en blanc per comen&ccedil;ar amb el primer element';
$lang['hide_summary_field']='Oculta el camp de resum quan s&#039;afegeixen o editen articles';
$lang['info_maxlength']='La llargada m&agrave;xima nom&eacute;s aplica als camps de text';
$lang['info_sysdefault']='<em>(contingut utilitzat per defecte quan es crea unanova planxeta)</em>';
$lang['info_sysdefault2']='<strong>Note:</strong> This tab contains text areas to allow you to edit a set of templates that are displayed when you create a &#039;new&#039; summary, detail, or form template.  Changing content in this tab, and clicking &#039;submit&#039; will <strong>not effect any current displays</strong>.';
$lang['lastpage']='>>';
$lang['maxlength']='Llargada m&agrave;xima';
$lang['more']='M&eacute;s';
$lang['moretext']='M&eacute;s text';
$lang['msg_contenttype_removed']='S&#039;ha esborrat el tipus de contingut de Not&iacute;cies.  Posa el tag {news} amb els par&agrave;metres adequats dins la teva plantilla o la teva p&agrave;gina per substituir aquesta funcionalitat.';
$lang['name']='Nom';
$lang['nameexists']='Un camp amb aquest mateix nom ja existeix';
$lang['needpermission']='You need the &#039;%s&#039; permission to perform that function.';
$lang['newcategory']='Nova Categoria';
$lang['news']='Not&iacute;cies';
$lang['news_return']='Tornar';
$lang['nextpage']='>';
$lang['nocategorygiven']='No s&#039;ha donat cap categoria';
$lang['nocontentgiven']='No s&#039;ha donat cap contingut';
$lang['noitemsfound']='<strong>No</strong> s&#039;han trobat elements per la categoria: %s';
$lang['nonamegiven']='No s&#039;ha donat un nom';
$lang['none']='Cap';
$lang['nopostdategiven']='No s&#039;ha donat una data per l&#039;element';
$lang['notanumber']='La Llargada m&agrave;xima no &eacute;s un n&uacute;mero';
$lang['note']='<em>Nota:</em> Dates han de ser en format &#039;yyyy-mm-dd hh:mm:ss&#039;.';
$lang['notify_n_draft_items']='Tens <a href="moduleinterface.php?module=News">%d articles de Not&iacute;cies </a> no publicats';
$lang['notify_n_draft_items_sub']='%d article(s) de not&iacute;cies';
$lang['notitlegiven']='No s&#039;ha donat un t&iacute;tol';
$lang['numbertodisplay']='Nombre a mostrar (en blanc per mostrar tots els registres)';
$lang['options']='Opcions';
$lang['optionsupdated']='Les opcions s&#039;han modificat correctament';
$lang['post_date_asc']='Data d&#039;entrada Ascendent';
$lang['post_date_desc']='Data d&#039;entrada Descendent';
$lang['postdate']='Data d&#039;enviament';
$lang['postinstall']='Make sure to set the &quot;Modify News&quot; permission on users who will be administering News items.';
$lang['prevpage']='<';
$lang['print']='Imprimeix';
$lang['prompt_default']='Per defecte';
$lang['prompt_name']='Nom';
$lang['prompt_newtemplate']='Crear una nova planxeta';
$lang['prompt_of']='de';
$lang['prompt_page']='P&agrave;gina';
$lang['prompt_pagelimit']='L&iacute;mit de p&agrave;gines';
$lang['prompt_sorting']='Ordenar per';
$lang['prompt_template']='Codi font de planxeta';
$lang['prompt_templatename']='Nom de planxeta';
$lang['public']='P&uacute;blic';
$lang['published']='Publicat';
$lang['reassign_category']='Canvia la categoria a';
$lang['removed']='Eliminat';
$lang['resettodefault']='Retorna als valors per defecte de f&agrave;brica';
$lang['restoretodefaultsmsg']='Aquesta operaci&oacute; restaurar&agrave; el contingut de la planxeta al seu valor per defecte. N&#039;est&agrave;s segur que vols continuar?';
$lang['revert']='Fixa l&#039;estat a &#039;Borrador&#039;';
$lang['select']='Tria';
$lang['selectcategory']='Tria una categoria';
$lang['showchildcategories']='Mostra les categories filles';
$lang['sortascending']='Ordre ascendent';
$lang['startdate']='Data d&#039;inici';
$lang['startdatetoolate']='La data d&#039;inici &eacute;s massa tardana (posterior a la data de final?)';
$lang['startoffset']='Comen&ccedil;a mostrant l&#039;element en&egrave;ssim';
$lang['startrequiresend']='Quan es defineix una data d&#039;inici cal tamb&eacute; definir data de finalitzaci&oacute;';
$lang['status']='Estat';
$lang['subject_newnews']='Un article de not&iacute;cies ha estat penjat';
$lang['submit']='Enviar';
$lang['summary']='Resum';
$lang['summarytemplate']='Planxetes de resum';
$lang['summarytemplateupdated']='La planxeta de resum de not&iacute;cia s&#039;ha modificat correctament';
$lang['sysdefaults']='Restaurar a valors per defecte';
$lang['template']='Plkanxeta';
$lang['textarea']='&Agrave;rea de text';
$lang['textbox']='Entrada de text';
$lang['title']='T&iacute;tol';
$lang['title_asc']='T&iacute;tol Ascendent';
$lang['title_available_templates']='Planxetes disponibles';
$lang['title_browsecat_sysdefault']='Plantilla per defecte de Navegar categoria';
$lang['title_browsecat_template']='';
$lang['title_desc']='T&iacute;tol Descendent';
$lang['title_detail_sysdefault']='Planxeta per defecte de detall';
$lang['title_detail_template']='Editor de planxeta de detall';
$lang['title_filter']='Filtres';
$lang['title_form_sysdefault']='Planxeta per defecte de formulari';
$lang['title_form_template']='Editor de planxeta de formulari';
$lang['title_summary_sysdefault']='Planxeta per defecte de resum';
$lang['title_summary_template']='Editor de planxeta de resum';
$lang['type']='Tipus';
$lang['unknown']='Desconegut';
$lang['unlimited']='Il.limitat';
$lang['up']='Amunt';
$lang['uploadscategory']='Puja categoria';
$lang['useexpiration']='Utilitza data de caducitat';
?>