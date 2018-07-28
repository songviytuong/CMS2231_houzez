<?php
$lang['edit_orig_content']=' Click here to edit original content.';
$lang['postinstall']='The Content Aliases Module has been installed.';
$lang['friendlyname']='Content Aliases';
$lang['target']='Target';
$lang['uninstalled'] = 'Module Uninstalled.';
$lang['installed'] = 'Module version %s installed.';
$lang['upgraded'] = 'Module upgraded to version %s.';
$lang['changelog']='<ul>
  <li>Version 1.0 - 14 Nov 2013.</li>
  <ul>
    <li> CMSMS 1.11.x enhancements.</li>
    <li> Minor work towards CMSMS 2.0 compatibility.</li>
    <li> Changed content tabs organization:</li>
    <ul>
      <li> Added an Options tab - some options are now directly inherited from CMSMS Content Base.</li>
      <li> Added a Preview tab - use of the preview system of CMSMS contents is now possible.</li>
    </ul>
  </ul>
  <li>Version 0.7 - 13 Nov 2012. CMSMS 1.1x enhancements.</li>
	<li>Version 0.6.11 - 8 Nov 2010. CMSMS 1.9 enhancements.</li>
	<li>Version 0.6.10 - 26 Oct 2010. More fixes to work with CMSMS 1.8.x and 1.9beta. Thanks Stikki!</li>
	<li>Version 0.6.9 - 22 Oct 2010. Fixes to work with CMSMS 1.8.x and 1.9beta.</li>
	<li>Version 0.6.8 - 3 September 2009. Fixes provided by numerous people, notably Jeff Bosch and Lew Shepherdson.</li>
		<li>Version 0.6.7 - 25 March 2009. Nuno\'s fixes, localizations, and more.</li>
		<li>Version 0.6.6 - 24 February 2008. Chris Smith\'s patch for pages with multiple content areas</li>
		<li>Version 0.6.5 - 4 January 2008. Updated maxversion to work with CMSMS 1.2.3 (and possible future 1.2.4)</li>
		<li>Version 0.6.4 - 24 December 2007. Fix for lazy-loading of Content Properties for CMS 1.2.x</li>
		<li>Version 0.6.3 - 24 August 2007. Additional features to protect against problems in Cataloger, if target not set or defective.</li>
		<li>Version 0.6.2 - 22 August 2007. Bug fix to restore compatibility with CMS 1.0.x.</li>
		<li>Version 0.6.1 - 20 June 2007. Added feature to enable correct operation with Cataloger 0.5.5.</li>
		<li>Version 0.6 - 25 May 2007. Upgraded to work with CMS MS 1.0.5 and later.</li>
		<li>Version 0.5 - 20 November 2006. Upgraded for CMS MS 1.0.x, just in time to break v.1.1.</li>
		<li>Version 0.4 - 28 October 2005. Added API method so other modules can access Aliased Content.</li>
		<li>Version 0.3 - 24 October 2005. Updated to work correctly with various menu modules, added option to edit original content.</li>
		<li>Version 0.2 - 8 July 2005. Updated to work with CMS version 0.10 and use a language file.</li>
		<li>Version 0.1 - 12 March 05. Initial release.</li></ul>';
$lang['help']='<h3>What does this do?</h3>
		<p>This module simple creates a new content type called a Content Alias. This is analogous to an "alias" in Mac OS or a "shortcut" in Windows. Basically, it lets you use the same content in multiple places on your site, and have multiple menu items pointing to that content. Editing the orginal item will update the content for all of the menu items.</P>
		<p>This is particularly useful if there is a page on your site that fits two places in the taxonomy: e.g., an "Our History" page which fits into the "About Our Company" section as well as in the "Investor Information" section.</p>
		<p>You can also use an alias to present content using a different template.</p>
		<p>Strangely and wondrously, you can point an a Content Alias at another Content Alias, and it will still work according to the associative property.</p>
		<h3>How do I use it?</h3>
		<p>After installing the module, you will have a new content type available. When you want to create an alias, simply select "Content Alias" as your content type. You can then specify the title, menu title, parent, activity, and template for the content as you would normally, but you will also be able to select the "target" to which this Content Alias points.</p>
<h3>Support</h3>
<p>This module does not include commercial support. However, there are a number of resources available to help you with it:</p>
<ul>
<li>For the latest version of this module, FAQs, or to file a Bug Report or buy commercial support, please visit the developer forge
at <a href="http://dev.cmsmadesimple.org">dev.cmsmadesimple.org</a>.</li>
<li>Additional discussion of this module may also be found in the <a href="http://forum.cmsmadesimple.org">CMS Made Simple Forums</a>.</li>
<li>The current developer, Jo Morg, can often be found in the <a href="irc://irc.freenode.net/#cms">CMS IRC Channel</a>.</li>
<li>Lastly, you may have some success emailing the current developer directly.</li>  
</ul>
<p>As per the GPL, this software is provided as-is. Please read the text
of the license for the full disclaimer.</p>

<h3>Copyright and License</h3>
<p>Copyright &copy; 2012-2013, Jo Morg (Fernando Morgado) <a href="mailto:jomorg.morg@gmail.com">&lt;jomorg.morg@gmail.com&gt;</a>. All Rights Are Reserved.</p>
<p>Copyright &copy; 2005, Samuel Goldstein. All Rights Are Reserved.</p>
<p>This module has been released under the <a href="http://www.gnu.org/licenses/licenses.html#GPL">GNU Public License</a>. You must agree to this license before using the module.</p>
';
?>
