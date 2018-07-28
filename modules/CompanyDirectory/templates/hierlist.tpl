{if !isset($actionparams.ajax)}
<script type="text/javascript">
$(document).ready(function(){
  var reorder_hierarchy_mode = 0;
  $('a.delete_hierarchy').click(function(e) {
    return confirm('{$mod->Lang('areyousure')}');
  });
  $('#reorder_hierarchy_mode_info,#reorder_hierarchy_opts').hide();

  $('a#reorder_hierarchy_mode_cancel').click(function(e) {
    $('#reorder_hierarchy_mode_info,#reorder_hierarchy_opts,#hierlist_opts').toggle();

    $('div#hierlist span.repeated').show();
    $('div#hierlist div.hiericon').show();
    $('div#hierlist ul').addClass('noindent');
    $('div#hierlist > ul').nestedSortable('destroy');
    var url = '{module_action_link module=CompanyDirectory action=admin_hiertab ajax=1 urlonly=1 jsfriendly=1}&showtemplate=false';
    $('div#hierlist').load(url);
    return false;
 });

  $('a#reorder_hierarchy_mode_submit').click(function(e) {
    $('#reorder_hierarchy_mode_info,#reorder_hierarchy_opts,#hierlist_opts').toggle();

    $('div#hierlist span.repeated').show();
    $('div#hierlist div.hiericon').show();
    $('div#hierlist ul').addClass('noindent');
    var list = $('div#hierlist > ul').nestedSortable('serialize');
    $('div#hierlist > ul').nestedSortable('destroy');
    var url = '{module_action_link module=CompanyDirectory action=admin_ajax_hierorder urlonly=1 jsfriendly=1}&showtemplate=false';
    $.post(url,list,
      function(data,textStatus,jqXHR) {
	var url = '{module_action_link module=CompanyDirectory action=admin_hiertab ajax=1 urlonly=1 jsfriendly=1}&showtemplate=false';
        $('div#hierlist').load(url);
      });
    return false;
  });

  $('a#reorder_hierarchy_mode').click(function(e) {
    $('#reorder_hierarchy_mode_info,#reorder_hierarchy_opts,#hierlist_opts').toggle();

    $('div#hierlist span.repeated').hide();
    $('div#hierlist div.hiericon').hide();
    $('div#hierlist ul').removeClass('noindent');
    $('div#hierlist > ul').nestedSortable({
      disableNesting: 'no-nest',
      forcePlaceholderSize: true,
      handle: 'div',
      items: 'li',
      opacity: .6,
      placeholder: 'placeholder',
      tabSize: 20,
      tolerance: 'pointer',
      listType: 'ul',
      toleranceElement: '> div'
    });
    return false;
  });

});
</script>

<div class="information" id="reorder_hierarchy_mode_info" style="display: block;">{$mod->Lang('reorder_mode')}</div>
<div id="reorder_hierarchy_opts" class="pageoptions">
  <a id="reorder_hierarchy_mode_cancel" href="#">{cgimage class="systemicon" image='false.gif' alt=$mod->Lang('cancel')} {$mod->Lang('cancel')}</a>&nbsp;
  <a id="reorder_hierarchy_mode_submit" href="#">{cgimage class="systemicon" image='true.gif' alt=$mod->Lang('submit')} {$mod->Lang('submit')}</a>
</div>
<div id="hierlist_opts" class="pageoptions">
  <a href="{$add_url}" class="pageoptions">{cgimage class="systemicon" image="icons/system/newobject.gif" alt="{$mod->Lang('addhier')}"} {$mod->Lang('addhier')}</a>
  <a href="{$update_url}" class="pageoptions">{cgimage class="systemicon" image="icons/system/run.gif" alt="{$mod->Lang('updatehier')}"} {$mod->Lang('updatehier')}</a>
  {if isset($hier)}
  <a id="reorder_hierarchy_mode" href="#">{cgimage class="systemicon" image='icons/system/reorder.gif' alt=$mod->Lang('reorder')} {$mod->Lang('reorder')}</a>
  {/if}
</div>

{/if}{* !ajax *}

{if isset($hier)}
{function dohier}
<ul class="noindent">
  {foreach $list as $node}
  {module_action_link module=CompanyDirectory action=admin_edithier catid=$node.id urlonly=1 assign='edit_url'}
  {module_action_link module=CompanyDirectory action=admin_delhier catid=$node.id urlonly=1 assign='delete_url'}
  <li id="{$actionid}hier_{$node.id}">
    {cycle values="row1,row2" assign='rowclass'}
    <div class="label hiernode {$rowclass}">
      <div class="hiername">
        <span class="repeated">{repeat string='&nbsp;&gt;&nbsp;' times=$node.depth}</span><a href="{$edit_url}" title="{$mod->Lang('edit')}">{$node.name}</a>
      </div>
      <div class="hiericon">
        {if !isset($node.children)}
        <a href="{$delete_url}" title="{$mod->Lang('delete')}">{cgimage image='icons/system/delete.gif' alt=$mod->Lang('delete')}</a>
	{/if}
      </div>
      <div class="hiericon">
        <a href="{$edit_url}" title="{$mod->Lang('edit')}">{cgimage image='icons/system/edit.gif' alt=$mod->Lang('edit')}</a>
      </div>
    </div>
    {if isset($node.children)}{dohier list=$node.children}{/if}
  </li>
  {/foreach}
</ul>
{/function}

<div id="hierlist" class="hierlist cf">
  <div class="header">{$mod->Lang('hierarchy')}</div>
  {dohier list=$hier}
</div>
{/if}