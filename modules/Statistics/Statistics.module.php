<?php
# Statistics. A plugin for CMS - CMS Made Simple
# Copyright (c) 2004-10 by Morten Poulsen <morten@poulsen.org>
#
#CMS - CMS Made Simple
#(c)2004 by Ted Kulp (wishy@users.sf.net)
#This project's homepage is: http://cmsmadesimple.sf.net
#
#This program is free software; you can redistribute it and/or modify
#it under the terms of the GNU General Public License as published by
#the Free Software Foundation; either version 2 of the License, or
#(at your option) any later version.
#
#This program is distributed in the hope that it will be useful,
#but WITHOUT ANY WARRANTY; without even the implied warranty of
#MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.	See the
#GNU General Public License for more details.
#You should have received a copy of the GNU General Public License
#along with this program; if not, write to the Free Software
#Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
#
#$Id$

if (!function_exists('fnmatch')) {
  function fnmatch($pattern, $string) {
    return @preg_match('/^' . strtr(addcslashes($pattern, '\\.+^$(){}=!<>|'), array('*' => '.*', '?' => '.?')) . '$/i', $string);
  }
}

class Statistics extends CMSModule {
  var $geoipurl="http://geolite.maxmind.com/download/geoip/database/GeoLiteCountry/GeoIP.dat.gz";

  //After how many minutes should a user be considered inactive
  //default : 5 minutes
  var $activelimit;

  //After how many minutes should a user be considered not accessing the site anymore
  //upon a new visit the user will be considered new and counted
  //default : 30 minutes
  var $visitorlimit;

  var $gonetokeep;

  //From Frank
  //How many days/weeks/months/years/browsers/OS'es/countries should be shown in the
  //statistic pages
  //default:
  //  days:      31 days
  //  weeks:     52 weeks
  //  months:    12 months
  //  years:     10 years
  //  browsers:  all
  //  OS'es:     all
  //  countries: all
  var $showdaylimit;
  var $showweeklimit;
  var $showmonthlimit;
  var $showyearlimit;
  var $showbrowserlimit;
  var $showoslimit;
  var $showcountrylimit;
  var $showpageslimit;
  var $showrefererlimit;
  var $expirytime;
  var $ignoreips;
  var $ignorevisitors;
  var $ignorepages;
  var $ignorereferers;
  var $ignorerobots;
  var $extrarobots;
  var $ignoreadmins;
  var $dateformat;
  var $charttype;
  var $iconset;
  var $jsdetects;
  var $visitortracking;
  var $debuglog;
  var $iphandling;
  var $statemail;
  var $emailinterval;
  var $lastemailtime;
  var $countrydetection;
  var $keywordreplacements;
  var $counturlaccess;
  var $singlekeywords;
  var $jqplotx;
  var $jqploty;
  var $gfxnumbers;

	function getcms($name)
	{
		$gCms = cmsms();
		
    //$contentobj = $gCms->variables['content_obj'];
    $contentobj = statistics_utils::GetCurremtContentObj();
    
    
		if ($contentobj != null)
		{
			switch ($name)
			{
				case 'content_id':
				{
					return $contentobj->Id();
				}
				case 'content_title':
				{
					return $contentobj->Name();
				}
				case 'content_alias':
				{
					return $contentobj->Alias();
				}
				case 'content_menutext':
				{
					return $contentobj->MenuText();
				}
				case 'content_titleattribute':
				{
					return $contentobj->TitleAttribute();
				}
				case 'content_hierarchy':
				{
					return $contentobj->Hierarchy();
				}
				case 'content_id_hierarchy':
				{
					return $contentobj->IdHierarchy();
				}
				case 'content_type':
				{
					return $contentobj->Type();
				}
				case 'content_props':
				{
					return $contentobj->mProperties->mPropertyNames;
				}
				case 'content_metadata':
				{
					return $contentobj->Metadata();
				}
				case 'content_created_date':
				{
					return $contentobj->GetCreationDate();
				}
				case 'content_modified_date':
				case 'content_last_modified_date':
				{
					return $contentobj->GetModifiedDate();
				}
				case 'content_last_modified_by_id':
				{
					return $contentobj->LastModifiedBy();
				}
				default:
				{
					return null;
				}
			}
		}
	}


  function GetVersion() {
    return '1.2.1.2';
  }

  function GetName() {
    return 'Statistics';
  }

  function GetFriendlyName() {
    return $this->Lang('Statistics');
  }

  function IsPluginModule() {
    return true;
  }

  function HasAdmin() {
    return true;
  }

  function GetAdminSection() {
    return $this->GetPreference("adminsection","extensions");
  }

  function GetAdminDescription() {
    return $this->Lang('moddescription');
  }

  function UninstallPostMessage() {
    return $this->lang('postuninstallmessage');
  }

  function GetHelp($lang='en_US') {
    return $this->lang("help");
  }

  function VisibleToAdminUser() {
    return ($this->CheckPermission('View Statistics') || $this->CheckPermission('Administrate Statistics'));
  }

  function GetAuthor() {
    return 'Morten Poulsen';
  }

  function GetAuthorEmail() {
    return 'morten@poulsen.org';
  }

  function GetChangeLog() {
    return $this->ProcessTemplate("changelog.tpl");
  }

  function InstallPostMessage() {
    return $this->lang('postinstallmessage');
  }

  function MinimumCMSVersion() {
    return "1.12.1";
  }

  # deprecated in CMSMS API needs to be moved (JM)
  function SetParameters() {
    $this->RestrictUnknownParams();
    $this->RegisterModulePlugin();

    $this->CreateParameter('what', "", $this->Lang('help_what'));
    $this->SetParameterType('what',CLEAN_STRING);

    $this->CreateParameter('how', "dont", $this->Lang('help_how'));
    $this->SetParameterType('how',CLEAN_STRING);

    $this->CreateParameter('howmany', "5", $this->Lang('help_howmany'));
    $this->SetParameterType('howmany',CLEAN_INT);

    $this->SetParameterType('show',CLEAN_STRING);
  }

  function GetHeaderHTML() {
    $css = '<link rel="stylesheet" type="text/css" href="../../modules/Statistics/jqplot.css" />';
    return $css;
  }

  function GetSummaryOutput() {
    
    $smarty = cmsms()->GetSmarty();
    $headers=array($this->lang("statitem"),$this->Lang("Count"));
    $smarty->assign('headers',$headers);
    $smarty->assign('icon',"summary.png");
    $smarty->assign('title',$this->Lang("summary"));
    $rows=array();

    $rows[]=array($this->lang("totalhits"),$this->GetValue("count_total","",0));
    $rows[]=array($this->lang("totalpageviews"),$this->GetValue("count_total_pageviews","",0));
    $rows[]=array($this->lang("hitstoday"),$this->GetValue("count_day",date("Ymd",time()),0));
    if ((date("W",time())>5) AND (date("j",time())==1)) {
      $rows[]=array($this->lang("hitsthisweek"),$this->GetValue("count_week",(date("Y",time())-1).date("W",time()),0));
    } else {
      $rows[]=array($this->lang("hitsthisweek"),$this->GetValue("count_week",date("YW",time()),0));
    }

    $rows[]=array($this->lang("hitsthismonth"),$this->GetValue("count_month",date("Ym",time()),0));
    $rows[]=array($this->lang("hitsthisyear"),$this->GetValue("count_year",date("Y",time()),0));
    $rows[]=array($this->lang("mostpopularbrowser"),$this->GetMaxSeckey("count_browser",$this->Lang("noneyet")));
    $rows[]=array($this->lang("mostpopularOS"),$this->GetMaxSeckey("count_os",$this->Lang("noneyet")));
    $rows[]=array($this->lang("bounces"),$this->GetValue("count_bounces"));
    $maxcountry=$this->GetMaxSeckey("count_country");
    
    //if (strlen($maxcountry)==2) */
    //echo $maxcountry;
    if (!$maxcountry) {
      $maxcountry=$this->Lang("noneyet");
    } else {
      $maxcountry=$this->GetCountryName($maxcountry);
    }
    //echo $maxcountry;
    $rows[]=array($this->lang("mostpopularcountry"),$maxcountry);
    $db=cmsms()->GetDb();
    $limit=time()-$this->activelimit;
    $query="SELECT id FROM ".cms_db_prefix()."module_stat_visitors WHERE lastseen>?";
    $dbresult=$db->Execute($query,array($limit));
    $currentlyactive=0;
    if ($dbresult) $currentlyactive=$dbresult->RecordCount();
    if ($currentlyactive==0) $currentlyactive=$this->Lang("none");
    $rows[]=array($this->lang("currentlyactive"),$currentlyactive);
    $smarty->assign('rows',$rows);
    $smarty->assign('rowcount',count($rows));

    return $this->ProcessTemplate("stattable.tpl");

  }

  function GetDashboardOutput() {
    if (!$this->VisibleToAdminUser()) return "";
    return $this->GetSummaryOutput();
  }

  function ShowSummary() {
    echo $this->GetSummaryOutput();
  }

  function ShowIcons($id,$returnid) {
    $config = cmsms()->GetConfig();
    $smarty = cmsms()->GetSmarty();
    $smarty->assign('rooturl', $config["root_url"]);
    
    $smarty->assign('summaryurl',$this->CreateLink($id,"defaultadmin",$returnid,"",array("show"=>"summary"),"",true));
    $smarty->assign('summarytitle', $this->Lang("summary"));

    $smarty->assign('daysurl',$this->CreateLink($id,"defaultadmin",$returnid,"",array("show"=>"days"),"",true));
    $smarty->assign('daystitle', $this->Lang("Days"));

    $smarty->assign('weekdaysurl',$this->CreateLink($id,"defaultadmin",$returnid,"",array("show"=>"weekdays"),"",true));
    $smarty->assign('weekdaystitle', $this->Lang("weekdays"));

    $smarty->assign('timesurl',$this->CreateLink($id,"defaultadmin",$returnid,"",array("show"=>"timeofday"),"",true));
    $smarty->assign('timestitle', $this->Lang("timeofday"));

    $smarty->assign('weeksurl',$this->CreateLink($id,"defaultadmin",$returnid,"",array("show"=>"weeks"),"",true));
    $smarty->assign('weekstitle', $this->Lang("Weeks"));

    $smarty->assign('monthsurl',$this->CreateLink($id,"defaultadmin",$returnid,"",array("show"=>"months"),"",true));
    $smarty->assign('monthstitle', $this->Lang("Months"));

    $smarty->assign('yearsurl',$this->CreateLink($id,"defaultadmin",$returnid,"",array("show"=>"years"),"",true));
    $smarty->assign('yearstitle', $this->Lang("Years"));

    $smarty->assign('browsersurl',$this->CreateLink($id,"defaultadmin",$returnid,"",array("show"=>"browsers"),"",true));
    $smarty->assign('browserstitle', $this->Lang("Browsers"));

    $smarty->assign('smartphonesurl',$this->CreateLink($id,"defaultadmin",$returnid,"",array("show"=>"smartphones"),"",true));
    $smarty->assign('smartphonestitle', $this->Lang("smartphones"));

    $smarty->assign('osesurl',$this->CreateLink($id,"defaultadmin",$returnid,"",array("show"=>"oses"),"",true));
    $smarty->assign('osestitle', $this->Lang("OSes"));

    if ($this->countrydetection!="disabled") {
      $smarty->assign('countriesurl',$this->CreateLink($id,"defaultadmin",$returnid,"",array("show"=>"countries"),"",true));
      $smarty->assign('countriestitle', $this->Lang("Countries"));
    }

    $smarty->assign('pagesurl',$this->CreateLink($id,"defaultadmin",$returnid,"",array("show"=>"pages"),"",true));
    $smarty->assign('pagestitle', $this->Lang("pages"));

    $smarty->assign('referersurl',$this->CreateLink($id,"defaultadmin",$returnid,"",array("show"=>"referers"),"",true));
    $smarty->assign('refererstitle', $this->Lang("referers"));

    $smarty->assign('searchenginesurl',$this->CreateLink($id,"defaultadmin",$returnid,"",array("show"=>"searchengines"),"",true));
    $smarty->assign('searchenginestitle', $this->Lang("searchengines"));

    $smarty->assign('robotsurl',$this->CreateLink($id,"defaultadmin",$returnid,"",array("show"=>"robots"),"",true));
    $smarty->assign('robotstitle', $this->Lang("robots"));

    $smarty->assign('visitorsurl',$this->CreateLink($id,"defaultadmin",$returnid,"",array("show"=>"visitors"),"",true));
    $smarty->assign('visitorstitle', $this->Lang("visitors"));

    if ($this->jsdetects=="1") {
      $smarty->assign('resolutionsurl',$this->CreateLink($id,"defaultadmin",$returnid,"",array("show"=>"resolutions"),"",true));
      $smarty->assign('resolutionstitle', $this->Lang("screenresolutions"));
    }
    $smarty->assign('iconset',$this->iconset);
    echo $this->ProcessTemplate("iconlist.tpl");
  }

  function GetHostFromIP($ip,$alwaysreturnbool=false) {
    $host=@gethostbyaddr($ip);
    if ($host==$ip) {
      if ($alwaysreturnbool) {
        return false;
      } else {
        return $ip;
      }
    }
    return $host;
  }

  function GetSuperDomain() {
    $host=$this->GetHostFromIP($_SERVER['REMOTE_ADDR']);
    if ($host==$_SERVER['REMOTE_ADDR']) return "";
    $pos=strrpos($host,".");
    $superdomain=substr($host,$pos+1);
    $superdomain=str_replace("..",".",$superdomain);
    return trim($superdomain);
  }

  function DoComplete() {
    $db=cmsms()->GetDb();
    $this->InsertVisitor();
    $this->IncreaseValue("count_total");
    $this->IncreaseValue("count_day",date("Ymd",time()));
    if ((date("W",time())>5) AND (date("j",time())==1)) {
      $this->IncreaseValue("count_week",(date("Y",time())-1).date("W",time()));
    } else {
      $this->IncreaseValue("count_week",date("YW",time()));
    }
    $this->IncreaseValue("count_month",date("Ym",time()));
    $this->IncreaseValue("count_year",date("Y",time()));

    $this->IncreaseValue("count_weekday",date("w",time()));
    $this->IncreaseValue("count_time",date("H",time()));
    
    $config = cmsms()->GetConfig();
    include_once(dirname(__FILE__)."/browsersniffer.php");

    $sniffer=new BrowserSniffer();

    $this->IncreaseValue("count_browser",$sniffer->GetBrowser($this->extrarobots));
    $this->IncreaseValue("count_os",$sniffer->GetOS());
    if ($sniffer->IsSmartPhone()) {
      $this->IncreaseValue("count_smartphone",$sniffer->smartphone);
    }
    $this->CountCountry();

    $this->SaveRefererData();
  }

  function DetectCountry() {
    static $detectedas=false;
    if ($detectedas) return $detectedas;
    $result=false;
    switch($this->GetPreference("countrydetection","superdomain")) {
      case "superdomain" : {
          $country=$this->GetSuperDomain();
          if ($country!="") {
            $result=$country;
          }
          break;
        }
      case "geoip" : {  
          include_once(dirname(__FILE__)."/geoip/geoip.inc");
          $handle = geoip_open(dirname(__FILE__)."/geoip/GeoIP.dat", GEOIP_STANDARD);
          if ($handle) {
            $countrycode=geoip_country_code_by_addr($handle, $_SERVER['REMOTE_ADDR']);
            if ($countrycode) {
              $result=$countrycode;
            }
            // close database handler
            geoip_close($handle);
          }
          break;
        }
      default : {

          break;
        }
    }
    $detectedas=$result;  
    return $result;
  }

  function CountCountry() {
    $country=$this->DetectCountry();
    if ($country) {
      $this->IncreaseValue("count_country",$country);
    }
  }

  /*function DoUpdate() {
    $this->UpdateVisitor();
  }*/

  function ReplaceKeywords($keywords) {
    if ($this->GetPreference("keywordreplacements")=="") return $keywords;
    $replacements=explode('|',$this->GetPreference("keywordreplacements"));
    if (count($replacements)==0) return $keywords;
    $result="";
    $thesekeywords=explode(' ',$keywords);
    foreach ($thesekeywords as $keyword) {
      $found=false;
      foreach ($replacements as $replacement) {
        $parts=explode('=',$replacement);
        if (count($parts)!=2) continue;
        $pattern=trim($parts[0]);
        $replacement=trim($parts[1]);
        if (fnmatch($pattern,$keyword)) {
          $result.=($replacement." ");
          $this->Log("Replacing [".$keyword."] with [".$replacement."] because of [".$pattern."]",3);
          $found=true;
          break;
        }
      }
      if (!$found) $result.=($keyword." ");
    }

    if ($result=="") $result=$keyword;
    return $result;
  }

  function SaveRefererData() {
    // thanx to ilovejackdaniels.com
    if ((isset($_SERVER['HTTP_REFERER'])) and ($_SERVER['HTTP_REFERER'] != '')) {
      // url must never exceed the length of the database field
      $url = strtolower(substr(urldecode($_SERVER['HTTP_REFERER']), 0, 255));

      // extract search engine data
      $keywords = "";
      // Google
      if (preg_match("/www\.google/i",$url)) {
        preg_match("'(\?|&)q=(.*?)(&|$)'si", " $url ", $keywords);
        $search_engine = 'Google';
      } else
      // AllTheWeb
        if (preg_match("/www\.alltheweb/i",$url)) {
          preg_match("'(\?|&)q=(.*?)(&|$)'si", " $url ", $keywords);
          $search_engine = 'AllTheWeb';
        } else
        // live.com
          if (preg_match("/live\.com/",$url)) {
            preg_match("'(\?|&)q=(.*?)(&|$)'si", " $url ", $keywords);
            $search_engine = 'MSN';
          }
      // MSN
      if (preg_match("/search\.msn/i",$url)) {
        preg_match("'(\?|&)q=(.*?)(&|$)'si", " $url ", $keywords);
        $search_engine = 'MSN';
      } else
      // Yahoo
        if ((preg_match("/yahoo\.com/i",$url)) or (preg_match("/search\.yahoo/i",$url))) {
          preg_match("'(\?|&)p=(.*?)(&|$)'si", " $url ", $keywords);
          $search_engine = 'Yahoo';
        } else
        // Looksmart
          if (preg_match("/looksmart\.com/i",$url)) {
            preg_match("'(\?|&)qt=(.*?)(&|$)'si", " $url ", $keywords);
            $search_engine = 'Looksmart';
          } else
          // Ilse (dutch)
            if (preg_match("/ilse\.nl/i",$url)) {
              preg_match("'(\?|&)in=(.*?)(&|$)'si", " $url ", $keywords);
              $search_engine = 'Ilse';
            }
      // Ilse (dutch)
      if (preg_match("/ilse\.nl/i",$url)) {
        preg_match("'(\?|&)search_for=(.*?)(&|$)'si", " $url ", $keywords);
        $search_engine = 'Ilse';
      }

      // create keyword array
      if ( is_array($keywords) && isset($keywords[2]) && ($keywords[2] != '') && ($keywords[2] != ' ')) {
        $keywords = preg_replace('/"|\'/', '', $keywords[2]); // remove quotes
        $keyword_array = preg_split("/[\s,\+\.]+/",$keywords); // create keyword array
      }
      // save
      if ($search_engine != '') {
        // save search engine and keywords to database
        $this->IncreaseValue("count_search_engine", $search_engine);
        $statkeywords=$this->ReplaceKeywords(join($keyword_array, " "));
        $statkeywords=utf8_encode($statkeywords);
        if ($this->singlekeywords=='1') {
          $singlekeywords=explode(' ',$statkeywords);
          foreach ($singlekeywords as $keyword) {
            $this->IncreaseValue("count_search_keywords", trim($keyword));
          }
        } else {
          $this->IncreaseValue("count_search_keywords", trim($statkeywords));
        }

      } else {
        // save plain referer url
        $pos=strpos($url,"/",7);
        if ($pos!=false) $url=substr($url,0,$pos+1);
        if (!$this->IgnoreReferer($url)) {
          if (strlen($url)>5) {
            $this->IncreaseValue("count_referer", $url);
          }
        }
      }
    } else {
      // save empty referer string (browser does not support referer or truly no referer)
      //if ($_SERVER['HTTP_REFERER'] == '' || !isset($_SERVER['HTTP_REFERER'])) {
      //$this->IncreaseValue("count_referer", "");
      //}
    }
  }



  function GetResult($showwhat,$params) {
    //echo $showwhat;
    switch ($showwhat) {
      case "visitorip" : return $_SERVER["REMOTE_ADDR"];
      case "visitorcountry" : return $this->GetCountryName($this->DetectCountry($_SERVER["REMOTE_ADDR"]));
      case "visitorcountrycode" : return $this->DetectCountry($_SERVER["REMOTE_ADDR"]);
      case "day" :
        return $this->GetValue("count_day",date("Ymd",time()),0);
      case "week" :
        if ((date("W",time())>5) AND (date("j",time())==1)) {
          return $this->GetValue("count_week",(date("Y",time())-1).date("W",time()),0);
        } else {
          if ((date("W",time())>5) AND (date("m",time())==1)) {
            return $this->GetValue("count_week",(date("Y",time())-1).date("W",time()),0);
          } else {
            return $this->GetValue("count_week",date("YW",time()),0);
          }
        }
      case "month" : {
          return $this->GetValue("count_month",date("Ym",time()),0);
        }
      case "online" : {
          return $this->CountOnline();
        }
      case "active" : {
          return $this->CountActive();
        }
      case "toppages" : {
          $howmany=5;
          if (isset($params["howmany"])) $howmany=$params["howmany"];
          return $this->GetTopX($howmany);
        }
      case "pageviews" : {
          return $this->GetValue("count_total_pageviews","",0);
        }
      case "thispageviews" : {
          return $this->GetValue("count_access_page",$this->getcms("content_alias"),0);
        }
      case "thisurlviews" : {
          return $this->GetValue("count_access_url",$this->GetCurrentUrl());
        }
      case "lastreset" : {
          return strftime($this->dateformat,$this->GetPreference("last_reset"));
        }
      case "total" :
      default : {
          return $this->GetValue("count_total","");
        }
    }
  }

  function Execute($showwhat,$params,&$ignored) {
    static $firsttimehere=true;
    $firsttimehere=true;
    //print_r($this->cms->variables["pageinfo"]->content_id/alias);
    $this->ReadSettings();

    if ($firsttimehere) {
      $firsttimehere=false;
      if (!$this->IgnoreVisitor()){
        $this->Log("*** STARTING SESSION ***");

        $this->IncreaseValue("count_total_pageviews");
        if (!$id=$this->ExistingVisitor()) {
          $this->CleanVisitors(); //needed every time? Yes... too slow if done too seldom
          $this->CleanReferers();
          $this->Log("User agent:".$_SERVER['HTTP_USER_AGENT']);
          $this->DoComplete();
        } else {
          $this->UpdateVisitor($id);
        }
        if ($this->GetPreference("jsdetects","0")=="1") {
          $this->CheckResolution();
          $this->CheckJavaScript();
        }
        $this->Log("*** ENDING SESSION ***");
        $ignored=false;
      } else {
        $ignored=true;
      }

      $this->Log("");

      $this->SendEmailStats();
    } else {
      $ignored=true;
    }
    return $this->GetResult($showwhat,$params);
  }

  function GetMaxResultValue($values) {
    $max=0;
    for($i=0;$i<count($values);$i++) {
      if ($values[$i]["value"]>$max) $max=$values[$i]["value"];
    }
    return $max;
  }
  function GetTotalResultValue($values) {
    $total=0;
    for($i=0;$i<count($values);$i++) {
      $total+=$values[$i]["value"];
    }
    return $total;
  }

  function ResetData($key="") {
    $db=$this->GetDb();
    $sql="DELETE FROM ".cms_db_prefix()."module_stat_data";
    $params=array();
    if ($key!="") {
      $sql.=" WHERE name=?";
      $params=array($key);
    }

    $db->Execute($sql,$params);
    $this->SetPreference("last_reset",time());
  }

  function ResetVisitors() {
    $db=$this->GetDb();
    $sql="DELETE FROM ".cms_db_prefix()."module_stat_visitors";
    $db->Execute($sql);
    $sql="DELETE FROM ".cms_db_prefix()."module_stat_visitortrack";
    $db->Execute($sql);
  }

  function ResetDebugLog() {
    $db=$this->GetDb();
    $sql="DELETE FROM ".cms_db_prefix()."module_stat_logstrings";
    $db->Execute($sql);
  }

  function GetLengthIndicator($units) {
    switch ($this->charttype) {
      case "text" : {
          $dotchar=$this->GetPreference("dotchar","&#8226;");
          $d="";
          for ($ii=0;$ii<$units;$ii++) $d.=$dotchar;
          return $d;
        }
      case "graphics" : {
          $gfx="<img alt=\"\"   src='../modules/Statistics/img/bar-left.gif' />";
          $gfx.="<img alt=\"\"  src='../modules/Statistics/img/bar-middle.gif' height=\"13\" width='".($units*4)."' />";
          $gfx.="<img alt=\"\"  src='../modules/Statistics/img/bar-right.gif' />";
          return $gfx;
        }
    }
  }

  function ShowSomeChart($title,$icon,$values,$label,$total=-1,$max=-1,$dotslabel="&nbsp;") {
    if (!$values) {
      $this->ShowNoStats($title);
      return;
    }
    $smarty = cmsms()->GetSmarty();
    $smarty->assign("title",$title);
    $smarty->assign("icon",$icon);
    $maxdots=$this->GetPreference("maxdots",32);

    $headers=array("#",$label,$this->lang("count"));


    if ($total>0) $headers[]="%";
    if ($max>0) $headers[]=$dotslabel;
    $smarty->assign("headers",$headers);
    $rows=array();
    for ($i=0; $i<count($values);$i++) {

      $row=array(($i+1),$values[$i]["label"],$values[$i]["value"]);
      if ($total>0) {
        $percent=round(($values[$i]["value"]/$total)*100);
        $row[]=$percent."%";
      }
      if ($max>0) {
        $dots=round(($values[$i]["value"]/$max)*$maxdots);

        $row[]=$this->GetLengthIndicator($dots);
      }
      $rows[]=$row;

    }
    $smarty->assign("rows",$rows);
    $smarty->assign('rowcount',count($rows));
    $smarty->assign('iconset',$this->iconset);
    echo $this->ProcessTemplate("stattable.tpl");

  }

  function ShowTextChart($type) {
    switch ($type) {
      case "days" :
        $values=$this->GetDayValues();
        $this->ShowSomeChart($this->lang("Days"),"days.png",$values,$this->lang("Day"),-1,$this->GetMaxResultValue($values));
        break;
      case "weekdays" :
        $values=$this->GetWeekDayValues();

        $this->ShowSomeChart($this->lang("weekdays"),"weekdays.png",$values,$this->lang("Weekday"),$this->GetTotalResultValue($values),$this->GetMaxResultValue($values));

        break;
      case "timeofday" :
        $values=$this->GetTimeOfDayValues();

        $this->ShowSomeChart($this->lang("timeofday"),"times.png",$values,$this->lang("timeofday"),$this->GetTotalResultValue($values),$this->GetMaxResultValue($values));

        break;
      case "weeks" :
        $values=$this->GetWeekValues();

        $this->ShowSomeChart($this->lang("Weeks"),"weeks.png",$values,$this->lang("Week"),-1,$this->GetMaxResultValue($values));

        break;
      case "months" :
        $values=$this->GetMonthValues();

        $this->ShowSomeChart($this->lang("Months"),"months.png",$values,$this->lang("Month"),-1,$this->GetMaxResultValue($values));

        break;
      case "years" :
        $values=$this->GetYearValues();

        $this->ShowSomeChart($this->lang("Years"),"years.png",$values,$this->lang("Year"),-1,$this->GetMaxResultValue($values));

        break;
      case "browsers" :
        $values=$this->GetBrowserValues();

        $this->ShowSomeChart($this->lang("Browsers"),"browsers.png",$values,$this->lang("Browser"),$this->GetTotalResultValue($values),$this->GetMaxResultValue($values));

        break;
      case "oses" :
        $values=$this->GetOsValues();

        $this->ShowSomeChart($this->lang("OSes"),"oses.png",$values,$this->lang("OS"),$this->GetTotalResultValue($values),$this->GetMaxResultValue($values));

        break;

      case "smartphones" :
        $values=$this->GetSmartphoneValues();

        $this->ShowSomeChart($this->lang("smartphones"),"smartphones.png",$values,$this->lang("smartphone"),$this->GetTotalResultValue($values),$this->GetMaxResultValue($values));

        break;
      case "countries" :
        $values=$this->GetCountryValues();
        
        $this->ShowSomeChart($this->lang("Countries"),"countries.png",$values,$this->lang("Country"),$this->GetTotalResultValue($values),$this->GetMaxResultValue($values));

        break;
      case "pagesaccess" :
        $values=$this->GetPageValues();

        $this->ShowSomeChart($this->lang("pages"),"pages.png",$values,$this->Lang("page"),$this->GetTotalResultValue($values),$this->GetMaxResultValue($values),$this->Lang("pageaccess"));

        break;
      case "pagesfirst" :
        $values=$this->GetFirstPageValues();

        $this->ShowSomeChart($this->lang("firstpages"),"",$values,$this->Lang("page"),$this->GetTotalResultValue($values),$this->GetMaxResultValue($values),$this->Lang("firstpagehits"));

        break;
      case "pageslast" :
        $values=$this->GetLastPageValues();

        $this->ShowSomeChart($this->lang("lastpages"),"",$values,$this->Lang("page"),$this->GetTotalResultValue($values),$this->GetMaxResultValue($values),$this->Lang("lastpagehits"));

        break;
      case "referers" :
        $values=$this->GetRefererValues();

        $this->ShowSomeChart($this->lang("referers"),"referers.png",$values,$this->Lang("referers"),$this->GetTotalResultValue($values),$this->GetMaxResultValue($values));

        break;
      case "searchengines" :
        $values=$this->GetSearchEngineValues();

        $this->ShowSomeChart($this->lang("searchengines"),"searchengines.png",$values,$this->Lang("searchengines"),$this->GetTotalResultValue($values),$this->GetMaxResultValue($values));

        break;
      case "robots" :
        $values=$this->GetRobotValues();
        $this->ShowSomeChart($this->lang("robots"),"robots.png",$values,$this->Lang("robots"),$this->GetTotalResultValue($values),$this->GetMaxResultValue($values));
        break;
      case "searchkeywords" :
        $values=$this->GetSearchKeywordValues();
        $this->ShowSomeChart($this->lang("keyword"),"",$values,$this->Lang("keyword"),$this->GetTotalResultValue($values),$this->GetMaxResultValue($values));
        break;
      case "screenresolutions" :
        $values=$this->GetScreenResolutionValues();
        $this->ShowSomeChart($this->lang("screenresolutions"),"resolutions.png",$values,$this->Lang("screenresolution"),$this->GetTotalResultValue($values),$this->GetMaxResultValue($values));
        break;
      case "colordepths" :
        $values=$this->GetColordepthValues();

        $this->ShowSomeChart($this->lang("colordepths"),"",$values,$this->Lang("colordepth"),$this->GetTotalResultValue($values),$this->GetMaxResultValue($values));

        break;
      default : echo "Unknown stattype";
        return;
    }
  }

  function GenerateJQPlotLines($type, $title,$icon,$values) {
    $jqlabels="";
    $jqvalues="";
    $maxvalue=0;
    if (!is_array($values)) $values=array();
    foreach ($values as $value) {
      if ($jqlabels!="") $jqlabels.=",";
      if ($jqvalues!="") $jqvalues.=",";
      $jqlabels.="'".$value["label"]."'";
      //$jqvalues.="'".$value["value"]."'";
      $jqvalues.="['".$value["label"]."',".$value["value"]."]";
      if ($value["value"]>$maxvalue) $maxvalue=$value["value"];
    }
    $config = cmsms()->GetConfig();
    $smarty = cmsms()->GetSmarty();
    $smarty->assign('rooturl',$config["root_url"]);
    $smarty->assign('jqplotx',$this->jqplotx);
    $smarty->assign('jqploty',$this->jqploty);
    $smarty->assign('title',$title);
    $smarty->assign('count',count($values));
    $smarty->assign('icon',$icon);
    $smarty->assign('values',$jqvalues);
    $smarty->assign('maxvalue',str_replace(',','.',($maxvalue*1.1)));
    //$smarty->assign('labels',$jqlabels);
    echo $this->ProcessTemplate("jqlines.tpl");
  }

  function GenerateJQPlotBars($type, $title,$icon,$values) {
    $jqlabels="";
    $jqvalues="";
    //print_r($values);
    $maxvalue=0;
    if (!is_array($values)) $values=array();
    foreach ($values as $value) {
      if ($jqlabels!="") $jqlabels.=",";
      if ($jqvalues!="") $jqvalues.=",";
      $jqlabels.="'".$value["label"]."'";
      //$jqvalues.="'".$value["value"]."'";
      $jqvalues.="['".str_replace('&nbsp;',' ', $value["label"])."',".$value["value"]."]";
      if ($value["value"]>$maxvalue) $maxvalue=$value["value"];
    }
    $config = cmsms()->GetConfig();
    $smarty = cmsms()->GetSmarty();
    $smarty->assign('rooturl',$config["root_url"]);
    $smarty->assign('title',$title);
    $smarty->assign('icon',$icon);
    $smarty->assign('jqplotx',$this->jqplotx);
    $smarty->assign('jqploty',$this->jqploty);
    $smarty->assign('values',$jqvalues);
    $smarty->assign('maxvalue',str_replace(',','.',($maxvalue*1.1)));
    $smarty->assign('labels',$jqlabels);
    echo $this->ProcessTemplate("jqbars.tpl");
  }

  function GenerateJQPlotPie($type, $title,$icon,$values) {
    //$jqlabels="";
    $jqvalues="";
    if (!is_array($values)) $values=array();
    foreach ($values as $value) {
      //if ($jqlabels!="") $jqlabels.=",";
      if ($jqvalues!="") $jqvalues.=",";
      //$jqlabels.="'".$value["label"]."'";
      //$jqvalues.="'".$value["value"]."'";
      $jqvalues.="['".$value["label"]."',".$value["value"]."]";
    }

    $config = cmsms()->GetConfig();
    $smarty = cmsms()->GetSmarty();
    $smarty->assign('rooturl',$config["root_url"]);
    $smarty->assign('title',str_replace("'","",$title));
    //$smarty->assign('title',$title);
    $smarty->assign('icon',$icon);
    $smarty->assign('jqplotx',$this->jqplotx);
    $smarty->assign('jqploty',$this->jqploty);
    $smarty->assign('values',$jqvalues);
    //$smarty->assign('labels',$jqlabels);
    echo $this->ProcessTemplate("jqpie.tpl");
  }

  function ShowJQPlot($type) {
    $config = cmsms()->GetConfig();

    $result=true;
    //OK we have to make it...
    $title="";
    $icon="";
    switch ($type) {
      case "days" : {
          $icon="days.png";
          $title=$this->lang("Days");
          $values=$this->GetDayValues();
          $this->GenerateJQPlotLines("days",$title,$icon,$values);
          break;
        }

      case "weekdays" : {
          $icon="weekdays.png";
          $title=$this->lang("weekdays");
          $values=$this->GetWeekdayValues();
          $this->GenerateJQPlotLines("weekdays",$title,$icon,$values);
          break;
        }

      case "timeofday" : {
          $icon="times.png";
          $title=$this->lang("timeofday");
          $values=$this->GetTimeofdayValues();
          $this->GenerateJQPlotLines("timeofday",$title,$icon,$values);
          break;
        }

      case "weeks" : {
          $icon="weeks.png";
          $title=$this->lang("Weeks");
          $values=$this->GetWeekValues();
          $this->GenerateJQPlotLines("weeks",$title,$icon,$values);
          break;
        }

      case "months" : {
          $icon="months.png";
          $title=$this->lang("Months");
          $values=$this->GetMonthValues();
          $this->GenerateJQPlotLines("months",$title,$icon,$values);
          break;
        }

      case "years" : {
          $icon="years.png";
          $title=$this->lang("Years");
          $values=$this->GetYearValues();
          $this->GenerateJQPlotLines("years",$title,$icon,$values);
          break;
        }
      case "browsers" : {
          $icon="browsers.png";
          $title=$this->lang("Browsers");
          $values=$this->GetBrowserValues();
          $this->GenerateJQPlotPie("browsers",$title,$icon,$values);
          break;
        }
      case "oses" : {
          $icon="oses.png";
          $title=$this->lang("OSes");
          $values=$this->GetOSValues();
          $result=$this->GenerateJQPlotPie("oses",$title,$icon,$values);
          break;
        }
      case "smartphones" : {
          $icon="smartphones.png";
          $title=$this->lang("smartphones");
          $values=$this->GetSmartphoneValues();
          $result=$this->GenerateJQPlotPie("smartphones",$title,$icon,$values);
          break;
        }
      case "countries" : {
          $icon="countries.png";
          $title=$this->lang("Countries");
          $values=$this->GetCountryValues(false);
          $result=$this->GenerateJQPlotPie("countries",$title,$icon,$values);
          break;
        }
      case "pagesaccess" :
        $values=$this->GetPageValues();
        $this->ShowSomeChart($this->lang("pages"),"pages.png",$values,$this->Lang("page"),$this->GetTotalResultValue($values),$this->GetMaxResultValue($values),$this->Lang("pageaccess"));
        return;
      case "pagesfirst" :
        $values=$this->GetFirstPageValues();
        $this->ShowSomeChart($this->lang("firstpages"),"",$values,$this->Lang("page"),$this->GetTotalResultValue($values),$this->GetMaxResultValue($values),$this->Lang("firstpagehits"));
        return;
      case "pageslast" :
        $values=$this->GetLastPageValues();
        $this->ShowSomeChart($this->lang("lastpages"),"",$values,$this->Lang("page"),$this->GetTotalResultValue($values),$this->GetMaxResultValue($values),$this->Lang("lastpagehits"));
        return;
      case "referers" :
        $values=$this->GetRefererValues();
        $this->ShowSomeChart($this->lang("referers"),"referers.png",$values,$this->Lang("referers"),$this->GetTotalResultValue($values),$this->GetMaxResultValue($values));
        return;
      case "searchengines" :
        $values=$this->GetSearchEngineValues();
        $this->ShowSomeChart($this->lang("searchengines"),"searchengines.png",$values,$this->Lang("searchengines"),$this->GetTotalResultValue($values),$this->GetMaxResultValue($values));
        return;
      case "robots" :
        $values=$this->GetRobotValues();
        $this->ShowSomeChart($this->lang("robots"),"robots.png",$values,$this->Lang("robots"),$this->GetTotalResultValue($values),$this->GetMaxResultValue($values));
        return;
      case "searchkeywords" :
        $values=$this->GetSearchKeywordValues();
        $this->ShowSomeChart($this->lang("keyword"),"",$values,$this->Lang("keyword"),$this->GetTotalResultValue($values),$this->GetMaxResultValue($values));
        $this->ShowNoStats($this->lang("timeofday"));
        return;
      case "screenresolutions" :
        $icon="screenresolutions.png";
        $title=$this->lang("screenresolutions");
        $values=$this->GetScreenResolutionValues();
        $result=$this->GenerateJQPlotPie("screenresolutions",$title,$icon,$values);
        break;
      case "colordepths" :
        $icon="colordepths.png";
        $title=$this->lang("colordepths");
        $values=$this->GetColordepthValues();
        $result=$this->GenerateJQPlotPie("screenresolutions",$title,$icon,$values);
        break;

    }
  }

  function ShowChart($type, $forcetext=false) {
    if ($forcetext) {
      $this->ShowTextChart($type);
      return;
    }
    switch ($this->charttype) {

      case "graphics" :
      case "text" : {
          $this->ShowTextChart($type);
          break;
        }
      case "jqplot" : {
          $this->ShowJQPlot($type);
          break;
        }
      case "highcharts" : {
          $this->ShowHCPlot($type);
          break;
        }
    }
  }

  function GetVisitorInfo($visitorid) {
    $db=cmsms()->GetDb();
    $query="SELECT * FROM ".cms_db_prefix()."module_stat_visitors WHERE id=?";
    $params=array($visitorid);
    $dbresult=$db->Execute($query,$params);
    if ($dbresult && $dbresult->RecordCount()) {
      $visitor=$dbresult->FetchRow();
      return $visitor;
    }
    return false;
  }

  function ShowOnline($previous=false,$id=0) {
    $db=cmsms()->GetDb();
    $smarty = cmsms()->GetSmarty();
    $this->CleanVisitors();
    $limit=time()-$this->visitorlimit;
    $query="";
    if ($previous) {
      $query="SELECT * FROM ".cms_db_prefix()."module_stat_visitors WHERE lastseen<? ORDER BY lastseen DESC";
    } else {
      $query="SELECT * FROM ".cms_db_prefix()."module_stat_visitors WHERE lastseen>? ORDER BY lastseen DESC";
    }
    $params=array($limit/*,session_id()*/);
    $dbresult=$db->Execute($query,$params);



    if ($dbresult && $dbresult->RecordCount()) {
      if ($previous) {
        $smarty->assign("title",$this->Lang("previousvisitors"));
      } else {
        $smarty->assign("title",$this->Lang("onlinevisitors"));
      }


      $smarty->assign("icon","visitors.png");
      $headers=array();
      if (!$previous) {
        $headers=array($this->lang("IP"),$this->lang("Host"),$this->lang("lastpageaccess"),$this->lang("currentpage"),$this->lang("pagecount"),$this->Lang("Status"));
      } else {
        $headers=array($this->lang("IP"),$this->lang("Host"),$this->lang("lastpageaccess"),$this->lang("currentpage"),$this->lang("pagecount"));
      }
      $smarty->assign("headers",$headers);

      $rows=array();
      while ($visitor=$dbresult->FetchRow()) {
        $remoteaddr=$visitor["remoteaddr"];
        $host=$visitor["remotehost"];//$this->GetHostFromIP($visitor["remoteaddr"]);
        if ($this->visitortracking=="1") {
          $remoteaddr=$this->CreateLink($id,"defaultadmin",0,$remoteaddr,array("trackid"=>$visitor["id"],"activetab"=>"tracking","show"=>"visitors"));
          $host=$this->CreateLink($id,"defaultadmin",0,$host,array("trackid"=>$visitor["id"],"activetab"=>"tracking","show"=>"visitors"));
        }
        $row=array($remoteaddr,$host);
        $timeago=time()-$visitor["lastseen"];
        if ($timeago < 60) {
          $timeago=$timeago."&nbsp;".$this->lang("Seconds")."&nbsp;".$this->lang("ago");
        } elseif ($timeago < 3600) {
          $minutesago=floor($timeago/60);
          $secondsago=$timeago-($minutesago*60);
          if ($minutesago == 1) {
            $timeago=$minutesago."&nbsp;".$this->lang("Minute")."&nbsp;".$secondsago."&nbsp;".$this->lang("Seconds")."&nbsp;".$this->lang("ago");
          } else {
            $timeago=$minutesago."&nbsp;".$this->lang("Minutes")."&nbsp;".$secondsago."&nbsp;".$this->lang("Seconds")."&nbsp;".$this->lang("ago");
          }
        } else {

          $hoursago=floor($timeago/3600);
          $minutesago=floor(($timeago-($hoursago*3600))/60);
          $secondsago=$timeago-(($hoursago*3600)+($minutesago*60));
          if ($hoursago == 1) {
            if ($minutesago == 1) {
              $timeago=$hoursago."&nbsp;".$this->lang("Hour")."&nbsp;".$minutesago."&nbsp;".$this->lang("Minute")."&nbsp;".$secondsago."&nbsp;".$this->lang("Seconds")."&nbsp;".$this->lang("ago");
            } else {
              $timeago=$hoursago."&nbsp;".$this->lang("Hour")."&nbsp;".$minutesago."&nbsp;".$this->lang("Minutes")."&nbsp;".$secondsago."&nbsp;".$this->lang("Seconds")."&nbsp;".$this->lang("ago");
            }
          } else {
            if ($minutesago == 1) {
              $timeago=$hoursago."&nbsp;".$this->lang("Hours")."&nbsp;".$minutesago."&nbsp;".$this->lang("Minute")."&nbsp;".$secondsago."&nbsp;".$this->lang("Seconds")."&nbsp;".$this->lang("ago");
            } else {
              $timeago=$hoursago."&nbsp;".$this->lang("Hours")."&nbsp;".$minutesago."&nbsp;".$this->lang("Minutes")."&nbsp;".$secondsago."&nbsp;".$this->lang("Seconds")."&nbsp;".$this->lang("ago");
            }
          }
        }

        $row[]=$timeago;
        $row[]=$this->GetShortPageTitle($visitor["lastpage"]);
        $row[]=$visitor["pagecount"];

        if (!$previous) {
          $status=$this->Lang("Active");
          $timeago=time()-$visitor["lastseen"];
          if ($timeago>$this->activelimit) $status=$this->Lang("Inactive");

          $row[]=$status;
        }
        $rows[]=$row;
      }
      $smarty->assign("rows",$rows);

      echo $this->ProcessTemplate("stattable.tpl");

    } else {
      if ($previous) {
        $this->ShowNoStats($this->Lang("previousvisitors"));
      } else {
        $this->ShowNoStats($this->Lang("onlinevisitors"));
      }

    }

  }


  function ShowVisitors($id=0) {
    $this->ShowOnline(false,$id);
    $this->ShowOnline(true,$id);
  }


  function ShowOtherStats() {
  }

  function InternalGetPageTitle($content_alias, $forcemenutext=false) {
    $db=cmsms()->GetDb();
    $query="SELECT content_name,menu_text FROM ".cms_db_prefix()."content WHERE content_alias=? OR content_id=?";
    $dbresult=$db->Execute($query,array($content_alias,$content_alias));
    if (!$dbresult || $dbresult->RecordCount()==0) return $content_alias;
    $row=$dbresult->FetchRow();
    $name=trim($row["content_name"]);
    if ($name=="") $name=trim($row["menu_text"]);
    if (trim($row["menu_text"])!="" && $forcemenutext) $name=trim($row["menu_text"]);

    if ($name=="") $name=$this->Lang("notitle");

    return $name;
  }

  function GetPageTitle($content_alias) {
    $result = $this->InternalGetPageTitle($content_alias);
    return str_replace(" ","&nbsp;",$result." (".$content_alias.")");
  }

  function GetShortPageTitle($content_alias, $maxlen = 30) {
    $result = $this->InternalGetPageTitle($content_alias);
    if (strlen($result) > $maxlen) {
      $result = substr($result, 0, $maxlen-3)."...";
    }
    $result=str_replace(" ","&nbsp;",$result);
    return $result;
  }

  function GetMaxSeckey($name,$default=false) {
    $db=cmsms()->GetDb();
    $query="SELECT seckey FROM ".cms_db_prefix()."module_stat_data WHERE name=? ORDER BY value DESC LIMIT 1";
    $params=array($name);
    $dbresult=$db->Execute($query,$params);
    if ($dbresult && $dbresult->RecordCount()) {
      $row=$dbresult->FetchRow();
      return $row["seckey"];
    } else {
      return $default;
    }
  }

  function GetMaxValue($name) {
    $db=cmsms()->GetDb();
    $query="SELECT value FROM ".cms_db_prefix()."module_stat_data WHERE name=? ORDER BY value DESC LIMIT 1";
    $params=array($name);
    $dbresult=$db->Execute($query,$params);
    if ($dbresult && $dbresult->RecordCount()) {
      $row=$dbresult->FetchRow();
      return $row["value"];
    } else {
      return false;
    }
  }

  function GetValues($name,$orderby="value",$ascdesc="DESC",$limit=-1) {
    $db=$this->GetDb();

    $query="SELECT seckey AS label,value FROM ".cms_db_prefix()."module_stat_data WHERE name=?";
    $params=array($name);

    $query.=" ORDER BY ".$orderby;
    if ($ascdesc=="DESC") {
      $query.=" DESC";
    } else {
      $query.=" ASC";
    }
    if ($limit!=-1) {
      $query.=" LIMIT $limit";
    }
    $dbresult=$db->Execute($query,$params);
    //echo $db->ErrorMsg();
    if ($dbresult && $dbresult->RecordCount()) {
      $rows=array();
      while ($row=$dbresult->FetchRow()) {
        $rows[]=$row;
      }
      return $rows;
    } else {
      return false;
    }
  }

  function GetValue($name,$seckey="",$default=0) {
    $db=$this->GetDb();
    $query="SELECT value FROM ".cms_db_prefix()."module_stat_data WHERE name=?";
    $params=array($name);
    if ($seckey!="") {
      $query.=" AND seckey=?";
      $params=array($name,$seckey);
    }
    $dbresult=$db->Execute($query,$params);
    if ($dbresult && $dbresult->RecordCount()) {
      $row=$dbresult->FetchRow();
      return $row["value"];
    } else {
      return $default;
    }
  }


  function SetValue($name,$seckey,$value) {
    $db=cmsms()->GetDb();

    //Sil: One check too many
    //if ($this->GetValue($name,$seckey,false)===false) {
    $newid=$db->GenID(cms_db_prefix()."module_stat_data_seq");
    $query="INSERT INTO ".cms_db_prefix()."module_stat_data (id,name,seckey,value,updated) VALUES (?,?,?,?,?)";
    $params=array($newid,$name,$seckey,$value,time());
    $dbresult=$db->Execute($query,$params);

    if ($dbresult) return true; else return false;

  }

  function DeleteValue($name,$seckey="") {
    $db=$this->GetDb();
    $query="DELETE FROM ".cms_db_prefix()."module_stat_data WHERE name=?";
    $params=array($name);
    if ($seckey!="") {
      $query.=" AND seckey=?";
      $params=array($name,$seckey);
    }
    $dbresult=$db->Execute($query,$params);
    return ($dbresult!==false);
  }

  function IncreaseValue($name,$seckey="",$setvalue=1) {
    $db=$this->GetDb();
    $query="UPDATE ".cms_db_prefix()."module_stat_data SET value=value+1, updated=? WHERE name=?";
    $params=array(time(),$name);
    if ($seckey!="") {
      $query.=" AND seckey=?";
      $params=array(time(),$name,$seckey);
    }
    $dbresult=$db->Execute($query,$params);

    if (!$dbresult || $db->Affected_rows()==0) {
      return $this->SetValue($name,$seckey,$setvalue);
    }
    return true;
  }

  function AddToValue($name,$seckey,$valuetoadd) {
    $db=$this->GetDb();
    $query="UPDATE ".cms_db_prefix()."module_stat_data SET value=value+?, updated=? WHERE name=?";
    $params=array(time(),$name,$valuetoadd);
    if ($seckey!="") {
      $query.=" AND seckey=?";
      $params=array(time(),$name,$seckey);
    }
    $dbresult=$db->Execute($query,$params);

    if (!$dbresult || $db->Affected_rows()==0) {
      return $this->SetValue($name,$seckey,$valuetoadd);
    }
    return true;
  }

  function CleanReferers() {
    $db=$this->GetDb();
    $limit=time()-$this->expirytime;
    $query="SELECT seckey FROM ".cms_db_prefix()."module_stat_data WHERE name='count_referer' AND updated<?";
    $params=array($limit);

    $dbresult=$db->Execute($query,$params);
    if ($dbresult && $dbresult->RecordCount()>0) {
      while ($row=$dbresult->FetchRow()) {
        $this->Log("Removed expired referer: ".$row["seckey"]);
        $q2="DELETE FROM ".cms_db_prefix()."module_stat_data WHERE name='count_referer' AND seckey=?";
        $dbresult2=$db->Execute($q2,array($row["seckey"]));
      }
    }
    return ($dbresult!=false);
  }

  function CleanVisitors() {
    $db=cmsms()->GetDb();
    $limit=time()-$this->visitorlimit;
    $query="SELECT * FROM ".cms_db_prefix()."module_stat_visitors WHERE lastseen<? ORDER BY lastseen DESC";
    $params=array($limit);
    $count=$this->gonetokeep;
    $dbresult=$db->Execute($query,$params);
    if ($dbresult && $dbresult->RecordCount()>0) {
      while ($row=$dbresult->FetchRow()) {
        if ($count==0) {
          if ($row["lastpage"]!="") {
            $this->IncreaseValue("count_last_page",$row["lastpage"]);
          }
          if ($row["pagecount"]==1) {
            $this->IncreaseValue("count_bounces");
          }
          $this->Log("Removed gone client ".$row["remoteaddr"]);
          $q2="DELETE FROM ".cms_db_prefix()."module_stat_visitors WHERE id=?";
          $dbresult2=$db->Execute($q2,array($row["id"]));
          $q2="DELETE FROM ".cms_db_prefix()."module_stat_visitortrack WHERE visitorid=?";
          $dbresult2=$db->Execute($q2,array($row["id"]));
        } else {
          $count--;
        }
      }
    }
    return ($dbresult!=false);
  }

  function CheckResolution() {
    if (isset($_SESSION["cmsms_module_statistics_screenres"])) return;
    if(!isset($_COOKIE["cmsms_statistics_module_resolution"])) return;
    $_SESSION["cmsms_module_statistics_screenres"]="Already Done";
    $this->IncreaseValue("count_screenresolution",$_COOKIE["cmsms_statistics_module_resolution"]);
    if (isset($_COOKIE["cmsms_statistics_module_colordepth"])) {
      $this->IncreaseValue("count_colordepth",$_COOKIE["cmsms_statistics_module_colordepth"]);
    }
  }

  function CheckJavaScript() {
    if (isset($_SESSION["cmsms_statistics_javascript_checked"])) return;
    if (!isset($_COOKIE["cmsms_statistics_javascript_detected"])) {
      $this->IncreaseValue("count_has_js","no");
    } else {
      $this->IncreaseValue("count_has_js","yes");
    }
  }

  function ExistingVisitor() {
    $db=$this->GetDb();
    $query="SELECT id FROM ".cms_db_prefix()."module_stat_visitors WHERE sessionid=?";
    $params=array(session_id());
    $dbresult=$db->Execute($query,$params);

    if ($dbresult && $dbresult->RecordCount()) {
      $row=$dbresult->FetchRow();
      $this->Log("Found as existing visitor");
      return $row["id"];
    } else {
      return false;
    }
  }

  function IgnoreThisPage($page="") {
    // ip addresses to ignore are separated by semicolons (like 172.10.1.93;172.10.1.94)
    $contentid="";
    $contentalias="";
    if ($page!="") {
      $contentid=$page;
      $contentalias=$page;
    } else {
      $contentid=$this->getcms("content_id");
      $contentalias=$this->getcms("content_alias");
    }
    if ($this->ignorepages!="") {
      $badpages=explode(";",$this->ignorepages);
      foreach($badpages as $badpage) {
        if (trim($badpage)==$contentid) {
          $this->Log("Ignoring visitor because of ignore page-list (page-id:".$contentid.")");
          return true;
        }
        if (trim($badpage)==$contentalias) {
          $this->Log("Ignoring visitor because of ignore page-list (page-alias:".$contentalias.")");
          return true;
        }
      }
    }
    return false;
  }

  function IgnoreThisIP() {
    if ($this->ignoreips!="") {
      $ip = $_SERVER["REMOTE_ADDR"];
      if (isset($ip)) {
        $badips=explode(";",$this->ignoreips);
        foreach($badips as $badip) {
          if (fnmatch(trim($badip),$ip)) {
            $this->Log("Ignoring visitor because of ignore IP-list (".$ip.")");
            return true;
          }
        }
      }
    }
    return false;
  }


  function IgnoreThisAdmin() {
    if ($this->ignoreadmins!="1") return false;
    $ignoreips=$this->GetPreference("adminips");
    if ($ignoreips!="") {
      $ip = $_SERVER["REMOTE_ADDR"];
      if (isset($ip)) {
        $badips=explode(";",$ignoreips);
        foreach($badips as $badip) {
          if (fnmatch(trim($badip),$ip)) {
            $this->Log("Ignoring visitor because of ignore Admin-IP-list (".$ip.")");
            return true;
          }
        }
      }
    }
    return false;
  }

  function IgnoreThisVisitor() {
    if ($this->ignorevisitors!="") {
      $ip = $_SERVER["REMOTE_ADDR"];
      $host=$this->GetHostFromIP($ip);
      if (isset($ip) && $host!=$ip) {
        $badvisitors=explode(";",$this->ignorevisitors);
        foreach($badvisitors as $badvisitor) {
          if (trim($badvisitor)!="") {
            $badvisitor="/".trim($badvisitor)."/i";
            if (preg_match($badvisitor,$host)) {
              //if (fnmatch(trim(strtolower($badvisitor)),strtolower($host))) {
              $this->Log("Ignoring visitor because of ignore visitor-list (".$host.")");
              return true;
            }
          }
        }
      }
    }
    return false;
  }

  function IgnoreReferer($referer) {
    if ($this->ignorereferers!="") {
      $badreferers=explode(";",$this->ignorereferers);
      foreach($badreferers as $badreferer) {
        if (trim($badreferer)!="") {
          $badreferer="/".trim($badreferer)."/i";
          if (preg_match($badreferer,$referer)) {
            $this->Log("Ignoring visitor because of ignore referer-list (".$referer.")");
            return true;
          }
        }
      }
    }
    $config = cmsms()->GetConfig();
    $rooturl=str_replace('/','\/',$config["root_url"]);
    $rooturl="/".$rooturl."/i";
    if (preg_match($rooturl,$referer)) {
      $this->Log("Ignoring visitor because of self-referer (".$referer.")");
      return true;
    }
    return false;
  }

  function IgnoreRobot() {
    include_once(dirname(__FILE__)."/browsersniffer.php");
    $sniffer=new BrowserSniffer();
    if ($sniffer->IsRobot($this->extrarobots)) {
      $this->IncreaseValue("count_robot",$sniffer->robot);
      if ($this->ignorerobots=="1") {
        $this->Log("Ignoring visitor because it was recognized as a robot (".$sniffer->robot.")");
        return true;
      }
    }
    return false;
  }

  function IgnoreVisitor() {
    static $alreadybeenhere=false;
    if ($alreadybeenhere) {
      $this->Log("Ignoring visitor because of already seen this session");
      return true;
    } else {
      $alreadybeenhere=true;
    }
    if ($this->IgnoreThisVisitor()) return true;
    if ($this->IgnoreThisIP()) return true;
    if ($this->IgnoreThisPage()) return true;
    if ($this->IgnoreRobot()) return true;
    if ($this->IgnoreThisAdmin()) return true;
    return false;
  }

  function VisitorActive() {
    $db=$this->GetDb();
    $limit=time()-$this->activelimit;
    $query="SELECT id FROM ".cms_db_prefix()."module_stat_visitors WHERE lastseen<? AND sessionid=?";
    $params=array($limit,session_id());
    $dbresult=$db->Execute($query,$params);

    if ($dbresult && $dbresult->RecordCount()) return true; else return false;
  }

  function UpdateVisitor($id) {
    $this->IncreaseValue("count_access_page",$this->getcms("content_alias"));
    if ($this->counturlaccess=="1") {
      $this->IncreaseValue("count_access_url",$this->GetCurrentURL());
    }
    $db=$this->GetDb();
    $query="UPDATE ".cms_db_prefix()."module_stat_visitors SET lastseen=?,lastpage=?,pagecount=pagecount+1 WHERE sessionid=?";
    $params=array(time(),$this->getcms("content_id"),session_id());
    $dbresult=$db->Execute($query,$params);

    if ($this->visitortracking=="1") {
      //$id=$this->ExistingVisitor();

      $query="INSERT INTO ".cms_db_prefix()."module_stat_visitortrack (visitorid,accesstime,pageid) VALUES (?,?,?)";
      $params=array($id,time(),$this->getcms("content_id"));
      $dbresult=$db->Execute($query,$params);
    }
    if ($dbresult && $db->Affected_Rows()) return true; else return false;
  }

  function InsertVisitor() {
    $this->IncreaseValue("count_first_page",$this->getcms("content_alias"));
    $this->IncreaseValue("count_access_page",$this->getcms("content_alias"));
    if ($this->counturlaccess=="1") {
      $this->IncreaseValue("count_access_url",$this->GetCurrentURL());
    }
    
    $remoteaddr=$_SERVER['REMOTE_ADDR'];
    //echo $this->iphandling;
    if ($this->iphandling=="half") {
      $addrparts=explode(".",$remoteaddr);
      if (count($addrparts)!=4) {
        //echo "hi"; echo count($remoteaddr);
        //print_r($addrparts);
        $this->Log("Something strange happened when parsing this IP-address: [".$remoteaddr."]");
        exit;
      }
      //echo "half";
      $remoteaddr=$addrparts[0].".".$addrparts[1].".x.x";
    }
    if ($this->iphandling=="none") {
      $remoteaddr=$this->Lang("ipnotrecorded");
    }
    $db=cmsms()->GetDb();
    $newid=$db->GenID(cms_db_prefix()."module_stat_visitors_seq");
    

    $referer="";
    if (isset($_SERVER['HTTP_REFERER'])) $referer=$_SERVER['HTTP_REFERER'];
    $query="INSERT INTO ".cms_db_prefix()."module_stat_visitors (id,sessionid,remoteaddr,remotehost,lastseen,lastpage,pagecount,referer) VALUES (?,?,?,?,?,?,?,?)";
    $params=array($newid,session_id(),$remoteaddr,$this->GetHostFromIP($remoteaddr),time(),$this->getcms("content_id"),1,$referer);
    $dbresult=$db->Execute($query,$params);
    //if (!$dbresult) echo "errror";

    if ($this->visitortracking=="1") {
      $query="INSERT INTO ".cms_db_prefix()."module_stat_visitortrack (visitorid,accesstime,pageid) VALUES (?,?,?)";
      $params=array($newid,time(),$this->getcms("content_id"));
      $dbresult=$db->Execute($query,$params);
    }

    $this->Log("Inserting new visitor");
    if ($dbresult && $dbresult->RecordCount()) return true; else return false;
  }

  function GetTrackingData($visitorid) {
    $db=cmsms()->GetDb();
    $query="SELECT * FROM ".cms_db_prefix()."module_stat_visitortrack WHERE visitorid=? ORDER BY accesstime";
    $params=array($visitorid);
    $dbresult=$db->Execute($query,$params);
    if ($dbresult && $dbresult->RecordCount()) {
      $rows=array();
      while ($row=$dbresult->FetchRow()) {
        $rows[]=$row;
      }
      return $rows;
    } else {
      return false;
    }
  }


  function ReadSettings() {
    $this->activelimit=$this->GetPreference("activelimit",300);
    $this->visitorlimit=$this->GetPreference("visitorlimit",1800);
    $this->gonetokeep=$this->GetPreference("gonetokeep",20);
    $this->visitorlimit=$this->GetPreference("visitorlimit",1800);
    $this->showdaylimit=$this->GetPreference("showdaylimit",31);
    $this->showweeklimit=$this->GetPreference("showweeklimit",52);
    $this->showmonthlimit=$this->GetPreference("showmonthlimit",12);
    $this->showyearlimit=$this->GetPreference("showyearlimit",10);
    $this->showbrowserlimit=$this->GetPreference("showbrowserlimit",-1);
    $this->showoslimit=$this->GetPreference("showoslimit",-1);
    $this->showcountrylimit=$this->GetPreference("showcountrylimit",-1);
    $this->showpageslimit=$this->GetPreference("showpageslimit",30);
    $this->showrefererlimit=$this->GetPreference("showrefererlimit",30);
    $this->keywordlimit=$this->GetPreference("keywordlimit",25);
    $this->expirytime=$this->GetPreference("expirytime",(3600*24*31));
    $this->ignoreips=$this->GetPreference("ignoreips","");
    $this->ignorepages=$this->GetPreference("ignorepages","error404");
    $this->ignorevisitors=$this->GetPreference("ignorevisitors","");
    $this->ignorereferers=$this->GetPreference("ignorereferers","");
    $this->ignoreadmins=$this->GetPreference("ignoreadmins","");
    $this->dateformat=$this->GetPreference("dateformat","r");
    $this->debuglog=$this->GetPreference("debuglog",0);
    $this->debugloglevel=$this->GetPreference("debugloglevel",0);
    $this->jsdetects=$this->GetPreference("jsdetects","1");
    $this->jsdetects=$this->GetPreference("jsdetects","1");
    $this->visitortracking=$this->GetPreference("visitortracking","0");
    $this->charttype=$this->GetPreference("charttype","text");
    $this->iconset=$this->GetPreference("iconset","crystalclear");
    $this->topxtemplate=$this->GetTopXTemplate();
    $this->iphandling=$this->GetPreference("iphandling","whole");
    $this->emailtemplate=$this->GetEmailTemplate();
    $this->statemail=$this->GetPreference("statemail","");
    $this->emailsubject=$this->GetPreference("emailsubject","Statistical information from %s");
    $this->emailinterval=$this->GetPreference("emailinterval",-1);
    $this->lastemailtime=$this->GetPreference("lastemailtime",-1);
    $this->ignorerobots=$this->GetPreference("ignorerobots","0");
    $this->extrarobots=$this->GetPreference("extrarobots","");
    $this->countrydetection=$this->GetPreference("countrydetection","superdomain");
    $this->jqplotx=$this->GetPreference("jqplotx","700");
    $this->jqploty=$this->GetPreference("jqploty","500");
    $this->counturlaccess=$this->GetPreference("counturlaccess","1");
    $this->keywordreplacements=$this->GetPreference("keywordreplacements","");
    $this->singlekeywords=$this->GetPreference("singlekeywords","0");
    $this->gfxnumbers=$this->GetPreference("gfxnumbers","digidisplyer");
    $this->adminsection=$this->GetPreference("adminsection","extensions");
  }

  function GetDayValues() {
    $oneday=86400;
    $count=0;
    $val=$this->GetValues("count_day","seckey","DESC",$this->showdaylimit);
    if (!$val) return false;

    for($i=0; $i<count($val);$i++) {
      $val[$i]["label"]=substr($val[$i]["label"],6,2)."/".substr($val[$i]["label"],4,2);
    }
    return $val;
  }

  function GetWeekDayValues() {
    $found=false;
    $statrows=$this->GetValues("count_weekday","seckey");
    $values=array();
    if ($statrows) {
      foreach($statrows as $row) {
        $found=true;
        $values[]=array("label"=>$this->DayName($row["label"]),"value"=>$row["value"]);
      }
    }
    if (!$found) return false; else return $values;
  }

  function GetTimeOfDayValues() {
    $found=false;
    $statrows=$this->GetValues("count_time","seckey","ASC");
    $values=array();
    if ($statrows) {
      foreach($statrows as $row) {
        $found=true;
        $label="";
        if ($row["label"][0]=="0") {
          $label=$row["label"]."-0".($row["label"]+1);
        } else {
          $label=$row["label"]."-".($row["label"]+1);
        }
        $label=str_replace("010","10",$label);

        $values[]=array("label"=>$label,"value"=>$row["value"]);
      }
    }

    if (!$found) return false; else return $values;
  }

  function GetWeekValues() {
    $val=$this->GetValues("count_week","seckey","DESC",$this->showweeklimit);
    if (!$val) return false;
    for($i=0; $i<count($val);$i++) {
      $val[$i]["label"]=substr($val[$i]["label"],4,2)." ".substr($val[$i]["label"],0,4);
    }
    return $val;
  }

  function GetMonthValues() {
    $val=$this->GetValues("count_month","seckey","ASC");
    if (!$val) return false;
    for($i=0; $i<count($val);$i++) {
      $val[$i]["label"]=$this->MonthName(substr($val[$i]["label"],4,2))." ".substr($val[$i]["label"],0,4);
    }
    return $val;
  }

  function GetYearValues() {
    $val=$this->GetValues("count_year","seckey","DESC",$this->showyearlimit);
    return $val;
  }

  function GetBrowserValues() {
    $val=$this->GetValues("count_browser","value","DESC",$this->showbrowserlimit);
    return $val;
  }

  function GetOsValues() {
    $val=$this->GetValues("count_os","value","DESC",$this->showoslimit);
    return $val;
  }

  function GetSmartphoneValues() {
    $val=$this->GetValues("count_smartphone","value","DESC",10);
    return $val;
  }

  function GetCountryName($country_id,$showflag=true) {
    $name=$this->Lang("country_".strtoupper($country_id));
    if (stripos($name,"--Add me")!==false) {
      $name=$this->Lang("country_unknown")." (.".$country_id.")";
    }
    //echo $name;
    $name=htmlentities($name);
    $config = cmsms()->GetConfig();
    if ($showflag) {
      $flag=$config['root_url']."/modules/Statistics/img/flags/".strtolower($country_id).".gif";
      //$flag="../modules/Statistics/img/flags/".strtolower($country_id).".gif";
      if (file_exists($flag)) {
        $flag="<img src='".$flag."' width='20' title='".$name."' alt='".$name."' />";
        $name=$flag."&nbsp;".$name;
      }
    }
    return $name;
  }

  function GetCountryValues($showflag=true) {
    $values=$this->GetValues("count_country","value","DESC",$this->showcountrylimit);
    if (!$values) return false;
    for ($i=0; $i<count($values); $i++) {
      //echo $values[$i]["label"];
      $values[$i]["label"]=($i+1).". ".$this->GetCountryName($values[$i]["label"],$showflag);
    }
    return $values;
  }

  function GetRobotValues() {
    $values=$this->GetValues("count_robot","value","DESC");
    /*	if (!$values) return false;
		for ($i=0; $i<count($values); $i++) {
			echo $values[$i]["label"];			
		}*/
    return $values;
  }

  function GetURLValues() {
    $values=$this->GetValues("count_access_url","value","DESC");
    return $values;
  }

  function GetPageValues() {
    $values=$this->GetValues("count_access_page","value","DESC",$this->showpageslimit);
    if (!$values) return false;
    for ($i=0; $i<count($values); $i++) {
      //echo $values[$i]["label"];
      $values[$i]["label"]=$this->GetShortPageTitle($values[$i]["label"]);
    }
    return $values;
  }

  function GetFirstPageValues() {
    $values=$this->GetValues("count_first_page","value","DESC",$this->showpageslimit);
    if (!$values) return false;
    for ($i=0; $i<count($values); $i++) {
      $values[$i]["label"]=$this->GetShortPageTitle($values[$i]["label"]);
    }
    return $values;
  }

  function GetLastPageValues() {
    $values=$this->GetValues("count_last_page","value","DESC",$this->showpageslimit);
    if (!$values) return false;
    for ($i=0; $i<count($values); $i++) {
      $values[$i]["label"]=$this->GetShortPageTitle($values[$i]["label"]);
    }
    return $values;
  }

  function GetRefererValues() {
    $val=$this->GetValues("count_referer","value","DESC",$this->showrefererlimit);
    if (!$val) return false;
    for($i=0; $i<count($val);$i++) {
      $val[$i]["label"]=substr($val[$i]['label'],0,100);
    }
    return $val;
  }

  function GetSearchKeywordValues() {
    // Get keywords data
    $val=$this->GetValues("count_search_keywords","value","DESC",$this->keywordlimit);
    return $val;
  }

  function GetSearchEngineValues() {
    // Get engines data
    $val=$this->GetValues("count_search_engine","value","DESC");
    return $val;
  }

  function GetScreenResolutionValues() {
    $val=$this->GetValues("count_screenresolution","value","DESC");
    return $val;
  }

  function GetColordepthValues() {
    $val=$this->GetValues("count_colordepth","value","DESC");
    return $val;
  }

  function ShowNoStats($title="") {
    static $alreadyshown=false;
    if ($alreadyshown) return false;
    $smarty = cmsms()->GetSmarty();
    $smarty->assign("sorrytext",$this->Lang("sorry"));
    $smarty->assign("nostatstext",$this->Lang("nodata"));
    $smarty->assign("title",$title);
    $smarty->assign("iconst",$this->iconset);
    echo $this->ProcessTemplate("nostats.tpl");
    $alreadyshown=true;
    return false;
  }

  function CountOnline() {
    $db=cmsms()->GetDb();
    $this->CleanVisitors();
    $limit=time()-$this->visitorlimit;
    $query="SELECT * FROM ".cms_db_prefix()."module_stat_visitors WHERE lastseen>? ORDER BY lastseen DESC";
    $params=array($limit);
    $dbresult=$db->Execute($query,$params);
    if ($dbresult) {
      return $dbresult->RecordCount();
    } else {
      return 0;
    }
  }

  function CountActive() {
    $db=cmsms()->GetDb();
    $this->CleanVisitors();
    $limit=time()-$this->activelimit;
    $query="SELECT * FROM ".cms_db_prefix()."module_stat_visitors WHERE lastseen>? ORDER BY lastseen DESC";
    $params=array($limit);
    $dbresult=$db->Execute($query,$params);
    if ($dbresult) {
      return $dbresult->RecordCount();
    } else {
      return 0;
    }
  }

  function GetTopXTemplate($forcedefault=false) {
    $gCms = cmsms();
    $config = $gCms->GetConfig();
    $defaulttemplate=file_get_contents($config['root_path'] . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . $this->GetName() . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'defaulttopx.tpl');
    if (!$forcedefault) {
      $template=$this->GetPreference("topxtemplate",$defaulttemplate);
      if (trim($template)=="") $template=$defaulttemplate;
    } else {
      $template=$defaulttemplate;
    }
    return $template;
  }

  function GetEmailTemplate($forcedefault=false) {
    $gCms = cmsms();
    $config = $gCms->GetConfig();
    $defaulttemplate=file_get_contents($config['root_path'] . DIRECTORY_SEPARATOR . 'modules' . DIRECTORY_SEPARATOR . $this->GetName() . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'defaultemail.tpl');
    if (!$forcedefault) {
      $template=$this->GetPreference("emailtemplate",$defaulttemplate);
      if (trim($template)=="") $template=$defaulttemplate;
    } else {
      $template=$defaulttemplate;
    }
    return $template;
  }

  function GetTopX($number) {
    $result="";
    $values=$this->GetValues("count_access_page","value","DESC",$number);
    $gCms = cmsms();
    $smarty = cmsms()->GetSmarty();
    $config = $gCms->GetConfig();
    $entries=array();
    for ($i=0; $i<count($values); $i++) {
      $entry = new stdClass();
      $entry->index=($i+1);

      $entry->fulllink="<a href='index.php?".$config["query_var"]."=".$values[$i]["label"]."'>";
      $entry->fulllink.=$this->GetShortPageTitle($values[$i]["label"]);
      $entry->fulllink.="</a>";

      $entry->title=$this->InternalGetPageTitle($values[$i]["label"]);
      $entry->alias=$values[$i]["label"];
      $entry->menutitle=$this->InternalGetPageTitle($values[$i]["label"],true);

      $entry->href="index.php?".$config["query_var"]."=".$values[$i]["label"];

      array_push($entries, $entry);

    }

    $smarty->assign('entries', $entries);
    return $this->ProcessTemplateFromData( $this->GetTopXTemplate() );
  }

  function GetCurrentURL() {
    $urlBASE = "http://".$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
    $url=$urlBASE;
    //if (!empty($_SERVER["QUERY_STRING"])) $urlBASE .= "?".$_SERVER['QUERY_STRING'];
    //$url = str_replace("index.php?page=", "", $urlBASE);
    return $url;
  }

  function MonthName($no) {
    switch ($no) {
      case 1: return $this->lang('jan');
      case 2: return $this->lang('feb');
      case 3: return $this->lang('mar');
      case 4: return $this->lang('apr');
      case 5: return $this->lang('may');
      case 6: return $this->lang('jun');
      case 7: return $this->lang('jul');
      case 8: return $this->lang('aug');
      case 9: return $this->lang('sep');
      case 10: return $this->lang('oct');
      case 11: return $this->lang('nov');
      case 12: return $this->lang('dec');
    }
  }

  function DayName($no) {
    switch ($no) {
      case 0: return $this->Lang("sunday");
      case 1: return $this->Lang("monday");
      case 2: return $this->Lang("tuesday");
      case 3: return $this->Lang("wednesday");
      case 4: return $this->Lang("thursday");
      case 5: return $this->Lang("friday");
      case 6: return $this->Lang("saturday");
    }
  }

  function Log($info, $level=1) {
    if ($this->debuglog!="1") return;
    if ($level>$this->debugloglevel) return;
    if ($info!="") $info="[".$_SERVER['REMOTE_ADDR']."] ".$info;
    $info="[".substr("*****",0,4-$level)."]".$info;
    $db=cmsms()->GetDb();
    $newid=$db->GenID(cms_db_prefix()."module_stat_logstrings_seq");
    $query="INSERT INTO ".cms_db_prefix()."module_stat_logstrings (id,time,info) VALUES (?,?,?)";
    $params=array($newid,time(),$info);
    $result=$db->Execute($query,$params);
    if (!$result) echo $db->ErrorMsg();
  }

  function ShowDebuglines($id,$returnid,$params=array()) {
    $db=cmsms()->GetDb();

    if ($this->GetPreference("maxlogage",-1)!=-1) {
      /*$sql="SELECT time FROM ".cms_db_prefix()."module_stat_logstrings";
			 $result=$db->Execute($sql);
			 if ($result && $result->RecordCount()>0) {
				if ($result->RecordCount()>$this->GetPreference("maxlogsize",1000)) {
				//echo $result->RecordCount();
				$sql="DELETE FROM ".cms_db_prefix()."module_stat_logstrings ORDER BY time DESC LIMIT ? OFFSET ?";
				$params=array($result->RecordCount()-$this->GetPreference("maxlogsize",1000),$this->GetPreference("maxlogsize",1000));
				$result=$db->Execute($sql,$params);
				}
				}*/
      $sql="DELETE FROM ".cms_db_prefix()."module_stat_logstrings WHERE time<?";
      $params=array(time()-$this->GetPreference("maxlogage",(3600*24*7)));
      $dbresult=$db->Execute($sql,$params);
      if ($dbresult) {
        $pruned=$db->Affected_Rows();
        if ($pruned>0) {
          $this->Log($pruned." expired lines pruned from the log");
        }
      }
    }

    $sql="SELECT * FROM ".cms_db_prefix()."module_stat_logstrings ORDER BY time DESC";
    $result=$db->Execute($sql);
    $loglines="";
    $count=0;
    if ($result && $result->RecordCount()) {
      echo $result->RecordCount()." ".$this->Lang("lines")."<br />";
      while ($row=$result->FetchRow()) {
        if ($row["info"]!="") {
          $loglines.=date("r",$row["time"])." ".$row["info"]."\n";
        } else {
          //echo "\n";
          $loglines.="\n";
        }
        $count++;
      }
    } else {
      $loglines=$this->Lang("nologlines");
    }
    $smarty = cmsms()->GetSmarty();
    $smarty->assign("loglines",$loglines);
    $smarty->assign("linecount",$count);
    if (isset($params["show"])) {
      $smarty->assign('show',$this->CreateInputHidden($id,"show",$params["show"]));
    }
    $smarty->assign("formstart",$this->CreateFormStart($id,"resetdata",$returnid,"post","",true));
    $smarty->assign("resetbutton",$this->CreateInputSubmit($id,"resetloglines",$this->Lang("resetloglines"),"","",$this->Lang("confirmresetloglines")));
    $smarty->assign("formend",$this->CreateFormEnd());

    echo $this->ProcessTemplate("debuglog.tpl");
  }

  function is_assoc($array) {
    return (is_array($array) && 0 !== count(array_diff_key($array, array_keys(array_keys($array)))));
  }

  function SmartyAssign($smartyinfo, $smartycontent="") {
    
    $smarty = NULL;
    if( statistics_utils::isCMS2() ) $smarty = $this->GetActionTemplateObject(); 
    if( !is_object($smarty) ) $smarty = cmsms()->GetSmarty();

    if (!is_array($smartyinfo)) {
      if ($smartyinfo!="" && $smartycontent!="") {
        $smarty->assign($smartyinfo, $smartycontent);
      }
      return;
    }
    //Ok it's an array
    if (!$this->is_assoc($smartyinfo)) return;
    foreach($smartyinfo as $smartyname=>$smartycontent) {
      if (is_array($smartycontent)) {
        $smarty->assign($smartyname, $smartycontent);
      } else {
        $smarty->assign($smartyname, $smartycontent);
      }
    }
  }

  function SendEmailStats($force=false) {
    $statemail=$this->GetPreference("statemail","");
    $emailinterval=$this->GetPreference("emailinterval",-1);
    if ($emailinterval==-1) return;
    $lastemailtime=$this->GetPreference("lastemailtime",0);

    if (!$force) {      
      if ($lastemailtime>=(time()-$emailinterval)) return;
      $this->SetPreference("lastemailtime",time());
    }  
    if ($statemail=="") {
      $this->Log("Tried to send emailstats, but nowhere to send it...");
      return false; //Nowhere to send it...
    }
    
    if( statistics_utils::isCMS2() )
    {
      $cmsmailer = new cms_mailer(FALSE); 
    }
    else
    {
      $cmsmailer = $this->GetModuleInstance('CMSMailer');
    }
    
    $cmsmailer->reset();
    foreach (explode(",",$statemail) as $email) {
      $cmsmailer->AddAddress($email);
    }

    $this->SmartyAssign(array(
            "total"=>$this->GetValue("count_total","",0),
            "pageviews"=>$this->GetValue("count_total_pageviews","",0),
            "today"=>$this->GetValue("count_day",date("Ymd",time()),0),
            /*"thisweek"=>$this->*/
            "thismonth"=>$this->GetValue("count_month",date("Ym",time()),0),
            "thisyear"=>$this->GetValue("count_year",date("Y",time()),0),
            "topbrowser"=>$this->GetMaxSeckey("count_browser",$this->Lang("noneyet")),
            "topos"=>$this->GetMaxSeckey("count_os",$this->Lang("noneyet"))
    ));

    if ((date("W",time())>5) AND (date("j",time())==1)) {
      $this->SmartyAssign("thisweek",$this->GetValue("count_week",(date("Y",time())-1).date("W",time()),0));
    } else {
      $this->SmartyAssign("thisweek",$this->GetValue("count_week",date("YW",time()),0));
    }



    $totalsinceemail=$this->GetPreference("totallastemail",-1);
    if ($totalsinceemail==-1) {
      $this->SmartyAssign('totalsinceemail',$this->Lang("firstemail"));
    } else {
      $totalsinceemail=$this->GetValue("count_total","",0)-$totalsinceemail;
      if ($totalsinceemail>0) {
        $this->SmartyAssign('totalsinceemail',$totalsinceemail);
      } else {
        $this->SmartyAssign('totalsinceemail',"0");
      }
    }
    $this->SetPreference("totallastemail",$this->GetValue("count_total","",0));

    $pageviewssinceemail=$this->GetPreference("pageviewssinceemail",-1);
    if ($pageviewssinceemail==-1) {
      $this->SmartyAssign('pageviewssinceemail',$this->Lang("firstemail"));
    } else {
      $pageviewssinceemail=$this->GetValue("count_total_pageviews","",0)-$pageviewssinceemail;
      if ($pageviewssinceemail>0) {
        $this->SmartyAssign('pageviewssinceemail',$pageviewssinceemail);
      } else {
        $this->SmartyAssign('pageviewssinceemail',"0");
      }
    }
    $this->SetPreference("pageviewssinceemail",$this->GetValue("count_total_pageviews","",0));
    $maxcountry=$this->GetMaxSeckey("count_country");
    //if (strlen($maxcountry)==2) */
    //echo $maxcountry;
    if (!$maxcountry) {
      $maxcountry=$this->Lang("noneyet");
    } else {
      $maxcountry=$this->GetCountryName($maxcountry);
    }
    //echo $maxcountry;
    //$rows[]=array($this->lang("mostpopularcountry"),$maxcountry);
    $this->SmartyAssign("topcountry",$maxcountry);

    $cmsmailer->SetBody($this->ProcessTemplateFromData($this->GetPreference("emailtemplate")));
    $cmsmailer->IsHTML(true);
    $config = cmsms()->GetConfig();
    $subject=$this->emailsubject;
    $subject=str_replace("%s",$config["root_url"],$subject);
    $subject=str_replace("%t",$this->cms->siteprefs['sitename'],$subject);
    $cmsmailer->SetSubject($subject);
    $cmsmailer->Send();
  }

  function FireDebug($message,$severity='message',$variables=array()) {
    $firephpmodule=$this->GetModuleInstance('FirePHPDebug');
    if ($firephpmodule) {
      //Module found
      $firephpmodule->ConsoleMessage($this->GetName(),$message, $severity, $variables);
      //More code coming here
    } //else Module not found}
  }

  function OutputGfxText($value) {
    $config = cmsms()->GetConfig();
    switch ($this->gfxnumbers) {
      case "digidisplayer" : {
          return "\n<img src='".$config["root_url"]."/modules/Statistics/numbers/digidisplayer/statisticsoutput.php?value=".$value."' />\n";
        }
    }
  }

  function ShowDonationsTab() {
    return ($this->GetPreference("hidedonationstab")!=$this->GetVersion());
  }
}//end class
?>