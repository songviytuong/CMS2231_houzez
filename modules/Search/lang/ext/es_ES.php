<?php
$lang['clear'] = 'Eliminar';
$lang['confirm_clearstats'] = '¿Esta seguro de querer eliminar todas las estadísticas?';
$lang['confirm_reindex'] = 'Esta operación puede tomar bastante tiempo y requerir una cantidad extensiva de memoria PHP. ¿Está seguro de querer re-indexar todo el contenido?';
$lang['count'] = 'Conteo';
$lang['default_stopwords'] = 'yo, mi, mio, tuyo, suyo, tu, vos, usted, su, cual, tal, el, ella, ellos, quién, quien, quienes, a, de, y, por, cual, porque, que, no, lo, los, solo, solamente, mismo, so, entonces, tambien, muy, mucho, con, sido, ha, acerca, contra, tuvo, tuve, tenia, tuvieron, tuviese, sobre, él, antes, ante, bajo, abajo, desde, una, uno, aqui, ahi, alli, 
i, me, my, myself, we, our, ours, ourselves, you, your, yours, 
yourself, yourselves, he, him, his, himself, she, her, hers, 
herself, it, its, itself, they, them, their, theirs, themselves, 
what, which, who, whom, this, that, these, those, am, is, are, 
was, were, be, been, being, have, has, had, having, do, does, 
did, doing, a, an, the, and, but, if, or, because, as, until, 
while, of, at, by, for, with, about, against, between, into, 
through, during, before, after, above, below, to, from, up, down, 
in, out, on, off, over, under, again, further, then, once, here, 
there, when, where, why, how, all, any, both, each, few, more, 
most, other, some, such, no, nor, not, only, own, same, so, 
than, too, very';
$lang['description'] = 'Módulo para buscar en el sitio y contenido de otros módulos.';
$lang['eventdesc-SearchAllItemsDeleted'] = 'Se envía al eliminar todos los elementos del índice.';
$lang['eventhelp-SearchAllItemsDeleted'] = '<p>Se envía al eliminar todos los elementos del índice.</p>
<h4>Parámetros</h4>
<ul>
<li>Ninguno</li>
</ul>';
$lang['eventdesc-SearchCompleted'] = 'Se envía al finalizar una búsqueda.';
$lang['eventhelp-SearchCompleted'] = '<p>Se envía al finalizar una búsqueda.</p>
<h4>Parámetros</h4>
<ol>
<li>Texto que se buscó.</li>
<li>Array del resultado completo.</li>
</ol>';
$lang['eventdesc-SearchInitiated'] = 'Se envía al iniciar una búsqueda.';
$lang['eventhelp-SearchInitiated'] = '<p>Se envía al iniciar una búsqueda.</p>
<h4>Parámetros</h4>
<ol>
<li>Texto que se buscó.</li>
</ol>';
$lang['eventdesc-SearchItemAdded'] = 'Se envía al indexar un nuevo elemento.';
$lang['eventhelp-SearchItemAdded'] = '<p>Se envía al indexar un nuevo elemento.</p>
<h4>Parámetros</h4>
<ol>
<li>Nombre del Módulo</li>
<li>Id del elemento.</li>
<li>Atributo Adicional.</li>
<li>Contenido a añadir e indexar.</li>
</ol>';
$lang['eventdesc-SearchItemDeleted'] = 'Se envía al eliminar un elemento del índice.';
$lang['eventhelp-SearchItemDeleted'] = '<p>Se envía al eliminar un elemento del índice.</p>
<h4>Parámetros</h4>
<ol>
<li>Nombre del Módulo</li>
<li>Id del elemento.</li>
<li>Atributo Adicional.</li>
</ol>';
$lang['export_to_csv'] = 'Exportar a formato CSV';
$lang['help'] = '<h3>¿Qué hace esto?</h3>
<p>El módulo de búsqueda es para realizar búsquedas en el "core" del contenido al mismo tiempo que en ciertos módulos registrados.  Usted pone una o dos palabras y él le dará como resultado coincidencias del contenido con las palabras dadas.</p>
<h3>¿Cómo lo puedo usar?</h3>
<p>La forma más sencilla de utilizarlo es con el contenedor de tag {search} (envuelve al módulo en un tag, con el fin de simplificar la sintaxis). Esto permitirá incluir al módulo en sus plantillas o páginas, cualquiera sea el lugar que quiera, y así mostrar el formulario de búsquedas.  El código se verá algo así como esto: <code>{search}</code></p>
<h4>¿Cómo puedo hacer para evitar que algún contenido sea indexado?</h4>
<p>El módulo de búsqueda no indexará aquellas páginas que estén "inactivas". Sin embargo hay ocasiones, cuando usted utiliza el módulo CustomContent, o algún otro con lógica smarty para mostrar diferentes contenidos a diferentes grupos de usuarios, puede ser aconsejable prevenir que la página completa sea indexada aún cuando se haya publicado.  Para lograr éste objetivo incluya la siguiente tag en cualquier lugar de la página <em><!-- pageAttribute: NotSearchable --></em> Cuando el módulo de búsqueda vea ésta tag en la página no la indexará de ninguna forma.</p>
<p>La tag <em><!-- pageAttribute: NotSearchable --></em> puede ubicarse también en la plantilla.  Si este fuera el caso, ninguna de las páginas unidas a esta plantilla será indexada.  Estas páginas serán re-indexadas si quitamos el tag</p>';
$lang['input_resetstopwords'] = 'Cargar';
$lang['noresultsfound'] = '¡No se ha encontrado resultados!';
$lang['nostatistics'] = '¡No se encontraron estadisticas!';
$lang['options'] = 'Opciones';
$lang['param_action'] = 'Especificar el modo de operación del módulo.  Los valores aceptables son \'default\', y \'keywords\'.  La acción keywords(palabras clave) se puede utilizar para generar un listado de palabras separadas por comas apta para ser usada en una meta tag de keywords(palabras clave).';
$lang['param_count'] = 'Usado con la acción keywords (palabras clave), este parámetro limitará el resultado de la búsqueda al número especificado de palabras';
$lang['param_detailpage'] = 'Usado unicamente para igualar resultados de modulos, este parametro permite especificar una pagina para mostrar detalles de los resultados. Esto es util si por ejemplo, la vista de detalle es mostrada siempre en una pagina con una plantilla distinta. <em>(<strong>Nota:</strong> los módulos deberán tener la habilidad de invalidar este parámetro.)</em>';
$lang['param_formtemplate'] = 'Usado en la acción por defecto, este parámetro permite especificar el nombre de una plantilla.';
$lang['param_inline'] = 'Si verdadero, el formulario de búsqueda remplazará el contenido original de l tag \'search\' en el bloque originario. Use este parámetro si su plantilla tiene múltiples bloques, y no quiere que el resultado de la búsqueda remplace el contenido que el bloque tiene por defecto';
$lang['param_modules'] = 'Limitar resultados de búsqueda a los valores indexados del listado de módulos (separados por coma) especificado';
$lang['param_pageid'] = 'Aplicable solo con la acción keywords (palabras clave), este parámetro se puede especificar para que los resultados sean de una página con diferente id';
$lang['param_passthru'] = 'Pasar los parámetros nombrados al módulo especificado. El formato de cada uno de esos parámetros es: "passtru_MODULENAME_PARAMNAME=\'value\'" i.e.: passthru_News_detailpage=\'newsdetails\'"';
$lang['param_resultpage'] = 'Página para mostrar resultados.  Puede ser un alias de página o un id.  Se usa para poder visualizar resultados con una plantilla diferente de la de búsqueda';
$lang['param_resulttemplate'] = 'Este parámetro permite especificar el nombre de una plantilla (que no sea por defecto) para desplegar resultados de búsqueda.';
$lang['param_searchtext'] = 'Texto a poner en la búsqueda';
$lang['param_submit'] = 'Texto a poner en el botón enviar';
$lang['param_useor'] = 'Cambiar el valor por defecto de una relación OR a una relación AND';
$lang['prompt_alpharesults'] = 'Ordenar resultados alfabeticamente, no por peso';
$lang['prompt_resetstopwords'] = 'Cargar lista de palabras no indexadas del lenguaje';
$lang['prompt_resultpage'] = 'Página para resultados individuales del módulo<em>(Nota: los módulos pueden opcionalmente invalidar esto)</em>';
$lang['prompt_savephrases'] = 'Buscar frases, no palabras individuales';
$lang['prompt_searchtext'] = 'Texto Buscar por Defecto';
$lang['reindexallcontent'] = 'Reindexar Todo el Contenido';
$lang['reindexcomplete'] = '¡Reindexado Completo!';
$lang['restoretodefaultsmsg'] = 'Esta operación restaura el contenido de la plantilla al por defecto del sistema. ¿Seguro que quiere continuar?';
$lang['resulttemplate'] = 'Plantilla de Resultado';
$lang['resulttemplateupdated'] = 'Plantilla de Resultados Actualizada';
$lang['search'] = 'Búsqueda';
$lang['searchresultsfor'] = 'Resultados obtenidos para:';
$lang['searchsubmit'] = 'Enviar';
$lang['searchtemplate'] = 'Plantilla de Búsqueda';
$lang['searchtemplateupdated'] = 'Plantilla de Búsqueda Actualizada';
$lang['search_method'] = 'Pretty URLs son compatibles mediante metodo POST, el valor por defecto es GET, para hacer funcionar esto simplemente poner: {search search_method="post"}';
$lang['statistics'] = 'Estadísticas';
$lang['stopwords'] = 'Parar Palabras';
$lang['submit'] = 'Enviar';
$lang['sysdefaults'] = 'Restaurar a por Defecto';
$lang['timetaken'] = 'Tiempo de la búsqueda';
$lang['type_Search'] = 'Buscar';
$lang['type_searchform'] = 'Forma de búsqueda';
$lang['type_searchresults'] = 'Resultados de búsqueda';
$lang['usestemming'] = 'Usar Word Stemming (Sólo Inglés)';
$lang['use_or'] = 'Buscar coincidencias con cualquier palabra';
$lang['word'] = 'Palabra';
?>