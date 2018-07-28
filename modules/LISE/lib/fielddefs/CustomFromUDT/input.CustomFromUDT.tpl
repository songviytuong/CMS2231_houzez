{$source = $fielddef->GetOptionValue('source_udt')}
{$type = $fielddef->GetOptionValue('type')}
{$opts = $fielddef->CallUDT($fielddef->GetOptionValue('source_udt'))}
{$sel = $fielddef->GetValue()}

<div class="pageoverflow">
	<p class="pagetext">{$fielddef->GetName()}{if $fielddef->IsRequired()}*{/if}:</p>
	<p class="pageinput">
		{if $fielddef->GetDesc()}({$fielddef->GetDesc()})<br />{/if}
    
    {if -1 != $source}
      {if $type == 'Dropdown'}
		    <select name="{$actionid}customfield[{$fielddef->GetId()}]">
		      {html_options options=$opts selected=$sel}
		    </select>
      {elseif $type == 'MultiSelect'}
        <select name="{$actionid}customfield[{$fielddef->GetId()}][]}" size="{$opts|count}" multiple>
          {html_options options=$opts selected=$sel}
        </select>      
      {elseif $type == 'RadioGroup'}
        {html_radios name="{$actionid}customfield[{$fielddef->GetId()}]" options=$opts selected=$sel separator='<br />'}
      {elseif $type == 'CheckboxGroup'}
        {html_checkboxes name="{$actionid}customfield[{$fielddef->GetId()}]" options=$opts selected=$sel separator='<br />'}
      {/if}
    {/if}
	</p>
</div>