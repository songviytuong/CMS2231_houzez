<?php  /* -*- Mode: PHP; tab-width: 4; c-basic-offset: 2 -*- */
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: CompanyDirectory (c) 2004-6 by Ted Kulp (ted@cmsmadesimple.org)
#   Copyright 2006 - 2014 by Robert Campbell (calguy1000@cmsmadesimple.org)
#
#  An addon module for CMS Made Simple to allow management of and various ways to display
#  company information for use in directories etc.
#
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2005-2010 by Ted Kulp (wishy@cmsmadesimple.org)
# Visit the CMSMS homepage at: http://www.cmsmadesimple.org
#
#-------------------------------------------------------------------------
#
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# However, as a special exception to the GPL, this software is distributed
# as an addon module to CMS Made Simple.  You may not use this software
# in any Non GPL version of CMS Made simple, or in any version of CMS
# Made simple that does not indicate clearly and obviously in its admin
# section that the site was built with CMS Made simple.
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
#END_LICENSE
if( !isset($gCms) ) exit;
if( !$this->CheckPermission('Modify Site Preferences') ) exit;
if( !isset($params['cat']) ) exit;

// first pass... change all the 'root' values to -1 and convert values to a hash
$hier = array();
{
  $tmp = $params['cat'];
  foreach( $tmp as $rid => $parent_id ) {
	if( $parent_id < 1 ) $parent_id = -1;
	$hier[$rid] = array('parent_id'=>$parent_id);
  }
}

// second pass... calculate item_order values for all items.
$calc_iorder = function(&$hier,$parent_id = -1) use (&$calc_iorder) {
  $iorder = 1;
  foreach( $hier as $rid => &$row ) {
	if( $row['parent_id'] == $parent_id ) {
	  $row['item_order'] = $iorder++;
	  $calc_iorder($hier,$rid);
	}
  }
};
$calc_iorder($hier);

// third pass... update parent id, and iorder id
$query = 'UPDATE '.cms_db_prefix().'module_compdir_categories SET parent_id = ?, item_order = ? WHERE id = ?';
foreach( $hier as $rid => $row ) {
  $dbr = $db->Execute($query,array($row['parent_id'],$row['item_order'],$rid));
}

// 4th... update hierarchy positions.
cd_category::calculate_hierarchy_positions();

exit;
#
# EOF
#
?>