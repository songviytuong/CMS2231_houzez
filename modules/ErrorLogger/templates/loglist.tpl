{* @author Oliver Jooss @copyright 2013 *}
   <form method="post">
      <input type="hidden" name="hidden_sort" value="{$SORT}" />
      <table cellspacing="0" class="pagetable">
         <thead>
            <tr>
               <th>ID</th>
               <th>
                  <table border="0">
                     <tr>
                        <th style="max-width: 15px; padding-left: 0px; padding-right: 0px;">{errorlogger_sortbutton field="log_time"}</th>
                        <th>time</th>
                     </tr>
                  </table>
               </th>
               <th>
                  <table border="0">
                     <tr>
                        <th style="max-width: 15px; padding-left: 0px; padding-right: 0px;">{errorlogger_sortbutton field="log_type"}</th>
                        <th>type</th>
                     </tr>
                  </table>
               </th>
               <th>
                  <table border="0">
                     <tr>
                        <th style="max-width: 15px; padding-left: 0px; padding-right: 0px;">{errorlogger_sortbutton field="log_message"}</th>
                        <th>message</th>
                     </tr>
                  </table>
               </th>
               <th>
                  <table border="0">
                     <tr>
                        <th style="max-width: 15px; padding-left: 0px; padding-right: 0px;">{errorlogger_sortbutton field="log_location"}</th>
                        <th>location</th>
                     </tr>
                  </table>
               </th>
               <th>&nbsp;</th>
            </tr>
         </thead>
         <tbody>
            <tr>
               <td>&nbsp;</td>
               <td><input type="text" name="filter[log_time]" value="{if isset($FILTER.log_time)}{$FILTER.log_time}{/if}" style="width: 95%;" /></td>
               <td><input type="text" name="filter[log_type]" value="{if isset($FILTER.log_type)}{$FILTER.log_type}{/if}" style="width: 95%;" /></td>
               <td><input type="text" name="filter[log_message]" value="{if isset($FILTER.log_message)}{$FILTER.log_message}{/if}" style="width: 95%;" /></td>
               <td><input type="text" name="filter[log_location]" value="{if isset($FILTER.log_location)}{$FILTER.log_location}{/if}" style="width: 95%;" /></td>
               <td style="text-align: right;"><input type="submit" style="padding: 1px 10px 2px;" value="filter" /></td>
            </tr>
         {foreach from=$LOG_MESSAGES item=LOG_MESSAGE name=items}
            {if $smarty.foreach.items.index % 2 == 0}
            <tr onmouseout="this.className='row1';" onmouseover="this.className='row1hover';" class="row1" id="tr_{$smarty.foreach.items.index}">
            {else}
            <tr onmouseout="this.className='row2';" onmouseover="this.className='row2hover';" class="row2" id="tr_{$smarty.foreach.items.index}">
            {/if}
               <td>{$LOG_MESSAGE.log_ID}</td>
               <td>{$LOG_MESSAGE.log_time}</td>
               <td>{$LOG_MESSAGE.log_type}</td>
               <td>{$LOG_MESSAGE.log_message}</td>
               <td colspan="2">{$LOG_MESSAGE.log_location}</td>
            </tr>
         {/foreach}
         </tbody>
      </table>

       {* $PAGE} von {$PAGES *}
       <div style="text-align: right;">
          Page
          <select name="page" class="cms_dropdown" onchange="this.form.submit();">
          {section name=pages start=0 loop=$PAGES step=1}
             <option value="{$smarty.section.pages.index+1}"{if $smarty.section.pages.index+1 == $PAGE} selected="selected"{/if}>{$smarty.section.pages.index+1}</option>
          {/section}
          </select>
       </div>
   </form>

   <div style="position: relative; top: -33px;">
        <form method="post" onsubmit="return confirm('Are you sure you would like to clear the log?');">
            <input type="submit" name="el_clear" value="clear log" />
        </form>
   </div>