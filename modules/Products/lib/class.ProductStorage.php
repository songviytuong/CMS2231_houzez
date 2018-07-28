<?php

namespace Products;

class ProductStorage {

    private static $_inst = 0; // this is a singleton.
    private static $_cache = [];
    private $_mod;
    private $_db;

    public function __construct(\Products $mod, $db) {
        if (self::$_inst > 0)
            throw new \LogicException('Only one instance of ' . __CLASS__ . ' is allowed');
        self::$_inst++;
        $this->_mod = $mod;
        $this->_db = $db;
    }

    protected function db_datestring($ts = null) {
        if (is_null($ts))
            $ts = time();
        return trim($this->_db->DbTimeStamp($ts), "'");
    }

    private function _insert_custom_fields($product_id, $product_arr) {
        if (isset($product_arr['field_vals']) && count($product_arr['field_vals'])) {
            $db = $this->_db;
            $defs = \product_utils::get_fielddefs(TRUE);
            $sql = 'INSERT INTO ' . self::product_fieldvals_table_name() . ' (product_id, fielddef_id, value, create_date, modified_date) VALUES (?,?,?,?,?)';
            foreach ($product_arr['field_vals'] as $fielddef_id => $val) {
                if ($defs[$fielddef_id]->type == 'dimensions' || $defs[$fielddef_id]->type == 'subscription' && (is_array($val) || is_object($val))) {
                    $val = serialize($val);
                }
                $db->Execute($sql, [ $product_id, $fielddef_id, $val, $this->db_datestring(), $this->db_datestring()]);
            }
        }
    }

    private function _insert_hierarchy_records($product_id, $product_arr) {
        if (isset($product_arr['hierarchies']) && count($product_arr['hierarchies'])) {
            $db = $this->_db;
            $sql = 'INSERT INTO ' . self::product_hierarchies_table_name() . ' (product_id,hierarchy_id) VALUES (?,?)';
            foreach ($product_arr['hierarchies'] as $hier_id) {
                $db->Execute($sql, [ $product_id, $hier_id]);
            }
        }
    }

    private function _insert_category_records($product_id, $product_arr) {
        if (isset($product_arr['categories']) && count($product_arr['categories'])) {
            $db = $this->_db;
            $sql = 'INSERT INTO ' . self::product_categories_table_name() . ' (product_id, category_id, create_date, modified_date) VALUES (?,?,?,?)';
            foreach ($product_arr['categories'] as $cat_id) {
                $db->Execute($sql, [ $product_id, $cat_id, $this->db_datestring(), $this->db_datestring()]);
            }
        }
    }

    private function _insert_attrib_records($product_id, $product_arr) {
        // always insert in the order we  found them.. regardless of any iorder field.
        if (isset($product_arr['attribs']) && count($product_arr['attribs'])) {
            $db = $this->_db;
            $iorder = 1;
            $sql = 'INSERT INTO ' . self::product_attribs_table_name() . ' (product_id, text, adjustment, sku, qoh, notes, iorder) VALUES (?,?,?,?,?,?,?)';
            foreach ($product_arr['attribs'] as $rec) {
                $db->Execute($sql, [ $product_id, $rec['text'], $rec['adjustment'], $rec['sku'], $rec['qoh'], $rec['notes'], $iorder++]);
            }
        }
    }

    private function _insert_timelines_records($product_id, $product_arr) {
        // always insert in the order we  found them.. regardless of any iorder field.
        if (isset($product_arr['timelines']) && count($product_arr['timelines'])) {
            $db = $this->_db;
            $iorder = 1;
            $sql = 'INSERT INTO ' . self::product_timelines_table_name() . ' (product_id, title, description, iorder) VALUES (?,?,?,?)';
            foreach ($product_arr['timelines'] as $rec) {
                $db->Execute($sql, [ $product_id, $rec['title'], $rec['description'], $iorder++]);
            }
        }
    }

    private function _insert_highlights_records($product_id, $product_arr) {
        // always insert in the order we  found them.. regardless of any iorder field.
        if (isset($product_arr['highlights']) && count($product_arr['highlights'])) {
            $db = $this->_db;
            $iorder = 1;
            $sql = 'INSERT INTO ' . self::product_highlights_table_name() . ' (product_id, highlight, iorder) VALUES (?,?,?)';
            foreach ($product_arr['highlights'] as $rec) {
                $db->Execute($sql, [ $product_id, $rec['highlight'], $iorder++]);
            }
        }
    }

    private function _insert_product(Product $product) {
        $arr = $product->to_array();
        $db = $this->_db;

        // insert the product itself.
        $adjust_parms = [ 'id' => null, 'create_date' => $this->db_datestring(), 'modified_date' => $this->db_datestring()];
        $sql = 'INSERT INTO ' . self::product_table_name() . ' (product_name, price, details, taxable, digital, status, weight, sku, alias, url, owner, extra,
                   create_date, modified_date)
                VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)';
        $i_arr = [ $product->name, $product->price, $product->details, $product->taxable, $product->digital, $product->status, $product->weight, $product->sku,
            $product->alias, $product->url, $product->owner, serialize($arr['extra']),
            $adjust_parms['create_date'], $adjust_parms['modified_date']];
        $dbr = $db->Execute($sql, $i_arr);
        if (!$dbr)
            throw new \cg_sql_error('SYSTEM ERROR: Problem inserting product: ' . $db->ErrorMsg());
        $new_id = $adjust_parms['id'] = $db->Insert_ID();
        $product->from_array($adjust_parms);

        // insert ancillary data.
        $this->_insert_custom_fields($new_id, $arr);
        $this->_insert_hierarchy_records($new_id, $arr);
        $this->_insert_category_records($new_id, $arr);
        $this->_insert_attrib_records($new_id, $arr);
        $this->_insert_timelines_records($new_id, $arr);
        $this->_insert_highlights_records($new_id, $arr);

        \CMSMS\HookManager::do_hook('Products::AfterInsertProduct', $product);
        return $product;
    }

    private function _delete_connected_data($product_id, $delete_files = false) {
        $product_id = (int) $product_id;
        if ($product_id < 1)
            throw new \LogicException('Invalid product_id passed to ' . __METHOD__);

        if ($delete_files) {
            $dir = \product_utils::get_product_upload_path($product_id);
            \cge_dir::recursive_remove_directory($dir);
        }

        $db = $this->_db;
        $sql = 'DELETE FROM ' . self::product_categories_table_name() . ' WHERE product_id = ?';
        $db->Execute($sql, [ $product_id]);
        $sql = 'DELETE FROM ' . self::product_hierarchies_table_name() . ' WHERE product_id = ?';
        $db->Execute($sql, [ $product_id]);
        $sql = 'DELETE FROM ' . self::product_fieldvals_table_name() . ' WHERE product_id = ?';
        $db->Execute($sql, [ $product_id]);
        $sql = 'DELETE FROM ' . self::product_attribs_table_name() . ' WHERE product_id = ?';
        $db->Execute($sql, [ $product_id]);
        $sql = 'DELETE FROM ' . self::product_timelines_table_name() . ' WHERE product_id = ?';
        $db->Execute($sql, [ $product_id]);
    }

    private function _update_product(Product $product) {
        $db = $this->_db;

        \CMSMS\HookManager::do_hook('Products::BeforeUpdateProduct', $product);
        $arr = $product->to_array();

        $sql = 'UPDATE ' . self::product_table_name() . ' SET product_name = ?, price = ?, details = ?, taxable = ?, digital = ?, status = ?, weight = ?,
                sku = ?, alias = ?, url = ?, owner = ?, extra = ?, modified_date = ? WHERE id = ?';
        $adj_parms = [ 'modified_date' => $this->db_datestring()];
        $db->Execute($sql, [ $product->name, $product->price, $product->details, $product->taxable, $product->digital, $product->status, $product->weight,
            $product->sku, $product->alias, $product->url, $product->owner, serialize($arr['extra']),
            $adj_parms['modified_date'], $product->id]);

        $this->_delete_connected_data($product->id);
        $this->_insert_custom_fields($product->id, $arr);
        $this->_insert_hierarchy_records($product->id, $arr);
        $this->_insert_category_records($product->id, $arr);
        $this->_insert_attrib_records($product->id, $arr);
        $this->_insert_timelines_records($product->id, $arr);
        $this->_insert_highlights_records($product->id, $arr);
        \CMSMS\HookManager::do_hook('Products::AfterUpdateProduct', $product);
    }

    protected function check_product_name(Product $product) {
        $product_name = trim($product->name);
        if (!$product_name)
            throw new \RuntimeException($this->_mod->Lang('error_product_namerequired'));

        $sql = 'SELECT id FROM ' . self::product_table_name() . ' WHERE product_name = ?';
        $parms = [ $product_name];
        if ($product->id > 0) {
            $sql .= ' AND id != ?';
            $parms[] = $product->id;
        }
        $t_id = (int) $this->_db->GetOne($sql, $parms);
        if ($t_id > 0)
            throw new \RuntimeException($this->_mod->Lang('error_product_nameused'));
        return $product;
    }

    public function check_product_alias(Product $product) {
        $alias = trim($product->alias);
        if (!$alias) {
            $alias = \product_ops::generate_alias($product->name);
        } else {
            $alias = munge_string_to_url($alias);
        }
        if (\product_ops::check_alias_used($alias, $product->id))
            throw new \RuntimeException($this->_mod->Lang('error_product_aliasused'));
        $product->set_alias($alias);
        return $product;
    }

    public function check_sku(Product $product) {
        if (empty($product->sku) && $this->_mod->GetPreference('skurequired'))
            throw new \RuntimeException($this->_mod->Lang('error_product_skurequired'));
        if (!empty($product->sku)) {
            if (\product_ops::check_sku_used($product->sku, $product->id))
                throw new \RuntimeException($this->_mod->Lang('error_product_skuused'));
        }
        return $product;
    }

    public function check_urlslug(Product $product) {
        $urlslug = $product->url;
        if ($urlslug) {
            $urlslug = trim(trim($urlslug, '/'));

            $tr = munge_string_to_url($urlslug, false, true);
            if (strtolower($tr) != strtolower($urlslug))
                throw new \RuntimeException($this->_mod->Lang('error_product_invalidurlslug'));

            // make sure this url isn't taken
            $url = trim($urlslug, " /\t\r\n\0\x08");
            \cms_route_manager::load_routes();
            $route = \cms_route_manager::find_match($urlslug);
            if ($route && isset($route->defaults['productid']) && $route->defaults['productid'] != $product->id) {
                // we're adding an article, not editing... any matching route is bad.
                throw new \RuntimeException($this->_mod->Lang('error_product_urlslugused'));
            }
        }
        return $product;
    }

    public function check_attribs(Product $product) {
        $attribs = $product->attribs;
        if (!is_array($attribs) || !count($attribs))
            return $product;
        //if( count($attribs) < 2 ) throw new \RuntimeException($this->_mod->Lang('error_attrib_count'));
        // trivial check for duplicated name or sku
        $names = $skus = [];
        foreach ($attribs as $attrib) {
            $text = trim($attrib->text);
            $sku = trim($attrib->sku);
            if ($text && !in_array($text, $names))
                $names[] = $text;
            if ($sku && in_array($sku, $skus))
                throw new \RuntimeException($this->_mod->Lang('error_attrib_duplicatesku'));
            $skus[] = $sku;
        }
        if (count($names) < count($attribs))
            throw new \RuntimeException($this->_mod->Lang('error_attrib_text'));

        foreach ($attribs as $attrib) {
            if (empty($product->sku)) {
                if ($this->_mod->GetPreference('skurequired'))
                    throw new \RuntimeException($mod->Lang('error_attrib_skurequired'));
            }
            else {
                if (\product_ops::check_sku_used($attrib->sku, $product->id))
                    throw new \RuntimeException($this->_mod->Lang('error_attrib_skuused'));
            }
        }
        return $product;
    }

    public function check_timelines(Product $product) {
        return $product;
    }

    protected function check_fields(Product $product) {
        $get_fielddef = function( $fid, array $fielddefs ) {
            foreach ($fielddefs as $one) {
                if ($one->id == $fid)
                    return $one;
            }
        };

        $fielddefs = \product_utils::get_fielddefs(TRUE, TRUE, FALSE);
        if (!count($fielddefs) && count($product->field_vals))
            throw new \LogicException('No fielddefs defined, but have field values in this product');

        foreach ($product->field_vals as $fid => $val) {
            if (!$get_fielddef($fid, $fielddefs)) {
                throw new \LogicException("Fielddef with id $fid exists in product but is not defined");
            }
            // todo: check field value.
        }
        return $product;
    }

    public function validate(Product $product) {
        if (!$product->name)
            throw new \RuntimeException($this->_mod->Lang('error_product_nameused'));
        $product = $this->check_product_name($product);
        $product = $this->check_product_alias($product);
        $product = $this->check_sku($product);
        $product = $this->check_urlslug($product);
        $product = $this->check_fields($product);
        $product = $this->check_attribs($product);
//        $product = $this->check_timelines($product);
    }

    public function save(Product $product) {
        $this->validate($product);
        if ($product->id > 0) {
            return $this->_update_product($product);
        } else {
            return $this->_insert_product($product);
        }
    }

    private function _build_from_row(array $row) {
        if (!isset($row['id']) || $row['id'] < 1 || !isset($row['product_name']) || !$row['product_name'])
            return;

        $db = $this->_db;
        $product_id = (int) $row['id'];
        $row['name'] = $row['product_name'];
        unset($row['product_name']);
        if ($row['extra'])
            $row['extra'] = unserialize($row['extra']);

        // get categories
        $sql = 'SELECT category_id FROM ' . self::product_categories_table_name() . ' WHERE product_id = ? ORDER BY category_id';
        $row['categories'] = [];
        $cats = $db->GetCol($sql, [ $product_id]);
        if (is_array($cats))
            $row['categories'] = $cats;

        // get hierarchies
        $sql = 'SELECT hierarchy_id FROM ' . self::product_hierarchies_table_name() . ' WHERE product_id = ? ORDER BY hierarchy_id';
        $row['hierarchies'] = [];
        $hiers = $db->GetCol($sql, [ $product_id]);
        if (is_array($hiers))
            $row['hierarchies'] = $hiers;

        // get field values
        $sql = 'SELECT fielddef_id, value FROM ' . self::product_fieldvals_table_name() . ' WHERE product_id = ? ORDER BY fielddef_id';
        $fv = $db->GetArray($sql, [ $product_id]);
        $row['fieldvals'] = [];
        if (is_array($fv)) {
            $defs = \product_utils::get_fielddefs(TRUE);
            foreach ($fv as $one) {
                $fid = $one['fielddef_id'];
                if ($fid < 1)
                    continue;
                if ($defs[$fid]->type == 'subscription' || $defs[$fid]->type == 'dimensions')
                    $one['value'] = unserialize($one['value']);
                $row['field_vals'][$one['fielddef_id']] = $one['value'];
            }
        }

        // get attributes
        $sql = 'SELECT * FROM ' . self::product_attribs_table_name() . ' WHERE product_id = ? ORDER BY IORDER ASC';
        $tmp = $db->GetArray($sql, [ $product_id]);
        $row['attribs'] = [];
        if (is_array($tmp))
            $row['attribs'] = $tmp;

        // get timelines
        $sql = 'SELECT * FROM ' . self::product_timelines_table_name() . ' WHERE product_id = ? ORDER BY IORDER ASC';
        $tmp = $db->GetArray($sql, [ $product_id]);
        $row['timelines'] = [];
        if (is_array($tmp))
            $row['timelines'] = $tmp;

        // get highlights
        $sql = 'SELECT * FROM ' . self::product_highlights_table_name() . ' WHERE product_id = ? ORDER BY IORDER ASC';
        $tmp = $db->GetArray($sql, [ $product_id]);
        $row['highlights'] = [];
        if (is_array($tmp))
            $row['highlights'] = $tmp;

        $obj = new Product;
        $obj->from_array($row);
        return $obj;
    }

    protected function raw_load_by_id($product_id) {
        $product_id = (int) $product_id;
        if ($product_id < 1)
            throw new \LogicException('Invalid product_id passed to ' . __METHOD__);

        $db = $this->_db;
        $sql = 'SELECT * FROM ' . self::product_table_name() . ' WHERE id = ?';
        $row = $db->GetRow($sql, [ $product_id]);
        if (!$row)
            return;
        return $this->_build_from_row($row);
    }

    protected function raw_load_by_name($name) {
        $name = trim($name);
        if (!$name)
            throw new \LogicException('Invalid product name passed to ' . __METHOD__);

        $db = $this->_db;
        $sql = 'SELECT * FROM ' . self::product_table_name() . ' WHERE product_name = ?';
        $row = $db->GetRow($sql, [ $name]);
        if (!$row)
            return;
        return $this->_build_from_row($row);
    }

    public function add_to_cache(Product $product) {
        if (!$product->id)
            return;
        if (!isset(self::$_cache[$product->id]))
            self::$_cache[$product->id] = $product;
    }

    public function get_by_id($product_id, $displayable = false) {
        $product_id = (int) $product_id;
        if ($product_id < 1)
            throw new \LogicException('Invalid product_id passed to ' . __METHOD__);

        $res = null;
        if (isset(self::$_cache[$product_id])) {
            $res = self::$_cache[$product_id];
        } else {
            $res = $this->raw_load_by_id($product_id);
            if ($res)
                $this->add_to_cache($res);
        }
        if ($res && $displayable)
            $res = new DisplayableProduct($res);
        return $res;
    }

    public function get_by_name($name, $displayable = false) {
        $name = trim($name);
        if (!$name)
            throw new \LogicException('Invalid product name passed to ' . __METHOD__);

        $res = null;
        foreach (self::$_cache as $product_id => $obj) {
            if ($obj->name == $name) {
                $res = $obj;
                break;
            }
        }
        if (!$res) {
            $res = $this->raw_load_by_name($name);
            if ($res)
                $this->add_to_cache($res);
        } else if ($displayable) {
            $res = new DisplayableProduct($res);
        }
        return $res;
    }

    public function get_by_any_sku($sku, $displayable = false) {
        $sku = trim($sku);
        if (!$sku)
            throw new \LogicException('Invalid sku passed to ' . __METHOD__);

        $sql = 'SELECT id FROM ' . self::product_table_name() . ' WHERE sku = ?';
        $pid = (int) $this->_db->GetOne($sql, [ $sku]);
        if ($pid)
            return self::get_by_id($pid, $displayable);

        $sql = 'SELECT product_id FROM ' . self::product_attribs_table_name() . ' WHERE sku = ?';
        $pid = (int) $this->_db->GetOne($sql, [ $sku]);
        if ($pid)
            return self::get_by_id($pid, $displayable);
    }

    public function delete_by_id($product_id) {
        \CMSMS\HookManager::do_hook('Products::BeforeDeleteProduct', $product_id);

        $product_id = (int) $product_id;
        if ($product_id < 1)
            throw new \LogicException('Invalid product_id passed to ' . __METHOD__);

        if (isset(self::$_cache[$product_id]))
            unset(self::$_cache[$product_id]);
        $db = $this->_db;

        //And remove it from any custom fields
        $query = "DELETE FROM " . cms_db_prefix() . "module_products_fieldvals WHERE product_id = ?";
        $db->Execute($query, [ $product_id]);

        //And remove it from any categories
        $query = "DELETE FROM " . cms_db_prefix() . "module_products_product_categories WHERE product_id = ?";
        $db->Execute($query, [ $product_id]);

        // and remove the hierarchy stuff
        $query = 'DELETE FROM ' . cms_db_prefix() . 'module_products_prodtohier WHERE product_id = ?';
        $db->Execute($query, [ $product_id]);

        // and remove the attribs stuff
        $query = 'DELETE FROM ' . cms_db_prefix() . 'module_products_attribs WHERE product_id = ?';
        $db->Execute($query, [ $product_id]);

        // and remove the attribs stuff
        $query = 'DELETE FROM ' . cms_db_prefix() . 'module_products_timelines WHERE product_id = ?';
        $db->Execute($query, [ $product_id]);

        // and the product itself.
        $query = "DELETE FROM " . cms_db_prefix() . "module_products WHERE id = ?";
        $db->Execute($query, [ $product_id]);

        // and (optionally) remove all files
        if ($this->_mod->GetPreference('deleteproductfiles')) {
            $dir = \product_utils::get_product_upload_path($product_id);
            \cge_dir::recursive_remove_directory($dir);
        }

        \CMSMS\HookManager::do_hook('Products::AfterDeleteProduct', [ 'product_id' => $product_id]);
    }

    public function get_product_owners(array $product_ids) {
        if (!count($product_ids))
            return;

        $query = new \products_query(['productlist' => $product_ids]);
        $rs = $query->execute();
        $out = null;
        while (!$rs->EOF) {
            $row = $rs->fields;
            $owner = (int) $row['owner'];
            if ($owner < 1)
                continue;
            if (!count($out) || !in_array($owner, $out))
                $out[] = $owner;
            $rs->MoveNext();
        }
        return $out;
    }

    public function count_owner_products($uid) {
        $uid = (int) $uid;
        $sql = 'SELECT COUNT id FROM ' . self::table_name() . ' WEHRE owner = ?';
        $cnt = (int) $db->GetOne($sql, [ $uid]);
        return $cnt;
    }

    public static function product_table_name() {
        return CMS_DB_PREFIX . 'module_products';
    }

    public static function product_categories_table_name() {
        return CMS_DB_PREFIX . 'module_products_product_categories';
    }

    public static function product_hierarchies_table_name() {
        return CMS_DB_PREFIX . 'module_products_prodtohier';
    }

    public static function product_fieldvals_table_name() {
        return CMS_DB_PREFIX . 'module_products_fieldvals';
    }

    public static function product_attribs_table_name() {
        return CMS_DB_PREFIX . 'module_products_attribs';
    }

    public static function product_timelines_table_name() {
        return CMS_DB_PREFIX . 'module_products_timelines';
    }

    public static function product_highlights_table_name() {
        return CMS_DB_PREFIX . 'module_products_highlights';
    }

}

// end of class
