<?php
$lang['friendlyname'] = 'CMSMailer&nbsp;';
$lang['help'] = '<h3>Que fait ce module&nbsp;?</h3>
<p><strong>Note :</strong> Ce module est obsolète et sera supprimé dans les futures versions de CMSMS.</p>
<p>Ce module n\'apporte pas de fonctionnalité pour l\'utilisateur final. Il a été écrit pour être intégré dans d\'autres modules et fournir des possibilités d\'envoi de courriels. Voilà, rien de plus.</p>
<h3>Comment l\'utiliser&nbsp;?</h3>
<p>Ce module englobe toutes les méthodes et variables de phpmailer. Il est construit de manière à pouvoir être utilisé par les développeurs des autres modules (voir l\'exemple ci-dessous et une brève référence API). Veuillez lire la documentation de PHPMailer pour plus d\'information.</p>
<h3>Un exemple</h3>
<pre>
  $cmsmailer = $this->GetModuleInstance(\'CMSMailer\');
  $cmsmailer->AddAddress(\'calguy1000@hotmail.com\',\'calguy\');
  $cmsmailer->SetBody(\'<b>Ceci est un message de test</b>\');
  $cmsmailer->IsHTML(true);
  $cmsmailer->SetSubject(\'Test message\');
  $cmsmailer->Send();
</pre>
<h3>API</h3>
<ul>
<li><p><b>void reset()</b></p>
<p>Réinitialise l\'object à la valeur spécifiée dans le panneau d\'administration</p>
</li>
<li><p><b>string GetAltBody()</b></p>
<p>Retourne le corps de remplacement de l\'email</p>
</li>
<li><p><b>void SetAltBody( $string )</b></p>
<p>Défini le corps de remplacement de l\'email</p>
</li>
<li><p><b>string GetBody()</b></p>
<p>Retourne le corps principal de l\'email</p>
</li>
<li><p><b>void SetBody( $string )</b></p>
<p>Défini le corps principal de l\'email</p>
</li>
<li><p><b>string GetCharSet()</b></p>
<p>Défaut: iso-8859-1</p>
<p>Retourne l\'encodage des caractères du mailer</p>
</li>
<li><p><b>void SetCharSet( $string )</b></p>
<p>Défini l\'encodage des caractères</p>
</li>
<li><p><b>string GetConfirmReadingTo()</b></p>
<p>Retourne l\'adresse de confirmation de lecture</p>
</li>
<li><p><b>void SetConfirmReadingTo( $address )</b></p>
<p>Défini ou enlève l\'adresse de confirmation de lecture</p>
</li>
<li><p><b>string GetContentType()</b></p>
<p>Défaut: text/plain</p>
<p>Retourne le content type</p>
</li>
<li><p><b>void SetContentType()</b></p>
<p>Défini le content type</p>
</li>
<li><p><b>string GetEncoding()</b></p>
<p>Retourne l\'encodage</p>
</li>
<li><p><b>void SetEncoding( $encoding )</b></p>
<p>Défini l\'encodage</p>
<p>Les options sont: 8bit, 7bit, binary, base64, quoted-printable</p>
</li>
<li><p><b>string GetErrorInfo()</b></p>
<p>Retourne toute information d\'erreur</p>
</li>
<li><p><b>string GetFrom()</b></p>
<p>Retourne l\'adresse d\'origine en cours</p>
</li>
<li><p><b>void SetFrom( $address )</b></p>
<p>Défini l\'adresse d\'origine</p>
</li>
<li><p><b>string GetFromName()</b></p>
<p>Retourne le nom d\'origine en cours</p>
</li>
<li><p><b>SetFromName( $name )</b></p>
<p>Défini le nom d\'origine</p>
</li>
<li><p><b>string GetHelo()</b></p>
<p>Retourne le string HELO</p>
</li>
<li><p><b>SetHelo( $string )</b></p>
<p>Défini le string HELO</p>
<p>Valeur par défaut: $hostname</p>
</li>
<li><p><b>string GetHost()</b></p>
<p>Retourne les hosts SMTPs séparés par des points-virgules</p>
</li>
<li><p><b>void SetHost( $string )</b></p>
<p>Défini les hosts</p>
</li>
<li><p><b>string GetHostName()</b></p>
<p>Retourne le nom du host utilisé pour le Helo SMTP</p>
</li>
<li><p><b>void SetHostName( $hostname )</b></p>
<p>Défini le nom du host utilisé pour le Helo SMTP</p>
</li>
<li><p><b>string GetMailer()</b></p>
<p>Retourne le mailer</p>
</li>
<li><p><b>void SetMailer( $mailer )</b></p>
<p>Défini le mailer, soit sendmail,mail, ou smtp</p>
</li>
<li><p><b>string GetPassword()</b></p>
<p>Retourne le mot de passe pour l\'authentification smtp</p>
</li>
<li><p><b>void SetPassword( $string )</b></p>
<p>Défini le mot de passe pour l\'authentification smtp</p>
</li>
<li><p><b>int GetPort()</b></p>
<p>Retourne le port pour les connexions smtp</p>
</li>
<li><p><b>void SetPort( $int )</b></p>
<p>Défini le port pour les connexions smtp</p>
</li>
<li><p><b>int GetPriority()</b></p>
<p>Retourne la priorité du message</p>
</li>
<li><p><b>void SetPriority( int )</b></p>
<p>Défini la priorité du message</p>
<p>Les valeurs sont 1=Haute, 3 = Normale, 5 = Basse</p>
</li>
<li><p><b>string GetSender()</b></p>
<p>Retourne l\'email de l\'expéditeur (adresse de réponse)</p>
</li>
<li><p><b>void SetSender( $address )</b></p>
<p>Défini l\'email de l\'expéditeur</p>
</li>
<li><p><b>string GetSendmail()</b></p>
<p>Retourne le chemin à sendmail</p>
</li>
<li><p><b>void SetSendmail( $path )</b></p>
<p>Défini le chemin à sendmail</p>
</li>
<li><p><b>bool GetSMTPAuth()</b></p>
<p>Retourne la valeur en cours du flag d\'authentification de smtp</p>
</li>
<li><p><b>SetSMTPAuth( $bool )</b></p>
<p>Défini la valeur en cours du flag d\'authentification de smtp</p>
</li>
<li><p><b>bool GetSMTPDebug()</b></p>
<p>Retourne la valeur du debug flag de SMTP</p>
</li>
<li><p><b>void SetSMTPDebug( $bool )</b></p>
<p>Défini la valeur du debug flag de SMTP</p>
</li>
<li><p><b>bool GetSMTPKeepAlive()</b></p>
<p>Retourne la valeur du keep alive flag de SMTP</p>
</li>
<li><p><b>SetSMTPKeepAlive( $bool )</b></p>
<p>Défini la valeur du keep alive flag de SMTP</p>
</li>
<li><p><b>string GetSubject()</b></p>
<p>Retourne le sujet en cours</p>
</li>
<li><p><b>void SetSubject( $string )</b></p>
<p>Défini le sujet</p>
</li>
<li><p><b>int GetTimeout()</b></p>
<p>Retourne la valeur du timeout</p>
</li>
<li><p><b>void SetTimeout( $seconds )</b></p>
<p>Défini la valeur du timeout</p>
</li>
<li><p><b>string GetUsername()</b></p>
<p>Retourne le nom d\'utilisateur de l\'authentification smtp</p>
</li>
<li><p><b>void SetUsername( $string )</b></p>
<p>Défini le nom d\'utilisateur de l\'authentification smtp</p>
</li>
<li><p><b>int GetWordWrap()</b></p>
<p>Retourne la valeur wordwrap</p>
</li>
<li><p><b>void SetWordWrap( $int )</b></p>
<p>Retourne la valeur wordwrap</p>
</li>
<li><p><b>AddAddress( $address, $name = \'\' )</b></p>
<p>Ajoute une adresse de destination</p>
</li>
<li><p><b>AddAttachment( $path, $name = \'\', $encoding = \'base64\', $type = \'application/octent-stream\' )</b></p>
<p>Ajoute un fichier attaché</p>
</li>
<li><p><b>AddBCC( $address, $name = \'\' )</b></p>
<p>Ajoute une adresse de destination cachée (BCC)</p>
</li>
<li><p><b>AddCC( $address, $name = \'\' )</b></p>
<p>Ajoute une adresse de destination copie (CC)</p>
</li>
<li><p><b>AddCustomHeader( $txt )</b></p>
<p>Ajoute un en-tête personnalisé au message</p>
</li>
<li><p><b>AddEmbeddedImage( $path, $cid, $name = \'\', $encoding = \'base64\', $type = \'application/octent-stream\' )</b></p>
<p>Ajoute une image intégrée</p>
</li>
<li><p><b>AddReplyTo( $address, $name = \'\' )</b></p>
<p>Ajoute une adresse de réponse</p>
</li>
<li><p><b>AddStringAttachment( $string, $filename, $encoding = \'base64\', $type = \'application/octent-stream\' )</b></p>
<p>Ajoute un fichier attaché</p>
</li>
<li><p><b>ClearAddresses()</b></p>
<p>Efface toutes les adresses</p>
</li>
<li><p><b>ClearAllRecipients()</b></p>
<p>Efface tous les destinataires</p>
</li>
<li><p><b>ClearAttachments()</b></p>
<p>Efface tous les attachements</p>
</li>
<li><p><b>ClearBCCs()</b></p>
<p>Efface toutes les adresses BCC</p>
</li>
<li><p><b>ClearCCs()</b></p>
<p>Efface toutes les adresses CC</p>
</li>
<li><p><b>ClearCustomHeaders()</b></p>
<p>Efface toutes les en-têtes personnalisées</p>
</li>
<li><p><b>ClearReplyto()</b></p>
<p>Efface l\'adresse de réponse</p>
</li>
<li><p><b>IsError()</b></p>
<p>Vérifie une condition d\'erreur</p>
</li>
<li><p><b>bool IsHTML( $bool )</b></p>
<p>Défini le html flag</p>
<p><i>Note :</i> si possible cela devrait être une méthode get et set</p>
</li>
<li><p><b>bool IsMail()</b></p>
<p>Vérifie si on utilise \'mail\'</p>
</li>
<li><p><b>bool IsQmail()</b></p>
<p>Vérifie si on utilise \'qmail\'</p>
</li>
<li><p><b>IsSendmail()</b></p>
<p>Vérifie si on utilise \'sendmail\'</p>
</li>
<li><p><b>IsSMTP()</b></p>
<p>Vérifie si on utilise \'smtp\'</p>
</li>
<li><p><b>Send()</b></p>
<p>Envoie le mail en cours de préparation</p>
</li>
<li><p><b>SetLanguage( $lang_type, $lang_path = \'\' )</b></p>
<p>Défini la langue <em>(optional)</em> language path</p>
</li>
<li><p><b>SmtpClose()</b></p>
<p>Ferme la connexion smtp</p>
</li>
</ul>
<h3>Support</h3>
<p>Ce module ne contient aucun support commercial. Cependant, ses ressources sont disponibles pour vous aider&nbsp;:</p>
<ul>
<li>Pour la dernière version de ce module, les FAQs, ou pour annoncer un bug, veuillez visiter la <a href="http://dev.cmsmadesimple.org/" target="_blank">forge de CMS Made Simple</a>.</li>
<li>Des discussions complémentaires relatives à ce module peuvent aussi être trouvées sur les <a href="http://forum.cmsmadesimple.org" target="_blank">Forums CMS Made Simple</a>.</li>
<li>L\'auteur, Calguy1000, est souvent sur IRC sur canal #cms: irc.freenode.net/#cms.</li>
<li>Et enfin, vous pouvez rencontrer un certain succès en envoyant un email directement à l\'auteur.</li>
</ul>
<p>Conformément à la licence GPL, ce module est distribué tel quel. Veuillez vous référer directement à la licence pour tout avis de non responsabilité.</p>
<p>As per the GPL, this software is provided as-is. Please read the text of the license for the full disclaimer.</p>

<h3>Copyright et Licence</h3>
<p>Copyright © 2005, Robert Campbell <a href="mailto:calguy1000@hotmail.com">calguy1000@hotmail.com</a>. Tous droits réservés.</p>
<p>Ce module est distribué sous la licence <a href="http://www.gnu.org/licenses/licenses.html#GPL" target="_blank">GNU Public License</a>. Vous devez agréer aux termes de cette licence pour pouvoir utiliser ce module.</p>
<p>This module has been released under the <a href=\'http://www.gnu.org/licenses/licenses.html#GPL\'>GNU Public License</a>. You must agree to this license before using the module.</p>';
$lang['moddescription'] = 'Ceci englobe simplement PHPMailer, il a un équivalent API (fonction pour fonction) et une interface simple pour les paramètres par défaut. Ce module est obsolète en version CMSMS 2.0';
$lang['postinstall'] = 'Le module CMSMailer a été correctement installé';
$lang['postuninstall'] = 'Le module CMSMailer a été désinstallé.';
?>