{$formstart}
	{$namehidden}
	{if $name != ''}
		<div class="pageoverflow">
			<p class="pagetext">{$name}*:</p>
			<p class="pageinput">{$nameinput}</p>
		</div>
	{/if}

	<div class="pageoverflow">
		<p class="pagetext">{$content}*:</p>
		<p class="pageinput">{$contentinput}</p>
		<p class="pageinput">{$templatehelp}: {ldelim}$quoteauthor}, {ldelim}$quotecontent}, {ldelim}$quotereference} and {ldelim}$quoteexposures}.</p>
	</div>

	<div class="pageoverflow">
		<p class="pagetext">&nbsp;</p>
		<p class="pageinput">{$submit}{$apply}{$reset}</p>
	</div>
{$formend}

{$backlink}