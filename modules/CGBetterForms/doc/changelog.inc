<ul>
	<li>v1.0 - Initial stable release.</li>
	<li>v1.1 - September 2017
		<p>- Minor bug fix.</p>
		<p>- Adds basic import and export functionality.</p>
	</li>

	<li>v1.1.2 - September 2017
		<p>- Improves the edit-form interface in the event of severe errors when parsing the form HTML.</p>
	        <p>- Improves messages about unknown HTML5 elements.  Will look at using a different library in later versions.</p>
		<p>- Minor bug fix related to static use of non-static method.</p>
	</li>
	<li>v1.2 - November 2017
		<p><strong>Note:</strong> For all forms using captcha, you may need to remove and re-add any &quot;Validate Captcha&quot; validation in the validation tab to ensure that captcha is validated on the server side.</p>
		<ul>
		<li>Fixes to captcha validation (wasn't happening server side)</li>
		<li>Can now auto-add valiations even if there are existing validations.</li>
		<li>Minor fix to template help stuff.</li>
		<li>Adds a new ModuleReference class and use it in at least one place to allow storing a simple reference to a module to use invisibly.</li>
		</ul>
	</li>
	<li>v1.2.1 - December 2017
		<ul>
		<li>FormResponse now contains a translator member and a get_translator() method.  May remove these later.</li>
		<li>Improvements to validation errors.</li>
		<li>Now handle disposition errors similar to validation errors.</li>
		<li>Smarty templates can now access raw response data.</li>
		<li>more...</li>
		</ul>
	</li>
	<li>v1.3 - December 2017
		<ul>
	        <li>Remove the reset button from the final message template.</li>
		<li>Fix issue with the honeypot field not being provided to the response object properly.</li>
	        <li>Fix issue with submissions when there are multiple forms on a page.</lli>
	        <li>Fix labels in the Smarty Template validation.</li>
	        <li>Fix issue with validations throwing the wrong exception.</li>
	        <li>Fix the select in the Dropdown-Email validation (you may need to remove and re-add this validation on your forms).</li>)
		<li>fix problem that resulted in an empty template being imported.</li>
	        <li>Unique filename disposition now has a filename template.</li>
		</ul>
	</li>
</ul>
