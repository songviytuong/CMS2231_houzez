<?php
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: CGSmartImage (c) 2013 by Robert Campbell (calguy1000@cmsmadesimple.org)
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

class CGImage_Sharpen_Filter extends CGImageFilterBase
{
private $_matrix = array(array(0,-3,0),array(-3,21,-3),array(0,-3,0));
//    private $_matrix = array(array(0,-1.0 ,0),array(-1.0, 5.0, -1.0),array(0,-1.0, 0));
    private $_divisor = 9;

    public function __construct(/* var args */)
    {
        $input = func_get_args();
        if( is_array($input) && count($input) == 1 ) $input = $input[0];
        $this->_divisor = array_sum(array_map('array_sum', $this->_matrix));

        $adj = 0;
        if( cge_array::is_hash($input) && isset($input['divisor']) ) {
            $adj = (float)$input['divisor'];
        }
        else if( is_array($input) && count($input) >= 1 ) {
            $adj = (float)$input[0];
        }
        $this->_divisor += max(-10,min(10,$adj));
    }

    public function transform(CGImageBase $src)
    {
        // copy the image (pixel for pixel)
        $_dest = new CGImageBase($src);
        imagecopy($_dest['rsrc'],$src['rsrc'],0,0,0,0,$src['width'],$src['height']);
        imageconvolution($_dest['rsrc'],$this->_matrix,$this->_divisor,0);
        return $_dest;
    }
}

#
# EOF
#
?>
