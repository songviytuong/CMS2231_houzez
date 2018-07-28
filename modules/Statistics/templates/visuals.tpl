<img width="80" alt="{$settingstitle|default:''}" src="../modules/Statistics/icons/crystalclear/settings.png" title="{$settingstitle|default:''}" style="float:right;" />

<table width="800"><tr><td>
{$startform}
{*$show*}
      <div class="pageoverflow">
        <p class="pagetext">{$charttypetext}:</p>
        <p class="pageinput">{$charttypeinput}
          <br/><br/>
{$iftextchartuse} {$maxdotsinput}{$times} {$dotcharinput}
          <br/><br/>
{$ifjqplotsize} {$jqplotxinput}x {$jqplotyinput}
        </p>
      </div>

      <div class="pageoverflow">
        <p class="pagetext">{$gfxnumberstext}:</p>
        <p class="pageinput">{$gfxnumbersinput}</p>
      </div>

      <div class="pageoverflow">
        <p class="pagetext">{$iconsettext}:</p>
        <p class="pageinput">{$iconsetinput}</p>
      </div>



      <div class="pageoverflow">
        <p class="pagetext">{$dateformattext}:</p>
        <p class="pageinput">{$dateformatinput}<br/>{$dateformathelp}</p>
      </div>

      <div class="pageoverflow">
        <p class="pagetext">&nbsp;</p>
        <p class="pageinput">{$submitvisuals}</p>
      </div>
{$endform}
    </td></tr></table>