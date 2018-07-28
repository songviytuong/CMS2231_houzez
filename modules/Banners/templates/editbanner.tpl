{$title}
{if isset($message) && $message != ''}
  {if isset($error) && $error != ''}
    <p><font color="red">{$message}</font></p>
  {else}
    <p>{$message}</p>
  {/if}
{else}
{$startform}
  <div class="pageoverflow">
    <p class="pagetext">{$prompt_bannername}</p>
    <p class="pageinput">{$input_bannername}</p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext">{$prompt_bannerdesc}</p>
    <p class="pageinput">{$input_bannerdesc}</p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext">{$prompt_image}</p>
    <p class="pageinput">{$input_image}<br/><em>{$info_image}</em></p>
  </div>
{if isset($filelist)}
  <div class="pageoverflow">
    <p class="pagetext">{$prompt_upload_file}</p>
    <p class="pageinput">
      <select name="{$actionid}input_upload_file">
      {html_options options=$filelist}
      </select>
    </p>
  </div>
{/if}
  <div class="pageoverflow">
    <p class="pagetext">{$prompt_url}</p>
    <p class="pageinput">{$input_url}</p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext">{$prompt_href_text}</p>
    <p class="pageinput">{$input_href_text}<br/><em>{$info_href_text}</em></p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext">{$prompt_image_text}</p>
    <p class="pageinput">{$input_image_text}<br/><em>{$info_image_text}</em></p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext">{$prompt_impressions}</p>
    <p class="pageinput">{$value_impressions}</p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext">{$prompt_max_impressions}</p>
    <p class="pageinput">{$input_max_impressions}<br/><em>{$info_max_impressions}</em></p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext">{$prompt_start}</p>
    <p class="pageinput">{html_select_date prefix=$startdateprefix time=$startdate start_year="-2" end_year="+10"}</p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext">{$prompt_expires}</p>
    <p class="pageinput">{html_select_date prefix=$expiresdateprefix time=$expiresdate end_year="+10"}</p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext">&nbsp;</p>
    <p class="pageinput">{$hidden}{$submit}{$cancel}</p>
  </div>
{$endform}
<br/>{$image}<br/>
{if $itemcount > 0}
<br/>
<table cellspacing="0" class="pagetable">
	<thead>
		<tr>
			<th>{$iptext}</th>
			<th>{$datetext}</th>
		</tr>
	</thead>
	<tbody>
{foreach from=$items item=entry}
		<tr class="{$entry->rowclass}">
			<td>{$entry->ip}</td>
			<td>{$entry->date}</td>
		</tr>
{/foreach}
	</tbody>
</table>
{/if}
{/if}
