<?php

namespace Products;

class ProductTimelines {

    private $_data = [ 'id' => null, 'product_id' => null, 'title' => null, 'description' => null, 'iorder' => null];

    public function __get($key) {
        switch ($key) {
            case 'id':
            case 'product_id':
            case 'title':
            case 'description':
                return trim($this->_data[$key]);
            case 'iorder':
                return (int) $this->_data[$key];
            default:
                throw new \LogicException("$key is not a gettable member of " . __CLASS__);
        }
    }

    /**
     * @ignore
     */
    public function from_array(array $input) {
        foreach ($input as $key => $val) {
            switch ($key) {
                case 'id':
                case 'product_id':
                case 'title':
                case 'description':
                    $this->_data[$key] = trim($val);
                    break;
                case 'iorder':
                    $this->_data[$key] = (int) $val;
                    break;
            }
        }
    }

    public function to_array() {
        return $this->_data;
    }

    public function set_product_id($val) {
        if (!is_null($val)) {
            $val = (int) $val;
            if ($val < 1)
                throw new \LogicException('Invalid product_id provided to ' . __METHOD__);
        }
        $this->_data['product_id'] = $val;
    }

    public function set_title($val) {
        $val = trim($val);
        if (!$val)
            throw new \LogicException('Invalid value provided to ' . __METHOD__);
        $this->_data['title'] = $val;
    }

    public function set_description($val) {
        $val = trim($val);
        if (!$val)
            throw new \LogicException('Invalid value provided to ' . __METHOD__);
        $this->_data['description'] = $val;
    }

}
