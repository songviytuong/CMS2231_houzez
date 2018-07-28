{* display variable help *}
<fieldset>
  <legend>{$mod->Lang('title_templating_help')}</legend>
  <table class="pagetable">
  <thead>
    <tr>
      <th>{$mod->Lang('name')}</th>
      <th>{$mod->Lang('type')}</th>
      <th>{$mod->Lang('description')}</th>
    </tr>
  </thead>
  <tbody>
  {foreach $vars as $var}
    <tr class="{cycle values='row1,row2'}">
      <td>{$var->key}</td>
      <td>{$var->type|default:''}</td>
      <td>{$var->desc|default:''}</td>
    </tr>
  {/foreach}
  </tbody>
  </table>
</fieldset>