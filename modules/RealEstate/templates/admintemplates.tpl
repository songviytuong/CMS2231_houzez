{if $itemcount > 0}
    <table class="pagetable">
        <thead>
            <tr>
                <th class="pageicon">#</th>
                <th>{$templates}</th>
                <th class="pageicon"></th>
                <th class="pageicon"></th>
                <th class="pageicon"></th>
            </tr>
        </thead>
        <tbody>
            {foreach from=$items item=entry}
                {cycle values="row1,row2" assign=rowclass}
                <tr class="{$rowclass}" onmouseover="this.className = '{$rowclass}hover';" onmouseout="this.className = '{$rowclass}';">
                    <td>{$entry->id}</td>
                    <td>{$entry->name}</td>
                    <td>{$entry->editlink}</td>
                    <td>{$entry->copylink}</td>
                    <td>{if $itemcount > 1}{$entry->deletelink}{/if}</td>
                </tr>
            {/foreach}
        </tbody>
    </table>
{else}
    <h4>{$notemplatestext}</h4>
{/if}

<div class="pageoptions">
    <p class="pageoptions">{$addlink}</p>
</div>