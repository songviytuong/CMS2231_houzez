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
if( !isset($params['sel_modules']) ) return;

$dom = new DOMDocument('1.0','UTF8');
$root = $dom->createElement('cmsms_code_export');
$udtops = $gCms->GetUserTagOperations();

foreach( $params['sel_templates'] as $one_item ) {
    $parent = '';
    if( startswith($one_item,'::udt::') ) {
        // a global content block.
        list($junk,$section,$udt_name) = explode('::',$one_item,3);
        if( $junk != '' || $section != 'udt' || $udt_name == '' ) continue;

        $tag = $udtops->GetUserTag($udt_name);
        if( !$tag || !isset($tag['code']) ) continue;

        $parent = $dom->createElement('userdefined_tag');
        $sub = $dom->createElement('name',$udt_name);
        $parent->appendChild($sub);

        $sub = $dom->createElement('description');
        $cdata = $dom->createCDATAsection(base64_encode($tag['description']));
        $sub->appendChild($cdata);
        $parent->appendChild($sub);

        $sub = $dom->createElement('code');
        $enc = base64_encode($tag['code']);
        $cdata = $dom->createCDATAsection($enc);
        $sub->appendChild($cdata);
        $parent->appendChild($sub);
    }
    else {
        // a module template.
        list($module_name,$tpl_name) = explode('::',$one_item,2);
        if( $module_name == '' || $tpl_name == '' ) continue;

        $tpl = $this->GetTemplate($tpl_name,$module_name);
        if( $tpl == '' ) continue;
        $tpl = base64_encode($tpl);

        $parent = $dom->createElement('module_template');

        $sub = $dom->createElement('module',$module_name);
        $parent->appendChild($sub);

        $sub = $dom->createElement('name',$tpl_name);
        $parent->appendChild($sub);

        $sub = $dom->createElement('template');
        $cdata = $dom->createCDATAsection($tpl);
        $sub->appendChild($cdata);
        $parent->appendChild($sub);
    }

    if( $parent ) $root->appendChild($parent);
}

$dom->appendChild($root);
$txt = $dom->saveXML();
$handlers = ob_list_handlers();
for ($cnt = 0; $cnt < sizeof($handlers); $cnt++) { ob_end_clean(); }

header('Pragma: public');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Cache-Control: private',false);
header('Content-Description: Export');
header('Content-Description: File Transfer');
header('Content-Type: application/force-download');
header('Content-Disposition: attachment; filename=cgcu_code_export.xml');
// header('Content-type: text/xml');
echo $txt;
exit();
