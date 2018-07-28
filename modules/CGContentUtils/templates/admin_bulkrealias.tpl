<script type="text/javascript">
$(document).ready(function(){
  $('#clear_all').click(function(){
     $('.newalias').val('');
  });
})
</script>

<h3>{$mod->Lang('title_bulkrealias')}</h3>
<div class="warning">{$mod->Lang('warn_bulkrealias')}</div>
<div class="information">{$mod->Lang('info_bulkrealias')}</div>

{form_start action='admin_bulkrealias'}
<div class="pageoverflow">
  <div class="pageinput" style="width: 51%; float: left;">
    <input type="submit" name="{$actionid}submit" value="{$mod->Lang('submit')}"/>
    <input type="submit" name="{$actionid}cancel" value="{$mod->Lang('cancel')}"/>
  </div>
  <div style="width: 49%; float: right; text-align: right;"><a id="clear_all">{$mod->Lang('clear_all')}</a></div>
</div>
<table id="realias_cont" class="pagetable">
  <thead>
    <tr>
      <th>{$mod->Lang('id')}</th>
      <th>{$mod->Lang('old_alias')}</th>
      <th>{$mod->Lang('new_alias')}</th>
    </tr>
  </thead>
  <tbody>
  {foreach $list as $row}
    <tr>
      <td>{$row.id}</td>
      <td>{$row.alias}</td>
      <td>
        <input type="text" class="newalias" name="{$actionid}aliases[{$row.id}]" value="{$row.alias}" placeholder="{$mod->Lang('new_alias')}"/>
      </td>
    </tr>
  {/foreach}
  </tbody>
</table>
{form_end}