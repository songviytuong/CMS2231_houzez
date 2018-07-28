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

class products_query extends \CGExtensions\query\query {

    private static $_keys = array('productid', 'product_id', 'productlist', 'alias', 'category', 'categoryid', 'excludecat',
        'hierarchy', 'hierarchyid', 'fieldid', 'fieldval', 'sortorder', 'sku', 'optsku',
        'productnamelike', 'isnotnull', 'desclike', 'sortby', 'sorttype', 'limit', 'offset', 'status', 'pricerange', 'useor', 'nochildren',
        'owner');
    private static $_sortings = array('id', 'product_name', 'price', 'create_date', 'modified', 'status', 'weight', 'random');
    private $_data = array();
    private $_origparms = null;
    private $_sortfield = 0;
    private $_field_expressions = array();

    public static function is_key($test) {
        if (in_array($test, self::$_keys))
            return TRUE;
        return FALSE;
    }

    public function __construct($data = array()) {
        if (is_array($data))
            $this->_origparms = $data;
        $this->reset();
    }

    public function reset() {
        $mod = cms_utils::get_module(MOD_PRODUCTS);
        $this->_data['limit'] = $mod->GetPreference('summary_pagelimit', 100);
        $this->_data['sortby'] = $mod->GetPreference('sortby', 'product_name');
        $this->_data['sortorder'] = $mod->GetPreference('sortorder', 'DESC');
        $this->_data['status'] = 'published';
        $this->_data['offset'] = 0;
        $this->_field_expressions = array();

        foreach ($this->_origparms as $key => $value) {
            if (in_array($key, self::$_keys))
                $this[$key] = $value;
        }
    }

    public function offsetGet($key) {
        if ($key == 'pagelimit')
            $key = 'limit';
        if (!in_array($key, self::$_keys))
            throw new Exception('Get: invalid key ' . $key . ' specified for products_query');
        if (isset($this->_data[$key]))
            return $this->_data[$key];
    }

    private function _resetidentifiers() {
        unset($this->_data['productnamelike']);
        unset($this->_data['sku']);
        unset($this->_data['optsku']);
        unset($this->_data['alias']);
        unset($this->_data['productlist']);
        unset($this->_data['product_id']);
    }

    public function offsetSet($key, $value) {
        if ($key == 'pagelimit')
            $key = 'limit';
        if (!in_array($key, self::$_keys))
            throw new Exception('Set: Invalid Key ' . $key . ' specified for products_query');
        if (!$value)
            return;

        $mod = cms_utils::get_module(MOD_PRODUCTS);
        switch ($key) {
            case 'status':
                $value = strtolower($value);
                switch ($value) {
                    case 'draft':
                    case 'disabled':
                    case 'published':
                    case '!draft':
                    case '!disabled':
                    case '!published':
                    case '*':
                        $this->_data['status'] = $value;
                        break;
                }
                break;

            case 'pricerange':
                if (strpos($value, ':') !== FALSE)
                    $this->_data[$key] = $value;
                break;


            case 'useor':
                $this->_data[$key] = cms_to_bool($value);
                break;

            case 'desclike':
                $this->_data[$key] = trim($value);
                break;

            case 'productid':
            case 'product_id':
                $key = 'product_id';
            // fallthrough
            case 'productnamelike':
            case 'optsku':
            case 'alias':
            case 'sku':
                $this->_resetidentifiers();
                $this->_data[$key] = trim($value);
                break;

            case 'productlist':
                $this->_resetidentifiers();
                $tmp = $value;
                if (is_string($value))
                    $tmp = explode(',', $value);
                if (is_array($tmp) && count($tmp)) {
                    $tmp2 = [];
                    foreach ($tmp as $one) {
                        $one = (int) $one;
                        if ($one > 0 && !in_array($one, $tmp2))
                            $tmp2[] = $one;
                    }
                    $value = implode(',', $tmp2);
                    $this->_data[$key] = $value;
                }
                break;

            case 'category':
                $this->_data[$key] = trim($value);
                unset($this->_data['categoryid']);
                break;

            case 'categoryid':
                $this->_data[$key] = (int) $value;
                unset($this->_data['category']);
                break;

            case 'excludecat':
                $this->_data[$key] = trim($value);
                break;

            case 'hierarchy':
                $this->_data[$key] = trim($value);
                unset($this->_data['hierarchyid']);
                break;

            case 'owner':
                $this->_data[$key] = (int) $value;
                break;

            case 'nochildren':
                $this->_data[$key] = cge_utils::to_bool($value);
                break;

            case 'hierarchyid':
                $this->_data[$key] = (int) $value;
                unset($this->_data['hierarchy']);
                break;

            case 'fieldid':
                $this->_data[$key] = (int) $value;
                break;

            case 'fieldval':
                $this->_data[$key] = trim($value);
                break;

            case 'sortorder':
                $value = strtolower(trim($value));
                switch ($value) {
                    case 'asc':
                    case 'desc':
                        $this->_data[$key] = $value;
                        break;
                }
                break;

            case 'sortby':
                $value = strtolower(trim($value));
                switch ($value) {
                    case 'name':
                        $key = 'product_name';
                        $this->_data[$key] = $value;
                        break;

                    case 'id':
                    case 'sku':
                    case 'product_name':
                    case 'price':
                    case 'weight':
                    case 'status':
                    case 'random':
                    case 'create_date':
                    case 'modified_date':
                        $this->_data[$key] = $value;
                        break;

                    case 'modified':
                        $this->_data[$key] = 'modified_date';
                        break;

                    case 'created':
                        $this->_data[$key] = 'create_date';
                        break;

                    default:
                        if (startswith($value, 'f:')) {
                            $fieldname = substr($value, strlen('f:'));
                            $fielddefs = product_utils::get_fielddefs(FALSE, TRUE, TRUE);
                            if (is_array($fielddefs) && isset($fielddefs[$fieldname]))
                                $this->_data[$key] = $value;
                        }
                        else {
                            throw new Exception('Set: invalid sorting ' . $value);
                        }
                }
                break;

            case 'sorttype':
                $value = trim(strtoupper($value));
                switch ($value) {
                    case 'STRING':
                        $this->_data[$key] = '';
                        break;
                    case 'SIGNED':
                    case 'UNSIGNED':
                        $this->_data[$key] = $value;
                        break;
                }
                break;
            case 'isnotnull':
                $this->_data[$key] = $value;
                break;
            case 'limit':
                $value = max(1, (int) $value);
                $this->_data['limit'] = $value;
                break;

            case 'offset':
                $value = max(0, (int) $value);
                $this->_data['offset'] = $value;
                break;
        }
    }

    public function offsetExists($key) {
        if (!in_array($key, self::$_keys))
            throw new Exception('Exists: Invalid Key ' . $key . ' specified for products_query');
        return isset($this->_data[$key]);
    }

    public function offsetUnset($key) {
        if (!in_array($key, self::$_keys))
            throw new Exception('Unset: Invalid Key ' . $key . ' specified for products_query');
        return FALSE;
    }

    public function &execute() {
        $rs = new products_resultset($this);
        return $rs;
    }

    public function add_field_expr($field, $expr) {
        if ($expr) {
            $this->_field_expressions[$field] = $expr;
        } else {
            unset($this->_field_expressions[$field]);
        }
    }

    public function get_field_exprs() {
        return $this->_field_expressions;
    }

}

// end of class
#
# EOF
#
?>
