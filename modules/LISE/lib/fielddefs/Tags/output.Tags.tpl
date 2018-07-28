{$name}:
{foreach $tags as $k => $v}
  <a href="{$v}">{$k}</a>
{foreachelse}
{/foreach}