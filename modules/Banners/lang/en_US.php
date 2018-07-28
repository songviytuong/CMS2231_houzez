<?php
$lang['help_param_docount'] = 'Applicable to the list view it indicates whether impression counting should be performed.';
$lang['help_param_listtemplate'] = 'Applicable to the list template this parameter allows specifying a non default template.  To use a file based template the value must end with .tpl.  Otherwise, a proper resource string must be supplied.  i.e:  cms_template:template_name (cms2.x) or globalcontent:template_name (cms1.x).';
$lang['total'] = 'Total';
$lang['last_impression'] = 'Last Impression';
$lang['error_categoryexists'] = 'A category by this name already exists';
$lang['error_namerequired'] = 'This object requires a name';
$lang['error_imagenotfound'] = 'Could not find the image file specified';
$lang['statreport_linesperpage']  = 'Lines per page on the statistics report';
$lang['banner'] = 'Banner Advertisement';
$lang['of'] = 'Of';
$lang['page'] = 'Page';
$lang['generated'] = 'Generated';
$lang['generated_by'] = 'Generated By';
$lang['desc_stats_report'] = 'Banner Impressions and Click throughs as of {$smarty.now|date_format:\'%x\'}';
$lang['title_stats_report'] = 'Banner Statistics Report';
$lang['view_statistics'] = 'View Statistics';
$lang['msg_new_window'] = 'Creates a new window';
$lang['statreport_template'] = 'Statistics Report Template';
$lang['your_ad_here'] = 'Your Advertisement could be here';
$lang['prompt_dflt_image'] = 'Default Image';
$lang['prompt_dflt_url'] = 'Default URL';
$lang['info_dflt_image'] = 'Specify an image name (relative to the uploads directory) of an image to use when no banners are valid to be displayed';
$lang['prompt_hidefrombots'] = 'Exclude robots from impression and click counting';
$lang['help_param_action'] = 'Specify the behaviour of the module.  Possible values are &quot;default&quot; and &quot;list&quot;.  The default action is used for displaying a single banner according to specified criterium.  The list action is used to display all of the banners of a specified category or category id';
$lang['help_param_category'] = 'In the default action, this parameter is used to specify the numeric id or name of the single category from which a single banner will be displayed.  In the list action this parameter is required to specify the numeric id or name of the single category from which all banners will be displayed';
$lang['help_param_mode'] = 'This parameter is only used in the default action, it specifies the way in which banners are selected from the specified category.  The only value is &quot;sequential&quot; which indicates that the module should choose the next non expired banner with the least amount of impressions.  Not specifying this parameter will result in a random banner being selected';
$lang['help_param_name'] = 'This parameter is only used in the default action.  It specifies an absolute name of a banner to load.  However, if the banner is invalid (the number of impressions has been reached, OR it has expired), nothing will be returned.';
$lang['bannerlist_template'] = 'Banner List Template';
$lang['info_bannerlist_template'] = 'Used with the list action, this template controls the dispay of all banners in the selected category';
$lang['none'] = 'None';
$lang['error_invalid_dates'] = 'Error Invalid Dates';
$lang['editbanner'] = 'Edit Banner';
$lang['start_date'] = 'Start Date';
$lang['atttext'] = 'at';
$lang['template'] = 'Template';
$lang['default_template'] = 'Default Category Template';
$lang['reset_template'] = 'Reset Template to Defaults';
$lang['error_banners'] = 'No banners';
$lang['error_bannerexists'] = 'Banner with that name already exists';
$lang['accessdenied'] = 'Access Denied. Please check your permissions.';
$lang['addbanner'] = 'Add Banner';
$lang['addcategory'] = 'Add Category';
$lang['areyousure'] = 'Are You Sure?';
$lang['banners'] = 'Banners';
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
$lang['expires'] = 'Expires';
$lang['friendlyname'] = 'Banners Manager';
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
$lang['postinstall'] = 'Banners module installed.  Only administrators with the "Manage Banners" permission will be able to utilize this module.';
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
?>