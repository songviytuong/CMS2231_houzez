<!-- {$JQueryTools->GetName()} version {$JQueryTools->GetVersion()} -->
{if isset($libs)}
{foreach from=$libs item='one'}
<script type="text/javascript" src="{$one}"></script>
{/foreach}
{/if}
{if isset($css)}
{foreach from=$css item='one'}
<link rel="stylesheet" type="text/css" href="{$one}" media="screen" />
{/foreach}
{/if}