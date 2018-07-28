{* new search template
  misc parameters:
  {$actionid}cd_resultpage - (string/integer) page id for summary results (see the help for the resultpage parameter)
  {$actionid}cd_summarytemplate - (string) see the help for the summarytemplate parameter
  {$actionid}cd_detailpage - (string/integer) page id for detail results (see the help for the detailpage parameter)
  {$actionid}cd_detailtemplate - (string/integer) page id for detail results (see the help for the detailtemplate parameter)
  {$actionid}cd_pagelimit - (integer) Number of items per page.  (see the help for the pagelimit parameter)
  {$actionid}cd_page - (integer) Number of items per page.  (see the help for the page parameter)
  {$actionid}cd_sortby - (string) Sorting (see the help for the sortby parameter)
  {$actionid}cd_sortorder - (string) Sort order (ascending or descending)

  valid fields are:
  {$actionid}cd_submit - (string) for a submit button
  {$actionid}cd_reset  - (string) a button to reset the form.
  {$actionid}cd_resetall  - (string) a button to reset all saved search data in the session.
  {$actionid}cd_phrase - (string) for advanced text search
     see MySQL full text search.  Searches on words (subject to stop words, and minimum word length in MySQL)
     valid syntaxes:
        "some phrase" search for the exact text (quotes important)
        word1 word2   search for the two words
        word1 -word2  search for entries with the first word but no occurrance of the second word
        +word1 +word2 search for entries with absolutely those two words.

  {$actionid}cd_lat - (float) - specify a latitude for a radius search
  {$actionid}cd_long - (float) - specify a longitude for a radius search
  {$actionid}cd_address - (string) for an address
     (default = EMPTY)
  {$actionid}cd_radius - (int) for a distance search (valid only for postcode or lat/long searches))
     (default = 50)
  {$actionid}cd_units  - (string) for a distance search (valid only for postcode or lat/long searches) ("km" or "miles")
     (default = miles)
  {$actionid}cd_name   - (string) for a company name
     (default = EMPTY)
  {$actionid}cd_name_type - (string) controls how the name is used ("exact" or "like")
     (default = exact)
  {$actionid}cd_address_type - (string) controls how the address field is used ("substr" or "lookup")
     (default = substr)
  {$actionid}cd_nochildren - (integer) optionally disable searching through matching child categories and/or hierarchies.
  {$actionid}cd_category[] - (array of integers), or comma separated list of integers, to filter on categories.  Use the {$categories} array to build checkboxes.  This specifies an IN relationship.... companies in any ONE of the specified categories will be returned.
     (default = EMPTY)
  {$actionid}cd_hier   - (int) to specify a hierarchy id that results must belong in.
{$actionid}cd_field_expr[] - array of custom field expressions, each element should be an array of three more elements indicating the field name, the filter value, and an (optional) expression type. i.e:
  {$actionid}cd_sortby - (string) see the help for this parameter
  {$actionid}cd_sortorder - (string) see the help for this parameter

  Custom Field Searches
  ---------------------
  It is possible to provide input fields to allow the user to filter/search on custom fields.  This is done by providing an array of expressions with the name cdx_field.  Each expression consists of three parts:
    a: fldname: The field name
    b: fldval:  The field value (term or value to filter on)
       NOTE: empty values, or the special value **IGNORE** will result in that field being ignored in the the expression.
    c: expr:    The field expression
       possible values for the expression are:
         AUTO: automatically determine an expression based on the field type, and other criteria.
               for multiselect, image, file, and other custom field types a substring comparison.
         LIKE: Match records where the fldval specified exists as a substring within the companies fldvalue
         SW/STARTSWITH: Match records where the field value in the database starts with the fldval specified
         EW/ENDSSWITH: Match records where the field value in the database ends with the fldval specified
         </LT: Match records where the field value in the database is less than the fldval specified.
         <=/LTE/LE: Match records where the field value in the database is less than or equal to the fldval specified.
         >/GT: Match records where the field value in the database is greater than the fldval specified.
         >=/GTE/GE: Match records where the field value in the database is greater than or equal to the fldval specified.
         =/EQ: Match records where the field value in the database is exactly equal to the fldval specified.
         !=/NE: Match records where the field value in the database is not equal to the fldval specified.
    d: type:     The field type
       (for expressions LT,LE,GT,GE,EQ,NE)
       Allows casting the field value to a more appropriate type for comparisons.
       possible values for the type are:
         FLOAT, REAL, DECIMAL  (floating point)
         INT, INTEGER, SIGNED  (signed integer)
         UNSIGNED (unsigned integer)

  See below for examples of using the cdx_field type.

  Postal Code Searches
  ---------------------
  Notes:  If a postal/zip code is specified, and the Postcode module, and CGGoogleMaps modules are installed, then the potal/zip code will be used first to calculate a geographic search area.
  {$actionid}cd_postal  - (string) for a postal code (valid only if the Postcodes module is installed)
     (default = EMPTY)
  {$actionid}cd_postalchars  - (integer) for a postal code (valid only if the Postcodes module is installed)
     Used to specify the number of accurate characters that can be used to do a postal code -> lat long lookup.
     Some postal code databases are only accurate to the first N characters.
    (default = 0 == use all chars of supplied postal code)
  {$actionid}cd_country - (string) for a postal code (valid only if the Postcodes module is installed) (use two letter country code)
     (default = US)
  {$actionid}cd_searchaddress - (int) to specify that, when doing a postal code search that the address field should be searched as well.
     (default 0)

  Supplying Parameters
  --------------------
  It is possible to put many of the above described parameters directly into the form (between the formstart and formend tags).  Additionally,
  for the security minded many parameters can be supplied in the tag to the module... or on the relevent summary and detail pages using the
  {cge_module_hint} tag that is supplied with later versions of CompanyDirectory.
*}

{* use some jquery, and browser location information to fill the lat/long fields this is great for mobile sites, note this will enable
   coordinate based searches and will exclude any companies that do not have latitudes and longitudes stored *}
{*
<script type="text/javascript">{literal}//<![CDATA[
if( typeof(jQuery) != 'undefined' ){
  if(navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position){
      // Try W3C Geolocation (Preferred)
      $('#latitude').val(position.coords.latitude);
      $('#longitude').val(position.coords.longitude);
    });
  }
}
//]]>
{/literal}</script>
*}

{strip}
<div id="cd_searchform">{$formstart}
  {* display any errors *}
  {if isset($errors)}
  <p class="errors">
    {'<br/>'|implode:$errors}
  </p>
  {/if}

  {* phrase search *}
  <div class="row">
    <p class="col-md-3 text-right">{$mod->Lang('phrase')}</p>
    <p class="col-md-9">
      <input type="text" name="{$actionid}cd_phrase" size="40" value="{$saved.phrase|default:''}"/>
    </p>
  </div>

  {* name substring search *}
  <div class="row">
    <p class="col-md-3 text-right">{$mod->Lang('name')}</p>
    <p class="col-md-9">
      <input type="text" name="{$actionid}cd_name" size="40" value="{$saved.name|default:''}"/>
      <input type="hidden" name="{$actionid}cd_name_type" value="LIKE"/>
    </p>
  </div>

  {* address substring search *}
  <div class="row">
    <p class="col-md-3 text-right">{$mod->Lang('address')}</p>
    <p class="col-md-9">
      <input type="text" name="{$actionid}cd_address" size="40" value="{$saved.address|default:''}"/>
    </p>
  </div>

  {* for lat/long radius searches *}
  <div class="row">
    <p class="col-md-3 text-right">{$mod->Lang('coordinates')}</p>
    <p class="col-md-9">
      {* note, if values are supplied for latitude and longitude then postal code is ignored *}
      {$mod->Lang('latitude')}: <input id="latitude" type="text" name="{$actionid}cd_lat" size="10" maxlength="10" value="{$saved.lat|default:''}"/><br/>
      {$mod->Lang('longitude')}: <input id="longitude" type="text" name="{$actionid}cd_long" size="10" maxlength="10" value="{$saved.long|default:''}"/><br/>
    </p>
  </div>

  {* for postal code radius searches *}
  <div class="row">
    <p class="col-md-3 text-right">{$mod->Lang('postal_code')}</p>
    <p class="col-md-9">
      <input type="text" name="{$actionid}cd_postal" size="20" maxlength="20" value="{$saved.postal|default:''}"/>
      {* you could also use the {$input_country} variable to display a country dropdown *}
      <input type="hidden" name="{$actionid}cd_country" value="CA"/>
      {* for US zips prolly should remove the postalchars stuff *}
      <input type="hidden" name="{$actionid}cd_postalchars" value="3"/>
      <input type="hidden" name="{$actionid}cd_searchaddress" value="0"/>
    </p>
  </div>

  {* for all radius searches *}
  <div class="row">
    <p class="col-md-3 text-right">{$mod->Lang('radius')}</p>
    <p class="col-md-9">
      {assign var='radiuses' value=[10=>10,25=>25,50=>50,100=>100]}
      <select name="{$actionid}cd_radius">
        {html_options options=$radiuses selected=$saved.radius|default:-1}
      </select>
      <input type="hidden" name="{$actionid}cd_units" value="miles"/>
    </p>
  </div>

 {* advanced filtering on hierarchies *}
 {if isset($hierarchies)}
 <div class="row">
   <p class="col-md-3 text-right">{$mod->Lang('hierarchy')}:</p>
   <p class="col-md-9">
     <select name="{$actionid}cd_hier">
       {html_options options=$hierarchies selected=$saved.hier|default:-1}
     </select>
   </p>
 </div>
 {/if}

 {* advanced filtering on categories *}
 {if isset($categories)}
 <div class="row">
   <p class="col-md-3 text-right">{$mod->Lang('categories')}:</p>
   <p class="col-md-9">
    {capture assign='tmp'}{$actionid}cd_category{/capture}
    {html_checkboxes name=$tmp options=$categories separator='<br/>' selected=$saved.category|default:''}
  </p>
 </div>
 {/if}

 {* advanced filtering on a specific custom field*}
 <div class="row">
   <p class="col-md-3 text-right">MyField substring Test:</p>
   <p class="col-md-9">
     <input type="hidden" name="{$actionid}cdx_field[0][fldname]" value="myfield"/>{* hidden input for custom field name *}
     <input type="text" name="{$actionid}cdx_field[0][fldval]" value=""/ size="10" value="{$saved.fields.myfield.fldval|default:''}">{* text input for custom field value *}
     <input type="hidden" name="{$actionid}cdx_field[0][expr]" value="LIKE"/>{* hidden input for custom field expression *}
   </p>
 </div>
 <div class="row">
   <p class="col-md-3 text-right">Custom Field value test:</p>
   <p class="col-md-9">
     <input type="hidden" name="{$actionid}cdx_field[1][fldname]" value="myintfield"/>{* hidden input for custom field name *}
     <input type="text" name="{$actionid}cdx_field[1][fldval]" value=""/ size="3" value="{$saved.fields.myintfield.fldval|default:''}>{* text input for custom field value *}
     <input type="hidden" name="{$actionid}cdx_field[1][expr]" value="lt"/>{* hidden input for custom field expression *}
     <input type="hidden" name="{$actionid}cdx_field[1][type]" value="int"/>{* hidden input for custom field expression *}
   </p>
 </div>

 <div class="row">
   <p class="col-md-3 text-right"></p>
   <p class="col-md-9">
     <input type="submit" name="{$actionid}cd_submit" value="{$mod->Lang('submit')}"/>
     <input type="submit" name="{$actionid}cd_reset" value="{$mod->Lang('reset')}"/>
   </p>
 </div>

{$formend}</div>{* #cd_searchform *}
{/strip}