<?php
$lang['friendlyname']='CMSMailer ';
$lang['help']='<h3>Was macht dieses Modul?</h3>
<p>Dieses Modul hat keine direkte Funktionalit&auml;t f&uuml;r den Webseitenbesucher. Es stellt anderen Modulen nur die Ressourcen zum Versand von Emails bereit.</p>
<h3>Wie wird es eingesetzt ?</h3>
<p>Dieses Modul ist ein einfacher Wrapper f&uuml;r alle Methoden und Variablen von <a rel="external" href="http://phpmailer.sourceforge.net/">PHPmailer</a>. Es wurde zur Unterst&uuml;tzung f&uuml;r die Modul-Programmierung konzipiert. Im folgenden finden Sie ein Anwendungsbeispiel und eine kurze API-Referenz. Weitere Informationen finden Sie in der Dokumentation zu PHPmailer.</p>
<h3>Ein Beispiel</h3>
<pre>
  $cmsmailer = $this->GetModuleInstance(&#039;CMSMailer&#039;);
  $cmsmailer->AddAddress(&#039;calguy1000@hotmail.com&#039;,&#039;calguy&#039;);
  $cmsmailer->SetBody(&#039;<h4>Das ist eine Testnachricht</h4>&#039;);
  $cmsmailer->IsHTML(true);
  $cmsmailer->SetSubject(&#039;Testnachricht&#039;);
  $cmsmailer->Send();
</pre>
<h3>API</h3>
<ul>
<li><p><tt>void reset()</tt></p>
<p>Setzt das Objekt auf die in der Administration definierten Werte zur&uuml;ck</p>
</li>
<li><p><tt>string GetAltBody()</tt></p>
<p>Gibt den alternativen Email-Body zur&uuml;ck</p>
</li>
<li><p><tt>void SetAltBody( $string )</tt></p>
<p>Definiert den alternativen Email-Body</p>
</li>
<li><p><tt>string GetBody()</tt></p>
<p>Gibt den prim&auml;ren Email-Body zur&uuml;ck</p>
</li>
<li><p><tt>void SetBody( $string )</tt></p>
<p>Definiert den prim&auml;ren Email-Body</p>
</li>
<li><p><tt>string GetCharSet()</tt></p>
<p>Standard: iso-8859-1</p>
<p>Gibt den verwendeten Zeichensatz der Email zur&uuml;ck</p>
</li>
<li><p><tt>void SetCharSet( $string )</tt></p>
<p>Definiert den verwendeten Zeichensatz der Email</p>
</li>
<li><p><tt>string GetConfirmReadingTo()</tt></p>
<p>Gibt die Email-Adresse zur&uuml;ck, an die die Lesebest&auml;tigung gesandt wird</p>
</li>
<li><p><tt>void SetConfirmReadingTo( $address )</tt></p>
<p>Definiert oder l&ouml;scht die Email-Adresse f&uuml;r die Lesebest&auml;tigung</p>
</li>
<li><p><tt>string GetContentType()</tt></p>
<p>Standard: text/plain</p>
<p>Gibt den Typ des Inhalts der Email zur&uuml;ck</p>
</li>
<li><p><tt>void SetContentType()</tt></p>
<p>Definiert den Typ des Inhalts der Email</p>
</li>
<li><p><tt>string GetEncoding()</tt></p>
<p>Gibt die Kodierung der Email zur&uuml;ck</p>
</li>
<li><p><tt>void SetEncoding( $encoding )</tt></p>
<p>Definiert die Kodierung der Email</p>
<p>M&ouml;gliche Optionen sind: 8bit, 7bit, binary, base64, quoted-printable</p>
</li>
<li><p><tt>string GetErrorInfo()</tt></p>
<p>Gibt eine Fehler-Information zur&uuml;ck</p>
</li>
<li><p><tt>string GetFrom()</tt></p>
<p>Gibt die aktuelle Email-Adresse des Absenders zur&uuml;ck</p>
</li>
<li><p><tt>void SetFrom( $address )</tt></p>
<p>Definiert die Email-Adresse des Absenders</p>
</li>
<li><p><tt>string GetFromName()</tt></p>
<p>Gibt den Namen des Absenders zur&uuml;ck</p>
</li>
<li><p><tt>SetFromName( $name )</tt></p>
<p>Definiert den Namen des Absenders</p>
</li>
<li><p><tt>string GetHelo()</tt></p>
<p>Gibt den HELO-String zur&uuml;ck</p>
</li>
<li><p><tt>SetHelo( $string )</tt></p>
<p>Definiert den HELO-String</p>
<p>Standardwert: $hostname</p>
</li>
<li><p><tt>string GetHost()</tt></p>
<p>Gibt die SMTP-Hosts zur&uuml;ck (getrennt durch Semikolon)</p>
</li>
<li><p><tt>void SetHost( $string )</tt></p>
<p>Definiert die Hosts</p>
</li>
<li><p><tt>string GetHostName()</tt></p>
<p>Gibt den Hostnamen zur&uuml;ck, der f&uuml;r SMTP Helo verwendet wird</p>
</li>
<li><p><tt>void SetHostName( $hostname )</tt></p>
<p>Definiert den Hostnamen, der f&uuml;r SMTP Hello verwendet wird</p>
</li>
<li><p><tt>string GetMailer()</tt></p>
<p>Gibt den verwendeten Mailer zur&uuml;ck</p>
</li>
<li><p><tt>void SetMailer( $mailer )</tt></p>
<p>Gibt den verwendeten Mailer zur&uuml;ck, entweder sendmail, mail, oder smtp</p>
</li>
<li><p><tt>string GetPassword()</tt></p>
<p>Gibt das Passwort f&uuml;r die SMTP-Authentifizierung zur&uuml;ck</p>
</li>
<li><p><tt>void SetPassword( $string )</tt></p>
<p>Definiert das Passwort f&uuml;r die SMTP-Authentifizierung</p>
</li>
<li><p><tt>int GetPort()</tt></p>
<p>Gibt die Portnummer f&uuml;r SMTP-Verbindungen zur&uuml;ck</p>
</li>
<li><p><tt>void SetPort( $int )</tt></p>
<p>Definiert die Portnummer f&uuml;r SMTP-Verbindungen</p>
</li>
<li><p><tt>int GetPriority()</tt></p>
<p>Gibt die Priorit&auml;t der Nachricht zur&uuml;ck</p>
</li>
<li><p><tt>void SetPriority( int )</tt></p>
<p>Definiert die Priorit&auml;t/Dringlichkeit der Nachricht</p>
<p>M&ouml;gliche Werte sind 1 = Hoch, 3 = Normal, 5 = Niedrig</p>
</li>
<li><p><tt>string GetSender()</tt></p>
<p>Gibt den sender-String zur&uuml;ck (return path) </p>
</li>
<li><p><tt>void SetSender( $address )</tt></p>
<p>Definiert den sender-String</p>
</li>
<li><p><tt>string GetSendmail()</tt></p>
<p>Gibt den sendmail-Pfad zur&uuml;ck</p>
</li>
<li><p><tt>void SetSendmail( $path )</tt></p>
<p>Definiert den sendmail-Pfad</p>
</li>
<li><p><tt>bool GetSMTPAuth()</tt></p>
<p>Gibt den aktuellen Wert des SMTP-Authentifizierungs-Flags zur&uuml;ck</p>
</li>
<li><p><tt>SetSMTPAuth( $bool )</tt></p>
<p>Definiert den SMTP-Authentifizierungs-Flag</p>
</li>
<li><p><tt>bool GetSMTPDebug()</tt></p>
<p>Gibt den aktuellen Wert des SMTP-Debug-Flags zur&uuml;ck</p>
</li>
<li><p><tt>void SetSMTPDebug( $bool )</tt></p>
<p>Definiert den SMTP-Debug-Flag</p>
</li>
<li><p><tt>bool GetSMTPKeepAlive()</tt></p>
<p>Gibt den aktuellen Wert des SMTP-Keep-Alive-Flags zur&uuml;ck</p>
</li>
<li><p><tt>SetSMTPKeepAlive( $bool )</tt></p>
<p>Definiert den SMTP-Keep-Alive-Flag</p>
</li>
<li><p><tt>string GetSubject()</tt></p>
<p>Gibt den aktuellen Betreff-String zur&uuml;ck</p>
</li>
<li><p><tt>void SetSubject( $string )</tt></p>
<p>Definiert den aktuellen Betreff-String</p>
</li>
<li><p><tt>int GetTimeout()</tt></p>
<p>Gibt den timeout-Wert zur&uuml;ck</p>
</li>
<li><p><tt>void SetTimeout( $seconds )</tt></p>
<p>Definiert den timeout-Wert</p>
</li>
<li><p><tt>string GetUsername()</tt></p>
<p>Gibt den Usernamen f&uuml;r die SMTP-Authentifizierung zur&uuml;ck</p>
</li>
<li><p><tt>void SetUsername( $string )</tt></p>
<p>Definiert den Usernamen f&uuml;r die SMTP-Authentifizierung</p>
</li>
<li><p><tt>int GetWordWrap()</tt></p>
<p>Gibt den wordwrap-Wert zur&uuml;ck</p>
</li>
<li><p><tt>void SetWordWrap( $int )</tt></p>
<p>Definiert den wordwrap-Wert</p>
</li>
<li><p><tt>AddAddress( $address, $name = &#039;&#039; )</tt></p>
<p>F&uuml;gt eine Zieladresse hinzu</p>
</li>
<li><p><tt>AddAttachment( $path, $name = &#039;&#039;, $encoding = &#039;base64&#039;, $type = &#039;application/octent-stream&#039; )</tt></p>
<p>F&uuml;gt einen Anhang hinzu</p>
</li>
<li><p><tt>AddBCC( $address, $name = &#039;&#039; )</tt></p>
<p>F&uuml;gt eine Zieladresse f&uuml;r eine verdeckte Kopie (BCC) hinzu</p>
</li>
<li><p><tt>AddCC( $address, $name = &#039;&#039; )</tt></p>
<p>F&uuml;gt eine Zieladresse f&uuml;r eine Kopie (CC) hinzu</p>
</li>
<li><p><tt>AddCustomHeader( $txt )</tt></p>
<p>F&uuml;gt der Email einen benutzerdefinierten Header hinzu</p>
</li>
<li><p><tt>AddEmbeddedImage( $path, $cid, $name = &#039;&#039;, $encoding = &#039;base64&#039;, $type = &#039;application/octent-stream&#039; )</tt></p>
<p>F&uuml;gt ein eingebettetes Bild hinzu</p>
</li>
<li><p><tt>AddReplyTo( $address, $name = &#039;&#039; )</tt></p>
<p>F&uuml;gt eine Adresse f&uuml;r die Antwort-Email hinzu</p>
</li>
<li><p><tt>AddStringAttachment( $string, $filename, $encoding = &#039;base64&#039;, $type = &#039;application/octent-stream&#039; )</tt></p>
<p>F&uuml;gt einen Dateianhang hinzu</p>
</li>
<li><p><tt>ClearAddresses()</tt></p>
<p>L&ouml;scht alle Email-Adressen</p>
</li>
<li><p><tt>ClearAllRecipients()</tt></p>
<p>L&ouml;scht alle Empf&auml;nger</p>
</li>
<li><p><tt>ClearAttachments()</tt></p>
<p>L&ouml;scht alle Anh&auml;nge</p>
</li>
<li><p><tt>ClearBCCs()</tt></p>
<p>L&ouml;scht alle BCC-Email-Adressen</p>
</li>
<li><p><tt>ClearCCs()</tt></p>
<p>L&ouml;scht alle CC-Email-Adressen</p>
</li>
<li><p><tt>ClearCustomHeaders()</tt></p>
<p>L&ouml;scht alle benutzerdefinierten Header</p>
</li>
<li><p><tt>ClearReplyto()</tt></p>
<p>L&ouml;scht die Email-Adresse f&uuml;r die Antwort</p>
</li>
<li><p><tt>IsError()</tt></p>
<p>Pr&uuml;ft, ob eine bestimmte Fehlerbedingung erf&uuml;llt ist</p>
</li>
<li><p><tt>bool IsHTML( $bool )</tt></p>
<p>Kennzeichnet die Email als HTML-Email</p>
<p><i>Hinweis:</i> Dies ist zwar eine M&ouml;glichkeit, jedoch sollte bevorzugt eine get- und set-Methode verwendet werden</p>
</li>
<li><p><tt>bool IsMail()</tt></p>
<p>Pr&uuml;ft, ob mail verwendet werden soll</p>
</li>
<li><p><tt>bool IsQmail()</tt></p>
<p>Pr&uuml;ft, ob qmail verwendet werden soll</p>
</li>
<li><p><tt>IsSendmail()</tt></p>
<p>Pr&uuml;ft, ob sendmail verwendet werden soll</p>
</li>
<li><p><tt>IsSMTP()</tt></p>
<p>Pr&uuml;ft, ob smtp verwendet werden soll</p>
</li>
<li><p><tt>Send()</tt></p>
<p>Versendet die aktuell vorbereitete Email</p>
</li>
<li><p><tt>SetLanguage( $lang_type, $lang_path = &#039;&#039; )</tt></p>
<p>Legt die aktuelle Sprache und <em>(optional)</em> den Sprach-Pfad fest</p>
</li>
<li><p><tt>SmtpClose()</tt></p>
<p>Schlie&szlig;t die smtp-Verbindung</p>
</li>
</ul>
<h3>Support</h3>
<p>Dieses Modul beinhaltet keinen kommerziellen Support. Sie k&ouml;nnen jedoch &uuml;ber folgende M&ouml;glichkeiten Hilfe zu dem Modul erhalten:</p>
<ul>
<li>F&uuml;r die letzte Version dieses Moduls, FAQs, dem Versand eines Fehlerreports oder dem Kauf kommerziellen Support besuchen Sie bitte calguys Homepage unter <a href="http://techcom.dyndns.org">techcom.dyndns.org</a>.</li>
<li>Eine weitere Diskussion zu diesem Modul ist auch in den Foren von <a href="http://forum.cmsmadesimple.org">CMS Made Simple</a> zu finden.</li>
<li>Der Autor calguy1000 ist h&auml;ufig im <a href="irc://irc.freenode.net/#cms">CMS IRC Channel</a> zu finden.</li>
<li>Letztlich erreichen Sie den Autor auch &uuml;ber eine direkte Email.</li>
</ul>
<p>Nach der GPL wird diese Software so ver&ouml;ffentlicht, wie sie ist. Bitte lesen Sie den Lizenztext f&uuml;r den vollen Haftungsausschluss.</p>

<h3>Copyright und Lizenz</h3>
<p>Copyright &copy; 2005, Robert Campbell <a href="mailto:calguy1000@hotmail.com"><calguy1000@hotmail.com></a>. Alle Rechte vorbehalten.</p>
<p>Dieses Modul wurde unter der <a href="http://www.gnu.org/licenses/licenses.html#GPL">GNU Public License</a> ver&ouml;ffentlicht. Sie m&uuml;ssen dieser Lizenz zustimmen, bevor Sie das Modul verwenden.</p>
';
$lang['moddescription']='Dies ist ein einfacher Wrapper f&uuml;r den PHPMailer; er hat die gleiche API (Funktion f&uuml;r Funktion) und ein einfaches Interface f&uuml;r ein paar Einstellungen.';
$lang['postinstall']='Das CMSMailer-Modul wurde installiert.';
$lang['postuninstall']='Das CMSMailer-Modul wurde deinstalliert ... schade, Sie gehen zu sehen!';
?>