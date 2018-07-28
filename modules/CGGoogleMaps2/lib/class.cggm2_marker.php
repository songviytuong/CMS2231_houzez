<?php
#
#
#

/**
 * CGGoogleMaps2\cggm2_marker.
 * @package CGGoogleMaps2
 */

/**
 * A class to encapsulate a map marker.
 * @package CGGoogleMaps2
 */
class cggm2_marker
{
    /**
     * @ignore
     */
    private $_marker_id;

    /**
     * @ignore
     */
    private $_map_id;

    /**
     * @ignore
     */
    private $_title;

    /**
     * @ignore
     */
    private $_description;

    /**
     * @ignore
     */
    private $_address;

    /**
     * @ignore
     */
    private $_lat;

    /**
     * @ignore
     */
    private $_long;

    /**
     * @ignore
     */
    private $_icon;

    /**
     * @ignore
     */
    private $_tooltip;

    /**
     * @ignore
     */
    private $_categories;

    /**
     * @ignore
     */
    private $_static = FALSE;

  /**
   * Constructor.
   *
   * Either an address OR latitude and longitude must be provided.
   *
   * @param string $title The marker title (optional).
   * @param string $address An address compatible with google geolocation service.
   * @param float  $lat The latitude.
   * @param float  $long The longitude.
   * @param string $icon The name of an icon (the name must be registered in the CGGoogleMaps2 module.
   */
  public function __construct($title = null,$address = '',$lat = '',$long = '',$icon = '')
  {
      $address = trim($address);
      $title = trim($title);

      $this->_title   = $title;
      $this->_address = $address;
      $this->_lat     = $lat;
      $this->_long    = $long;
      $this->_icon    = $icon;  // should look this up somehow.
  }

  /**
   * Set the static flag
   *
   * @param bool $flag
   * @return void
   */
  public function set_static($flag = TRUE)
  {
    $this->_static = (bool)$flag;
  }

  /**
   * Tests if this is a static marker
   *
   * @return bool
   */
  public function is_static()
  {
      return $this->_static;
  }

  /**
   * Set the marker ID
   *
   * For dynamic points this will be null.  For static points associated with a map
   * this will be a positive integer.
   *
   * @internal
   * @ignore
   * @param int $marker_id
   */
  public function set_marker_id($marker_id)
  {
      $this->_marker_id = $marker_id;
  }

  /**
   * Get the marker id
   *
   * For dynamic points this will be null.  For static points associated with a map
   * this will be a positive integer.
   *
   * @return int
   */
  public function get_marker_id()
  {
      return $this->_marker_id;
  }

  /**
   * Set the ID of the map that this marker is associated with
   *
   * @internal
   * @ignore
   * @param int $map_id
   */
  public function set_map_id($map_id)
  {
      $this->_map_id = $map_id;
  }

  /**
   * Get the ID of the map that this marker is associated with
   *
   * @return int
   */
  public function get_map_id()
  {
      return $this->_map_id;
  }

  /**
   * Get the title for this marker
   *
   * @return string
   */
  public function get_title()
  {
      return $this->_title;
  }

  /**
   * Set the title for this marker
   *
   * @param string $title
   */
  public function set_title($title)
  {
      $this->_title = $title;
  }

  /**
   * Set the description for this marker.
   *
   * @param string $description
   */
  public function set_description($description)
  {
      $this->_description = $description;
  }

  /**
   * Get the description for this marker.
   *
   * @return string
   */
  public function get_description()
  {
      return $this->_description;
  }

  /**
   * Set the description for this marker.
   *
   * @param string $description
   */
  public function set_desc($description)
  {
      $this->_description = $description;
  }

  /**
   * Get the description for this marker.
   *
   * @return string
   */
  public function get_desc()
  {
      return $this->_description;
  }

  /**
   * Set the address for this marker
   *
   * If a valid address is given, the latitude and longitude will be erased.
   *
   * @param string $addr An address that can be understood by google's geolocate service
   */
  public function set_address($addr)
  {
      if( $addr != '' ) {
          $this->_address = $addr;
          $this->_lat = '';
          $this->_long = '';
      }
  }

  /**
   * Get the address for this marker (if any)
   *
   * @return string
   */
  public function get_address()
  {
      return $this->_address;
  }

  /**
   * Set the coordinates for this marker
   *
   * If valid coodrinates are specified, the address will be erased.
   *
   * @param float $latitude The latitude (between -180.0 and +180.0)
   * @param float $longitude The longitude (between -180.0 and +180.0)
   */
  public function set_coords($latitude,$longitude)
  {
      if( $latitude != '' && $longitude != '' ) {
          $this->_address = '';
          $this->_lat = (float)$latitude;
          $this->_long = (float)$longitude;
      }
  }

  /**
   * Return the latitude if any, for this marker.
   *
   * @return float
   */
  public function get_latitude()
  {
      return (float)$this->_lat;
  }

  /**
   * Return the longitude if any, for this marker.
   *
   * @return float
   */
  public function get_longitude()
  {
      return (float)$this->_long;
  }

  /**
   * Set the icon for this marker
   *
   * The icon name must be registered with the CGGoogleMaps2 module.
   *
   * @param string $icon
   */
  public function set_icon($icon)
  {
      $this->_icon = $icon;
  }

  /**
   * Return the icon for this marker
   *
   * @return string
   */
  public function get_icon()
  {
      return $this->_icon;
  }

  /**
   * Set (or erase) a tooltip for this marker
   *
   * @param string $tooltip
   */
  public function set_tooltip($tooltip)
  {
      if( !$tooltip ) {
          $this->_tooltip = null;
      }
      else {
          $this->_tooltip = $tooltip;
      }
  }

  /**
   * Return the tooltip for this marker
   *
   * @return string
   */
  public function get_tooltip()
  {
      return $this->_tooltip;
  }


  /**
   * Add a category to this marker
   *
   * @param string $category
   */
  public function add_category($category)
  {
      if( !is_array($this->_categories) )	$this->_categories = array();
      if( !is_array($category) ) $category = explode(',',$category);
      $this->_categories = array_unique(array_merge($this->_categories,$category));
  }

  /**
   * Count the number of categories that this marker has
   *
   * @return int
   */
  public function count_categories()
  {
    return count($this->_categories);
  }

  /**
   * Get the categories for this marker
   *
   * @param bool $as_array Optionally return the categories as an array
   * @return mixed A comma separated list of categories, or an array of strings.
   */
  public function get_categories($as_array = false)
  {
    if( is_array($this->_categories) ) {
      if( $as_array ) return $this->_categories;
      return implode(',',$this->_categories);
    }
  }

  /**
   * Test if the marker has the specified category
   *
   * @param string $catname the category name to test
   * @return bool
   */
  public function has_category($catname)
  {
    if( !is_array($this->_categories) ) return FALSE;
    if( !$catname ) return FALSE;

    if( !is_array($catname) ) $catname = explode(',',$catname);
    foreach( $catname as $one ) {
      if( in_array($catname,$this->_categories) ) return TRUE;
    }
    return FALSE;
  }

  /**
   * Populate the marker object from a database array
   *
   * @internal
   * @return void
   */
  public function from_array($data)
  {
    if( isset($data['map_id']) ) $this->set_map_id($data['map_id']);
    if( isset($data['marker_id']) ) $this->set_marker_id($data['marker_id']);
    if( isset($data['name']) ) {
      $this->set_title($data['name']);
    }
    else {
      $this->set_title($data['title']);
    }
    $this->set_desc($data['info']);
    $this->set_tooltip($data['tooltip']);
    $this->set_address($data['address']);
    if( isset($data['latitude']) && isset($data['longitude']) && $data['latitude'] != $data['longitude'] ) {
      $this->set_coords($data['latitude'],$data['longitude']);
    }
    else if( isset($data['lat']) && isset($data['lon']) && $data['lat'] != $data['lon'] ) {
      $this->set_coords($data['lat'],$data['lon']);
    }
    $this->set_icon($data['icon']);
    if( isset($data['categories']) ) $this->add_category($data['categories']);
  }

  /**
   * Save this marker
   *
   * @return void
   */
  public function save()
  {
    if( !$this->_marker_id ) {
      return cggm2_marker_operations::insert($this);
    }
    else {
      return cggm2_marker_operations::update($this);
    }
  }

} // end of class

?>