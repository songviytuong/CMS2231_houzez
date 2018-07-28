<?php
$lang['friendlyname'] = 'CGSimpleSmarty ';
$lang['help'] = '<h3>What Does This Do?</h3>
<p>This module provides some simple smarty utilities for use in applications or for customizing the behaviour of your CMS Made Simple pages.</p>
<h3>How Do I Use It:</h3>
<p>When this module is installed, a new smarty object named cgsimple is automatically available to your page templates, global content blocks, and various module templates.  This smarty object has numerous functions that you can call at any time.</p>
<h4>Available Functions:</h4>
<ul>
<li><strong>self_url</strong>([$assign])
    <p>Return the current URL</p>
    <p>Arguments:
       <ul>
         <li>[$assign]   - (optional) The name of a variable to assign the results to.</li>
      </ul>  
    <br/></p>
</li>

<li><strong>module_installed</strong>($modulename[,$assign])
    <p>Test if a particular module is installed.</p>
    <p>Arguments:
       <ul>
         <li>$modulename - The name of the module to check</li>
         <li>[$assign]   - (optional) The name of a variable to assign the results to.</li>
      </ul>  
    <br/></p>
    <p>Example:<br/>
    <pre>{if $cgsimple-&amp;gt;module_installed(&#039;FrontEndUsers&#039;)}Found FEU{/if}</pre><br/>
    </p>
</li>

<li><strong>module_version</strong>($modulename[,$assign])
    <p>Return the version number of a specific installed module</p>
    <p>Arguments:
       <ul>
         <li>$modulename - The name of the module to check</li>
         <li>[$assign]   - (optional) The name of a variable to assign the results to.</li>
      </ul>  
    <br/></p>
    <p>Example:<br/>
    <pre>{$cgsimple-&amp;gt;module_version(&#039;FrontEndUsers&#039;,&#039;feu_version&#039;)}We have Version {$feu_version} of FrontEndUsers</pre><br/>
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
    <pre>The parent page alias is {$cgsimple-&amp;gt;get_parent_alias()}</pre><br/>
    </p>
</li>

<li><strong>get_root_alias</strong>([$alias][,$assign])
    <p>Returns the alias of the specified pages root parent. Returns an empty string if there is no root parent.</p>
    <p>Arguments:
       <ul>
       <li>[$alias] - (optional) The page alias to find the root parent of.  If no value is specified, the current page is used.</li>
       <li>[$assign]   - (optional) The name of a variable to assign the results to.</li>
       </ul>  
    <br/></p>
    <p>Example:<br/>
    <pre>The root parent page alias is {$cgsimple-&amp;gt;get_root_alias()}</pre><br/>
    </p>
</li>

<li><strong>get_page_title</strong>([$alias][,$assign])
    <p>Returns the title of the specified page.</p>
    <p>Arguments:
       <ul>
       <li>[$alias] - (optional) The page alias to find the title of.  If no value is specified, the current page is used.</li>
       <li>[$assign]   - (optional) The name of a variable to assign the results to.</li>
       </ul>  
    <br/></p>
    <p>Example:<br/>
    <pre>The title of the current page is {$cgsimple-&amp;gt;get_page_title()}</pre><br/>
    </p>
</li>

<li><strong>get_page_menutext</strong>([$alias][,$assign])
    <p>Returns the menutext of the specified page.</p>
    <p>Arguments:
       <ul>
       <li>[$alias] - (optional) The page alias to find the title of.  If no value is specified, the current page is used.</li>
       <li>[$assign]   - (optional) The name of a variable to assign the results to.</li>
       </ul>  
    <br/></p>
    <p>Example:<br/>
    <pre>The menutext of the current page is {$cgsimple-&amp;gt;get_page_menutext()}</pre><br/>
    </p>
</li>

<li><strong>get_page_type</strong>([$alias][,$assign])
    <p>Returns the name of the content type of the specified content object (by alias)</p>
    <p>Arguments:
       <ul>
       <li>[$alias] - (optional) The page alias to find the title of.  If no value is specified, the current page is used.</li>
       <li>[$assign]   - (optional) The name of a variable to assign the results to.</li>
       </ul>  
    <br/></p>
    <p>Example:<br/>
    <pre>The type of the current page is {$cgsimple-&amp;gt;get_page_type()}</pre><br/>
    </p>
</li>

<li><strong>has_children</strong>([$alias][,$assign])
    <p>Test if the specified page has children.</p>
    <p>Arguments:
       <ul>
       <li>[$alias] - (optional) The page alias to test.  If no value is specified, the current page is used.</li>
       <li>[$assign] - (optional) The name of a variable to assign the results to.</li>
       </ul>  
    <br/></p>
    <p>Example:<br/>
    <pre>{$cgsimple-&amp;gt;has_children(&#039;&#039;,&#039;has_children&#039;)}{if $has_children}The current page has children{else}The current page has no children{/if}</pre><br/>
    </p>
</li>

<li><strong>get_children</strong>([$alias][,$showinactive][,$assign])
   <p>Return an array containing information about a pages children (if any)</p>
    <p>Arguments:
       <ul>
       <li>[$alias] - (optional) The page alias to test.  If no value is specified, the current page is used.</li>
       <li>[$showinactive] - (optional) Wether inactive pages should be included in the result (defaults to false).</li>
       <li>[$assign] - (optional) The name of a variable to assign the results to.</li>
       </ul>  
    <br/></p>
    <p>Fields:
       <ul>
       <li>alias - the page alias of the child</li>
       <li>id - the page id of the child</li>
       <li>title - the title page of the child page.</li>
       <li>menutext - the menu text of the child</li>
       <li>show_in_menu - wether this child page is visible in menus.</li>
       <li>type - The type of child content object.</li>
       </ul>
    <br/></p>
    <p>Example:<br/>
    <pre>
{$cgsimple-&amp;gt;get_children(&#039;&#039;,0,&#039;children&#039;)}
{if count($children)}
   {foreach from=$children item=&#039;child&#039;}
      {if $child.show_in_menu}
        Child:  id = {$child.id} alias = {$child.alias}&amp;lt;br/&amp;gt;
      {/if}
   {/foreach}
{/if}
    </pre><br/>
    </p>
</li>

<li><strong>get_page_content</strong>($alias[,$block][,$assign])
    <p>Returns the text of a specific content block of another page.</p>
    <p>Arguments:
       <ul>
       <li>$alias - The page alias to extract content from.</li>
       <li>[$block] - (optional) The name of the content block in the specified page.  If this variable is not specified the value of the default content block <em>(content_en)</em> is assumed.</li>
       <li>[$assign] - (optional) The name of a variable to assign the results to.</li>
       </ul>  
    <br/></p>
    <p>Example:<br/>
    <pre>The &#039;second&#039; block of the &#039;about&#039; page is {$cgsimple-&amp;gt;get_page_content(&#039;about&#039;,&#039;second&#039;,&#039;foo&#039;)}{eval var=$foo}</pre><br/>
    </p>
</li>

<li><strong>get_sibling</strong>($direction[,$assign][,$alias])
    <p>Returns the alias of the next or previous sibling to the specified
       page. or false.</p>
    <p>Arguments:
       <ul>
       <li>$direction - the direction to look in.  possible values are prev,previous,-1,next,1</li>
       <li>[$assign] - (optional) The name of the variable to assign the results to.</li>
       <li>[$alias] - (optional) The page alias to find the sibling for.  If this is not specified, the current page is used.</li>
    <br/></p>
       <p>Example:<br/>
       <pre>Link to previous sibling: {$cgsimple-&amp;gt;get_sibling(&amp;quot;prev&amp;quot,&amp;quot;prev_sibling&amp;quot;)}{if !empty($prev_sibling)}{cms_selflink page=&amp;quot;$prev_sibling&amp;quot; text=&amp;quot;Previous&amp;quot;}{/if}</pre><br/>
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
       <li>jsfriendly - Used with the urlonly parameter this parameter will ensure that a javascrpt friendly url is output.</li>
       <li>confmessage - A confirmation message to display when the link is clicked.</li>
       <li>image - An image to use on the link</li>
       <li>imageonly - If an image is specified, create a link only consisting of the image.  The text will be used for the title attribute</li>
       </ul>
    <br/></p>
    <p>Any other arguments to the smarty plugin will be added to the URL generated.</p>   <p>Example:
<pre>{module_action_link module=&#039;News&#039; action=&#039;fesubmit&#039; text=&#039;Submit a New News Article&#039;}</pre><br/></p></li>


    <li><strong>{session_put}</strong>
    <p>A smarty plugin that can store data in the user session. This data is then accessible via the $smarty.session array in subsequent pages.</p>
    <p>Arguments:
       <ul>
       <li>var - The name of the variable to create in the session.</li>
       <li>value - The desired value of the variable.</li>
       </ul>
    <br/></p>
    <p>Example:
    <pre>{session_put var=&#039;test&#039; value=&#039;blah&#039;}</pre><br/></p></li>

    <li><strong>{session_erase}</strong>
    <p>A smarty plugin that can erase data from the user session.</p>
    <p>Arguments:
       <ul>
       <li>var - The name of the variable to erase in the session.</li>
       </ul>
    <br/></p>
    <p>Example:
    <pre>{session_erase var=&#039;test&#039;}</pre><br/></p></li>

    <li><strong>{cgrepeat}</strong>
    <p>Another smarty plugin that will allow repeating text</p>
    <p>Arguments:</p>
      <ul>
        <li>text - The text to be repeated</li>
        <li>count - The number of times it should be repeated</li>
        <li>assign - Assign the output to the specified smarty variable</li>
      </ul>
    <br/>
    <p>Example: <pre>{cgrepeat text=&#039;this&#039; count=&#039;5&#039;}</pre><br/></p>
    </li>
</ul>
<h3>Copyright and License</h3>
<p>Copyright &amp;copy; 2008, Robert Campbel <a href="mailto:calguy1000@cmsmadesimple.org">&amp;lt;calguy1000@cmsmadesimple.org&amp;gt;</a>. All Rights Are Reserved.</p>
<p>This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.</p>
<p>However, as a special exception to the GPL, this software is distributed
as an addon module to CMS Made Simple.  You may not use this software
in any Non GPL version of CMS Made simple, or in any version of CMS
Made simple that does not indicate clearly and obviously in its admin 
section that the site was built with CMS Made simple.</p>
<p>This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
Or read it <a href="http://www.gnu.org/licenses/licenses.html#GPL">online</a></p>';
$lang['moddescription'] = 'Calguys SimpleSmarty Tools';
$lang['postinstall'] = 'CGSimpleSmarty &egrave; ora installato';
$lang['postuninstall'] = 'CGSimpleSmarty &egrave; stato rimosso';
$lang['utma'] = '156861353.974349155.1299072468.1302003201.1303465107.4';
$lang['qca'] = 'P0-1868709163-1302003200778';
$lang['utmb'] = '156861353';
$lang['utmc'] = '156861353';
$lang['utmz'] = '156861353.1303465107.4.1.utmccn=(direct)|utmcsr=(direct)|utmcmd=(none)';
?>