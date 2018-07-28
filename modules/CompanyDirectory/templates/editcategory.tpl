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

{if $category.id < 1}
  <h3>{$mod->Lang('add_category')}</h3>
{else}
  <h3>{$mod->Lang('edit_category')}</h3>
{/if}

{$startform}
	<div class="pageoverflow">
		<p class="pageinput">
		   <input type="submit" name="{$actionid}submit" value="{$mod->Lang('submit')}"/>
		   <input type="submit" name="{$actionid}cancel" value="{$mod->Lang('cancel')}"/>
		</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">*{$mod->Lang('name')}:</p>
		<p class="pageinput">
		   <input type="text" name="{$actionid}name" value="{$category.name}" maxlength="255" required="required"/>
		</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">*{$mod->Lang('parent')}:</p>
		<p class="pageinput">
		   <select name="{$actionid}parent_id">
		      {html_options options=$categories selected=$category.parent_id}
		   </select>
		</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$mod->Lang('description')}:</p>
		<p class="pageinput">
                  {cge_textarea wysiwyg=1 prefix=$actionid name='description' content=$category.description}
                </p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$mod->Lang('imagetext')}:</p>
		<p class="pageinput">
                  <input type="file" name="{$actionid}image"/>
                  {if $category.image != ''}
                    <br/>{$mod->Lang('current_value')}: {$image}
                    <input type="checkbox" value="1" name="{$actionid}delimage">&nbsp;{$mod->Lang('delete')}
                  {/if}
                </p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$mod->Lang('extra1')}:</p>
		<p class="pageinput">
		    <input type="text" name="{$actionid}extra1" value="{$category.extra1}" maxlength="255" size="50"/>
		</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$mod->Lang('extra2')}:</p>
		<p class="pageinput">
		    <input type="text" name="{$actionid}extra2" value="{$category.extra2}" maxlength="255" size="50"/>
		</p>
	</div>
	<div class="pageoverflow">
		<p class="pagetext">{$mod->Lang('extra3')}:</p>
		<p class="pageinput">
		    <input type="text" name="{$actionid}extra3" value="{$category.extra3}" maxlength="255" size="50"/>
		</p>
	</div>
{$endform}
