{if $field.id}
<h3>{$mod->Lang('editfielddef')}</h3>
{else}
<h3>{$mod->Lang('addfielddef')}</h3>
{/if}

<script>
$(function(){
   var cancelled;
   var orig_type = $('#type').val();
   $('#type').change(function(){
       var val = $(this).val();
       $('[data-type]').each(function(){
           var dat = $(this).data('type');
	   if( dat != val ) {
	       $(this).hide();
           } else {
               $(this).show();
	   }
       })
   })

   $('#editfielddef').submit(function(ev){
      if( cancelled ) return true;
      var val = $('#type').val();
      if( (orig_type == 'file' || orig_type == 'image') && val != orig_type ) {
          ev.preventDefault();
	  alert('{$mod->Lang('warn_change_fieldtype')}');
      }
      return true;
   })
   $('#cancel').click(function(){
      cancelled = 1;
   })
   $('#type').trigger('change');
})
</script>

{form_start fdid=$field.id id="editfielddef"}
<div class="c_full cf">
  <label class="grid_2">*{$mod->Lang('name')}:</label>
  <div class="grid_9">
     <input class="grid_12" name="{$actionid}name" value="{$field.name}" maxlength="255" required/>
     <p class="grid_12">{$mod->Lang('info_alnumonly')}</p>
  </div>
</div>

<div class="c_full cf">
  <label class="grid_2">*{$mod->Lang('prompt')}:</label>
  <div class="grid_9">
    <input class="grid_12" name="{$actionid}prompt" value="{$field.prompt}" maxlength="255" required/>
  </div>
</div>

<div class="c_full cf">
  <label class="grid_2">*{$mod->Lang('type')}:</label>
  <div class="grid_9">
    <select class="grid_12" id="type" name="{$actionid}type">{html_options options=$types selected=$field.type}</select>
  </div>
</div>

<div class="c_full cf" data-type="textbox" style="display: none;">
  <label class="grid_2">*{$mod->Lang('maxlength')}:</label>
  <div class="grid_9">
    <input class="grid_12" type="text" name="{$actionid}max_length" value="{$field.max_length}"/>
  </div>
</div>

<div class="c_full cf" data-type="dropdown" style="display: none;">
  <label class="grid_2">*{$mod->Lang('dropdown_options')}:</label>
  <div class="grid_9">
    <textarea class="grid_12" rows="5" name="{$actionid}options">{$field.options}</textarea>
    <p class="grid_12">{$mod->Lang('info_dropdown_options')}</p>
  </div>
</div>

<div class="c_full cf">
  <label class="grid_2">*{$mod->Lang('public')}:</label>
  <div class="grid_9">
    <label class="grid_12"><input type="checkbox" name="{$actionid}public" value="1" {if $field.public}checked{/if}/></label>
    <p class="grid_12">{$mod->Lang('info_publicfield')}</p>
  </div>
</div>

<div class="c_full cf">
  <input type="submit" name="{$actionid}submit" value="{$mod->Lang('submit')}"/>
  <input type="submit" name="{$actionid}cancel" value="{$mod->Lang('cancel')}" id="cancel" formnovalidate/>
</div>
{form_end}
