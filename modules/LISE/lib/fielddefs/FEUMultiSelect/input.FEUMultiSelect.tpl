{$type = $fielddef->GetOptionValue('type')}
{$opts = $fielddef->GetFEUUserList()}
{$sel = $fielddef->GetValue('array')}
<div class="pageoverflow">
	<p class="pagetext">{$fielddef->GetName()}{if $fielddef->IsRequired()}*{/if}:</p>
	<p class="pageinput">
		{if $fielddef->GetDesc()}({$fielddef->GetDesc()})<br />{/if}
    {if $type == 'MultiSelect'}
        <input type="hidden" name="{$actionid}customfield[{$fielddef->GetId()}]" value="" />
        <select name="{$actionid}customfield[{$fielddef->GetId()}][]}" size="{$opts|count}" multiple>        
          {html_options options=$opts selected=$sel}
        </select>  
    {/if}    
    {if $type == 'RadioGroup'}
      <input type="hidden" name="{$actionid}customfield[{$fielddef->GetId()}]" value="" />
      {html_radios name="{$actionid}customfield[{$fielddef->GetId()}]" options=$opts selected=$sel separator='<br />'}
    {/if}      
    {if $type == 'CheckboxGroup'}
      <input type="hidden" name="{$actionid}customfield[{$fielddef->GetId()}]" value="" />
      {html_checkboxes name="{$actionid}customfield[{$fielddef->GetId()}]" options=$opts selected=$sel separator='<br />'}
    {/if}    
    {if $type == 'JQueryMultiSelect'}
      <div class="ms-container">
        <input type="hidden" name="{$actionid}customfield[{$fielddef->GetId()}]" value="" />
        <select id="{$actionid}customfield{$fielddef->GetId()}" name="{$actionid}customfield[{$fielddef->GetId()}][]}" size="{$opts|count}" multiple>        
          {html_options options=$opts selected=$sel}
        </select>
      </div> 
      <script type="text/javascript">
            $('#{$actionid}customfield{$fielddef->GetId()}').multiSelect();
      </script>
    {/if}
	</p>
</div>