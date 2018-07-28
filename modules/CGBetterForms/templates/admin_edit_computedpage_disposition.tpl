<h3>{$mod->Lang('name_ComputedPageDisposition')}</h3>

{form_start form_guid=$form_guid disp_guid=$guid editor_name=$editor_name}
<div class="pageoverflow">
  <input type="submit" name="{$actionid}submit" value="{$mod->Lang('submit')}"/>
  <input type="submit" name="{$actionid}cancel" value="{$mod->Lang('cancel')}" formnovalidate/>
</div>

<div class="pageoverflow">
  <p class="pagetext">{$mod->Lang('prompt_page_tpl')}:</p>
  <p class="pageinput">
     {cge_textarea prefix=$actionid name=template value=$handler->template rows=5}
     <br/>{$mod->Lang('info_page_tpl')}
  </p>
</div>
{form_end}
{$tpl_help}
