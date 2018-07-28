<?php
/**
 * A class to represent a marker icon
 *
 * @package CGGoogleMaps2
 * @author Robert Campbell <calguy1000@gmail.com>
 */

/**
 * A class to represent a marker icon
 *
 * @package CGGoogleMaps2
 * @author Robert Campbell <calguy1000@gmail.com>
 */
class cggm2_icon
{
    /**
     * @ignore
     */
    private $_name;

    /**
     * @ignore
     */
    private $_url;

    /**
     * @ignore
     */
    private $_width = '';

    /**
     * @ignore
     */
    private $_height = '';

    /**
     * @ignore
     */
    private $_anchor_x = 'x';

    /**
     * @ignore
     */
    private $_anchor_y = 'x';

    /**
     * @ignore
     */
    private $_info_anchor_x = 'x';

    /**
     * @ignore
     */
    private $_info_anchor_y = 'x';

    /**
     * @ignore
     */
    private $_shadow_icon = '';

    /**
     * @ignore
     */
    private $_shadow_width = '';

    /**
     * @ignore
     */
    private $_shadow_height = '';


    /**
     * Constructor
     *
     * @param string $name The name for this icon
     * @param string $url  The URL to the icon image
     * @param int    $anchor_x
     * @param int    $anchor_y
     * @param int    $info_anchor_x
     * @param int    $info_anchor_y
     */
    public function __construct($name,$url,$anchor_x = 'x',$anchor_y = 'x',
                                $info_anchor_x = 'x',$info_anchor_y = 'x')
    {
        $this->_name = $name;
        $this->_url = $url;
        $this->_anhor_x = $anchor_x;
        $this->_anhor_y = $anchor_y;
        $this->_info_anhor_x = $info_anchor_x;
        $this->_info_anhor_y = $info_anchor_y;
    }


    /**
     * Set the name for this icon
     *
     * @param string $name
     */
    public function set_name($name)
    {
        $this->_name = $name;
    }


    /**
     * Get the name for this icon
     *
     * @return string
     */
    public function get_name()
    {
        return $this->_name;
    }


    /**
     * Set the icon image URL
     *
     * The URL is assumed to be relative to the CMSMS root path.
     *
     * @param string $url
     */
    public function set_url($url)
    {
        $this->_url = $url;
    }


    /**
     * Get the icon image URL
     *
     * @return string
     */
    public function get_url()
    {
        return $this->_url;
    }


    /**
     * Get the image size (given it's URL)
     *
     * The URL is assumed to be relative to the CMSMS root url.
     *
     * @param string $url
     * @return int[]
     */
    protected function _get_image_info($url)
    {
        $gCms = cmsms();
        $config = $gCms->GetConfig();
        $fn = $config['root_path'].'/'.$url;
        if( !file_exists($fn) ) return FALSE;

        $tmp = getimagesize($fn);
        return $tmp;
    }

    /**
     * Set the icon image width
     *
     * @param int $width
     */
    public function set_width($width)
    {
        $this->_width = $width;
    }


    /**
     * Get the icon image width
     *
     * @return int
     */
    public function get_width()
    {
        if( $this->_width == '' || $this->_height == '' ) {
            $tmp = $this->_get_image_info($this->get_url());
            if( $tmp === FALSE ) return FALSE;
            $this->_width = $tmp[0];
            $this->_height = $tmp[1];
        }
        return $this->_width;
    }


    /**
     * Set the icon image height
     *
     * @param int $height
     */
    public function set_height($height)
    {
        $this->_height = $height;
    }

    /**
     * Get the icon image height
     *
     * @return int
     */
    public function get_height()
    {
        if( $this->_width == '' || $this->_height == '' ) {
            $tmp = $this->_get_image_info($this->get_url());
            if( $tmp === FALSE ) return FALSE;
            $this->_width = $tmp[0];
            $this->_height = $tmp[1];
        }
        return $this->_height;
    }

    /**
     * Set the anchor X position (in pixels from the left)
     *
     * @param int $anchor_x
     */
    public function set_anchor_x($anchor_x)
    {
        $this->_anchor_x = $anchor_x;
    }

    /**
     * Get the anchor X position (in pixels from the left)
     *
     * @return int $anchor_x
     */
    public function get_anchor_x()
    {
        return $this->_anchor_x;
    }

    /**
     * Set the anchor Y position (in pixels from the top)
     *
     * @param int $anchor_y
     */
    public function set_anchor_y($anchor_y)
    {
        $this->_anchor_y = $anchor_y;
    }

    /**
     * Get the anchor Y position (in pixels from the top)
     *
     * @return int
     */
    public function get_anchor_y()
    {
        return $this->_anchor_y;
    }

/*
    public function set_info_anchor_y($info_anchor_y)
    {
        $this->_info_anchor_y = $info_anchor_y;
    }


    public function get_info_anchor_y($info_anchor_y)
    {
        return $this->_info_anchor_y;
    }


    public function set_info_anchor_x($info_anchor_x)
    {
        $this->_info_anchor_x = $info_anchor_x;
    }


    public function get_info_anchor_x($info_anchor_x)
    {
        return $this->_info_anchor_x;
    }
*/


    /**
     * Fill this icon from database data stored in an array
     *
     * @internal
     * @param array $data Associative array
     */
    public function from_array($data)
    {
        foreach($data as $key => $value ) {
            if( isset($this->$key) ) $this->$key = $value;
        }
    }

/*
    public function set_shadow_icon($shadow_icon)
    {
        $this->_shadow_icon = $shadow_icon;
    }


    public function get_shadow_icon($shadow_icon)
    {
        return $this->_shadow_icon;
    }


    public function set_shadow_width($shadow_width)
    {
        $this->_shadow_width = $shadow_width;
    }


    public function get_shadow_width()
    {
        if( $this->_shadow_width == '' || $this->_shadow_height == '' ) {
            $tmp = $this->_get_image_info($this->get_shadow_icon());
            if( $tmp === FALSE ) return FALSE;
            $this->_shadow_width = $tmp[0];
            $this->_shadow_height = $tmp[1];
        }
        return $this->_shadow_width;
    }


    public function set_shadow_height($shadow_height)
    {
        $this->_shadow_height = $shadow_height;
    }


    public function get_shadow_height($shadow_height)
    {
        if( $this->_shadow_width == '' || $this->_shadow_height == '' ) {
            $tmp = $this->_get_image_info($this->get_shadow_icon());
            if( $tmp === FALSE ) return FALSE;
            $this->_shadow_width = $tmp[0];
            $this->_shadow_height = $tmp[1];
        }
        return $this->_shadow_height;
    }
*/

} // end of class

?>