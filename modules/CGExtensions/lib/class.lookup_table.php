<?php
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: CGExtensions (c) 2008-2014 by Robert Campbell
#         (calguy1000@cmsmadesimple.org)
#  An addon module for CMS Made Simple to provide useful functions
#  and commonly used gui capabilities to other modules.
#
#-------------------------------------------------------------------------
# CMSMS - CMS Made Simple is (c) 2005 by Ted Kulp (wishy@cmsmadesimple.org)
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

namespace CGExtensions;

/**
 * An abstract class for a generic lookup table.
 * This class manages a table, and it's items.
 *
 * @property-read int $id
 * @property string $name
 * @property string $description
 */
abstract class lookup_table
{
    /**
     * @ignore
     */
    private $_data = array('id'=>null,'name'=>null,'description'=>null,'iorder'=>null);

    /**
     * @ignore
     */
    private static $_cache;

    /**
     * Return the table name.
     * uses late static bindings.
     *
     * @abstract
     * @return string
     */
    public static function table_name()
    {
        die('YOU MUST override the table_name METHOD in your lookup table derived class.');
    }


    /**
     * Return a title for the add/edit form.
     * uses late static bindings.
     *
     * @abstract
     * @return lookup_form_data
     */
    public static function get_addedit_formdata()
    {
        die('YOU MUST override the get_addedit_formdata METHOD in your lookup table derived class.');
    }

    /**
     * Create the database table for this lookup table
     */
    public static function install()
    {
        $db = \cge_utils::get_db();
        $flds = "id I KEY AUTO,
                 name C(255) NOT NULL,
                 description X,
                 iorder I NOT NULL";

        $dict = NewDataDictionary($db);
        $taboptarray = array('mysqli' => 'ENGINE=InnoDB');
        $sqlarray = $dict->CreateTableSQL(static::table_name(),$flds,$taboptarray);
        $dict->ExecuteSQLArray($sqlarray,FALSE);

        $idx = static::table_name().'_idx1';
        $sqlarray = $dict->CreateIndexSQL($idx,static::table_name(),'name',array('UNIQUE'));
        $dict->ExecuteSQLArray($sqlarray,FALSE);
    }

    /**
     * Destroy the database table for this lookup table.
     */
    public static function uninstall()
    {
        $db = \cge_utils::get_db();
        $dict = NewDataDictionary($db);

        $sqlarray = $dict->DropTableSQL(static::table_name());
        $dict->ExecuteSQLArray($sqlarray,FALSE);
    }

    /**
     * @ignore
     */
    public function __get($key)
    {
        switch( $key ) {
        case 'id':
        case 'name':
        case 'description':
        case 'iorder':
            return $this->_data[$key];
            break;

        default:
            throw new \LogicException("$key is not a valid member of ".__CLASS__);
        }
    }

    public function __set($key,$val)
    {
        switch( $key ) {
        case 'id':
        case 'iorder':
            throw new \LogicException("$key is not a settable member of ".__CLASS__);

        case 'name':
        case 'description':
            $this->_data[$key] = trim($val);
            break;

        default:
            throw new \LogicException("$key is not a valid member of ".__CLASS__);
        }
    }

    public function __isset($key)
    {
        switch( $key ) {
        case 'id':
        case 'name':
        case 'description':
        case 'iorder':
            return TRUE;

        default:
            throw new \LogicException("$key is not a valid member of ".__CLASS__);
        }

        return FALSE;
    }

    public function __unset($key)
    {
        return; // do nothing
    }

    public function validate()
    {
        if( !$this->name ) throw new \RuntimeException(cgex_lang('error_lkp_namerequired'));
    }

    public function save()
    {
        $this->validate();
        if( $this->id > 0 ) {
            $this->_update();
        } else {
            $this->_insert();
        }
    }

    public function _insert()
    {
        $db = \cge_utils::get_db();
        $query = 'SELECT COALESCE(MAX(iorder),0) + 1 FROM '.static::table_name();
        $this->_data['iorder'] = (int) $db->GetOne($query);

        $query = 'INSERT INTO '.static::table_name().' (name,description,iorder) VALUES (?,?,?)';
        $db->Execute($query,array($this->name,$this->description,$this->iorder));
    }

    public function _update()
    {
        $db = \cge_utils::get_db();
        $query = 'UPDATE '.static::table_name().' SET name = ?, description = ?, iorder = ? WHERE id = ?';
        $db->Execute($query,array($this->name,$this->description,$this->iorder,$this->id));
    }

    public static function delete($item_id)
    {
        $item_id = (int) $item_id;
        if( $item_id < 1 ) throw new \LogicException('Cannot delete a '.get_class($this).' that has not been saved');

        $db = \cge_utils::get_db();
        try {
            $db->BeginTrans();

            $query = 'SELECT iorder FROM '.static::table_name().' WHERE id = ?';
            $iorder = $db->GetOne($query,array($item_id));
            if( $iorder < 1 ) throw new \LogicException('Could not find an iorder associated with the lookup item '.$item_id);

            $query = 'UPDATE '.static::table_name().' SET iorder = iorder - 1 WHERE iorder > ?';
            $db->Execute($query,array($iorder));

            $query = 'DELETE FROM '.static::table_name().' WHERE id = ?';
            $db->Execute($query,array($item_id));

            $db->CommitTrans();
        }
        catch( \Exception $e ) {
            $db->RollbackTrans();
            throw $e;
        }
    }

    public static function move_up($item_a_id)
    {
        $item_a_id = (int) $item_a_id;

        // get this item and it's iorder
        $item_a = static::load($item_a_id);

        // get the item with the previous iorder
        $db = \cge_utils::get_db();
        $query = 'SELECT id FROM '.static::table_name().' WHERE iorder = ?';
        $item_b_id = (int) $db->GetOne($query,array($item_a->iorder-1));
        if( !$item_b_id ) throw new \LogicException('This lookup item cannot be moved up');
        $item_b = static::load($item_b_id);

        // swap the two items orders
        $tmp = $item_a->iorder;
        $item_a->_data['iorder'] = $item_b->iorder;
        $item_b->_data['iorder'] = $tmp;

        // save them both.
        $item_a->save();
        $item_b->save();
    }

    public static function move_down($item_a_id)
    {
        $item_a_id = (int) $item_a_id;

        // get this item and it's iorder
        $item_a = static::load($item_a_id);

        // get the item with the previous iorder
        $db = \cge_utils::get_db();
        $query = 'SELECT id FROM '.static::table_name().' WHERE iorder = ?';
        $item_b_id = (int) $db->GetOne($query,array($item_a->iorder+1));
        if( !$item_b_id ) throw new \LogicException('This lookup item cannot be moved up');
        $item_b = static::load($item_b_id);

        // swap the two items orders
        $tmp = $item_a->iorder;
        $item_a->_data['iorder'] = $item_b->iorder;
        $item_b->_data['iorder'] = $tmp;

        // save them both.
        $item_a->save();
        $item_b->save();
    }

    public static function load($id)
    {
        $id = (int) $id;
        $list = self::load_all();
        if( isset($list[$id]) ) return $list[$id];
        throw new \RuntimeException(cgex_lang('error_itemnotfound'));
    }

    public static function load_all()
    {
        if( is_array(self::$_cache[static::table_name()]) ) {
            return self::$_cache[static::table_name()];
        }

        self::$_cache[static::table_name()] = array();
        $db = \cge_utils::get_db();
        $query = 'SELECT id,name,description,iorder FROM '.static::table_name().' ORDER BY iorder';
        $rows = $db->GetArray($query);
        if( !is_array($rows) ) return;

        $class = get_called_class();
        foreach( $rows as $row ) {
            $obj = new $class;
            $obj->_data = $row;
            self::$_cache[static::table_name()][$obj->id] = $obj;
        }
        return self::$_cache[static::table_name()];
    }

    public static function add($name,$description = null)
    {
        $name = trim((string) $name);
        if( !$name ) throw new \LogicException("A valid name must be passed to ".__METHOD__);
        $class = get_called_class();

        $obj = new $class;
        $obj->name = $name;
        $obj->description = trim((string) $description);
        $obj->save();
    }

    public static function exists($id)
    {
        $id = (int) $id;
        if( $id < 1 ) throw new \LogicException("A valid id must be passed to ".__METHOD__);
        $class = get_called_class();
        $list = $class::load_all();
        if( isset($list[$id]) ) return TRUE;
        return FALSE;
    }

    public static function get_list()
    {
        $class = get_called_class();
        $list = $class::load_all();

        if( !count($list) ) return;

        $out = array();
        foreach( $list as $id => $obj ) {
            $out[$id] = $obj->name;
        }
        return $out;
    }

} // end of class

/**
 * A simple class to provide title, and return data information to the lookup form manager
 *
 * @property string $module_name The module name that the lookup type belongs to.
 * @property string $title A title for the add/edit form.
 * @property string $subtitle A subtitle for the add/edit form
 * @property string $return_action The optional action that the user should be returned to within the owning module (if not specified defaultadmin is used)
 * @property string $return_tab The optional tab name that the user should be returned to within the specified action of the owning module.
 * @proeprty string $post_add_message Optional message to display after the user has added a new item to the lookup table.
 * @property string $post_edit_message Optional message to display after the user has edited an existing item in the lookup table.
 * @property string $cancel_message Optional message to display after hte user has cancelled an add or edit operation.
 */
final class lookup_form_data
{
    private $_data = array('module_name'=>null,'title'=>null,'subtitle'=>null,'return_action'=>null,'return_tab'=>null,
                           'post_add_message'=>null,'post_edit_message'=>null,'cancel_message'=>null);

    public function __construct($data = null)
    {
        if( !$data ) return;
        if( !is_array($data) ) throw new \LogicException(__METHOD__.' accepts only an array as input');
        foreach( $data as $key => $val ) {
            $this->$key = $val;
        }
    }

    public function __get($key)
    {
        switch( $key ) {
        case 'module_name':
        case 'title':
        case 'subtitle':
        case 'return_tab':
        case 'post_add_message':
        case 'post_edit_message':
        case 'cancel_message':
            return $this->_data[$key];

        case 'return_action':
            if( !$this->_data[$key] ) return 'defaultadmin';
            return $this->_data[$key];

        default:
            throw new \LogicException("$key is not a valid member of ".__CLASS__);
        }
    }

    public function __set($key,$val)
    {
        switch( $key ) {
        case 'module_name':
        case 'title':
        case 'subtitle':
        case 'return_action':
        case 'return_tab':
        case 'post_add_message':
        case 'post_edit_message':
        case 'cancel_message':
            $this->_data[$key] = trim($val);
            break;

        default:
            throw new \LogicException("$key is not a valid member of ".__CLASS__);
        }
    }

    public function __isset($key)
    {
        switch( $key ) {
        case 'module_name':
        case 'title':
        case 'subtitle':
        case 'return_action':
        case 'return_tab':
        case 'post_add_message':
        case 'post_edit_message':
        case 'cancel_message':
            return !empty($this->_data[$key]);

        default:
            throw new \LogicException("$key is not a valid member of ".__CLASS__);
        }
    }

    public function __unset($key)
    {
        switch( $key ) {
        case 'module_name':
        case 'title':
        case 'subtitle':
        case 'return_action':
        case 'return_tab':
        case 'post_add_message':
        case 'post_edit_message':
        case 'cancel_message':
            $this->_data[$key] = null;
            break;

        default:
            throw new \LogicException("$key is not a valid member of ".__CLASS__);
        }
    }

    public function validate()
    {
        if( !$this->module_name || !$this->title ) throw new \LogicException('instance of '.__CLASS__.' could not validate');
    }
}
?>