<?php
$lang['friendlyname'] = 'CGSimpleSmarty ';
$lang['help'] = '<h3>What Does This Do?</h3>
<p>This module provides some simple smarty utilities for use in applications or for customizing the behaviour of your CMS Made Simple pages.</p>
<h3>How Do I Use It:</h3>
<p>When this module is installed, a new smarty object named cgsimple is automatically available to your page templates, global content blocks, and various module templates.  This smarty object has numerous functions that you can call at any time.</p>
<h4>Available Functions:</h4>
<ul>
<li><strong>module_installed</strong>($modulename,[$assign])
    <p>Test if a particular module is installed.</p>
    <p>Arguments:
       <ul>
         <li>$modulename - The name of the module to check</li>
         <li>[$assign]   - (optional) The name of a variable to assign the results to.</li>
      </ul>  
    <br/></p>
    <p>Example:<br/>
    <pre>{if $cgsimple->module_installed(\'FrontEndUsers\')}Found FEU{/if}</pre>
    </p>
</li>

<li><strong>module_version</strong>($modulename,[$assign])
    <p>Return the version number of a specific installed module</p>
    <p>Arguments:
       <ul>
         <li>$modulename - The name of the module to check</li>
         <li>[$assign]   - (optional) The name of a variable to assign the results to.</li>
      </ul>  
    <br/></p>
    <p>Example:<br/>
    <pre>{$cgsimple->module_version(\'FrontEndUsers\',\'feu_version\')}We have Version {$feu_version} of FrontEndUsers</pre>
    </p>
</li>

<li><strong>get_parent_alias</strong>([$alias],[$assign])
    <p>Returns the alias of the specified pages parent. Returns an empty string if there is no parent.</p>
    <p>Arguments:
       <ul>
       <li>[$alias] - (optional) The page alias to find the parent of.  If no value is specified, the current page is used.</li>
       <li>[$assign]   - (optional) The name of a variable to assign the results to.</li>
       </ul>  
    <br/></p>
    <p>Example:<br/>
    <pre>The parent page alias is {$cgsimple->get_parent_alias()}</pre>
    </p>
</li>

<li><strong>get_root_alias</strong>([$alias],[$assign])
    <p>Returns the alias of the specified pages root parent. Returns an empty string if there is no root parent.</p>
    <p>Arguments:
       <ul>
       <li>[$alias] - (optional) The page alias to find the root parent of.  If no value is specified, the current page is used.</li>
       <li>[$assign]   - (optional) The name of a variable to assign the results to.</li>
       </ul>  
    <br/></p>
    <p>Example:<br/>
    <pre>The root parent page alias is {$cgsimple->get_root_alias()}</pre>
    </p>
</li>

<li><strong>get_page_title</strong>([$alias],[$assign])
    <p>Returns the title of the specified page.</p>
    <p>Arguments:
       <ul>
       <li>[$alias] - (optional) The page alias to find the title of.  If no value is specified, the current page is used.</li>
       <li>[$assign]   - (optional) The name of a variable to assign the results to.</li>
       </ul>  
    <br/></p>
    <p>Example:<br/>
    <pre>The title of the current page is {$cgsimple->get_page_title()}</pre>
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
    <pre>{$cgsimple->has_children(\'\',$has_children)}{if $has_children}The current page has children{else}The current page has no children{/if}</pre>
    </p>
</li>

    <li><strong>get_page_content</strong>($alias,[$block],[$assign])
    <p>Returns the text of a specific content block of another page.</p>
    <p>Arguments:
       <ul>
       <li>$alias - The page alias to extract content from.</li>
       <li>[$block] - (optional) The name of the content block in the specified page.  if this variable is not specified, \'content_en\' is assumed.</li>
       <li>[$assign] - (optional) The name of a variable to assign the results to.</li>
       </ul>  
    <br/></p>
    <p>Example:<br/>
    <pre>The title of the current page is {$cgsimple->get_page_title()}</pre>
    </p>
</li>

</ul>';
$lang['moddescription'] = 'Инструменты Calguys Simple Smarty';
$lang['postinstall'] = 'CGSimpleSmarty был установлен';
$lang['postuninstall'] = 'CGSimpleSmarty был удалён';
$lang['qca'] = 'P0-636611758-1290773054030';
$lang['utmz'] = '156861353.1293134170.11.6.utmcsr=dev.cmsmadesimple.org|utmccn=(referral)|utmcmd=referral|utmcct=/bug/view/5775';
$lang['utma'] = '156861353.581103809.1290773047.1293121076.1293134170.11';
$lang['utmc'] = '156861353';
$lang['utmb'] = '156861353.2.10.1293134170';
?>