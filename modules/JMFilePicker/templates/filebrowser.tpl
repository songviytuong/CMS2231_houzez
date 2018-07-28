{strip}
{*------------------------------------------------------------------------------

  Module : JMFilePicker (c) 2010-2012 by Georg Busch (georg.busch@gmx.net)
           a filepicker tool for CMS Made Simple
           The projects homepage is dev.cmsmadesimple.org/projects/gbfilepicker
           CMS Made Simple is (c) 2004-2012 by Ted Kulp
           The projects homepage is: cmsmadesimple.org
  Version: 1.3.2
  File   : prefstab
  License: GPL

------------------------------------------------------------------------------*}

<div id="JMFP_header">

{if isset($jmfp_currentdir)}

	<div class="breadcrumbs">
		<p class="breadcrumbs">
		
	{if isset($jmfp_starturl)}
			
			<a href="{$jmfp_starturl}" id="JMFP_goto_root" title="{$jmfp_startdir_text}" onclick="JMFP.loadDir(this.href,'{$jmfp_cssid}','{$jmfp_startdir}'); return false;">{$jmfp_startdir_text}</a>
			
			&nbsp;{$jmfp_currentdir_text}:&nbsp;
			
			{assign var="current_breadcrumb" value="$jmfp_startdir"}
			{foreach from=$jmfp_breadcrumbs item=breadcrumb name=current}
				{assign var="current_breadcrumb" value=$current_breadcrumb|cat:'/'|cat:$breadcrumb->filename|@trim:'/'}
				{if $jmfp_currentdir != $current_breadcrumb}
			
			<a href="{$breadcrumb->fileurl}" onclick="JMFP.loadDir(this.href,'{$jmfp_cssid}','{$breadcrumb->id}'); return false;">{$breadcrumb->filename}</a>
			
				{else}
					{$breadcrumb->filename}
				{/if}
				{if !$smarty.foreach.current.last} / {/if}
			{/foreach}
	{else}
			
			<img src="{root_url}/modules/JMFilePicker/images/dir.gif" alt="" />
			
			&nbsp;{$jmfp_currentdir_text}:&nbsp;{$jmfp_currentdir}
			
	{/if}
	
		</p>
	</div>
	<div class="hstippled">&nbsp;</div>
	
{/if}

{if isset($jmfp_formstart)}
{$jmfp_formstart}
	<fieldset id="JMFP_fileoperations_wrapper" class="jmfp_fieldset{if !$jmfp_fileoperations_display} jmfp_no-border{/if}">
	{if $jmfp_mode != 'dropdown'}
		<legend><a href="{$jmfp_prefurl}{if !$jmfp_fileoperations_display}1{else}0{/if}" class="{if !$jmfp_fileoperations_display}jmfp_expand{else}jmfp_contract{/if}" id="JMFP_toggle_fileoperations">{$jmfp_fileoperations_text}</a></legend>
	{/if}
		
		<div {if $jmfp_mode != 'dropdown'}id="JMFP_fileoperations" style="display:{if !$jmfp_fileoperations_display && $jmfp_mode != 'dropdown'}none{else}block{/if}"{/if}>
			<table>
				<tbody>
					<tr>
					{if $jmfp_upload}
						<td>{$jmfp_fileupload_text}:</td>
					{/if}
					{if $jmfp_create_dirs}
						<td>{$jmfp_createdir_text}:</td>
					{/if}
					</tr>
					<tr>
					{if $jmfp_upload}
						<td>{$jmfp_fileupload_input}</td>
					{/if}
					{if $jmfp_create_dirs}
						<td>{$jmfp_createdir_input}</td>
					{/if}
					</tr>
					<tr>
					{if $jmfp_upload && $jmfp_allow_scaling}
						<td>{$jmfp_resizeimage_text}:&nbsp;{$jmfp_resizeimage_input}</td>
					{/if}
					{if $jmfp_create_dirs}
						<td>{$jmfp_createdir_submit}</td>
					{/if}
					</tr>
					{if $jmfp_upload && $jmfp_allow_scaling}
					<tr>
						<td>{$jmfp_imagesize_x_input}&nbsp;x&nbsp;{$jmfp_imagesize_y_input}</td>
					</tr>
					<tr>
						<td>{$jmfp_keepaspectratio_text}:&nbsp;{$jmfp_keepaspectratio_input}</td>
					</tr>
						{if $jmfp_allow_upscaling}
					<tr>
						<td>{$jmfp_forceupscaling_text}:&nbsp;{$jmfp_forceupscaling_input}</td>
					</tr>
						{/if}
					{/if}
					{if $jmfp_upload}
					<tr>
						<td>{$jmfp_fileupload_submit}</td>
					</tr>
					{/if}
				</tbody>
			</table>
		</div>
	</fieldset>
{$jmfp_formend}
{/if}

{if isset($jmfp_errormessage) && $jmfp_errormessage!=""}
	<fieldset class="JMFP_message" id="JMFP_error" onclick="JMFP.tmp.template['#JMFP'].css('height','auto');jQuery(this).fadeTo(JMFP.inputs[JMFP.tmp.currentPickerId].fadeSpeed,0,function(){literal}{{/literal}jQuery(this).animate({literal}{{/literal}height: '0px'{literal}}{/literal}, JMFP.inputs[JMFP.tmp.currentPickerId].animateSpeed , 'swing', function(){literal}{{/literal}jQuery(this).remove();JMFP.resize();{literal}}{/literal}){literal}}{/literal});" style="cursor:pointer">
		<legend>{$jmfp_error_text}</legend>
		{$jmfp_errormessage}
	</fieldset>
{/if}

{if isset($jmfp_message) && $jmfp_message!=""}
	<fieldset class="JMFP_message" id="JMFP_success" onclick="JMFP.tmp.template['#JMFP'].css('height','auto');jQuery(this).fadeTo(JMFP.inputs[JMFP.tmp.currentPickerId].fadeSpeed,0,function(){literal}{{/literal}jQuery(this).animate({literal}{{/literal}height: '0px'{literal}}{/literal}, JMFP.inputs[JMFP.tmp.currentPickerId].animateSpeed , 'swing', function(){literal}{{/literal}jQuery(this).remove();JMFP.resize();{literal}}{/literal}){literal}}{/literal});" style="cursor:pointer">
		<legend>{$jmfp_success_text}</legend>
		{$jmfp_message}
	</fieldset>
{/if}

</div>

{if $jmfp_mode != 'dropdown' && isset($jmfp_files)}

<div id="JMFP_filelist">

	{if $jmfp_files|@count}
	
	<table style="width:100%;" id="JMFP_filetable" class="pagetable" cellspacing="0">
		<tbody>
		{foreach from=$jmfp_files item=file}
		
		<tr class="{cycle values="row1,row2"} {$file->id}">
		
			{if $file->is_dir}
			<td class="pagepos" style="width:{$jmfp_thumb_width}px">{$file->fileicon}</td>
			<td>
				<a title="{$file->relurl}" style="padding:0.8em;display:block" href="{$file->fileurl}" onclick="JMFP.loadDir(this.href,'{$jmfp_cssid}','{$file->relurl}'); return false;">
					{$file->basename}
				</a>
			</td>
			
				{if $jmfp_media_type=='file'}
			<td>&nbsp;</td>
				{/if}
			
			<td>&nbsp;</td>
			
			<td class="pagepos">
				{if $jmfp_delete && isset($file->deleteurl)}
				<a href="{$file->deleteurl}" onclick="JMFP.deleteFile(this.href,'{$file->confirmdelete}', '{$file->relurl}'); return false;">
					{$jmfp_deleteicon}
				</a>
				{/if}
			</td>
			
			{else}
			
			<td class="pagepos" style="width:{$jmfp_thumb_width}px">
				{if $file->is_image && $file->thumbnail}
				<div class="JMFP_thumbnail_wrapper">
					<a title="{$file->relurl}" id="{$file->id}" href='{$file->fullurl}' onclick="{if $file->is_image && $file->thumburl}JMFP.toggleThumbnail('{$jmfp_cssid}','{$file->thumburl}','{$file->relurl}', '{$file->relurl}');{/if}JMFP.pickFile('{$file->relurl}', '{$jmfp_cssid}'); return false;">
						
						{$file->thumbnail}
						
					</a>
				</div>
				{else}
					{$file->fileicon}
				{/if}
			</td>
			<td>
				<a {if $file->is_image && $file->thumbnail}style="padding:0.8em;display:block;line-height:{$jmfp_thumb_height}px;"{/if} title="{$file->basename}" href='{$file->fullurl}' onclick="{if $file->is_image && $file->thumburl}JMFP.toggleThumbnail('{$jmfp_cssid}','{$file->thumburl}','{$file->relurl}', '{$file->relurl}');{/if}JMFP.pickFile('{$file->relurl}', '{$jmfp_cssid}'); return false;">
					{$file->basename}
				</a>
				
			</td>
			
				{if $jmfp_media_type=='file'}
			<td>{$file->filetype}</td>
				{/if}
				
			<td align="right" style="text-align:right;white-space: nowrap;line-height:130%">
				{$file->filesize}
				{if $file->is_image}
				<br />{$file->imgsize}
				{/if}
			</td>
			
			<td class="pagepos" align="right">
				{if $jmfp_delete && isset($file->deleteurl)}
				<a href="{$file->deleteurl}" onclick="JMFP.deleteFile(this.href,'{$file->confirmdelete}', '{$file->relurl}'); return false;">
					{$jmfp_deleteicon}
				</a>
				{/if}
			</td>
			
			{/if}
		</tr>
		{/foreach}
		</tbody>
	</table>
	{/if}
</div>
{/if}

{/strip}
