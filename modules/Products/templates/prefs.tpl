{$startform}
<fieldset>
    <legend>{$mod->Lang('general_settings')}:</legend>
    <div class="c_full cf">
        <label class="grid_3">{$mod->Lang('prompt_custom_modulename')}:</label>
        <div class="grid_8"><input type="text" name="{$actionid}custom_modulename" size="20" maxlength="50" value="{$custom_modulename}"/></div>
    </div>
    <div class="c_full cf">
        <label class="grid_3">{$mod->Lang('prompt_urlprefix')}:</label>
        <div class="grid_8"><input type="text" name="{$actionid}urlprefix" size="20" maxlength="20" value="{$urlprefix}"/></div>
    </div>
    {if isset($input_currencysymbol)}
        <div class="c_full cf">
            <label class="grid_3">{$prompt_currencysymbol}:</label>
            <div class="grid_8">{$input_currencysymbol}</div>
        </div>
        <div class="c_full cf">
            <label class="grid_3">{$prompt_weightunits}:</label>
            <div class="grid_8">{$input_weightunits}</div>
        </div>
        <div class="c_full cf">
            <label class="grid_3">{$prompt_lengthunits}:</label>
            <div class="grid_8">{$input_lengthunits}</div>
        </div>
    {/if}
    <hr/>
    <div class="c_full cf">
        <input type="submit" class="grid_4" name="{$actionid}setecomhandlers" value="{$mod->Lang('btn_setecomhandlers')}"/>
        <div class="grid_7">
            {$mod->Lang('info_setecomhandlers')}
        </div>
    </div>
</fieldset>

<fieldset>
    <legend>{$mod->Lang('product_editing_settings')}:</legend>
    <div class="c_full cf">
        <label class="grid_3">{$mod->Lang('prompt_sku_required')}:</label>
        <div class="grid_8">
            {cge_yesno_options prefix=$actionid name='skurequired' selected=$skurequired}
        </div>
    </div>
    <div class="c_full cf">
        <label class="grid_3">{$mod->Lang('prompt_default_taxable')}:</label>
        <div class="grid_8">{$input_taxable}</div>
    </div>
    <div class="c_full cf">
        <label class="grid_3">{$mod->Lang('prompt_default_status')}:</label>
        <div class="grid_8">{$input_status}</div>
    </div>
    <div class="c_full cf">
        <label class="grid_3">{$mod->Lang('prompt_deleteproductfiles')}:</label>
        <div class="grid_8">{$input_deleteproductfiles}</div>
    </div>
    {if !empty($feu_grouplist)}
        <div class="c_full cf">
            <label class="grid_3">{$mod->Lang('feu_owner_group')}:</label>
            <select class="grid_8" name="{$actionid}feu_ownergroup">
                {html_options options=$feu_grouplist selected=$feu_ownergroup}
            </select>
        </div>
    {/if}
    <hr/>

    <h4>{$mod->Lang('prompt_slugtemplate')}</h4>
    <div class="c_full cf">
        <textarea class="grid_12" name="{$actionid}slugtemplate" rows="3">{$slugtemplate}</textarea>
        <div class="grid_12">{$mod->Lang('info_slugtemplate')}</div>
    </div>

</fieldset>

<fieldset>
    <legend>{$mod->Lang('product_summary_settings')}:</legend>
    <div class="c_full cf">
        <label class="grid_3">{$mod->Lang('prompt_summary_newdefault')}:</label>
        <div class="grid_8">
            {cge_yesno_options prefix=$actionid name='summary_newdefault' selected=$summary_newdefault}
        </div>
    </div>
    <div class="c_full cf">
        <label class="grid_3">{$mod->Lang('prompt_summarypagelimit')}:</label>
        <div class="grid_8">
            <input type="text" name="{$actionid}summary_pagelimit" size="5" maxlength="5" value="{$summary_pagelimit}"/>
        </div>
    </div>
    <div class="c_full cf">
        <label class="grid_3">{$prompt_summarysortorder}:</label>
        <div class="grid_8">{$input_summarysortorder}</div>
    </div>
    <div class="c_full cf">
        <label class="grid_3">{$prompt_summarysorting}:</label>
        <div class="grid_8">{$input_summarysorting}</div>
    </div>
</fieldset>

<fieldset>
    <legend>{$mod->Lang('product_detail_settings')}:</legend>
    <div class="c_full cf">
        <label class="grid_3">{$mod->Lang('prompt_usehierpathurls')}:</label>
        <div class="grid_8">
            {$input_usehierpathurls}
            <p>{$mod->Lang('deprecated')}</p>
        </div>
    </div>
    <div class="c_full cf">
        <label class="grid_3">{$prompt_detailpage}:</label>
        <div class="grid_8">{$input_detailpage}</div>
    </div>
    <div class="c_full cf">
        <label class="grid_3">{$mod->Lang('prompt_use_detailpage_for_search')}:</label>
        <div class="grid_8">
            {$input_use_detailpage_for_search}
        </div>
    </div>
    <div class="c_full cf">
        <label class="grid_3">{$mod->Lang('prompt_notfound_behavior')}:</label>
        <div class="grid_8">
            <select name="{$actionid}prodnotfound">
                {html_options options=$notfound_opts selected=$prodnotfound}
            </select>
            <p>{$mod->Lang('info_prodnotfound')}</p>
        </div>
    </div>
    <div class="c_full cf">
        <label class="grid_3">{$mod->Lang('prompt_notfound_page')}:</label>
        <div class="grid_8">
            {$input_prodnotfoundpage}
        </div>
    </div>
    <div class="c_full cf">
        <label class="grid_3">{$mod->Lang('prompt_notfound_msg')}:</label>
        <div class="grid_8">
            <textarea name="{$actionid}prodnotfoundmsg" rows="5" cols="70">{$prodnotfoundmsg}</textarea>
        </div>
    </div>
</fieldset>

<fieldset>
    <legend>{$mod->Lang('hierarchy_settings')}:</legend>
    <div class="c_full cf">
        <label class="grid_3">{$mod->Lang('prompt_hierpage')}:</label>
        <div class="grid_8">
            {$input_hierpage}
            <p>{$mod->Lang('info_hierpage')}</p>
        </div>
    </div>
    <div class="c_full cf">
        <label class="grid_3">{$mod->Lang('prompt_prettyhierurls')}:</label>
        <div class="grid_8">
            {cge_yesno_options prefix=$actionid name='prettyhierurls' selected=$prettyhierurls}
            <p>{$mod->Lang('info_prettyhierurls')}</p>
        </div>
    </div>
</fieldset>

<fieldset>
    <legend>{$mod->Lang('upload_settings')}:</legend>
    <div class="c_full cf">
        <label class="grid_3">{$mod->Lang('prompt_allowed_imagetypes')}:</label>
        <div class="grid_8">{$input_allowed_imagetypes}</div>
    </div>
    <div class="c_full cf">
        <label class="grid_3">{$mod->Lang('prompt_allowed_filetypes')}:</label>
        <div class="grid_8">{$input_allowed_filetypes}</div>
    </div>
</fieldset>

<fieldset>
    <legend>{$mod->Lang('multiple_languages')}:</legend>
    <div class="c_full cf">
        <label class="grid_3">{$allowmle}:</label>
        <div class="grid_8">{$allowmleinput}</div>
    </div>
</fieldset>

<fieldset>
    <legend>{$mod->Lang('support_travel')}:</legend>
    <div class="c_full cf">
        <label class="grid_3">{$allowtravel}:</label>
        <div class="grid_8">{$allowtravelinput}</div>
    </div>
</fieldset>

<div class="c_full cf">
    <div class="grid_8">{$submit}</div>
</div>

{$endform}
