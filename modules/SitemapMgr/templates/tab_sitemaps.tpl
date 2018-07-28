<div class="c_full cf">
	<div class="grid_6">
		{form_start action='save_sitemaps'}
			<div class="pageoverflow">
				<p class="pagetext">{$label_create_sitemap}:</p>
				{*<p class="pageinput"></p>*}
			</div>
			<div class="pageoverflow">
				<p class="pagetext">{$label_new_sitemap}:</p>
				<p class="pageinput">{$input_new_sitemap}</p>
			</div>
			<div class="pageoverflow">
				<p class="pagetext">{$label_sitemap_type}:</p>
				<p class="pageinput">{$input_sitemap_type}</p>
			</div>
			<br />
			<div class="pageoverflow">
				{*<p class="pagetext">&nbsp;</p>*}
				<p>{$create_new_sitemap}{$cancel}</p>
			</div>
			<br />
			<div class="pageoverflow" style="padding: 10px; background: #f0f0f0; border: #ddd solid 1px;">
				<p class="pageinput"><b>{$label_sitemap_index}: {$open_file}</b></p>
				<p class="pageinput">{$help_sitemap_index}</p>
			</div>
		{form_end}
	</div>
	<div class="grid_6">
		<div class="pageoverflow">
			<p class="pagetext">{$label_documentation}</p>
			<p class="pageinput">{$sitemap_documentation}</p>
		</div>
	</div>
</div>