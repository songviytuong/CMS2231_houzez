

<img alt="{$title}"  title="{$title}" src="{$rooturl}/modules/Statistics/icons/{$iconset}/{$icon}" style="float:right"/>


<center>
<div id="jqchart" style="width:{$jqplotx}px;height:{$jqploty}px;">

</div>
</center>

<!--[if IE]><script language="javascript" type="text/javascript" src="{$rooturl}/modules/Statistics/chart/jqplot/excanvas.js"></script><![endif]-->
<script language="javascript" type="text/javascript" src="{$rooturl}/modules/Statistics/chart/jqplot/jquery-1.3.2.min.js"></script>
<script language="javascript" type="text/javascript" src="{$rooturl}/modules/Statistics/chart/jqplot/jquery.jqplot.min.js"></script>
<script type="text/javascript" src="{$rooturl}/modules/Statistics/chart/jqplot/plugins/jqplot.dateAxisRenderer.min.js"></script>
<script type="text/javascript" src="{$rooturl}/modules/Statistics/chart/jqplot/plugins/jqplot.canvasTextRenderer.min.js"></script>
<script type="text/javascript" src="{$rooturl}/modules/Statistics/chart/jqplot/plugins/jqplot.canvasAxisTickRenderer.min.js"></script>
<script type="text/javascript" src="{$rooturl}/modules/Statistics/chart/jqplot/plugins/jqplot.categoryAxisRenderer.min.js"></script>
<script type="text/javascript" src="{$rooturl}/modules/Statistics/chart/jqplot/plugins/jqplot.pointLabels.min.js"></script>
<script language="javascript" type="text/javascript">
{literal}
line1 = [{/literal}{$values}{literal}];

plot2 = jQuery.jqplot('jqchart', [line1], {
    //legend:{show:true, location:'ne', xoffset:55},
    title: '{/literal}{$title}{literal}',
    {/literal}{if $count>15}{literal}
    axesDefaults: {
      tickRenderer: jQuery.jqplot.CanvasAxisTickRenderer ,
      tickOptions: {
        angle: -30,
        fontSize: '9pt'
      }
    },
    {/literal}{/if}{literal}
    axes: {
      xaxis:{
        renderer:jQuery.jqplot.CategoryAxisRenderer
      },
      yaxis:{
        autoscale:true,
        min:0,
        max:{/literal}{$maxvalue}{literal},
        tickOptions:{formatString:'%i'}
      }
    }

});

{/literal}
</script>

{*ticks:[{/literal}{$labels}{literal}]*}
{*,min:0,max:{/literal}{$maxvalue}{literal}*}


