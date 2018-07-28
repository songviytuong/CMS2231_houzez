<?php
/**
 * A class to represent a CGGM2 map.
 *
 * @package CGGoogleMaps2
 */

/**
 * A class to represent a CGGM2 map.
 *
 * @package CGGoogleMaps2
 */
final class cggm2_map extends friendly
{
    /**
     * @ignore
     */
    private $_map_id;

    /**
     * @ignore
     */
    private $_name;

    /**
     * @ignore
     */
    private $_owner_id;

    /**
     * @ignore
     */
    private $_data = array();

    /**
     * @ignore
     */
    private static $_types = array();

    /**
     * @ignore
     */
    private $_markers;

    /**
     * @ignore
     */
    private $_kml_files;

    /**
     * @ignore
     */
    private $_unsaved_map_template;

    /**
     * @ignore
     */
    private $_unsaved_directions_template;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->add_friend('cggm2_map_operations,CGGoogleMaps2,cggm2_map');
        if( !count(self::$_types) ) {
            $mod = cge_utils::get_module('CGGoogleMaps2');
            $cggm2_map_fields = array();
            include_once(__DIR__.'/map_fields.dat');
            if( count($cggm2_map_fields) ) {
                foreach( $cggm2_map_fields as $key => &$rec ) {
                    if( !isset($rec['type']) ) $rec['type'] = 'TEXT';
                    switch($rec['type']) {
                    case 'SELECT':
                        $tmp = cge_array::explode_with_key($rec['options'],'=>',',');
                        foreach( $tmp as $k => &$v ) {
                            if( startswith($v,'k:') ) {
                                $t2 = substr($v,2);
                                $v = $mod->Lang($t2);
                            }
                        }
                        $rec['options'] = cge_array::implode_with_key($tmp,'=>',',');
                        break;
                    }
                }
                self::$_types = $cggm2_map_fields;
            }
        }

        if( count(self::$_types) ) {
            // sets some defaults for the member variables.
            foreach( self::$_types as $prop => $info ) {
                if( $prop == 'id' || $prop == 'map_id' ) continue; // no default for you.
                if( isset($info['dflt']) ) $this->$prop = $info['dflt'];
            }
        }
    }


    /**
     * Set the id for this map
     *
     * @internal
     * @ignore
     * @param int $id
     */
    public function set_id($id)
    {
        $this->is_friendly();
        $this->_map_id = (int)$id;
    }


    /**
     * Get the id for this map
     *
     * @return int
     */
    public function get_id()
    {
        return $this->_map_id;
    }


    /**
     * Set the owner ID for this map
     *
     * The owner ID is the integer UID of the admin user who owns this map
     *
     * @param int $owner_id
     */
    public function set_owner_id($owner_id)
    {
        $this->is_friendly();
        $this->_owner_id = (int)$owner_id;
    }


    /**
     * Get the owner ID for this map.
     *
     * @return int
     */
    public function get_owner_id()
    {
        return $this->_owner_id;
    }


    /**
     * Set a name for this map
     *
     * @param string $name
     */
    public function set_name($name)
    {
        $this->is_friendly();
        $this->_name = (string)$name;
    }


    /**
     * Get the name for this map
     *
     * @return string
     */
    public function get_name()
    {
        return $this->_name;
    }


    /**
     * Return the map data (suitable for saving)
     *
     * @internal
     * @return string
     */
    public function get_data()
    {
        $this->is_friendly();
        return serialize($this->_data);
    }


    /**
     * Set the map data
     *
     * @internal
     * @param string $data A serialized array
     */
    public function set_data($data)
    {
        $this->is_friendly();
        if( is_string($data) ) {
            $tmp = unserialize($data);
            if( $tmp && is_array($tmp) ) {
                // todo: check for keys.
                $this->_data = $tmp;
            }
        }
    }


    /**
     * Get the fields for a map
     *
     * @internal
     * @return array
     */
    public function get_fields()
    {
        return self::$_types;
    }


    /**
     * Test if a field exists
     *
     * @param string $key The field name
     * @return bool
     */
    public function field_exists($key)
    {
        if( isset(self::$_types[$key]) ) return TRUE;
        return FALSE;
    }


    /**
     * @ignore
     */
    public function __get($key)
    {
        switch( $key ) {
        case 'name':
            return $this->_name;
        case 'id':
            return $this->_map_id;
        case 'owner_id':
            return $this->_owner_id;
        default:
            if( in_array($key,array_keys(self::$_types)) ) {
                if( isset($this->_data[$key]) ) {
                    return $this->_data[$key];
                }
                else {
                    return;
                }

                $trace = debug_backtrace();
                trigger_error('Undefined property via __get(): '.$key.' in '.$trace[0]['file'].' on line ' . $trace[0]['line'], E_USER_NOTICE);
            }
            break;
        }
    }


    /**
     * @ignore
     */
    public function __set($key,$value)
    {
        switch( $key ) {
        case 'name':
            return $this->set_name($value);
        case 'id':
            return $this->set_id($value);
        case 'owner_id':
            return $this->set_owner_id($value);
        default:
            if( in_array($key,array_keys(self::$_types)) ) {
                // todo: type checking.
                $this->_data[$key] = $value;
                return;
            }

            $trace = debug_backtrace();
            throw new Exception('Undefined property via __set(): '.$key.' in '.$trace[0]['file'].' on line '.$trace[1]['line']);
        }
    }


    /**
     * Save this map
     *
     * @param bool $deep Indicates wether markers and overlays should also be saved
     */
    public function save($deep = false)
    {
        if( empty($this->_map_id) )	return cggm2_map_operations::insert($this,$deep);
        return cggm2_map_operations::update($this,$deep);
    }


    /**
     * Add a KML file overlay to this map
     *
     * @param string $href  The URL to the KML file
     */
    public function add_kml($href)
    {
        if( !is_array($this->_kml_files) ) $this->_kml_files = array();
        $this->_kml_files[] = $href;
    }

    /**
     * Return the list of KML files attached to this map
     *
     * @return string[]
     */
    public function get_kml_files()
    {
        if( !is_array($this->_kml_files) || count($this->_kml_files) == 0 ) return;
        return $this->_kml_files;
    }


    /**
     * Generate a unique marker name, given a title
     *
     * @internal
     * @param string $title The marker title
     * @return string
     */
    protected function generate_marker_name($title)
    {
        // clean the title
        $name = munge_string_to_url($title);
        $name = str_replace('-','_',$name);
        $tmp = '';
        $n = 0;
        while( $n < 10 ) {
            $tmp = str_replace('__','_',$name);
            if( $tmp == $name ) break;
            $name = $tmp;
            $n++;
        }

        // generate an unused name.
        $n = 1;
        $tmp = $name;
        while( isset($this->_markers[$tmp]) && $n < 100 ) {
            $n++;
            $tmp = $name.'_'.$n;
        }
        $name = $tmp;

        if( $n == 100 ) return FALSE;
        return $name;
    }


    /**
     * Add a marker to this map
     *
     * @param cggm2_marker $marker
     * @return mixed  The marker name, or FALSE
     */
    public function add_marker(cggm2_marker& $marker)
    {
        if( !is_array($this->_markers) ) $this->_markers = array();

        $name = $this->generate_marker_name($marker->get_title());
        if( !$name ) return FALSE;
        $this->_markers[$name] = $marker;
        return $name;
    }


    /**
     * Remove a marker from the map
     *
     * @param string $name The marker name
     * @return bool
     */
    public function delete_marker($name)
    {
        if( !is_array($this->_markers) ) return FALSE;
        if( !isset($this->_markers[$name]) ) return FALSE;
        unset($this->_markers[$name]);
        return TRUE;
    }

    /**
     * Remove markers that have not been saved
     */
    public function delete_unsaved_markers()
    {
        if( !is_array($this->_markers) ) return FALSE;
        foreach( $this->_markers as $name => $obj ) {
            if( $obj->get_marker_id() > 0 ) continue;
            unset($this->_markers[$name]);
        }
    }

    /**
     * Get the Nth marker
     *
     * @param int $idx The marker index
     * @return cggm2_marker
     */
    public function &get_marker_by_idx($idx)
    {
        $this->is_friendly();
        if( !is_array($this->_markers) ) return;
        if( $idx >= count($this->_markers) || $idx < 0 ) return;

        $tmp = $trace = debug_backtrace();
        if(isset($trace[1]['class']) && $trace[1]['class'] == 'cggm2_map_operations') {
            return $this->_markers[$idx];
        }
    }


    /**
     * Get the marker by it's integer ID (for saved markers only)
     *
     * @param int $marker_id
     * @return cggm2_marker
     */
    public function &get_marker_by_id($marker_id)
    {
        if( !is_array($this->_markers) ) return FALSE;
        foreach( $this->_markers as $name => $marker ) {
            if( $marker->get_marker_id() == $marker_id ) return $marker;
        }
        return FALSE;
    }


    /**
     * Get a marker by it's name
     *
     * @param string $name
     * @return cggm2_marker
     */
    public function &get_marker_by_name($name)
    {
        if( !is_array($this->_markers) ) return FALSE;
        if( !isset($this->_markers[$name]) ) return FALSE;
        return $this->_markers[$name];
    }


    /**
     * Get a list of marker names
     *
     * @return string[]
     */
    public function get_marker_names()
    {
        if( !is_array($this->_markers) ) return FALSE;
        return array_keys($this->_markers);
    }


    /**
     * Count the number of markers associated with this map
     *
     * @return int
     */
    public function count_markers()
    {
        return count($this->_markers);
    }


    /**
     * Get the name of the map template, suitable for passing to smarty
     *
     * @internal
     * @return string
     */
    public function get_map_template_name()
    {
        $name = 'maptemplate_'.$this->_map_id;
        return $name;
    }

    /**
     * Get the map template
     *
     * @param bool $unsaved Wether to return the unsaved map template (if one exists)
     * @return string
     */
    public function get_map_template($unsaved = false)
    {
        $mod = cge_utils::get_module('CGGoogleMaps2');
        if( $this->_unsaved_map_template ) return $this->_unsaved_map_template;

        if( $unsaved ) return;
        if( $this->_map_id ) {
            $txt = $mod->GetTemplate($this->get_map_template_name());
            return $txt;
        }
        else {
            $fn = dirname(__DIR__).'/templates/orig_map_template.tpl';
            return file_get_contents($fn);
        }
    }

    /**
     * Set the map template
     *
     * @param string $data The map template
     */
    public function set_map_template($data)
    {
        $this->_unsaved_map_template = $data;
    }

    /**
     * Get the name of the directions template (suitable for passing to smarty)
     *
     * @return string
     */
    public function get_directions_template_name()
    {
        $name = 'directionstemplate_'.$this->_map_id;
        return $name;
    }

    /**
     * Get the directions template
     *
     * @param bool $unsaved return the unsaved template, if any
     * @return string
     */
    public function get_directions_template($unsaved = false)
    {
        $mod = cge_utils::get_module('CGGoogleMaps2');
        if( $this->_unsaved_directions_template ) return $this->_unsaved_directions_template;

        if( $unsaved ) return;
        if( $this->_map_id ) {
            $txt = $mod->GetTemplate($this->get_directions_template_name());
            return $txt;
        }
        else {
            $fn = dirname(__DIR__).'/templates/orig_directions_template.tpl';
            return file_get_contents($fn);
        }
    }

    /**
     * Set the directions template
     *
     * @param string $data The template data
     */
    public function set_directions_template($data)
    {
        $this->_unsaved_directions_template = $data;
    }

} // end of class

?>