<ul>
  <li>Version 1.0 - Initial Release</li>
  <li>Version 1.0.1 - Bug fixes.</li>
  <li>Version 1.0.2 - Bug fixes.</li>
  <li>Version 1.0.3 - Bug fixes.</li>
  <li>Version 1.1 - March 2011
    <ul>
      <li>Adds the croptofit filter.</li>
      <li>Adds automatic image resizing.</li>
    </ul>
  </li>
  <li>Version 1.1.1 - March 2011
    <ul>
      <li>Fixes to croptofit.</li>
    </ul>
  </li>
  <li>Version 1.1.1 - May 2011
    <ul>
      <li>Fixes to GIF image handling.</li>
      <li>Add a bit more intelligence into image src handling.</li>
    </ul>
  </li>
  <li>Version 1.1.2 - May 2011
    <ul>
      <li>Many minor bug fixes.</li>
    </ul>
  </li>
  <li>Version 1.2 - May 2011
    <ul>
      <li>Adds rounded image corner support... with transparency.</li>
    </ul>
  </li>
  <li>Version 1.2.1 - May 2011
    <ul>
    <li>Fixes problems with IE7 and embedding (IE7 wont embed, as much as I try to make it).</li>
    <li>Requires new version of CGExtensions that does crude hack for mime type detection on windoze servers.</li>
    </ul>
  </li>
  <li>
  </li>Version 1.3 - May 2011
  <li>
    <ul>
    <li>Adds support for jpeg auto-rotation via EXIF.</li>
    <li>Adds a flip filter.</li>
    <li>Adds command aliases.</li>
    <li>Adds support for multiple src## arguments.</li>
    </ul>
  </li>
  </li>Version 1.3.1 - May 2011
  <li>
    <ul>
    <li>Supress a warning.</li>
    </ul>
  </li>
  </li>Version 1.4 - July 2011
  <li>
    <ul>
    <li>Adds the {cgsi_convert} tag.</li>
    </ul>
  </li>
  </li>Version 1.4.1 - July 2011
  <li>
    <ul>
    <li>Address an issue with the CMS_STYLESHEET global occassionally being set, which results in the notag stuff messing up.</li>
    </ul>
  </li>
  </li>Version 1.4.2 - July 2011
  <li>
    <ul>
    <li>Minor bug fixes.</li>
    </ul>
  </li>
  <li>Version 1.5 - August 2011
    <ul>
    <li>Minor Bug Fixes.</li>
    <li>Fixes issues with cgsi_convert.</li>
    <li>Adds documentation for the title, rel, and id parameters.</li>
    <li>Adds the ability to download images from a remote site, cache them.. and process them.</li>
    </ul>
  </li>
  <li>Version 1.5.1 - September, 2011
    <ul>
      <li>Minor bug fixes.</li>
    </ul>
  </li>
  <li>Version 1.6 - October, 2011
    <ul>
      <li>Adds the ability to specify a crop-to-fit location other than center.</li>
      <li>Adds a preference for the default crop-to-fit location, but changing this will not generate new images... you will need to clear your generated image files.</li>
      <li>crop-to-fit filter now checks for possible upscaling and will not allow it.</li>
      <li>rename the nocache parameter to nobcache to remove conflict with CGExtensions.</li>
      <li>Fixes a bug with multiple class names specified in aliases.</li>
      <li>Fixes a bug in the resize filter.</li>
      <li>Fixes a bug where if nothing happened in an image filter (due to constraints) the system would not safe the file.</li>
      <li>Adds a resizetofit filter.</li>
      <li>Generated files no longer have an extension to prevent inconsistencies in file types.</li>
    </ul>
  </li>
  <li>Version 1.6.1 - November, 2011
    <ul>
      <li>Minor fixes to cgsi_convert.</li>
    </ul>
  </li>
  <li>Version 1.7 - February, 2012
    <ul>
      <li>Adds the ability to check the time of the source image to aide in deciding if the cached image needs to be generated/re-generated.</li>
      <li>Fixes to the resize filter.</li>
      <li>Resample instad of resize by default in the resize filter.</li>
      <li>Create an index.html file in the image directory to prevent browsing.</li>
    </ul>
  </li>
  <li>Version 1.8.1 - February, 2012
    <ul>
      <li>Adds the silent param to hide errors.</li>
      <li>Adds resize to largest edge to filter_resize.</li>
      <li>Removes lazyloading so that {cgsi_converT} will work.</li>
      <li>some minor fixes.</li>
    </ul>
  </li>
 <li>Version 1.8.4 - May, 2012
    <ul>
      <li>Fixes to cgsi_convert.</li>
      <li>Removes the color parameter from filter_rotate.</li>
      <li>Fixes warnings.</li>
      <li>Code cleanup.</li>
    </ul>
 </li>
 <li>Version 1.9 - May 2012
   <ul>
     <li>Adds responsive image capabilities with web service based mobile device detection.</li>
     <li>Improves path detection.</li>
   </ul>
 </li>
 <li>Version 1.10 - Jan 2013
   <ul>
      <li>Adds reflection filter (thanks to Tapio)... note only works well with jpeg images</li>
   </ul>
 </li>
 <li>Version 1.11 - July 2013
   <ul>
      <li>Minor documentation fix.  Files provided via the src argument must be below the CMSMS root URL.</li>
      <li>Adds a simple sharpen filter.</li>
      <li>Adds simple memory limit checking (will work for hosts where we can ini_get the memory limit.</li>
      <li>Numerous improvements to the resizetoFit filter.</li>
      <li>Fixes cached filenames to be entirely encoded.</li>
      <li>Fixes alt value for image tags.</li>
      <li>Now uses a single last filter... not multiple.</li>
      <li>Rationalize behavior between max_width/max_height and width/height.
        <p>Now, if max_width/max_height is specified via the parameter, or by device detection, AND the height/width parameters are specified, the smaller of these two pairs of values will be used, and a single filter applied.  The noauto parameter can still be used to ensure that the img tag (if generated) has the specified with and height parameters.</p>
      </li>
      <li>Minor bug fixes.</li>
   </ul>
 </li>
 <li>Version 1.12 - August 2013
   <ul>
     <li>Get rid of filename extensions completely.</li>
     <li>Now use exceptions alot more than error status (allows cleaning up code).</li>
     <li>Adds the filter_##_name syntax which allows calling the same filter multiple times.</li>
     <li>Adds a simple transparency filter.</li>
     <li>Adds a simple untransparent filter.</li>
     <li>Rewrites the rounded corners filter.</li>
     <li>Rewrites the resize to fit filter (again).</li>
     <li>Rewrites the rotate filter.</li>
     <li>Fixes problems with empty cache path</li>
     <li>alt attribute is now allowed to be empty.</li>
   </ul>
 </li>
 <li>Version 1.13 - October 2013
   <ul>
    <li>Adds a preference for memory checking.</li>
    <li>Change to the memory needed calculation.</li>
    <li>Bug fixes.</li>
   </ul>
 </li>
 <li>Version 1.14 - October 2013
   <ul>
    <li>Adds a preference for extension handling.</li>
    <li>Adds the force_ext and force_type parameters.</li>
   </ul>
 </li>
 <li>Version 1.15 - December 2013
   <ul>
    <li>Adds crop2size filter.</li>
    <li>Minor fixes to croptofit filter.</li>
    <li>Minor fixes to resize filter wrt transparent PNG images</li>
   </ul>
 </li>
 <li>Version 1.16 - March 2014
   <ul>
     <li>Adds {cgsi_getimages} plugin.</li>
     <li>Cleanup temporary resources.</li>
   </ul>
 </li>
 <li>Version 1.16.1 - April 2014
   <ul>
	<li>Fixes issue with caching and DeviceAtlas requests.</li>
	<li>Now cache deviceAtlas requests for 14 days instead of 7</li>
	<li>more auditing</li>
	<li>Fixes minor problem with filter_resize and filter_watermark.</li>
   </ul>
 </li>
 <li>Version 1.17 - August 2014
   <ul>
        <li>Optimizations in the event that connections to the remote server for device characteristics fail.</li>
	<li>Adds the option to save JPEG's as progressive.</li>
	<li>Turn off responsive images by default (since DeviceAtlas seems to have shut down their service)</li>
	<li>Minor improvements to the sharpen filter.</li>
   </ul>
 </li>
 <li>Version 1.17.1 - November 2014
   <ul>
     <li>Minor bugfixes.</li>
   </ul>
 </li>
 <li>Version 1.17.2 - January 2015
   <ul>
     <li>Watermarking class now uses CGExtensions watermark class.</li>
     <li>Minor bugfixes.</li>
   </ul>
	</li>
  <li>Version 1.18 - April 2015
	<ul>
        <li>Bug fixes wrt {cgsi_convert} (actually mostly done in CGExtensions).</li>
	<li>Bug fixes wrt smart, size limited embedding.</li>
	<li>Bug fixes wrt cache prefixes.</li>
	<li>Adds noop filter.</li>
	</ul>
  </li>
  <li>Version 1.19
	<ul>
	<li>Replace responsive image functionality with new functionality.   the {CGSmartImage action=responsive} now outputs functionality to send device characteristics to the server ala the mustard-cut technique (if cookie does not exist, set cookie and reload).</li>
	</ul>
  </li>
  <li>Version 1.20
	<ul>
	<li><strong>Important</strong> rationalize the autoscaling functionality.   If autoscaling is enabled (the default) or device capabilties are detected, now ensure that the image will always be adjusted to fit the smallest resolution specified, and always maintain aspect ratio.</li>
	<li>Clean up rationalization of width/height, max_width/max_height stuff.</li>
	<li>Add the assume responsive preference to optimize performance on mobile-first sites.</li>
	<li>Add the autoscale_op preference to indicate what filter to call when doing auto scaling</li>
	<li>Adds the ability to output images specifically for devices with a higher dpr (device pixel ratio).</li>
	<lI>Adds the nodpradjust parameter to disable adjusting output for devices with a higher device pixel ratio.</li>
	<li>Adjust the watermark filter so that text can optionally be provided.  i.e:  filter_watermark="some text".  Read the help for this parameter for further info.</li>
	</ul>
  </li>
  <li>Version 1.20.5
    <ul>
      <li>Fixes to responsive breakpoints.</li>
      <li>Fixes for resize filter.</li>
      <li>Fixes for relative path issues.</li>
      <li>Improvements to the template for the responsive action.</li>
    </ul>
  </li>
  <li>Version 1.21
    <ul>
      <li>Adds the ability to auto-resize, watermark and rotate images in the background.  Requires CMSMS 2.1 and the CGMessageQueue module.</li>
      <li>Minor improvements to cgsi_utils</li>
    </ul>
  </li>
<li>Version 1.21.2
   <ul>
   <li>Minor bug fixes.</li>
   </ul>
</li>
<li>Version 1.21.4
   <ul>
   <li>Fix to {cgsi_convert} block tag so that empty nodes that cannot be empty are not empty.  Use a hardcoded list.</li>
   </ul>
</li>
<li>Version 1.21.5
   <ul>
   <li>Fix to {cgsi_convert} block tag when there is no image scaling/rework required and source size is equal to destination size.</li>
   </ul>
</li>
<li>Version 1.21.9
  <ul>
    <li>Fix to the autoscale_op stuff.</ul>
  </ul>
</li>
<li>Version 1.22
  <ul>
    <li>Change auto processing to use the CmsJobManager instead of CGMessageQueue.</li>
  </ul>
</li>
</ul>
