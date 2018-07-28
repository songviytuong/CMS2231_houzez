<?php

final class products_highlights implements ArrayAccess {

    private static $_keys = array('id', 'product_id', 'highlight', 'iorder');
    private $_data = array('id' => '', 'product_id' => '', 'highlight' => '', 'iorder' => -1);
    private $_dirty;

    public function __clone() {
        $this->_dirty = TRUE;
        $this->_data['id'] = '';
        $this->_data['iorder'] = -1;
    }

    public function __get($key) {
        // allow access as object too.
        if (!in_array($key, self::$_keys)) {
            throw new CmsException('Invalid key ' . $key . ' specified for products_highlights object');
        }
        if (isset($this->_data[$key]))
            return $this->_data[$key];
    }

    public function offsetGet($key) {
        if (!in_array($key, self::$_keys)) {
            throw new CmsException('Invalid key ' . $key . ' specified for products_highlights object');
        }
        if (isset($this->_data[$key]))
            return $this->_data[$key];
    }

    public function offsetSet($key, $value) {
        if (!in_array($key, self::$_keys)) {
            throw new CmsException('Invalid key ' . $key . ' specified for products_highlights object');
        }

        switch ($key) {
            case 'id':
                throw new CmsException('id cannot be set for the products_highlights object');
                break;

            case 'iorder':
                throw new CmsException('iorder cannot be set for the products_highlights object in this manner');
                break;

            case 'product_id':
                $value = (int) $value;
                if ($value < 1)
                    throw new CmsException('product id cannot be negative or zero for products_highlights object');
                break;

            case 'highlight':
                $value = trim($value);
        }
        $this->_data[$key] = (string) $value;
        $this->_dirty = TRUE;
    }

    public function offsetUnset($key) {
        if (!in_array($key, self::$_keys)) {
            throw new CmsException('Invalid key ' . $key . ' specified for products_highlights object');
        }

        switch ($key) {
            case 'id':
            case 'ioroder':
                throw new CmsException("$key cannot be unset for a " . __CLASS__ . ' object');
            default:
                unset($this->_data[$key]);
                $this->_dirty = TRUE;
                break;
        }
    }

    public function offsetExists($key) {
        if (!in_array($key, self::$_keys)) {
            throw new CmsException('Invalid key ' . $key . ' specified for products_highlights object');
        }

        return TRUE;
    }

    private function _insert() {
        $db = cmsms()->GetDb();

        if ($this->_data['iorder'] < 1) {
            // calculate a new iorder for this product
            $query = 'SELECT MAX(COALESCE(iorder,0))+1 FROM ' . cms_db_prefix() . 'module_products_highlights WHERE product_id = ?';
            $this->_data['iorder'] = $db->GetOne($query, array($this->_data['product_id']));
        }

        $data = $this->_data;
        $query = 'INSERT INTO ' . cms_db_prefix() . 'module_products_highlights
              (product_id,highlight,iorder)
              VALUES (?,?,?)';
        $dbr = $db->Execute($query, array($data['product_id'], $data['highlight'], $data['iorder']));
        if (!$dbr)
            throw new CmsException('SQL ERROR: ' . $db->ErrorMsg() . ' -- ' . $db->sql);

        $this->_data['id'] = $db->Insert_ID();
        $this->_dirty = FALSE;
    }

    private function _update() {
        $data = $this->_data;

        $db = cmsms()->GetDb();
        $query = 'UPDATE ' . cms_db_prefix() . 'module_products_highlights
              SET highlight = ?, iorder = ?,
              WHERE id = ?';
        $dbr = $db->Execute($query, array($data['highlight'], $data['iorder'], $data['id']));
        $this->_dirty = FALSE;
    }

    public function validate() {
        if (!isset($this->_data['product_id']) || $this->_data['product_id'] < 1) {
            throw new CmsException('Each products_highlights object needs a product_id');
        }
        if (!isset($this->_data['highlight']) || $this->_data['highlight'] == '') {
            throw new CmsException('Each products_highlights object needs some text');
        }
    }

    public function save() {
        if (!$this->_dirty)
            return;
        $this->validate();

        if (isset($this->_data['id']) && $this->_data['id'] != '') {
            $this->_update();
        } else {
            $this->_insert();
        }
    }

    protected static function &load_from_data($data) {
        foreach (self::$_keys as $k) {
            if ($k != 'id' && $k != 'iorder' && !in_array($k, array_keys($data))) {
                throw new CmsException($k . ' is missing from loaded highlights record');
            }
        }
        foreach (array_keys($data) as $key) {
            if (!in_array($key, self::$_keys)) {
                throw new CmsException('Unknown or extra data exists in the supploed attrib record');
            }
        }

        $ob = new products_highlights;
        $ob->_data = $data;
        $ob->_dirty = TRUE;
        return $ob;
    }

    public static function load_from_form($params) {
        if (!isset($params['prodid'])) {
            throw new CmsException('Missing product id value from form');
        }

        if (!isset($params['highlight']) && !is_array($params['highlight'])) {
            throw new CmsException('Missing highlight data from form');
        }

        $i = 1;
        foreach ($params['highlight'] as $one) {
            if (!$one) {
                throw new CmsException('Option highlight empty at row ' . $i);
            }
            $i++;
        }

        // put everything together.
        $out = array();
        $keys = array('highlight');
        for ($i = 0; $i < count($params['highlight']); $i++) {
            $rec = array('product_id' => (int) $params['prodid']);
            foreach ($keys as $key) {
                $rec[$key] = $params[$key][$i];
            }
            $obj = self::load_from_data($rec);
            $obj->_data['iorder'] = $i + 1;
            $out[] = $obj;
        }

        return $out;
    }

    public static function load_by_product($id) {
        $db = cmsms()->GetDb();
        $query = 'SELECT * FROM ' . cms_db_prefix() . 'module_products_highlights
                  WHERE product_id = ? ORDER BY iorder';
        $dbr = $db->GetArray($query, array((int) $id));
        if (!is_array($dbr) || count($dbr) == 0)
            return;

        $res = array();
        foreach ($dbr as $one) {
            $res[] = self::load_from_data($one);
        }
        return $res;
    }

    public static function delete_by_product($id) {
        $db = cmsms()->GetDb();
        $query = 'DELETE FROM ' . cms_db_prefix() . 'module_products_highlights
              WHERE product_id = ?';
        $dbr = $db->Execute($query, array((int) $id));
        if (!$dbr)
            return FALSE;
        return TRUE;
    }

}

// end of class
#
# EOF
#
?>