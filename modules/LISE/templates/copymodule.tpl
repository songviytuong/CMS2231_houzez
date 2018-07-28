<h3>{$mod->Lang('copy_title')}</h3>
{$startform}
<div class="pageoverflow">
    <p class="pagetext">* {$mod->ModLang('module_name')}:</p>
    <p class="pageinput">{$input_module_name}</p>
</div>

{if $autoinstall}
<div class="pageoverflow">
    <p class="pagetext">* {$mod->ModLang('instance_friendlyname')}:</p>
    <p class="pageinput">{$input_module_friendlyname}</p>
</div>
<div class="pageoverflow">
    <p class="pagetext">{$mod->ModLang('prompt_moddescription')}:</p>
    <p class="pageinput">{$input_moddescription}</p>
</div>      
<div class="pageoverflow">
    <p class="pagetext">{$mod->ModLang('prompt_adminsection')}:</p>
    <p class="pageinput">{$input_adminsection}</p>
</div> 
{/if}

<div class="pageoverflow">
    <p class="pagetext">&nbsp;</p>
    <p class="pageinput">{$submit}{$cancel}</p>
</div>
{$endform}

