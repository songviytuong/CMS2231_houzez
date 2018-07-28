<script type="text/javascript">
function parseTree(ul) {
	var tags = [];
	ul.children("li").each(function(){
		var subtree =	$(this).children("ul");
		if(subtree.size() > 0)
			tags.push([$(this).attr("id"), parseTree(subtree)]);
		else
			tags.push($(this).attr("id"));
	});
	return tags;
}

$(document).ready(function() {
  $('ul.sortable').nestedSortable({
     disableNesting: 'no-nest',
     forcePlaceholderSize: true,
     handle: 'div',
     items: 'li',
     opacity: 6,
     placeholder: 'placeholder',
     tabSize: 35,
     tolerance: 'pointer',
     listType: 'ul',
     toleranceElement: '> div'
  });

  $('#submit_btn').live('click',function(){
     var tree = $.toJSON(parseTree($('ul.sortable')));
     $('#orderdata').val(tree);
  });

});
</script>

{function draw_hierarchy depth=0}
  <ul class="sortableList {if $depth==0}sortable{/if}">
  {foreach from=$items item='item'}
    {if $item.parent_id == -1}
      {assign var="depth" value="0"}
    {/if}
    <li id="hier_{$item.id}"><div class="label"><span>&nbsp;</span>{$item.name}</div>
      {if isset($item.children)}
        {draw_hierarchy depth=$depth+1 items=$item.children}
      {/if}
    </li>
  {/foreach}
  </ul>
{/function}

<h3>{$mod->Lang('reorder_hierarchy')}</h3>
<div class="pagetext">{$mod->Lang('info_reorder_content')}</div>
{$formstart}
<input type="hidden" name="{$actionid}orderdata" value="" id="orderdata"/>

<div class="pageoverflow">
  <div class="reorder-pages pageinput">
    {draw_hierarchy items=$tree}
  </div>
</div>

<div class="pageoverflow">
  <p class="pagetext"></p>
  <p class="pageinput">
    <input id="submit_btn" type="submit" name="{$actionid}submit" value="{$mod->Lang('submit')}"/>
    <input type="submit" name="{$actionid}cancel" value="{$mod->Lang('cancel')}"/>
  </p>
</div>
{$formend}
