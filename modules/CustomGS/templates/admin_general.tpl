{$startform}

	{foreach from=$items item=entry}
		{if $entry->type == 'fieldsetstart' || $entry->type == 'fieldsetend'}
		
			{$entry->fieldhtml}
			{if !empty($entry->help)}<p class="pageinput">{$entry->help|escape}</p>{/if}
    
		{else}
		
			<div class="pageoverflow">
				<p class="pagetext">{if $entry->type != 'button'}{$entry->name|escape}:</p>
				<p class="pageinput{$entry->fieldclass}">{/if}{$entry->fieldhtml}</p>
				<p class="pageinput">{$entry->help|escape}</p>
			</div>
		
		{/if}
	{/foreach}
	
	<hr />
	<div class="pageoverflow">
		<p class="pagetext">&nbsp;</p>
		<p class="pageinput">{$submit}{$cancel}</p>
	</div>

{$endform}