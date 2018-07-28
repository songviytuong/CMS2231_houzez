<?php
$lang['addarticle']='Добавить новость';
$lang['addcategory']='Добавить категорию';
$lang['addfielddef']='Добавить определение поля';
$lang['addnewsitem']='Добавить статью';
$lang['allcategories']='Все категории';
$lang['allentries']='Все новости';
$lang['allow_summary_wysiwyg']='Разрешить использование визуального редактора для резюме';
$lang['allowed_upload_types']='Разрешить для загрузки только файлы с этими расширениями';
$lang['anonymous']='Анонимный';
$lang['apply']='Применить';
$lang['approve']='Установить статус \'Опубликовано\'';
$lang['areyousure']='Вы действительно хотите это удалить?';
$lang['areyousure_deletemultiple']='Вы уверены, что хотите удалить все эти новости?\nЭто действие не может быть отменено!';
$lang['article']='Статья';
$lang['articleadded']='Новость успешно добавлена.';
$lang['articledeleted']='Новость успешно удалена.';
$lang['articles']='Новости';
$lang['articleupdated']='Новость успешно обновлена.';
$lang['author']='Автор';
$lang['author_label']='Разместил:';
$lang['auto_create_thumbnails']='Автоматически создать эскиз файлов для файлов с этими расширениями';
$lang['browsecattemplate']='Обзор категории шаблонов';
$lang['cancel']='Отмена';
$lang['categories']='Категории';
$lang['category']='Категория';
$lang['category_label']='Категория:';
$lang['categoryadded']='Категория успешно добавлена.';
$lang['categorydeleted']='Категория успешно удалена.';
$lang['categoryupdated']='Категория успешно обновлена.';
$lang['checkbox']='Флажок';
$lang['content']='Полный текст';
$lang['customfields']='Определения поля';
$lang['dateformat']='%s - неверный формат даты yyyy-mm-dd hh:mm:ss';
$lang['default_category']='Категория по умолчанию';
$lang['default_templates']='Шаблон по умолчанию';
$lang['delete']='Удалить';
$lang['delete_selected']='Удалить выбранные новости';
$lang['deprecated']='неподдерживается';
$lang['description']='Добавление, редактирование и удаление новостей';
$lang['detail_page']='Страница подробностей';
$lang['detail_template']='Шаблон подробностей';
$lang['detailtemplate']='Шаблон для полного текста новости';
$lang['detailtemplateupdated']='Обновленный шаблон для полного текста новости успешно сохранен в базе данных.';
$lang['displaytemplate']='Шаблон для списка';
$lang['down']='Вниз';
$lang['draft']='Черновик';
$lang['edit']='Редактировать';
$lang['editfielddef']='Редактировать определение поля';
$lang['email_subject']='Тема из исходящего сообщения';
$lang['email_template']='Формат сообщения электронной почты';
$lang['enddate']='Дата окончания';
$lang['endrequiresstart']='Ввод даты окончания требует ввода даты начала';
$lang['entries']='%s материалов';
$lang['error_duplicatename']='Элемент с таким именем уже есть';
$lang['error_filesize']='Загруженный файл превысил максимально разрешённый размер';
$lang['error_insufficientparams']='Не заданы значения обязательных параметров (либо заданы пустые значения)';
$lang['error_invaliddates']='Одна или несколько дат введены неверно';
$lang['error_invalidfiletype']='Не удается загрузить этот тип файла';
$lang['error_invalidurl']='Неверная ссылка <em>(возможно, уже используется или содержит запрещенные символы)</em>';
$lang['error_mkdir']='Не удалось создать каталог: %s';
$lang['error_movefile']='Не удалось создать файл: %s';
$lang['error_noarticlesselected']='Нет выбранных новостей';
$lang['error_templatenamexists']='Шаблон с этим именем уже существует';
$lang['error_upload']='Произошла проблема при загрузке файла';
$lang['eventdesc-NewsArticleAdded']='Отправляется, когда статья добавлена.';
$lang['eventdesc-NewsArticleDeleted']='Отправляется, когда статья была удалена.';
$lang['eventdesc-NewsArticleEdited']='Отправляется, когда статья отредактирована.';
$lang['eventdesc-NewsCategoryAdded']='Отправляется, когда категория добавлена.';
$lang['eventdesc-NewsCategoryDeleted']='Отправляется, когда категория удалена.';
$lang['eventdesc-NewsCategoryEdited']='Отправляется, когда категория отредактирована.';
$lang['eventhelp-NewsArticleAdded']='<p>Отправляется, когда статья добавлена.</p>
<h4>Параметры</h4>
<ul>
<li>\"news_id\" - Id новостной статьи</li>
<li>\"category_id\" - Id категории для этой статьи</li>
<li>\"title\" - Заголовок статьи</li>
<li>\"content\" - Content of the article</li>
<li>\"summary\" - Summary of the article</li>
<li>\"status\" - Status of the article ("draft" or "publish")</li>
<li>\"start_time\" - Дата публикации статьи</li>
<li>\"end_time\" - Дата окончания публикации статьи</li>
<li>\"useexp\" - Должно ли истечение срока быть проигнорировано</li>
</ul>
';
$lang['eventhelp-NewsArticleDeleted']='<p>Отправляется, когда статья была удалена.</p>
<h4>Параметры</h4>
<ul>
<li>\"news_id\" - Id новостной статьи</li>
</ul>
';
$lang['eventhelp-NewsArticleEdited']='<p>Отправляется, когда статья отредактирована.</p>
<h4>Параметры</h4>
<ul>
<li>\"news_id\" - Id of the news article</li>
<li>\"category_id\" - Id категории для этой статьи</li>
<li>\"title\" - Заголовок статьи</li>
<li>\"content\" - Содержание статьи</li>
<li>\"summary\" - Резюме статьи</li>
<li>\"status\" - Статус статьи ("draft" или "publish")</li>
<li>\"start_time\" - Дата публикации статьи</li>
<li>\"end_time\" - Дата окончания публикации статьи</li>
<li>\"useexp\" - Должно ли истечение срока быть проигнорировано</li>
</ul>
';
$lang['eventhelp-NewsCategoryAdded']='<p>Отправляется, когда категория была добавлена.</p>
<h4>Параметры</h4>
<ul>
<li>\"category_id\" - Id новостной категории</li>
<li>\"name\" - Имя новостной категории</li>
</ul>
';
$lang['eventhelp-NewsCategoryDeleted']='<p>Отправлется, когда категория удалена.</p>
<h4>Параметры</h4>
<ul>
<li>\"category_id\" - Id удаленной категории </li>
<li>\"name\" - Имя удаленной категории</li>
</ul>
';
$lang['eventhelp-NewsCategoryEdited']='<p>Отправляется, когда категория отредактирована.</p>
<h4>Параметры</h4>
<ul>
<li>\"category_id\" - IId новостной категории</li>
<li>\"name\" - Имя новостной категории</li>
<li>\"origname\" - Исходное  имя новостной категории</li>
</ul>
';
$lang['expired']='Истекает';
$lang['expired_searchable']='Новости могут появляться в результатах поиска, независимо от даты окончания';
$lang['expired_viewable']='Истекшие статьи можно посмотреть в подробном виде';
$lang['expiry']='Истекает';
$lang['expiry_date_asc']='Дате окончания (Истекшие вверху)';
$lang['expiry_date_desc']='Дате окончания (Истекшие внизу)';
$lang['expiry_interval']='Число дней (по умолчанию) до истечения срока действия новости (если выбран срок истечения)';
$lang['extra']='Экстра';
$lang['extra_label']='Дополнительно:';
$lang['fesubmit_redirect']='ID страницы или алиас для переброса пользователя после добавления новости через форму на сайте';
$lang['fesubmit_status']='Статус новостей представленных через интерфейс';
$lang['fielddef']='Определение поля';
$lang['fielddefadded']='Определение поля успешно добавлено';
$lang['fielddefdeleted']='Определение поля удалено';
$lang['fielddefupdated']='Определение поля обновлено';
$lang['file']='Файл';
$lang['filter']='Фильтр';
$lang['firstpage']='<<';
$lang['formsubmit_emailaddress']='Адрес электронной почты, чтобы получить уведомление о представлении новостей';
$lang['formtemplate']='Шаблоны форм';
$lang['help']='<h3>Important Notes</h3>
<p>Version 2.9 and greater of News has removed the formatpostdate member from the templates, and has also removed the dateformat parameter.  You should be using the cms_date_format modifier (as indicated in the default templates) to format dates, and should be using entry->postdate instead of entry->formatpostdate in your templates.</p>
<h3>What does this do?</h3>
<p>News is a module for displaying news events on your page, similar to a blog style, except with more features!.  When the module is installed, a News admin page is added to administration menu that will allow you to select or add a news category.  Once a news category is created or selected, a list of news items for that category will be displayed.  From here, you can add, edit or delete news items for that category.</p>
<h4>Numerous display methods</h4>
<p>The parameters supported by the news module, and support for numerous templates of each time mean that your options for displaying news articles are limitless.</p>
<h4>Custom Fields</h4>
<p>The News module allows defining numerous custom fields (including files and images) that will allow you to attach pdf files or numerous images to your articles.</p>
        <h4>Categories</h4>
	<p>News supplies a hierarchical category mechanism for organizing your articles.  A news article can only be in one place in the hierarchy.</p>
        <h4>RSS Feeds</h4>
        <p>News supports generating simple rss feeds from your news articles, so that your visitors can always be up to date with what is happening on your site.</p>
	<h4>Expiry and Status</h4>
	<p>Each news article can have an optional expiry date, after which it will not be shown on your web page.  As well, articles can be marked as <em>draft</em> to remove them permanently from your web page.</p>
	<h3>Security</h3>
	<p>The user must belong to a group with the \'Modify News\' permission in order to add or edit News entries.</p>
        <p>As well, In order to delete news entries, the user must belong to a group with the \'Delete News Articles\' permission.</p>
	<p>In order to edit the layout templates, the user must belong to a group with the \'Modify Templates\' permission.</p>
	<p>In order to edit the global news preferences, the user must belong to a group with the \'Modify Site Preferences\' permission.</p>
	<p>Additionally, to approve news for frontend display the user must belong to a group with the \'Approve News\' permission.</p>
	<h3>How do I use it?</h3>
	<p>The easiest way to use it is with the {news} wrapper tag (wraps the module in a tag, to simplify the syntax).  This will insert the module into your template or page anywhere you wish, and display news items.  The code would look something like: <code>{news number=\'5\'}</code></p>
<h3>Templates</h3>
<p>Since version 2.3 News supports multiple database templates, and no longer supports additional file templates.  Users who used the old file template system should follow these steps (for each file template):</p>
<ul>
<li>Copy the file template into the clipboard</li>
<li>Create a new database template <em>(either summary or detailed as required)</em>.  Give the new template the same name (including the .tpl extension) as the old file template, and paste the contents.</li>
<li>Hit Submit</li>
</ul>
<p>Following these steps should solve the problem of your news templates not being found and other similar smarty errors when you upgrade to a version of CMS that has News 2.3 or greater.</p>';
$lang['help_articleid']='Этот параметр применяется только для подробного просмотра. Это позволяет указать, какие статьи новостей на дисплее в режиме "подробно". Если специальное значение -1 используется, то система будет показывать новейшую опубликованную, не истекшую статью.';
$lang['help_pagelimit']='Максимальное число элементов для отображения (на странице). Если этот параметр не будет указан, то будут отображены все соответствующие элементы. Если будет указан, и есть больше доступных элементов, чем указанно в параметре, то будет ставиться текст и ссылки, чтобы позволить просматривать результаты';
$lang['helpaction']='Отменяет действие значения по умолчанию. Возможные значения - \'default\', чтобы отобразить резюме, и \'fesubmit\', чтобы отобразить форму внешнего интерфейса для того, чтобы позволить пользователям представлять статьи новостей из фронтенда.';
$lang['helpbrowsecat']='Показывает список категорий.';
$lang['helpbrowsecattemplate']='Используйте шаблон базы данных чтобы отобразить браузер категории. Этот шаблон должен существовать и быть видимым во вкладке Browse Category Templates администрации новостей, хотя это не должно быть значением по умолчанию. Если этот параметр не определен, то будет использоваться текущий шаблон, отмеченный как значение.';
$lang['helpcategory']='Отображать только объекты данной категории. <b>Необходимо использовать * после имени, чтобы показать дочерние объекты.</b> чтобы ввести несколько категорий, их нужно разделить запятыми. В случае незаполнения, будет показывать все категории.';
$lang['helpdetailpage']='Страница для отображения полного текста новостного сообщения. Это может быть либо идентификатор страницы, либо алиас. Используется для отображения полного текста новостного сообщения с помощью шаблона, отличного от используемого в краткой сводке.';
$lang['helpdetailtemplate']='Использование отдельной базы данных шаблонов для подробного отображения статьи. Этот шаблон должен существовать и быть видимым в деталях шаблона на вкладке новостей администратора, но он не должен быть включен по умолчанию. Если этот параметр не указан, то будет использоваться текущий шаблон с пометкой умолчанию.';
$lang['helpformtemplate']='Используйте шаблон базы данных чтобы отобразить форму представления статьи. Этот шаблон должен существовать и быть видимым во вкладке шаблонов формы администрации новостей, хотя это не должно быть значением по умолчанию. Если этот параметр не определен, то будет использоваться текущий шаблон, отмеченный как значение по умолчанию.';
$lang['helpmoretext']='Текст, отображаемый в конце новостного объекта если он превышает длину резюме. По умолчанию "more..."';
$lang['helpnumber']='Максимальное число отображаемых элементов =- в случае незаполнения будет показывать все объекты.';
$lang['helpshowall']='Показать все новости, независимо от даты окончания';
$lang['helpshowarchive']='Показывать только статьи с истекшим сроком.';
$lang['helpsortasc']='Сортировать статьи по возрастанию даты, а не по убыванию.';
$lang['helpsortby']='Поле для сортировки. Варианты: "news_date", "summary", "news_data", "news_category", "news_title", "news_extra", "end_time", "start_time", "random". По умолчанию это "news_date". Если "random", то предполагается, что в sortasc параметр игнорируется.';
$lang['helpstart']='Начать с n-го объекта -- в случае незаполнения будет начинать с первого объекта.';
$lang['helpsummarytemplate']='Использовать отдельный шаблон для отображения резюме. Он должен быть расположен в папке modules/News/templates.';
$lang['hide_summary_field']='Скрыть поле резюме при добавлении или редактировании новостей';
$lang['info_detail_returnid']='Этот параметр используется для назначания страницы (и соотвествнно шаблона), в которой будет показываться полный текст новости. Альтернативные ссылки на новостт не будут работать, если этот параметр не установлен. Также, если этот параметр установлен и тег {news} используется без параметра detailpage, то это значение будет использовано по умолчанию.';
$lang['info_maxlength']='Максимальная длина применяется только для полей ввода текста.';
$lang['info_sysdefault']='<em>(шаблон используется по умолчанию, когда выбирается новый шаблон)</em>';
$lang['info_sysdefault2']='<strong> Примечание:</strong> Эта вкладка содержит текстовые области, чтобы позволить Вам редактировать набор шаблонов, которые отображены, когда Вы создаете \'new\' резюме, подробно, или шаблон формы. Измените содержание в этой вкладке, и щелкните \'Отправить\' будет <strong> не влияет на любые текущие экраны</strong>.';
$lang['lastpage']='>>';
$lang['maxlength']='Максимальная длина';
$lang['more']='Подробнее';
$lang['moretext']='Текст для подробнее';
$lang['msg_contenttype_removed']='Тип содержания новостей был удален. Пожалуйста поместите {news} теги с соответствующими параметрами в ваш шаблон страницы или в ваше содержание страницы, чтобы заменить эти функциональные возможности.';
$lang['name']='Имя';
$lang['nameexists']='Поле с таким именем уже существует';
$lang['needpermission']='Вам нужны права \'%s\' для совершения этого действия.';
$lang['newcategory']='Новая категория';
$lang['news']='Новости';
$lang['news_return']='Вернуться';
$lang['nextpage']='>';
$lang['nocategorygiven']='Не задана категория';
$lang['nocontentgiven']='Не задан полный текст';
$lang['noitemsfound']='<strong>Нет</strong> элементов в этой категории: %s';
$lang['nonamegiven']='Не задано имя';
$lang['none']='Нет';
$lang['nopostdategiven']='Не введена дата публикации';
$lang['notanumber']='Максимальная длина не является не числом';
$lang['note']='<em>Примечание:</em> Даты должны быть в формате \'yyyy-mm-dd hh:mm:ss\'.';
$lang['notify_n_draft_items']='У вас есть не опубликованые новости, всего %s';
$lang['notify_n_draft_items_sub']='%d новостных статей';
$lang['notitlegiven']='Не задан заголовок';
$lang['numbertodisplay']='Количество для показа (если не задано, то выводит все)';
$lang['options']='Опции';
$lang['optionsupdated']='Опции были успешно обновлены.';
$lang['post_date_asc']='Дате (Новые ввнизу)';
$lang['post_date_desc']='Дате (Новые вверху)';
$lang['postdate']='Дата публикации';
$lang['postinstall']='Убедитесь, что вы установили права "Modify News" для тех пользователей, кто должен администрировать материалы.';
$lang['preview']='Предпросмотр';
$lang['prevpage']='<';
$lang['print']='Печать';
$lang['prompt_default']='По умолчанию';
$lang['prompt_name']='Имя';
$lang['prompt_newtemplate']='Создать новый шаблон';
$lang['prompt_of']='из';
$lang['prompt_page']='Страница';
$lang['prompt_pagelimit']='Новостей на страницу';
$lang['prompt_sorting']='Сортировать по';
$lang['prompt_template']='Исходные данные шаблона';
$lang['prompt_templatename']='Имя шаблона';
$lang['public']='Общий';
$lang['published']='Опубликовано';
$lang['reassign_category']='Сменить категорию на';
$lang['removed']='Удалено';
$lang['resettodefault']='Сбросить установки';
$lang['restoretodefaultsmsg']='Эта операция восстановит содержание шаблонов к изначальному. Продолжить?';
$lang['revert']='Установить статус \'Черновик\'';
$lang['select']='Выбрать';
$lang['selectcategory']='Выберите категорию';
$lang['showchildcategories']='Показывать подкатегории';
$lang['sortascending']='Сортировать по возрастанию';
$lang['startdate']='Дата начала';
$lang['startdatetoolate']='Дата начала слишком поздняя (после даты окончания?)';
$lang['startoffset']='Начать вывод новостей с n-ой';
$lang['startrequiresend']='Ввод даты начала требует ввода даты окончания';
$lang['status']='Статус';
$lang['status_asc']='Статус (от А до Я)';
$lang['status_desc']='Статусу (от Я до А)';
$lang['subject_newnews']='Новость была размещена';
$lang['submit']='Отправить';
$lang['summary']='Резюме';
$lang['summarytemplate']='Шаблон для резюме';
$lang['summarytemplateupdated']='Шаблон для резюме был успешно обновлен.';
$lang['sysdefaults']='Восстановить значения по умолчанию';
$lang['template']='Шаблон';
$lang['textarea']='Текстовая область';
$lang['textbox']='Ввод текста';
$lang['title']='Заголовок';
$lang['title_asc']='Заголовку (от А до Я)';
$lang['title_available_templates']='Доступные шаблоны';
$lang['title_browsecat_sysdefault']='Обзор по умолчанию категории шаблона';
$lang['title_browsecat_template']='Просмотр категории редактора шаблонов';
$lang['title_desc']='Заголовку (от Я до А)';
$lang['title_detail_returnid']='Страница по умолчанию для полного текста новости';
$lang['title_detail_settings']='Настройки показа полного текста новости';
$lang['title_detail_sysdefault']='Шаблон полный текст по умолчанию';
$lang['title_detail_template']='Редактор шаблона полный текст';
$lang['title_fesubmit_settings']='Настройки добавления новостей пользователями';
$lang['title_filter']='Фильтр';
$lang['title_form_sysdefault']='Форма шаблона по умолчанию';
$lang['title_form_template']='Редактор форм шаблонов';
$lang['title_notification_settings']='Настройки уведомлений';
$lang['title_submission_settings']='Настройки добавления новостей';
$lang['title_summary_sysdefault']='Шаблон резюме по умолчанию';
$lang['title_summary_template']='Редактор шаблона резюме';
$lang['type']='Тип';
$lang['unknown']='Неизвестно';
$lang['unlimited']='Неограничено';
$lang['up']='Вверх';
$lang['uploadscategory']='Загрузка файлов';
$lang['url']='Ссылка';
$lang['useexpiration']='Использовать дату окончания';
$lang['warning_preview']='Предупреждение: Данная панель предпросмотра во многом подобна полноценному браузеру и позволяет покинуть стартовую страницу, перейдя по размещённым на ней ссылкам. Однако, после этого Вы можете столкнуться с неожиданным поведением. Покинув стартовую страницу и затем вернувшись, Вы можете не получить ожидаемого результата.<br/><strong>Примечание:</strong> Окно предпросмотра позволяет выбрать файлы для загрузки, но не выполняет загрузку.';
?>
