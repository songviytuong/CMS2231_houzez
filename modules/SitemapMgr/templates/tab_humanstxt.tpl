<style>
	.warning, .information { width: 90% }
	.cms_textarea { height: 300px; width: 90%; }
	.cms_dropdown { width: 100% }
	.cms_textfield { width: 98% }
	p { padding-bottom: 15px }
	a:hover { text-decoration: none }
</style>

<div class="c_full cf">
	<div class="grid_6">
		{form_start action='save_humanstxt'}
			{if !empty($humanstxt_available)}<p class="warning">{$humanstxt_available}</p>{/if}
			<div class="pageoverflow">
				<p class="pagetext">{$label_content}:</p>
				<p class="pageinput">{$input_humanstxt_content}</p>
			</div>
			<br />
			<div class="pageoverflow">
				{*<p class="pagetext">&nbsp;</p>*}
				<p class="pageinput">{$submit}{$cancel}<input class="cms_submit" name="m1_reset" id="m1_reset" value="{$reset}" type="submit" onclick="return confirm('{$areyousure}')" /></p>
			</div>
			<br />
			{if !empty($open_file)}
				<div class="pageoverflow">
					<p class="pagetext" style="padding: 10px; background: #f0f0f0; border: #ddd solid 1px;">humans.txt: {$open_file}</p>
					{*<p class="pageinput"></p>*}
				</div>
			{/if}
		{form_end}
	</div>
	<div class="grid_6">
		<div class="pageoverflow">
			<p class="information">{$about_humanstxt}</p>
		</div>
	</div>
</div>