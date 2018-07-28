{* search statistics summary view *}

{* usage: {expand_dd_selected options=array_options selected=$selected_keys *}
{function expand_dd_selected}
  {if is_array($selected) || $selected != ''}
    {if !is_array($selected)}{$selected=[$selected]}{/if}
    {$vals=[]}
    {foreach $selected as $one}
      {$vals[]=$options[$one]}
    {/foreach}
    {implode(', ',$vals)}
  {/if}
{/function}

{if isset($searches)}
  {* todo: navigation stuff here *}
  <table>
    <thead>
      <tr>
        <th>{$mod->Lang('search_date')}</th>
        <th>{$mod->Lang('search_ip')}</th>
        <th>{$mod->Lang('search_name')}</th>
        <th>{$mod->Lang('search_address')}</th>
        <th>{$mod->Lang('search_postal')}</th>
        <th>{$mod->Lang('search_hier')}</th>
        <th>{$mod->Lang('search_categories')}</th>
        <th>Mining: {* a dropdown custom field *}</th>
        <th>ms1: {* a multiselect custom field *}</th>
      </td>
    </thead>
    <tbody>
    {foreach $searches as $search}
      <tr>
        <td>{$search.date_searched}</td>
        <td>{$search.ip_address}</td>
        <td>{$search.vals.name|default:''}</td>
        <td>{$search.vals.adddress|default:''}</td>
        <td>{$search.vals.postal|default:''}</td>
        <td>
           {if isset($search.vals.hier)}
             {$hierarchies[$search.vals.hier]}
           {/if}
        </td>
        <td>
          {if isset($search.vals.category)}
            {foreach $search.vals.category as $catid}
              {$cats2[]=$categories[$search.vals.category]}
            {/foreach}
            {implode(', ',$cats2)}
          {/if}
        </td>
        <td>{expand_dd_selected options=$fields.Mining.options selected=$search.vals.field_Mining|default:''}</td>
        <td>{expand_dd_selected options=$fields.ms1.options selected=$search.vals.field_ms1|default:''}</td>
      </tr>
    {/foreach}
    </tbody>
  </table>
{/if}