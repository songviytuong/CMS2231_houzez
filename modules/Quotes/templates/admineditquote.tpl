<h2>{$titleaction}</h2>

{$formstart}

	<div class="pageoverflow">
		<p class="pagetext">{$quotetextid}:</p>
		<p class="pageinput">{$textidinput}{$quotetextidhelp}</p>
	</div>

	{if $type=="1"}
		<div class="pageoverflow">
			<p class="pagetext">{$quotecontent}*:</p>
			<p class="pageinput">{$contentinput}</p>
		</div>

		<div class="pageoverflow">
			<p class="pagetext">{$quoteauthor}:</p>
			<p class="pageinput">{$authorinput}</p>
		</div>
		
		<div class="pageoverflow">
			<p class="pagetext">{$quotereference}:</p>
			<p class="pageinput">{$referenceinput}</p>
		</div>
	{/if}

	{if $type=="2"}
		<div class="pageoverflow">
			<p class="pagetext">{$rssurltext}:</p>
			<p class="pageinput">{$rssurlinput}</p>
		</div>

		<!--
		<div class="pageoverflow">
			<p class="pagetext">{$rssparsingtext}:</p>
			<p class="pageinput">{$rssparsinginput}{$rssparsinghelp}</p>
		</div>
		-->
	{/if}

	<div class="pageoverflow">
		<p class="pagetext">{$groupstext}:</p>
		<p class="pageinput">{$groupsinput}</p>
	</div>

	<div class="pageoverflow">
		<p class="pagetext">&nbsp;</p>
		<p class="pageinput">{$submit}</p>
	</div>
	
{$formend}

{$backlink}