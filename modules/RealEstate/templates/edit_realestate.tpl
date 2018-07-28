<h3>{$mod->Lang('edit')}</h3>
{form_start rid=$realestate->real_id}
<div class="pageoverflow">
    <p class="pageinput">
        <input type="submit" name="{$actionid}submit" value="{$mod->Lang('submit')}"/>
        <input type="submit" name="{$actionid}cancel" value="{$mod->Lang('cancel')}"/>
    </p>
</div>
<div class="pageoverflow">
    <p class="pagetext">{$mod->Lang('title')}:</p>
    <p class="pageinput">
        <input type="text" name="{$actionid}title" value="{$realestate->title}"/>
    </p>
</div>
{form_end}
