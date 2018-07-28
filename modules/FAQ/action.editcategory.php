<?php

#-------------------------------------------------------------------------
# Module: FAQ
# Author: Jos (josvd@live.nl)
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2008 by Ted Kulp (wishy@cmsmadesimple.org)
# This project's homepage is: http://www.cmsmadesimple.org
# The module's homepage is: http://dev.cmsmadesimple.org/projects/faq/
#-------------------------------------------------------------------------

if (!$gCms)
	exit();

if (!$this->CheckPermission('FAQ: Modify'))
{
	echo $this->ShowErrors(lang('needpermissionto', 'FAQ: Modify'));
	return;
}

if (isset($params['cancel']))
{
	$params = array('active_tab' => 'categories');
	$this->Redirect($id, 'defaultadmin', '', $params);
}

if (!isset($params['mode']))
{
	$params = array('errors' => lang('missingparams'), 'active_tab' => 'categories');
	$this->Redirect($id, 'defaultadmin', '', $params);
	return;
}

switch ($params['mode'])
{
	case 'add':
		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			$params['active'] = empty($params['active']) ? 0 : 1;

			$query = "SELECT max(sort) as maxsort
								FROM " . cms_db_prefix() . "module_faq_categories";
			$maxsort = $db->GetOne($query);

			$query = "INSERT INTO " . cms_db_prefix() . "module_faq_categories (
									category, 
									alias, 
									lang,
									sort,
									active) 
								VALUES 
									(?,?,?,?,?)";
			$result = $db->Execute($query, array(
				$params['category'],
				strtolower(munge_string_to_url($params['category'])),
				$params['lang'],
				$maxsort + 1,
				$params['active']
			));

			$params = array('tab_message' => 'categoryadded', 'active_tab' => 'categories');
			$this->Redirect($id, 'defaultadmin', '', $params);
		}
		else
		{
			$params['categoryid'] = 0;
			$category['category'] = '';
			$category['lang'] = '';
			$category['active'] = 1;
		}
		$smarty->assign('title', $this->Lang('addcategory'));
		break;


	case 'delete':
		if (!isset($params['categoryid']))
		{
			$params = array('errors' => lang('missingparams'), 'active_tab' => 'categories');
			$this->Redirect($id, 'defaultadmin', '', $params);
			return;
		}

		$query = "DELETE FROM " . cms_db_prefix() . "module_faq_catentries WHERE category_id = ?";
		$db->Execute($query, array($params['categoryid']));

		$query = "DELETE FROM " . cms_db_prefix() . "module_faq_entries 
							WHERE entry_id IN (SELECT e.entry_id FROM module_faq_entries e LEFT JOIN module_faq_catentries ce ON e.entry_id=ce.entry_id WHERE ce.entry_id IS NULL)";
		$db->Execute($query);

		$query = "SELECT category_id
							FROM " . cms_db_prefix() . "module_faq_categories
							ORDER BY sort";
		$result = $db->Execute($query);
		if ($result)
		{
			if ($result->RecordCount() > 1)
			{
				//do not delete if there is only one category
				$query = "DELETE FROM " . cms_db_prefix() . "module_faq_categories WHERE category_id=?";
				$db->Execute($query, array($params['categoryid']));

				$updatequery = "UPDATE " . cms_db_prefix() . "module_faq_categories SET sort=? WHERE category_id=?";
				$i = 0;
				while ($row = $result->FetchRow())
				{
					if ($row['category_id'] != $params['categoryid'])
					{
						if ($i == 0)
						{
							if ($params['categoryid'] == $this->GetPreference('defaultcategory'))
							{
								$this->SetPreference('defaultcategory', $row['category_id']);
							}
							if ($params['categoryid'] == $_SESSION['cmsms_module_faq']['defaultcategory'])
							{
								$_SESSION['cmsms_module_faq']['defaultcategory'] = $row['category_id'];
							}
						}
						$updateresult = $db->Execute($updatequery, array($i++, $row['category_id']));
					}
				}
			}
		}


		$params = array('tab_message' => 'categorydeleted', 'active_tab' => 'categories');
		$this->Redirect($id, 'defaultadmin', '', $params);
		break;


	case 'moveup':
		$query = "SELECT sort
							FROM " . cms_db_prefix() . "module_faq_categories
							WHERE category_id=?";
		$sort = $db->GetOne($query, array($params['categoryid']));

		$query = "UPDATE " . cms_db_prefix() . "module_faq_categories SET sort = sort + 1 WHERE sort = ?";
		$db->Execute($query, array($sort - 1));

		$query = "UPDATE " . cms_db_prefix() . "module_faq_categories SET sort = sort - 1 WHERE category_id = ?";
		$db->Execute($query, array($params['categoryid']));

		$params = array('active_tab' => 'categories');
		$this->Redirect($id, 'defaultadmin', '', $params);
		break;


	case 'movedown':
		$query = "SELECT sort
							FROM " . cms_db_prefix() . "module_faq_categories
							WHERE category_id=?";
		$sort = $db->GetOne($query, array($params['categoryid']));

		$query = "UPDATE " . cms_db_prefix() . "module_faq_categories SET sort = sort - 1 WHERE sort = ?";
		$db->Execute($query, array($sort + 1));

		$query = "UPDATE " . cms_db_prefix() . "module_faq_categories SET sort = sort + 1 WHERE category_id = ?";
		$db->Execute($query, array($params['categoryid']));

		$params = array('active_tab' => 'categories');
		$this->Redirect($id, 'defaultadmin', '', $params);
		break;


	case 'switchactive':
		$query = "UPDATE " . cms_db_prefix() . "module_faq_categories SET active = active^1 WHERE category_id = ?";
		$db->Execute($query, array($params['categoryid']));

		$params = array('tab_message' => 'categoryupdated', 'active_tab' => 'categories');
		$this->Redirect($id, 'defaultadmin', '', $params);
		break;


	case 'switchdefault':
		$this->SetPreference('defaultcategory', $params['categoryid']);

		$params = array('tab_message' => 'categoryupdated', 'active_tab' => 'categories');
		$this->Redirect($id, 'defaultadmin', '', $params);
		break;


	case 'edit':
		if (!isset($params['categoryid']))
		{
			$params = array('errors' => lang('missingparams'), 'active_tab' => 'categories');
			$this->Redirect($id, 'defaultadmin', '', $params);
			return;
		}

		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			$params['active'] = empty($params['active']) ? 0 : 1;
			$query = "UPDATE " . cms_db_prefix() . "module_faq_categories SET 
									category = ?, 
									alias = ?, 
									lang = ?, 
									active = ? 
								WHERE 
									category_id = ?";
			$result = $db->Execute($query, array(
				$params['category'],
				strtolower(munge_string_to_url($params['category'])),
				$params['lang'],
				$params['active'],
				$params['categoryid']
			));

			// import csv
			$fieldname = $id . "import_csv";
			if (isset($_FILES) && isset($_FILES[$fieldname]) && is_array($_FILES[$fieldname]) && $_FILES[$fieldname]['name'])
			{
				$query = "SELECT MAX(sort) AS maxsort
									FROM " . cms_db_prefix() . "module_faq_catentries
									WHERE category_id=?
									GROUP BY category_id";
				$maxsort = $db->GetOne($query, array($params['category']));

				$entryinsertquery = "INSERT INTO " . cms_db_prefix() . "module_faq_entries 
										(question, answer, active)
									VALUES
										(?, ?, 1)";

				$catinsertquery = "INSERT INTO " . cms_db_prefix() . "module_faq_catentries (
									category_id, entry_id, sort) 
								VALUES 
									(?,?,?)";

				$file = $_FILES[$fieldname];
				$filecontent = file_get_contents($file['tmp_name']);
				$filecontent = str_replace("\r\n", "\n", $filecontent);
				$filecontent = str_replace("\n\r", "\n", $filecontent);
				$filecontent = str_replace(';;', ';"";', $filecontent);
				//$csvdata = str_getcsv($filecontent, "\n"); //parse the rows
				$csvdata = explode("\"\n\"", $filecontent); //parse the rows
				$search = cms_utils::get_module('Search');
				foreach ($csvdata as $row)
				{
					//$csvrow = str_getcsv($row, ";"); //parse the items in rows
					$csvrow = explode("\";\"", $row); //parse the items in rows
					for ($i = 0; $i < count($csvrow); $i++)
					{
						$csvrow[$i] = stripslashes($csvrow[$i]);
						//$csvrow[$i] = html_entity_decode($csvrow[$i],ENT_QUOTES);
						$csvrow[$i] = utf8_encode($csvrow[$i]);
						//if ( $i < 2 ) $csvrow[$i] = strip_tags($csvrow[$i]);
					}
					$result = $db->Execute($entryinsertquery, array($csvrow[0], $csvrow[1]));
					$insert_id = $db->Insert_ID();
					$result = $db->Execute($catinsertquery, array($params['categoryid'], $insert_id, $maxsort++));
					//Update search index
					if ($search != false)
					{
						$search->AddWords($this->GetName(), $insert_id, 'entry', $csvrow[0] . ' ' . $csvrow[1]);
					}
				}
			}

			$params = array('tab_message' => 'categoryupdated', 'active_tab' => 'categories');
			$this->Redirect($id, 'defaultadmin', '', $params);
		}
		else
		{
			$categories = FAQ_utils::GetCategories($params['categoryid'], false);
			$category = $categories[0];
		}
		$smarty->assign('title', $this->Lang('editcategory'));
}

// get languages
$langlist = FAQ_utils::GetLangs();
$langlist = array_flip($langlist);

$smarty->assign('prompt_name', $this->Lang('category'));
$smarty->assign('name', $this->CreateInputText($id, 'category', $category['category'], 40));

$smarty->assign('prompt_catlang', 'Lang');
//$smarty->assign('catlang', $this->CreateInputText($id, 'lang', $category['lang'], 6 ));
$smarty->assign('catlang', $this->CreateInputDropdown($id, 'lang', $langlist, '', $category['lang']));

$smarty->assign('prompt_active', lang('active'));
$smarty->assign('active', $this->CreateInputCheckbox($id, 'active', 1, $category['active']));

$smarty->assign('prompt_import_csv', $this->Lang('import_csv'));
$smarty->assign('import_csv', $params['mode'] == 'add' ? '' : $this->CreateInputFile($id, 'import_csv', 'text/xml', 40));
$smarty->assign('csv_format', $this->Lang('csv_format'));

$smarty->assign('submit', $this->CreateInputSubmit($id, 'submitbutton', lang('submit')));
//$this->smarty->assign('apply',$params['mode'] == 'add' ? '' : $this->CreateInputSubmit($id, 'applybutton', $this->Lang('apply')));
$smarty->assign('cancel', $this->CreateInputSubmit($id, 'cancel', lang('cancel')));

$smarty->assign('formstart', $this->CreateFormStart($id, 'editcategory', $returnid, 'post', 'multipart/form-data', false, '', $params));
$smarty->assign('formend', $this->CreateFormEnd());

echo $this->ProcessTemplate('editcategory.tpl');
?>