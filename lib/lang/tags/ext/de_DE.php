<?php
$lang['help_modifier_cms_date_format'] = '<h3>Beschreibung</h3>
<p>Dieser Modifikator formatiert Datumsangaben in ein geeignetes Format. Es nutzt die regul&auml;ren &bdquo;strftime&ldquo;-Parameter. Wenn keine Format-Zeichenfolge angegeben ist, verwendet das System die Benutzereinstellungen des Datumsformats (f&uuml;r angemeldete Benutzer) oder das Standard-Datumsformat des Systems.</p>
<p>Dieser Modifikator ist in der Lage, Daten in vielen Formaten zu verstehen, z. B. Datumsausgaben aus der Datenbank oder Integer-Zeitstempel, die von der Funktion time() erzeugt werden.</p>
<h3>Verwendung</h3>
<pre><code>{$some_date_var|cms_date_format[:&amp;lt;format string&amp;gt;]}</code></pre>
<h3>Beispiel</ h3>
<pre><code>{&#039;2012-03-24 22:44:22 &#039;|cms_date_format}</code></pre>';
$lang['tag_help'] = 'Hilfe f&uuml;r dieses Tag anzeigen (sofern verf&uuml;gbar)';
$lang['tag_name'] = 'Dies ist der Name f&uuml;r das Tag';
$lang['tag_type'] = 'Tag-Typ (Funktion, Modifikator bzw. Pre- oder Post-Filter';
$lang['title_admin'] = 'Diese Erweiterung ist nur im CMSMS-Administrationsbereich verf&uuml;gbar.';
$lang['title_notadmin'] = 'Diese Erweiterung ist im Administrationsbereich und auf der &ouml;ffentlichen Website verwendbar.';
$lang['title_cachable'] = 'Diese Erweiterung kann zwischengespeichert werden';
$lang['title_notcachable'] = 'Diese Erweiterung kann nicht zwischengespeichert werden';
$lang['viewabout'] = 'Vorgeschichte und Autoreninformation f&uuml;r dieses Modul anzeigen';
$lang['viewhelp'] = 'Modulhilfe anzeigen';
?>