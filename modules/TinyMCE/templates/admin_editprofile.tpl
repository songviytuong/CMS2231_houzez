
<script src="{root_url}/modules/TinyMCE/lib/js/autosize.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		ta = $('textarea');
		autosize(ta);

		$('.tinymce-profile-edit #page_tabs > div').mousedown(function(){
			autosize.update(ta);
		});
	});
</script>

{function name='label'}
	<p class="pagetext">
		<label {if isset($for)}for="{$for}"{/if}>{$mod->Lang($text)}</label>
		{if isset($help) && $help}
			{cms_help title=$mod->Lang($text) key="help_{$help}"}
		{/if}
		{if !empty($documentation)}
			&nbsp;(<a href="{$documentation}" target="_blank">{$mod->Lang('documentation')}</a>)
		{/if}
	</p>
{/function}

{function name='submit_form_buttons'}
	<div class="pageoverflow">
		<p class="pagetext"></p>
		<p class="pageinput">
			<input type="submit" name="{$actionid}submit" value="{$mod->Lang('submit')}" class="pagebutton" />
			<input type="submit" name="{$actionid}cancel" value="{$mod->Lang('cancel')}" class="pagebutton" />
			<input type="submit" name="{$actionid}apply" value="{$mod->Lang('apply')}" class="pagebutton" />
		</p>
	</div>
{/function}

{function name='checkbox' simple=false}
	{if !$simple}
		<div class="pageoverflow">
			{label text=$fld_name for=$fld_name}
			<p class="pageinput">
				<input type="hidden" name="{$actionid}{$fld_name}" value="0">
				<input type="checkbox" id="{$fld_name}" name="{$actionid}{$fld_name}" value="1" {if $profile->{$fld_name}}checked="checked"{/if}>
			</p>
		</div>
	{else} {* Simple oneline *}
		<input type="hidden" name="{$actionid}{$fld_name}" value="0">
		<label>
			<input type="checkbox" id="{$fld_name}" name="{$actionid}{$fld_name}" value="1" {if $profile->{$fld_name}}checked="checked"{/if}> {$mod->Lang($fld_name)}
		</label><br>
	{/if}
{/function}

{function name='text_input'}

	{if !isset($help)}
		{$help=false}
	{/if}

	<div class="pageoverflow">
		{if isset($label_name)}
			{label text=$label_name for=$fld_name help=$help}
		{else}
			{label text=$fld_name for=$fld_name help=$help}
		{/if}
		<p class="pageinput">
			<input name='{$actionid}{$fld_name}' value='{$profile->$fld_name}' id='{$fld_name}' {if isset($size)}size="{$size}{/if}"> {if isset($ext)}{$ext}{/if}
		</p>
	</div>
{/function}

{function name='textarea'}
	<div class="pageoverflow">
		{if !isset($text)}
			{$text=$fld_name}
		{/if}
		{if !empty($documentation)}
			{label text=$text for=$fld_name documentation=$documentation}
		{elseif !isset($nolabel)}
			{label text=$text for=$fld_name}
		{/if}
		{if isset($subtext)}
			<p class="pageinput">
				{$mod->Lang($subtext)}
			</p>
		{/if}

		<p class="pageinput">
			{cms_textarea name="{$actionid}{$fld_name}" value=$profile->{$fld_name} rows=1}
			{if isset($subhelp)}
				<br>{$mod->Lang('subhelp_'|cat:$subhelp)}
			{/if}
		</p>
	</div>
{/function}



<div class="tinymce-profile-edit">

	<h3>{strip}
		{if $mode eq 'add'}
			{$mod->Lang('new_profile')}
		{else}
			{$mod->Lang('edit_profile')}: {$profile->name}&nbsp;(ID {$profile->id_profile})
		{/if}
	{/strip}</h3>


	{form_start}


	{include file='module_file_tpl:TinyMCE;admin_example.tpl'}




	{* Active tab *}
	{$active_tab='general'}
	{if isset($actionparams['active_tab'])}
		{$active_tab=$actionparams['active_tab']}
	{/if}
	<input type="hidden" name="{$actionid}active_tab" id="active_tab" value="{$active_tab}">
	<script type="text/javascript">
		$(document).ready(function(){
			$('#page_tabs > div').mousedown(function(){
				tab_id = $(this).attr('id');
				$('#active_tab').val(tab_id);
			});
		});
	</script>

	{submit_form_buttons}

	{if $profile->id_profile}
		<input type="hidden" name="{$actionid}id_profile" value="{$profile->id_profile}">
	{/if}





		{tab_header name='general' label=$mod->Lang('general') active=$active_tab}
		{tab_header name='plugins' label=$mod->Lang('plugins') active=$active_tab}
		{tab_header name='menubar' label=$mod->Lang('menubar') active=$active_tab}
		{tab_header name='toolbar' label=$mod->Lang('toolbar') active=$active_tab}
		{tab_header name='contextmenu' label=$mod->Lang('contextmenu') active=$active_tab}
		{tab_header name='css' label='CSS' active=$active_tab}
		{tab_header name='filemanager' label=$mod->Lang('filemanager') active=$active_tab}
		{tab_header name='users_groups' label=$mod->Lang('usergroups') active=$active_tab}
		{tab_header name='templates' label=$mod->Lang('templates') active=$active_tab}


		{* GENERAL ************************************* *}
		{tab_start name='general'}
			{text_input fld_name='name' label_name='profile_name'}

			<hr>
			<div class="pageoverflow">
				{label text='resize' for='resize'}
				<p class="pageinput">
					<input type="radio" name="{$actionid}resize" id="resize_0" value="0" {if !$profile->resize} checked="checked"{/if}>
					<label for="resize_0">{$mod->Lang('resize_no')}</label><br>

					<input type="radio" name="{$actionid}resize" id="resize_1" value="1" {if $profile->resize eq '1'} checked="checked"{/if}>
					<label for="resize_1">{$mod->Lang('resize_vertical')}</label><br>

					<input type="radio" name="{$actionid}resize" id="resize_both" value="both" {if $profile->resize eq 'both'} checked="checked"{/if}>
					<label for="resize_both">{$mod->Lang('resize_both')}</label>
				</p>
			</div>

			{checkbox fld_name='autoresize' help='autoresize'}

			<hr>
			{checkbox fld_name='show_statusbar' help='show_statusbar'}

			<hr>
			{checkbox fld_name='forced_root_block' help='forced_root_block' documentation='https://www.tinymce.com/docs/configure/content-filtering/#forced_root_block'}



		{* PLUGINS ************************************* *}
		{tab_start name='plugins'}
			{textarea fld_name='plugins' documentation='https://www.tinymce.com/docs/plugins/' help='plugins'}

			{checkbox fld_name='enable_linker'}


			{* External modules list *}
			{if isset($external_modules) and !empty($external_modules)}
				<hr>

				{label text='external_modules' help='external_modules'}

				{foreach $external_modules as $mod_name=>$mod_infos}
					<label>
						<input type="checkbox" name="{$actionid}external_modules[]" value="{$mod_name}" {if is_array($profile->external_modules) and in_array($mod_name, $profile->external_modules)}checked="checked"{/if}> {$mod_infos.friendlyname} - {$mod->Lang('button_name')}: <strong>{$mod_infos.button_name}</strong>
					</label>
					<br>
				{/foreach}

				{checkbox fld_name='external_modules_show_menutext'}

			{/if}

			<hr>

			{label text='image_plugin'}
			{checkbox fld_name='image_advtab' simple=true}





		{* MENU BAR ************************************* *}
		{tab_start name='menubar'}
			{checkbox fld_name='show_menubar'}
			{textarea fld_name='menubar' documentation='https://www.tinymce.com/docs/advanced/editor-control-identifiers/' help='menubar'}

			{label text='advanced_menu' help='advanced_menu'}

			{checkbox fld_name='use_advanced_menu' help='use_avanced_menu' simple=true}
			{textarea fld_name='advanced_menu' nolabel=1}



		{* TOOLBAR ************************************* *}
		{tab_start name='toolbar'}
			{checkbox fld_name='show_toolbar' help='toolbar'}
			{textarea fld_name='toolbar1' documentation='https://www.tinymce.com/docs/advanced/editor-control-identifiers/'}
			{textarea fld_name='toolbar2' documentation='https://www.tinymce.com/docs/advanced/editor-control-identifiers/' subhelp='toolbar'}

			{if isset($external_modules) and is_array($profile->external_modules)}
				<p class="pageinput">
					{$mod->Lang('external_modules')}:
					{foreach $profile->external_modules as $ext_module_loaded}
						<em>{$external_modules[$ext_module_loaded]['button_name']}</em>
					{/foreach}
				</p>
			{/if}

			<hr>

			{* Block formats *}
			{checkbox fld_name='use_custom_block_formats' help='use_custom_block_formats'}
			{textarea fld_name='block_formats' subhelp='custom_block_formats'}

			<hr>

			{* Custom dropdown *}
			{checkbox fld_name='enable_custom_dropdown' help='enable_custom_dropdown'}
			{text_input fld_name='custom_dropdown_title' label_name='custom_dropdown_title'}
			{textarea fld_name='custom_dropdown' subhelp='custom_dropdown'}





		{* CONTEXTMENU ************************************* *}
		{tab_start name='contextmenu'}

			{checkbox fld_name='enable_contextmenu'}
			{textarea fld_name='contextmenu' text='contextmenu_content' documentation='https://www.tinymce.com/docs/plugins/contextmenu/' subhelp='contextmenu_content'}


		{* CSS ************************************* *}
		{tab_start name='css'}
			<div class="pageoverflow">
				{label text='design_css' for='id_design' help='design_css'}
				<p class="pageinput">
					<select name='{$actionid}id_design' id="id_design">
						<option value="0" {if $profile->id_design eq 0}selected="selected"{/if}>
							- {$mod->Lang('no_design_linked')} -
						</option>
						{foreach $designs as $design}
							<option value="{$design->get_id()}" {if $design->get_id() eq $profile->id_design}selected="selected"{/if}>
								{$design->get_name()}
							</option>
						{/foreach}
					</select>
				</p>
			</div>

			{textarea fld_name='style_formats' subtext='style_formats_info' help='style_formats' documentation='https://www.tinymce.com/docs/configure/content-formatting/#style_formats'}

			<fieldset>
				<legend>{$mod->Lang('css_classes')}</legend>

				<div class="c_full cf">
					<div class="grid_6">
						{textarea fld_name='link_classes' subtext='link_classes_info' help='link_classes'}
					</div>
					<div class="grid_6">
						{textarea fld_name='image_classes' subtext='image_classes_info' help='image_classes'}
					</div>
				</div>
			</fieldset>




		{* FILEMANAGER ************************************* *}
		{tab_start name='filemanager'}
			{checkbox fld_name='filemanager_use' help='filemanager_use'}

			{checkbox fld_name='relative_urls' help='relative_urls'}

			{* Filemanager options *}
			<div class="pageoverflow">
				<fieldset>
					<legend>{$mod->Lang('filemanager_options')}</legend>

					<div class="c_full cf">
						<div class="grid_6">
							{checkbox fld_name='filemanager_delete_files' simple=true}
							{checkbox fld_name='filemanager_create_folders' simple=true}
							{checkbox fld_name='filemanager_delete_folders' simple=true}
							{checkbox fld_name='filemanager_upload_files' simple=true}
							{checkbox fld_name='filemanager_rename_files' simple=true}
							{checkbox fld_name='filemanager_rename_folders' simple=true}
							{checkbox fld_name='filemanager_duplicate_files' simple=true}
						</div>
						<div class="grid_6">
							{checkbox fld_name='filemanager_copy_cut_files' simple=true}
							{checkbox fld_name='filemanager_copy_cut_dirs' simple=true}
							{checkbox fld_name='filemanager_chmod_files' simple=true}
							{checkbox fld_name='filemanager_chmod_dirs' simple=true}
							{checkbox fld_name='filemanager_preview_text_files' simple=true}
							{checkbox fld_name='filemanager_create_text_files' simple=true}
							{checkbox fld_name='filemanager_edit_text_files' simple=true}
						</div>
					</div>
				</fieldset>
			</div>

			<div class="pageoverflow">
				<fieldset>
					<legend>{$mod->Lang('filemanager_image_resizing_title')} {cms_help title=$mod->Lang('filemanager_image_resizing_title') key='help_filemanager_image_resizing'}</legend>
					{checkbox fld_name='filemanager_image_resizing' simple=true}

					<div class="c_full cf">
						<div class="grid_6">
							{text_input fld_name='filemanager_image_resizing_width' ext='px' size=3}
						</div>
						<div class="grid_6">
							{text_input fld_name='filemanager_image_resizing_height' ext='px' size=3}
						</div>
					</div>
				</fieldset>
			</div>


			<div class="pageoverflow">
				<fieldset>
					<legend>{$mod->Lang('filemanager_photo_editor')} {cms_help title=$mod->Lang('filemanager_photo_editor') key="help_aviary"}</legend>
					{checkbox fld_name='filemanager_aviary_active' simple=true}

					{text_input fld_name='filemanager_aviary_apiKey' size=40}
				</fieldset>
			</div>



		{* USER GROUPS ************************************* *}
		{tab_start name='users_groups'}
			<div class="pageoverflow">
				{label text='usergroups' for='usergroups' help='usergroups'}
				<p class="pageinput">
					<select name="{$actionid}usergroups[]" id="usergroups" multiple="multiple" size="5">
						{html_options options=$usergroups selected=$profile->usergroups_ids}
					</select>
				</p>
			</div>

			{text_input fld_name='priority' help='priority' size=3}



		{* TEMPLATES ************************************* *}
		{tab_start name='templates'}
			<div class="pageoverflow">
				{label text='js_template' for='id_template' help='js_template'}
				<p class="pageinput">
					<select name='{$actionid}id_template' id="id_template">
						<option value="-1" {if $profile->id_template eq -1}selected="selected"{/if}>
							- {$mod->Lang('orig_js_template_file')} -
						</option>

						{if !empty($templates)}
							<option value="0" {if $profile->id_template eq 0}selected="selected"{/if}>
								- {$mod->Lang('default_designmanager_template')} -
							</option>
							{foreach $templates as $template}
								<option value="{$template->get_id()}" {if $template->get_id() eq $profile->id_template}selected="selected"{/if}>
									{$template->get_name()}
								</option>
							{/foreach}
						{/if}
					</select>
				</p>
			</div>

			{textarea fld_name='extra_js' help='extra_js'}

			<hr>

			<div class="pageoverflow">
				{checkbox fld_name='enable_user_templates' help='user_templates'}
			</div>



		{tab_end}





		{submit_form_buttons}



	{form_end}
</div>
