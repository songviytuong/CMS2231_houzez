<?php
$lang['403description'] = 'Page Forbidden';
$lang['adminpaneltitle'] = 'CMS Made Simple Admin Console';
$lang['aliasalreadyused'] = 'The supplied "Page Alias" is already in use on another page.  Change the "Page Alias" to something else.';
$lang['autoclearcache2'] = 'Dileu ffeiliau cache sy\'n hŷn na\'r nifer penodol o ddyddiau.';
$lang['cantchmodfiles'] = 'Couldn\'t change permissions on some files';
$lang['close'] = 'Cau';
$lang['config_information'] = 'Config Information';
$lang['contentimage_path'] = 'Llwybr ar gyfer {content_image} tag';
$lang['contenttype_redirlink'] = 'Ailgyfeirio Linc';
$lang['content_autocreate_flaturls'] = 'Mi fydd URL sy\'n cael eu creu yn awtomatig yn fflat';
$lang['content_autocreate_urls'] = 'Creu URL tudalen yn awtomatig';
$lang['content_imagefield_path'] = 'Llwybr ar gyfer maes Lluniau';
$lang['content_mandatory_urls'] = 'Mae URL Tudalen yn angenrheidiol';
$lang['content_thumbnailfield_path'] = 'Llwybr ar gyfer Thumbnail Lluniau';
$lang['date_format_string_help'] = '<em>strftime</em> formatted date format string.  Try googling \'strftime\'';
$lang['ecommerce'] = 'E-Fasnach';
$lang['ecommerce_desc'] = 'Modiwlau ar gyfer darparu galluoedd e-fasnach';
$lang['editcontent_settings'] = 'Gosodiadau Golygu Cynnwys';
$lang['enablesitedown'] = 'Enable Site Down Message';
$lang['enablewysiwyg'] = 'Enable WYSIWYG on Site Down Message';
$lang['error_delete_default_parent'] = 'You cannot delete the parent of the default page.';
$lang['error_nograntall_found'] = 'Could not find a suitable "GRANT ALL" permission.  This may mean you could have problems installing or removing modules.  Or even adding and deleting items, including pages';
$lang['error_no_default_content_block'] = 'No default content block was detected in this template.  Please ensure that you have a {content} tag in the page template.';
$lang['event_help_addglobalcontentpost'] = '<p>Sent after a new global content block is created.</p>
<h4>Parameters</h4>
<ul>
<li>\'global_content\' - Reference to the affected global content block object.</li>
</ul>';
$lang['event_help_addglobalcontentpre'] = '<p>Sent before a new global content block is created.</p>
<h4>Parameters</h4>
<ul>
<li>\'global_content\' - Reference to the affected global content block object.</li>
</ul>';
$lang['event_help_addgrouppost'] = '<p>Sent after a new group is created.</p>
<h4>Parameters</h4>
<ul>
<li>\'group\' - Reference to the affected group object.</li>
</ul>';
$lang['event_help_addgrouppre'] = '<p>Sent before a new group is created.</p>
<h4>Parameters</h4>
<ul>
<li>\'group\' - Reference to the affected group object.</li>
</ul>';
$lang['event_help_addstylesheetpost'] = '<p>Sent after a new stylesheet is created.</p>
<h4>Parameters</h4>
<ul>
<li>\'stylesheet\' - Reference to the affected stylesheet object.</li>
</ul>';
$lang['event_help_addstylesheetpre'] = '<p>Sent before a new stylesheet is created.</p>
<h4>Parameters</h4>
<ul>
<li>\'stylesheet\' - Reference to the affected stylesheet object.</li>
</ul>';
$lang['event_help_addtemplatepost'] = '<p>Sent after a new template is created.</p>
<h4>Parameters</h4>
<ul>
<li>\'template\' - Reference to the affected template object.</li>
</ul>';
$lang['event_help_addtemplatepre'] = '<p>Sent before a new template is created.</p>
<h4>Parameters</h4>
<ul>
<li>\'template\' - Reference to the affected template object.</li>
</ul>';
$lang['event_help_adduserpost'] = '<p>Sent after a new user is created.</p>
<h4>Parameters</h4>
<ul>
<li>\'user\' - Reference to the affected user object.</li>
</ul>';
$lang['event_help_adduserpre'] = '<p>Sent before a new user is created.</p>
<h4>Parameters</h4>
<ul>
<li>\'user\' - Reference to the affected user object.</li>
</ul>';
$lang['event_help_changegroupassignpost'] = '<p>Sent after group assignments are saved.</p>
<h4>Parameters></h4>
<ul>
<li>\'group\' - Reference to the affected group object.</li>
<li>\'users\' - Array of references to user objects now belonging to the affected group.</li>';
$lang['event_help_changegroupassignpre'] = '<p>Sent before group assignments are saved.</p>
<h4>Parameters></h4>
<ul>
<li>\'group\' - Reference to the group object.</li>
<li>\'users\' - Array of references to user objects belonging to the group.</li>';
$lang['event_help_contentdeletepost'] = '<p>Sent after content is deleted from the system.</p>
<h4>Parameters</h4>
<ul>
<li>\'content\' - Reference to the affected content object.</li>
</ul>';
$lang['event_help_contentdeletepre'] = '<p>Sent before content is deleted from the system.</p>
<h4>Parameters</h4>
<ul>
<li>\'content\' - Reference to the affected content object.</li>
</ul>';
$lang['event_help_contenteditpost'] = '<p>Sent after edits to content are saved.</p>
<h4>Parameters</h4>
<ul>
<li>\'content\' - Reference to the affected content object.</li>
</ul>';
$lang['event_help_contenteditpre'] = '<p>Sent before edits to content are saved.</p>
<h4>Parameters</h4>
<ul>
<li>\'global_content\' - Reference to the affected content object.</li>
</ul>';
$lang['event_help_contentpostcompile'] = '<p>Sent after content has been processed by smarty.</p>
<h4>Parameters</h4>
<ul>
<li>\'content\' - Reference to the affected content text.</li>
</ul>';
$lang['event_help_contentpostrender'] = '<p>Sent before the combined html is sent to the browser.</p>
<h4>Parameters</h4>
<ul>
<li>\'content\' - Reference to the html text.</li>
</ul>';
$lang['event_help_contentprecompile'] = '<p>Sent before content is sent to smarty for processing.</p>
<h4>Parameters</h4>
<ul>
<li>\'content\' - Reference to the affected content text.</li>
</ul>';
$lang['event_help_contentstylesheet'] = '<p>Sent before the sytlesheet is sent to the browser.</p>
<h4>Parameters</h4>
<ul>
<li>\'content\' - Reference to the affected stylesheet text.</li>
</ul>';
$lang['event_help_deleteglobalcontentpost'] = '<p>Sent after a global content block is deleted from the system.</p>
<h4>Parameters</h4>
<ul>
<li>\'global_content\' - Reference to the affected global content block object.</li>
</ul>';
$lang['event_help_deleteglobalcontentpre'] = '<p>Sent before a global content block is deleted from the system.</p>
<h4>Parameters</h4>
<ul>
<li>\'global_content\' - Reference to the affected global content block object.</li>
</ul>';
$lang['event_help_deletegrouppost'] = '<p>Sent after a group is deleted from the system.</p>
<h4>Parameters</h4>
<ul>
<li>\'group\' - Reference to the affected group object.</li>
</ul>';
$lang['event_help_deletegrouppre'] = '<p>Sent before a group is deleted from the system.</p>
<h4>Parameters</h4>
<ul>
<li>\'group\' - Reference to the affected group object.</li>
</ul>';
$lang['event_help_deletestylesheetpost'] = '<p>Sent after a stylesheet is deleted from the system.</p>
<h4>Parameters</h4>
<ul>
<li>\'stylesheet\' - Reference to the affected stylesheet object.</li>
</ul>';
$lang['event_help_deletestylesheetpre'] = '<p>Sent before a stylesheet is deleted from the system.</p>
<h4>Parameters</h4>
<ul>
<li>\'stylesheet\' - Reference to the affected stylesheet object.</li>
</ul>';
$lang['event_help_deletetemplatepost'] = '<p>Sent after a template is deleted from the system.</p>
<h4>Parameters</h4>
<ul>
<li>\'template\' - Reference to the affected template object.</li>
</ul>';
$lang['event_help_deletetemplatepre'] = '<p>Sent before a template is deleted from the system.</p>
<h4>Parameters</h4>
<ul>
<li>\'template\' - Reference to the affected template object.</li>
</ul>';
$lang['event_help_deleteuserpost'] = '<p>Sent after a user is deleted from the system.</p>
<h4>Parameters</h4>
<ul>
<li>\'user\' - Reference to the affected user object.</li>
</ul>';
$lang['event_help_deleteuserpre'] = '<p>Sent before a user is deleted from the system.</p>
<h4>Parameters</h4>
<ul>
<li>\'user\' - Reference to the affected user object.</li>
</ul>';
$lang['event_help_editglobalcontentpost'] = '<p>Sent after edits to a global content block are saved.</p>
<h4>Parameters</h4>
<ul>
<li>\'global_content\' - Reference to the affected global content block object.</li>
</ul>';
$lang['event_help_editglobalcontentpre'] = '<p>Sent before edits to a global content block are saved.</p>
<h4>Parameters</h4>
<ul>
<li>\'global_content\' - Reference to the affected global content block object.</li>
</ul>';
$lang['event_help_editgrouppost'] = '<p>Sent after edits to a group are saved.</p>
<h4>Parameters</h4>
<ul>
<li>\'group\' - Reference to the affected group object.</li>
</ul>';
$lang['event_help_editgrouppre'] = '<p>Sent before edits to a group are saved.</p>
<h4>Parameters</h4>
<ul>
<li>\'group\' - Reference to the affected group object.</li>
</ul>';
$lang['event_help_editstylesheetpost'] = '<p>Sent after edits to a stylesheet are saved.</p>
<h4>Parameters</h4>
<ul>
<li>\'stylesheet\' - Reference to the affected stylesheet object.</li>
</ul>';
$lang['event_help_editstylesheetpre'] = '<p>Sent before edits to a stylesheet are saved.</p>
<h4>Parameters</h4>
<ul>
<li>\'stylesheet\' - Reference to the affected stylesheet object.</li>
</ul>';
$lang['event_help_edittemplatepost'] = '<p>Sent after edits to a template are saved.</p>
<h4>Parameters</h4>
<ul>
<li>\'template\' - Reference to the affected template object.</li>
</ul>';
$lang['event_help_edittemplatepre'] = '<p>Sent before edits to a template are saved.</p>
<h4>Parameters</h4>
<ul>
<li>\'template\' - Reference to the affected template object.</li>
</ul>';
$lang['event_help_edituserpost'] = '<p>Sent after edits to a user are saved.</p>
<h4>Parameters</h4>
<ul>
<li>\'user\' - Reference to the affected user object.</li>
</ul>';
$lang['event_help_edituserpre'] = '<p>Sent before edits to a user are saved.</p>
<h4>Parameters</h4>
<ul>
<li>\'user\' - Reference to the affected user object.</li>
</ul>';
$lang['event_help_globalcontentpostcompile'] = '<p>Sent after a global content block has been processed by smarty.</p>
<h4>Parameters</h4>
<ul>
<li>\'global_content\' - Reference to the affected global content block text.</li>
</ul>';
$lang['event_help_globalcontentprecompile'] = '<p>Sent before a global content block is sent to smarty for processing.</p>
<h4>Parameters</h4>
<ul>
<li>\'global_content\' - Reference to the affected global content block text.</li>
</ul>';
$lang['event_help_loginpost'] = '<p>Sent after a user logs into the admin panel.</p>
<h4>Parameters</h4>
<ul>
<li>\'user\' - Reference to the affected user object.</li>
</ul>';
$lang['event_help_logoutpost'] = '<p>Sent after a user logs out of the admin panel.</p>
<h4>Parameters</h4>
<ul>
<li>\'user\' - Reference to the affected user object.</li>
</ul>';
$lang['event_help_smartypostcompile'] = '<p>Sent after any content destined for smarty has been processed.</p>
<h4>Parameters</h4>
<ul>
<li>\'content\' - Reference to the affected text.</li>
</ul>';
$lang['event_help_smartyprecompile'] = '<p>Sent before any content destined for smarty is sent to for processing.</p>
<h4>Parameters</h4>
<ul>
<li>\'content\' - Reference to the affected text.</li>
</ul>';
$lang['event_help_templatepostcompile'] = '<p>Sent after a template has been processed by smarty.</p>
<h4>Parameters</h4>
<ul>
<li>\'template\' - Reference to the affected template text.</li>
</ul>';
$lang['event_help_templateprecompile'] = '<p>Sent before a template is sent to smarty for processing.</p>
<h4>Parameters</h4>
<ul>
<li>\'template\' - Reference to the affected template text.</li>
</ul>';
$lang['helpaddtemplate'] = '<p>A template is what controls the look and feel of your site\'s content.</p><p>Create the layout here and also add your CSS in the Stylesheet section to control the look of your various elements.</p>';
$lang['help_systeminformation'] = 'The information displayed below is collected from a variety of locations, and summarized here so that you may be able to conveniently find some of the information required when trying to diagnose a problem or request help with your CMS Made Simple installation.';
$lang['hide_help_links'] = 'Hide module help link';
$lang['hide_help_links_help'] = 'Check this box to disable the module help link in page headers.';
$lang['info_edituser_password'] = 'Change this field to change the user\'s password';
$lang['info_edituser_passwordagain'] = 'Change this field to change the user\'s password';
$lang['info_sitedownexcludes'] = 'This parameter allows listing a comma separated list of ip addresses or networks that should not be subject to the sitedown mechanism.  This allows administrators to work on a site whilst anonymous visitors receive a sitedown message.<br/><br/>Addresses can be specified in the following formats:<br/>
1. xxx.xxx.xxx.xxx -- (exact IP address)<br/>
2. xxx.xxx.xxx.[yyy-zzz] -- (IP address range)<br/>
3. xxx.xxx.xxx.xxx/nn -- (nnn = number of bits, cisco style.  i.e:  192.168.0.100/24 = entire 192.168.0 class C subnet)';
$lang['info_target'] = 'Gall dewis hwn a ddefnyddir gan y Rheolwr Ddewislen i ddangos pryd a sut y dylid fframiau ffenestri newydd neu gael ei hagor. Mae rhai rheolwr menu templedi anwybyddu\'r gall yr opsiwn hwn.';
$lang['logintitle'] = 'Login to CMS Made Simple';
$lang['login_info_params'] = '<ol> 
  <li>Cookies must be enabled in your browser</li> 
  <li>Javascript must be enabled in your browser</li> 
  <li>Popup windows must be allowed for the following address:</li> 
</ol>';
$lang['lostpwemail'] = 'You are recieving this e-mail because a request has been made to change the (%s) password associated with this user account (%s).  If you would like to reset the password for this account simply click on the link below or paste it into the url field on your favorite browser:
%s

If you feel this is incorrect or made in error, simply ignore the email and nothing will change.';
$lang['moduledescription'] = 'Modules extend CMS Made Simple to provide all kinds of custom functionality.';
$lang['moduleupgraded'] = 'Upgrade Successfull';
$lang['needpermissionto'] = 'You need the \'%s\' permission to perform that function.';
$lang['new_version_available'] = '<em>Notice:</em> A new version of CMS Made Simple is available.  Please notify your administrator.';
$lang['no'] = 'Na';
$lang['none'] = 'none';
$lang['nopasswordforrecovery'] = 'No email address set for this user.  Password recovery is not possible.  Please contact your administrator.';
$lang['output'] = 'Allbwn';
$lang['page_url'] = 'URL y Tudalen';
$lang['prefsupdated'] = 'Preferences have been updated.';
$lang['revert'] = 'Dychwelyd holl newidiadau';
$lang['run'] = 'Rhedwch';
$lang['runuserplugin'] = 'Rhedwch Ategyn Defnyddiwr';
$lang['run_udt'] = 'Rhedwch y User Defined Tag yma';
$lang['showbookmarks'] = 'Show Admin Shortcuts';
$lang['sitedownexcludeadmins'] = 'Eithriwch defnyddwyr wedi mewngofnodi i\'r ardal rheoli o fewn CMSMS';
$lang['sitedownexcludes'] = 'Exclude these Addresses from Sitedown Messages';
$lang['sitedownwarning'] = '<strong>Warning:</strong> Your site is currently showing a "Site Down for Maintenance" message. Remove the %s file to resolve this.';
$lang['sitedown_settings'] = 'Sitedown Settings';
$lang['use_wysiwyg'] = 'Defnyddiwch WYSIWYG';
$lang['warning_safe_mode'] = '<strong><em>WARNING:</em></strong> PHP Safe mode is enabled.  This will cause difficulty with files uploaded via the web browser interface, including images, theme and module XML packages.  You are advised to contact your site administrator to see about disabling safe mode.';
$lang['yes'] = 'Ie';
$lang['your_ipaddress'] = 'Eidh cyfeiriad IP';
$lang['help_page_alias'] = 'Mae\'r alias cael ei ddefnyddio fel ail i\'r dudalen id i adnabod unigryw dudalen. Rhaid iddo fod yn unigryw ar draws pob tudalen. Mae\'r alias cael ei ddefnyddio hefyd i helpu i adeiladu URL ar gyfer y dudalen';
$lang['help_page_cachable'] = 'Gellir gynyddu perfformiad drwy osod cyn gymain o tudalennau â phosibl i cachable. Fodd bynnag, ni all hyn gael ei ddefnyddio ar gyfer tudalennau lle gall gynnwys newid ar sail fesul gais';
$lang['help_page_searchable'] = 'Mae\'r gosodiad hwn yn nodi a ddylid cynnwys y dudalen hon yn cael ei fynegeio gan y modiwl Chwilio';
$lang['help_page_url'] = 'Penodwch URL arall (o\'i gymharu â gwraidd eich gwefan) y gellir eu defnyddio i adnabod y dudalen hon yn unigryw. h.y: llwybr / i / tutadlenhon. Mae\'r URL y dudalen ond yn defnyddiol pan mae URLS bert yn cael eu galluogi.';
$lang['deletetemplate'] = 'Delete Templates';
?>