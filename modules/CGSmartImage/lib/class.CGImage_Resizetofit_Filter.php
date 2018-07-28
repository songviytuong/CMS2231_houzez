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

class CGImage_Resizetofit_Filter extends CGImageFilterBase
{
  private $_dest_w = 0;
  private $_dest_h = 0;
  private $_color;
  private $_alpha = 0;
    
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
      if( isset($input['color']) && $input['color'] != '') $this->_color = strtolower($input['color']);
      if( isset($input['alpha']) ) $this->_alpha = (int)$input['alpha'];
    }
    else if( is_array($input)  ) {
      if( count($input) >= 2 ) {
	$this->_dest_w = (int)trim($input[0]);
	$this->_dest_h = (int)trim($input[1]);
	if( count($input) >= 3 ) {
	  if( $input[2] != '' ) $this->_color = strtolower($input[2]);
	  if( count($input) >= 4 ) if( $input[3] != '' ) $this->_alpha = (int)$input[3];
	}
      }
    }

    $this->_dest_w = cgsi_utils::trim_to_device('width',$this->_dest_w);
    $this->_dest_h = cgsi_utils::trim_to_device('height',$this->_dest_h);
    $this->_alpha = max(0,min(127,$this->_alpha));

    // todo: convert color name into rgb.
    if( $this->_dest_h <= 0 || $this->_dest_w <= 0 ) {
      throw new Exception('Invalid values specified for Croptofit filter constructor');
    }
  }

  public function transform(CGImageBase $src)
  {
    // quick optimization (nothing to do)
    //if( $this->_dest_w == $src['width'] && $this->_dest_h == $src['height'] ) return $src;

    $type = $src['type'];
    if( $this->_alpha == 127 ) $this->_color = 'transparent';
    if( $src->supports_transparency() && !$this->_color ) $this->_color = 'transparent';
    if( $this->_color == 'transparent' || $this->_alpha > 0 ) $type = 'image/png';
    if( $this->_color == 'transparent' ) $this->_alpha = 127;

    // create our destination image.
    $_dest = new CGImageBase(array($type,$this->_dest_w,$this->_dest_h));

    // fill our image with a color (or transparent)
    $color = null;
    if( $this->_color ) {
      if( $this->_color == 'transparent' ) {
	// need to get a transparent color from someplace
	$color = $_dest['transparent'];
      }
      else {
	$_r = $_g = $_b = 255;
	list($_r,$_g,$_b) = cgsi_utils::color_to_rgb($this->_color);
	$color = imagecolorallocatealpha($_dest['rsrc'], $_r, $_g, $_b, $this->_alpha);
      }
    }
    
    if( $this->_alpha > 0 && $this->_alpha < 127) {
      $_dest['savealpha'] = TRUE;
      imagealphablending($_dest['rsrc'],TRUE);
      imagesavealpha($_dest['rsrc'],TRUE);
    } if( $this->_color == 'transparent' ) {
      imagecolortransparent($_dest['rsrc'],$color);
      imagealphablending($_dest['rsrc'],FALSE);
    }

    imagefill($_dest['rsrc'], 0, 0, $color);

    if( ($this->_dest_w / $this->_dest_h) > ($src['width']/$src['height']) ) {
      // height is greater... 
      $new_h = $this->_dest_h;
      $new_w = round(($new_h / $src['height']) * $src['width'], 0);
    }
    else {
      // width is greater.
      $new_w = $this->_dest_w;
      $new_h = round(($new_w / $src['width']) * $src['height'], 0);
    }

    $x0 = (int)(($this->_dest_w - $new_w) / 2);
    $y0 = (int)(($this->_dest_h - $new_h) / 2);

    // resize the big image into the temporary transparent image
    $res = imagecopyresampled($_dest['rsrc'],$src['rsrc'],$x0,$y0,0,0,$new_w,$new_h,$src['width'],$src['height']);
    if( $res === FALSE ) throw new Exception('Resizetofit - stage 1 - failed');
    return $_dest;
  }

} // end of class

#
# EOF
#
?>