<script type="text/javascript">
$(document).ready(function(){
  $('#expires_nv').change(function(){
    var v = $(this).is(':checked');
    if( v ) {
      $('#expires_ds :input').attr('disabled','disabled');
    } else {
      $('#expires_ds :input').removeAttr('disabled');
    }
  });
  $('#expires_nv').trigger('change');
})
</script>

<h3>{$mod->Lang('addbanner')}</h3>
<h4>{$mod->Lang('category')}: {$category_name|default:''}</h4>

{$startform}
  <div class="c_full cf">
     <input type="submit" name="{$actionid}submit" value="{$mod->Lang('submit')}"/>
     <input type="submit" name="{$actionid}cancel" value="{$mod->Lang('cancel')}"/>
  </div>
  <div class="c_full cf">
    <label class="grid_2">*{$mod->Lang('name')}:</label>
    <input type="text" name="{$actionid}input_bannername" value="{$banner->name}" class="grid_9"/>
  </div>
  <div class="c_full cf">
    <label class="grid_2">{$mod->Lang('description')}:</label>
    <input type="text" name="{$actionid}input_bannerdesc" value="{$banner->description}" class="grid_9"/>
  </div>
  <div class="c_full cf">
    <label class="grid_2">*{$mod->Lang('image')}:</label>
    <div class="grid_9">
      {cms_filepicker name="{$actionid}input_image" value="{$banner->image}"}
      <p>{$mod->Lang('info_image')}</p>
    </div>
  </div>
  <div class="c_full cf">
    <label class="grid_2">*{$mod->Lang('url')}:</label>
    <input type="text" name="{$actionid}input_url" value="{$banner->url}" class="grid_9"/>
  </div>
  <div class="c_full cf">
    <label class="grid_2">{$mod->Lang('max_impressions')}:</label>
    <p class="grid_9">
      <input type="text" name="{$actionid}input_max_impressions" value="{$banner->max_impressions}" size="3"/>
      {$mod->Lang('info_max_impressions')}
    </p>
  </div>
  <div class="c_full cf">
    <label class="grid_2">{$mod->Lang('expires')}</label>
    <p class="grid_9">
      <span id="expires_ds">
        {$tmp=$actionid|cat:'expiresdate_'}
        {html_select_date prefix=$tmp time=$banner->expires end_year="+10"}
      </span>
      <input type="hidden" name="{$actionid}input_neverexpires" value="0"/>
      <input id="expires_nv" type="checkbox" name="{$actionid}input_neverexpires" value="1" {if $banner->neverexpires}checked="checked"{/if}/> {$mod->Lang('never')}
    </p>
  </div>
  <div class="c_full cf">
    <label class="grid_2">{$mod->Lang('start_date')}:</label>
    <p class="grid_9">
      {$tmp=$actionid|cat:'startdate_'}
      {html_select_date prefix=$tmp time=$banner->start_date start_year="-2" end_year="+10"}
    </p>
  </div>
  <div class="c_full cf">
    <label class="grid_2">{$mod->Lang('href_text')}:</label>
    <p class="grid_9">
      <input type="text" name="{$actionid}input_href_text" size="80" value="{$banner->href_text}"/>
      {$mod->Lang('info_href_text')}
    </p>
  </div>
  <div class="c_full cf">
    <label class="grid_2">{$mod->Lang('image_text')}:</label>
    <p class="grid_9">
      <input type="text" name="{$actionid}input_image_text" size="80" value="{$banner->text}"/>
      {$mod->Lang('info_image_text')}
    </p>
  </div>
{$endform}
