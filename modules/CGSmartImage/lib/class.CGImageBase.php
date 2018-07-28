<?php
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: CGSmartImage (c) 2011 by Robert Campbell (calguy1000@cmsmadesimple.org)
#
#  An addon module for CMS Made Simple to allow creating image tags in a smart
#  way to optimize performance.
#
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2005-2010 by Ted Kulp (wishy@cmsmadesimple.org)
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

class CGImageBase implements ArrayAccess
{
    private $_transparent;
    private $_savealpha; // indicates that the image should be saved with alpha channels
    private $_rsrc;
    private $_srcname;
    private $_dirty;
    private $_info;
    private static $_keys = array('dirty','rsrc','width','height','type','filename','name','transparent','savealpha');

    private function create_new_rsrc($mimetype,$width,$height)
    {
        switch( $mimetype ) {
        case 'image/jpeg':
            $_rsrc = imagecreatetruecolor($width,$height);
            return $_rsrc;

        case 'image/png':
            // from supersizer
            $_rsrc = imagecreatetruecolor($width, $height);
            $color = imagecolorallocatealpha($_rsrc, 0, 0, 0, 127);
            imagecolortransparent($_rsrc,$color);
            $this->_transparent = $color;
            return $_rsrc;

        case 'image/gif':
            $_rsrc = imagecreatetruecolor($width, $height);
            imagetruecolortopalette($_rsrc, true, 256);
            imagealphablending($_rsrc, false);
            imagesavealpha($_rsrc,true);
            $transparent = imagecolorallocatealpha($_rsrc, 255, 255, 255, 127);
            imagefilledrectangle($_rsrc, 0, 0, $width, $height, $transparent);
            imagecolortransparent($_rsrc, $transparent);
            return $_rsrc;

        default:
            throw new Exception('Cannot create new image of type '.$mimetype);
        }
    }

    public function __construct($input)
    {
        if( is_object($input) && $input instanceof CGImageBase  ) {
            // copy constructor
            $this->_savealpha = $input->_savealpha;
            $this->_transparent = $input->_transparent;
            $this->_rsrc = $input->_rsrc;
            $this->_srcname = $input->_srcname;
            $this->_info = $input->_info;
            $this->_dirty = 1;
        }
        else if( is_string($input) && is_readable($input) && is_file($input) ) {
            $data = file_get_contents($input);
            if( $data !== FALSE ) {
                $this->_rsrc = imagecreatefromstring($data);
                $this->_srcname = $input;
                $this->_info = getimagesize($input);
                $tmp = imagecolortransparent($this->_rsrc);
                if( $tmp != -1 ) $this->_transparent = $tmp;
                $this->_info[2] = image_type_to_mime_type($this->_info[2]);
                return;
            }
            throw new Exception('Problem creating new CGImageBase object from '.$input);
        }
        else if( is_array($input) && count($input) >= 3 ) {
            $this->_rsrc = $this->create_new_rsrc($input[0],$input[1],$input[2]);
            $this->_info = array($input[1],$input[2],$input[0]);
            $this->_dirty = 1;
        }
        else {
            throw new Exception('Attempt to create a CGImageBase object with invalid input');
        }
    }


    public function offsetExists($k)
    {
        return in_array($k,CGImageBase::$_keys);
    }


    public function offsetUnset($k)
    {
        throw new Exception('Attempt to unset an attribute of a CGImageBase object');
    }

    public function offsetGet($k)
    {
        $k = strtolower($k);
        if( !in_array($k,CGImageBase::$_keys) )
            throw new Exception('Attempt to get invalid attribute '.$k.' From CGImageBase');

        switch( $k ) {
        case 'rsrc':
            return $this->_rsrc;
            break;

        case 'width':
            if( !is_array($this->_info) ) throw new Exception('Attempt to get information on uninitialized object');
            return $this->_info[0];
            break;

        case 'height':
            if( !is_array($this->_info) ) throw new Exception('Attempt to get information on uninitialized object');
            return $this->_info[1];
            break;

        case 'type':
            if( !is_array($this->_info) ) throw new Exception('Attempt to get information on uninitialized object');
            return $this->_info[2];
            break;

        case 'dirty':
            return $this->_dirty;
            break;

        case 'transparent':
            return $this->_transparent;
            break;

        case 'savealpha':
            return $this->_savealpha;

        case 'filename':
        case 'name':
            return $this->_srcname;
            break;
        }
    }


    public function offsetSet($k,$v)
    {
        if( !in_array($k,CGImageBase::$_keys) ) throw new Exception('Invalid Attempt to modify the attribute of CGImageBase');

        $this->_dirty = 1;
        switch($k) {
        case 'rsrc':
        case 'dirty':
        case 'transparent':
            $k = '_'.$k;
            $this->$k = $v;
            break;

        case 'width':
            if( !is_array($this->_info) ) $this->_info = array();
            $this->_info[0] = $v;
            break;

        case 'height':
            if( !is_array($this->_info) ) $this->_info = array();
            $this->_info[1] = $v;
            break;

        case 'type':
            if( !is_array($this->_info) ) $this->_info = array();
            $this->_info[2] = $v;
            break;

        case 'savealpha':
            $this->_salvealpha = (bool)$v;
            break;

        case 'filename':
        case 'name':
            $this->_srcname = $v;
            break;
        }
    }


    public function save($filename,$quality = 75,$progressive = 0)
    {
        if( !$this->_dirty ) return;

        $type = $this['type'];
        $res = '';
        switch($type) {
        case 'image/jpeg':
            imageinterlace($this['rsrc'],$progressive);
            $res = imagejpeg($this['rsrc'],$filename,(int)$quality);
            break;

        case 'image/png':
            if( $this->_savealpha ) imagesavealpha($this['rsrc'],TRUE);
            $quality = ceil((100.0 - (float)$quality)/100.0*10.0);
            $res = imagepng($this['rsrc'],$filename,$quality);
            break;

        case 'image/gif':
            if( $this->_savealpha ) {
                imagesavealpha($this['rsrc'],TRUE);
            }
            else {
                imagesavealpha($this['rsrc'],FALSE);
            }
            $res = imagegif($this['rsrc'],$filename);
            break;

        default:
            throw new Exception('Cannot save image of type '.$this['type']);
        }

        if( $res ) return;
        throw new Exception('Error saving image of type '.$this['type'].' to '.$filename);
    }

    public function supports_transparency()
    {
        switch( $this['type'] ) {
        case 'image/gif':
        case 'image/png':
            return TRUE;

        default:
            return FALSE;
        }
    }
} // class CGImageBase

// $img1 = new CGImage($somefilename);
// $filter = new CmsSomethingFilter();
// $img2 = $filter->transform($img1);
// $img2->save();
#
# EOF
#
?>