<?php
$lang['changelog'] = '<ul>
<li>1.1 - February, 2008
  <p>Added module_action_link</p>
</li>
<li>1.0 - December, 2007
  <p>Initial release</p>
</li>
</ul>';
$lang['friendlyname'] = 'CGSimpleSmarty';
$lang['help'] = '<h3>Co tento modul děl&aacute;?</h3>
<p>Tento modul poskytuje několik jednoduch&yacute;ch pomůcek pro pr&aacute;ci s &scaron;ablonovac&iacute;m syst&eacute;mem Smarty ve Va&scaron;ich aplikac&iacute;ch nebo při modifikaci chov&aacute;n&iacute; Va&scaron;ich str&aacute;nek.</p>
<h3>Jak tento modul použ&iacute;t:</h3>
<p>Po instalaci tohoto modulu můžete ve Va&scaron;ich &scaron;ablon&aacute;ch str&aacute;nek, bloc&iacute;ch obsahu a &scaron;ablon&aacute;ch modulů zač&iacute;t použ&iacute;vat nov&yacute; Smarty objekt pojmenovan&yacute; <i>cgsimple</>. Tento objekt zpřistupňuje mnoho funkc&iacute;, kter&eacute; můžete zač&iacute;t použ&iacute;vat.</p>
<h4>Dostupn&eacute; funkce:</h4>
<ul>
<li><strong>module_installed</strong>($modulename,[$assign])
    <p>Testuje, zda je dan&yacute; modul nainstalov&aacute;n.</p>
    <p>Arguments:
       <ul>
         <li>$modulename - Jm&eacute;no modulu, k němuž se vztahuje kontrola.</li>
         <li>[$assign]   - (optional) The name of a variable to assign the results to.</li>
      </ul>  
    <br/></p>
    <p>Př&iacute;klad:<br/>
    <pre>{if $cgsimple->module_installed(&#039;FrontEndUsers&#039;)}Found FEU{/if}</pre>
    </p>
</li>

<li><strong>module_version</strong>($modulename,[$assign])
    <p>Vr&aacute;t&iacute; č&iacute;slo verze urit&eacute;ho nainstalovan&eacute;ho modulu</p>
    <p>Arguments:
       <ul>
         <li>$modulename - Jm&eacute;no modulu, jehož č&iacute;slo verze chcete zjistit.</li>
         <li>[$assign]   - (optional) The name of a variable to assign the results to.</li>
      </ul>  
    <br/></p>
    <p>Př&iacute;klad:<br/>
    <pre>{$cgsimple->module_version(&#039;FrontEndUsers&#039;,&#039;feu_version&#039;)}We have Version {$feu_version} of FrontEndUsers</pre>
    </p>
</li>

<li><strong>get_parent_alias</strong>([$alias],[$assign])
    <p>Vr&aacute;t&iacute; alias str&aacute;nky bezprostředně rodičovsk&eacute; vůči zadan&eacute; str&aacute;nce.</p>
    <p>Arguments:
       <ul>
       <li>[$alias] - (optional) Alias str&aacute;nky, jej&iacute;ž rodič bude vyps&aacute;n.  Pokud nen&iacute; uvedena ž&aacute;dn&aacute; hodnota, bude použita současn&aacute; str&aacute;nka.</li>
       <li>[$assign]   - (optional) The name of a variable to assign the results to.</li>
       </ul>  
    <br/></p>
    <p>Př&iacute;klad:<br/>
    <pre>The parent page alias is {$cgsimple->get_parent_alias()}</pre>
    </p>
</li>

<li><strong>get_root_alias</strong>([$alias],[$assign])
    <p>Vr&aacute;t&iacute; alias kořenu - rodiče zadan&eacute; str&aacute;nky, kter&yacute; je nejv&yacute;&scaron;e v hierarchii .</p>
    <p>Arguments:
       <ul>
       <li>[$alias] - (optional) Alias str&aacute;nky, jej&iacute;ž kořen bude vyps&aacute;n. Pokud nen&iacute; hodnota uvedena, bude použita aktu&aacute;ln&iacute; str&aacute;nka.</li>
       <li>[$assign]   - (optional) The name of a variable to assign the results to.</li>
       </ul>  
    <br/></p>
    <p>Př&iacute;klad:<br/>
    <pre>The root parent page alias is {$cgsimple->get_root_alias()}</pre>
    </p>
</li>

<li><strong>get_page_title</strong>([$alias],[$assign])
    <p>Vr&aacute;t&iacute; titulek uveden&eacute; str&aacute;nky.</p>
    <p>Arguments:
       <ul>
       <li>[$alias] - (optional) Alias str&aacute;nky, jej&iacute;ž titulek chceme vypsat.  Pokud nen&iacute; zad&aacute;na ž&aacute;dn&aacute; hodnota, bude použita aktu&aacute;ln&iacute; str&aacute;nka.</li>
       <li>[$assign]   - (optional) The name of a variable to assign the results to.</li>
       </ul>  
    <br/></p>
    <p>Př&iacute;klad:<br/>
    <pre>The title of the current page is {$cgsimple->get_page_title()}</pre>
    </p>
</li>

<li><strong>get_page_menutext</strong>([$alias],[$assign])
    <p>Vr&aacute;t&iacute; text, j&iacute;mž je určit&aacute; str&aacute;nka pops&aacute;na v menu.</p>
    <p>Arguments:
       <ul>
       <li>[$alias] - (optional) The page alias to find the title of.  If no value is specified, the current page is used.</li>
       <li>[$assign]   - (optional) The name of a variable to assign the results to.</li>
       </ul>  
    <br/></p>
    <p>Example:<br/>
    <pre>The menutext of the current page is {$cgsimple->get_page_title()}</pre>
    </p>
</li>

<li><strong>has_children</strong>([$alias],[$assign])
    <p>Test if the specified page has children.</p>
    <p>Arguments:
       <ul>
       <li>[$alias] - (optional) The page alias to test.  If no value is specified, the current page is used.</li>
       <li>[$assign] - (optional) The name of a variable to assign the results to.</li>
       </ul>  
    <br/></p>
    <p>Example:<br/>
    <pre>{$cgsimple->has_children(&#039;&#039;,$has_children)}{if $has_children}The current page has children{else}The current page has no children{/if}</pre>
    </p>
</li>

    <li><strong>get_page_content</strong>($alias,[$block],[$assign])
    <p>Returns the text of a specific content block of another page.</p>
    <p>Arguments:
       <ul>
       <li>$alias - The page alias to extract content from.</li>
       <li>[$block] - (optional) The name of the content block in the specified page.  if this variable is not specified, &#039;content_en&#039; is assumed.</li>
       <li>[$assign] - (optional) The name of a variable to assign the results to.</li>
       </ul>  
    <br/></p>
    <p>Example:<br/>
    <pre>The title of the current page is {$cgsimple->get_page_title()}</pre>
    </p>
</li>
</ul>
<h4>Other Smarty functions</h4>
<ul>
    <li><strong>{module_action_link}</strong>
    <p>A smarty plugin that can create a link to a module action.</p>
    <p>Arguments:
       <ul>
       <li>module - The module to create a link to</li>
       <li>action (default) - The action to call within the module</li>
       <li>text - The text to put in the link</li>
       <li>page - Specify the destination page</li>
       <li>urlonly - Instead of generating a link, generate just the url</li>
       </ul>
    <br/></p>
    <p>Any other arguments to the smarty plugin will be added to the URL generated.</p>   <p>Example:<br/>
<pre>{module_action_link module=&#039;News&#039; action=&#039;fesubmit&#039; text=&#039;Submit a New News Article&#039;}</pre></p>
</ul>';
$lang['moddescription'] = 'Calguys Simple Smarty Tools';
$lang['postinstall'] = 'Modul &quot;CGSimpleSmarty&quot; je nyn&iacute; nainstalov&aacute;n';
$lang['postuninstall'] = 'Modul &quot;CGSimpleSmarty&quot; je odinstalov&aacute;n';
$lang['utmz'] = '156861353.1203024614.301.68.utmccn=(referral)|utmcsr=cmsmadesimple.org|utmcct=/|utmcmd=referral';
$lang['utma'] = '156861353.880267837.1180991669.1202648374.1203024614.301';
$lang['utmc'] = '156861353';
?>