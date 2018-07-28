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
if( !$modify_templates && !$modify_udt && !$modify_gcb ) exit;
$this->SetCurrentTab('import_code');

$uploader = new cg_fileupload($id,TMP_CACHE_LOCATION);
$uploader->set_accepted_filetypes('xml');
$uploader->set_allow_overwrite(true);
$res = $uploader->handle_upload('xmlfile',$this->GetName().'_code_import.tmp');
$err = '';
if( !$res )
{
    $err = $uploader->get_error();
    if( $err == cg_fileupload::NOFILE )
    {
        $res = $this->session_get('code_filename');
        if( !$res || !file_exists(TMP_CACHE_LOCATION.'/'.$res) )
        {
            $err = $this->Lang('error_upload');
        }
    }
    else
    {
        $err = $this->GetUploadErrorMessage($err);
    }
}
if( !$res )
{
    $this->SetError($err);
    $this->RedirectToTab($id);
}
$this->session_put('code_filename',$res);
$fn = TMP_CACHE_LOCATION.'/'.$res;
$reader = new cgcu_code_reader($fn);
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
    $row['available'] = 1;
    $row['new_name'] = $row['name'];

    switch( $row['type'] ) {
    case 'module_template':
        $obj = cge_utils::get_module($row['module']);
        if( !is_object($obj) ) {
            $row['available'] = 0;
            continue;
        }
        if( cgcu_utils::module_template_exists($row['module'],$row['name']) ) {
            $row['new_name'] = cgcu_utils::module_template_newname($row['module'],$row['name']);
        }
        $num_available++;
        break;

    case 'userdefined_tag':
        if( cgcu_utils::udt_exists($row['name']) ) {
            $row['new_name'] = cgcu_utils::udt_newname($row['name']);
        }
        $num_available++;
        break;
    }
}

//
// build the preview form.
//
$smarty->assign('filename',$res);
$smarty->assign('formstart',$this->CGCreateFormStart($id,'admin_import_code'));
$smarty->assign('formend',$this->CreateFormEnd());
$smarty->assign('scanned_data',$all_data);
$smarty->assign('num_available',$num_available);
echo $this->ProcessTemplate('admin_scan_code.tpl');

#
# EOF
#
?>