<h3>What does this do?</h3>
  <p>This module provides a way to collect, organize, and display information about products.  This module can stand on its own within CMSMS. Or, if you wish, be part of an ecommerce solution.  The module supports an item existing in more than one category, supports organizing products into hierarchies, supports SKU's, dimensions, item weight, price, and attributes such as size and color with different SKU and pricing options.  Each item option can have a price adjustment.  Each item can be set as taxable, or non taxable.</p>
  <p>This module provides multiple custom field definitions, and for the ability to discriminate private from public data.</p>

<h3>Features:</h3>
<ul>
  <li>Numerous Views</li>
    <ul>
      <li>Summary view</li>
      <li>Category List View</li>
      <li>Detail view</li>
      <li>Hierarchy Drill-down View</li>
      <li>Advanced search</li>
      <li>more...</li>
    </ul>
  <li>Entirely template driven
    <p>Numerous templates of each type can be defined, defaults specified for each type, and the template used for each particular view can be specified as a parameter</p>
  </li>
  <li>Sorting and pagination in the summary view</li>
  <li>Products can exist in multiple categories</li>
  <li>Numerous custom fields can be defined, including images</li>
  <li>Admin defined fields</li>
  <li>Product options (including price adjustment)</li>
  <li>Weight, dimensions and taxable fields (for use in e-commerce solutions)</li>
  <li>Products can have a status (published, disabled or draft) in order to hide products from public display at any time</li>
  <li>Strong pretty URL Support</li>
  <li>Acts as a product source and communicates with the Ecommerce suite by the same author.</li>
  <li><strong>More...</strong></li>
</ul>

<h3>How Do I Use It:</h3>
<ol>
<li>Set preferences
  <p>Usually this is just a formality.  You should specify your default weight units, and your default currency symbol for your local environment.</p>
  <p>If you are preparing an e-commerce solution then units are configured in the CGEcommerceBase module.</li>
</li>
<li>Setup users and permissions
  <p>The 'Modify Site Preferences' permission is needed to be able to adjust the modules preferences.  In order to have the ability to modify field definitions, categories, or products, your users will need the 'Modify Products' permission.</p>
</li>
<li>(optional) Define one or more categories
  <p>This is an optional step, but you will probably want to do this early to prevent having to go back to modify each and every product later.  Adding a category is as simple as clicking on the 'Categories' tab in the Product Managers admin section, and clicking 'Add A Category'.  From there you will be prompted for a category name.</p>
</li>
<li>(optional) Define a product hierarchy.
  <p>You can organize your products into a hierarchy.  The hierarchy is similar to categories except that each node in the hierarchy can have zero or more childrern.  A product can only belong to one place in the hierarchy.</p>
</li>
<li>(optional) Define one or more custom fields
  <p>This is an optional step for simple usage scenarios, but may be required when implementing an Ecommerce application.  Custom fields are not needed if this module suits you exactly as it is.  However if you would like to store additional information for each of your products you can create custom fields.  Creating custom fields is similar to creating categories, except that more data is requested.</p>
<p>Currently a number of types of custom fields are available, including: 'textbox','checkbox',and 'textarea', 'dropdown', and 'file'.  Select one of these, give your new field a name, and indicate wether that field should be visible to the public in the various views.  Then hit submit</p>
</li>
<li>Create one or more items.
<p>You should create one or more products to display in your website content.  Give each product a name, a price (optional) a weight (optional), a status (draft or published), and some information.  Additionally, you can also specify if the product is taxable.</p>
<p>If you are implementing an e-commerce solution then you should provide each product with a unique SKU. And depending upon your application requirements, weight and dimensions for each product.</p>
<p>You can create multiple attributes for a product to define variations on size, color, etc.  Each variation can have a different SKU.</p>
<p>If categories are defined, then a multiselect field will appear allowing you to select the categories for the item.</p>
<p>If custom fields are defined, then input fields appropriate to the type of custom field will appear and allow you to specify data for each of them.  This data is optional.</p>
</li>
<li>Add the appropriate tags into your page templates or page content</li>
<p>This can be as simple as adding the <code>{Products}</code> tag into the content area of one of your pages, or into your page template.</p>
<p>If you wish to alter the behaviour of this application from its default, you can do that by adding one or more parameters to the <code>{Products}</code> tag.  The complete list of parameters and their behaviour is listed below.  But for example, to display a list of items in a single, existing category, you could use a tag like <code>{Products category='categoryname'}</code></p>
</ol>

<h3>Pretty URLS</h3>
<p>If you have enabled pretty URLS in the CMSMS config file <em>(either mod_rewrite, or internal pretty URLS)</em> Then this module is capable of generating pretty URLS for various links to product views.  There is also the power to completely customize the URL to a product detail view.  There are a few settings in the module's admin panels to configure.</p>
<h4>URL Slugs:</h4>
<p>URL Slugs are portions of a URL that are appended to the root url (along with the URL prefix described below) to allow uniquely specifying a URL to an individual product.  URL Slugs (basically fixed string routes) must be unique across the entire website, and an error will be generated if the slug provided is already in use.</p>
<p>When a new product is created, or a product without a URL slug is edited, the system will automatically generate a URL slug based on the product name, the selected hierarchy level, the selected categories, and the slug template in the preferences panel.  You may also enter your own URL slug in the appropriate field of the form.</p>
<p>The system will never automtically adjust an existing URL slug, even if you move the product to a different level of the hierarchy, or change the slug template.  Adjusting a URL slug must involve an authorized administrator, and should be done with caution for SEO purposes.</p>

<h4>Options:</h4>
<ul>
  <li>Default Detail Page  <strong>*required*</strong>:
    <p>When using pretty URLS, and either a URL slug exists, or the &quot;Use Hierarchy Path&quot; preference <em>(described below) is enabled, a page id will not be specified on the URL.  For this purpose it is ncessary to tell the module which content page the detail view should be displayed on.</p>
  </li>

  <li>Prefix to use on all URLS targeted to this this module:
     <p>This preference is an optional string that will be prepended to each and every pretty URL generated by the products module.  This may be necessary to ensure uniqueness across the website, and for organizational purposes.</p>
  </li>

  <li>Use Hierarchy Path in Item Detail URLS:
    <p>This boolean preference indicates that when creating a detail URL to a product, and no URL slugs are present an attempt should be made to use the hierarchy path in the URL.</p>
    <p>This is problematic solution remaining only for backwards compatibility purposes, as if a product is ever moved to a different place in the hierarchy tree, or even if the spelling of one of the paths in the hierarchy path changes, the URL would change.  This is not a good solution for SEO purposes, and should not be used.</p>
  </li>

  <li>Default Detail Page:
     <p>When using pretty urls, and particularly when specifying aliases or URL slugs for products, it is required to tell the system what CMSMS content page to use to display that product.  If one is not specified, the default content page will be used.</p>
  </li>

  <li>Default Page for Hierarchy View:
     <p>When using pretty urls, and particularly when specifying aliases or URL slugs for products, it is required to tell the system what CMSMS content page to use to display a hierarchy view.</p>
  </li>
</ul>

<h3>SKU and Quantity Handling</h3>
<p>This module provides a unique field for each item <em>(and item option)</em>.  The SKU value can be used to uniquely identify an item or option.  When using this system as an e-commerce system each item and option is required to have a SKU.</p>
<h3>Product Options</h3>
<p>This module provides the capability of handling <em>(options)</em> to base items.  Options can be used for making different sizes, or colors of an item available in the cart.   Each option can have a description, a price <em>(or price adjustment)</em> and a SKU for e-commerce purposes.</p>

<h3>Smarty Plugins</h3>
<p>This module also registers one or more smarty plugins to aide in retrieving various products related information when designing products module templates:</p>
<ul>
  <li>{products_getcategory categoryid='99' [assign='tmp']}
  <p>This plugin allows retrieving all of the information for a specific category id and optionally assigning it to the named smarty variable.  The returned is an object containing all of the information about a category, including its field values.<br/>i.e:. <code>{products_getcategory categoryid=1 assign='tmp'}Category name = {\$tmp->name}</code></p>
  </li>
  <li>{products_gethierarchy id='99' [assign='tmp']}
  <p>This plugin allows retrieving all of the information for a specific hierarchy level and optionally assigning it to the named smarty variable.  The returned is an object containing all of the information about a hierarchy, including its field values.<br/>i.e:. <code>{products_gethierarchy id=1 assign='tmp'}name = {\$tmp.name}</code></p>
  </li>
  <li>{products_hierarchy_breadcrumb hierarchyid='99' [pageid=alias] [delim=' &raquo '][assign='tmp']}
  <p>This plugin allows retrieving the breadcrumb path to a particular hierarchy id and optionally assigning it to the named smarty variable.  This plugin will output zero or more links to hierarchy views with one link for each level in the hierarchy.  To specify a different delimiter use the "delim" argument.  If an empty delimiter is specified, then an array of links will be returned rather than one coninuous html segment.  To specify a different page id forthe links, use the pageid attribute.   If the pageid attribute is not specified, and the hierarchy id preference is set it will be used.  Otherwise the current page id will be used.</p>
  </li>
  <li>{products_hierarchy_parent hierarchyid=99 [assign='tmp']}
  <p>This plugin will return the parent hierarchy id for a given hierarchy id.  If the specified hierarchy id does not exist, then nothing will be returned.  if the specified hierarchy id does not have a parent this plugin will return -1.</p>
  </li>
</ul>
<h3>The <em>ajax_propval</em> Action</h3>
  <p>The <em>ajax_propval</em> is a special action that is used to return the distinct values of a custom field, or a property via json.  Typically this action is used to perform autocomplete actions, and usually in conjunction with the search action.  This action accepts the parameters: field for the name of the field, and fieldval for indicating a starting value.  None of the parameters can be empty.  Below you will find a simple example of using the ajax_propval action to perform autocomplete for item names in conjunction with the search template.</p>
<pre><code>&lt;script type="text/javascript"&gt;{literal}
$(document).ready(function(){
  var ajax_url = '{/literal}<span style="color: green;">{module_action_link module=Products action=ajax_propval urlonly=1 jsfriendly=1}</span>{literal}';
  ajax_url = ajax_url + <span style="color: red;">'&showtemplate=false'</span>;

  $(<span style="color: blue;">'#productname'</span>).autocomplete({
    source: function(req,add){
      var tmp =  ajax_url+<span style="color: red;">'&cntnt01field=::name::&cntnt01fieldval='</span>+req.term;
      $.getJSON(tmp,function(json){
        if( json.status == 'OK' && json.data.length > 0) {
          add(json.data);
        }
      })
    }
  });
});
{/literal}&lt;/script&gt;
</code></pre>
<p>As you can see from the above code snippet.. the {module_action_link} plugin from CGSimpleSmarty is used to generate a url that will trigger the ajax_propval action.  After that URL is retrieved, the showtemplate=false parameter is added to the URL.   When setting up the autocomplete plugin, the callback used to fill in the data values for the field uses ajax.  We take the ajax_url already prepared and add the field=::name:: and fieldval=req.term parameters to the URL.  The term is automatically provided by the autocomplete plugin in the req.term variiable.</p>
<p>To use this example, the user would need to ensure that jquery is loaded, along with the jquery ui (including autocomplete), and any required stylesheets.  This could be done either in the page specific metadata field when editing the page containing the search form, or in the page template itself.</p>
<h3>Importing from ASCII</h3>
<p>This module includes a flexible mechanism of importing and updating item information from ASCII files.  The system handles multi-line records with different line endings (Unix/MAC/DOS) and different field delimiters.  Categories, hierarchy information, and custom field information can be imported for each item.</p>
<p>The import system is capable of creating new items, or updating existing ones, creating unknown categories, hierarchies, or custom fields, and attaching images to uploaded files.</p>
<h4>Images</h4>
<p>Images can optionally be associated with imported records, but must be previously uploaded to a central location.  When a image field value specifies an image filename, and that file exists in the specified directory (relative to the uploads directory). it will be copied into the appropriate place for future display and management.</p>

<h3>Hooks</h3>
<ul>
   <li><code>Product::AfterInsertProduct</code>
      <p>Parameters:</p>
      <ol>
         <li>$product - object of type Product -- The product after insertion into the database.</li>
      </ol>
   </li>
   <li><code>Product::BeforeUpdatetProduct</code>
      <p>Parameters:</p>
      <ol>
         <li>$product - object of type Product -- The product object before updating the database.</li>
      </ol>
   </li>
   <li><code>Product::AfterUpdatetProduct</code>
      <p>Parameters:</p>
      <ol>
         <li>$product - object of type Product -- The product after updating the database the database.</li>
      </ol>
   </li>
   <li><code>Product::BeforeDeleteProduct</code>
      <p>Parameters:</p>
      <ol>
         <li>$product_id - integer -- The product after updating the database the database.</li>
      </ol>
   </li>
</ul>

<h3>Support</h3>
<p>The module author is in no way obligated to provide support for this code in any fashion.  However, there are a number of resources available to help you with it:</p>
<ul>
<li>A bug tracking and feature request system has been created for this module <a href="http://dev.cmsmadesimple.org/projects/products">here</a>.  Please be verbose and descriptive when submitting bug reports and feature requests, and for bug reports ensure that you have provided sufficient information to reliably reproduce the issue.</li>
<li>Additional discussion of this module may also be found in the <a href="http://forum.cmsmadesimple.org">CMS Made Simple Forums</a>.  When describing an issue please make an effort to provide all relavant information, a thorough description of your issue, and steps to reproduce it or your discussion may be ignored.</li>
<li>The author, calguy1000, can often be found in the <a href="irc://irc.freenode.net/#cms">CMS IRC Channel</a>.</li>
<li>Lastly, you may have some success emailing the author directly.  However, please use this as a last resort, and ensure that you have followed all applicable instructions on the forge, in the forums, etc.</li>
</ul>

<h3>Copyright and License</h3>
<p>Copyright &copy; 2017, Robert Campbell <a href="mailto:calguy1000@cmsmadesimple.org">&lt;calguy1000@cmsmadesimple.org&gt;</a>. All Rights Are Reserved.</p>
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
