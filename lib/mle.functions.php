<?php

#------------------------------------------------------------------------
# MLE - MultiLanguage Edition
# 2016 (c) Lipit (Lee Peace) <songviytuong@gmail.com>
# mle.functions.php 113 2016-10-06 21:30:12Z Lipit $
# mle.functions.php 114 2017-08-28 10:38:12Z Lipit $
#------------------------------------------------------------------------
function CheckExits() {
    $modobj = cms_utils::get_module("MleCMS");
    $result = false;
    if (is_object($modobj)) {
        $result = true;
    }
    return $result;
}

function MultiLanguage() {
    $gCms = CmsApp::get_instance();
    $db = $gCms->GetDb();
    $q = 'SELECT * FROM ' . CMS_DB_PREFIX . 'module_mlecms_config WHERE active = 1 ORDER BY sort ASC';
    $dbresult = $db->Execute($q);
    if ($dbresult == false)
        return false;

    $result = array();
    while ($row = $dbresult->FetchRow()) {
        $result[] = $row;
    }
    return $result;
}

function Define_MultiLanguage() {
    $gCms = CmsApp::get_instance();
    $config = $gCms->GetConfig();
    $hls = MultiLanguage();
    $arr = array();
    foreach ($hls as $item) {
        $arr[$item["locale"]]["locale_cms"] = $item["alias"];
        $arr[$item["locale"]]["block"] = $item["alias"];
        $arr[$item["locale"]]["parent"] = $item["alias"];
        $arr[$item["locale"]]["flag"] = '<img src=' . $config["root_url"] . '/uploads/' . $item["flag"] . ' style="border:0;opacity:1;" alt="' . $item["name"] . '" title="' . $item["name"] . '" />';
        $arr[$item["locale"]]["text"] = $item["name"];
        $arr[$item["locale"]]["locale"] = $item["locale"] . ".UTF-8";
    }
    return $arr;
}

function opacity_flags($replace, $percent, $reverse = false) {
    global $hls, $hl;
    $percent = intval($percent);
    $strreplace = "filter:alpha(opacity={$percent});-moz-opacity:.{$percent};opacity:.{$percent};";
    foreach ($hls as $key => $val) {
        if ($reverse) {
            $hls["$key"]['flag'] = str_replace($strreplace, $replace, $val['flag']);
            continue;
        }
        if ($hl == $key)
            continue;
        if (strstr($val['flag'], $replace) !== false)
            $hls["$key"]['flag'] = str_replace($replace, $strreplace, $val['flag']);
    }
    return true;
}

function check_mle_pretty_urls($hls, $default = '') {
    $url = explode('/', $_SERVER['PHP_SELF']);
    foreach ($url as $url_key => $url_val) {
        foreach ($hls as $key => $val) {
            if ($key == $url_val)
                return $key;
        }
    }
    return $default;
}

function language_accept_order($a, $b) {
    if ($a[1] == $b[1])
        return ($a[2] > $b[2]) ? 1 : -1;
    return ($a[1] > $b[1]) ? -1 : 1;
}

//Build a new array
function transform_language_arr($hls) {
    $t_hls = array('parent' => array(), 'locale' => array());
    foreach ($hls as $key => $val) {
        if (isset($val['locale_cms']))
            $locale = $val['locale_cms'];
        else
            $locale = $key;

        if (isset($val['parent']))
            $parent = strtolower($val['parent']);
        else
            $parent = strtolower($val['block']);
        $parent5 = strtolower(str_replace('_', '-', $locale));

        if (!in_array($locale, array_keys($t_hls['locale'])))
            $t_hls['locale']["$locale"] = $key;
        if (!in_array($parent, array_keys($t_hls['parent'])))
            $t_hls['parent']["$parent"] = $key;
        if (!in_array($parent5, array_keys($t_hls['parent'])))
            $t_hls['parent']["$parent5"] = $key;
    }
    return $t_hls;
}

//Specified by the user via the browser's Accept Language setting
//Samples: "hu, en-us;q=0.66, en;q=0.33", "hu,en-us;q=0.5"
function language_user_setting($hls) {
    $browser_langs = array();
    $t_hls = transform_language_arr($hls);

    //Check if we have $_SERVER['HTTP_ACCEPT_LANGUAGE'] set and
    //it no longer breaks if you only have one language set :)
    if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
        $str = strtolower(trim($_SERVER["HTTP_ACCEPT_LANGUAGE"]));
        $str = str_replace(' ', '', $str);
        $browser_accept = explode(',', $str);

        //Go through all language preference specs
        for ($i = 0; $i < count($browser_accept); $i++) {
            //The language part is either a code or a code with a quality
            //We cannot do anything with a * code, so it is skipped
            //If the quality is missing, it is assumed to be 1 according to the RFC
            if (preg_match("!([a-z-]+)(;q=([0-9\\.]+))?!", $browser_accept[$i], $found)) {
                $quality = (isset($found[3]) ? (float) $found[3] : 1.0);
                $browser_langs[] = array($found[1], $quality, $i + 1);
            }
            unset($found);
        }
    } elseif (isset($_SERVER['HTTP_USER_AGENT'])) {
        $str = strtolower(trim($_SERVER["HTTP_USER_AGENT"]));
        $user_agent = explode(';', $str);

        for ($i = 0; $i < sizeof($user_agent); $i++) {
            $languages = explode('-', $user_agent[$i]);
            if (sizeof($languages) == 2 || strlen(trim($languages[0])) == 2) {
                $browser_langs[] = array(trim($languages[0]), 1.0, $i + 1);
            }
        }
    }

    //Sort by quality and order
    usort($browser_langs, "language_accept_order");

    foreach ($browser_langs as $arr_language) {
        $language = $arr_language[0];
        if (in_array($language, array_keys($t_hls['parent'])))
            return $t_hls['parent']["$language"];
        if (strlen($language) > 2) {
            $language = substr($language, 0, 2);
            if (in_array($language, array_keys($t_hls['parent'])))
                return $t_hls['parent']["$language"];
        }
    }
    return DEFAULT_LANG;
}
#+Lee
function counter(){
    $db = cmsms()->GetDb();
    $q = 'SELECT count(*) FROM ' . CMS_DB_PREFIX . 'module_mlecms_config WHERE active = 1';
    $dbresult = $db->GetOne($q);
    if($dbresult > 1){
        return true;
    } else {
        return false;
    }
}

#+Lee
function active_languages() {
    $db = cmsms()->GetDb();
    $NotSync = "SELECT module_name FROM " . cms_db_prefix() . "modules WHERE module_name LIKE '%LISE%' AND module_name !='LISE' AND sync = 0";
    $SyncArr = $db->GetAll($NotSync);
    $arr = array();
    foreach ($SyncArr as $item) {
        $arr[] = strtolower($item["module_name"]);
    }
    $mact = isset($_GET["mact"]);
    $moduleCK = explode(",", $mact);
    if (in_array(strtolower($moduleCK[0]), $arr)) {
        return false;
    } else {
        if (counter() == FALSE) {
            return false;
        } else {
            return true;
        }
    }
}

#+Lee
function count_language($mod){
    $db = cmsms()->GetDb();
    $sql = "SELECT count(*) as cnt FROM cms_modules WHERE module_name LIKE '%" . $mod ."%' and `sync` = 1";
    $rest = $db->GetRow($sql);
    if($rest['cnt'] == 0){
        return false;
    } else {
        return true;
    }
}

?>