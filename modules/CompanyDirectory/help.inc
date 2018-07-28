<h3>What does this do?</h3>
  <p>This module provides a way to collect, organize, search, filter, and display information about companies.  Usually this is the contact information and a logo, but it is flexibile enough to allow for extendable fields, and discriminating public from private data.</p>
<p>This module could be used for a variety of purposes. Including a regional tourism site, a suppliers list, or a contact list.  It is flexible enough that it could be re-used for many different purposes.</p>
<h3>How Do I Use It</h3>
<p>The easiest way to use this module is by placing the <code>{CompanyDirectory}</code> tag into either your page template or page content.  You would then start editing records in the &quot;Company Directory&quot; admin interface.  Explore the various parameters (described below) for ways to customize the behaviour of the module.</p>
<h3>Features:</h3>
<ul>
  <li>Custom Fields
    <p>This module provides the ability to extend the basic database model by ading custom fields to the structure.  There are numerous different types of custom fields, and some modules may provide additional types.  It is also possible to mark customf ields as editable in the admin interface only, or as non public (not available for frontend display).</p>
  </li>
  <li>Geolocating
    <p>If a suitable module <em>(CGGoogleMaps or CGGoogleMaps2)</em> is installed, then this module is capable of converting many address formats to latitude and longitude so that maps can be built from the CompanyDirectory data.</p>
  </li>
  <li>KML Import
    <p>This module can import basic company data from KML format.</p>
  </li>
  <li>Flexible ASCII Import and Export
    <p>This module provides the ability to import companies, field definitions, and categories from a flexible (semi-user-definable) ASCII format.</p>
  </li>
  <li>Flexible Categorization
    <p>The site administrator can create a hierarchical data structure.  Each Company record can be associated to a place inside that hierarchical data structure to allow for filtering, or drill down searces.</p>
    <p>Additionally, the site administrator can create a list of &quot;categories&quot;.  Each company location can be associated with multiple categories.  This is useful for searching and filtering functionality.  For display purposes additional information can be associated with each category (three user defined areas).  And when editing a company record, category information can be overriden for each record.</p>
  </li>
  <li>Flexible URL mechanisms</li>
    <p>This module provides the for the site administrator to specify a unique SEO friendly URL for the detail view of each company record.  This URL works in addition to the other SEO friendly mechanisms that can be used to access a company detail record.</p>
    <p><strong>Note:</strong> When using SEO friendly URLS it is important to use canonical URLS.</p>
  <li>Frontend Editing
    <p>The CompanyDirectory module is capable of allowing authorized frontend users <em>(see the FrontendUsers module)</em> to add and manage (even import from CSV) Company records.  This is useful for building a directory site, for example for a regional tourism board where individual subscribers may manage the visible public information for one or more companies.</p>
  </li>
  <li>Numerous display mechanisms</li>
  <li>Advanced Search and Filtering Capabilities
    <p>Search capabilties can be customized in numerous ways and also includes the possiblity for location aware based searches and postcode based searches <em>(Requires the PostCode module)</em></p>
  </li>
  <li>Flexible Templating Capabilities</li>
</ul>


<h3>Smarty Plugins</h3>
<p>This module shares numerous smarty plugins to make template design and application development simpler:</p>
<ul>
<li><strong>{cd_hierbreadcrumb hier=int [options]}</strong> - Create a series of links representing the breadcrumb to a particular hierarchy id.  Each link will generate a summary view of companies in that hierarchy.<br/>Options:
  <ul>
    <li>hier=integer - <strong>required</strong> - The CompanyDirectory hierarchy id to build a breadcrumb to.</li>
    <li>page=string - A page id or alias to use for the summary view.  If none is specified, the current page is used.</li>
    <li>delim=string - The delimiter between each string.  By default a pipe character surrounded by spaces is used.</li>
    <li>class=string - An optional class (or series of classes) to assign to each link.</li>
    <li>raw=boolean - If enabled, an array of hierarchy data representing the path to the hierarchy specified will be returned.  This can be used to allow building your own links.  If this is specified, the delim and class arguments are ignored as links will not be returned.</li>
    <li>assign=string - The name of a smarty variable to assign the output to.</li>
  </ul>
  <p>Additionally, this tag accepts any parameters that the default summary view will accept (i.e: sorting options, page limit) and they will be passed to the url building process.</p>
  <p>Example <em>(suitable for a detail template)</em>: {cd_hierbreadcrumb hier=$entry->hier_id hier_children=1 pagelimit=50}</code></p>
</li>
<li><strong>{cd_selcategory [options]}</strong> - Create a form dropdown or multi-select area for CompanyDirectory categories.<br/>Options:
  <ul>
     <li>prefix=string - Provide a prefix to the select element name.</li>
     <li>name=string - The select element name.</li>
     <li>id=string - The select element id.</li>
     <li>selected - An array, or comma separated list of category ids to indicate which items should be selected.</li>
     <li>class=string - The select element class.</li>
     <li>multiple=anything - If set, indicates to allow selecting multiple values instead of a single value.</li>
     <li>size=integer - If multiple is set indicates the size of the multi-select area.</li>
     <li>assign=string - Assign the generated XHTML output to the named smarty variable.</li>
  </ul>
  <p>Example: <code>{cd_selcategory prefix=$actionid name='cd_category' selected=$cd_category}</code></p>
</li>
<li><strong>{cd_selhierarchy [options]}</strong> - Provide a dropdown control for selecting a CompanyDirectory Hierarchy.<br/>Options:
  <ul>
    <li>prefix=string - A prefix for the select elements name.</li>
    <li>id=string - The select element id.</li>
    <li>name=string - The select element name.</li>
    <li>selected=integer - The selected hierarchy id</li>
    <li>none=integer - Wether &quot;none&quot; is a valid option in the select element.</li>
    <li>assign=string - Assign the generated XHTML output to the named smarty variable.</li>
  </ul>
  <p>Example: <code>{cd_selhierarchy prefix=$actionid name='cd_hierarchy' selected=$my_hier}</code></p>
</li>
  <li><strong>{cd_initjs [assign=string]}</strong> - Return tags to include necessary javascript for advanced frontend editing functionality.
  <p>This tag is typically plased in the metadata section of pages where advanced companydirectory frontend editing functionality is required.  It generates the &lt;script&gt; tags and other javascript to enable some ajax functionality.</p>
  </li>
<li><strong>{cd_getcompany id=integer [assign=string]}</strong> - Return an object filled with information about a single company<br/>Options:
  <ul>
  <li><strong>id=integer</strong> - The company id (required).</li>
  <li>detailpage=string - (optional) Detailpage alias or id.  If not specified, the preference value will be used.</li>
  <li>assign=string - (optional) Assign the generated XHTML output to the named smarty variable.</li>
  </ul>
  <p>Example: {cd_getcompany id=$company_id assign='tmp'}&lt;pre&gt;{$tmp|@print_r}&lt;/pre&gt;</p>
</li>
<li><strong>{cd_searchstats list=array [days=integer] [assign=string]}</strong>
  <p>Collect a count of searches for each of the companies specified in the list parameters.  This tag is typically used in the frontendlist template to show a company owner a count of the number of searches that his companies were matched for within the specified number of days.</p>
  Options:
  <ul>
  <li><strong>list=array</strong> - An array of integers containing company ids.</li>
  <li>days=integer - (optional,default = 365) Specify the number of days that search staistics should be gathered for.</li>
  <li>assign=string - (optional) Assign the generated array output to the named smarty variable.</li>
  </ul>
  <p>Example: {$list=[5,10,20,35]}{cd_searchstats list=$list days=90 assign='tmp'}&lt;pre&gt;{$tmp|@print_r}&lt;/pre&gt;</p>
</li>
<li><strong>{cd_getcategory category=int [assign=string]}</strong>
  <p>This tag retrieves the information for the specified category id.  Useful in summary views for a specific category.</p>
  <p>Usage:</p>
  <pre><code>{if isset($filter.categoryid)}
{cd_getcategory category=$categoryid assign='cat'}
&lt;h4&gt;The category name is: {$cat.name}&lt;/h4&gt;
{/if}</code></pre>
</li>
</ul>

<h3>The Filter Object</h3>
<p>The summary view makes use of an advanced filter object that contains all of the criteria used when building the view.  This filter object is provided to smarty on display to be used when building advanced displays.  It behaves much like a smarty array, and contains numerous fields:</p>
<ul>
  <li><strong>name</strong>
    <p>The name string used for filtering results.</p>
  </li>
  <li><strong>phrase</strong>
    <p>The phrase string used for filtering results.</p>
  </li>
  <li><strong>sortby</strong>
    <p>The sorting used.</p>
  </li>
  <li><strong>sortorder</strong>
    <p>The sorting used.</p>
  </li>
  <li><strong>category</strong>
    <p>A category name.</p>
  </li>
  <li><strong>categoryid</strong>
    <p>An integer category id (if any) used for filtering.</p>
  </li>
  <li><strong>hier</strong>
    <p>The hierarchy (if any) used for filtering.</p>
  </li>
  <li><strong>nochildren</strong>
    <p>Wether or not child categories should be included in filtering.</p>
  </li>
  <li><strong>address</strong>
    <p>The address (if any) used for filtering.</p>
  </li>
  <li><strong>lat</strong>
    <p>The latitude (if any) used for filtering.</p>
  </li>
  <li><strong>long</strong>
    <p>The longitude (if any) used for filtering.</p>
  </li>
  <li><strong>radius</strong>
    <p>The radius (if any) used for filtering.</p>
  </li>
</ul>

<h3>Fields</h3>
  <p>This module provides the ability to dynamically extend the structure of the system by adding fields to associate with each data record.  These fields can be addressed in the summary and detail views.  The fields can be edited in the various forms and searched.</p>
  <p>Various modules can provide different field types to the CompanyDirectory module.  i.e: When the CGSocialApp module is installed and properly configured, an &quot;Activity&quot; field type is available.  When either CGGoogleMaps or CGGoogleMaps2 are installed, an &quot;icon&quot; field type is available.&quot;
  <p>In the summary and detail templates the fields that are valid for a company are available via smarty in the {$entry->fields} associative array.  The keys to this array are the field names, and the values are objects that provide information about the field, including its value(s).</p>
  <p>To see what fields are available, and the values of the various objects you can add this to your smarty template:</p>
  <pre><code>&lt;pre&gt;{$entry->fields|@print_r}&lt;/pre&gt;</code></pre>
  <p>To see the data available for a specific field you can add this <em>(temporarily)</em> to your smarty template:</p>
  <pre><code>&lt;pre&gt;{$entry->fields<span style="color: red;">.FIELDNAME</span>|@print_r}&lt;/pre&gt;</code></pre>
  <p>To output the value of a single field you can addthis to your smarty template:</p>
  <pre><code>&lt;pre&gt;{$entry->fields<span style="color: red;">.FIELDNAME</span>->value&lt;/pre&gt;</code></pre>

<h3>Albums</h3>
  <p>The album field type allows associating multiple images with a single company entry.  They are represented in the summary and detail templates as a simple array of filenames.  You may build your own display mechanism from this.</p>
  <p>The album field type does not provide any image processing capabilities.  Image processing such as watermarking or thumbnailing can be done at the tiem of display with an addon module like CGSmartImage.</p>
<h4>Sample Gallery</h4>
  <p>The code below illustrates how a simple album can be created from within the CompanyDirectory summary or detail template.  This example uses CGSmartImage to size the thumbnails, and target images, and gives each link a class that can be used to generate a javascript popup window.</p>
<pre><code>
{if isset(<span style="color: red;">$entry->fields.Album</span>)}
  <span style="color: green;">{JQueryTools action=require lib=fancybox}</span><span style="color: blue;">{* see the help for the JQueryTools module for more information *}</span>
  &lt;h3&gt;Gallery&lt;/h3&gt;
  &lt;div class="gallery"&gt;
  {foreach from=<span style="color: red;">$entry->fields.Album->value</span> item='img'}
&lt;a class="fancybox" style="float: left; width: 110px;" href="<span style="color: green;">{CGSmartImage src1=$entry->fields.Album->picture_path src2=$img width=500 height=500 notag=1 noembed=1}</span>"/&gt;<span style="color: green;">{CGSmartImage src1=$entry->fields.Album->picture_path src2=$img width=100 height=100}</span>&lt;/a&gt;
  {/foreach}
  &lt;div style="clear: both;"&gt;&lt;/div&gt;
  &lt;/div&gt;
{/if}
</code></pre>

<h3>Pretty URLS</h3>
<p>Pretty URLS are ideal for websites where search engine optimization is a real concern.  It provides a shorter, friendlier URL that search engines will treat better, and that are easier to share.  However they come at a cost.  Particularly, many of the parameters specified in the call to CompanyDirectory, that should be passed down to another view via a link cannot be passed on a pretty url.</p>
<p>For example, when pretty urls are not enabled it is possible to call the browsecat action like this: {CompanyDirectory action=categorylist summarytemplate=somesummary detailtemplate=somedetail detailpage=mydetailpage pagelimit=25 sortby=cgblog_extra sortorder=asc}.  Now when the categorylist action generates its display, including links to summary views for each category, it should pass the summarytemplate,detailtemplate,detailpage,paglimit,sortby, and sortorder parameters along on the URL For the resulting summary view to use.   However, it is not possible to pass these parameters on a pretty URL, and to keep them &quot;pretty&quot;</p>
<p>To that end, it is possible to provide default values for many of these parameters via CompanyDirectory admin console.  This however, limits the flexibility of the module in some ways.  Another possibility is to use the {cge_module_hint} tag to provide behavioral hints to the module on destination pages.</p>

<h3>Security</h3>
<p>In order to manage the companies inside this module, the administrator must have the '<em>Modify Company Directory</em>' permission.</p>
<p>In order to edit the built in templates that control the layout of the companydirectory information, the administrator needs the '<em>Modify Templates</em>' permission.</p>
<p>To adjust the various settings, the '<em>Modify Site Preferences</em>' permission is required.</p>

<h3>Support</h3>
<p>The module author is in no way obligated to provide support for this code in any fashion.  However, there are a number of resources available to help you with it:</p>
<ul>
<li>A bug tracking and feature request system has been created for this module <a href="http://dev.cmsmadesimple.org/projects/companydir">here</a>.  Please be verbose and descriptive when submitting bug reports and feature requests, and for bug reports ensure that you have provided sufficient information to reliably reproduce the issue.</li>
<li>Additional discussion of this module may also be found in the <a href="http://forum.cmsmadesimple.org">CMS Made Simple Forums</a>.  When describing an issue please make an effort to provide all relavant information, a thorough description of your issue, and steps to reproduce it or your discussion may be ignored.</li>
<li>The author, calguy1000, can often be found in the <a href="irc://irc.freenode.net/#cms">CMS IRC Channel</a>.</li>
<li>Lastly, you may have some success emailing the author directly.  However, please use this as a last resort, and ensure that you have followed all applicable instructions on the forge, in the forums, etc.</li>
</ul>

<h3>Copyright and License</h3>
<p>Copyright &copy; 2012, Robert Campbell <a href="mailto:calguy1000@cmsmadesimple.org">&lt;calguy1000@cmsmadesimple.org&gt;</a>. All Rights Are Reserved.</p>
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
