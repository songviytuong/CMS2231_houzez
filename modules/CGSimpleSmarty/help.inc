<h3>What Does This Do?</h3>
<p>This module provides some simple smarty utilities for use in applications or for customizing the behaviour of your CMS Made Simple pages.</p>
<h3>How Do I Use It:</h3>
<p>When this module is installed, a new smarty class named cgsimple is automatically available to your page templates, global content blocks, and various module templates.  This smarty class has numerous functions that you can call at any time.</p>
<h4>Available Functions:</h4>
<ul>

<li><strong>setvar</strong>(name=value [name2=value2[ name3=value3]])
   <p>For use when smarty variable scope is being problematic. This plugin will store data outside of smarty to allow that data to be recalled in a sub template or at a later place in the same template.</p>
   <p>Example:  <code>{setvar foo='bar' foo2='bar2' foo3='bar3'}</code></p>
   <br/>
</li>

<li><strong>unsetvar</strong>(name=value [name2=value2 [name3=value3]])
   <p>For use when smarty variable scope is being problematic, this plugin allows erasing data that was created with the {setvar} plugin.</p>
   <p>Arguments:
      <ul>
        <li>unset - required : A comma separated string of the names of data previously created with <code>{setvar}</code></li>
      </ul>
   </p>
   <p>Example:  <code>{unsetvar unset='foo2,foo3'}</code></p>
   <br/>
</li>

<li><strong>getvar</strong>(var=name [dflt=value] [assign=name [scope=global|local]])
  <p>For use when smarty variable scope is being problematic.  This plugin will retrieve data previously created with the {setvar} plugin.  You can optionally assign the data to a new local, or global smarty variable.</p>
  <p>Arguments:
     <ul>
       <li>v|var  - required : The name of the stored data to retrieve.</li>
       <li>dflt   - optional : A value to return if the named variable specified in the var argument does not exist.</li>
       <li>assign - optional : Instead of returning the output data assign the data to the named sparty variable.</li>
       <li>scope  - optional : For use only when the assign argument is used, additionally assign the output data to a smarty variable to the global scope.</li>
     </ul>
  </p>
  <p>Example1 - Output a previously set variable to the template: <code>{getvar var=foo}</code></p>
  <p>Example2 - Output a previously set variable to the template.  If it does not exist, use a default value.: <code>{getvar var=foo dflt='something'}</code></p>
  <p>Example3 - Output a previously set variable to a local smarty variable: <code>{getvar var=foo assign='foo'}{$foo}</code></p>
  <p>Example4 - Output a previously set variable to a global smarty variable: <code>{getvar var=foo assign='foo' scope='global'}{$foo}</code></p>
  <br/>
</li>


<br/>
<li><strong>cgsimple::self_url</strong>()
    <p>Return the current URL</p>
</li>

<br/>
<li><strong>cgsimple::anchor_url</strong>($name)
  <p>Generate the absolute URL to an anchor that is on the same page.</p>
  <p>Arguments:
    <ul>
      <li>$name - The name of the anchor to link to.</li>
    </ul>
  <br/></p>
  <p>Example:<br/>
    <pre>&lt;a href="{cgsimple::anchor_url('bottom')}"&gt;Go to the bottom&lt;/a&gt;
&lt;a name="bottom"&gt;The bottom&lt;a&gt;</pre><br/>
  </p>
</li>

<br/>
<li><strong>cgsimple::module_installed</strong>($modulename)
    <p>Test if a particular module is installed.</p>
    <p>Arguments:
       <ul>
         <li>$modulename - The name of the module to check</li>
      </ul>
    <br/></p>
    <p>Example:<br/>
    <pre>{if cgsimple::module_installed('FrontEndUsers')}Found FEU{/if}</pre><br/>
    </p>
</li>

<br/>
<li><strong>cgsimple::module_version</strong>($modulename)
    <p>Return the version number of a specific installed module</p>
    <p>Arguments:
       <ul>
         <li>$modulename - The name of the module to check</li>
      </ul>
    <br/></p>
    <p>Example:<br/>
    <pre>{$version=cgsimple::module_version('FrontEndUsers')}We have Version {$feu_version} of FrontEndUsers</pre><br/>
    </p>
</li>

<br/>
<li><strong>cgsimple::get_parent_alias</strong>([$alias])
    <p>Returns the alias of the specified pages parent. Returns an empty string if there is no parent.</p>
    <p>Arguments:
       <ul>
       <li>[$alias] - (optional) The page alias to find the parent of.  If no value is specified, the current page is used.</li>
       </ul>
    <br/></p>
    <p>Example:<br/>
    <pre>The parent page alias is {cgsimple::get_parent_alias()}</pre><br/>
    </p>
</li>

<br/>
<li><strong>cgsimple::get_root_alias</strong>([$alias])
    <p>Returns the alias of the specified pages root parent. Returns an empty string if there is no root parent.</p>
    <p>Arguments:
       <ul>
       <li>[$alias] - (optional) The page alias to find the root parent of.  If no value is specified, the current page is used.</li>
       </ul>
    <br/></p>
    <p>Example:<br/>
    <pre>The root parent page alias is {cgsimple::get_root_alias()}</pre><br/>
    </p>
</li>

<br/>
<li><strong>cgsimple::get_page_title</strong>([$alias])
    <p>Returns the title of the specified page.</p>
    <p>Arguments:
       <ul>
       <li>[$alias] - (optional) The page alias to find the title of.  If no value is specified, the current page is used.</li>
       </ul>
    <br/></p>
    <p>Example:<br/>
    <pre>The title of the current page is {cgsimple::get_page_title()}</pre><br/>
    </p>
</li>

<br/>
<li><strong>cgsimple::get_page_menutext</strong>([$alias])
    <p>Returns the menutext of the specified page.</p>
    <p>Arguments:
       <ul>
       <li>[$alias] - (optional) The page alias to find the title of.  If no value is specified, the current page is used.</li>
       </ul>
    <br/></p>
    <p>Example:<br/>
    <pre>The menutext of the current page is {cgsimple::get_page_menutext()}</pre><br/>
    </p>
</li>

<br/>
<li><strong>cgsimple::get_page_type</strong>([$alias])
    <p>Returns the name of the content type of the specified content object (by alias)</p>
    <p>Arguments:
       <ul>
       <li>[$alias] - (optional) The page alias to find the title of.  If no value is specified, the current page is used.</li>
       </ul>
    <br/></p>
    <p>Example:<br/>
    <pre>The type of the current page is {cgsimple::get_page_type()}</pre><br/>
    </p>
</li>

<br/>
<li><strong>cgsimple::has_children</strong>([$alias])
    <p>Test if the specified page has children.</p>
    <p>Arguments:
       <ul>
       <li>[$alias] - (optional) The page alias to test.  If no value is specified, the current page is used.</li>
       </ul>
    <br/></p>
    <p>Example:<br/>
    <pre>{$has_children=cgsimple::has_children()}{if $has_children}The current page has children{else}The current page has no children{/if}</pre><br/>
    </p>
</li>

<br/>
<li><strong>cgsimple::get_children</strong>([$alias][,$showinactive])
   <p>Return an array containing information about a pages children (if any)</p>
    <p>Arguments:
       <ul>
       <li>[$alias] - (optional) The page alias to test.  If no value is specified, the current page is used.</li>
       <li>[$showinactive] - (optional) Wether inactive pages should be included in the result (defaults to false).</li>
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
{$children=cgsimple::get_children()}
{if count($children)}
   {foreach from=$children item='child'}
      {if $child.show_in_menu}
        Child:  id = {$child.id} alias = {$child.alias}&lt;br/&gt;
      {/if}
   {/foreach}
{/if}
    </pre><br/>
    </p>
</li>

<br/>
<li><strong>cgsimple::get_page_content</strong>($alias[,$block])
    <p>Returns the text of a specific content block of another page.</p>
    <p>Arguments:
       <ul>
       <li>$alias - The page alias to extract content from.</li>
       <li>[$block] - (optional) The name of the content block in the specified page.  If this variable is not specified the value of the default content block <em>(content_en)</em> is assumed.</li>
       </ul>
    <br/></p>
    <p>Example:<br/>
    <pre>The 'second' block of the 'about' page is {$foo=cgsimple::get_page_content('about','second')}{eval var=$foo}</pre><br/>
    </p>
</li>

<br/>
<li><strong>cgsimple::get_sibling</strong>($direction,$alias)
    <p>Returns the alias of the next or previous sibling to the specified
       page. or false.</p>
    <p>Arguments:
       <ul>
       <li>$direction - the direction to look in.  possible values are prev,previous,-1,next,1</li>
       </ul>
    <br/></p>
       <p>Example:<br/>
       <pre>Link to previous sibling: {$prev_sibling=cgsimple::get_sibling(&quot;prev&quot)}{if !empty($prev_sibling)}{cms_selflink page=&quot;$prev_sibling&quot; text=&quot;Previous&quot;}{/if}</pre><br/>
    </li>

<br/>
<li><strong>cgsimple::get_parallel_page</strong>($new_root[,$current_page = null])
   <p>Get the alias of a parallel page in the page stricture given a different root alias.</p>
   <p>In a multilanguage site where the root levels represent different languages, it may be useful to retrieve the alias to an equivalent page in a different language.  i.e.: if the user is currently browsing the french page and wishes to see the same page in english (if it exists).</p>
   <p>This function returns the alias of the specified page under the new root.  If it exists.  If nothing is found, null is returned.</p>
   <p>Arguments:
       <ul>
       <li>new root - The alias of the new root parent.  Note, if a top level page is not specified, the alias provided is used to find the top level page (see get_root_alias).</li>
       <li>current_page - (optional) The page alias to find the peer of.  If no value is specified, the current page is used.</li>
       </ul>
    <br/></p>
    <p>Example:<br/>
    <pre>Find the equivalent french page for this page: {$tmp=cgsimple::get_parallel_page('FR')}{if $tmp != '' && $tmp != $page_alias}{cms_selflink page=$tmp}{/if}</pre>
    </p>
</li>

<br/>
<li><strong>cgsimple::get_parallel_url</strong>($new_root[,$current_page = null])
   <p>Get the URL of a parallel page in the page stricture given a different root alias.</p>
   <p>In a multilanguage site where the root levels represent different languages, it may be useful to retrieve the URL to an equivalent page in a different language.  i.e.: if the user is currently browsing the french page and wishes to see the same page in english (if it exists).</p>
   <p>This function returns the alias of the specified page under the new root.  If it exists.  If nothing is found, null is returned.</p>
   <p>Arguments:
       <ul>
       <li>new root - The alias of the new root parent.  Note, if a top level page is not specified, the alias provided is used to find the top level page (see get_root_alias).</li>
       <li>current_page - (optional) The page alias to find the peer of.  If no value is specified, the current page is used.</li>
       </ul>
    <br/></p>
    <p>Example:<br/>
    <pre>Find the equivalent french page for this page: {$url=cgsimple::get_parallel_page('FR')}{if $url}<a href="{$url}">FR</a>{/if}</pre>
    </p>
</li>

<br/>
<li><strong>cgsimple::get_file_listing</strong>($dir[,$excludeprefix])
    <p>Retrn a list of files in a directory.</p>
    <p>Arguments:
      <ul>
      <li>$dir - Te directory to scan (should be an absolute directory)</li>
      <li>[$excludeprefix] - (optional) Exclude files strting with the specified prefix.</li>
      </ul>
    </p>
</li>
</ul>

<h4>Other Smarty plugins</h4>
<ul>
    <li><strong>{module_action_url}</strong>
    <p>A smarty plugin that can create a url to a module action.</p>
    <p>Arguments:
       <ul>
       <li>module - The module to create a link to.  This argument is optional, the system will attempt to detect the current module name (if within a module action)</li>
       <li>action (default) - The action to call within the module</li>
       <li>page - Specify the destination page</li>
       <li>jsfriendly|forjs - Turns on the urlonly parameter, and indicates that javascript friendly urls are output.</li>
       <li>forajax - Turns on the jsfriendly parameter (and the urlonly parameter), and also appends showtemplate=false to the URL output for AJAX requests</li>
       <li>assign - Assign the output of the plugin to the named smarty variable.</li>
       </ul>
    <br/></p>
    <p>Any other arguments to the smarty plugin will be added to the URL generated.</p>   <p>Example:
    <pre>{module_action_url module='News' action='fesubmit' assign='foo'}</pre><br/></p></li>

    <li><strong>{module_action_link}</strong>
    <p>A smarty plugin that can create a link to a module action.</p>
    <p>Arguments:
       <ul>
       <li>module - The module to create a link to.  This argument is optional, the system will attempt to detect the current module name (if within a module action)</li>
       <li>action (default) - The action to call within the module</li>
       <li>text - The text to put in the link</li>
       <li>page - Specify the destination page</li>
       <li>urlonly - Instead of generating a link, generate just the url</li>
       <li>jsfriendly|forjs - Turns on the urlonly parameter, and indicates that javascript friendly urls are output.</li>
       <li>forajax - Turns on the jsfriendly parameter (and the urlonly parameter), and also appends showtemplate=false to the URL output for AJAX requests</li>
       <li>confmessage - A confirmation message to display when the link is clicked.</li>
       <li>image - An image to use on the link</li>
       <li>imageonly - If an image is specified, create a link only consisting of the image.  The text will be used for the title attribute</li>
       <li>assign - Assign the output of the plugin to the named smarty variable.</li>
       </ul>
    <br/></p>
    <p>Any other arguments to the smarty plugin will be added to the URL generated.</p>   <p>Example:
    <pre>{module_action_link module='News' action='fesubmit' text='Submit a New News Article'}</pre><br/></p></li>

    <li><strong>{anchor_link}</strong>
    <p>A smarty plugin to generate a link to an anchor that is on the same page.</p>
    <p>Arguments:
      <ul>
      <li>n|name - <em>(string)</em> The name of the anchor to link to.</li>
      <li>text - <em>(string></em> The text portion of the link.  If not specified, the anchor name will be used.</li>
      <li>urlonly - <em>(bool)</em> Optionally only generate the URL portion of the link.  see cgsimple::anchor_url()</li>
      <li>assign - <em>(string></em> Optionally assign the output of the plugin to the named smarty variable.</li>
      </ul>
    </p>
    <p>Any other arguments to the smarty plugin will be added as attributes to the link generated.</p>
    <p>Example: <pre>{anchor_link name=bottom class="anchor_class" id="anchor_id"}</pre></p>
    </li>

    <li><strong>{session_put}</strong>
    <p>A smarty plugin that can store data in the user session. This data is then accessible via the $smarty.session array in subsequent pages.</p>
    <p>Arguments:
       <ul>
       <li>var - The name of the variable to create in the session.</li>
       <li>value - The desired value of the variable.</li>
       </ul>
    <br/></p>
    <p>Example:
    <pre>{session_put var='test' value='blah'}</pre><br/></p></li>

    <li><strong>{session_erase}</strong>
    <p>A smarty plugin that can erase data from the user session.</p>
    <p>Arguments:
       <ul>
       <li>var - The name of the variable to erase in the session.</li>
       </ul>
    <br/></p>
    <p>Example:
    <pre>{session_erase var='test'}</pre><br/></p></li>

    <li><strong>{cgrepeat}</strong>
    <p>Another smarty plugin that will allow repeating text</p>
    <p>Arguments:</p>
      <ul>
        <li>text - The text to be repeated</li>
        <li>count - The number of times it should be repeated</li>
        <li>assign - Assign the output to the specified smarty variable</li>
      </ul>
    <br/>
    <p>Example: <pre>{cgrepeat text='this' count='5'}</pre><br/></p>
    </li>
</ul>

<h3>Support</h3>
<p>The module author is in no way obligated to provide support for this code in any fashion.  However, there are a number of resources available to help you with it:</p>
<ul>
<li>A bug tracking and feature request system has been created for this module <a href="http://dev.cmsmadesimple.org/projects/cgsimplesmarty">here</a>.  Please be verbose and descriptive when submitting bug reports and feature requests, and for bug reports ensure that you have provided sufficient information to reliably reproduce the issue.</li>
<li>Additional discussion of this module may also be found in the <a href="http://forum.cmsmadesimple.org">CMS Made Simple Forums</a>.  When describing an issue please make an effort to privide all relavant information, a thorough description of your issue, and steps to reproduce it or your discussion may be ignored.</li>
<li>The author, calguy1000, can often be found in the <a href="irc://irc.freenode.net/#cms">CMS IRC Channel</a>.</li>
<li>Lastly, you may have some success emailing the author directly.  However, please use this as a last resort, and ensure that you have followed all applicable instructions on the forge, in the forums, etc.</li>
</ul>

<h3>Copyright and License</h3>
<p>Copyright &copy; 2008, Robert Campbel <a href="mailto:calguy1000@cmsmadesimple.org">&lt;calguy1000@cmsmadesimple.org&gt;</a>. All Rights Are Reserved.</p>
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
Or read it <a href="http://www.gnu.org/licenses/licenses.html#GPL">online</a></p>
