<?php
#-------------------------------------------------------------------------
# Module: FAQ
# Author: Jos (josvd@live.nl)
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2008 by Ted Kulp (wishy@cmsmadesimple.org)
# This project's homepage is: http://www.cmsmadesimple.org
# The module's homepage is: http://dev.cmsmadesimple.org/projects/faq/
#-------------------------------------------------------------------------

if (!isset($gCms)) exit;

if ( !$this->CheckPermission('FAQ: Use') )
{
	echo $this->ShowErrors(lang('needpermissionto', 'FAQ: Use'));
	return;
}

$admintheme = cms_utils::get_theme_object();

$categories = FAQ_utils::GetCategories('', false);
$i = 0;
foreach ( $categories as $key=>$item )
{
	if ( $i > 0 )
	{
		$categories[$key]['moveup'] = $this->CreateLink($id, 'editcategory', $returnid, $admintheme->DisplayImage('icons/system/arrow-u.gif', lang('up'),'','','systemicon'), array('categoryid' => $item['category_id'], 'mode' => 'moveup'));
	}
	else
	{
		$categories[$key]['moveup'] = '';
	}

	if ( $i < count($categories) - 1 && count($categories) > 1 )
	{
		$categories[$key]['movedown'] = $this->CreateLink($id, 'editcategory', $returnid, $admintheme->DisplayImage('icons/system/arrow-d.gif', lang('down'),'','','systemicon'), array('categoryid' => $item['category_id'], 'mode' => 'movedown'));
	}
	else
	{
		$categories[$key]['movedown'] = '';
	}
	$i++;
}
$smarty->assign('categories', $categories);


/*
 * The tab headers
 */
echo $this->StartTabHeaders();
$active_tab = empty($params['active_tab']) ? '' : $params['active_tab'];


echo $this->SetTabHeader('items',$this->Lang('entries'), ($active_tab == 'items')?true:false);



if ( $this->CheckPermission('FAQ: Modify') )
{
	echo $this->SetTabHeader('categories',$this->Lang('categories'), ($active_tab == 'categories')?true:false);
}


if ( $this->CheckPermission('Modify Templates') )
{
	//echo $this->SetTabHeader('fielddefs',$this->Lang('fielddefinitions'), ($active_tab == 'fielddefs')?true:false);

	echo $this->SetTabHeader('templates',lang('templates'), ($active_tab == 'templates')?true:false);
}


if ($this->CheckPermission('Modify Site Preferences'))
{
	echo $this->SetTabHeader('options',lang('options'), ($active_tab == 'options')?true:false);
}
echo $this->EndTabHeaders();


/*
 * The content of the tabs
 */
echo $this->StartTabContent();

echo $this->StartTab('items', $params);
include(dirname(__FILE__).'/function.admin_itemstab.php');
echo $this->EndTab();

if ( $this->CheckPermission('FAQ: Modify') )
{
	echo $this->StartTab('categories', $params);
	include(dirname(__FILE__).'/function.admin_categoriestab.php');
	echo $this->EndTab();
}

if( $this->CheckPermission('Modify Templates') )
{
	//echo $this->StartTab('fielddefs', $params);
	//include(dirname(__FILE__).'/function.admin_fielddefstab.php');
	//echo $this->EndTab();

	echo $this->StartTab('templates', $params);
	include(dirname(__FILE__).'/function.admin_templatestab.php');
	echo $this->EndTab();
}

if ($this->CheckPermission('Modify Site Preferences'))
{
	echo $this->StartTab('options', $params);
	include(dirname(__FILE__).'/function.admin_optionstab.php');
	echo $this->EndTab();
}

echo $this->EndTabContent();


?>