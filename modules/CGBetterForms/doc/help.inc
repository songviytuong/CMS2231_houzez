<h3>What is this</h3>
<p>This is a new generation of form handling module that provides the ability for web professionals to build forms the way they know how, using HTML, CSS and javascript.. and then easily define what should happen with the data users submitted.</p>
<p>This module can allow you to create well styled, dynamic forms, using whatever toolkit you like (Bootstrap, Foundation, etc).  and integrate javascript.  Then quickly define how the form data should be processed.</p>

<h3>Features</h3>
<ul>
  <li>You create the form. and can get it looking the way you want.</li>
  <li>Allows for javascript validation, and HTML5 field types.</li>
  <li>Can verify data from HTML5 attributes on the server side,  even if the browser does not support them natively.</li>
  <li>Provides data attributes to assist in rendering and handling the form.</li>
  <li>Integrates with smarty</li>
  <li>Takes advantage of CMSMS 2.2 features like template types and hooks</li>
  <li>Tests your code to tell you about parsing errors and potential rendering, or submission problems.</li>
  <li>Supports file uploads</li>
  <li>Addresses security issues:
    <ul>
      <li>Supports captcha</li>
      <li>Has built in honeypot captcha support</li>
      <li>Each request is assigned a unique GUID, which is validated on submission.</li>
      <li>Automatically disallows HTML tags in submitted responses.</li>
      <li>Form attributes are parsed and stored in the database, and validated on the server to mitigate Man-in-the-Middle attacks.</li>
    </ul>
  </li>
  <li>Has multiple server-side data validation routines</li>
  <li>Create validations by automatically parsing your HTML and template.</li>
  <li>Multiple built-in handlers/dispositions.</li>
  <li>Easily add handlers and dispositions via the API.</li>
  <li>Supports hooks for validation and disposition/handling.</li>
  <li>More</li>
</ul>

<h3>How do I use it</h3>
<p><strong>Note:</strong> This is a module for the experienced CMSMS web professional,  you should have good experience with CMSMS, HTML, CSS and potentially javascript.</p>
<ol>
  <li>Create your form HTML template
     <ul>
       <li>Create a new template of type <code>CGBetterForms::Form</code> in the Design manager.  Be careful to remember the name you give the new template.</li>
       <li>Copy/paste or enter your HTML form code into the template.  Save when ready.</li>
     </ul>
  </li>
  <li>Create a new content page and test your form HTML
     <p>Add this code to the content area:</p>
     <pre>{include file='cms_template:your_template_name'}</pre>
     <p>This is for testing purposes, we will be changing it later once our form looks good.</p>
     <p><strong>Note:</strong> You probably want to disable the WYSIWYG editor for this new content page.</p>
  </li>
  <li>Edit, style, and code your form HTML template.
     <p>Save the content page and view it in your browser. You should test out your HTML, CSS, and javascript.  Ensure your form is responsive, and test for HTML and validation functionality.  You can even submit your form, though at this point it should not do anything except refresh the page.</p>
     <p>You may need to repeatedly reload the content page as you are editing the HTML, and styling your form.</p>
     <p><strong>Note:</strong> Your HTML form tag should be as simple as <code>&lt;form&gt;</code>.  Particularly, you should leave out the the method, and action attributes. Later, when the CGBetterForms module is rendering your form, any important form attributes and hidden variables will be injected.  You can though add any id, class and style attributes that you wish.</p>
     <p><strong>Note:</strong> It is important that your HTML validate as much as possible.  So it is a good idea to check your output with a validator.  Also check the javascript console for warnings or errors.</p>
  </li>
  <li>Create a form in CGBetterForms and link it to your form template.
     <ol>
     <li>Browse to <code>Extensions >> CGBetterForms</code> in the CMSMS admin panel, and create a new form.</li>
     <li>Select the name of the form you created and edited above... and optionally provide a description.</li>
     <li>Click &quot;scan&quot;  this will parse your HMTL template and provide feedback on the &quot;messages&quot; tab to indicate errors and possible improvements.</li>
     <li>Review the content of the &quot;fields&quot; tab to ensure that all necessary fields are present, and that everything looks correct.</li>
     <li>Add one or more &quot;handlers&quot;</li>
     <li>Enter in some text, or select a final action.</li>
     <li>Save your form.</li>
     </ol>
  </li>
  <li>Change the call to render your form.
    <p>Edit the page you created in step 2 above, and change the call to <code>{CGBetterForms form='yourformname'}</code>.  Then save the content page.</p>
  </li>
  <li>Test
    <p>Reload the content page we created above in your browser, and ensure everything looks correct.  And then test the submission of the form.</p>
    <p>Behavior of the form will be dependant upon what form options are selected, what validations are selected, and the handlers.</p>
  </li>
</ol>

<h3>Built in Form and Template Tests</h3>
<ul>
  <li>Validate template contents <em>(TemplateValidator)</em>
    <p>This test checks for valid form starting and ending tags, whether they are provided via HTML tags, or the CMSMS {form_start} and {form_end} tags.  It also checks if your template is calling {cgbf_form_errors} to retrieve validation errors.</p>
  </li>
  <li>Form Validation <em>(FormTagValidator)</em>
    <p>This test ensures that your template contains only one form, and checks to ensure that you have not provided any form attributes that will be overridden by the form rendering process.</p>
  </li>
  <li>Test for missing input names <em>(FormMissingNameValidator)</em>
    <p>When submitting a form to a server, the name of each input, textarea, and select field is mandatory.  This test ensures that each of those fields has a valid name attribute.</p>
  </li>
  <li>Test for missing labels <em>(FormMissingLabelValidator)</em>
    <p>This test ensures that each input has some sort of label detected.  The label is used automatically by form handlers as the human-readable value for each field when savng the form.</p>
  </li>
  <li>Test for missing values <em>(FormMissingValueValidator)</em>
    <p>Some inputs (like checkboxes, and radio buttons) require a value attribute, and require it to be filled in so that data can be properly transmitted to the server.  This test ensures that each of your fields has a value, as required.</p>
  </li>
  <li>Duplicate ID test <em>(FormDuplicateIdValidator)</em>
    <p>As a convenience, though it is not important for the form submission process, this test ensures that no two input fields have the same id.</p>
  </li>
  <li>Duplicate name test <em>(FormDuplicateNameValidator)</em>
    <p>This test ensures that the name of input fields is not erroneously duplicated.  We check for duplicate names with different types of fields.  It ignores radio button groups, and other fields where it is valid to duplicate the input name.</p>
  </li>
</ul>

<h3>Form Scanning and Saving</h3>
<p>This module stores metadata about the form template in the database.  This metadata is used for building validators and handlers, and on the frontend to aide in rendering and validation and handling.  Therefore, each time the form template is changed the form must be re-scanned.</p>
<p>The scanning process will parse the HTML of the form template, and build metadata.  It will output a list of potential problems with your form.  i.e.:  invalid syntax, missing labels, etc. Some of these messages may be intentional, or may be an error in the template.  Each developer will need to determine this for himself.</p>

<h3>Pre-render logic</h3>
<p>This smarty template allows you to initialize information in the $form_data object for use when the form is initially displayed (i.e.: not the result of a submission).  It is useful for setting the default value of input fields based on some logic.</p>
<p>This is accomplished by using the <code>{cgbf_set}</code> smarty plugin.  i.e: <code>{cgbf_set field=widget_color value=white}</code>.</p>
<p>This simple example, will set the default value for a field named &quot;widget_color&quot; to white on sundays:</p>
<pre><code>{if $smarty.now|date_format:'%d' == 0}{cgbf_set field=widget_color value='white'}{/if}</code></pre>

<h3>Submission Validations</h3>
<p>Submission validations take the user entered response, and ensure that it conforms to the requirements specified either in the form itself, or via additional validators you added.  They may also modify the response.  Usually though they do not store the data or send the data anywhere.</p>
<p>If any validations fail, the error messages are collected and the form is re-rendered, without executing any of the handlers.</p>
<p>Below is a list of the submission validations that are built in to CGBetterForms.</p>
<ul>
  <li>Check for HTML in input submissio.n  <em>(HtmlDetectionValidation)</em>
     <p>This validation ensures that a user has not any injected HTML code (including potentially malicious script tags) into any submitted fields.</p>
     <p>This test is added automatically when auto-validation is enabled.</p>
     <p><strong>Note:</strong> This validator does not obey the data-cgbf-novalidate attribute.</p>
  </li>
  <li>Check for required data  <em>(HtmlRequiredFieldValidation)</em>
     <p>This validation ensures that there is some data in every field that is marked as required. Either via the <code>required</code> HTML5 attribute or the <code>data-cgbf-required</code> attribute.</p>
     <p>This test is added automatically when auto-validation is enabled.</p>
  </li>
  <li>Check the value of all Select fields, radio-button groups, and checkbox-groups  <em>(SelectFieldValidation)</em>
     <p>This test ensures that for each of the multi-option (select fields, radio-button-groups and checkbox-groups) fields that only a valid value is submitted.</p>
     <p>This test is added automatically when auto-validation is enabled and one or more multi-option fields are detected.</p>
  </li>
  <li>Check the value of all email fields.  <em>(EmailPrimitivieValidation)</em>
     <p>This test ensures that for each email field (denoted by either <code>type="email"</code> or <code>data-cgbf-primary="email"</code>) That each of the values contains a valid email address.</p>
     <p>This test is added automatically when auto-validation is enabled and one or more email fields are detected.</p>
  </li>
  <li>Check the value of all date fields.  <em>(DatePrimitiveValidation)</em>
     <p>This test will ensure that for each date field (denoted by either <code>type="date"</code> or <code>data-cgbf-primary="date"</code>) That each of the values is a valid date.  This test will also validate the values given any range attributes such as min,max,data-cgbf-min,data-cgbf-max.  A date string must be in the format of yyyy-mm-dd.</p>
     <p>This test is added automatically when auto-validation is enabled and one or more date fields are detected.</p>
  </li>
  <li>Ensure that all uploads conform to the specifications. <em>(FileValidator)</em>
     <p>TODO</p>
     <p>This test is added automatically when auto-validation is enabled, and one or more file files are detected.</p>
  </li>
  <li>Check the value of specific integer fields.  <em>(IntegerFieldValidation)</em>
     <p>This test will ensure that the specified field is an integer, and that it's values conform to developer entered range values.</p>
  </li>
  <li>Check the value of specific float fields.  <em>(FloatFieldValidation)</em>
     <p>This test will ensure that the specified field is a float, and that it's values conform to developer entered range values.</p>
  </li>
  <li>Ensure the value of a specific field matches a regular expression/pattern.  <em>(RegexFieldValidation)</em>
     <p>This test will ensure that all of the values of the specified field match the provided regular expression/pattern.</p>
     <p>This test is added automatically for each field with a pattern, or data-cgbf-pattern attribute when auto-validation is enabled in the form.</p>
  </li>
  <li>Ensure the value of a specific field is an email address.  <em>(EmailFieldValidation)</em>
     <p>This test will ensure that all of the values of the specified field are valid email addresses.</p>
  </li>
  <li>Validate via Smarty Template.  <em>(TemplateValidation)</em>
     <p>This validator allows you to use smarty to validate the form submission.  You can use smarty logic, and/or UDT's or other plugins to evaluate the content.  If the test fails, the template should output an error message.</p>
  </li>
  <li>Compute the value of a field, given a template.  <em>(ComputedValue)</em>
     <p>This is a special kind of validation test.  It is capable of computing the value of one field given the other data in the submitted response.  It is useful for doing calculations and putting the output into a new field, or for adjusting the value of one field based on limits specified in other fields.</p>
     <p>The output of a smarty template <em>(a string)</em> replaces the value of a specified field.</p>
  </li>
  <li>Use a hook to validate the response.  <em>(HookValidation)</em>
     <p>This validation calls a hook entitled <code>CGBetterForms::validateForm</code> and passes the entire form response.  The hook handlers can choose to modify the response, or to perform various other tests.  If a test fails, then it is expected to throw a special exception.</p>
  </li>
</ul>

<h3>Built in Handlers/Dispositions</h3>
<p>Form handlers are executed after all submission validations have passed, and are used to &quot;do things&quot; with the data.  They do not typically modify the output data.</p>
<p>If an error occurs in a disposition, typically the error is logged in some format (this is the task of the specific handler), and processing continues.</p>
<p>Below is a brief description of the built-in dispositions.</p>
<ul>
  <li>Save the results to a file based on the value of a multi-option field.</li>
  <li>Save the results to a unique file.</li>
  <li>Save the results to a flat file <em>(usually CSV)</em></li>
  <li>Send the results via email based on the value of a multi-option field.</li>
  <li>Send the results via email to specified email addresses.</li>
  <li>Send the results via email to a user specified email address.</li>
  <li>POST form results to a URL/WebHook.</li>
  <li>Redirect to a URL based on the output of a template.</li>
  <li>Redirect to a page based on the output of a template.</li>
  <li>Use a hook to handle/dispose of the response.</li>
  <li>Store form results to the session for later processing.</li>
  <li>Stop Processing Dispositions based on a Condition</li>
</ul>

<h3>Common Errors and Problems.</h3>
<ul>
  <li>Could not retrieve form object
     <p>CGBetterForms uses the session when editing a form.  This message indicates that the session has timed out, and anything un-saved in your form has been lost.   Please ensure that you save your form often.<p>
  </li>
  <li>Modification of field variables in smarty
     <p>Each template used by each validation or handler in the CGBetterForms module uses its own scope to prevent variable name conflicts.  For this reason you cannot modify the values of the response by editing the smarty variables.</p>
  </li>
  <li>Conditional fields (via smarty)
    <p>CGFormBuilder's scan functionality is an admin side action that takes your form template and parses it against smarty.   The smarty environment in the admin interface is different than that in the frontend, or even on different CMSMS content pages.  Therefore, smarty conditionals in your page template may prevent some fields from being scanned.</p>
  </li>
  <li>Try to avoid the use of smarty conditionals to display forms in your template, use javascript where possible.  However, if there are smarty conditionals that control the display of certain fields, then it is strongly advised that you create a hidden field as a place holder for that field prior to the conditional.  This will usually ensure that the field name is scanned.</li>
</ul>

<h3>Controlling form behavior with attributes</h3>
<ul>
  <li>Using regular HTML5 attributes
    <p>CGBetterForms will parse and remember the value of various HTML input attributes.  i.e: required, min, max and pattern.  These will be used to also perform server-side validation on the submitted data.</p>
    <p>Using these attributes to validate data on the server side is a good way of mitigating man-in-the-middle attacks, or doing data validation when the site visitor is using a browser that does not enforce them.</p>
  </li>
  <li>Data attributes for rendering
    <p>The following data attributes are hints to the renderer to make it easy for the developer to integrate smarty into a form, to include captcha, and other things.</p>
    <ul>
      <li><code>data-cgbf-captcha</code> - This attribute indicates where the captcha display will appear.
         <p>If specified, and if Captcha is installed and enabled, upon rendering the form, the captcha display will be appended to contents of the matching element.</p>
	 <p>If the captcha display requires an input field,  and no element with the data-cgbf-captcha-input attribute exists, then the captcha input field will also be appended to the contents of this element.</p>
      </li>
      <li><code>data-cgbf-captcha-input</code> - This attribute indicates where, if necessary any input field needed by the captcha display will be inserted.
         <p>Some captcha methods require the user to enter some text.  Using this atttibute allows the form creator to define where and how the input field will be displayed.</p>
      </li>
      <li><code>data-cgbf-selected</code> - This attribute is useful on <code>&lt;select&gt;</code> elements and radio-button groups to indicate the value of the selected option. i.e.:<br/>
<pre>&lt;select name="myselect" data-cgbf-selected=&quot;{$form_data-&gt;myselect|default:'<span style="color: red;">opt2</span>'}&quot;&gt;
    &lt;option value="opt1"&gt;Option 1&lt;/option&gt;
    &lt;option value="<span style="color: red;">opt2</span>"&gt;Option 2&lt;/option&gt;
    &lt;option value="opt3"&gt;Option 3&lt;/option&gt;
&lt;/select&gt;</pre>
      </li>
    </ul>
  </li>
  <li>Data attributes to aide server side validation
    <ul>
      <li>data-cgbf-novalidate
         <p>This attribute, on any input, select, or textarea fields indicates to disable all server-side validation for that field.  Some validators may not obey it.</p>
      </li>
      <li>data-cgbf-accept
         <p>Applicable only to file fields, this attribute can contain a comma separated list of wildcard mime types to indicate the type of files that are accepted. i.e.: <code>data-cgbf-accept="image/*,application/*pdf"</code>.</p>
      </li>
      <li>data-cgbf-maxsize
         <p>Applicable only to file fields, this attribute can specify a maximum size <em>(in bytes)</em> for any single file uploaded to that field.</p>
      </li>
      <li>data-cgbf-extension
         <p>Applicable only to file fields, this attribute can contain a comma separated list of valid file extensions to indicate the type of files that are accepted.</p>
	 <p><strong>Note:</strong> We do not recommend using this as some operating systems, or users do not maintain a religous policy on file extensions.</p>
      </li>
      <li>data-cgbf-primitive
         <p>Applicable to all but file fields, this attribute indicates the type of data that should appear in the value(s) for that field.  Possible values for this attribute are: int, float, date, email, and string.   If none specififed, then the data primitive will be interpreted from the field type, or string will be assumed.</p>
      </li>
      <li>data-cgbf-required
         <p>Applicable to all fields, this attribute indicates that at least one value must be specified for the field.</p>
      </li>
      <li>data-cgbf-pattern
         <p>Applicable to all but file fields, this attribute indicates that all values of the field must confirm to the specified regular expression.</p>
	 <p><strong>Note:</strong> PHP requires a start and end delimiter to a regular expression. i.e: <code>|[0-9]*|</code> whereas HTML does not.  CGBetterForms will provide them.</p>
      </li>
      <li>data-cgbf-min (todo)
         <p>Applicable to integer and float fields, this attribute indicates a minimum value for all values of the field.</p>
      </li>
      <li>data-cgbf-max (todo)
         <p>Applicable to integer and float fields, this attribute indicates a maximum value for all values of the field.</p>
      </li>
      <li>data-cgbf-captcha
         <p>This attribute serves two purposes.  On render it will append the contents of a <code>&lt;div&gt;</code> tag with this attribute with some captcha input.  On validation the captcha will be tested.</p>
      </li>
    </ul>
  </li>
  <li>Data attributes useful for scanning and disposition
    <ul>
      <li>data-cgbf-label
         <p>This attribute is useful on radio-button and checkbox groups when the form is scanned and parsed.  Because individual radio-button or checkbox fields may have separate labels, this attribute allows explicitly specifying a label to be used for the field as a whole in the disposition process.</p>
      </li>
      <li>data-cgbf-human
         <p>This attribute is useful on the individual options of select fields, radio-button groups, or checkbox-groups to specify a human readable value for each option to use in the disposition process.  If not specified, then the text portion of each &lt;option&gt; element, or the label of each radio-button or checkbox will be used.</p>
      </li>
    </ul>
  </li>
</ul>

<h3>Smarty plugins and variables for form rendering</h3>
<ul>
  <li><code>{cgbf_form_errors assign=string}</code>
     <p>Gather form errors from server side validation, and assign them to a smarty array. i.e.:</p>
     <pre><code>{cgbf_form_errors assign=errors}
{if !empty($errors)}
  &lt;ul class="errors"&gt;
    {foreach $errors as $error}
       &lt;li&gt;{$error}&lt;/li&gt;
    {/foreach}
  &lt;/ul&gt;
{/if}</code></pre>
  </li>
</ul>

<h3>Tips and Techniques</h3>
<ul>
  <li>Captcha validation.
     <p>Captcha validation is a two part process.  a:  the captcha must be rendered in the form using the &lt;div data-cgbf-captcha&gt;&lt;/div&gt; syntax, and b: The captcha input must be validated in the response.  You must have a &quot;Validate Captcha&quot; validation enabled.</p>
  </li>
  <li>Limit the number of fields.
     <p>For a better user interface it is important to limit the number of fields in a form.  If your field has more than about a dozen fields that the user can edit or adjust then typically users will not respond to them, or if they do the quality of the information submitted is reduced.  for those purposes it is often best to keep the forms small, simple, and easy to use.</p>
  </li>
  <li>Conditional Fields
     <p>If you would like to hide different fields based on certain conditions, it is best to do that using javascript and your favorite jquery plugins etc.</p>
     <p>Hint:  You can supply data to javascript from within your template using smarty variables. i.e.:</p>
     <pre>&lt;script&gt;var feu_uid = '{$feu_smarty::get_current_userid()}';&lt;/script&gt;</pre>
  </li>
  <li>Dynamic multi-option fields
     <p>If you would like to add options to select, or other multi-option fields (checkbox groups, radio-button groups) dynamically via smarty plugins where the options in the field may change, it is best to turn off validation for that field.</p>
     <p><strong>Note:</strong> This will turn off all validations for that field, including HTML validation.</p>
  </li>
  <li>Pre-filled fields
     <p>There are numerous ways to provide initial data to a form (i.e.: before the form is submitted by the user for the first time). These methods, if done correctly will also preserve user data if there is an error in form submission.</p>
     <ul>
       <li>Using field name arguments on the smarty tag:
          <p>i.e.:  <code>{CGBetterForms form='myform' cgbf_myfieldname='somevalue'}</code></p>
       </li>
       <li>Calling <code>{cgbf_set field=field_name value=something}</code> the &quot;Pre-render Logic&quot; tab when editing the form.</li>
       <li>Calling a UDT from within the form template to adjust the $form_data response object.</li>
       <li>Using the <code>data-cgbf-selected</code> attribute on select boxes and radio button groups.</li>
       <li>Using <code>{$form_data->myfieldname}</code> and the &quot;default&quot; smarty modifier.
          <p>i.e: <code>{$form_data->myfieldname|default:'foo'}</code>.</p>
       </li>
     </ul>
  </li>
  <li>Working with Files</li>
  <li>Arrays of data</li>
  <li>Calculated fields
      <p>Use the "Compute a Field Value" validation.</p>
  </li>
  <li>UDT's in validation
     <p>You can use the "Validate via Smarty Template" validation. In the template for that validation call your UDT.  If your UDT returns any output it will be treated as a validation error.</p>
  </li>
  <li>UDT's in dispositions
     <p>Use the StopDisposing Disposition, and in that template call your UDT.  If your UDT returns any output then disposing will stop.</p>
  </li>
  <li>Chaining forms
     <ol>
       <li>Use a UDT to dispose the form response to the session.</li>
       <li>Either using another disposition, or code within your UDT, redirect to the page containing the second form.</li>
       <li>Use hidden fields in the second form to contain the values from the first form.</li>
     </ol>
  </li>
</uL>

<h4>Hooks</h4>
<p>CGBetterForms uses Hooks on every form submission.  Hooks are another method of using third party code to do validation or dispositions of forms.</p>
<ul>
  <li><code>CGBetterForms::validateForm</code>
     <p>This hook is called after all other validations.  The same hook is called for each form so handlers should check the value of the form_name property to do different validations for fields on different forms.  The handlers should throw a \CGBetterForms\FormValidationError exception in the case of errors.</p>
     <h5>Arguments:</h5>
     <p>This hook sends the FormResponse object as its single argument.</p>
     <h5>Returns: <code>void</code><h5>
     <h5>Example:</h5>
     <pre><code>\CMSMS\HookManager::add_hook( 'CGBetterforms::validateForm', function( \CGBetterForms\FormResponse $response ){
    if( $response->form != 'myform' ) return;
    $email = $response->get_field_value('email');
    if( !is_email($email) ) throw new \CGBetterForms\FormValidationError('Please enter a valid email address');
    // here we could check if the email already exists in our database, etc.
});</code></pre>
  </li>

  <li><code>CGBetterForms::dispose</code>
     <p>This hook is called after all other dispositions (assuming processing has not been stopped by a previous disposition), but before the final response is generated or final redirect is performed.  The same hook is called for each form, so handlers should check the value of the form property of the response object to do different processing on different forms.  The handlers should throw runtime exceptions in the case of errors.</p>
     <h5>Arguments:</h5>
     <p>This hook sends the FormResponse object as its single argument.</p>
     <h5>Returns: <code>void</code><h5>
     <h5>Example:</h5>
     <pre><code>\CMSMS\HookManager::add_hook( 'CGBetterforms::dispose', function( \CGBetterForms\FormResponse $response ){
    if( $response->form != 'myform' ) return;
    $name = $response->get_field_value('name');
    $email = $response->get_field_value('email');
    // validation is already done... save this info into an email list.
    $fh = fopen(CMS_ROOT_URL.'/uploads/emails.dat','a');
    fprintf( $fh, "$email,$name\n", $email, $name );
    fclose( $fh );
});</code></pre>
  </li>

  <li><code>CGBetterForms::cleanup</code>
     <p>This hook is called after all validations and dispositions and even in the event of validation errors.  Its intent is to cleanup any temporary garbage left over from validating and processing the submission.</p>
     <h5>Arguments:</h5>
     <p>This hook sends the FormResponse object as its single argument.</p>
     <h5>Returns: <code>void</code><h5>
  </li>
</ul>

<h3>API Reference</h3>
<ul>
  <li><strong>FormResponse object</strong>
     <p>This object represents the results of user form submissions.  It encapsulates the user submitted information, uploaded files, and metadata about the form.  This object is passed via smarty to each disposition for use in UDT's and other code.</p>
     <h4>Properties:</h4>
     <ul>
       <li><code>form</code> - <em>(string, read only)</em> - The name of the form.</li>
       <li><code>remote_ip</code> - <em>(string, read only)</em> - The IP address of the client browser.</li>
       <li><code>submit_time</code> - <em>(int, read only)</em> - The Unix timestamp of the time that the form was submitted.</li>
       <li><code>version</code> - <em>(string, read only)</em> - The current version of CGBetterForms.</li>
       <li><code>guid</code> - <em>(string, read only)</em> - The unique guid of this submission.
          <p>To aide in secuity, and with uploading multiple files, A unique guid string is generated when the form is rendered.  This property contains that guid value.</p>
       </li>
     </ul>
     <h4>Methods:</h4>
     <ul>
       <li><code>get_field_value(<em>string</em> $key)</code> - Return the value for a specific field, if any.
           <h5>Arguments:</h5>
	   <p><code>$key</code> - <em>(string)</em> - A field name.</p>
	   <h5>Returns: <code><em>mixed</em></code></h5>
       </li>
       <li><code>get_human_readable_field_value(<em>string</em> $key)</code> - Return the human readable value for a specific field, if any.
           <p>Fields such as select fields, radio-button groups or checkbox-groups can have an explicit value for each option useful for processing, and a human readable value that is suitable for presentation in emails and reports. This method attempts to return the human readable value for a field in a response.  If no explicit human readable value is specified, then the user entered value is returned verbatum.  See the <code>data-cgbf-human</code> data attribute.</p>
           <h5>Arguments:</h5>
	   <p><code>$key</code> - <em>(string)</em> - A field name.</p>
	   <h5>Returns: <code><em>string</em></code></h5>
	   <p>The human readable value, if any can be found.  If not, then the input field value will be returned.</p>
       </li>
       <li><code>list_files(<em>string</em> $name = null)</code> - Return files uploaded with this submission request.  If any.
           <h5>Arguments:</h5>
	   <p><code>$name</code> - <em>(string)</em> - An optional field name.</p>
	   <h5>Returns: <code><em>string[]|null</em></code></h5>
           <p>If a field name is specified, and one or more files were uploaded for that field, then this method will return an array of file names representing the files uploaded for htat field.</p>
	   <p>If no field name is specified, this method will return an array of all uploads for the entire form submission, keyed by the field name.</p>
	   <p>If no files were uploaded for this response this method will return null, or an empty array.</p>
       </li>
       <li><code>has_files(<em>string</em> $name)</code> - Test if a file has been uploaded for a specific field name.
           <h5>Arguments:</h5>
	   <p><code>$name</code> - <em>(string)</em> - A field name.</p>
	   <h5>Returns: <code><em>bool</em></code></h5>
       </li>
       <li><code>is_file_field(<em>string</em> $name)</code> - Test if a specific field name represents a file upload field.
           <h5>Arguments:</h5>
	   <p><code>$name</code> - <em>(string)</em> - A field name.</p>
	   <h5>Returns: <code><em>bool</em></code></h5>
       </li>
       <li><code>has_uploads()</code> - Test if the form response contains any uploaded files.
           <h5>Arguments:</h5>
	   <h5>Returns: <code><em>bool</em></code></h5>
       </li>
       <li><code>get_file_as_url(<em>string</em> $name)</code> - Get the URL(s) for all files uploaded to for a specified field.
           <h5>Arguments:</h5>
	   <p><code>$name</code> - <em>(string)</em> - A field name.</p>
	   <h5>Returns: <code><em>string[]|string|null</em></code></h5>
	   <p>Similar to the <em><strong>list_files()</strong></em> method, this method will return all of the files uploaded for a specific field.  However, the output is complete URLs to the uploaded files.</p>
	   <p>If multiple files were uploaded for the specifed field, this method will return an array of strings.</p>
	   <p>If a single file was uploaded for the specified field, this method will return a single string.</p>
	   <p>If no files were uploaded for the specified field, this method will return null.</p>
       </li>
     </ul>
  </li>
</ul>

<h3>Extending functionality</h3>
<h4>Adding Validations</h4>
<h4>Adding Dispositions</h4>

<h3>Support</h3>
<p>The module author is in no way obligated to provide support for this code in any fashion.  However, there are a number of resources available to help you with it:</p>
<ul>
<li>A bug tracking and feature request system has been created for this module <a href="http://dev.cmsmadesimple.org/projects/cgextensions">here</a>.  Please be verbose and descriptive when submitting bug reports and feature requests, and for bug reports ensure that you have provided sufficient information to reliably reproduce the issue.</li>
<li>Additional discussion of this module may also be found in the <a href="http://forum.cmsmadesimple.org">CMS Made Simple Forums</a>.  When describing an issue please make an effort to privide all relavant information, a thorough description of your issue, and steps to reproduce it or your discussion may be ignored.</li>
<li>The author, calguy1000, can often be found in the <a href="irc://irc.freenode.net/#cms">CMS IRC Channel</a>.</li>
<li>Lastly, you may have some success emailing the author directly.  However, please use this as a last resort, and ensure that you have followed all applicable instructions on the forge, in the forums, etc.</li>
</ul>

<h3>Copyright & License</h3>
<p>Copyright &copy; 2017, Robert Campbell <a href="mailto:calguy1000@cmsmadesimple.org">&lt;calguy1000@cmsmadesimple.org&gt;</a>. All Rights Are Reserved.</p>
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
