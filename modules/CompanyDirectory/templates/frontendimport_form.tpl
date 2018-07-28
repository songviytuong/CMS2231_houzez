{$iformstart}
<div class="pageoverflow">
  <p class="pagetext">{$mod->Lang('prompt_import_template')}</p>
  <p class="pageinput">
    <textarea name="{$actionid}feimport_template">{$feimport_template}</textarea>
    <br/>
    <input type="submit" name="{$actionid}feimport_submit" value="{$mod->Lang('submit')}"/>
    <input type="submit" name="{$actionid}feimport_reset" value="{$mod->Lang('resettofactory')}"/>
  </p>
</div>
{$iformend}