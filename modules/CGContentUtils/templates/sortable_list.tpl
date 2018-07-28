{* sortable list template *}
<style type="text/css" scoped>
ul.sortable_selected {
  min-height: 10em;
  max-height: 20em;
  overflow-y: auto;
  border: 1px solid green;
}
ul.sortable_master {
  min-height: 10em;
  max-height: 20em;
  overflow-y: auto;
  border: 1px solid blue;
}
.sortable_list td {
  text-align: center;
}
.sortable_list ul {
  margin-left: 10px !important;
  margin-right: 10px !important;
  padding-right: 10px;
  text-align: left;
}
.sortable_list ul li {
  list-style: none;
  margin-left: 10px;
  margin-top: 5px;
  margin-right: 5px;
  cursor: move;
}
</style>

<script type='text/javascript'>
function sortable_list(_container) {
    var container, selected, master, value_fld;

    container = _container;
    var element_name = container.attr('id');
    selected = $('ul.sortable_selected',container);
    master = $('ul.sortable_master',container);
    var sel = 'input[name="'+element_name+'"]';
    value_fld = $(sel,container);

    var h = Math.max(master.height(),selected.height());
    var w = Math.max(master.width(),selected.width());
    selected.height(h); master.height(h);
    if( w > 0 ) {
        selected.width(w); master.width(w);
    }
    selected.sortable({
       connectWith: master,
       update: function( ev, ui ) {
          console.debug('in selectted update');
          if( {$max_selected} > 0 && $('li',this).length > {$max_selected} ) {
             $(ui.sender).sortable('cancel');
          }
          else {
	     var sel = [];
	     $('li',this).each(function(){
	        var key = $(this).data('key');
		sel.push(key);
	     });
	     value_fld.val(sel.join());
          }
       }
    });
    master.sortable({
       connectWith: selected
    });
};

$(document).ready(function(){
   var cont = $('#{$selectarea_prefix}');
   var my_sortable_list = new sortable_list(cont);
});
</script>

{* note: $selectarea_prefix contains the name of the input element that must exist/be created on form submit.
         On submission of the form, this field must contain a comma separated list of the currently selected keys.
         $selectarea_selected is an associative array of keys and values representing the currently selected item.
	 $selectarea_selected_str is a string consisting of a comma separated list of currently selected keys.
*}
<div class="sortable_list" id="{$selectarea_prefix}">
  <table>
  <tr>
    <td>{$label_left}</td>
    <td>{$label_right}</td>
  </tr>
  <tr>
    <td valign="top">
      {* left column - for the selected items *}
      <ul class="sortable_selected" title="{$cge->Lang('sortablelist_selectlist')}">
      {if isset($selectarea_selected)}
        {foreach $selectarea_selected as $key => $val}
          <li data-key="{$key}">{$val}</li>
        {/foreach}
      {/if}
      </ul>
    </td>
    <td valign="top">
      {* right column - for the master list *}
      <ul class="sortable_master" title="{$cge->Lang('sortablelist_masterlist')}">
      {foreach $selectarea_masterlist as $key => $val}
        {if !isset($selectarea_selected) || !isset($selectarea_selected[$key])}
          <li data-key="{$key}">{$val}</li>
	{/if}
      {/foreach}
      </ul>
    </td>
  </tr>
  </table>
  <input type="hidden" class="sortable_val" name="{$selectarea_prefix}" value="{$selectarea_selected_str}"/>
</div> {* .sortable_list *}
