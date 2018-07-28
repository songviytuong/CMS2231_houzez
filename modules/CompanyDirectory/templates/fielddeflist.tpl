{*
#CMS - CMS Made Simple
#(c)2004-6 by Ted Kulp (ted@cmsmadesimple.org)
#This project's homepage is: http://cmsmadesimple.org
#
#This program is free software; you can redistribute it and/or modify
#it under the terms of the GNU General Public License as published by
#the Free Software Foundation; either version 2 of the License, or
#(at your option) any later version.
#
#This program is distributed in the hope that it will be useful,
#but WITHOUT ANY WARRANTY; without even the implied warranty of
#MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#GNU General Public License for more details.
#You should have received a copy of the GNU General Public License
#along with this program; if not, write to the Free Software
#Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
#
#$Id$	
*}

<div id="fieldlist_opts" class="pageoptions">
  <a id="fieldlist_addlink" href="{module_action_link action=addfielddef urlonly=1}">{cgimage class="systemicon" image='icons/system/newobject.gif' alt=$mod->Lang('addfielddef')} {$mod->Lang('addfielddef')}</a>
</div>

{if $itemcount > 0}
<div id="fieldlist">
  <table class="pagetable">
  <thead>
    <tr>
      <th>{$fielddeftext}</th>
      <th>{$typetext}</th>
      <th class="move">&nbsp;</th>
      <th class="pageicon">&nbsp;</th>
      <th class="pageicon">&nbsp;</th>
    </tr>
  </thead>
  <tbody>
  {foreach from=$items item=entry}
    {cycle values="row1,row2" assign='rowclass'}
    <tr id="{$actionid}field_{$entry->id}" class="{$rowclass}" onmouseover="this.className='{$rowclass}hover';" onmouseout="this.className='{$rowclass}';">
      <td>{$entry->name}</td>
      <td>{capture assign='tmp'}field_{$entry->type}{/capture}{$mod->Lang($tmp)}</td>
      <td>{$entry->uplink} {$entry->downlink}</td>
      <td>{$entry->editlink}</td>
      <td>{$entry->deletelink}</td>
    </tr>
  {/foreach}
  </tbody>
  </table>
</div>
{/if}

