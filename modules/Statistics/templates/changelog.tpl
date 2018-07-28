<ul>
<li>
  <p>Version: 1.2.0</p>
  <p>Prepared for cmsms 1.11-series</p>
  <p>Fixed some stupid logic resulting in no emails sent under some circumstances</p>
</li>
<li>
  <p>Version: 1.1.3</p>
  <p>Fixed a wrong SQL statement bug #6120</p>
  <p>Made the choice of submenu a setting</p>
</li>
<li>
  <p>Version: 1.1.2</p>
  <p>Fixed a space outside php in en_US.php causing header problems</p>
  <p>Fixed a root_path which should be root_url #6109</p>
</li>
  <li>
    <p>Version: 1.1.1</p>
    <p>Added SymbianOS to smartphone detection</p>
    <p>Added referrer saving on single visitors</p>
    <p>Now supports sending regular email to multiple adresses</p>
    <p>Moved statistics to Site Admin-menu... makes more sense...</p>
    <p>Fixed a path-issue bug #6105, thanks to springercreative</p>
  </li>
  <li>
    <p>Version: 1.1.0</p>
    <p>Rewrote to use preg_match instead of depreciated eregi</p>
    <p>Added Smartphone-detection</p>
    <p>Added Bounce-detection</p>
    <p>Added multiple icon themes</p>
  </li>
<li>
    <p>Version: 1.0.2</p>
    <p>Removed some potential warnings when starting to use stats for the first time</p>
    <p>Fixed some potention eregi-errors on visitor/referer-filtering</p>
</li>
<li>
    <p>Version: 1.0.1</p>
    <p>Fixed broken statistics when user did not have permission to adminsitrate settings</p>
    <p>Fixed a strange occurence of double dots in TLD's</p>
</li>
<li>
    <p>Version: 1.0</p>
    <p>Lots of cleaning up after pChart-crap</p>
    <p>Tweeks to the jqPlot-stuff</p>    
</li>
<li>
    <p>Version: 1.0rc2</p>
    <p>Lots of cleaning up after pChart-crap</p>
    <p>Implemented jqPlot-charts (yes, I know rc's are not the place for new features, but...</p>
    <p>Implemented graphical numbers output. Very simple for now.</p>
    <p>total hits are now default when output is selected</p>
    <p>Fixed donations tab</p>
</li>
<li>
    <p>Version: 1.0rc1</p>
    <p>Added options not to record and store IP-addresses</p>
    <p>Disabledd pChart's, not working properly</p>
    <p>Cleaned up stuff</p>
</li>
  <li>
    <p>Version: 0.9.9</p>
    <p>this is 1.0-pre</p>
    <p>switched order in browser-sniffing so that chrome, doubling id's as safari, is recognized as chrome first</p>
    <p>fixed IE8 identifyeing as IE6</p>
    <p>Added donationstab</p>
</li>
<li>
    <p>Version: 0.9.3</p>
    <p>Added showing which visitor is being tracked in tracking-details</p>
    <p>Finally implemented sending emails with stats</p>
    <p>Cosmetic changes in admin</p>
    <p>Changed delimiter in keywords from ; to | to allow &-style entities</p>
    <p>Added a limit to searchwords</p>

  </li>
  <li>
    <p>Version: 0.9.2</p>
    <p>Fixed a lot of pChart bugs</p>
    <p>Fixed referer filtering bugs</p>
    <p>Added an option whether to gather complete url-statistics</p>
    <p>Added an option whether to register single keywords or combination of the</p>
    <p>Added an option to do string replacements within keywords</p>
    <p>Added levelling of log event (probably also used in a place or 2)</p>
    <p>Reorganized settings into settings and visuals and templates</p>
    <p>Probably other stuff I forgot and which hopefully didn't break anything...</p>
  </li>
  <li>
    <p>Version: 0.9.1</p>
    <p>Did new what-parameter, thispageviews showing the viewings of the current page</p>
    <p>Fixed giant geoip-errormessage bug</p>
    <p>Implemented an option to automagically detect admins IP's and ignore them</p>
    <p>Implemented gathering stats about robots, and made the list of robots configurable</p>
    <p>Implemented actual visitor tracking through pages</p>
    <p>Now supports the nice pChart-system for relevant charts. Work-in-progress!</p>
    <p>Now stays on the selected stat-type when saving settings etc.</p>
    <p>Many, many smaller fixes and cosmetic changes</p>
  </li>
  <li>
    <p>Version: 0.9.0</p>
    <p>Fixed host-filter so it's now actually doing substring-matching, not wildcardmatching, as the doc says</p>
  </li>
  <li>
    <p>Version: 0.9.0b2</p>
    <p>Added showing the current visitor IP when called</p>
    <p>Prevented multiple calls to the module from generation multiple view counts</p>
    <p>Implemented country detection by geoIP-data</p>
    <p>Reorganized admin section into multiple tabs</p>
    <p>Removed the how-parameter</p>
    <p>Added translatable countrynames and flags</p>
    <p>Added small iconversions, and different icons for dates</p>
  </li>

  <li>
    <p>Version: 0.9.0b1</p>
    <p>Sanitation of a lot of queries</p>
    <p>Completely revamping visual layout, with graphical bars, icons</p>
    <p>Seperated pages to avoid major overhead when loaden fronpage</p>
    <p>Improved compatibility with PostGreSQL</p>
    <p>Rewrote browser and OS-detection schemes</p>
    <p>Now allows a list of referers to ignore</p>
    <p>Numerous fixes and optimizations</p>
  </li>

  <li>
    <p>Version: 0.8.0</p>
    <p>0.8.0-final as no bugs have been reported for some time</p>
  </li>
  <li>
    <p>Version: 0.8.0b9</p>
    <p>Revised toppages-template to using cms_selflink</p>
  </li>
  <li>
    <p>Version: 0.8.0b8</p>
    <p>Fixed saving ignorepages, really goodbye google-bot</p>
    <p>Implemented a customizable template for topX-list</p>
  </li>
  <li>
    <p>Version: 0.8.0b8</p>
    <p>Fixed saving ignorepages, really goodbye google-bot</p>
    <p>Implemented a customizable template for topX-list</p>
  </li>
  <li>
    <p>Version: 0.8.0b7</p>
    <p>Implemented ignoring visitors based on hostname, goodbye google-bot</p>
    <p>Made ignore-ips wildcard-aware</p>
  </li>
  <li>
    <p>Version: 0.8.0b6</p>
    <p>Rewrote lastreset to use strftime syntax as date cannot be localized</p>
    <p>Fixed a php5 warning</p>
  </li>
  <li>
    <p>Version: 0.8.0b5</p>
    <p>Added code to show last reset of stat data</p>
    <p>Implemented ip/host-lookup caching as multiple gethostbyaddr-calls can get slow.</p>
    <p>Prevented js-inserts for visitors who were ignored</p>
    <p>Fixed disabling JS-detections, thanks Chris</p>
  </li>
  <li>
    <p>Version: 0.8.0b4</p>
    <p>Removed some debugging code</p>
    <p>Implemented ip/host-lookup caching as multiple gethostbyaddr-calls can get slow.</p>
    <p>Prevented js-inserts for visitors who were ignored</p>
  </li>

  <li>
    <p>Version: 0.8.0b3</p>
    <p>Several bugfixes</p>
    <p>Implemented online, active and toppages as what-to-show's</p>
    <p>Added parameter-filtering and registered as plugin</p>
  </li>

  <li>
    <p>Version: 0.8.0b2</p>
    <p>Fixed the bug causing content page list to break. Thanks a million Chris!</p>
    <p>Added detection and presentation of clients screen-resolution (optional as it inserts javascript-code)</p>
    <p>Optimized a couple of sql-statements away</p>
    <p>Added expirytime for things like referrers</p>
    <p>Tried to sanitize referrer statistics</p>
    <p>Bugfixes</p>
  </li>
  <li>
    <p>Version: 0.8.0b1</p>
    <p>Wow, the changelist is almost too long to mention. Almost every part touched for more modern module-building. Apart from actually working, which it did not earlier, logging has been fixed, code optimized and simplified.</p>
    <p>Did I mention numerous bugfixes and cosmetic fixes</p>
    <p>Text and Gfx charts works now</p>
    <p>Flash charts added, but not displaying actual data, that's for 0.8.1</p>
  </li>
  <li>
    <p>Version: 0.7.0</p>
    <p>Optimized memory usage by getting a db-reference</p>
  </li>
  <li>
    <p>Version: 0.6.2</p>
    <p><b>Jan's improvements:</b></p>
    <p>Added stats for referrer urls</p>
    <p>Added stats for search engines and keywords (for a few search engines)</p>
    <p>Added IP addresses to ignore (your own IP address is added by default at installation)</p>
    <p>Corrected default values for activelimit and visitorlimit at installation</p>
    <p><b>My fixes:</b></p>
    <p>Fixed showing pages with no titles</p>
    <p>Fixed a stupid bug with a &lt; sign which should be a &gt;</p>
    <p>Fixed showing online visitors (active limit is saved in seconds, not minutes)</p>
    <p>No longer counts "" as a country</p>
  </li>
  <li>
    <p>Version: 0.6.1</p>
    <p>Fixed some AdoDBlite stuff, seems RowCount is not equal to RecordCount in AdoDBlite...</p>
    <p>Added statistics gathering and presentation of CMSMS-pages. Makes you see which parts of your site is most popular, and what subpage other pages links to etc.</p>
    <p>Cleaned up translations and some other stuff</p>
  </li>
  <li>
    <p>Version: 0.6.0 (or 0.5.2 in Frank's version)</p>
    <p>Franks contributions</p>
    <p>Fixed bug that makes website not working properly</p>
    <p>Moved some more phrases in the language file</p>
    <p>Completed showing hits per year, browsers, countries, settings for all show functions</p>
    <p>Changed date format in db to sort data easier for output</p>
    <p>Changed show functions to work with settings</p>
    <br/>
    <p>todo: session_id doesn't work all the time, problem with cmsms?</p>
    <p>      add average hour page and average weekday page</p>
    <br/>
    <p>Mortens contributions</p>
    <p>Mostly integrating Frank's changes with the small changes I had already done</p>
    <p></p>
  </li>
  <li>
    <p>Version: 0.5.1</p>
    <p>Fixed numerous braindead bugs</p>
    <p>Added reset of statistics to settings</p>
    <p>Made settings actually configurable</p>
  </li>
  <li>
    <p>Version: 0.5.0</p>
    <p>Fixed a really serious bug in statistics gathering... Please uninstall and reinstall for a cleaner DB! sorry...</p>
    <p>Added administration of stat-options. Some at least, more are coming</p>
    <p>Fixed some other bugs concerning missing cms_db_prefix\'es</p>
    <p>Dramatically reduced number of queries needed to gather statistics data.</p>
  </li>
  <li>
    <p>Version: 0.4.0</p>
    <p>Fixed showing of the counter. More 0.9.0-api-stuff.</p>
  </li>
  <li>
    <p>Version: 0.3.2</p>
    <p>Worked a bit on the tabbed showing of the stats</p>
  </li>
  <li>
    <p>Version: 0.3.1</p>
    <p>Ported to module-API 0.9.0</p>
  </li>
  <li>
    <p>Version: 0.2</p>
    <p>Now presenting statistics for days, weeks and online visitors. And gathering data about which countries a visitor comes from.</p>
  </li>
  <li>
    <p>Version: 0.1a</p>
    <p>Just fixed some ugly notices</p>
  </li>
  <li>
    <p>Version: 0.1</p>
    <p>Initial release - data is collected, but only summary is presented by now. The others will follow...</p>
  </li>
</ul>

