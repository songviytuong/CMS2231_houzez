{literal}
<script type="text/javascript">
$(document).ready(function() {
	$('#maxlength').hide();
	$('#properties').hide();
	$('#parsesmarty').hide();
	$('#fieldtype').change(function() {
		if ($('#fieldtype').val() == 'textfield')
		{
			$('#maxlength').slideDown('slow');
			$('#properties').slideUp('slow');
			$('#parsesmarty').slideUp('slow');
		}
		else if ($('#fieldtype').val() == 'pulldown' || $('#fieldtype').val() == 'radiobuttons')
		{
			$('#maxlength').slideUp('slow');
			$('#properties').slideDown('slow');
			$('#parsesmarty').slideUp('slow');
		}
		else if ($('#fieldtype').val() == 'textarea' || $('#fieldtype').val() == 'wysiwyg')
		{
			$('#maxlength').slideUp('slow');
			$('#properties').slideUp('slow');
			$('#parsesmarty').slideDown('slow');
		}
		else
		{
			$('#maxlength').slideUp('slow');
			$('#properties').slideUp('slow');
			$('#parsesmarty').slideUp('slow');
		}
	});
	$('#fieldtype').change();
});
</script>
{/literal}
<div class="pageoverflow">
<h3>{$title}</h3>
</div>
{$formstart}{$hidden}

<div class="pageoverflow">
  <p class="pagetext">{$prompt_name}:</p>
  <p class="pageinput">{$name}</p>
</div>

<div class="pageoverflow">
  <p class="pagetext">{$prompt_type}:</p>
  <p class="pageinput">{$type}</p>
</div>

<div class="pageoverflow" id="maxlength">
  <p class="pagetext">{$prompt_maxlength}:</p>
  <p class="pageinput">{$maxlength}</p>
</div>

<div class="pageoverflow" id="properties">
  <p class="pagetext">{$prompt_properties}:</p>
  <p class="pageinput">{$help_properties}</p>
  <p class="pageinput">{$properties}</p>
</div>

<div class="pageoverflow" id="parsesmarty">
  <p class="pagetext">{$prompt_parsesmarty}:</p>
  <p class="pageinput">{$parsesmarty}</p>
</div>

<div class="pageoverflow">
  <p class="pagetext">{$prompt_help}:</p>
  <p class="pageinput">{$help}</p>
</div>

<div class="pageoverflow">
  <p class="pagetext">{$prompt_clearcache}:</p>
  <p class="pageinput">{$clearcache} {$help_clearcache}</p>
</div>

<div class="pageoverflow">
  <p class="pagetext">{$prompt_editors}:</p>
  <p class="pageinput">{$editors}</p>
</div>

<div class="pageoverflow">
  <p class="pagetext">{$prompt_tabs}:</p>
  <p class="pageinput">
  {foreach $tabs as $tab}
    {$tab}<br />
  {/foreach}
  </p>
</div>

<div class="pageoverflow">
  <p class="pagetext">&nbsp;</p>
  <p class="pageinput">{$submit}{$cancel}</p>
	<p>&nbsp;</p>
</div>

{$formend}