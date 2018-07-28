<li>Version 1.0. 6 August 2005. Initial Release.</li>
<li>Version 2.0. September 2005. Initial Release for 0.1..</li>
<li>Version 2.0.1. September 2005. Display sample banner in the edit banner page, added name= parameter, and made subnet exclusions work.  Also changed the definition of the database to allow for additional text in the link and image tags.</li>
<li>Version 2.0.2. September 2005. Added integration with the uploads module (1.0.6) so that we can get lits of files for banners, etc.  The banners module is still optional though.</li>
<li>Version 2.0.3. September 2005. Fixed a very minor issue with never expires..</li>
<li>Version 2.0.4. September 2005. Fixed a very minor issue with module dependencies, and a big bug in the database spec if you did a scratch install.</li>
<li>Version 2.0.5. October 2005. Add coments around the output</li>
<li>Version 2.0.6. December 2005. Minor validation fixes, description is now output between the <img>and</img> tags, and an alt attribute is in the img tag.</li>
<li>Version 2.0.7. January 2006. More validation fixes, Moved the admin tabs around, fixed an issue where you could almost create a banner without defining a category, and... fixed the expiry date issue for good (hopefully).</li>
<li>Version 2.1.0. August 2006. Prepared for 1.0 compatibility, split into multiple files, used references where possible, improved messages, and a general cleanup.</li>
<li>Version 2.2. March 2008.
    <p>The first release in a long while this fixes issues with the date fields, and the expiry date.  Also integrates changes so that the active tab is maintaned (DeeEye) and changes the license.</p>
    <p>Now require CMS 1.2.3 or greater</p>
</li>
<li>Version 2.2.1. April 2008.
    <p>Minor fixes.</p>
</li>
<li>Version 2.2.3. April 2009.
    <p>Remove the width and height parameters, add a start date, and now use templates... major overhaul.</p>
</li>
<li>Version 2.3 - September 2009.
  <ul>
    <li>Major cleanup of code</li>
    <li>Get rid of the never expire stuff... people can just use a really long date.</li>
    <li>Dont ask for input of times any more... just use days</li>
    <li>Fixed to work with newest version of uploads, if it can be found.</li>
    <li>Now depends on CGExtensions</li>
    <li>Adds the banner list action.</li>
  </ul>
</li>
<li>Version 2.3.1 - September 2009.
  <ul>
    <li>Bug Fixes.</li>
  </ul>
</li>
<li>Version 2.3.2 - October 2009.
  <ul>
    <li>Minor Bug Fixes.</li>
  </ul>
</li>
<li>Version 2.3.6 - August 2010.
  <ul>
    <li>Adds a last_impression field.. and made mode=sequential listen to that.</li>
  </ul>
</li>
<li>Version 2.3.7 - February, 2011
  <ul>
    <li>Adds pretty url support to grab a banner from other apps or via javascript.</li>
  </ul>
</li>
<li>Version 2.4 - February, 2011
  <ul>
    <li>Adds the ability to exclude bots from impression counting.</li>
  </ul>
</li>
<li>Version 2.5 - March, 2011
  <ul>
    <li>Adds reporting options.</li>
  </ul>
</li>
<li>Version 2.5.1 - March, 2011
  <ul>
    <li>Minor fix to $module->smarty->assign() calls, though I dont know why it doesnt work for some I fixed it anyways.</li>
  </ul>
</li>
<li>Version 2.5.3 - July, 2012
  <ul>
    <li>Moved help to external file.</li>
    <li>Added admin lazy loading.</li>
    <li>Fixes to notices in templates.</li>
    <li>Bumped minimum CMS version.</li>
  </ul>
</li>
<li>Version 2.6.1
  <ul>
    <li>Fixes for CMSMS 2.0</li>
    <li>Bump Dependencies</li>
    <li>Minor cleanups.</li>
  </ul>
</li>
<li>Version 2.7
  <ul>
  <li>Removes all reference to the uploads module.  :: This may cause a compatibility problem.</li>
  <li>Code cleanup.</li>
  <li>Report now uses CGEXtensions report utilities.</li>
  <li>Rewrite some display templates to be shorter. :: There may be a compatibility problem here.</li>
  </ul>
</li>
<li>Version 2.7.1
  <ul>
    <li>Begins introducing smarty scope stuff (not complete).</li>
    <li>Minor bug fix.</li>
  </ul>
</lI>
<li>Version 2.7.2
  <ul>
    <li>Tweaks to the list mode.</li>
    <li>Documentation improvements.</li>
  </ul>
</lI>
<li>Version 2.7.6
  <p>Minor bug fixes.</p>
</li>
<li>Version 2.8
	<p>Adds integration with JMFilePicker if it is available.</p>
	<p>Minor fixes.</p>
</li>
<li>Version 2.9
	<p>Adds alternate templates, and optional counting to list view.</p>
	<p>List view now uses smarty scope.</p>
	<p>Minor code cleanup.</p>
	<p>Minor fixes.</p>
</li>
<li>Version 2.10
   <p>Now requires CMSMS 2.2.2</p>
   <p>Get rid of JMFilePicker stuff.</p>
   <p>Now use {cms_filepicker}</p>
   <p>Clean up a couple of templates.</p>
</li>

</ul>
