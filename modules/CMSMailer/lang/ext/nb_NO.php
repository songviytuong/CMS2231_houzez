<?php
$lang['friendlyname'] = 'CMS Mailer';
$lang['help'] = '<h3>Hva gjør denne?</h3>
<p><strong>MERK:</strong> Denne modulen er utdatert og vil bli fjernet i nyere versjoner av CMSMS.</p>
<p>Denne modulen gir ingen sluttbrukerfunksjonalitet. Den er designet for å bli integrert i andre moduler for å gi epostfunksjoner. Det er det, ingenting mer.</p>
<h3>Hvordan bruker jeg det</h3>
<p>Denne modulen gir et enkelt omslag rundt alle metoder og variabler av phpmailer. Den er designet for bruk av andre modulutviklere, nedenfor er et eksempel og en kort API-referanse. Vennligst les PHPMailer dokumentasjonen inkludert for mer informasjon.</p>
<h3>Et Eksempel</h3>
<pre>
  $cmsmailer = $this->GetModuleInstance(\'CMSMailer\');
  $cmsmailer->AddAddress(\'calguy1000@hotmail.com\',\'calguy\');
  $cmsmailer->SetBody(\'<h4>This is a test message</h4>\');
  $cmsmailer->IsHTML(true);
  $cmsmailer->SetSubject(\'Test melding\');
  $cmsmailer->Send();
</pre>
<h3>API</h3>
<ul>
<li><p><b>void reset()</b></p>
<p>Tilbakestill objektet tilbake til verdiene som er angitt i administrasjons-panelet</p>
</li>
<li><p><b>string GetAltBody()</b></p>
<p>Returner den alternative delen av e-posten</p>
</li>
<li><p><b>void SetAltBody( $string )</b></p>
<p>Angi den alternative delen av e-posten</p>
</li>
<li><p><b>string GetBody()</b></p>
<p>Gå tilbake til hoveddelen av e-posten</p>
</li>
<li><p><b>void SetBody( $string )</b></p>
<p>Angi hoveddelen av e-posten</p>
</li>
<li><p><b>string GetCharSet()</b></p>
<p>Default: iso-8859-1</p>
<p>Returnere mailer tegnsett</p>
</li>
<li><p><b>void SetCharSet( $string )</b></p>
<p>Still inn e-postsettet</p>
</li>
<li><p><b>string GetConfirmReadingTo()</b></p>
<p>Retur adressen bekreftet leser e-postflagg</p>
</li>
<li><p><b>void SetConfirmReadingTo( $address )</b></p>
<p>Angi eller unset bekreftelses leser adresse</p>
</li>
<li><p><b>string GetContentType()</b></p>
<p>Standard: tekst/vanlig</p>
<p>Returner innholdstype</p>
</li>
<li><p><b>void SetContentType()</b></p>
<p>Angi innholdstypen</p>
</li>
<li><p><b>string GetEncoding()</b></p>
<p>Returner kodingen</p>
</li>
<li><p><b>void SetEncoding( $encoding )</b></p>
<p>Angi kodingen</p>
<p>Alternativene er: 8bit, 7bit, binær, base64, sitert-utskrivbar</p>
</li>
<li><p><b>string GetErrorInfo()</b></p>
<p>Returner eventuelle feilinformasjon</p>
</li>
<li><p><b>string GetFrom()</b></p>
<p>Gi gjeldende opprinnelsesadresse tilbake</p>
</li>
<li><p><b>void SetFrom( $address )</b></p>
<p>Angi opprinnelsesadresse</p>
</li>
<li><p><b>string GetFromName()</b></p>
<p>Gi gjeldende opprinnelsesnavn tilbake</p>
</li>
<li><p><b>SetFromName( $name )</b></p>
<p>Sett opprinnelse navnet</p>
</li>
<li><p><b>string GetHelo()</b></p>
<p>Returner HELLO strengen</p>
</li>
<li><p><b>SetHelo( $string )</b></p>
<p>Sett HELO strengen</p>
<p>Standardverdi: $hostname</p>
</li>
<li><p><b>string GetHost()</b></p>
<p>Returner SMTP-verten adskilt av semikolon</p>
</li>
<li><p><b>void SetHost( $string )</b></p>
<p>Sett vertene</p>
</li>
<li><p><b>string GetHostName()</b></p>
<p>Returner vertsnavnet som brukes til SMTP Helo</p>
</li>
<li><p><b>void SetHostName( $hostname )</b></p>
<p>Angi vertsnavnet som brukes til SMTP Helo</p>
</li>
<li><p><b>string GetMailer()</b></p>
<p>Returner maileren</p>
</li>
<li><p><b>void SetMailer( $mailer )</b></p>
<p>Still inn maileren, enten sendmail, mail eller smtp</p>
</li>
<li><p><b>string GetPassword()</b></p>
<p>Return passordet for smtp auth</p>
</li>
<li><p><b>void SetPassword( $string )</b></p>
<p>Angi passordet for smtp auth</p>
</li>
<li><p><b>int GetPort()</b></p>
<p>Returner portnummeret for SMTP-tilkoblinger</p>
</li>
<li><p><b>void SetPort( $int )</b></p>
<p>Sett port for smtp-tilkoblinger</p>
</li>
<li><p><b>int GetPriority()</b></p>
<p>Returner meldingsprioriteten</p>
</li>
<li><p><b>void SetPriority( int )</b></p>
<p>Angi prioritet for meldingen</p>
<p>Verdiene er 1 = Høy, 3 = Normal, 5 = Lav</p>
</li>
<li><p><b>string GetSender()</b></p>
<p>Returner avsenderens e-postadresse (returvei)</p>
</li>
<li><p><b>void SetSender( $address )</b></p>
<p>Sett avsenderen strengen</p>
</li>
<li><p><b>string GetSendmail()</b></p>
<p>Returner sendmail banen</p>
</li>
<li><p><b>void SetSendmail( $path )</b></p>
<p>Sett sendmail banen</p>
</li>
<li><p><b>bool GetSMTPAuth()</b></p>
<p>Returnere den nåværende verdien av smtp auth flagget</p>
</li>
<li><p><b>SetSMTPAuth( $bool )</b></p>
<p>Sett smtp auth flagget</p>
</li>
<li><p><b>bool GetSMTPDebug()</b></p>
<p>Returner verdien av SMTP-feilsøkingsflagget</p>
</li>
<li><p><b>void SetSMTPDebug( $bool )</b></p>
<p>Sett SMTP-feilsøkingsflagget</p>
</li>
<li><p><b>bool GetSMTPKeepAlive()</b></p>
<p>Returner verdien av SMTP hold i live flagget</p>
</li>
<li><p><b>SetSMTPKeepAlive( $bool )</b></p>
<p>Sett SMTP-holdet i live flagget</p>
</li>
<li><p><b>string GetSubject()</b></p>
<p>Returner gjeldende emne streng</p>
</li>
<li><p><b>void SetSubject( $string )</b></p>
<p>Sett emnet strengen</p>
</li>
<li><p><b>int GetTimeout()</b></p>
<p>Returner tidsavbrudd-verdien</p>
</li>
<li><p><b>void SetTimeout( $seconds )</b></p>
<p>Angi tidsavbrudd-verdien</p>
</li>
<li><p><b>string GetUsername()</b></p>
<p>Returner smtp auth brukernavnet</p>
</li>
<li><p><b>void SetUsername( $string )</b></p>
<p>Angi smtp auth brukernavn</p>
</li>
<li><p><b>int GetWordWrap()</b></p>
<p>Returner wordwrap-verdien</p>
</li>
<li><p><b>void SetWordWrap( $int )</b></p>
<p>Return the wordwrap value</p>
</li>
<li><p><b>AddAddress( $address, $name = \'\' )</b></p>
<p>Legg til en destinasjonsadresse</p>
</li>
<li><p><b>AddAttachment( $path, $name = \'\', $encoding = \'base64\', $type = \'application/octent-stream\' )</b></p>
<p>Legg til et filvedlegg</p>
</li>
<li><p><b>AddBCC( $address, $name = \'\' )</b></p>
<p>Legg til en BCC\'d destinasjonsadresse</p>
</li>
<li><p><b>AddCC( $address, $name = \'\' )</b></p>
<p>Legg til en CC\'d destinasjonsadresse</p>
</li>
<li><p><b>AddCustomHeader( $txt )</b></p>
<p>Legg til en egendefinert overskrift til e-posten</p>
</li>
<li><p><b>AddEmbeddedImage( $path, $cid, $name = \'\', $encoding = \'base64\', $type = \'application/octent-stream\' )</b></p>
<p>Legg til et innebygd bilde</p>
</li>
<li><p><b>AddReplyTo( $address, $name = \'\' )</b></p>
<p>Legg til en svaradresse</p>
</li>
<li><p><b>AddStringAttachment( $string, $filename, $encoding = \'base64\', $type = \'application/octent-stream\' )</b></p>
<p>Legg til et filvedlegg</p>
</li>
<li><p><b>ClearAddresses()</b></p>
<p>Fjern alle adressene</p>
</li>
<li><p><b>ClearAllRecipients()</b></p>
<p>Fjern alle mottakere</p>
</li>
<li><p><b>ClearAttachments()</b></p>
<p>Fjern alle vedlegg</p>
</li>
<li><p><b>ClearBCCs()</b></p>
<p>Fjern alle BCC-adresser</p>
</li>
<li><p><b>ClearCCs()</b></p>
<p>Fjern alle CC adresser</p>
</li>
<li><p><b>ClearCustomHeaders()</b></p>
<p>Fjern alle tilpassede overskrifter</p>
</li>
<li><p><b>ClearReplyto()</b></p>
<p>Fjern svar på adresse</p>
</li>
<li><p><b>IsError()</b></p>
<p>Se etter en feiltilstand</p>
</li>
<li><p><b>bool IsHTML( $bool )</b></p>
<p>Sett html flagget</p>
<p><i>Merk</i> muligens bør dette være en get og sett metode</p>
</li>
<li><p><b>bool IsMail()</b></p>
<p>Sjekk om vi bruker e-post</p>
</li>
<li><p><b>bool IsQmail()</b></p>
<p>Sjekk om vi bruker qmail</p>
</li>
<li><p><b>IsSendmail()</b></p>
<p>Sjekk om vi bruker sendmail</p>
</li>
<li><p><b>IsSMTP()</b></p>
<p>Sjekk om vi bruker smtp</p>
</li>
<li><p><b>Send()</b></p>
<p>Send den for tiden utarbeidede e-posten</p>
</li>
<li><p><b>SetLanguage( $lang_type, $lang_path = \'\' )</b></p>
<p>Angi gjeldende språk og <em>(optional)</em> Språksti</p>
</li>
<li><p><b>SmtpClose()</b></p>
<p>Lukk smtp tilkoblingen</p>
</li>
</ul>
<h3>Brukerstøtte</h3>
<p>Denne modulen inkluderer ikke kommersiell støtte. Det er imidlertid en rekke ressurser tilgjengelig for å hjelpe deg med det:</p>
<ul>
<li>For den nyeste versjonen av denne modulen, Ofte stilte spørsmål, eller for å sende en feilrapport eller kjøp kommersiell støtte, vennligst besøk CMSMS Forge.</li>
<li>Ytterligere diskusjon om denne modulen kan også bli funnet i <a href=\'https://forum.cmsmadesimple.org\'>CMS Made Simple Forumet</a>.</li>
<li>Forfatteren, Calguy1000, kan ofte bli funnet i <a href=\'irc://irc.freenode.net/#cms\'>CMS IRC Kanalen</a>.</li>
<li>Til slutt kan du ha en viss suksess med å sende e-post til forfatteren direkte.</li>  
</ul>
<p>I henhold til GPL er denne programvaren gitt som-er. Vennligst les teksten
Av lisensen for fullstendig ansvarsfraskrivelse.</p>

<h3>Opphavsrett og lisens</h3>
<p>Opphavsrett © 2005, Robert Campbell <a href=\'mailto:calguy1000@hotmail.com\'><calguy1000@hotmail.com></a>. Alle rettigheter er reservert.</p>
<p>Denne modulen har blitt utgitt under <a href=\'http://www.gnu.org/licenses/licenses.html#GPL\'>GNU Public License</a>. Du må godta denne lisensen før du bruker modulen.</p>';
$lang['moddescription'] = 'Dette er en enkel wrapper rundt PHPMailer. Den har en tilsvarende API og et enkelt grensesnitt for noen standarder. Denne modulen er utgått siden CMSMS 2.0';
$lang['postinstall'] = 'CMSMailer-modulen har blitt installert';
$lang['postuninstall'] = 'CMSMailer-modulen er avinstallert';
?>