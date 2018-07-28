<?php
#-------------------------------------------------------------------------
# Module: SitemapMgr
# Author: Rolf Tjassens
#-------------------------------------------------------------------------
# CMS Made Simple is (c) 2004 - 2011 by Ted Kulp (wishy@cmsmadesimple.org)
# CMS Made Simple is (c) 2011 - 2017 by The CMSMS Dev Team
# This project's homepage is: http://www.cmsmadesimple.org
# The module's homepage is: http://dev.cmsmadesimple.org/projects/sitemapmgr
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

if ( !cmsms() ) exit;

if ( !$this->CheckPermission('Modify Modules') ) {
	echo $this->ShowErrors($this->Lang('accessdenied'));
	return;
}

if (isset($params['message']))
	echo $this->ShowMessage($this->Lang($params['message']));

if (isset($params['errors']) && count($params['errors']))
	echo $this->ShowErrors($params['errors']);

if ( $this->GetPreference('sitemapmgr_firstrun') == 'true' )
{
	// create initial sitemap file for pages and the sitemap index file
	$this->CreateSitemap('1');
	$this->CreateSitemapIndex();
	
	// don't need this anymore
	$this->RemovePreference('sitemapmgr_firstrun');
}

$active_tab = (isset($params['active_tab']) ? $params['active_tab'] : 'sitemaps');

if (empty($config['permissive_smarty']))
	echo '<p class="red">' . $this->Lang('warning_permissive_smarty') . '</p>';

if (!preg_match("/http/i", $config['root_url']))
	echo '<p class="red">' . $this->Lang('warning_protocol_less_urls') . '</p>';

$lastrun_time = date("j F Y - G:i:s", $this->GetPreference('updatesitemapstask_lastrun') );
echo '<p class="pagewarning">' . $this->Lang('label_lastrun') . ':&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br />' . $lastrun_time . '</p>';

echo $this->StartTabHeaders();
	echo $this->SetTabHeader('humanstxt', $this->Lang('humanstxt'), 'humanstxt' == $active_tab ? true : false);
	echo $this->SetTabHeader('robotstxt', $this->Lang('robotstxt'), 'robotstxt' == $active_tab ? true : false);
	echo $this->SetTabHeader('sitemaps', $this->Lang('sitemaps').':', 'sitemaps' == $active_tab ? true : false);
	
	// -----------------------------------------------
	$db = cmsms()->GetDb();
	$query = "SELECT * FROM " . CMS_DB_PREFIX . "module_sitemapmgr ORDER BY sitemap_name";
	$dbresult = $db->Execute($query);
	
	$tab_content = array();
	
	while ( $row = $dbresult->FetchRow() ) {
		echo $this->SetTabHeader('sitemap'.$row['sitemap_id'], $row['sitemap_name'], 'sitemap'.$row['sitemap_id'] == $active_tab ? true : false);
		$tab_content[] = $row;
	}
	// -----------------------------------------------
	
echo $this->EndTabHeaders();

echo $this->StartTabContent();
	echo $this->StartTab('humanstxt');
		include 'function.humanstxt.php';
	echo $this->EndTab();
	
	echo $this->StartTab('robotstxt');
		include 'function.robotstxt.php';
	echo $this->EndTab();
	
	echo $this->StartTab('sitemaps');
		include 'function.sitemaps.php';
	echo $this->EndTab();
	
	// -----------------------------------------------
	foreach($tab_content as $entry) {
		echo $this->StartTab('sitemap'.$entry['sitemap_id'], $params);
			
			$admintheme = cms_utils::get_theme_object();
			
			$smarty->assign('sitemap_id', $this->CreateInputHidden($id, 'sitemap_id', $entry['sitemap_id']));
			$smarty->assign('label_sitemap_type', $this->Lang('label_sitemap_type'));
			$smarty->assign('sitemap_type', $entry['sitemap_type']);
			
			$smarty->assign('input_sitemap_name_hidden', $this->CreateInputHidden($id, 'sitemap_name_existing', $entry['sitemap_name']));
			
			$smarty->assign('label_sitemap_name', $this->Lang('label_sitemap_name'));
			$smarty->assign('input_sitemap_name', $this->CreateInputText($id, 'sitemap_name', $entry['sitemap_name']));
			
			$smarty->assign('label_sitemap_tag', $this->Lang('label_sitemap_tag'));
			$smarty->assign('input_sitemap_tag', $this->CreateInputText($id, 'sitemap_tag', $entry['sitemap_tag']));

			$smarty->assign('label_sitemap', $this->Lang('label_sitemap'));

			$smarty->assign('label_delete_sitemap', $this->Lang('label_delete_sitemap'));
			$smarty->assign('delete', $this->Lang('delete'));
			$smarty->assign('areyousure', $this->Lang('areyousure'));
			
			$smarty->assign('label_description', $this->Lang('label_description'));
			$smarty->assign('sitemap_description', $this->Lang('description_'.$entry['sitemap_type']));
			$smarty->assign('label_documentation', $this->Lang('label_documentation'));
			$smarty->assign('sitemap_documentation', $this->Lang('help_'.$entry['sitemap_type']));
			
			$smarty->assign('label_default_template_content', $this->Lang('label_default_template_content'));
			$smarty->assign('template_content', ''); // default
			$not_designmgr_comp = array ('sitemap_compdir', 'sitemap_liseinstance', 'sitemap_custom');
			if ( in_array ( $entry['sitemap_type'], $not_designmgr_comp ) )
			{
				$the_template_content = file_get_contents( dirname(__FILE__) . '/templates/default_' . strtolower($entry['sitemap_type']) . '.tpl' );
				$smarty->assign('template_content', $this->CreateTextArea ( false, '', $the_template_content, 'cms_textarea', '', '', '', '', '', '', '', '', 'readonly' ) );
			}
			
			$smarty->assign('submit', $this->CreateInputSubmit($id, 'submit', lang('submit')));
			$smarty->assign('cancel', $this->CreateInputSubmit($id, 'cancel', lang('cancel')));
			
			if ( file_exists( $config['root_path'] . '/assets/sitemaps/sitemap-' . strtolower($entry['sitemap_name']) . '.xml' ) )
			{
				$file_url = $config['root_url'] . '/assets/sitemaps/sitemap-' . strtolower($entry['sitemap_name']) . '.xml';
				$open_file = '<a href="' . $file_url . '" target="_blank" class="external">' . $file_url . '</a>';
				$sitemap_available = '';
			} else {
				$open_file = '';
				$sitemap_available = $this->Lang('no_sitemap_found');
			}
			
			$smarty->assign('open_file', $open_file);
			$smarty->assign('sitemap_available', $sitemap_available);
			
			echo $this->ProcessTemplate('tab_sitemap.tpl');
		echo $this->EndTab();
	}
	// -----------------------------------------------

echo $this->EndTabContent();

#
# EOF
#
?>