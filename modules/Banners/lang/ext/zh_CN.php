<?php
$lang['accessdenied'] = '拒绝进入. 请检查权限';
$lang['addbanner'] = '新增标志';
$lang['addcategory'] = '新增类别';
$lang['areyousure'] = '确定?';
$lang['banners'] = '标志';
$lang['cancel'] = '取消';
$lang['categories'] = '类别';
$lang['category'] = '类别';
$lang['created'] = '创建';
$lang['date'] = '日期';
$lang['delete'] = '取消';
$lang['description'] = '描述';
$lang['edit'] = '编辑';
$lang['editcategory'] = '编辑类别';
$lang['error'] = '出错!';
$lang['error_banerexists'] = 'Banner with that name already exists';
$lang['error_categorynotempty'] = 'Error: Category Not Empty!';
$lang['error_dberror'] = 'Error: Database Error!';
$lang['error_emptybannername'] = 'Error: Empty banner name!';
$lang['error_emptycategory'] = 'Error: Empty Category!';
$lang['error_insufficientparams'] = 'Error: Insufficient Input';
$lang['error_noresults'] = 'No banners matched the query';
$lang['error_textorimage'] = 'Specify URL and IMAGE or TEXT, not both';
$lang['expires'] = 'Expires';
$lang['friendlyname'] = 'Manage Banners';
$lang['height'] = 'Height';
$lang['hits'] = 'Hits';
$lang['href_text'] = 'Link Text';
$lang['id'] = 'ID';
$lang['image'] = 'Image';
$lang['image_text'] = 'Image Text';
$lang['impressions'] = 'Impressions';
$lang['info_href_text'] = 'Additional text for the link tag';
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
$lang['postuninstall'] = 'Post Uninstall Message, e.g., "Curses! Foiled Again!"';
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
</ul>';
$lang['help'] = '<h3>What Does This Do?</h3>
<p>This banner manages numerous categories of banners, tracks hits, impressions, and expiry dates, and randomly selects from all available and valid banners for one to display</p>
<h3>How Do I Use It</h3>
<p>To use this module, place the module code in a page or template using the smarty tag &#123;cms_module module=\'Banners\' category="<category>"}</p> 
<p>You must also upload banners to a suitable directory within the uploads directory and must use the admin panel interface to add banners to the database.</p
<h3>Parameters</h3>
<ul>
<li><em>(REQUIRED)</em> category="category" = randomly select from all available in this category</li>
<li><em>(optional)</em> name="name" = select only the banner with this name</li>
</ul>
<h4>Hint</h4>
<p>The uploads module and the banners module work well together.  You can create a "banners" category in the uploads module, and upload your banner images there, then specify "banners/<filename>" when adding a banner in the banners module.</p>';
?>