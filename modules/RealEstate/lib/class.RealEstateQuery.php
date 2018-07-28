<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class RealEstateQuery extends CmsDbQueryBase {

    public function execute() {
        if (!is_null($this->_rs))
            return;
        $sql = 'SELECT SQL_CALC_FOUND_ROWS H.*
                FROM ' . CMS_DB_PREFIX . 'houzez_realestate H ORDER BY real_id ASC';
        $db = \cms_utils::get_db();
        $this->_rs = $db->SelectLimit($sql, $this->_limit, $this->_offset);
        IF ($db->ErrorMsg())
            throw new \CmsSQLErrorException($db->sql . ' -- ' . $db->ErrorMsg());
        $this->_totalmatchingrows = $db->GetOne('SELECT FOUND_ROWS()');
    }

    public function &GetObject() {
        $obj = new RealEstateItem;
        $obj->fill_from_array($this->fields);
        return $obj;
    }

}
