
<br/>
<table class='pagetable'>
<tr>
  <td valign="top" style="text-align:center; width:200px;">
<br/>

{if $title!=""}
  <h1>{$title}</h1>
{/if}

</td>
  <td valign="top">
<br/>
<table align='center' class='pagetable' style="width:600px">
<thead>
  <tr>
  {foreach from=$headers item=header}
  <th>{$header}</th>
  {/foreach}
  </tr>
</thead>
<tbody>  
  {foreach from=$rows item=row}
  {cycle values="row1,row2" assign=rowclass}
  <tr class="{$rowclass}">
    {foreach from=$row item=cell}
    <td>{$cell}</td>
    {/foreach}
  </tr>
  {/foreach}
</tbody>
</table>

</td>
<td valign="top" style="text-align:center; width:200px;">
<br/>
{if $icon!=""}

  <img alt="{$title}"  title="{$title}" src="../modules/Statistics/icons/{$iconset}/{$icon}" style="float:right;" />

{/if}


</td>
</tr>
</table>