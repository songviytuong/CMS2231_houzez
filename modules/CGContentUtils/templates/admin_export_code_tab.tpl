{if isset($v2warning)}
<div class="warning" style="display: block;">{$mod->Lang('warn_v2')}</div>
{/if}
<div class="information">{$mod->Lang('info_export_code')}</div>

{literal}
<script type="text/javascript">
var ajax_url = '{/literal}{$ajax_url}{literal}';

function on_checkbox_click() {
  var selected = new Array();
  $('#avail_code').show();
  jQuery('input:checkbox:checked').each(function(){
    selected.push($(this).val());
  });

  xhr = $.post(ajax_url, { sel_items: selected }, function(retdata){
    eval('var templates ='+retdata);
    jQuery('#sel_templates').html('<option>{/literal}{$mod->Lang('loading')}{literal}</option>');
    var txt = '';
    if( templates.length ) {
      for( i = 0; i < templates.length; i++ ) {
	txt += '<option value="'+templates[i]+'">'+templates[i]+'</option>';
      }
    }
    jQuery('#sel_templates').html(txt);
  });
}

jQuery(document).ready(function(){
  ajax_url = ajax_url.replace(/amp;/g,'') + '&suppressoutput=1';

  jQuery('#sel_export').attr('disabled','disabled');

  jQuery('#sel_all').click(function(){
    var status = this.checked;
    jQuery('#sel_items_sub input:checkbox').each(function(){
       this.checked = status;
    });
    on_checkbox_click();
  });

  jQuery('#sel_items_sub :checkbox').click(function(){
    on_checkbox_click()
  });

  jQuery('#sel_templates').live('change',function(){
    var sel_templates = [];
    jQuery('#sel_templates :selected').each(function(i,selected){
      sel_templates[i] = jQuery(selected).val();
    });
    if( sel_templates.length > 0 ){
      jQuery('#sel_export').removeAttr('disabled');
      jQuery('#sel_export').button('enable');
    }
    else {
      jQuery('#sel_export').attr('disabled','disabled');
      jQuery('#sel_export').button('disable');
    }
  });

  jQuery('#export_sel_all').click(function(){
    var v = jQuery(this).is(':checked');
    if( v ) v = 'selected';
    jQuery('#sel_templates').each(function(){
      jQuery('#sel_templates option').attr('selected',v);
    });
    if( v == 'selected' ) {
      jQuery('#sel_export').removeAttr('disabled');
      jQuery('#sel_export').button('enable');
    }
    else {
      jQuery('#sel_export').attr('disabled','disabled');
      jQuery('#sel_export').button('disable');
    }
  });
});
</script>
{/literal}

{$formstart}
<table>
 <tr>
   <td width="40%">
     <fieldset id="sel_items">
     <legend>{$mod->Lang('sections')}: </legend>
       <p>{$mod->Lang('info_available_items')}</p>
       {capture assign='tmp'}{$actionid}sel_modules{/capture}
       <input type="checkbox" name="sel_all" id="sel_all" value="1"/><label for="sel_all">{$mod->Lang('select_all')}</label><br/><br/>
       <div id='sel_items_sub'>
       {if isset($module_list)}
         <h4>{$mod->Lang('modules')}:</h4>
         {html_checkboxes name=$tmp options=$module_list separator='<br/>'}
         <br/>
       {/if}
       {if isset($modify_udt)}
         <h4>{$mod->Lang('list_udts')}:</h4>
         <input type="checkbox" name="{$actionid}sel_modules" value="udt::"/>
         <label>{$mod->Lang('list_udts')}</label>
       {/if}
       </div>
     </fieldset>
   </td>
   <td valign="top">
     <fieldset id="avail_code" style="display: none;">
       <legend>{$mod->Lang('available_templates')}:</legend>
       <p class="pageoverflow">
          {$mod->Lang('select_all')}:
  	  <input type="checkbox" id="export_sel_all" name="export_sell_all" value="1"/>
       </p>
       <select id="sel_templates" name="{$actionid}sel_templates[]" multiple="multiple" size={$num_modules}"></select>
     </fieldset>
   </td>
 </tr>
</table>
<div class="pageoverflow">
  <p class="pagetext"></p>
  <p class="pageinput">
    <input type="submit" id="sel_export" name="export" value="{$mod->Lang('export')}"/>
  </p>
</div>
{$formend}