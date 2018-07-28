{* search template *}
{* valid fields are:
   {$actionid}notpretty = (inteter) turn off pretty urls for detail views.
   {$actionid}pagelimit - (integer) override page limit setting.  maximum value is 500. Minimum value is 1.
   {$actionid}sortby - (string) See the sortby param in the module help for valid values.
   {$actionid}sortorder - (string) See the sortorder param in the module help for valid values.
   {$actionid}summarytemplate - (string) See the summarytemplate param in the module help for valid values.
   {$actionid}detailtemplate - (string) See the detailtemplate param in the module help for valid values. (not valid if pretty urls are enabled)
   {$actionid}detailpage - (string) See the detailpage param in the module help for valid values. (not valid if pretty urls are enabled)

   {$actionid}cd_submit    - (string) for a submit button
   {$actionid}cd_cancel    - (string) for a cancel button
   {$actionid}cd_prodname  - (string) for text field to search against product name
   {$actionid}cd_proddesc  - (string) for text field to search against product description.
   {$actionid}cd_prodprice - (select) for price searching.
     options must be of type string with high low limits separated by a :
     i.e:   1000:2000
     a special value of -1 can be used to indicate any price.
   {$actionid}cd_prodprice_min - (string) for minimum price value
   {$actionid}cd_prodprice_max - (string) for minimum price value
     note: if prodprice is specified, prodprice_min and prodprice_max will be ignored
   {$actionid}cd_allany    - (int) to indicate wether all of the
     conditions much match, or if any one of them may.
   {$actionid}cd_prodvalue[] - (array) field values.
     the key for each element must be the field name (not the prompt)
     i.e:  <input type="text" name="{$actionid}cd_prodvalue[myfield]" size="10"/>
     values can either be single values to indicate an exact value match or can be in numerous formats:
     wildcard characters (% or *) can be used for substring matches on field values
     i.e:  <input type="hidden" name="{$actionid}cd_propval[myfield]" value="*foo*"/>

     minval: -- specify a minimum numeric value
     :maxval -- specify a maximum numeric value
     minval:maxval -- specify a range of numeric values
     ::null:: -- search for null values
     ::notnull:: -- search for fields that have any value
     i.e: <input type="hidden" name="{$actionid}cd_propval[myfield]" value="5:10"/>
   {$actionid}cd_prodvalue_<fldname>_min - Minimum value to search for in the <fldname> field.
   {$actionid}cd_prodvalue_<fldname>_max - Maximum value to search for in the <fldname> field.
     i.e:  Select Min Value:  <input type="text" name="{$actionid}cd_propval_myfield_min" size="10"/><br/>
           Select Max Value:  <input type="text" name="{$actionid}cd_propval_myfield_max" size="10"/>
*}

<div id="prod_searchform">
{$formstart}

<div class="row">
  <p class="row_prompt">{$mod->Lang('search_expr')}:</p>
  <p class="row_input">
    <select name="{$actionid}cd_allany">
      <option value="0">{$mod->Lang('all')}</option>
      <option value="1">{$mod->Lang('any')}</option>
    </select>
  </p>
</div>

<div class="row">
  <p class="row_prompt">{$mod->Lang('search_name')}:</p>
  <p class="row_input">
    <input type="text" name="{$actionid}cd_prodname" size="40" maxlength="255"/>
  </p>
</div>

<div class="row">
  <p class="row_prompt">{$mod->Lang('search_description')}:</p>
  <p class="row_input">
    <input type="text" name="{$actionid}cd_proddesc" size="40" maxlength="255"/>
  </p>
</div>

<div class="row">
  <p class="row_prompt">{$mod->Lang('search_price')}:</p>
  <p class="row_input">
    <select name="{$actionid}cd_prodprice">
      <option value="-1">{$mod->Lang('any')}</option>
      <option value="0:99.99">Less Than $100</option>
      <option value="100:999.99">$100 to $1000</option>
      <option value="1000:9999.99">$1000 to $10000</option>
      <option value="10000:9999999">Greater than $10000</option>
    </select>
  </p>
</div>

{if isset($searchprops)}
{* building inputs for all addressable fields in a loop *}
{foreach from=$searchprops key='fldname' item='obj'}
<div class="row">
  <p class="row_prompt">{$obj->prompt}:</p>
  <p class="row_input">
    {if $obj->type == 'text'}
      <input type="text" name="{$actionid}cd_prodvalue[{$fldname}]" size="40" maxlength="40"/>
    {else if $obj->type == 'dropdown'}
      <select name="{$actionid}cd_prodvalue[{$fldname}]">
      {html_options options=$obj->options}
      </select>
    {/if}
  </p>
</div>
{/foreach}

{* accessing a searchable field by name *}
{if isset($searchprops.myfield)}
  {$obj=$searchprops.myfield}
<div class="row">
  <p class="row_prompt">{$obj->prompt}:</p>
  </p class="row_input">
    Min: <input type="text" name="{$actionid}cd_propvalue_myfield_min" size="3">
    Max: <input type="text" name="{$actionid}cd_propvalue_myfield_max" size="3">
  </p>
</div>
{/if}

{/if}

<div class="row">
  <p class="row_prompt"></p>
  <p class="row_input">
    <input type="submit" name="{$actionid}cd_submit" value="{$mod->Lang('submit')}"/>
    <input type="submit" name="{$actionid}cd_cancel" value="{$mod->Lang('cancel')}"/>
  </p>
</div>


{$formend}
</div>{* prod_searchform *}