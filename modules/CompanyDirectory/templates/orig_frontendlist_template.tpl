{* template to list a particular users companies and optionally allow editing *}
<div id="compdir_frontend_list">
{if isset($records)}
  {$tmp=[]}
  {foreach $records as $onerecord}
    {$tmp[]=$onerecord.id}
  {/foreach}
  {cd_searchstats list=$tmp assign='searchhits'}
{/if}

{if isset($fe_add_url)}
<div class="navbar navbar-default" role="navigation">
  <a type="button" class="btn btn-default navbar-btn" href="{$fe_add_url}">
     <span class="glyphicon glyphicon-plus"></span> {$mod->Lang('addcompany')}
  </a>
  {if isset($fe_import_url)}
    <a type="button" class="btn btn-default navbar-btn" href="{$fe_import_url}">
      <span class="glyphicon glyphicon-import"></span> {$mod->Lang('importcsv')}
    </a>
  {/if}
</div>
{/if}

{if isset($records)}
  <table class="table">
    <thead>
      <tr>
        <th>{$mod->Lang('id')}</th>
        <th>{$mod->Lang('name')}</th>
        <th>{$mod->Lang('status')}</th>
        <th>{$mod->Lang('created')}</th>
        <th>{$mod->Lang('modified')}</th>
        <th>{$mod->Lang('searches')}</th>
        {if $have_album}<th class="icon"></th>{/if}
        <th class="icon"></th>
        {if $frontend_delete}<th class="icon"></th>{/if}
      </tr>
    </thead>
    <tbody>
    {foreach from=$records item='onerecord'}
      <tr>
        <td>{$onerecord.id}</td>
        <td>{$onerecord.company_name}</td>
        <td>{$mod->Lang($onerecord.status)}</td>
        <td>{$onerecord.create_date|cms_date_format}</td>
        <td>{$onerecord.modified_date|cms_date_format}</td>
        <td>{$num=$searchhits[$onerecord.id]}
          {if $num > 0}
            {module_action_link action='searchstats' companyid=$onerecord.id urlonly=1 assign='searchstats_url'}
            <a href="{$searchstats_url}">{$num}</a>
          {else}
            {$num|default:0}
          {/if}
        </td>
        {if $have_album}<td><a href="{$onerecord.gallery_url}">{$mod->Lang('album')}</a></td>{/if}
        <td><a href="{$onerecord.edit_url}"><span class="glyphicon glyphicon-edit" title="{$mod->Lang('edit')}"></span></a></td>
        {if $frontend_delete}<td><a href="{$onerecord.delete_url}"><span class="glyphicon glyphicon-remove" title="{$mod->Lang('delete')}"></a></td>{/if}
      </tr>
    {/foreach}
    </tbody>
  </table>
{/if}
</div>