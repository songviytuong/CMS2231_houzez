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

if (!$this->CheckPermission('FAQ: Use'))
{
	echo $this->ShowErrors(lang('needpermissionto', 'FAQ: Use'));
	return;
}

if (isset($params['cancel']))
{
	$params = array('active_tab' => 'items');
	$this->Redirect($id, 'defaultadmin', '', $params);
}

if (!isset($params['mode']) || !isset($params['entryid']))
{
	$params = array('errors' => lang('missingparams'), 'active_tab' => 'items');
	$this->Redirect($id, 'defaultadmin', '', $params);
	return;
}

switch ($params['mode'])
{
	case 'add':
		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			$params['active'] = empty($params['active']) ? 0 : 1;

			$added = FAQ_utils::AddEntry($params['question'], $params['answer'], $params['active'], $params['categories']);

			$params = array('tab_message' => 'itemadded', 'active_tab' => 'items', 'category' => $params['categoryid']);
			$this->Redirect($id, 'defaultadmin', '', $params);
		}
		else
		{
			//$params['categoryid'] = 0;
			$params['entryid'] = 0;
      $item = new stdClass();
			$item->question = '';
			$item->answer = '';
			$item->categories = array($params['categoryid']);
			$item->active = 1;
		}
		$smarty->assign('title', $this->Lang('additem'));
		break;


	case 'delete':
		$deleted = FAQ_utils::DeleteEntry($params['entryid']);
		$params = $deleted ? array('tab_message' => 'itemdeleted', 'active_tab' => 'items') : array('errors' => lang('failure'), 'active_tab' => 'items');
		$this->Redirect($id, 'defaultadmin', '', $params);
		break;


	case 'edit':
		if (!isset($params['entryid']))
		{
			$params = array('categoryid' => $params['categoryid'], 'active_tab' => 'entries', 'errors' => lang('missingparams'));
			$this->Redirect($id, 'defaultadmin', '', $params);
			return;
		}

		if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($params['submit']))
		{
			$params['active'] = empty($params['active']) ? 0 : 1;
			$edited = FAQ_utils::EditEntry($params['entryid'], $params['question'], $params['answer'], $params['categories'], $params['active']);
			$params = array('categoryid' => $params['categoryid'], 'active_tab' => 'items');
			if ($edited)
			{
				$params['tab_message'] = 'itemupdated';
			}
			else
			{
				$params['errors'] = lang('failure');
			}
			$this->Redirect($id, 'defaultadmin', '', $params);
		}
		$smarty->assign('title', $this->Lang('edititem'));
		$item = FAQ_utils::GetEntry($params['entryid']);
		break;


	case 'moveup':
		$query = "SELECT sort
							FROM " . cms_db_prefix() . "module_faq_catentries
							WHERE category_id=? AND entry_id=?";
		$sort = $db->GetOne($query, array($params['categoryid'], $params['entryid']));

		$query = "UPDATE " . cms_db_prefix() . "module_faq_catentries SET sort = sort + 1 WHERE category_id = ? AND sort = ?";
		$db->Execute($query, array($params['categoryid'], $sort - 1));

		$query = "UPDATE " . cms_db_prefix() . "module_faq_catentries SET sort = sort - 1 WHERE category_id = ? AND entry_id = ?";
		$db->Execute($query, array($params['categoryid'], $params['entryid']));

		$params = array('active_tab' => 'entries', 'categoryid' => $params['categoryid']);
		$this->Redirect($id, 'defaultadmin', '', $params);
		break;


	case 'movedown':
		$query = "SELECT sort
							FROM " . cms_db_prefix() . "module_faq_catentries
							WHERE category_id=? AND entry_id=?";
		$sort = $db->GetOne($query, array($params['categoryid'], $params['entryid']));

		$query = "UPDATE " . cms_db_prefix() . "module_faq_catentries SET sort = sort - 1 WHERE category_id = ? AND sort = ?";
		$db->Execute($query, array($params['categoryid'], $sort + 1));

		$query = "UPDATE " . cms_db_prefix() . "module_faq_catentries SET sort = sort + 1 WHERE category_id = ? AND entry_id = ?";
		$db->Execute($query, array($params['categoryid'], $params['entryid']));

		$params = array('active_tab' => 'entries', 'categoryid' => $params['categoryid']);
		$this->Redirect($id, 'defaultadmin', '', $params);
		break;


	case 'sort':
		if (!empty($params['sortseq']))
		{
			$sortseq = str_replace('i', '', $params['sortseq']);
			$sortentries = explode(',', $sortseq);
			foreach ($sortentries as $key => $entry_id)
			{
				$query = "UPDATE " . cms_db_prefix() . "module_faq_catentries SET sort = ? WHERE category_id = ? AND entry_id = ?";
				$db->Execute($query, array($key + 1, $params['categoryid'], $entry_id));
			}
		}
		$params = array('active_tab' => 'entries', 'categoryid' => $params['categoryid']);
		$this->Redirect($id, 'defaultadmin', '', $params);
		break;


	case 'switchactive':
		$query = "UPDATE " . cms_db_prefix() . "module_faq_entries SET active = active^1 WHERE entry_id = ?";
		$db->Execute($query, array($params['entryid']));

		$item = FAQ_utils::GetEntry($params['entryid']);
		$this->SendEvent('FAQ_entry_edited', $item);

		//Update search index
		$search = cms_utils::get_search_module();
		if ($search != false && $item->active == 1)
		{
			$search->AddWords($this->GetName(), $params['entryid'], 'entry', $item->question . ' ' . $item->answer);
		}
		elseif ($search != false)
		{
			$search->DeleteWords($this->GetName(), $params['entryid'], 'entry');
		}

		$params = array('categoryid' => $params['categoryid'], 'active_tab' => 'entries');
		$this->Redirect($id, 'defaultadmin', '', $params);
		break;
}

if (!empty($item))
{
	$smarty->assign('faq_question_label', $this->Lang('question'));
	$smarty->assign('faq_question_input', $this->CreateTextArea($this->GetPreference('use_question_wysiwyg', 0), $id, $item->question, 'question', '', $id . 'question', '', '', 80, 5, '', '', 'style="height:80px;"'));

	$smarty->assign('faq_answer_label', $this->Lang('answer'));
	$smarty->assign('faq_answer_input', $this->CreateTextArea($this->GetPreference('use_answer_wysiwyg', 1), $id, $item->answer, 'answer', '', $id . 'answer', '', '', 80, 10, '', '', 'style="height:200px;"'));

	$categorieslist = FAQ_utils::GetCategorieslist();
	$selectedcategories = $item->categories; //(array)unserialize($this->GetPreference('categories', ''));
	$smarty->assign('faq_categories_label', $this->Lang('categories'));
	$smarty->assign('faq_categories_input', $this->CreateInputSelectList($id, 'categories[]', $categorieslist, $selectedcategories, 6));

	$smarty->assign('faq_active_label', lang('active'));
	$smarty->assign('faq_active_input', $this->CreateInputCheckbox($id, 'active', '1', $item->active));

	$smarty->assign('submit', $this->CreateInputSubmit($id, 'submit', lang('submit')));
	//$smarty->assign('apply', $params['mode'] == 'add' ? '' : $this->CreateInputSubmit($id, 'applybutton', $this->Lang('apply')));
	$smarty->assign('cancel', $this->CreateInputSubmit($id, 'cancel', lang('cancel')));

	$params = array('mode' => $params['mode'], 'categoryid' => $params['categoryid'], 'entryid' => $params['entryid']);
	$smarty->assign('formstart', $this->CreateFormStart($id, 'edititem', $returnid, 'post', '', false, '', $params));
	$smarty->assign('formend', $this->CreateFormEnd());

	echo $this->ProcessTemplate('edititem.tpl');
}
?>