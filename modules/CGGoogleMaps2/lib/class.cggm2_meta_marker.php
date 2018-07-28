<?php
/**
 * A marker class that represents multiple locations.
 *
 * This class groups multiple child markers into one location.
 * @package CGGoogleMaps2
 * @author Robert Campbell
 */


/**
 * A marker class that represents multiple locations.
 *
 * This class groups multiple child markers into one location.
 * @package CGGoogleMaps2
 * @author Robert Campbell
 */
class cggm2_meta_marker extends cggm2_marker
{
    /**
     * @ignore
     */
    private $_desc_override;

    /**
     * @ignore
     */
    private $_members;

    /**
     * constructor
     *
     * @param cggm2_marker $marker The first marker in the set
     * @param string $icon The icon name
     */
    public function __construct(cggm2_marker& $marker, $icon = '')
    {
        parent::__construct('meta marker','',$marker->get_latitude(),$marker->get_longitude(),$icon);
        $this->_members = array($marker);
    }

    /**
     * @ignore
     */
    public function set_map_id($map_id)
    {
        throw new Exception('cannot set mapid on meta marker');
    }

    /**
     * @ignore
     */
    public function set_marker_id($map_id)
    {
        throw new Exception('cannot set marker on meta marker');
    }

    /**
     * Set the description for this marker
     *
     * @param string $str The description
     */
    public function set_description($str)
    {
        parent::set_description($str);
        $this->_desc_override = 1;
    }

    /**
     * Return a description for this marker.
     *
     * If a description has not been explicitly set, the description (if any)
     * of the first child marker will be used.
     *
     * @return string
     */
    public function get_description()
    {
        if( $this->_desc_override == 1 ) return parent::get_description();
        return $this->_members[0]->get_description();
    }

    /**
     * Get all of the categories for this marker
     *
     * This is calculated by merging all of the categories from the child markers
     *
     * @param bool $as_array Optionally return the categories as an array
     * @return mixed A comma separated string, or a string[]
     */
    public function get_categories($as_array = false)
    {
        $tmp = array();
        for( $i = 0; $i < count($this->_members); $i++ ) {
            $t1 = $this->_members[$i]->get_categories(true);
            if( is_array($t1) ) $tmp = array_merge($tmp,$this->_members[$i]->get_categories(true));
        }
        $tmp = array_unique($tmp);

        if( !$as_array ) return implode(',',$tmp);
        return $tmp;
    }

    /**
     * Count the number of categories for this marker
     *
     * @return int
     */
    public function count_categories()
    {
        return count($this->get_categories(TRUE));
    }


    /**
     * Test if the marker has the specified category
     *
     * @param string $catname the category name to test
     * @return bool
     */
    public function has_category($catname)
    {
        $tmp = $this->get_categories(TRUE);
        if( in_array($catname,$tmp) ) return TRUE;
        return FALSE;
    }

    /**
     * Populate the marker object from a database array
     *
     * This method is invalid in this object and throws an exception
     */
    public function from_array($data)
    {
        throw new Exception('cannot convert a meta marker from an array');
    }

    /**
     * This method is invalid in this object and throws an exception
     * @param string $addr
     */
    public function set_address($addr)
    {
        throw new Exception('cannot set address on meta marker');
    }

    /**
     * This method is invalid in this object and throws an exception
     *
     */
    public function get_address()
    {
        throw new Exception('cannot get address on meta marker');
    }

    /**
     * This method is invalid in this object and throws an exception
     *
     * @param float $latitude
     * @param float $longitude
     */
    public function set_coords($latitude,$longitude)
    {
        throw new Exception('cannot set coords on meta marker');
    }

    /**
     * This method is invalid in this object and throws an exception
     *
     */
    public function save()
    {
        throw new Exception('invalid operation save on meta marker');
    }

    /**
     * Add a child marker to this meta marker
     *
     * @param cggm2_marker $marker
     * @return void
     */
    public function add_marker(cggm2_marker& $marker)
    {
        $this->_members[] = $marker;
    }

    /**
     * Count the number of child markers for this marker
     *
     * @return int
     */
    public function count_markers()
    {
        return count($this->_members);
    }

    /**
     * Get the Nth marker
     * @param int $i The marker index
     */
    public function get_marker($i)
    {
        if( $i >= 0 && $i < $this->count_markers() ) return $this->_members[$i];
        throw new Exception('attempt to retrieve invalid marker '.$i.' from meta marker');
    }
} // class

?>