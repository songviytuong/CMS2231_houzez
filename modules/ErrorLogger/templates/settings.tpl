<form method="post">
   <table>
      <tr>
         <td>Log notices:</td>
         <td>&nbsp;</td>
         <td><input type="radio" name="el_notices" value="true" {if $MOD_ERROR_LOGGER_INFO}checked="checked"{/if} />yes
             &nbsp;&nbsp;&nbsp;
             <input type="radio" name="el_notices" value="false" {if !$MOD_ERROR_LOGGER_INFO}checked="checked"{/if} />no
         </td>
      </tr>
      <tr>
         <td>Log warnings:</td>
         <td>&nbsp;</td>
         <td><input type="radio" name="el_warnings" value="true" {if $MOD_ERROR_LOGGER_WARNING}checked="checked"{/if} />yes
             &nbsp;&nbsp;&nbsp;
             <input type="radio" name="el_warnings" value="false" {if !$MOD_ERROR_LOGGER_WARNING}checked="checked"{/if} />no
         </td>
      </tr>
      <tr>
         <td>Log errors:</td>
         <td>&nbsp;</td>
         <td><input type="radio" name="el_errors" value="true" {if $MOD_ERROR_LOGGER_ERROR}checked="checked"{/if} />yes
             &nbsp;&nbsp;&nbsp;
             <input type="radio" name="el_errors" value="false" {if !$MOD_ERROR_LOGGER_ERROR}checked="checked"{/if} />no
         </td>
      </tr>
      <tr>
         <td>Log exceptions:</td>
         <td>&nbsp;</td>
         <td><input type="radio" name="el_exceptions" value="true" {if $MOD_ERROR_LOGGER_EXCEPTION}checked="checked"{/if} />yes
             &nbsp;&nbsp;&nbsp;
             <input type="radio" name="el_exceptions" value="false" {if !$MOD_ERROR_LOGGER_EXCEPTION}checked="checked"{/if} />no
         </td>
      </tr>

      <tr>
         <td>Itmes per page:</td>
         <td>&nbsp;</td>
         <td>
            <select name="el_ipp">
               <option value="10" {if $MOD_ERROR_LOGGER_ITEMS_PER_PAGE == 10}selected="selected"{/if}>10</option>
               <option value="30" {if $MOD_ERROR_LOGGER_ITEMS_PER_PAGE == 30}selected="selected"{/if}>30</option>
               <option value="50" {if $MOD_ERROR_LOGGER_ITEMS_PER_PAGE == 50}selected="selected"{/if}>50</option>
               <option value="100" {if $MOD_ERROR_LOGGER_ITEMS_PER_PAGE == 100}selected="selected"{/if}>100</option>
               <option value="150" {if $MOD_ERROR_LOGGER_ITEMS_PER_PAGE == 150}selected="selected"{/if}>150</option>
            </select>
         </td>
      </tr>

      <tr>
         <td colspan="3">
            <input type="submit" name="el_settings" value="save" />
         </td>
      </tr>
   </table>
</form>

<p>
   <form method="post" onsubmit="return confirm('Are you sure you would like to clear the log?');">
      <input type="submit" name="el_clear" value="clear log" />
   </form>
</p>