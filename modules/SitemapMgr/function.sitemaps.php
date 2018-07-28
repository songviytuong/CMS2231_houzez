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

if (isset($params['cancel'])) 
	$this->Redirect($id, 'defaultadmin', $returnid, array('active_tab' => 'sitemaps'));

$smarty->assign('label_create_sitemap', $this->Lang('label_create_sitemap'));

$smarty->assign('label_new_sitemap', $this->Lang('label_new_sitemap'));
$smarty->assign('input_new_sitemap', $this->CreateInputText($id, 'new_sitemap_name', ''));
$smarty->assign('create_new_sitemap', $this->CreateInputSubmit($id, 'create_new_sitemap', $this->lang('create')));

$smarty->assign('label_sitemap_type', $this->Lang('label_sitemap_type'));
$smarty->assign('input_sitemap_type', $this->CreateInputDropdown($id, 'new_sitemap_type',
	array ( $this->Lang('sitemap_pages') => 'sitemap_pages',
		$this->Lang('sitemap_news') => 'sitemap_news',
		$this->Lang('sitemap_cgblog') => 'sitemap_cgblog',
		$this->Lang('sitemap_cgcalendar') => 'sitemap_cgcalendar',
		$this->Lang('sitemap_compdir') => 'sitemap_compdir',
		$this->Lang('sitemap_liseinstance') => 'sitemap_liseinstance',
		$this->Lang('sitemap_products') => 'sitemap_products',
		$this->Lang('sitemap_custom') => 'sitemap_custom' ),
		-1,
		''
	)
);

$smarty->assign('cancel', $this->CreateInputSubmit($id, 'cancel', lang('cancel')));

$open_file = '<a href="' . cms_join_path( $config['root_url'],'sitemap.xml' ) . '" target="_blank" class="external">' . $config['root_url'] . '/sitemap.xml</a>';
$smarty->assign('open_file', $open_file);

$smarty->assign('label_sitemap_index', $this->Lang('label_sitemap_index'));
$smarty->assign('help_sitemap_index', $this->Lang('help_sitemap_index'));

$smarty->assign('label_documentation', $this->Lang('label_documentation'));
$smarty->assign('sitemap_documentation', $this->Lang('help_new_sitemap'));

echo $this->ProcessTemplate('tab_sitemaps.tpl');

#
# EOF
#
?>