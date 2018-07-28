<style type="text/css" scoped>
h5 {
  margin-top: 0.75em;
  margin-bottom: 0.75em;
}
li.top {
  margin-bottom: 1em;
}
code.tag {
  font-size: 14px;
  color: green;
}
</style>
<h3>What Does This Do?</h3>
<p>This module merely provides convenience api's, re-usable forms, and smarty tags for use in other modules.  It is meant solely from which to build other modules. If you are not a programmer you probably won't need to do anything with this module besides adjust some preferences.</p>

<h3 style="color: #f00;">Notes</h3>
<p>Many modules take advantages of the forms that are provided by the CGExtensions module to assist in managing templates.  When they do, the CGExtensions module information is displayed prominently.  However when you submit, or cancel from these forms you will be returned to the original module.</p>

<h3>How Do I Use It</h3>
<p>Well, you start your own module (I suggest starting with the Skeleton module), and then when you need to use an advanced form object from this library, simply make your module dependant upon FormObjects, and then instantiate an object of the appropriate type.  See the code inside the FormObjects directory for usage instructions.</p>
<h3>Smarty Addons</h3>
<p>This module adds a few smarty conveniences for use with other modules. They are listed and described here:</p>
<ul>

<li class="top"><code class="tag">{cge_module_hint module=string ...}</code>
  <p>This function plugin can be used to provide hints for module behavior if various parameters cannot be specified on the URL.  I.e: In a situation when a site is configured to use pretty urls for SEO purposes it is often impossible to provide additional module parameters like a detailtemplate or sort order on a URL.  This plugin can be used in page templates, GCBs or in a page specific way to give hints as to how modules should behave.</p>
  <p><strong>Note:</strong> Any parameters that are specified on the URL will override matching module hints.   i.e:  When using CGBlog and a detailtemplate parameter is specified on a CGBlog detail url, any detailtemplate hints will have no effect.</p>
<p><strong>Note:</strong> In order to ensure proper behavior, module hints must be created before the {content} tag is executed in the CMSMS page template.  Therefore they should (normally) be created very early in the page template process.  An ideal location for page specifc hints is in the &quot;Smarty data or logic that is specific to this page:&quot; textarea on the editcontent form.</p>
  <h5>Example:</h5>
  <p>When using the CGBlog module, and pretty urls.  You wish to display blog articles for a specific category on one page, and would like to use a non standard detail template to display the individual articles on a differernt page.  I.e: perhaps on your &quot;Sports&quot; page you are calling CGBlog like: <code>{CGBlog category=sports detailpage=sports_detail}</code>.  However, using pretty urls it is impossible to specify a detailtemplate on the links that will generate the detail views.  The solution is to use the {cge_module_hint} tag on the <u>sports_detail</u> page to provide some hints as to how CGBlog should behave on that page.</p>
  <p>When editing the <u>sports_detail</u> page on the options tab, in the textarea entitled &quot;Smarty data or logic that is specific to this page:&quot; you could enter a tag such as: <code>{cge_module_hint module=CGBlog detailtemplate=sports}</code>.  Now when a user clicks on a link from the CGBlog display on your &quot;sports&quot; page he will be directed to the <u>sports_detail</u> page, and the CGBlog detail template entitled &quot;sports&quot; will be used to display the article.</p>
  <ul>
    <li>It is possible to specify multiple parameter hints to a single module in one call to this plugin.</li>
    <li>It is possible to call this module multiple times in a request to provide hints to different modules.</li>
  </ul>
  <h5>Usage:</h5>
<pre><code>{cge_module_hint module=CGBlog summarytemplate=something detailpage=home}
{cge_module_hint module=CGSmartImage noembed=1}</code></pre>
</li>

<li class="top"><code class="tag">{cgerror [errorclass=string]}...{/cgerror}</code>
  <p>This block plugin uses the error template (configurable from the CGExtensions admin interface) to display an error message.</p>
  <p>Arguments:</p>
  <ul>
    <li>'errorclass' - (string) override the default class name in the template.</li>
  </ul>
  <p>Usage:</p>
  <pre><code>{cgerror}This is error text{/cgerror}</code></pre>
</li>

<li class="top"><code class="tag">{cge_content_type type=string}</code>
  <p>This plugin is used to change the mime type of an action.  This is particularly useful in templates that are in response to ajax requests.</p>
  <p>Arguments:</p>
  <ul>
     <li>'type' - (string) The desired output mime type.</li>
  </ul>
</li>

<li class="top"><code class="tag">{cge_cached_url url=string [time=int] [assign=string]}</code>
  <p>This plugin to retrieve the contents of a remote URL and cache the contents for a specified number of minutes.  Then returns those.  This plugin is useful for retrieving the contents of remote URLS, or of local urls that represent expensive operations but can be cached.</p>
  <p>Arguments:</p>
  <ul>
    <li>'url' - (string) - The URL to fetch and cache</li>
    <li>'time' - (int) - The number of minutes to cache this url for. The default value is 120</li>
    <li>'assign' - (string) - Assign the output of this plugin to the named smarty variable.</li>
  </ul>
  <p>Usage:</p>
  <pre><code>&lt;div id="something"&gt;{cge_cached_url url=something}&lt;/div&gt;</code></pre>
  <p>Tip:  It is possible to use this function to cache expensive operations:</p>
  <ol>
    <li>Create a new page template with just <code>{content}</code> in it. Name the page template something like content_only</li>
    <li>Create a new content page using the new content_only page template.  Ensure that it will not be shown in the menu. In the content area of this page place smarty tags or other functions that are quite expensive in processing but do not need to be refreshed regularly.  Remember the page alias for this new page.</li>
    <li>On your normal page template(s) call <code>{cge_cached_url url="{cms_selflink href=$page_alias}"}</code></li>
  </ol>
</li>

<li class="top"><code class="tag">{cge_isbot [assign=name]}</code>
  <p>This plugin returns a boolean indicating wether or not the user agent of the request has been identified to be a robot.</p>
  <p>Arguments:</p>
  <ul>
    <li>'assign' - (string) - Assign the output of this plugin to the named smarty variable.</li>
  </ul>
  <p>Usage:</p>
  <pre><code>{cge_isbot assign='isbot'}{if $isbot}&lt;h3&gt;You are a bot&lt;/h3&gt;{/if}</code></pre>
</li>

<li class="top"><code class="tag">{cge_is_smartphone [assign=name]}</code>
  <p>This plugin determines wether the request is from a smart phone such as an iphone or android.<p>
  <p>Arguments:</p>
  <ul>
    <li>'assign' - (string) - Assign the output of this plugin to the named smarty variable.</li>
  </ul>
  <p>Usage:</p>
  <pre><code>{cge_is_smartphone assign='isphone'}{if !$isphone}{* display more stuff *}{/if}</code></pre>
</li>

<li class="top"><code class="tag">{cge_getbrowser [assign=name]}</code>
  <p>This plugin returns a short string indicating the browser type.</p>
  <p>Arguments:</p>
  <ul>
    <li>'assign' - (string) - Assign the output of this plugin to the named smarty variable.</li>
  </ul>
  <p>Usage:</p>
  <pre><code>{cge_getbrowser assign='browser'}{if $browser == 'chrome'}{* display more stuff *}{/if}</code></pre>
</li>

<li class="top"><code class="tag">{cge_isie [assign=name]}</code>
  <p>This plugin returns wether or not the current request was made by <em>(eeewww)</em> Internet Exploder.  It returns 0 or 1.</p>
  <p>Arguments:</p>
  <ul>
    <li>'assign' - (string) - Assign the output of this plugin to the named smarty variable.</li>
  </ul>
  <p>Usage:</p>
  <pre><code>{cge_isie assign='ie'}{if $ie}&lt;h3 style="color: red;"&gt;Eeeeww!!!&lt;/h3&gt;{/if}</code></pre>
</li>

<li class="top"><code class="tag">{cge_state_options [selected=string] [selectone=string]}</code>
  <p>Output a set of &lt;option&gt; tags for states.  The values are US/Canada State/Province abbreviations, the labels are the full length names in english.  This method reads the defined state list as defined in the database.</p>
  <p>Arguments:</p>
  <ul>
    <li>'selected' - (string) - Indicates the currently selected option.  Should be a state or province abbreviation.</li>
    <li>'selectone' - (string) - Adds an option to the top of the dropdown indicating that no value has been selected.</li>
  </ul>
  <p>Usage:</p>
  <pre><code>&lt;select name="state"&gt;{cge_state_options selected=$mystate}&lt;/select&gt;</code></pre>
</li>

<li class="top"><code class="tag">{cge_country_options [selected=string] [selectone=string]}</code>
  <p>Output a set of &lt;options&gt; tags for countries.  The values are approved country codes, the labels are the full length names (in english).  This method reads the country list as defined in the database, and takes into account the priority countries as defined in the CGExtensions admin console.</p>
  <p>Arguments:</p>
  <ul>
    <li>'selected' - (string) - Indicates the currently selected option.  Should be a country abbreviation.</li>
    <li>'selectone' - (string) - Adds an option to the top of the dropdown indicating that no value has been selected.</li>
  </ul>
  <p>Usage:</p>
  <pre><code>&lt;select name="state"&gt;{cge_country_options selected=$mystate}&lt;/select&gt;</code></pre>
</li>

<li class="top"><code class="tag">{get_current_url [assign=string]}</code>
  <p>Return the current request url (without fragment, or query arguments).  This plugin is useful to build form or anchor links or for any other tag that requires knowing the current page URL.</p>
  <p>Arguments:</p>
  <ul>
    <li>'assign' - (string) - Assign the output of this plugin to the named smarty variable.</li>
  </ul>
  <p>Usage:</p>
  <pre><code>&lt;a href="{get_current_url}#anchor"&gt;Go to Anchor&lt;/a&gt;</code></pre>
</li>

<li class="top"><code class="tag">{cge_setlist name=string key=string value=string}</code>
  <p style="color: red;">Deprecated... this functionality is available natively in Smarty now.</p>
  <p>Allows adding items to flat smarty arrays. This plugin returns no output</p>
  <p>Arguments:</p>
  <ul>
    <li>&quot;name&quot; - The name of the smarty array.</li>
    <li>&quot;key&quot; - The array key.<li>
    <li>&quot;value&quot; - The array value.</li>
  </ul>
  <p>Usage:</p>
  <pre><code>{cge_setlist name=items key=item1 value='value1'}</code></pre>
</li>

<li class="top"><code class="tag">{cge_unsetlist name=string key=string}</code>
  <p style="color: red;">Deprecated... this functionality is available natively in Smarty now.</p>
  <p>Removing items from flat smarty arrays. This plugin returns no output</p>
  <p>Arguments:</p>
  <ul>
    <li>&quot;name&quot; - The name of the smarty array.</li>
    <li>&quot;key&quot; - The array key.<li>
  </ul>
  <p>Usage:</p>
  <pre><code>{cge_unsetlist name=items key=item1}</code></pre>
</li>

<li class="top"><code class="tag">{cge_yesno_options [prefix=string] [name=string] [id=string] [class=string] [selected=string] [assign=string]}</code>
  <p>Output options for a dropdown list that allows selecting two options, &quot;Yes&quot; or &quot;No&quot;.  This plugin will output the &lt;option&gt; tags using localized strings for the labels, and integers for the values.</p>
  <p>Arguments:</p>
  <ul>
    <li>&quot;prefix&quot; - (string) A prefix to place before the name attribute on the tag.  i.e: prefix=$actionid</li>
    <li>&quot;name&quot; - (string) A name for the select list, if this parameter is specified the system will generate a complete &lt;select&gt; tag.  Otherwise, only &lt;option&gt; tags will be generated.</li>
    <li>&quot;id&quot; - (string) An id attribue for the select list.  Only useful if the name is also specified.</li>
    <li>&quot;class&quot; - (string) A class attribue for the select list.  Only useful if the name is also specified.</li>
    <li>&quot;selected&quot; - (string) The value of the currently selected element (either 0 or 1)</li>
    <li>&quot;assign&quot; - (string) Assign the output html code to a newly generated smarty variable.</li>
  </ul>
  <p>Usage:</p>
  <pre><code>{cge_yesno_options name=flag selected=$myflag}</code></pre>
</li>

<li class="top"><code class="tag">{cge_have_module m|mod|module=string [assign=string]}</code>
  <p>Output a boolean (0 or 1) value if the specified module is installed and ready to use.</p>
  <p>Arguments:</p>
  <ul>
    <li>&quot;m&quot;|&quot;mod&quot;|&quot;module&quot; - (string) Specify the module name</lI>
    <li>&quot;assign&quot; - (string) Assign the output html code to a newly generated smarty variable.</li>
  </ul>
  <p>Usage:</p>
  <pre><code>{cge_have_module module='Cart2' assign='cart2'}{if $have_cart2}{Cart2}{/if}</code></pre>
</li>

<li class="top"><code class="tag">{cgimage image=string [alt=string] [class=string] [width=int] [height=int] [assign=string]}</code>
  <p>Output an image tag, This plugin is typically used in admin templates, as it automatically searches in the admin theme, and in registered icon directories.</p>
  <p>Arguments:</p>
  <ul>
    <li>&quot;image&quot; - The filename of the image.  You may specify a filename, or a path relative to the admin theme&quot;s images directory.</li>
    <li>&quot;alt&quot; - Specify alt text for the image.  If not specified, the value of the image parameter will be used.</li>
    <li>&quot;class&quot; - Specify a class for the image tag.</li>
    <li>&quot;width&quot; - Specify an integer width for the image tag.</li>
    <li>&quot;height&quot; - Specify an integer height for the image tag.</li>
    <li>&quot;assign&quot; - Assign the output html code to a newly generated smarty variable.</li>
  </ul>
  <p>Usage:</p>
  <pre><code>{cgimage image='icons/system/newobject.gif' alt='Create new item'}</code></pre>
</li>

<li class="top"><code class="tag">rfc_date</code> - <em>modifier</em>
  <p>Format a supplied time in an RFC consistent manner.  This modifier is particularly useful when generating RSS feeds.</p>
  <p>Usage:</p>
  <pre><code>{$smarty.now|rfc_date}</code></pre>
</li>

<li class="top"><code class="tag">{jsmin}...{/jsmin}</code>
  <p>Pass content through the javascript minifier.</p>
  <p>Usage:</p>
  <pre><code>{jsmin}
$(document).ready(function(){
  $(document).tooltip();
})
{/jsmin}</code></pre>
  <p>Note: You must specify the approprate {literal},{/literal},{ldelim|, and {rdelim} inside the block to allow smarty to process or ignore the code.</p>
</li>

<li class="top"><code class="tag">{cge_textarea [prefix=string] [name=string] [wywisyg]=bool [syntax=bool] [content=string] [class=string] [id=string] [rows=int] [cols=int] [assign=string]}</code>
  <p>Create a text area tag, with optional support for WYSIWYG editor or syntax hilighter.  This tag is typically used in admin templates to create text areas.</p>
  <p>Arguments:</p>
    <ul>
      <li>&quot;prefix&quot; - (string) A string to prefix the textarea element name.  i.e: {$actionid}</li>
      <li>&quot;name&quot; - (string, <strong>required</strong>) The element name.</li>
      <li>&quot;wysiwyg&quot; - (bool) Indicates wether a WYSIWYG should be applied (the actual WYSIWYG that is used depends on CMSMS site preferrences and user preferences.</li>
      <li>&quot;syntax&quot; - (bool) Indicates wether the preferred syntax hilighter (if any are available and selected) should be applied. If both WYSIWYG and syntax are true, then wysiwyg is preferred.  No check is done to see if a WYSIWYG module is actually available.  This parameter is ignored when this tag is used for frontend requests.</li>
      <li>&quot;content&quot; - (string) )The content for the text area.</li>
      <li>&quot;class&quot; - (string) An optional class to supply to the text area tag.</li>
      <li>&quot;id&quot; - (string) An optional id attribute for the text area tag.</li>
      <li>&quot;rows&quot; - (int) An optional rows attribute for the text area tag.</li>
      <li>&quot;cols&quot; - (int) An optional cols attribute for the text area tag.</li>
      <li>&quot;assign&quot; - (int) Assign the output html code to a newly generated smarty variable.</li>
    </ul>
  <p>Usage:</p>
  <pre><code>{cge_textarea prefix=$actionid name=description content=$description wysiwyg=1}</code></pre>
</li>

<li class="top"><code class="tag">{cge_str_to_assoc input=string [delim1=string] [delim2=string] [assign=string]}</code>
  <p style="color: red;">Deprecated</p>
  <p>Convert a URL parameter type string to an associative array.</p>
  <p>Arguments:</p>
    <ul>
      <li>&quot;input&quot; - (string,<strong>required</strong> The input string</li>
      <li>&quot;delim1&quot; - (string) )Delimiter for separating the string into a list of variables.  Defaults to &quot;,&quot;</li>
      <li>&quot;delim2&quot; - (string) Delimiter for separating variable into a variable name and value.  Defaults to &quot;=&quot;</li>
      <li>&quot;assign&quot; - (string) Assign the output html code to a newly generated smarty variable.</li>
    </ul>
  <pre><code>{cge_str_to_assoc input=&quot;var1=val1,var2=val2,var3=val3&quot; assign=&quot;tmp&quot;}</code></pre>
</li>

<li class="top"><code class="tag">{cge_wysiwyg}</code>
  <p>An alias for the {cge_textarea} plugin.</p>
</li>

<li class="top"><code class="tag">{cge_cache [key=string]}...{/cge_cache}</code>
  <p style="color: red;">Deprecated... See the {cge_cache_block} plugin instead.</p>
  <p>This compiler plugin allows caching HTML outout between start and end blocks for performance. By default content between the start and end tags is cached to files in the tmp/cache directory for a period of five minutes.  Later versions of this plugin will allow extending the cache lifetime.</p>
  <p><strong>Note:</strong> This is not technically a block plugin, but does behave like one.</p>
  <p><strong>Note:</strong> This is an advanced plugin that can dramatically improve the average performance of your (primarily static) website, though it should be used with caution as using it incorrectly can cause strange behaviour on your site.  This functionality works best when wrapped around smarty tags that query the database and generate static html content.  This plugin should not be used around dynamic functionality or forms.</p>
  <p><strong>Note:</strong> This plugin utilizes file locking to prevent race conditions.  This may present problems on different platforms.  Use this plugin with caution.</p>
  <p>Arguments:</p>
    <ul>
      <li>&quot;key&quot; - (string) An optional unique key to identify this cache block.  Must contain only alphanumeric charactes.</li>
    </ul>
  <pre><code>{cge_cache}{Products}{/cge_cache}</code></pre>
</li>

<li class="top"><code class="tag">{cge_cache_block [key=string] [expires=int] [lowentropy=boolean]}</code>
   <p>This block plugin allows caching HTML output of the specified block to increase performance.   This plugin is particularly handy for blocks of HTML that are static in nature (don't change often) but require significant server resources to generate.</p>
   <p>This block plugin caches the HTML output.  It is intended to improve performance.  It will not check if the content inside the block has changed, it merely caches the HTML for a specified amount of time (1 hour by default).</p>
   <p>By default, this plugin adds entropy to the key (even if it is auto generated) to ensure that the particular block is cached once per CMSMS page.  This allows use of {cge_cache_block} around navigations and other blocks of code that change for each page, but for which the template syntax is entirely the same.</p>
   <p><strong>Note:</strong> This plugin should not be used around dynamic functionality, or forms.</p>
   <p><strong>Note:</strong> This plugin has no effect when logged in to the CMSMS admin console.  For testing, it is recommended that you use an incognito or private window, or a different browser.</p>
   <p><strong>Note:</strong> This plugin utilizes file locking to prevent race conditions.  This may present problems on different platforms.  Use this plugin with caution.</p>
  <p>Arguments:</p>
    <ul>
      <li>&quot;key&quot; - (string) An optional unique key to identify this cache block.  Must contain only alphanumeric charactes.</li>
      <li>&quot;expires&quot; - (integer) The expiry time for this block (in minutes).  The default value is 120 minutes.</li>
      <li>&quot;lowentropy&quot; - (boolean) Prevent adding entropy to the key.  This allows the same block of HTML to be cached across multiple different pages.</li>
    </ul>
  <pre><code>{cge_cache_block}{Products}{/cge_cache_block}</code></pre>
  <p><strong>Tip:</strong> Never place the {cge_cache_block} tags around the default content block.</p>
  <p><strong>Tip:</strong> Use caution with smarty logic and the assignment of variables within {cge_cache_block} calls.  Do not create smarty variables within the block that will be used outside of the block.</p>
</li>

<li class="top"><code class="tag">{cge_file_list [dir=string] [pattern=string] [excludes=string] [maxdepth=int] [absolute=bool] [options=bool] [novalue=string] [assign=string]}</code>
   <p>A Smarty plugin to retrieve a list of files that match a criteria, and optionally to build a list of HTML options from the results for use in a dropdown</p>
   <p>Arguments:</p>
    <ul>
     <li>&quot;dir&quot; - (string) The name of the directory <em>(relative to the uploads path)</em> to search.</li>
     <li>&quot;pattern&quot; - (string) A list of file patterns separated by || to search for.  i.e: *.pdf||*.doc</li>
     <li>&quot;excludes&quot; - (string) A list of file patterns separated by || to exclude from the returned list.  i.e: Z*</li>
     <li>&quot;maxdepth&quot; - (int) A positive integer representing the maximum depth of directories to search.  Default is to put no limit on directory depth.</li>
     <li>&quot;absolute&quot; - (bool) A boolean option indicating that the absolute path to the files should be used in the returned values.</li>
     <li>&quot;options&quot; - (bool) A boolean option indicating that the output should be a string of html options.</li>
     <li>&quot;selected&quot; - (string) If options is specified, this parameter can be used to specify the currently selected option.</li>
     <li>&quot;novalue&quot; - (string) if the &quot;options&quot; attribute is specified, this parameter can be used to specify the string used to indicate in the generated dropdown or multi select list to indicate that no value has been selected.  By default, there is no option indicating novalue.</li>
     <li>&quot;assign&quot; - (string) Assign the output of this plugin to the named smarty variable.</li>
    </ul>
   <p>Example One: Create a dropdown of PDF files in the uploads/docs directory:</p>
   <pre><code>&lt;select name="{$actionid}pdf_file">{cge_file_list dir=docs options=1 novalue="None" pattern='*.pdf' selected=$somevar}&lt;select&gt;</code></pre>
   <p>Example Two: Create an array of PDF Files in the uploads/docs directory:</p>
     <pre><code>{cge_file_list dir=docs pattern='*.pdf' assign='pdf_files'}</code></pre>
</li>

<li class="top"><code class="tag">{cge_image_list dir=string [extensions=string] [exclude=string] [maxdepth=int] [absolute=bool] [options=bool] [selected=string] [novalue=string] [assign=string]}</code>
   <p>A smarty plugin to retrieve a list of images that match a criteria from a directory, and optionally to build a list of html options from the results.  This plugin is simply a wrapper around the {cge_file_list} plugin described above.</p>
   <p>Arguments:</p>
   <ul>
     <li>&quot;dir&quot; - (string) The name of the directory <em>(relative to the uploads path)</em> to search.</li>
     <li>&quot;extensions&quot; - (string) A list of file patterns separated by || to override the default pattern of *.jpg||*.jpeg||*.png||*.gif||*.bmp||*.ico</li>
     <li>&quot;excludes&quot; - (string) A list of file patterns separated by || to exclude from the returned list.  i.e: Z*||a*</li>
     <li>&quot;maxdepth&quot; - (int) A positive integer representing the maximum depth of directories to search.  Default is to put no limit on directory depth.</li>
     <li>&quot;absolute&quot; - (bool) A boolean option indicating that the absolute path to the files should be used in the returned values.</li>
     <li>&quot;options&quot; - (bool) A boolean option indicating that the output should be a string of html options.</li>
     <li>&quot;selected&quot; - (string) If options is specified, this parameter can be used to specify the currently selected option.</li>
     <li>&quot;novalue&quot; - (string) if the &quot;options&quot; attribute is specified, this parameter can be used to specify the string used to indicate in the generated dropdown or multi select list to indicate that no value has been selected.  By default, there is no option indicating novalue.</li>
     <li>&quot;assign&quot; - (string) Assign the output of this plugin to the named smarty variable.</li>
   </ul>
</li>

</ul>

<h3>Tab Functions:</h3>
<p>This module provides some smarty plugins to assist in building tabbed output in admin side templates.  This aids in further separating the display issues from logic issues.</p>
<h4>Example:</h4>
  <pre><code>
  {cge_start_tabs}
  {cge_tabheader name='tab1' label='Tab One'}
  {cge_tabheader name='tab2' label='Tab Two'}
  {cge_tabcontent_start name='tab1'}
  &lt;p&gt;Content for tab one&lt;/p&gt;
  {cge_tabcontent_end}{* not necessary, but provided for completeness *}
  {cge_tabcontent_start name='tab2'}
  &lt;p&gt;Content for tab two&lt;/p&gt;
  {cge_end_tabs}
  </code></pre>
<ul>

<li class="top"><code class="tag">{cge_start_tabs [assign=string]}</code>
   <p>An admin only smarty plugin useful in admin tabs to indicate the start of tabbed output.  See the brief demo above.</p>
   <p>Arguments:</p>
   <ul>
     <li>&quot;assign&quot; - (string) Assign the output of this plugin to the named smarty variable.</li>
   </ul>
</li>
<li class="top"><code class="tag">{cge_tabheader name=string [label=string] [assign=string]}</code>
   <p>An admin only smarty plugin used to denote the start of a tab header.  See the brief demo above.</p>
   <p>Arguments:</p>
   <ul>
     <li>&quot;name&quot; - (string) The name for the tab.  This shold be all alphanumeric characters, or underscore.</li>
     <li>&quot;label&quot; - (string) The human readable label for this tab.</li>
     <li>&quot;assign&quot; - (string) Assign the output of this plugin to the named smarty variable.</li>
    </ul>
</li>

<li class="top"><code class="tag">{cge_tabcontent_start name=string [assign=string]}</code>
   <p>An admin only smarty plugin used to denote the start of a tab content.  See the demo above.</p>
   <p><strong>Note:</strong> The order of the tabcontents must match exactly the order of the tab headers specified.  Additionally, it is not necessary to denote the ending of the tab headers, as this is detected automatically by the first call to {cge_tabcontent_start}.</p>
   <p>Arguments:</p>
    <ul>
     <li>&quot;name&quot; - (string) The name for the tab.  This shold be all alphanumeric characters, or underscore.</li>
     <li>&quot;assign&quot; - (string) Assign the output of this plugin to the named smarty variable.</li>
    </ul>
</li>

<li class="top"><code class="tag">{cge_tabcontent_end [assign=string]}</code>
   <p>An admin only smarty plugin used to denote the end of a tabs content.  See the demo above.</p>
   <p><strong>Note:</strong>  It is not necessary to call this plugin for each tab, as it is done implicitly by the call to {cge_tabcontent_start} or {cge_end_tabs}.</p>
   <p>Arguments:</p>
   <ul>
     <li>&quot;assign&quot; - (string) Assign the output of this plugin to the named smarty variable.</li>
   </ul>
</li>

<li class="top"><code class="tag">{cge_end_tabs [assign=string]}</code>
   <p>Description: An admin only smarty plugin used to denote the end of tabbed output..  See the demo above.</p>
   <p>Arguments:</p>
    <ul>
     <li>&quot;assign&quot; - (string) Assign the output of this plugin to the named smarty variable.</li>
    </ul>
</li>

<li class="top"><code class="tag">{cge_message key=string [value=string] [assign=string]}</code>
   <p>Description: A simple convenience plugin to store messages in the session and retrieve them. Messages are automatically removed from the session once retrieved.</p>
   <p>See also: class cge_message</p>
   <p>Arguments:</p>
   <ul>
     <li>&quot;key&quot; - (string) The message key.</li>
     <li>&quot;value&quot; - (string) Optionally create a new message variable.</li>
     <li>&quot;assign&quot; - (string) Assign the output of this plugin to the named smarty variable.</li>
   </ul>
   <p>Usage:</p>
   <ul>
     <li>{cge_message key='sample'} - get, erase, and output the value of &quot;sample&quot; if it exists.</li>
     <li>{cge_message key='sample' assign='foo'} - get, erase, and assign the value of &quot;sample&quot; if it exists to the smarty variable foo.</li>
     <li>{cge_message key='sample' value='bar'} - set the value of the key &quot;sample&quot; to &quot;bar&quot;</li>
   </ul>
</li>

<li class="top"><code class="tag">{cge_pageoptions [start_page=int|string] [selected=int|string] [show_navhidden=bool] [none=bool]}</code>
   <p>Description: Generate a list of options for a select statement consisting of matching content pages.  This can be used to select a page as a module preference etc.</p>
   <p>Arguments:</p>
    <ul>
     <li>&quot;start_page&quot; - (int|string) The page id or alias of the parent page.  Only the descendents of this page will be used in the output.</li>
     <li>&quot;selected&quot; - (int|string) The page id or alias of the currently selected page.</li>
     <li>&quot;show_navhidden&quot; - (bool) Wether or not to show content items that are marked as not shown in menu.</li>
     <li>&quot;none&quot; - (bool) Wether or not to show a &quot;None&quot; option at the top of the list.</li>
    </ul>
   <p>Usage:</p>
   <pre><code>&lt;select name="{$actionid}something"&gt;
{cge_pageoptions selected=$some_preference}
&lt;/select&gt;</code></pre>
</li>

</ul>


<h3>Dynamic CSS and Javascript</h3>

<p>Frequently when doing site design, some javascript plugins and custom css are needed explicitily for a single page, or a single form.  You often need to include some javascript code that is unique to that page or form to initialize or activate jquery plugins.   Next you may need to add some specific css styles that will only be used on this page or for this form.  It would be best (for management reasons) if all of that code (requesting the javascript libraries, including extra javascript and/or css) could be maintained from within the single template where it will be used.   However, including javascript inline can impede performance, it is bad form to include javascript libraries from within the (middle) of the html page, and it is bad form and problematic to embed inline stylesheets into html output. The CGExtensions module <em>(v 1.39+)</em> Introduces a few new tags to allow inserting javascript and stylesheets in a &quot;reasonably&quot; cache efficient, and convenient to use mechanism.</p>

<p>The CGExtensions plugins {cgjs_require}, {cgjs_add}, {cgcss_add} and {cgjs_render} allow queing javascript libraries (with their dependencies), single javascript and css files, and inline css and js into single minified urls (one for javascript, and one for css).  This aides in performance (as multiple javascript and css files are concatenated and minified), keeps all relevant code (smarty. javascript, and css) together, and eliminates the issuees of inline code.</p>

<h4>Javascript Libraries</h4>
<p>Numerous CGExtensions derived modules (CGExtensions, CGContacts, and JQueryTools) share various javascript libraries.  requiring that these libraries be included in your output html code is as simple as using the <code>{cgjs_require lib=&lt;libname&gt;}</code> tag in the relavent template.</p>

<h4>Rendering Output</h4>
<p>The <code>{cgjs_render}</code> tag will open all required libraries <em>(and their dependencies)</em>, all required javascript and css files, and all inline javascript and css files, concatenate them into a single javascript file, and a single css file.  Each unique combination of requested libraries, javascript, and css files, and inlined code is hashed into a single 'signature', which is used to determine the output javascript and css filenames.  The tag will then concatenate all of the javascript, minify it, and output to a single javascript file.  Similarly css is output to a single minimized css file.   To improve server side performance, the render functionality will not resolve dependencies, or generate the resulting javascript and css files if the output files already exist (unless they are older than the preset expiry age).</p>
<p>The <code>{cgjs_render}</code> tag should (typically) be put just before the end of the &lt;head&gt; section of the page template. This is because it renders javascript and stylesheets.</p>

<h4>Admin Templates</h4>
<p>The <code>cge_jsloader::render()</code> function is called automatically for each CGExtensions derived admin action.  This means that the {cgjs_require}, {cgjs_add} and {cgcss_add} plugins can all be used from within action templates for CGExtensions derived modules.</p>

<p><strong>Note:</strong> In admin requests, because the CMSMS standard OneEleven admin theme automatically includes the jquery, and jquery ui plugins, these plugins are automatically excluded from rendered output.</p>


<h4>Config Variables</h4>
<p>This functionality listens to a few different <em>(optional)</em> variables in the config.php file:</p>
<ul>
  <li><code>$config['cge_prettyhtml']</code> = (bool:false)
    <p>A flag indicating wether to prettify the HTML output after rendering.  Note:  The head section is not formatted.</p>
  </li>
  <li><code>$config['cge_minhtml']</code> = (bool:false)
    <p>A flag indicating wether to minify the HTML output after rendering.   If both cge_prettyhtml and cge_minhtml are specified, cge_prettyhtml will have precedence.</p>
  </li>
  <li><code>$config['cgjs_cachelife']</code> = (int:24)
    <p>The number of hours that each signature js and/or css file should be cached for, before being regenerated.  The default is 24 hours.</p>
  </li>
  <li><code>$config['cgjs_nocache']</code> = (bool:false)
    <p>This config entry, if set, and true explicitly disables caching.  The combined css and js files will be regenerated for each request.</p>
  </li>
  <li><code>$config['cgjs_nominify']</code> = (bool:false)
    <p>This config entry, if set, and true explicitly disables minifying of javascript or CSS code, independent of other params or flags.</p>
  </li>
  <li><code>$config['developer_mode']</code> = (bool:false)
    <p>This config entry, if set, and true explicitly disables the behavior of the {cge_cache} and {cge_cache_block} plugins.</p>
  </li>
  <li><code>$config['cge_relax_sql']</code> = (bool:false)
    <p>This config entry, if set, and true attempts to set the mysql sql_mode to TRADITIONAL to fix some errors cropping up in queries for users running mysql 5.7+</p>
  </li>
</ul>

<h4>Future Features</h4>

<h4>API Documentation</h4>
<p>TODO</p>

<h4>Tag Usage:</h4>
<ul>

<li><code class="tag">{cgcss_add [depends=mixed] [nominify=true]}...{/cgcss_add}</code>
  <p>This plugin allows adding CSS to the cached stylesheets generated by <code>{cgjs_render}</code>. This is similar to (but better than) embedded CSS &lt;style&gt; tags because the css is concatenated to a minimized, and cached stylesheet that is downloaded by the user once.</p>
  <p>See Also: <code>{cgjs_render}</code></p>
  <p>Arguments:</p>
    <ul>
       <li>depends - (mixed) Either a comma separated string, or an array of required library names.  These libraries (and their dependents will be loaded prior to the inclusion of this css).</li>
       <LI>nominify - (bool) Explicitly disable minifying this CSS.</li>
       <li>append - (bool) Specify that this code should be appended AFTER all regular requires, and includes.  This parameter can be useful considering the order in which CMSMS templates are processed.</li>
    </ul>
  <p>Usage:</p>
<pre><code>{* add some css specific for this page or template *
{cgcss_add}
img.album {
  float: left;
  width: 33%;
  padding: 4px;
}
{/cgcss_add}
</code></pre>
</li>

<li><code class="tag">{cgjs_add [depends=mixed] [nominify=true]}...{/cgjs_add}</code>
  <p>This plugin allows adding javascript to the cached javascript file generated by <code>{cgjs_render}</code>. This is similar to (but better than) embedded &lt;script&gt; tags because the javascript is concatenated to a minimized, and cached stylesheet that is downloaded by the user once.</p>
  <p>See Also: <code>{cgjs_render}</code></p>
  <p>Arguments:</p>
  <ul>
    <li>&quot;depends&quot; - (mixed) A comma separated list of registered lib names, or an array of registered lib names.</li>
    <LI>&quot;nominify&quot; - (bool) explicitly disable minifying this javascript.</li>
    <li>&quot;append&quot; - (bool) specify that this code should be appended AFTER all regular requires, and includes.  This parameter can be useful if there is javascript generated in module templates, and output at the bottom of the page content.</li>
  </ul>
  <p>Usage:</p>
  <pre><code>{* automatically enable jquery ui tooltip functionality *}
{cgjs_add depends=ui}
$(document).ready(function(){
  $(document).tooltip();
});
{/cgjs_add}</code></pre>
</li>

<li><code class="tag">{cgjs_require lib|jsfile|cssname|cssfile=string [depends=mixed] [nominify=true]}</code>
  <p>This plugin allows adding <em>(one of)</em> a predefined javascript library (and its associated css), a CMSMS stylesheet, a static CSS file, or a javascript file to the compiled javascript and css output.  This plugin replaces multiple &lt;script&gt; and/or &lt;link rel=stylesheet ...&gt; tags.</p>
  <p>See Also: <code>{cgjs_render}</code></p>
  <p>Arguments:</p>
    <ul>
      <li>&quot;lib&quot; - (string) A name of a registered library.</li>
      <li>&quot;cssname&quot; - (string) The name of a CMSMS stylesheet.</li>
      <li>&quot;cssfile&quot; - (string) A CSS Filename <em>(relative to the current module, or to the uploads directory)</em></li>
      <li>&quot;cssurl&quot; - (string) A URL to a remote CSS file to fetch and cache.</li>
      <li>&quot;jsfile&quot; - (string) A Javascript filename <em>(relative to the current module, or to the uploads directory)</em></li>
      <li>&quot;jsurl&quot; - (string) A URL to a remote Javascript file to fetch and cache.</li>
      <li>&quot;depends&quot; - (mixed) A comma separated list of registered lib names, or an array of registered lib names.</li>
      <LI>&quot;nominify&quot; - (bool) explicitly disable minifying both the css and the javascript from this library, overriding what is stated in the library.</li>
    </ul>
  <p>Usage:</p>
    <ul>
      <li><code>{cgjs_require lib='fancybox'}</code><br/>Ensure that the fancybox library, and any (registered) libraries that it depends on are loaded.</li>
      <li><code>{cgjs_require jsfile='assets/mystuff.js'}</code><br/>Ensure that the specified javascript file is included in the javascript output when this page is rendered.</li>
      <li><code>{cgjs_require cssname='mystuff'}</code><br/>Ensure that the specified CMSMS stylesheet named 'mystuff' is included in the css output when this page is rendered.</li>
      <li><code>{cgjs_require cssfile='assets/mystuff.css'}</code><br/>Ensure that the specified CSS file is included in the css output when this page is rendered.</li>
      <li><code>{cgjs_require jsfile='assets/mystuff2.js' depends='fancybox'}</code><br/>Ensure that the assets/mystuff2.js file, and it's dependents (fancybox) is included in the javascript output,</li>
    </ul>
  <p>Notes:</p>
     <ul>
       <li>Only one of: lib, jsfile, jsurl, cssfile, cssurl, and cssname are required.  Specifying multiple arguments could result in random behavior.</li>
       <li>The jsfile, cssfile, and cssname arguments all support the depends argument... however it is ignored when specifying the &quot;lib&quot; argument.</li>
       <li>When using remote URLS, they are cached locally before minifying or attaching to the css.</li>
       <li>Libraries, files and code are largely attached in the order they are specified.</li>
     </ul>
</li>

<li><code class="tag">{cgjs_render [excludes=array] [cache_lifetime=int] [nocache=int] [nominify=int] [no_js=int] [no_css=int] [assign=string]}</code>
  <p>This plugin intelligently and recursively resolves all library dependencies, and outputs two tags:</p>
    <ul>
      <li>A script tag to all of the requested javascript (including javascript libraries, javascript files, and embedded javascript), in a single minimized file.</li>
      <li>A stylesheet tag to all of the requested CSS (including that defined for javascript libraries), CSS files, and embedded CSS), in a single minimized file.</li>
    </ul>
  <p>The plugin allows caching the output for an adjustable number of hours, so that the potentially expensive function of resolving all of the dependencies, reading all of the code and concatenating them is minimized.</p>
  <p>Arguments:</p>
  <ul>
    <li>&quot;excludes&quot; - (string[]) - An array of library names to exclude from the output <em>(even if they are required by other libaries)</em> This is useful if some libraries will be included by means external to the <code>{cgjs_require}</code> tag.</li>
    <li>&quot;cache_lifetime&quot; - (int) - The number of hours that the output should be cached for.  The default value is 24.  This value can be overridden globally with the &quot;cgejs_cachelife&quot; config entry.</li>
    <li>&quot;nocache&quot; - (int) - Any non zero value indicates that caching should be turned off entirely... this is potentially an expensive option, and should only be used for development.  This value can be overridden globally with the &quot;cgejs_nocache&quot; config entry.</li>
    <li>&quot;nominify&quot; - (int) - Any non zero value indicates that minifying of javascript and CSS output should be turned off entirely... This value can be overridden globally with the &quot;cgejs_nominify&quot; config entry.</li>
    <li>&quot;nocss&quot; - (int) - Any non zero value indicates that stylesheet tags should not be output.</li>
    <li>&quot;nojs&quot; - (int) - Any non zero value indicates that javascript tags should not be output.</li>
    <li>&quot;addkey&quot; - (string) Add entropy into the cache file name generation algorithm.</li>
    <li>&quot;assign&quot; - (string) Assign the html output of this plugin to the named smarty variable.</lI>
  </ul>
  <p>Usage:</p>
<pre><code>...
{* output all javascript and CSS data queued via the cgjs_require, cgjs_addjs, and cgjs_addcss plugins *}
{cgjs_render}
&lt;/head&gt;</code></pre>
  <p>Notes:</p>
  <ul>
    <li>This plugin is merely a wrapper around the <code>cge_jsloader::render</code> API function.</li>
    <li>The <code>cge_jsloader::render</code> API function is called automatically for admin actions in modules that inherit from CGExtensions.  This means that you can use {cgjs_require}, {cgjs_addcss} and {cgjs_addjs} in any admin side action in any of my modules.</li>
    <li>In admin side actions, because the CMSMS admin theme <em>(OneEleven, and NCleanGrey)</em> automatically include JQuery, and JQuery UI, these libraries <em>(jquery, ui)</em> are automatically added to the exclude list.</li>
    <li>In frontend page templates, I recommend adding this tag to the bottom of the &lt;head&gt; tag so that {cgjs_require}, {cgjs_add} and {cgcss_add} can be called anywhere in module action templates, page templates, etc.</li>
  </ul>
</li>

</ul>

<h3>Admin Styles</h3>
<p>This module, and all modules derived from CGExtensions support loading a separate stylesheet for use in admin requests for that module.  This allows adjusting styles on a per-module basis within the admin console.</p>
<p>To use this, plase a file named admin_styles.css in the <root>/module_custom/<modulename>/css directory, with the css that you want to adjust or override.  i.e:  for the FrontEndUsers module you would:</p>
<p><pre><code>mkdir -p module_custom/FrontEndUsers/css
vi module_custom/FrontEndUsers/css/admin_styles.css</code></pre></p>

<h3>Support</h3>
<p>The module author is in no way obligated to provide support for this code in any fashion.  However, there are a number of resources available to help you with it:</p>
<ul>
<li>A bug tracking and feature request system has been created for this module <a href="http://dev.cmsmadesimple.org/projects/cgextensions">here</a>.  Please be verbose and descriptive when submitting bug reports and feature requests, and for bug reports ensure that you have provided sufficient information to reliably reproduce the issue.</li>
<li>Additional discussion of this module may also be found in the <a href="http://forum.cmsmadesimple.org">CMS Made Simple Forums</a>.  When describing an issue please make an effort to privide all relavant information, a thorough description of your issue, and steps to reproduce it or your discussion may be ignored.</li>
<li>The author, calguy1000, can often be found in the <a href="irc://irc.freenode.net/#cms">CMS IRC Channel</a>.</li>
<li>Lastly, you may have some success emailing the author directly.  However, please use this as a last resort, and ensure that you have followed all applicable instructions on the forge, in the forums, etc.</li>
</ul>

<h3>Copyright and License</h3>
<p>Copyright &copy; 2008, Robert Campbell <a href="mailto:calguy1000@cmsmadesimple.org">&lt;calguy1000@cmsmadesimple.org&gt;</a>. All Rights Are Reserved.</p>
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
