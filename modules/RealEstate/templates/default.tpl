<div class="holidayWrapper">
    {foreach $real_items as $item}
        <div class="realestate">
            <div class="row">
                <div class="col-sm-6">
                    <a href="{cms_action_url action='detail' rid=$item->real_id}">{$item->real_name}</a>
                </div>
            </div>
        </div>
    {foreachelse}
        <div class="alert alert-danger">{$mod->Lang('sorry_norealestates')}</div>
    {/foreach}
</div>