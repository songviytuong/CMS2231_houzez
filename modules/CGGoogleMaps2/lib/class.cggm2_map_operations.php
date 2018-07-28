<?php
/**
 * Utility methods for working with maps
 *
 * @package CGGoogleMaps2
 * @author Robert Campbell <calguy1000@gmail.com>
 */

/**
 * Utility methods for working with maps
 *
 * @package CGGoogleMaps2
 * @author Robert Campbell <calguy1000@gmail.com>
 */
final class cggm2_map_operations
{
    /**
     * @ignore
     */
    static private $_dflt_icon;

    /**
     * @ignore
     */
    static private $_map_tpl;

    /**
     * @ignore
     */
    static private $_maps;

    /**
     * @ignore
     */
    static private $_map_name_map;

    /**
     * @ignore
     */
    private function __construct() {}

    /**
     * Update a map object given form data
     *
     * @param cggm2_map $map The map to update
     * @param array $formdata The associative array of form data
     */
    public static function update_from_formdata(cggm2_map& $map,$formdata)
    {
        if( !is_array($formdata) ) return;

        foreach( $formdata as $key => $value ) {
            try {
                $map->$key = $value;
            }
            catch( Exception $e ) {
                // nothing to do.
            }
        }
    }

    /**
     * @ignore
     */
    private static function map_to_row(cggm2_map& $map)
    {
        $data = array();
        $data[] = $map->get_name();
        $data[] = $map->get_owner_id();
        $data[] = $map->get_data();
        return $data;
    }

    /**
     * @ignore
     */
    private static function &row_to_map($row)
    {
        $obj = new cggm2_map;
        $obj->set_id($row['map_id']);
        $obj->set_name($row['name']);
        $obj->set_owner_id($row['owner_id']);
        $obj->set_data($row['data']);
        return $obj;
    }

    /**
     * @ignore
     */
    private static function _init_data()
    {
        if( self::$_map_tpl != '' ) return;
        $mod = cge_utils::get_module('CGGoogleMaps2');
        self::$_dflt_icon = $mod->GetPreference('default_marker','dd-end');
        self::$_map_tpl = $mod->GetTemplate(CGGM2_PREF_NEWMAP_TEMPLATE);
    }

    /**
     * Load a map given a map id
     *
     * @param int $map_id The integer map id
     * @param bool $deep Wether to load marker and other dependant data
     * @return cggm2_map
     */
    public static function &load_by_id($map_id,$deep = false)
    {
        $res = null;

        if( !isset(self::$_maps[$map_id]) ) {
            $db = cmsms()->GetDb();
            $query = 'SELECT * FROM '.cms_db_prefix().'module_cggooglemaps2 WHERE map_id = ?';
            $row = $db->GetRow($query,array($map_id));
            if( !is_array($row) ) return $res;

            $obj = self::row_to_map($row);
            if( !is_array(self::$_maps) ) self::$_maps = array();
            self::$_maps[$map_id] = $obj;
        }

        if( $deep && !self::$_maps[$map_id]->count_markers() ) cggm2_marker_operations::load_markers_for_map(self::$_maps[$map_id]);
        return self::$_maps[$map_id];
    }

    /**
     * Load a map given a map name
     *
     * @param int $map_name The integer map id
     * @param bool $deep Wether to load marker and other dependant data
     * @return cggm2_map
     */
    public static function &load_by_name($map_name,$deep = false)
    {
        if( (int)$map_name > 0 ) return self::load_by_id($map_name,$deep);

        $out = null;
        $db = cmsms()->GetDb();
        if( !is_array(self::$_map_name_map) ) {
            $query = 'SELECT map_id,name FROM '.cms_db_prefix().'module_cggooglemaps';
            $tmp = $db->GetArray($query);
            if( !is_array($tmp) || count($tmp) == 0 ) return $out;
            self::$_map_name_map = cge_array::to_hash($tmp,'name');
        }

        if( !isset(self::$_map_name_map[$map_name]) ) return $out;
        $id = self::$_map_name_map[$map_name]['map_id'];
        return self::load_by_id($id,$deep);
    }


    /**
     * Delete a map
     *
     * @param cggm2_map $map The map to delete
     */
    public static function delete(cggm2_map& $map)
    {
        $gCms = cmsms();
        $db = $gCms->GetDb();
        $map_id = $map->get_id();

        $query = 'DELETE FROM '.cms_db_prefix().'module_cggooglemaps2_points WHERE map_id = ?';
        $db->Execute($query,array($map_id));

        $query = 'DELETE FROM '.cms_db_prefix().'module_cggooglemaps2 WHERE map_id = ?';
        $db->Execute($query,array($map_id));

        $mod = cms_utils::get_module('CGGoogleMaps2');
        $mod->DeleteTemplate('maptemplate_'.$map_id);
        $mod->DeleteTemplate('mapdirections_'.$map_id);
    }

    /**
     * Insert a map into the database
     *
     * @internal
     * @param cggm2_map $map The map to insert
     * @param bool $deep wether or not to save markers
     * @return bool
     */
    public static function insert(cggm2_map& $map,$deep = true)
    {
        $query = 'INSERT '.cms_db_prefix().'module_cggooglemaps2 (name,owner_id,data) VALUES (?,?,?)';

        $gCms = cmsms();
        $db = $gCms->GetDb();
        $dbr = $db->Execute($query,self::map_to_row($map));
        if( !$dbr ) die($db->sql.'<br/>'.$db->ErrorMsg());
        if( !$dbr ) return FALSE;
        $map_id = $db->Insert_Id();
        $map->set_id($map_id);
        if( $deep ) {
            for( $i = 0; $i < $map->count_markers(); $i++ ) {
                $marker = $map->get_marker_by_idx($i);
                $marker->set_map_id($map_id);
                cggm2_marker_operations::insert($marker);
            }
        }

        $mod = cge_utils::get_module('CGGoogleMaps2');
        $tmp = $map->get_map_template(true);
        if( $tmp ) $mod->SetTemplate('maptemplate_'.$map->get_id(),$tmp);
        $tmp = $map->get_directions_template(true);
        if( $tmp ) $mod->SetTemplate('directionstemplate_'.$map->get_id(),$tmp);

        $query = 'SELECT COUNT(map_id) FROM '.cms_db_prefix().'module_cggooglemaps2';
        $tmp = $db->GetOne($query);
        $mod = cms_utils::get_module('CGGoogleMaps2');
        if( $tmp == 1 ) $mod->SetPreference('default_map',$map_id);
        return TRUE;
    }


    /**
     * Update an existing map record into the database
     *
     * @internal
     * @param cggm2_map $map The map to insert
     * @param bool $deep wether or not to save markers
     * @return bool
     */
    public static function update(cggm2_map& $map,$deep = true)
    {
        $query = 'UPDATE '.cms_db_prefix().'module_cggooglemaps2 SET name = ?, owner_id = ?, data = ? WHERE map_id = ?';
        $gCms = cmsms();
        $db = $gCms->GetDb();
        $tmp = self::map_to_row($map);
        $tmp[] = $map->get_id();
        $dbr = $db->Execute($query,$tmp);
        if( !$dbr ) return FALSE;
        if( $deep ) {
            for( $i = 0; $i < $map->count_markers(); $i++ ) {
                $marker = $map->get_marker_by_idx($i);
                $marker->set_map_id($map_id);
                cggm2_marker_operations::update($marker);
            }
        }

        $mod = cge_utils::get_module('CGGoogleMaps2');
        $tmp = $map->get_map_template(true);
        if( $tmp ) $mod->SetTemplate('maptemplate_'.$map->get_id(),$tmp);
        $tmp = $map->get_directions_template(true);
        if( $tmp ) $mod->SetTemplate('directionstemplate_'.$map->get_id(),$tmp);
        return TRUE;
    }

} // end of class

?>