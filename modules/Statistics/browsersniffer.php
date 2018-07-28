<?php

class BrowserSniffer {

  var $useragent = "";
  var $robot = "";
  var $smartphone = "";
  var $oses = array(
      "win" => "Windows",
      "linux" => "Linux",
      "mac" => "MacOS",
      "freebsd" => "FreeBSD",
      "netbsd" => "NetBSD",
      "sun" => "SunOS"
  );
  var $browsers = array(
      "firefox" => "Firefox",
      "chrome" => "Chrome",
      "safari" => "Safari",
      "opera" => "Opera",
      "netscape" => "Netscape",
      "konqueror" => "Konqueror"
  );
  var $robots = array(
      "msnbot",
      "cuill",
      "crawl",
      "search",
      "exabot",
      "msn",
      "googlebot",
      "yahoo",
      "jeeves"
  );
  var $smartphones = array(
      "iPhone" => "iPhone/iPod", // Apple iPhone
      "iPod" => "iPhone/iPod", // Apple iPod touch
      "Android" => "Android", // 1.5+ Android
      "dream" => "Android", // Pre 1.5 Android
      "CUPCAKE" => "Android", // 1.5+ Android
      "BlackBerry9500" => "BlackBerry", // Storm
      "BlackBerry9530" => "BlackBerry", // Storm
      "webOS" => "Palm", // Palm Pre Experimental
      "incognito" => "iPhone/iPod", // Other iPhone browser
      "webmate" => "iPhone/iPod",     // Other iPhone browser
      "SymbianOS" => "Symbian" //Symbian
  );

  function __construct() {
    $this->useragent = $_SERVER['HTTP_USER_AGENT'];
    if ($this->useragent == "") $this->useragent = "unknown useragent";
  }

  function GetBrowser($extrarobots="") {
    if (preg_match("/msie/i", $this->useragent)) {
      if (preg_match("/msie 6.0/i", $this->useragent))
          return "Internet Explorer 6";
      if (preg_match("/msie 7.0/i", $this->useragent))
          return "Internet Explorer 7";
      if (preg_match("/msie 8.0/i", $this->useragent))
          return "Internet Explorer 8";
      if (preg_match("/msie 9.0/i", $this->useragent))
          return "Internet Explorer 9";
      return "Internet Explorer";
    }
    foreach ($this->browsers as $id => $browser) {
      if (preg_match("/" . $id . "/i", $this->useragent)) return $browser;
    }
    if ($this->IsRobot($extrarobots)) return "Robot (" . $this->robot . ")";
    return "Other";
  }

  function GetOS($extrarobots="") {
    foreach ($this->oses as $id => $os) {
      if (preg_match("/" . $id . "/i", $this->useragent)) return $os;
    }
    if ($this->IsRobot($extrarobots)) return "Robot (" . $this->robot . ")";
    return "Other";
  }

  function IsRobot($extrarobots="") {
    $robots = $this->robots;
    if ($extrarobots != "") {
      $robots = array_merge($robots, explode(";", $extrarobots));
    }
    foreach ($robots as $id) {
      if (preg_match("/" . $id . "/i", $this->useragent)) {
        $this->robot = $id;
        return true;
      }
    }
    return false;
  }

  function IsSmartPhone($extrasmartphones="") {
    $smartphones = $this->smartphones;
    if ($extrasmartphones != "") {
      $smartphones = array_merge($smartphones, explode(";", $extrasmartphonessmartphones));
    }
    foreach ($smartphones as $id => $phonetype) {
      if (preg_match("/" . $id . "/i", $this->useragent)) {
        $this->smartphone = $phonetype;
        return true;
      }
    }
    return false;
  }

}

?>