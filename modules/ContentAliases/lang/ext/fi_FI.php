<?php
$lang['postinstall'] = 'Content Aliases -moduuli on asennettu.';
$lang['friendlyname'] = 'Sis&auml;lt&ouml;aliakset';
$lang['target'] = 'Kohde';
$lang['uninstalled'] = 'Moduulin asennus poistettu';
$lang['installed'] = 'Moduulin versio %s asennettu.';
$lang['upgraded'] = 'Moduuli p&auml;ivitetty versioon %s.';
$lang['changelog'] = '<ul>  
		<li>Version 0.6.6 - 24 February 2008. Chris Smith&#039;s patch for pages with multiple content areas</li>
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
$lang['help'] = '<h3>What does this do?</h3>
		<p>This module simple creates a new content type called a Content Alias. This is analogous to an &quot;alias&quot; in Mac OS or a &quot;shortcut&quot; in Windows. Basically, it lets you use the same content in multiple places on your site, and have multiple menu items pointing to that content. Editing the orginal item will update the content for all of the menu items.</P>
		<p>This is particularly useful if there is a page on your site that fits two places in the taxonomy: e.g., an &quot;Our History&quot; page which fits into the &quot;About Our Company&quot; section as well as in the &quot;Investor Information&quot; section.</p>
		<p>You can also use an alias to present content using a different template.</p>
		<p>Strangely and wondrously, you can point an a Content Alias at another Content Alias, and it will still work according to the associative property.</p>
		<h3>How do I use it?</h3>
		<p>After installing the module, you will have a new content type available. When you want to create an alias, simply select &quot;Content Alias&quot; as your content type. You can then specify the title, menu title, parent, activity, and template for the content as you would normally, but you will also be able to select the &quot;target&quot; to which this Content Alias points.</p>
<h3>Support</h3>
<p>This module does not include commercial support. However, there are a number of resources available to help you with it:</p>
<ul>
<li>For the latest version of this module, FAQs, or to file a Bug Report or buy commercial support, please visit the developer forge
at <a href=&quot;http://dev.cmsmadesimple.org&quot;>dev.cmsmadesimple.org</a>.</li>
<li>Additional discussion of this module may also be found in the <a href=&quot;http://forum.cmsmadesimple.org&quot;>CMS Made Simple Forums</a>.</li>
<li>The author, SjG, can often be found in the <a href=&quot;irc://irc.freenode.net/#cms&quot;>CMS IRC Channel</a>.</li>
<li>Lastly, you may have some success emailing the author directly.</li>  
</ul>
<p>As per the GPL, this software is provided as-is. Please read the text
of the license for the full disclaimer.</p>

<h3>Copyright and License</h3>
<p>Copyright &copy; 2005, Samuel Goldstein <a href=&quot;mailto:sjg@cmsmodules.com&quot;><sjg@cmsmodules.com></a>. All Rights Are Reserved.</p>
<p>This module has been released under the <a href=&quot;http://www.gnu.org/licenses/licenses.html#GPL&quot;>GNU Public License</a>. You must agree to this license before using the module.</p>
';
$lang['utma'] = '156861353.1959547193.1213865783.1214291689.1214296543.21';
$lang['utmz'] = '156861353.1214056345.10.4.utmccn=(referral)|utmcsr=dev.cmsmadesimple.org|utmcct=/forum/forum.php|utmcmd=referral';
$lang['utmc'] = '156861353';
?>