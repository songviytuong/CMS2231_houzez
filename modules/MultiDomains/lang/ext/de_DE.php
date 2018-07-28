<?php

# 0-9

# A
$lang['active'] = 'Aktiv';
$lang['always'] = 'Immer';

# B

# C
$lang['cache'] = 'Zwischenspeichern';
$lang['cancel'] = 'Abbrechen';
$lang['changelog'] = <<<EOT
<ul>
<li>2.2.3 - Februar 2016<p>
* Nur ein Bugfix (Parameter)
</p></li>
<li>2.2.2 - Februar 2016<p>
* Nur ein Bugfix (während der Installation)
</p></li>
<li>2.2.1 - Januar 2016<p>
* Modul ist nun kompatibel mit CMSms 2.x<br />
- Systemcheck entfernt<br />
+ www Prefix kann nun angepasst werden
</p></li>
<li>2.1.2 - April 2013
<p>* Filter hinzugefügt. Bisher nur für das NMS Modul - es arbeitete nicht korrekt mit MultiDomains zusammen - deshalb habe ich die Filter Funktion als Workaround hinzugefügt.</p></li>
<li>2.1.1 - August 2012
<p>* Tabellen für 301 und 404 werden nun nicht mehr gelöscht und können so durch ToolBox installiert werden.</p></li>
<li>2.1 - August 2012
<p>* Kompatibel für CMSms 1.11.x gemacht.<br />
* Einige Fehler beseitigt (PHP-Notices wegen fehlenden Indizies, andere Probleme).<br />
+ Einstellung für die Domains hinzugefügt, um festzulegen, ob eine Domain ohne Request-String (also ohne was nach der Domain) auf die erste Seite innerhalb sich selbst geleitet werden soll oder auf die Standard Seite, die in der Seitenübersicht festgelegt wurde.</p></li>
<li>2.0.1 - Dezember 2011
<p>* Einige Fehler beseitigt (in Domain-Verlinkungen und Statistik).</p></li>
<li>2.0 - November 2011
<p>* Tools entfernt, die für die Domain-Umleitungen nicht notwendig waren - diese wurden jetzt in einem separaten Modul (namens ToolBox) veröffentlicht.<br />
* Statistik-Ansicht vereinfacht (wurde bei längerer Benutzung unübersichtlich).<br />
+ Einstellung hinzugefügt, um den CMS-Cache zu leeren, nachdem eine Änderung in den Domain-Einstellungen vorgenommen wurde.<br />
+ Reiter hinzugefügt, um einen System Check durchzuführen, dabei werden die Dateien .htaccess und config.php überprüft.<br />
* Hilfstexte hinzugefügt - für ein besseres Verständnis der aktuellen Konfiguration.</p></li>
<li>1.5.3 - November 2011
<p>+ Neue Option hinzugefügt, um MultiDomains ohne Ereignisverwaltung verwenden zu können<br />
+ Ab nun steht (bei Verwendung ohne Ereignisverwaltung) eine neue Smarty-Variable zur Verfügung: \$mdsite - diese enthält den gerade aktiven Domain Namen<br />
* Behebung von einigen PHP Notices</p></li>
<li>1.5.2 - November 2011
<p>* Kompatibel mit CMSms 1.10.x.</p></li>
<li>1.5.1 - April 2011
<p>+ Nun können auch Seiten-Titel, Menütexte oder Seiten-Attribute im Front-End abgefragt werden (anstelle der Seiten-URL) - könnte bei einigen Menü-Templates hilfreich sein.</p></li>
<li>1.5 - März 2011
<p>+ Neuer Reiter: Fehler-Meldungen.<br />
+ 301-Weiterleitungs-Regeln unterstützen nun reguläre Ausdrücke.<br />
* Einige kleinere Verbesserungen in der Bedien-Oberfläche.<br />
* Fehler behoben: 301 Weiterleitungen waren nicht möglich bei einigen News-Artikeln.<br />
* Fehler behoben: Auf einigen Servern war eine Weiterleitung mit www. nicht möglich.</p></li>
<li>1.4.1 - Februar 2011
<p>+ Ignorier-Filter-Liste für 404-Fehler (inkl. RegExp.)<br />
+ Einstellung hinzugefügt, um eine Maximal-Zahl an mitgeloggten 404-Fehlern einzustellen.<br />
* Verbesserungen an der 404 Fehler-Liste und im 404-Handling.</p></li>
<li>1.4 - Februar 2011
<p>* Kompatibel mit CMSms 1.9.x.<br />
+ 404 Error Tracking.<br />
+ Platzhalter für korrekte Domainnamen in einem Link (z.B. für den Menumanager).<br />
* Fehlerbeseitigungen.</p></li>
<li>1.3 - Mai 2010
<p>* Auf Eventsteuerung umgestellt - Platzhalter wird nun nicht mehr benötigt.<br />
+ Schalter für Statistiken und Alte URL Weiterleitungen hinzugefügt.<br />
+ EMail Funktion für monatliche Statistik hinzugefügt.<br />
* Problem mit Log Summary.<br />
* Problem mit falschen Page Extensions beseitigt.<br />
* Problem mit Default Content beseitigt.</p></li>
<li>1.2.2 - Mai 2010
<p>* Problem mit 404 Seiten beseitigt.<br />
* Problem mit Entwicklungsserver beseitigt.</p></li>
<li>1.2.1 - Mai 2010
<p>* Fehler in der Log Summary beseitigt.</p></li>
<li>1.2 - Mai 2010
<p>+ Unterstützung für 301 Weiterleitungen für alte URLs hinzugefügt.<br />
+ Kleine Statistik hinzugefügt.<br />
* Einige Fehlerbeseitigungen.</p></li>
<li>1.1 - Mai 2010
<p>+ Unterstützung für mehr als eine Domain hinzugefügt.<br />
+ Unterstützung für Entwicklungsserver-Domain hinzugefügt.</p></li>
<li>1.0 - Mai 2010
<p>Erstes Release des Moduls MultiDomains.</p></li>
</ul>
EOT;
$lang['clear_cache'] = 'CMS-Cache nach Änderungen leeren';
$lang['clear_cache_help'] = 'Nach jeder Änderung der Domain-Einstellungen dieses Moduls wird der CMS-Cache geleert, damit die Änderungen sofort wirksam werden.';
$lang['config_backup_fail'] = 'Backup der alten config.php ist fehlgeschlagen. Geänderte config.php wird zum Download angeboten.';
$lang['config_download'] = 'Angepasste config.php downloaden';
$lang['config_modify'] = 'config.php anpassen';
$lang['config_not_modified'] = 'Die Datei config.php wurde noch nicht angepasst!';
$lang['config_ok'] = 'Die Datei config.php wurde bereits angepasst und liegt in der richtigen Version vor :-)';
$lang['config_written'] = 'Die Datei config.php wurde angepasst. Von der alten config.php wurde unter %s ein Backup erstellt.';
$lang['config_written_fail'] = 'Schreiben der neuen config.php ist fehlgeschlagen. Geänderte config.php wird zum Download angeboten.';
$lang['config_wrong_version'] = 'Die Datei config.php liegt in der falsche Version vor!';
$lang['created'] = 'Erstes Auftreten';

# D
$lang['day'] = 'Tag';
$lang['days'] = 'Tage';
$lang['ddescription'] = 'Diese Domain wird genutzt von allen Seiten unterhalb (und eingeschlossen) Seite <strong>%s</strong>. Betroffene Seiten: ';
$lang['debug'] = 'Debug';
$lang['debug_log'] = 'Debug Log';
$lang['debug_use'] = 'Debug Reiter verwenden';
$lang['delete'] = 'Löschen';
$lang['deleteall'] = 'Alle löschen';
$lang['desc_cerror'] = 'Falsche Einstellungen';
$lang['desc_csuccess'] = 'Korrekte Einstellungen';
$lang['desc_hterror'] = 'Fehlende Zeilen';
$lang['desc_htsuccess'] = 'Korrekte Einstellungen';
$lang['devdomain'] = 'Entwicklungsservers Domainname';
$lang['devdomain_activate'] = 'Support für Entwicklungsserver';
$lang['devdomain_short'] = 'DevDomain';
$lang['devip'] = 'IP des Entwicklungsserver';
$lang['do'] = 'Aktion';
$lang['domain'] = 'Domain';
$lang['domainedit'] = 'Domain bearbeiten';
$lang['domainname'] = 'Domainname';
$lang['domains'] = 'Domains';
$lang['dont_use_event_handler'] = 'Modul in der Ereignisverwaltung deaktivieren';
$lang['dont_use_event_handler_help'] = 'Wenn das Modul aus der Ereignisverwaltung deaktiviert wird, muss die Smarty-Anweisung {MultiDomains} an den Anfang der Seiten-Templates eingesetzt werden.';
$lang['donate'] = '<div style="float:right"><form action="https://www.paypal.com/cgi-bin/webscr" method="post"><input type="hidden" name="cmd" value="_s-xclick"><input type="hidden" name="hosted_button_id" value="ED8PXCY89U4TG"><input type="image" src="https://www.paypalobjects.com/WEBSCR-640-20110306-1/de_DE/DE/i/btn/btn_donate_SM.gif" border="0" name="submit" alt="Jetzt einfach, schnell und sicher online bezahlen – mit PayPal."><img alt="" border="0" src="https://www.paypalobjects.com/WEBSCR-640-20110306-1/de_DE/i/scr/pixel.gif" width="1" height="1"></form></div>';

# E
$lang['edit'] = 'Bearbeiten';
$lang['error_permissiondenied'] = 'Zugriff verweigert';
$lang['errorinsertingdomain'] = 'Fehler bei der Domain Verarbeitung';
$lang['errorlist'] = 'Fehlerliste';
$lang['extradomains'] = 'Extra Domains';
$lang['extradomains_description'] = 'Domains, welche auf diese Domain gemappt werden sollen, jede in einer Zeile:';

# F
$lang['friendlyname'] = 'MultiDomains';
$lang['fromurl'] = 'Verweis-URL';

# G

# H
$lang['help'] = <<<EOT
<h3>Was macht dieses Modul?</h3>
<p>Dieses Modul ermöglicht eine Verwendung von verschiedenen Domains mit CMS made simple. Die Domains können dabei verschiedenen Seiten(bäumen) zugeordnet werden, so dass der Browser bei Eingabe einer Domain automatisch zur entsprechenden Seite (bzw. zum Seitenbaum) gelangt.</p>
<h3>Wie benutze ich dieses Modul?</h3>
<p><strong>1. Anpassungen an .htaccess und config.php</strong></p>
<p>- Erstelle eine neue Datei namens ".htaccess" (falls diese nicht bereits existiert) im CMSms Root Verzeichnis mit (mindestens) folgendem Inhalt:
<pre># .htaccess für CMS made simple
RewriteEngine On
RewriteBase /
RewriteCond %{REQUEST_URI} !/$
RewriteCond %{REQUEST_URI} !\.
RewriteCond %{REQUEST_METHOD} !POST$
RewriteRule ^(.*) %{REQUEST_URI}/ [NE,R=301,L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.+)$ index.php?page=$1 [QSA]
# EOF</pre></p>
<p>- Öffne die Datei "config.php" (im CMSms Root Verzeichnis) und setze den Parameter "url_rewriting" auf "mod_rewrite" (falls dies nicht schon geschehen ist).</p>
<p><strong>2. Füge deine Domains im Modul-Backend hinzu</strong><br />
Gehe ins Modul-Backend (unter Erweiterungen/MultiDomains) und füge deine Domains mit deren zugehörigen Seiten(bäumen) hinzu.</p>
<p><i>3. (Optional) Platzhalter für URLs benutzen (z.B. im Menumanager)</i><br />
z.B.: <code>{MultiDomains pageid=&quot;16&quot;}</code></p>
<h3>Nutzung ohne Ereignisverwaltung</h3>
<p>Seit Version 2.0 von MultiDomains gibt es in den Einstellungen die Möglichkeit, die Einbindung des Moduls in die Ereignisverwaltung zu unterbinden.</p>
<p>Stattdessen muss der Modulaufruf an den Anfang des/der Seiten-Templates eingebunden werden:<br /><code>{MultiDomains}</code><br />
Am besten ist dieser Aufruf gleich hinter {process_pagedata} platziert.</p>
<p>Dadurch stehen im Templates dann folgende Smarty-Variablen zur Verfügung:<br />
<code>\$mdsite</code> - enthält die gerade aktive Domain (ohne www, wie sie auch im Modul hinterlegt wird)<br />
<code>\$mddevsite</code> - enthält die gerade aktive Entwicklungsserver-Domain (steht nur auf dem Entwicklungsserver zur Verfügung)</p>
<p>Angeblich soll dadurch auch das eingebaute Caching von CMSms nicht mehr behindert werden.</p>
<h3>Parameter</h3>
<ul>
<li><i>pageid</i> - ID der Seite, zu welcher die URL zurückgeliefert werden soll.</li>
<li><i>pagealias</i> - (nur, falls pageid nicht nutzbar) Alias der Seite, zu welcher die URL zurückgeliefert werden soll.</li>
<li><i>linkvalue</i> - Wenn Du (statt der URL) den Titel der Seite, den Menü Text oder die Beschreibung ausgeben möchtest, kannst Du diesen Parameter verwenden.<br />Verfügbare Werte: title, menutext, titleattribute, url<br />Standard-Wert: url</li>
</ul>
<h3>Support</h3>
<p>Dieses Modul besitzt keinen kommerziellen Support. Jedoch gibt es einige Anlaufstellen für Hilfestellungen:</p>
<ul>
<li>Für die neueste Version dieses Modules, FAQs, oder um einen Fehler zu berichten, besuchen Sie bitte die Webseiten von CMS made simple: http://www.cmsmadesimple.de</li>
<li>Zusätzliche Diskussionen über dieses Modul können auch im Forum gefunden werden: http://forum.cmsmadesimple.de/viewforum.php?id=9</li>
<li>Der Autor, Andi Petzoldt, kann über seine Webseite erreicht werden: http://andiministrator.de/</li>
<li>Außerdem kann der Autor über seine EMail-Adresse erreicht werden.</li>
</ul>
<h3>Copyright and License</h3>
<p>Copyright © 2011, Andi Petzoldt <andi@petzoldt.net>. Alle Rechte vorbehalten.</p>
<p>Dieses Modul wurde unter der GPL (GNU Public License) veröffentlicht. Sie müssen dieser Lizenz zustimmen, bevor Sie dieses Modul benutzen.</p>
EOT;
$lang['htaccess_missing'] = 'Die Datei .htaccess ist nicht vorhanden!';
$lang['htaccess_ok'] = 'Die Datei .htaccess enthält keine Fehler :-)';

# I
$lang['id'] = 'ID';
$lang['installed'] = 'installiert';
$lang['ip'] = 'IP Nummer';

# J

# K
$lang['keyword'] = 'Suchbegriff';

# L
$lang['last_day'] = 'Gestern';
$lang['last_month'] = 'Letzter Monat';
$lang['last_year'] = 'Letztes Jahr';
$lang['linkvalue'] = 'Rückgabewert des Links';

# M
$lang['makeactive'] = 'Aktivieren';
$lang['makeinactive'] = 'Deaktivieren';
$lang['makestandard'] = 'Als Standard';
$lang['moddescription'] = 'Mit diesem Modul kann CMSms verschiedene Domains innerhalb einer Installation (und Backend) verwalten. Weiterhin bietet es auch eine kleine Statistik.';
$lang['modified'] = 'Letztes Auftreten';
$lang['month'] = 'Monat';
$lang['months'] = 'Monate';
$lang['morehelp'] = 'Rufe die Modulhilfe auf, um nähere Informationen zu erhalten!';

# N
$lang['never'] = 'Niemals';
$lang['new'] = '(neu)';
$lang['newdomain'] = 'Neue Domain';
$lang['notes'] = 'Notizen';

# O

# P
$lang['page'] = 'Seite';
$lang['pageid'] = 'Seiten-ID';
$lang['pagealias'] = 'Seiten-Alias';
$lang['postinstall'] = 'Das Modul MultiDomains wurde erfolgreich installiert. Sie erreichen das Modul-Backend über Erweiterungen / MultiDomains. Das Modul nutzt die Berechtigung "Manage MultiDomains".';
$lang['postuninstall'] = 'Das Modul MultiDomains wurde erfolgreich deinstalliert.';
$lang['preferences'] = 'Einstellungen';
$lang['prefix'] = 'WWW Prefix?';
$lang['preuninstall'] = 'Sind Sie sicher, dass Sie das Modul MultiDomains wirklich deinstallieren können?';

# Q

# R
$lang['reallymakeactive'] = 'Wirklich aktivieren?';
$lang['reallymakeinactive'] = 'Wirklich deaktivieren?';
$lang['reallydelete'] = 'Wirklich löschen?';
$lang['referer'] = 'Herkunft';
$lang['regexp'] = 'RegExp';
$lang['reset'] = 'Zurücksetzen';
$lang['root'] = 'Root';
$lang['root_help'] = 'Soll diese Domain bei Eingabe ohne Request-String (also ohne was nach der Domain) auf die erste Seite innerhalb sich selbst geleitet werden?<br />Sonst wird in diesem Fall auf die Standard Seite umgeleitet, die in der Seitenübersicht festgelegt wurde.';

# S
$lang['searchengine'] = 'Suchmaschine';
$lang['send'] = 'Absenden';
$lang['session_id'] = 'Session ID';
$lang['standard'] = 'Standard';
$lang['stats'] = 'Statistiken';
$lang['stats_daily'] = 'Tägliche Statistik verwenden';
$lang['stats_email'] = 'EMail für monatliche Statistik';
$lang['stats_email_help'] = 'Leer lassen, wenn keine EMails versandt werden sollen';
$lang['stats_email_subject'] = 'MultiDomains Statistik %u von %m';
$lang['stats_use'] = 'Statistik verwenden';
$lang['status'] = 'Status';
$lang['submit'] = 'Speichern';

# T
$lang['targetpage'] = 'Ziel-Seite';
$lang['targeturl'] = 'Ziel-URL';
$lang['time'] = 'Zeit';
$lang['tourl'] = 'Fehlende Seite';

# U
$lang['url'] = 'URL';
$lang['urls'] = 'URLs';

# V
$lang['visits'] = 'Besucher';
$lang['view'] = 'Anschauen';

# W
$lang['www_notice'] = 'ohne www.';
$lang['www_replace'] = 'Ersetze www';

# X

# Y
$lang['year'] = 'Jahr';
$lang['year'] = 'Jahre';

# Z

// EOF