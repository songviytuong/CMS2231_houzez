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
 * Converts a transparent image to untransparent, by specifying a color that should become the background color.
 * 
 * @author Robert Campbell <calguy1000@cmsmadesimple.org>
 * @package CGSmartImage
 */
class CGImage_Untransparent_Filter extends CGImageFilterBase
{
  /**
   * The number of degrees to rotate
   *
   * @access private
   * @var integer
   */
  private $_color;
  private $_pct = 100;

  public function __construct(/* variable arguments */)
  {
    $args = func_get_args();
    if( is_array($args[0]) && count($args) == 1) $args = $args[0];
    if( count($args) >= 1 ) $this->_color = $args[0];
    if( count($args) >= 2 ) $this->_pct = (int)$args[1];

    $this->_pct = max(0,min(100,$this->_pct));
  }

  public function transform(CGImageBase $src)
  {
    $type = 'image/jpeg';
    if( !function_exists('imagerotate') ) throw new Exception('imagerotate function not found');
    $_dest = new CGImageBase(array($type,$src['width'],$src['height']));
    list($_r,$_g,$_b) = cgsi_utils::color_to_rgb($this->_color);
    $color = imagecolorallocate($_dest['rsrc'],$_r,$_g,$_b);
    imagefill($_dest['rsrc'],0,0,$color);
    if( $this->_pct == 100 ) {
      imagecopy($_dest['rsrc'],$src['rsrc'], 0, 0, 0, 0, $src['width'], $src['height']);
    }
    else {
      imagecopymerge($_dest['rsrc'],$src['rsrc'], 0, 0, 0, 0, $src['width'], $src['height'],$this->_pct);
    }
    return $_dest;
  }
}

#
# EOF
#
?>