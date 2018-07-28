<?php

/**
 * A class for generating the HTML and javascript needed for generating a map.
 *
 * Given a cggm2_map object this class will generate the javascript data suitable for use by the cggm2 jquery plugin.
 * @package CGGoogleMaps2
 */

/**
 * A class for generating the HTML and javascript needed for generating a map.
 *
 * Given a cggm2_map object this class will generate the javascript data suitable for use by the cggm2 jquery plugin.
 * @package CGGoogleMaps2
 */
class cggm2_map_generator
{
    /**
     * @ignore
     */
    private $_map;

    /**
     * @ignore
     */
    private $_defer;

    /**
     * @ignore
     */
    private $_api_ver = '3.s';

    /**
     * @ignore
     */
    private $_all_icons = FALSE;

    /**
     * @ignore
     */
    private $_markers = array();        // a list of all displayable marker objects (after combining points)

    /**
     * @ignore
     */
    private $_icon_names = array();     // a list of all used icons

    /**
     * @ignore
     */
    private $_icons = array();          // an array of use icon objects

    /**
     * @ignore
     */
    private $_meta = array();           // calculated metadata

    /**
     * @ignore
     */
    private $_errors = array();         // errors

    /**
     * @ignore
     */
    private static $_instance = 0;      // instance generator.

    /**
     * Constructor.
     *
     * @param cggm2_map $map The map definition to generate output for
     * @param boolean $defer  Wether the defer attribute should be used on the output javascript
     */
    public function __construct(cggm2_map& $map,$defer = false)
    {
        self::$_instance++;
        $this->_map = $map;
        $this->_defer = $defer;
    }

    /**
     * Return the errors (if any) found when generating this map
     *
     * @return string[]
     */
    public function get_errors()
    {
        if( !count($this->_errors) ) return;
        return $this->_errors;
    }

    /**
     * @ignore
     */
    private function _calc_coords_meta()
    {
        if( count($this->_markers) ==  0 ) return;
        if( isset($this->_meta['center_lat']) ) return;

        // calculate minimum/maximum lat/long
        $min_lat = 9999999.9;
        $min_lon = 9999999.9;
        $max_lat = -9999999.9;
        $max_lon = -9999999.9;
        foreach( $this->_markers as $marker_name => $marker ) {
            $min_lat = (float)min($marker->get_latitude(),$min_lat);
            $min_lon = (float)min($marker->get_longitude(),$min_lon);
            $max_lat = (float)max($marker->get_latitude(),$max_lat);
            $max_lon = (float)max($marker->get_longitude(),$max_lon);
        }
        // adjust min/max lat/long by bounds fudge
        $diff_lat = $max_lat - $min_lat;
        $diff_lon = $max_lon - $min_lon;
        $min_lat -= $diff_lat * (float)$this->_map->bounds_fudge;
        $min_lon -= $diff_lon * (float)$this->_map->bounds_fudge;
        $max_lat += $diff_lat * (float)$this->_map->bounds_fudge;
        $max_lon += $diff_lon * (float)$this->_map->bounds_fudge;

        // calculate the center.
        $center_lat = $min_lat + ($max_lat - $min_lat) / 2.0;
        $center_lon = $min_lon + ($max_lon - $min_lon) / 2.0;

        $this->_meta['min_lat'] = (float)$min_lat;
        $this->_meta['min_lon'] = (float)$min_lon;
        $this->_meta['max_lat'] = (float)$max_lat;
        $this->_meta['max_lon'] = (float)$max_lon;
        $this->_meta['center_lat'] = (float)$center_lat;
        $this->_meta['center_lon'] = (float)$center_lon;
    }

    /**
     * Set a flag to indicate wether the system should export all known icons
     * to javascript, or merely the known icons
     *
     * @param bool $flag
     */
    public function set_all_icons($flag = TRUE)
    {
        $this->_all_icons = $flag;
    }

    /**
     * Prepare all map markers for output
     *
     * This method will make sure that all markers have coordinates
     * and that (if enabled in the map) markers that are near eachother
     * are combined into a meta marker.
     */
    protected function prepare_markers()
    {
        $map = $this->_map;
        $mod = cge_utils::get_module('CGGoogleMaps2');
        $this->_markers = array();
        $input_names = $map->get_marker_names();
        if( !$input_names ) return;

        // first pass.. make sure we have lat/longs
        $lookups = array();
        foreach( $input_names as $marker_name ) {
            $marker = $map->get_marker_by_name($marker_name);
            if( $marker->get_latitude() == '' || $marker->get_longitude() == '' ) {
                $lookups[] = $marker->get_address();
            }
        }

        $multiple_coords = null;
        if( is_array($lookups) && count($lookups) ) {
            $multiple_coords = cggm2_address_lookup::lookup_multiple($lookups);
        }

        foreach( $input_names as $marker_name ) {
            // get the marker.
            $marker = $map->get_marker_by_name($marker_name);

            // make sure it has an icon
            if( $marker->get_icon() == '' || $marker->get_icon() == -1 ) $marker->set_icon($map->default_icon);
            if( !in_array($marker->get_icon(),$this->_icon_names) ) $this->_icon_names[] = $marker->get_icon();

            // grab a lat/long for this marker if necessary.
            if( $marker->get_latitude() == '' || $marker->get_longitude() == '' ) {
                if( isset($multiple_coords[$marker->get_address()]) ) {
                    $coords = $multiple_coords[$marker->get_address()];
                    $marker->set_coords($coords[0],$coords[1]);
                }
                else {
                    audit('','CGGoogleMaps2','Maker with address '.$marker->get_address().' skipped (geolocate failed)');
                    continue;
                }
            }

            // handle combined points
            if( $map->combine_points && $map->point_combine_fudge > 0.000 ) {
                $merged = false;
                foreach( $this->_markers as $m_name => &$m_info ) {
                    $box_toplat = $m_info->get_latitude() - $map->point_combine_fudge;
                    $box_toplon = $m_info->get_longitude() - $map->point_combine_fudge;
                    $box_botlat = $m_info->get_latitude() + $map->point_combine_fudge;
                    $box_botlon = $m_info->get_longitude() + $map->point_combine_fudge;
                    if( $marker->get_latitude() >= $box_toplat && $marker->get_latitude() <= $box_botlat &&
                        $marker->get_longitude() >= $box_toplon && $marker->get_longitude() <= $box_botlon ) {
                        // gotta combine this marker with an existing one.
                        if( !$m_info instanceof cggm2_meta_marker ) {
                            $m_info = new cggm2_meta_marker($m_info,$map->combined_icon);
                            $m_info->set_title($mod->Lang('title_combined_marker'));
                        }
                        $m_info->add_marker($marker);
                        // done merging;
                        $merged = true;
                        break;
                    }
                }
                if( $merged ) {
                    // done merging;
                    continue;
                }
            }

            $this->_markers[$marker_name] = $marker;
        }
    }

    /**
     * Provide information about KML overlays, and other minor information
     * to smarty.
     */
    protected function generate_map_data()
    {
        $defertxt = '';
        $mod = cge_utils::get_module('CGGoogleMaps2');
        if( $this->_defer ) $defertxt = ' defer="defer"';
        $smarty = $mod->smarty;
        $smarty->assign('map_defertxt',$defertxt);
        $kml_files = $this->_map->get_kml_files();
        if( is_array($kml_files) && count($kml_files) ) {
            $smarty->assign('kml_files',$kml_files);
        } else {
            $smarty->assign('kml_files','');
        }
    }

    /**
     * Convert the marker data into a flat array that is suitable
     * for export to javascript or smarty
     *
     * @return array
     */
    protected function _get_markers_as_data()
    {
        $_fix_coord = function($num) {
            return (float) number_format($num,6,'.','');
        };

        $out = array();
        foreach( $this->_markers as $name => $marker ) {
            $rec = array();
            $rec['name'] = $name;
            $rec['position'] = array($_fix_coord($marker->get_latitude()),$_fix_coord($marker->get_longitude()));
            if( $marker->get_icon() ) $rec['icon'] = $marker->get_icon();
            if( $marker->get_title() ) $rec['title'] = htmlspecialchars($marker->get_title(),ENT_QUOTES);
            if( $marker->get_tooltip() ) $rec['tooltip'] = htmlspecialchars($marker->get_tooltip(),ENT_QUOTES);
            if( $marker->get_description() ) $rec['bubbletext'] = addslashes($marker->get_description());
            $out[] = $rec;
        }
        return $out;
    }

    /**
     * Generate the html, and javascript to draw the map
     *
     * This method uses the template associated with the map
     *
     * @return string
     */
    protected function generate_map()
    {
        $template = $this->_map->get_map_template_name();
        if( $template ) {
            $mod = cge_utils::get_module('CGGoogleMaps2');
            $output = $mod->ProcessTemplateFromDatabase($template);
            return $output;
        }
    }

    /**
     * Generate the map
     *
     * @return string
     */
    public function generate()
    {
        $map = $this->_map;
        $mod = cge_utils::get_module(MOD_CGGOOGLEMAPS2);
        $smarty = $mod->smarty;
        $smarty->assign('apikey',$mod->GetPreference('apikey'));
        $smarty->assign('map',$this->_map);
        $smarty->assign('mapinstance',self::$_instance);
        $smarty->assign('generator',$this);

        // parse through the markers, cleaning up icons if necessary.
        $this->prepare_markers();

        $smarty->assign('icon_base_url',$mod->GetModuleURLPath().'/icons');

        // and put it all together
        $output = $this->generate_map();
        return $output;
    }

    /**
     * Get the count of all markers
     *
     * @return int
     */
    public function get_marker_count()
    {
        return count($this->_markers);
    }

    /**
     * Calculate the center latitude of all markers
     *
     * This method should probably be called after prepare_markers
     *
     * @return string A formatted string (suitable for use IN HTML)
     */
    public function get_center_lat()
    {
        if( $this->_map->center_lat != '' ) return $this->_map->center_lat;

        $this->_calc_coords_meta();
        $val = 0;
        if( isset($this->_meta['center_lat']) ) $val = $this->_meta['center_lat'];
        return number_format($val,6,'.',',');
    }

    /**
     * Calculate the center longitude of all markers
     *
     * This method should probably be called after prepare_markers
     *
     * @return string A formatted string (suitable for use IN HTML)
     */
    public function get_center_lon()
    {
        if( $this->_map->center_lon != '' ) return $this->_map->center_lon;

        $this->_calc_coords_meta();
        $val = 0;
        if( isset($this->_meta['center_lon']) ) $val = $this->_meta['center_lon'];
        return number_format($val,6,'.',',');
    }

    /**
     * Get the minumum latitude of all markers
     * This method should probably be called after prepare_markers
     *
     * @return string A formatted string (suitable for use IN HTML)
     */
    public function get_min_lat()
    {
        $this->_calc_coords_meta();
        return number_format($this->_meta['min_lat'],6,'.',',');
    }

    /**
     * Get the minumum longitude of all markers
     * This method should probably be called after prepare_markers
     *
     * @return string A formatted string (suitable for use IN HTML)
     */
    public function get_min_lon()
    {
        $this->_calc_coords_meta();
        return number_format($this->_meta['min_lon'],6,'.',',');
    }

    /**
     * Get the maximum latitude of all markers
     *
     * This method should probably be called after prepare_markers
     *
     * @return string A formatted string (suitable for use IN HTML)
     */
    public function get_max_lat()
    {
        $this->_calc_coords_meta();
        return number_format($this->_meta['max_lat'],6,'.',',');
    }

    /**
     * Get the maximum longitude of all markers
     *
     * This method should probably be called after prepare_markers
     *
     * @return string A formatted string (suitable for use IN HTML)
     */
    public function get_max_lon()
    {
        $this->_calc_coords_meta();
        return number_format($this->_meta['max_lon'],6,'.',',');
    }


    /**
     * Convert the map type to a string understandable by google.
     */
    public function get_google_maptype()
    {
        switch($this->_map->type) {
        case 'map':
            return 'ROADMAP';
            break;
        case 'satellite':
        case 'terrain':
        case 'hybrid':
            return strtolower($this->_map->type);
        }
    }

    /**
     * @ignore
     */
    private function _array_to_jsarray($in)
    {
        $data = array();
        foreach( $in as $val ) {
            if( $val == '' ) continue;

            $datatype = gettype($val);
            switch( $datatype ) {
            case 'boolean':
                $data[] = (bool)$val;
                continue;

            case 'integer':
                $data[] = (int)$val;
                continue;

            case 'double':
                $data[] = (double)$val;
                continue;

            case 'string':
                if( ($val == 'true' || $val == 'TRUE' || $val == 'false' || $val == 'FALSE') ) {
                    $data[] = (bool)$val;
                }
                else {
                    if( !startswith($val,"'") && !startswith($val,'"') ) {
                        $data[] = "'".$val."'";
                    }
                    else {
                        $data[] = $val;
                    }
                }
                continue;

            case 'array':
                if( cge_array::is_hash($val) ) {
                    $data[] = $this->_hash_to_jsobj($val);
                }
                else {
                    $data[] = $this->_array_to_jsarray($val);
                }
                continue;

            case 'object':
            case 'NULL':
            default:
                // do nothing
                continue;
            }
        }

        return '[ '.implode(',',$data).' ]';
    }

    /**
     * @ignore
     */
    private function _hash_to_jsobj($in)
    {
        $data = array();
        foreach( $in as $fld => $val ) {
            if( $val == '' ) continue;

            $datatype = gettype($val);
            switch( $datatype ) {
            case 'boolean':
                $data["'".$fld."'"] = (bool)$val;
                continue;

            case 'integer':
                $data["'".$fld."'"] = (int)$val;
                continue;

            case 'double':
                $data["'".$fld."'"] = (double)$val;
                continue;

            case 'string':
                if( ($val == 'true' || $val == 'TRUE' || $val == 'false' || $val == 'FALSE') ) {
                    $data["'".$fld."'"] = (bool)$val;
                }
                elseif( (int)$val != 0 || $val === '0' ) {
                    $data["'".$fld."'"] = (int)$val;
                }
                else {
                    if( !startswith($val,"'") && !startswith($val,'"') ) {
                        $val = nl2br($val);
                        $val = str_replace("\r\n",'',$val);
                        $val = str_replace("\r",'',$val);
                        $val = str_replace("\n",'',$val);
                        $data["'".$fld."'"] = "'".$val."'";
                    }
                    else {
                        $val = nl2br($val);
                        $val = str_replace("\r\n",'',$val);
                        $val = str_replace("\r",'',$val);
                        $val = str_replace("\n",'',$val);
                        $data["'".$fld."'"] = $val;
                    }
                }
                continue;

            case 'array':
                if( cge_array::is_hash($val) ) {
                    $data["'".$fld."'"] = $this->_hash_to_jsobj($val);
                }
                else {
                    $data["'".$fld."'"] = $this->_array_to_jsarray($val);
                }
                continue;

            case 'object':
            case 'NULL':
            default:
                // do nothing
                continue;
            }
        }

        $out = '{ '.cge_array::implode_with_key($data,': ',',').' }';
        return $out;
    }

    /**
     * Convert the map data into a javascript object compatible with the cggm2 jquery plugin
     *
     * This method is normally called from within the map template
     *
     * @return string The javascript object.
     */
    public function get_map_options_js()
    {
        $data = array();
        $fields = $this->_map->get_fields();
        foreach( array_keys($fields) as $fld ) {
            $val = $this->_map->$fld;
            if( $val == '' ) continue;
            if( is_string($val) && is_numeric($val) ) {
                if( (string)(int)$val == $val ) $val = (int) $val;
            }
            $data[$fld] = $val;
        }

        $mod = cge_utils::get_module('CGGoogleMaps2');
        $data['markers'] = $this->_get_markers_as_data();
        $data['youareherestr'] = $mod->Lang('youarehere');
        $data["mapinstance"] = self::$_instance;
        $data['center'] = [ $this->get_center_lat(), $this->get_center_lon() ];
        if( !in_array($this->_map->default_icon,$this->_icon_names) ) $this->_icon_names[] = $this->_map->default_icon;
        if( !in_array($this->_map->sensor_icon,$this->_icon_names) ) $this->_icon_names[] = $this->_map->sensor_icon;
        if( !in_array($this->_map->combined_icon,$this->_icon_names) ) $this->_icon_names[] = $this->_map->combined_icon;
        if( (is_array($this->_icon_names) && count($this->_icon_names)) || $this->_all_icons ) {
            // get the info for these icons by name
            $db = cmsms()->GetDb();
            $query = '';
            if( $this->_all_icons ) {
                $query = 'SELECT name,url,anchor_x,anchor_y FROM '.cms_db_prefix().'module_cggooglemaps2_icons';
            }
            else {
                $query = 'SELECT name,url,anchor_x,anchor_y FROM '.cms_db_prefix().'module_cggooglemaps2_icons WHERE name IN (';
                $query .= cge_array::implode_quoted($this->_icon_names,',',"'");
                $query .= ')';
            }
            $dbr = $db->GetArray($query);
            $data['icons'] = cge_array::to_hash($dbr,'name');
        }
        $kml_files = $this->_map->get_kml_files();
        if( is_array($kml_files) && count($kml_files) ) $data['kml'] = $kml_files;

        //$out = $this->_hash_to_jsobj($data);
        $out = json_encode($data);
        return $out;
    }

    /**
     * Get the directions form
     *
     * Normally called from within the map template
     *
     * @return string The HTML of the directions form
     */
    public function get_directions_form()
    {
        if( !$this->_map->directions ) return;
        $mod = cms_utils::get_module(MOD_CGGOOGLEMAPS2);
        return $mod->ProcessTemplateFromDatabase($this->_map->get_directions_template_name());
    }
} // end of class

?>