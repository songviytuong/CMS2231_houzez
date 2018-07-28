{* newer ga stuff -- slightly faster, not compatibile with some older browsers *}
<script async src='//www.google-analytics.com/analytics.js'></script>
<script>window.ga=window.ga||function(){ (ga.q=ga.q||[]).push(arguments) };ga.l=+new Date;
var _props = { };
{if !empty($config.cghm_ga_subdomains) && $config.cghm_ga_subdomains}{* handle subdomains *}_props.cookieDomain = '{$domain}',{/if}
{if !empty($config.cghm_ga_linkdomains) && $config.cghm_ga_linkdomains}{* linking to top level domains *}_props.allowLinker = true;{/if}
ga('create', '{$config.cghm_ga_propertyid}', _props);
{if !empty($config.cghm_ga_linkid) && $config.cghm_ga_linkid}ga('require', 'linkid', 'linkid.js');{/if}
{if !empty($config.cghm_ga_displayfeatures) && $config.cghm_ga_displayfeatures}ga('require', 'displayfeatures');{/if}
{if !empty($linkdomains)}
ga('require','linker');
ga('linker:autoLink', {json_encode($linkdomains)} );
{/if}
ga('send','pageview');
</script>