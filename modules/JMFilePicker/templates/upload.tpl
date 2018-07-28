{strip}
{*------------------------------------------------------------------------------

  Module : JMFilePicker (c) 2010-2012 by Georg Busch (georg.busch@gmx.net)
           a filepicker tool for CMS Made Simple
           The projects homepage is dev.cmsmadesimple.org/projects/gbfilepicker
           CMS Made Simple is (c) 2004-2012 by Ted Kulp
           The projects homepage is: cmsmadesimple.org
  Version: 1.3.2
  File   : filebrowser.tpl
  License: GPL

------------------------------------------------------------------------------*}

<div id="JMFP_header">
{if isset($jmfp_errormessage) && $jmfp_errormessage!=""}
	<fieldset class="JMFP_message" id="JMFP_error">
		<legend>{$jmfp_error_text}</legend>
		{$jmfp_errormessage}
	</fieldset>
{/if}
{if isset($jmfp_message) && $jmfp_message!=""}
	<fieldset class="JMFP_message" id="JMFP_success">
		<legend>{$jmfp_success_text}</legend>
		{$jmfp_message}
	</fieldset>
{/if}
{if isset($jmfp_formstart)}
	<fieldset>
{$jmfp_formstart}
		<div style="float:left;margin-right:5%">
			<p>{$jmfp_fileupload_text}:</p>
			<p>{$jmfp_fileupload_input}</p>
	{if $jmfp_allow_scaling}
			<p>{$jmfp_resizeimage_text}:&nbsp;{$jmfp_resizeimage_input}</p>
			<p>{$jmfp_imagesize_x_input}&nbsp;x&nbsp;{$jmfp_imagesize_y_input}</p>
			<p>{$jmfp_keepaspectratio_text}:&nbsp;{$jmfp_keepaspectratio_input}</p>
			{if $jmfp_allow_upscaling}
			<p>{$jmfp_forceupscaling_text}:&nbsp;{$jmfp_forceupscaling_input}</p>
			{/if}
	{/if}
			<p>{$jmfp_fileupload_submit}</p>
		</div>
{$jmfp_formend}
	</fieldset>
{/if}
</div>
{/strip}
