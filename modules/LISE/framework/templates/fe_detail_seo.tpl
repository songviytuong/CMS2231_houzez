{if $item->active == 1}
{foreach from=$item->fielddefs item=fielddef}
    {if $fielddef.value && $fielddef.type != 'Categories'}
        {if $fielddef.type == 'SelectFile' || $fielddef.type == 'FileUpload'}
                {assign var="img" value="{$fielddef->GetImagePath(true)}/{$fielddef.value}"}
        {/if}
    {/if}
{/foreach}
{if isset($img)}
{assign var="seo_image" value="{CGSmartImage src=$img filter_resize='h,400' notag=1 noembed=1}"}
{assign var="meta_image" value="{root_url}/{$seo_image}" scope="global"}
{/if}
{assign var="meta_title" value="{$item->fielddefs.meta_title->value|strip_tags:false}" scope="global"}
{assign var="meta_keywords" value="{$item->fielddefs.meta_keywords->value|strip_tags:false}" scope="global"}
{assign var="meta_description" value="{$item->fielddefs.meta_description->value|strip_tags:false|truncate:'200':"":false}" scope="global"}
{/if}

{*
    Category: Modules (modules)
        - List
        - Page
        - Products
    Field Definitions: Meta Title (text), Meta Picture (file upload), Meta Keywords (tags), Meta Description (textarea)
*}