<?php
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: CGExtensions (c) 2008-2014 by Robert Campbell
#         (calguy1000@cmsmadesimple.org)
#  An addon module for CMS Made Simple to provide useful functions
#  and commonly used gui capabilities to other modules.
#
#-------------------------------------------------------------------------
# CMSMS - CMS Made Simple is (c) 2005 by Ted Kulp (wishy@cmsmadesimple.org)
# Visit the CMSMS Homepage at: http://www.cmsmadesimple.org
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
 * A simple class for utilities related to manipulating images
 *
 * @package CGExtensions
 * @category Utilities
 * @author  calguy1000 <calguy1000@cmsmadesimple.org>
 * @copyright Copyright 2010 by Robert Campbell
 */

/**
 * A simple class for utilities related to manipulating images.
 *
 * @deprecated Do not use
 * @ignore
 */
class cge_image
{
    /**
     * @ignore
     */
    private function __construct() {}

    /**
     * Resize an image to the specified width and height.
     * This method makes no checks for upscaling, downscaling, or if image aspect ratio is maintained.
     *
     * @param string $srcSpec The complete path to the input file.
     * @param string $destSpec The complete path to the output file.
     * @param int $new_w The destination width (in pixels).
     * @param int $new_h The destination height (in pixels).
     */
    public static function resize($srcSpec,$destSpec,$new_w,$new_h)
    {
        if( !file_exists( $srcSpec ) ) throw new \CmsInvalidDataException('File '.$srcSpec.' not found');
        if( !is_readable( $srcSpec ) ) throw new \CmsInvalidDataException('File '.$srcSpec.' is not readable');
        $destdir = dirname($destSpec);
        if( !is_writable( $destdir ) ) throw new \CmsInvalidDataException($destdir.' is not writable');
        if( file_exists( $destSpec ) && !is_writable( $destSpec ) ) throw new \CmsInvalidDataException($destSpec.' exists, but cannot be overwritten.');
        if( $new_w < 1 || $new_h < 1 ) throw new \CmsInvalidDataException('Invalid width/height passed to '.__METHOD__);
        $ext = substr($srcSpec, strrpos($srcSpec, '.') + 1);

        $imginfo = getimagesize($srcSpec);
        if( $imginfo === FALSE ) throw new \RuntimeException($srcSpec.' is not a valid image file (could not get dimensions)');

        $img_rsrc = imagecreatefromstring(file_get_contents($srcSpec));
        if( $img_rsrc === FALSE ) throw new \RuntimeException('Problem reading image '.$srcSpec);

        $dest_rsrc = ImageCreateTrueColor($new_w,$new_h);
        imagealphablending($dest_rsrc,FALSE);
        imagesavealpha($dest_rsrc,TRUE);
        $transparent = imagecolorallocatealpha($dest_rsrc,255,255,255,127);
        imagefilledrectangle($dest_rsrc, 0, 0, $new_w, $new_h, $transparent);
        ImageCopyResampled($dest_rsrc, $img_rsrc, 0, 0, 0, 0, $new_w, $new_h, $imginfo[0], $imginfo[1]);

        $func = null;
        switch( $imginfo[2] ) {
        case IMAGETYPE_GIF:
            $func = 'imagegif';
            break;
        case IMAGETYPE_JPEG:
            $func = 'imagejpeg';
            break;
        case IMAGETYPE_PNG:
            $func = 'imagepng';
            break;
        case IMAGETYPE_BMP:
            $func = 'imagebmp';
            break;
        default:
            if( strtolower($ext) == 'webp' ) {
                // no imagetype constant for webp?
                $func = 'imagewebp';
            }
            else {
                throw new \RuntimeException('Cannot save files of type '.$imginfo[2]." ($ext)");
            }
        }

        $res = $func($dest_rsrc,$destSpec);
        if( $res === FALSE ) throw new \RuntimeException('Problem saving file '.$destSpec);
        ImageDestroy($img_rsrc);
        ImageDestroy($dest_rsrc);
    }

    /**
     * Resize an image to have the specifified number of pixels in the logest dimension while retaining aspect ratio.
     *
     * @param string $srcSpec The complete path to the input file.
     * @param string $destSpec The complete path to the output file.
     * @param int $size The maximum size of the longest dimension of the image (in pixels).
     */
    public static function transform_image($srcSpec,$destSpec,$size = null)
    {
        if( !file_exists( $srcSpec ) ) throw new \CmsInvalidDataException('File '.$srcSpec.' not found');
        if( !is_readable( $srcSpec ) ) throw new \CmsInvalidDataException('File '.$srcSpec.' is not readable');
        $destdir = dirname($destSpec);
        if( !is_writable( $destdir ) ) throw new \CmsInvalidDataException($destdir.' is not writable');
        if( file_exists( $destSpec ) && !is_writable( $destSpec ) ) throw new \CmsInvalidDataException($destSpec.' exists, but cannot be overwritten.');

        $imginfo = getimagesize($srcSpec);
        if( $imginfo === FALSE ) throw new \RuntimeException($srcSpec.' is not a valid image file (could not get dimensions)');

        if( $size < 1 ) {
            // get a default thumbnail size.
            $cge = cge_utils::get_cge();
            $size = (int) $cge->GetPreference('thumbnailsize');
        }

        // calculate new sizes.
        $new_w = $new_h = 0;
        if( $imginfo[0] >= $imginfo[1] ) {
            // image is taller than wide
            $new_w = $size;
            $new_h = round(($new_w / $imginfo[0]) * $imginfo[1], 0);
        }
        else {
            $new_h = $size;
            $new_w = round(($new_h / $imginfo[1]) * $imginfo[0], 0);
        }

        self::resize($srcSpec,$destSpec,$new_w,$new_h);
    }
} // end of class

#
# EOF
#
?>