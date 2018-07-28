{$startform}
<fieldset>
  <legend>{$mod->Lang('prompt_general_settings')}:</legend>
  <div class="pageoverflow">
    <p class="pagetext"><label for="prepend_website_http">{$mod->Lang('prompt_prepend_website_http')}:</label></p>
    <p class="pageinput">
      <select id="prepend_website_http" name="{$actionid}prepend_website_http">
        {cge_yesno_options selected=$prepend_website_http}
      </select>
      <br/>{$mod->Lang('info_prepend_website_http')}
    </p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext"><label for="allow_duplicate_companynames">{$mod->Lang('prompt_allowduplicatecompanynames')}:</label></p>
    <p class="pageinput">
      <select id="allow_duplicate_companynames" name="{$actionid}allow_duplicate_companynames">
        {cge_yesno_options selected=$allow_duplicate_companynames}
      </select>
    </p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext"><label for="collectstats">{$mod->Lang('prompt_collectstats')}:</label></p>
    <p class="pageinput">
      <select id="collectstats" name="{$actionid}collectstats">
        {cge_yesno_options selected=$collectstats}
      </select>
      <br/>{$mod->Lang('info_collectstats')}
    </p>
  </div>
</fieldset>

<fieldset>
  <legend>{$mod->Lang('prompt_admin_edit_settings')}:</legend>
  <div class="pageoverflow">
    <p class="pagetext"><label for="adminwysiwyg">{$mod->Lang('prompt_adminwysiwyg')}:</label></p>
    <p class="pageinput">
      <select id="adminwysiwyg" name="{$actionid}adminwysiwyg">
        {cge_yesno_options selected=$adminwysiwyg}
      </select>
      <br/>{$mod->Lang('info_adminwysiwyg')}
    </p>
  </div>
</fieldset>

{if isset($frontendcreate)}
<fieldset>
  <legend>{$mod->Lang('prompt_feu_edit_settings')}:</legend>
  <div class="pageoverflow">
    <p class="pagetext"><label for="frontendcreate">{$mod->Lang('prompt_feu_create')}:</label></p>
    <p class="pageinput">
      <select id="frontendcreate" name="{$actionid}frontendcreate">
        {cge_yesno_options selected=$frontendcreate}
      </select>
    </p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext"><label for="frontenddelete">{$mod->Lang('prompt_feu_delete')}:</label></p>
    <p class="pageinput">
      <select id="frontenddelete" name="{$actionid}frontenddelete">
        {cge_yesno_options selected=$frontenddelete}
      </select>
    </p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('prompt_feu_new_status')}:</p>
    <p class="pageinput">
      <select id="frontendnewstatus" name="{$actionid}frontendnewstatus">
        {html_options options=$statuses selected=$frontendnewstatus}
      </select>
    </p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('prompt_feu_change_status')}:</p>
    <p class="pageinput">
      <select id="frontendchangestatus" name="{$actionid}frontendchangestatus">
        {cge_yesno_options selected=$frontendchangestatus}
      </select>
    </p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext"><label for="frontendnumrecords">{$mod->Lang('prompt_feu_numrecords')}:</label></p>
    <p class="pageinput">
      <select id="frontendnumrecords" name="{$actionid}frontendnumrecords">
        {html_options options=$nums selected=$frontendnumrecords}
      </select>
    </p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext"><label for="frontendimport">{$mod->Lang('prompt_feu_import')}:</label></p>
    <p class="pageinput">
      <select id="frontendimport" name="{$actionid}frontendimport">
        {cge_yesno_options selected=$frontendimport}
      </select>
    </p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext"><label for="frontend_emailonadd">{$mod->Lang('prompt_feu_emailonadd')}:</label></p>
    <p class="pageinput">
      <select id="frontend_emailonadd" name="{$actionid}frontend_emailonadd">
        {cge_yesno_options selected=$frontend_emailonadd}
      </select>
    </p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext"><label for="frontend_emailonedit">{$mod->Lang('prompt_feu_emailonedit')}:</label></p>
    <p class="pageinput">
      <select id="frontend_emailonedit"> name="{$actionid}frontend_emailonedit">
        {cge_yesno_options selected=$frontend_emailonedit}
      </select>
    </p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext"><label for="frontend_emailgroup">{$mod->Lang('prompt_feu_emailgroup')}:</label></p>
    <p class="pageinput">
      <select id="frontend_emailgroup" name="{$actionid}frontend_emailgroup">
        {html_options options=$grouplist selected=$frontend_emailgroup}
      </select>
    </p>
  </div>
</fieldset>

<fieldset>
  <legend>{$mod->Lang('prompt_feu_display_settings')}:</legend>
  <div class="pageoverflow">
    <p class="pagetext">{$prompt_detailpage}:</p>
    <p class="pageinput">{$input_detailpage}</p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext"><label for="sortorder">{$mod->Lang('prompt_summarysortorder')}:</label></p>
    <p class="pageinput">
      <select id="sortorder" name="{$actionid}sortorder">
        {html_options options=$sortorders selected=$sortorder}
      </select>
    </p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext"><label for="sortby">{$mod->Lang('prompt_summarysorting')}:</label></p>
    <p class="pageinput">
      <select id="sortby" name="{$actionid}sortby">
        {html_options options=$sortings selected=$sortby}
      </select>
    </p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext"><label for="frontend_showexpired">{$mod->Lang('prompt_frontend_showexpired')}:</label></p>
    <p class="pageinput">
      <select id="frontend_showexpired" name="{$actionid}frontend_showexpired">
        {cge_yesno_options selected=$frontend_showexpired}
      </select>
    </p>
  </div>
</fieldset>
{/if}

<div class="pageoverflow">
  <p class="pagetext"></p>
  <p class="pageinput">
    <input type="submit" name="{$actionid}submit" value="{$mod->Lang('submit')}"/>
  </p>
</div>

{$endform}