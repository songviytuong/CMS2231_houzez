<?php
$lang['friendlyname']='CMSMailer Module';
$lang['help']='<h3>Hvad er det til for?</h3>
<p>Dette modul tilbyder ikke slutbrugeren nogen funktioner. Det er alene lavet mhp. integration i andre moduler, s&aring; de kan g&oslash;re brug af email. Mere er der ikke i det.</p>
<h3>Hvordan skal jeg anvende det?</h3>
<p>Dette modul giver let adgang til alle PHPMailers metoder og variable. Hensigten er, at modulet skal bruges af andre modul-udviklere. Herunder ses et eksempel og en hurtig API-reference.  L&aelig;s venligst den dokumentation til PHPMailer, som medf&oslash;lger for mere information.</p>
<h3>Et eksempel</h3>
<pre>
  $cmsmailer = $this->GetModuleInstance(\&#039;CMSMailer\&#039;);
  $cmsmailer->AddAddress(\&#039;calguy1000@hotmail.com\&#039;,\&#039;calguy\&#039;);
  $cmsmailer->SetBody(\&#039;<h1>Denne besked er en pr&oslash;ve<h1>\&#039;);
  $cmsmailer->IsHTML(true);
  $cmsmailer->SetSubject(\&#039;Pr&oslash;vebesked\&#039;);
  $cmsmailer->Send();
</pre>
<h3>API</h3>
<ul>
<li><p><b>void reset()</b></p>
<p>Nulstil objektet og gendan de v&aelig;rdier, som er specificeret i administrationspanelet</p>
</li>
<li><p><b>string GetAltBody()</b></p>
<p>Return&eacute;r emailens alternative indhold (body)</p>
</li>
<li><p><b>void SetAltBody( $string )</b></p>
<p>Bestem emailens alternative indhold (body)</p>
</li>
<li><p><b>string GetBody()</b></p>
<p>Return&eacute;r emailens prim&aelig;re indhold (body)</p>
</li>
<li><p><b>void SetBody( $string )</b></p>
<p>Bestem emailens prim&aelig;re indhold (body)</p>
</li>
<li><p><b>string GetCharSet()</b></p>
<p>Hvis intet andet er angivet, bruges iso-8859-1</p>
<p>Return&eacute;r mailerens tegns&aelig;t</p>
</li>
<li><p><b>void SetCharSet( $string )</b></p>
<p>Bestem mailerens tegns&aelig;t</p>
</li>
<li><p><b>string GetConfirmReadingTo()</b></p>
<p>Return&eacute;r modtageradresse ved emails, hvor modtageren bedes bekr&aelig;fte at have l&aelig;st emailen</p>
</li>
<li><p><b>void SetConfirmReadingTo( $address )</b></p>
<p>Anvend eller anvend ikke emailadresse for modtagelse af bekr&aelig;ftelse</p>
</li>
<li><p><b>string GetContentType()</b></p>
<p>Hvis intet er angivet bruges text/plain</p>
<p>Return&eacute;r indholdstype</p>
</li>
<li><p><b>void SetContentType()</b></p>
<p>Bestem indholdstype</p>
</li>
<li><p><b>string GetEncoding()</b></p>
<p>Return&eacute;r indkodning</p>
</li>
<li><p><b>void SetEncoding( $encoding )</b></p>
<p>iBestem ndkodning</p>
<p>Der er f&oslash;lgende muligheder: 8bit, 7bit, binary, base64, quoted-printable</p>
</li>
<li><p><b>string GetErrorInfo()</b></p>
<p>Return&eacute;r information om fejl, hvis de opst&aring;r</p>
</li>
<li><p><b>string GetFrom()</b></p>
<p>Return&eacute;r den aktuelle oprindelsesadresse</p>
</li>
<li><p><b>void SetFrom( $address )</b></p>
<p>Bestem den oprindelsesadresse, som emailen kommer fra</p>
</li>
<li><p><b>string GetFromName()</b></p>
<p>Return&eacute;r det aktuelle oprindelsesnavn</p>
</li>
<li><p><b>SetFromName( $name )</b></p>
<p>Bestem oprindelsesnavnet</p>
</li>
<li><p><b>string GetHelo()</b></p>
<p>Return&eacute;r HELO-teksten</p>
</li>
<li><p><b>SetHelo( $string )</b></p>
<p>Bestem HELO-teksten</p>
<p>Hvis intet andet er angivet, bruges $hostname</p>
</li>
<li><p><b>string GetHost()</b></p>
<p>Return&eacute;r SMTP&#039;ernes host adskilt af semikolon</p>
</li>
<li><p><b>void SetHost( $string )</b></p>
<p>Bestem v&aelig;rtsnavn</p>
</li>
<li><p><b>string GetHostName()</b></p>
<p>Return&eacute;r det v&aelig;rtsnavn, som SMTP Helo bruger</p>
</li>
<li><p><b>void SetHostName( $hostname )</b></p>
<p>Bestem det v&aelig;rtsnavn, som SMTP Helo skal bruge</p>
</li>
<li><p><b>string GetMailer()</b></p>
<p>Return&eacute;r maileren</p>
</li>
<li><p><b>void SetMailer( $mailer )</b></p>
<p>Bestem maileren - enten sendmail,mail, eller smtp</p>
</li>
<li><p><b>string GetPassword()</b></p>
<p>Return&eacute;r adgangskoden til smtp auth</p>
</li>
<li><p><b>void SetPassword( $string )</b></p>
<p>Bestem adgangskoden til smtp auth</p>
</li>
<li><p><b>int GetPort()</b></p>
<p>Return&eacute;r smtp-forbindelsens portnummer</p>
</li>
<li><p><b>void SetPort( $int )</b></p>
<p>Bestem smtp-forbindelsens portnummer</p>
</li>
<li><p><b>int GetPriority()</b></p>
<p>Return&eacute;r beskedens prioritet</p>
</li>
<li><p><b>void SetPriority( int )</b></p>
<p>Bestem beskedens prioritet</p>
<p>Mulige v&aelig;rdier er 1=H&oslash;j, 3 = Normal, 5 = Lav</p>
</li>
<li><p><b>string GetSender()</b></p>
<p>Return&eacute;r afsender (adresse for modtagelse af besvarelse)</p>
</li>
<li><p><b>void SetSender( $address )</b></p>
<p>Bestem afsenderadresse</p>
</li>
<li><p><b>string GetSendmail()</b></p>
<p>Return&eacute;r stien til sendmail</p>
</li>
<li><p><b>void SetSendmail( $path )</b></p>
<p>Bestem stien til sendmail</p>
</li>
<li><p><b>bool GetSMTPAuth()</b></p>
<p>Return the current value of the smtp auth flag</p>
</li>
<li><p><b>SetSMTPAuth( $bool )</b></p>
<p>Set the smtp auth flag</p>
</li>
<li><p><b>bool GetSMTPDebug()</b></p>
<p>Return the value of the SMTP debug flag</p>
</li>
<li><p><b>void SetSMTPDebug( $bool )</b></p>
<p>Set the SMTP debug flag</p>
</li>
<li><p><b>bool GetSMTPKeepAlive()</b></p>
<p>Return the value of the SMTP keep alive flag</p>
</li>
<li><p><b>SetSMTPKeepAlive( $bool )</b></p>
<p>Set the SMTP keep alive flag</p>
</li>
<li><p><b>string GetSubject()</b></p>
<p>Return the current subject string</p>
</li>
<li><p><b>void SetSubject( $string )</b></p>
<p>Set the subject string</p>
</li>
<li><p><b>int GetTimeout()</b></p>
<p>Return the timeout value</p>
</li>
<li><p><b>void SetTimeout( $seconds )</b></p>
<p>Set the timeout value</p>
</li>
<li><p><b>string GetUsername()</b></p>
<p>Return the smtp auth username</p>
</li>
<li><p><b>void SetUsername( $string )</b></p>
<p>Set the smtp auth username</p>
</li>
<li><p><b>int GetWordWrap()</b></p>
<p>Return the wordwrap value</p>
</li>
<li><p><b>void SetWordWrap( $int )</b></p>
<p>Return the wordwrap value</p>
</li>
<li><p><b>AddAddress( $address, $name = \&#039;\&#039; )</b></p>
<p>Add a destination address</p>
</li>
<li><p><b>AddAttachment( $path, $name = \&#039;\&#039;, $encoding = \&#039;base64\&#039;, $type = \&#039;application/octent-stream\&#039; )</b></p>
<p>Add a file attachment</p>
</li>
<li><p><b>AddBCC( $address, $name = \&#039;\&#039; )</b></p>
<p>Add a BCC\&#039;d destination address</p>
</li>
<li><p><b>AddCC( $address, $name = \&#039;\&#039; )</b></p>
<p>Add a CC\&#039;d destination address</p>
</li>
<li><p><b>AddCustomHeader( $txt )</b></p>
<p>Add a custom header to the email</p>
</li>
<li><p><b>AddEmbeddedImage( $path, $cid, $name = \&#039;\&#039;, $encoding = \&#039;base64\&#039;, $type = \&#039;application/octent-stream\&#039; )</b></p>
<p>Add an embedded image</p>
</li>
<li><p><b>AddReplyTo( $address, $name = \&#039;\&#039; )</b></p>
<p>Add a reply to address</p>
</li>
<li><p><b>AddStringAttachment( $string, $filename, $encoding = \&#039;base64\&#039;, $type = \&#039;application/octent-stream\&#039; )</b></p>
<p>Add a file attachment</p>
</li>
<li><p><b>ClearAddresses()</b></p>
<p>Clear all addresses</p>
</li>
<li><p><b>ClearAllRecipients()</b></p>
<p>Clear all recipients</p>
</li>
<li><p><b>ClearAttachments()</b></p>
<p>Clear all attachments</p>
</li>
<li><p><b>ClearBCCs()</b></p>
<p>Clear all BCC addresses</p>
</li>
<li><p><b>ClearCCs()</b></p>
<p>Clear all CC addresses</p>
</li>
<li><p><b>ClearCustomHeaders()</b></p>
<p>Clear all custom headers</p>
</li>
<li><p><b>ClearReplyto()</b></p>
<p>Clear reply to address</p>
</li>
<li><p><b>IsError()</b></p>
<p>Check for an error condition</p>
</li>
<li><p><b>bool IsHTML( $bool )</b></p>
<p>Set the html flag</p>
<p><i>Note</i> possibly this should be a get and set method</p>
</li>
<li><p><b>bool IsMail()</b></p>
<p>Check wether we are using mail</p>
</li>
<li><p><b>bool IsQmail()</b></p>
<p>Check wether we are using qmail</p>
</li>
<li><p><b>IsSendmail()</b></p>
<p>Check wether we are using sendmail</p>
</li>
<li><p><b>IsSMTP()</b></p>
<p>Check wether we are using smtp</p>
</li>
<li><p><b>Send()</b></p>
<p>Send the currently prepared email</p>
</li>
<li><p><b>SetLanguage( $lang_type, $lang_path = \&#039;\&#039; )</b></p>
<p>Set the current language and <em>(optional)</em> language path</p>
</li>
<li><p><b>SmtpClose()</b></p>
<p>Close the smtp connection</p>
</li>
</ul>
<h3>Support</h3>
<p>This module does not include commercial support. However, there are a number of resources available to help you with it:</p>
<ul>
<li>For the latest version of this module, FAQs, or to file a Bug Report or buy commercial support, please visit calguys homepage at <a href=\"http://techcom.dyndns.org\">techcom.dyndns.org</a>.</li>
<li>Additional discussion of this module may also be found in the <a href=\"http://forum.cmsmadesimple.org\">CMS Made Simple Forums</a>.</li>
<li>The author, calguy1000, can often be found in the <a href=\"irc://irc.freenode.net/#cms\">CMS IRC Channel</a>.</li>
<li>Lastly, you may have some success emailing the author directly.</li>  
</ul>
<p>As per the GPL, this software is provided as-is. Please read the text
of the license for the full disclaimer.</p>

<h3>Copyright and License</h3>
<p>Copyright &copy; 2005, Robert Campbell <a href=\"mailto:calguy1000@hotmail.com\"><calguy1000@hotmail.com></a>. All Rights Are Reserved.</p>
<p>This module has been released under the <a href=\"http://www.gnu.org/licenses/licenses.html#GPL\">GNU Public License</a>. You must agree to this license before using the module.</p>
';
$lang['moddescription']='Dette er et interface til PHPMailer, det et tilsvarende API (funktion for funktion) og et simpelt interface til nogle standardv&aelig;rdier.';
$lang['postinstall']='CMSMailer modulet blev installeret';
$lang['postuninstall']='CMSMailer modulet blev afinstalleret';
?>