<img  width="80" alt="{$resetdatatitle|default:''}"   src="../modules/Statistics/icons/crystalclear/reset.png" title="{$resetdatatitle|default:''}" style="float:right; display:block;" />

<table width="800"><tr><td>
{$startform}
{*$show*}
<div class="pageoverflow">
  <p class="pagetext">{$submitresetvisitors}</p>
  <p class="pageinput">{$resetvisitorshelp}</p>
</div>

<div class="pageoverflow">
  <p class="pagetext">{$submitresetdata}</p>
  <p class="pageinput">{$resetdatahelp}</p>
</div>

<div class="pageoverflow">
  <p class="pagetext">{$submitresetall}</p>
  <p class="pageinput">{$resetallhelp}</p>
</div>

<div class="pageoverflow">
  <p class="pagetext">{$forcevisitorstext}</p>
  <p class="pageinput">{$forcevisitors}{$currentvisitors}</p>
</div>


<div class="pageoverflow">
  <p class="pagetext">{$forcepageviewstext}</p>
  <p class="pageinput">{$forcepageviews}{$currentpageviews}</p>
</div>

{$endform}

</td></tr></table>