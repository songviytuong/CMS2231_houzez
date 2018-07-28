<img width="80" alt="{$settingstitle|default:''}"   src="../modules/Statistics/icons/crystalclear/limits.png" title="{$settingstitle|default:''}" style="float:right;"/>
<table width="800"><tr><td>

{$startform}
{*$show|default:''*}
      <div class="pageoverflow">
        <p class="pagetext">{$activelimittext}:</p>
        <p class="pageinput">{$activelimitinput}</p>
      </div>

      <div class="pageoverflow">
        <p class="pagetext">{$visitorlimittext}:</p>
        <p class="pageinput">{$visitorlimitinput}</p>
      </div>

      <div class="pageoverflow">
        <p class="pagetext">{$gonetokeeptext}:</p>
        <p class="pageinput">{$gonetokeepinput}</p>
      </div>

      <div class="pageoverflow">
        <p class="pagetext">{$daylimittext}:</p>
        <p class="pageinput">{$daylimitinput}</p>
      </div>

      <div class="pageoverflow">
        <p class="pagetext">{$weeklimittext}:</p>
        <p class="pageinput">{$weeklimitinput}</p>
      </div>

      <div class="pageoverflow">
        <p class="pagetext">{$monthlimittext}:</p>
        <p class="pageinput">{$monthlimitinput}</p>
      </div>

      <div class="pageoverflow">
        <p class="pagetext">{$yearlimittext}:</p>
        <p class="pageinput">{$yearlimitinput}</p>
      </div>

      <div class="pageoverflow">
        <p class="pagetext">{$browserlimittext}:</p>
        <p class="pageinput">{$browserlimitinput}</p>
      </div>

      <div class="pageoverflow">
        <p class="pagetext">{$oslimittext}:</p>
        <p class="pageinput">{$oslimitinput}</p>
      </div>

{** TODO maybe? (JM)
      <div class="pageoverflow">
        <p class="pagetext">{$smartphoneslimittext}:</p>
        <p class="pageinput">{$smartphoneslimitinput}</p>
      </div>
*}
      <div class="pageoverflow">
        <p class="pagetext">{$countrylimittext}:</p>
        <p class="pageinput">{$countrylimitinput}</p>
      </div>
      <div class="pageoverflow">
        <p class="pagetext">{$pagelimittext}:</p>
        <p class="pageinput">{$pagelimitinput}</p>
      </div>
      <div class="pageoverflow">
        <p class="pagetext">{$refererlimittext}:</p>
        <p class="pageinput">{$refererlimitinput}</p>
      </div>
      <div class="pageoverflow">
        <p class="pagetext">{$keywordlimittext}:</p>
        <p class="pageinput">{$keywordlimitinput}</p>
      </div>


      <div class="pageoverflow">
        <p class="pagetext">&nbsp;</p>
        <p class="pageinput">{$submitsettings}</p>
      </div>
{$endform}

    </td></tr></table>