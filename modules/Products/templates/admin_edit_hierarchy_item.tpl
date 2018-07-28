<script type="text/javascript">{literal}
$(document).ready(function(){
  $('a.popup_image').fancybox();
});
{/literal}</script>
{if isset($hier_rec.id)}
<h3>{$mod->Lang('edit_hierarchy_item')}</h3>
{else}
<h3>{$mod->Lang('add_hierarchy_item')}</h3>
{/if}

{form_start hierarchy_id=$hier_rec.id}
<div class="c_full cf">
  <input type="submit" name="{$actionid}submit" value="{$mod->Lang('submit')}">&nbsp;<input type="submit" name="{$actionid}cancel" value="{$mod->Lang('cancel')}">
</div>
<hr/>

<h4>{$mod->Lang('main')}</h4>
<div class="c_full cf">
  <label class="grid_2">{$mod->Lang('name')}</label>
  <input class="grid_9" type="text" name="{$actionid}name" value="{$hier_rec.name}" maxlength="255"></p>
</div>
<div class="c_full cf">
  <label class="grid_2">{$mod->Lang('parent')}</label>
  <select class="grid_9" name="{$actionid}parent_id">{html_options options=$hierarchy_items selected=$hier_rec.parent_id}</select>
</div>
<hr/>

<h4>{$mod->Lang('description')}</h4>
<div class="pageoverflow">
  <div class="pageinput">
    {cge_wysiwyg prefix=$actionid name=description value=$hier_rec.description class="grid_9"}
  </div>
</div>
<hr/>

<h4>{$mod->Lang('imagetext')}</h4>
<div class="c_full cf">
  <div class="grid_12">
     {if !empty($hier_rec.image) && $hier_rec.image != '0' && !empty($image_url)}
     <p class="grid_12">
       {$mod->Lang('current_value')}: <a class="popup_image" href="{$image_url}">{$hier_rec.image}</a>
       {$mod->Lang('delete')}:<input type="checkbox" name="{$actionid}deleteimg" value="1">
     </p>
     {/if}
     <input class="grid_12" type="file" name="{$actionid}image" size="50" maxlength="255">
  </div>
</div>
<hr/>

<h4>{$mod->Lang('extra_info')}</h4>
<div class="c_full cf">
  <label class="grid_2">{$mod->Lang('extra1')}</label>
  <p class="pageinput"><input type="text" name="{$actionid}extra1" value="{$hier_rec.extra1}" size="50" maxlength="255"></p>
</div>
<div class="c_full cf">
  <label class="grid_2">{$mod->Lang('extra2')}</label>
  <p class="pageinput"><input type="text" name="{$actionid}extra2" value="{$hier_rec.extra2}" size="50" maxlength="255"></p>
</div>

{form_end}