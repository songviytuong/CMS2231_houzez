{assign var=size value="48"}

<table align='center' class='pagetable' style="border-width:0px;text-align:center;">
<tr>
<td>
{if isset($summaryurl)}
<div style="float: left; margin:10px;">
<a href="{$summaryurl}">
  <img alt="{$summarytitle}" src="../modules/Statistics/icons/{$iconset}/summary_small.png" title="{$summarytitle}" width="{$size}" height="{$size}" />
</a>
<br/>
  {$summarytitle}

</div>

{/if}

{if isset($daysurl)}
<div style="float: left; margin:10px;">
<a href="{$daysurl}">
  <img alt="{$daystitle}" src="../modules/Statistics/icons/{$iconset}/days_small.png" title="{$daystitle}" width="{$size}" height="{$size}" />
</a>
<br/>
  {$daystitle}

</div>

{/if}

{if isset($weekdaysurl)}
<div style="float: left; margin:10px;">
<a href="{$weekdaysurl}">
  <img alt="{$weekdaystitle}" src="../modules/Statistics/icons/{$iconset}/weekdays_small.png" title="{$weekdaystitle}" width="{$size}" height="{$size}" />
</a>
<br/>{$weekdaystitle}
</div>

{/if}

{if isset($timesurl)}

<div style="float: left; margin:10px;">

<a href="{$timesurl}">
  <img alt="{$timestitle}" src="../modules/Statistics/icons/{$iconset}/times_small.png" title="{$timestitle}" width="{$size}" height="{$size}" />
</a>
<br/>{$timestitle}

</div>

{/if}

{if isset($weeksurl)}

<div style="float: left; margin:10px;">

<a href="{$weeksurl}">
  <img alt="{$weekstitle}" src="../modules/Statistics/icons/{$iconset}/weeks_small.png" title="{$weekstitle}" width="{$size}" height="{$size}" />
</a>
<br/>{$weekstitle}

</div>

{/if}

{if isset($monthsurl)}

<div style="float: left; margin:10px;">

<a href="{$monthsurl}">
  <img alt="{$monthstitle}"  src="../modules/Statistics/icons/{$iconset}/months_small.png" title="{$monthstitle}" width="{$size}" height="{$size}" />
</a>
<br/>{$monthstitle}

</div>

{/if}

{if isset($yearsurl)}

<div style="float: left; margin:10px;">

<a href="{$yearsurl}">
  <img alt="{$yearstitle}" src="../modules/Statistics/icons/{$iconset}/years_small.png" title="{$yearstitle}" width="{$size}" height="{$size}" />
</a>
<br/>{$yearstitle}

</div>

{/if}

{if isset($browsersurl)}

<div style="float: left; margin:10px;">

<a href="{$browsersurl}">
  <img alt="{$browserstitle}" src="../modules/Statistics/icons/{$iconset}/browsers_small.png" title="{$browserstitle}" width="{$size}" height="{$size}" />
</a>
<br/>{$browserstitle}

</div>

{/if}

{if isset($osesurl)}

<div style="float: left; margin:10px;">

<a href="{$osesurl}">
  <img alt="{$osestitle}" src="../modules/Statistics/icons/{$iconset}/oses_small.png" title="{$osestitle}" width="{$size}" height="{$size}" />
</a>
<br/>{$osestitle}

</div>

{/if}

{if isset($smartphonesurl)}

<div style="float: left; margin:10px;">

<a href="{$smartphonesurl}">
  <img alt="{$smartphonestitle}" src="../modules/Statistics/icons/{$iconset}/smartphones_small.png" title="{$smartphonestitle}" width="{$size}" height="{$size}" />
</a>
<br/>{$smartphonestitle}

</div>

{/if}

{if isset($countriesurl)}

<div style="float: left; margin:10px;">

<a href="{$countriesurl}">
  <img alt="{$countriestitle}" src="../modules/Statistics/icons/{$iconset}/countries_small.png" title="{$countriestitle}" width="{$size}" height="{$size}" />
</a>
<br/>{$countriestitle}

</div>

{/if}

{if isset($pagesurl)}

<div style="float: left; margin:10px;">

<a href="{$pagesurl}">
  <img alt="{$pagestitle}" src="../modules/Statistics/icons/{$iconset}/pages_small.png" title="c" width="{$size}" height="{$size}" />
</a>
<br/>{$pagestitle}


</div>

{/if}

{if isset($referersurl)}

<div style="float: left; margin:10px;">

<a href="{$referersurl}">
  <img alt="{$refererstitle}" src="../modules/Statistics/icons/{$iconset}/referers_small.png" title="{$refererstitle}" width="{$size}" height="{$size}" />
</a>
<br/>{$refererstitle}

</div>

{/if}

{if isset($searchenginesurl)}

<div style="float: left; margin:10px;">
<a href="{$searchenginesurl}">
  <img alt="{$searchenginestitle}" src="../modules/Statistics/icons/{$iconset}/searchengines_small.png" title="{$searchenginestitle}" width="{$size}" height="{$size}" />
</a>
<br/>{$searchenginestitle}

</div>

{/if}

{if isset($robotsurl)}

<div style="float: left; margin:10px;">

<a href="{$robotsurl}">
  <img alt="{$robotstitle}" src="../modules/Statistics/icons/{$iconset}/robots_small.png" title="{$robotstitle}" width="{$size}" height="{$size}" />
</a>
<br/>{$robotstitle}

</div>

{/if}

{if isset($visitorsurl)}

<div style="float: left; margin:10px;">


<a href="{$visitorsurl}">
  <img alt="{$visitorstitle}"  src="../modules/Statistics/icons/{$iconset}/visitors_small.png" title="{$visitorstitle}" width="{$size}" height="{$size}" />

</a>
<br/>{$visitorstitle}

</div>

{/if}

{if isset($resolutionsurl)}

<div style="float: left; margin:10px;">

<a href="{$resolutionsurl}">
  <img alt="{$resolutionstitle}" src="../modules/Statistics/icons/{$iconset}/resolutions_small.png" title="{$resolutionstitle}" width="{$size}" height="{$size}"  />
</a>
<br />{$resolutionstitle}

</div>

{/if}
</td>
</tr>
</table>