<?php
$lang['addarticle']='הוסף מאמר';
$lang['addcategory']='הוסף מדור';
$lang['addfielddef']='הוסף הגדרת שדה';
$lang['addnewsitem']='הוסף ידיעה';
$lang['allcategories']='כל המדורים';
$lang['allentries']='כל החדשות';
$lang['allow_summary_wysiwyg']='אפשר באמצעות עורך "וויזיוויג" על המגרש סיכום';
$lang['allowed_upload_types']='אפשר רק קבצים עם סיומות אלו להיות נטען';
$lang['anonymous']='אלמוני';
$lang['approve']='סטטוס הגדר "פורסם"';
$lang['areyousure']='האם למחוק לצמיתות?';
$lang['areyousure_deletemultiple']='האם אתה בטוח שאתה רוצה למחוק את כל אלה כתבות?\nפעולה זו לא ניתן לבטל!';
$lang['articleadded']='המאמר נוסף בהצלחה.';
$lang['articledeleted']='המאמר נמחק בהצלחה';
$lang['articles']='מאמרים';
$lang['articleupdated']='המאמר עודכן בהצלחה.';
$lang['author']='מחבר';
$lang['author_label']='נשלח ע"י:';
$lang['auto_create_thumbnails']='יצירה אוטומטית של קבצי התמונות של קבצים עם סיומות אלה';
$lang['browsecattemplate']='עיון בקטגוריה תבניות';
$lang['cancel']='בטל';
$lang['categories']='מדורים';
$lang['category']='מדור';
$lang['category_label']='מדור:';
$lang['categoryadded']='המדור נוסף בהצלחה.';
$lang['categorydeleted']='המדור נמחק בהצלחה.';
$lang['categoryupdated']='המדור עודכן בהצלחה.';
$lang['checkbox']='תיבת סימון';
$lang['content']='תוכן';
$lang['customfields']='שדה הגדרות';
$lang['dateformat']='%s אינו בתצורת yyyy-mm-dd hh:mm:ss תקינה';
$lang['default_category']='מדור ראשי';
$lang['default_templates']='ברירת המחדל של תבניות';
$lang['delete']='מחק';
$lang['delete_selected']='מחיקת מאמרים נבחרים';
$lang['deprecated']='לא נתמך';
$lang['description']='הוסף, ערוך ומחק חדשות';
$lang['detailtemplate']='תבנית פרטים';
$lang['detailtemplateupdated']='תבנית הפרטים המעודכנת נשמרה בהצלחה במסד הנתונים';
$lang['displaytemplate']='הצג תבנית';
$lang['down']='מטה';
$lang['draft']='טיוטה';
$lang['edit']='ערוך';
$lang['editfielddef']='עריכת הגדרת שדה';
$lang['email_subject']='הנושא של הדוא"ל היוצא';
$lang['email_template']='הפורמט של הודעת הדוא"ל';
$lang['enddate']='תאריך סיום';
$lang['endrequiresstart']='הכנסת תאריך סיום דורשת גם תאריך התחלה';
$lang['entries']='%s חדשות';
$lang['error_filesize']='הקובץ שהועלה חריגה המרבי המותר גודל';
$lang['error_invaliddates']='אחד או יותר של תאריכים נכנסו אינם חוקיים';
$lang['error_invalidfiletype']='לא מצליח להעלות קובץ מסוג זה';
$lang['error_mkdir']='אין אפשרות ליצור את תיקיה: %s';
$lang['error_movefile']='אין אפשרות ליצור את הקובץ: %s';
$lang['error_noarticlesselected']='מאמרים לא נבחרו';
$lang['error_templatenamexists']='תבנית בשם זה כבר קיים';
$lang['error_upload']='הבעיה התרחשה העלאת קובץ';
$lang['eventdesc-NewsArticleAdded']='נשלח כשנוסף מאמר.';
$lang['eventdesc-NewsArticleDeleted']='נשלח כשמאמר נמחק.';
$lang['eventdesc-NewsArticleEdited']='נשלח כשמאמר נערך.';
$lang['eventdesc-NewsCategoryAdded']='נשלח כאשר נוסף מדור.';
$lang['eventdesc-NewsCategoryDeleted']='נשלח כאשר מדור נמחק.';
$lang['eventdesc-NewsCategoryEdited']='נשלח כאשר מדור נערך.';
$lang['eventhelp-NewsArticleAdded']='<p>נשלח כשנוסף מאמר.</p>
<h4>פרמטרים</h4>
<ul>
<li>\"news_id\" - קוד הזיהוי של המאמר</li>
<li>\"category_id\" - קוד זיהוי המדור של מאמר זה</li>
<li>\"title\" - כותרת המאמר</li>
<li>\"content\" - תוכן המאמר</li>
<li>\"summary\" - תקציר המאמר</li>
<li>\"status\" - מצב המאמר ("טיוטא" או "פרסם")</li>
<li>\"start_time\" - התאריך שבו המאמר יוצג</li>
<li>\"end_time\" - התאריך שבו המאמר יפסיק להיות מוצג</li>
<li>\"useexp\" - האם יש להתעלם מתאריך התפוגה או לא</li>
</ul>
';
$lang['eventhelp-NewsArticleDeleted']='<p>נשלח כשמאמר נמחק.</p>
<h4>פרמטרים</h4>
<ul>
<li>\"news_id\" - קוד הזיהוי של המאמר</li>
</ul>';
$lang['eventhelp-NewsArticleEdited']='<p>נשלח כשמאמר נערך.</p>
<h4>פרמטרים</h4>
<ul>
<li>\"news_id\" - קוד הזיהוי של המאמר</li>
<li>\"category_id\" - מס' המדור למאמר זה</li>
<li>\"title\" - כותרת המאמר</li>
<li>\"content\" - תוכן המאמר</li>
<li>\"summary\" - תקציר המאמר</li>
<li>\"status\" - מצב המאמר ("טיוטא" או "פרסם")</li>
<li>\"start_time\" - התאריך שבו המאמר יוצג</li>
<li>\"end_time\" - התאריך שבו המאמר יפסיק להיות מוצג</li>
<li>\"useexp\" - האם יש להתעלם מתאריך התפוגה או לא</li>
</ul>';
$lang['eventhelp-NewsCategoryAdded']='<p>נשלח כאשר נוסף מדור.</p>
<h4>פרמטרים</h4>
<ul>
<li>\"category_id\" - קוד הזיהוי של המדור</li>
<li>\"name\" - שם המדור</li>
</ul>
';
$lang['eventhelp-NewsCategoryDeleted']='<p>נשלח כאשר מדור נמחק.</p>
<h4>פרמטרים</h4>
<ul>
<li>\"category_id\" - קוד הזיהוי של המדור המחוק</li>
<li>\"name\" - שם המדור המחוק</li>
</ul>
';
$lang['eventhelp-NewsCategoryEdited']='<p>נשלח כאשר מדור נערך.</p>
<h4>פרמטרים</h4>
<ul>
<li>\"category_id\" - קוד הזיהוי של המדור</li>
<li>\"name\" - שם המדור</li>
<li>\"origname\" - השם המקורי של המדור</li>
</ul>
';
$lang['expired']='פג תוקף';
$lang['expired_searchable']='מאמרים פג תוקף יכול להופיע בתוצאות החיפוש';
$lang['expiry']='תפוגה';
$lang['expiry_date_asc']='תאריך תפוגה עולה';
$lang['expiry_date_desc']='תאריך תפוגה יורד';
$lang['expiry_interval']='מספר ימים (כברירת מחדל) לפני המאמר פוקעת (אם פקיעת מסומנת)';
$lang['extra']='נוסף';
$lang['fesubmit_redirect']='PageID או alias to redirect to after a news article has been submitted via the fesubmit action';
$lang['fesubmit_status']='מעמדו של מאמרי חדשות שהוגשו באמצעות הממשק';
$lang['fielddef']='שדה Definition';
$lang['fielddefadded']='הגדרת שדה Definition הוסיף בהצלחה';
$lang['fielddefdeleted']='הגדרת שדות שנמחקו';
$lang['fielddefupdated']='הגדרת שדה עודכן';
$lang['file']='קובץ';
$lang['filter']='מסננת';
$lang['firstpage']='<<';
$lang['formsubmit_emailaddress']='כתובת דוא"ל כדי לקבל הודעה על הגשת החדשות';
$lang['formtemplate']='תבניות טופס';
$lang['help']='	<h3>What does this do?</h3>
	<p>News is a module for displaying news events on your page, similar to a blog style, except with more features!.  When the module is installed, a News admin page is added to administration menu that will allow you to select or add a news category.  Once a news category is created or selected, a list of news items for that category will be displayed.  From here, you can add, edit or delete news items for that category.</p>
	<h3>Template variables</h3>
	<ul>
		<li><b>itemcount</b> - The number of news articles to be shown.</li>
		<li><b>entry->authorname</b> - The full name of the the author including First and Last name.</li>
	</ul>
	<h3>Security</h3>
	<p>The user must belong to a group with the 'Modify News' permission in order to add, edit, or delete News entries.</p>
	<p>In order to edit the layout templates, the user must belong to a group with the 'Modify Templates' permission.</p>
	<p>In order to edit the global news preferences, the user must belong to a group with the 'Modify Site Preferences' permission.</p>
	<h3>How do I use it?</h3>
	<p>The easiest way to use it is with the {news} wrapper tag (wraps the module in a tag, to simplify the syntax).  This will insert the module into your template or page anywhere you wish, and display news items.  The code would look something like: <code>{news number='5'}</code></p>';
$lang['help_articleid']='פרמטר זה הוא ישים רק כדי להציג את הפרטים. זה מאפשר ציון אשר מאמר חדשותי כדי להציג במצב בפירוט. אם הערך המיוחד -1 משמש, המערכת תציג את החדש, שפורסם, מאמר שאינו פג.';
$lang['help_pagelimit']='מספר מרבי של פריטים להצגה (בכל דף). אם הפרמטר הזה לא סיפק את כל הפריטים התואמים יוצג. אם כן, ויש עוד פריטים זמינים מאשר המצוין בפרמטר, טקסט וקישורים יסופקו על מנת לאפשר גלילה באמצעות התוצאות';
$lang['helpaction']=''Override the default action.  Possible values are:
<ul>
<li>"detail" - to display a specified articleid in detail mode.</li>
<li>"default" - to display the summary view</li>
<li>"fesubmit" - to display the frontend form for allowing users to submit news articles on the front end.</li>
<li>"browsecat" - to display a browseable category list.</li>
</ul>';
$lang['helpbrowsecat']='מציג רשימת מדורים לעיון.';
$lang['helpbrowsecattemplate']='שימוש באתר התבנית להצגת דפדפן בקטגוריה. תבנית זו חייבת להתקיים ולהיות גלויים על הכרטיסייה קטגוריה תבניות עיון של מנהל החדשות, למרות שזה לא צריך להיות ברירת המחדל. אם פרמטר זה לא צוין, ואז שוטפים את התבנית מסומן כברירת מחדל ישמשו.';
$lang['helpcategory']='Only display items for that category. <b>Use * after the name to show children.</b>  Multiple categories can be used if separated with a comma. Leaving empty, will show all categories.';
$lang['helpdetailpage']='דף כדי להציג פרטים חדשות פנימה זה יכול להיות כינוי מקור או תעודת זהות. משמש כדי לאפשר הפרטים שיוצגו תבנית שונה סיכום.';
$lang['helpdetailtemplate']='Use a separate template for displaying the article detail.  It have to live in modules/News/templates.';
$lang['helpformtemplate']='שימוש באתר התבנית להצגת טופס הגשת המאמר. תבנית זו חייבת להתקיים ולהיות גלוי בצורת תבניות הכרטיסייה של מנהל החדשות, למרות שזה לא צריך להיות ברירת המחדל. אם פרמטר זה לא צוין, ואז שוטפים את התבנית מסומן כברירת מחדל ישמשו.';
$lang['helpmoretext']='Text to display at the end of a news item if it goes over the summary length.  Defaults to "more..."';
$lang['helpnumber']='Maximum number of items to display =- leaving empty will show all items.';
$lang['helpshowall']='הצג את כל הכתבות, ללא קשר לתאריך הסיום';
$lang['helpshowarchive']='הצג מאמרים שתוקפם פג בלבד.';
$lang['helpsortasc']='לפי ידיעות על מנת תאריך עולה ולא יורד.';
$lang['helpsortby']='שדה המיון.  האפשרויות הן: "news_date" (תאריך), "summary" (תקציר), "news_data" (מידע), "news_category" (מדור), "news_title" (כותרת).  ברירת המחדל היא "news_date" (תאריך).';
$lang['helpstart']='התחל פריט המי יודע כמה - משאיר ריק יתחיל בשעה הפריט הראשון.';
$lang['helpsummarytemplate']='Use a separate template for displaying the article summary.  It have to live in modules/News/templates.';
$lang['hide_summary_field']='הסתרת שדה סיכום בעת הוספת או עריכת מאמרים';
$lang['info_maxlength']='האורך המרבי חל רק על שדות הזנת טקסט.';
$lang['info_sysdefault']='<em>(תוכן המשמש כברירת מחדל כאשר התבנית החדשה שנוצרה)</em>';
$lang['info_sysdefault2']='<strong>ערה:</strong> כרטיסייה זו מכילה אזורים טקסט תאפשר לך לערוך את ערכה של תבניות מוצגות כאשר אתה יוצר "סיכום חדש ', פרט, או תבנית הטופס. שינוי התוכן בלשונית זו, לחיצה על 'שלח' יהיה<strong>לא כל השפעה מציגה הנוכחית</strong>.';
$lang['lastpage']='>>';
$lang['maxlength']='אורך מקסימלי';
$lang['more']='עוד';
$lang['moretext']='עוד מלל';
$lang['msg_contenttype_removed']='סוג התוכן החדשות הוסר. אנא (news) המקום תגיות עם הפרמטרים המתאימים לתוך דף התבנית שלך או אל מקור התוכן שלך כדי להחליף את הפונקציה הזו.';
$lang['name']='שם';
$lang['nameexists']='שדה בשם זה כבר קיים';
$lang['needpermission']='נדרשת הרשאת '%s' כדי לבצע פעולה זו.';
$lang['newcategory']='מדור חדש';
$lang['news']='חדשות';
$lang['news_return']='חזור';
$lang['nextpage']='>';
$lang['nocategorygiven']='לא צויין מדור';
$lang['nocontentgiven']='לא ניתן תוכן';
$lang['noitemsfound']='<strong>אין</strong> חדשות במדור %s';
$lang['nonamegiven']='לא ניתן שם';
$lang['none']='לא';
$lang['nopostdategiven']='לא צויין תאריך פרסום';
$lang['notanumber']='האורך המקסימלי אינו מספר';
$lang['note']='<strong>שים לב:</strong> תאריכים חייבים להיות בתצורה 'yyyy-mm-dd hh:mm:ss'.';
$lang['notify_n_draft_items']='יש לך %s לא פורסמו';
$lang['notify_n_draft_items_sub']='%d חדשות מאמר';
$lang['notitlegiven']='לא ניתנה כותרת';
$lang['numbertodisplay']='מספר על הצג (מראה ריק כל הרשומות)';
$lang['options']='אפשרויות';
$lang['optionsupdated']='האפשרויות עודכנו בהצלחה';
$lang['post_date_asc']='פוסט תאריך עולה';
$lang['post_date_desc']='פוסט תאריך יורד';
$lang['postdate']='תאריך פרסום';
$lang['postinstall']='חשוב להסמן את ההרשאה "לנהל חדשות" למשתמשים המתאימים.';
$lang['prevpage']='<';
$lang['print']='הדפס';
$lang['prompt_default']='ברירת מחדל';
$lang['prompt_name']='שם';
$lang['prompt_newtemplate']='יצירת תבנית חדשה';
$lang['prompt_of']='מ';
$lang['prompt_page']='דף';
$lang['prompt_pagelimit']='הגבלת דפים';
$lang['prompt_sorting']='מיין לפי';
$lang['prompt_template']='המקור תבנית';
$lang['prompt_templatename']='שם תבנית';
$lang['public']='הציבור';
$lang['published']='פורסם';
$lang['reassign_category']='שינוי הקטגוריה';
$lang['removed']='הוסר';
$lang['resettodefault']='איפוס לברירות המחדל במפעל';
$lang['restoretodefaultsmsg']='פעולה זו תחזיר את תבניות התוכן לברירות המחדל שלהן. האם להמשיך?';
$lang['revert']='סטטוס הגדר "טיוטה"';
$lang['select']='לבחור';
$lang['selectcategory']='בחר מדור';
$lang['showchildcategories']='הצג תת-מדורים';
$lang['sortascending']='מיין בסדר עולה';
$lang['startdate']='תאריך התחלה';
$lang['startdatetoolate']='תאריך ההתחלה מאוחר מדי (לאחר תאריך סיום?)';
$lang['startoffset']='הצג החל מהחדשה ה-n';
$lang['startrequiresend']='ציון תאריך התחלה דורשת גם ציון תאריך סיום';
$lang['status']='מצב';
$lang['status_asc']='סטטוס עולה';
$lang['status_desc']='סטטוס יורד';
$lang['subject_newnews']='מאמר חדש חדשות כבר פורסם';
$lang['submit']='שלח';
$lang['summary']='תקציר';
$lang['summarytemplate']='תבנית תקצירים';
$lang['summarytemplateupdated']='תבנית התקצירים לחדשות עודכנה בהצלחה';
$lang['sysdefaults']='החזר את ברירות המחדל';
$lang['template']='תבנית';
$lang['textarea']='Text אזור';
$lang['textbox']='להכניס Text';
$lang['title']='כותרת';
$lang['title_asc']='כותר עולה';
$lang['title_available_templates']='ניתן להשיג תבניות';
$lang['title_browsecat_sysdefault']='עיון בקטגוריה ברירת המחדל תבנית';
$lang['title_browsecat_template']='עיון בקטגוריה תבנית עורך';
$lang['title_desc']='כותרת יורד';
$lang['title_detail_sysdefault']='פירוט תבנית ברירת מחדל';
$lang['title_detail_template']='עורך פירוט תבנית';
$lang['title_filter']='מסננים';
$lang['title_form_sysdefault']='טופס תבנית ברירת מחדל';
$lang['title_form_template']='עורך תבנית טופס';
$lang['title_summary_sysdefault']='סיכום תבנית ברירת מחדל';
$lang['title_summary_template']='עורך סיכום תבנית';
$lang['type']='סוג';
$lang['unknown']='לא ידוע';
$lang['unlimited']='בלתי מוגבל';
$lang['up']='למעלה';
$lang['uploadscategory']='ההעלאות קטגוריה';
$lang['useexpiration']='השתמש בתאריך תפוגה';
?>