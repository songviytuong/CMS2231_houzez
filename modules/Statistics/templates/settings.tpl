<img width="80" alt="{$settingstitle|default:''}" src="../modules/Statistics/icons/crystalclear/settings.png" title="{$settingstitle|default:''}" style="float:right;" />

<table width="800"><tr><td>
{$startform}
{*$show*}
  <div class="pageoverflow">
		<p class="pagetext">{$countrydetectiontext}:</p>
		<p class="pageinput">{$countrydetectioninput}<br/>{$countrydetectionhelp}</p>
	</div>

  <div class="pageoverflow">
		<p class="pagetext">{$iphandlingtext}:</p>
		<p class="pageinput">{$iphandlinginput}<br/>{$iphandlinghelp}</p>
	</div>

	<div class="pageoverflow">
		<p class="pagetext">{$statemailtext}:</p>
		<p class="pageinput">{$statemailinput}</p>
	</div>
  <div class="pageoverflow">
		<p class="pagetext">{$emailsubjecttext}:</p>
		<p class="pageinput">{$emailsubjectinput}<br/>{$emailsubjecthelp}</p>
	</div>

	<div class="pageoverflow">
		<p class="pagetext">{$emailintervaltext}:</p>
		<p class="pageinput">{$emailintervalinput}</p>
	</div>

	<div class="pageoverflow">
		<p class="pagetext">{$jsdetectstext}:</p>
		<p class="pageinput">{$jsdetectsinput} {$jsdetectshelp}</p>
	</div>

	<div class="pageoverflow">
		<p class="pagetext">{$visitortrackingtext}:</p>
		<p class="pageinput">{$visitortrackinginput} {$visitortrackinghelp}</p>
	</div>

  <div class="pageoverflow">
		<p class="pagetext">{$keywordreplacementstext}:</p>
		<p class="pageinput">{$keywordreplacementsinput}<br/>{$keywordreplacementshelp}</p>
	</div>

  <div class="pageoverflow">
		<p class="pagetext">{$singlekeywordstext}:</p>
		<p class="pageinput">{$singlekeywordsinput} {$singlekeywordshelp}</p>
	</div>

  <div class="pageoverflow">
		<p class="pagetext">{$counturlaccesstext}:</p>
		<p class="pageinput">{$counturlaccessinput} {$counturlaccesshelp}</p>
	</div>

	<div class="pageoverflow">
		<p class="pagetext">{$expirytimetext}:</p>
		<p class="pageinput">{$expirytimeinput} {$expirytimehelp}</p>
	</div>

  <div class="pageoverflow">
		<p class="pagetext">{$adminsectiontext}:</p>
		<p class="pageinput">{$adminsectioninput}</p>
	</div>



	<div class="pageoverflow">
		<p class="pagetext">{$debuglogtext}:</p>
		<p class="pageinput">{$debugloginput}&nbsp;{$debuglogleveltext}:&nbsp;{$debugloglevelinput}&nbsp;&nbsp;{$maxlogagetext}:&nbsp;{$maxlogageinput}</p>
	</div>


 {*
	<div class="pageoverflow">
		<p class="pagetext">&nbsp;</p>
		<p class="pageinput">{$submit}</p>
	</div>
  *}

  <div class="pageoverflow">
		<p class="pagetext">&nbsp;</p>
		<p class="pageinput">{$submitsettings}{$submitsettingsemail}</p>
	</div>
{$endform}

</td></tr></table>