<script type="text/javascript">
    $(document).ready(function () {
        $('a.del_realestate').click(function () {
            return confirm('{$mod->Lang('confirm_delete')}');
        })
    });
</script>
<div class="pageoptions">
    <a href="{cms_action_url action=edit_realestate}">{admin_icon icon='newobject.gif'}
        {$mod->Lang('add_realestate')}
    </a>
</div>
{if !empty($real_items)}
    <table class="pagetable">
        <thead>
            <tr>
                <th>{$mod->Lang('title')}</th>
                <th class="pageicon">{* edit icon *}</th>
                <th class="pageicon">{* delete icon *}</th>
            </tr>
        </thead>
        <tbody>
            {foreach $real_items as $item}
                {cms_action_url action=edit_realestate rid=$item->real_id assign='edit_url'}
                <tr>
                    <td><a href="{$edit_url}" title="{$mod->Lang('edit')}">{$item->title}</a></td>
                    <td><a href="{$edit_url}" title="{$mod->Lang('edit')}">
                            {admin_icon icon='edit.gif'}</a>
                    </td>
                    <td><a class="del_realestate" href="{cms_action_url action=delete_realestate rid=$item->real_id}"
                           title="{$mod->Lang('delete')}">{admin_icon icon='delete.gif'}</a></td>
                </tr>
            {/foreach}
        </tbody>
    </table>
{/if}