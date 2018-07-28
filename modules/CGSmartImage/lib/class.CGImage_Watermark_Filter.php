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

class CGImage_Watermark_Filter extends CGImageFilterBase
{
    private $_wmtext;

    public function __construct(/* var args */)
    {
        $input = func_get_args();
        if( count($input) == 1 && is_array($input[0]) ) $input = $input[0];

        if( cge_array::is_hash($input) ) {
            $this->_wmtext = \cge_param::get_string($input,'text');
        }
        else if( is_array($input) && count($input) >= 1 ) {
            $tmp = \cge_param::get_string($input,0);
            if( is_string($tmp) && !is_numeric($tmp) ) {
                $this->_wmtext = $tmp;
            }
        }
    }

    public function transform(CGImageBase $src)
    {
        $_dest = new CGImageBase($src);

        $watermarker = \cge_setup::get_watermarker();
        if( $this->_wmtext ) {
            // clean up the text
            $text = strip_tags($this->_wmtext);
            $text = substr($text,0,50);
            $text = trim($text);
            if( is_null(\cge_utils::to_bool($text,TRUE)) ) {
                $watermarker->set_watermark_text($text);
            }
        }
        $_dest['rsrc'] = $watermarker->get_watermarked_image($_dest['rsrc']);
        return $_dest;
    }
} // end of class

#
# EOF
#
?>
