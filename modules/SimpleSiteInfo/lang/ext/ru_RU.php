<?php
$lang['friendlyname'] = 'Simple Site Info ';
$lang['moddescription'] = 'SimpleSiteInfo installs Event Handlers in support of the SimpleSiteMgr module.';
$lang['modsimplesiteinfo'] = 'SimpleSiteInfo: Измените кодовую фразу';
$lang['postupgrade'] = 'SimpleSiteInfo был успешно обновлен.';
$lang['postinstall'] = 'SimpleSiteInfo has successfully been installed.<br />
<b>NOTE: You must logout to create the initial version file for this site. <br />
Also, you should change the pass phrase used to encrypt the version file.</b>';
$lang['postuninstall'] = 'SimpleSiteInfo был успешно удален.';
$lang['uninstalled'] = 'SimpleSiteInfo удален.';
$lang['installed'] = 'SimpleSiteInfo версии %s установлен.';
$lang['upgraded'] = 'SimpleSiteInfo обновлен до версии %s.';
$lang['pwdchange'] = 'Измените кодовую фразу.';
$lang['pwdchanged'] = 'Кодовая фраза изменена.';
$lang['header_pwd'] = 'Кодовая фраза.';
$lang['prompt_oldpwd'] = 'Текущая кодовая фраза';
$lang['prompt_pwdchange'] = 'Новая кодовая фраза';
$lang['changelog'] = '<dl>
	<dt>0.1</dt>
		<dd>Test version published for the first time.</dd>
	<dt>0.2</dt>
		<dd>Fixed typos and cosmetics and added a passphrase to encrypt the output file.</dd>
	<dt>0.2.1</dt>
		<dd>Uploaded correct files.</dd>
	<dt>0.3</dt>
		<dd><ul>
			<li>Fixed CMS version variables.</li>
			<li>Limited the length of the Pass Phrase.</li>
		</ul></dd>
	<dt>0.4</dt>
		<dd>Changed the encryption function.</dd>
	<dt>0.5</dt>
		<dd><ul>
			<li>Added admin page info.</li>
			<li>Fixed Upgrade error.</li>
		</ul></dd>
	<dt>1.0</dt>
		<dd>Added a new field to show site needs module upgrades.</dd>
	<dt>1.1</dt>
		<dd>Fixed Bug #5467.</dd>
	<dt>2.0</dt>
		<dd>><ul>
			<li>Simplified the siteinfo file.</li>
			<li>Moved the nuSOAP processing to the SimpleSiteMgr module.</li>
		</ul></dd>

</dl> ';
$lang['help'] = '<h3>About</h3>
<p>This module installs Event Handlers in support of the SimpleSiteMgr module. 
You can, and should, change the Pass Phrase used to encrypt the version info file.</p>
<p>The events that trigger an update of the version info file are:
	<ul>
		<li>When someone logs out of the Admin of the site</li>
		<li>When any module is installed</li>
		<li>When any module is uninstalled</li>
		<li>When any module is upgraded</li>
	</ul>
</p>
<h3>Usage</h3>
<p>There is only one item that can be changed, the "Pass Phrase" used to encrypt the version info file. 
When you open the Admin panel for this module, there is an input field to enter the new password, which is stored 
in the siteprefs table. Pass Phrases are limited to 24 characters.</p>
<p><b>NOTE:</b> You must use the same "Pass Phrase" in the SimpleSiteMgr module entry for this site, or you will not 
be able to decrypt the file.</p>
<h3>Support</h3>
<p>This module does not contain any commercial support. If you have problems, ask in the
<a href="http://forum.cmsmadesimple.org">forums</a>, the 
<a href="irc://irc.freenode.net/cms"><abbr title="Internet Relay Chat">IRC</abbr> chat</a> or write an email to
<a href="mailto:nmcgran@telus.net?subject=SimpleSiteInfoClient">me</a>.<p> ';
$lang['utmz'] = '156861353.1357695352.1.1.utmccn=(direct)|utmcsr=(direct)|utmcmd=(none)';
$lang['utma'] = '156861353.2110014820.1357695352.1357730232.1357752424.5';
$lang['utmc'] = '156861353';
$lang['utmb'] = '156861353';
?>