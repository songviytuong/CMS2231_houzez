<?php

namespace Banners;

class banner
{
    private $_dirty;
    private $_data = array('id'=>null,'category_id'=>null,'name'=>null,'description'=>null,
                           'image'=>null,'url'=>null,'text'=>null,
                           'created'=>null,'expires'=>null,
                           'max_impressions'=>null, 'num_impressions'=>null,
                           'href_text'=>null, 'start_date'=>null,
                           'neverexpires'=>null,
                           'last_impression'=>null);

    public function __construct()
    {
        $this->_data['start_date'] = time();
        $this->_data['max_impressions'] = 0;
        $this->_data['num_impressions'] = 0;
    }

    public function __get($key)
    {
        switch( $key ) {
        case 'id':
        case 'category_id':
        case 'name':
        case 'description':
        case 'image':
        case 'url':
        case 'text':
        case 'created':
        case 'expires':
        case 'max_impressions':
        case 'num_impressions':
        case 'href_text': // href alt tag text
        case 'text':  // image alt tag text
        case 'start_date':
        case 'last_impression':
        case 'neverexpires':
            return $this->_data[$key];

        default:
            throw new \CmsInvalidDataException($key.' is not a valid member of '.__CLASS__);
        }
    }

    public function __set($key,$val)
    {
        switch( $key ) {
        case 'id':
        case 'created':
            throw new \LogicException('Cannot modify a readonly member of '.__CLASS__);

        case 'category_id':
            $val = (int) $val;
            if( $val < 1 ) throw new \LogicException("$val is an invalid value for $key in ".__CLASS__);
            $this->_data[$key] = $val;
            $this->_dirty = TRUE;
            break;

        case 'num_impressions':
        case 'max_impressions':
            $val = (int) $val;
            if( $val < 0 ) throw new \LogicException("$val is an invalid value for $key in ".__CLASS__);
            $this->_data[$key] = $val;
            $this->_dirty = TRUE;
            break;

        case 'name':
        case 'description':
        case 'image':
        case 'url':
        case 'text':
        case 'href_text': // href alt tag text
        case 'text':  // image alt tag text
            $this->_data[$key] = trim($val);
            $this->_dirty = TRUE;
            break;

        case 'expires':
            // expect a timestamp
            $val = (int) $val;
            if( $val < 0 ) throw new \LogicException("$val is an invalid value for $key in ".__CLASS__);
            $this->_data[$key] = $val;
            $this->_dirty = TRUE;
            break;

        case 'neverexpires':
            $this->_data[$key] = (bool) $val;
            $this->_dirty = TRUE;
            break;

        case 'start_date':
        case 'last_impression':
            // expect a timestamp
            $val = (int) $val;
            if( $val < 0 ) throw new \LogicException("$val is an invalid value for $key in ".__CLASS__);
            $this->_data[$key] = $val;
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

    protected function _insert()
    {
        $db = cmsms()->GetDb();
        $this->_data['id'] = $db->GenID(cms_db_prefix().'module_banners_seq');

        $query = 'INSERT INTO '.cms_db_prefix()."module_banners
                  (banner_id, category_id, name, description, image, url, text, href_text, start_date, expires, max_impressions, num_impressions, created)
                  VALUES (?,?,?,?,?,?,?,?,?,?,?,?,NOW())";

        $expires = \cge_date_utils::ts_to_dbformat($this->_data['expires']);
        if( $this->neverexpires ) $expires = null;

        $dbr = $db->Execute($query, array($this->id,
                                          $this->category_id,
                                          $this->name,
                                          $this->description,
                                          $this->image,
                                          $this->url,
                                          $this->text,
                                          $this->href_text,
                                          \cge_date_utils::ts_to_dbformat($this->start_date),
                                          $expires,
                                          $this->max_impressions,
                                          $this->num_impressions));
        $this->_dirty = FALSE;
    }

    protected function _update()
    {
        $expires = \cge_date_utils::ts_to_dbformat($this->_data['expires']);
        if( $this->neverexpires ) $expires = null;

        $db = cmsms()->GetDb();
        $query = 'UPDATE '.cms_db_prefix().'module_banners
                  SET category_id = ?, name = ?, description = ?, image = ?, url = ?, text = ?, href_text = ?,
                      start_date = ?, expires = ?, max_impressions = ?, num_impressions = ?, last_impression = ?
                  WHERE banner_id = ?';
        $dbr = $db->Execute($query,array($this->category_id,$this->name,$this->description,$this->image,$this->url,
                                         $this->text,$this->href_text,\cge_date_utils::ts_to_dbformat($this->start_date),
                                         $expires,$this->max_impressions,
                                         $this->num_impressions,\cge_date_utils::ts_to_dbformat($this->last_impression),
                                         $this->id));
        $this->_dirty = FALSE;
    }

    public function validate()
    {
        $mod = \cms_utils::get_module(MOD_BANNERS);
        if( !$this->name ) throw new \CmsInvalidDataException($mod->Lang('error_emptybannername'));
        if( !$this->url ) throw new \CmsInvalidDataException($mod->Lang('error_insufficientparams'));
        if( !$this->image ) throw new \CmsInvalidDataException($mod->Lang('error_insufficientparams'));
        $config = cmsms()->GetConfig();
        if( !file_exists(cms_join_path($config['uploads_path'],$this->image)) ) {
            throw new \CmsInvalidDataException($mod->Lang('error_imagenotfound'));
        }

        $db = cmsms()->GetDb();
        if( $this->id ) {
            $query = 'SELECT banner_id FROM '.cms_db_prefix().'module_banners WHERE name = ? AND banner_id != ?';
            $tmp = $db->GetOne($query,array($this->name,$this->id));
            if( $tmp ) throw new \CmsInvalidDataException($mod->Lang('error_bannerexists'));
        }
        else {
            $query = 'SELECT banner_id FROM '.cms_db_prefix().'module_banners WHERE name = ?';
            $tmp = $db->GetOne($query,array($this->name));
            if( $tmp ) throw new \CmsInvalidDataException($mod->Lang('error_bannerexists'));
        }
    }

    public function save()
    {
        try {
            if( !$this->_dirty ) return;
            $this->validate();
            if( $this->id == 0 ) {
                $this->_insert();
            } else {
                $this->_update();
            }
        }
        catch( \Exception $e ) {
            \cge_utils::log_exception($e);
            throw $e;
        }
    }

    public function to_array()
    {
        return $this->_data;
    }

    // accept a name or an id.
    public static function load($id)
    {
        $mod = \cms_utils::get_module(MOD_BANNERS);
        $db = cmsms()->GetDb();

        $query = null;
        $parms = array();
        if( is_string($id) && (int) $id == 0 ) {
            $id = (string) $id;
            $query = 'SELECT * FROM '.cms_db_prefix().'module_banners WHERE name = ?';
        } else {
            $id = (int) $id;
            if( $id < 1 ) throw new \CmsInvalidDataSpecified("$id is not a valid banner id");
            $query = 'SELECT * FROM '.cms_db_prefix().'module_banners WHERE banner_id = ?';
        }

        $parms[] = $id;
        $row = $db->GetRow($query,array($id));
        if( !is_array($row) || count($row) == 0 ) throw new \CmsInvalidDataException($mod->Lang('error_noresults'));

        return self::_build_from_data($row);
    }

    private static function _build_from_data($row)
    {
        $db = cmsms()->GetDb();

        $row['id'] = $row['banner_id'];
        unset($row['banner_id']);
        $row['created'] = $db->UnixTimeStamp($row['created']);
        $row['expires'] = $db->UnixTimeStamp($row['expires']);
        $row['start_date'] = $db->UnixTimeStamp($row['start_date']);
        $row['last_impression'] = $db->UnixTimeStamp($row['last_impression']);
        $row['neverexpires'] = (!$row['expires'])?TRUE:FALSE;

        $obj = new self();
        $obj->_data = $row;
        $obj->_dirty = null;
        return $obj;
    }

    public static function load_latest($category_id = null,$sequential = FALSE)
    {
        $db = cmsms()->GetDb();
        $mod = \cms_utils::get_module(MOD_BANNERS);

        $parms = array();
        $where = array();
        $query = 'SELECT * FROM '.cms_db_prefix().'module_banners';
        $where[] = '(start_date <= NOW())';
        $where[] = '(expires >= NOW() OR isnull(expires))';
        $where[] = '(max_impressions = 0 OR num_impressions < max_impressions)';
        if( (int) $category_id > 0 ) {
            $where[] = '(category_id = ?)';
            $parms[] = $category_id;
        }

        // build it
        $query .= ' WHERE '.implode(' AND ',$where);
        if( $sequential ) {
            $query .= ' ORDER BY last_impression ASC';
        }
        else {
            $query .= ' ORDER BY RAND()';
        }

        $row = $db->GetRow($query,$parms);
        if( !is_array($row) || count($row) == 0 ) throw new \RuntimeException($mod->Lang('error_noresults'));

        return self::_build_from_data($row);
    }

    public function delete()
    {
        if( !$this->id ) return;

        $db = cmsms()->GetDb();
        $query = 'DELETE FROM '.cms_db_prefix().'module_banners_hits WHERE banner_id = ?';
        $dbr = $db->Execute($query,array($this->id));

        $query = 'DELETE FROM '.cms_db_prefix().'module_banners WHERE banner_id = ?';
        $dbr = $db->Execute($query,array($this->id));

        $this->_data['id'] = null;
        $this->_dirty = TRUE;
    }
} // end of class

?>
