<div id="page_tabs">
    <div id="general">General</div>
	<div id="start">Getting started</div>
	<div id="permissions">Permissions</div>
	<div id="examples">Examples</div>
	<div id="troubleshooting">Troubleshooting</div>
    <div id="copyright">Copyright and License</div>
</div>

<div class="clearb"></div>

<div id="page_content">
	<div id="general_c">
		<p>This module extends the Global Settings with some customized parameters.<br />
		You can define an unlimited number of fields which can be used as smarty-variable in templates or pages.</p>
		<br />
		<p>Available are:</p>
		<ul>
		<li>Button</li>
		<li>Checkbox</li>
		<li>Colorpicker</li>
		<li>Datepicker</li>
		<li>Date and timepicker</li>
		<li>GBFilePicker <i>(module GBFilePicker needs to be installed)</i></li>
		<li>JMFilePicker <i>(module JMFilePicker needs to be installed)</i></li>
		<li>Page selector</li>
		<li>Pulldown</li>
		<li>Radiobuttongroup</li>
		<li>Textarea</li>
		<li>Textarea with WYSIWYG</li>
		<li>Textfield</li>
		<li>Timepicker</li>
		</ul>
		<br />
		<p>Additional there is a special fielddefinition "Fieldgroup start". With this option you can create a collapsible group of fields.<br />
		After creating the "Fieldgroup start", also a "Fieldgroup end" with the same name will be added automatically. Drag &amp; drop fields between start and end to put them in the group.</p>
		<br />
	</div>

	<div id="start_c">
		<p>Go to the Custom Global Settings module admin (by default under menu 'Extensions') and define fields in the tab 'Field Definitions'.</p>
		<p>In the templates or pages of your website you will now automatically have those smarty variables available.</p>
		<br />
		<p>The exact way to call each variable is shown in the 'Field Definitions' tab.<br />You can also check which variables and values are available by placing <b>{CustomGS showvars=1}</b> in the content field of a page.</p>
		<br />
		<p><b>Note:</b> in previous versions of this module, you needed to put the tag {CustomGS} in your template(s). This is not needed anymore. When you upgrade from a version prior to 2.2, you should delete the {CustomGS} tag from your templates, although it won't do any harm if you leave it there.</p>
		<br />
		<h4>Organizing fields</h4>
		<p>When you have many fielddefinitions, you can organize them by creating custom tabs.</p>
		<p>Fields can be assigned to one or more tabs, while editing the fielddefinition. A more easy way is to select a tab in the dropdown at the top of the fielddefinitionslist and then toggle the V-marks. Changes are immediately saved.<br />The tab-dropdown will only be available at the top of the fielddefinitionslist when there are more than one custom tabs you have permissions on.</p>
		<br />
		<p>The sortorder of fielddefinitions and custom tabs can be changed by dragging &amp; dropping the rows in their list. The new sortorder will be saved immediately on drop.</p>
		<br />
	</div>

	<div id="permissions_c">
		<p>This module provides three different levels of permissions: on a module level, on a tab level and on a field level.</p>
		<h4>Module level</h4>
		<p>For setting module permissions, go to menu <i>Users & Groups » Group Permissions</i>:</p>
		<ul>
		<li><b>Custom Global Settings - Use</b><br />
		A permission for editors. It will only show the (custom) tabs for changing fieldvalues in the module admin page.</li>
		<li><b>Custom Global Settings - Manage</b><br />
		A permission for administrators. It will show extra tabs for creating/editing fielddefinitions, tabs and options.</li>
		</ul>
		<h4>Tab level</h4>
		<p>When creating or editing a custom tab, select one or more groups in the <b>Group Permissions</b> dropdown list (with ctrl). Only users who belong to the selected groups will be able to see the tab in the module admin. If no group is selected, the tab will be visible for all groups. <br />Tabs will never be hidden for admin users.</p>
		<h4>Field level</h4>
		<p>When creating or editing a fielddefinition, select one or more groups in the <b>Group Permissions</b> dropdown list (with ctrl). Only users who belong to the selected groups will be able to see and change the fieldvalue assigned tab(s). If no group is selected, the field will be visible for all groups.</p>
		<p>Note that a user will not be able to see a field when that field was assigned only to tab(s) for which the user does not have permissions.</p>
		<p>Fields will never be hidden for admin users.</p>
		<br />
	</div>

	<div id="examples_c">
		<p>More examples at the <a href="http://wiki.cmsms.nl/index.php/CustomGS#Examples" target="_blank" class="external">CustomGS wiki page</a></p>
		
		<h3>CHECKBOX</h3>
		<h4>Change frontend theme</h4>
		<p>Define a checkbox 'Christmas now' which will activate a special theme on the frontend when checked</p>
		<p style="border:1px solid #ddd; padding:10px; background-color:#f3f3f3">
		<code>
		{if $CustomGS.Christmas_now == '1'}<br />
		&nbsp;&nbsp;&nbsp;{* Show Christmas frontend theme *}<br />
		{else}<br />
		&nbsp;&nbsp;&nbsp;{* Show default frontend theme *}<br />
		{/if}
		</code>
		</p>
		<br />
		
		<h4>Magic with a checkbox</h4>
		<p>Define a checkbox 'MyCheckbox' which will do some magic stuff when unchecked</p>
		<p style="border:1px solid #ddd; padding:10px; background-color:#f3f3f3">
		<code>
		{if $CustomGS.MyCheckbox != '1'}<br />
		&nbsp;&nbsp;&nbsp;{* Do some magic stuff *}<br />
		{/if}
		</code>
		</p>
		<br />
		
		<h3>DATE and TIMEPICKER</h3>
		<h4>Display page content only in a specific timeframe</h4>
		<p>Define two timepicker fields 'starttime' and 'endtime'. Replace the {content} tag in your page template with this code and the normal page content is only visible when the current time is between the starttime and endtime.</p>
		<p style="border:1px solid #ddd; padding:10px; background-color:#f3f3f3">
		<code>
		{if $smarty.now|date_format:'%H:%M' >= $CustomGS.starttime && $smarty.now|date_format:'%H:%M' <= $CustomGS.endtime}<br />
		&nbsp;&nbsp;&nbsp;{content}<br />
		{else}<br />
		&nbsp;&nbsp;&nbsp;{content block="SiteClosedContent"}<br />
		{/if}<br />
		</code>
		</p>
		<br />
		
		<h3>PULLDOWN</h3>
		<h4>Pulldown for Featured Newsarticle</h4>
		<p>Define a pulldown field that contains the titles of articles from the News module, so the user can choose a featured article which can be displayed on a special section on the site.</p>

		<p>First create a new summarytemplate in the News module, named "CustomGS_pulldown" with the following content:</p>

		<p style="border:1px solid #ddd; padding:10px; background-color:#f3f3f3">
		<code>{foreach from=$items item=entry}<br />
		&nbsp;&nbsp;&nbsp;{$entry-&gt;id}|{$entry-&gt;title}<br />
		{/foreach}</code>
		</p>
		<br />
		<p>Then define a new field in the Custom Global Settings module</p>

		<p><b>Name:</b> Featured News<br />
		<b>Type:</b> Pulldown<br />
		<b>Properties:</b> {cms_module module='News' summarytemplate='CustomGS_pulldown'}<br />
		Note that short module tags won't work in the back-end, so you have to use the cms_module tag.</p>
		<br />
		<p>Finally put this tag in your page template to display the featured newsarticle:</p>
		<p style="border:1px solid #ddd; padding:10px; background-color:#f3f3f3">
		<code>{news action='detail' articleid=$CustomGS.Featured_News}</code>
		</p>
		<br />
		
		<h3>RADIOBUTTONGROUP</h3>
		<h4>Change frontend color</h4>

		<p>Create a Radiobutton group named "textcolor"</p>
		<p>The properties value are:<p>
		<p style="border:1px solid #ddd; padding:10px; background-color:#f3f3f3">
		#ff0000|red<br />
		#00f|blue<br />
		#101010|almost black</p>
		<br />
		<p>Also click the checkbox 'Clear stylesheetcache'. This will automatically renew the stylesheets.</p>
		<br />
		<p>Add to the top of your stylesheet:</p>
		<p style="border:1px solid #ddd; padding:10px; background-color:#f3f3f3">
		<code>[[CustomGS]]</code>
		</p>
		<br />
		<p>To change for example the color of the p-text add:</p>
		<p style="border:1px solid #ddd; padding:10px; background-color:#f3f3f3">
		<code>color: [[$CustomGS.textcolor]];</code>
		</p>
		<br />
		<p>Or directly included in a page or template:<p>
		<p style="border:1px solid #ddd; padding:10px; background-color:#f3f3f3">
		<code>&lt;p style="color: {$CustomGS.textcolor};"&gt;Lorem Ipsum&lt;/p&gt;</code>
		</p>
		<br />

		<h3>TEXTFIELD</h3>
		<h4>Show current trainer</h4>
		<p>Define a textfield or pulldown field 'Trainer' which will contain the current trainers name.</p>
		<p style="border:1px solid #ddd; padding:10px; background-color:#f3f3f3">
		<code>
		&lt;p&gt;This weeks trainers name is: {$CustomGS.Trainer}&lt;/p&gt;
		</code>
		</p>
		<br />
	</div>

	<div id="troubleshooting_c">
		<h4>Check template variables</h4>
		<p>You can check which variables and values are available by placing <b>{CustomGS showvars=1}</b> in the content field of a page.</p>
		<br />
		
		<h4>Smarty error</h4>
		<p><b>Error:</b> Smarty error: [in temporary template line 4]: [plugin] unknown tag...</p>
		<p><b>Solution:</b> You probably have entered curly bracket &#123; &#125; signs in the properties field of a pulldown or radiobutton fielddefinition. These are interpreted by Smarty.</p>
		<p>Delete them, use <code>&#123;cms_module&#125;</code> tag in stead of the short module call, or use <code>&#123;literal&#125;</code> tags.</p>
		<br />
		
		<h4>Can't choose GBFilePicker anymore after upgrading to CMSMS 2.x</h4>
		<p><b>Error:</b> GBFilePicker (Not installed)</p>
		<p><b>Solution:</b> Install module JMFilePicker and then change the type of the fielddefinition accordingly. The earlier selected image will be preserved.</p>
		<br />
		
		<h4>tmp/cache/debug.log gets flooded with CustomGS errors</h4>
		<p><b>Error:</b> Redundant {CustomGS} tag found.</p>
		<p><b>Solution:</b> In previous versions of this module, you needed to put the tag {CustomGS} in your template(s). This is not needed anymore. When you have upgraded from a version prior to 2.2, you should delete the {CustomGS} tag from your templates.</p>
		<br />
		
		<h4>Other Errors</h4>
		<p><b>Error:</b> My problem was not described here.</p>
		<p><b>Solution:</b> Set Debug to 'true' in config.php and see if any error messages appear. Look also for error messages in the html sourcecode. Maybe the error message tells you enough to solve the issue yourself. Someone else may have encountered the same problem before you, so you could also search the CMSMS forum for possible solutions. If you haven't found any related topics, please feel free to open a new forumtopic.</p>
		<br />
		<p>It may be that there is more info available at the <a href="http://wiki.cmsms.nl/index.php/CustomGS#Troubleshooting" target="_blank" class="external">CustomGS Wiki page</a></p>
	</div>

	<div id="copyright_c">
		<p>Copyright © 2012, Rolf Tjassens &lt;rolf at cmsmadesimple dot org&gt;, Jos &lt;<a href="mailto:josvd@live.nl">josvd@live.nl</a>&gt;. All Rights Are Reserved.</p>
		<br />
		<p>This module has been released under the <a href="http://www.gnu.org/licenses/licenses.html#GPL" target="_blank">GNU Public License v3</a>.<br />
		<b>However</b>, as a special exception to the GPL, this software is distributed as an addon module to CMS Made Simple. You may only use this software when there is a clear and obvious indication in the admin section that the site was built with CMS Made Simple!</p>
		<br />
	</div>
</div>