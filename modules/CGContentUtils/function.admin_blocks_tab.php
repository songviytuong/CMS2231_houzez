<?php
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: CGContentUtils (c) 2009 by Robert Campbell
#         (calguy1000@cmsmadesimple.org)
#  An addon module for CMS Made Simple to provide various additional utilities
#  for dealing with content pages.
#
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2005 by Ted Kulp (wishy@cmsmadesimple.org)
# This project's homepage is: http://www.cmsmadesimple.org
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
if (!isset($gCms)) exit;

//
// initialization
//

//
// setup
//

//
// get the data
//
$fmt = "{content_module module='CGContentUtils' block='%s'}";
$query = 'SELECT * FROM '.cms_db_prefix().'module_cgcontentutils';
$data = $db->GetArray($query);
if( $data && is_array($data) && count($data) > 0 ) {
  for( $i = 0; $i < count($data); $i++ ) {
    $row =& $data[$i];
    $row['sampletag'] = sprintf($fmt,$row['name']);
    $row['edit_url'] = $this->create_url($id,'admin_edit_block',$returnid,
					 array('blockid'=>$row['id']));
    $row['editlink'] = $this->CreateImageLink($id,'admin_edit_block',$returnid,
					      $this->Lang('edit'),
					      'icons/system/edit.gif',
					      array('blockid'=>$row['id']));
    $row['deletelink'] = $this->CreateImageLink($id,'admin_delete_block',$returnid,
						$this->Lang('delete'),
						'icons/system/delete.gif',
						array('blockid'=>$row['id']),
						'',
						$this->Lang('ask_delete_block'));
  }
}

//
// give everything to smarty
//
if( $data && is_array($data) && count($data) > 0 ) $smarty->assign('data',$data);
$smarty->assign('addlink',
		$this->CreateImageLink($id,'admin_edit_block',$returnid,
				       $this->Lang('add_block'),
				       'icons/system/newobject.gif',
				       array(), '', '', false));

//
// display the template
//
echo $this->ProcessTemplate('admin_blocks_tab.tpl');
#
# EOF
#
