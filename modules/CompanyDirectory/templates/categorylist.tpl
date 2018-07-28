{*
#CMS - CMS Made Simple
#(c)2004-6 by Ted Kulp (ted@cmsmadesimple.org)
#This project's homepage is: http://cmsmadesimple.org
#
#This program is free software; you can redistribute it and/or modify
#it under the terms of the GNU General Public License as published by
#the Free Software Foundation; either version 2 of the License, or
#(at your option) any later version.
#
#This program is distributed in the hope that it will be useful,
#but WITHOUT ANY WARRANTY; without even the implied warranty of
#MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#GNU General Public License for more details.
#You should have received a copy of the GNU General Public License
#along with this program; if not, write to the Free Software
#Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
#
#$Id$
*}

{if !isset($actionparams.ajax)}
<script type="text/javascript">
$(document).ready(function(){
  $('a.delete_cat').click(function(e) {
    return confirm('{$mod->Lang('areyousure')}');
  });
  $('#reorder_category_mode_info,#reorder_category_opts').hide();

  $('a#reorder_category_mode_cancel').click(function(e) {
    $('#reorder_category_mode_info,#reorder_category_opts').toggle();
    $('div#catlist_opts').toggle();
    $('div#categorylist span.repeated').show();
    $('div#categorylist div.hiericon').show();
    $('div#categorylist ul').addClass('noindent');

    var url = '{module_action_link module=CompanyDirectory action=admin_categories_tab ajax=1 urlonly=1 jsfriendly=1}&showtemplate=false';
    $('div#categorylist').load(url);
    return false;
  });

  $('a#reorder_category_mode_submit').click(function(e) {
    $('#reorder_category_mode_info,#reorder_category_opts').toggle();
    $('div#catlist_opts').toggle();
    $('div#categorylist span.repeated').show();
    $('div#categorylist div.hiericon').show();
    $('div#categorylist ul').addClass('noindent');

    var list = $('div#categorylist > ul').nestedSortable('serialize');
    $('div#categorylist > ul').nestedSortable('destroy');
    var url = '{module_action_link module=CompanyDirectory action=admin_ajax_categoryorder urlonly=1 jsfriendly=1}&showtemplate=false';
    $.post(url,list,
      function(data,textStatus,jqXHR) {
        var url = '{module_action_link module=CompanyDirectory action=admin_categories_tab ajax=1 urlonly=1 jsfriendly=1}&showtemplate=false';
        $('div#categorylist').load(url);
      }
    );
    return false;
  });

  $('a#reorder_category_mode').click(function(e){
    $('#reorder_category_mode_info,#reorder_category_opts').toggle();

    $('div#catlist_opts').toggle();
    $('div#categorylist span.repeated').hide();
    $('div#categorylist div.hiericon').hide();
    $('div#categorylist ul').removeClass('noindent');
    $('div#categorylist > ul').nestedSortable({
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
  });
});
</script>

<div id="reorder_category_mode_info" class="information" style="display: block;">{$mod->Lang('reorder_mode')}</div>
<div id="reorder_category_opts" class="pageoptions">
  <a id="reorder_category_mode_cancel">{cgimage class="systemicon" image='false.gif' alt=$mod->Lang('cancel')} {$mod->Lang('cancel')}</a>&nbsp;
  <a id="reorder_category_mode_submit">{cgimage class="systemicon" image='true.gif' alt=$mod->Lang('submit')} {$mod->Lang('submit')}</a>
</div>
<div id="catlist_opts" class="pageoptions">
  <a id="add_category" href="{$url_add_category}">{cgimage class="systemicon" image='icons/system/newobject.gif' alt=$mod->Lang('addcategory')} {$mod->Lang('addcategory')}</a>
  {if isset($categories)}
  <a id="reorder_category_mode">{cgimage class="systemicon" image='icons/system/reorder.gif' alt=$mod->Lang('reorder')} {$mod->Lang('reorder')}</a>
  {/if}
</div>
{/if} {* ajax *}

{if isset($categories)}
{function docat}
<ul class="noindent">
  {foreach $list as $node}
    {module_action_link module=CompanyDirectory action=editcategory catid=$node->id urlonly=1 assign='edit_url'}
    {module_action_link module=CompanyDirectory action=deletecategory catid=$node->id urlonly=1 assign='delete_url'}
    <li id="{$actionid}cat_{$node->id}">
      {cycle values="row1,row2" assign='rowclass'}
      <div class="label hiernode {$rowclass}">
        <div class="hiername">
          <span class="repeated">{repeat string='&nbsp;&gt;&nbsp;' times=$node->depth}</span><a href="{$edit_url}" title="{$mod->Lang('edit')}">{$node->name}</a>
        </div>
        <div class="hiericon">
	  {if !isset($node->children)}
          <a href="{$delete_url}" class="del_cat" title="{$mod->Lang('delete')}">{cgimage image='icons/system/delete.gif' alt=$mod->Lang('delete')}</a>
	  {/if}
        </div>
        <div class="hiericon">
          <a href="{$edit_url}" class="edit_cat" title="{$mod->Lang('edit')}">{cgimage image='icons/system/edit.gif' alt=$mod->Lang('edit')}</a>
        </div>
      </div>
      {if isset($node->children)}{docat list=$node->children}{/if}
    </li>
  {/foreach}
</ul>
{/function}

<div id="categorylist" class="hierlist cf">
  <div class="header">{$mod->Lang('categories')}</div>
  {docat list=$categories}
</div>
{/if}
