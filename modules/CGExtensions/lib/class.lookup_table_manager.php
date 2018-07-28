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

namespace CGExtensions;

class lookup_table_manager
{
    private $_data = array('_m'=>null,'_c'=>null);

    public function __construct($module,$class)
    {
        $this->_data['_m'] = (string) $module;
        $this->_data['_c'] = (string) $class;

        // @todo: check to see if module works
    }

    public function get_class()
    {
        return $this->_data['class'];
    }

    public function display_manager()
    {
        // only for admin requests.
        if( \CmsApp::get_instance()->is_frontend_request() ) throw new \LogicException(__METHOD__.' cannot be used for frontend requests.');

        $class = $this->_data['_c'];
        $list = $class::load_all();

        // transform the list into a simple class
        $mod = \cms_utils::get_module(MOD_CGEXTENSIONS);
        $newlist = array();
        $keys = array_keys($list);
        for( $i = 0, $n = count($keys); $i < $n; $i++ ) {
            $key = $keys[$i];
            $item = $list[$key];
            $n_item = new \StdClass;
            $n_item->id = $item->id;
            $n_item->name = $item->name;
            $n_item->description = $item->description;
            $n_item->iorder = $item->iorder;

            $parms = $this->_data;
            $parms['_i'] = $n_item->id;
            $n_item->edit_url = $mod->create_url('m1_','admin_lkp_edititem','',\cge_utils::encrypt_params($parms));
            $n_item->del_url = $mod->create_url('m1_','admin_lkp_delitem','',\cge_utils::encrypt_params($parms));
            if( $i > 0 && count($list) > 1 ) {
                // can move up
                $parms['_dir'] = 'up';
                $n_item->up_url = $mod->create_url('m1_','admin_lkp_moveitem','',\cge_utils::encrypt_params($parms));
            }
            if( count($list) > 1 && $i < count($list) - 1 ) {
                // can move down
                $parms['_dir'] = 'down';
                $n_item->down_url = $mod->create_url('m1_','admin_lkp_moveitem','',\cge_utils::encrypt_params($parms));
            }

            $newlist[] = $n_item;
        }
        $tpl = $mod->CreateSmartyTemplate('lookup_table_list.tpl');
        $tpl->assign('items',$newlist);
        $tpl->assign('class',$class);
        $tpl->assign('cge',$mod);
        $tpl->assign('add_url',$mod->create_url('m1_','admin_lkp_edititem','',\cge_utils::encrypt_params($this->_data)));
        $tpl->display();
    }
} // end of class

?>