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
 * Filter class for making reflection for image.
 *
 * @author Tapio Löytty <stikki@cmsmadesimple.org>
 * @package CGSmartImage
 */
class CGImage_Reflect_Filter extends CGImageFilterBase
{
  private $_reflection_height				= 100;
  private $_reflection_transparency			= 0;
  private $_div_height						= 0;

  public function __construct()
  {
    if(func_num_args() > 0) {

		$args = func_get_args();
		$args = (array)$args[0];

		if(isset($args[0]))
			$this->_reflection_height = (int)$args[0];

		if(isset($args[1]))
			$this->_reflection_transparency = (int)$args[1];

		if(isset($args[2]))
			$this->_div_height = (int)$args[2];
	}
  }

  /**
   * Transform the specified image using the parameters set
   *
   * @param CGImageBase The image to transform
   * @return CGImageBase The transformed image.
   */
  public function transform(CGImageBase $src)
  {
    $width      = $src['width'];
    $height     = $src['height'];
	$type 		= $src['type'];

	// Create _dest image and copy orginal image into it
    $_dest = new CGImageBase(array($type, $width, $height + $this->_reflection_height));
	$res = imagecopyresampled($_dest['rsrc'], $src['rsrc'], 0, 0, 0, 0, $width, $height, $width, $height);

    if($res === FALSE)
		throw new Exception('Creation of destination image failed');

	// Make white mask
	$mask = imagecreatetruecolor($width, $height);
	$bgc = imagecolorallocate($mask, 255, 255, 255); // Background color
	imagefilledrectangle($mask, 0, 0, $width, $height, $bgc);

	// Flip orginal image and dump it to new picture ($dumpimage)
	$dumpimage = imagecreatetruecolor($width, $this->_reflection_height);
	$bgc = imagecolorallocate($src['rsrc'], 255, 255, 255); // Background color
	$src['rsrc'] = imagerotate($src['rsrc'], -180, $bgc);
	imagecopyresampled($dumpimage, $src['rsrc'], 0, 0, 0, 0, $width, $height, $width, $height);

	// Set Orginal image as dumpimage and create new $dumpimage
	$src['rsrc'] = $dumpimage;
	$dumpimage = imagecreatetruecolor($width, $this->_reflection_height);

	// Make mirror image of current Orginal image and dump it to $dumpimage. Set $dumpimage to $src['rsrc']
	for ($x = 0; $x < $width; $x++) {

		imagecopy($dumpimage, $src['rsrc'], $x, 0, $width-$x-1, 0, $width, $this->_reflection_height);
	}
	$src['rsrc'] = $dumpimage;

	// Set $mask on $src['rsrc'] and make actual reflection
	$in = 100/$this->_reflection_height;
	for($i=0; $i <= $this->_reflection_height; $i++){

		if($this->_reflection_transparency > 100) $this->_reflection_transparency = 100;

		imagecopymerge($src['rsrc'], $mask, 0, $i, 0, 0, $width, 1, $this->_reflection_transparency);

		$this->_reflection_transparency += $in;
	}

	// Set Divider line for $src['rsrc']
	$res = imagecopymerge($src['rsrc'], $mask, 0, 0, 0, 0, $width, $this->_div_height, 100);

    if($res === FALSE)
		throw new Exception('Creation of mask copy failed');

	// Copy reflection to $_dest image
	$res = imagecopymerge($_dest['rsrc'], $src['rsrc'], 0, $height, 0, 0, $width, $this->_reflection_height, 100);

    if( is_resource($mask) ) imagedestroy($mask);
    if( is_resource($dumpimage) ) imagedestroy($dumpimage);

    if($res === FALSE)
		throw new Exception('Creation of final image failed');

    return $_dest;
  }
}

#
# EOF
#
?>