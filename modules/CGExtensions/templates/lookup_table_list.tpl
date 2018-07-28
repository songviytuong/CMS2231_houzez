<div class="pageoptions">
  <a href="{$add_url}">{cgimage image='icons/system/newobject.gif'} {cgex_lang('add_lkp_entry')}</a>
</div>

{if count($items)}
  <table class="pagetable">
    <thead>
      <tr>
        <th class="pageicon">{cgex_lang('id')}</th>
        <th>{cgex_lang('name')}</th>
        <th>{cgex_lang('description')}</th>
	<th class="pageicon">{* move *}</th>
	<th class="pageicon">{* move *}</th>
	<th class="pageicon">{* edit *}</th>
	<th class="pageicon">{* delete *}</th>
      </tr>
    </thead>
    <tbody>
    {foreach $items as $item}
      <tr>
        <td>{$item->id}</td>
        <td><a href="{$item->edit_url}" title="{cgex_lang('edit_lkpitem')}">{$item->name}</a></td>
        <td>{$item->description|summarize}</td>
	<td>
	   {if isset($item->up_url)}
	     <a href="{$item->up_url}">{cgimage image='icons/system/sort_up.gif' alt=cgex_lang('move_up')}</a>
	   {/if}
	</td>
	<td>
	   {if isset($item->down_url)}
	     <a href="{$item->down_url}">{cgimage image='icons/system/sort_down.gif' alt=cgex_lang('move_down')}</a>
	   {/if}
	</td>
	<td><a href="{$item->edit_url}">{cgimage image='icons/system/edit.gif' alt=cgex_lang('edit_lkpitem')}</a></td>
	<td><a href="{$item->del_url}" class="del_lkpitem">{cgimage image='icons/system/delete.gif' alt=cgex_lang('del_lkpitem')}</a></td>
      </tr>
    {/foreach}
    </tbody>
  </table>
{/if}