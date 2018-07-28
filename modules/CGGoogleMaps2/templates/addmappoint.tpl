<script type="text/javascript">
/*<![CDATA[*/
var iconsbyname = new Array();
{foreach from=$iconsbyname key='name' item='url'}
iconsbyname['{$name}'] = '../{$url}';
{/foreach}

$(document).ready(function(){
  $('#sel_icon').change(function(){
    var val = $(this).val();
    $('#img_icon').attr('src',iconsbyname[val]);
  });
  $('#point_type').change(function(){
    var val = $(this).val();
    if( val == 'addr' ) {
      $('#addr').show();
      $('#latlon').hide();
    } else {
      $('#addr').hide();
      $('#latlon').show();
    }
  });
});
/*]]> */
</script>

<h3>{$title}</h3>
{$formstart}{$hidden|default:''}
<p class="pageoverflow">
</p>
<div class="pageoverflow">
  <p class="pagetext">{$mod->Lang('point_name')}:</p>
  <p class="pageinput">
    <input type="text" name="{$actionid}title" value="{$marker->get_title()}" size="40" maxlength="80"/>
  </p>
</div>
<div class="pageoverflow">
  <p class="pagetext">{$mod->Lang('icon')}:</p>
  <p class="pageinput">
    <select id="sel_icon" name="{$actionid}icon">
      {html_options options=$icons selected=$sel_icon}
    </select>
    <img style="margin-top: 2px;" id="img_icon" src="../{$iconsbyname.$sel_icon}" alt=""/>
  </p>
</div>
<div class="pageoverflow">
  <p class="pagetext">{$mod->Lang('text')}:</p>
  <p class="pageinput">
    <textarea rows="5" cols="80" name="{$actionid}info">{$marker->get_description()}</textarea>
  </p>
</div>

<div class="pageoverflow">
  <p class="pagetext">{$mod->Lang('tooltip')}:</p>
  <p class="pageinput">
    <textarea rows="2" cols="60" name="{$actionid}tooltip">{$marker->get_tooltip()}</textarea>
  </p>
</div>

<div class="information">{$mod->Lang('info_address_latlong')}</div>

<div class="pageoverflow">
  <p class="pagetext">{$mod->Lang('point_type')}:</p>
  <p class="pageinput">
    <select id="point_type" name="point_type">
      <option value="addr">{$mod->Lang('address')}</option>
      <option value="latlon" {if !isset($point_address)}selected="selected"{/if}>{$mod->Lang('latlong')}</option>
    </select>
  </p>
</div>
<div id="addr" class="pageoverflow" {if !isset($point_address)}style="display: none;"{/if}>
  <p class="pagetext">{$mod->Lang('prompt_address')}:</p>
  <p class="pageinput">
    <input type="text" name="{$actionid}address" value="{$marker->get_address()}" size="100" maxlength="255" placeholder="{$mod->Lang('ph_address')}"/>
    <br/>{$mod->Lang('info_address')}
  </p>
</div>

<div id="latlon" {if isset($point_address)}style="display: none;"{/if}">
<div class="pageoverflow">
  <p class="pagetext">{$mod->Lang('latitude')}:</p>
  <p class="pageinput">
   <input type="text" name="{$actionid}latitude" value="{$marker->get_latitude()}" size="10" maxlength="15"/>
  </p>
</div>
<div class="pageoverflow">
  <p class="pagetext">{$mod->Lang('longitude')}:</p>
  <p class="pageinput">
   <input type="text" name="{$actionid}longitude" value="{$marker->get_longitude()}" size="10" maxlength="15"/>
  </p>
</div>
</div>

<div class="pageoverflow">
  <p class="pagetext">&nbsp;</p>
  <p class="pageinput">
    <input type="submit" name="{$actionid}submit" value="{$mod->Lang('submit')}"/>
    <input type="submit" name="{$actionid}cancel" value="{$mod->Lang('cancel')}"/>
  </p>
</div>
{$formend}