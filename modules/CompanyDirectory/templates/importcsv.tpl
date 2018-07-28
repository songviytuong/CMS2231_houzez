<script type="text/javascript">
function _valsdefs(str) {
  $('#'+str+'vals :input').change(function(){
    var v = $(this).val();
    if( v == 1 ) {
      $('#'+str+'defs').show();
    } else {
      $('#'+str+'defs').hide();
    }
  });
  $('#'+str+'vals :input').trigger('change');
}
$(document).ready(function(){
  _valsdefs('field')
  _valsdefs('category')
  _valsdefs('hierarchy')
});
</script>

<h3>{$mod->Lang('importcsv')}</h3>

<div class="information" style="display: block;">{$mod->Lang('info_importformat')}</div>

{$formstart}
<div class="pageoverflow">
  <p class="pagetext">{$mod->Lang('prompt_delimeter')}:</p>
  <p class="pageinput">
   <input type="text" name="{$actionid}delimeter" value="{$mod->GetPreference('import_delimeter')}" size="4" maxlength="4"/>
  </p>
</div>

<div class="pageoverflow">
  <p class="pagetext">{$mod->Lang('prompt_enclosure')}:</p>
  <p class="pageinput">
   <input type="text" name="{$actionid}enclosure" value="{$mod->GetPreference('import_enclosure')}" size="4" maxlength="4"/>
  </p>
</div>

<div class="pageoverflow">
  <p class="pagetext">{$mod->Lang('prompt_check_duplicates')}</p>
  <p class="pageinput">
    <select name="{$actionid}check_duplicates">
      {html_options options=$duplicate_opts selected=$mod->GetPreference('import_checkduplicates')}
    </select>
  </p>
</div>

<div class="pageoverflow" id="fieldvals">
  <p class="pagetext">{$mod->Lang('prompt_import_fieldvals')}</p>
  <p class="pageinput">
    {cge_yesno_options prefix=$actionid name=do_fieldvals selected=$mod->GetPreference('import_fieldvals')}
    <br/>{$mod->Lang('info_import_fieldvals')}
  </p>
</div>

<div class="pageoverflow" id="fielddefs" style="margin-left: 2em;">
  <p class="pagetext">{$mod->Lang('prompt_import_fielddefs')}</p>
  <p class="pageinput">
    {cge_yesno_options prefix=$actionid name=do_fielddefs selected=$mod->GetPreference('import_fielddefs')}
    <br/>{$mod->Lang('info_import_fielddefs')}
  </p>
</div>


<div class="pageoverflow" id="categoryvals">
  <p class="pagetext">{$mod->Lang('prompt_import_categoryvals')}:</p>
  <p class="pageinput">
    {cge_yesno_options prefix=$actionid name=do_categoryvals selected=$mod->GetPreference('import_categoryvals')}
    <br/>{$mod->Lang('info_import_categoryvals')}
  </p>
</div>

<div class="pageoverflow" id="categorydefs" style="margin-left: 2em;">
  <p class="pagetext">{$mod->Lang('prompt_import_categorydefs')}</p>
  <p class="pageinput">
    {cge_yesno_options prefix=$actionid name=do_categorydefs selected=$mod->GetPreference('import_categorydefs')}
    <br/>{$mod->Lang('info_import_categorydefs')}
  </p>
</div>

<div class="pageoverflow" id="hierarchyvals">
  <p class="pagetext">{$mod->Lang('prompt_import_hierarchyvals')}</p>
  <p class="pageinput">
    {cge_yesno_options prefix=$actionid name=do_hierarchyvals selected=$mod->GetPreference('import_hierarchyvals')}
    <br/>{$mod->Lang('info_import_hierarchyvals')}
  </p>
</div>

<div class="pageoverflow" id="hierarchydefs" style="margin-left: 2em;">
  <p class="pagetext">{$mod->Lang('prompt_import_hierarchydefs')}:</p>
  <p class="pageinput">
    {cge_yesno_options prefix=$actionid name=do_hierarchydefs selected=$mod->GetPreference('import_hierarchydefs')}
    <br/>{$mod->Lang('info_import_hierarchydefs')}
  </p>
</div>

{if $can_lookup}
<div class="pageoverflow">
  <p class="pagetext">{$mod->Lang('prompt_import_lookuplatlong')}</p>
  <p class="pageinput">
    {cge_yesno_options prefix=$actionid name=do_lookuplatlong selected=$mod->GetPreference('import_lookuplatlong')}
  </p>
</div>
{/if}

{if $url_optional}
<div class="pageoverflow">
  <p class="pagetext">{$mod->Lang('prompt_create_url')}</p>
  <p class="pageinput">
    {cge_yesno_options prefix=$actionid name=create_url selected=$mod->GetPreference('import_create_url')}
    <br/>
    {$mod->Lang('info_create_url')}
  </p>
</div>
{/if}

<div class="pageoverflow">
  <p class="pagetext">{$mod->Lang('prompt_import_csvfile')}</p>
  <p class="pageinput">
    <input type="file" name="{$actionid}csvfile" size="40"/>
  </p>
</div>


<div class="pageoverflow">
  <p class="pagetext">&nbsp;</p>
  <p class="pageinput">
   <input type="submit" name="{$actionid}submit" value="{$mod->Lang('submit')}"/>
   <input type="submit" name="{$actionid}cancel" value="{$mod->Lang('cancel')}"/>
  </p>
</div>
{$formend}