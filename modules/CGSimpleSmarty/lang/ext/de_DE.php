<?php
$lang['friendlyname'] = 'CG Simple Smarty';
$lang['help'] = '<h3>Was macht dieses Modul?</h3>
<p>Mit diesem Modul erhalten Sie ein paar einfache Smarty-Werkzeuge, die Sie in eigenen Modulen oder zur Anpassung der Seiten-Eigenschaften in CMS made simple.</p>
<h3>Wie wird es eingesetzt?</h3>
<p>Wenn das Modul installiert ist, ist in den Templates, Globalen Inhaltsbl&ouml;cken und verschiedenen und den Modul-Templates automatisch ein neues Smarty-Objekt mit dem Namen cgsimple verf&uuml;gbar. Dieses Smarty-Objekt hat verschiedene Funktionen, die Sie jederzeit aufrufen k&ouml;nnen.</p>
<h4>Verf&uuml;gbare Funktionen:</h4>
<li><strong>self_url</strong>([$assign])
    <p>Gibt die aktuelle URL zur&uuml;ck</p>
    <p>Argumente:
       <ul>
         <li>[$assign]   - (optional) der Name der Variable, der das Ergebnis zugewiesen werden soll.</li>
      </ul>  
    <br/></p>
</li>

<ul>
<li><strong>module_installed</strong>($modulename,[$assign])
    <p>Pr&uuml;ft, ob ein bestimmtes Modul installiert ist.</p>
    <p>Argumente:
       <ul>
         <li>$modulename - der Name des Moduls, dessen Existenz bzw. Installation gepr&uuml;ft werden soll</li>
         <li>[$assign]   - (optional) der Name der Variable, der das Ergebnis zugewiesen werden soll.</li>
      </ul>  
    <br/></p>
    <p>Beispiel:<br/>
    <pre>{if $cgsimple->module_installed(&#039;FrontEndUsers&#039;)}FEU-Modul gefunden{/if}</pre>
    </p>
</li>

<li><strong>module_version</strong>($modulename,[$assign])
    <p>Gibt die Versionsnummer des abgefragten Moduls zur&uuml;ck</p>
    <p>Argumente:
       <ul>
         <li>$modulename - der Name des Moduls, das gepr&uuml;ft werden soll</li>
         <li>[$assign]   - (optional) der Name der Variable, der das Ergebnis zugewiesen werden soll.</li>
      </ul>  
    <br/></p>
    <p>Beispiel:<br/>
    <pre>{$cgsimple->module_version(&#039;FrontEndUsers&#039;,&#039;feu_version&#039;)}Es ist die Version {$feu_version} des FrontEndUsers-Moduls installiert</pre>
    </p>
</li>

<li><strong>get_parent_alias</strong>([$alias],[$assign])
    <p>Gibt den Alias der &uuml;bergeordneten Seite einer festgelegten Seite zur&uuml;ck. Falls keine &uuml;bergeordnete Seite vorhanden ist, wird ein leerer String zur&uuml;ck gegeben.</p>
    <p>Argumente:
       <ul>
       <li>[$alias] - (optional) der Seiten-Alias der Seite, deren &uuml;bergeordnete Seite gefunden werden soll. Wenn kein Wert festgelegt wurde, wird die aktuelle Seite verwendet.</li>
       <li>[$assign]   - (optional) der Name der Variable, der das Ergebnis zugewiesen werden soll.</li>
       </ul>  
    <br/></p>
    <p>Beispiel:<br/>
    <pre>Der Alias der &uuml;bergeordneten Seite ist {$cgsimple->get_parent_alias()}</pre>
    </p>
</li>

<li><strong>get_root_alias</strong>([$alias],[$assign])
    <p>Gibt den Alias der &uuml;bergeordneten Seite der 1. Ebene zur&uuml;ck. Falls keine &uuml;bergeordneten Seiten existieren, wird ein leerer String zur&uuml;ck gegeben.</p>
    <p>Argumente:
       <ul>
       <li>[$alias] - (optional) der Seiten-Alias der Seite, deren &uuml;bergeordnete Seite der 1. Ebene gefunden werden soll.  Wenn kein Wert festgelegt wurde, wird die aktuelle Seite verwendet.</li>
       <li>[$assign]   - (optional) der Name der Variable, der das Ergebnis zugewiesen werden soll.</li>
       </ul>  
    <br/></p>
    <p>Beispiel:<br/>
    <pre>Der Seiten-Alias der obersten, &uuml;bergeordneten Seite ist {$cgsimple->get_root_alias()}</pre>
    </p>
</li>

<li><strong>get_page_title</strong>([$alias],[$assign])
    <p>Gibt den Titel einer festgelegten Seite zur&uuml;ck.</p>
    <p>Argumente:
       <ul>
       <li>[$alias] - (optional) Der Seiten-Alias, deren Titel gefunden werden soll. Wenn kein Wert festgelegt wurde, wird die aktuelle Seite verwendet.</li>
       <li>[$assign]   - (optional) der Name der Variable, der das Ergebnis zugewiesen werden soll.</li>
       </ul>  
    <br/></p>
    <p>Beispiel:<br/>
    <pre>Der Titel der aktuellen Seite ist {$cgsimple->get_page_title()}</pre>
    </p>
</li>

<li><strong>get_page_menutext</strong>([$alias],[$assign])
    <p>Gibt den Men&uuml;text einer festgelegten Seite zur&uuml;ck.</p>
    <p>Argumente:
       <ul>
       <li>[$alias] - (optional) Der Seiten-Alias, dessen Men&uuml;text gefunden werden soll. Wenn kein Wert festgelegt wurde, wird die aktuelle Seite verwendet.</li>
       <li>[$assign]   - (optional) der Name der Variable, der das Ergebnis zugewiesen werden soll.</li>
       </ul>  
    <br/></p>
    <p>Beispiel:<br/>
    <pre>Der Men&uuml;text der aktuelle Seite ist {$cgsimple->get_page_title()}</pre>
    </p>
</li>

<li><strong>get_page_type</strong>([$alias][,$assign])
    <p>Gibt den Inhaltstyp eines vorgegebenen Objekts zur&uuml;ck (nach dem Alias)</p>
    <p>Argumente:
       <ul>
       <li>[$alias] - (optional) Der Seiten-Alias, dessen Inhaltstyp gefunden werden soll. Wenn kein Wert festgelegt wurde, wird die aktuelle Seite verwendet.</li>
       <li>[$assign]   - (optional) der Name der Variable, der das Ergebnis zugewiesen werden soll.</li>
       </ul>  
    <br/></p>
    <p>Beispiel:<br/>
    <pre>Der Inhaltstyp der aktuellen Seite ist {$cgsimple-&amp;gt;get_page_type()}</pre>
    </p>
</li>

<li><strong>has_children</strong>([$alias],[$assign])
    <p>Pr&uuml;ft, ob eine festgelegte Seite untergeordnete Seiten hat.</p>
    <p>Argumente:
       <ul>
       <li>[$alias] - (optional) der Seiten-Alias der zu pr&uuml;fenden Seite. Wenn kein Wert festgelegt wurde, wird die aktuelle Seite verwendet.</li>
       <li>[$assign] - (optional) der Name der Variable, der das Ergebnis zugewiesen werden soll.</li>
       </ul>  
    <br/></p>
    <p>Beispiel:<br/>
    <pre>{$cgsimple->has_children(&#039;&#039;,$has_children)}{if $has_children}Die aktuelle Seite hat untergeordnete Seiten{else}Die aktuelle Seite hat keine untergeordneten Seiten{/if}</pre>
    </p>
</li>

<li><strong>get_children</strong>([$alias],[$showinactive],[$assign])
   <p>Gibt ein Array zur&uuml;ck, welches Informationen &uuml;ber die untergeordneten Seiten enth&auml;lt (falls vorhanden)</p>
    <p>Arguments:
       <ul>
       <li>[$alias] - (optional) der Seiten-Alias der zu pr&uuml;fenden Seite. Wenn kein Wert festgelegt wurde, wird die aktuelle Seite verwendet.</li>
       <li>[$showinactive] - (optional) hier kann eingestellt werden, ob inaktive Seiten im Ergebnis enthalten sein sollen (Standard ist false).</li>
       <li>[$assign] - (optional) der Name der Variable, der das Ergebnis zugewiesen werden soll.</li>
       </ul>  
    <br/></p>
    <p>Felder:
       <ul>
       <li>alias - der Seiten-Alias der untergeordneten Seite</li>
       <li>id - die Seiten-ID der untergeordneten Seite</li>
       <li>title - der Seitentitel der untergeordneten Seite</li>
       <li>menutext - der Men&uuml;text der untergeordneten Seite</li>
       </ul>
    <br/></p>
    <p>Beispiel:<br/>
    <pre>
{$cgsimple->get_children(&#039;&#039;,&#039;&#039;,$children)}
{if count($children)}
   {foreach from=$children item=&#039;child&#039;}
      {if $child.show_in_menu}
        Untergeordnete Seite:  id = {$child.id} Alias = {$child.alias}<br />
      {/if}
   {/foreach}
{/if}
    </pre>
    </p>
</li>

    <li><strong>get_page_content</strong>($alias,[$block],[$assign])
    <p>Gibt den Inhalt eines festgelegten Content-Blocks einer anderen Seite zur&uuml;ck.</p>
    <p>Argumente:
       <ul>
       <li>$alias - Der Alias der Seite, deren Inhalt zur&uuml;ck gegeben werden soll.</li>
       <li>[$block] - (optional) der Name des Content-Blocks der festgelegten Seite. Ohne Vorgabe wird der Wert aus &#039;content_en&#039; verwendet.</li>
       <li>[$assign] - (optional) der Name der Variable, der das Ergebnis zugewiesen werden soll.</li>
       </ul>  
    <br/></p>
    <p>Beispiel:<br/>
    <pre>Der Inhalt der festgelegten Seite ist {$cgsimple->get_page_content(home)}</pre>
    </p>
</li>

    <li><strong>get_sibling</strong>($direction,[$assign],[$alias])
    <p>Gibt den Seiten-Alias der n&auml;chsten oder vorhergehenden Seite der gleichen Ebene der vorgegebenen
       Seite an. Oder auch false.</p>
    <p>Argumente:
       <ul>
       <li>$direction - die Richtung, in die geschaut werden soll. M&ouml;gliche Werte sind prev,previous,-1,next,1.</li>
       <li>[$assign] - (optional) der Name der Variable, der das Ergebnis zugewiesen werden soll.</li>
       <li>[$alias] - (optional) Der Alias der Seite, dessen Seiten der gleichen Ebene gefunden werden sollen. Ohne Vorgabe wird die aktuelle Seite verwendet.</li>
    <br/></p>
       <p>Beispiel:<br />
       <pre>Link auf die vorherige Seite: {$cgsimple->get_sibling(&quot;prev&quot;,&quot;prev_sibling&quot;)}{if !empty($prev_sibling)}{cms_selflink page=&quot;$prev_sibling&quot; text=&quot;Previous&quot;}{/if}</pre><br/>
    </li>

</ul>
<h4>Weitere Smarty-Functionen</h4>
<ul>
    <li><strong>{module_action_link}</strong>
    <p>Ein Smarty-Plugin, mit dem ein Link auf eine Modul-Aktion gesetzt werden kann.</p>
    <p>Argumente:
       <ul>
       <li>module - das Modul, auf welches ein Link gesetzt werden soll</li>
       <li>action (default) - die Aktion des Moduls, welche aufgerufen werden soll</li>
       <li>text - der auszugebende Text des Links</li>
       <li>page - die Zielseite, auf der das Ergebnis ausgegeben werden soll</li>
       <li>urlonly - anstatt einen Link zu erzeugen, kann auch nur die URL ausgegeben werden</li>
       <li>jsfriendly - Wird dieser Parameter in Verbindung mit dem Parameter urlonly eingesetzt, stellt er sicher, dass eine javascript-freundliche URL ausgegeben wird.</li>
       <li>confmessage - eine Best&auml;tigungsnachricht, die angezeigt wird, wenn der Link geklickt wurde.</li>
       <li>image - ein Bild, das f&uuml;r den Link verwendet werden kann</li>
       <li>imageonly - Wurde f&uuml;r image ein Bild festgelegt, wird ein Link erzeugt, der nur dieses Bild enth&auml;lt. Der Text wird f&uuml;r das title-Attribut verwendet</li>
       </ul>
    <br/></p>
    <p>Jedes weitere Arguments wird der erzeugten URL des Smarty-Plugins hinzugef&uuml;gt.</p>
    <p> Beispiel:<br/>
    <pre>{module_action_link module=&quot;News&quot; action=&quot;fesubmit&quot; text=&quot;Einen neuen Artikel einsenden&quot;}</pre></p></li>


    <li><strong>{session_put}</strong>
    <p>Ein Smarty-Plugin, mit dem Daten in der User-Session gespeichert werden k&ouml;nnen. Auf diese Daten kann auf den entsprechenden Seiten dann &uuml;ber das Array $smarty.session zugegriffen werden.</p>
    <p>Argumente:
       <ul>
       <li>var - Name der Variablen, die in der Session erzeugt werden soll.</li>
       <li>value - Der entsprechende Wert dieser Variablen.</li>
       </ul>
    <br/></p>
    <p>Beispiel:<br />
    <pre>{session_put var=&quot;test&quot; value=&quot;blah&quot;}</pre></p></li>

    <li><strong>{session_erase}</strong>
    <p>Ein Smarty-Plugin, mit dem Daten aus einer User-Session gel&ouml;scht werden k&ouml;nnen.</p>
    <p>Argumente:
       <ul>
       <li>var - Name der Variable, die in der Session gel&ouml;scht werden soll.</li>
       </ul>
    <br/></p>
    <p>Beispiel:<br />
    <pre>{session_erase var=&quot;test&quot;}</pre></p></li>

   <li><strong>{cgrepeat}</strong>
    <p>Ein weiteres Smarty-Plugin, &uuml;ber das ein vorgegebener Text wiederholt ausgegeben werden kann</p>
    <p>Argumente:</p>
      <ul>
        <li>text - Text, der wiederholt ausgegeben werden soll</li>
        <li>count - Anzahl der Wiederholungen</li>
        <li>assign - Name der Variable, der das Ergebnis zugewiesen werden soll.</li>
      </ul>
    <br/>
    <p>Beispiel:<br />
    <pre>{cgrepeat text=&#039;dies&#039; count=&#039;5&#039;}</pre></p>
    </li>
</ul>
<h3>Copyright und Lizenz</h3>
<p>Copyright &copy; 2008, Robert Campbell <a href="mailto:calguy1000@cmsmadesimple.org">calguy1000@cmsmadesimple.org</a>. Alle Rechte vorbehalten.</p>
<p>Dieses Modul wurde unter der <a href="http://www.gnu.org/licenses/licenses.html#GPL">GNU Public License</a> ver&ouml;ffentlicht. Sie m&uuml;ssen dieser Lizenz zustimmen, bevor sie das Modul verwenden.</p>
<p>This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.</p>
<p>However, as a special exception to the GPL, this software is distributed
as an addon module to CMS Made Simple.  You may not use this software
in any Non GPL version of CMS Made simple, or in any version of CMS
Made simple that does not indicate clearly and obviously in its admin 
section that the site was built with CMS Made simple.</p>
<p>This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA</p>';
$lang['moddescription'] = 'Calguys einfache Smarty-Werkzeuge';
$lang['postinstall'] = 'CGSimpleSmarty wurde installiert';
$lang['postuninstall'] = 'CGSimpleSmarty wurde deinstalliert';
$lang['utma'] = '156861353.543163381.1302603430.1307687320.1308060137.24';
$lang['utmz'] = '156861353.1306611468.14.2.utmcsr=feedburner|utmccn=Feed: cmsmadesimple/blog (CMS Made Simple)|utmcmd=feed';
$lang['utmb'] = '156861353';
$lang['utmc'] = '156861353';
?>