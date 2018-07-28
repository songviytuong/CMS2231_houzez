{* directions form template *}
{* this template is used when directions are enabled.  The default plugin calls the following 2 plugin methods:
   'getMarkerList' retrieves a list of the markers currently availablein the map.
   'getDirections' to get direction output
*}
<script type="text/javascript">
if( typeof(jQuery) == 'undefined' ) {
  var div = document.getElementById('cggm_map_{$mapinstance}').
  div.innerHTML = '<h3 style="color: red;">jQuery and jQuery UI Are Required</h3>';
  throw new Error('jQuery and jQuery UI Are Required');
}
$(document).ready(function(){
  $('#cggm_map_{$mapinstance}').on('cggm2update',function(){
    var locations = $('#cggm_map_{$mapinstance}').cggm2('getMarkerList');
    $('#from_location_{$mapinstance}').find('option').remove();
    $('#to_location_{$mapinstance}').find('option').remove();
    for( var i = 0; i < locations.length; i++ ) {
      var loc = locations[i];
      $('#from_location_{$mapinstance}').append($('<option>', { value: loc.value, text: loc.text }));
      $('#to_location_{$mapinstance}').append($('<option>', { value: loc.value, text: loc.text }));
    }
    $('#to_location_{$mapinstance},#from_location_{$mapinstance}').change(function(){
      var list = [];
      list.push($('#from_location_{$mapinstance}').val());
      list.push($('#to_location_{$mapinstance}').val());
      $('#cggm_map_{$mapinstance}').cggm2('getDirections',list,function(res) {
        if( typeof res == undefined || res == null ) {
          $('#directions_error_{$mapinstance}').html('{$mod->Lang('error_directionsfailed')}').show();
        }
      });
    });
  }); // update event
});
</script>
<fieldset id="directions_form_{$mapinstance}">
  <legend>{$mod->Lang('prompt_directions')}</legend>
  {$mod->Lang('from')}: <select id="from_location_{$mapinstance}"></select>
  {$mod->Lang('to')}: <select id="to_location_{$mapinstance}"></select>
  <div id="directions_error_{$mapinstance}" class="alert alert-error" style="display: none;"></div>
</fieldset>
