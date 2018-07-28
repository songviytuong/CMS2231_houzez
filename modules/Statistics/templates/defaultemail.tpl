{* There plenty that could be improved in this template,
feel free to submit suggestions! *}

<html>
<head>
<title>
</title>

{literal}
<style type="text/css">
body {
  background-color: #dddddd;
  color: black;
}
thead {
  background-color: #eeeeee;
}
td {
  border: 1px solid black;
}
</style>
{/literal}

</head>
<body>
<table>
<thead>
<tr>
  <th colspan="2">Statistical Data</th>
</tr>
</thead>
<tbody>
<tr>
  <td>Total hits</td><td>{$total}</td>
</tr>
<tr>
  <td>Total pageviews</td><td>{$pageviews}</td>
</tr>
<tr>
  <td>Hits today</td><td>{$today}</td>
</tr>
<tr>
  <td>Hits this week</td><td>{$thisweek}</td>
</tr>
<tr>
  <td>Hits this month</td><td>{$thismonth}</td>
</tr>
<tr>
  <td>Hits this year</td><td>{$thisyear}</td>
</tr>
<tr>
  <td>Most popular browser</td><td>{$topbrowser}</td>
</tr>
<tr>
  <td>Most popular OS</td><td>{$topos}</td>
</tr>
<tr>
  <td>Most frequent country</td><td>{$topcountry}</td>
</tr>
</tbody>
</table>
<br/>
<table>
<thead>
<tr>
  <th colspan="2">Since last email</th>
</tr>
</thead>
<tbody>
<tr>
  <td>Hits</td><td>{$totalsinceemail}</td>
</tr>
<tr>
  <td>Pageviews</td><td>{$pageviewssinceemail}</td>
</tr>
</tbody>
</table>



</body>
</html>