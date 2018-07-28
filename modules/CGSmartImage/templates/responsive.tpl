<script type="text/javascript">{jsmin}
{* this javascript will set a cookie with the device height, width, and pixel ratio for use in CGSmartImage responsive image handling *}
if( document.cookie.indexOf('{$cookiename}') < 0 ) {
  var _ex = new Date;
  _ex.setFullYear(_ex.getFullYear() + 1);
  var _d = {};
  _d.width = screen.width;
  _d.height = screen.height;
  _d.dpr = window.devicePixelRatio;
  document.cookie = "{$cookiename}="+JSON.stringify(_d)+"; expires='+_ex.toGMTString().'; path=/;";
  if( document.cookie.indexOf('{$cookiename}') >= 0 ) {
    window.stop();
    window.location.reload();
  }
}
{/jsmin}</script>