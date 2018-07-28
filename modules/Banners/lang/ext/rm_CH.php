<?php
$lang['error_banners'] = 'No banners';
$lang['error_bannerexists'] = 'Banner with that name already exists';
$lang['accessdenied'] = 'Access Denied. Please check your permissions.';
$lang['addbanner'] = 'Add Banner';
$lang['addcategory'] = 'Add Category';
$lang['areyousure'] = 'Are You Sure?';
$lang['banners'] = 'Banners ';
$lang['cancel'] = 'Cancel';
$lang['categories'] = 'Categories';
$lang['category'] = 'Category';
$lang['created'] = 'Created';
$lang['date'] = 'Date';
$lang['delete'] = 'Delete';
$lang['description'] = 'Description';
$lang['edit'] = 'Edit';
$lang['editcategory'] = 'Edit Category';
$lang['error'] = 'Error!';
$lang['error_banerexists'] = 'Banner with that name already exists';
$lang['error_categorynotempty'] = 'Error: Category Not Empty!';
$lang['error_dberror'] = 'Error: Database Error!';
$lang['error_emptybannername'] = 'Error: Empty banner name!';
$lang['error_emptycategory'] = 'Error: Empty Category!';
$lang['error_insufficientparams'] = 'Error: Insufficient Input';
$lang['error_nocategories'] = 'Error: No categories found';
$lang['error_noresults'] = 'No banners matched the query';
$lang['error_textorimage'] = 'Specify URL and IMAGE or TEXT, not both';
$lang['expires'] = 'Expires';
$lang['friendlyname'] = 'Manage Banners';
$lang['height'] = 'Height';
$lang['hits'] = 'Hits';
$lang['href_text'] = 'Link Text';
$lang['id'] = 'ID';
$lang['image'] = 'Image';
$lang['image_text'] = 'Alt Image Text';
$lang['impressions'] = 'Impressions';
$lang['info_href_text'] = 'Additional text for the link tag.  This text is placed in the link tag verbatim';
$lang['info_image'] = 'Specify a file relative to your uploads directory';
$lang['info_image_text'] = 'Additional text for the image tag';
$lang['info_max_hits'] = 'Use 0 for unlimited hits';
$lang['info_max_impressions'] = 'Use 0 for unlimited impressions';
$lang['installed'] = 'Module version %s installed.';
$lang['ipaddress'] = 'IP Address';
$lang['max_hits'] = 'Maximum Hits';
$lang['max_impressions'] = 'Maximum Impressions';
$lang['name'] = 'Name';
$lang['never'] = 'Never';
$lang['postinstall'] = 'Post Install Message, e.g., Be sure to set "Manage Banners" permissions to use this module!';
$lang['postuninstall'] = 'Banners module uninstalled, and all database tables removed.  Sorry to see you leave."';
$lang['preferences'] = 'Preferences';
$lang['prefsupdated'] = 'Module preferences updated.';
$lang['prompt_categorydesc'] = 'Category Description';
$lang['prompt_categoryname'] = 'Category Name';
$lang['prompt_imageheight'] = 'Image Height';
$lang['prompt_imagewidth'] = 'Image Width';
$lang['prompt_subnet_exclusions'] = 'Exclude these subnets from any statistics gathering';
$lang['prompt_upload_category'] = 'Category (Uploads Module)';
$lang['prompt_upload_file'] = 'Image (Uploads Module)';
$lang['selectcategory'] = 'Select Category';
$lang['submit'] = 'Submit';
$lang['text'] = 'Text';
$lang['title_mod_admin'] = 'Module Admin Panel';
$lang['title_mod_prefs'] = 'Module Preferences';
$lang['uninstalled'] = 'Module Uninstalled.';
$lang['upgraded'] = 'Module upgraded to version %s.';
$lang['url'] = 'URL';
$lang['width'] = 'Width';
$lang['title_admin_panel'] = 'Banners Module';
$lang['moddescription'] = 'A module to manage rotating banners';
$lang['welcome_text'] = '<p>Welcome to the Banner Management Module admin section.</p>';
$lang['changelog'] = '<ul>
<li>Version 1.0. 6 August 2005. Initial Release.</li>
<li>Version 2.0. September 2005. Initial Release for 0.1..</li>
<li>Version 2.0.1. September 2005. Display sample banner in the edit banner page, added name= parameter, and made subnet exclusions work.  Also changed the definition of the database to allow for additional text in the link and image tags.</li>
<li>Version 2.0.2. September 2005. Added integration with the uploads module (1.0.6) so that we can get lits of files for banners, etc.  The banners module is still optional though.</li>
<li>Version 2.0.3. September 2005. Fixed a very minor issue with never expires..</li>
<li>Version 2.0.4. September 2005. Fixed a very minor issue with module dependencies, and a big bug in the database spec if you did a scratch install.</li>
<li>Version 2.0.5. October 2005. Add coments around the output</li>
<li>Version 2.0.6. December 2005. Minor validation fixes, description is now output between the <img>and</img> tags, and an alt attribute is in the img tag.</li>
<li>Version 2.0.7. January 2006. More validation fixes, Moved the admin tabs around, fixed an issue where you could almost create a banner without defining a category, and... fixed the expiry date issue for good (hopefully).</li>
<li>Version 2.1.0. August 2006. Prepared for 1.0 compatibility, split into multiple files, used references where possible, improved messages, and a general cleanup.</li>
<li>Version 2.2. March 2008. 
    <p>The first release in a long while this fixes issues with the date fields, and the expiry date.  Also integrates changes so that the active tab is maintaned (DeeEye) and changes the license.</p>
    <p>Now require CMS 1.2.3 or greater</p>
</li>
<li>Version 2.2.1. April 2008.
    <p>Minor fixes.</p>
</li>
</ul>';
$lang['help'] = '<h3>What Does This Do?</h3>
<p>This banner manages numerous categories of banners, tracks hits, impressions, and expiry dates, and randomly selects from all available and valid banners for one to display</p>
<h3>How Do I Use It</h3>
<p>To use this module, place the module code in a page or template using the smarty tag {Banners category="categoryname"}</p> 
<p>You must also upload banners to a suitable directory within the uploads directory and must use the admin panel interface to add banners to the database.</p
<h3>Parameters</h3>
<ul>
<li><em>(REQUIRED)</em> category="category" = randomly select from all available in this category</li>
<li><em>(optional)</em> name="name" = select only the banner with this name</li>
<li><em>(optional)</em> mode="sequential" = Instead of randomly selecting a valid banner, select the one with the least impressions.</li>
</ul>
<h4>Hint</h4>
<p>The uploads module and the banners module work well together.  You can create a "banners" category in the uploads module, and upload your banner images there, then specify "banners/<filename>" when adding a banner in the banners module.</p>
<h3>Support</h3>
<p>This module does not include commercial support. However, there are a number of resources available to help you with it:</p>
<ul>
<li>For the latest version of this module, FAQs, or to file a Bug Report or buy commercial support, please visit calguy\'s
module homepage at <a href="http://techcom.dyndns.org">techcom.dyndns.org</a>.</li>
<li>Additional discussion of this module may also be found in the <a href="http://forum.cmsmadesimple.org">CMS Made Simple Forums</a>.</li>
<li>The author, calguy1000, can often be found in the <a href="irc://irc.freenode.net/#cms">CMS IRC Channel</a>.</li>
<li>Lastly, you may have some success emailing the author directly.</li>  
</ul>
<h3>Copyright and License</h3>
<p>Copyright © 2008, Robert Campbel <a href="mailto:calguy1000@cmsmadesimple.org"><calguy1000@cmsmadesimple.org></a>. All Rights Are Reserved.</p>
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
$lang['utmz'] = '156861353.1218831136.353.14.utmcsr=forum.cmsmadesimple.org|utmccn=(referral)|utmcmd=referral|utmcct=/index.php/topic,24797.new.html';
$lang['utma'] = '156861353.179052623084110100.1210423577.1218974879.1218981523.362';
$lang['utmc'] = '156861353';
$lang['utmb'] = '156861353.4.10.1218981523';
?>