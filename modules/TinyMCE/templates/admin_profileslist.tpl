
{if $profiles}

  <table class="pagetable">
    <thead>
      <tr>
        <th>{$mod->Lang('id')}</th>
        <th>{$mod->Lang('profile_name')}</th>
        <th>{$mod->Lang('usergroups')}</th>
        <th>{$mod->Lang('priority')}</th>
        <th>{$mod->Lang('default')}</th>
        <th class="pageicon"></th>
        <th class="pageicon"></th>
        <th class="pageicon"></th>
      </tr>
    </thead>

    {foreach $profiles as $profile}

      {cycle values="row1,row2" assign='rowclass'}
      {cms_action_url action=admin_editprofile id_profile=$profile->id_profile assign='edit_url'}
      {cms_action_url action=admin_copyprofile id_profile=$profile->id_profile assign='copy_url'}
      {cms_action_url action=admin_deleteprofile id_profile=$profile->id_profile assign='delete_url'}

      <tr class="{$rowclass}" onmouseover="this.className='{$rowclass}hover';" onmouseout="this.className='{$rowclass}';">
        <td>
          <a href="{$edit_url}">{$profile->id_profile}</a>
        </td>
        <td>
          <a href="{$edit_url}">{$profile->name}</a>
        </td>
        <td>
          {foreach $profile->usergroups as $usergroup}{strip}
            {$usergroup->name}{if !$usergroup@last}, {/if}
          {foreachelse}
            -
          {/strip}{/foreach}
        </td>
        <td>
          {$profile->priority}
        </td>
        <td>
          {if $profile->id_profile eq $id_default_profile}
            {admin_icon icon='true.gif'}
          {else}
            <a href="{cms_action_url action=admin_setdefaultprofile id_profile=$profile->id_profile}">
              {admin_icon icon='false.gif'}
            </a>
          {/if}
        </td>
        <td><a href="{$edit_url}" title="{$mod->Lang('edit_profile')}">{admin_icon icon='edit.gif'}</a></td>
        <td><a href="{$copy_url}" title="{$mod->Lang('copy_profile')}">{admin_icon icon='copy.gif'}</a></td>
        <td><a href="{$delete_url}" title="{$mod->Lang('delete_profile')}" onclick="return confirm('{$mod->Lang('delete_profile_confirm')}');">{admin_icon icon='delete.gif'}</a></td>
      </tr>

    {/foreach}

  </table>

{/if}
