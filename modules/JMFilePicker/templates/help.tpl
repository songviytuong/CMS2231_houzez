<div class="clear"></div>
<div id="page_tabs">
  <div id="general">
      What is it
  </div>    
  <div id="designers">
    For Designers
  </div>
  <div id="developers">
    For Developers
  </div>
{*    
  <div id="whatsnew">
     {$mod->ModLang('whatsnew')}
  </div>   
  *}  
  <div id="about">
     About
  </div>
</div>
<div class="clearb"></div>
<div id="page_content">
  <div id="general_c">
    <h3>What does this do?</h3>
    <p>This module provides a filepicker to module developers as well as webdesigners.</p>
    <h3>How is it used?</h3>
    <p>After installation the module settings can be found in "Extensions > JMFilePicker".</p>
  </div>    
  <div id="designers_c">
   <p><strong>For designers:</strong></p>
    <p>You can use this module in conjunction with the {literal}{content_module}{/literal} tag of the CMSms core.<br />
    Just place this in your template to get an additional content block that shows a filepicker in backend when editing the page:</p>
    <pre><code>{literal}{content_module block="filepicker_block" module="JMFilePicker"}{/literal}</code></pre>
    <h3>What parameters are available?</h3>
    <p>All params are optional and can be used with {literal}{content_module}{/literal} tag as well with the api function. <br />
    Notice that some params will have no effect if you are the admin. That means the admin has always any permissions.<br />E.g: you cannot deny filemanagement or image resizing on upload to the admin but only to other users.</p>
    <ul>
      <li>
        <tt>media_type</tt> <em>(file,image)</em>
        <ul>
          <li>Allows you to specify what media type is displayed. (supports only images and all files at the moment)</li>
        </ul>
        <br />
      </li>
      <li>
        <tt>mode</tt> (browser/dropdown)
        <ul>
          <li>
            By default a dropdown will be used. Set to "browser" if user may browse the files.<br />
            <code>{literal}{content_module module="JMFilePicker" block="some_image" mode="browser"}{/literal}</code>
          </li>
        </ul>
        <br />
      </li>
      <li>
        <tt>dir</tt> (string)
        <ul>
          <li>
            The name of a directory (relative to the uploads directory from which to select images/files. If not specified, the uploads directory will be used.<br />
            E.g.: This will display the dir "[your uploads dir]/images/".<br />
            <code>{literal}{content_module module="JMFilePicker" block="some_image" dir="images"}{/literal}</code>
          </li>
        </ul>
        <br />
      </li>
      <li>
        <tt>show_subdirs</tt> (true/false)
        <ul>
          <li>
            Set to true if user may browse subdirectories. (mode="browser" only)<br />
            E.g.: <code>{literal}{content_module module="JMFilePicker" block="some_file" media_type="file" show_subdirs="true"}{/literal}</code><br />
            <em><strong>Note:</strong> This param will be ignored if the user belongs to the admin group.<br /></em>
          </li>
        </ul>
        <br />
      </li>
      <li>
        <tt>upload</tt> (true/false)
        <ul>
          <li>
            Set to true if user may upload files.<br />
            Set to false to deny upload.<br />
            <em><strong>Note:</strong> By default this param depends on the user permission "Modify Files".<br />
            If set to true you can grant upload of files to certain blocks even to users without apropriate permission.<br />
            Vise versa you can deny file upload even to users with "Modify Files" permission.<br />
            This only works if the module setting "Show filemanagement options" is set.<br /></em>
          </li>
        </ul>
        <br />
      </li>
      <li>
        <tt>delete</tt> (true/false)
        <ul>
          <li>
            Set to true if user may delete files.<br />
            Set to false to deny deleting files.<br />
            <em><strong>Note:</strong> By default this param depends on the user permission "Modify Files".<br />
            If set to true you can grant deleting files or directories to certain blocks even to users without apropriate permission.<br />
            Vise versa you can deny deleting anything even to users with "Modify Files" permission.<br />
            This only works if the module setting "Show filemanagement options" is set.<br /></em>
          </li>
        </ul>
        <br />
      </li>
      <li>
        <tt>create_dirs</tt> (true/false)
        <ul>
          <li>
            Set to true if users may create directories.<br />
            Set to false to deny directory creation.<br />
            <em><strong>Note:</strong> By default this param depends on the user permission "Modify Files".<br />
            If set to true you can grant creation of directories to certain blocks even to users without apropriate permission.<br />
            Vise versa you can deny directory creation even to users with "Modify Files" permission.<br />
            This only works if the module setting "Show filemanagement options" is set.<br />
            If you want to allow to create directories to non-admin users you need to set show_subdirs=true.</em>
          </li>
        </ul>
        <br />
      </li>
      <li>
        <tt>lock_input</tt> (true/false)
        <ul>
          <li>
            Set to false if user may enter the file path in the file input (block_type="file" only)<br />
            By default this is always true if the user is no admin.
            <em><strong>Note:</strong> This param will be ignored if the user belongs to the admin group.<br /></em>
          </li>
        </ul>
        <br />
      </li>
      <li>
        <tt>exclude_prefix</tt> (string)
        <ul>
          <li>
            A comma separated list of prefixes to exclude files that starts with the set prefix.<br/>
          </li>
        </ul>
        <br />
      </li>
      <li>
        <tt>include_prefix</tt> (string)
        <ul>
          <li>
            A comma separated list of prefixes to show only files that starts with the set prefix.<br/>
          </li>
        </ul>
        <br />
      </li>
      <li>
        <tt>exclude_sufix</tt> (string)
        <ul>
          <li>
            A comma separated list of sufixes to exclude files that ends with the set sufix.<br/>
          </li>
        </ul>
        <br />
      </li>
      <li>
        <tt>include_sufix</tt> (string)
        <ul>
          <li>
            A comma separated list of sufixes to show only files that ends with the set sufix.<br/>
          </li>
        </ul>
        <br />
      </li>
      <li>
        <tt>file_extensions</tt> (string)
        <ul>
          <li>A comma separated list of allowed file extensions of files to display (excluding the dot)</li>
        </ul>
        <br />
      </li>
      <li>
        <tt>restrict_users_diraccess</tt> (true/false)
        <ul>
          <li>Usually this is a preference that can be set up in the modules admin panel. It grants access only to a directory that is named like the username.<br />
            Let's assume the username is Foo. So the module looks for a dir in "[your uploads dir]/Foo/".<br />
            If it does not exist it will be created. If set to true everything will be relative to the username dir. <br />
            That means this example will look for images in "[your uploads dir]/Foo/images/":<br />
            <code>{literal}{content_module module="JMFilePicker" block="some_image" dir="images" restrict_users_diraccess=true}{/literal}</code><br />
            With this param you can override this setting to specify certain preferences for each block individually.<br />
            <em><strong>Note:</strong> This has no effect if you are admin.</em>
          </li>
        </ul>
        <br />
      </li>
      <li>
        <tt>allow_none</tt> (true/false)
        <ul>
          <li>
            This is for mode dropdown only. If set to false there is no "none" option in the dropdown.<br />
            <em><strong>Note:</strong> This has no effect if you are admin.</em>
          </li>
        </ul>
        <br />
      </li>
      <li>
        <tt>allow_scaling</tt> (true/false)
        <ul>
          <li>Usually this is a preference that can be set up in the modules admin panel. It specifies if images may be resized on upload.<br />
            With this param you can override this setting to specify certain preferences for each block individually.<br />
            <em><strong>Note:</strong> This has no effect if you are admin.</em>
          </li>
        </ul>
        <br />
      </li>
      <li>
        <tt>force_scaling</tt> (true/false)
        <ul>
          <li>Usually this is a preference that can be set up in the modules admin panel. <br />
            If set images will be resized to a given size if user may not resize images.<br />
            With this param you can override this setting to specify certain preferences for each block individually.<br />
            <em><strong>Note:</strong> This has no effect if you are admin.</em>
          </li>
        </ul>
        <br />
      </li>
      <li>
        <tt>scaling_width</tt> (int)
        <ul>
          <li>Usually this is a preference that can be set up in the modules admin panel. It specifies the default image width to resize an image to on upload.<br />
            With this param you can override this setting to specify certain preferences for each block individually.
          </li>
        </ul>
        <br />
      </li>
      <li>
        <tt>scaling_height</tt> (int)
        <ul>
          <li>Usually this is a preference that can be set up in the modules admin panel. It specifies the default image height to resize an image to on upload.<br />
            With this param you can override this setting to specify certain preferences for each block individually.
          </li>
        </ul>
        <br />
      </li>
      <li>
        <tt>allow_upscaling</tt> (true/false)
        <ul>
          <li>Usually this is a preference that can be set up in the modules admin panel. It specifies if images may be enlarged when resized.<br />
            With this param you can override this setting to specify certain preferences for each block individually.<br />
            <em><strong>Note:</strong> This has no effect if you are admin.</em>
          </li>
        </ul>
        <br />
      </li>
      <li>
        <tt>create_thumbs</tt> (true/false)
        <ul>
          <li>Usually this is a preference that can be set up in the modules admin panel. It specifies if the module will create thumbnails of images when reading the directory.<br />
            With this param you can override this setting to turn off thumbail creation for a certain input block individually.
          </li>
        </ul>
        <br />
      </li>
      <li>
        <tt>show_thumbfiles</tt> (true/false)
        <ul>
          <li>Usually this is a preference that can be set up in the modules admin panel. It specifies if the module will show even the thumbnails as regular files.<br />
            With this param you can override this setting to specify certain preferences for each block individually.
          </li>
        </ul>
        <br />
      </li>
    </ul>
  </div>
  <div id="developers_c">
    <p><strong>For developers:</strong></p>
    <p>Actually at the moment there is just one function that might be of interest for module developers: </p>
    <p><code>CreateFilePickerInput($module, $id, $name, $value = '', $params = array())</code></p>
    <p>Here is an example how to integrate the filepicker input in other modules:</p>
    <pre><code>
    if($jmfp = cmsms()->GetModuleInstance('JMFilePicker')) 
    {
      // prints out a file dropdown showing only images in "[your uploads dir]/images";
      // selected images will appear as thumbnail preview below the dropdown
      
      echo $jmfp->CreateFilePickerInput( '', $id,'filepicker_input_1', '', array('dir' => 'images') );
      
      
      // prints out a button and a hidden input field to browse images in "[your uploads dir]/images" using the built in filebrowser
      // selected images will appear as thumbnail preview below the button;
      // value is stored in the hidden input field
      
      echo $jmfp->CreateFilePickerInput('', $id, 'filepicker_input_2', '', array('dir'=>'images','mode'=>'browser'));
      
      
      // prints out a file dropdown showing all files in uploads dir
      echo $jmfp->CreateFilePickerInput('', $id, 'filepicker_input_3', '', array('media_type'=>'file'));
      
      
      // prints out a button and a text input field to browse images in uploads/images using the built in filebrowser
      // value is stored in the text input field
      
      echo $jmfp->CreateFilePickerInput('',$id, 'filepicker_input_4','',array('media_type'=>'file','mode'=>'browser'));
      
    }</code></pre>
    {* <p><a href="../modules/JMFilePicker/doc/api/index.html" target="_blank">Click here to view the generated API documentation for more details.</a></p> *}
  </div>
 {*
  <div id="whatsnew_c">
    <div class="pageoverflow">
 
      <h3>What's new</h3>
      <p>These are some of the new features of this release:</p>
      <ul>
        <li></li>
      </ul>
    </div>  
  </div>
  *}
  <div id="about_c">
    <div class="pageoverflow">
 
      <h3>About this module</h3>
      <p>Origin of this module comes from <strong>GBFilePicker</strong> developed by <strong>Georg Busch</strong>.</p>
      
      <h3>Support</h3>
      <p>This module does not include commercial support. However, there are a number of resources available to help you with it:</p>
      <ul>
        <li>The projects homepage is <a href="http://dev.cmsmadesimple.org/projects/jmfilepicker/" target="_blank">http://dev.cmsmadesimple.org/projects/jmfilepicker/</a></li>
        <li>Additional discussion of this module may also be found in the CMS Made Simple Forums:<br />
        <a href="http://forum.cmsmadesimple.org" target="_blank">http://forum.cmsmadesimple.org</a></li>
      </ul>
      <br />
      <p>Please report any kind of feedback.</p>
      <p>If want to help the development and maintenance of this module, please consider donating. <br /> <br />
        <a target="_blank" href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=PBK4X3XKMASZC"> 
        <img src="{$root_url}/modules/JMFilePicker/images/pp_button.png" border="0" name="submit" alt="PayPal – The safer, easier way to pay online." />
      </a>
      </p>

      <h3>Copyright and License</h3>

      <p>The Module is currently being developed by <strong>Fernando Morgado (Jo Morg)</strong>
      <br />
      Web: <a href="https://www.sm-art-lab.com" rel="external" target="_blank">www.sm-art-lab.com</a>
      <br />
      Email: <a href="mailto:jomorg@sm-art-lab.com">jomorg@sm-art-lab.com</a>
      </p>
      {if $smarty.now|date_format:"%Y" == '2016'}{$cr = '2016'}{else}{$cr = "2016 - {$smarty.now|date_format:'%Y'}"}{/if}
      <p>Copyright &copy; {$cr} . All Rights Are Reserved.<br /></p>

      <p><strong>JMFilePicker</strong> is free software;<br /> you can redistribute it and/or modify it under the terms of the <strong>GNU General Public License</strong> as published by the <strong>Free Software Foundation</strong>;<br /> either version 2 of the License, or (at your option) any later version.</p>
      <p><strong>JMFilePicker</strong> is distributed in the hope that it will be useful, but <strong>WITHOUT ANY WARRANTY</strong>;<br /> without even the implied warranty of <strong>MERCHANTABILITY</strong> or <strong>FITNESS FOR A PARTICULAR PURPOSE</strong>.</p>
      <p>See theGNU General Public License for more details.</p>
       <p>You should have received a copy of the <strong>GNU General Public License</strong> along with this program;<br /> if not, write to the <strong>Free Software Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA</strong> or <a target="_blank" href="http://www.gnu.org/licenses/licenses.html#GPL">read it online</a>.</p>
      <p><strong>You must agree to this license before using <strong>JMFilePicker</strong>.</strong></p>  

      <p>Copyright &copy; {$cr}, Fernando Morgado (Jo Morg). All Rights Are Reserved.</p>
      <p>This module has been released under the <a href="http://www.gnu.org/licenses/licenses.html#GPL" target="_blank">GNU Public License</a>. You must agree to this license before using the module.</p>
      <h4>Contributors</h4>
      <ul>
        <li><strong>Georg Busch (nan)</strong> georg.busch@gmx.net - original developer (GBfilePicker);</li>
        <li><strong>Jeff Bosch (ajprog)</strong> jeff@ajprogramming.com - code, suggestions and fixes;</li>
      </ul>
    </div>
  </div>  
  <div class="clearb"></div>
</div>
