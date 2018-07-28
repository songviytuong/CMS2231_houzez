<ul>
  <li>v1.0 - June 2009
    <ul>
      <li>Initial Relase</li>
    </ul>
  </li>
  <li>v1.0.2 - July 2010
    <ul>
      <li>Ability to perserve hierarchy when copying parents and children (Ted)</li>
      <li>Added check for prop copying to keep E_NOTICE happy (Ted)></li>
      <li>Minor change to sample tag info.</li>
      <li>Adds the page selector field type.</li>
    </ul>
  </li>
  <li>v1.2 - December 2010
    <ul>
      <li>Adds the export and import code functionality.</li>
    </ul>
  </li>
  <li>v1.2.1 - December 2010
    <ul>
      <li>Minor Fixes.</li>
    </ul>
  </li>
  <li>v1.2.2 - November 2011
    <ul>
      <li>Minor Fixes.</li>
    </ul>
  </li>
  <li>v1.3 - December 2011
    <ul>
      <li>Adds the group= param to the content block.</li>
      <li>Fixes to the advanced copy functionality.</li>
    </ul>
  </li>
  <li>v1.3.2 - June 2012
    <ul>
      <li>Fixes for CMSMS 1.10.x and 1.11</li>
      <li>Moves help out of the lang file.</li>
    </ul>
  </li>
  <li>1.3.4 - January 2013
   <ul>
    <li>Minor fix to advanced copy function.</li>
    <li>Remove help and changelog from lang files.</li>
   </ul>
  </li>

  <li>1.3.4 - August 2013
   <ul>
    <li>Fixes.</li>
   </ul>
  </li>

  <li>1.4 - January 2014
    <ul>
	<li>Adds multiselect field.</li>
	<li>Adds static text field.</li>
	<li>Adds WYSIWYG option to textarea field.</li>
	<li>Bug fixes.</li>
    </ul>
  </li>

  <li>1.5.x - January 2015
  <ul>
	<li>Adds advanced pageselector field.</li>
	<li>Adds gcb selector field.</li>
	<li>Adds sortable list field (uses jquery ui sortable, and is stylable with a custom template).</li>
	<li>minor fixes.</li>
  </ul>
  </li>

  <li>2.0.x
  <ul>
	<li>Restructure for CMSMS 2.0.  <strong>Note:</strong>  The export code functionality has been changed due to the new functionality of Design Manager.</li>
	<li>Adds the new bulk action to bulk change aliases.</li>
	<li>Improvements to Import code functionality.</li>
  </ul>
  </li>

  <li>2.1.x
  <ul>
	<li>gcb selector now works for CMSMS 2.0.1 - Slightly different behavior.</li>
	<li>Now can use the prompt from the field without specifying it on the tag.</li>
	<li>Removes GCB stuff from export/import code.</li>
        <li>Corrections to admin permissions logic.</li>
	</ul>
	</li>

  <li>2.1.4 - June 2016
	<p><strong>Note:</strong> This release fixes an issue with entities in dropdown/multi-select fields.  Howeveer, if you have entities in your keys and values for these fields then you will need to update each and every page that uses templates with these fields on them.</p>
	<ul>
	  <li>Now convert keys and values in dropdown/multiselect lists to entities before using them in edit content.</li>
          <li>Bug fixes.</li>
	</ul>
  </li>

  <li>2.1.5 - September 2016
       <p>Minor bug fixes.</li>
  </li>

  <li>2.1.5
	<p>The options textarea for multiselect fields, etc. in create/edit block is now treated as a smarty template..</li>
	<p>Re-works the sortable list template.  If using a custom template you may need to refactor your custom template for compatibility.</li>
	<p>Custom blocks now (once again) support the required field.</p>
	<p>Minor styling tweaks to the admin panel.</p>
  </li>
</ul>
