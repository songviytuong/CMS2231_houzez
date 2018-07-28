{$type = $fielddef->GetOptionValue('type')}
{$opts = $fielddef->GetFEUUserList()}
{$sel = $fielddef->GetValue()}
<div class="pageoverflow">
	<p class="pagetext">{$fielddef->GetName()}{if $fielddef->IsRequired()}*{/if}:</p>
	<p class="pageinput">
		{if $fielddef->GetDesc()}({$fielddef->GetDesc()})<br />{/if}
    {if $type == 'Dropdown'}        
      {html_options name="{$actionid}customfield[{$fielddef->GetId()}]" options=$opts selected=$sel}
    {/if}    
    {if $type == 'RadioGroup'}
      {html_radios name="{$actionid}customfield[{$fielddef->GetId()}]" options=$opts selected=$sel separator='<br />'}
    {/if}          
    {if $type == 'JQueryMultiSelect'}
      <div class="ms-container">
        <select id="{$actionid}customfield{$fielddef->GetId()}" name="{$actionid}customfield[{$fielddef->GetId()}][]}" size="{$opts|count}" multiple> 
          {html_options options=$opts selected=$sel}
        </select>
      </div> 
      <script type="text/javascript">
            // dirty hack to avoid recursion...
            window.ms_des = true;
            $('#{$actionid}customfield{$fielddef->GetId()}').multiSelect({
                 afterSelect: function(values){
                   if(window.ms_des){
                         $('#{$actionid}customfield{$fielddef->GetId()}').multiSelect('deselect_all');
                         window.ms_des = false;
                         $('#{$actionid}customfield{$fielddef->GetId()}').multiSelect('select', values);
                        }else{
                          window.ms_des = true;
                        }
                 }    
            });
      </script>
    {/if}
	</p>
</div>