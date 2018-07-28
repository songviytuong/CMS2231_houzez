{* CompanyDirectory Detail Template *}
{strip}
<article class="CompanyDirectoryItem">
  {if isset($entry->canonical)}{$canonical=$entry->canonical}{/if}
  <div class="row-fluid">
     <div class="span2">
       {if $entry->logo_location ne ''}
         <div class="row-fluid">
         {CGSmartImage src=$entry->logo_path max_width=150 max_height=150}
         </div>
       {/if}

       {if $entry->picture_location ne ''}
         <div class="row-fluid">
         {CGSmartImage src=$entry->picture_path max_width=800 max_height=600 notag=1 noembed=1 assign='picture_url'}
         <a class="fancybox" href="{$picture_url}">{CGSmartImage src=$entry->picture_path max_width=150 max_height=150}</a>
         </div>
       {/if}
     </div>

     <div class="span10">
       <h4>{if $entry->website !=''}<a class="external" href="{$entry->website}" title="{$CompanyDirectory->Lang('view_website')}">{$entry->company_name}</a>{else}{$entry->company_name}{/if}</h4>
       <div class="row-fluid">
         {$entry->address}
       </div>
       {if $entry->telephone ne ''}
         <div class="row-fluid">
           {$CompanyDirectory->Lang('telephone')}: {$entry->telephone}
         </div>
       {/if}
       {if $entry->fax ne ''}
         <div class="row-fluid">
           {$CompanyDirectory->Lang('fax')}: {$entry->fax}
         </div>
       {/if}
       {if $entry->contact_email ne ''}
         <div class="row-fluid">
           {$CompanyDirectory->Lang('contactemail')}: <a href="mailto:{$entry->contact_email}">{$entry->contact_email}</a>
         </div>
       {/if}

       {if $entry->hier_id > 0}
         <div class="row-fluid">
           {$CompanyDirectory->Lang('hierarchy')}: {cd_hierbreadcrumb page=$summarypage hier=$entry->hier_id hier_children=1}
         </div>
       {/if}

       {if isset($categories)}
         <div class="row-fluid">
         {$CompanyDirectory->Lang('categories')}:&nbsp;
         {foreach $categories as $catname => $rec}
	   {module_action_link action=default category=$rec->id urlonly=1 assign=url}
           <a href="{$url}" title="{$rec->description|strip_tags|summarize:40}">{$catname}</a>{if !$rec@last},  {/if}
         {/foreach}
         </div>
       {/if}

       {if $entry->details ne ''}
         <div class="row-fluid" style="border-top: 1px solid silver; margin-top: 0.5em;">{$entry->details}</div>
       {/if}

       {if isset($entry->fields) }
         {* handle everything but images *}
         {$have_images=0}
         {foreach from=$entry->fields key='field_name' item=customfield}
           {if $customfield->type == 'image'}
             {$have_images=1}
           {else}
             <div class="row-fluid">
               {$customfield->name}:&nbsp;
               {if $customfield->type == 'file'}
                  <a href="{$customfield->file_url}">{$customfield->value}</a>
               {else}
                 {$customfield->name}: {$customfield->value}
               {/if}
             </div>
           {/if}
         {/foreach}

         {* now handle images *}
         {if $have_images}
           <div class="row-fluid">
           {foreach from=$entry->fields key='field_name' item=customfield}
             <div class="span2">
               {CGSmartImage src=$customfield->url max_width=800 max_height=600 notag=1 noembed=1 assign='img'}
               <a class="fancybox" href="{$img}" rel="img_album">{CGSmartImage src=$customfield->url width=150 height=150}</a>
             </div>
           {/foreach}
           </div>
         {/if}
       {/if}

     </div>{* span10 *}
  </div>{* top row *}
</article>
{/strip}