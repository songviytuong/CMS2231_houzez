<h3>{$mod->Lang('contents_of_file')}: {$filename}</h3>
<p>{$mod->Lang('info_scanned_file')}</p>

<script type="text/javascript">
{literal}
function display_import_btn()
{
  var n = jQuery(':checked.import_row').length;
  if( n > 0 ) {
    jQuery('.import_btn').show();
  }
  else {
    jQuery('.import_btn').hide();
  }
}

function display_name_boxes()
{
   jQuery(':checkbox.import_row').each(function(){
     var un = jQuery(this).val();
     var sel = jQuery(this).closest('tr').find('.new_name_text')
     if( jQuery(this).is(':checked') ) {
	jQuery(sel).show();
     }
     else {
        jQuery(sel).hide();
     }
   });
}

jQuery(document).ready(function(){
  display_import_btn();
  display_name_boxes();

  jQuery(':checkbox.import_row').click(function(){
    display_name_boxes();
    display_import_btn();
  });

  jQuery('#sel_all').click(function(){
    jQuery(':checkbox').attr('checked', jQuery(this).is(':checked'))
    display_import_btn();
    display_name_boxes();
  });
});
{/literal}
</script>

{if $num_available == 0}
{cge_admin_error error=$mod->Lang('error_nothingtoimport')}
{/if}

{$formstart}
<input type="hidden" name="{$actionid}filename" value="{$filename}"/>

<div class="pageoverflow">
  <p class="pagetext"></p>
  <p class="pageinput">
    <input type="submit" id="import_btn" name="{$actionid}import" class="pagebutton import_btn" value="{$mod->Lang('next')}"/>
    <input type="submit" name="{$actionid}cancel" class="pagebutton" value="{$mod->Lang('cancel')}"/>
  </p>
</div>

<table width="100" cellspacing="0" class="pagetable">
 <thead>
  <tr>
    <th>{$mod->Lang('type')}</th>
    <th>{$mod->Lang('module')}</th>
    <th>{$mod->Lang('name')}</th>
    <th>{$mod->Lang('import_name')}</th>
    <th class="pageicon">{$mod->Lang('preview')}</th>
    <th class="pageicon">{if $num_available gt 0}<input type="checkbox" name="sel_all" id="sel_all" value="1"/>{/if}</th>
  </tr>
 </thead>

 <tbody>
 {foreach from=$scanned_data name='scanned_data' item='row'}
  <tr {if $row.available == 0}style="background-color: pink;"{/if}>
    <td>{$mod->Lang($row.type)}</td>
    <td>{if isset($row.module)}{$row.module|default:''}{/if}</td>
    <td>{$row.name}</td>
    <td>
      {if $row.available == 1}
        <input type="text" name="{$actionid}new_name[{$row.uniqueid}]" value="{$row.new_name|default:''}" size="40" maxlength="40" class="new_name_text"/>
      {/if}
    </td>
    <td align="center">{module_action_link module='CGContentUtils' action='admin_preview' file=$filename type=$row.type name=$row.name image='icons/system/view.gif' imageonly=1}</td>
    <td>{if isset($row.available) && $row.available == 1}<input type="checkbox" class="import_row" name="{$actionid}import_item[]" value="{$row.uniqueid}">{/if}</td>
  </tr>
 {/foreach}
 </tbody>
</table>

<div class="pageoverflow">
  <p class="pagetext"></p>
  <p class="pageinput">
    <input type="submit" id="import_btn" name="{$actionid}import" class="pagebutton import_btn" value="{$mod->Lang('next')}"/>
    <input type="submit" name="{$actionid}cancel" class="pagebutton" value="{$mod->Lang('cancel')}"/>
  </p>
</div>
{$formend}