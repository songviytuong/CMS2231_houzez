{literal}
<script type="text/javascript">
(function($){
	var selectors = ['jmfp_thumb_upload_action'];
	$(document).ready(function(){
		for(var i=0; i<selectors.length; i++) {
			$("#" + selectors[i]).change(function() {
				var v = this.value;
				$('.' + this.id).each(function(){
					var $this = $(this),
						a = $this.hasClass('jmfp_value_' + v),
						m = (a && v != '');
					if(m) {
						$this.find('input').removeAttr('disabled');
						$this.slideDown();
					}
					else {
						$this.slideUp();
						$this.find('input').attr('disabled', 'disabled');
					}
				});
			});
		}
	});
})(jQuery);
</script>
{/literal}
{$startForm}
<fieldset>
	<legend>{$settings_text}</legend>
	<div class="pageoverflow">
		<p class="pagetext">{$show_filemanagement_text}:</p>
		<p class="pageinput">{$show_filemanagement_input}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$show_thumbfiles_text}:</p>
		<p class="pageinput">{$show_thumbfiles_input}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$allow_scaling_text}:</p>
		<p class="pageinput">{$allow_scaling_input}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$force_scaling_text}:</p>
		<p class="pageinput">{$force_scaling_input}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$scaling_width_text}:</p>
		<p class="pageinput">{$scaling_width_input}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$scaling_height_text}:</p>
		<p class="pageinput">{$scaling_height_input}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$allow_upscaling_text}:</p>
		<p class="pageinput">{$allow_upscaling_input}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$restrict_users_diraccess_text}:</p>
		<p class="pageinput">{$restrict_users_diraccess_input}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$create_thumbs_text}:</p>
		<p class="pageinput">{$create_thumbs_input}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$use_mimetype_text}:</p>
		<p class="pageinput">{$use_mimetype_input}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$thumb_upload_action_text}:</p>
		<p class="pageinput">{$thumb_upload_action_input}</p>
		<p class="pageinput jmfp_thumb_upload_action jmfp_value_1"{if !$thumb_upload_action} style="display:none"{/if}>
			{$thumb_prefix_replacement_text}: {$thumb_prefix_replacement_input}
		</p>
	</div>
  {*
	<div class="pageoverflow">
		<p class="pagetext">{$default_admin_theme_text}:</p>
		<p class="pageinput">{$default_admin_theme_input}</p>
	</div>
  *}
	{if isset($feu_access_text)}
	  <div class="pageoverflow">
		  <p class="pagetext">{$feu_access_text}:</p>
		  <p class="pageinput">{$feu_access_input}</p>
	  </div>
    {*
	  <div class="pageoverflow">
		  <p class="pagetext">{$default_frontend_theme_text}:</p>
		  <p class="pageinput">{$default_frontend_theme_input}</p>
	  </div>
    *}
	{/if}
	<div class="pageoverflow">
		<p class="pagetext">&nbsp;</p>
		<p class="pageinput">{$submit}</p>
	</div>
</fieldset>
{$endForm}
