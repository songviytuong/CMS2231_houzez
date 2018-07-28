<div class="pageoverflow">
	<p class="pagetext">{$fielddef->GetName()}{if $fielddef->IsRequired()}*{/if}:</p>
	<p class="pageinput">
		{if $fielddef->GetDesc()}({$fielddef->GetDesc()})<br />{/if}
    <div class="ms-container">
      <input type="hidden" name="{$actionid}customfield[{$fielddef->GetId()}]" value="" />
      <select id="{$actionid}customfield{$fielddef->GetId()}" name="{$actionid}customfield[{$fielddef->GetId()}][]}" size="{$fielddef->GetOptionValue('size', 5)}" multiple>
        {html_options options=$fielddef->GetOptions() selected=$fielddef->GetValue("array")}
		  </select>
    </div>
	</p>
</div>
<script type="text/javascript">
  $('#{$actionid}customfield{$fielddef->GetId()}').multiSelect();
</script>