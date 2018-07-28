<div class="pageoverflow">
<h3>{$title}</h3>
</div>
{$javascript}
{$formstart}
<div class="pageoverflow">
  <p class="pagetext">{$prompt_templatename}:</p>
  <p class="pageinput">{$templatename}</p>
</div>

<div class="pageoverflow">
  <p class="pagetext">{$prompt_type}:</p>
  <p class="pageinput">{$type}&nbsp;&nbsp;»&nbsp;{$reset}</p>
</div>

<div class="pageoverflow">
  <p class="pagetext">{$prompt_template}:</p>
  <p class="pageinput">{$template}</p>
</div>

<div class="pageoverflow">
  <p class="pagetext">&nbsp;</p>
  <p class="pageinput">{$submit}{$cancel}{$apply}</p>
</div>
{*
<div class="pageoverflow">
  <p class="pagetext">{$availablevariables}: <a href="#" onclick="togglecollapse('variablesinfo'); return false;">{$availablevariableslink}</a></p>
</div>
<div id="variablesinfo" style="display: none;">
<div class="pageoverflow">
  <p class="pageinput">{$availablevariableslist}</p>
</div>
</div>
*}
{$formend}
