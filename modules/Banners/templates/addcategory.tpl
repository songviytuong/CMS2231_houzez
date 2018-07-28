<h3>{$mod->Lang('addcategory')}</h3>

{$startform}
  <div class="pageoverflow">
    <p class="pageinput">
      <input type="submit" name="{$actionid}submit" value="{$mod->Lang('submit')}"/>
      <input type="submit" name="{$actionid}cancel" value="{$mod->Lang('cancel')}"/>
    </p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('prompt_categoryname')}:</p>
    <p class="pageinput">
      <input type="text" name="{$actionid}name" value="{$category->name}" size="20"/>
    </p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('prompt_categorydesc')}:</p>
    <p class="pageinput">
      <input type="text" name="{$actionid}description" value="{$category->description}" size="80"/>
    </p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('prompt_dflt_image')}:</p>
    <p class="pageinput">
       {cms_filepicker name="{$actionid}dflt_image" value="{$category->dflt_image}"}
    </p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('prompt_dflt_url')}:</p>
    <p class="pageinput">
       <input type="text" name="{$actionid}dflt_url" value="{$category->dflt_url}" size="80" maxlength="255"/>
    </p>
  </div>
  <div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('template')}:</p>
    <p class="pageinput">
      {cge_textarea prefix=$actionid name=template syntax=1 value=$category->template}
    </p>
  </div>
{$endform}
