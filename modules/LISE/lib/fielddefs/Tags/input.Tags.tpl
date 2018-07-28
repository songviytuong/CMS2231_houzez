<div class="pageoverflow">
	<p class="pagetext">{$fielddef->GetName()}{if $fielddef->IsRequired()}*{/if}:</p>
	<p class="pageinput">
  <script>
      $(function(){ 
          $("input.tags").tagsInput({
            width:'auto'
          });
      });
  </script>
		{if $fielddef->GetDesc()}({$fielddef->GetDesc()})<br />{/if}
		<input type="text" class='tags' name="{$actionid}customfield[{$fielddef->GetId()}]" value="{$fielddef->GetValue()}" size="{$fielddef->GetOptionValue('size')}" maxlength="{$fielddef->GetOptionValue('max_length')}" />
	</p>
</div>