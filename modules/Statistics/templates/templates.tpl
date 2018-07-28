<img width="80" alt="{$settingstitle|default:''}" src="../modules/Statistics/icons/crystalclear/settings.png" title="{$settingstitle|default:''}" style="float:right;" />

<table width="800"><tr><td>

{$startform1}
{*$show*}
	<div class="pageoverflow">
		<p class="pagetext">{$topxtemplatetext}:</p>
		<p class="pageinput">{$topxtemplateinput}<br/>{$topxtemplatehelp}<br/>{$topxtemplateparams}</p>
  </div>
  
  <div class="pageoverflow">
		<p class="pagetext">&nbsp;</p>
		<p class="pageinput">{$submittopx}{$resettopx}</p>
	</div>
{$endform1}

{$startform2}
{*$show*}
	<div class="pageoverflow">
		<p class="pagetext">{$emailtemplatetext}:</p>
		<p class="pageinput">{$emailtemplateinput}<br/>{$emailtemplatehelp}<br/>{$emailtemplateparams}</p>
  </div>
  <div class="pageoverflow">
		<p class="pagetext">&nbsp;</p>
		<p class="pageinput">{$submitemail}{$resetemail}</p>
	</div>
{$endform2}

</td></tr></table>