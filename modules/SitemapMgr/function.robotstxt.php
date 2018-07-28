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

$smarty->assign('about_robotstxt', $this->Lang('about_robotstxt'));

if ( !file_exists( cms_join_path( $config['root_path'], 'robots.txt') ) )
	$smarty->assign('robotstxt_available', $this->Lang('no_robotstxt_found'));

$smarty->assign('label_content', $this->Lang('label_content'));
	
$smarty->assign('input_robotstxt_content', $this->CreateTextArea(false, $id, $this->GetPreference('robotstxt_content'), 'robotstxt_content'));

$smarty->assign('reset', $this->Lang('reset'));
$smarty->assign('areyousure', $this->Lang('areyousure'));

$smarty->assign('submit', $this->CreateInputSubmit($id, 'submit', lang('submit')));
$smarty->assign('cancel', $this->CreateInputSubmit($id, 'cancel', lang('cancel')));

if ( file_exists( cms_join_path( $config['root_path'], 'robots.txt') ) ) {
	$open_file = '<a href="' . cms_join_path( $config['root_url'],'robots.txt' ) . '" target="_blank" class="external">' . $config['root_url'] . '/robots.txt</a>';
	$smarty->assign('open_file', $open_file);
} else {
	$smarty->assign('open_file', '');
}

echo $this->ProcessTemplate('tab_robotstxt.tpl');

#
# EOF
#
?>