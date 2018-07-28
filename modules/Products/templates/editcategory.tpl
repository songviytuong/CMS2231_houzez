<script>
$(function(){
   $('#editcategoryfields').click(function(ev){
      ev.preventDefault();
      var url = '{cms_action_url action=editcategoryfields catid=$category.id forjs=1}';
      window.location.href = url;
   })
})
</script>

{if empty($hidden)}
<h3>{$mod->Lang('addcategory')}</h3>
{else}
<h3>{$mod->Lang('edit_category')}</h3>
{/if}

{form_start action=editcategory catid=$category.id}
<div class="c_full cf">
  <input type="submit" name="{$actionid}submit" value="{$mod->Lang('submit')}"/>
  <input type="submit" id="editcategoryfields" value="{$mod->Lang('edit_fields')}" title="{$mod->Lang('edit_category_fields',$category.name)}">
  <input type="submit" name="{$actionid}cancel" value="{$mod->Lang('cancel')}" formnovalidate/>
</div>
<div class="c_full cf">
  <label class="grid_2">{$mod->Lang('name')}:</label>
  <input class="grid_9" name="{$actionid}name" value="{$category.name}" maxlength="255" required/>
</div>
{form_end}
