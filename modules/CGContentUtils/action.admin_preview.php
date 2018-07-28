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
if( !isset($gCms) ) exit;
if( !isset($params['file']) || !isset($params['type']) || !isset($params['name']) )
  {
    echo $this->ShowErrors($this->Lang('error_missing_param'));
    return;
  }

if( isset($params['submit']) )
  {
    $this->Redirect($id,'admin_scan_code');
  }

// get the record out of the file.
$fn = TMP_CACHE_LOCATION.'/'.$params['file'];
$reader = new cgcu_code_reader($fn);
$tmp = $reader->get_record($params['name']);
if( !is_array($tmp) ) {
    echo $this->ShowErrors($this->Lang('error_missing_param'));
    return;
}

if( isset($tmp['code']) ) {
    $tmp['code'] = base64_decode($tmp['code']);
}
else if( isset($tmp['template']) ) {
    $tmp['code'] = base64_decode($tmp['template']);
}
$smarty->assign('formstart',$this->CGCreateFormStart($id,'admin_preview',$returnid,$params));
$smarty->assign('formend',$this->CreateFormEnd());
$smarty->assign('data',$tmp);

echo $this->ProcessTemplate('admin_preview.tpl');
