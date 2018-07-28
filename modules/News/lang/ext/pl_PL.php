<?php
$lang['addarticle']='Dodaj artykuł';
$lang['addcategory']='Dodaj kategorię';
$lang['addfielddef']='Dodaj definicję pola';
$lang['addnewsitem']='Dodaj element aktualności';
$lang['allcategories']='Wszystkie kategorie';
$lang['allentries']='Wszystkie wpisy';
$lang['allow_summary_wysiwyg']='Zezw&oacute;l na użycie edytora WYSIWYG do pola podsumowania';
$lang['allowed_upload_types']='Zezwalaj na upload plik&oacute;w tylko z następującymi rozszerzeniami';
$lang['anonymous']='Anonim';
$lang['apply']='Zastosuj';
$lang['approve']='Zmień status na &quot;opublikowano&quot;';
$lang['areyousure']='Czy na pewno chcesz usunąć?';
$lang['areyousure_deletemultiple']='Czy napewno chcesz skasować wszystkie aktualności?\nTa czynność jest nieodwracalna.';
$lang['article']='Artykuł';
$lang['articleadded']='Artykuł dodany pomyślnie';
$lang['articledeleted']='Atrykuł został usunięty';
$lang['articles']='Artykuły';
$lang['articleupdated']='Artykuł pomyślnie zaktualizowany';
$lang['author']='Autor';
$lang['author_label']='Napisał:';
$lang['auto_create_thumbnails']='Automatycznie stw&oacute;rz miniatury dla plik&oacute;w z tymi rozszerzeniami';
$lang['browsecattemplate']='Szablony Przegladanie Kategorii';
$lang['cancel']='Anuluj';
$lang['categories']='Kategorie';
$lang['category']='Kategoria';
$lang['category_label']='Kategoria:';
$lang['categoryadded']='Kategoria została dodana';
$lang['categorydeleted']='Kategoria została usunięta';
$lang['categoryupdated']='Kategoria została zaktualizowana';
$lang['content']='Treść';
$lang['customfields']='Definicje p&oacute;l';
$lang['dateformat']='%s nie jest w poprawnym formacie yyyy-mm-dd hh:mm:ss';
$lang['default_category']='Domyślna kategoria';
$lang['default_templates']='Szablony domyślne';
$lang['delete']='Usuń';
$lang['delete_selected']='Skasuj wybrane artykuły';
$lang['deprecated']='nieobsługiwane';
$lang['description']='Dodawanie, edycja i usuwanie aktualności';
$lang['detailtemplate']='Szablon szczeg&oacute;łowy';
$lang['detailtemplateupdated']='Zaktualizowany szablon szczeg&oacute;łowy został zapisany w bazie danych.';
$lang['displaytemplate']='Wyświetl szablon';
$lang['down']='Do dołu';
$lang['draft']='Kopia robocza';
$lang['edit']='Edytuj';
$lang['editfielddef']='Edytuj definicję pola';
$lang['email_subject']='Temat widomości powiadamiającej';
$lang['email_template']='Format wiadomości powiadamiającej';
$lang['enddate']='Data końcowa';
$lang['endrequiresstart']='Wprowadzenie daty końcowej wymaga także wprowadzenia daty początkowej';
$lang['entries']='%s wpis&oacute;w';
$lang['error_duplicatename']='Element z taką nazwą  już istnieje';
$lang['error_filesize']='Wgrywany plik przekracza limit wielkości';
$lang['error_invaliddates']='Przynajmniej jedna z z wpisanych dat jest nieprawidłowa';
$lang['error_invalidfiletype']='Nie wolno wgrywać plik&oacute;w o rozszerzeniu';
$lang['error_invalidurl']='Błędny URL <em>(może być w użyciu, albo zawiera niepoprawne znaki)</em>';
$lang['error_mkdir']='Nie mogę utworzyć katalogu: %s';
$lang['error_movefile']='Nie mogę utworzyć pliku: %s';
$lang['error_noarticlesselected']='Żaden artykuł nie został zaznaczony';
$lang['error_templatenamexists']='Szablon o tej nazwie już istnieje';
$lang['error_upload']='Problem wystąpił przy wgrywaniu pliku';
$lang['eventdesc-NewsArticleAdded']='Wyślij, gdy dodano artykuł.';
$lang['eventdesc-NewsArticleDeleted']='Wyślij, gdy usunięto artykuł.';
$lang['eventdesc-NewsArticleEdited']='Wyślij, gdy zmieniono artykuł.';
$lang['eventdesc-NewsCategoryAdded']='Wyślij, gdy dodano kategorię.';
$lang['eventdesc-NewsCategoryDeleted']='Wyślij, gdy usunięto kategorię.';
$lang['eventdesc-NewsCategoryEdited']='Wyślij, gdy zmieniono kategorię.';
$lang['eventhelp-NewsArticleAdded']='<p>Sent when an article is added.</p>
<h4>Parameters</h4>
<ul>
<li>\&quot;news_id\&quot; - Id of the news article</li>
<li>\&quot;category_id\&quot; - Id of the category for this article</li>
<li>\&quot;title\&quot; - Title of the article</li>
<li>\&quot;content\&quot; - Content of the article</li>
<li>\&quot;summary\&quot; - Summary of the article</li>
<li>\&quot;status\&quot; - Status of the article (\&quot;draft\&quot; or \&quot;publish\&quot;)</li>
<li>\&quot;start_time\&quot; - Date the article should start being displayed</li>
<li>\&quot;end_time\&quot; - Date the article should stop being displayed</li>
<li>\&quot;useexp\&quot; - Whether the expiration date should be ignored or not</li>
</ul>
';
$lang['eventhelp-NewsArticleDeleted']='<p>Sent when an article is deleted.</p>
<h4>Parameters</h4>
<ul>
<li>\&quot;news_id\&quot; - Id of the news article</li>
</ul>
';
$lang['eventhelp-NewsArticleEdited']='<p>Sent when an article is edited.</p>
<h4>Parameters</h4>
<ul>
<li>\&quot;news_id\&quot; - Id of the news article</li>
<li>\&quot;category_id\&quot; - Id of the category for this article</li>
<li>\&quot;title\&quot; - Title of the article</li>
<li>\&quot;content\&quot; - Content of the article</li>
<li>\&quot;summary\&quot; - Summary of the article</li>
<li>\&quot;status\&quot; - Status of the article (\&quot;draft\&quot; or \&quot;publish\&quot;)</li>
<li>\&quot;start_time\&quot; - Date the article should start being displayed</li>
<li>\&quot;end_time\&quot; - Date the article should stop being displayed</li>
<li>\&quot;useexp\&quot; - Whether the expiration date should be ignored or not</li>
</ul>
';
$lang['eventhelp-NewsCategoryAdded']='<p>Sent when a category is added.</p>
<h4>Parameters</h4>
<ul>
<li>\&quot;category_id\&quot; - Id of the news category</li>
<li>\&quot;name\&quot; - Name of the news category</li>
</ul>
';
$lang['eventhelp-NewsCategoryDeleted']='<p>Sent when a category is deleted.</p>
<h4>Parameters</h4>
<ul>
<li>\&quot;category_id\&quot; - Id of the deleted category </li>
<li>\&quot;name\&quot; - Name of the deleted category</li>
</ul>
';
$lang['eventhelp-NewsCategoryEdited']='<p>Sent when a category is edited.</p>
<h4>Parameters</h4>
<ul>
<li>\&quot;category_id\&quot; - Id of the news category</li>
<li>\&quot;name\&quot; - Name of the news category</li>
<li>\&quot;origname\&quot; - The original name of the news category</li>
</ul>
';
$lang['expired']='Wygasło';
$lang['expired_searchable']='Wygasłe artykuły mogą pojawiać się w wynikach wyszukiwania';
$lang['expiry']='Wygasa';
$lang['expiry_date_asc']='Data wygaśnięcia rosnąco';
$lang['expiry_date_desc']='Data wygaśnięcia malejąco';
$lang['expiry_interval']='Domyślna ilość dni po jakiej artykuł wygaśnie (o ile zaznaczono wygasanie)';
$lang['extra']='Ekstra';
$lang['extra_label']='Ekstra:';
$lang['fesubmit_redirect']='ID strony lub alias do przekierowania po tym, jak artykuł został wysłany przez akcję fesubmit';
$lang['fesubmit_status']='Status artykuł&oacute;w przesłanych przez stronę (front-end)';
$lang['fielddef']='Definicja pola';
$lang['fielddefadded']='Definicja pola dodana';
$lang['fielddefdeleted']='Skasuj definicję pola';
$lang['fielddefupdated']='Definicja pola została zaktualizowana';
$lang['file']='Plik';
$lang['filter']='Filtr';
$lang['firstpage']='<<';
$lang['formsubmit_emailaddress']='Adres email używany do wysłania wiadomości z informacją o nowym newsie';
$lang['formtemplate']='Szablony formularza';
$lang['help']='	<h3>Do czego to służy?</h3>
	<p>News jest modułem do wyświetlania aktualności na Twojej stronie. Podobnie jak blog, tylko że posiada więcej funkcji. Jeśli moduł News jest zainstalowany, strona administracji News jest dodana do menu administracyjnego i pozwala Ci wybrać lub dodać kategorię aktualności. Jeśli kategoria aktualności zostanie stworzona lub wybrana, zostanie wyświetlona lista aktualności dla danej kategorii. W tym miejscu możesz dodawać, edytować i usuwać aktualności z wybranej kategorii.</p>
	<h3>Bezpieczeństwo</h3>
	<p>Użytkownik musi należeć do grupy z uprawnieniami do modyfikacji aktualności aby dodawać, edytować lub usuwać wpisy aktualności.</p>
	<h3>Jak się tego używa?</h3>
	<p>Najprostszą drogą jest użycie w połączeniu ze znacznikiem cms_module. To pozwala na wstawienie modułu w szablon lub lub stronę tam gdzie chcesz i wyświetla elementy news. Kod powinien wyglądać mniej więcej tak: <code>{news number=&quot;5&quot; category=&quot;beer&quot;}</code></p>
	<h3>Jakie przyjmuje parametry?</h3>
	<p>
	<ul>
	<li><em>(opcjonalny)</em> number=\&quot;5\&quot; - Maksymalna ilość element&oacute;w do wyświetlenia - pozostawienie pustego parametru wyświetla wszystkie</li>
	<li><em>(opcjonalny)</em> makerssbutton=\&quot;true\&quot; - Stworzenie przycisku do kanału RSS element&oacute;w news.</li>
	<li><em>(opcjonalny)</em> category=\&quot;category\&quot; - Wyświetla tylko elementy dla wybranej kategorii i podrzędnych. Pozostawienie pustego wyświetli wszystkie kategorie.</li>
	<li><em>(opcjonalny)</em> moretext=\&quot;more...\&quot; - Tekst do wyświetlenia na końcu elementu news, jeśli jego długość wykroczy ponad długość podsumowania. Domyślnie \&quot;more...\&quot;.</li>
	<li><em>(opcjonalny}</em> summarytemplate=\&quot;sometemplate.tpl\&quot; - Użycie oddzielnego szablonu do wyświetlania podsumowania artykułu. Szablon zostanie umieszczony w katalogu modules/News/templates.
	<li><em>(opcjonalny}</em> detailtemplate=\&quot;sometemplate.tpl\&quot; - Użycie oddzielnego szablonu do wyświetlania szczeg&oacute;ł&oacute;w artykułu. Szablon zostanie umieszczony w katalogu modules/News/templates.
	<li><em>(opcjonalny)</em> sortby=\&quot;news_date\&quot; - Pole po kt&oacute;rym nastąpi sortowanie. Możliwe opcje to: \&quot;news_date\&quot;, \&quot;summary\&quot;, \&quot;news_data\&quot;, \&quot;news_category\&quot;, \&quot;news_title\&quot;.  Domyślnie \&quot;news_date\&quot;.</li>
	<li><em>(opcjonalny)</em> sortasc=\&quot;true\&quot; - Sortowanie element&oacute;w aktualności w porządku rosnącym zamiast malejącym.</li>
	</ul>
	</p>';
$lang['help_pagelimit']='Maksymalna liczba artykuł&oacute;w do wyświetlenia (na stronę)<br />
If this parameter is not supplied all matching items will be displayed.  If it is, and there are more items available than specified in the pararamter, text and links will be supplied to allow scrolling through the results';
$lang['helpaction']='Override the default action.  Possible values are &#039;default&#039; to display the summary view, and &#039;fesubmit&#039; to display the frontend form for allowing users to submit news articles on the front end.';
$lang['helpbrowsecat']='Pokazuje i umożliwia przeglądanie listy kategorii.';
$lang['helpcategory']='Wyświetl tylko elementy dla tej kategorii. Użyj * po nazwie aby wyświetlić kat. podrzędne. Wiele kategorii może być użytych, jeśli będą rozdzielone przecinkami. Pozostawienie pustego spowoduje wyświetlenie wszystkich kategorii.';
$lang['helpdetailpage']='Strona, na kt&oacute;rej będą widoczne szczeg&oacute;ły aktualności. To może być alias strony lub numer id.';
$lang['helpdetailtemplate']='Użyj osobnego szablonu do wyświetlenia szczeg&oacute;ł&oacute;w artykułu. Znajduje się w katalogu modules/News/templates.';
$lang['helpmoretext']='Tekst do wyświetlenia na końcu elementu news, jeśli przekroczy długość podsumowania. Domyślnie &quot;więcej...&quot;';
$lang['helpnumber']='Maksymalna ilość element&oacute;w do wyświetlenia =- pozostawienie pustego spowoduje wyświetlenie wszystkich element&oacute;w';
$lang['helpshowall']='Pokaż wszystkie artykuły niezależnie od daty zakończenia publikacji';
$lang['helpshowarchive']='Pokaż tylko aktualności, kt&oacute;re wygasły.';
$lang['helpsortasc']='Sortowanie element&oacute;w news w kolejności rosnącej zamiast malejącej.';
$lang['helpsortby']='Pola po kt&oacute;rych można sortować: &quot;news_date&quot;, &quot;summary&quot;, &quot;news_data&quot;, &quot;news_category&quot;, &quot;news_title&quot;.  Domyślnie &quot;news_date&quot;.';
$lang['helpstart']='Rozpocznij od n-tego elementu -- pozostawienie pustego spowoduje rozpoczęcie od pierwszego.';
$lang['helpsummarytemplate']='Użyj osobnego szablonu do wyświetlenia podsumowania artykułu. Znajduje się w katalogu modules/News/templates.';
$lang['hide_summary_field']='Ukryj pole podsumowania przy dodawaniu i edycji artykuł&oacute;w';
$lang['info_maxlength']='Długość maksymalna ma zastosowanie tylko do p&oacute;l tekstowych';
$lang['info_sysdefault']='<em>(szablon używany domyślnie, gdy nowy szablon jest zaznaczony)</em>';
$lang['info_sysdefault2']='<strong>Note:</strong> This tab contains text areas to allow you to edit a set of templates that are displayed when you create a &#039;new&#039; summary, detail, or form template.  Changing content in this tab, and clicking &#039;submit&#039; will <strong>not effect any current displays</strong>.';
$lang['lastpage']='>>';
$lang['maxlength']='Maksymalna długość';
$lang['more']='Więcej';
$lang['moretext']='Tekst &quot;Więcej&quot;';
$lang['msg_contenttype_removed']='Typ strony &#039;news&#039; został usunięty. Wpisz tag {news} z odpowiednimi parametrami w szablony lub zawartość stron.';
$lang['name']='Nazwa';
$lang['nameexists']='Pole z taką nazwą już istnieje';
$lang['needpermission']='Musisz posiadać uprawnienie &#039;%s&#039;, aby wykonać tę funkcję.';
$lang['newcategory']='Nowa kategoria';
$lang['news']='Aktualności';
$lang['news_return']='Wracaj';
$lang['nextpage']='>';
$lang['nocategorygiven']='Nie podano kategorii';
$lang['nocontentgiven']='Nie podano treści';
$lang['noitemsfound']='<strong>Nie znaleziono</strong> element&oacute;w dla kategorii: %s';
$lang['nonamegiven']='Nie podano nazwy';
$lang['none']='Żaden';
$lang['nopostdategiven']='Nie podano daty publikacji';
$lang['notanumber']='Wpisana maksymalna długość nie jest liczbą';
$lang['note']='<em>Uwaga:</em> daty muszą być w formacie &#039;yyyy-mm-dd hh:mm:ss&#039;.';
$lang['notify_n_draft_items']='Masz <a href="moduleinterface.php?module=News">%d artykuł&oacute;w</a>, kt&oacute;re nie zostały jeszcze opublikowane';
$lang['notify_n_draft_items_sub']='%d news&oacute;w';
$lang['notitlegiven']='Nie podano tytułu';
$lang['numbertodisplay']='Ilość do wyświetlenia (puste wyświetla wszystkie rekordy)';
$lang['options']='Opcje';
$lang['optionsupdated']='Opcje zostały zaktualizowane.';
$lang['post_date_asc']='Data publikacji rosnąco';
$lang['post_date_desc']='Data publikacji malejąco';
$lang['postdate']='Data publikacji';
$lang['postinstall']='Upewnij się, że ustawiłeś/aś uprawnienia do modyfikacji aktualności dla użytkownik&oacute;w, kt&oacute;rzy będą administrowali aktualnościami.';
$lang['preview']='Podgląd';
$lang['prevpage']='<';
$lang['print']='Drukuj';
$lang['prompt_default']='Domyślny';
$lang['prompt_name']='Nazwa';
$lang['prompt_newtemplate']='Utw&oacute;rz nowy szablon';
$lang['prompt_of']='z';
$lang['prompt_page']='Strona';
$lang['prompt_pagelimit']='Limit stron';
$lang['prompt_sorting']='Sortowanie';
$lang['prompt_template']='Źr&oacute;dło szablonu';
$lang['prompt_templatename']='Nazwa szablonu';
$lang['public']='Publiczna';
$lang['published']='Opublikowany';
$lang['reassign_category']='Zmień kategorię na';
$lang['removed']='Usunięte';
$lang['resettodefault']='Przywr&oacute;ć ustawienia fabryczne';
$lang['restoretodefaultsmsg']='Ta operacja przywr&oacute;ci zawartość szablon&oacute;w do ich domyślnej zawartości. Czy na pewno kontynuować?';
$lang['revert']='Zmień status na &quot;roboczy&quot;';
$lang['select']='Zaznacz';
$lang['selectcategory']='Wybierz kategorię';
$lang['showchildcategories']='Pokaż kategorie podrzędne';
$lang['sortascending']='Sortuj rosnąco';
$lang['startdate']='Data początkowa';
$lang['startdatetoolate']='Data rozpoczęcia jest nieprawidłowa (p&oacute;źniejsza niż data zakończenia?)';
$lang['startoffset']='Rozpocznij wyświetlanie od n-tego elementu';
$lang['startrequiresend']='Wprowadzenie daty początkowej wymaga także wprowadzenia daty końcowej';
$lang['status']='status';
$lang['status_asc']='Status rosnąco';
$lang['status_desc']='Status malejąco';
$lang['subject_newnews']='Nowy news został dodany';
$lang['submit']='Zatwierdź';
$lang['summary']='Podsumowanie';
$lang['summarytemplate']='Szablon podsumowania';
$lang['summarytemplateupdated']='Szablon szczeg&oacute;łowy został zaktualizowany.';
$lang['sysdefaults']='Przywr&oacute;ć domyślne';
$lang['template']='Szablon';
$lang['textarea']='Pole tekstowe (textarea)';
$lang['textbox']='Pole tekstowe';
$lang['title']='Tytuł';
$lang['title_asc']='Tytuł rosnąco';
$lang['title_available_templates']='Dostępne szablony';
$lang['title_browsecat_sysdefault']='Domyślny szablon Przeglądanie Kategorii';
$lang['title_browsecat_template']='Edytor szablon&oacute;w Przeglądanie Kategorii ';
$lang['title_desc']='Tytuł malejąco';
$lang['title_detail_returnid']='Domyślna strona dla widoku szczeg&oacute;łowego';
$lang['title_detail_settings']='Ustawienia widoku szczeg&oacute;łowego';
$lang['title_detail_sysdefault']='Domyślny szablon szczeg&oacute;łowy';
$lang['title_detail_template']='Edytor szablonu szczeg&oacute;łowego';
$lang['title_filter']='Filtry';
$lang['title_form_sysdefault']='Domyślny szablon formularza';
$lang['title_form_template']='Edytor szablonu formularza';
$lang['title_notification_settings']='Ustawienia powiadomień';
$lang['title_summary_sysdefault']='Domyślny szablon og&oacute;lny';
$lang['title_summary_template']='Edytor szablonu og&oacute;lnego';
$lang['type']='Typ';
$lang['unknown']='Nieznane';
$lang['unlimited']='Bez limitu';
$lang['up']='Do g&oacute;ry';
$lang['uploadscategory']='Kategoria Uploads';
$lang['useexpiration']='Użyj daty wygaśnięcia';
?>