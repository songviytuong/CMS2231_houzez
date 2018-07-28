{if isset($message) && $message!=''}<p>{$message}</p>{/if}
{$startform}
	<div class="pageoverflow">
		<p class="pagetext">{$prompt_subnet_exclusions}:</p>
		<p class="pageinput">{$input_subnet_exclusions}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$mod->Lang('statreport_linesperpage')}:</p>
		<p class="pageinput"><input type="text" name="{$actionid}statreport_linesperpage" value="{$statreport_linesperpage}" size="3" maxlength="3"/></p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$mod->Lang('prompt_hidefrombots')}:</p>
		<p class="pageinput">{cge_yesno_options prefix=$actionid name='hide_from_bots' selected=$hide_from_bots}</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$prompt_dflt_template}:</p>
		<p class="pageinput">{$input_dflt_template}
		  <br/>
                  {$prompt_reset}&nbsp;{$input_reset}
                </p>
	</div>
        {if isset($input_createpath)}
	<div class="pageoverflow">
		<p class="pagetext">&nbsp;</p>
		<p class="pageinput">{$input_createpath}</p>
	</div>
        {/if}
	<div class="pageoverflow">
		<p class="pagetext">&nbsp;</p>
		<p class="pageinput">{$submit}{$cancel}</p>
	</div>
{$endform}
