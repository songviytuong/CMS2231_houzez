<?php
$lang['friendlyname'] = 'Error Logger';
$lang['really_uninstall'] = 'Really? Are you sure you want to uninstall '.$lang['friendlyname'].' ?';
$lang['uninstalled'] = 'Module Uninstalled.';
$lang['installed'] = 'Module version %s installed.';
$lang['upgraded'] = 'Module upgraded to version %s.';
$lang['moddescription'] = 'This module writes (system) error messages in to the database and provides the possibility to browse them.';

$lang['error'] = 'Error!';
$land['admin_title'] = 'Error Logger Admin Panel';
$lang['admindescription'] = $lang['moddescription'];
$lang['accessdenied'] = 'Access Denied. Please check your permissions.';

$lang['changelog'] = '<ul>
   <li>Version 1.0 - 31 December 2012.<br />Initial Release.</li>
   <li>Version 1.0.1 - 01 January 2013.<br />Bugfix on installation routine</li>
   <li>Version 1.1 - 20 January 2013.<br />added download as CSV file</li>
   <li>Version 1.2 - June 2015<br />fixed reported bugs (10527, 10528, 10529, 10530)</li>
   <li>Version 1.3 - November 2015<br />prepared for CMSMS 2.x</li>
   <li>Version 1.4 - December 2015<br />added some comments to code</li>
</ul>';
$lang['help'] = '<h3>What Does This Do?</h3>
<p>Some webhoster do not offer access to the log files.<br />'.$lang['moddescription'].'</p>

<h3>How Do I Use It?</h3>
<p>Just install, and feel free to change some settings.</p>
<p>If your config.php is write protected, add this line by yourself:<br />
<i>require_once "path/to/ErrorLogger.handler.php";</i>
</p>

<h3>Support</h3>
<p>As per the GPL, this software is provided as-is. Please read the text of the license for the full disclaimer.</p>

<h3>Copyright and License</h3>
<p>Copyright &copy; 2012, Oliver Joo&szlig;. All Rights Are Reserved.</p>

<p>This module has been released under the <a href="http://www.gnu.org/licenses/licenses.html#GPL">GNU Public License</a>. You must agree to this license before using the module.</p>';

?>