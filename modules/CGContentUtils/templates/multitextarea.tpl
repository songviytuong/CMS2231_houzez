
<style type="text/css" scoped>
div.cgcu_list > div {
  border: 1px dashed gray;
  padding: 3px;
  margin: 5px;
}
</style>

<script type="text/javascript">
$(document).ready(function(){
  $('#cgcu_add{$name}').click(function(){
     // find a unique suffix for this thing
     var n = 1;
     $('#cgcu_list{$name} textarea').each(function(idx,el){
        var name = $(el).attr('name');
	var l = '{$name}'.length+1;
	var i = parseInt(name.substr(l));
	n = Math.max(i,n);
     });
     var name = '{$name}_'+(n+1);
     var sub = $('<div style="float: left;"/>').append(name+'<br/>').append('<a class="cgcu_del{$name}">{$del_image}</a>');
     var e = $('<textarea rows="5" cols="80" style="margin-left: 5px;"/>').attr('name',name);
     var d = $('<div/>').append(sub).append(e);
     $('#cgcu_list{$name}').append(d);
     return false;
  })
  $(document).on('click','.cgcu_del{$name}',function(){
     $(this).parent().parent().remove();
     return false;
  })
  $('#cgcu_list{$name}').sortable()
});
</script>
<div>
  <div class="pageoptions">
    <a id="cgcu_add{$name}">{$add_image} {$add_text}</a> {cms_help title='title_multiextarea' key1=CGContentUtils key2='help_multitextarea'}
  </div>
  <div id="cgcu_list{$name}" class="cgcu_list">
  {foreach $children as $fname => $val}
    <div>
      <div style="float: left;">
        {$fname}<br/>
        <a class="cgcu_del{$name}">{$del_image}</a>
      </div>
      <textarea rows="5" cols="80" style="margin-left: 5px;" name="{$fname}">{$val}</textarea>
    </div>
  {/foreach}
  </div>
</div>
