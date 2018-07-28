
<img alt="{$title}"  title="{$title}" src="{$rooturl}/modules/Statistics/icons/{$icon}" style="float:right"/>

<center>
<div style="margin-top:30px; width:{math equation="x + y" x=20 y=$jqplotx}px; height:{$jqploty}px; overflow: auto; position: relative;">
<div id="jqchart" style="width:{$jqplotx}px; height:{$jqploty}px;">

</div>

</div>
</center>

<!--[if IE]><script language="javascript" type="text/javascript" src="{$rooturl}/modules/Statistics/chart/jqplot/excanvas.js"></script><![endif]-->
<script language="javascript" type="text/javascript" src="{$rooturl}/modules/Statistics/chart/jqplot/jquery-1.3.2.min.js"></script>
<script language="javascript" type="text/javascript" src="{$rooturl}/modules/Statistics/chart/jqplot/jquery.jqplot.min.js"></script>
<script type="text/javascript" src="{$rooturl}/modules/Statistics/chart/jqplot/plugins/jqplot.pieRenderer.min.js"></script>
<script language="javascript" type="text/javascript">
{literal}
line1 = [{/literal}{$values}{literal}];
plot2 = jQuery.jqplot('jqchart', [line1], {

    title:'{/literal}{$title}{literal}',
    seriesDefaults:{
      renderer:$.jqplot.PieRenderer,
      rendererOptions:{sliceMargin:8}
    },
    legend:{show:true},
    grid:{borderWidth:0, shadow:false}     
});
{/literal}
</script>

