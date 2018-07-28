{if !empty($error)}
   <div class="information" style="text-align: center;">{$message}</div>
{else}
  <script type="text/javascript">
  function do_report_popup(url,title) {
    window.open(url,title,'width=800,height=600,scrollbars=yes,resizable=yes');
  }
  </script>

  <div class="pageoptions">
    <div style="float: left; width: 59%; vertical-align: middle;">
      {$addbanner}
      <a href="javascript:void()" onclick="do_report_popup('{$report_url}','{$mod->Lang('title_stats_report')}'); return false;">
      <img width="16" src="{$mod->GetModuleURLPath()}/images/report.gif" class="systemicon" alt=""/>&nbsp;{$mod->Lang('view_statistics')} <em>({$mod->Lang('msg_new_window')})</em></a>
    </div>
    <div style="float: right; width: 39%; text-align: right;">
      {$startform}
      {$mod->Lang('category')}&nbsp;
      <select name="{$actionid}input_category">
        {html_options options=$categorylist selected=$curcategory}
      </select>
      <input type="submit" name="{$actionid}submitcategory" value="{$mod->Lang('selectcategory')}"/>
      {$endform}
    </div>
    <div style="clear: both;"></div>
  </div>

  {if $itemcount > 0}
  <table cellspacing="0" class="pagetable">
	<thead>
		<tr>
			<th width="5%">{$mod->Lang('id')}</th>
			<th>{$mod->Lang('name')}</th>
			<th>{$mod->Lang('description')}</th>
			<th>{$mod->Lang('created')}</th>
			<th>{$mod->Lang('start_date')}</th>
			<th>{$mod->Lang('expires')}</th>
			<th>{$mod->Lang('impressions')}</th>
			<th>{$mod->Lang('hits')}</th>
			<th class="pageicon">&nbsp;</th>
			<th class="pageicon">&nbsp;</th>
		</tr>
	</thead>
	<tbody>
  {foreach from=$items item=entry}
    {module_action_link action='addbanner' category_id=$curcategory banner_id=$entry->id urlonly=1 assign=edit_url}
    {module_action_link action='do_deletebanner' category_id=$curcategory banner_id=$entry->id urlonly=1 assign=delete_url}
    {$finished=''}
    {if $entry->expires_ts > $smarty.now || $entry->fin_expr}{$finished=1}{/if}
		<tr class="{cycle values="row1,row2"} {$finished}">
			<td>{$entry->id}</td>
			<td><a href="{$edit_url}" title="{$mod->Lang('edit')}">{$entry->name}</a></td>
			<td>{$entry->description}</td>
			<td>{$entry->created}</td>
			<td>
			  {if $entry->start_ts > $smarty.now}<span style="color: red;">{$entry->start}</span>
			  {else}{$entry->start}{/if}
			</td>
			<td>
			  {if $entry->expires_ts > 0 && $entry->expires_ts < $smarty.now}<span style="color: red;">{$entry->expires}</span>
			  {else}{$entry->expires}{/if}
			</td>
			<td>
			  {if $entry->fin_expr}
			    <span style="color: red;">{$entry->impressions}/{$entry->max_impressions}</span>
			  {else}
  			    {$entry->impressions}/{$entry->max_impressions}
			  {/if}
			</td>
			<td>{$entry->hits}</td>
			<td><a href="{$edit_url}" title="{$mod->Lang('edit')}">{cgimage image='icons/system/edit.gif' alt=$mod->Lang('edit')}</a></td>
			<td><a href="{$delete_url}" title="{$mod->Lang('delete')}">{cgimage image='icons/system/delete.gif' alt=$mod->Lang('delete')}</a></td>
		</tr>

  {/foreach}
	</tbody>
  </table>
  {/if}

{/if}