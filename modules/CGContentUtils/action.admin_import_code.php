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
$modify_templates = $this->CheckPermission('Modify Templates');
$modify_udt = $this->CheckPermission('Modify User-defined Tags');
if( !$modify_templates && !$modify_udt ) exit;
$this->SetCurrentTab('import_code');

$filename = $this->session_get('code_filename');
if( !$filename ) {
    $this->SetError($this->Lang('error_uploadnotfound'));
    $this->RedirectToTab($id);
}
$filename = TMP_CACHE_LOCATION.'/'.$filename;
if( !file_exists($filename) ) {
    $this->SetError($this->Lang('error_uploadnotfound'));
    $this->RedirectToTab($id);
}

$reader = new cgcu_code_reader($filename);
$error = $reader->get_error();
if( $error ) {
    $this->SetError($this->Lang($error));
    $this->RedirectToTab($id);
}
$all_data = $reader->get_data();

$num_available = 0;
for( $i = 0; $i < count($all_data); $i++ ) {
    $row =& $all_data[$i];
    $row['uniqueid'] = 'x'.md5(serialize($row));
    switch( $row['type'] ) {
    case 'module_template':
        $obj = cge_utils::get_module($row['module']);
        if( !is_object($obj) ) continue;
        if( cgcu_utils::module_template_exists($row['module'],$row['name']) ) {
            $row['new_name'] = cgcu_utils::module_template_newname($row['module'],$row['name']);
        }
        $row['available'] = 1;
        $num_available++;
        break;

    case 'userdefined_tag':
        if( cgcu_utils::udt_exists($row['name']) ) {
            $row['new_name'] = cgcu_utils::udt_newname($row['name']);
        }
        $row['available'] = 1;
        break;
    }
}


//
// handle form input
//
if( isset($params['import']) ) {
    if( !isset($params['import_item']) || !is_array($params['import_item']) ||
	count($params['import_item']) == 0 ) {
        echo $this->ShowErrors($this->Lang('error_nothingselected'));
    }
    else {
        // build an array of the items we are gonna import.
        $import_items = array();
        foreach( $params['import_item'] as $one ) {
            for( $i = 0; $i < count($all_data); $i++ ) {
                if( $all_data[$i]['uniqueid'] == $one ) {
                    $import_items[$one] = $all_data[$i];
                }
                if( isset($params['new_name'][$one]) && !empty($params['new_name'][$one]) ) {
                    $import_items[$one]['new_name'] = $params['new_name'][$one];
                }
            }
        }

        //
        // at this point we must confirm stuff.
        //
        $smarty->assign('import_data',base64_encode(serialize($import_items)));
        $smarty->assign('import_items',$import_items);
        $smarty->assign('formstart',$this->CGCreateFormStart($id,'admin_import_code'));
        $smarty->assign('formend',$this->CreateFormEnd());

        echo $this->ProcessTemplate('admin_import_code.tpl');
    }
}
else if( isset($params['do_import']) && isset($params['confirm_import']) )  {
    if( !isset($params['import_data']) )  {
        echo $this->SetError($this->Lang('error_missing_params'));
        $this->RedirectToTab($id);
    }

    $data = unserialize(base64_decode($params['import_data']));
    foreach( $data as $item ) {
        switch( $item['type'] ) {
        case 'module_template':
            $mod = cge_utils::get_module($item['module']);
            if( $mod ) {
                $tpl = base64_decode($item['template']);
                $mod->SetTemplate($item['new_name'],$tpl);
            }
            break;

        case 'userdefined_tag':
            $ops = cmsms()->getUserTagOperations();
            $desc = isset($item['description']) ? base64_decode($item['description']) : null;
            $ops->SetUserTag($item['new_name'],base64_decode($item['code']),$desc);
            break;
        }
    }

    $this->SetMessage($this->Lang('msg_imported',count($data)));
    $this->RedirectToTab($id);
}
else  {
    $this->SetMessage($this->Lang('msg_cancelled'));
    $this->RedirectToTab($id);
}

#
# EOF
#
?>