<?php
$lang['act_cachecleaned'] = 'Zwischenspeicher geleert';
$lang['add_row'] = 'Zeile hinzuf&uuml;gen';
$lang['alias'] = 'Alias ';
$lang['aliases'] = 'Aliase';
$lang['ask_clear_image_cache'] = 'Wollen Sie wirklich ALLE Dateien aus dem Zwischenspeicher entfernen?';
$lang['clear_all'] = 'Alle Dateien l&ouml;schen';
$lang['clear_now'] = 'Jetzt l&ouml;schen';
$lang['delete'] = 'L&ouml;schen';
$lang['embedding'] = 'Eingebettete Bilder';
$lang['embedding_mode'] = 'Bildeinbettungsmodus';
$lang['embed_sizelimit'] = 'Bilder einbetten bis maximal (kb)';
$lang['embed_types'] = 'Bilder des Typs einbetten';
$lang['error_alias_duplicatename_atrow'] = 'Den Alias-Namen, der f&uuml;r Alias in Zeile %d angegeben wurde, duplizieren.';
$lang['error_alias_noname_atrow'] = 'Kein Name f&uuml;r den Alias in Zeile %d angegeben.';
$lang['error_alias_nooptions_atrow'] = 'Keine Optionen f&uuml;r den Alias in Zeile %d angegeben.';
$lang['error_invalid_age'] = 'Alterseinstellung ung&uuml;ltig ... keine Aktion ausgef&uuml;hrt';
$lang['error_missingparam'] = 'Ein erforderlicher Parameter fehlt oder ist ung&uuml;ltig: %s';
$lang['error_invalidparam'] = 'Ung&uuml;ltiger Parameter in %s';
$lang['error_srcnotfound'] = 'Konnte Datei in %s nicht finden';
$lang['error_remotefile'] = 'Es gab ein Problem, die entfernte Datei in %s zu finden.';
$lang['error_unknownfilter'] = 'CGSmartImage &ndash; Unbekannter Filter: %s';
$lang['friendlyname'] = 'Calguys Smart-Image-Werkzeuge';
$lang['general'] = 'Allgemein';
$lang['help'] = '<h3>What Does This Do?</h3>
<p>This module provides a simple way to process, and display images on your web page.  It allows simple image processing, and watermarking.  This module makes displaying processed images on your website trivial.  It also provides features to improve the performance rating of your website, making your website powerful and fast at the same time.</p>
<h3>Features</h3>
<ul>
<li>Powerful, but simple to use image filtering and processing. Filtering includes:
  <ul>
    <li>Blur</li>
    <li>Brightness</li>
    <li>Colorize</li>
    <li>Contrast</li>
    <li>Crop</li>
    <li><strong>Crop To Fit</strong></li>
    <li>Edge Detection</li>
    <li>Emboss</li> 
    <li>Grayscale</li>
    <li>Mean Removal</li>
    <li>Negate</li>
    <li>Pixelate</li>
    <li>Resize</li>
    <li>Rotate</li>
    <li>Selictive Blur</li>
    <li>Smooth</li>
    <li>Watermark</li>
  </ul>
</li><br/>
<li>Smart detection of images.  Specify absolute URLS, absolute paths, or files relative to your root installation.</li>
<li>Automatic downloading, caching, processing, and re-caching of images from remote websites.</li>
<li>Smart automatic resizing (automatically resize to desired width and height before serving the image... resizing to width AND height does a crop to fit. <em>(just specify a width, and/or height parameter to the CGSmartImage tag.)</em></li>
<li>Automatically reads image EXIF information and corrects the orientation.</li>
<li>Image change detection, if the master image is changed scaled images will be regenerated. (see the notimecheck parameter to disable this behavior).</li>
<li>Smart attribute generation for images.</li>
<li>Processed images are cached on the server for faster serving.</lI>
<li>The ability to use a separate URL (CDN) for serving images</li>
<li>Image processes can be combined, and are executed in order.</li>
<li>Provides the ability to embed images directly into the content of the web page to minimize space.</li>
<li>Provides the ability to limit embedding images smartly, only to browsers that are capable of understanding them.</li>
<li>Combine commonly used arguments into named aliases.</li>
<li>Also works within stylesheets via the {cms_stylesheet} tag.</li>
<li>The ability to automatically process images inside a block of html code using the {cgsi_convert} block tag.</li>
<li>More...</li>
</ul>
<h3>Why should I use it?</h3>
<p>There are four very important reasons to use this plugin:</p>
<ul>
  <li>Performance:  Using image embedding (even if no other functions are used) results in fewer requests.  Most browsers only perform two to four simultaneous requests to the same domain at the same time.  For web pages with lots of images this can seriously slow down your site.</li>
  <li>Performance:  Even if not using embedding, sending large images to your visitors, and asking their browser to scale the image is very very slow.</li>
  <li>Security:  CGSmartImage caches its images in a separate directory, thereby hiding the original (perhaps copyrighted) images from your users.  If embedding is used they cant even find the cached location)</li>
  <li>Simplicity:  The filtering capabilities of CGSmartImage allow you to automatically process images for consistent and secure display, without site editors having to play with them.  They can upload larger images, and your site will just handle them properly.</li>
</ul>
<h3>How do I use it?</h3>
<p>The simplest way to use this module is to use it in the same place you would the {image} tag.  I.e: Something like <code style=&quot;color: blue;&quot;>{CGSmartImage src=&#039;uploads/images/picture.jpg&#039;}</code>.  This will generate the image tag for you with no processing.  And if possible, embed the image directly into your html output.</p>
<p>Often people want to display a watermark on the images that they display on the frontend to prevent image theft.  The CGExtensions module provides settings for you to configure watermarking and you can enable that with any image with a tag like this: <code style=&quot;color: blue;&quot;>{CGSmartImage src=&#039;uploads/images/picture.jpg&#039; filter_watermark=1}</code>.  This will read the image, apply the watermark according to the settings in CGExtensions, cache the altered image, and then embed it into your output.</p>
<p>Also, Pictures taken by modern digital cameras are often too large for use on a website, therefore they need to be scaled before displayed on your page.  This can be done quite easily with a tag like: <code style=&quot;color: blue;&quot;>{CGSmartImage src=&#039;uploads/images/picture.jpg&#039; filter_watermark=1 filter_resize=&#039;w,350&#039;}</code>.  As you may think, the watermark will be applied to the image before it is resized to a maximum width of 300 pixels (retaining aspect ratio).  Then the adjusted image will be cached, and if the browser allowes the image will be embedded into the HTML output.  If embedding is not possible, the img tag will contain the URL to the cached image.</p>
<p>From here you can combine the options below to perform alot of different effects to your images, build simple galleries, and improve your site performance at the same time.  Enjoy!</p>
<h3>Automatic image resizing</h3>
  <p>If you specify a width, and/or a height parameter, and do not specify the &amp;quot;noautoscale&amp;quot; parameter, the module will analyze the filters you have already specified, and if there is no resize filter already specified automatically add a filter to resize or croptofit the image on output.  This is useful to do automatic thumbnailing on the server, and not require the browser to resize the image.</p>
 <h3>A Simple Gallery</h3>
<p>The code below uses the {CGSmartImage} module, fancybox, and a bit of smarty magic to generate a simple lightbox style albom from a subdirectory on your website, while processing the images for web standards, and creating thumbnails.</p>
<pre style=&quot;background-color: #ddd; border: 1px solid black;&quot;><code><span style=&quot;color: red;&quot;> 1:</span> &amp;lt;script type=&quot;text/javascript&quot;&amp;gt;{literal}
<span style=&quot;color: red;&quot;> 2:</span> jQuery(document).ready(function(){
<span style=&quot;color: red;&quot;> 3:</span>  jQuery(&#039;a.fancybox&#039;).fancybox();
<span style=&quot;color: red;&quot;> 4:</span> });
<span style=&quot;color: red;&quot;> 5:</span> {/literal}&amp;lt;/script&amp;gt;
<span style=&quot;color: red;&quot;> 6:</span> {assign var=&#039;files&#039; value=&#039;uploads/album/*.jpg&#039;|glob}
<span style=&quot;color: red;&quot;> 7:</span> {if count($files)}
<span style=&quot;color: red;&quot;> 8:</span> &amp;lt;div style=&quot;width: 100%; height: 150px; overflow: auto;&quot;&amp;gt;
<span style=&quot;color: red;&quot;> 9:</span> {foreach from=$files item=&#039;file&#039;}
<span style=&quot;color: red;&quot;>10:</span>  &amp;lt;a rel=&#039;simple_album&#039; class=&quot;fancybox&quot; href=&quot;<span style=&quot;color: blue;&quot;>{CGSmartImage src=$file filter_rotate=90 filter_watermark=1 filter_resize=&#039;h,500&#039; notag=1 noembed=1}</span>&quot;&amp;gt;
<span style=&quot;color: red;&quot;>11:</span>  <span style=&quot;color: blue;&quot;>{CGSmartImage src=$file filter_rotate=90 filter_grayscale=1 filter_watermark=1 filter_resize=&#039;h,150&#039;}</span>
<span style=&quot;color: red;&quot;>12:</span>  &amp;lt;/a&amp;gt;
<span style=&quot;color: red;&quot;>13:</span> {/foreach}
<span style=&quot;color: red;&quot;>14:</span> &amp;lt;/div&amp;gt;
<span style=&quot;color: red;&quot;>15:</span> {/if}
</code></pre><br/>
<p>Lets talk about this.</p>
<p>Lines 1 through 5 utilize jQuery to call fancybox on any links that have the &amp;quot;fancybox&amp;quot; class.  The fancybox jQuery plugin is included with the JQueryTools module.</p>
<p>Line 6 uses a built in php function called glob, and some smarty magic to find all of the JPG files in the uploads/album directory below our installation root.</p>
<p>Line 7 is a test to see if any files were actually found in the assign line stated above.  This if statement is closed on line 15.</p>
<p>Line 8 opens up a div to contain our album.  For the purposes of this example the styles were included inline, however a class that was defined in the stylesheet should be used in production environments.  The closing tag for this div is on line 14, just before the <code>{/if}</code>.</p>
<p>Line 9 begins a loop through all of the files that we found in the directory.  This loop is closed on line 13.</p><br/>
<p>Lines 10 and 11 are the real magic.  Here we create a link with class &amp;quot;fancybox&amp;quot; and adds the <code>rel</code> attribute so that fancybox knows that all of these images should be grouped together as one album and allow clicking between the images.  Then comes the part where we define our images.
<p>We supply the $file variable to the src argument of the <code>{CGSmartImage}</code> tag so that it will get the name of each matched jpeg as the loop is executed.</p>
<p>The images I was testing with were uploaded from my ipod, and all seemed to be rotated 90 degrees counter clockeis.  So the first filter I added was to rotate the image 90 degrees clockwise via the <code>filter_rotate=90</code> argument. The images then needed to have the watermark on them <em>(this is just for example purposes, I dont think anybody would really steal the blurry pictures from my ipod for commercial purposes)</em>, so I added the <code>filter_watermark=1</code> parameter.  And finally, because even the ipod touch can take pictures that are too big to display on the screen I wanted to resize them to a maximum height of 500 pixels.  This was accomplished via the <code>filter_resize=h,500</code> argument.  We add the <code>noembed=1</code> argument because fancybox does not understand how to display embedded images in its popup window.  This defined the image that we were going to link to.</p>
<p>Next we needed to define the thumbnail image that we are going to use in the gallery.  This call to <code>{CGSmartImage}</code> is almost identical to the first call, except that we use a different height value (150 pixels) for the thumbnail, and for kicks I converted the thumbnail to grayscale <strong>before</strong> applying the watermark.  I also removed the noembed=1 argument so that the system could embed the image in the HTML output if the browser supported it.  The screen capture below shows the effect.</p>
<img src=&quot;data:image/jpeg;base64,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&quot; alt=&quot;Your browser does not support embedded images, sorry&quot;/>
<h3>Stylesheets:</h3>
<p>This module also works within stylesheets, if using the {cms_stylesheet} tag in your page template.  Because the smarty syntax is slightly different inside the {cms_stylesheet} tag you utilize the module using the [[ and ]] delimiters.  i.e: <code style=&quot;color: blue;&quot;>div.header { background: url([[CGSmartImage src=&#039;uploads/picture.jpg&#039; notag=1]]); }</code></p>
<p>Because stylesheets are generated on modification and stored in the filesystem there is no way to determine during the request which browser is requesting the stylesheet, therefore embedding will be done strictly based upon the presense of the noembed parameter.  If you have chosen to embed images directly into your stylesheets, You may need to add additional stylesheet support for the browsers that do not support embedded images.  i.e:  IE6.</p>
<h3>Automatic Processing</h3>
<p>This module includes a smarty block tag called <code style=&quot;color: blue;&quot;>{cgsi_convert}</code> that can surround a block of html, or other smarty tags to allow automatic image processing.  This tag can be used like: (for example):</p>
<pre><code style=&quot;color: blue;&quot;>{cgsi_convert}{content}{/cgsi_convert}</code></pre>
<p>This will allow your users to include images into pages using the normal wysiwyg tools, and to have them automatically processed and embedded into the page using the magic of {CGSmartImage}. i.e: See the following code:</p>
<pre><code style=&quot;color: blue;&quot;>{cgsi_convert filter_grayscale=1 filter_watermark=1}{content}{/cgsi_convert}</code></pre>
<p>The above code will capture all image tags, and convert them to grayscale and then apply the watermark (according to the settings in the CGExtensions module).  All of the pareters available to the <code style=&quot;color: blue;&quot;>{CGSmartImage}</code> tag are available to this tag (for image scaling etc.).  Additionally, two new parameters have been introduced: <strong>max_width</strong> and <strong>max_height</strong> which can be used to set a maximum size for images..</p>
<div style=&quot;margin-left: 3em;&quot;><strong style=&quot;color: red;&quot;>Note:</strong>
<p>This tag parses the HTML content between the start and end tags to find the <img> tags.  It then will output syntactically valid HTML for the subset of code it was provided.  Therefore it is important that the snippet of HTML passed to this tag be intact and as close to valid as possible.  <strong>Use with caution.</strong>
</div>
<h3>Support</h3>
<p>This module does not include commercial support. However, there are a number of resources available to help you with it:</p>
<ul>
<li>For the latest version of this module, FAQs, or to file a Bug Report or buy commercial support, please visit calguy&#039;s
module homepage at <a href="http://calguy1000.com">calguy1000.com</a>.</li>
<li>Additional discussion of this module may also be found in the <a href="http://forum.cmsmadesimple.org">CMS Made Simple Forums</a>.</li>
<li>The author, calguy1000, can often be found in the <a href="irc://irc.freenode.net/#cms">CMS IRC Channel</a>.</li>
<li>Lastly, you may have some success emailing the author directly.</li>  
</ul>
<h3>Requirements</h3>
<p>This module makes evtensive use of the GD Image processing library to do image manipulation.  Additionally, the {cgsi_convert} plugin makes extensive use of the simplexml and XMLDom classes built in to php.  There may be other additional requirements.  If you are experiencing errors you should ensure that error reporting is enabled, and that you have analyzed your error logs.</p>
<h3>Copyright and License</h3>
<p>Copyright &amp;copy; 2008, Robert Campbel <a href="mailto:calguy1000@cmsmadesimple.org">&amp;lt;calguy1000@cmsmadesimple.org&amp;gt;</a>. All Rights Are Reserved.</p>
<p>This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.</p>
<p>However, as a special exception to the GPL, this software is distributed
as an addon module to CMS Made Simple.  You may not use this software
in any Non GPL version of CMS Made simple, or in any version of CMS
Made simple that does not indicate clearly and obviously in its admin 
section that the site was built with CMS Made simple.</p>
<p>This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
Or read it <a href="http://www.gnu.org/licenses/licenses.html#GPL">online</a></p>';
$lang['info_aliases'] = 'Um zahlreiche und h&auml;ufig verwendete Optionen zu kombinieren k&ouml;nnen aliase von alias1 bis alias5 durch CGSmartImage Optionen verwendet werden.';
$lang['info_croptofit_default_loc'] = 'Standard richtung,  f&uuml;r &quot;crop to fit&quot;, dies wirkt sich auf alle &quot;crop to fit&quot; operationen aus, ausgenommen filter_croptofit Attribut &uuml;berschreibt es. Standard-Einstellung ist &quot;center&quot;.';
$lang['image_url_hascachedir'] = 'Z&auml;hlt die URL oben f&uuml;r das Zwischenspeicher-Verzeichnis (_CGSmartImage)';
$lang['image_url_prefix'] = 'Bild-URL-Pr&auml;fix';
$lang['info_cache_age'] = 'Maximales Alter einer Datei (in Tagen) bevor es entfernt und neu erzeugt wird. N&uuml;tzlich, wenn die Einstellungen ver&auml;ndert wurden oder um die Gr&ouml;&szlig;e des genutzten Speicherplatzes zu kontrollieren.';
$lang['info_embed_mode'] = 'This selection determines how the {smartimg} tag will generate output.  If &quot;none&quot; is selected no image embedding will be performed.  If &quot;smart&quot; is selected then the system will decide based on the image size, type, and the browser that is requesting the image.  Other options include always embedding based on the image size, or the image type.';
$lang['info_embed_sizelimit'] = 'Wenn die Option f&uuml;r Bild-Einbettung durch die Bildgr&ouml;&szlig;e bestimmt wird, geben Sie die maximale Gr&ouml;&szlig;e (in Kilobyte) f&uuml;r eingebettete Bilder an  (32 wird empfohlen).';
$lang['info_embed_types'] = 'Wenn die Option f&uuml;r Bild-Einbettung durch Bild-Typ bestimmt wird, geben Sie durch Komma getrennte Erweiterungen der Dateien an, die eingebettet werden sollen. Gro&szlig;-/Kleinschreibung wird nicht beachtet.';
$lang['info_image_url_hascachedir'] = 'Wenn Ihr CDN direkt auf das Zwischenspeicher-Verzeichnis verweist, k&ouml;nnte diese Optionen hilfreich sein.';
$lang['info_image_url_prefix'] = 'URL der Bilder. Standardm&auml;&szlig;ig ist dies die Upload-URL. Verwenden Sie ein CDN (oder mehrere Domains, die auf das selbe Verzeichnis verweisen) k&ouml;nnen Sie hier ein eine andere URL festlegen.';
$lang['max_cache_age'] = 'Maximales Alter der Dateien im Zwischenspeicher (Tage)';
$lang['moddescription'] = 'Ein Modul zur schlauen Erzeugung von Bildern f&uuml;r CMS Made Simple';
$lang['msg_aliases_updated'] = 'Aliase aktualisiert';
$lang['msg_cachecleaned'] = 'Zwischenspeicher geleert. %d Dateien entfernt.';
$lang['msg_cacheremoved'] = 'Zwischenspeicher entfernt';
$lang['msg_prefsupdated'] = 'Einstellungen aktualisiert';
$lang['none'] = 'Keiner';
$lang['options'] = 'Optionen';
$lang['param_alias'] = 'The CGSmartImage admin panel allows creating numerous command alias to combine a frequently used pattern of arguments into one name.  To use these aliases use an argument of the form alias##=alias_name i.e:  alias1=foo alias2=foo.';
$lang['param_alt'] = 'Used when creating an img tag, specify the value for the alt attribute.  Note, if this is not specified a value will be automatically calculated for this attribute so that most generated img tags will validate.  You can override this auto calculation with the &quot;noauto&quot; parameter';
$lang['param_class'] = 'Used when creating an img tag, allows specifying one or more classes to include on the tag.  i.e: class=&quot;fancybox thumbnail&quot;';
$lang['param_filter_blur'] = '(irgendwas) Geben Sie einen beliebigen Wert ein f&uuml;r diesen Parameter zum Hinzuf&uuml;gen eines Weichzeichnungsfilter auf das Bild';
$lang['param_filter_brightness'] = '(Ganzzahl) Erh&ouml;hen Sie die Helligkeit des bearbeiteten Bildes durch den angegeben Ganzzahl-Wert';
$lang['param_filter_colorize'] = '(r,g,b[,alpha]) - Wie filter_greyscale, jedoch k&ouml;nnen Sie die Farbe und den Alpha-Wert bestimmen';
$lang['param_filter_contrast'] = '(Ganzzahl) Ver&auml;ndert den Konstrast des Bildes um die angegebene Ganzzahl';
$lang['param_filter_crop'] = '(percent[,h_align,v_align]) - Perform cropping on the image specified. Crop parameeters are specified as a comma separated list of parameters.  The first (required) value is an integer percentage of the original image size.  The optional second and third parameters are one of l,c,r (left,center,right) and t,c,b (top,center,bottom) specifying where the location within the source image to crop from.  i.e: crop=33,b,r to grab a crop of 33% from the bottom right of the source image.';
$lang['param_filter_croptofit'] = '(width,height) - Perform a croptofit on the image specified. This attempts to rescale the image to the destination size while reatining aspect ratio, then focus on the center of the resized image.  Crop to fit parameters are specified as the desired width and height for the destination image.';
$lang['param_filter_edgedetect'] = '(irgendwas) Kanten im Bild hervorheben.';
$lang['param_filter_emboss'] = '(irgendwas) Bild pr&auml;gen';
$lang['param_filter_flip'] = '(mode) - F&uuml;hrt eine Drehung auf dem angegebenen Bild. Geben Sie 0 f&uuml;r horizontale, 1 f&uuml;r vertikale und 2 f&uuml;r Drehung in beide Richtungen.';
$lang['param_filter_grayscale'] = '(anything) Bild in Graustufen umwandeln';
$lang['param_filter_meanremoval'] = '(anything) Versucht einen &quot;gezeichnet&quot;-Effekt';
$lang['param_filter_negate'] = '(anything) Bild ins Negativ umkehren';
$lang['param_filter_pixelate'] = '(size[,advanced]) Pixelate the image, specify an integer size and an optional boolean (default is false) to enable advanced pixelation';
$lang['param_filter_resize'] = 'type,number[,number] - Perform a resize of the source image.  Possible values are:
<ul>
  <li>p,number - Perform a simple rescale to a certain percentage.  i.e:  resize=p,50 to resize to 50% of the original size.</li>
  <li>w,number - Perform a resize to a specified width (while retaining aspect ratio). i.e: resize=w,80 to create a thumbnail with a maximum width of 80 pixels.</li>
  <li>h,number - Perform a resize to a specified height (while retaining aspect ratio). i.e: resize=h,80 to create a thumbnail with a maximum height of 80 pixels.</li>
  <li>c,x,y - Perform a resize to a custom size (without retaining aspect ratio).  i.e: resize=c,50,75 to create a thumbnail that is 50x75 pixels.</li>
</ul>';
$lang['param_filter_resizetofit'] = '(width,height[,color[,alpha]]) - Perform a resize on the image specified. This attempts to rescale the image to the destination size while reatining aspect ratio, the image is centered in the box specified (either horizontally or vertically depending upon aspect ratio and the destination size, and the image is surrounded by the supplied color.  Colors can be specified by name (see the X11 color names), or by #nnnnnn hexadecimal format, or as rgb values separated by a : i.e:  filter_croptofit=600,400,#ff0000.  The special color value &quot;transparent&quot; can be specified to force the background to be transparent.   An alpha value may be specified between 0 and 127 to specify different degrees of translucency for the background.   At no time will this plugin perform any upscaling.';
$lang['param_filter_rotate'] = '(angle,color) Specify the integer angle (counter clockwise) to rotate the image, and a color to fill the empty pixels with.  The image is rotated about its center.';
$lang['param_filter_roundedcorners'] = '(radius) einen ganzzahligen Radius (in Pixeln) zum Abrunden der Ecken angeben';
$lang['param_filter_watermark'] = '(irgendwas) Wasserzeichen (wie in den Einstellungen von CGExtensions definiert) auf das Bild anwenden';
$lang['param_height'] = 'Used when creating an img tag, specify the value for the height attribute.  Note, if this is not specified a value will be automatically calculated for this attribute so that most generated img tags will validate.  You can override this auto calculation with the &quot;noauto&quot; parameter';
$lang['param_id'] = 'Used when creating an img tag, allows specifying an id attribute to include on the tag.  i.e: id=&quot;sometag&quot;';
$lang['param_max_height'] = 'Wird nur f&uuml;r {cgsi_convert} tag verwendet. Dieser Parameter erm&ouml;glicht die Angabe einer maximalen H&ouml;he f&uuml;r die konvertierten Bilder';
$lang['param_max_width'] = 'Wird nur f&uuml;r {cgsi_convert} tag verwendet. Dieser Parameter erm&ouml;glicht die Angabe einer maximalen Breite f&uuml;r die konvertierten Bilder';
$lang['param_name'] = 'Verwendet bei der Erstellung eines img-Tags, geben Sie den Wert f&uuml;r das name Attribut.';
$lang['param_noauto'] = 'Attribute f&uuml;r das img-Tag nicht automatisch berechnet. Dies k&ouml;nnte dazu f&uuml;hren, dass Ihre Seite nicht mehr validiert, wenn verpflichtende Attribute (width, height, alt) nicht angegeben sind.';
$lang['param_noautoscale'] = 'wenn Breite und H&ouml;he Parameter angegeben werden, wird dieser Parameter die automatische Skalierung des Bildes deaktivieren.';
$lang['param_nobcache'] = 'Do not allow the resized image to cache in the browser (useful for development purposes) this adds a unique number as a parameter to the image which will force the browser not to cache the image.';
$lang['param_noembed'] = 'Force the image to not embed.  Regardless of settings in the admin panel, the URL and tag generated will be to a file on the server.  No embedding will be performed';
$lang['param_notimecheck'] = 'Zeit&uuml;berpr&uuml;fung der zwischengespeicherten Dateien deaktivieren.';
$lang['param_noremote'] = 'Aufruf von extrenen URL&#039;s nicht erlauben';
$lang['param_norotate'] = 'Exif Information der Datei nicht auslesen und Bilrotation nicht korrigieren';
$lang['param_notag'] = 'Kein img-Tag ausgeben, nur die URL zum Bild. Kein Effekt, wenn CGSmartImages in einem Stylesheet verwendet wird.';
$lang['param_overwrite'] = 'Zwischenspeicher deaktivieren und Neuberechnung aller Filter erzwingen';
$lang['param_quality'] = 'Qualit&auml;t des Bildes. Ein Wert zwischen 0 und 100. Die Voreinstellung ist 75.';
$lang['param_rel'] = 'Used when building an image tag allows specifying an optional rel attribute (typically used with javascript type albums). i.e: rel=&quot;album&quot;';
$lang['param_silent'] = 'Fehler still ignorieren';
$lang['param_src'] = 'Specify the source for the image processing (if any) or the generated img tag.  Note, this parameter is flexible, and the module will attempt many methods to find the source image file on the web server as follows:
<ul>
  <li>First look to see if the specified src value exists as a file on the filesystem.</li>
  <li>Next, check if the value specified for the src parameter is a URL and begins with the uploads_url (as specified in the config.php)</li>
  <li>Next, check if the value specified for the src parameter is a URL and begins with the root_url (as specified in the config.php)</li>
  <li>Next, check if the value specified for the src parameter is a URL and begins with the ssl_url (as specified in the config.php)</li>
</ul>';
$lang['param_style'] = 'Used when creating an img tag, allows specifying alternate styles for the tag.  i.e: style=&quot;border: 1px solid black;&quot;';
$lang['param_title'] = 'Titel-Attribut f&uuml;r das img-Tag (optional), z. B. <code>title=&quot;Dies ist der Tooltip&quot;</code>';
$lang['param_width'] = 'Used when creating an img tag, specify the value for the width attribute.  Note, if this is not specified a value will be automatically calculated for this attribute so that most generated img tags will validate.  You can override this auto calculation with the &quot;noauto&quot; parameter';
$lang['postinstall'] = 'Modul wurde installiert';
$lang['postuninstall'] = 'Alle Daten dieses Moduls wurden entfernt.';
$lang['prompt_croptofit_default_loc'] = 'Standardbereich f&uuml;r &bdquo;Beschneiden und Anpassen&ldquo;';
$lang['prompt_embed_sizelimit'] = 'Basierend auf Bildgr&ouml;&szlig;e';
$lang['prompt_embed_smartlimited'] = 'Smart-Modus, aber Bildgr&ouml;&szlig;e beschr&auml;nken';
$lang['prompt_embed_type'] = 'Bildtyp-basierend';
$lang['prompt_loc_bottomleft'] = 'unten links';
$lang['prompt_loc_bottomcenter'] = 'unten mittig';
$lang['prompt_loc_bottomright'] = 'unten rechts';
$lang['prompt_loc_centerleft'] = 'mittig links';
$lang['prompt_loc_center'] = 'mittig';
$lang['prompt_loc_centerright'] = 'mittig rechts';
$lang['prompt_loc_topleft'] = 'oben links';
$lang['prompt_loc_topcenter'] = 'oben mittig';
$lang['prompt_loc_topright'] = 'oben rechts';
$lang['resizing'] = 'Gr&ouml;&szlig;en&auml;nderung';
$lang['smart'] = 'automatisch';
$lang['submit'] = 'Absenden';
$lang['utma'] = '156861353.326700450.1373827367.1373827367.1373827367.1';
$lang['utmc'] = '156861353';
$lang['utmz'] = '156861353.1373827367.1.1.utmccn=(direct)|utmcsr=(direct)|utmcmd=(none)';
$lang['utmb'] = '156861353';
?>