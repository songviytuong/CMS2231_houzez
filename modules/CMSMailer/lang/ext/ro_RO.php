<?php
$lang['friendlyname']='CMSMailer ';
$lang['help']='<h3>Ce realizeaza acest modul?</h3>
<p>Acest modul nu ofera nici o functionalitate utilizatorului final.  Este destinat spre a fi integrat in alte module pentru a oferi suport pentru e-mail.  Aceasta este tot, nimic mai mult.</p>
<h3>Cum il folosesc</h3>
<p>Acest modul ofera o simpla infasurare a metodelor si variabilelor lui phpmailer.  Este destinat folosirii de catre alti dezvoltatori de module, mai jos este prezentat un exemplu si o scurta referinta API.  Va rog sa cititi documentatia inclusa in PHPMailer pentru mai multe informatii.</p>
<h3>Exemplu</h3>
<pre>
  $cmsmailer = $this->GetModuleInstance(&#039;CMSMailer&#039;);
  $cmsmailer->AddAddress(&#039;calguy1000@hotmail.com&#039;,&#039;calguy&#039;);
  $cmsmailer->SetBody(&#039;<h4>Acesta este un mesaj de test</h4>&#039;);
  $cmsmailer->IsHTML(true);
  $cmsmailer->SetSubject(&#039;Mesaj de test&#039;);
  $cmsmailer->Send();
</pre>
<h3>API</h3>
<ul>
<li><p><b>void reset()</b></p>
<p>Reseteaza obiectul inapoi la valorile specificate in panoul de administrare</p>
</li>
<li><p><b>string GetAltBody()</b></p>
<p>Returneaza body alternativ e-mail</p>
</li>
<li><p><b>void SetAltBody( $string )</b></p>
<p>Seteaza body alternativ e-mail</p>
</li>
<li><p><b>string GetBody()</b></p>
<p>Returneaza body primar e-mail</p>
</li>
<li><p><b>void SetBody( $string )</b></p>
<p>Seteaza body primar e-mail</p>
</li>
<li><p><b>string GetCharSet()</b></p>
<p>Implicit: iso-8859-1</p>
<p>Returneaza setul de caractere mailer</p>
</li>
<li><p><b>void SetCharSet( $string )</b></p>
<p>Seteaza set caractere mailer</p>
</li>
<li><p><b>string GetConfirmReadingTo()</b></p>
<p>Returneaza flag de confirmare citire e-mail adresa</p>
</li>
<li><p><b>void SetConfirmReadingTo( $address )</b></p>
<p>Seteaza sau de-seteaza adresa de confirmare citire</p>
</li>
<li><p><b>string GetContentType()</b></p>
<p>Implicit: text/plain</p>
<p>Returneaza tipul de continut</p>
</li>
<li><p><b>void SetContentType()</b></p>
<p>Seteaza tipul de continut</p>
</li>
<li><p><b>string GetEncoding()</b></p>
<p>Returneaza encodarea folosita</p>
</li>
<li><p><b>void SetEncoding( $encoding )</b></p>
<p>Seteaza encodarea</p>
<p>Optiuni disponibile: 8bit, 7bit, binary, base64, quoted-printable</p>
</li>
<li><p><b>string GetErrorInfo()</b></p>
<p>Returneaza orice informatie de eroare</p>
</li>
<li><p><b>string GetFrom()</b></p>
<p>Returneaza adresa expeditor curenta</p>
</li>
<li><p><b>void SetFrom( $address )</b></p>
<p>Seteaza adresa expeditor</p>
</li>
<li><p><b>string GetFromName()</b></p>
<p>Returneaza nume expeditor curent</p>
</li>
<li><p><b>SetFromName( $name )</b></p>
<p>Seteaza nume expeditor</p>
</li>
<li><p><b>string GetHelo()</b></p>
<p>Returneaza stringul HELO</p>
</li>
<li><p><b>SetHelo( $string )</b></p>
<p>Seteaza stringul HELO</p>
<p>Valoare implicita: $hostname</p>
</li>
<li><p><b>string GetHost()</b></p>
<p>Returneaza hosturile SMTP separate prin punct si virgula</p>
</li>
<li><p><b>void SetHost( $string )</b></p>
<p>Seteaza host-urile</p>
</li>
<li><p><b>string GetHostName()</b></p>
<p>Returneaza hostname folosit pentru SMTP Helo</p>
</li>
<li><p><b>void SetHostName( $hostname )</b></p>
<p>Seteaza hostname folosit pentru SMTP Helo</p>
</li>
<li><p><b>string GetMailer()</b></p>
<p>Returneaza mailer-ul</p>
</li>
<li><p><b>void SetMailer( $mailer )</b></p>
<p>Seteaza mailer-ul, sendmail,mail, sau smtp</p>
</li>
<li><p><b>string GetPassword()</b></p>
<p>Returneaza parola pentru autentificare smtp</p>
</li>
<li><p><b>void SetPassword( $string )</b></p>
<p>Seteaza parola pentru autentificare smtp</p>
</li>
<li><p><b>int GetPort()</b></p>
<p>Returneaza numarul de port pentru conexiuni smtp</p>
</li>
<li><p><b>void SetPort( $int )</b></p>
<p>Seteaza portul pentru conexiuni smtp</p>
</li>
<li><p><b>int GetPriority()</b></p>
<p>Returneaza prioritatea mesajului</p>
</li>
<li><p><b>void SetPriority( int )</b></p>
<p>Seteaza prioritatea mesajului</p>
<p>Valori disponibile 1=Mare, 3 = Normala, 5 = Scazuta</p>
</li>
<li><p><b>string GetSender()</b></p>
<p>Returneaza stringul e-mail expeditor (return path)</p>
</li>
<li><p><b>void SetSender( $address )</b></p>
<p>Seteaza string expeditor</p>
</li>
<li><p><b>string GetSendmail()</b></p>
<p>Returneaza calea catre sendmail</p>
</li>
<li><p><b>void SetSendmail( $path )</b></p>
<p>Seteaza calea catre sendmail</p>
</li>
<li><p><b>bool GetSMTPAuth()</b></p>
<p>Returneaza valoarea curenta a smtp auth flag</p>
</li>
<li><p><b>SetSMTPAuth( $bool )</b></p>
<p>Seteaza smtp auth flag</p>
</li>
<li><p><b>bool GetSMTPDebug()</b></p>
<p>Returneaza valoarea SMTP debug flag</p>
</li>
<li><p><b>void SetSMTPDebug( $bool )</b></p>
<p>Seteaza SMTP debug flag</p>
</li>
<li><p><b>bool GetSMTPKeepAlive()</b></p>
<p>Returneaza valoarea SMTP keep alive flag</p>
</li>
<li><p><b>SetSMTPKeepAlive( $bool )</b></p>
<p>Seteaza SMTP keep alive flag</p>
</li>
<li><p><b>string GetSubject()</b></p>
<p>Returneaza string curent subiect e-mail</p>
</li>
<li><p><b>void SetSubject( $string )</b></p>
<p>Seteaza string subiect e-mail</p>
</li>
<li><p><b>int GetTimeout()</b></p>
<p>Returneaza valoare timeout</p>
</li>
<li><p><b>void SetTimeout( $seconds )</b></p>
<p>Seteaza valoare timeout</p>
</li>
<li><p><b>string GetUsername()</b></p>
<p>Returneaza username autentificare smtp</p>
</li>
<li><p><b>void SetUsername( $string )</b></p>
<p>Seteaza username autentificare smtp</p>
</li>
<li><p><b>int GetWordWrap()</b></p>
<p>Returneaza valoare wordwrap</p>
</li>
<li><p><b>void SetWordWrap( $int )</b></p>
<p>Returneaza valoare wordwrap</p>
</li>
<li><p><b>AddAddress( $address, $name = &#039;&#039; )</b></p>
<p>Adauga adresa destinatar</p>
</li>
<li><p><b>AddAttachment( $path, $name = &#039;&#039;, $encoding = &#039;base64&#039;, $type = &#039;application/octent-stream&#039; )</b></p>
<p>Adauga atasament</p>
</li>
<li><p><b>AddBCC( $address, $name = &#039;&#039; )</b></p>
<p>Adauga adresa destinatar camp BCC</p>
</li>
<li><p><b>AddCC( $address, $name = &#039;&#039; )</b></p>
<p>Adauga adresa destinatar camp CC</p>
</li>
<li><p><b>AddCustomHeader( $txt )</b></p>
<p>Adauga header custom e-mailului</p>
</li>
<li><p><b>AddEmbeddedImage( $path, $cid, $name = &#039;&#039;, $encoding = &#039;base64&#039;, $type = &#039;application/octent-stream&#039; )</b></p>
<p>Adauga imagine embedded</p>
</li>
<li><p><b>AddReplyTo( $address, $name = &#039;&#039; )</b></p>
<p>Adaugare adresa reply to</p>
</li>
<li><p><b>AddStringAttachment( $string, $filename, $encoding = &#039;base64&#039;, $type = &#039;application/octent-stream&#039; )</b></p>
<p>Adauga atasament</p>
</li>
<li><p><b>ClearAddresses()</b></p>
<p>Goleste toate adresele</p>
</li>
<li><p><b>ClearAllRecipients()</b></p>
<p>Goleste toti destinatarii</p>
</li>
<li><p><b>ClearAttachments()</b></p>
<p>Arunca toate atasamentele</p>
</li>
<li><p><b>ClearBCCs()</b></p>
<p>Goleste toate adresele BCC</p>
</li>
<li><p><b>ClearCCs()</b></p>
<p>Goleste toate adresele CC</p>
</li>
<li><p><b>ClearCustomHeaders()</b></p>
<p>Goleste header-ele custom</p>
</li>
<li><p><b>ClearReplyto()</b></p>
<p>Goleste adresa reply to</p>
</li>
<li><p><b>IsError()</b></p>
<p>Verifica pentru conditie de eroare</p>
</li>
<li><p><b>bool IsHTML( $bool )</b></p>
<p>Seteaza flag html</p>
<p><i>Nota</i> posibil ca aceasta sa trebuiasca sa fie o metoda get si set</p>
</li>
<li><p><b>bool IsMail()</b></p>
<p>Verifica daca folosim mail</p>
</li>
<li><p><b>bool IsQmail()</b></p>
<p>Verifica daca folosim qmail</p>
</li>
<li><p><b>IsSendmail()</b></p>
<p>Verifica daca folosim sendmail</p>
</li>
<li><p><b>IsSMTP()</b></p>
<p>Verifica daca folosim smtp</p>
</li>
<li><p><b>Send()</b></p>
<p>Trimite emailul curent</p>
</li>
<li><p><b>SetLanguage( $lang_type, $lang_path = &#039;&#039; )</b></p>
<p>Seteaza limba curenta si <em>(optional)</em> cale limba</p>
</li>
<li><p><b>SmtpClose()</b></p>
<p>Inchide conexiunea smtp</p>
</li>
</ul>
<h3>Suport</h3>
<p>Acest modul nu include suport comercial. Totusi, sunt disponibile resurse pentru a primi ajutor in privinta lui:</p>
<ul>
<li>For the latest version of this module, FAQs, or to file a Bug Report or buy commercial support, please visit calguys homepage at <a href=&#039;http://techcom.dyndns.org&#039;>techcom.dyndns.org</a>.</li>
<li>Additional discussion of this module may also be found in the <a href=&#039;http://forum.cmsmadesimple.org&#039;>CMS Made Simple Forums</a>.</li>
<li>The author, calguy1000, can often be found in the <a href=&#039;irc://irc.freenode.net/#cms&#039;>CMS IRC Channel</a>.</li>
<li>Lastly, you may have some success emailing the author directly.</li>  
</ul>
<p>As per the GPL, this software is provided as-is. Please read the text
of the license for the full disclaimer.</p>

<h3>Copyright and License</h3>
<p>Copyright &copy; 2005, Robert Campbell <a href=&#039;mailto:calguy1000@hotmail.com&#039;><calguy1000@hotmail.com></a>. All Rights Are Reserved.</p>
<p>This module has been released under the <a href=&#039;http://www.gnu.org/licenses/licenses.html#GPL&#039;>GNU Public License</a>. You must agree to this license before using the module.</p>
';
$lang['moddescription']='Este o infasurare simpla pentru PHPMailer, are un API echivalent (functie cu functie) si o interfata simple pentru cateva detalii implicite.';
$lang['postinstall']='Modulul CMSMailer a fost instalat cu succes';
$lang['postuninstall']='Modulul CMSMailer dezinstalat... imi pare rau sa vad ca plecati';
?>