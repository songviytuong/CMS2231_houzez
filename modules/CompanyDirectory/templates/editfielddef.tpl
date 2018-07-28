<script type="text/javascript">
/*<![CDATA[*/
function onchange_fldtype(elem) {
  var idx = elem.selectedIndex;
  var val = elem[idx].value;
  
  var ml = document.getElementById('maxlength');
  var opts = document.getElementById('dropdown_options');
  var exts = document.getElementById('file_extensions');
  var alb = document.getElementById('album_info');
  if( val == 'textbox' ) {
    ml.style.display   = 'block';
    opts.style.display = 'none';
    exts.style.display = 'none';
    alb.style.display  = 'none';
  }
  else if( val == 'dropdown' || val == 'multiselect' ) {
    ml.style.display   = 'none';
    opts.style.display = 'block';
    exts.style.display = 'none';
    alb.style.display  = 'none';
  }
  else if( val == 'file' || val == 'image' ) {
    ml.style.display   = 'none';
    opts.style.display = 'none';
    exts.style.display = 'block';
    alb.style.display  = 'none';
  }
  else if( val == 'album' ) {
    ml.style.display   = 'none';
    opts.style.display = 'none';
    exts.style.display = 'block';
    alb.style.display  = 'inline';
  }
  else {
    ml.style.display   = 'none';
    opts.style.display = 'none';
    exts.style.display = 'none';
    alb.style.display  = 'none';
  }
}

$('#fldtype').ready(function($) {
  var e = document.getElementById('fldtype');
  onchange_fldtype(e);
});
/*]]> */
</script>

<h3>{$mod->Lang('prompt_addeditfield')}</h3>

{$startform}
<div class="pageoverflow">
  <p class="pagetext">*{$nametext}:</p>
  <p class="pageinput">{$inputname}</p>
</div>

<div class="pageoverflow">
  <p class="pagetext">*{$typetext}:</p>
  <p class="pageinput">
    <select id='fldtype' name="{$actionid}type" onchange="onchange_fldtype(this);">
      {html_options options=$fieldtypes selected=$fldtype}
    </select>
    <span id="album_info" style="display_none"><br/>{$mod->Lang('info_album_fieldtype')}</span>
  </p>
</div>

<div id="maxlength" class="pageoverflow">
	<p class="pagetext">*{$maxlengthtext}:</p>
	<p class="pageinput">{$inputmaxlength}</p>
</div>
<div id="dropdown_options" class="pageoverflow" style="display: none;">
  <p class="pagetext">*{$mod->Lang('prompt_dropdown_options')}:</p>
  <p class="pageinput">
    <textarea name="{$actionid}dropdown_options">{$dropdown_data}</textarea>
    <br/>
    {$mod->Lang('info_dropdown_options')}
  </p>
</div>
<div id="file_extensions" class="pageoverflow" style="display: none;">
  <p class="pagetext">*{$mod->Lang('prompt_extensions')}:</p>
  <p class="pageinput">
     <input type="text" size="80" name="{$actionid}extensions" value="{$extensions|default:''}" maxlength="255"/>
     <br/>
     {$mod->Lang('info_extensions')}
  </p>
</div>
<div class="pageoverflow">
	<p class="pagetext">*{$useredittext}:</p>
	<p class="pageinput">{$input_useredit}<br/>{$mod->Lang('info_useredit')}</p>
</div>
<div class="pageoverflow">
	<p class="pagetext">*{$userviewtext}:</p>
	<p class="pageinput">{$input_userview}<br/>
          {$mod->Lang('info_userview')}
        </p>
</div>
<div class="pageoverflow">
	<p class="pagetext">&nbsp;</p>
	<p class="pageinput">{$hidden}{$submit}{$cancel}</p>
</div>
{$endform}
