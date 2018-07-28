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
 * A simple class for utilities related to manipulating directories.
 * and searching.  and to include builtin caching
 *
 * @package CGExtensions
 * @category Utilities
 * @author  calguy1000 <calguy1000@cmsmadesimple.org>
 * @copyright Copyright 2010 by Robert Campbell
 */

/**
 * A simple class for utilities related to manipulating directories.
 * and searching.  and to include builtin caching
 *
 * @package CGExtensions
 */
final class cge_dir
{
    /**
     * @ignore
     */
    private function __construct() {}

    /**
     * Recursively remove a directory
     * an alias for recursive_remove_directory
     *
     * @param string $directory The absolute path to the directory to be removed.
     */
    public static function recursive_rmdir($directory)
    {
        return self::recursive_remove_directory($directory);
    }


    /**
     * Recursively remove a directory
     *
     * @param string $directory The absolute path to the directory to be removed.
     */
    public static function recursive_remove_directory($directory)
    {
        if(substr($directory,-1) == '/') $directory = substr($directory,0,-1);
        if(!file_exists($directory) || !is_dir($directory))	{
            return FALSE;
        }
        elseif(is_readable($directory)) {
            $handle = opendir($directory);
            while (FALSE !== ($item = readdir($handle))) {
                if($item != '.' && $item != '..') {
                    $path = $directory.'/'.$item;
                    if (is_dir($path)) {
                        self::recursive_remove_directory($path);
                    } else {
                        unlink($path);
                    }
                }
            }
            closedir($handle);
            if(!rmdir($directory)) return FALSE;
        }
        return TRUE;
    }


    /**
     * Return a list of all of the directories inside a parent
     * This method is NOT recursive
     *
     * @param string $parent The absolute path to the directory to search
     * @return mixed An array of directories directly below the parent, or false.
     */
    static public function dir_list($parent)
    {
        if( empty($parent) ) return false;
        if( !is_dir($parent) ) return false;

        $dh = opendir($parent);
        if( !$dh ) return false;

        $results = array();
        while( ($file = readdir($dh)) !== false ) {
            if( $file == '.' || $file == '..' ) continue;
            if( startswith($file,'.') ) continue;
            if( is_dir($parent.'/'.$file) ) $results[] = $file;
        }
        closedir($dh);

        if( count($results) == 0 ) return false;
        return $results;
    }


    /**
     * A function to return a list of all files in a directory that match a regular expression.
     * This method is not recursive.
     *
     * @deprecated
     * @param string $dir The absolute path to the directory to search
     * @param string $regexp The regular expression
     * @param int $limit The maximum number of results to return.
     */
    public static function file_list_regexp($dir,$regexp,$limit=1000000)
    {
        if( empty($dir) ) return false;
        if( !is_dir($dir) ) return false;

        $dh = opendir($dir);
        if( !$dh ) return false;

        $results = array();
        while( ($file = readdir($dh)) !== false && count($results) < $limit  ) {
            if( $file == '.' || $file == '..' ) continue;
            if( preg_match( '/'.$regexp.'/', $file ) ) $results[] = $file;
        }
        closedir($dh);

        if( count($results) == 0 ) return false;
        return $results;
    }


    /**
     * Recursively create a subdirectory till the path exists
     *
     * @deprecated
     * @param string $pathname The path name to create
     * @param int $mode The octal permission for the newly created subdirectories
     * @return bool
     */
    public static function mkdirr ($pathname, $mode = 0777, $callback = null)
    {
        // Check if directory already exists
        if (is_dir ($pathname) || empty ($pathname)) return TRUE;

        // Ensure a file does not already exist with the same name
        if (is_file ($pathname)) return TRUE; // RC: Modification such that this isn't an error

        // Crawl up the directory tree
        $next_pathname = substr ($pathname, 0, strrpos ($pathname, DIRECTORY_SEPARATOR));
        if (self::mkdirr ($next_pathname, $mode)) {
            if (!file_exists ($pathname)) {
                $res = mkdir ($pathname, $mode);
                if( $res && is_callable($callback) ) call_user_func($callback,$pathmame);
                return $res;
            }
        }

        return FALSE;
    }


    /**
     * Given a directlry, and a list of extensions, return a list of matching files.
     * This method will not return any directories.
     * This method is not recursive.
     *
     * @param string $dir The search directory
     * @param string $extensions A comma delimited list of extensions to return
     * @param bool $sorted Wether the output should be sorted (natural case) or not.
     * @return string[]
     */
    public static function get_file_list($dir,$extensions,$sorted = true)
    {
        $filetypes = array();
        if( !empty($extensions) && !is_array($extensions) ) $filetypes = explode(',',$extensions);

        $tmp = array();
        foreach( $filetypes as $one ) {
            $one = strtolower(trim($one));
            if( $one ) $tmp[] = $one;
        }
        $filetypes = null;
        if( count($tmp) ) $filetypes = $tmp;

        $files = array();
        $dh = opendir( $dir );
        if( $dh ) {
            while (false !== ($file = readdir($dh))) {
                if( $file == '.' || $file == '..' ) continue;

                $fullpath = cms_join_path($dir,$file);
                if( is_dir( $fullpath ) ) continue;

                $ext = substr(strrchr($file, '.'), 1);
                if( count($filetypes) > 0 && !in_array( $ext, $filetypes ) ) continue;

                $files[$file] = $file;
            }
            closedir($dh);
        }

        if( $sorted ) natcasesort($files);

        return $files;
    }


    /**
     * Given a filename, test if it matches the specified pattern
     *
     * @param string $filename The test filename (string) or an array of strings
     * @param mixed $pattern An array of string patterns, or a single string.
     * @param bool $case_sensitive Wether the pattern(s) is/are case sensitive
     * @param bool $allow_empty Wether or not an empty pattern is allowed (to match anything) (deprecated)
     */
    public static function file_matches_pattern($filename,$pattern,$case_sensitive = TRUE,$allow_empty = TRUE)
    {
        if( !is_array($pattern) ) {
            if( !$pattern && $allow_empty ) return TRUE; // no pattern = match everything
            $pattern = array($pattern);
        }
        for( $i = 0, $n = count($pattern); $i < $n; $i++ ) {
            $f = $filename;
            $p = $pattern[$i];
            if( !$p ) continue;
            if( !$case_sensitive ) {
                $f = strtolower($filename);
                $p = strtolower($pattern[$i]);
            }
            if( fnmatch($p,$f) ) return TRUE;
        }
        return FALSE;
    }

    /**
     * Similar to the PHP glob method this function will search all files in the directory (and below it) and return all files that match the pattern.
     *
     * @param string $path The full path to the input directory
     * @param mixed $pattern An array of string patterns.  Or a single string
     * @param string $mode Either FILES, DIRS, or FULL.  If 'FILES', only files matching the pattern are returned.  If 'DIRS' only directories are returned.  IF 'FULL', any file or directory matching the pattern is returned.
     * @param mixed $excludepattern An array of string patterns to exclude.  Or a simple string
     * @param int $maxdepth The maximum dirctory level to search.  Default is infinite.
     * @param int $d Internal
     */
    public static function recursive_glob($path,$pattern,$mode = 'FULL',$excludepattern = '',$maxdepth = -1, $d = 0)
    {
        if( !endswith($path,'/') ) $path .= '/';
        $dirlist = array();
        if( $mode != 'FILES' ) {
            if( self::file_matches_pattern(basename($file),$pattern) && !self::file_matches_pattern(basename($file),$excludepattern) ) {
                $dirlist[] = $path;
            }
        }

        if( !is_dir($path) ) return;
        if( $handle = opendir($path) ) {
            while( false !== ( $file = readdir($handle) ) ) {
                if( $file == '.' || $file == '..' ) continue;

                $fs = $path . $file;
                if ( !@is_dir($fs) && !startswith($file,'.') && !startswith($file,'_') ) {
                    if( $mode != "DIRS" && self::file_matches_pattern($file,$pattern) ) {
                        if( !self::file_matches_pattern($file,$excludepattern,FALSE,FALSE) ) $dirlist[] = $fs;
                    }
                }
                elseif( !startswith($file,'.') && !startswith($file,'_') && $d >= 0 && ($d < $maxdepth || $maxdepth < 0) ) {
                    if( !self::file_matches_pattern($file,$excludepattern,TRUE,FALSE) ) {
                        $tmp = self::recursive_glob( $fs.'/', $pattern, $mode, $excludepattern, $maxdepth, $d+1 );
                        $dirlist = array_merge( $dirlist, $tmp );
                    }
                }
            }
            closedir( $handle );
        }
        return $dirlist;
    }
} // end of class

#
# EOF
#
?>