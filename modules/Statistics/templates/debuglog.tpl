<img width="80" alt="{$debuglogtitletitle|default:''}" src="../modules/Statistics/icons/debuglog.png" title="{$debuglogtitletitle|default:''}" style="float:right; display:block;" />

<table>
<tr>
  <td valign="top">
		  {$formstart}
      {*$show*}
		  {$resetbutton}
		  {$formend}
		</td><td>
		  <form action="">
      <textarea name="loglines" cols="45" rows="5">{$loglines}</textarea>
      </form>
  </td>
 </tr>
 </table>
