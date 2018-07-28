<?php
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: CGExtensions (c) 2008-2014 by Robert Campbell
#         (calguy1000@cmsmadesimple.org)
#  An addon module for CMS Made Simple to provide useful functions
#  and commonly used gui capabilities to other modules.
#
#-------------------------------------------------------------------------
# CMSMS - CMS Made Simple is (c) 2005 by Ted Kulp (wishy@cmsmadesimple.org)
# Visit the CMSMS Homepage at: http://www.cmsmadesimple.org
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
if( !$gCms ) exit();
if( cmsms()->is_frontend_request() ) throw new \LogicException(__METHOD__.' cannot be used for frontend requests.');

$formdata = $mod = null;
try {
    $params = \cge_utils::decrypt_params($params);
    $module_name = cge_param::get_string($params,'_m');
    $class = cge_param::get_string($params,'_c');
    $item_id = cge_param::get_int($params,'_i');
    $dir = cge_param::get_string($params,'_dir','up');
    $mod = \cms_utils::get_module($module_name);
    if( !$mod ) throw new \LogicException("Could not get instance of module ".$module_name);
    $formdata = $class::get_addedit_formdata();
    if( ! $formdata instanceof \CGExtensions\lookup_form_data ) throw new \LogicException('Problem occurred getting form data for lookup table: '.$class);
    $formdata->validate();
    if( $item_id < 1 ) throw new \LogicException('Invalid item id specified for move lookup item');
    $item = $class::load($item_id);

    switch( $dir ) {
    case 'up':
        $class::move_up($item_id);
        break;

    case 'down':
    default:
        $class::move_down($item_id);
        break;
    }
}
catch( \Exception $e ) {
    $mod->SetError($e->GetMessage());
}

$mod->RedirectToTab($id,$formdata->return_tab,'',$formdata->return_action);

#
# EOF
#
?>
