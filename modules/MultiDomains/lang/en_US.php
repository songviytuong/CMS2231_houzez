<?php

# 0-9

# A
$lang['active'] = 'Active';
$lang['always'] = 'Always';

# B

# C
$lang['cache'] = 'Cache';
$lang['cancel'] = 'Cancel';
$lang['changelog'] = <<<EOT
<ul>
<li>2.2.3 - February 2016<p>
* Just a bugfix (parameter)
</p></li>
<li>2.2.2 - February 2016<p>
* Just a bugfix (during installation)
</p></li>
<li>2.2.1 - January 2016<p>
* Module is now compatible to CMSms 2.x<br />
- Systemcheck removed<br />
+ www prefix now editable
</p></li>
<li>2.1.2 - April 2013
<p>* Filter added. Up to now just for the NMS module - it was not working correctly with MultiDomains - so I added the filter function as a workaround.</p></li>
<li>2.1.1 - August 2012
<p>* Tables for 301 and 404 are not dropped automatically anymore and and can be imported of the module ToolBox.</p></li>
<li>2.1 - August 2012
<p>* Ready for CMSms 1.11.x.<br />
* Fixed some issues (PHP-Notices, other problems).<br />
+ Setting for the domains added to decide, wether a domain without request-string (that means without anything after the domain name) should directed to the first page within the domain-tree or to the standard page which is set in the page overview.</p></li>
<li>2.0.1 - December 2011
<p>* Fixed some bugs in domain linking and statistics.</p></li>
<li>2.0 - November 2011
<p>* Removed tools that are not neccesary for Domain redirecting and created a separate module (called ToolBox).<br />
* Look of Statistics-Tab simplyfied (was confusing me after using it for a longer time).<br />
+ Added setting to clear the CMS cache after a modification on the domains.<br />
+ Added tab for a system check - to check whether .htaccess and config.php are configured correctly.<br />
* Added some help for a better understanding, what you did configure.</p></li>
<li>1.5.3 - November 2011
<p>+ Added an option to use MultiDomains without the event management<br />
+ Added a smarty variable \$mdsite with the current active domain name<br />
* Fixed some PHP notices</p></li>
<li>1.5.2 - November 2011
<p>* Compatible with CMSms 1.10.x.</p></li>
<li>1.5.1 - April 2011
<p>+ Add feature to get an page-title, page-menutext or page-attribute (instead of an page url) - should be useful for the menu manager</p></li>
<li>1.5 - March 2011
<p>+ Add feature to show debug messages<br />
+ Add RegExp to 301 Forwardings<br />
* Some small usability improvements<br />
* Bugfix: 301 Forwarding was not possible with some news articles<br />
* Bugfix: On some servers forwarding with www. was not possible</p></li>
<li>1.4.1 - February 2011
<p>+ Add ignore filter for 404 error tracking<br />
+ Add setting for a maximum amount of 404 errors<br />
* Improvements to the 404 error list and -handling</p></li>
<li>1.4 - February 2011
<p>* Compatible with CMSms 1.9.x.<br />
+ 404 Error Tracking.<br />
+ Placeholder for correct domain names in links (e.g. for the menu manager).<br />
* Different bugs fixed.</p></li>
<li>1.3 - Mai 2010
<p>* Changend to event handling - placeholder is not needed anymore.<br />
+ Added switch for statistics and old url rewrite.<br />
+ Added EMail functionality for monthly statistics.<br />
* Fixed bug with log summary.<br />
* Fixed bug with wrong page extensions.<br />
* Fixed bug with default content.</p></li>
<li>1.2.2 - May 2010
<p>* Fixed a problem with 404 pages.<br />
* Fixed a problem with development server.</p></li>
<li>1.2.1 - May 2010
<p>* Fixed a bug with log summary.</p></li>
<li>1.2 - May 2010
<p>+ Added support for 301 redirect old urls.<br />
+ Added some small statistics.<br />
* Fixed some bugs.</p></li>
<li>1.1 - May 2010
<p>+ Added support for more than one domain for a page(-structure).<br />
+ Added support for development domain.</p></li>
<li>1.0 - May 2010
<p>Initial Release of the module MultiDomains</p></li>
</ul>
EOT;
$lang['clear_cache'] = 'Clear CMS-Cache after changes';
$lang['clear_cache_help'] = 'After each change at the domain settings of this module, the CMS-Cache will be cleared, so that the changes will affect immediately.';
$lang['config_backup_fail'] = 'Backup of the old config.php failed. Modified config.php sendt as download.';
$lang['config_download'] = 'Download modified config.php';
$lang['config_modify'] = 'modify config.php';
$lang['config_not_modified'] = 'The file config.php was not yet modified!';
$lang['config_ok'] = 'The file config.php was already modified and has the right version :-)';
$lang['config_written'] = 'The file config.php was modified. The old config.php was saved under %s.';
$lang['config_written_fail'] = 'Writing of config.php failed. Modified config.php sendt as download.';
$lang['config_wrong_version'] = 'The file config.php has a wrong version!';
$lang['created'] = 'First time';

# D
$lang['day'] = 'Day';
$lang['days'] = 'Days';
$lang['ddescription'] = 'This domain will be used for all pages below (and including) page <strong>%s</strong>. Affected pages: ';
$lang['debug'] = 'Debug';
$lang['debug_log'] = 'Debug Log';
$lang['debug_use'] = 'Use Debug Tab';
$lang['delete'] = 'Delete';
$lang['deleteall'] = 'Delete all';
$lang['desc_cerror'] = 'Wrong Settings';
$lang['desc_csuccess'] = 'Right Settings';
$lang['desc_hterror'] = 'Missing Lines';
$lang['desc_htsuccess'] = 'Right Settings';
$lang['devdomain'] = 'Development server domain';
$lang['devdomain_activate'] = 'Support for development server';
$lang['devdomain_short'] = 'DevDomain';
$lang['devip'] = 'IP of the Development Server';
$lang['do'] = 'Action';
$lang['domain'] = 'Domain';
$lang['domainedit'] = 'Edit Domain';
$lang['domainname'] = 'Domainname';
$lang['domains'] = 'Domains';
$lang['dont_use_event_handler'] = 'Don\'t use Event Handler';
$lang['dont_use_event_handler_help'] = 'Without using the event handler, you need to insert {MultiDomains} at the bottom of your page templates...';
$lang['donate'] = '<div style="float:right"><form action="https://www.paypal.com/cgi-bin/webscr" method="post"><input type="hidden" name="cmd" value="_s-xclick"><input type="hidden" name="hosted_button_id" value="9BQAL9XT45FGN"><input type="image" src="https://www.paypalobjects.com/WEBSCR-640-20110306-1/en_US/i/btn/btn_donate_SM.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!"><img alt="" border="0" src="https://www.paypalobjects.com/WEBSCR-640-20110306-1/de_DE/i/scr/pixel.gif" width="1" height="1"></form></div>';

# E
$lang['edit'] = 'Edit';
$lang['error_permissiondenied'] = 'Permission Denied';
$lang['errorinsertingdomain'] = 'Error with domain processing';
$lang['errorlist'] = 'Error listing';
$lang['extradomains'] = 'Extra Domains';
$lang['extradomains_description'] = 'Associated Domains to this Domain, each in one line:';

# F
$lang['friendlyname'] = 'MultiDomains';
$lang['fromurl'] = 'Referer URL';

# G

# H
$lang['help'] = <<<EOT
<h3>What Does It Do?</h3>
<p>This module allows to use multiple domains with CMS made simple. You can assign domain names to existing pages.</p>
<h3>How Do I Use it?</h3>
<p><strong>1. Enable mod_rewrite</strong></p>
<p>- Create a new file named ".htaccess" (if it not already exists) in the CMSms root directory with (at least) the following content:
<pre># .htaccess for CMS made simple
RewriteEngine On
RewriteBase /
RewriteCond %{REQUEST_URI} !/$
RewriteCond %{REQUEST_URI} !\.
RewriteCond %{REQUEST_METHOD} !POST$
RewriteRule ^(.*) %{REQUEST_URI}/ [NE,R=301,L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.+)$ index.php?page=$1 [QSA]
# EOF</pre></p>
<p>Open the file "config.php" (in the CMSms root directory) and set the parameter "url_rewriting" to "mod_rewrite" (if it is not already done).</p>
<p><strong>2. Add your domains in the module backend</strong><br />
Go the the module backend (Extensions/MultiDomains) and add your domains and its associated pages.</p>
<p><i>3. (Optional) Use Placeholder for URLs (e.g. in the Menumanager)</i><br />
z.B.: <code>{MultiDomains pageid=&quot;16&quot;}</code></p>
<h3>Using the module without event management</h3>
<p>Since version 2.0 of MultiDomains I added a new option to the module settings to de-activate the using of MultiDomains through the CMSms-integrated Event Management.</p>
<p>If you use this option, you need to include the module calling at the beginning of your page-template(s):<br /><code>{MultiDomains}</code><br />
The best place to include it is right after {process_pagedata}.</p>
<p>After that you can even use some variables within your template:<br />
<code>\$mdsite</code> - contains the current active domain name (without www, as the site is entered in the module)<br />
<code>\$mddevsite</code> - contains the current active development domain name</p>
<p>Furthermore, this option will not disturb the CMSms-integrated caching mechanism.</p>
<h3>Parameters</h3>
<ul>
<li><i>pageid</i> - ID of page, which you want to get the url from.</li>
<li><i>pagealias</i> - (only if pageid cannot be used) Alias of page, which you want to get the url from.</li>
<li><i>linkvalue</i> - If you want to return the page title, menu text or title attibute (instead of url), you can specify this here.<br />Available values: title, menutext, titleattribute, url<br />Default value: url</li>
</ul>
<h3>Support</h3>
<p>This module does not include commercial support. However, there are a number of resources available to help you with it:</p>
<ul>
<li>For the latest version of this module, FAQs, or to file a Bug Report or buy commercial support, please visit the CMS Made simple website: http://www.cmsmadesimple.de</li>
<li>Additional discussion of this module may also be found in the CMS Made Simple Forum: http://forum.cmsmadesimple.de/viewforum.php?id=9</li>
<li>The author, Andi Petzoldt, can be reached using his website: http://andiministrator.de/</li>
<li>Lastly, you may have some success emailing the author directly.</li>
</ul>
<p>As per the GPL, this software is provided as-is. Please read the text of the license for the full disclaimer.</p>
<h3>Copyright and License</h3>
<p>Copyright © 2011, Andi Petzoldt <andi@petzoldt.net>. All Rights Are Reserved.</p>
<p>This module has been released under the GNU Public License. You must agree to this license before using the module.</p>
EOT;
$lang['htaccess_missing'] = 'The file .htaccess is missing!';
$lang['htaccess_ok'] = 'The file .htaccess is ok :-)';

# I
$lang['id'] = 'ID';
$lang['installed'] = 'installed';
$lang['ip'] = 'IP Number';

# J

# K
$lang['keyword'] = 'Keyword';

# L
$lang['last_day'] = 'Yesterday';
$lang['last_month'] = 'Last month';
$lang['last_year'] = 'Last year';
$lang['linkvalue'] = 'Type of return value of the link';

# M
$lang['makeactive'] = 'Activate';
$lang['makeinactive'] = 'Deactivate';
$lang['makestandard'] = 'As Standard';
$lang['moddescription'] = 'This module enables CMSms to manage mutiple domains within one installation (and backend). Furthermore has some statistics included.';
$lang['modified'] = 'Last time';
$lang['month'] = 'Month';
$lang['months'] = 'Months';
$lang['morehelp'] = 'Take a look in the module help page to get more information!';

# N
$lang['never'] = 'Never';
$lang['new'] = '(new)';
$lang['newdomain'] = 'New Domain';
$lang['notes'] = 'Notes';

# O

# P
$lang['page'] = 'Page';
$lang['pageid'] = 'Page ID';
$lang['pagealias'] = 'Page Alias';
$lang['postinstall'] = 'The MultiDomains module has successfully been installed. You can access the module backend in Extensions / MultiDomains. The module is using the permissions "Manage MultiDomains".';
$lang['postuninstall'] = 'The MultiDomains module has successfully been removed';
$lang['preferences'] = 'Preferences';
$lang['prefix'] = 'WWW Prefix?';
$lang['preuninstall'] = 'Are you really sure you want to uninstall the module MultiDomains?';

# Q

# R
$lang['reallymakeactive'] = 'Do you want to activate this really?';
$lang['reallymakeinactive'] = 'Do you want to deactivate this really?';
$lang['reallydelete'] = 'Do you want to delete this really?';
$lang['referer'] = 'Referer';
$lang['regexp'] = 'RegExp';
$lang['reset'] = 'Reset';
$lang['root'] = 'Root';
$lang['root_help'] = 'Should this domain by accessing without request-string (that means without anything after the domain name) point to the first page from itself (within the domain-tree)? Otherwise it will redirect to the standard page which is set in the page overview.';

# S
$lang['searchengine'] = 'Search Engine';
$lang['send'] = 'Submit';
$lang['session_id'] = 'Session ID';
$lang['standard'] = 'Standard';
$lang['stats'] = 'Statistics';
$lang['stats_daily'] = 'Use daily statistics';
$lang['stats_email'] = 'EMail for monthly statistics';
$lang['stats_email_help'] = 'Leave empty, if you won\'t use it';
$lang['stats_email_subject'] = 'MultiDomains Statistics %u of %m';
$lang['stats_use'] = 'Use statistics';
$lang['status'] = 'Status';
$lang['submit'] = 'Save';

# T
$lang['targetpage'] = 'Target Page';
$lang['targeturl'] = 'Target URL';
$lang['time'] = 'Time';
$lang['tourl'] = 'Missing Page';

# U
$lang['url'] = 'URL';
$lang['urls'] = 'URLs';

# V
$lang['visits'] = 'Visits';
$lang['view'] = 'View';

# W
$lang['www_notice'] = 'without www.';
$lang['www_replace'] = 'replace www';

# X

# Y
$lang['year'] = 'Year';
$lang['years'] = 'Years';

# Z

// EOF