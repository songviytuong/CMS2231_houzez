<?php
#-------------------------------------------------------------------------
# Module: Quotes Made Simple
# Author: Morten Poulsen <morten@poulsen.org>
#-------------------------------------------------------------------------
# CMS Made Simple is (c) 2004 - 2011 by Ted Kulp (wishy@cmsmadesimple.org)
# CMS Made Simple is (c) 2011 - 2014 by The CMSMS Dev Team
# This project's homepage is: http://www.cmsmadesimple.org
# The module's homepage is: http://dev.cmsmadesimple.org/projects/quotesms
#-------------------------------------------------------------------------
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
# Or read it online: http://www.gnu.org/licenses/licenses.html#GPL
#-------------------------------------------------------------------------

class Rss{
	var $Count=0;
	var $Template;
	var $Items=array();
	var $CashPath="tmp/";
  var $inerror=false;
  function __construct($url){
  	global $Items;
  	
		if(!$url) {$this->inerror="RSS: url don't exists";return false;}//die("RSS: url don't exists");
		/*$urlx=parse_url($url);
		$Filename=$this->CashPath.$urlx[host].".rss";
		$modifed=time()-@filemtime($Filename);
		if(!file_exists($Filename) || $modifed>CASHE_TIMEOUT){
			if( !($content = file_get_contents($url)) ) {$this->inerror="RSS: source error";return false;}//die("RSS: sourse error");
			$rss_tmp=fopen($Filename,"w");
			fputs($rss_tmp,$content);
			fclose($rss_tmp);
		}
		else*/ $content = file_get_contents($url);
		//echo $content;
		preg_match_all("/<item>(.+)<\/item>/Uis",$content,$Items1,PREG_SET_ORDER);
		foreach($Items1 as $indx=>$var){
			$this->Items[$indx]=$var[1];
		}
		//echo count($this->Items);
	}

	function parseItems(){
		//$Item=$this->Items[$this->Count];
		//
//		if(!$Item) return FALSE;
		//echo "hejsa";
		//$this->Count++;
		$parsedarray=array();
		foreach($this->Items as $item) {
			preg_match_all("/<(title|link|description)>(.+)<\/(\\1)>/is",$item,$ParsedItem,PREG_SET_ORDER);
			$newquote=array("author"=>htmlspecialchars($ParsedItem[0][2],ENT_QUOTES),
											"content"=>strip_tags(html_entity_decode($ParsedItem[1][2])),
											"reference"=>strip_tags(htmlspecialchars($ParsedItem[2][2],ENT_QUOTES)));
			//echo "<pre>",strip_tags($newquote["content"])."</pre>";
			$parsedarray[]=$newquote;
		  /*$ParsedArray["title"]      = htmlspecialchars($ParsedItem[0][2],ENT_QUOTES);
		  $ParsedArray["link"]      = urldecode($ParsedItem[1][2]);
		  $ParsedArray["description"] = htmlspecialchars($ParsedItem[2][2],ENT_QUOTES);*/
		}
		/*preg_match_all("/<(title|link|description)>(.+)<\/(\\1)>/is",$Item,$ParsedItem,PREG_SET_ORDER);
		$ParsedArray["title"]      = htmlspecialchars($ParsedItem[0][2],ENT_QUOTES);
		$ParsedArray["link"]      = urldecode($ParsedItem[1][2]);
		$ParsedArray["description"] = htmlspecialchars($ParsedItem[2][2],ENT_QUOTES);
*/
		/*echo count($parsedarray);
		echo "hej";*/
		
//print_r($parsedarray);
		return $parsedarray;
	}
}

class Quotes extends CMSModule {
	function GetName()  { return 'Quotes'; }
	function GetAdminSection() { return "content"; }
	function GetFriendlyName()  { return $this->Lang("friendlyname"); }
	function IsPluginModule() { return true; 	}
	function HasAdmin() { return true; }
	function GetVersion() { return '1.0.1'; }
	function InstallPostMessage() { return $this->Lang("installpostmessage"); }
	function UnInstallPostMessage() { return $this->Lang('uninstallpostmessage'); }
	function VisibleToAdminUser() { return $this->CheckPermission('managequotes'); }
	function GetAuthor() { return 'Morten Poulsen'; }
	function GetAuthorEmail() { return 'morten@poulsen.org'; }
	function GetChangeLog() { return file_get_contents(dirname(__FILE__).'/changelog.inc'); }
	function GetHelp() { return file_get_contents(dirname(__FILE__).'/help_text.inc'); }
	function MinimumCMSVersion() { return '1.11'; }

	function SetParameters() {
		$this->RestrictUnknownParams();
		$this->RegisterModulePlugin();
		$this->CreateParameter('pickedby', 'random', $this->lang('parampickedbyhelp'));
		$this->SetParameterType('pickedby',CLEAN_STRING);
		$this->CreateParameter('template', '', $this->lang('paramtemplatehelp'));
		$this->SetParameterType('template',CLEAN_STRING);
		$this->CreateParameter('group', '', $this->lang('paramgroupshelp'));
		$this->SetParameterType('group',CLEAN_STRING);
		$this->CreateParameter('quote', '', $this->lang('paramquoteshelp'));
		$this->SetParameterType('quote',CLEAN_STRING);
		$this->CreateParameter('showall', '1', $this->lang('paramshowallhelp'));
		$this->SetParameterType('showall',CLEAN_INT);
		//$this->SetParameterType('startpageoffset',CLEAN_INT);
	}

	function GetTypes() {
		return array(
		$this->Lang("plainquote")=>"1",
		//$this->Lang("rssquote")=>"2",
		//$this->Lang("javascriptquote")=>"3"
		);
	}

	function GetTypeName($type) {
		switch ($type) {
			case "1" : return $this->Lang("plainquote");
			//case "2" : return $this->Lang("rssquote");
			//case "3" : return $this->Lang("javascriptquote");
			default : return "unknown type";
		}
	}
	
	function GetRSSQuote($info) {		
		$quoteinfo=$this->GetQuote("",$info["id"]);
		$rss=new Rss($quoteinfo["content"]);
		if ($rss->inerror!="")  {
			echo $rss->inerror;
		  return false;		  
		}
		$rssquotes=$rss->parseItems();
		if (count($rssquotes)>1) {
			return $this->SelectRandom($rssquotes);
		}
		return $rssquotes[0];
	}

	function GetQuoteProps($quoteid) {
		$db=cmsms()->GetDb();
		$q="SELECT name,value FROM ".cms_db_prefix()."module_quoteprops WHERE quoteid=?";
		$p=array($quoteid);
		$result=$db->Execute($q,$p);
		if (!$result || ($result->NumRows()==0)) {
			return false;
		}
		$output=array();
		while($row=$result->FetchRow()) {
			$output[$row["name"]]=$row["value"];
		}
		return $output;
	}

	function GetQuoteProp($quoteid,$name,$default=false) {
		$props=$this->GetQuoteProps($quoteid);
		if (!$props) return $default;
		if (!isset($props[$name])) return $default;
		return $props[$name];
	}

	function SetQuoteProp($quoteid,$name,$value) {
		if ($quoteid=="") return false;
		$db=cmsms()->GetDb();
		$q="";

		if ($this->GetQuoteProp($quoteid,$name)!==false) {
			$q="UPDATE ".cms_db_prefix()."module_quoteprops SET value=? WHERE name=? AND quoteid=?";
		} else {
			$q="INSERT INTO ".cms_db_prefix()."module_quoteprops (value, name, quoteid) VALUES (?,?,?)";
		}
		
		$p=array($value,$name,$quoteid);
		$result=$db->Execute($q,$p);
		return ($result==true);
	}

	function RemoveQuoteProp($quoteid,$name="") {
		$db=cmsms()->GetDb();
		$q="DELETE FROM ".cms_db_prefix()."module_quoteprops WHERE id=?";
		if ($name!="") $q.="AND name=?";
		$p=array();
		if ($name!="") $p=array($name,$quoteid); else $p=array($quoteid);
		$result=$db->Execute($q,$p);
		return ($result==true);
	}

	function AddGroup($textid,$description) {
		$db=cmsms()->GetDb();
		$newid=$db->GenID(cms_db_prefix()."module_quotegroups_seq");
		$sql="INSERT INTO ".cms_db_prefix()."module_quotegroups (id,textid,description) VALUES (?,?,?)";
		$values=array($newid,$textid,$description);
		$result=$db->Execute($sql,$values);
		return $newid;
	}

	function UpdateGroup($id,$textid,$description) {
		$db=cmsms()->GetDb();
		$q="UPDATE ".cms_db_prefix()."module_quotegroups SET textid=?,description=? WHERE id=?";
		$p=array($textid,$description,$id);
		$result=$db->Execute($q,$p);
		return true;
	}

	function GetGroup($textid="",$id="") {
		$db=cmsms()->GetDb();
		$q="";
		$p="";
		if ($textid!="") {
			$q="SELECT * FROM ".cms_db_prefix()."module_quotegroups WHERE textid=?";
			$p=array($textid);
		} else {
			$q="SELECT * FROM ".cms_db_prefix()."module_quotegroups WHERE id=?";
			$p=array($id);
		}
		$result=$db->Execute($q,$p);
		if (!$result || $result->RecordCount()==0) return false;
		$row=$result->FetchRow();
		return $row;
	}

	function GetGroups() {
		$db=cmsms()->GetDb();
		$q="SELECT * FROM ".cms_db_prefix()."module_quotegroups";

		$result=$db->Execute($q);
		if (!$result || ($result->NumRows()==0)) {
			return false;
		}
		$output=array();
		while($row=$result->FetchRow()) {
			//			print_r($row);
			$output[]=$row;
		}
		return $output;
	}

	function AddQuote($type) {		
		$db=cmsms()->GetDb();
		$newid=$db->GenID(cms_db_prefix()."module_quotes_seq");
		$sql="INSERT INTO ".cms_db_prefix()."module_quotes (id,type) VALUES (?,?)";
		$values=array($newid,$type);
		$result=$db->Execute($sql,$values);
		return $newid;
	}
	
	function GetQuoteEntries($addsql="") {
		$db=cmsms()->GetDb();
		$q="SELECT * FROM ".cms_db_prefix()."module_quotes";
		$q.=$addsql;
		$result=$db->Execute($q);
		if (!$result || ($result->NumRows()==0)) {
			return false;
		}
		$output=array();
		while($row=$result->FetchRow()) {
			$props=$this->GetQuoteProps($row["id"]);
			$row=array_merge($row,$props);
			$output[]=$row;			
		}
		return $output;
	}

	function GetQuotes($addsql="") {
		$db=cmsms()->GetDb();
		$q="SELECT * FROM ".cms_db_prefix()."module_quotes";
		$q.=$addsql;
		$result=$db->Execute($q);
		if (!$result || ($result->NumRows()==0)) {
			return false;
		}
		$output=array();
		while($row=$result->FetchRow()) {
			//print_r($row);
			$props=$this->GetQuoteProps($row["id"]);
			switch($row["type"]) {
				case 1 : {
					$row=array_merge($row,$props);
					$output[]=$row;
					break;
				}
				case 2 : {
					$rssquotes=$this->GetRSSQuotes($row);
					//echo count($rssquotes);
					if (count($rssquotes)>0) {						
						foreach($rssquotes as $rssquote) {
							$output[]=$rssquote;
						}
					}
				}
			}
		}
		return $output;
	}

	function GetQuote($textid="",$id="") {
		$db=cmsms()->GetDb();
		$q="";
		$p="";
		if ($textid!="") {
			$q="SELECT * FROM ".cms_db_prefix()."module_quotes WHERE textid=?";
			$p=array($textid);
		} else {
			$q="SELECT * FROM ".cms_db_prefix()."module_quotes WHERE id=?";
			$p=array($id);
		}
		$result=$db->Execute($q,$p);
		if (!$result || $result->RecordCount()==0) return false;
		$row=$result->FetchRow();
		$props=$this->GetQuoteProps($row["id"]);
		$row=array_merge($row,$props);
		return $row;
	}

	function DeleteGroup($groupid) {
		$this->ClearConnections("",$groupid);
		$db=cmsms()->GetDb();
		$sql="DELETE FROM ".cms_db_prefix()."module_quotegroups WHERE id=?";
		$values=array($groupid);
		$result=$db->Execute($sql,$values);
		return $result;
	}

	function DeleteQuote($quoteid) {
		$this->ClearConnections($quoteid);
		$this->RemoveQuoteProp($quoteid);
		$db=cmsms()->GetDb();
		$sql="DELETE FROM ".cms_db_prefix()."module_quotes WHERE id=?";
		$values=array($quoteid);
		$result=$db->Execute($sql,$values);
		return $result;
	}

	function ClearConnections($quoteid="",$groupid="") {
		$db=cmsms()->GetDb();
		$result=false;
		if ($quoteid!="") {
			$q="DELETE FROM ".cms_db_prefix()."module_quoteconnections WHERE quoteid=?";
			$dbresult=$db->Execute($q,array($quoteid));
			$result=($dbresult!=false);
		}
		if ($groupid!="") {
			$q="DELETE FROM ".cms_db_prefix()."module_quoteconnections WHERE groupid=?";
			$dbresult=$db->Execute($q,array($groupid));
			$result=($dbresult!=false);
		}
		return $result;
	}

	function GetConnection($quoteid, $groupid) {
		$db=cmsms()->GetDb();
		$q="SELECT * FROM ".cms_db_prefix()."module_quoteconnections WHERE quoteid=? AND groupid=?";
		$result=$db->Execute($q,array($quoteid,$groupid));
		if (!$result || ($result->NumRows()==0)) {
			return false;
		}
		return true;
	}

	function SetConnection($quoteid,$groupid) {
		if ($this->GetConnection($quoteid, $groupid)) return true;
		$db=cmsms()->GetDb();
		$q="INSERT INTO ".cms_db_prefix()."module_quoteconnections (quoteid,groupid) VALUES (?,?)";
		$result=$db->Execute($q,array($quoteid,$groupid));
		if (!$result) return "0";
		return "1";
	}

	function GetTemplates() {
		$db=cmsms()->GetDb();
		$q="SELECT * FROM ".cms_db_prefix()."module_quotetemplates";

		$result=$db->Execute($q);
		if (!$result || ($result->NumRows()==0)) {
			return false;
		}
		$output=array();
		while($row=$result->FetchRow()) {
			$output[]=$row;
		}
		return $output;
	}

	function AddTemplate($name,$content) {
		$db=cmsms()->GetDb();
		$newid=$db->GenID(cms_db_prefix()."module_quotetemplates_seq");
		$sql="INSERT INTO ".cms_db_prefix()."module_quotetemplates (id,name,content,isdefault) VALUES (?,?,?,0)";
		$values=array($newid,$name,$content);
		$result=$db->Execute($sql,$values);
		return $newid;
	}

	function UpdateTemplate($id,$name,$content) {
		$db=cmsms()->GetDb();
		$q="UPDATE ".cms_db_prefix()."module_quotetemplates SET name=?,content=? WHERE id=?";
		$p=array($name,$content,$id);
		$result=$db->Execute($q,$p);
		return true;
	}

	function SetDefaultTemplate($id) {
		$db=cmsms()->GetDb();
		$q="UPDATE ".cms_db_prefix()."module_quotetemplates SET isdefault='0'";
		$result=$db->Execute($q);
		$q="UPDATE ".cms_db_prefix()."module_quotetemplates SET isdefault='1' WHERE id=?";
		$p=array($id);
		$result=$db->Execute($q,$p);
		return true;
	}

	function RemoveTemplate($id) {
		$db=cmsms()->GetDb();
		$q="DELETE FROM ".cms_db_prefix()."module_quotetemplates WHERE id=?";
		$p=array($id);
		$result=$db->Execute($q,$p);
		return true;
	}

	function GetTemplateFull($id) {
		$db=cmsms()->GetDb();
		$q="";
		$p=array();
		if (is_numeric($id)) {
			$q="SELECT * FROM ".cms_db_prefix()."module_quotetemplates WHERE id=?";
			$p=array($id);
		} else {
			$q="SELECT * FROM ".cms_db_prefix()."module_quotetemplates WHERE name=?";
			$p=array($name);
		}
		$result=$db->Execute($q,$p);
		if (!$result || ($result->NumRows()==0)) {
			return false;
		}
		$row=$result->FetchRow();
		return $row;
	}

	function GetTemplateContent($id) {
		$template=$this->GetTemplateFull($id);
		if ($template!=false) return $template["content"];
		return false;
	}

	function IncreaseExposure($quoteid) {
		$exposures=$this->GetQuoteProp($quoteid,"exposures");
		if (!$exposures) {
			$this->SetQuoteProp($quoteid,"exposures",1);
		} else {
			$this->SetQuoteProp($quoteid,"exposures",$exposures+1);
		}
	}

	function SelectRandom($quotes) {
		$quote=array();
		$count=count($quotes);
		$picked=rand(0,$count-1);
		$quote=$quotes[$picked];
		$this->IncreaseExposure($quote["id"]);
		return $quote;
	}

	function SelectEqual($quotes) {
		$hits=999999;
		$picked=array();
		foreach($quotes as $quote) {
			if ($quote["exposures"]<$hits) {
				$hits=$quote["exposures"];
				$picked=$quote;
			}
		}

		$this->IncreaseExposure($picked["id"]);
		return $picked;
	}

	function SelectQuoteoftheday($quotes) {
		$quote=array();
		$lasttime=$this->GetPreference("lastdaypick",-1);
		$lastid=$this->GetPreference("lastidpick",-1);
		if ($lasttime==-1) {
			$quote=$this->SelectRandom($quotes);
			$this->SetPreference("lastdaypick",time());
			$this->SetPreference("lastidpick",$quote["id"]);
		} else {
			if ($lasttime<(time()-(24*60*60))) {
				//quote is expired
				$this->SetPreference("lastdaypick",-1);
				$this->SetPreference("lastidpick",-1);
				$quote=$this->SelectQuoteoftheday($quotes);
			} else {
				foreach ($quotes as $thisquote) {
					if ($thisquote["id"]==$lastid) {
						$quote=$thisquote;
						break;
					}
				}

				if (count($quote)==0) {
					//Quote must have been deleted
					$this->SetPreference("lastdaypick",-1);
					$this->SetPreference("lastidpick",-1);
					$quote=$this->SelectQuoteoftheday($quotes);
				}
			}
		}
		return $quote;
	}

	function GetFilteredQuotes($params) {
		$availablequotes=$this->GetQuotes();
			//echo count($availablequotes);
		$quotes=array();

		if (isset($params["quote"]) && trim($params["quote"])!="") {
			$selectedquotes=explode(",",$params["quote"]);
			//print_r($selectedquotes);
			foreach($availablequotes as $quote) {
				foreach($selectedquotes as $textid) {
					if ($quote["textid"]==$textid) {
						$quotes[]=$quote;
					}
				}
			}
		} elseif (isset($params["group"]) && trim($params["group"])!="") {
			$selectedgroups=explode(",",$params["group"]);
			//  print_r($selectedgroups);
			foreach($availablequotes as $quote) {
				foreach($selectedgroups as $group) {
					$group=$this->GetGroup($group);
					if ($this->GetConnection($quote["id"],$group["id"])) {
						$quotes[]=$quote;
					}
				}
			}
		} else {
			$quotes=$availablequotes;
		}
		unset($availablequotes); // free a little memory?
		
		return $quotes;
	}

	function SelectQuote($params) {
		$output=array();
		//$params["quote"]
		$quotes=$this->GetFilteredQuotes($params);
		 
		if (empty($quotes)) {
			$output["content"]=$this->lang("nomatchingquotes");
			$output["author"]="Roy Batty";
			$output["reference"]="the BladeRunner movie";
		} else {
			$pickedby="random";
			if (isset($params["pickedby"])) $pickedby=$params["pickedby"];
			$quotecount=count($quotes);
			$chosenindex=-1; // ???
			switch($pickedby) {
				case "equal" : $output=$this->SelectEqual($quotes); break;
				case "day" : $output=$this->SelectQuoteoftheday($quotes); break;
				case "random" :
				default: $output=$this->SelectRandom($quotes);
			}
		}
		return $output;
	}
	
#
# EOF
#
}