{* email sent to an administrator when an FEU adds or changes a record *}

<h3>Company information has been changed</h3>

<table>
<tr>
 <td>{$mod->Lang('companyname')}:</td>
 <td>{$company_name}</td>
</tr>
<tr>
 <td>{$mod->Lang('website')}:</td>
 <td><a href="{$website}">{$website}</a></td>
</tr>
<tr>
 <td>{$mod->Lang('contactemail')}:</td>
 <td>{$contactemail}</td>
</tr>
<tr>
 <td>{$mod->Lang('owner')}:</td>
 <td>{$uinfo.username}&nbsp;({$mod->Lang('expires')} {$uinfo.expires|cms_date_format})</td>
</tr>
<tr>
 <td>{$mod->Lang('telephone')}:</td>
 <td>{$telephone}</td>
</tr>
<tr>
 <td>{$mod->Lang('fax')}:</td>
 <td>{$fax}</td>
</tr>
<tr>
 <td>{$mod->Lang('address')}:</td>
 <td>{$address}</td>
</tr>
<tr>
 <td>{$mod->Lang('latitude')}:</td>
 <td>{$latitude}</td>
</tr>
<tr>
 <td>{$mod->Lang('longitude')}:</td>
 <td>{$longitude}</td>
</tr>
{if isset($fielddefs)}
{foreach from=$fielddefs item='one'}
<tr>
 <td>{$fielddef->name}:</td>
 <td>{$fielddef->value}</td>
</tr>
{/foreach}
{/if}

{if isset($categories)}
<tr>
  <td>{$mod->Lang('categories')}:</td>
  <td>{', '|implode:$categories}</td>
</tr>
{/if}
</table>

<pre>
<code>
{$test|@print_r}
</code>
</pre>

