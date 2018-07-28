{* statistics report template *}

{if $pagination.firstpage}
  <html>
  <head>
  </head>
  <body>
{/if}

{* page header goes here *}

{* report header *}
{if $pagination.firstpage}
<div style="width: 100%;">
  <h1 style="text-align: center; margin-bottom: 1.5em;">{$report_name}</h3>
  <div style="width: 50%; float: left;">
    {$report_description}
  </div>
  <div style="width: 49%; float: right; text-align: right; border: 1px solid black;">
    <h4>{$mod->Lang('generated_by')}: {if $user->lastname}{$user->lastname}, {$user->firstname}{else}{$user->username}{/if}</h4>
    {$mod->Lang('generated')}: {$smarty.now|cms_date_format}
  </div>
  </div style="clear: both;"></div>
</div>
<div style="margin-bottom: 3em;">&nbsp;</div>
{/if}

{* report body *}
<table width="100%" style="border: 1px; solid black;">
  <thead>
   <tr>
     <th align="left">{$mod->Lang('banner')}</th>
     <th align="left">{$mod->Lang('category')}</th>
     <th align="left">{$mod->Lang('url')}</th>
     <th align="left">{$mod->Lang('created')}</th>
     <th align="left">{$mod->Lang('expires')}</th>
     <th align="left">{$mod->Lang('impressions')}</th>
     <th align="left">{$mod->Lang('hits')}</th>
   </tr> 
  </thead>
  <tbody>
  {foreach from=$report_data item='row'}
   <tr>
     <td>{$row.name}</td>
     <td>{$row.category}</td>
     <td>{$row.url}</td>
     <td>{$row.created|cms_date_format:"%x"}</td>
     <td>{$row.expires|cms_date_format:"%x"}</td>
     <td>{$row.num_impressions}{if $row.num_impressions}/{$row.num_impressions}{/if}</td>
     <td>{$row.hits}</td>
   </tr>
  {/foreach}
  </tbody>
</table>

{* report footer *}
{if $pagination.lastpage}
  {* report footer goes here *}
{/if}

{* page footer *}
<div style="border: 1px. solid black; width: 30%; float: right; text-align: right; display: block; position: fixed; bottom: 0; ">
  {$mod->Lang('page')}&nbsp;{$pagination.pagenum}&nbsp;{$mod->Lang('of')}&nbsp;{$pagination.pagecount}
</div>

{if $pagination.lastpage}
  {* close off the report *}
  </body>
  </html>
{/if}