{* map template *}
{* inline css styles are just for example purposes *}
<style type="text/css">
.infoBox {
  padding: 0.5em;
  border: 1px solid-black;
  background-color: yellow;
}
.m_tooltip {
  padding: 0.5em;
  border: 1px solid-black;
  border-radius: 3px;
  background-color: white;
}
</style>

{* this should be only done once *}
<script type="text/javascript" src="//maps.google.com/maps/api/js?libraries=geometry&key={$apikey|default:''}"></script>
<script type="text/javascript" src="{$mod->GetModuleURLPath()}/lib/js/infobox_packed.js"></script>
<script type="text/javascript" src="{$mod->GetModuleURLPath()}/lib/js/map_tooltip.js"></script>
<script type="text/javascript" src="{$mod->GetModuleURLPath()}/lib/js/jquery.cggm_map.js"></script>

{* this is where the map will be displayed *}
<div id="cggm_map_{$mapinstance}" style="height: 500px; width: 500px;">
</div>
<div class="cggm2_markers" style="display: none;">
  {* a sample marker statically declared.... note.  you must supply a latitude and longitude using this method
  <div class="cggm2_marker">
    <input type="hidden" class="cggm2_marker_name" value="vancouver"/>
    <input type="hidden" class="cggm2_marker_title" value="Vancouver, BC"/>
    <input type="hidden" class="cggm2_marker_tooltip" value="Vancouver, BC!!"/>
    <input type="hidden" class="cggm2_marker_icon" value="food"/>
    <input type="hidden" class="cggm2_marker_latitude" value="49.250000"/>
    <input type="hidden" class="cggm2_marker_longitude" value="-123.1000"/>
    <div class="cggm2_marker_desc">
      <p><strong>Note:</strong> This is a test about vancouver!</p>
    </div>
  </div>
  *}
</div>

{if $map->directions}
  {* enable directions *}
  {$generator->get_directions_form()}
{/if}

{* javascript is on the bottom incase some smarty variables we need were set in the various generator calls *}
<script type="text/javascript">
if( typeof(jQuery) == 'undefined' ) {
  var div = document.getElementById('cggm_map_{$mapinstance}').
  div.innerHTML = '<h3 style="color: red;">jQuery and jQuery UI Are Required</h3>';
  throw new Error('jQuery and jQuery UI Are Required');
}
$(document).ready(function(){
  var obj = $('#cggm_map_{$mapinstance}');
  obj.cggm2({$generator->get_map_options_js()});
  {if $map->directions && isset($directions_form_id)}$obj.cggm2('options','directions_form','#{$directions_form_id}');{/if}
});
</script>
