<div class="c_full cf">
	<div class="grid_6">
		{form_start action='save_sitemap'}
			{$sitemap_id}
			{if !empty($sitemap_available)}<p class="warning">{$sitemap_available}</p>{/if}
			<div class="pageoverflow">
				<p class="pagetext">{$label_sitemap_type}: {$sitemap_type|replace:'_':' '|capitalize}</p>
				{*<p class="pageinput"></p>*}
			</div>
			<div class="pageoverflow">
				<p class="pagetext">{$label_sitemap_name}:</p>
				<p class="pageinput">{$input_sitemap_name}{$input_sitemap_name_hidden}</p>
			</div>
			<div class="pageoverflow">
				<p class="pagetext">{$label_sitemap_tag}:</p>
				<p class="pageinput">{$input_sitemap_tag}</p>
			</div>
			<br />
			<div class="pageoverflow">
				{*<p class="pagetext">&nbsp;</p>*}
				<p class="pageinput">{$submit}{$cancel}</p>
			</div>
			<br />
			<div class="pageoverflow">
				<p class="pagetext" style="padding: 10px; background: #f0f0f0; border: #ddd solid 1px;">{$label_sitemap}: {$open_file}</p>
				{*<p class="pageinput"></p>*}
			</div>
			<div class="pageoverflow">
				<p class="pagetext">{$label_delete_sitemap}:</p>
				<p class="pageinput">
					<input class="cms_submit" name="m1_delete_sitemap" id="m1_delete_sitemap" value="{$delete}" type="submit" onclick="return confirm('{$areyousure}')" />
				</p>
			</div>
		{form_end}
	</div>
	<div class="grid_6">
		<div class="pageoverflow">
			<p class="pagetext">{$label_description}</p>
			<p class="pageinput">{$sitemap_description}</p>
		</div>
		<div class="pageoverflow">
			<p class="pagetext">{$label_documentation}</p>
			<p class="pageinput">{$sitemap_documentation}</p>
		</div>
		{if !empty($template_content)}
			<div class="pageoverflow">
				<p class="pagetext">{$label_default_template_content}</p>
				<p class="pageinput">{$template_content}</p>
			</div>
		{/if}
	</div>
</div>