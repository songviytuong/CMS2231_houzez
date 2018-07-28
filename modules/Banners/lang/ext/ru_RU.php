<?php
$lang['error_invalid_dates'] = 'Неверно введенная дата';
$lang['editbanner'] = 'Редактировать баннер';
$lang['start_date'] = 'Дата начала';
$lang['atttext'] = 'к';
$lang['template'] = 'Шаблон';
$lang['default_template'] = 'Шаблон категории по-умолчанию';
$lang['reset_template'] = 'Загрузить шаблон по-умолчанию';
$lang['error_banners'] = 'Нет баннеров';
$lang['error_bannerexists'] = 'Баннер с таким названием уже существует';
$lang['accessdenied'] = 'Доступ ограничен. Пожалуйста проверьте ваши права.';
$lang['addbanner'] = 'Добавить баннер';
$lang['addcategory'] = 'Добавить категорию';
$lang['areyousure'] = 'Вы уверены?';
$lang['banners'] = 'Баннеры';
$lang['cancel'] = 'Отмена';
$lang['categories'] = 'Категории';
$lang['category'] = 'Категория';
$lang['created'] = 'Создано';
$lang['date'] = 'Дата';
$lang['delete'] = 'Удалить';
$lang['description'] = 'Описание';
$lang['edit'] = 'Редактирование';
$lang['editcategory'] = 'Редактировать категорию';
$lang['error'] = 'Ошибка!';
$lang['error_banerexists'] = 'Баннер с таким именем уже существует';
$lang['error_categorynotempty'] = 'Ошибка: Категория не пуста!';
$lang['error_dberror'] = 'Ошибка: Ошибка базы данных!';
$lang['error_emptybannername'] = 'Ошибка: Пустое имя баннера!';
$lang['error_emptycategory'] = 'Ошибка: Пустая категория!';
$lang['error_insufficientparams'] = 'Ошибка: Недостаточный ввод';
$lang['error_nocategories'] = 'Ошибка: Не найдена категория';
$lang['error_noresults'] = 'Нет баннеров соответствующих запросу';
$lang['error_textorimage'] = 'Определите URL и ИЗОБРАЖЕНИЕ или ТЕКСТ, но не оба';
$lang['expires'] = 'Истекает';
$lang['friendlyname'] = 'Управление баннерами';
$lang['height'] = 'Высота';
$lang['hits'] = 'Хиты';
$lang['href_text'] = 'Текстовая ссылка';
$lang['id'] = 'ID';
$lang['image'] = 'Изображение';
$lang['image_text'] = 'Alt текст к изображению';
$lang['impressions'] = 'Показы';
$lang['info_href_text'] = 'Дополнительный текст в тег ссылки. Этот текст помещается в тег ссылки дословно';
$lang['info_image'] = 'Укажите файл относительно вашего каталога загрузок';
$lang['info_image_text'] = 'Дополнительный текст в тег изображения';
$lang['info_max_hits'] = 'Используйте 0 для неограниченных хитов';
$lang['info_max_impressions'] = 'Используйте 0 для неограниченных показов';
$lang['installed'] = 'Модуль версии %s установлен.';
$lang['ipaddress'] = 'IP адрес';
$lang['max_hits'] = 'Максимум хитов';
$lang['max_impressions'] = 'Максимум показов';
$lang['name'] = 'Название';
$lang['never'] = 'Никогда';
$lang['postinstall'] = 'Отправить почтовое сообщение, например, Не забудьте установить "Manage Banners" разрешения на использование этого модуля!';
$lang['postuninstall'] = 'Модуль баннеров удалён, и все таблицы базы данных удалены. Жаль раставаться."';
$lang['preferences'] = 'Настройки';
$lang['prefsupdated'] = 'Настройки модуля обновлены.';
$lang['prompt_categorydesc'] = 'Описание категории';
$lang['prompt_categoryname'] = 'Название категории';
$lang['prompt_imageheight'] = 'Высота изображения';
$lang['prompt_imagewidth'] = 'Ширина изображения';
$lang['prompt_subnet_exclusions'] = 'Исключение этих подсетей из любого сбора статистики';
$lang['prompt_upload_category'] = 'Категория (модуль Uploads)';
$lang['prompt_upload_file'] = 'Изображение (модуль Uploads)';
$lang['selectcategory'] = 'Выберите категорию';
$lang['submit'] = 'Отправить';
$lang['text'] = 'Текст';
$lang['title_mod_admin'] = 'Админ панель модуля';
$lang['title_mod_prefs'] = 'Настройки модуля';
$lang['uninstalled'] = 'Модуль деинсталлирован.';
$lang['upgraded'] = 'Модуль обновлён до версии %s.';
$lang['url'] = 'URL';
$lang['width'] = 'Ширина';
$lang['title_admin_panel'] = 'Модуль баннеров';
$lang['moddescription'] = 'Модуль для управления ротацией баннеров';
$lang['welcome_text'] = '<p>Welcome to the Banner Management Module admin section. Something else would probably go here if the module actually did something.</p>';
$lang['changelog'] = '<ul>
<li>Version 1.0. 6 August 2005. Initial Release.</li>
<li>Version 2.0. September 2005. Initial Release for 0.1..</li>
<li>Version 2.0.1. September 2005. Display sample banner in the edit banner page, added name= parameter, and made subnet exclusions work.  Also changed the definition of the database to allow for additional text in the link and image tags.</li>
<li>Version 2.0.2. September 2005. Added integration with the uploads module (1.0.6) so that we can get lits of files for banners, etc.  The banners module is still optional though.</li>
<li>Version 2.0.3. September 2005. Fixed a very minor issue with never expires..</li>
<li>Version 2.0.4. September 2005. Fixed a very minor issue with module dependencies, and a big bug in the database spec if you did a scratch install.</li>
<li>Version 2.0.5. October 2005. Add coments around the output</li>
<li>Version 2.0.6. December 2005. Minor validation fixes, description is now output between the <img>and</img> tags, and an alt attribute is in the img tag.</li>
<li>Version 2.0.7. January 2006. More validation fixes, Moved the admin tabs around, fixed an issue where you could almost create a banner without defining a category, and... fixed the expiry date issue for good (hopefully).</li>
<li>Version 2.1.0. August 2006. Prepared for 1.0 compatibility, split into multiple files, used references where possible, improved messages, and a general cleanup.</li>
<li>Version 2.2. March 2008. 
    <p>The first release in a long while this fixes issues with the date fields, and the expiry date.  Also integrates changes so that the active tab is maintaned (DeeEye) and changes the license.</p>
    <p>Now require CMS 1.2.3 or greater</p>
</li>
<li>Version 2.2.1. April 2008.
    <p>Minor fixes.</p>
</li>
</ul>';
$lang['help'] = '<h3>What Does This Do?</h3>
<p>This banner manages numerous categories of banners, tracks hits, impressions, and expiry dates, and randomly selects from all available and valid banners for one to display</p>
<h3>How Do I Use It</h3>
<p>To use this module, place the module code in a page or template using the smarty tag {Banners category="categoryname"}</p> 
<p>You must also upload banners to a suitable directory within the uploads directory and must use the admin panel interface to add banners to the database.</p
<h3>Parameters</h3>
<ul>
<li><em>(REQUIRED)</em> category="category" = randomly select from all available in this category</li>
<li><em>(optional)</em> name="name" = select only the banner with this name</li>
<li><em>(optional)</em> mode="sequential" = Instead of randomly selecting a valid banner, select the one with the least impressions.</li>
</ul>
<h4>Hint</h4>
<p>The uploads module and the banners module work well together.  You can create a "banners" category in the uploads module, and upload your banner images there, then specify "banners/<filename>" when adding a banner in the banners module.</p>
<h3>Support</h3>
<p>This module does not include commercial support. However, there are a number of resources available to help you with it:</p>
<ul>
<li>For the latest version of this module, FAQs, or to file a Bug Report or buy commercial support, please visit calguy\'s
module homepage at <a href="http://techcom.dyndns.org">techcom.dyndns.org</a>.</li>
<li>Additional discussion of this module may also be found in the <a href="http://forum.cmsmadesimple.org">CMS Made Simple Forums</a>.</li>
<li>The author, calguy1000, can often be found in the <a href="irc://irc.freenode.net/#cms">CMS IRC Channel</a>.</li>
<li>Lastly, you may have some success emailing the author directly.</li>  
</ul>
<h3>Copyright and License</h3>
<p>Copyright © 2008, Robert Campbel <a href="mailto:calguy1000@cmsmadesimple.org"><calguy1000@cmsmadesimple.org></a>. All Rights Are Reserved.</p>
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
$lang['utma'] = '156861353.1176733453.1235081356.1243070135.1243105518.58';
$lang['utmz'] = '156861353.1243070135.57.12.utmcsr=google.de|utmccn=(referral)|utmcmd=referral|utmcct=/';
$lang['utmc'] = '156861353';
$lang['utmb'] = '156861353.1.10.1243105518';
?>