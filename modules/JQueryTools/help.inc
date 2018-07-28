<h3>What is this?</h3>
<p>This module adds the functionality of <a href="http://www.jquery.com">jQuery</a> and various addon libraries to CMS Made Simple page, and modules (even in the admin section), conveniently and easily.  It provides a convenient and simple way to include jquery and jquery dependent libraries into your CMSMS content page.</p>
<h3>How do I use it?</h3>
<p>Enabling this functionality is a two step process:</p>
<ul>
  <li>1.  Enable the jquery libraries that you want by calling <code>{JQueryTools action=require lib=&quot;library name&quot; nocache}</code> in your page content.
    <p>This tag can be called multiple times to enable multiple libraries.  the lib argument also supports passing a comma separated list of library names.</p>
  </li>
  <li>2.  Call <code>{JQueryTools action=placemarker nocache}</code> in the appropriate part of your page template.
    <ul>
      <li>To enable JQueryTools for a specific page it is often useful to place the <code>{JQueryTools action=placemarker nocache}</code> tag in the page specific metadata field of each content page.</li>
      <li>To enable JQueryTools on a site wide basis the <code>{JqueryTools action=placemarker nocache}</code> tag can be plased in the global metadata field in the global settings.</li>
      <li>You may also place the <code>{JQueryTools action=placemarker}</code> tag in each specific page template, at the botoom of the template above </body> or anywhere in thhe head section.</li>
    </ul>
  </li>
</ul>
<p>This module does not provide samples and instructions as to how to use jquery or the various addon libraries that we include.  to learn how to use these libraries you will need to read the documentation for the plugins at their respective home page.</p>

<h3>What jquery version is included?</h3>
<p>Currently JQueryTools uses jquery 1.8.3</p>
<h3>What JQuery plugins are included</h3>
<ul>
  <li>tablesorter <em>(see <a href="http://tablesorter.com">http://tablesorter.com</a> for usage instructions)</em>
<p>-- To allow sorting your tables, give the follwing classes to the table definition: cms_sortable tablesorter. i.e: <code>&lt;table class="cms_sortable tablesorter"&gt;...&lt;/table&gt;</code></p>
  </li>
  <li>jquery</li>
  <li>jquery ui - smoothness theme.</li>
  <li>cluetip <em>(see <a href="http://plugins.learningjquery.com/cluetip/">http://plugins.learningjquery.com/cluetip/</a> for usage instructions)</em></li>
  <li>form <em>(see <a href="http://malsup.com/jquery/form/">http://malsup.com/jquery/form/</a> for usage instructions)</em></li>
  <li>fancybox <em>(see <a href="http://fancy.klade.lv/">http://fancy.klade.lv/</a> for usage instructions)</em></li>
  <li>json</li>
  <li>lightbox</li>
  <li>fileupload - The blueimp jquery file upload library.</li>
</ul>
<h3>Example:</h3>
 <p>So you have uploaded some files to a category in the uploads module, and you want to use fancybox to preview the images from an Uploads module summary view. This is a simple 3 step process:</p>
<ol>
   <li>Modify your uploads summary template to something similar to this:
<pre><code><span style="color: blue;">{JQueryTools action=require lib=fancybox nocache}</span>
{foreach from=$items item='entry' name='uploads'}
  &lt;div class="upload" style="float: left; width: 33%;"&gt;
  {if isset($entry->thumbnail_url)}
  &lt;a class="fancybox" href="{$entry->origfile_url}" title="{$entry->upload_name}"&gt;&lt;img src="{$entry->thumbnail_url}" alt=""/&gt;&lt;/a&gt;
  {/if}
  &lt;/div&gt;
{/foreach}
&lt;div style="clear: both;"&gt;&gt;/div&lt;</code></pre>
   <p>Note the call to JQueryTools to include the fancybox library. Additionally, note the class given to the <em>a</em> tag.</p>
  </li>
  <li>Call <code>{JQueryTools action=placemarker nocache}</code>
    <p>There are at least four locations where this tag can be called:</p>
    <ul>
      <li>In the page template directly before the <code>&lt;/body&gt;</code> tag.</li>
      <li>In the page template directly before the <code>&lt;/head&gt;</code> tag.</li>
      <li>In the page metadata field when editing content.</li>
      <li>In the global metadata field in the global settings page.</li>
    </ul>
  </li>
  <li>Call the Uploads module from a page.  i.e:<br/>
    <pre><code>{Uploads category=category_name}</code></pre>
  </li>
</ol>
<h3>Built in Ready Scripts</h3>
<p>This module supports some simple ready states to ease in development.  All of these can be overwritten in your own javascript:</p>
<ul>
    <li>fancybox - fancybox will work on any a tag with a class of fancybox:  $('a.fancybox').fancybox()
      <pre><code>&lt;a class=&quot;fancybox&quot; href=&quot;http://www.mysite.com/uploads/images/image.jpg&quot;&gt;&lt;img src=&quot;http://www.mysite.com/uploads/images/thumb_image.jpg&quot;/&gt;&lt;a&gt;</code></pre>
		    <p><strong>Hint:</strong> Use CGSmartImage to avoid having to create and manage thumbnails <em>(requires downloading and installing the CGSmartImage module)</em>:</p>
		    <pre><code>&lt;a class=&quot;fancybox&quot; href=&quot;{CGSmartImage src='images/image.jpg' noembed=1}&quot;&gt;{CGSmartImage src='images/image.jpg' width=100 height=100}&lt;a&gt;</pre></code>
    </li>
    <li>lightbox - lightbox will work on any a tag with a class of lightbox:  $('a.lightbox').lightbox()</li>
    <li>cluetip - cluetip will work on any a tag with a class of cluetip:  $('a.cluetip').cluetip()</li>
    <li>tablesorter - tablesorter will work on any table tag with a class of cms_sortable: $('table.cms_sortable').tableSorter()</li>
</ul>
<h3>About smarty caching</h3>
<p>The require, and placemarker actions do not support smarty caching.  It is therefere critical that the nocache attribute be used on calls to the JQueryTools module.</p>
<h3>About the placemarker action.</h3>
<p>The placemarker action does the job of generating the html to insert the jquery scripts, and the various addon libraries that were requested via the require action.  Therefore the placemarker action must be called AFTER all calls to the require action.   Please keep in mind that CMSMS divides page templates into three portions and processes them in this order:  The top portion of the page before the &lt;html&gt; tag.  The body section, and the head section.</p>

<h3>Support</h3>
<p>The module author is in no way obligated to privide support for this code in any fashion.  However, there are a number of resources available to help you with it:</p>
<ul>
<li>A bug tracking and feature request system has been created for this module <a href="http://dev.cmsmadesimple.org/projects/jquerytools">here</a>.  Please be verbose and descriptive when submitting bug reports and feature requests, and for bug reports ensure that you have provided sufficient information to reliably reproduce the issue.</li>
<li>Additional discussion of this module may also be found in the <a href="http://forum.cmsmadesimple.org">CMS Made Simple Forums</a>.  When describing an issue please make an effort to privide all relavant information, a thorough description of your issue, and steps to reproduce it or your discussion may be ignored.</li>
<li>The author, calguy1000, can often be found in the <a href="irc://irc.freenode.net/#cms">CMS IRC Channel</a>.</li>
<li>Lastly, you may have some success emailing the author directly.  However, please use this as a last resort, and ensure that you have followed all applicable instructions on the forge, in the forums, etc.</li>
</ul>


<h3>Copyright and License</h3>
<p>Copyright &copy; 2012, Robert Campbel <a href="mailto:calguy1000@cmsmadesimple.org">&lt;calguy1000@cmsmadesimple.org&gt;</a>. All Rights Are Reserved.</p>
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
