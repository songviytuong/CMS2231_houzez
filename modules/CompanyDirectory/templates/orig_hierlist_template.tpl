{function do_hierdata depth=1}
  <ul class="cd_hier-{$depth}">
  {foreach $data as $key => $item}
      <li>
        {if $item.count gt 0}
          <a href="{$item.url}">{$item.name} <em>({$item.count})</em></a>
        {else}
          {$item.name} <em>({$item.count})</em>
        {/if}
        {if isset($item.children) && count($item.children) > 0}
          {do_hierdata depth=$depth+1 data=$item.children}
        {/if}
      </li>
  {/foreach}
  </ul>
{/function}

{do_hierdata data=$hierdata}
