{cgbf_form_errors assign='errors'}
{if !empty($errors)}
  <ul class="error">
  {foreach $errors as $err}
    <li>{$err}</li>
  {/foreach}
  </ul>
{/if}

<form>
  <h3>A more advanced contact form</h3>

  <div class="form-group">
     <label for="myname">Your Name:</label>
     <input id="myname" class="form-control" name="name" value="{$form_data->name}" required/>
  </div>

  <div class="form-group">
     <label for="myemail">Your Email:</label>
     <input id="myemail" class="form-control" type="email" name="email" value="{$form_data->email}" required/>
  </div>

  <div class="form-group">
     <label for="phone">Phone Number (10 digits):</label>
     <input id="phone" class="form-control" type="text" name="phone" value="{$form_data->phone}" pattern="[0-9]{ldelim}10,11{rdelim}"/>
  </div>

  <div class="form-group">
     <label for="duedate">Due Date:</label>
     <input id="duedate" class="form-control" type="date" name="duedate" value="{$form_data->duedate}" data-cgbf-min="{$smarty.now|date_format:'%Y-%m-%d'}"/>
  </div>

  <div class="form-group">
     <label for="inquiry_type">How did you hear about us:</label>
     <select id="inquiry_type" class="form-control" name="inquiry_type" data-cgbf-required data-cgbf-selected="webad">
        <option value="" label="none"></option>
	<option value="webad" data-cgbf-human="Web Advertisement">Via a web ad</option>
	<option value="search" data-cbgf-human="Search Engine">Internet search</option>
	<option value="friend">From a friend</option>
	<option value="customer" data-cgbf-human="Customer">I am a current/past customer</option>
     </select>
     <foo>{* this invalid tag is here intentionally, to illustrate some of the form scanning process *}
  </div>

  <div class="form-group">
     <label for="comments">Your Comments:</label>
     <textarea id="comments" class="form-control" name="comments" data-cgbf-required>{$form_data->contents}</textarea>
  </div>

  <div class="form-group">
     <label for="image">Image Attachment (required)</label>
     <input id="image" class="form-control" type="file" name="image" accept="image/*" data-cgbf-maxsize=50000 data-cgbf-required/>
  </div>

  <div class="form-group">
     <label for="priority">Priority</label>
     <input id="priority" class="form-control" type="number" name="priority" value="{$form_data->priority|default:5}" data-cgbf-required/>
  </div>

  <div class="form-group">
     <p>Please contact me via:</p>
     <label><input class="form-control" type="radio" name="contact_by" value="email" data-cgbf-label='Contact Via' data-cgbf-selected="{$form_data->contact_by|default:'email'}"/> Email</label>
     <label><input class="form-control" type="radio" name="contact_by" value="phone" data-cgbf-selected="{$form_data->contact_by|default:'email'}"/> Phone</label>
  </div>

  <div data-cgbf-captcha>{* captcha will be appended here *}</div>
  <div data-cgbf-captcha-input>{* captcha input field, if necessary will be appended here *}</div>

  <div class="form-group">
    <button type="reset">Reset</button>
    <button type="submit">Submit</button>
  </div>
</form>
