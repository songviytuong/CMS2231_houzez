<?php
$lang['error_bannerexists'] = 'Izen hori duen banerra dagoeneko eratua dago';
$lang['accessdenied'] = 'Sarrea debekatua. Begiratu permisoak.';
$lang['addbanner'] = 'Banerra gehitu';
$lang['addcategory'] = 'Kategoria gehitu';
$lang['areyousure'] = 'Ziur zaude?';
$lang['banners'] = 'Banerrak';
$lang['cancel'] = 'Ezeztatu';
$lang['categories'] = 'Kategoriak';
$lang['category'] = 'Kategoria';
$lang['created'] = 'Sortua';
$lang['date'] = 'Data';
$lang['delete'] = 'Ezabatu';
$lang['description'] = 'Azalpena';
$lang['edit'] = 'Editatu';
$lang['editcategory'] = 'Kategoria editatu';
$lang['error'] = 'Akatsa!';
$lang['error_banerexists'] = 'Izen hori duen banerra dagoeneko eratua dago';
$lang['error_categorynotempty'] = 'Akatsa: kategoria ez dago utsik.';
$lang['error_dberror'] = 'Akatsa! Datu base akatsa!';
$lang['error_emptybannername'] = 'Akatsa! Baner izena utsik!';
$lang['error_emptycategory'] = 'Akatsa! Kategoria utsik!';
$lang['error_insufficientparams'] = 'Akatsa! Ez dago behar bezain beste sarrerarik';
$lang['error_nocategories'] = 'Akatsa! Ez da kategoriarik aurkitu';
$lang['error_noresults'] = 'Ez dago banerrik bilaketa horretarako';
$lang['error_textorimage'] = 'Azaldu url eta irudia edo testua, ez biak';
$lang['expires'] = 'Bukaera data';
$lang['friendlyname'] = 'Banerrak erabili';
$lang['height'] = 'Altuera';
$lang['hits'] = 'Hits';
$lang['href_text'] = 'Link Text';
$lang['id'] = 'ID';
$lang['image'] = 'Irudia';
$lang['image_text'] = 'Alt irudi testua';
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
$lang['postinstall'] = 'Post Install Message, e.g., Be sure to set &quot;Manage Banners&quot; permissions to use this module!';
$lang['postuninstall'] = 'Banners module uninstalled, and all database tables removed.  Sorry to see you leave.&quot;';
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
$lang['welcome_text'] = '<p>Welcome to the Banner Management Module admin section. Something else would probably go here if the module actually did something.</p>';
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
</ul>';
$lang['help'] = '<h3>What Does This Do?</h3>
<p>This banner manages numerous categories of banners, tracks hits, impressions, and expiry dates, and randomly selects from all available and valid banners for one to display</p>
<h3>How Do I Use It</h3>
<p>To use this module, place the module code in a page or template using the smarty tag {cms_module module=&#039;Banners&#039; category=&quot;<category>&quot;}</p> 
<p>You must also upload banners to a suitable directory within the uploads directory and must use the admin panel interface to add banners to the database.</p
<h3>Parameters</h3>
<ul>
<li><em>(REQUIRED)</em> category=&quot;category&quot; = randomly select from all available in this category</li>
<li><em>(optional)</em> name=&quot;name&quot; = select only the banner with this name</li>
<li><em>(optional)</em> mode=&quot;sequential&quot; = Instead of randomly selecting a valid banner, select the one with the least impressions.</li>
</ul>
<h4>Hint</h4>
<p>The uploads module and the banners module work well together.  You can create a &quot;banners&quot; category in the uploads module, and upload your banner images there, then specify &quot;banners/<filename>&quot; when adding a banner in the banners module.</p>';
$lang['utmz'] = '156861353.1160562385.7.4.utmccn=(organic)|utmcsr=google|utmctr=cmsms banner add|utmcmd=organic';
$lang['utma'] = '156861353.598626517.1160380927.1160562385.1161013547.8';
?>