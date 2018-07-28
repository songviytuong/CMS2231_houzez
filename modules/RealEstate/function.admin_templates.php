<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$db=$this->GetDb();

$admintheme = cms_utils::get_theme_object();

$templates = $this->GetRealTemplates();

$tpl = $smarty->CreateTemplate($this->GetTemplateResource('admintemplates.tpl'), null, null, $smarty);

$showtemplates = array();

if (TRUE == empty($templates)) {
    $tpl->assign('notemplatestext', $this->Lang("notemplates"));
} else {
    foreach ($templates as $template) {
        //print_r($template);

        $onerow = new stdClass();
        $onerow->name = $this->CreateLink($id, 'edittemplate', $returnid, $template["name"], array('templateid' => $template["id"], "todo" => "edit"));
        $onerow->id = $template["id"];
        if ($this->GetPreference("defaulttemplate") == $template["id"]) {
            $onerow->default = $admintheme->DisplayImage('icons/system/true.gif', $this->Lang("isdefaulttemplate"), '', '', 'systemicon');
        } else {
            $onerow->default = $this->CreateLink($id, 'edittemplate', $returnid, $admintheme->DisplayImage('icons/system/false.gif', $this->Lang("setasdefaulttemplate"), '', '', 'systemicon'), array('templateid' => $template["id"], "todo" => "setasdefault"));
        }

        $onerow->editlink = $this->CreateLink($id, 'edittemplate', $returnid, $admintheme->DisplayImage('icons/system/edit.gif', $this->Lang("edittemplate"), '', '', 'systemicon'), array('templateid' => $template["id"], "todo" => "edit"));
        $onerow->copylink = $this->CreateLink($id, 'edittemplate', $returnid, $admintheme->DisplayImage('icons/system/copy.gif', $this->Lang("copytemplate"), '', '', 'systemicon'), array('templateid' => $template["id"], "todo" => "copy"));
        if ($template["name"] != "default") {
            $onerow->deletelink = $this->CreateLink($id, 'edittemplate', $returnid, $admintheme->DisplayImage('icons/system/delete.gif', $this->Lang("deletetemplate"), '', '', 'systemicon'), array('templateid' => $template["id"], "todo" => "delete"), $this->Lang("confirmdeletetemplate"));
        }
        array_push($showtemplates, $onerow);
    }
}
$tpl->assign('items', $showtemplates);
$tpl->assign('itemcount', count($showtemplates));
$link=$this->CreateLink($id, 'edittemplate', 0, $admintheme->DisplayImage('icons/system/newobject.gif', $this->Lang("addtemplate"),'','','systemicon'), array(), '', false, false, '') .' '. $this->CreateLink($id, 'edittemplate', $returnid, $this->Lang("addtemplate"), array("todo"=>"add"), '', false, false, 'class="pageoptions"');
$tpl->assign('addlink', $link);
$tpl->display();
