{if $tabs|count}
	{if !{jmfp_cms2}}{$start_tabheaders}{/if}
		{foreach $tabs as $tab}
			{$tab.tabheader|print_r:1}
		{/foreach}
	{if !{jmfp_cms2}}{$end_tabheaders}
	{$start_tabcontent}{/if}
		{foreach $tabs as $tab}
			{$tab.tabcontent}
		{/foreach}
	{if !{jmfp_cms2}}{$end_tabcontent}{/if}
{/if}
