<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class RealEstateItem {

    private $_data = array(
        'real_id' => null,
        'title' => null,
        'sanitizetitle' => null,
        'lat' => null,
        'lng' => null,
        'bedrooms' => null,
        'bathrooms' => null,
        'address' => null,
        'thumbnail' => null,
        'url' => null,
        'type' => null,
        'price' => null,
        'icon' => null,
    );

    public function __get($key) {
        switch ($key) {
            case 'real_id':
            case 'title':
            case 'sanitizetitle':
            case 'lat':
            case 'lng':
            case 'bedrooms':
            case 'bathrooms':
            case 'address':
            case 'thumbnail':
            case 'url':
            case 'type':
            case 'price':
            case 'icon':
                return $this->_data[$key];
        }
    }

    public function __set($key, $val) {
        switch ($key) {
            case 'title':
            case 'sanitizetitle':
            case 'lat':
            case 'lng':
            case 'address':
            case 'thumbnail':
            case 'url':
            case 'icon':
                $this->_data[$key] = trim($val);
                break;
            case 'bedrooms':
            case 'bathrooms':
            case 'type':
                $this->_data[$key] = (int) $val;
                break;
            case 'price':
                $this->_data[$key] = (double) $val;
                break;
        }
    }

    public function save() {
        if (!$this->is_valid())
            return FALSE;
        if ($this->real_id > 0) {
            $this->update();
        } else {
            $this->insert();
        }
    }

    public function is_valid() {
        if (!$this->title)
            return false;
        return TRUE;
    }

    protected function insert() {
        $db = \cms_utils::get_db();
        $sql = 'INSERT INTO ' . CMS_DB_PREFIX . 'houzez_realestate
                (title)
                VALUES (?)';
        $dbr = $db->Execute($sql, array($this->title));
        if (!$dbr)
            return FALSE;
        $this->_data['real_id'] = $db->Insert_ID();
        return TRUE;
    }

    protected function update() {
        $db = \cms_utils::get_db();
        $sql = 'UPDATE ' . CMS_DB_PREFIX . 'houzez_realestate SET title = ? WHERE real_id = ?';
        $dbr = $db->Execute($sql, array($this->title, $this->real_id));
        if (!$dbr)
            return FALSE;
        return TRUE;
    }

    public function delete() {
        if (!$this->real_id)
            return FALSE;
        $db = \cms_utils::get_db();
        $sql = 'DELETE FROM ' . CMS_DB_PREFIX . 'houzez_realestate WHERE real_id = ?';
        $dbr = $db->Execute($sql, array($this->real_id));
        if (!$dbr)
            return FALSE;
        $this->_data['real_id'] = null;
        return TRUE;
    }

    /** internal */
    public function fill_from_array($row) {
        foreach ($row as $key => $val) {
            if (array_key_exists($key, $this->_data)) {
                $this->_data[$key] = $val;
            }
        }
    }

    public static function &load_by_id($id) {
        $id = (int) $id;
        $db = \cms_utils::get_db();
        $sql = 'SELECT * FROM ' . CMS_DB_PREFIX . 'houzez_realestate WHERE real_id = ?';
        $row = $db->GetRow($sql, array($id));
        if (is_array($row)) {
            $obj = new self();
            $obj->fill_from_array($row);
            return $obj;
        }
    }

}
