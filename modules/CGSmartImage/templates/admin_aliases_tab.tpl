<p>{$mod->Lang('info_aliases')}</p>

<script type="text/javascript">{literal}
$(document).ready(function(){
  $('#alias_table tr:last').find('img').hide();
  $('#add_row').click(function(){
    var new_row = $('#alias_table tr:last').clone(true);
    $('#alias_table tr:last').find('img').show();
    new_row.find(':input').each(function(){
      $(this).val('');
    });
    $('#alias_table tbody').append(new_row);
    return false;
  });

  $('img.deleterow').click(function(){
    if( $('#alias_table tr').length <= 2 ) return false;
    $(this).closest('tr').remove();   
  });
});
{/literal}</script>

{$formstart}
<table class="pagetable pageinput" cellspacing="0" id="alias_table">
  <thead>
    <tr>
      <th>{$mod->Lang('alias')}</th>
      <th>{$mod->Lang('options')}</th>
      <th class="pageicon"></th>
    </tr>
  </thead>
  <tbody>
{if isset($aliases)}
{foreach from=$aliases item='alias'}
    <tr>
      <td>
        <input type="text" name="{$actionid}alias_name[]" value="{$alias.name|htmlspecialchars}" size="20" maxlength="50"/>
      </td>
      <td>
        <input type="text" name="{$actionid}alias_options[]" value="{$alias.options|htmlspecialchars}" size="60" maxlength="255"/>
      </td>
      <td>
        {cgimage class='deleterow' image='icons/system/delete.gif' alt=$mod->Lang('delete')}
      </td>
    </tr>
{/foreach}
{/if}
    {* empty row *}
    <tr>
      <td>
        <input type="text" name="{$actionid}alias_name[]" value="" size="20" maxlength="50"/>
      </td>
      <td>
        <input type="text" name="{$actionid}alias_options[]" value="" size="60" maxlength="255"/>
      </td>
      <td>
        {cgimage class='deleterow' image='icons/system/delete.gif' alt=$mod->Lang('delete')}
      </td>
    </tr>
  </tbody>
</table>

<div class="pageoverflow">
  <p class="pagetext"></p>
  <p class="pageinput">
    <input type="submit" name="{$actionid}submit" value="{$mod->Lang('submit')}"/>
    <input type="submit" id="add_row" name="{$actionid}add_row" value="{$mod->Lang('add_row')}"/>
  </p>
</div>
{$formend}