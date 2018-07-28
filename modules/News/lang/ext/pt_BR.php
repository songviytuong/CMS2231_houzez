<?php
$lang['addarticle']='Adicionar Artigo';
$lang['addcategory']='Adicionar Categoria';
$lang['addnewsitem']='Adicionar Not&iacute;cia';
$lang['allcategories']='Todas Categorias';
$lang['allentries']='Todas Entradas';
$lang['anonymous']='An&ocirc;nimo';
$lang['approve']='Mude o Status para &#039;Publicado&#039;';
$lang['areyousure']='Voc&ecirc; tem certeza que quer deletar?';
$lang['areyousure_deletemultiple']='Voc&ecirc; tem certeza que quer deletas todas estas not&iacute;cias?\nEsta a&ccedil;&atilde;o n&atilde;o pode ser desfeita!';
$lang['articleadded']='O artigo foi adicionado com sucesso.';
$lang['articledeleted']='O artigo foi deletado com sucesso.';
$lang['articles']='Artigos';
$lang['articleupdated']='O artigo foi atualizado com sucesso.';
$lang['author']='Autor';
$lang['author_label']='Postado por:';
$lang['cancel']='Cancelar';
$lang['categories']='Categorias';
$lang['category']='Categoria';
$lang['category_label']='Categoria:';
$lang['categoryadded']='A categoria foi adicionada com sucesso.';
$lang['categorydeleted']='A categoria foi deletada com sucesso.';
$lang['categoryupdated']='A categoria foi atualizada com sucesso.';
$lang['content']='Conte&uacute;do';
$lang['dateformat']='%s n&atilde;o est&aacute; em um formato de hora v&aacute;lido (aaaa-mm-dd hh:mm:ss)';
$lang['default_category']='Categoria Padr&atilde;o';
$lang['default_templates']='Modelo Visual Padr&atilde;o';
$lang['delete']='Deletar';
$lang['delete_selected']='Delete os artigos selecionados';
$lang['description']='Adicione, edite e remova Not&iacute;cias';
$lang['detailtemplate']='Modelo Visual Detalhado';
$lang['detailtemplateupdated']='O modelo visual detalhado foi atualizado com sucesso no banco de dados.';
$lang['displaytemplate']='Exibir Modelo Visual';
$lang['draft']='Rascunho';
$lang['edit']='Editar';
$lang['enddate']='Data Final';
$lang['endrequiresstart']='Ao entrar uma data final, &eacute; preciso entrar uma data inicial tamb&eacute;m';
$lang['entries']='%s Entradas';
$lang['error_invaliddates']='Uma ou mais das datas enviadas est&atilde;o inv&aacute;lidas';
$lang['error_invalidfiletype']='N&atilde;o pode enviar este tipo de arquivo';
$lang['error_mkdir']='N&atilde;o foi poss&iacute;vel criar o diret&oacute;rio: %s';
$lang['error_movefile']='N&atilde;o foi poss&iacute;vel criar o arquivo: %s';
$lang['error_noarticlesselected']='Nenhum artigo foi selecionado';
$lang['error_templatenamexists']='Um template com este nome j&aacute; existe';
$lang['error_upload']='Um problema ocorreu ao enviar um arquivo';
$lang['eventdesc-NewsArticleAdded']='Enviado quando o artigo &eacute; adicionado.';
$lang['eventdesc-NewsArticleDeleted']='Enviado quando o artigo &eacute; deletado.';
$lang['eventdesc-NewsArticleEdited']='Enviado quando o artigo &eacute; editado.';
$lang['eventdesc-NewsCategoryAdded']='Enviado quando uma categoria &eacute; adicionada.';
$lang['eventdesc-NewsCategoryDeleted']='Enviado quando uma categoria &eacute; deletada.';
$lang['eventdesc-NewsCategoryEdited']='Enviado quando uma categoria &eacute; editada.';
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
$lang['expired']='Expirado';
$lang['expired_searchable']='Artigos expirados podem aparecer nos resultados da pesquisa';
$lang['expiry']='Expira&ccedil;&atilde;o';
$lang['expiry_interval']='O n&uacute;mero de dias (por padr&atilde;o) antes de um artigo expirar (se expirar estiver selecionado)';
$lang['filter']='Filtro';
$lang['firstpage']='$lt;<';
$lang['formtemplate']='Modelo Visual de Formul&aacute;rios';
$lang['help']='	<h3>O que isto faz?</h3>
	<p>Not&iacute;cias &eacute; um m&oacute;dulo para exibir eventos e not&iacute;cias no seu site, similar a um blog, mas com muito mais fun&ccedil;&otilde;es!.  Quando o m&oacute;dulo &eacute; instalado, uma p&aacute;gina de administra&ccedil;&atilde;o de Not&iacute;cias &eacute; adicionada ao menu de administradao e ir&aacute; permitir que voc&ecirc;s selecione ou adiocione uma categoria de not&iacute;cias. Uma vez criada ou selecionada, uma lista de itens de not&iacute;cias ser&aacute; exibida. Daqui, voc&ecirc; pode adicionar, editar ou deletar not&iacute;cias para esta categoria.</p>
	
<h3>Vari&aacute;veis de Modelo Visual</h3>
	<ul>
		<li><b>itemcount</b> - N&uacute;mero de not&iacute;cias a exibir.</li>
	</ul>
<h3>Seguran&ccedil;a</h3>
	<p>O usu&aacute;rio deve pertencer a um grupo com a permiss&atilde;o &#039;Modificar Not&iacute;cias&#039; a fim de adicionar, editar ou apagar Not&iacute;cias.</p>
	<p> Para adicionar, editar ou apagar Modelos Visuais, o usu&aacute;rio deve pertencer a um grupo com a permiss&atilde;o &#039;Modificar Modelos Visuais&#039;.</p>
	<p>Para editar as prefer&ecirc;ncias das not&iacute;cias globais, o usu&aacute;rio deve pertencer a um grupo com a permiss&atilde;o &#039;Modificar Prefer&ecirc;ncias do Site&#039;.</p>
	<h3>Como eu uso?</h3>
	<p>A maneira mais f&aacute;cil de usar-lo &eacute; em conjun&ccedil;&atilde;o com a tag cms_module. Isto ir&aacute; inserir o m&oacute;dulo dentro do seu Modelo Visual ou p&aacute;gina em qualquer lugar que voc&ecirc; quiser exibir as not&iacute;cias. O c&oacute;digo deve se parecer com algo como: <code>{cms_module module=&quot;news&quot; number=&quot;5&quot; category=&quot;beer&quot;</code>}</p>
<h3>Informa&ccedil;&atilde;o de Tradu&ccedil;&atilde;o</h3>
<p>Traduzido por Jos&eacute; Diogenes Silva</br>D&uacute;vidas e sugest&otilde;es: diogenescmsms@gmail.com</p>
';
$lang['help_pagelimit']='Maximum number of items to display (per page).  If this parameter is not supplied all matching items will be displayed.  If it is, and there are more items available than specified in the pararamter, text and links will be supplied to allow scrolling through the results';
$lang['helpaction']='Override the default action.  Possible values are &#039;default&#039; to display the summary view, and &#039;fesubmit&#039; to display the frontend form for allowing users to submit news articles on the front end.';
$lang['helpcategory']='S&oacute; mostrar itens para aquela categoria. Use * ap&oacute;s o nome para exibir as subcategorias. Muitas categiras pode ser usadas se separadas por v&iacute;rgula. Deixar em branco, ir&aacute; mostrar todas as categorias.';
$lang['helpdetailpage']='P&aacute;gina para exibir a noticia detalhada. Pode ser o atalho da p&aacute;gina ou um ID. Usado para permitir que a pagina detalhada seja exibida num modelo visual diferente do resumo.';
$lang['helpdetailtemplate']='Usa um modelo visual diferente para exibir o artigo detalhado. Ele deve estar no diret&oacute;rio modules/News/templates.';
$lang['helpmoretext']='Texto para exibir no final de uma not&iacute;cia se ela passar do tamanho m&aacute;ximo do resumo. O Padr&atilde; &eacute; &quot;mais...&quot;';
$lang['helpnumber']='N&uacute;mero m&aacute;ximo de itens a exibir =- deixar em branco mostrar&aacute; todos os itens.';
$lang['helpshowall']='Mostrar todos os artigos independentemente da data de vencimento';
$lang['helpsortasc']='Organizar novos itens em ordem de data ascendente ao inv&eacute;s de descendente.';
$lang['helpsortby']='Organizar por.  As op&ccedil;&otilde;es s&atilde;o: &quot;news_date&quot;, &quot;summary&quot;, &quot;news_data&quot;, &quot;news_category&quot;, &quot;news_title&quot;.  O padr&atilde;o &eacute; &quot;news_date&quot;.';
$lang['helpstart']='Iniciar no en&eacute;simo item -- deixar em branco iniciar&aacute; no primeiro item';
$lang['helpsummarytemplate']='Usa um modelo visual diferente para exibir o resumo do artigo. Ele deve estar no diret&oacute;rio modules/News/templates.';
$lang['info_sysdefault']='<em>(the content used by default when a new template is created)</em>';
$lang['info_sysdefault2']='<strong>Note:</strong> This tab contains text areas to allow you to edit a set of templates that are displayed when you create a &#039;new&#039; summary, detail, or form template.  Changing content in this tab, and clicking &#039;submit&#039; will <strong>not effect any current displays</strong>.';
$lang['lastpage']='>>';
$lang['more']='Mais';
$lang['moretext']='Mais Texto';
$lang['name']='Nome';
$lang['needpermission']='Voc&ecirc; precisa da permiss&atilde;o &#039;%s&#039; para realizar esta fun&ccedil;&atilde;o.';
$lang['newcategory']='Nova Categoria';
$lang['news']='Not&iacute;cias';
$lang['news_return']='Retornar';
$lang['nextpage']='>';
$lang['nocategorygiven']='Nenhuma categoria especificada';
$lang['nocontentgiven']='Nenhum conte&uacute;do especificado';
$lang['noitemsfound']='<strong>Nenhum</strong> item encontrado para a categoria: %s';
$lang['nonamegiven']='Nenhum nome informado';
$lang['none']='Nenhum';
$lang['nopostdategiven']='Nenhuma Data de Postagem informada';
$lang['note']='<em>Nota:</em> As datas precisam estar no formato &#039;aaaa-mm-dd hh:mm:ss&#039;.';
$lang['notify_n_draft_items_sub']='%d Artigo(s) de not&iacute;cia';
$lang['notitlegiven']='Nenhum t&iacute;tulo informado';
$lang['numbertodisplay']='N&uacute;mero &aacute; exibir (em branco mostra todos os registros)';
$lang['options']='Op&ccedil;&otilde;es';
$lang['optionsupdated']='As op&ccedil;&otilde;es foram atualizadas com sucesso.';
$lang['postdate']='Data de Postagem';
$lang['postinstall']='Tenha certeza de especificar a permiss&atilde;o de &quot;Modificar Not&iacute;cias&quot; aos usu&aacute;rios que ir&atilde;o administrar os itens de Not&iacute;cias.';
$lang['prevpage']='<';
$lang['print']='Imprimir';
$lang['prompt_of']='de';
$lang['prompt_page']='P&aacute;gina';
$lang['prompt_pagelimit']='Limite de P&aacute;gina';
$lang['prompt_sorting']='Ordenar por';
$lang['published']='Publicado';
$lang['reassign_category']='Mudar categoria para';
$lang['removed']='Removido';
$lang['restoretodefaultsmsg']='Esta opera&ccedil;&atilde;o ir&aacute; restaurar o conte&uacute;do do  Modelo Visual para o padr&atilde;o do sistema. Voc&ecirc; tem certeza que quer prosseguir?';
$lang['revert']='Mude o Status para &#039;Rascunho&#039;';
$lang['select']='Selecione';
$lang['selectcategory']='Selecione a Categoria';
$lang['showchildcategories']='Exibir sub-categorias';
$lang['sortascending']='Ordena&ccedil;&atilde;o Ascendente';
$lang['startdate']='Data de In&iacute;cio';
$lang['startoffset']='Come&ccedil;ar a exibir a partir do en&eacute;simo item';
$lang['startrequiresend']='Ao entrar uma data inicial, &eacute; preciso entrar uma data final tamb&eacute;m';
$lang['submit']='Enviar';
$lang['summary']='Sum&aacute;rio';
$lang['summarytemplate']='Modelo Visual Resumido';
$lang['summarytemplateupdated']='O modelo visual de not&iacute;cia resumido foi atualizado com sucesso.';
$lang['sysdefaults']='Restaurar para os padr&otilde;es';
$lang['title']='T&iacute;tulo';
$lang['title_filter']='Filtros';
$lang['unknown']='Desconhecido';
$lang['unlimited']='Ilimitado';
$lang['useexpiration']='Usar data de expira&ccedil;&atilde;o';
?>