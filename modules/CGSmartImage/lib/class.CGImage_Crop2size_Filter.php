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

class CGImage_Crop2size_Filter extends CGImageFilterBase
{
  private $_dest_w = 0;
  private $_dest_h = 0;
  private $_loc = 'c';
  static private $_valid_locs = array('tl','tc','tr','cl','c','cc','cr','bl','bc','br');

  public function __construct($input)
  {
    if( cge_array::is_hash($input) ) {
      if( isset($input['width']) ) {
	$this->_dest_w = (int)$input['width'];
	$this->_dest_h = (int)$input['height'];
      }
      else if ( isset($input['w']) ) {
	$this->_dest_w = (int)$input['w'];
	$this->_dest_h = (int)$input['h'];
      }
      if( isset($input['loc']) && in_array($input['loc'],self::$_valid_locs) ) $this->_loc = trim($input['loc']);
    }
    else if( is_array($input)  ) {
      if( count($input) >= 2 ) {
	$this->_dest_w = (int)trim($input[0]);
	$this->_dest_h = (int)trim($input[1]);
	if( count($input) >= 3 && in_array($input[2],self::$_valid_locs) ) $this->_loc = trim($input[2]);
      }
    }

    if( $this->_dest_h <= 0 || $this->_dest_w <= 0 ) throw new Exception('Invalid values specified for Croptofit filter constructor');
  }

  public function transform(CGImageBase $src)
  {
    $dest_w = (int)$this->_dest_w;
    $dest_h = (int)$this->_dest_h;
    $src_w  = (int)$src['width'];
    $src_h  = (int)$src['height'];

    $dest_w = min($src_w,$dest_w);
    $dest_h = min($src_h,$dest_h);
    
    if( $dest_w <= 0 || $dest_h <= 0 ) throw new Exception('Invalid values specified for Crop2 filter');
    if( $dest_w == $src_w && $dest_h == $src_h ) return $src;

    $x0 = $y0 = 0;
    switch( strtolower($this->_loc) ) {
    case 'tl':
      // use defaults.
      break;

    case 'tc':
      $x0 = floor( ($src_w - $dest_w) / 2 );
      break;

    case 'tr':
      $x0 = $src_w - $dest_w;
      break;

    case 'cl':
      $y0 = floor( ($src_h - $dest_h) / 2 );
      break;

    case 'c':
    case 'cc':
      $x0 = floor( ($src_w - $dest_w) / 2 );
      $y0 = floor( ($src_h - $dest_h) / 2 );
      break;

    case 'cr':
      $x0 = $src_w - $dest_w;
      $y0 = floor( ($src_h - $dest_h) / 2 );
      break;

    case 'bl':
      $y0 = $src_h - $dest_h;
      break;

    case 'bc':
      $x0 = floor( ($src_w - $dest_w) / 2 );
      $y0 = $src_h - $dest_h;
      break;

    case 'br':
      $x0 = $src_w - $dest_w;
      $y0 = $src_h - $dest_h;
      break;
    }

    $_dest = new CGImageBase(array($src['type'],$dest_w,$dest_h));
    $res = imagecopy($_dest['rsrc'],$src['rsrc'],0,0,$x0,$y0,$dest_w,$dest_h);
    if( $res === FALSE ) throw new Exception('crop2 failed');
    return $_dest;
  }

} // end of class

#
# EOF
#
?>