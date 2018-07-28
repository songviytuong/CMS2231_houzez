<h3>{$mod->Lang('title_import_report')}</h3>


{if isset($errors)}
  <div class="pageerrorcontainer">
  <ul>
  {foreach from=$errors item='one'}
    <li>{$one}</li>
  {/foreach}
  </ul>
  </div>
{/if}

<div class="pageoverflow">
  <table class="pagetable" border="0">
    <tr>
      <td>{$mod->Lang('prompt_companies_imported')}:</td>
      <td align="left">{$num_companies}</td>
    </tr>
    <tr>
      <td>{$mod->Lang('prompt_fielddefs_imported')}:</td>
      <td align="left">{$num_fielddefs}</td>
    </tr>
    <tr>
      <td>{$mod->Lang('prompt_categories_imported')}:</td>
      <td align="left">{$num_categories}</td>
    </tr>
    <tr>
      <td>{$mod->Lang('prompt_hierarchies_imported')}:</td>
      <td align="left">{$num_hier}</td>
    </tr>
  </table>
</div>

<div class="pageoverflow">
  <p class="pageinput">
    <a href="{$return_url}" title="{$mod->Lang('return')}">{$mod->Lang('return')}</a>
  </p>
</div>