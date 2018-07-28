<h3>What Does This Do?</h3>
<p>This module works in the CMS Made Simple administration console and provides various aditional functions and utilities for working with CMS Made Simple's content pages.</p>
<h3>Features</h3>
<ul>
  <li>Export content pages to XML</li>
  <li>Import content pages from XML</li>
  <li>Allows Creating and managing various different content blocks for embedding into CMSMS page templates.</li>
  <li>Provides bulk page copy capability.</li>
</ul>
<h3>How do I use it</h3>
<p>If you are an authorized CMS Made Simple web site administrator, and have sufficient privilege to manage all content, then the &quot;Calguys Content Utilities&quot; menu item should appear in the CMS Made Simple administration panel.  You will see a number of tabs, including:</p>
<ul>
  <li><u>Blocks</u>
  <p>This tab provides functionality for creating &quot;named&quot; and managing content blocks of various types.  Tags for these content blocks can then be inserted into CMSMS page templates.  This provides functionality to put additonal content blocks into your page template to allow the user to enter or choose different data which may have a result on the appearance of the page.</p>
  <p>For example, a content block of type &quot;checkbox&quot; could be used to indicate wether an image is to be displayed or not.</p>
  <p>This is an advanced feature, and utilizing this feature requires that you be familiar with the smarty templating engine that is used througout CMSMS.</p>
  <p>Additionally, it is possible to hide these content blocks from users who tradittionally have edit access to the page.  The groups parameter can be used to specify a comma separated list of group names to members of which the content block should be visible. If this parameter is not specified, it is assumed that the content block is visible to all valid editors for the content page.';
<pre><code>{content_module module='CGContentUtils' block='cb' name='cb' label='Checkbox' groups='designers,otherdesigners'}</code></pre><br/>
  </li>
  <li><u>Import</u>
  <p>This tab provides the ability to import one or more content pages from an XML file that was created by the export functionality.   Using this functionality you can easily migrate information from one website to another.<p>
  </li>
  <li><u>Export</u>
  <p>This tab provides the ability to choose a single page from a dropdown to export to XML format.  You can also indicate wether the children of the selected page should be exported.  Clicking on the export button will prompt you to download the XML file.</p>
  <p>The generated XML file does not contain images, or page templates, or global content blocks, etc.  It only contains the contents of the various content objects, and their values.</p>
  </li>
</ul>
<p>Additionally, this module adds a bulk action to the content management page, which should be visible if you have the appropriate permission.  This bulk action allows selecting multiple pages, and creating a single copy of each of the selected pages,</p>

<h3>Note about content block types.</h3>
<p><strong>Note:</strong> it is generally not a good idea, and not the intent of CMSMS to allow editors to make design level decisions.  Therefore, generally speaking logic related to design elements should be left at the template level, and editors should merely select a template that they want to use.  Smarty template inheritance is a mechanism whereby many similar templates with different design features can be organized in a simple manner to allow editors to select the layout that they want.</p>
<p>It is the intent of this module that the content block types provided only be used for the entering, selection of, and display of different data. However, Logic as to what is displayed and how it is displayed, should be done in different page templates.  i.e.:  Do not use a select box, checkbox, or other input elements to determine a 1, 2 or 3 column layout.  Instead, the editor should select a 1, 2 or 3 column template.</p>

<h3>Support</h3>
<p>This module does not include commercial support. However, there are a number of resources available to help you with it:</p>
<ul>
<li>For the latest version of this module, FAQs, or to file a Bug Report or buy commercial support, please visit calguy\'s
module homepage at <a href="http://calguy1000.com">calguy1000.com</a>.</li>
<li>Additional discussion of this module may also be found in the <a href="http://forum.cmsmadesimple.org">CMS Made Simple Forums</a>.</li>
<li>The author, calguy1000, can often be found in the <a href="irc://irc.freenode.net/#cms">CMS IRC Channel</a>.</li>
<li>Lastly, you may have some success emailing the author directly.</li>
</ul>
<h3>Copyright and License</h3>
<p>Copyright &copy; 2008, Robert Campbel <a href="mailto:calguy1000@cmsmadesimple.org">&lt;calguy1000@cmsmadesimple.org&gt;</a>. All Rights Are Reserved.</p>
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
Or read it <a href="http://www.gnu.org/licenses/licenses.html#GPL">online</a></p>
