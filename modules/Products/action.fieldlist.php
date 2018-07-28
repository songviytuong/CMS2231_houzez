<?php  /* -*- Mode: PHP; c-set-style: linux; tab-width: 4; c-basic-offset: 4 -*- */
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: Products (c) 2008-2014 by Robert Campbell
#         (calguy1000@cmsmadesimple.org)
#  An addon module for CMS Made Simple to allow users to create, manage
#  and display products in a variety of ways.
#
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2005 by Ted Kulp (wishy@cmsmadesimple.org)
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
if( !isset($gCms) ) exit;

$thetemplate = $this->GetPreference(PRODUCTS_PREF_DFLTCATEGORYLIST_TEMPLATE);
$thetemplate = \cge_param::get_string($params,'categorylisttemplate',$thetemplate);

$cache_id = '|pd'.md5(serialize($params));
$tpl = $this->CreateSmartyTemplate($thetemplate,'categorylist_',$cache_id);
if( !$tpl->isCached() ) {
    try {
        $fields = array();
        {
            $tmp = product_utils::get_fielddefs();
            if( is_array($tmp) ) {
                for( $i = 0; $i < count($tmp); $i++ ) {
                    $obj = $tmp[$i];
                    $fields[$obj->name] = $obj;
                }
            }
        }
        $fieldname = '';
        $showall = 0;

        $detailpage = $this->GetPreference('detailpage',-1);
        $detailpage = \cge_param::get_string($params,'detailpage',$detailpage);

        if( !empty($detailpage) && $detailpage != -1 )  {
            $manager = $gCms->GetHierarchyManager();
            $node = $manager->sureGetNodeByAlias($detailpage);
            if (isset($node)) {
                $content = $node->GetContent();
                if (isset($content)) $detailpage = $content->Id();
            }
            else {
                $node = $manager->sureGetNodeById($detailpage);
                if (!isset($node)) $detailpage = '';
            }
        }
        if( empty($detailpage) || $detailpage == -1 ) $detailpage = $returnid;

        $fieldname = \cge_param::get_string($params,'field');
        if( !$fieldname ) throw new \LogicException("field is a required parameter");
        if( !isset($fields[$fieldname]) ) throw new \LogicException("Could not find a visible custom field named ".$fieldname);
        $showall = \cge_param::get_int($params,'showall');
        $field = $fields[$fieldname];

        // okie, now gotta get the distinct values out of the database
        // for this field.
        $query = 'SELECT DISTINCT value AS name,count(value) as count FROM '.cms_db_prefix().'module_products_fieldvals
           WHERE fielddef_id = ? GROUP BY value';
        $tmp = $db->GetArray($query,array($fields[$fieldname]->id));
        if( $tmp ) {
            $tresults = cge_array::to_hash($tmp,'name');
            foreach( $tresults as $key => &$row ) {
                $nparams = $params;
                unset($nparams['field']);
                $nparams['fieldid'] = $field->id;
                $nparams['fieldval'] = $row['name'];
                $row['summary_url'] = $this->CreateURL($id,'default',$detailpage,$nparams);
            }
            if( $showall ) {
                if( $field->type != 'dropdown' ) {
                    // it's another field type.. prolly a text field.
                    $query = 'SELECT count(A.id) FROM '.cms_db_prefix().'module_products A
                    LEFT JOIN '.cms_db_prefix().'module_products_fieldvals B
                      ON A.id = B.product_id AND B.fielddef_id = ?
                   WHERE B.product_id IS NULL';
                    $trow = array();
                    $trow['count'] = $db->GetOne($query,array($field->id));
                    $trow['name'] = $this->Lang('undefined_field_value');

                    $nparams = $params;
                    unset($nparams['field']);
                    $nparams['fieldid'] = $field->id;
                    $nparams['fieldval'] = '::null::';
                    $trow['summary_url'] = $this->CreateURL($id,'default',$detailpage,$nparams);
                    $tresults['--:products_unset_field:--'] = $trow;
                }
                else {
                    // it's a dropdown
                    // fill in the records for the other options, while preserving option order.
                    $tmp = array();
                    foreach( $field->options as $option ) {
                        if( isset($tresults[$option]) ) {
                            $tmp[$option] = $tresults[$option];
                            continue;
                        }
                        $trow = array();
                        $trow['name'] = $option;
                        $trow['count'] = 0;

                        $nparams = $params;
                        unset($nparams['field']);
                        $nparams['fieldid'] = $field->id;
                        $nparams['fieldval'] = '::null::';
                        $trow['summary_url'] = $this->CreateURL($id,'default',$detailpage,$nparams);
                        $tmp[$option] = $trow;
                    }
                    $tresults = $tmp;
                }
            }

            $results = array();
            foreach( $tresults as $key => $rec ) {
                $results[] = cge_array::to_object($rec);
            }
            $tpl->assign('categorylist',$results);
        }
    }
    catch( \Exception $e ) {
        audit('',$this->GetName(),'fieldlist action: '.$e->GetMessage());
    }
} // not cached

$tpl->display();

#
# EOF
#
?>
