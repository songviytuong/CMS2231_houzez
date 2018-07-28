<?php
#-------------------------------------------------------------------------
# Module: FAQ
# Author: Jos (josvd@live.nl)
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2008 by Ted Kulp (wishy@cmsmadesimple.org)
# This project's homepage is: http://www.cmsmadesimple.org
# The module's homepage is: http://dev.cmsmadesimple.org/projects/faq/
#-------------------------------------------------------------------------


if ( !empty($params['categoryid']) )
{
	$category_id = $params['categoryid'];
	$_SESSION['cmsms_module_faq']['defaultcategory'] = $category_id;
}
elseif ( !empty($_SESSION['cmsms_module_faq']['defaultcategory']) )
{
	$category_id = $_SESSION['cmsms_module_faq']['defaultcategory'];
	$_SESSION['cmsms_module_faq']['defaultcategory'] = $category_id;
}
else
{
	$category_id = $this->GetPreference('defaultcategory');
}


if ( count($categories) > 1 )
{
	// create category dropdownfield
	foreach ( $categories as $category ) 
	{
		$label = $category['category'] . ' (' . $category['entries'] . ')';
		$categorylist[$label] = $category['category_id'];
		if ( $category_id == $category['category_id'] ) $entries = $category['entries'];
	}
	$smarty->assign('categorylabel', $this->Lang('category') . ':');
	$smarty->assign('categoryselect', $this->CreateInputDropdown($id, 'categoryselect', $categorylist, -1, $category_id, 'id="' . $id . 'categoryselect"'));
	$smarty->assign('categoryselectjs', '
	<script type="text/javascript">
		$(function() {
			$(\'#' . $id . 'categoryselect\').change( function() {
				location.href = "' . str_replace('&amp;','&',$this->CreateLink($id, 'defaultadmin', $returnid, '', array('active_tab' => 'items'), '', true))  . '&' . $id . 'categoryid="+$(this).val();
			});
		});
	</script>
');
}
else
{
	$smarty->assign('categorylabel', '');
	$smarty->assign('categoryselect', '');
	$smarty->assign('categoryselectjs', '');
	$entries = $categories[0]['entries'];
}

// pagination
$params['modpage'] = empty($params['modpage']) ? 1 : $params['modpage'];
$entries_per_page = 40;
$pages = ceil($entries / $entries_per_page);
$start = (($params['modpage'] - 1) * $entries_per_page) + 1;

$pagelinks = array();
for ($i = 1; $i <= $pages; $i++) {
	$pagelinks[$i] = $this->CreateLink($id, 'defaultadmin', $returnid, '', array ('categoryid' => $category_id, 'modpage' => $i, 'active_tab' => 'items'), '', true);
}
$smarty->assign('pagelinks', $pagelinks);
$smarty->assign('currentpage', $params['modpage']);


$items = FAQ_utils::GetEntries($category_id, $start, $entries_per_page, false);

$i = 0;
foreach ( $items as $key=>$item )
{
	if ( $i > 0 )
	{
		$items[$key]->moveup = $this->CreateLink($id, 'edititem', $returnid, $admintheme->DisplayImage('icons/system/arrow-u.gif', lang('up'),'','','systemicon'), array('categoryid' => $category_id, 'entryid' => $item->entry_id, 'mode' => 'moveup'));
	}
	else
	{
		$items[$key]->moveup = '';
	}

	if ( $i < count($items) - 1 && count($items) > 1 )
	{
		$items[$key]->movedown = $this->CreateLink($id, 'edititem', $returnid, $admintheme->DisplayImage('icons/system/arrow-d.gif', lang('down'),'','','systemicon'), array('categoryid' => $category_id, 'entryid' => $item->entry_id, 'mode' => 'movedown'));
	}
	else
	{
		$items[$key]->movedown = '';
	}
	$i++;
}

$smarty->assign('items', $items);


$smarty->assign('id', $this->Lang('id'));
$smarty->assign('question', $this->Lang('question'));
$smarty->assign('answer', $this->Lang('answer'));
$smarty->assign('active', lang('active'));


$smarty->assign('itemcount', count($items));

$smarty->assign('activefalselink', $this->CreateLink($id, 'edititem', $returnid,
				    $admintheme->DisplayImage('icons/system/true.gif', lang('active'),'','','systemicon'),
				    array ('categoryid' => $category_id, 'entryid' => 'QQ', 'mode'=>'switchactive')));
$smarty->assign('activetruelink', $this->CreateLink($id, 'edititem', $returnid,
				    $admintheme->DisplayImage('icons/system/false.gif', lang('inactive'),'','','systemicon'),
				    array ('categoryid' => $category_id, 'entryid' => 'QQ', 'mode'=>'switchactive')));
$smarty->assign('editicon', $admintheme->DisplayImage('icons/system/edit.gif', lang ('edit'), '', '', 'systemicon'));
$smarty->assign('editurl', $this->CreateLink($id, 'edititem', $returnid,
				    lang ('edit'),
				    array ('categoryid' => $category_id, 'entryid' => 'QQ', 'mode'=>'edit'), '', true));
$smarty->assign('deletelink', $this->CreateLink($id, 'edititem', $returnid,
					  $admintheme->DisplayImage('icons/system/delete.gif', lang ('delete'), '', '', 'systemicon'),
					  array ('categoryid' => $category_id, 'entryid' => 'QQ', 'mode'=>'delete'), $this->Lang ('areyousure')));


$params = array('mode'=>'sort', 'categoryid'=>$category_id, 'entryid'=>0);
$smarty->assign('formstart', $this->CreateFormStart ($id, 'edititem', $returnid, 'post', '', false, '', $params ));
$smarty->assign('formend', $this->CreateFormEnd());
$smarty->assign('sortseq',$this->CreateInputHidden($id, 'sortseq', '', 'class="sortseq"'));
$smarty->assign('submit', '<span class="sort_save" style="display:none; margin-left:20px;">' . $this->CreateInputSubmit ($id, 'submit', lang('submit')) . '</span>');
/*
$smarty->assign('multiselect', $this->CreateInputCheckbox($id, 'multiselect[QQ]', 1));
$multiactionlist = array(lang('delete') => 'delete', lang('active') => 'active', lang('inactive') => 'inactive');
$smarty->assign('prompt_multiaction', $this->Lang('withselected'));
$smarty->assign('multiaction', $this->CreateInputDropdown($id, 'multiaction', $multiactionlist, -1) . ' ' . $this->CreateInputSubmit($id, 'multiactionsubmit', lang('apply'), '', '', $this->Lang('areyousuremulti')) );
*/

$params = array('mode'=>'add', 'categoryid'=>$category_id, 'entryid'=>0);
$smarty->assign('addlink', $this->CreateLink($id, 'edititem', 0, $admintheme->DisplayImage('icons/system/newobject.gif', $this->Lang('additem'),'','','systemicon'), $params, '', false, false, '') .' '. $this->CreateLink($id, 'edititem', $returnid, $this->Lang("additem"), $params, '', false, false, 'class="pageoptions"'));
	
// Display the populated template
echo $this->ProcessTemplate('adminitems.tpl');

?>