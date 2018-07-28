<h3>{$mod->Lang('generate_module_checksums')}</h3>

<table class="pagetable">
  <thead>
    <tr>
      <th>{lang('name')}:</th>
      <th>{lang('version')}:</th>
      <th>{$mod->Lang('has_checksum_data')}</th>
      <th class="pageicon"></th>
    </tr>
  </thead>
  <tbody>
  {foreach $module_list as $rec}
    <tr>
      <td>{$rec.name}</td>
      <td>{$rec.version}</td>
      <td>
        {if $rec.has_checksum}{cgimage image='icons/system/true.gif'}{/if}
      </td>
      <td>
        {if $rec.has_checksum}
	{else}
	  <a href="{$rec.generate_url}">{cgimage image='icons/system/run.gif' alt=$mod->Lang('generate')}</a>
	{/if}
      </td>
    </tr>
  {/foreach}
  </tbody>
</table>