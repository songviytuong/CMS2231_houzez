<h3>{$mod->Lang('verify_module_integrity')}:</h3>

<div class="pageoptions">
  <a href="{$return_url}">{cgimage image='icons/system/back.gif' alt=$mod->Lang('return')} {$mod->Lang('return')}</a>
</div>

<table class="pagetable">
  <thead>
    <tr>
      <th>{lang('module')}</th>
      <th>{lang('version')}</th>
      <th>{lang('status')}</th>
      <th><span title="{$mod->Lang('title_vrfy_checksum')}">{$mod->Lang('checksum')}</th>
    </tr>
  </thead>
  <tbody>
  {foreach $report_data as $row}
    {cycle values='row1,row2' assign='rowclass'}
    <tr class="{$rowclass}">
      <td>{$row.module}</td>
      <td>{$row.version}</td>
      <td>
        {if $row.status == -1}
	  {cgimage image='icons/system/warning.gif' alt=$mod->Lang('stat_vrfy_nodata')}
	{elseif $row.status == 0}
	  {cgimage image='icons/system/stop.gif' alt=$mod->Lang('stat_vrfy_failed')}
	{elseif $row.status == 1}
	  {cgimage image='icons/system/true.gif' alt=$mod->Lang('stat_vrfy_passed')}
        {/if}
      <td style="font-family: monospace;">{$row.checksum}</td>
    </tr>
    {if $row.message}
    <tr class="{$rowclass}">
      <td></td>
      <td colspan="3">{$row.message}</td>
    </tr>
    {/if}
  {/foreach}
  </tbody>
</table>
