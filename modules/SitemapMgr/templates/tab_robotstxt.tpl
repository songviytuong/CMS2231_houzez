<div class="c_full cf">
	<div class="grid_6">
		{form_start action='save_robotstxt'}
			{if !empty($robotstxt_available)}<p class="warning">{$robotstxt_available}</p>{/if}
			<div class="pageoverflow">
				<p class="pagetext">{$label_content}:</p>
				<p class="pageinput">{$input_robotstxt_content}</p>
			</div>
			<br />
			<div class="pageoverflow">
				{*<p class="pagetext">&nbsp;</p>*}
				<p class="pageinput">{$submit}{$cancel}<input class="cms_submit" name="m1_reset" id="m1_reset" value="{$reset}" type="submit" onclick="return confirm('{$areyousure}')" /></p>
			</div>
			<br />
			{if !empty($open_file)}
				<div class="pageoverflow">
					<p class="pagetext" style="padding: 10px; background: #f0f0f0; border: #ddd solid 1px;">robots.txt: {$open_file}</p>
					{*<p class="pageinput"></p>*}
			</div>
			{/if}
		{form_end}
	</div>
	<div class="grid_6">
		<div class="pageoverflow">
			<p class="information">{$about_robotstxt}</p>
		</div>
	</div>
</div>