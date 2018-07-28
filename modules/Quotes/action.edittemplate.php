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

if (!isset($params["todo"])) exit;

if (isset($params["reset"])) $params["todo"]="reset";
if (isset($params["apply"])) $params["todo"]="apply";
$inerror=false;

$params["tab"]="templates";
$templateid="";

if ($params["todo"]!="add" && !isset($params["templateid"])) {
	echo "Internal error"; exit;
} else {
	if (isset($params["templateid"])) $templateid=$params["templateid"];
}

if (isset($params["apply"])) $params["todo"]="apply";

switch ($params["todo"]) {
	case "setasdefault" : {
    $this->SetPreference("defaulttemplate",$templateid);
		$params["module_message"]=$this->Lang("defaulttemplateset");
		$this->Redirect($id, 'defaultadmin', $returnid,$params);
		break;
	}
	case "delete" : {
		$this->RemoveTemplate($templateid);
		$params["module_message"]=$this->Lang("templatedeleted");		
		$this->Redirect($id, 'defaultadmin', $returnid,$params);
		break;
	}
	case "reset" : {
		$this->UpdateTemplate($templateid,"default",file_get_contents("../modules/Quotes/templates/default.tpl"));
		$params["module_message"]=$this->Lang("templatereset");
		/*$this->Redirect($id, 'defaultadmin', $returnid,$params);
		break;*/
		$params["content"]=	file_get_contents("../modules/Quotes/templates/default.tpl");
		$params["todo"]="edit";		
		unset($params["reset"]);
		$this->Redirect($id, 'edittemplate', $returnid,$params);
		break;
	}
	case "save" : {
		if (!isset($params["name"]) || trim($params["name"]=="")) {
			echo $this->ShowErrors($this->Lang("missingname"));
			$inerror=true;
			break;
		}

		$this->AddTemplate($params["name"],$params["content"]);
		
		$params["module_message"]=$this->Lang("templateadded");
		$this->Redirect($id, 'defaultadmin', $returnid,$params);
		break;
	}
	case "apply" : {
		if (!isset($params["name"]) || trim($params["name"]=="")) {
			echo $this->ShowErrors($this->Lang("missingname"));
			break;
		}
		$this->UpdateTemplate($templateid,$params["name"],$params["content"]);
		$params["module_message"]=$this->Lang("templateupdated");
		$params["todo"]="edit";		
		unset($params["apply"]);
		$this->Redirect($id, 'edittemplate', $returnid,$params);
		break;
	}
	case "update" : {
		if (!isset($params["name"]) || trim($params["name"]=="")) {
			echo $this->ShowErrors($this->Lang("missingname"));
			break;
		}
		$this->UpdateTemplate($templateid,$params["name"],$params["content"]);
		$params["module_message"]=$this->Lang("templateupdated");
		$this->Redirect($id, 'defaultadmin', $returnid,$params);
		break;
	}
}

$name="";
$content=file_get_contents("../modules/Quotes/templates/default.tpl");

if ($params["todo"]=="edit") {
	$template=$this->GetTemplateFull($templateid);
	$name=$template["name"];
	$content=$template["content"];
}

if (isset($params["name"])) $name=$params["name"];
if (isset($params["content"])) $content=$params["content"];

$newtodo="";
if ($inerror) {
	$newtodo=$params["todo"];
} else {
	if ($params["todo"]=="edit") $newtodo="update";
	if ($params["todo"]=="add" || $params["todo"]=="copy") $newtodo="save";
}
$this->smarty->assign('formstart',$this->CreateFormStart($id,"edittemplate",$returnid,"post","",false,"",array("todo"=>$newtodo,"templateid"=>$templateid)));
$this->smarty->assign('formend',$this->CreateFormEnd());
if ($name=="default") {
	$this->smarty->assign('nameinput',$name);
	$this->smarty->assign('namehidden',$this->CreateInputHidden($id,"name",$name));
} else {
	$this->smarty->assign('nameinput',$this->CreateInputText($id,"name",$name,40,100));
}

$this->smarty->assign('name',$this->lang("templatename"));
$this->smarty->assign('templatehelp',$this->lang("templatehelp"));

$this->smarty->assign('content',$this->lang("templatecontent"));
$this->smarty->assign('contentinput',$this->CreateTextArea(false,$id,$content,"content"));

if ($params["todo"]=="edit") {
	$this->smarty->assign('submit', $this->CreateInputSubmit($id,"submit",$this->Lang("savetemplate")));	
	$this->smarty->assign('apply', $this->CreateInputSubmit($id,"apply",$this->Lang("applychanges")));
	$this->smarty->assign('reset', $this->CreateInputSubmit($id,"reset",$this->Lang("resettemplate"),"","",$this->Lang("confirmtemplatereset")));
} else {
	$this->smarty->assign('submit', $this->CreateInputSubmit($id,"submit",$this->Lang("addtemplate")));
}

$this->smarty->assign('backlink', $this->CreateLink($id,"defaultadmin",$returnid,$this->Lang("backlink"),array("tab"=>"templates")));

echo $this->ProcessTemplate('adminedittemplate.tpl');

#
# EOF
#
?>