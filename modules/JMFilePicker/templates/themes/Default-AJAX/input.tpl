{strip}
{*------------------------------------------------------------------------------

  Module : JMFilePicker (c) 2010-2012 by Georg Busch (georg.busch@gmx.net)
           a filepicker tool for CMS Made Simple
           The projects homepage is dev.cmsmadesimple.org/projects/gbfilepicker
           CMS Made Simple is (c) 2004-2012 by Ted Kulp
           The projects homepage is: cmsmadesimple.org
  Version: 1.3.2
  File   : input.tpl
  License: GPL

------------------------------------------------------------------------------*}

<span class="JMFP_input_wrapper JMFP_{$jmfp_media_type} JMFP_{$jmfp_mode}" id="JMFP_{$jmfp_cssid}">
{literal}
<script language="javascript" type="text/javascript">
jmfp_onload.push(function(){
	JMFP.registerInput({{/literal}
		id: '{$jmfp_cssid}',
		moduleId: '{$jmfp_id}',
		dir:'{$jmfp_dir}',
		mode:'{$jmfp_mode}',
		browseUrl:'{if $jmfp_mode == "dropdown"}{$jmfp_reload_dropdown_url}{else}{$jmfp_browse_url}{/if}'{if $jmfp_upload_url},
		uploadUrl:'{$jmfp_upload_url}'{/if}
	{literal}});
});
</script>
{/literal}
{if $jmfp_prompt}
	<label for="{$jmfp_cssid}">{$jmfp_prompt}:</label>&nbsp;
{/if}
<span id="{$jmfp_cssid}_JMFP_{$jmfp_mode}_wrapper" class="JMFP_{$jmfp_mode}_wrapper">
	{$jmfp_input}
</span>
{if $jmfp_browse_link}
	<a href="#" class="JMFP_link JMFP_browse" id="{$jmfp_cssid}_JMFP_browse" onclick="return false;">{$jmfp_browse_text}</a>
{/if}
{if $jmfp_clear_link}
	&nbsp;|&nbsp;{$jmfp_clear_link}
{/if}
{if $jmfp_upload_link}
	&nbsp;|&nbsp;
	<a href="#" class="JMFP_link JMFP_upload" id="{$jmfp_cssid}_JMFP_upload" onclick="return false;">{$jmfp_upload_text}</a>
{/if}
{if $jmfp_mode == 'dropdown' && $jmfp_reload_dropdown_link}
	&nbsp;|&nbsp;{$jmfp_reload_dropdown_link}
{/if}

&nbsp;<img class="JMFP_loading_img" src="{root_url}/modules/JMFilePicker/templates/themes/Default-AJAX/img/loading.gif" alt="" />

{if $jmfp_media_type == 'image'}
	<br />
	<span id="{$jmfp_cssid}_JMFP_thumbnail_wrapper" class="JMFP_thumbnail_wrapper">
		{if $jmfp_value != ''}
		<img class="JMFP_thumbnail" id="{$jmfp_cssid}_JMFP_thumbnail" src="{$jmfp_thumburl}" width="{$jmfp_thumb_width}" height="{$jmfp_thumb_height}" alt="{$jmfp_value}" title="{$jmfp_value}" />
		{/if}
	</span>
{/if}
</span>
{/strip}
