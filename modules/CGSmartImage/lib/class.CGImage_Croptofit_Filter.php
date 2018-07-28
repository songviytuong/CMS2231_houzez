<?php
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: CGSmartImage (c) 2012 by Robert Campbell (calguy1000@cmsmadesimple.org)
#
#  An addon module for CMS Made Simple to allow creating image tags in a smart
#  way to optimize performance.
#
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2005-2010 by Ted Kulp (wishy@cmsmadesimple.org)
# This projects homepage is: http://www.cmsmadesimple.org
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

class CGImage_Croptofit_Filter extends CGImageFilterBase
{
    private $_dest_w = 0;
    private $_dest_h = 0;
    private $_loc = 'c';
    private $_upscale = 0;
    static private $_valid_locs = array('tl','tc','tr','cl','c','cr','bl','bc','br');

    public function __construct($input)
    {
        $mod = cms_utils::get_module('CGSmartImage');
        $this->_loc = $mod->GetPreference('croptofit_default_loc','c');
        if( cge_array::is_hash($input) ) {
            if( isset($input['width']) ) {
                $this->_dest_w = (int)$input['width'];
                $this->_dest_h = (int)$input['height'];
            }
            else if ( isset($input['w']) ) {
                $this->_dest_w = (int)$input['w'];
                $this->_dest_h = (int)$input['h'];
            }
            if( isset($input['loc']) && in_array($input['loc'],self::$_valid_locs) ) $this->_loc = $input['loc'];
            if( isset($input['upscale']) ) $this->_upscale = (int)$input['upscale'];
        }
        else if( is_array($input)  ) {
            if( count($input) >= 2 ) {
                $this->_dest_w = (int)trim($input[0]);
                $this->_dest_h = (int)trim($input[1]);
                if( count($input) >= 3 && in_array($input[2],self::$_valid_locs) ) $this->_loc = $input[2];
                if( count($input) >= 4 ) $this->_upscale = (int)$input[3];
            }
        }

        if( !$this->_upscale ) {
            $this->_dest_w = cgsi_utils::trim_to_device('width',$this->_dest_w);
            $this->_dest_h = cgsi_utils::trim_to_device('height',$this->_dest_h);
        }

        if( $this->_dest_h <= 0 || $this->_dest_w <= 0 ) throw new Exception('Invalid values specified for Croptofit filter constructor');
    }


    public function transform(CGImageBase $src)
    {
        if( !$this->_upscale ) {
            // prevent any upscaling
            $this->_dest_w = min($this->_dest_w,$src['width']);
            $this->_dest_h = min($this->_dest_h,$src['height']);
        }

        //
        // note:  this code developed by using the following page as a reference
        // http://911-need-code-help.blogspot.com/2009/04/crop-to-fit-image-using-aspphp.html
        //
        $src_ratio = (float)$src['width'] / (float)$src['height'];
        $dest_ratio = (float)$this->_dest_w / (float)$this->_dest_h;

        // determine the size of the temp image that fits into
        // the desired area by at least one dimension.
        $new_h = '';
        $new_w = '';
        if( $src_ratio >= $dest_ratio ) {
            $new_h = (int) $this->_dest_h;
            $new_w = (int) ceil($this->_dest_h * $src_ratio);
        }
        else {
            //else if( $src_ratio < $dest_ratio ) {
            $new_w = (int) $this->_dest_w;
            $new_h = (int) ceil($this->_dest_w / $src_ratio );
        }

        // get the transparent color of the source image.
        $tmp_rsrc = null;
        $tc = imagecolorat($src['rsrc'],0,$src['height']-1);
        $tr = $tg = $tb = 0; $ta = 127;
        if( $tc > 0 ) {
            $tmp = imagecolorsforindex($src['rsrc'],$tc);
            $tr = $tmp['red'];
            $tg = $tmp['green'];
            $tb = $tmp['blue'];
            $ta = $tmp['alpha'];
        }

        if( $new_w == $src['width'] && $new_h == $src['height'] ) {
            $tmp_rsrc = $src['rsrc'];
        }
        else {
            // create temporary transparent image
            $tmp_rsrc = imagecreatetruecolor($new_w,$new_h);
            imagealphablending($tmp_rsrc, TRUE);
            $transparent = imagecolorallocatealpha($tmp_rsrc, $tr, $tg, $tb, $ta);
            imagecolortransparent($tmp_rsrc,$transparent);
            imagefill($tmp_rsrc, 0, 0, $transparent);
        }

        // resize the big image into the temporary transparent image
        $res = imagecopyresampled($tmp_rsrc,$src['rsrc'],0,0,0,0,$new_w,$new_h,$src['width'],$src['height']);
        if( $res === FALSE ) throw new Exception('Croptofit - stage 1 - failed');

        // calculate the offset into the destination iamge.
        switch( strtolower($this->_loc) ) {
        case 'tl':
            $x0 = 0;
            $y0 = 0;
            break;

        case 'tc':
            $x0 = (int)( $new_w - $this->_dest_w ) / 2;
            $y0 = 0;
            break;

        case 'tr':
            $x0 = (int)( $new_w - $this->_dest_w );
            $y0 = 0;
            break;

        case 'cl':
            $x0 = 0;
            $y0 = (int)( $new_h - $this->_dest_h ) / 2;
            break;

        case 'cr':
            $x0 = (int)( $new_w - $this->_dest_w );
            $y0 = (int)( $new_h - $this->_dest_h ) / 2;
            break;

        case 'bl':
            $x0 = 0;
            $y0 = (int)( $new_h - $this->_dest_h );
            break;

        case 'bc':
            $x0 = (int)( $new_w - $this->_dest_w ) / 2;
            $y0 = (int)( $new_h - $this->_dest_h );
            break;

        case 'br':
            $x0 = (int)( $new_w - $this->_dest_w );
            $y0 = (int)( $new_h - $this->_dest_h );
            break;

        case 'c':
        default:
            // center
            $x0 = (int)( $new_w - $this->_dest_w ) / 2;
            $y0 = (int)( $new_h - $this->_dest_h ) / 2;
            break;
        }

        // create destination image at the desired thumb size.
        //$_dest = new CGImageBase(array('image/png',$this->_dest_w,$this->_dest_h));
        $_dest = new CGImageBase(array($src['type'],$this->_dest_w,$this->_dest_h));

        // set this transparent color into into the dest image.
        $transparent2 = imagecolorallocatealpha($_dest['rsrc'], $tr, $tg, $tb, $ta);
        imagecolortransparent($_dest['rsrc'],$transparent2);
        imagefill($_dest['rsrc'], 0, 0, $transparent2);

        // copy the temp image into the dest image.
        imagealphablending($_dest['rsrc'],TRUE);
        $res = imagecopy($_dest['rsrc'],$tmp_rsrc,0,0,$x0,$y0,$new_w,$new_h);
        if( $res === FALSE ) throw new Exception('Croptofit - stage 2 - failed');
        imagedestroy($tmp_rsrc);
        return $_dest;
    }

} // end of class

#
# EOF
#
?>