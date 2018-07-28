{cgerror}{$message}{/cgerror}
{$startform}
    <div class="pagerow">
    <div class="rowtext">{$nametext}</div>
	<div class="rowinput">{$inputname}</div>
        </div>
        <div class="pagerow">
		   <div class="rowtext">{$addresstext}</div>
		   <div class="rowinput">{$inputaddress}</div>
        </div>
        <div class="pagerow">
		   <div class="rowtext">{$telephonetext}</div>
		   <div class="rowinput">{$inputtelephone}</div>
        </div>
        <div class="pagerow">
		   <div class="rowtext">{$faxtext}</div>
		   <div class="rowinput">{$inputfax}</div>
        </div>
        <div class="pagerow">
		   <div class="rowtext">{$emailtext}</div>
		   <div class="rowinput">{$inputemail}</div>
        </div>
        <div class="pagerow">
		   <div class="rowtext">{$websitetext}</div>
		   <div class="rowinput">{$inputwebsite}</div>
        </div>
        <div class="pagerow">
		   <div class="rowtext">{$detailstext}</div>
		   <div class="rowinput">{$inputdetails}</div>
        </div>
        <div class="pagerow">
		   <div class="rowtext">{$imagetext}</div>
		   <div class="rowinput">{$imagecurrent}{$imagecurrenthidden}{$imageupload}{$deletetext}{$imagecurrentdelete}</div>
        </div>
	    {if $customfieldscount gt 0}
		    {foreach from=$customfields item=customfield}
			<div class="pagerow">
				<p class="rowtext">{$customfield->name}:</p>
				<p class="rowinput">{$customfield->input_box}</p>
			</div>
		    {/foreach}
  	    {/if}
   	    {if $categoriescount gt 0}
		  {foreach from=$categories item=category}
			<div class="pageorow">
				<p class="rowtext">{$category->name}:</p>
				<p class="rowinput">{$category->checkbox}</p>
			</div>
		  {/foreach}
	    {/if}
	    <div class="pagerow">
		  <p class="rowtext">&nbsp;</p>
		  <p class="rowinput">{$hidden}{$submit}{$cancel}</p>
	    </div>
      {$endform}
