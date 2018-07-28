{strip}
{*------------------------------------------------------------------------------

  Module : JMFilePicker (c) 2010-2012 by Georg Busch (georg.busch@gmx.net)
           a filepicker tool for CMS Made Simple
           The projects homepage is dev.cmsmadesimple.org/projects/gbfilepicker
           CMS Made Simple is (c) 2004-2012 by Ted Kulp
           The projects homepage is: cmsmadesimple.org
  Version: 1.3.2
  File   : header.tpl
  License: GPL

------------------------------------------------------------------------------*}

<!-- start jmfp head -->

<style type="text/css">
.jmfp_contract {
	background-image: url("{$contract_img}") !important;
}
.jmfp_expand {
	background-image: url("{$expand_img}") !important;
}
</style>
<script language="javascript" type="text/javascript">
jmfp_onload = [
	function(){
		JMFP.init({
			title: '{$jmfp_title}',
			closeText: '{$jmfp_close_text}',
			reloadText: '{$jmfp_reload_dir_text}',
			clearCacheText: '{$jmfp_clear_cache_text}',
			rootUrl: '{root_url}',
			thumbnailWidth: {$thumb_width},
			thumbnailHeight: {$thumb_height},
			moduleId: '{$jmfp_id}'
		});
	}
];
if(typeof jsLoader_scripts == 'undefined')
	jsLoader_scripts = [];
jsLoader_scripts.push({
	url:'{root_url}/modules/JMFilePicker/templates/themes/Default-AJAX/js/JMFP.js', 
	loadType:'defer'
});
</script>
<link rel="stylesheet" media="screen" type="text/css" href="{root_url}/modules/JMFilePicker/templates/themes/Default-AJAX/css/JMFP.css" />
{jmfp_jsloader}

<!-- end jmfp head -->

{/strip}
