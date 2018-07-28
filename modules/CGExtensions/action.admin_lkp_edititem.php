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
    $mod = \cms_utils::get_module($module_name);
    if( !$mod ) throw new \LogicException("Could not get instance of module ".$module_name);
    $formdata = $class::get_addedit_formdata();
    if( ! $formdata instanceof \CGExtensions\lookup_form_data ) throw new \LogicException('Problem occurred getting form data for lookup table: '.$class);
    $formdata->validate();

    $item = new $class;
    if( $item_id > 0 ) $item = $class::load($item_id);

    // handle the form
    if( isset($params['cancel']) ) {
        // @todo add showmessage here.
        if( $formdata->cancel_message ) $mod->SetMessage($formdata->cancel_message);
        $mod->RedirectToTab($id,$formdata->return_tab,'',$formdata->return_action);
    }
    else if( isset($params['submit']) ) {
        $in_edit = ($item->id > 0) ? TRUE : FALSE;
        $item->name = cge_param::get_string($params,'name');
        $item->description = cge_param::get_html($params,'description');
        $item->save();

        // all done.
        if( $in_edit ) {
            if( $formdata->post_edit_message ) $mod->SetMessage($formdata->post_edit_message);
        } else if( $formdata->post_add_message ) {
            $mod->SetMessage($formdata->post_add_message);
        }
        $mod->RedirectToTab($id,$formdata->return_tab,'',$formdata->return_action);
    }

    // build the form
    $parms = array('_m'=>$module_name,'_c'=>$class,'_i'=>$item_id);
    $tpl = $this->CreateSmartyTemplate('admin_lkp_edititem.tpl');
    $tpl->assign('item',$item);
    $tpl->assign('title',$formdata->title);
    $tpl->assign('subtitle',$formdata->subtitle);
    $tpl->assign('formstart',$this->CGCreateFormStart($id,'admin_lkp_edititem',$returnid,\cge_utils::encrypt_params($parms)));
    $tpl->assign('formend',$this->CreateFormEnd());
    $tpl->display();
}
catch( \Exception $e ) {
    $mod->SetError($e->GetMessage());
    $mod->RedirectToTab($id,$formdata->return_tab,'',$formdata->return_action);
}
#
# EOF
#
?>
