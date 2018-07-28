<table align='center' class='pagetable' style="width:600px">
<thead>
<tr>
  <th colspan="4" style="text-align:center"><h2>{$visitorshowing}</h2></th>
  </tr>
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
    
    <td>{$row->count}</td>
    <td>{$row->page}</td>
    <td>{$row->time}</td>
    <td>{$row->viewtime}</td>
  </tr>
  {/foreach}
</tbody>
</table>
