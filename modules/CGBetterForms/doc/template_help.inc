<div class="warning" style="width: 95%;"><strong>Remember</strong> to re-scan and re-save any forms using this template each time you save it.</div>

<fieldset>
<legend>Smarty Variables</legend>
<table style="width: 100%;">
  <tr>
    <td>$form_data</td>
    <td style="text-align: right;"><em>(\CGBetterForms\FormResponse object)</em></td>
  </tr>
  <tr>
    <th colspan="2">Members</th>
  </tr>
  <tr>
    <td colspan="2">Each form field (as identified in the fields tab) is available as a member of this object. i.e: <code>{$form_data->foo}</code></td>
  </tr>
  <tr>
    <th colspan="2">Methods</th>
  </tr>
  <tr>
    <td><code>string[] {$form_data->list_fields()}</code></td>
    <td>Return a list of all known field names.</td>
  </tr>
</table>
</fieldset>

<fieldset>
<legend>Smarty Plugins</legend>
<table style="width: 100%;">
  <tr>
    <td valign="top"><code>{cgbf_form_errors assign=name}</code></td>
    <td valign="top">
      <p>Output:  <code>string[]</code></p>
      <p>Parameters: <code>assign</code> - Assign the output from this plugin to the named smarty variable.</p>
      <p>After the form has been submitted, if any errors occur, the form will be re-rendered.  This plugin can be used to retrieve the errors.</p>
    </td>
  </tr>
</table>
</fieldset>

<fieldset>
<legend>Data Attributes</legend>
<table style="width: 100%;">
  <thead>
    <tr>
      <th style="min-width: 15em;">Name</th>
      <th>Valid for</th>
      <th>Contents (if any)</th>
      <th>Description</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td><code>data-cgbf-novalidate<code></td>
      <td>input, select, textarea</td>
      <td></td>
      <td>When scanning the form, do not validate this field at all.</p>
    </tr>
    <tr>
      <td><code>data-cgbf-accept<code></td>
      <td>type="file"</td>
      <td><p>Comma separated string of mime types.  Wildcards supported.</p><p>i.e: <code>image/*,application/pdf<code></p></td>
      <td>When validating the form response accept only uploads matching these file types.</td>
    </tr>
    <tr>
      <td><code>data-cgbf-maxsize<code></td>
      <td>type="file"</td>
      <td>integer</td>
      <td>The maximum file size of any file uploaded for this field.</td>
    </tr>
    <tr>
      <td><code>data-cgbf-extension<code></td>
      <td>type="file"</td>
      <td>string</td>
      <td><em>(not recommended)</em> A comma separated list of valid file extensions that can be uploaded.</td>
    </tr>
    <tr>
      <td><code>data-cgbf-primitive<code></td>
      <td>! type="file"</td>
      <td>The values <code>int, float, date, email, or string</code></td>
      <td>Explicitly specify the type of value expected in the field, for server-side validation purposes.  If not specified then intelligent guesses are made based on the type of field and other attributes.</td>
    </tr>
    <tr>
      <td><code>data-cgbf-required<code></td>
      <td>input, select, textarea</td>
      <td></td>
      <td>Indicates that at least one value for this field is required to pass validation.</td>
    </tr>
    <tr>
      <td><code>data-cgbf-pattern<code></td>
      <td>! type="file"</td>
      <td>string</td>
      <td>A regular expression that all values for the field must match.</td>
    </tr>
    <tr>
      <td><code>data-cgbf-min<code></td>
      <td>type="number" | data-cgbf-primitive="float" | data-cgbf-primitive="int"</td>
      <td>string</td>
      <td>The minimum value for this field.</td>
    </tr>
    <tr>
      <td><code>data-cgbf-max<code></td>
      <td>type="number" | data-cgbf-primitive="float" | data-cgbf-primitive="int"</td>
      <td>string</td>
      <td>The maximum value for this field.</td>
    </tr>
    <tr>
      <td><code>data-cgbf-captcha<code></td>
      <td>&lt;div&gt; or &lt;span&gt; or &lt;p&gt;</td>
      <td></td>
      <td>Marks a container for placing catcha HTML code. If captcha is available.</td>
    </tr>
    <tr>
      <td><code>data-cgbf-captcha-input<code></td>
      <td>&lt;div&gt; or &lt;span&gt; or &lt;p&gt;</td>
      <td></td>
      <td>Marks a container for placing catcha input HTML code.</td>
    </tr>
    <tr>
      <td><code>data-cgbf-label<code></td>
      <td>type="radio" or type="checkbox"</td>
      <td>string</td>
      <td>Used on the first field of a checkbox or radio group, specifies a human-readable label for the field if none can otherwise be determined.  This label is used in the disposition process.</td>
    </tr>
    <tr>
      <td><code>data-cgbf-human<code></td>
      <td>type="radio" or type="checkbox" or &lt;option&gt;</td>
      <td>string</td>
      <td>Used to specify a human readable value to be used to denote the option in the disposition process.</td>
    </tr>
  </tbody>
</table>
</fieldset>