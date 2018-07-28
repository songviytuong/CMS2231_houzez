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

//  THIS CLASS IS DEPRECATED AND SHOULD BE REMOVED
//  Use ProductAttribute class.
final class products_attrib implements ArrayAccess
{
    private static $_keys = array('id','product_id','text','adjustment','sku','qoh','notes','iorder');
    private $_data = array('id'=>'','product_id'=>'','text'=>'','adjustment'=>'','sku'=>'','qoh'=>'','notes'=>'','iorder'=>-1);
    private $_dirty;

    public function __clone()
    {
        $this->_dirty = TRUE;
        $this->_data['id'] = '';
        $this->_data['iorder'] = -1;
    }

    public function __get($key) {
        // allow access as object too.
        if( !in_array($key,self::$_keys) ) {
            throw new CmsException('Invalid key '.$key.' specified for products_attrib object');
        }
        if( isset($this->_data[$key]) ) return $this->_data[$key];
    }

    public function offsetGet($key) {
        if( !in_array($key,self::$_keys) ) {
            throw new CmsException('Invalid key '.$key.' specified for products_attrib object');
        }
        if( isset($this->_data[$key]) ) return $this->_data[$key];
    }

    public function offsetSet($key,$value) {
        if( !in_array($key,self::$_keys) ) {
            throw new CmsException('Invalid key '.$key.' specified for products_attrib object');
        }

        switch( $key ) {
        case 'id':
            throw new CmsException('id cannot be set for the products_attrib object');
            break;

        case 'iorder':
            throw new CmsException('iorder cannot be set for the products_attrib object in this manner');
            break;

        case 'product_id':
            $value = (int)$value;
            if( $value < 1 ) throw new CmsException('product id cannot be negative or zero for products_attrib object');
            break;

        case 'qoh':
            $value = (int)$value;
            if( $value < 0 ) throw new CmsException('QOH cannot be negative for products_attrib object');
            break;

        case 'text':
        case 'adjustment':
        case 'sku':
        case 'notes':
            $value = trim($value);
        }
        $this->_data[$key] = (string)$value;
        $this->_dirty = TRUE;
    }

    public function offsetUnset($key)
    {
        if( !in_array($key,self::$_keys) ) {
            throw new CmsException('Invalid key '.$key.' specified for products_attrib object');
        }

        switch( $key ) {
        case 'id':
        case 'ioroder':
            throw new CmsException("$key cannot be unset for a ".__CLASS__.' object');
        default:
            unset($this->_data[$key]);
            $this->_dirty = TRUE;
            break;
        }
    }

    public function offsetExists($key)
    {
        if( !in_array($key,self::$_keys) ) {
            throw new CmsException('Invalid key '.$key.' specified for products_attrib object');
        }

        return TRUE;
    }

    private function _insert()
    {
        $db = cmsms()->GetDb();

        if( $this->_data['iorder'] < 1 ) {
            // calculate a new iorder for this product
            $query = 'SELECT MAX(COALESCE(iorder,0))+1 FROM '.cms_db_prefix().'module_products_attribs WHERE product_id = ?';
            $this->_data['iorder'] = $db->GetOne($query,array($this->_data['product_id']));
        }

        $data = $this->_data;
        $query = 'INSERT INTO '.cms_db_prefix().'module_products_attribs
              (product_id,text,adjustment,sku,qoh,notes,iorder)
              VALUES (?,?,?,?,?,?,?)';
        $dbr = $db->Execute($query,array($data['product_id'],$data['text'],$data['adjustment'],
                                         $data['sku'],$data['qoh'],$data['notes'],$data['iorder']));
        if( !$dbr ) throw new CmsException('SQL ERROR: '.$db->ErrorMsg().' -- '.$db->sql);

        $this->_data['id'] = $db->Insert_ID();
        $this->_dirty = FALSE;
    }

    private function _update()
    {
        $data = $this->_data;

        $db = cmsms()->GetDb();
        $query = 'UPDATE '.cms_db_prefix().'module_products_attribs
              SET text = ?, adjustment = ?, sku = ?, qoh = ?, notes = ?, iorder = ?,
              WHERE id = ?';
        $dbr = $db->Execute($query,array($data['text'],$data['adjustment'],$data['sku'],
                                         $data['qoh'],$data['notes'],$data['iorder'],$data['id']));
        $this->_dirty = FALSE;
    }

    public function validate()
    {
        if( !isset($this->_data['product_id']) || $this->_data['product_id'] < 1 ) {
            throw new CmsException('Each products_attrib object needs a product_id');
        }
        if( !isset($this->_data['text']) || $this->_data['text'] == '' ) {
            throw new CmsException('Each products_attrib object needs some text');
        }
        if( !isset($this->_data['adjustment']) || $this->_data['adjustment'] == '' ) {
            throw new CmsException('Each products_attrib object needs some adjustment value');
        }
        $mod = cms_utils::get_module('Products');
        $sku_required = $mod->GetPreference('skurequired',0);
        if( $sku_required && (!isset($this->_data['sku']) || $this->_data['sku'] == null) ) {
            throw new CmsException('A sku is required for a products_attrib object');
        }
        if( isset($this->_data['sku']) && $this->_data['sku'] != '' ) {
            if( product_ops::check_sku_used($this->_data['sku'],$this->_data['product_id']) ) {
                throw new CmsException('SKU '.$this->_data['sku'].' is already in use by another product');
            }
        }
    }

    public function save()
    {
        if( !$this->_dirty ) return;
        $this->validate();

        if( isset($this->_data['id']) && $this->_data['id'] != '' ) {
            $this->_update();
        }
        else {
            $this->_insert();
        }
    }

    protected static function &load_from_data($data)
    {
        foreach( self::$_keys as $k ) {
            if( $k != 'id' && $k != 'iorder' && !in_array($k,array_keys($data)) ) {
                throw new CmsException($k.' is missing from loaded attrib record');
            }
        }
        foreach( array_keys($data) as $key ) {
            if( !in_array($key,self::$_keys) ) {
                throw new CmsException('Unknown or extra data exists in the supploed attrib record');
            }
        }

        $ob = new products_attrib;
        $ob->_data = $data;
        $ob->_dirty = TRUE;
        return $ob;
    }

    public static function load_from_form($params)
    {
        if( !isset($params['prodid']) ) {
            throw new CmsException('Missing product id value from form');
        }
        if( !isset($params['sku']) && !is_array($params['sku']) ) {
            throw new CmsException('Missing SKU data from form');
        }
        if( !isset($params['text']) && !is_array($params['text']) ) {
            throw new CmsException('Missing Text data from form');
        }
        if( !isset($params['adjustment']) && !is_array($params['adjustment']) ) {
            throw new CmsException('Missing adjustment data from form');
        }
        if( !isset($params['qoh']) && !is_array($params['qoh']) ) {
            throw new CmsException('Missing qoh information from form');
        }
        if( !isset($params['notes']) && !is_array($params['notes']) ) {
            throw new CmsException('Missing notes information from form');
        }
        if( (count($params['sku']) != count($params['text'])) ||
            (count($params['sku']) != count($params['adjustment'])) ||
            (count($params['sku']) != count($params['qoh'])) ||
            (count($params['sku']) != count($params['notes'])) ) {
            throw new CmsException('Invalid parameter count (length of sku field does not match one of the others');
        }

        $mod = cms_utils::get_module('Products');
        $sku_required = $mod->GetPreference('skurequired',0);
        $i = 0;
        foreach( $params['sku'] as $one ) {
            $one = trim($one);
            if( !$one && $sku_required ) {
                throw new CmsException('SKU required at row '.$i);
            }
        }

        $i = 1;
        foreach( $params['text'] as $one ) {
            if( !$one ) {
                throw new CmsException('Option text empty at row '.$i);
            }
            $i++;
        }

        // check qoh
        $i = 1;
        foreach( $params['qoh'] as $one ) {
            if( (int)$one < 0 ) {
                throw new CmsException('QOH is negative at row '.$i);
            }
            $i++;
        }

        // put everything together.
        $out = array();
        $keys = array('text','adjustment','sku','qoh','notes');
        for( $i = 0; $i < count($params['sku']); $i++ ) {
            $rec = array('product_id'=>(int)$params['prodid']);
            foreach( $keys as $key ) {
                $rec[$key] = $params[$key][$i];
            }
            $obj = self::load_from_data($rec);
            $obj->_data['iorder'] = $i+1;
            $out[] = $obj;
        }

        return $out;
    }

    public static function load_by_product($id)
    {
        $db = cmsms()->GetDb();
        $query = 'SELECT * FROM '.cms_db_prefix().'module_products_attribs
                  WHERE product_id = ? ORDER BY iorder';
        $dbr = $db->GetArray($query,array((int)$id));
        if( !is_array($dbr) || count($dbr) == 0 ) return;

        $res = array();
        foreach( $dbr as $one ) {
            $res[] = self::load_from_data($one);
        }
        return $res;
    }

    public static function delete_by_product($id)
    {
        $db = cmsms()->GetDb();
        $query = 'DELETE FROM '.cms_db_prefix().'module_products_attribs
              WHERE product_id = ?';
        $dbr = $db->Execute($query,array((int)$id));
        if( !$dbr ) return FALSE;
        return TRUE;
    }

} // end of class

#
# EOF
#
?>