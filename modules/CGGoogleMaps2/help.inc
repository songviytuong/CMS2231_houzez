<h3>What does this do</h3>
  <p>This module provides a quick, convenient, yet flexible and extendable way to place google maps on a page providing a number of built in functions, and providing easy extendability for those familiar with Javascript, JQuery and the Google Maps V3 API</p>
  <p><strong>Note:</strong> This module is not designed to be a plug and play module.  You will probably need to customize the map template, and other templates associated with a map to fit the style of your site, and to ensure that the map container has a default size.</p>
<h3>Features:</h3>
<ul>
  <li>Map creation using a full admin interface for managing maps and markers within a map.</li>
  <li>Flexible marker icon management.</li>
  <li>Infowindow content can be specified using HTML</li>
  <li>Streetview support</li>
  <li>Directions support with the ability to display the route on the map.</li>
  <li>Reads sensor information from GPS sensors on mobile devices.</li>
  <li>The ability to group markers that are within a lat/long radius to a single marker with a special icon.</li>
  <li>The ability to dynamically add markers given data from an outside point <em>(see {cggm2_add_dynpoint})</em>
  <li>Uses jquery for advanced DOM manipulation.</li>
  <li>Allows for custom styling of the infowindow, and directions form.</li>
  <li>Provides a simple, and extendable jQuery UI widget plugin to manipulate the map.</li>
  <li>Provides numerous callbacks and events to add your own javascript.</li>
</ul>

<h3>How Do I Use It?</h3>
<ul>
<li>Install the module via the normal methods</li>
<li>Setup your users and groups with the appropriate permissions:
  <ul>
    <li>The 'Manage Maps' Permission allows administrators to add/edit and delete maps</li>
    <li>The 'Manage Map Locations' permission allows administrators to add/edit/delete points within a map</li>
  </ul>
  <p><strong>Note:</strong> These are the same permissions that the originalCGGoogleMaps module used.</p>
</li>
<li>Create a map.  Give the map a name, and adjust the paramters of the particular map to meet your liking.  Note that when resetting one of the map templates to defaults, you must still press the &quot;Apply&quot; or &quot;Submit&quot; buttons.</p>
<li>Mark one of your maps as default, by clicking on the red 'X' beside a particular map.  This is useful if you do not specify the 'map' parameter on the tag.</li>
  <li><em>(optional)</em> Create one or more points within the map, either by specifying a latitude and longitude, or with an address.  There is a button in the edit map form, or an icon on each row of the map list to allow creating static markers for a map</li>
  <li>Adjust either your CSS, or the map and <em>(optionally) directions and other templates</li> to provide styles.   The CGGoogleMaps2 module comes with some sample styles, but only for demonstration purposes.</li>
  <li>In the page, or page template that will be utilizing the map be sure to enable jQuery, and the jQuery UI.  One convenient way to do this is with the {cms_jquery} plugin provided with CMSMS.</li>
  <li>Add the {CGGoogleMaps2} tag inside the content block of a page, or inside a page template.</li>
</ul>
<br/>
<h3>Adding Points to a Map Dynamically</h3>
<p>You can use smarty to add points to a module dynamically.  You can use this functionality to build a frappr like map with multiple points that are controlled dynamically from another module (like CompanyDirectory or FrontEndUsers).</p>
<h4>The {cggm2_add_dynpoint} Smarty Plugin</h4>
<p>This smarty plugin <em>(only available when CGGoogleMaps2 is installed)</em> allows adding a point dynamically to a specified map.  Dynamic points must be added before the map is created.</p>
<h5>Usage:</h5>
<pre><code>{cggm2_add_dynpoint map=1 name='New York' address='New York, NY' icon='food'}</code></pre><br/>
<h5>Parameters:</h5>
  <ul>
<li><strong>required</strong> - map : The ineger ID, or string name of the map to add the point to</li>
<li><strong>required</strong> - name : The name of the point to add</li>
<li><em>optional</em> - keys : A comma separated list of keys for storing the point.  Multiiple keys can be specified and the point will be stored under each key.  This is useful in conjunction with the &quot;key&quot; parameter of the CGGoogleMaps module to indicate which points to display in a particular map.</li>
<li><em>optional</em> - desc/description : The HTML content to show in the info window</li>
<li><em>optional</em> - address : The address of the location you are adding. (you must specify an address, or lat and long parameters)</li>
<li><em>optional</em> - lat/latitude : The latitude of the location you are adding.</li>
<li><em>optional</em> - long/longitude : The longitude of the location you are adding.</li>
<li><em>optional</em> - tooltip : A tooltip to display when hovering over a point.</li>
<li><em>optional</em> - icon : The name of an icon to use for this point.</li>
  </ul>
<br/>
<p><strong>Note:</strong> Either the lat and long parameters must be specified, or the address.</p>
<p><strong>Note:</strong> This plugin returns no direct output, and if errors occur, it will silently fail.  Success means that the point will show up on your google map.</p>
</ul>
<h4>The {cggm2_set_var} smarty plugin.</h4>
<p>This smarty plugin <em>(only available when CGGoogleMaps is installed)</em> Allows controlling aspects of the map behavior from within a smarty template.</p>
<h5>Usage:</h5>
<pre><code>{cggm2_set_var key=value ...}</code></pre>
<h5>Parameters:</h5>
<ul>
  <li>map : The integer id, or string name of the map that we will be controlling.  If not specified the default map is assumed.</li>
  <li>zoom_encompass : Integer (either 0 or 1) indicating wether zoom_encompass should be enabled for the map.</li>
  <li>description : Text description for the map.</li>
  <li>default_icon : The name of the icon to be used as the &quot;default&quot;</li>
  <li>type : String.  Possible values are map,satellite,terraint,hybrid.</li>
  <li>nav_controls : boolean, indicating wether navigation controls should be displayed.</li>
  <li>scale_controls : boolean, indicating wether scale controls should be displayed.</li>
  <li>sv_coontrols : boolean, indicating wether streetview controls should be displayed.</li>
  <li>type_controls : string, possible values are: default,dropdown,small,horizontal_bar.</li>
  <li>zoom : integer - zoom level between 1 and 17</li>
  <li>sensor : boolean - indicating wether the gps sensor should be used.</li>
  <li>center_lat : Center latitude for the map (ignored if zoom_encompass is on).</li>
  <li>center_lon : Center longitudde for the map (ignored if zoom_encompass is on).</li>
</ul>
<h4>The {cggm2_add_kml} smarty plugin.<h4>
<p>This smarty plugin <em>(only available when CGGoogleMaps is installed)</em> allows adding a kml file dynamically to a specified map.</p>
<h5>Usage:</h5>
<pre><code>{cggm2_add_kml map=1 href="http://path/to/kmlfile.kml"></code></pre>
<h5>Parameters:</h5>
<ul>
  <li><strong>required</strong> - map : The integer ID, or string name of the map to add the point to</li>
  <li><strong>required</strong> - href : The complete url to the kml file.  This kml file must be addressable by google over the internet.</li>
</ul>

<h3>KML File Support:</h3>
<p>Rudimentary support for kml files is provided via the {cggm2_add_kml} plugin.  However this plugin is not intelligent.  It will not consider the latitude and longitude of locations in the kml file(s) when considering the zoom range for zoom_encompass, etc.</p>

<h3>Entities and Quotes</h3>
<p>To avoid javascript errors the following processing occurs on markers for display:</p>
<ul>
  <li>The marker &quot;name&quot; is munged to url safe characters, - is changed to _ and duplicate _ characters are removed.</li>
  <li>The marker title and tootip contents are converted to HTML entities.</li>
  <li>Due to the fact that the info window may contain html content, it is not converted to html entities.  However, quotes are escaped.</li>
</ul>

<h3>Differences between CGGoogleMaps and CGGoogleMaps2</h3>
<p>There are a few important differences between the two modules that you should take note of:</p>
<ul>
  <li>Width and Height Inputs removed
    <p>For the most part, styling is now done with the various templates, and in your CMSMS stylesheets.  For that reason, the width and height, and any other styling related input fields have been removed from the map form.</p>
  <li>Categories Removed
    <p>Categories were a seldom used feature that are different for each implementation.  The CGGoogleMaps2 removes the inflexible category mechanism in exchange for providing flexibility in the jquery plugin provided.</p>
  </li>
  <li>Sidebar Removed
    <p>The sidebar a seldom used feature that are different for each implementation.  The CGGoogleMaps2 removes the inflexible sidebar mechanism in exchange for providing flexibility in the jquery plugin provided.</p>
    <p>Users developing applications centered around a map can modify the map template of their map to quite easily add a sidebar.</li>
  </li>
  <li>Numerous Templates Removed.
    <p>Most of the templates that users never modified in CGGoogleMaps were removed.  The javascript template was merged into the map template, and because of the provided jquery plugin the code is much simpler.</p>
  </li>
  <li>Updates for the revised GoogleMaps API.
    <p>The google maps api continues to evolve.  The GoogleMaps2 module takes advantage of the latest version of the API as of this writing.</li>
  </li>
  <li>Allows for ajax based map generation.
    <p>This module makes it easy for anyone with javascript and CMSMS experience to build an ajax based map (where the markers are retrieved via ajax).  Simply bind to the &quot;cggm2idle&quot; event.  or set the &quot;idle_cb&quot; option into the object to a function.</li>
  </li>
</ul>

<h3>The CGGM2 jquery ui plugin:</h3>
<p>Extensive documentation for this jquery plugin can be found <a href="../modules/CGGoogleMaps2/docs/cggm2%20Jquery%20plugin.html">here</a> <em>(link will not work when viewing this help from CMSMS ModuleManager)</em></p>

<h3>Support</h3>
<p>This module does not include commercial support. However, there are a number of resources available to help you with it:</p>
<ul>
<li>For the latest version of this module, FAQs, or to file a Bug Report or buy commercial support, please visit calguy\'s
module homepage at <a href="http://calguy1000.com">calguy1000.com</a>.</li>
<li>Additional discussion of this module may also be found in the <a href="http://forum.cmsmadesimple.org">CMS Made Simple Forums</a>.</li>
<li>The author, calguy1000, can often be found in the <a href="irc://irc.freenode.net/#cms">CMS IRC Channel</a>.</li>
<li>Lastly, you may have some success emailing the author directly.</li>
</ul>
<h3>Requirements</h3>
<p>This map functionality makes extensive use of <strong>jQuery</strong> and the <strong>jQuery UI library</strong> it is your responsibility to include jQuery and the jquery UI in pages that use these maps and ensure that it is loaded before the map is called.</p>
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