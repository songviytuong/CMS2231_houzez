<style>
#attrib_table tbody tr {
   cursor: move;
}
</style>

<h3>{$mod->Lang('edit_options')}</h3>
<h4>{$product->name} // {$product->sku} // ({$product->id})</h4>

<script type="text/javascript">
$(document).ready(function(){
  // move the skel row to a hidden div.
  var e = $('<div style="display: none;"></div>');
  $('body').append(e);
  var skel = $('#skel_row');
  skel.remove();
  e.append(skel);

  $('#attrib_table > tbody').sortable({
    cursor: 'move'
  });
  $('#add_option').click(function(){
    var e2 = skel.clone();
    e2.removeAttr('id').show();
    $('#attrib_table > tbody').append(e2);
  })
  $('.copy_option').live('click',function(){
    // find the preceding row.. and copy it.
    var tr = $(this).closest('tr');
    var clone = tr.clone();
    tr.after(clone);
  });
  $('.del_option').live('click',function(){
    var tbl = $(this).closest('table');
    var len = $('tbody tr',tbl).length;
    $(this).closest('tr').remove();
  });
  $('.edit_notes').live('click',function(){
    var a = $(this).closest('tr');
    var b = $('.notes',a);
    var idx = a.prevAll().length;
    $('#notes_idx').val(idx);
    $('#notes_txt').val(b.val());
    $('#notes_dialog').dialog({
      modal: true,
      width: 'auto',
      buttons: [
        { text: "{$mod->Lang('ok')}",
          click: function(){
	    var txt = $('#notes_txt').val();
	    var idx = $('#notes_idx').val();
  	    $('#attrib_table tbody tr').eq(idx).find('.notes').val(txt);
            $(this).dialog('close');
          }
        }
      ]
    });
  });

  $(document).on('click','#submit',function(){
    // don't remove the required attributes.
    var l = $('#attrib_table tbody tr').length;
    if( l == 1 ) {
      // if the text is empty, sku is empty, and the adjustment and qoh are 0
      // the we will delete the row and there will be no options
      // otherwise, require two rows.
      var row = $('#attrib_table > tbody > tr:first');
      var sku = $('input.option_sku',row).val();
      var txt = $('input.option_text',row).val();
      var adj = $('input.option_adj',row).val();
      var qoh = $('input.option_qoh',row).val();
      if( sku == '' && txt == '' && (adj == '' || adj == '0') && (qoh == '' || qoh == '0') ) {
        // empty row
	row.remove();
      }
      else {
        alert('{$mod->Lang('error_needtworows')}');
        return false;
      }
    }
  });

  $(document).on('click','#cancel',function(){
    // cancel, remove required attributes
    $(':input').removeAttr('required');
  });

  $(document).on('click','#copyattribs',function(){
    // copy from something else.
    if( confirm('{$mod->Lang('confirm_copyoptions')}') ) {
      $(':input').removeAttr('required');
      return true;
    }
    return false;
  });
});
</script>

<div id="notes_dialog" style="display: none;" title="{$mod->Lang('edit_option_notes')}">
  <div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('notes')}:</p>
    <p class="pageinput">
      <input type="hidden" id="notes_idx" value=""/>
      <textarea id="notes_txt" rows="5" columns="40"></textarea>
    </p>
  </div>
</div>
<div class="information" style="display: block;">{$mod->Lang('info_edit_product_options')}</div>
<div id="warn_edit_product_options" class="pagewarning" style="display: block;">{$mod->Lang('warn_edit_product_options')}</div>

<div class="pageoptions">
<a id="add_option">{cgimage image='icons/system/newobject.gif' alt=$mod->Lang('addoption') class='systemicon'} {$mod->Lang('addoption')}</a>
</div>
{$formstart}
<table class="pagetable" cellspacing="0" id="attrib_table">
  <thead>
    <tr>
      <th><span title="{$mod->Lang('title_sku')}">{if $sku_is_required}*{/if}{$mod->Lang('sku')}</span></th>
      <th><span title="{$mod->Lang('title_attribute_text')}">*{$mod->Lang('attrib_text')}</span></th>
      <th><span title="{$mod->Lang('title_adjustment')}">{$mod->Lang('price_adjustment')}</span></th>
      <th><span title="{$mod->Lang('title_qoh')}">{$mod->Lang('quantity_on_hand')}</span></th>
      <th class="pageicon"></th>
      <th class="pageicon"></th>
      <th class="pageicon"></th>
    </tr>
  </thead>
  <tbody>
    <tr id="skel_row" style="display: none;">
      <td><input type="text" class="option_sku" name="{$actionid}sku[]" value="{$skel_row->sku}" size="10" maxlength="25"  placeholder="{$mod->Lang('sku')}" {if $sku_is_required}required="required"{/if}/></td>
      <td><input type="text" class="option_text" name="{$actionid}text[]" value="{$skel_row->text}" size="80" maxlength="255" required="required" placeholder="{$mod->Lang('ph_optiontext')}"/></td>
      <td><input type="text" class="option_adj" name="{$actionid}adjustment[]" value="{$skel_row->adjustment}" size="10" maxlength="10"/></td>
      <td><input type="text" class="option_qoh" name="{$actionid}qoh[]" value="{$skel_row->qoh}" size="5" maxlength="5" value="0"/></td>
      <td><input type="hidden" class="notes" name="{$actionid}notes[]" value="{$skel_row->notes}"/>{cgimage image='icons/system/edit.gif' class="edit_notes" alt=$mod->Lang('edit_notes')}</td>
      <td>{cgimage image='icons/system/copy.gif' class="copy_option" alt=$mod->Lang('copy_attribute')}
      <td>{cgimage image='icons/system/delete.gif' class="del_option" alt=$mod->Lang('delete_attribute')}
    </tr>

  {foreach $attribs as $attrib}
    <tr id="attrib_{$attrib->id}">
      <td><input type="text" class="option_sku" name="{$actionid}sku[]" value="{$attrib->sku}" size="10" maxlength="25"  placeholder="{$mod->Lang('sku')}" {if $sku_is_required}required="required"{/if}/></td>
      <td><input type="text" class="option_text" name="{$actionid}text[]" value="{$attrib->text}" size="80" maxlength="255" required="required" placeholder="{$mod->Lang('ph_optiontext')}"/></td>
      <td><input type="text" class="option_adj" name="{$actionid}adjustment[]" value="{$attrib->adjustment}" size="10" maxlength="10"/></td>
      <td><input type="text" class="option_qoh" name="{$actionid}qoh[]" value="{$attrib->qoh}" size="5" maxlength="5"/></td>
      <td><input type="hidden" class="notes" name="{$actionid}notes[]" value="{$attrib->notes}"/>{cgimage image='icons/system/edit.gif' class="edit_notes" alt=$mod->Lang('edit_notes')}</td>
      <td>{cgimage image='icons/system/copy.gif' class="copy_option" alt=$mod->Lang('copy_attribute')}
      <td>{cgimage image='icons/system/delete.gif' class="del_option" alt=$mod->Lang('delete_attribute')}
    </tr>
  {/foreach}
  </tbody>
</table>
<div class="pageoptions">
{if isset($products_with_attribs)}
  <label for="copy_attribs_from">{$mod->Lang('copy_options_from')}:</label>&nbsp;
  <select id="copy_attribs_from" name="{$actionid}copyfrom">
    {html_options options=$products_with_attribs}
  </select>&nbsp;
  <input type="submit" id="copyattribs" name="{$actionid}copyattribs" value="{$mod->Lang('ok')}"/>
{/if}
</div>

<div class="pageoverflow">
  <p class="pagetext"></p>
  <p class="pageinput">
    <input type="submit" name="{$actionid}submit" id="submit" value="{$mod->Lang('submit')}"/>
    <input type="submit" name="{$actionid}cancel" id="cancel" value="{$mod->Lang('cancel')}"/>
  </p>
</div>
{$formend}