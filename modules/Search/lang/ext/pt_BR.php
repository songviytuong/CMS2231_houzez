<?php
$lang['clear']='Limpar';
$lang['count']='Contador';
$lang['description']='M&oacute;dulo para pesquisar no site e no conte&uacute;do dos outros m&oacute;dulos.';
$lang['eventdesc-SearchAllItemsDeleted']='Enviado quando todos os itens s&atilde;o deletados do &iacute;ndice.';
$lang['eventdesc-SearchCompleted']='Enviado quando uma busca termina.';
$lang['eventdesc-SearchInitiated']='Enviado quando uma busca se inicia.';
$lang['eventdesc-SearchItemAdded']='Enviado quando um novo item &eacute; indexado.';
$lang['eventdesc-SearchItemDeleted']='Enviado quando um item &eacute; deletado do &iacute;ndice.';
$lang['eventhelp-SearchAllItemsDeleted']='<p>Enviado quando todos os itens s&atilde;o deletados do &iacute;ndice.</p>
<h4>Par&acirc;metros</h4>
<ul>
<li>Nenhum</li>
</ul>
';
$lang['eventhelp-SearchCompleted']='<p>Enviado quando uma busca termina..</p>
<h4>Par&acirc;metros</h4>
<ol>
<li>Texto o qual foi pesquisado.</li>
<li>Conjunto dos resultados encontrados.</li>
</ol>
';
$lang['eventhelp-SearchInitiated']='<p>Enviado quando uma busca se inicia.</p>
<h4>Par&acirc;metros</h4>
<ol>
<li>Texto o qual foi pesquisado.</li>
</ol>
';
$lang['eventhelp-SearchItemAdded']='<p>Enviado quando um novo item &eacute; indexado.</p>
<h4>Par&acirc;metros</h4>
<ol>
<li>Nome do m&oacute;dulo.</li>
<li>Id do item.</li>
<li>Atributo Adicional.</li>
<li>Conte&uacute;do a indexar e adicionar.</li>
</ol>
';
$lang['eventhelp-SearchItemDeleted']='<p>Enviado quando um item &eacute; deletado do &iacute;ndice..</p>
<h4>Par&acirc;metros</h4>
<ol>
<li>Nome do m&oacute;dulo.</li>
<li>Id do item.</li>
<li>Atributo Adicional.</li>
</ol>
';
$lang['help']='<h3>What does this do?</h3>
<p>Search is a module for searching &quot;core&quot; content along with certain registered modules.  You put in a word or two and it gives you back matching, relevent results.</p>
<h3>How do I use it?</h3>
<p>The easiest way to use it is with the {search} wrapper tag (wraps the module in a tag, to simplify the syntax). This will insert the module into your template or page anywhere you wish, and display the search form.  The code would look something like: <code>{search}</code></p>
<h4>How do i prevent certain content from being indexed</h4>
<p>The search module will not search any &quot;inactive&quot; pages. However on occasion, when you are using the CustomContent module, or other smarty logic to show different content to different groups of users, it may be advisiable to prevent the entire page from being indexed even when it is live.  To do this include the following tag anywhere on the page <em><!-- pageAttribute: NotSearchable --></em> When the search module sees this tag in the page it will not index any content for that page.</p>
<p>The <em><!-- pageAttribute: NotSearchable --></em> tag can be placed in the template as well.  if this is done, none of the pages attached to that template will be indexed.  Those pages will be re-indexed if the tag is removed</p>
';
$lang['noresultsfound']='Nenhum resultado encontrado!';
$lang['options']='Op&ccedil;&otilde;es';
$lang['param_action']='Specify the mode of operation for the module.  Acceptable values are &#039;default&#039;, and &#039;keywords&#039;.  The keywords action can be used to generate a comma seperated list of words suitable for use in a keywords meta tag.';
$lang['param_inline']='If true, the output from the search form will replace the original content of the &#039;search&#039; tag in the originating content block.  Use this parameter if your template has multiple content blocks, and you do not want the output of the search to replace the default content block';
$lang['param_passthru']='Pass named parameters down to specified modules.  The format of each of these parameters is: &quot;passtru_MODULENAME_PARAMNAME=&#039;value&#039;&quot; i.e.: passthru_News_detailpage=&#039;newsdetails&#039;&quot;';
$lang['param_searchtext']='Texto para exibir na caixa de pesquisa';
$lang['param_submit']='Texto para exibir no bot&atilde;o enviar';
$lang['prompt_searchtext']='Texto padr&atilde;o para a busca';
$lang['reindexallcontent']='Reindexar todo o conte&uacute;do';
$lang['reindexcomplete']='Reindexa&ccedil;&atilde;o conclu&iacute;da!';
$lang['restoretodefaultsmsg']='Esta opera&ccedil;&atilde;o ir&aacute; restaurar o modelo visual para o padr&atilde;o do sistema. Voc&ecirc; tem certeza que quer continuar?';
$lang['resulttemplate']='Modelo Visual dos Resultados';
$lang['resulttemplateupdated']='Modelo Visual de Resultados Atualizados';
$lang['search']='Pesquisa';
$lang['searchresultsfor']='Buscar resultados para';
$lang['searchsubmit']='Enviar';
$lang['searchtemplate']='Modelo Visual de Pesquisa';
$lang['searchtemplateupdated']='Modelo Visual de pesquisa atualiazado';
$lang['statistics']='Estat&iacute;sticas';
$lang['stopwords']='Palavras Chave';
$lang['submit']='Enviar';
$lang['sysdefaults']='Restaurar para os padr&otilde;es';
$lang['timetaken']='Tempo gasto';
$lang['usestemming']='Fazer busca por radical (Somente Ingl&ecirc;s)';
$lang['word']='Palavra';
?>