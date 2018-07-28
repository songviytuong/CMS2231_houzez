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

class CGImage_Resize_Filter extends CGImageFilterBase
{
    private $_width;         // dest width
    private $_height;        // dest height
    private $_edge = 0;	     // edge size
    private $_percent = 0;   // scale to percent
    private $_resample = 1;  // resample, vs resize.
    private $_upscale = 1;   // allow upscale by default.

    public function __construct(/* var args */)
    {
        $input = func_get_args();
        if( count($input) == 1 && is_array($input[0]) ) $input = $input[0];

        if( cge_array::is_hash($input) ) {
            if( isset($input['width']) ) $this->_width = (int)$input['width'];
            if( isset($input['height']) ) $this->_height = (int)$input['height'];
            if( isset($input['percent']) ) {
                $this->_percent = (int)$input['percent'];
                $this->_percent = min(100,max(1,$this->_percent));
            }
            if( isset($input['resample']) ) $this->_resample = (int)$input['resample'];
            if( isset($input['upscale']) ) $this->_upscale = (int)$input['upscale'];
            if( isset($input['edge']) ) $this->_edge = (int)$input['edge'];
        }
        else if( is_array($input) && count($input) >= 2 ) {
            $idx = 2;
            switch( $input[0] ) {
            case 'p':
                $this->_percent = (int)$input[1];
                break;
            case 'w':
                $this->_width = (int)$input[1];
                break;
            case 'h':
                $this->_height = (int)$input[1];
                break;
            case 'e':
                $this->_edge = (int)$input[1];
		break;
            case 'c':
                $this->_width = (int)$input[1];
                $this->_height = (int)$input[2];
                $idx = 3;
                break;
            }

            if( count($input) > $idx ) $this->_upscale = (int)$input[$idx];
        }

        if( $this->_width > 0 ) $this->_width = cgsi_utils::trim_to_device('width',$this->_width);
        if( $this->_height > 0 ) $this->_height = cgsi_utils::trim_to_device('height',$this->_height);
        if( !($this->_percent > 0 || $this->_width > 0 || $this->_height > 0 || $this->_edge > 0) ) {
            throw new Exception('Could not Create Resize Filter - Invalid Parameters');
        }
  }


  private function _transform(CGImageBase $src,$new_w,$new_h)
  {
      if( $new_w == $src['width'] && $new_h == $src['height'] ) return $src;

      $_dest = new CGImageBase(array($src['type'],$new_w,$new_h));

      $res = '';
      if( $this->_resample ) {
          imagealphablending($_dest['rsrc'],FALSE);
          imagesavealpha($_dest['rsrc'], TRUE);
          $res = imagecopyresampled($_dest['rsrc'],$src['rsrc'],0,0,0,0,$new_w,$new_h,$src['width'],$src['height']);
          imagealphablending($_dest['rsrc'],TRUE);
      }
      else {
          $res = imagecopyresized($_dest['rsrc'],$src['rsrc'],0,0,0,0,$new_w,$new_h,$src['width'],$src['height']);
      }

      if( !$res ) throw new Exception('Image Transform Failed');
      return $_dest;
  }


  protected function _transform_percentage(CGImageBase $src)
  {
      $new_w = (int)((float)$src['width'] * (float)$this->_percent / 100.0);
      $new_h = (int)((float)$src['height'] * (float)$this->_percent / 100.0);
      return $this->_transform($src,$new_w,$new_h);
  }


  protected function _transform_width(CGImageBase $src)
  {
      // calculate new width and height, preserving aspect ratio
      $new_w = $this->_width;
      $new_h = (int)($this->_width * $src['height'] / $src['width']);
      return $this->_transform($src,$new_w,$new_h);
  }

  protected function _transform_height(CGImageBase $src)
  {
      // calculate new width and height, preserving aspect ratio
      $new_h = $this->_height;
      $new_w = (int)($this->_height * $src['width'] / $src['height']);
      return $this->_transform($src,$new_w,$new_h);
  }

  protected function _transform_edge(CGImageBase $src)
  {
      //find the longest edge of image and resize based on it
      if($src['width'] > $src['height']) {
          $new_w = $this->_edge;
          $new_w = cgsi_utils::trim_to_device('width',$new_w);
          $new_h = (int)($this->_edge * $src['height'] / $src['width']);
          return $this->_transform($src,$new_w,$new_h);
      } else {
          $new_h = $this->_edge;
          $new_h = cgsi_utils::trim_to_device('height',$new_h);
          $new_w = (int)($this->_edge * $src['width'] / $src['height']);
          return $this->_transform($src,$new_w,$new_h);
      }
  }

  protected function _transform_custom(CGImageBase $src)
  {
      // this does not preserve aspect ratio.
      return $this->_transform($src,$this->_width,$this->_height);
  }


  public function transform(CGImageBase $img)
  {
      if( $this->_percent > 0 ) return $this->_transform_percentage($img); // percentage resize.
      if( $this->_edge > 0 && (($img['width'] > $this->_edge || $img['height'] > $this->_edge) || $this->_upsscale) ) {
          //resize by longest edge
          return $this->_transform_edge($img);
      }
      if( $this->_width > 0 && $this->_height == 0 && (($img['width'] > $this->_width) || $this->_upscale) ) {
          return $this->_transform_width($img);
      }
      if( $this->_width == 0 && $this->_height > 0 && (($img['height'] > $this->_height) || $this->_upscale) ) {
          return $this->_transform_height($img);
      }
      if( $this->_width > 0 && $this->_height > 0 ) {
          if( $img['width'] == $this->_width && $img['height'] == $this->_height ) {
              // nothing to do... but trick the image to be dirty.
              $img['height'] = $img['height'];
              return $img;
          }
          return $this->_transform_custom($img);
      }

      // nothing to do.... but trick the image to be dirty.
      $img['height'] = $img['height'];
      return $img;
  }
}

#
# EOF
#
?>
