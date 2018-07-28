<div class="pageoverflow">
<h3>{$title}</h3>
</div>
{$formstart}
<div class="pageoverflow">
  <p class="pagetext">{$prompt_name}:</p>
  <p class="pageinput">{$name}</p>
</div>

<div class="pageoverflow">
  <p class="pagetext">{$prompt_catlang}:</p>
  <p class="pageinput">{$catlang}</p>
</div>

<div class="pageoverflow">
  <p class="pagetext">{$prompt_active}:</p>
  <p class="pageinput">{$active}</p>
</div>

{if !empty($import_csv)}
<div class="pageoverflow">
  <p class="pagetext">{$prompt_import_csv}:</p>
  <p class="pageinput">{$import_csv}</p>
  <p class="pageinput">{$csv_format}</p>
</div>
{/if}

<div class="pageoverflow">
  <p class="pagetext">&nbsp;</p>
  <p class="pageinput">{$submit}{$cancel}{*$apply*}</p>
</div>
{$formend}
