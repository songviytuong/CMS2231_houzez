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

class CGImage_Pixelate_Filter extends CGImageFilterBase
{
  private $_size = 3;
  private $_pixelate = 0;

  public function __construct(/* variable arguments */)
  {
    $args = func_get_args();
    if( is_array($args[0]) && count($args) == 1 )
      $args = $args[0];

    if( count($args) != 2 )
      {
	throw new Exception('Invalid arguments to '.get_class($this));
      }

    $this->_size = (int)$args[0];
    $this->_pixelate = (int)$args[1];
  }


  public function transform(CGImageBase $src)
  {
    $_dest = new CGImageBase($src);
    $res = imagefilter($_dest['rsrc'],IMG_FILTER_PIXELATE,$this->_pixelate);

    if( !$res )
      {
	throw new Exception('Error applying filter '.IMG_FILTER_PIXELATE);
      }
    return $_dest;
  }
}

#
# EOF
#
?>