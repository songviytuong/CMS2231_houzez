<?php
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: CGBetterForms (c) 2017-6 by Robert Campbell (calguy1000@cmsmadesimple.org)
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
if (!isset($gCms)) exit;

try {
    // clear output buffers.
    $handlers = ob_list_handlers();
    for ($cnt = 0; $cnt < sizeof($handlers); $cnt++) { ob_end_clean(); }

    $config = \cms_config::get_instance();
    $guid = \cge_param::get_string($_REQUEST,'guid');
    $element = \cge_param::get_string($_REQUEST,'element');
    if( !$guid ) throw new \LogicException('Missing guid param',400);
    if( !$element ) throw new \LogicException('Missing element param',400);

    if( !isset($_FILES) || !isset($_FILES['file']) ) throw new \RuntimeException('Nothing uploaded',400);
    $file = $_FILES['file'];
    if( $file['size'] == 0 || $file['error'] > 0 ) throw new \RuntimeException('Problem uploading file ',400);
    if( !is_uploaded_file($file['tmp_name']) ) throw new \RuntimeException('Invalid upload file ',400);

    $tmp_location = TMP_CACHE_LOCATION.'/'.$guid;
    @mkdir($tmp_location);
    $tmp_filename = md5(time().$guid.$element.$file['tmp_name']);
    @move_uploaded_file( $file['tmp_name'], $tmp_location.'/'.$tmp_filename );

    \cge_utils::send_ajax_and_exit( [ 'tmp_name'=>$tmp_filename, 'element'=>$element, 'guid'=>$guid, 'name'=>$file['name'], 'size'=>$file['size'] ] );
}
catch( \Exception $e ) {
    $code = $e->getCode();
    header('HTTP/1.0 '.$code.' '.$e->GetMessage());
    header('Status '.$code.' '.$e->GetMessage());
    exit;
}


#
# EOF
#
