{* here we set default values and attributes for the libs that are loaded. *}
{capture assign='out'}{strip}
{if isset($jquery_libs.tablesorter)}
if( $.tablesorter ) { $(".cms_sortable").tablesorter({ widthFixed: true, widgets: ['zebra'], sortList: [[0,0]] }) }
{/if}
if( $.ui ) {  $('div.accordion').accordion(); }
{if isset($jquery_libs.lightbox)}if( $.lightbox ) { $('a.lightbox').lightBox(); }{/if}
{if isset($jquery_libs.fancybox)}if( $.fancybox ) { $('a.fancybox').fancybox(); }{/if}
{if isset($jquery_libs.cluetip)}if( $.cluetip ) { $("a.tooltip").cluetip({ local:true, cursor: 'pointer' }); } {/if}
{/strip}{/capture}
{if strlen($out)}
<script type="text/javascript">//<![CDATA[{jsmin}
$(document).ready(function($) { {$out} });  //end
{/jsmin}//]]></script>
{/if}
