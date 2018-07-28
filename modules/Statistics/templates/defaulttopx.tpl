{foreach from=$entries item=entry}
  {$entry->index}. {cms_selflink page=$entry->alias text=$entry->title}
  <br/>
{/foreach}