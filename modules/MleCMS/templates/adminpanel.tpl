{if isset($activelang)}{$langList}<br/><br/>{/if}

{if isset($title_section)}}<h3>{$title_section}</h3>{/if}
{if $add}
<div class="pageoptions">
	<p class="pageoptions">{$addSnippetIcon} {$addSnippetLink}
            <a id="toggle_filter" onclick="popup(this);" data-prefix="{$prefix}">{admin_icon icon='view.gif' alt=$mod->Lang('viewfilter')} {$mod->Lang('viewfilter')}</a>
        </p>
</div>
{/if}
{if $snippets|@count > 0}
    <table cellspacing="0" class="pagetable">
        <thead>
            <tr>
{*                <th>{$title}</th>*}
                <th style="width:50%;">{$title_tag}</th>
                <th>{$title_content}</th>
                <th class="pageicon" style="width:20px"> </th>
                {if $delete}<th class="pageicon" style="width:20px"> </th>{/if}
            </tr>
        </thead>
        <tbody>
            {foreach from=$snippets item=entry}
                <tr class="{$entry->rowclass}" onmouseover="this.className='{$entry->rowclass}hover';" onmouseout="this.className='{$entry->rowclass}';">
{*                    <td>{$entry->edit}</td>*}
                    <td>{literal}{MleCMS name='{/literal}{$entry->name}{literal}'}{/literal}</td>
                    <td>{$entry->content}</td>
                    <td>{$entry->editlink}</td>
                    {if $delete}
                        <td>{$entry->deletelink}</td>
                    {/if}
                </tr>
            {/foreach}
        </tbody>
    </table>
{/if}

{if $add}
<div class="pageoptions">
	<p class="pageoptions">{$addSnippetIcon} {$addSnippetLink}</p>
</div>
{/if}

<div id="log"></div>

<script type="text/javascript">
//<![CDATA[ 

   $("#filter_translate").autocomplete({
      source: '{cms_action_url action=admin_ajax_pagelookup forjs=1}&showtemplate=false',
      minLength: 3,
      change: function( event, ui ) {
          
      }
    });
    
    function popup(obj){
        $('#filter_language').dialog({
            width: 'auto',
            modal: true
        });
    }
//]]>
</script>
{if isset($formstart) }
    <div id="filter_language" title="{$filtertext}" style="display: none;">
        {$formstart}
        <div class="pageoverflow">
            <p class="pagetext"><label for="filter_pagelimit">{$prompt_translate}:</label></p>
            <p class="pageinput"><input type="text" name="filter_translate" id="filter_translate" /></p>
        </div>
        <div class="pageoverflow">
            <p class="pagetext"><label for="filter_pagelimit">{$prompt_pagelimit}:</label> {cms_help key='help_articles_pagelimit' title=$prompt_pagelimit}</p>
            <p class="pageinput">
                <select id="filter_pagelimit" name="{$actionid}pagelimit">
                    {html_options options=$pagelimits selected=$sortby}
                </select>
            </p>
        </div>
        <div class="pageoverflow">
            <p class="pageinput">
                <input type="submit" name="{$actionid}submitfilter" value="{$mod->Lang('submit')}"/>
                <input type="submit" name="{$actionid}resetfilter" value="{$mod->Lang('reset')}"/>
            </p>
        </div>
        {$formend}
    </div>
{/if}

