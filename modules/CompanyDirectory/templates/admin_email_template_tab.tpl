{* admin email form *}
{$formstart}
<div class="pageoverflow">
  <p class="pagetext">{$mod->Lang('prompt_email_subject')}:</p>
  <p class="pageinput">
  <input type="text" name="{$actionid}email_subject" size="80" maxlength="255" value="{$email_subject}"/>
  </p>
</div>
<div class="pageoverflow">
  <p class="pagetext">{$mod->Lang('prompt_email_ishtml')}:</p>
  <p class="pageinput">
    <input type="hidden" name="{$actionid}email_ishtml" value="0"/>
    <input type="checkbox" name="{$actionid}email_ishtml" value="1" {if $email_ishtml}checked="checked"{/if}/>
  </p>
</div>
<div class="pageoverflow">
  <p class="pagetext">{$mod->Lang('prompt_email_template')}:</p>
  <p class="pageinput">
  <textarea name="{$actionid}email_template">{$email_template}</textarea>
  </p>
</div>
<div class="pageoverflow">
  <p class="pagetext"></p>
  <p class="pageinput">
    <input type="submit" name="{$actionid}submit" value="{$mod->Lang('submit')}"/>
    <input type="submit" name="{$actionid}reset" value="{$mod->Lang('reset_to_factory')}"/>
  </p>
</div>
{$formend}