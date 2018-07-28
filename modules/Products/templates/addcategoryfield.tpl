<script type="text/javascript">
$(function(){
   $('#fldtype').change(function(){
      var _t = $(this).val();
      if( _t == 'file' || _t == 'image' ) {
          $('#fldval').prop('type','file');
      } else {
          $('#fldval').prop('type','text');
      }
   })
})
</script>

<h3>{$mod->Lang('add_category_field',$category.name)}</h3>

{form_start catid=$catid fldname=$fieldname}
<div class="c_full cf">
  <label class="grid_2">{$mod->Lang('type')}:</label>
  <select class="grid_9" id="fldtype" name="{$actionid}input_fieldtype">{html_options options=$fieldtypes selected=$fieldtype}</select>
</div>
<div class="c_full cf">
  <label class="grid_2">{$mod->Lang('name')}:</label>
  <input class="grid_9" name="{$actionid}input_fieldname" value="{$fieldname}"/>
</div>
<div class="c_full cf">
  <label class="grid_2">{$mod->Lang('prompt')}:</label>
  <input class="grid_9" name="{$actionid}input_fieldprompt" value="{$fieldprompt}" maxlength="255"/>
</div>
<div class="c_full cf">
  <label class="grid_2">{$mod->Lang('value')}:</label>
  {if $fieldtype == 'file' || $fieldtype == 'image'}
    <input class="grid_9" type="file" name="{$actionid}input_fieldvalue" value="{$fieldvalue}"/>
    <div class="grid_2">&nbsp;</div>
    <div class="grid_9">{$mod->Lang('current_value')}:&nbsp;{$fieldvalue}
      {if isset($fileexists)}&nbsp;{$mod->Lang('valid')}{else}<em>({$mod->Lang('error_filenotfound')})</em>{/if}
    </div>
  {else}
    <input id="fldval" class="grid_9" type="text" name="{$actionid}input_fieldvalue" value="{$fieldvalue}"/>
  {/if}
</div>

<div class="c_full cf">
  <input type="submit" name="{$actionid}submit" value="{$mod->Lang('submit')}"/>
  <input type="submit" name="{$actionid}cancel" value="{$mod->Lang('cancel')}" formnovalidate/>
</div>
{form_end}