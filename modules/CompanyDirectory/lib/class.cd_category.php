<?php
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: CompanyDirectory (c) 2004-6 by Ted Kulp (ted@cmsmadesimple.org)
#   Copyright 2006 - 2014 by Robert Campbell (calguy1000@cmsmadesimple.org)
#
#  An addon module for CMS Made Simple to allow management of and various ways to display
#  company information for use in directories etc.
#
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2005-2010 by Ted Kulp (wishy@cmsmadesimple.org)
# Visit the CMSMS homepage at: http://www.cmsmadesimple.org
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

final class cd_category implements ArrayAccess
{
    // keys are: id (ro), image_url (ro), image_file (ro), description, name, parent_id, item_order, hierarchy (ro), extra1, extra2, extra3
    private $_orig_parent = -100;
    private $_data = null;
    private $_dirty;

    public function __construct()
    {
        $this->_data = array('id'=>null,'image'=>null,'description'=>null,'parent_id'=>-1,'hierarchy'=>null,'extra1'=>null,'extra2'=>null,'extra3'=>null);
    }

    public function OffsetGet($key)
    {
        switch( $key ) {
        case 'id':
        case 'item_order':
            if( isset($this->_data[$key]) && !is_null($this->_data[$key]) ) return (int)$this->_data[$key];
            break;

        case 'parent_id':
            if( isset($this->_data[$key]) && !is_null($this->_data[$key]) ) return (int)$this->_data[$key];
            return -1;

        case 'image_url':
            if( isset($this->_data[$key]) && !is_null($this->_data['image']) ) {
                die('not done');
            }
            break;

        case 'image_file':
            if( isset($this->_data[$key]) && !is_null($this->_data['image']) ) {
                die('not done');
            }
            break;

        case 'image':
        case 'name':
        case 'description':
        case 'hierarchy':
        case 'extra1':
        case 'extra2':
        case 'extra3':
            if( isset($this->_data[$key]) && !is_null($this->_data[$key]) ) return trim($this->_data[$key]);
            break;

        default:
            throw new CmsException($key.' is an invalid key for a '.__CLASS__.' object');
        }
    }

    public function OffsetSet($key,$value)
    {
        switch( $key ) {
        case 'parent_id':
            $value = (int)$value;
            if( $value == 0 || $value < -1 ) throw new CmsInvalidDataException("Invalid value $value for key $key in class ".__CLASS__);
            $this->_orig_parent = $this->_data[$key];
            $this->_data[$key] = (int)$value;
            $this->_dirty = TRUE;
            break;

        case 'item_order':
            $value = (int)$value;
            if( $value < 1 ) throw new CmsInvalidDataException("Invalid value $value for key $key in class ".__CLASS__);
            $this->_data[$key] = (int)$value;
            $this->_dirty = TRUE;
            break;

        case 'image':
        case 'name':
        case 'description':
        case 'hierarchy':
        case 'extra1':
        case 'extra2':
        case 'extra3':
            $this->_data[$key] = trim($value);
            $this->_dirty = TRUE;
            break;

        case 'id':
        case 'image_url':
        case 'image_file':
            throw new CmsException($key.' is a readonly key for a '.__CLASS__.' object');

        default:
            throw new CmsException($key.' is an invalid key for a '.__CLASS__.' object');
        }
    }

    public function OffsetExists($key)
    {
        switch( $key ) {
        case 'id':
        case 'parent_id':
        case 'item_order':
        case 'image':
        case 'name':
        case 'description':
        case 'hierarchy':
        case 'extra1':
        case 'extra2':
        case 'extra3':
        case 'image_url':
        case 'image_file':
            return (isset($this->_data[$key]) && !is_null($this->_data[$key]))?TRUE:FALSE;

        default:
            throw new CmsException($key.' is an invalid key for a '.__CLASS__.' object');
        }
    }

    public function OffsetUnset($key)
    {
        switch( $key ) {
        case 'image':
            // todo: here we should delete the image (or mark it for deletion on save)
        case 'name':
        case 'description':
        case 'hierarchy':
        case 'extra1':
        case 'extra2':
        case 'extra3':
            unset($this->_data[$key]);
            $this->_dirty = TRUE;
            break;

        case 'parent_id':
        case 'id':
        case 'item_order':
        case 'image_url':
        case 'image_file':
            throw new CmsException($key.' is a readonly key for a '.__CLASS__.' object');

        default:
            throw new CmsException($key.' is an invalid key for a '.__CLASS__.' object');
        }
    }

    private function _insert()
    {
        if( $this['id'] > 0 ) throw new CmsInvalidDataException('Cannot update a category record with a valid item id');
        $db = cmsms()->GetDb();
        // calculate an item order
        if( $this['item_order'] < 1 ) {
            $query = 'SELECT COALESCE(MAX(item_order),0)+1 FROM '.cms_db_prefix().'module_compdir_categories WHERE parent_id = ?';
            $this['item_order'] = $db->GetOne($query,array($this['parent_id']));
        }
        $query = 'INSERT INTO '.cms_db_prefix().'module_compdir_categories (name,image,description,parent_id,item_order,extra1,extra2,extra3)
            VALUES (?,?,?,?,?,?,?,?)';
        $dbr = $db->Execute($query,array($this['name'],$this['image'],$this['description'],$this['parent_id'],$this['item_order'],
                                         $this['extra1'],$this['extra2'],$this['extra3']));
        if( !$dbr ) throw new CmsException("Database Error: ".$db->sql.' -- '.$db->ErrorMsg());
        $this->_data['id'] = $db->Insert_ID();
        $this->_dirty = FALSE;
    }

    private function _update()
    {
        // additional validation
        if( $this['id'] < 1 ) throw new CmsInvalidDataException('Cannot update a category record with no item id');
        if( $this['item_order'] < 1 ) throw new CmsInvalidDataException('Invalid item_order for '.__CLASS__);
        if( $this['parent_id'] == 0 || $this['parent_id'] < -1 ) throw new CmsInvalidDataException('Invalid parent_id for '.__CLASS__);

        $db = cmsms()->GetDb();
        if( $this->_orig_parent > -100 && $this->_orig_parent != $this['parent_id'] ) {
            // changing parent
            $query = 'UPDATE '.cms_db_prefix().'module_compdir_categories SET item_order = item_order - 1 WHERE item_order > ? AND parent_id = ?';
            $db->Execute($query,array($this['item_order'],$this->_orig_parent));

            $query = 'SELECT COALESCE(MAX(item_order),0)+1 FROM '.cms_db_prefix().'module_compdir_categories WHERE parent_id = ?';
            $this->_data['item_order'] = $db->GetOne($query,array($this['parent_id']));
        }

        $query = 'UPDATE '.cms_db_prefix().'module_compdir_categories SET name = ?, image = ?, description = ?, parent_id = ?, item_order = ?,
                  extra1 = ?, extra2 = ?, extra3 = ? WHERE id = ?';
        $dbr = $db->Execute($query,array($this['name'],$this['image'],$this['description'],$this['parent_id'],$this['item_order'],
                                         $this['extra1'],$this['extra2'],$this['extra3'],$this['id']));
        if( !$dbr ) throw new CmsException("Database Error: ".$db->sql.' -- '.$db->ErrorMsg());
        $this->_dirty = FALSE;
    }

    public function validate()
    {
        $mod = cms_utils::get_module(MOD_COMPANYDIRECTORY);
        if( $this['name'] == '' ) throw new CmsInvalidDataException($mod->Lang('nonamegiven'));
        if( preg_match('/[^\w \&]/',$this['name']) ) throw new CmsInvalidDataException($mod->Lang('badnamegiven'));
        if( strpos('|',$this['name']) !== FALSE ) throw new CmsInvalidDataException($mod->Lang('badnamegiven'));

        $db = cmsms()->GetDb();
        $tmp = -1;
        if( $this['id'] > 0 ) {
            $query = 'SELECT id FROM '.cms_db_prefix().'module_compdir_categories WHERE parent_id = ? AND name = ? AND id != ?';
            $tmp = $db->GetOne($query,array($this['parent_id'],$this['name'],$this['id']));
        }
        else {
            $query = 'SELECT id FROM '.cms_db_prefix().'module_compdir_categories WHERE parent_id = ? AND name = ?';
            $tmp = $db->GetOne($query,array($this['parent_id'],$this['name']));
        }
        if( $tmp > 0 ) throw new CmsInvalidDataException($mod->Lang('error_duplicate_category'));
    }

    public function save()
    {
        if( !$this->_dirty ) return;
        $this->validate();
        if( $this['id'] > 0 ) {
            $this->_update();
        } else {
            $this->_insert();
        }
        self::calculate_hierarchy_positions();
    }

    public static function &load($id)
    {
        $id = (int)$id;
        if( $id < 1 ) throw new CmsInvalidDataException('Cannot Invalid category id '.$id);

        $db = cmsms()->GetDb();
        $query = 'SELECT * FROM '.cms_db_prefix().'module_compdir_categories WHERE id = ?';
        $dbr = $db->GetRow($query,array($id));
        if( !is_array($dbr) ) throw new CmsInvalidDataException('Category '.$id.' not found');

        $obj = new self();
        $obj->_data = $dbr;
        return $obj;
    }

    public function delete()
    {
        if( $this['id'] < 1 ) throw new CmsException('Cannot delete category that has not been saved');

        $db = cmsms()->GetDb();

        // check for children
        $query = 'SELECT count(id) FROM '.cms_db_prefix().'module_compdir_categories WHERE parent_id = ?';
        $tmp = $db->GetOne($query,array($this['id']));
        if( $tmp > 0 ) throw new Exception('Cannot delete category that has children');

        // delete the thing
        $query = 'DELETE FROM '.cms_db_prefix().'module_compdir_company_categories WHERE category_id = ?';
        $dbr = $db->Execute($query,array($this['id']));
        $query = 'UPDATE '.cms_db_prefix().'module_compdir_categories SET item_order = item_order - 1 WHERE parent_id = ? AND item_order > ?';
        $dbr = $db->Execute($query,array($this['parent_id'],$this['item_order']));
        $query = 'DELETE FROM '.cms_db_prefix().'module_compdir_categories WHERE parent_id = ? AND id = ?';
        $dbr = $db->Execute($query,array($this['parent_id'],$this['id']));
        self::calculate_hierarchy_positions();
    }

    public static function get_list()
    {
        $tmp = cd_utils::get_categories(TRUE);
        if( count($tmp) ) {
            $out = array();
            foreach( $tmp as $one ) {
                $_h = explode('.',$one->hierarchy);
                $depth = count($_h)-1;
                $out[$one->id] = str_repeat('&nbsp;&nbsp;',$depth).$one->name;
            }
            return $out;
        }
    }

    public static function get_tree()
    {
        $list = cd_utils::get_categories(TRUE);
        if( !is_array($list) || count($list) == 0 ) return;

        $get_tree = function($parent_id = -1, $depth = 0) use ($list,&$data,&$get_tree) {
            $out = array();
            foreach( $list as $one ) {
                if( $one->parent_id != $parent_id ) continue;

                $tmp = $get_tree($one->id,$depth+1);
                if( is_array($tmp) && count($tmp) ) {
                    $one->children = $tmp;
                }
                $one->depth = $depth;
                $out[] = $one;
            }
            return $out;
        };

        $tree = $get_tree();
        return $tree;
    }

    /**
     * @internal
     * @ignore
     */
    public static function calculate_hierarchy_positions()
    {
        $db = cmsms()->GetDb();

        $query = "SELECT id, item_order, name FROM ".cms_db_prefix()."module_compdir_categories";
        $dbresult = $db->Execute($query);
        if( !$dbresult ) throw new CmsException('SQL Error: '.$db->sql.' -- '.$db->ErrorMsg());
        while ($dbresult && $row = $dbresult->FetchRow()) {
            $current_hierarchy_position = "";
            $current_long_name = "";
            $content_id = $row['id'];
            $current_parent_id = $row['id'];
            $count = 0;

            while ($current_parent_id > 0) {
                $query = "SELECT id, item_order, name, parent_id FROM ".cms_db_prefix()."module_compdir_categories
                          WHERE id = ?";
                $row2 = $db->GetRow($query, array($current_parent_id));
                if ($row2) {
                    $current_hierarchy_position = str_pad($row2['item_order'], 5, '0', STR_PAD_LEFT) . "." . $current_hierarchy_position;
                    $current_long_name = $row2['name'] . ' | ' . $current_long_name;
                    $current_parent_id = $row2['parent_id'];
                    $count++;
                }
                else {
                    $current_parent_id = 0;
                }
            }

            if (strlen($current_hierarchy_position) > 0) {
                $current_hierarchy_position = substr($current_hierarchy_position, 0, strlen($current_hierarchy_position) - 1);
            }

            if (strlen($current_long_name) > 0) $current_long_name = substr($current_long_name, 0, strlen($current_long_name) - 3);

            $query = "UPDATE ".cms_db_prefix()."module_compdir_categories SET hierarchy = ?, long_name = ? WHERE id = ?";
            $db->Execute($query, array($current_hierarchy_position, $current_long_name, $content_id));
        }
    }
} // end of class
?>