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
# This projects homepage is: http://www.cmsmadesimple.org
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
if( !$this->CheckPermission('Modify Templates') ) exit;

debug_to_log('ajax_gettemplates');
debug_to_log($_POST);
debug_to_log('__');

if( !isset($_POST['sel_items']) || !is_array($_POST['sel_items']) ) return;

$res = array();
foreach( $_POST['sel_items'] as $item ) {
    if( $item == 'udt::' ) {
        $ops = $gCms->GetUserTagOperations();
        $all_tags = $ops->ListUserTags();
        foreach( $all_tags as $one ) {
            $res[] = '::udt::'.$one;
        }
    }
    else {
        // assume it's a module.
        $module = cge_utils::get_module($item);
        if( !$module ) continue;

        // get a list of the templates for this module.
        $templates = $module->ListTemplates();
        foreach( $templates as $template ) {
            $res[] = $item.'::'.$template;
        }
    }
}

debug_to_log($res);
debug_to_log('__');
echo json_encode($res);

#
# EOF
#
?>