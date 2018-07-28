<?php

namespace Banners;

class category
{
    private $_data = array('id'=>null,'name'=>null,'description'=>null,'template'=>null,'dflt_image'=>null,'dflt_url'=>null);
    private $_dirty;

    public function __get($key)
    {
        switch( $key ) {
        case 'id':
        case 'name':
        case 'description':
        case 'template':
        case 'dflt_image':
        case 'dflt_url':
            return $this->_data[$key];

        default:
            throw new \CmsInvalidDataException($key.' is not a valid member of '.__CLASS__);
        }
    }

    public function __set($key,$val)
    {
        switch( $key ) {
        case 'id':
            throw new \LogicException('Cannot modify a readonly member of '.__CLASS__);

        case 'name':
        case 'description':
        case 'template':
        case 'dflt_image':
        case 'dflt_url':
            $this->_data[$key] = trim($val);
            $this->_dirty = TRUE;
            break;

        default:
            throw new \CmsInvalidDataException($key.' is not a valid member of '.__CLASS__);
        }
    }

    public function __isset($key)
    {
        return isset($this->_data[$key]);
    }

    public function __unset($key)
    {
        // do nothing
    }

    protected function _update()
    {
        $mod = \cms_utils::get_module(MOD_BANNERS);
        $db = cmsms()->GetDb();

        $query = 'UPDATE '.cms_db_prefix().'module_banners_categories
                    SET name = ?, description = ?, template = ?, dflt_image = ?, dflt_url = ?
                  WHERE category_id = ?';
        $dbr = $db->Execute($query,array($this->name,$this->description,$this->template,
                                         $this->dflt_image,$this->dflt_url,$this->id));
        $this->_dirty = FALSE;
    }

    protected function _insert()
    {
        $mod = \cms_utils::get_module(MOD_BANNERS);
        $db = cmsms()->GetDb();

        $this->_data['id'] = $db->GenID(cms_db_prefix().'module_banners_categories_seq');
        $query = 'INSERT INTO '.cms_db_prefix().'module_banners_categories (category_id,name,description,template,dflt_image,dflt_url)
                    VALUES (?,?,?,?,?,?)';
        $dbr = $db->Execute($query,array($this->id,$this->name,$this->description,
                                         $this->template,$this->dflt_image,$this->dflt_url));
        $this->_dirty = FALSE;
    }

    public function validate()
    {
        $mod = \cms_utils::get_module(MOD_BANNERS);
        $db = cmsms()->GetDb();

        if( !$this->name ) throw new \CmsInvalidDataException($mod->Lang('error_namerequired'));
        if( $this->dflt_image ) {
            $config = cmsms()->GetConfig();
            $fn = cms_join_path($config['uploads_path'],$this->dflt_image);
            if( !file_exists($fn) ) throw new \CmsInvalidDataException($mod->Lang('error_imagenotfound'));
        }

        if( $this->id ) {
            $query = 'SELECT category_id FROM '.cms_db_prefix().'module_banners_categories WHERE name = ? AND id = ?';
            $tmp = $db->GetOne($query,array($this->name,$this->id));
            if( $tmp ) throw new \CmsInvalidDataException($mod->Lang('error_categoryexists'));
        }
        else {
            $query = 'SELECT category_id FROM '.cms_db_prefix().'module_banners_categories WHERE name = ?';
            $tmp = $db->GetOne($query,array($this->name));
            if( $tmp ) throw new \CmsInvalidDataException($mod->Lang('error_categoryexists'));
        }
    }

    public function save()
    {
        if( !$this->_dirty ) return;
        $this->validate();
        if( $this->id ) {
            $this->_update();
        } else {
            $this->_insert();
        }
    }

    public function to_array()
    {
        return $this->_data;
    }

    // accepts name or id.
    public static function load($id)
    {
        $mod = \cms_utils::get_module(MOD_BANNERS);
        $db = cmsms()->GetDb();

        $row = null;
        if( is_string($id) && (int) $id == 0 ) {
            // assume it is a category name
            $query = 'SELECT * FROM '.cms_db_prefix().'module_banners_categories WHERE name = ?';
            $row = $db->GetRow($query,array($id));
        } else {
            // assume it is a category id
            if( $id < 1 ) throw new \CmsInvalidDataSpecified("$id is not a valid category id");
            $query = 'SELECT * FROM '.cms_db_prefix().'module_banners_categories WHERE category_id = ?';
            $row = $db->GetRow($query,array($id));
        }
        if( !is_array($row) || count($row) == 0 ) throw new \CmsInvalidDataException($mod->Lang('error_noresults'));

        $row['id'] = $row['category_id']; unset($row['category_id']);
        unset($row['uploads_category_id']);
        $obj = new self();
        $obj->_data = $row;
        $obj->_dirty = FALSE;
        return $obj;
    }

    public function delete()
    {
        if( $this->id < 1 ) return;
        $mod = \cms_utils::get_module(MOD_BANNERS);
        $db = cmsms()->GetDb();

        $query = 'SELECT COUNT(banner_id) FROM '.cms_db_prefix().'module_banners WHERE category_id = ?';
        $tmp = $db->GetOne($query,array($this->id));
        if( $tmp > 0 ) throw new \LogicException($mod->Lang('error_categorynotempty'));

        $query = 'DELETE FROM '.cms_db_prefix().'module_banners_categories WHERE category_id = ?';
        $dbr = $db->Execute($query,array($this->id));

        $this->_data['id'] = null;
        $this->_dirty = TRUE;
    }

    public static function load_all()
    {
        $db = cmsms()->GetDb();
        $sql = 'SELECT * FROM '.cms_db_prefix().'module_banners_categories ORDER BY name';
        $list = $db->GetArray($sql);

        if( !is_array($list) || !count($list) ) return;
        $out = [];
        foreach( $list as $row ) {
            $obj = new self();
            $row['id'] = $row['category_id']; unset($row['category_id']);
            $obj->_data = $row;
            $obj->_dirty = FALSE;
            $out[] = $obj;
        }
        return $out;
    }

    public static function get_list()
    {
        $list = self::load_all();
        if( !$list ) return;

        $out = [];
        foreach( $list as $obj ) {
            $out[$obj->id] = $obj->name;
        }
        return $out;
    }
} // end of class

?>