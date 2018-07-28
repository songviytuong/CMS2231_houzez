<?php
#-------------------------------------------------------------------------
# Module: FAQ
# Author: Jos (josvd@live.nl)
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2008 by Ted Kulp (wishy@cmsmadesimple.org)
# This project's homepage is: http://www.cmsmadesimple.org
# The module's homepage is: http://dev.cmsmadesimple.org/projects/faq/
#-------------------------------------------------------------------------


$smarty->assign('category', $this->Lang('category'));
$smarty->assign('tag', lang('tags'));
$smarty->assign('entries', $this->Lang('entries'));
$smarty->assign('active', lang('active'));

$smarty->assign('activetruelink', $this->CreateLink($id, 'editcategory', $returnid,
				    $admintheme->DisplayImage('icons/system/true.gif',lang ('setfalse'),'','','systemicon'),
				    array('categoryid' => 'QQ', 'mode' => 'switchactive')));
$smarty->assign('activefalselink', $this->CreateLink($id, 'editcategory', $returnid,
				    $admintheme->DisplayImage('icons/system/false.gif',lang ('settrue'),'','','systemicon'),
				    array('categoryid' => 'QQ', 'mode' => 'switchactive')));

$smarty->assign('editicon', $admintheme->DisplayImage('icons/system/edit.gif', lang ('edit'), '', '', 'systemicon'));
$smarty->assign('editurl', $this->CreateLink($id, 'editcategory', $returnid,
				    lang ('edit'),
				    array ('categoryid' => 'QQ', 'mode'=>'edit'), '', true));
$smarty->assign('deletelink', $this->CreateLink($id, 'editcategory', $returnid,
					  $admintheme->DisplayImage('icons/system/delete.gif', lang ('delete'), '', '', 'systemicon'),
					  array ('categoryid' => 'QQ', 'mode'=>'delete'), $this->Lang ('areyousure')));

$smarty->assign('formstart', $this->CreateFormStart ($id, 'edititem', $returnid, 'post', '', false, '', array('mode'=>'sort') ));
$smarty->assign('formend', $this->CreateFormEnd());
$smarty->assign('faq_sort',$this->CreateInputHidden($id, 'faq_sort', '', 'class="faq_sort"'));
$smarty->assign('submit', '<span class="faq_save" style="display:none; margin-left:20px;">' . $this->CreateInputSubmit ($id, 'submit', lang('submit')) . '</span>');

$smarty->assign('addlink', $this->CreateLink($id, 'editcategory', 0, $admintheme->DisplayImage('icons/system/newobject.gif', $this->Lang('addcategory'),'','','systemicon'), array(), '', false, false, '') .' '. $this->CreateLink($id, 'editcategory', $returnid, $this->Lang("addcategory"), array("mode"=>"add"), '', false, false, 'class="pageoptions"'));


// Display the populated template
echo $this->ProcessTemplate ('admincategories.tpl');

?>