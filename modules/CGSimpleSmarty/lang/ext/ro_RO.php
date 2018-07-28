<?php
$lang['friendlyname'] = 'CGSimpleSmarty ';
$lang['help'] = '<h3>Ce face acesta?</h3>
<p>Acest modul furnizeaza niste utilitare simple smarty de folosit pentru aplicatii sau pentru a customiza comportamentul paginilor CMS Made Simple.</p>
<h3>Cum se foloseste:</h3>
<p>Cand acest modul este instalat, un nou obiect smarty numit cgsimple devine disponibil automat pentru template-uri, blocuri globale de continut si variate template-uri de module. Acest obiect smarty are numeroase functii cere pot fi apelate oricand.</p>
<h4>Functii disponibile:</h4>
<ul>
<li><strong>self_url</strong>([$assign])
    <p>Returneaza url-ul curent</p>
    <p>Argumente:
       <ul>
         <li>[$assign]   - (optional) Numele unei variabile careia sa i se aloce rezultatul.</li>
      </ul>  
    <br/></p>
</li>

<li><strong>module_installed</strong>($modulename,[$assign])
    <p>Testeaza daca un modul anume este instalat.</p>
    <p>Argumente:
       <ul>
         <li>$modulename - Numele modulului de verificat</li>
         <li>[$assign]   - (optional) Numele unei variabile careia sa i se aloce rezultatul.</li>
      </ul>  
    <br/></p>
    <p>Exemplu:<br/>
    <pre>{if $cgsimple->module_installed(&#039;FrontEndUsers&#039;)}Found FEU{/if}</pre><br/>
    </p>
</li>

<li><strong>module_version</strong>($modulename,[$assign])
    <p>Returneaza numarul de versiune al unui modul anume instalat</p>
    <p>Argumente:
       <ul>
         <li>$modulename - Numele modulului de verificat</li>
         <li>[$assign]   - (optional) Numele unei variabile careia sa i se aloce rezultatul.</li>
      </ul>  
    <br/></p>
    <p>Exemplu:<br/>
    <pre>{$cgsimple->module_version(&#039;FrontEndUsers&#039;,&#039;feu_version&#039;)}Avem versiunea {$feu_version} a modulului FrontEndUsers</pre><br/>
    </p>
</li>

<li><strong>get_parent_alias</strong>([$alias],[$assign])
    <p>Returneaza aliasul parintelui paginii specificate. Returneaza un sir gol daca nu este nici un parinte.</p>
    <p>Argumente:
       <ul>
       <li>[$alias] - (optional) Aliasul paginii pentru care se gaseste parintele. Daca nu este specificata nici o valoare, se foloseste pagina curenta.</li>
       <li>[$assign]   - (optional) Numele unei variabile careia sa i se aloce rezultatul.</li>
       </ul>  
    <br/></p>
    <p>Exemplu:<br/>
    <pre>Aliasul paginii parinte este {$cgsimple->get_parent_alias()}</pre><br/>
    </p>
</li>

<li><strong>get_root_alias</strong>([$alias],[$assign])
    <p>Returneaza aliasul parintelui radacina al paginii specificate. Returneaza un sir gol daca nu este nici un parinte radacina.</p>
    <p>Argumente:
       <ul>
       <li>[$alias] - (optional) Aliasul paginii pentru care se gaseste parintele radacina. Daca nu este specificata nici o valoare, se foloseste pagina curenta.</li>
       <li>[$assign]   - (optional) Numele unei variabile careia sa i se aloce rezultatul.</li>
       </ul>  
    <br/></p>
    <p>Exemplu:<br/>
    <pre>Aliasul paginii parinte radacina este {$cgsimple->get_root_alias()}</pre><br/>
    </p>
</li>

<li><strong>get_page_title</strong>([$alias],[$assign])
    <p>Returneaza titlul paginii specificate.</p>
    <p>Argumente:
       <ul>
       <li>[$alias] - (optional) Aliasul paginii pentru care se gaseste titlul.  Daca nu este specificata nici o valoare, se foloseste pagina curenta.</li>
       <li>[$assign]   - (optional) Numele unei variabile careia sa i se aloce rezultatul.</li>
       </ul>  
    <br/></p>
    <p>Exemplu:<br/>
    <pre>Titlul paginii curente este {$cgsimple->get_page_title()}</pre><br/>
    </p>
</li>

<li><strong>get_page_menutext</strong>([$alias],[$assign])
    <p>Returneaza textul meniu al paginii specificate.</p>
    <p>Argumente:
       <ul>
       <li>[$alias] - (optional) Aliasul paginii pentru care se gaseste textul meniului. Daca nu este specificata nici o valoare, se foloseste pagina curenta.</li>
       <li>[$assign]   - (optional) Numele unei variabile careia sa i se aloce rezultatul.</li>
       </ul>  
    <br/></p>
    <p>Exemplu:<br/>
    <pre>Textul pentru meniu al paginii curente este {$cgsimple->get_page_title()}</pre><br/>
    </p>
</li>

<li><strong>has_children</strong>([$alias],[$assign])
    <p>Testeaza daca pagina specificata are copii.</p>
    <p>Argumente:
       <ul>
       <li>[$alias] - (optional) Aliasul paginii de testat. Daca nu este specificata nici o valoare, se foloseste pagina curenta.</li>
       <li>[$assign] - (optional) Numele unei variabile careia sa i se aloce rezultatul.</li>
       </ul>  
    <br/></p>
    <p>Exemplu:<br/>
    <pre>{$cgsimple->has_children(&#039;&#039;,$has_children)}{if $has_children}Pagina curenta are copii{else}Pagina curenta nu are copii{/if}</pre><br/>
    </p>
</li>

<li><strong>get_children</strong>([$alias],[$showinactive],[$assign])
   <p>Returneaza un array continand informatii despre copiii unei pagini (daca este vreunul)</p>
    <p>Argumente:
       <ul>
       <li>[$alias] - (optional) Aliasul paginii de testat. Daca nu este specificata nici o valoare, se foloseste pagina curenta.</li>
       <li>[$showinactive] - (optional) Daca se includ in rezultat si paginile inactive (implicit este false).</li>
       <li>[$assign] - (optional) Numele unei variabile careia sa i se aloce rezultatul.</li>
       </ul>  
    <br/></p>
    <p>Campuri:
       <ul>
       <li>alias - Aliasul paginii copil</li>
       <li>id - ID al paginii copil</li>
       <li>title - Titlul paginii copil</li>
       <li>menutext - Textul din meniu al paginii copil</li>
       </ul>
    <br/></p>
    <p>Exemplu:<br/>
    <pre>
{$cgsimple->get_children(&#039;&#039;,&#039;&#039;,$children)}
{if count($children)}
   {foreach from=$children item=&#039;child&#039;}
      {if $child.show_in_menu}
        Copil:  id = {$child.id} alias = {$child.alias}<br/>
      {/if}
   {/foreach}
{/if}
    </pre><br/>
    </p>
</li>

    <li><strong>get_page_content</strong>($alias,[$block],[$assign])
    <p>Returneaza textul unui bloc specific de continut din alta pagina.</p>
    <p>Argumente:
       <ul>
       <li>$alias - Aliasul paginii de unde se extrag informatiile.</li>
       <li>[$block] - (optional) Numele blocului de continut din pagina specificata. Daca aceasta variabila nu este specificata, &#039;content_en&#039; este cel preluat implicit.</li>
       <li>[$assign] - (optional) Numele unei variabile careia sa i se aloce rezultatul.</li>
       </ul>  
    <br/></p>
</li>

    <li><strong>get_sibling</strong>($direction,[$assign],[$alias])
    <p>Returneaza aliasul urmatorului sau precedentului frate(sora) al paginii specificate, sau false.</p>
    <p>Argumente:
       <ul>
       <li>$direction - directia in care ne uitam. Valori posibile sunt prev,previous,-1,next,1</li>
       <li>[$assign] - (optional) Numele unei variabile careia sa i se aloce rezultatul.</li>
       <li>[$alias] - (optional) Aliasul paginii pentru care se cauta frati.  Daca nu este specificata nici o valoare, se foloseste pagina curenta.</li>
    <br/></p>
       <p>Exemplu:<br/>
       <pre>Link catre pagina precedenta: {$cgsimple->get_sibling(&quot;prev&quot;,&quot;prev_sibling&quot;)}{if !empty($prev_sibling)}{cms_selflink page=&quot;$prev_sibling&quot; text=&quot;Previous&quot;}{/if}</pre><br/>
    </li>
</ul>
<h4>Alte functii smarty</h4>
<ul>
    <li><strong>{module_action_link}</strong>
    <p>Un plugin smarty care poate crea un link catre actiunea unui modul.</p>
    <p>Argumente:
       <ul>
       <li>module - Modulul catre care se creaza link</li>
       <li>action (default) - Actiunea care se apeleaza in modul</li>
       <li>text - Textul care se pune in link</li>
       <li>page - Specificati pagina de destinatie</li>
       <li>urlonly - In loc sa se genereze un link, se genereaza doar url-ul</li>
       <li>jsfriendly - Folosit impreuna cu parametrul urlonly acest parametru va asigura ca outputul va fi un url javascript friendly.</li>
       <li>confmessage - Un mesaj de confirmare de afisat cand linkul este accesat.</li>
       <li>image - O imagine care se foloseste pentru link</li>
       <li>imageonly - Daca o imagine este specificata, se creaza un link numai imagine. Textul va fi folosit pentru atributul titlu</li>
       </ul>
    <br/></p>
    <p>Orice alt argument al plugin-ului smarty va fi adaugat la URL-ul generat.</p>   <p>Exemplu:
<pre>{module_action_link module=&#039;Noutati&#039; action=&#039;fesubmit&#039; text=&#039;Trimiteti un articol nou&#039;}</pre><br/></p></li>


    <li><strong>{session_put}</strong>
    <p>Un plugin smarty care poate stoca date in sesiunea utilizator. Aceste date sunt apoi disponibile prin intermediul array-ului $smarty.session in urmatoarele pagini.</p>
    <p>Argumente:
       <ul>
       <li>var - Numele variabile care se creaza in sesiune.</li>
       <li>value - Valoarea dorita a variabilei.</li>
       </ul>
    <br/></p>
    <p>Exemplu:
    <pre>{session_put var=&#039;test&#039; value=&#039;blah&#039;}</pre><br/></p></li>

    <li><strong>{session_erase}</strong>
    <p>Un plugin smarty care poate sterge date din sesiunea utilizator.</p>
    <p>Argumente:
       <ul>
       <li>var - Numele variabilei de sters din sesiune.</li>
       </ul>
    <br/></p>
    <p>Exemplu:
    <pre>{session_erase var=&#039;test&#039;}</pre><br/></p></li>

    <li><strong>{cgrepeat}</strong>
    <p>Un alt plugin smarty care permite repetare de text</p>
    <p>Argumente:</p>
      <ul>
        <li>text - Textul care se repeta</li>
        <li>count - Numarul de ori in care ar trebui sa se repete</li>
        <li>assign - Aloca output-ul catre variabila smarty specificata</li>
      </ul>
    <br/>
    <p>Exemplu: <pre>{cgrepeat text=&#039;this&#039; count=&#039;5&#039;}</pre><br/></p>
    </li>
</ul>
<h3>Copyright and License</h3>
<p>Copyright &copy; 2008, Robert Campbel <a href="mailto:calguy1000@cmsmadesimple.org"><calguy1000@cmsmadesimple.org></a>. All Rights Are Reserved.</p>
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
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
Or read it <a href="http://www.gnu.org/licenses/licenses.html#GPL">online</a></p>';
$lang['moddescription'] = 'Calguys Simple Smarty Tools ';
$lang['postinstall'] = 'CGSimpleSmarty a fost instalat';
$lang['postuninstall'] = 'CGSimpleSmarty a fost dezinstalat';
$lang['utmc'] = '156861353';
$lang['utma'] = '156861353.3573843717708992500.1250056267.1250590168.1250593399.17';
$lang['utmz'] = '156861353.1250579160.14.3.utmccn=(referral)|utmcsr=dev.cmsmadesimple.org|utmcct=/project/files/6|utmcmd=referral';
$lang['qcb'] = '1912438266';
$lang['qca'] = '1249980835-92593492-79567608';
?>