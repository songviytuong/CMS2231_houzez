{cgbf_form_errors assign='errors'}
{if !empty($errors)}
  <ul class="error">
  {foreach $errors as $err}
    <li>{$err}</li>
  {/foreach}
  </ul>
{/if}

<form>

  <div class="row">
     <label for="myname">Your Name:</label>
     <input id="myname" class="form-control" name="name" value="{$form_data->name}" required/>
  </div>

  <div class="row">
     <label for="myemail">Your Email:</label>
     <input id="myemail" class="form-control" type="email" name="email" value="{$form_data->email}" required/>
  </div>

  <div class="row">
     <label for="comments">Your Comments:</label>
     <textarea id="comments" class="form-control" name="comments" required>{$form_data->contents}</textarea>
  </div>

  <div data-cgbf-captcha></div>

  <div class="row">
    <button type="reset">Reset</button>
    <button type="submit">Submit</button>
  </div>
</form>