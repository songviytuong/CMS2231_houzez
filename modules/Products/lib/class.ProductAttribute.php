<?php
namespace Products;

class ProductAttribute
{
    private $_data = [ 'id'=>null, 'product_id'=>null, 'text'=>null, 'adjustment'=>null, 'sku'=>null, 'qoh'=>null, 'notes'=>null, 'iorder'=>null ];

    public function __get( $key )
    {
        switch( $key ) {
        case 'id':
        case 'product_id':
        case 'qoh':
        case 'iorder':
            return (int) $this->_data[$key];
        case 'text':
        case 'adjustment':
        case 'sku':
        case 'notes':
            return trim($this->_data[$key]);
        default:
            throw new \LogicException("$key is not a gettable member of ".__CLASS__);
        }
    }

    /**
     * @ignore
     */
    public function from_array( array $input )
    {
        foreach( $input as $key => $val ) {
            switch( $key ) {
            case 'id':
            case 'product_id':
            case 'qoh':
            case 'iorder':
                $this->_data[$key] = (int) $val;
                break;
            case 'text':
            case 'adjustment':
            case 'sku':
            case 'notes':
                $this->_data[$key] = trim($val);
                break;
            }
        }
    }

    public function to_array()
    {
        return $this->_data;
    }

    public function set_product_id( $val )
    {
        if( !is_null($val) ) {
            $val = (int) $val;
            if( $val < 1 ) throw new \LogicException('Invalid product_id provided to '.__METHOD__);
        }
        $this->_data['product_id'] = $val;
    }

    public function set_text( $val )
    {
        $val = trim($val);
        if( !$val ) throw new \LogicException('Invalid value provided to '.__METHOD__);
        $this->_data['text'] = $val;
    }

    public function set_adjustment( $val )
    {
        $val = trim($val);
        if( !$val ) throw new \LogicException('Invalid value provided to '.__METHOD__);
        $this->_data['adjustment'] = $val;
    }

    public function set_sku( $val )
    {
        if( !is_null($val) ) $val = trim($val);
        $this->_data['sku'] = $val;
    }

    public function set_qoh( $val )
    {
        $val = (int) $val;
        $this->_data['qoh'] = $val;
    }

    public function set_notes( $val )
    {
        $text = trim($val);
        $this->_data['notes'] = $val;
    }
}