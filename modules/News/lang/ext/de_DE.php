<?php
$lang['addarticle'] = 'Artikel hinzufügen';
$lang['addcategory'] = 'Kategorie hinzufügen';
$lang['addfielddef'] = 'Extrafeld hinzufügen';
$lang['addnewsitem'] = 'Nachrichteneintrag hinzufügen';
$lang['allcategories'] = 'Alle Kategorien';
$lang['allentries'] = 'Alle Einträge';
$lang['allowed_upload_types'] = 'Es dürfen nur Dateien mit dieser Namenserweiterung hochgeladen werden';
$lang['allow_summary_wysiwyg'] = 'Den WYSIWYG-Editor für das Zusammenfassungsfeld verwenden';
$lang['anonymous'] = 'Anonym';
$lang['apply'] = 'Übernehmen';
$lang['approve'] = 'Status auf „veröffentlicht“ setzen';
$lang['areyousure'] = 'Wollen Sie dies wirklich löschen?';
$lang['areyousure_deletemultiple'] = 'Wollen Sie wirklich alle ausgewählten Artikel löschen?\\nDies kann NICHT rückgängig gemacht werden!';
$lang['areyousure_multiple'] = 'Wollen sie diese Aktion wirklich mit mehreren Artikel durchführen?';
$lang['article'] = 'Artikel';
$lang['articleadded'] = 'Der Artikel wurde hinzugefügt.';
$lang['articledeleted'] = 'Der Artikel wurde gelöscht.';
$lang['articles'] = 'Artikel';
$lang['articlesubmitted'] = 'Der Artikel wurde gespeichert.';
$lang['articleupdated'] = 'Der Artikel wurde aktualisiert.';
$lang['author'] = 'Autor';
$lang['author_label'] = 'Erstellt von:';
$lang['auto_create_thumbnails'] = 'Für Dateien mit dieser Namenserweiterung automatisch ein Vorschaubild erstellen';
$lang['bulk_delete'] = 'Löschen';
$lang['bulk_setcategory'] = 'Kategorie festlegen';
$lang['bulk_setdraft'] = 'Auf „Entwurf“ setzen';
$lang['bulk_setpublished'] = 'Auf „veröffentlicht“ setzen';
$lang['browsecattemplate'] = 'Vorlagen für die Kategorienanzeige';
$lang['cancel'] = 'Abbrechen';
$lang['categories'] = 'Kategorien';
$lang['category'] = 'Kategorie';
$lang['categoryadded'] = 'Die Kategorie wurde hinzugefügt.';
$lang['categorydeleted'] = 'Die Kategorie wurde gelöscht.';
$lang['categoryupdated'] = 'Die Kategorie wurde aktualisiert.';
$lang['category_label'] = 'Kategorie:';
$lang['checkbox'] = 'Kontrollkästchen';
$lang['close'] = 'Schließen';
$lang['content'] = 'Inhalt';
$lang['customfields'] = 'Benutzerdefinierte Felder';
$lang['dateformat'] = '%s ist nicht im gültigen Format „JJJJ-MM-TT hh:mm:ss“';
$lang['default_category'] = 'Voreingestellte Kategorie';
$lang['default_templates'] = 'Voreingestellte Vorlagen';
$lang['delete'] = 'Löschen';
$lang['delete_article'] = 'Artikel löschen';
$lang['delete_selected'] = 'Ausgewählte Artikel löschen';
$lang['deprecated'] = 'Nicht unterstützt';
$lang['description'] = 'Hinzufügen, Bearbeiten und Löschen von Nachrichtenartikeln';
$lang['desc_adminsearch'] = 'Alle Artikel durchsuchen, unabhängig vom Status oder Ablaufdatum';
$lang['desc_news_settings'] = 'Einstellungen für das Nachrichtenmodul';
$lang['detailtemplate'] = 'Detailvorlagen';
$lang['detailtemplateupdated'] = 'Das aktualisierte Detailvorlage wurde in der Datenbank gespeichert.';
$lang['detail_page'] = 'Detail-Ansichtsseite';
$lang['detail_template'] = 'Detailvorlage';
$lang['displaytemplate'] = 'Vorlage anzeigen';
$lang['down'] = 'Nach unten';
$lang['draft'] = 'Entwurf';
$lang['dropdown'] = 'Auswahl';
$lang['edit'] = 'Bearbeiten';
$lang['editarticle'] = 'Artikel bearbeiten';
$lang['editcategory'] = 'Kategorie bearbeiten';
$lang['editfielddef'] = 'Felddefinition bearbeiten';
$lang['email_subject'] = 'Betreff der ausgehenden E-Mail';
$lang['email_template'] = 'Inhalt der E-Mail-Nachricht';
$lang['enddate'] = 'Ende';
$lang['endrequiresstart'] = 'Wenn Sie einen Endzeitpunkt angeben, müssen Sie auch ein Startzeitpunkt festgelegen.';
$lang['entries'] = '%s Einträge';
$lang['error_categorynotfoun'] = 'Die angegebene Kategorie wurde nicht gefunden';
$lang['error_categoryparent'] = 'Ungültige übergeordnete Kategorie';
$lang['error_duplicatename'] = 'Ein Eintrag mit diesem Namen existiert bereits';
$lang['error_filesize'] = 'Die hochgeladene Datei überschreitet die maximal erlaubte Größe';
$lang['error_insufficientparams'] = 'Unzureichende (oder leere) Parameter';
$lang['error_invaliddates'] = 'Ein oder mehrere der eingegebenen Daten sind ungültig';
$lang['error_invalidfiletype'] = 'Dieser Dateityp darf nicht hochgeladen werden';
$lang['error_invalidurl'] = 'Ungültige URL <em>(eventuell wird diese bereits verwendet oder sie enthält ungültige Zeichen)</em>';
$lang['error_mkdir'] = 'Konnte das Verzeichnis %s nicht erstellen';
$lang['error_movefile'] = 'Konnte die Datei %s nicht erstellen';
$lang['error_noarticlesselected'] = 'Es wurden keine Artikel ausgewählt';
$lang['error_nooptions'] = 'Keine Optionen für die Felddefinition angegeben';
$lang['error_templatenamexists'] = 'Es existiert bereits eine Vorlage mit diesem Namen';
$lang['error_upload'] = 'Beim Hochladen der Datei ist ein Problem aufgetreten';
$lang['eventdesc-NewsArticleAdded'] = 'Ausführen, wenn ein Artikel hinzugefügt wurde.';
$lang['eventhelp-NewsArticleAdded'] = '<table>
	<thead>
		<th>Parameter</th>
		<th>Beschreibung</th>
	</thead>
	<tbody>
		<tr>
			<th>news_id</th>
			<td>ID des Nachrichtenartikels</td>
		</tr>
		<tr>
			<th>category_id</th>
			<td>ID der Kategorie für diesen Artikel</td>
		</tr>
		<tr>
			<th>title</th>
			<td>Titel des Artikels</td>
		</tr>
		<tr>
			<th>content</th>
			<td>Inhalt des Artikels</td>
		</tr>
		<tr>
			<th>summary</th>
			<td>Zusammenfassung des Artikels</td>
		</tr>
		<tr>
			<th>status</th>
			<td>Status des Artikels („Entwurf/draft“ oder „Veröffentlicht/publish“)</td>
		</tr>
		<tr>
			<th>start_time</th>
			<td>Datum, ab dem der Artikel angezeigt werden soll</td>
		</tr>
		<tr>
			<th>end_time</th>
			<td>Datum, ab dem der Artikel nicht mehr angezeigt werden soll</td>
		</tr>
		<tr>
			<th>useexp</th>
			<td>die Zeitsteuerung soll ignoriert werden oder auch nicht</td>
		</tr>
	</tbody>
</table>';
$lang['eventdesc-NewsArticleDeleted'] = 'Ausführen, wenn ein Artikel gelöscht wurde.';
$lang['eventhelp-NewsArticleDeleted'] = '<table>
	<thead>
		<th>Parameter</th>
		<th>Beschreibung</th>
	</thead>
	<tbody>
		<tr>
			<th>news_id</th>
			<td>ID des Nachrichtenartikels</td>
		</tr>
	</tbody>
</table>';
$lang['eventdesc-NewsArticleEdited'] = 'Ausführen, wenn ein Artikel bearbeitet wurde.';
$lang['eventhelp-NewsArticleEdited'] = '<table>
	<thead>
		<th>Parameter</th>
		<th>Beschreibung</th>
	</thead>
	<tbody>
		<tr>
			<th>news_id</th>
			<td>ID des Nachrichtenartikels</td>
		</tr>
		<tr>
			<th>category_id</th>
			<td>ID der Kategorie für diesen Artikel</td>
		</tr>
		<tr>
			<th>title</th>
			<td>Titel des Artikels</td>
		</tr>
		<tr>
			<th>content</th>
			<td>Inhalt des Artikels</td>
		</tr>
		<tr>
			<th>summary</th>
			<td>Zusammenfassung des Artikels</td>
		</tr>
		<tr>
			<th>status</th>
			<td>Status des Artikels („Entwurf/draft“ oder „Veröffentlicht/publish“)</td>
		</tr>
		<tr>
			<th>start_time</th>
			<td>Datum, ab dem der Artikel angezeigt werden soll</td>
		</tr>
		<tr>
			<th>end_time</th>
			<td>Datum, ab dem der Artikel nicht mehr angezeigt werden soll</td>
		</tr>
		<tr>
			<th>useexp</th>
			<td>die Zeitsteuerung soll ignoriert werden oder auch nicht</td>
		</tr>
	</tbody>
</table>';
$lang['eventdesc-NewsCategoryAdded'] = 'Ausführen, wenn eine Kategorie hinzugefügt wurde.';
$lang['eventhelp-NewsCategoryAdded'] = '<table>
	<thead>
		<th>Parameter</th>
		<th>Beschreibung</th>
	</thead>
	<tbody>
		<tr>
			<th>category_id</th>
			<td>ID der Nachrichtenkategorie</td>
		</tr>
		<tr>
			<th>name</th>
			<td>Name der Nachrichtenkategorie</td>
		</tr>
	</tbody>
</table>';
$lang['eventdesc-NewsCategoryDeleted'] = 'Ausführen, wenn eine Kategorie gelöscht wurde.';
$lang['eventhelp-NewsCategoryDeleted'] = '<table>
	<thead>
		<th>Parameter</th>
		<th>Beschreibung</th>
	</thead>
	<tbody>
		<tr>
			<th>category_id</th>
			<td>ID der gelöschten Nachrichtenkategorie</td>
		</tr>
		<tr>
			<th>name</th>
			<td>Name der gelöschten Nachrichtenkategorie</td>
		</tr>
	</tbody>
</table>';
$lang['eventdesc-NewsCategoryEdited'] = 'Ausführen, wenn eine Kategorie bearbeitet wurde.';
$lang['eventhelp-NewsCategoryEdited'] = '<table>
	<thead>
		<th>Parameter</th>
		<th>Beschreibung</th>
	</thead>
	<tbody>
		<tr>
			<th>category_id</th>
			<td>ID der Nachrichtenkategorie</td>
		</tr>
		<tr>
			<th>name</th>
			<td>Name der Nachrichtenkategorie</td>
		</tr>
		<tr>
			<th>origname</th>
			<td>ursprünglicher Name der Nachrichtenkategorie</td>
		</tr>
	</tbody>
</table>';
$lang['expired'] = 'abgelaufen';
$lang['expired_searchable'] = 'Artikel, deren Anzeigedauer überschritten ist, dürfen in den Suchergebnissen erscheinen';
$lang['expired_viewable'] = 'Abgelaufene Artikel können in der Detailansicht angezeigt werden';
$lang['expiry'] = 'Ablauf';
$lang['expiry_date_asc'] = 'nach Verfallsdatum aufsteigend';
$lang['expiry_date_desc'] = 'nach Verfallsdatum absteigend';
$lang['expiry_interval'] = 'Voreingestellte Anzahl der Tage, nach denen ein Artikel nicht mehr auf der Webseite angezeigt werden soll (falls die Zeitsteuerung verwendet wird)';
$lang['extra'] = 'Extrafeld';
$lang['extra_label'] = 'Extra:';
$lang['fesubmit_redirect'] = 'Die Seiten-ID oder der Seiten-Alias der Seite, auf die der Einsender eines Artikels über die fesubmit-Aktion weitergeleitet werden soll';
$lang['fesubmit_status'] = 'Status für Artikel, die über die Webseite (Frontend) eingesandt wurden';
$lang['fielddef'] = 'Felddefinition';
$lang['fielddefadded'] = 'Das Feld wurde hinzugefügt';
$lang['fielddefdeleted'] = 'Felddefinition gelöscht';
$lang['fielddefupdated'] = 'Das Felddefinition wurde aktualisiert';
$lang['file'] = 'Datei';
$lang['filter'] = 'Artikelfilter';
$lang['firstpage'] = '«';
$lang['formsubmit_emailaddress'] = 'E-Mail-Adresse zur Benachrichtigung bei neuen Artikeln';
$lang['formtemplate'] = 'Formularvorlagen';
$lang['help'] = '<h3>Wichtiger Hinweis</h3>
<p>Ab Version 2.9 des Nachrichtenmoduls wurde sowohl das Variablenelement <code>$entry->formatpostdate</code> als auch der Parameter „dateformat“ entfernt. Sie sollten daher anstatt <code>$entry->formatpostdate</code> jetzt <code>$entry->postdate</code> verwenden. Das Datum kann dann mit dem Modifikator „cms_date_format“ formatiert werden (wie in den mitgelieferten Muster-Templates gezeigt).</p>
<h3>Was macht dieses Modul?</h3>
<p>„News“ ist ein Modul, um Artikel/Neuigkeiten Blog-ähnlich auf Ihrer Seite anzuzeigen, jedoch mit mehr Möglichkeiten. Nach der Modulinstallation wird dem Menüpunkt „Inhalte“ ein Link zur Administration des News-Moduls hinzugefügt, über den Sie Nachrichtenkategorien auswählen oder hinzufügen können. Wurde eine Kategorie angelegt oder ausgewählt, wird eine Liste der vorhandenen Einträge dieser Kategorie angezeigt. Von hier aus können Sie dieser Kategorie Einträge hinzufügen, bearbeiten oder löschen.</p>
<h4>Verschiedene Anzeigemethoden</h4>
<p>Aufgrund der verfügbaren Parameter und die Unterstützung für verschiedene Templates sind die Verwendungsmöglichkeiten des Moduls extrem vielfältig.</p>
<h4>Benutzerdefinierte Felder</h4>
<p>Im News-Modul können auch benutzerdefinierte Felder erstellt werden (einschließlich für Dateien und Bilder). Dies macht es möglich, dass Sie den Artikeln auch PDF-Dateien oder Bilder o. ä. anhängen können.</p>
<h4>Kategorien</h4>
<p>Für die Verwaltung der Nachrichtenartikel bietet das Modul einen hierarchischen Kategorie-Mechanismus. Ein Nachrichtenartikel kann jedoch nicht mehreren Kategorien zugeordnet werden.</p>
<h4>Verfallsdatum und Status</h4>
<p>Jeder News-Artikel kann optional mit einem Verfallsdatum versehen werden, nach dem er nicht mehr auf der Webseite angezeigt werden soll. Außerdem kann der Status des News-Artikels auf <em>„Entwurf“</em> gesetzt werden, um ihn dauerhaft von der Webseite zu entfernen.</p>
<h3>Sicherheit</h3>
<p>Um News-Einträge hinzufügen oder bearbeiten zu können, muss der Benutzer einer Gruppe angehören, die die Berechtigung „Modify News“ hat.</p>
<p>Um News-Einträge löschen zu können, muss der Benutzer einer Gruppe angehören, die die Berechtigung „Delete News Articles“ hat.</p>
<p>Um die Templates bearbeiten zu können, muss der Benutzer einer Gruppe angehören, die die Berechtigung „Modify Templates“ hat.</p>
<p>Um die globalen News-Einstellungen zu ändern, muss der Benutzer einer Gruppe angehören, die die Berechtigung „Modify Site Preferences“ hat.</p>
<p>Um News-Einträge für die Anzeige auf der Website freizugeben, muss der Benutzer zusätzlich einer Gruppe angehören, die die Berechtigung „Approve News“ hat.</p>
<h3>Wie wird es eingesetzt?</h3>
<p>Am einfachsten kann das Modul mit dem <code>{news}</code>-Tag verwendet werden. Dieser fügt die Ausgabe des Moduls in Ihr Template oder Seite ein und zeigt die News-Einträge an. Der einzufügende Code sollte so aussehen: <code>{news number=\'5\'}</code></p>
<h3>Templates</h3>
<p>Seit Version 2.3 werden die Templates des News-Moduls in der Datenbank gespeichert. Dateibasierte Templates werden nicht mehr unterstützt. Wenn Sie noch solche verwenden, sollten Sie mit der folgenden Anleitung jedes verwendete (dateibasierte) Template importieren:</p>
<ul>
<li>Kopieren Sie den Inhalt Ihrer Template-Datei in den Zwischenspeicher Ihres Rechners.</li>
<li>Erstellen Sie ein neues Datenbank-Template <em>(je nach Bedarf für die Zusammenfassungs- oder Detailansicht)</em>. Geben Sie dem neuen Template den gleichen Namen wie der alten (einschließlich der Endung .tpl). Fügen Sie den Inhalt des Zwischenspeichers ein.</li>
<li>Klicken Sie auf „Absenden“</li>
</ul>
<p>Mit diesem Ablauf sollte sichergestellt sein, dass Fehlermeldungen über Templates, die nicht gefunden werden oder ähnliche Smarty-Fehler, nicht auftreten, wenn auf eine CMSms-Version aktualisiert wird, die das News-Modul 2.3 oder höher verwendet.</p>
<h4>Template-Variablen</h4>
<ul>
	<li><strong>itemcount</strong> - maximale Anzahl der anzuzeigenden News-Artikel
	<li><strong>entry->authorname</strong> - vollständiger Name des News-Autors (Vor-/Nachname), wie er in der Benutzer-Verwaltung gespeichert ist</li>
</ul>
<p>Auch die Variablen der Extra-Felder können in den Templates separat verwendet werden. So lässt sich zum Beispiel das Extrafeld mit dem Namen „musterfeld“ über die Variable entry->musterfeld abfragen.</p>
<p><strong>ACHTUNG:</strong> Leerzeichen müssen dabei durch den Unterstrich („_“) ersetzt werden.</p>';
$lang['helpaction'] = 'Überschreibt die vorgegebene Aktion. Mögliche Werte sind:
<ul>
<li>"detail" - einen bestimmten Artikel im Detail-Modus anzeigen</li>
<li>"default" - die Zusammenfassungansicht anzeigen</li>
<li>"fesubmit" - auf der Webseite ein Formular zum Einsenden neuer Artikel anzeigen. Um für das Formular den voreingestellten WYSIWYG-Editor zu verwenden, müssen Sie den Metadaten (Webseiten-Administration > Globale Einstellungen) <code>{cms_init_editor}</code> hinzufügen.</li>
<li>"browsecat" - eine Kategorienliste anzeigen.</li>
</ul>';
$lang['helpbrowsecat'] = 'Mit diesem Parameter wird eine Liste der Kategorien angezeigt (browsecat=\'1\'). Kann NICHT zusammen mit dem Parameter „category“ verwendet werden.';
$lang['helpbrowsecattemplate'] = 'Verwendet ein Template für die Anzeige der Kategorien. Dieses Template muss vorhanden sein und  in der Administration des News-Moduls in der Registerkarte „Kategorien-Template“ angezeigt werden. Sie muss jedoch nicht als Standard gekennzeichnet sein. Ohne Parameter wird das als Standard gekennzeichnete Template für die Anzeige verwendet.';
$lang['helpcategory'] = 'Mit diesem Parameter können Sie festlegen, aus welcher Kategorie die Einträge angezeigt werden. <strong>Um auch die Unterkategorien anzuzeigen, geben Sie nach dem Kategorienamen ein * ein.</strong> Über eine durch Kommata getrennte Liste können auch mehrere Kategorien angezeigt werden. Ohne diesen Parameter werden alle Kategorien angezeigt. Dieser Parameter funktioniert auch mit der Aktion „fesubmit“, obwohl dort nur eine Kategorie unterstützt wird.';
$lang['helpdetailpage'] = 'Seite, auf der die Nachrichtendetails angezeigt werden. Das kann entweder ein Seiten-Alias oder eine Seiten-ID sein. Damit können die Nachrichtendetails in einem anderen Template als die Nachrichtenzusammenfassung angezeigt werden.';
$lang['helpdetailtemplate'] = 'Verwendet eine separates Template für die Detail-Anzeige des Artikels. Dieses Template muss vorhanden sein und in der Administration des News-Moduls in der Registerkarte „Detail-Template“ angezeigt werden. Ohne Parameter wird das als Standard gekennzeichnete Template verwendet.';
$lang['helpformtemplate'] = 'Verwendet ein Template für die Anzeige des Formulars zur Übermittlung neuer Artikel. Dieses Template muss vorhanden sein und in der Administration des News-Moduls in der Registerkarte „Formular-Template“ angezeigt werden. Ohne Parameter wird das als Standard gekennzeichnete Template verwendet.';
$lang['helpmoretext'] = 'Mit diesem Parameter wird der Text festgelegt, der nach der News-Zusammenfassung angezeigt wird, wenn der Artikel länger als die vorgegebene Länge ist. Vorgegeben ist „Weiterlesen …“';
$lang['helpnumber'] = 'Anzahl der maximal anzuzeigenden Einträge (pro Seite) – ohne Parameter werden alle Einträge angezeigt. Dies ist ein Synonym für den Parameter <tt>pagelimit</tt>.';
$lang['helpshowall'] = 'Mit diesem Parameter können alle Artikel (unabhängig von der festgelegten Anzeigedauer) angezeigt werden (showall=\'1\').';
$lang['helpshowarchive'] = 'Mit diesem Parameter werden nur die Artikel angezeigt, deren festgelegte Anzeigedauer bereits abgelaufen ist (showarchive=\'1\').';
$lang['helpsortasc'] = 'Sortiert Einträge in aufsteigender Folge anstatt in absteigender (nach Datum).';
$lang['helpsortby'] = 'Felder, nach denen die Einträge sortiert werden. Mögliche Optionen sind: „news_date“, „summary“, „news_data“, „news_category“, „news_title“, „news_extra“, „end_time“, „start_time“, „random“. Standard ist „news_date“. Ist die gewählte Option „random“, wird der Parameter „sortasc“ ignoriert.';
$lang['helpstart'] = 'Beginnt die Anzeige mit dem n-ten Eintrag – wird das Feld leer gelassen, wird mit dem ersten Eintrag begonnen.';
$lang['helpsummarytemplate'] = 'Verwendet ein separates Template für die Anzeige der Artikel-Zusammenfassungen. Dieses Template muss vorhanden sein und in der Administration des News-Moduls in der Registerkarte „Zusammenfassungs-Template“ angezeigt werden. Ohne Parameter wird das als Standard gekennzeichnete Template verwendet.';
$lang['help_articleid'] = 'Dieser Parameter funktioniert nur in der Detailansicht. Mit ihm kann vorgegeben werden, welcher Artikel im Detail-Modus angezeigt werden soll. Wird an dieser Stelle der Wert -1 verwendet, wird der neueste veröffentlichte, nicht abgelaufene Artikel angezeigt.';
$lang['help_article_title'] = 'Der Titel des Artikels sollte kurz sein und keinen HTML-Code beinhalten';
$lang['help_article_category'] = 'Für Organisationszwecke kann eine Kategorie ausgewählt werden';
$lang['help_article_content'] = 'Der Hauptinhalt des Artikels';
$lang['help_article_enddate'] = 'Wenn die Verwendung des Verfallsdatums aktiviert ist, gibt dieses Datum an, ab wann der Artikel vor der Öffentlichkeit versteckt wird.';
$lang['help_article_extra'] = 'Das sind Extra-Daten, die mit dem News-Artikel verknüpft werden können. Sie können für die Sortierreihenfolge oder andere Darstellungsaufgaben verwendet werden. Sie sollten Ihren Webdesigner fragen, wie dieses Feld verwendet werden sollte - wenn überhaupt.';
$lang['help_article_searchable'] = 'Dieses Feld zeigt an, ob ein Artikel durch das Suchmodul indiziert werden soll.';
$lang['help_article_postdate'] = 'Das Absendedatum <em>(normalerweise das aktuelle Datum neuer Artikel)</em> ist das Datum, das als Veröffentlichungsdatum verwendet wird. Außerdem wird es zur Sortierung verwendet.';
$lang['help_article_summary'] = 'Geben Sie einen kurzen Text zur Beschreibung des Artikels ein. Diese Zusammenfassung kann verwendet werden, wenn mehrere Artikel angezeigt werden sollen.';
$lang['help_article_startdate'] = 'Wenn die Verwendung des Verfallsdatums aktiviert ist, gibt dieses Datum an, ab wann der Artikel öffentlich sichtbar ist.';
$lang['help_article_status'] = 'Wenn der Artikel sofort für alle sichtbar sein soll, setzen Sie den Status auf „veröffentlicht“. Wenn Sie am Artikel noch weiter arbeiten wollen, setzen Sie den Status auf „Entwurf“.';
$lang['help_articles_sortby'] = 'Wählen Sie aus, wie die Artikel normalerweise sortiert werden sollen.';
$lang['help_category_name'] = 'Geben Sie einen Namen für diese Kategorie an; der Name sollte für die Verwendung in URLs geeignet sein, d. h. keine Sonder- oder Leerzeichen enthalten.';
$lang['help_fielddef_options'] = 'Hier können gültige Optionen für Auswahlfelder angegeben werden';
$lang['help_pagelimit'] = 'Maximale Anzahl der anzuzeigenden Einträge (pro Seite). Ohne diesen Parameter werden alle Einträge angezeigt. Wenn dieser Parameter gesetzt wurde und mehr Einträge vorhanden sind, als pro Seite angezeigt werden sollen, werden Links eingeblendet, um vorwärts oder rückwärts zu den nächsten Seiten blättern zu können.';
$lang['hide_summary_field'] = 'Das Zusammenfassungsfeld verbergen, wenn ein Artikel hinzugefügt oder bearbeitet wird';
$lang['info_allow_fesubmit'] = 'Mit dieser Option wird festgelegt, ob eine Veröffentlichung über das Frontend erlaubt ist. Bitte mit Vorsicht verwenden!';
$lang['info_categories'] = 'Zu organisatorischen Zwecken können News-Artikel in hierarchischen Kategorien angeordnet werden.';
$lang['info_detail_returnid'] = 'Mit diesen Einstellungen kann eine Seite festgelegt werden (und damit auch ein Template), die für die Anzeige der Detailansicht verwendet werden soll. Die individuellen News-Detail-URLs werden jedoch nicht funktionieren, wenn dieser Parameter keine gültige Seite enthält. Wird diese Einstellung aktiviert und im news-Tag der Parameter detailpage nicht angegeben, wird dieser Wert für Detail-Links verwendet.';
$lang['info_expired_searchable'] = 'Wenn aktiviert, können abgelaufene News-Artikel von dem Such-Modul indexiert und in Suchergebnissen angezeigt werden.';
$lang['info_expired_viewable'] = 'Wenn aktiviert, können abgelaufene Artikel im Detail-Modus angezeigt werden (dies reproduziert alte Funktionalität). Der showall Parameter kann für die URL (wenn sie pretty URL\'s nicht verwenden) verwendet werden, um zu zeigen dass auch abgelaufene Artikel angezeigt werden können.';
$lang['info_fesubmit_notification'] = 'Sie können optional eine E-Mail an eine bestimmte E-Mail-Adresse versenden lassen, wenn über das Frontend ein News-Artikel veröffentlicht wurde.';
$lang['info_maxlength'] = 'Die maximale Länge hat nur Auswirkungen auf einzeilige Textfelder.';
$lang['info_public'] = 'Nur öffentliche Felder werden in Zusammenfassungs- oder Detailansichten angezeigt und sind für öffentliche Bearbeitung verfügbar.';
$lang['info_reorder_categories'] = 'Ziehen Sie die Items in die richtige Reihenfolge, um Kategoriebezihungen zu ändern.';
$lang['info_searchable'] = 'Dieses Feld gibt an, ob der Artikel vom Such-Modul indexiert werden soll.';
$lang['info_sysdefault'] = '(der Inhalt, der standardmäßig beim Erstellen einer neuen Vorlage verwendet wird)';
$lang['info_sysdefault2'] = '<strong>Hinweis:</strong> In den Textbereichen dieser Registerkarte können Sie die Vorlagen vordefinieren, die automatisch eingefügt werden, wenn Sie eine neue Zusammenfassungs-, Detail- oder Formularvorlage erstellen. Das Ändern/Speichern der Inhalte in diesem Reiter hat <strong>keine Auswirkungen auf die aktuelle Anzeige</strong>.';
$lang['lastpage'] = '»';
$lang['lbl_adminsearch'] = 'Nachrichtenartikel suchen';
$lang['maxlength'] = 'Maximale Länge';
$lang['msg_cancelled'] = 'Aktion abgebrochen';
$lang['msg_categoriesreordered'] = 'Reihenfolge der Kategorien wurde aktualisiert';
$lang['msg_contenttype_removed'] = 'Der Inhaltstyp „News“ wird nicht mehr unterstützt. Bitte verwenden Sie in Ihren Seiten-Templates bzw. -inhalten anstatt dessen den {news}-Tag mit den entsprechenden Parametern.';
$lang['msg_success'] = 'Aktion erfolgreich';
$lang['more'] = 'weiterlesen';
$lang['moretext'] = 'Text für den Link „weiterlesen“';
$lang['name'] = 'Name';
$lang['nameexists'] = 'Ein Extra-Feld mit diesem Namen existiert bereits';
$lang['needpermission'] = 'Sie benötigen die Berechtigung „%s“, um diese Funktion nutzen zu können.';
$lang['newcategory'] = 'Neue Kategorie';
$lang['news'] = 'Nachrichten';
$lang['news_return'] = 'Zurück';
$lang['nextpage'] = '›';
$lang['noarticles'] = 'Es gibt im Moment keine Nachrichtenartikel';
$lang['noarticlesinfilter'] = 'Es gibt keine Nachrichtenartikel, die mit diesem Filter angezeigt werden';
$lang['nocategorygiven'] = 'Keine Kategorie vorhanden';
$lang['nocontentgiven'] = 'Es wurde kein Inhalt eingegeben';
$lang['noitemsfound'] = '<strong>Keine</strong> Einträge in der Kategorie %s gefunden';
$lang['nonamegiven'] = 'Es wurde kein Name eingegeben';
$lang['none'] = 'Keine';
$lang['nopostdategiven'] = 'Es wurde kein Erstellungsdatum eingestellt';
$lang['notanumber'] = 'Die maximale Länge ist keine Zahl';
$lang['note'] = '<em>Hinweis:</em> Datum/Zeit muss im Format „JJJJ-MM-TT hh:mm:ss“ angegeben werden.';
$lang['notify_n_draft_items'] = '%s Nachrichtenartikel wurde(n) noch nicht veröffentlicht.';
$lang['notify_n_draft_items_sub'] = '%d Nachrichtenartikel';
$lang['notitlegiven'] = 'Es wurde kein Titel eingegeben';
$lang['numbertodisplay'] = 'Anzuzeigende Anzahl (ohne Eintrag werden alle Datensätze angezeigt)';
$lang['options'] = 'Optionen';
$lang['optionsupdated'] = 'Die Einstellungen wurden gespeichert.';
$lang['parent'] = 'übergeordnet';
$lang['postdate'] = 'Erstellt am';
$lang['postinstall'] = 'Stellen Sie sicher, dass die Benutzer, die die News verwalten, die Berechtigung „Modify News“ haben.';
$lang['post_date_asc'] = 'nach Erstellungsdatum aufsteigend';
$lang['post_date_desc'] = 'nach Erstellungsdatum absteigend';
$lang['preview'] = 'Vorschau';
$lang['prevpage'] = '‹';
$lang['print'] = 'Drucken';
$lang['prompt_allow_fesubmit'] = 'Erlaubt das Abschicken von News-Artikeln über das Frontend';
$lang['prompt_default'] = 'Voreingestellt';
$lang['prompt_go'] = 'Los';
$lang['prompt_name'] = 'Name';
$lang['prompt_newtemplate'] = 'Eine neue Vorlage erstellen';
$lang['prompt_of'] = 'von';
$lang['prompt_page'] = 'Seite';
$lang['prompt_pagelimit'] = 'Artikel pro Seite';
$lang['prompt_redirecttocontent'] = 'Zurück zur Seite';
$lang['prompt_sorting'] = 'Sortieren';
$lang['prompt_template'] = 'Vorlagenquelle';
$lang['prompt_templatename'] = 'Vorlagenname';
$lang['public'] = 'Öffentlich';
$lang['published'] = 'Veröffentlicht';
$lang['reassign_category'] = 'Kategorie ändern auf';
$lang['removed'] = 'Entfernt';
$lang['reorder'] = 'neu anordnen';
$lang['reorder_categories'] = 'Kategorien neu anordnen';
$lang['reset'] = 'Zurücksetzen';
$lang['resettodefault'] = 'Auf die programmseitigen Voreinstellungen zurücksetzen';
$lang['restoretodefaultsmsg'] = 'Diese Funktion setzt die Templates auf die programmseitigen Voreinstellung zurück. Wollen Sie das wirklich?';
$lang['revert'] = 'Status auf „Entwurf“ setzen';
$lang['searchable'] = 'durchsuchbar';
$lang['select'] = 'Auswählen';
$lang['select_option'] = 'Option auswählen';
$lang['selectall'] = 'Alle auswählen';
$lang['selectcategory'] = 'Kategorie auswählen';
$lang['showchildcategories'] = 'Unterkategorien anzeigen';
$lang['sortascending'] = 'aufsteigend sortieren';
$lang['startdate'] = 'Beginn';
$lang['startdatetoolate'] = 'FEHLER: Der Startzeitpunkt muss VOR dem Endzeitpunkt liegen';
$lang['startoffset'] = 'Beginnt mit der Anzeige ab dem <em>n</em>-ten Eintrag';
$lang['startrequiresend'] = 'Die Eingabe eines Startzeitpunktes erfordert auch die Eingabe eines Endzeitpunktes.';
$lang['status'] = 'Status';
$lang['status_asc'] = 'nach Status aufsteigend';
$lang['status_desc'] = 'nach Status absteigend';
$lang['subject_newnews'] = 'Es wurde ein neuer Artikel eingesandt';
$lang['submit'] = 'Speichern';
$lang['summary'] = 'Zusammenfassung';
$lang['summarytemplate'] = 'Zusammenfassungsvorlage';
$lang['summarytemplateupdated'] = 'Das Zusammenfassungsvorlage wurde aktualisiert.';
$lang['sysdefaults'] = 'Auf die programmseitigen Voreinstellungen zurücksetzen';
$lang['template'] = 'Vorlage';
$lang['textarea'] = 'Mehrzeiliger Textbereich';
$lang['textbox'] = 'Einzeiliges Textfeld';
$lang['title'] = 'Titel';
$lang['title_asc'] = 'nach Titel aufsteigend';
$lang['title_available_templates'] = 'Verfügbare Vorlagen';
$lang['title_browsecat_sysdefault'] = 'Voreingestellte Vorlage für die Kategorienanzeige';
$lang['title_browsecat_template'] = 'Vorlageneditor für die Kategorienanzeige';
$lang['title_desc'] = 'nach Titel absteigend';
$lang['title_detail_returnid'] = 'Voreingestellte Seite, die für die Detailansicht verwendet werden soll';
$lang['title_detail_settings'] = 'Einstellungen für die Detailansicht';
$lang['title_detail_sysdefault'] = 'Voreingestellte Vorlage für die Details';
$lang['title_detail_template'] = 'Editor für die Detailvorlagen';
$lang['title_fesubmit_form'] = 'Artikel absenden';
$lang['title_fesubmit_settings'] = 'Einstellungen für die News-Einsendung über die Webseite';
$lang['title_filter'] = 'Anzeige filtern';
$lang['title_form_sysdefault'] = 'Voreingestellte Vorlage für das Formular';
$lang['title_form_template'] = 'Editor für die Formularvorlagen';
$lang['title_news_settings'] = 'Nachrichteneinstellungen';
$lang['title_notification_settings'] = 'Benachrichtigungseinstellungen';
$lang['title_submission_settings'] = 'Einstellungen für die Nachrichtenübertragung';
$lang['title_summary_sysdefault'] = 'Voreingestellte Vorlage für die Zusammenfassung';
$lang['title_summary_template'] = 'Editor für die Zusammenfassungsvorlagen';
$lang['toggle_bulk'] = 'Diesen Artikel für Massenbearbeitung auswählen';
$lang['type'] = 'Typ';
$lang['type_browsecat'] = 'Kategorie durchstöbern';
$lang['type_form'] = 'Webseitenformular';
$lang['type_detail'] = 'Detail';
$lang['type_News'] = 'Nachrichten';
$lang['type_summary'] = 'Zusammenfassung';
$lang['unknown'] = 'Unbekannt';
$lang['unlimited'] = 'Unbegrenzt';
$lang['up'] = 'Nach oben';
$lang['uploadscategory'] = 'Kategorie im Uploads-Modul';
$lang['url'] = 'Individuelle Artikel-URL';
$lang['useexpiration'] = 'Zeitsteuerung aktivieren';
$lang['viewfilter'] = 'Filter anzeigen';
$lang['warning_preview'] = 'Warnung: Diese Vorschau verhält sich ähnlich wie ein Browser-Fenster, mit dem Sie von der ursprünglich ausgewählten Seite aus navigieren können. Jedoch können unerwartete Verhalten auftreten. Wenn Sie auf der ursprünglich angewählten Seite navigieren und dann dorthin zurückkehren, sehen Sie die unveränderten Inhalte, obwohl Sie im der Hauptregisterkarte Änderungen vorgenommen und diese neu geladen haben. Wenn Sie Inhalte hinzufügen, währenddessen Sie auf der Seite navigieren, ist es Ihnen nicht möglich zurückzukehren - Sie müssen dann die Vorschau-Seite aktualisieren.<br /><strong>Hinweis:</strong> Im Vorschau-Modus werden keine Dateien hochladen, die Sie möglicherweise dafür ausgewählt haben.';
$lang['with_selected'] = 'ausgewählte';
?>