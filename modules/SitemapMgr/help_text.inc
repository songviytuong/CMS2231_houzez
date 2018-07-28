<div id="page_tabs">
    <div id="general">General</div>
	<div id="start">Getting started</div>
	<div id="template">Templates</div>
	<div id="support">Support</div>
    <div id="copyright">Copyright and License</div>
</div>

<div class="clearb"></div>

<div id="page_content">
	<div id="general_c">
		<h3>Thanks for using SitemapMgr</h3>
		<p><b>Sitemaps</b></p>
		<p>The Sitemaps protocol allows a webmaster to inform search engines about URLs on a website that are available for crawling. A Sitemap is an XML file that lists the URLs for a site. It allows webmasters to include additional information about each URL: when it was last updated, how often it changes, and how important it is in relation to other URLs in the site. This allows search engines to crawl the site more intelligently. Sitemaps are a URL inclusion protocol and complement robots.txt, a URL exclusion protocol.</p>
		<br />
		<p><b>Robots.txt</b></p>
		<p>File to give instructions about the site to web robots; this is called The Robots Exclusion Protocol.</p>
		<br />
		<p><b>Humans.txt</b></p>
		<p>An initiative for knowing the people behind a website. It is a TXT file that contains information about the different people who have contributed to building the website.</p>
	</div>
	
	<div id="start_c">
		<h3>Getting started</h3>
		
		<p><b>1.</b> After installation you will find the SitemapMgr module in the Site Admin menu.</p>
		<br />
		<p><b>2.</b> The install process will automatically create a robots.txt, a sitemap.xml and a sitemap-pages.xml file. The last one is stored in a separate folder in the /assets/ directory, according to CMSMS 2.2 specs.</p>
		<p>Pre-existing humans.txt and robots.txt files are not overwritten, but the content is re-used in the module!</p>
		<br />
		<p><b>3.</b> The humans.txt file is only created after you update the content and save it... If you don't want to use this feature after all, just empty the content and save... The file will be deleted.</p>
		<br />
		<p><b>4.</b> By default there is a sitemap file created for content pages. In the tab "Sitemaps" you can create more sitemaps.</p>
		<br />
		<p><b>5.</b> An internal cron job will recreate the sitemaps every 24 hour.</p>
		<br />
		<p><b>6.</b> In the website root you will find the <u>sitemap index file</u> ( website.com/sitemap.xml ). It is a sitemap for sitemaps. Submit *only* this file to Bing, Google, or... No need to submit all individual sitemaps!</p>
		<br />
		
		<hr />
		
		<h3>Known issues and fixes</h3>
		
		<p><b>Permissive Smarty</b><br />
		In order to calculate the change frequenty the SitemapMgr module uses a PHP function within Smarty.<br />
		You need to add the following line to your config.php file to let it work!<br />
		<br />
		&nbsp;&nbsp;&nbsp;<code>$config['permissive_smarty'] = 1;</code><br />
		<br />
		If not you get the error message: <i>"PHP function xxx not allowed by security setting"</i></p>
		<br />
		
		<p><b>Protocol less URLs</b><br />
		If your CMSMS root url doesn't start with http or https, your sitemaps will not validate and won't be accepted by search engines.<br />
		You need to add the following line to your config.php file to let it work!<br />
		<br />
		&nbsp;&nbsp;&nbsp;<code>$config['root_url'] = 'http://www.website.com';</code></p>
		<br />
		
		<p><b>No automatic sitemap renewal in maintenance mode</b><br />
		This module action is depending on a frontend request. If you want to let it work add the IP of the website/server in the field: <i>Exclude these IP addresses from the "Site Down" status</i> at the Maintenance Mode tab in the CMSMS Global Settings page.</p>
		<br />
		
		<hr />
		
		<br />
		<p><b>More information on using SitemapMgr and creating custom sitemap templates at:</b></p>
		<br />
		<p><a href="https://www.cmscanbesimple.org/blog/how-to-use-sitemapmgr" rel="noopener noreferrer" target="_blank">
		<img src="../modules/SitemapMgr/images/cms-can-be-simple-org.png" alt="" width="500" />
		</a></p>
		<br />
	</div>
	
	<div id="template_c">
		<h3>Templates</h3>
		<p>You will find the templates in the CMS Made Simple Design Manager.</p>
		<h4>Template types and default templates</h4>
		<ul>
			<li>Sitemap CGBlog</li>
			<li>Sitemap CGCalendar</li>
			<li>Sitemap Company Directory</li>
			<li>Sitemap LISE Instances</li>
			<li>Sitemap News</li>
			<li>Sitemap Pages</li>
			<li>Sitemap Products</li>
			<li>Sitemap Custom</li>
		</ul>
		<p>And in the module Admin page content for:</p>
		<ul>
			<li>humans.txt</li>
			<li>robots.txt</li>		
		</ul>
	</div>
	
	<div id="support_c">
		<h3>This module is brought to you by:</h3>
		<p><a href="https://www.cmscanbesimple.org/buy-rolf-a-cup-of-coffee" rel="noopener noreferrer" target="_blank">
		<img src="../modules/SitemapMgr/images/cms-can-be-simple-org.png" alt="" width="500" />
		</a></p>
		<br />
		<p><b>Tips, tricks and tutorials to make it even easier to work with CMS Made Simple&trade;.</b></p>
		<br />
		<p>You can find me at:</p>
		<ul>
			<li><a href="https://www.cmscanbesimple.org" rel="noopener noreferrer" target="_blank">cmscanbesimple.org</a> &raquo;</li>
			<li><a href="https://twitter.com/cmscanbesimple" rel="noopener noreferrer" target="_blank">twitter.com</a> &raquo;</li>
			<li><a href="https://www.youtube.com/channel/UCBmVKhO3jAry90EX-yUVVxQ/videos" rel="noopener noreferrer" target="_blank">youtube.com</a> &raquo;</li>
		</ul>
		
		<h3>Support me for supporting you!</h3>
		<p>Do you like this module and the help you get at CMS Can Be Simple?<p>
		<p>You can donate some money to buy me a virtual cup of coffee as a small token of appreciation.<p>
		<p><b><a href="https://www.cmscanbesimple.org/buy-rolf-a-cup-of-coffee" rel="noopener noreferrer" target="_blank">DONATE NOW</a> &raquo;</b></p>
		
		<h3>Support</h3>
		<p>This module does not contain any commercial support. If you have problems, ask for help in the:</p>
		<ul>
			<li><a href="https://forum.cmsmadesimple.org/" rel="noopener noreferrer" target="_blank">CMS Made Simple forums</a>,</li>
			<li><a href="irc://irc.freenode.net/cms" rel="noopener noreferrer" target="_blank"><abbr title="Internet Relay Chat">IRC</abbr> chat</a>,</li>
			<li>or write an email to the author</li>
		</ul>
	</div>
	
	<div id="copyright_c">
		<h3>Copyright and License</h3>
		<p>Copyright &copy; 2017, Rolf Tjassens [info at cmscanbesimple dot org]. All Rights Are Reserved.</p>
		<br />
		<p>This module has been released under the <b><a href="http://www.gnu.org/licenses/licenses.html#GPL" rel="noopener noreferrer" target="_blank">GNU Public License v3</a></b>.</p>
		<br />
		<p><b>However</b>, as a special exception to the GPL, this software is distributed as an addon module to CMS Made Simple&trade;.<br />
		You may only use this software when there is a clear and obvious indication in the admin section that the site was built with <b>CMS Made Simple&trade;</b>.</p>
	</div>
</div>