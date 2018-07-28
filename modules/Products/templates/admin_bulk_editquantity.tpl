<h3>{$mod->Lang('bulk_edit_quantity')}</h3>
<div class="information">{$mod->Lang('info_bulk_editquantity')}</div>

{$prev_product=-1}
{$formstart}
<div class="pageoverflow">
  <p class="pageinput">
    <input type="submit" name="{$actionid}submit" value="{$mod->Lang('submit')}"/>
    <input type="submit" name="{$actionid}cancel" value="{$mod->Lang('cancel')}"/>
  </p>
</div>
<table class="pagetable">
  <thead>
    <tr>
      <th>{$mod->Lang('product')}</th>
      <th>{$mod->Lang('option')}</th>
      <th>{$mod->Lang('sku')}</th>
      <th>{$mod->Lang('quantity_on_hand')}</th>
    </tr>
  </thead>
  <tbody>
  {foreach $editable as $one}
    <tr>
      <td>{$one->product_name}</td>
      <td>{$one->attribute}</td>
      <td>{$one->sku}</td>
      <td>
        <input type="text" name="{$actionid}cd_qoh[{$one->sku}]" value="{$one->stock}" size="5" maxlength="5"/>
      </td>
    </tr>
  {/foreach}
  </tbody>
</table>
{$formend}