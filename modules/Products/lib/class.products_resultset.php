<?php

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

final class products_resultset extends \CGExtensions\query\resultset {

    private $_category_cache;
    private $_field_cache;
    private $_hierarchy_cache;
    private $_attribute_cache;
    private $_timelines_cache;
    private $_highlights_cache;
    private $_detailpage;
    private $_hierpage;
    private $_curpage;
    private $_notpretty;
    private $_detailtemplate;

    public function __construct(products_query $query) {
        $this->_filter = $query;
    }

    private function _wildcard($str) {
        if (strpos($str, '*') === FALSE && strpos($str, '%') === FALSE)
            $str = '%' . $str . '%';
        $str = str_replace('*', '%', $str);
        $str = str_replace('%%', '%', $str);
        return $str;
    }

    /**
     * Given a query object... build the sql query to extract the product data.
     */
    protected function _query() {
        if (!is_null($this->_rs))
            return;
        $db = \cge_utils::get_db();
        $obj = $this->_filter;

        $query = 'SELECT SQL_CALC_FOUND_ROWS C.*,PH.hierarchy_id FROM ' . CMS_DB_PREFIX . 'module_products C';
        $where = array();
        $qparms = array();
        $joins = array();

        $joins[] = CMS_DB_PREFIX . 'module_products_prodtohier PH ON PH.product_id = C.id';

        if (isset($obj['productnamelike'])) {
            $where[] = 'C.product_name LIKE ?';
            $qparms[] = $this->_wildcard($obj['productnamelike']);
        } else if (isset($obj['product_id']) && $obj['product_id'] != '') {
            $where[] = 'C.id = ?';
            $qparms[] = $obj['product_id'];
        } else if (isset($obj['alias']) && $obj['alias'] != '') {
            $where[] = 'C.alias = ?';
            $qparms[] = $obj['alias'];
        } else if (isset($obj['sku']) && $obj['sku'] != '') {
            $where[] = 'C.sku = ?';
            $qparms[] = $obj['sku'];
        }
        if (isset($obj['optsku']) && $obj['optsku'] != '') {
            $subquery = 'SELECT DISTINCT product_id FROM ' . CMS_DB_PREFIX . 'module_products_attribs WHERE sku = ?';
            $subparms = array($obj['optsku']);

            $pid = $db->GetOne($subquery, $subparms);
            $where[] = 'C.id = ?';
            $qparms[] = $pid;
        } else if (isset($obj['productlist']) && $obj['productlist'] != '') {
            $tmp = $obj['productlist'];
            if (!is_array($tmp))
                $tmp = explode(',', $tmp);
            $list = array();
            foreach ($tmp as $one) {
                $one = (int) trim($one);
                if ($one > 0)
                    $list[] = $one;
            }
            $list = array_unique($list);
            $where[] = 'C.id IN (' . implode(',', $list) . ')';
        }

        if (isset($obj['desclike']) && $obj['desclike']) {
            $val = trim($obj['desclike']);
            $where[] = 'C.details LIKE ?';
            $qparms[] = $this->_wildcard($val);
        }

        if (($owner = $obj['owner']) > 0) {
            $where[] = 'C.owner = ?';
            $qparms[] = $owner;
        }

        if (isset($obj['status']) && $obj['status'] != '*') {
            $val = $obj['status'];
            if (startswith($val, '!')) {
                $where[] = 'C.status != ?';
                $val = substr($val, 1);
            } else {
                $where[] = 'C.status = ?';
            }
            $qparms[] = $val;
        }

        if (isset($obj['pricerange'])) {
            if (strpos($obj['pricerange'], ':') !== FALSE) {
                list($min, $max) = explode(':', $obj['pricerange']);
                if ($min && $max) {
                    $min = floatval($min);
                    $max = floatval($max);
                    if ($min > $max) {
                        $tmp = $min;
                        $min = $max;
                        $max = $tmp;
                    }
                    $where[] = '(C.price BETWEEN ? AND ?)';
                    $qparms[] = $min;
                    $qparms[] = $max;
                } elseif ($min) {
                    $min = floatval($min);
                    $where[] = 'C.price >= ?';
                    $qparms[] = $min;
                } elseif ($max) {
                    $max = floatval($max);
                    $where[] = 'C.price <= ?';
                    $qparms[] = $max;
                }
            }
        }

        if (isset($obj['hierarchy']) && $obj['hierarchy'] != '') {
            $subquery = 'SELECT DISTINCT id FROM ' . CMS_DB_PREFIX . 'module_products_hierarchy h WHERE ';
            $subparms = array();
            $tmp = explode(',', $obj['hierarchy']);
            $tmp2 = array();
            foreach ($tmp as $one) {
                if (strstr($one, '*') !== FALSE) {
                    $tmp2[] = 'upper(h.long_name) LIKE upper(?)';
                } else {
                    $tmp2[] = 'upper(h.name) = upper(?)';
                }

                $one = cms_html_entity_decode($one);
                $one = trim(str_replace('*', '%', str_replace('"', '_', $one)));
                $subparms[] = $one;
            }
            $subquery .= implode(' OR ', $tmp2);
            $hierarchy_ids = $db->GetCol($subquery, $subparms);

            if (is_array($hierarchy_ids) && count($hierarchy_ids)) {
                //$joins[] = CMS_DB_PREFIX.'module_products_prodtohier ph ON ph.product_id = C.id';
                $where[] = 'PH.hierarchy_id IN (' . implode(',', $hierarchy_ids) . ')';
            }
        } else if (isset($obj['hierarchyid'])) {
            if (isset($obj['nochildren']) && $obj['nochildren']) {
                // do not include children
                $where[] = 'PH.hierarchy_id = ?';
                $qparms[] = (int) $obj['hierarchyid'];
            } else {
                // include children
                // get the long name of this hierarchy id
                $info = hierarchy_ops::get_hierarchy_info((int) $obj['hierarchyid']);
                $str = '**|junk|**';
                if (is_array($info))
                    $str = $info['long_name'] . '%';
                $joins[] = CMS_DB_PREFIX . 'module_products_hierarchy H ON H.id = PH.hierarchy_id';
                $where[] = 'H.long_name LIKE ?';
                $qparms[] = $str;
            }
        }

        if (isset($obj['category']) && $obj['category'] != '') {
            // get the category's
            $ocats = product_utils::get_categories(TRUE);
            $icatids = array();
            $icats = explode(',', $obj['category']);
            if (is_array($icats) && count($icats)) {
                foreach ($icats as $one) {
                    $one = trim($one);
                    if (isset($ocats[$one]))
                        $icatids[] = (int) $ocats[$one]->id;
                }
                $icatids = array_unique($icatids);
            }
            if (count($icatids)) {
                $joins[] = CMS_DB_PREFIX . 'module_products_product_categories cc ON cc.product_id = C.id';
                $where[] = 'cc.category_id IN (' . implode(',', $icatids) . ')';
            } else {
                debug_buffer('products_resultset - category parameter provided to query (' . $obj['category'] . '), but no matching categories found');
            }
        } else if (isset($obj['categoryid']) && $obj['categoryid'] != '') {
            $joins[] = CMS_DB_PREFIX . 'module_products_product_categories pc ON pc.product_id = C.id';
            $where[] = 'pc.category_id = ?';
            $qparms[] = $obj['categoryid'];
        }

        if (isset($obj['excludecat']) && $obj['excludecat'] != '') {
            // get the cateogry id's from the name.
            $ocats = product_utils::get_categories(TRUE);
            $ecats = explode(',', $obj['excludecat']);
            $exclude_ids = array();
            foreach ($ecats as $ecat) {
                if ((int) $ecat > 0) {
                    $exclude_ids[] = (int) $ecat;
                } else {
                    if (isset($ocats[$ecat]))
                        $exclude_ids[] = (int) $ocats[$ecat]->id;
                }
            }
            if (count($exclude_ids)) {
                $joins[] = CMS_DB_PREFIX . 'module_products_product_categories cc ON cc.product_id = C.id';
                $where[] = 'cc.category_id NOT IN (' . implode(',', $exclude_ids) . ')';
            }
        }

        if (isset($obj['fieldid']) && $obj['fieldid'] > 0 && isset($obj['fieldval']) && $obj['fieldval'] != '') {
            // add a default field expression
            $fieldid = $obj['fieldid'];
            $fieldval = $obj['fieldval'];
            $obj->add_field_expr($fieldid, $fieldval);
        }

        $suffix = 'A';
        foreach ($obj->get_field_exprs() as $fieldid => $fieldval) {
            if ($fieldval == '::null::') {
                // handle a case where a field is not set for a product.
                $joins[] = sprintf(CMS_DB_PREFIX . "module_products_fieldvals FV{$suffix} ON C.id = FV{$suffix}.product_id AND FV{$suffix}.fielddef_id = %d", $fieldid);
                $where[] = "(FV{$suffix}.value IS NULL)";
            } else if ($fieldval == '::notnull::') {
                // handle the case where a field is set for a product, but we don't care about the value.
                $joins[] = sprintf(CMS_DB_PREFIX . "module_products_fieldvals FV{$suffix} ON C.id = FV{$suffix}.product_id AND FV{$suffix}.fielddef_id = %d", $fieldid);
                $where[] = "(FV{$suffix}.value != \'\')";
            } else if (strpos($fieldval, ':') !== FALSE) {
                // it's a min:max cast expression.
                list($min, $max) = explode(':', $fieldval, 2);
                $min = trim($min);
                $max = trim($max);
                if ($min && $max) {
                    $joins[] = sprintf(CMS_DB_PREFIX . "module_products_fieldvals FV{$suffix} ON C.id = FV{$suffix}.product_id AND FV{$suffix}.fielddef_id = %d", $fieldid);
                    $where[] = "(CAST(FV{$suffix}.value AS DECIMAL(12,3)) BETWEEN ? AND ?)";
                    $min = floatval($min);
                    $max = floatval($max);
                    $qparms[] = $min;
                    $qparms[] = $max;
                } elseif ($min) {
                    $joins[] = sprintf(CMS_DB_PREFIX . "module_products_fieldvals FV{$suffix} ON C.id = FV{$suffix}.product_id AND FV{$suffix}.fielddef_id = %d", $fieldid);
                    $where[] = "(CAST(FV{$suffix}.value AS DECIMAL(12,3)) >= ?)";
                    $min = floatval($min);
                    $qparms[] = $min;
                } elseif ($max) {
                    $joins[] = CMS_DB_PREFIX . "module_products_fieldvals FV{$suffix} ON C.id = FV{$suffix}.product_id AND FV{$suffix}.fielddef_id = ?";
                    $where[] = "(CAST(FV{$suffix}.value AS DECIMAL(12,3)) <= ?)";
                    $max = floatval($max);
                    $qparms[] = $max;
                }
            } else {
                // limit results to all of the items that have this field, and field value.
                $joins[] = sprintf(CMS_DB_PREFIX . "module_products_fieldvals FV{$suffix} ON C.id = FV{$suffix}.product_id AND FV{$suffix}.fielddef_id = %d", $fieldid);
                if (strpos($fieldval, '*') !== FALSE || strpos($fieldval, '%') !== FALSE) {
                    $where[] = "(FV{$suffix}.value LIKE ?)";
                    $qparms[] = $this->_wildcard($fieldval);
                } else {
                    $where[] = "(FV{$suffix}.value = ?)";
                    $qparms[] = $fieldval;
                }
            }
            $suffix++;
        }

        $sortby = $obj['sortby'];
        $sortorder = $obj['sortorder'];
        $isnotnull = "";
        if (startswith($sortby, 'f:')) {
            $sortby = substr($sortby, 2);
            $fielddefs = product_utils::get_fielddefs(FALSE, TRUE, TRUE);
            if (is_array($fielddefs) && count($fielddefs) && isset($fielddefs[$sortby])) {
                $joins[] = CMS_DB_PREFIX . 'module_products_fieldvals FVS ON C.id = FVS.product_id AND FVS.fielddef_id = ' . (int) $fielddefs[$sortby]->id;
                if (!empty($obj['isnotnull'])) {
                    $isnotnull = 'FVS.value !=""';
                }
                $sortby = 'FVS.value';
            } else {
                $sortby = 'C.product_name';
            }
        } else if ($sortby == 'random') {
            $sortby = 'RAND()';
            $sortorder = '';
        } else {
            $sortby = 'C.' . $sortby;
        }
        //
        // build the query now.
        //
        $expr = ' AND ';
        if (isset($obj['useor']) && $obj['useor'])
            $expr = ' OR ';
        if (count($joins))
            $query .= ' LEFT JOIN ' . implode(' LEFT JOIN ', $joins);
        if (count($where))
            $query .= ' WHERE ' . implode($expr, $where);
        if ($obj['sorttype'] == '') {
            if (!empty($obj['isnotnull'])) {
                $query .= ' AND ' . $isnotnull . ' ORDER BY ' . $sortby . ' ' . $obj['sortorder'];
            } else {
                $query .= ' ORDER BY ' . $sortby . ' ' . $obj['sortorder'];
            }
        } else {
            $query .= ' ORDER BY CAST(' . $sortby . ' AS ' . $obj['sorttype'] . ') ' . $obj['sortorder'];
        }

        $offset = 0;
        $limit = 100000;
        if ($obj['limit'] > 0) {
            $limit = (int) $obj['limit'];
            $offset = (int) $obj['offset'];
        }

        $this->_rs = $db->SelectLimit($query, $limit, $offset, $qparms);
        if (!$this->_rs)
            throw new Exception('INTERNAL ERROR: Query failed - ' . $db->sql . ' -- ' . $db->ErrorMsg());
        $this->_totalmatching = $db->GetOne('SELECT FOUND_ROWS()');

        $this->_preload();
    }

// _query

    private function _preload_categories($product_ids) {
        if (!is_array($product_ids) || count($product_ids) == 0)
            return;

        $db = cmsms()->GetDb();
        $query = 'SELECT product_id,category_id FROM ' . CMS_DB_PREFIX . 'module_products_product_categories
              WHERE product_id IN (' . implode(',', $product_ids) . ') ORDER BY product_id ASC';
        $dbr = $db->GetArray($query);
        if (!is_array($dbr) || count($dbr) == 0)
            return;

        $this->_category_cache = $dbr;
    }

    private function _preload_hierarchies($product_ids) {
        if (!is_array($product_ids) || count($product_ids) == 0)
            return;
        $db = cmsms()->GetDb();

        $sql = 'SELECT product_id, hierarchy_id FROM ' . CMS_DB_PREFIX . 'module_products_prodtohier
                WHERE product_id IN (' . implode(',', $product_ids) . ') ORDER BY product_id ASC, hierarchy_id';
        $dbr = $db->GetArray($sql);
        if (!is_array($dbr) || count($dbr) == 0)
            return;

        $this->_hierarchy_cache = $dbr;
    }

    private function _preload_fields($product_ids) {
        if (!is_array($product_ids) || count($product_ids) == 0)
            return;

        $db = cmsms()->GetDb();
        $query = 'SELECT product_id,fielddef_id,value FROM ' . CMS_DB_PREFIX . 'module_products_fieldvals
              WHERE fielddef_id > 0 && product_id IN (' . implode(',', $product_ids) . ') ORDER BY product_id ASC';
        $dbr = $db->GetArray($query);
        if (!is_array($dbr) || count($dbr) == 0)
            return;

        $this->_field_cache = $dbr;
    }

    private function _preload_attributes($product_ids) {
        if (!is_array($product_ids) || count($product_ids) == 0)
            return;

        $db = cmsms()->GetDb();
        $query = 'SELECT * FROM ' . CMS_DB_PREFIX . 'module_products_attribs
              WHERE product_id IN (' . implode(',', $product_ids) . ') ORDER BY product_id ASC, iorder ASC';
        $attribs = $db->GetArray($query);
        if (!is_array($attribs) || count($attribs) == 0)
            return;

        $this->_attribute_cache = array();
        for ($i = 0; $i < count($attribs); $i++) {
            $oneset = & $attribs[$i];
            $pid = $oneset['product_id'];
            if (!isset($this->_attribute_cache[$pid]))
                $this->_attribute_cache[$pid] = array();
            $this->_attribute_cache[$pid][] = $oneset;
        }
    }

    private function _preload_timelines($product_ids) {
        if (!is_array($product_ids) || count($product_ids) == 0)
            return;

        $db = cmsms()->GetDb();
        $query = 'SELECT * FROM ' . CMS_DB_PREFIX . 'module_products_timelines
              WHERE product_id IN (' . implode(',', $product_ids) . ') ORDER BY product_id ASC, iorder ASC';
        $timelines = $db->GetArray($query);
        if (!is_array($timelines) || count($timelines) == 0)
            return;

        $this->_timelines_cache = array();
        for ($i = 0; $i < count($timelines); $i++) {
            $oneset = & $timelines[$i];
            $pid = $oneset['product_id'];
            if (!isset($this->_timelines_cache[$pid]))
                $this->_timelines_cache[$pid] = array();
            $this->_timelines_cache[$pid][] = $oneset;
        }
    }

    private function _preload_highlights($product_ids) {
        if (!is_array($product_ids) || count($product_ids) == 0)
            return;
        $db = cmsms()->GetDb();
        $query = 'SELECT * FROM ' . CMS_DB_PREFIX . 'module_products_highlights
              WHERE product_id IN (' . implode(',', $product_ids) . ') ORDER BY product_id ASC, iorder ASC';
        $highlights = $db->GetArray($query);
        if (!is_array($highlights) || count($highlights) == 0)
            return;

        $this->_highlights_cache = array();
        for ($i = 0; $i < count($highlights); $i++) {
            $oneset = & $highlights[$i];
            $pid = $oneset['product_id'];
            if (!isset($this->_highlights_cache[$pid]))
                $this->_highlights_cache[$pid] = array();
            $this->_highlights_cache[$pid][] = $oneset;
        }
    }

    private function _preload() {
        if (!$this->_rs)
            return;

        $product_ids = array();
        $this->_rs->MoveFirst();
        while (!$this->_rs->EOF) {
            $product_ids[] = $this->_rs->fields['id'];
            $this->_rs->MoveNext();
        }
        $this->_rs->MoveFirst();

        if (!count($product_ids))
            return;
        $product_ids = array_unique($product_ids);

        // preload category info for proudct(s).
        $allcats = product_utils::get_categories(TRUE);
        if (is_array($allcats) && count($allcats))
            $this->_preload_categories($product_ids);

        $this->_preload_hierarchies($product_ids);

        // preload field info
        $allfields = product_utils::get_fielddefs(TRUE, TRUE);
        if (is_array($allfields) && count($allfields))
            $this->_preload_fields($product_ids);

        // preload attributes
        $this->_preload_attributes($product_ids);

        // preload timelines
        $this->_preload_timelines($product_ids);

        // preload highlights
        $this->_preload_highlights($product_ids);
    }

    public function RecordCount() {
        $this->_query();
        if ($this->_rs)
            return $this->_rs->RecordCount();
    }

    public function MoveNext() {
        $this->_query();
        if ($this->_rs)
            return $this->_rs->MoveNext();
        return FALSE;
    }

    public function MoveFirst() {
        $this->_query();
        if ($this->_rs)
            return $this->_rs->MoveFirst();
        return FALSE;
    }

    public function Rewind() {
        $this->_query();
        return $this->MoveFirst();
    }

    public function MoveLast() {
        $this->_query();
        if ($this->_rs)
            return $this->_rs->MoveLast();
        return FALSE;
    }

    public function EOF() {
        $this->_query();
        if ($this->_rs)
            return $this->_rs->EOF();
        return TRUE;
    }

    public function Close() {
        $this->_query();
        if ($this->_rs)
            return $this->_rs->Close();
        return TRUE;
    }

    public function __get($key) {
        $mod = cms_utils::get_module('Products');

        if ($key == 'detailpage') {
            $detailpage = null;
            if ($this->_detailpage)
                $detailpage = $mod->resolve_alias_or_id($detailpage);
            if ($detailpage)
                return $detailpage;
            $dfltreturnid = $mod->GetPreference('detailpage', -1);
            if ($dfltreturnid > 0)
                return $dfltreturnid;
            if ($this->_curpage)
                return $this->_curpage;
            return \ContentOperations::get_instance()->GetDefaultContent();
        }
        if ($key == 'detailtemplate')
            return $this->_detailtemplate;
        if ($key == 'hierpage') {
            if ($this->_hierpage)
                return $this->_hierpage;
            $dfltreturnid = $mod->GetPreference('hierpage', -1);
            if ($dfltreturnid > 0)
                return $dfltreturnid;
            if ($this->_curpage)
                return $this->_curpage;
            return \ContentOperations::get_instance()->GetDefaultContent();
        }
        if ($key == 'curpage')
            return $this->_curpage;
        if ($key == 'notpretty')
            return $this->_notpretty;

        $this->_query();
        if ($key == 'EOF')
            return $this->_rs->EOF();
        if ($key == 'totalrows')
            return $this->_totalmatching;
        if ($key == 'fields' && $this->_rs && !$this->_rs->EOF())
            return $this->_rs->fields;
        if ($key == 'numpages')
            return ceil($this->_totalmatching / $this->_filter['pagelimit']);
    }

    public function __set($key, $value) {
        $mod = cms_utils::get_module('Products');
        switch ($key) {
            case 'detailpage':
                $tmp = $mod->resolve_alias_or_id($value);
                if ($tmp)
                    $this->_detailpage = $tmp;
                break;
            case 'hierpage':
                $tmp = $mod->resolve_alias_or_id($value);
                if ($tmp)
                    $this->_hierpage = $value;
                break;
            case 'curpage':
                $tmp = $mod->resolve_alias_or_id($value);
                if ($tmp)
                    $this->_curpage = $value;
                break;
            case 'notpretty':
                $this->_notpretty = trim($value);
                break;
            case 'detailtemplate':
                $this->_detailtemplate = $value;
                if ($this->_notpretty == '')
                    $this->_notpretty = 'details';
                break;

            default:
                throw new Exception('Cannot set ' . $key . ' into this object');
        }
    }

    public function &get_object() {
        $obj = $this->get_product();
        return $obj;
    }

    // return the full product (with fields, and attributes)
    public function get_product($as_array = FALSE) {
        $ret = null;
        if (!$this->_rs)
            return $ret;

        $product_arr = $this->_rs->fields;
        $product_arr['extra'] = unserialize($product_arr['extra']);

        $product_id = (int) $product_arr['id'];

        // categories
        if (is_array($this->_category_cache) && count($this->_category_cache)) {
            $catarray = [];
            for ($i = 0; $i < count($this->_category_cache); $i++) {
                if ($this->_category_cache[$i]['product_id'] < $product_id)
                    continue;
                if ($this->_category_cache[$i]['product_id'] > $product_id)
                    break;

                $catarray[] = (int) $this->_category_cache[$i]['category_id'];
            }
            $product_arr['categories'] = $catarray;
        }

        // hierarchy cache
        if (is_array($this->_hierarchy_cache) && count($this->_hierarchy_cache)) {
            $out = [];
            for ($i = 0; $i < count($this->_hierarchy_cache); $i++) {
                if ($this->_hierarchy_cache[$i]['product_id'] < $product_id)
                    continue;
                if ($this->_hierarchy_cache[$i]['product_id'] > $product_id)
                    break;
                $out[] = (int) $this->_hierarchy_cache[$i]['hierarchy_id'];
            }
            $product_arr['hierarchies'] = $out;
        }

        // fields
        if (is_array($this->_field_cache) && count($this->_field_cache)) {
            $flddefs = product_utils::get_fielddefs(FALSE, TRUE);
            $unserialize = [];
            foreach ($flddefs as $onedef) {
                if ($onedef->type == 'dimensions' || $onedef->type == 'subscription')
                    $unserialize[] = $onedef->id;
            }

            $fldarray = [];
            for ($i = 0; $i < count($this->_field_cache); $i++) {
                $row = $this->_field_cache[$i];
                if ($row['product_id'] < $product_id)
                    continue;
                if ($row['product_id'] > $product_id)
                    break;

                $value = $row['value'];
                if (in_array((int) $row['fielddef_id'], $unserialize)) {
                    $value = unserialize($value);
                }
                $fldarray[$row['fielddef_id']] = $value;
            }
            $product_arr['field_vals'] = $fldarray;
        }

        // attributes/options
        if (is_array($this->_attribute_cache) && isset($this->_attribute_cache[$product_id]) &&
                is_array($this->_attribute_cache[$product_id]) &&
                count($this->_attribute_cache[$product_id])) {
            $product_arr['attribs'] = $this->_attribute_cache[$product_id];
        }

        // timelines
        if (is_array($this->_timelines_cache) && isset($this->_timelines_cache[$product_id]) &&
                is_array($this->_timelines_cache[$product_id]) &&
                count($this->_timelines_cache[$product_id])) {
            $product_arr['timelines'] = $this->_timelines_cache[$product_id];
        }

        // highlights
        if (is_array($this->_highlights_cache) && isset($this->_highlights_cache[$product_id]) &&
                is_array($this->_highlights_cache[$product_id]) &&
                count($this->_highlights_cache[$product_id])) {
            $product_arr['highlights'] = $this->_highlights_cache[$product_id];
        }
        
        $product_arr['lp'] = "Lee Peace";

        if ($as_array)
            return $product_arr;
        $mod = cms_utils::get_module('Products');
        $obj = new \Products\Product;
        $obj->from_array($product_arr);
        $mod->GetProductStorage()->add_to_cache($obj);
        return $obj;
    }

    public function get_product_for_display() {
        $ret = null;
        if (!$this->_rs)
            return $ret;

        $product = $this->get_product();
        $arr = ['detailpage' => $this->detailpage];
        $arr['detailtemplate'] = $this->detailtemplate;
        $arr['curpage'] = $this->curpage; // absolutely required.
        $arr['notpretty'] = $this->notpretty;
        $arr['hierpage'] = $this->hierpage;
        $obj = new \Products\DisplayableProduct($product, $arr);
        return $obj;
    }

// function
}

// end of class

#
# EOF
#
