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

if (!cmsms() || !$this->VisibleToAdminUser()) {
	echo $this->Lang("accessdenied");
	return;
}

$db=$this->GetDb();

$admintheme = cms_utils::get_theme_object();

$tab="";
if (isset($params["tab"])) $tab=$params["tab"];

echo $this->StartTabHeaders();
	echo $this->SetTabHeader("quotes",$this->Lang("quotestab"),($tab=="quotes"));
	echo $this->SetTabHeader("groups",$this->Lang("grouptab"),($tab=="groups"));
	if( $this->CheckPermission('Modify Templates') ) {
		echo $this->SetTabHeader("templates",$this->Lang("templatetab"),($tab=="templates"));
	}
	echo $this->SetTabHeader("settings",$this->Lang("settings"),($tab=="settings"));
echo $this->EndTabHeaders();

echo $this->StartTabContent();
	echo $this->StartTab("quotes");
		$groups=$this->GetGroups();
		$quotes=$this->GetQuoteEntries();
		
		$showquotes = array();
		if (TRUE == empty($quotes)) {
			$this->smarty->assign('noquotestext', $this->Lang("noquotes"));
		} else {
			foreach ($quotes as $quote) {
				$onerow = new stdClass();
				switch($quote["type"]) {
					case "1" : $quote["content"]=substr($quote["content"],0,200); break;
				}
				$onerow->content = $this->CreateLink($id, 'editquote', $returnid, strip_tags($quote["content"]), array('quoteid'=>$quote["id"],"todo"=>"edit","type"=>$quote["type"]));
				$onerow->id = $quote["id"];
				$onerow->quoteauthor = $quote["author"];

				$qgroups="";
				foreach($groups as $group) {
					if ($this->GetConnection($quote["id"],$group["id"])) {
						if ($qgroups!="") $qgroups.=", ";
						$qgroups.=$group["textid"];
					}
				}
				$onerow->quotegroups = $qgroups;

				$onerow->exposures="0";
				if (isset($quote["exposures"])) $onerow->exposures=$quote["exposures"];
		
				$onerow->quotetype = $this->GetTypeName($quote["type"]);

				$onerow->editlink = $this->CreateLink($id, 'editquote', $returnid, $admintheme->DisplayImage('icons/system/edit.gif', $this->Lang("editquote"),'','','systemicon'), array('quoteid' => $quote["id"],"todo"=>"edit","type"=>$quote["type"]));
		
				$onerow->deletelink = $this->CreateLink($id, 'editquote', $returnid, $admintheme->DisplayImage('icons/system/delete.gif', $this->Lang("deletequote"),'','','systemicon'), array('quoteid' => $quote["id"],"todo"=>"delete","type"=>$quote["type"]), $this->Lang("confirmdeletequote"));

				array_push($showquotes, $onerow);
			}
		}
		
		$this->smarty->assign('quoteauthor', $this->Lang("quoteauthor"));
		$this->smarty->assign('quotegroups', $this->Lang("quotegroups"));
		$this->smarty->assign('quotetype', $this->Lang("quotetype"));
		$this->smarty->assign('quoteexposures', $this->Lang("quoteexposures"));
		$this->smarty->assign('quotes', $this->Lang("quotes"));
		$this->smarty->assign('items', $showquotes);

		$this->smarty->assign('itemcount', count($showquotes));

		$form=$this->CreateFormStart($id,"editquote",$returnid,"post","",false,"",array("todo"=>"add"));
		$form.=$this->CreateInputDropdown($id,"type",$this->GetTypes());
		$form.=$this->CreateInputSubmit($id,"submit",$this->Lang("addquote"));
		$form.= $this->CreateFormEnd();

		$this->smarty->assign('addform', $form);

		echo $this->ProcessTemplate('adminquotes.tpl');
	echo $this->EndTab();

	echo $this->StartTab("groups");
		$groups=$this->GetGroups();
		//print_r($groups);
		$showgroups = array();
		
		if (TRUE == empty($groups)) {
			$this->smarty->assign('nogroupstext', $this->Lang("nogroups"));
		} else {
			foreach ($groups as $group) {
				$onerow = new stdClass();
				$textid = $group["textid"];
				$groupdescription = $group["description"];
				$onerow->textid = $this->CreateLink($id, 'editgroup', $returnid, $textid, array('groupid'=>$group["id"],"todo"=>"edit"));
				$onerow->id = $group["id"];
				$onerow->description = $group["description"];
				if ($this->GetPreference("defaultgroup")==$group["id"]) {
					$onerow->default = $admintheme->DisplayImage('icons/system/true.gif', $this->Lang("isdefaultgroup"),'','','systemicon');
				} else {
					$onerow->default = $this->CreateLink($id, 'editgroup', $returnid, $admintheme->DisplayImage('icons/system/false.gif', $this->Lang("setasdefaultgroup"),'','','systemicon'), array('groupid' =>  $group["id"],"todo"=>"setasdefault"));
				}
				$onerow->editlink = $this->CreateLink($id, 'editgroup', $returnid, $admintheme->DisplayImage('icons/system/edit.gif', $this->Lang("editgroup"),'','','systemicon'), array('groupid' => $group["id"],"todo"=>"edit"));
				
				$onerow->deletelink = $this->CreateLink($id, 'editgroup', $returnid, $admintheme->DisplayImage('icons/system/delete.gif', $this->Lang("deletegroup"),'','','systemicon'), array('groupid' => $group["id"],"todo"=>"delete"), $this->Lang("confirmdeletegroup"));

				array_push($showgroups, $onerow);
			}
		}

		$this->smarty->assign('title_groups', $this->Lang("title_groups"));
		$this->smarty->assign('title_description', $this->Lang("title_description"));
		$this->smarty->assign('items', $showgroups);
		$this->smarty->assign('itemcount', count($showgroups));

		$link=$this->CreateLink($id, 'editgroup', 0, $admintheme->DisplayImage('icons/system/newobject.gif', $this->Lang("addgroup"),'','','systemicon'), array(), '', false, false, '') .' '. $this->CreateLink($id, 'editgroup', $returnid, $this->lang("addgroup"), array("todo"=>"add"), '', false, false, 'class="pageoptions"');

		$this->smarty->assign('addlink', $link);

		echo $this->ProcessTemplate('admingroups.tpl');
	echo $this->EndTab();

	if( $this->CheckPermission('Modify Templates') ) {
		echo $this->StartTab("templates");
			$templates=$this->GetTemplates();

			$showtemplates = array();
			if (TRUE == empty($templates)) {
				$this->smarty->assign('notemplatestext', $this->Lang("notemplates"));
			} else {
				foreach ($templates as $template) {
					//print_r($template);

					$onerow = new stdClass();
					$onerow->name = $this->CreateLink($id, 'edittemplate', $returnid, $template["name"], array('templateid'=>$template["id"],"todo"=>"edit"));
					$onerow->id = $template["id"];
					if ($this->GetPreference("defaulttemplate")==$template["id"]) {
						$onerow->default = $admintheme->DisplayImage('icons/system/true.gif', $this->Lang("isdefaulttemplate"),'','','systemicon');
					} else {
						$onerow->default = $this->CreateLink($id, 'edittemplate', $returnid, $admintheme->DisplayImage('icons/system/false.gif', $this->Lang("setasdefaulttemplate"),'','','systemicon'), array('templateid' => $template["id"],"todo"=>"setasdefault"));
					}

					$onerow->editlink = $this->CreateLink($id, 'edittemplate', $returnid, $admintheme->DisplayImage('icons/system/edit.gif', $this->Lang("edittemplate"),'','','systemicon'), array('templateid' => $template["id"],"todo"=>"edit"));
					$onerow->copylink = $this->CreateLink($id, 'edittemplate', $returnid, $admintheme->DisplayImage('icons/system/copy.gif', $this->Lang("copytemplate"),'','','systemicon'), array('templateid' => $template["id"],"todo"=>"copy"));
					if ($template["name"]!="default") {
						$onerow->deletelink = $this->CreateLink($id, 'edittemplate', $returnid, $admintheme->DisplayImage('icons/system/delete.gif', $this->Lang("deletetemplate"),'','','systemicon'), array('templateid' => $template["id"],"todo"=>"delete"), $this->Lang("confirmdeletetemplate"));
					}
					array_push($showtemplates, $onerow);
				}	
			}

			$this->smarty->assign('templates', $this->Lang("templates"));
			$this->smarty->assign('items', $showtemplates);
			$this->smarty->assign('itemcount', count($showtemplates));

			$link=$this->CreateLink($id, 'edittemplate', 0, $admintheme->DisplayImage('icons/system/newobject.gif', $this->Lang("addtemplate"),'','','systemicon'), array(), '', false, false, '') .' '. $this->CreateLink($id, 'edittemplate', $returnid, $this->Lang("addtemplate"), array("todo"=>"add"), '', false, false, 'class="pageoptions"');

			$this->smarty->assign('addlink', $link);

			echo $this->ProcessTemplate('admintemplates.tpl');
		echo $this->EndTab();
	}
	
		echo $this->StartTab("settings");
			$this->smarty->assign('formstart',$this->CreateFormStart($id,"savesettings",$returnid));
			$this->smarty->assign('formend',$this->CreateFormEnd());

			$this->smarty->assign('allowwysiwygtext', $this->Lang("allowwysiwyg"));
			$this->smarty->assign('allowwysiwyginput', $this->CreateInputCheckbox($id,"allowwysiwyg",'1',$this->GetPreference("allowwysiwyg",'0')));
			
			$this->smarty->assign('captchatext', $this->Lang("enablecaptcha"));
			$this->smarty->assign('captchainput', $this->CreateInputCheckbox($id,"captchacomments",'1',$this->GetPreference("captchacomments",'0')));
			$this->smarty->assign('wysiwygtext', $this->Lang("allowwysiwyg"));
			$this->smarty->assign('wysiwyginput', $this->CreateInputCheckbox($id,"wysiwygentries",'1',$this->GetPreference("wysiwygentries",'0')));
                        #+Lee
                        $this->smarty->assign('allowmle', $this->Lang("allowmle"));
			$this->smarty->assign('allowmleinput', $this->CreateInputCheckbox($id,"allowmle",'1',$this->GetPreference("allowmle",'0')));
                        #-Lee
			$this->smarty->assign('filestext', $this->Lang("allowfiles"));
			$this->smarty->assign('filesinput', $this->CreateInputCheckbox($id,"filesentries",'1',$this->GetPreference("filesentries",'0')));
			$this->smarty->assign('forcefiledescriptiontext', $this->Lang("forcefiledescription"));
			$this->smarty->assign('forcefiledescriptioninput', $this->CreateInputCheckbox($id,"forcefiledescription",'1',$this->GetPreference("forcefiledescription",'0')));
			$this->smarty->assign('breadcrumbtext', $this->Lang("showbreadcrumb"));
			$this->smarty->assign('breadcrumbinput', $this->CreateInputCheckbox($id,"enablebreadcrumb",'1',$this->GetPreference("enablebreadcrumb",'0')));
			$this->smarty->assign('recordiptext', $this->Lang("saveips"));
			$this->smarty->assign('recordipinput', $this->CreateInputCheckbox($id,"recordip",'1',$this->GetPreference("recordip",'0')));
			$this->smarty->assign('breadcrumbroottext', $this->Lang("blogpagealias"));
			$this->smarty->assign('breadcrumbrootinput', $this->CreateInputText($id,"breadcrumbroot",$this->GetPreference("breadcrumbroot",'blog'),40,255));
			$this->smarty->assign('filedirtext', $this->Lang("filedir"));
			$this->smarty->assign('filedirinput', $this->CreateInputText($id,"filedir",$this->GetPreference("filedir",'uploads/blogfiles'),40,255));
			
			$this->smarty->assign('submit', $this->CreateInputSubmit($id,"submit",$this->Lang("savesettings")));

		echo $this->ProcessTemplate('settings.tpl');
	echo $this->EndTab();

echo $this->EndTabContent();

#
# EOF
#
?>