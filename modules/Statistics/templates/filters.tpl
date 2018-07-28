<img width="80" alt="{$settingstitle|default:''}" src="../modules/Statistics/icons/crystalclear/filters.png" title="{$settingstitle|default:''}" style="float:right" />

<table width="800"><tr><td>
{$startform}
{*$show*}
	<div class="pageoverflow">
        <div class="pagetext">{$ignorerobotstext}: {$ignorerobotsinput}</div>
	</div>
	
  <div class="pageoverflow">
		<div class="pagetext">{$extrarobotstext}:</div>
		<div class="pageinput">{$extrarobotsinput}<br/>{$extrarobotshelp}</div>    
	</div>

	<div class="pageoverflow">
		<div class="pagetext">{$ignoreiptext}:</div>
		<div class="pageinput">{$ignoreipinput}</div>
	</div>
	<div class="pageoverflow">
		<div class="pagetext">{$ignorepagestext}:</div>
		<div class="pageinput">{$ignorepagesinput}</div>
	</div>
	<div class="pageoverflow">
		<div class="pagetext">{$ignorevisitorstext}:</div>
		<div class="pageinput">{$ignorevisitorsinput}<br/>{$ignorevisitorshelp}</div>
	</div>
	<div class="pageoverflow">
		<div class="pagetext">{$ignorerefererstext}:</div>
		<div class="pageinput">{$ignorereferersinput}<br/>{$ignorereferershelp}</div>
	</div>
  <div class="pageoverflow">
		<div class="pagetext">{$ignoreadminstext}:</div>
		<div class="pageinput">{$ignoreadminsinput}<br/>{$ignoreadminshelp}</div>
	</div>



  <div class="pageoverflow">
		<p class="pagetext">&nbsp;</p>
		<p class="pageinput">{$submitfilters}</p>
	</div>
{$endform}

</td></tr></table>