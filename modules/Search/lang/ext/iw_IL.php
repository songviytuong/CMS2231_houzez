<?php
$lang['clear']='נקה';
$lang['confirm_clearstats']='האם אתה בטוח שאתה רוצה לצמיתות לנקות את כל הנתונים הסטטיסטיים?';
$lang['count']='ספירה';
$lang['description']='מודול באתר חיפוש תוכן המודול של אחרים.';
$lang['eventdesc-SearchAllItemsDeleted']='נשלח כאשר כל הפריטים נמחקו מהאינדקס.';
$lang['eventdesc-SearchCompleted']='נשלך כאשר חיפוש הסתים';
$lang['eventdesc-SearchInitiated']='נשלך כאשר חיפוש התחיל';
$lang['eventdesc-SearchItemAdded']='נשלח כאשר פריט חדש מופתח.';
$lang['eventdesc-SearchItemDeleted']='נשלח כאשר פריט נמחק מהאינדקס.';
$lang['eventhelp-SearchAllItemsDeleted']='<p>נשלח כאשר כל הפריטים שנמחקו מן המדד.</p>
<h4>פרמטרים</h4>
<ul>
<li>None</li>
</ul>
';
$lang['eventhelp-SearchCompleted']='<p>נשלח כאשר חיפוש הושלם.</p>
<h4> פרמטרים </h4>
<ol>
<li>טקסט זה חיפשו.</li>
<li>מערך של תוצאות סיום.</li>
</ol>
';
$lang['eventhelp-SearchInitiated']='<p>נשלח כאשר החיפוש הוא התחיל.</p>
<h4> פרמטרים </h4>
<ol>
<li>טקסט זה חיפשו.</li>
</ol>
';
$lang['eventhelp-SearchItemAdded']='<p>נשלח כאשר פריט חדש באינדקס.</p>
<h4>פרמטרים </h4>
<ol>
<li>שם מודול.</li>
<li>זיהוי של פריט.</li>
<li>מאפיינים נוספים.</li>
<li>תוכן למדד ולהוסיף.</li>
</ol>
';
$lang['eventhelp-SearchItemDeleted']='<p>שלח כאשר פריט נמחק מהאינדקס .</p>
<h4>פרמטרים</h4>
<ol>
<li>שם מודול.</li>
<li>זיהוי של פריט.</li>
<li>מאפיינים נוספים.</li>
</ol>
';
$lang['export_to_csv']='ייצוא ל CSV';
$lang['help']='<h3>What does this do?</h3>
<p>Search is a module for searching "core" content along with certain registered modules.  You put in a word or two and it gives you back matching, relevent results.</p>
<h3>How do I use it?</h3>
<p>The easiest way to use it is with the {search} wrapper tag (wraps the module in a tag, to simplify the syntax). This will insert the module into your template or page anywhere you wish, and display the search form.  The code would look something like: <code>{search}</code></p>
<h4>How do i prevent certain content from being indexed</h4>
<p>The search module will not search any "inactive" pages. However on occasion, when you are using the CustomContent module, or other smarty logic to show different content to different groups of users, it may be advisiable to prevent the entire page from being indexed even when it is live.  To do this include the following tag anywhere on the page <em><!-- pageAttribute: NotSearchable --></em> When the search module sees this tag in the page it will not index any content for that page.</p>
<p>The <em><!-- pageAttribute: NotSearchable --></em> tag can be placed in the template as well.  if this is done, none of the pages attached to that template will be indexed.  Those pages will be re-indexed if the tag is removed</p>
';
$lang['noresultsfound']='לא נמצאו תוצאות!';
$lang['options']='אפשרויות';
$lang['param_action']='ציין את מצב הפעולה של המודול. הערכים המותרים הם "ברירת המחדל", מילות מפתח 'ו'. מילות המפתח הפעולה יכול לשמש כדי ליצור רשימה מופרדת בפסיקים של מילים מתאים לשימוש תג מילות המפתח meta.';
$lang['param_count']='בשימוש עם פעולה מילות המפתח, פרמטר זה יגביל את הפלט של מספר מסוים של מילים';
$lang['param_detailpage']='השתמשו רק עבור התאמת תוצאות מודולים, פרמטר זה מאפשר ציון מקור אחר פרט לתוצאות.  הדבר שימושי אם, למשל, אתה תמיד להציג תצוגות פרט שלך בדף עם תבנית אחרת.  <em>(<strong>הערה:</strong> מודולים ייתכן אופציונלי לעקוף את זה.)</em>';
$lang['param_inline']='אם נכון, מהפלט בטופס החיפוש יחליף את התוכן המקורי של החיפוש "התג לחסום תוכן שמקורו. השתמש בפרמטר זה, אם התבנית שלך יש קוביות תוכן מרובים, ואתה לא רוצה את הפלט של החיפוש במקום לחסום תוכן ברירת מחדל';
$lang['param_modules']='מגבלת תוצאות החיפוש כדי ערכים באינדקס מן פסיק (המצוין מופרדים) רשימה של מודולים';
$lang['param_pageid']='ישים רק עם פעולה מילות המפתח, פרמטר זה יכול לשמש כדי לציין pageid שונים כדי להחזיר תוצאות עבור';
$lang['param_passthru']='פס בשם פרמטרים אל מודולים שצוין.  הפורמט של כל הפרמטרים הללו: "passtru_MODULENAME_PARAMNAME='value'" כלומר: passthru_News_detailpage='newsdetails'"';
$lang['param_resultpage']='דף כדי להציג תוצאות חיפוש פנימה זה יכול להיות כינוי מקור או מזהה. משמש כדי לאפשר את תוצאות החיפוש יוצגו תבנית שונה מטופס החיפוש';
$lang['param_searchtext']='טקסט למקום לתוך תיבת החיפוש';
$lang['param_submit']='טקסט למקום לתוך לחצן "שלח"';
$lang['prompt_alpharesults']='מיין תוצאות לפי סדר אלפביתי ולא לפי משקל';
$lang['prompt_resultpage']='דף תוצאות מודול הפרט <em>(הערה מודולים ייתכן אופציונלי לעקוף את זה)</em>';
$lang['prompt_savephrases']='עקוב אחר חיפוש ביטויים, ולא מילים בודדת';
$lang['prompt_searchtext']='תוכן לחיפוש ברירת מיחדל';
$lang['reindexallcontent']='למפתח כל התוכן';
$lang['reindexcomplete']='מיפתוח הסתים בהצלחה!';
$lang['restoretodefaultsmsg']='פעולה זו תשחזר את תבנית ברירת המחדל של מערכת התוכן שלהם. האם אתה בטוח שאתה רוצה להמשיך?';
$lang['resulttemplate']='תבנית תוצאה';
$lang['resulttemplateupdated']='תבנית תוצאות עלה';
$lang['search']='חיפוש';
$lang['search_method']='די כתובות אתרים תאימות באמצעות שיטת POST, ערך ברירת המחדל הוא תמיד GET, לעשות את העבודה הזאת רק את {search search_method="post"} ';
$lang['searchresultsfor']='תוצאות חיפוש עבור';
$lang['searchsubmit']='לחץ';
$lang['searchtemplate']='תבנית חיפוש';
$lang['searchtemplateupdated']='תבנית חיפוש עלה';
$lang['statistics']='סטטיסטיקה';
$lang['stopwords']='מילות עצירה';
$lang['submit']='שלח';
$lang['sysdefaults']='החזר לברירות המחדל';
$lang['timetaken']='הזמן שנדרש';
$lang['usestemming']='השתמש במילים הנובעיות (אנגלית בלבד)';
$lang['word']='מילה';
?>