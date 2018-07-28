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
 * This file defines the cge_uploader class.
 *
 * @package CGExtensions
 * @category Utilities
 * @author  calguy1000 <calguy1000@cmsmadesimple.org>
 * @copyright Copyright 2010 by Robert Campbell
 */


/**
 * A class to aide in dealing with uploaded files, including post processing of images.
 *
 * @package CGExtensions
 */
class cge_uploader extends cg_fileupload
{
    /**
     * @ignore
     */
    private $_do_preview = false;

    /**
     * @ignore
     */
    private $_preview_size = 800;

    /**
     * @ignore
     */
    private $_do_watermark = false;

    /**
     * @ignore
     */
    private $_watermarker = null;

    /**
     * @ignore
     */
    private $_do_thumbnail = false;

    /**
     * @ignore
     */
    private $_thumbnail_size = 75;

    /**
     * @ignore
     */
    private $_delete_orig = 0;

    /**
     * @ignore
     */
    private $_imagetypes;

    /**
     * Set a flag indicating that a preview (slightly larger than a thumbnail) image should be generated from an uploaded image.
     *
     * @param bool $flag
     */
    public function set_preview($flag = true)
    {
        $this->_do_preview = (bool) $flag;
    }

    /**
     * Set the size (in pixels) of the preview image.
     * This is only applicable if preview is enabled.
     *
     * @param int $size
     */
    public function set_preview_size($size)
    {
        $this->_preview_size = max(1,(int)$size);
    }

    /**
     * Set a flag indicating that an uploaded image should be watermarked.
     *
     * @param bool $flag
     */
    public function set_watermark($flag = true)
    {
        $this->_do_watermark = (bool) $flag;
    }

    /**
     * Set a flag indicating that a thumbnail should be generated from an uploaded image.
     *
     * @param bool $flag
     */
    public function set_thumbnail($flag = true)
    {
        $this->_do_thumbnail = $flag;
    }

    /**
     * Get the watermark object that will be used to watermark images.
     *
     * @internal
     * @return cg_watermark
     */
    public function &get_watermark_obj()
    {
        if( !is_object($this->_watermarker) ) {
            $this->_watermarker = cge_setup::get_watermarker();
        }

        return $this->_watermarker;
    }

    /**
     * Set the size (in pixels) of the generated thumbnails.
     *
     * @param int $size
     */
    public function set_thumbnail_size($size)
    {
        $this->_thumbnail_size = $size;
    }

    /**
     * Set a flag to indicate that the original file should be deleted after processing.
     *
     * @param bool $flag
     */
    public function set_delete_orig($flag = true)
    {
        $this->_delete_orig = $flag;
    }

    /**
     * Test wether the filename specified is a file acceptable for processing.
     *
     * @param string $filename
     * @return bool
     */
    public function is_accepted_imagefile($filename)
    {
        $imagetypes = $this->get_accepted_imagetypes();
        if( is_array($imagetypes) && count($imagetypes) ) {
            $extension = strrchr($filename,".");
            $found = FALSE;
            foreach( $imagetypes as $type ) {
                if( ".".strtolower($type) == strtolower($extension) ) {
                    $found = TRUE;
                    break;
                }
            }
            if( !$found ) return FALSE;
        }
        return TRUE;
    }

    /**
     * Return a list of the file extensions that will be accepted for processing on upload.
     *
     * @return string[]
     */
    public function get_accepted_imagetypes()
    {
        return $this->_imagetypes;
    }

    /**
     * Set the list of file extensions that will be accepted for processing on upload.
     *
     * @param string|string[] $imagetypes Either an array or a comma delimited list of file extensions.
     */
    public function set_accepted_imagetypes($imagetypes)
    {
        if( is_array( $imagetypes ) ) {
            $this->_imagetypes = $imagetypes;
        }
        else {
            if( empty($imagetypes) ) {
                $this->_imagetypes = false;
            }
            else if( is_array($imagetypes) ) {
                $this->_imagetypes = $imagetypes;
            }
            else {
                $this->_imagetypes = explode(',',$imagetypes);
            }
        }
    }

    /**
     * Preprocess the uploaded image file.  If the file is in the accepted image types.
     * by default this method will generate a preview image (if enabled), and then optionally watermark it.
     *
     * @param array $fileinfo The fileinfo array passed from the $_FILES upload global.
     * @return string The path and filename of the destination file.
     */
    protected function preprocess_upload($fileinfo)
    {
        $srcname = $fileinfo['tmp_name'];
        if( !$this->is_accepted_imagefile($fileinfo['name']) ) {
            return $srcname;
        }

        if( $this->_do_preview && $this->_preview_size > 0 ) {
            // I guess we're resizing the master image.
            $destdir = dirname($srcname);
            $destname = 'rs_'.basename($srcname);
            $tmpname = $destdir.'/'.$destname;

            cge_image::transform_image($srcname,$tmpname,$this->_preview_size);
            if( !file_exists($tmpname) ) {
                $mod = cge_utils::get_cge();
                $this->set_error($mod->Lang('error_image_transform'));
                return FALSE;
            }
            else if( $this->_delete_orig ) {
                @unlink($srcname);
                @rename($tmpname,$srcname);
            }
            else {
                $srcname = $tmpname;
            }
        }

        if( $this->_do_watermark ) {
            // I guess we're creating a watermark image.
            $destdir = dirname($srcname);
            $destname = 'wm_'.basename($srcname);
            $tmpname = $destdir.'/'.$destname;
            $obj = $this->get_watermark_obj();

            try {
                $res = $obj->create_watermarked_image($srcname,$tmpname);
                @unlink($srcname);
                $srcname = $tmpname;
            }
            catch( \Exception $e ) {
                $this->set_error('WATERMARKING: '.$e->GetMessage());
            }
        }

        return $srcname;
    }


    /**
     * Handle the upload of a file.
     * This method will generate thumbnails from images that are in the accepted filetypes.
     *
     * @param string $name The input field name from the form's input field of type FILE.
     * @param string $destfilename The destination filename.
     * @param bool $subfield
     * @return string The basename of the uploaded file.
     */
    public function handle_upload($name,$destfilename = '',$subfield = false)
    {
        $res = parent::handle_upload($name,$destfilename,$subfield);
        if( !$res ) return false;

        $src = $this->get_dest_filename();
        if( !$this->is_accepted_imagefile($src) ) {
            // not an image file, nothing more to do.
            return $res;
        }

        if( $this->_do_thumbnail && $this->_thumbnail_size > 0 ) {
            // I guess we're making a thumbnail.
            $bn = basename($this->get_dest_filename());
            $filename = 'thumb_'.$bn;
            $dest = cms_join_path($this->get_dest_dir(),$filename);

            // todo: check to see if the input is greater than the thumbnail size.
            cge_image::transform_image($src,$dest,$this->_thumbnail_size);
        }

        return basename($this->get_dest_filename());
    }

}

#
# EOF
#
?>
