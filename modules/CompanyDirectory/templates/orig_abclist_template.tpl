{* default abclist template *}
<style type="text/css">
nav.abclist ul {
   list-style-type: none;
}
nav.abclist li.current a {
   color: red;
}
nav.abclist li {
   display: inline-block;
   margin-right: 0.5em;
}
</style>

{if !empty($error)}
   <div class="alert alert-danger">{$error}</div>
{else}
   <nav class="abclist">
     <ul>
       {foreach $abclist as $letter => $rec}
         <li {if $rec.current}class="current"{/if}>
	   {if $rec.count < 1}
	     {$letter}
	   {else}
  	     <a href="{$rec.url}" title="{$rec.count}">{$letter}</a>
	   {/if}
	 </li>
       {/foreach}
     </ul>
   </nav>

   {if !empty($items)}
      <h3>Items</h3>
      {* pagination *}
      {$npages = $pagination->get_page_count()}
      {if $npages > 1}
         <div class="row text-right">
	    {$page=$pagination->get_current_page()}
	    {if $page > 1}
	      <a href="{$pagination->get_firstpage_url()}">{$mod->Lang('firstpage')}</a>&nbsp;
	      <a href="{$pagination->get_prevpage_url()}">{$mod->Lang('prevpage')}</a>&nbsp;
	    {/if}
	    {$mod->lang('page')} {$page} {$mod->Lang('of')} {$npages}
	    {if $page < $npages}
	      <a href="{$pagination->get_nextpage_url()}">{$mod->Lang('nextpage')}</a>&nbsp;
	      <a href="{$pagination->get_lastpage_url()}">{$mod->Lang('lastpage')}</a>&nbsp;
	    {/if}
	 </div>
      {/if}

      {foreach $items as $item}
      <div class="row CompanyDirectoryItem">
        {if $item->picture_location}
	  <div class="col-sm-3">{CGSmartImage src=$item->picture_path height=150 width=150}</div>
	{/if}
	<div class="col-sm-9 row">
  	  <h4><a href="{$item->detail_url}">{$item->company_name}</a></h4>
	  {if $item->address}<p>{$item->address}</p>{/if}
	  {if $item->website}<p>{$item->website}</p>{/if}
        </div>
      </div>
      {/foreach}
   {/if}
{/if}