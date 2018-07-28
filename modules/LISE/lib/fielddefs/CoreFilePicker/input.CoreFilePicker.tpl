<div class="pageoverflow">
	<p class="pagetext">{$fielddef->GetName()}{if $fielddef->IsRequired()}*{/if}:</p>
	<p class="pageinput">
    {cms_filepicker name="{$actionid}customfield[{$fielddef->GetId()}]" profile=$fielddef->GetOptionValue('profiles') value=$fielddef->GetValue() required=$fielddef->IsRequired()}
	</p>
</div>