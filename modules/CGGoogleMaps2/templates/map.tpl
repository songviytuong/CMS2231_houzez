{$google_map_header}

{*
<!-- necessary for google maps polyline drawing in IE -->
{literal}
<style type="text/css">
v\:* {
 behavior:url(#default#VML);
}
{/literal}
</style>
*}

<!-- begin display map -->
<table>
  <tr>
     <td>{$google_map}</td>
     <td>{$google_map_sidebar}</td>
  </tr>
</table>
{$map_description}
{$google_map_js}
<!-- end display map -->
