<?php
#-------------------------------------------------------------------------
# Module: FAQ
# Author: Jos (josvd@live.nl)
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2008 by Ted Kulp (wishy@cmsmadesimple.org)
# This project's homepage is: http://www.cmsmadesimple.org
# The module's homepage is: http://dev.cmsmadesimple.org/projects/faq/
#-------------------------------------------------------------------------

class FAQ_utils
{
	protected function __construct() {}

	
	public static function GetCategories($category = '', $filter = true, $lang = '') {
		$output = array();
		
		$db = cmsms()->GetDB();
		$query = "SELECT
								c.*,
								COUNT(e.entry_id) AS entries
							FROM
								" . cms_db_prefix() . "module_faq_categories c
							LEFT JOIN
								" . cms_db_prefix() . "module_faq_catentries ce
							ON
								c.category_id = ce.category_id
							LEFT JOIN
								" . cms_db_prefix() . "module_faq_entries e
							ON
								ce.entry_id = e.entry_id
							";
		if ( $filter === true )
		{
			$query .= "	AND e.active = 1
							";
		}
		$query .= "WHERE
								1 = 1
								";
		if ( ctype_digit($category) )
		{
			$query .= "AND c.category_id = " . $db->Qmagic($category) . " 
								";
		}
		elseif ( !empty($category) )
		{
			$query .= "AND c.alias = " . $db->Qmagic($category) . "
								";
		}
		if ( $filter === true )
		{
			$query .= "AND c.active = 1
								";
		}
		if ( !empty($lang) )
		{
			$query .= "AND (c.lang = " . $db->Qmagic($lang) . " OR c.lang = '')
								";
		}
		$query .= "GROUP BY
								c.category_id
							ORDER BY
								c.sort ASC";

		$result = $db->Execute($query);

		if ( $result && $result->RecordCount() > 0 )
		{
		  while ( $row=$result->FetchRow() )
		  {
		    $output[] = $row;
		  }
		}
		if ( !$result )
		{
			echo 'ERROR: ' . __LINE__ . ' » ' . $db->ErrorMsg();
			exit();
		}
		return $output;

	}
	
	
	public static function GetCategorieslist($category = '') {
		$output = array();
		
		$db = cmsms()->GetDB();
		$query = "SELECT
								category_id, category
							FROM
								" . cms_db_prefix() . "module_faq_categories
							ORDER BY
								lang ASC, sort ASC";
		if ( empty($category) )
		{
			$result = $db->Execute($query);
		}
		else
		{
			$result = $db->Execute($query, array($category));
		}
		if ( $result && $result->RecordCount() > 0 )
		{
		  while ( $row=$result->FetchRow() )
		  {
		    $output[$row['category']] = $row['category_id'];
		  }
		}
		if ( !$result )
		{
			echo 'ERROR: ' . __LINE__ . ' » ' . $db->ErrorMsg();
			exit();
		}
		return $output;

	}
	
	
	public static function GetEntries($category = '', $start = 1, $number = 10000, $filter = true, $lang = '', $parseSmarty = false) {
		$start = ($start < 1) ? 0 : $start - 1;
		$output = array();

		$db = cmsms()->GetDB();
		$query = "SELECT
								e.*, ce.sort, ce.category_id, c.category, c.lang
							FROM
								" . cms_db_prefix() . "module_faq_entries e,
								" . cms_db_prefix() . "module_faq_catentries ce,
								" . cms_db_prefix() . "module_faq_categories c
							WHERE
								e.entry_id = ce.entry_id
								AND ce.category_id = c.category_id
								";
		if ( ctype_digit($category) )
		{
			$query .= "AND ce.category_id = " . $db->Qmagic($category) . " 
								";
		}
		elseif ( !empty($category) )
		{
			$query .= "AND c.alias = " . $db->Qmagic($category) . "
								";
		}
		if ( $filter === true )
		{
			$query .= "AND e.active = 1 AND c.active = 1
								";
		}
		if ( !empty($lang) )
		{
			$query .= "AND (c.lang = " . $db->Qmagic($lang) . " OR c.lang = '')
								";
		}
		$query .= "ORDER BY c.sort ASC, ce.sort ASC";
		$result = $db->SelectLimit($query, $number, $start) ;
		if ( $result && $result->RecordCount() > 0 )
		{
		  while ( $row = $result->FetchRow() )
		  {
				$onerow = new stdClass();
				$onerow->entry_id = $row['entry_id'];
				$onerow->category_id = $row['category_id'];
				$onerow->category = $row['category'];
				$onerow->question = $row['question'];
				$onerow->answer = $row['answer'];
				$onerow->sort = $row['sort'];
				$onerow->lang = $row['lang'];
				$onerow->active = $row['active'];
				
				if ( $parseSmarty )
				{
						$smarty = cmsms()->GetSmarty();
						$onerow->question = $smarty->fetch('eval:'.$row['question']);
						$onerow->answer = $smarty->fetch('eval:'.$row['answer']);
				}
				
				array_push($output, $onerow);
		  }
		}
		if ( !$result )
		{
			echo 'ERROR: ' . __LINE__ . ' » ' . $db->ErrorMsg();
			exit();
		}
		return $output;
	}

	
	public static function GetEntry($entry_id) {
		$output = array();

		$db = cmsms()->GetDB();
		$query = "SELECT
								*
							FROM
								" . cms_db_prefix() . "module_faq_entries
							WHERE
								entry_id = ?
								";
		$result = $db->Execute($query, array($entry_id));
		if ( $result && $result->RecordCount() > 0 )
		{
		  $row = $result->FetchRow();
			$onerow = new stdClass();
			$onerow->entry_id = $row['entry_id'];
			$onerow->question = $row['question'];
			$onerow->answer = $row['answer'];
			$onerow->active = $row['active'];
			$onerow->lang = '';
			$onerow->categories = array();
			$onerow->categorieslist = array();
			
			//get categories for this entry
			$query = "SELECT
									ce.*, c.category, c.lang, c.sort AS catsort, c.active
								FROM
									" . cms_db_prefix() . "module_faq_catentries ce,
									" . cms_db_prefix() . "module_faq_categories c
								WHERE
									ce.category_id = c.category_id
									AND ce.entry_id = ?
									";
			$result = $db->Execute($query, array($entry_id));
			if ( $result && $result->RecordCount() > 0 )
			{
				while ( $row = $result->FetchRow() )
				{
					$onerow->lang = $row['lang'];
					array_push($onerow->categories, $row['category_id']);
					$onerow->categorieslist[$row['category_id']]['category'] = $row['category'];
					$onerow->categorieslist[$row['category_id']]['lang'] = $row['lang'];
					$onerow->categorieslist[$row['category_id']]['sort'] = $row['catsort'];
					$onerow->categorieslist[$row['category_id']]['active'] = $row['active'];
				}
			}
			if ( !$result )
			{
				echo 'ERROR: ' . __LINE__ . ' » ' . $db->ErrorMsg();
				exit();
			}

			$output = $onerow;
		}
		if ( !$result )
		{
			echo 'ERROR: ' . __LINE__ . ' » ' . $db->ErrorMsg();
			exit();
		}
		return $output;
	}


	public static function AddEntry($question, $answer, $active, $categories) {
		$mod = cms_utils::get_module('FAQ');
		$db = cmsms()->GetDB();
		
		$query = "INSERT INTO ".cms_db_prefix()."module_faq_entries (
								question, 
								answer, 
								active) 
							VALUES 
								(?,?,?)";
		$result = $db->Execute($query, array(
				$question, 
				$answer, 
				$active
			));
		if ( !$result )
		{
			return array('error' => 1);
			//echo 'ERROR: ' . __LINE__ . ' » ' . $db->ErrorMsg();
			//exit();
		}
		else
		{
			$insert_id = $db->Insert_ID();

			$search = cms_utils::get_search_module();
			if ( $search != false && $active == 1 )
			{
				$search->AddWords($mod->GetName(), $insert_id, 'entry', $question . ' ' . $answer);
			}

			$catentries = empty($categories) ? 1 : implode(',', $categories);
			$query = "SELECT c.category_id, MAX(ce.sort) AS maxsort
								FROM ".cms_db_prefix()."module_faq_categories c
								LEFT JOIN ".cms_db_prefix()."module_faq_catentries ce ON c.category_id=ce.category_id
								WHERE c.category_id IN (" . $catentries . ")
								GROUP BY c.category_id";
			$result = $db->Execute($query);

			if ( $result && $result->RecordCount() > 0 )
			{
				$insertquery = "INSERT INTO ".cms_db_prefix()."module_faq_catentries (
									category_id, 
									entry_id, 
									sort) 
								VALUES 
									(?,?,?)";
				while ( $row = $result->FetchRow() )
				{
					$insertresult = $db->Execute($insertquery, array($row['category_id'], $insert_id, $row['maxsort'] + 1));
				}
			}
			if ( !$result )
			{
				echo 'ERROR: ' . __LINE__ . ' » ' . $db->ErrorMsg();
				exit();
			}

			$params['entry_id'] = $insert_id;
			$mod->SendEvent('FAQ_entry_added', $params);
			return array('entry added' => array($insert_id));
			
		}

	}


	public static function EditEntry($entry_id, $question, $answer, $categories, $active) {

		$db = cmsms()->GetDB();
		$query = "UPDATE " . cms_db_prefix() . "module_faq_entries SET
								question= ?,
								answer = ?,
								active = ?
							WHERE
								entry_id = ?";
		$result = $db->Execute($query, array(
				$question, 
				$answer, 
				$active,
				$entry_id
		));
		if ( $result )
		{
			$catentries = empty($categories) ? 1 : implode(',', $categories);
			$query = "SELECT c.category_id, MAX(ce.sort) AS maxsort
								FROM ".cms_db_prefix()."module_faq_categories c
								LEFT JOIN ".cms_db_prefix()."module_faq_catentries ce ON c.category_id=ce.category_id
								WHERE c.category_id IN (" . $catentries . ")
								GROUP BY c.category_id";
			$result = $db->Execute($query);

			if ( $result && $result->RecordCount() > 0 )
			{
				$insertquery = "INSERT INTO ".cms_db_prefix()."module_faq_catentries (
									category_id, 
									entry_id, 
									sort) 
								VALUES 
									(?,?,?)";
				while ( $row = $result->FetchRow() )
				{
					$insertresult = $db->Execute($insertquery, array($row['category_id'], $entry_id, $row['maxsort'] + 1));
				}
			}
			if ( !$result )
			{
				echo 'ERROR: ' . __LINE__ . ' » ' . $db->ErrorMsg();
				exit();
			}
			$deletequery = "DELETE FROM ".cms_db_prefix()."module_faq_catentries
											WHERE entry_id=? AND category_id NOT IN (" . $catentries . ")";
			$deleteresult = $db->Execute($deletequery, array($entry_id));
			
			$mod = cms_utils::get_module('FAQ');
			$params['entry_id'] = $entry_id;
			$mod->SendEvent('FAQ_entry_edited', $params);

			//Update search index
			$search = cms_utils::get_search_module();
			if ( $search != false )
			{
				if ( $active == 1 )
				{
					$search->AddWords($mod->GetName(), $entry_id, 'entry', $question . ' ' . $answer);
				}
				else
				{
					$search->DeleteWords($mod->GetName(), $entry_id, 'entry');
				}
			}
			return true;
		}
		else
		{
			echo 'ERROR: ' . __LINE__ . ' » ' . $db->ErrorMsg();
			exit();
		}

	}


	public static function DeleteEntry($entry_id) {
		$db = cmsms()->GetDB();
		$query = "DELETE FROM " . cms_db_prefix() . "module_faq_catentries WHERE entry_id = ?";
		$result = $db->Execute($query, array($entry_id));
		if ( !$result )
		{
			echo 'ERROR: ' . __LINE__ . ' » ' . $db->ErrorMsg();
			exit();
		}
		$query = "DELETE FROM " . cms_db_prefix() . "module_faq_entries WHERE entry_id = ?";
		$result = $db->Execute($query, array($entry_id));
		if ( !$result )
		{
			echo 'ERROR: ' . __LINE__ . ' » ' . $db->ErrorMsg();
			exit();
		}
		
		//Update search index
		$mod = cms_utils::get_module('FAQ');
		$search = cms_utils::get_search_module();
		if ( $search != false )
		{
			$search->DeleteWords($mod->GetName(), $entry_id, 'entry');
		}
		return true;
	}


	public static function GetUsers()
	{
		$users = array();
		$gCms = cmsms();
		$groupops = $gCms->GetGroupOperations();
		$allgroups = $groupops->LoadGroups();
		foreach ($allgroups as $onegroup)
		{
			$users[lang('group') . ': ' . $onegroup->name] = $onegroup->id * -1;
		}
		$userops = $gCms->GetUserOperations();
		$allusers = $userops->LoadUsers();
		foreach ($allusers as $oneuser)
		{
			$users[$oneuser->username] = $oneuser->id;
		}
		return $users;
	}


	public static function GetLangs()
	{
		$MleCMS = cms_utils::get_module('MleCMS');
		if ( $MleCMS != false )
		{
			$langs = $MleCMS->getLangs();
			foreach ($langs as $lang) {
				$obj = CmsNlsOperations::get_language_info($lang['locale']);
				$value = $obj->display();
				if ($obj->fullname())
				{
					$value .= ' (' . $obj->fullname() . ')';
				}
				$langlist[$lang['locale']] = $value;
			}
		}
		else
		{
			$langlist = get_language_list();
		}
		return $langlist;
	}

}
?>