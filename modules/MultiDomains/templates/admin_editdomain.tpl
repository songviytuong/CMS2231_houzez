{$formstart}
{$tabto}
{$prefix}
{$domain}
<fieldset>
<legend>{$domainedit}</legend>
<div class="pageoverflow">
    <p class="pagetext">{$prompt_domainid}:</p>
    <p class="pageinput">{$domainid}</p>
</div>
<div class="pageoverflow">
    <p class="pagetext">{$prompt_active}:</p>
    <p class="pageinput">{$input_active}</p>
</div>
<div class="pageoverflow">
    <p class="pagetext">{$prompt_root}:</p>
    <p class="pageinput">{$input_root}<br />{$help_root}</p>
</div>
<div class="pageoverflow">
    <p class="pagetext">{$prompt_prefix}:</p>
    <p class="pageinput">{$input_prefix}</p>
</div>
<div class="pageoverflow">
    <p class="pagetext">{$prompt_domainname}{if !$check_prefix} ({$www_notice}){/if}:</p>
    <p class="pageinput">{if $check_prefix}{$wwwreplace}.{/if}{$input_domainname}</p>
</div>
{if $check_devdomain=='1'}
	<div class="pageoverflow">
		<p class="pagetext">{$prompt_devdomainname}{if !$check_prefix} ({$www_notice}){/if}:</p>
		<p class="pageinput">{if $check_prefix}{$wwwreplace}.{/if}{$input_devdomainname}</p>
	</div>
{/if}
<div class="pageoverflow">
    <p class="pagetext">{$prompt_page}:</p>
    <p class="pageinput">{$input_page}</p>
</div>
<div class="pageoverflow">
	<p class="pagetext">{$prompt_extradomains}:</p>
    <p class="pageinput">
		{$description_extradomains}<br />
		{$input_extradomains}
	</p>
</div>
<div class="pageoverflow">
	<p class="pagetext">{$prompt_notes}:</p>
    <p class="pageinput">{$domain_notes}</p>
</div>
<div class="pageoverflow">{$submit}{$cache}{$reset}{$cancel}</div>
</fieldset>
{$formend}