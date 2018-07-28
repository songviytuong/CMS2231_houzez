<?php

# Module: Multilanguage CMS
# Zdeno Kuzmany (zdeno@kuzmany.biz) kuzmany.biz
#
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2009 by Ted Kulp (wishy@cmsmadesimple.org)
# This project's homepage is: http://www.cmsmadesimple.org
# The module's homepage is: http://dev.cmsmadesimple.org/projects/skeleton/
#
#-------------------------------------------------------------------------
#
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
#
#-------------------------------------------------------------------------

if (!isset($gCms))
    exit;

if (!$this->CheckAccess('manage ' . $prefix . 'mle')) {
    echo $this->ShowErrors($this->Lang('accessdenied'));
    return;
}

#Start MLE
global $hls, $hl, $mleblock;
$thisURL = $_SERVER['SCRIPT_NAME'] . '?';
foreach ($_GET as $key => $val)
    if ('hl' != $key)
        $thisURL .= $key . '=' . $val . '&amp;';
if (isset($hls)) {
    $langList = ' &nbsp; &nbsp; ';
    foreach ($hls as $key => $mle) {
        $langList .= ($hl == $key) ? $mle['flag'] . ' ' : '<a href="' . $thisURL . 'hl=' . $key . '">' . $mle['flag'] . '</a> ';
    }
}
$smarty->assign('langList', $langList);
#End MLE

$lg = str_replace("_", "", $mleblock);
$lg = isset($lg) ? $lg : 'en';

$this->smarty->assign('formstart',$this->CreateFormStart($id,'defaultadmin'));
/* -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-

  Code for Snippets "defaultadmin" admin action

  -=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-

  Typically, this will display something from a template
  or do some other task.

 */

$admintheme = cms_utils::get_theme_object();
$template_list = cge_template_utils::get_admintemplates_by_prefix('', $prefix);

$rowclass = 'row1';
$templates = array();
foreach ($template_list as $key=>$template) {
    $onerow = new stdClass();
    $onerow->name = $template['template_name'];
    
    $content = json_decode($template['content']);
    $onerow->content = $content->$lg;
    $onerow->deletelink = $this->CreateLink($id, 'deleteSnippet', $returnid, $admintheme->DisplayImage('icons/system/delete.gif', $this->Lang('delete'), '', '', 'systemicon'), array('name' => $template['template_name'], 'prefix' => $prefix), $this->Lang('areyousure'));
    $onerow->editlink = $this->CreateLink($id, 'manageSnippet', $returnid, $admintheme->DisplayImage('icons/system/edit.gif', $this->Lang('edit'), '', '', 'systemicon'), array('name' => $template['template_name'], 'prefix' => $prefix, 'wysiwyg' => $wysiwyg));
    $onerow->edit = $this->CreateLink($id, 'manageSnippet', $returnid, $template['template_name'], array('name' => $template['template_name'], 'prefix' => $prefix, 'wysiwyg' => $wysiwyg));
    $onerow->rowclass = $rowclass;
    $templates[] = $onerow;
    ($rowclass == "row1" ? $rowclass = "row2" : $rowclass = "row1");
}

$pagelimit = (int) $this->GetPreference('article_pagelimit',50);
$smarty->assign('prompt_pagelimit', $this->Lang('prompt_pagelimit'));
$smarty->assign('prompt_translate', $this->Lang('prompt_translate'));

$this->smarty->assign('snippets', $templates);

$this->smarty->assign('title', $this->Lang('name'));
$this->smarty->assign('title_tag', $this->Lang('tag'));
$this->smarty->assign('title_content', $this->Lang('content'));

$smarty->assign('filtertext',$this->Lang('title_filter'));
$smarty->assign('pagelimits',array(10=>10,25=>25,50=>50,250=>250,500=>500,1000=>1000));
$smarty->assign('pagelimit',$pagelimit);
$smarty->assign('prefix',$prefix);

#Status: Active Languages
$language_status = active_languages();
if($language_status){
    $smarty->assign('activelang',$language_status);
}
#Status: End Active Languages

$this->smarty->assign('formend',$this->CreateFormEnd());

$smarty->assign('delete',$this->CheckPermission('Modify Site Preferences'));
$smarty->assign('add',$this->CheckPermission('Modify Site Preferences'));

$this->smarty->assign('addSnippetLink', $this->CreateLink($id, 'manageSnippet', '', $this->Lang('add'), array('prefix' => $prefix, 'wysiwyg' => $wysiwyg)));

$this->smarty->assign('addSnippetIcon', $this->CreateLink($id, 'manageSnippet', '', $admintheme->DisplayImage('icons/system/newobject.gif', $this->Lang('add_snippet'), '', '', 'systemicon'), array('prefix' => $prefix, 'wysiwyg' => $wysiwyg)));

// Import section

$this->smarty->assign('form_start', $this->CreateFormStart($id, 'importSnippet', $returnid, 'post', 'multipart/form-data'));
$this->smarty->assign('form_end', $this->CreateFormEnd());

$this->smarty->assign('info_leaveempty', $this->Lang('help_leaveempty'));

echo $this->ProcessTemplate('adminpanel.tpl');
?>