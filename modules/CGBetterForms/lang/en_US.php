<?php
$lang['prompt_uniquefile_filenametpl'] = 'File name template';
$lang['info_uniquefile_filenametpl'] = 'Specify a template used to create the output filename.  Note, the filename should ensure uniqueness, or overwriting may occur.  If the template is empty, or the template does not result in any output after processing, then the unique request id will be used.';
$lang['err_captcha_mismatch'] = 'Sorry, incorrect captcha value';
$lang['validate_captcha'] = 'Validate Captcha';
$lang['use_async_upload'] = 'Upload files asynchronously';
$lang['info_use_async_upload'] = 'If enabled, javascript will be appended to the form to allow uploading files asynchronously.  This greatly improves usability when uploading multiple files';
$lang['varhelp_form'] = 'The Form object itself.';
$lang['varhelp_response'] = 'The FormResponse object itself.';
$lang['edit_csv_disposition'] = 'Save results to a flat file';
$lang['info_flatfile_filename'] = 'Specify the name of the file (relative to the site root)';
$lang['prompt_file'] = 'File';
$lang['msg_formexporteed'] = 'Form exported';
$lang['msg_imported'] = 'Form imported';
$lang['err_import_validation_notfound'] = 'Sorry, we could not find a registered validation of type %s.  This form cannot be imported';
$lang['err_import_disposition_notfound'] = 'Sorry, we could not find a registered disposition of type %s.  This form cannot be imported';
$lang['err_import_format'] = 'Sorry, but there was a problem with the format of the data';
$lang['err_noupload'] = 'You must select a file to upload';
$lang['err_badupload'] = 'There was a problem uploading the selected file';
$lang['import_form'] = 'Import form';
$lang['export_form'] = 'Export this form';
$lang['name_SessionDisposition'] = 'Store form results in the session for further processing';
$lang['display_EmailAdminWithReplyTo'] = 'Email fixed addesses, and set reply-to as value provided in %s field';
$lang['info_emailuseraddress'] = 'Select a form field that should contain a user supplied email address';
$lang['name_EmailAdminWithReplyTo'] = 'Send an email to fixed addresses, with reply-to as user address';
$lang['err_nocontents'] = 'Sorry, but it seems there is no content (or at least no valid HTML) in your form template.';
$lang['name_FileValidator'] = 'Validate uploaded files';
$lang['prompt_prerender_logic'] = 'Pre-render Logic';
$lang['info_prerender_tab'] = '<p>Use the text area below to adjust the $form_data object that is available when your form is initially rendered.<br/><strong>Note:</strong> This logic is not evaluated when handling the form response.</p><p><em>hint</em>:  Use <code>{cgbf_set key=fieldname value=thevalue}</code></p>';
$lang['prerender_logic'] = 'Pre-render Logic';
$lang['auto_add_validations'] = 'Auto Add Validations';
$lang['apply'] = 'Apply';
$lang['info_stopdisposing_tpl'] = 'Provide a test <em>(via a smarty template)</em> to indicate whether any further processing of dispositions should be prevented.<br/>If the result of processing this template returns anything other than an empty string all further disposition processing except the final action, will stop.  i.e.:
<pre>{if $some_dropdown_field == &quot;some_value&quot;}1{/if}</pre>';
$lang['display_StopDisposingDisposition'] = 'Stop processing dispositions based on a condition';
$lang['name_StopDisposingDisposition'] = 'Stop processing dispositions based on a condition';
$lang['err_form_actionattr'] = 'Your form tag has an action attribute.  This will be replaced when the form is rendered.';
$lang['err_form_methodattr'] = 'Your form tag has a method attribute.  This will be replaced when the form is rendered.';
$lang['err_form_enctypeattr'] = 'Your form tag has an enctype attribute.  This will be replaced when the form is rendered.';
$lang['info_templatevalidation'] = 'Use the contents of this smarty template to evaluate the data submitted to the form.  If the template returns any valid (non whitespace) output, it will be interpreted as an error and the output used as an error message.  Here is a simple example:<br/>
<pre>{if $a < 0 || $a > 20}Valid values for the &quot;a&quot; field are between 0 and 20{/if}</pre>';
$lang['display_TemplateValidation'] = 'Validate via Smarty Template';
$lang['name_TemplateValidation'] = 'Validate via Smarty Template';
$lang['param_form'] = 'The form name to render and process';
$lang['param_nodatecheck'] = 'Specify a positive integer to disable date checking when rendering a form.  This is useful for development and testing purposes, but should not be used in a production system.';
$lang['err_field_invalidvalue'] = 'The value for the %s field is invalid';
$lang['attribs'] = 'Attributes';
$lang['attr_multiple'] = 'multiple';
$lang['attr_novalidate'] = 'novalidate';
$lang['attr_min'] = 'min';
$lang['attr_max'] = 'max';
$lang['attr_pattern'] = 'pattern';
$lang['err_form_versionchange'] = 'This form was last saved with a different version of CGBetterForms... please scan and save the form.';
$lang['name_DatePrimitiveValidator'] = 'Ensure a reasonable value for all date fields';
$lang['display_DatePrimitiveValidator'] = 'Ensure a reasonable value for all date fields';
$lang['err_input_outofrange'] = 'One or more values of the %s field are outside of the allowed limits';
$lang['display_RedirectURLDisposition'] = 'Redirect to a computed URL';
$lang['info_redirecturl_template'] = 'The output of this template should be a simple URL in a string.  If non empty, and a valid URL then the system will redirect to this URL via GET.';
$lang['prompt_redirecturl_template'] = 'URL Template';
$lang['name_RedirectURLDisposition'] = 'Redirect to a computed URL';
$lang['display_ComputedPageDisposition'] = 'Redirect to a computed page alias/id';
$lang['prompt_page_tpl'] = 'Page alias template';
$lang['info_page_tpl'] = 'The output of this smarty template should be a single page alias or id to redirect to.  If nothing is output, then this disposition will be ignored';
$lang['display_EmailUserAddressDisposition'] = 'Send a copy of the submission to the user address specified in the %s field';
$lang['edit_ComputedPageDisposition'] = 'Redirect to a computed page alias/id';
$lang['name_ComputedPageDisposition'] = 'Redirect to a computed page alias/id';
$lang['prompt_email_field'] = 'Email address field';
$lang['name_EmailUserAddressDisposition'] = 'Send email to user supplied address';
$lang['msg_scanned_saveneeded'] = 'The form template has been scanned.  Please ensure that you save the form';
$lang['form_from_email'] = 'Reply-to Email Address';
$lang['emailaddr_sysdflt'] = 'Use system default';
$lang['none'] = 'None';
$lang['form_from_name'] = 'Email reply-to Name';
$lang['info_form_from_email'] = 'Specify an email address for the reply-to address for emails sent by this form.  If not specified, then system default information will be used.
<br/><strong>Note:</strong> This adjusts the reply-to address in the email from the system defaults.  Some dispositions may further modify the reply-to header.';
$lang['info_form_from_name'] = 'Specify a name to use with the reply-to address for emails sent by this form.  If not specified, no value will be used';
$lang['display_FileValidator'] = 'Ensure all uploads conform to specifications in attributes';
$lang['auto_validations'] = 'Auto Validations';
$lang['display_EmailPrimitiveValidator'] = 'Ensure a reasonable value for all email fields';
$lang['name_EmailPrimitiveValidator'] = 'Ensure a reasonable value for all email fields';
$lang['display_RequiredFieldValidator'] = 'Validate that all required fields are present';
$lang['name_RequiredFieldValidator'] = 'Validate that all required fields are present';
$lang['err_input_missingrequiredvalue'] = 'A value was not submitted for the %s field';
$lang['form_auto_validations'] = 'Use automatic validations';
$lang['info_auto_validations'] = 'If enabled, server side validation will be done based on attributes detected for each element in the form template.  Otherwise, you must manually validate each field';
$lang['err_upload_size'] = 'Sorry, but the files you uploaded for the %s field are too large.';
$lang['err_upload_type'] = 'Sorry, but files of this type are not allowed for field %s';
$lang['err_upload_extension'] = 'Sorry, but files of this type are not allowed for field %s';
$lang['title_templating_help'] = 'Form templating help';
$lang['varhelp_cgbf_submit_time'] = 'The unix timestamp of the time the user submitted the form.<br/><em>(hint: use the date_format modifier to format the timestamp into something readable for your locale)</em.';
$lang['varhelp_cgbf_submit_ip'] = 'The IP address of the user submitting the form';
$lang['varhelp_cgbf_formname'] = 'The name of the form being submitted';
$lang['varhelp_cgbf_formdesc'] = 'The description <em>(if any)</em> associated with the form.';
$lang['varhelp_cgbf_requestid'] = 'The unique id generated for each form submission.';
$lang['varhelp_cgbf_EOL'] = 'An end of line character sequence (may be platform specific).  This is suitable for use in file output templates.';
$lang['varhelp_cgbf_LF'] = 'A line feed character';
$lang['varhelp_cgbf_TAB'] = 'A tab character, suitable for use in file output templates.';
$lang['info_form_inline'] = 'If enabled, the output of this form <em>(when it is text based)</em> will replace the original tag.  This allows the tag to be in a sidebar or embedded in a content area.';
$lang['options'] = 'Options';
$lang['form_inline'] = 'Display form inline';
$lang['display_ComputedValue'] = 'Compute a value and place the result into &quot;%s&quot;';
$lang['edit_computed_value'] = 'Computed Value Field';
$lang['info_computed_value_field'] = 'Select the field that will receive the output of the template.';
$lang['prompt_template'] = 'Template';
$lang['name_ComputedValue'] = 'Compute a field value';
$lang['info_fields_tab'] = 'Below is a list of all of the input fields that will be submitted with your form.  Only input fields for which a name was detected are listed.';
$lang['no_messages'] = 'Woot! Your form is looking good.';
$lang['type_CGBetterForms'] = 'CGBetterForms';
$lang['type_Form'] = 'Form';
$lang['err_mod_validatiooneonly'] = 'Sorry, you are already using this validation on this form.';
$lang['display_WebHookDisposition'] = 'Post form results to %s';
$lang['info_webhook_extravars'] = 'Enter any extra fixed data that should be sent with the form.  One entry per line with variables and data separated with an equal sign.  i.e:<br/><pre>foo=bar<br/>foo2=bar2</pre>';
$lang['prompt_webhook_extravars'] = 'Extra form variables';
$lang['info_webhook_url'] = 'Specify the complete URL that the form results will be sent to via POST.';
$lang['prompt_webhook_url'] = 'WebHook URL';
$lang['edit_WebHookDisposition'] = 'Edit a WebHook Disposition';
$lang['name_WebHookDisposition'] = 'POST form results to a URL/WebHook';
$lang['delete'] = 'Delete';
$lang['display_UniqueFileDisposition'] = 'Store form results in a unique file in &quot;&lt;root&gt;/%s&quot;';
$lang['name_UniqueFileDisposition'] = 'Store form results in a unique file for each submission';
$lang['info_uniquefile_folder'] = 'Specify a folder <em>(relative to the CMSMS root directory) to the store output files.';
$lang['edit_uniquefile_disposition'] = 'Store results in a unique file';
$lang['prompt_uniquefile_folder'] = 'Output folder';
$lang['name_EmailFieldValidator'] = 'Ensure a specific field value contains email addresses';
$lang['edit_email_fieldvalidation'] = 'Validate that submitted value(s) for a field contain email addresses';
$lang['display_EmailFieldValidation'] = 'Ensure that values for field %s are valid email addresses';
$lang['display_RegexFieldValidation'] = 'Ensure that values for field %s match the pattern %s';
$lang['name_RegexFieldValidator'] = 'Match field values against a regular expression';
$lang['edit_regex_fieldvalidation'] = 'Validate that submitted value(s) for a field match a regular expression';
$lang['prompt_regex_pattern'] = 'Regular Expression';
$lang['msg_validation_saved'] = 'Validation saved... Please save the form.';
$lang['display_HtmlDetectionValidation'] = 'Detect HTML tags in form input';
$lang['err_security_requestguid'] = 'Sorry, something has gone wrong.  We could not find a valid unique request id in the posted data';
$lang['captcha_validate'] = 'Please validate the captcha text';
$lang['err_form_scanneeded'] = 'The template object has been modified.  Please scan the form.<br/><strong>Reminder:</strong> If you modified the input fields in this form you may also need to adjust your handler templates.';
$lang['display_DropdownEmailDisposition'] = 'Send results via email based on the value of field %s';
$lang['prompt_dflt_email_address'] = 'Default email address';
$lang['prompt_ddemail_value_map'] = 'Map field values to Email addresses';
$lang['info_dflt_email_address'] = 'Enter an email address to use in the event that a value selected by the user does not exist in the map below.';
$lang['info_ddemail_value_map'] = 'Enter a map (one entry per line) of values available in the field to email addresses.  Values should be separated from emails using a pope <em>(|)</em> character.';
$lang['edit_ddemail_disposition'] = 'Send output via email depending on a dropdown/multi-option field';
$lang['name_DropdownEmailDisposition'] = 'Send form submission via email based on a dropdown';
$lang['info_ddemail_field'] = 'The fields listed above are the fields detected to allow predefined values.  Select one of those fields to base the output filename upon.';
$lang['info_ddfile_field'] = 'The fields listed above are the fields detected to allow predefined values.  Select one of those fields to base the output filename upon.';
$lang['prompt_hdrtemplate'] = 'Header Template';
$lang['prompt_entrytemplate'] = 'Entry Template';
$lang['err_duplicate_fieldname'] = 'The field at line %s has the same name as the field at line %s';
$lang['err_duplicate_fieldid'] = 'The field at line %s has the same id (%s) as the field at line %s';
$lang['err_input_missingvalue'] = 'The %s field with name %s at about line %d is missing a value attribute';
$lang['prompt_finalaction'] = 'Behavior after all other dispositions are complete';
$lang['prompt_dofinalmsg'] = 'Display a message to the user';
$lang['prompt_dofinalredirect'] = 'Redirect to a content page';
$lang['prompt_finalpage'] = 'Page to redirect to';
$lang['prompt_finalmessage'] = 'Smarty template for the final message to display to the user';
$lang['info_final_disposition'] = 'This tab is used to define the final disposition.  It is possible that this final disposition is not performed, depending upon the behavior of other dispositions.';
$lang['info_form_handlers'] = 'This tab is used to define how the user-entered information will be processed after form submit.  Note, that it is possible that some handlers may stop the processing of further handlers, or even the final disposition. so their order may be important.';
$lang['info_form_validations'] = 'Validations are tests that are run on your form after a user submits it.  If a test fails, then an error message is displayed and your form is re-displayed.  Note that file uploads can be lost when an error occurs.';
$lang['info_form_messages'] = 'The messages below indicate potential problems detected when scanning the template provided.  Please resolve as many of these as possible to ensure that your form behaves well.';
$lang['edit'] = 'Edit';
$lang['multiple'] = 'Multiple';
$lang['msg_cancelled'] = 'Cancelled';
$lang['msg_handler_saved'] = 'Handler edited... Please save the form.';
$lang['prompt_email_body_template'] = 'Body Template';
$lang['prompt_email_subject_template'] = 'Subject Template';
$lang['prompt_csv_email_addresses'] = 'Email Addresses (csv)';
$lang['name_HtmlDetectionValidator'] = 'Detect HTML tags in input values';
$lang['name_SelectFieldValidator'] = 'Validate values for select fields';
$lang['name_FloatFieldValidator'] = 'Float Field Validator';
$lang['name_IntegerFieldValidator'] = 'Integer Field Validator';
$lang['display_FloatFieldValidation1'] = 'Validate that the %s field has a value of at least %.3f';
$lang['display_FloatFieldValidation2'] = 'Validate that the %s field has a value of no more than %.3f';
$lang['display_FloatFieldValidation3'] = 'Validate that the %s field has a value between %.3f and %.3f';
$lang['display_IntegerFieldValidation1'] = 'Validate that the %s field has a value of at least %d';
$lang['display_IntegerFieldValidation2'] = 'Validate that the %s field has a value of no more than %d';
$lang['display_IntegerFieldValidation3'] = 'Validate that the %s field has a value between %d and %d';
$lang['edit_float_fieldvalidation'] = 'Ensure that a field is a floating point value within a specified range.';
$lang['edit_integer_fieldvalidation'] = 'Ensure that a field is an integer value within a specified range.';
$lang['prompt_maxvalue'] = 'Maximum Value';
$lang['prompt_minvalue'] = 'Minimum Value';
$lang['err_mod_validationoneonly'] = 'Only one of these validations is allowed per form';
$lang['display_SelectFieldValidation'] = 'Validate the value of select fields';
$lang['add_validation'] = 'Add a validation';
$lang['error_botdetected'] = 'Hmmm... Something has gone wrong (EB001)';
$lang['msg_formsaved'] = 'Form saved';
$lang['msg_formdeleted'] = 'Form deleted';
$lang['final'] = 'Form output';
$lang['reset'] = 'Reset';
$lang['display_DropdownFileDisposition'] = 'Store results to a file in %s based on value of field %s';
$lang['reset_tpls'] = 'Reset Templates';
$lang['edit_ddfile_disposition'] = 'Save output to file depending on dropdown/multi-option field';
$lang['prompt_field'] = 'Field';
$lang['prompt_ddfile_folder'] = 'Output Folder';
$lang['id'] = 'Id';
$lang['tag'] = 'Tag';
$lang['save'] = 'Save';
$lang['display_EmailFixedAddressesDisposition1'] = 'Email results to %s';
$lang['display_EmailFixedAddressesDisposition2'] = 'Email results to %d addresses';
$lang['form'] = 'Form';
$lang['name_EmailFixedAddressesDisposition'] = 'Email results to specified addresses';
$lang['display_FlatFileDisposition'] = 'Save form results to a flat File %s';
$lang['info_FlatFile_filename'] = 'The path (relative to the website root) of the Flat file';
$lang['prompt_filename'] = 'Filename';
$lang['err_nodisposition'] = 'Please select a handler';
$lang['name_FlatFileDisposition'] = 'Save form results to a flat File';
$lang['name_DropdownFileDisposition'] = 'Save form results to a file based on a dropdown';
$lang['add_disposition'] = 'Add a Handler';
$lang['add'] = 'Add';
$lang['handler'] = 'Handler';
$lang['handlers'] = 'Handlers';
$lang['validation'] = 'Validation';
$lang['friendlyname'] = 'CGBetterForms';
$lang['moddescription'] = 'A module for handling forms that were created and designed by a developer';
$lang['add_new_form'] = 'Create a new form';
$lang['editing_form'] = 'Edit a form';
$lang['submit'] = 'Submit';
$lang['cancel'] = 'Cancel';
$lang['form_name'] = 'Form Name';
$lang['ph_form_name'] = 'Enter a unique name';
$lang['form_template'] = 'Form Template';
$lang['scan'] = 'Scan';
$lang['description'] = 'Description';
$lang['ph_form_desc'] = 'Enter a brief description of this form';
$lang['err_noforms'] = 'Could not find any form tags';
$lang['err_manyforms'] = 'Found multiple form tags';
$lang['err_missing_formstart'] = 'Could not find any form tags';
$lang['err_missing_formend'] = 'Could not find any end form tags';
$lang['err_missing_messagestring'] = 'Could not find a call to {cgbf_form_errors} in the template.';
$lang['err_input_missingname'] = 'The %s field at about line %s is missing a name.';
$lang['err_input_invalidname'] = 'The %s field at about line %s has a problematic name of: &quot;%s&quot;';
$lang['err_input_notdate'] = 'One or more values of the %s field are not valid dates.';
$lang['err_input_notemail'] = 'One or more values of the %s field are not valid email addresses.';
$lang['err_input_missinglabel'] = 'Could not find a label for field &quot;%s&quot; at about line %d.';
$lang['name'] = 'Name';
$lang['label'] = 'Label';
$lang['type'] = 'Type';
$lang['node'] = 'Node';
$lang['messages'] = 'Messages';
$lang['fields'] = 'Fields';