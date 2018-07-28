<table cellspacing="0" class="pagetable">
  <thead>
    <tr>
      <th width="5%">{$idtext}</th>
      <th>{$nametext}</th>
      <th class="pageicon">&nbsp;</th>
      <th class="pageicon">{$defaulttext}</th>
      <th class="pageicon">&nbsp;</th>
      <th class="pageicon">&nbsp;</th>
    </tr>
  </thead>
  <tbody>
  {foreach from=$maplist item='map'}
    {cycle values='row1,row2' assign='rowclass'}
    <tr class="{$rowclass}" onmouseover="this.className='{$rowclass}hover';" onmouseout="this.className='{$rowclass}';">
      <td>{$map->map_id}</td>
      <td><a href="{$map->edit_url}">{$map->name}</a></td>
      <td>{if isset($map->points_link)}{$map->points_link}{else}&nbsp;{/if}</td>
      <td>{if isset($map->default_link)}{$map->default_link}{else}&nbsp;{/if}</td>
      <td>{if isset($map->edit_link)}{$map->edit_link}{else}&nbsp;{/if}</td>
      <td>{if isset($map->delete_link)}{$map->delete_link}{else}&nbsp;{/if}</td>
    </tr>
  {/foreach}
  </tbody>
</table>

<p class="pageoverflow">
{$add_link}
</p>