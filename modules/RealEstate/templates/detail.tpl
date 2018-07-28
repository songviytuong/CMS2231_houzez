{if $realestate}
<fieldset>
  <legend>{$mod->Lang('realestate_detail')}</legend>
  <div class="row">
    <p class="col-sm-2 text-right">{$mod->Lang('title')}:</p>
    <p class="col-sm-10">{$realestate->title}</p>
  </div>
</fieldset>
{else}
  <div class="alert alert-danger">{$mod->Lang('error_notfound')}</div>
{/if}