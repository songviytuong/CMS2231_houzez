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
 * A simple class to assist with handling PHP file uploads
 *
 * @package CGExtensions
 * @category Utilities
 * @author  calguy1000 <calguy1000@cmsmadesimple.org>
 * @copyright Copyright 2010 by Robert Campbell
 */

/**
 * A simple class to assist with handling PHP file uploads
 *
 * @package CGExtensions
 */
class cg_fileupload
{
    const NOFILE = 'CGFILEUPLOAD_NOFILE';
    const FILESIZE = 'CGFILEUPLOAD_FILESIZE';
    const FILETYPE = 'CGFILEUPLOAD_FILETYPE';
    const FILEEXISTS = 'CGFILEUPLOAD_FILEEXISTS';
    const BADDESTDIR = 'CGFILEUPLOAD_BADDESTDIR';
    const BADPERMS = 'CGFILEUPLOAD_BADPERMS';
    const MOVEFAILED = 'CGFILEUPLOAD_MOVEFAILED';
    const UPLOADFAILED = 'CGFILEUPLOAD_UPLOADFAILED';
    const PREPROCESSING_FAILED = 'CGFILEUPLOAD_PREPROCESSING_FAILED';

    /**
     * @ignore
     */
    private $_maxfilesize;

    /**
     * @ignore
     */
    private $_errno = false;

    /**
     * @ignore
     */
    private $_errmsg = null;

    /**
     * @ignore
     */
    private $_prefix = null;

    /**
     * @ignore
     */
    private $_destdir;

    /**
     * @ignore
     */
    private $_filetypes;

    /**
     * @ignore
     */
    private $_allow_overwrite;

    /**
     * @ignore
     */
    private $_destname;

    /**
     * @ignore
     */
    private $_files;

    /**
     * @ignore
     */
    private $_preprocessor;

    /**
     * @ignore
     */
    private $_origname;


    /**
     * Constructor
     *
     * @param string $prefix A common array key prefix for all files to be handled by this object.
     * @param string $destdir The full path to the destination directory.
     */
    public function __construct($prefix = '',$destdir = '')
    {
        $this->_errno = false;
        $this->_allow_overwrite = false;
        $this->_prefix = $prefix;
        $this->_files = $_FILES;
        $this->_preprocessor = null;

        $config = cmsms()->GetConfig();
        $this->_maxfilesize = $config['max_upload_size'];

        if( empty($destdir) ) $destdir = $config['uploads_path'];
        $this->_destdir = $destdir;
    }


    /**
     * Set a preprocessor object
     *
     * @param callable $func
     */
    public function set_preprocessor($func)
    {
        $this->_preprocessor = $func;
    }


    /**
     * Return the list of accepted file extensions
     *
     * @preturn string[]
     */
    public function get_accepted_filetypes()
    {
        return $this->_filetypes;
    }


    /**
     * Set the list of accepted file extensions
     *
     * @param mixed $filetypes  Accepts an array of strings, or a comma separated list of strings.
     */
    public function set_accepted_filetypes($filetypes)
    {
        if( is_array( $filetypes ) ) {
            $this->_filetypes = $filetypes;
        }
        else {
            if( empty($filetypes) ) {
                $this->_filetypes = false;
            }
            else if( is_array($filetypes) ) {
                $this->_filetypes = $filetypes;
            }
            else {
                $this->_filetypes = explode(',',$filetypes);
            }
        }
  }


    /**
     * Test if the specified filename is among the accepted filetypes
     *
     * @param string $filename
     * @return bool
     */
    public function is_accepted_file($filename)
    {
        $filetypes = $this->get_accepted_filetypes();
        if( is_array($filetypes) && count($filetypes) ) {
            $extension = strrchr($filename,".");
            $found = false;
            foreach( $filetypes as $type ) {
                if( ".".strtolower(trim($type)) == strtolower($extension) ) {
                    $found = true;
                    break;
                }
            }
            if( count($filetypes) && $found === false ) return false;
        }
        return true;
    }


    /**
     * Set the maximum file size for uploaded files (in kilobytes).
     * This method has no effect on the php.ini settings.
     *
     * @param int $size
     */
    public function set_max_filesize($size)
    {
        $this->_maxfilesize = max(1,(int) $size) * 1024;
    }


    /**
     * Set a flag that indicates wether overwriting existing files is permitted.
     *
     * @param bool $flag
     */
    public function set_allow_overwrite($flag = true)
    {
        $this->_allow_overwrite = (bool) $flag;
    }


    /**
     * Get any error code returned after handling the upload.
     * See the error codes contained in this string.
     *
     * @return string
     */
    public function get_error()
    {
        return $this->_errno;
    }

    /**
     * Return a human readable message pertaining to any error code returned after handling the
     * upload.
     *
     * @return string
     */
    public function get_errormsg()
    {
        if( $this->_errmsg ) return $this->_errmsg;
        if( $this->_errno ) {
            $mod = \cms_utils::get_module(MOD_CGEXTENSIONS);
            return $mod->Lang($this->_errno);
        }
    }


    /**
     * Reset any errors
     */
    public function reset_errors()
    {
        $this->_errno = null;
        $this->_errmsg = null;
    }

    /**
     * Set the current error code
     * See error codes defined above.
     *
     * @param string $val
     */
    protected function set_errno($val)
    {
        $this->_errno = $val;
    }


    /**
     * Set a human readable error message.
     *
     * @param string $val
     */
    protected function set_error($val)
    {
        $this->_errmsg = $val;
    }


    /**
     * Return the destination directory for uploaded files
     *
     * @return string
     */
    public function get_dest_dir()
    {
        return $this->_destdir;
    }


    /**
     * Set the destination directory for uploaded files
     *
     * @param string $dir The destination directory
     */
    public function set_dest_dir($dir)
    {
        $this->_destdir = $dir;
    }


    /**
     * Get the optional destination filename.  If any has been specified.
     *
     * @return string
     */
    public function get_dest_filename()
    {
        return $this->_destname;
    }


    /**
     * Get the original filename.
     * This method is only useful after handle_upload has been called.
     */
    public function get_orig_filename()
    {
        // only useful after handle upload
        return $this->_origname;
    }

    /**
     * Check if a file has been uploaded with the specified field name.
     * If specified in the constructor a prefix will be prepended to this name for comparison.
     * This method will not set any of the error members in the object.
     *
     * @param string $name The field name
     * @param string $subfield Assume that the prefix+field name represent an array
     * @return bool
     */
    public function check_upload_attempted($name,$subfield = false)
    {
        $fldname = $this->_prefix.$name;

        if( !isset($this->_files) || !isset($this->_files[$fldname]) ) return FALSE;

        if( !empty($subfield) ) {
            if( !isset($this->_files[$fldname][$subfield]) || !isset($this->_files[$fldname][$subfield]['name']) ||
                empty($this->_files[$fldname][$subfield]['name']) ) {
                return FALSE;
            }
        }
        else {
            if( !is_array($this->_files[$fldname]) || !isset($this->_files[$fldname]['name']) ||
                empty($this->_files[$fldname]['name']) ) {
                return FALSE;
            }
        }
        return TRUE;
    }

    /**
     * Get an adjusted upload filename, using the destname if provided.
     * Note: extension will be preserved in output filename.
     *
     * @param string $input_name The input filename
     * @return string
     */
    protected function get_new_filename( $input_name )
    {
        $newname = $input_name;
        if( !empty($this->_destname) ) {
            $destfilename = $this->_destname;

            // put the extensionof the input file on the new destination name.
            // this prevents a .jpg from being named a .gif or something.
            $destfilename = basename($destfilename);
            $tmp = substr($destfilename,0,strlen($file['name'])-strlen($extension));
            $newname = $tmp.$extension;
        }
        return $newname;
    }

    protected function get_file_record( $field_name, $subfield )
    {
        // note, sets errno

        $fldname = $this->_prefix.$field_name;
        if( !isset($this->_files) || !isset($this->_files[$fldname]) ) {
            $this->_errno = self::NOFILE;
            return false;
        }

        $file = null;
        if( empty($subfield) ) {
            if( !is_array($this->_files[$fldname]) || !isset($this->_files[$fldname]['name']) ||
                empty($this->_files[$fldname]['name']) ) {
                // there's nothing to handle
                $this->_errno = self::NOFILE;
                return false;
            }
            else {
                $file = $this->_files[$fldname];
            }
        }
        else {
            // the files are an array, so each element is an array
            // we gotta build $file from the $_FILES one step at a time
            $tmp = array();
            foreach( $this->_files[$fldname] as $key => $value ) {
                if( isset($value[$subfield]) ) {
                    $tmp[$key] = $value[$subfield];
                }
            }
            $file = $tmp;

            if( !is_array($file) ||
                !isset($file['name']) ||
                empty($file['name']) ) {
                $this->_errno = self::NOFILE;
                return false;
            }
        }
        return $file;
    }

    public function get_uploaded_filename( $field_name, $subfield = null )
    {
        $file = $this->get_file_record( $field_name, $subfield );
        if( !$file ) return;
        return $this->get_new_filename( $file['name'] );
    }

    /**
     * Check if a file has been uploaded to the specified name, and if it is valid.
     * If specified in the constructor a prefix will be prepended to this name for comparison.
     * This method will set internal error strings and numbers on failure.
     *
     * @param string $name The upload key name
     * @param string $subfield Assume that the prefix+field name represent an array
     * @param bool $checkdir Test if the destination directory exists, and is writable.
     * @return bool True on success, false on error.
     */
    public function check_upload($name,$subfield = false,$checkdir = TRUE)
    {
        $file = $this->get_file_record( $name, $subfield );
        if( !$file ) return false;

        // Normalize the file variables
        if (!isset ($file['type'])) $file['type'] = '';
        if (!isset ($file['size'])) $file['size'] = '';
        if (!isset ($file['tmp_name'])) $file['tmp_name'] = '';
        $file['name'] =
            preg_replace('/[^a-zA-Z0-9\.\$\%\'\`\-\@\{\}\~\!\#\(\)\&\_\^]/', '',
                         str_replace(array(' ', '%20'),array ('_', '_'),$file['name']));
        $extension = strrchr($file['name'],".");

        // Check the file size
        if( ($this->_maxfilesize > 0) &&
            ($file['size'] > $this->_maxfilesize) ) {
            $this->_errno = self::FILESIZE;
            return false;
        }

        // Check the file extension
        if( !$this->is_accepted_file($file['name']) ) {
            $this->_errno = self::FILETYPE;
            return false;
        }

        if( !$this->_destdir || !$checkdir ) return true;

        // check the destination directory
        if( !is_dir($this->_destdir) ) {
            $this->_errno = self::BADDESTDIR;
            return false;
        }
        if( !is_writable($this->_destdir) ) {
            $this->_errno = self::BADPERMS;
            return false;
        }

        $newname = $this->get_new_filename( $file['name'] );
        $destname = cms_join_path($this->_destdir,$newname);
        if( file_exists($destname) ) {
            if( !$this->_allow_overwrite ) {
                $this->_errno = self::FILEEXISTS;
                return false;
            }
            else if( !is_writable($destname) ) {
                $this->_errno = self::BADPERMS;
                return false;
            }
        }

        return true;
    }


    /**
     * Handle preprocessing an uploaded file, test for errors and move the file
     * to its destination location.
     *
     * @param string $name The upload key name
     * @param string $destfilename An optional destination filename.
     * @param string $subfield Assume that the prefix+field name represent an array
     * @return bool True on success, false on error.
     */
    public function handle_upload($name,$destfilename='',$subfield = false)
    {
        $fldname = $this->_prefix.$name;
        if( !isset($this->_files) || !isset($this->_files[$fldname]) ) {
            $this->_errno = self::NOFILE;
            return false;
        }

        $file = '';
        if( strlen($subfield) == 0 ) {
            if( !is_array($this->_files[$fldname]) || !isset($this->_files[$fldname]['name']) ||
                empty($this->_files[$fldname]['name']) ) {
                // there's nothing to handle
                $this->_errno = self::NOFILE;
                return false;
            }
            else {
                $file = $this->_files[$fldname];
            }
        }
        else {
            // the files are an array, so each element is an array
            // we gotta build $file from the $_FILES one step at a time
            $tmp = array();
            foreach( $this->_files[$fldname] as $key => $value ) {
                if( isset($value[$subfield]) ) $tmp[$key] = $value[$subfield];
            }
            $file = $tmp;

            if( !is_array($file) || !isset($file['name']) || empty($file['name']) ) {
                $this->_errno = self::NOFILE;
                return false;
            }
        }

        // Normalize the file variables
        if (!isset ($file['type'])) $file['type'] = '';
        if (!isset ($file['size'])) $file['size'] = '';
        if (!isset ($file['tmp_name'])) $file['tmp_name'] = '';
        $file['name'] =
            preg_replace('/[^a-zA-Z0-9\.\$\%\'\`\-\@\{\}\~\!\#\(\)\&\_\^]/', '',
                         str_replace(array(' ', '%20'),array ('_', '_'),$file['name']));
        $extension = strrchr($file['name'],".");

        // Check the file size
        if( (($this->_maxfilesize > 0) && $file['size'] > $this->_maxfilesize) ||
            $file['size'] == 0 ) {
            $this->_errno = self::FILESIZE;
            return false;
        }

        // Check the file extension
        if( !$this->is_accepted_file($file['name']) ) {
            $this->_errno = self::FILETYPE;
            return false;
        }

        // check the destination directory
        if( !is_dir($this->_destdir) ) {
            $this->_errno = self::BADDESTDIR;
            return false;
        }

        if( !is_writable($this->_destdir) ) {
            $this->_errno = self::BADPERMS;
            return false;
        }

        $newname = $this->_origname = $file['name'];
        if( empty($destfilename) && !empty($this->_destname) ) $destfilename = $this->_destname;
        if( !empty($destfilename) ) {
            // put the extensionof the input file on the new destination name.
            // this prevents a .jpg from being named a .gif or something.
            $destfilename = basename($destfilename);
            $textension = strrchr($destfilename,'.');
            $tmp = substr($destfilename,0,strlen($destfilename)-strlen($textension));
            $newname = $tmp.$extension;
        }
        $destname = cms_join_path($this->_destdir,$newname);
        if( !$this->_destname ) $this->_destname = $destname;
        if( file_exists($destname) ) {
            if( !$this->_allow_overwrite ) {
                $this->_errno = self::FILEEXISTS;
                return false;
            }
            else if( !is_writable($destname) ) {
                $this->_errno = self::BADPERMS;
                return false;
            }
        }

        // here we could do any preprocessing on the file.
        $srcname = $file['tmp_name'];
        $tmp = $this->preprocess_upload($file);
        if( !$tmp ) {
            $this->_errno = self::PREPROCESSING_FAILED;
            return false;
        }
        $srcname = $tmp;

        // And Attempt the copy
        $res = @copy( $srcname, $destname );
        if( !$res ) {
            $this->_errno = self::MOVEFAILED;
            return false;
        }

        return $newname;
    }


    /**
     * Preprocess the uploaded file.
     * If a preprocessor has been passed into this object, this method
     * will preprocess the file

     * @param array $fileinfo The file info record (from the $_FILES array) for the file to preprocess.
     * @return string The filename of the pre-processed file on success.  Otherwise, FALSE
     */
    protected function preprocess_upload($fileinfo)
    {
        if( !isset($fileinfo['tmp_name']) ) return FALSE;
        $srcname = $fileinfo['tmp_name'];
        if( $this->_preprocessor ) {
            $tmp = call_user_func($this->_preprocessor,$fileinfo);
            if( !$tmp ) return false;
            $srcname = $tmp;
        }

        return $srcname;
    }


    /**
     * Override the $_FILES array
     *
     * @param array $newfiles.  An overridden files array
     * @internal
     */
    public function set_files(&$newfiles)
    {
        $this->_files = $newfiles;
    }

} // end of class

#
# EOF
#
?>
