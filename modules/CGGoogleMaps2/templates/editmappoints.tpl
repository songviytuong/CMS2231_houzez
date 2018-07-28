<h3>{$title}</h3>
<table cellspacing="0" class="pagetable">
  <thead>
    <tr>
      <th class="pageicon">{$idtext}</th>
      <th>{$nametext}</th>
      <th>{$locationtext}</th>
      <th class="pageicon">&nbsp;</th>
      <th class="pageicon">&nbsp;</th>
      <th class="pageicon">&nbsp;</th>
    </tr>
  </thead>
  <tbody>
  {foreach from=$pointlist item='point'}
    {cycle values='row1,row2' assign='rowclass'}
    <tr class="{$rowclass}" onmouseover="this.className='{$rowclass}hover';" onmouseout="this.className='{$rowclass}';">
      <td>{$point->marker_id}</td>
      <td><a href="{$point->edit_url}" title="{$mod->Lang('edit')}">{$point->name}</a></td>
      <td>{if !empty($point->lat) && !empty($point->lon)}
            {$point->lat},&nbsp;{$point->lon}
          {else}
            {$point->address}
          {/if}
      </td>
      <td>{if !empty($point->icon)}<img src="{$mod->GetModuleURLPath()}/icons/{$point->icon}.png" alt="{$point->icon}" width="16" height="16">{/if}</td>
      <td>{$point->edit_link}</td>
      <td>{$point->delete_link}</td>
    </tr>
  {/foreach}
  </tbody>
</table>
<br/>
<p class="pageoverflow">
  {$add_link}
</p>