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
# This project's homepage is: http://www.cmsmadesimple.org
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

/**
 * Filter class for horizontally flipping an image.
 * 
 * @author Robert Campbell <calguy1000@cmsmadesimple.org>
 * @package CGSmartImage
 */
class CGImage_Flip_Filter extends CGImageFilterBase
{
  private $_mode;

  public function construct()
  {
    if( func_num_args() != 1 ) {
      throw new Exception('Invalid arguments to '.get_class($this));
    }

    $args = func_get_args();
    $args = $args[0];
    if( is_array($args) ) {
      $this->_mode = (int)$args[0];
    }
    else {
      $this->_mode = $args;
    }
    $this->_mode = max(0,$this->_mode);
    $this->_mode = min(2,$this->_mode);
  }

  /**
   * Transform the specified image using the parameters set
   *
   * @param CGImageBase The image to transform
   * @return CGImageBase The transformed image.
   */
  public function transform(CGImageBase $src)
  {
    $width       = $src['width'];
    $height      = $src['height'];

    $src_x       = 0;
    $src_y       = 0;
    $src_width   = $width;
    $src_height  = $height;

    switch ( (int) $mode ) {
    case 0:
      $src_y                =    $height;
      $src_height           =    -$height;
      break;

    case 1:
      $src_x                =    $width;
      $src_width            =    -$width;
      break;

    case 2:
      $src_x                =    $width;
      $src_y                =    $height;
      $src_width            =    -$width;
      $src_height           =    -$height;
      break;

    default:
      return $imgsrc;
    }

    $_dest = new CGImageBase(array($src['type'],$width,$height));
    $res = imagecopyresampled ( $_dest['rsrc'], $src['rsrc'], 0, 0, $src_x, $src_y, $width, $height, $src_width, $src_height );
    if( !$res )	throw new Exception('Image Transform Failed');

    return $_dest;
  }
}

#
# EOF
#
?>