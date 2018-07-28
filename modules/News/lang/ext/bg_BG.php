<?php
$lang['addarticle']='Прибавя статия';
$lang['addcategory']='Прибавя категория';
$lang['addnewsitem']='Прибавя новина';
$lang['allcategories']='Всички категории';
$lang['allentries']='Всички статии';
$lang['areyousure']='Сигурни ли сте че искате да изтриете?';
$lang['areyousure_deletemultiple']='Are you sure you want to delete all of these news articles?\nThis action cannot be undone!';
$lang['articleadded']='Статията беше добавена.';
$lang['articles']='Статии';
$lang['author']='Автор';
$lang['author_label']='Публикувано от:';
$lang['cancel']='Отказ';
$lang['categories']='Категории';
$lang['category']='Категория';
$lang['category_label']='Категория:';
$lang['categoryadded']='Категорията беше успешно добавена.';
$lang['categoryupdated']='Категорията беше успешно обновена.';
$lang['content']='Съдържание';
$lang['dateformat']='%s не във валидния yyyy-mm-dd hh:mm:ss формат';
$lang['default_category']='Категория по подразбиране';
$lang['default_templates']='Шаблони по подразбиране';
$lang['delete']='Изтрива';
$lang['description']='Прибавя, редактира и премахва новини';
$lang['detailtemplate']='Шаблон за детайли';
$lang['detailtemplateupdated']='Обновеният Шаблон за детайли беше успешно записан в базата данни.';
$lang['displaytemplate']='Шаблон за бърз преглед';
$lang['edit']='Редактира';
$lang['enddate']='Крайна дата';
$lang['endrequiresstart']='Въвеждането на крайна дата изисква и начална такава';
$lang['entries']='%s новини';
$lang['eventhelp-NewsArticleAdded']='<p>Sent when an article is added.</p>
<h4>Parameters</h4>
<ul>
<li>\"news_id\" - Id of the news article</li>
<li>\"category_id\" - Id of the category for this article</li>
<li>\"title\" - Title of the article</li>
<li>\"content\" - Content of the article</li>
<li>\"summary\" - Summary of the article</li>
<li>\"status\" - Status of the article ("draft" or "publish")</li>
<li>\"start_time\" - Date the article should start being displayed</li>
<li>\"end_time\" - Date the article should stop being displayed</li>
</ul>
';
$lang['eventhelp-NewsArticleDeleted']='<p>Sent when an article is deleted.</p>
<h4>Parameters</h4>
<ul>
<li>\"news_id\" - Id of the news article</li>
</ul>
';
$lang['eventhelp-NewsArticleEdited']='<p>Sent when an article is edited.</p>
<h4>Parameters</h4>
<ul>
<li>\"news_id\" - Id of the news article</li>
<li>\"category_id\" - Id of the category for this article</li>
<li>\"title\" - Title of the article</li>
<li>\"content\" - Content of the article</li>
<li>\"summary\" - Summary of the article</li>
<li>\"status\" - Status of the article ("draft" or "publish")</li>
<li>\"start_time\" - Date the article should start being displayed</li>
<li>\"end_time\" - Date the article should stop being displayed</li>
</ul>
';
$lang['eventhelp-NewsCategoryAdded']='<p>Sent when a category is added.</p>
<h4>Parameters</h4>
<ul>
<li>\"category_id\" - Id of the news categpry</li>
<li>\"name\" - Name of the news category</li>
</ul>
';
$lang['eventhelp-NewsCategoryDeleted']='<p>Sent when a category is deleted.</p>
<h4>Parameters</h4>
<ul>
<li>\"category_id\" - Id of the news categpry</li>
</ul>
';
$lang['eventhelp-NewsCategoryEdited']='<p>Sent when a category is edited.</p>
<h4>Parameters</h4>
<ul>
<li>\"category_id\" - Id of the news categpry</li>
<li>\"name\" - Name of the news category</li>
</ul>
';
$lang['expiry']='Изтича';
$lang['filter']='Филтер';
$lang['firstpage']='<<';
$lang['formtemplate']='Шаблони за форми';
$lang['help']='	<h3>What does this do?</h3>
	<p>News is a module for displaying news events on your page, similar to a blog style, except with more features!.  When the module is installed, a News admin page is added to administration menu that will allow you to select or add a news category.  Once a news category is created or selected, a list of news items for that category will be displayed.  From here, you can add, edit or delete news items for that category.</p>
	<h3>Security</h3>
	<p>The user must belong to a group with the \'Modify News\' permission in order to add, edit, or delete News entries.</p>
	<h3>How do I use it?</h3>
	<p>The easiest way to use it is in conjunction with the cms_module tag.  This will insert the module into your template or page anywhere you wish, and display news items.  The code would look something like: <code>{cms_module module="news" number="5" category="beer"}</code></p>';
$lang['helpaction']='Override the default action.  Possible values are:
<ul>
<li>"detail" - to display a specified articleid in detail mode.</li>
<li>"default" - to display the summary view</li>
<li>"fesubmit" - to display the frontend form for allowing users to submit news articles on the front end.</li>
<li>"browsecat" - to display a browseable category list.</li>
</ul>';
$lang['helpcategory']='Показва само новините в тази категория. Използва * след името за да покаже подкатегориите. Множествени категории могат да се използват разделени чрез запейтаки. Оставяйки празно, показва всички категории.';
$lang['helpdetailpage']='Страница където да показва детайлите за новина. Тази страница може да бъде или псевдоним или id. Използва се за да може цялата новина да се покаже в различен шаблон от този за резюмето.';
$lang['helpdetailtemplate']='Използва отделен шаблон за визуализиране на детайлното показване на новината. Може да се намери в /modules/News/templates.';
$lang['helpmoretext']='Текст за визуализиране накрая на всяка новина ако текстта на резюмето й е по-дълъг. По подразбиране "прочети повече..."';
$lang['helpnumber']='Максимален брой статии за покзване =- оставяйки празно показва всички.';
$lang['helpsortasc']='Сортира в ред абв а не в яюь.';
$lang['helpsortby']='Поле по което да се сортира. Възможности: "news_date", "summary", "news_data", "news_category", "news_title". По подразбиране е "news_date". ';
$lang['helpstart']='Показване от nтата статия -- оставяйки празно ще започне от първата статия.';
$lang['helpsummarytemplate']='Използва отделен шаблон за визуализиране на резюмето на новината. Може да се намери в /modules/News/templates.';
$lang['info_sysdefault']='<em>(the content used by default when a new template is created)</em>';
$lang['lastpage']='>>';
$lang['more']='Повече';
$lang['moretext']='Прочете повече';
$lang['name']='Име';
$lang['needpermission']='Необходими са ви \'%s\' права за изпълнение на тази функция.';
$lang['newcategory']='Нова категория';
$lang['news']='Новини';
$lang['news_return']='Връща';
$lang['nextpage']='>';
$lang['nocategorygiven']='Няма зададена категория';
$lang['nocontentgiven']='Няма зададено съдържание';
$lang['noitemsfound']='<strong>Няма</strong> намерени записи за категорията: %s';
$lang['nonamegiven']='Не е зададено име';
$lang['nopostdategiven']='Няма зададена дата';
$lang['note']='<em>Бележки:</em> Датите трябва да са в \'yyyy-mm-dd hh:mm:ss\' формат.';
$lang['notitlegiven']='Няма зададено заглавие';
$lang['numbertodisplay']='Брой статии за показване (ако е оставено празно показва всички)';
$lang['options']='Опции';
$lang['optionsupdated']='Опциите бяха успешно обновени.';
$lang['postdate']='Дата на публикуване';
$lang['postinstall']='Уверете се че правото "Промяна на Новини" е избрано за потребителите които ще администрират новините.';
$lang['prevpage']='<';
$lang['print']='Печат';
$lang['restoretodefaultsmsg']='Тази операция връща шаблоните към техните фабрични настройки. Сигурни ли сте че искате да продължите?';
$lang['selectcategory']='Избира категория';
$lang['showchildcategories']='Показва подкатегории';
$lang['sortascending']='Сортира абв';
$lang['startdate']='Начална дата';
$lang['startoffset']='Започва да показва на n-тата статия';
$lang['startrequiresend']='Въвеждането на начална дата изисква и крайна такава';
$lang['status']='Статус';
$lang['submit']='Въвежда';
$lang['summary']='Резюме';
$lang['summarytemplate']='Шаблон за резюме';
$lang['sysdefaults']='Връща фабричните настройки';
$lang['title']='Заглавие';
$lang['useexpiration']='Използва крайна дата';
?>
