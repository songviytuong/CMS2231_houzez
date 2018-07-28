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

class CGImage_Crop_Filter extends CGImageFilterBase
{
  const ALIGN_TOP    = 'top';
  const ALIGN_CENTER = 'center';
  const ALIGN_BOTTOM = 'bottom';
  const ALIGN_LEFT   = 'left';
  const ALIGN_RIGHT  = 'right';

  private $_percent = 50;
  private $_h_align = self::ALIGN_CENTER;
  private $_v_align = self::ALIGN_CENTER;
    
  public function __construct($input)
  {
    $percent = 50;
    $h_align = CGImage_Crop_Filter::ALIGN_CENTER;
    $v_align = CGImage_Crop_Filter::ALIGN_CENTER;

    if( cge_array::is_hash($input) ) {
      $percent = (int)$input['percent'];
      $h_align = trim($params['h']);
      $v_align = trim($params['v']);
    }
    else if( is_array($input) ) {
      if( count($input) > 1 ) $percent = (int)$input[0];
      if( count($input) == 3 ) {
	$h_align = trim($input[1]);
	$v_align = trim($input[2]);
      }
    }
    
    $this->_percent = min(100,max(1,$percent));
    switch($h_align) {
    case '-1':
    case 'left':
    case 'l':
      $this->_h_align = self::ALIGN_LEFT;
      break;

    case '0':
    case 'c':
    case 'center':
      $this->_h_align = self::ALIGN_CENTER;
      break;

    case '1':
    case 'r':
    case 'right':
      $this->_h_align = self::ALIGN_RIGHT;
      break;

    default:
      throw new Exception('Invalid value '.$h_align.' for horizontal alignment');
    }

    switch($v_align) {
    case '-1':
    case 't':
    case 'top':
      $this->_v_align = self::ALIGN_TOP;
      break;

    case '0':
    case 'c':
    case 'center':
      $this->_v_align = self::ALIGN_CENTER;
      break;

    case '1':
    case 'b':
    case 'bottom':
      $this->_v_align = self::ALIGN_BOTTOM;
      break;

    default:
      throw new Exception('Invalid value '.$h_align.' for horizontal alignment');
    }
  }


  public function transform(CGImageBase $src)
  {
    $new_w = (int)($src['width'] * $this->_percent / 100.0);
    $new_h = (int)($src['height'] * $this->_percent / 100.0);

    $src_x = 0;
    switch( $this->_h_align ) {
    case self::ALIGN_LEFT:
      $src_x = 0;
      break;

    case self::ALIGN_CENTER:
      $src_x = (int)(($src['width'] - $new_w) / 2);
      break;

    case self::ALIGN_RIGHT:
      $src_x = $src['width'] - $new_w;
      break;
    }

    $src_y = 0;
    switch( $this->_v_align ) {
    case self::ALIGN_TOP:
      $src_y = 0;
      break;

    case self::ALIGN_CENTER:
      $src_y = (int)(($src['height'] - $new_h) / 2);
      break;

    case self::ALIGN_BOTTOM:
      $src_y = $src['height'] = $new_h;
      break;
    }

    $_dest = new CGImageBase(array($src['type'],$new_w,$new_h));
    $res = imagecopyresampled($_dest['rsrc'],$src['rsrc'],0,0,$src_x,$src_y,$new_w,$new_h,$new_w,$new_h);
    if( $res === FALSE ) throw new Exception('crop failed');

    return $_dest;
  }

} // end of class

#
# EOF
#
?>