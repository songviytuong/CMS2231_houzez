<h3>What does this do</h3>
<p>This module is a powerful and flexible tool to aide in automatically setting meta tags into your output HTML, and for customizing the value of those meta tags based on page content.</p>
<p>This module should be used by any production website in order to aide in getting your website noticed by search engines, and to aide in integration with social media sites.</p>
<h4>Notices:</h4>
<ul>
  <li>This module has no admin interface <em>(at this time)</em>.
     <p>Adjustments to the output are made directly in the HTML page template editor, or the page editor.  Additionally, you can adjust some settings by adding values to the CMSMS system config.php file.</p>
  </li>
  <li>This module only has the most basic of understanding of some meta tags.  It does not parse the values for meta tags.  Therefore it is important that the user have experience in and knowledge with implementing meta tags.</li>
  <li>Unlike other modules with a similar purpose, this module does not interact with the HTML doctype or viewport, or any other tags that are generally related to display or URL issues (i.e: the &lt;base&gt; tag).  Additionally, it does not include jquery or any other css or javascript frameworks or libraries.  See the JQueryTools module, and the {cgjs_render} plugin suite in the CGExtensions module.</li>
</ul>

<h3>Features</h3>
<ul>
  <li>Uses smarty plugins to interact with meta tags.</li>
  <li>Extendable &quot;Known fields&quot; list</li>
  <lI>Fields are groupable, and you can specify which groups of fields to output.</li>
  <li>Values in the CMSMS config file are used to override default field values.</li>
  <li>Can output the google analytics plugin javascript.</li>
  <li>Default field values are actually smarty templates.</li>
  <li>Handles meta, and link tags.</li>
  <li>Fields with an empty value are not output.</li>
  <li>Does not interfere with the CMSMS built in {metadata} plugin.</li>
  <li>Organizes fields into groups... for easier including and excluding.</li>
  <li>more...</li>
</ul>

<h3>How Do I Use It</h3>
<p>To get basic output, add <code>{cghm_render}</code> into the &quot;Global Metadata&quot; field of the &quot;Global Settings&quot; page.</p>
<p>Note:  You can also put the <code>{cghm_render}</code> tag into the page template directly above {metadata}, or for testing on a single page, you can place the <code>{cghm_render}</code> tag into the metadata section of a content page.</p>

<h3>Smarty Plugins</h3>
<ul>
  <li><code style="color: blue;">{cghm_set}</code>
    <p><strong>Description:</strong> This plugin is used to alter the value of a known meta field.  It can be used to adjust the value of a simple &lt;meta&quot; tag with a name and a content attribute, or a more advanced &quot;link&quot; tag witn multiple attributes.</p>
    <p>Usage:</p>
    <ul>
      <li>Modifying a simple meta tag:  <code style="color: blue;">{cghm_set name|key=string val|value=string}</code>
        <p>Parameters:</p>
	<ul>
	  <li>name|key = string -- specify the name of the meta tag you want to change.</li>
	  <li>val|value = string -- The new value for the meta tag.</li>
	</ul>
	<p>Example:  <code>{cghm_set name=robots val=noindex}</code></p>
      </li>
      <li>Modifying a complex link tag:  <code style="color: blue;">{cghm_set rel=string name=val}</code>
        <p>Parameters:</p>
	<ul>
	  <li>rel = string -- The name of the meta tag you want to change.</li>
	  <li>other parameters = string -- Specify the attribute name (other than rel) and value of the attribute to modify.</li>
	</ul>
	<p>Example:  <code>{cghm_set rel='apple-touch-icon' sizes=='16x16'}</code></p>
      </li>
    </ul>
  </li>
  <li><code style="color: blue;">{cghm_config_set}</code>
    <p><strong>Description:</strong> This plugin is used to alter the value of, or set a config variable.  The config variables can be used in the field templates to set a field value.</p>
    <p>Setting a config variable using this plugin will overwrite in memory (for one request) any values for the same variable read from the CMSMS config file.</p>
    <p>Usage:</p>
    <ul>
      <li><code style="color: blue;">{cghm_config_set key=string val=string}</code>
        <p>Parameters:</p>
	<ul>
	  <li>key|name = string -- The name of the config value you want to change.</li>
	  <li>val|value = string -- The new value for the config variable.</li>
	</ul>
	<p>Example:  <code>{cghm_config_set key='title' val=$val}</code></p>
      </li>
    </ul>
  </li>
  <li><code style="color: blue;">{cghm_unset}</code>
    <p><strong>Description:</strong> This plugin is used to remove a value from a known meta field.  This forces the value of the meta field to be calculated using the default methods.</p>
    <p>Usage:</p>
    <ul>
      <li><code style="color: blue;">{cghm_unset name|key=string}</code>
        <p>Parameters:</p>
	<ul>
	  <li>name|key = string -- specify the name of the meta tag you want to hide.</li>
	</ul>
	<p>Example:  <code>{cghm_unset name='robots'}</code></p>
      </li>
    </ul>
  </li>
  <li><code style="color: blue;">{cghm_hide}</code>
    <p><strong>Description:</strong> This plugin is used to hide a known tag from being rendered in the HTML output.</p>
    <p>Usage:</p>
    <ul>
      <li><code style="color: blue;">{cghm_hide name|key=string}</code>
        <p>Parameters:</p>
	<ul>
	  <li>name|key = string -- specify a comma separated list of the meta tags you want to hide.</li>
	</ul>
	<p>Example:  <code>{cghm_hide name='robots,copyright'}</code></p>
      </li>
    </ul>
  </li>
  <li><code style="color: blue;">{cghm_render}</code>
    <p><strong>Description:</strong> This plugin is used to render all known meta tags with their specified (or calculated) values.</p>
    <p>Usage:</p>
    <ul>
      <li><code style="color: blue;">{cghm_render [groups=string]}</code>
        <p>Parameters:</p>
	<ul>
	  <li>group = string -- specify a comma separated list of known groups to output.  Leaving this blank will use a default group list.  Preceding a group name with an ! will ensure that absolutely no fields that are in that group will be displayed.</li>
	</ul>
	<p>Example:  <code>{cghm_render groups='misc,og,fb,twitter,!old'}</code></p>
      </li>
    </ul>
  </li>
</ul>

<h3>Google Analytics</h3>
<p>This module is capable of outputing the google analytics plugin code, including support for subdomains, and multiple top level domains depending upon the following config values:</p>
<ul>
  <li><code>cghm_ga_propertyid</code> (string)</li>
  <li><code>cghm_ga_subdomains</code> (optional boolean)</li>
  <li><code>cghm_ga_domain</code> (optional string)</li>
  <li><code>cghm_ga_linkdomains</code> (optional string)</li>
  <li><code>cghm_ga_linkid<code> (optional boolean)</li>
  <li><code>cghm_ga_displayfeatures<code> (optional boolean)</li>
</ul>

<h3>Known Fields</h3>
<p>The following meta fields are known by default:</p>
<ul>
  <li>date
    <ul>
      <li>dflt1: {$content_obj->GetModifiedDate()|date_format:'%Y-%m-%dT%h:%m:%sP'}</li>
      <li>group: misc</li>
    </ul>
  </li>
  <li>lastupdate
    <ul>
      <li>dflt1: {$content_obj->GetModifiedDate()|date_format:'%Y-%m-%dT%h:%m:%sP'}</li>
      <li>group: misc</li>
    </ul>
  </li>
  <li>revised
    <ul>
      <li>dflt1: {$content_obj->GetModifiedDate()|date_format:'%Y-%m-%dT%h:%m:%sP'}</li>
      <li>group: misc</li>
    </ul>
  </li>
  <li>canonical
    <ul>
      <li>tag: link</li>
      <li>keyattr: rel</li>
      <li>attr1: href</li>
      <li>dflt1: {$config.canonical|default:$content_obj->GetURL()}</li>
      <li>group: misc</li>
    </ul>
  </li>
  <li>copyright
    <ul>
      <li>dflt1: {$content_obj->GetModifiedDate()|date_format:'%Y'}</li>
      <li>group: misc</li>
    </ul>
  </li>
  <li>title_tag
    <ul>
      <li>dflt: {$config.title|default:\"{title} - {sitename}\"}</li>
      <li>tag: title</li>
      <li>noattrs: 1</li>
      <li>group: misc</li>
    </ul>
  </li>
  <li>title
    <ul>
      <li>dflt1: {$config.title|default:\"{title} - {sitename}\"}</li>
      <li>group: misc</li>
    </ul>
  </li>
  <li>description
    <ul>
      <li>dflt1: {$tmp=$config.description|default:$config.cghm_description|default:''}{if !empty($tmp)}{$tmp}{else}{description}{/if}</li>
      <li>group: misc</li>
    </ul>
  </li>
  <li>expires
    <ul>
      <li>dflt1: **NONE**</li>
      <li>group: misc</li>
    </ul>
  </li>
  <li>revisit-after
    <ul>
      <li>dflt1: **NONE**</li>
      <li>group: misc</li>
    </ul>
  </li>
  <li>google
    <ul>
      <li>dflt1: **NONE**</li>
      <li>group: google</li>
    </ul>
  </li>
  <li>googlebot
    <ul>
      <li>dflt1: **NONE**</li>
      <li>group: google</li>
    </ul>
  </li>
  <li>google-site-verification
    <ul>
      <li>dflt1: **NONE**</li>
      <li>group: google</li>
    </ul>
  </li>
  <li>keywords <em>(see below)</em>
    <ul>
      <li>dflt1: **NONE**</li>
      <li>group: misc</li>
    </ul>
  </li>
  <li>robots
    <ul>
      <li>dflt1: {if $content_obj->Cachable() && $content_obj->IsPermitted()}</li>
      <li>group: misc</li>
    </ul>
  </li>
  <li>x-ua-compatible
    <ul>
      <li>dflt1: **NONE**</li>
      <li>group: misc</li>
    </ul>
  </li>
  <li>author
    <ul>
      <li>dflt1: **NONE**</li>
      <li>tag: link</li>
      <li>keyattr: rel</li>
      <li>attr1: href</li>
      <li>group: misc</li>
    </ul>
  </li>
  <li>meta_author
    <ul>
      <li>dflt1: **NONE**</li>
      <li>keyval: author</li>
      <li>group: misc</li>
    </ul>
  </li>
  <li>publisher
    <ul>
      <li>dflt1: **NONE**</li>
      <li>tag: link</li>
      <li>keyattr: rel</li>
      <li>attr1: href</li>
      <li>group: misc</li>
    </ul>
  </li>
  <li>meta_publisher
    <ul>
      <li>dflt1: **NONE**</li>
      <li>keyval: publisher</li>
      <li>group: misc</li>
    </ul>
  </li>
  <li>geo.placename
    <ul>
      <li>dflt1: {$config.cghm_city|default:''}</li>
      <li>group: geo</li>
    </ul>
  </li>
  <li>geo.region
    <ul>
      <li>dflt1: {$config.cghm_state|default:''}</li>
      <li>group: geo</li>
    </ul>
  </li>
  <li>geo.position
    <ul>
      <li>dflt1: {if !empty($config.cghm_lat) && !empty($config.cghm_long)}{$config.cghm_lat}, {$config.cghm_long}{/if}</li>
      <li>group: geo</li>
    </ul>
  </li>
  <li>ICBM
    <ul>
      <li>dflt1: {if !empty($config.cghm_lat) && !empty($config.cghm_long)}{$config.cghm_lat}, {$config.cghm_long}{/if}</li>
      <li>group: misc</li>
    </ul>
  </li>
  <li>twitter:card
    <ul>
      <li>dflt1: {$config.cghm_twittercard|default:'summary'}</li>
      <li>group: twitter</li>
    </ul>
  </li>
  <li>twitter:site
    <ul>
      <li>dflt1: {$config.cghm_twitterid|default:''}</li>
      <li>group: twitter</li>
    </ul>
  </li>
  <li>twitter:creator
    <ul>
      <li>dflt1: {$config.cghm_twitterid|default:''}</li>
      <li>group: twitter</li>
    </ul>
  </li>
  <li>twitter:uri
    <ul>
      <li>dflt1: {if isset($canonical)}{$canonical}{else}{$config.canonical|default:$content_obj->GetURL()}{/if}</li>
      <li>group: twitter</li>
    </ul>
  </li>
  <li>twitter:image
    <ul>
      <li>dflt1: ** NONE **</li>
      <li>group: twitter</li>
    </ul>
  </li>
  <li>twitter:description
    <ul>
      <li>dflt1: {$tmp=$config.description|default:$config.cghm_description|default:''}{if !empty($tmp)}{$tmp}{else}{description}{/if}</li>
      <li>group: twitter</li>
    </ul>
  </li>
  <li>tweetmeme-title
    <ul>
      <li>dflt1: {$config.title|default:\"{title} - {sitename}\"}</li>
      <li>group: twitter</li>
    </ul>
  </li>
  <li>og:title
    <ul>
      <li>dflt1: {$config.title|default:\"{title} - {sitename}\"}</li>
      <li>group: og</li>
    </ul>
  </li>
  <li>og:type
    <ul>
      <li>dflt1: website</li>
      <li>group: og</li>
    </ul>
  </li>
  <li>og:url
    <ul>
      <li>dflt1: {if isset($canonical)}{$canonical}{else}{$config.canonical|default:$content_obj->GetURL()}{/if}</li>
      <li>group: og</li>
    </ul>
  </li>
  <li>og:image
    <ul>
      <li>dflt1: {$config.image|default:$config.cghm_image|default:''}</li>
      <li>group: og</li>
    </ul>
  </li>
  <li>og:site_name
    <ul>
      <li>dflt1: {sitename}</li>
      <li>group: og</li>
    </ul>
  </li>
  <li>og:description
    <ul>
      <li>dflt1: {$tmp=$config.description|default:$config.cghm_description|default:''}{if !empty($tmp)}{$tmp}{else}{description}{/if}</li>
      <li>group: og</li>
    </ul>
  </li>
  <li>og:latitude
    <ul>
      <li>dflt1: {$config.cghm_lat|default:''}</li>
      <li>group: og</li>
    </ul>
  </li>
  <li>og:longitude
    <ul>
      <li>dflt1: {$config.cghm_long|default:''}</li>
      <li>group: og</li>
    </ul>
  </li>
  <li>og:street_address
    <ul>
      <li>dflt1: {$config.cghm_address|default:''}</li>
      <li>group: og</li>
    </ul>
  </li>
  <li>og:locality
    <ul>
      <li>dflt1: {$config.cghm_city|default:''}</li>
      <li>group: og</li>
    </ul>
  </li>
  <li>og:region
    <ul>
      <li>dflt1: {$config.cghm_state|default:''}</li>
      <li>group: og</li>
    </ul>
  </li>
  <li>og:postal-code
    <ul>
      <li>dflt1: {$config.cghm_postal_code|default:''}</li>
      <li>group: og</li>
    </ul>
  </li>
  <li>og:country-name
    <ul>
      <li>dflt1: {$config.cghm_country|default:''}</li>
      <li>group: og</li>
    </ul>
  </li>
  <li>og:email
    <ul>
      <li>dflt1: {$config.cghm_email|default:''}</li>
      <li>group: og</li>
    </ul>
  </li>
  <li>og:phone-number
    <ul>
      <li>dflt1: {$config.cghm_phone|default:''}</li>
      <li>group: og</li>
    </ul>
  </li>
  <li>og:fax-number
    <ul>
      <li>dflt1: {$config.cghm_fax|default:''}</li>
      <li>group: og</li>
    </ul>
  </li>
  <li>fb:page_id
    <ul>
      <li>dflt1: {$config.cghm_fbpageid|default:''}</li>
      <li>group: fb</li>
    </ul>
  </li>
  <li>fb:admins
    <ul>
      <li>dflt1: {$config.cghm_fbadmins|default:''}</li>
      <li>group: fb</li>
    </ul>
  </li>
  <li>fb:app_id
    <ul>
      <li>dflt1: {$config.cghm_fbAPPID|default:''}</li>
      <li>group: fb</li>
    </ul>
  </li>
  <li>msvalidate.01
    <ul>
      <li>dflt1: **NONE**</li>
      <li>group: misc</li>
    </ul>
  </li>
  <li>apple-mobile-web-app-capable
    <ul>
      <li>dflt1: {$config.chm_webappcapable|default:0}</li>
      <li>group: apple</li>
    </ul>
  </li>
  <li>apple-mobile-web-app-status-bar-style
    <ul>
      <li>dflt1: default</li>
      <li>group: apple</li>
    </ul>
  </li>
  <li>apple-touch-icon
    <ul>
      <li>tag: link</li>
      <li>keyattr: rel</li>
      <li>attr1: href</li>
      <li>dflt1: {root_url}/favicon_cms.ico</li>
      <li>attr2: type</li>
      <li>dflt2: image/x-icon</li>
      <li>group: apple</li>
    </ul>
  </li>
  <li>&quot;shortcut icon&quot;
    <ul>
      <li>tag: link</li>
      <li>keyattr: rel</li>
      <li>attr1: href</li>
      <li>dflt1: **NONE**</li>
      <li>attr2: type</li>
      <li>dflt2: image/x-icon</li>
      <li>attr3: sizes</li>
      <li>dflt3: 32x32</li>
      <li>group: apple</li>
    </ul>
  </li>
</ul>

<h3>Config Variables:</h3>
<p>This module will read any config variables starting with the cghm_ prefix.  They can be used in the default values for fields. Here is a description of some of the config variables that this module may by default refer to:</p>
<table width="100%" border="1">
  <tr>
    <th colspan="3">Fixed config variables:</th>
  </tr>
  <tr>
    <td>cghm_ga_propertyid</td>
    <td>string</td>
    <td>The Google Analytics property id.  If this config entry is not set, no google analytics javascript code will be generated.</td>
  </tr>
  <tr>
    <td>cghm_ga_subdomains</td>
    <td>bool</td>
    <td>Wether or not to include subdomains in the analytics tracking.  This is useful if this website has, or will in the future have subdomains.</td>
  </tr>
  <tr>
    <td>cghm_ga_domain</td>
    <td>string</td>
    <td>An optional domain name to use in the google analytics javascript code.  If none is specified, the system will use the host portion of the CMSMS root url.</td>
  </tr>
  <tr>
    <td>cghm_ga_linkdomain</td>
    <td>string</td>
    <td>An optional comma separated list of top level domains to include in the tracking for this user.  Note:  The same propertyid must be used on all domains if linking across top level domains.</td>
  </tr>
  <tr>
    <td>cghm_ga_linkid</td>
    <td>bool</td>
    <td>A flag indicating wether or not to enable enhanced link attribution in google analytics.</td>
  </tr>
  <tr>
    <td>cghm_ga_displayfeatures</td>
    <td>bool</td>
    <td>A flag indicating wether or not to enable the display features plugin.</td>
  </tr>
  <tr>
    <th colspan="3">Generic config variables:
      <p>Generic config variables are those used by default for standard tags like title, description, image, and canonical.  Using the standard field templates, these are usually used in the event where numerous meta tags may have the same value.</p>
      <p>These can still be overridden by using the {cghm_set} tag to specify a specific value for a specific meta tag.</p>
    </th>
  </tr>
  <tr>
    <td>title</td>
    <td>string</td>
    <td>The page title. This will typically be used for the title tag, the meta title tag, the og:title tag, and the twitter:title tag./td>
  </tr>
  <tr>
    <td>canonical</td>
    <td>string</td>
    <td>The canonical url for the pagee. This will typically be used for the rel=canonical tag, the twitter:uri tag, and the og:url tag./td>
  </tr>
  <tr>
    <td>description</td>
    <td>string</td>
    <td>The page description.  This will typically be used for the meta description tag, and twitter:description tag, and the og:description tag.</td>
  </tr>
  <tr>
    <td>image</td>
    <td>string</td>
    <td>The complete URL to the single image to use for this page.  specifically it is used for the og:image and the image_src meta tags.</td>
  </tr>

  <tr>
    <th colspan="3">Flexible config variables:</th>
  </tr>
  <tr>
    <td>cghm_hidden</td>
    <td>string</td>
    <td>A comma separated list of field names to explicitly not display.</td>
  </tr>
  <tr>
    <td>cghm_groups</td>
    <td>string</td>
    <td>A comma separated list of group names to display.  The default value is: &quot;dates,misc,google,geo,twitter,og,fb,apple,!old&quot;</td>
  </tr>
  <tr>
    <td>cghm_address</td>
    <td>string</td>
    <td>The business street address</td>
  </tr>
  <tr>
    <td>cghm_city</td>
    <td>string</td>
    <td>The business city</td>
  </tr>
  <tr>
    <td>cghm_description</td>
    <td>string</td>
    <td>The page description.</td>
  </tr>
  <tr>
    <td>cghm_state</td>
    <td>string</td>
    <td>The business state or province</td>
  </tr>
  <tr>
    <td>cghm_postal_code</td>
    <td>string</td>
    <td>The business postal/zip code.</td>
  </tr>
  <tr>
    <td>cghm_postal_country</td>
    <td>string</td>
    <td>The business country</td>
  </tr>
  <tr>
    <td>cghm_postal_email</td>
    <td>string</td>
    <td>The business email address</td>
  </tr>
  <tr>
    <td>cghm_postal_phone</td>
    <td>string</td>
    <td>The business phone number</td>
  </tr>
  <tr>
    <td>cghm_postal_fax</td>
    <td>string</td>
    <td>The business fax number</td>
  </tr>
  <tr>
    <td>cghm_lat</td>
    <td>float</td>
    <td>The latitude of the business location.</td>
  </tr>
  <tr>
    <td>cghm_twittercard</td>
    <td>string</td>
    <td>The default value for the twitter:card meta tag.<br/>
      see: <a href="https://dev.twitter.com/cards/overview">https://dev.twitter.com/cards/overview</a>
    </td>
  </tr>
  <tr>
    <td>cghm_twitterid</td>
    <td>string</td>
    <td>The website owner's twitter id.<br/>
      see: <a href="https://dev.twitter.com/cards/overview">https://dev.twitter.com/cards/overview</a>
    </td>
  </tr>
  <tr>
    <td>cghm_fbpageid</td>
    <td>string</td>
    <td>The unique facebook page id</td>
  </tr>
  <tr>
    <td>cghm_fbadmins</td>
    <td>string</td>
    <td></td>
  </tr>
  <tr>
    <td>cghm_fbappid</td>
    <td>string</td>
    <td>The unique facebook app id</td>
  </tr>
  <tr>
    <td>cghm_webappcapable</td>
    <td>bool</td>
    <td></td>
  </tr>
</table>
<p>It is also possible to specify default properties for attributes of meta fields using config variables.  The format is: <code>cghm_{attrname}_{fieldname}=string</code>.</p>
<p>i.e: <code>config['cghm_href_applie-touch-icon'] = '{root_url}/favicon_cms.ico'</code></pre>

<h3>Sample Usage from a Detail Template</h3>
<p>Typically you will want to adjust some meta tags from within the detail template of a module, to override the default values that are generated for the page alone.  Here you will see some sample code from a CGBlog detail template:</p>
<pre><code>{cghm_config_set key='title' val="{$entry->title} - {sitename}"}
{cghm_config_set key='canonical' val=$entry->canonical|default:''}
{cghm_config_set key='image' val="{$entry->file_location}/{$entry->fields.image->value}"}
{cghm_config_set key='description' val="{$entry->summary|strip_tags}"}</code></pre>
<p>On line 1 we override the title (for the title_tag, the meta title, the meta og:title, and the meta tweetmeme:title tags).<br/>
On the second line we override the canonical entry... if it is set, if it is not set, then the standard default value will be used.<br/>
The third line sets the image URL to be used for the og:image meta tag and any other meta tag that reads the <code>{$config.image}</code> variable in its template.
The final line overrides the description for use in the description, og:description and other meta tags.</p>
<p>Note: We could explicitly set the value for any one tag we want using the {cghm_set} smarty plugin.  i.e: <code>{cghm_set key='og:title' value="My Fancy Blog Article"}</code>.</p>

<h4>What about keywords</h4>
<p>there are numerous resources on the web that indicate that the keywords metatag no longer has any positivie influence on search engine ranking or performance.  In fact, even having the keywords meta tag present in your HTML output may have negative effects on your search engine ranking.  Therefore, this module by default does not do any keyword detection, or output a value for this meta field.</p>
<p>Though the module will understand the keywords field type in the config entries, and in the {cghm_set} tag,  we highly recommend that you do not undertake the effort to include keywords in your HTML output.</p>

<h3>Adding Known Fields</h3>
<p>It is possible to define more meta fields that this module knows about by creating another fields.ini file:</p>
<ol>
   <li>Create a new directory under your CMSMS root entitled:  module_custom/CGHeadMaster/config</li>
   <li>Create a new file in that directory called fields.ini and open it in a text editor.</li>
   <li>Create the new fields in ini file format and save the file.</li>
</ol>

<li>File format</li>
<ul>
  <li>The sections are <em>(by default)</em> the field names.</li>
  <li>Available keys and values within each section:
    <ul>
      <li>group - required -  Define the group name for the field.</li>
      <li>groups - optional - Define a comma separated list of group names for the field.  You must specify either group or groups.</li>
      <li>tag - optional - Define the tag name.  Default is meta</li>
      <li>keyattr - optional - Specify the primary key for this field (the attribute that will contain the field name).  Default is &quot;name&quot;</li>
      <li>keyval - optional - Specify the value for the primary key for this field, <em>(i.e.: override the field name)</em> useful if different from the section name.</li>
      <li>attr1..N - optional - Specify the attribute that will contain the value for this field. Default is &quot;content&quot;.  It is possible that a tag have multiple value attributes.</li>
      <li>dflt1..N - optional - Specify the default value (or the smarty template to generate the default value) for this field.</li>
      <li>noattrs - optional - Indicate that there are no attributes for this tag, and that the value will be enclosed within the tag contents.  This is used for tags like &lt;title&gt;.</li>
      <li>dflt - optional - Used only when the noattrs flag is set, this is the default value (or the smarty template to generate a value) for the interior of the tag.</li>
    </ul>
  </li>
</ul>

<h3>Smarty in default values</h3>
<p>Smarty is used to calculate default values for meta fields that have not had a value explicitly set.  When this happens you may use all known CMSMS and smarty plugins.  Also the current content object is provided to smarty as <code>$content_obj</code>   The config variables <em>(only the variables beginning with cghm_)</em> are provided under the <code>$config</code> smarty variable.</p>

<h3>Support</h3>
<p>The module author is in no way obligated to provide support for this code in any fashion.  However, there are a number of resources available to help you with it:</p>
<ul>
<li>A bug tracking and feature request system has been created for this module <a href="http://dev.cmsmadesimple.org/projects/cgheadmaster">here</a>.  Please be verbose and descriptive when submitting bug reports and feature requests, and for bug reports ensure that you have provided sufficient information to reliably reproduce the issue.</li>
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
