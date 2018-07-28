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
 * A set of high level convenience methods.
 *
 * @package CGExtensions
 * @category Utilities
 * @author  calguy1000 <calguy1000@cmsmadesimple.org>
 * @copyright Copyright 2010 by Robert Campbell
 */

/**
 * A set of high level convenience methods.
 *
 * @package CGExtensions
 */
final class cge_utils
{
    private static $_dbinstance;

    /**
     * @ignore
     */
    private function __construct() {}

    private static function _newAdodbConnection(\cms_config $config)
    {

        // copied from adodb.functions.php::adodb_connect
        // modified to not support persistent connections
        // @todo: revise this again for cmsms 2.2
        $str = 'pear:date:extend:transaction';
        $dbinstance = ADONewConnection($config['dbms'], $str);
        $dbinstance->raiseErrorFn = "adodb_error";
        if(!empty($config['db_port'])) $dbinstance->port = $config['db_port'];
        $connect_result = $dbinstance->Connect($config['db_hostname'], $config['db_username'], $config['db_password'], $config['db_name']);

        if (FALSE == $connect_result) {
            $str = "Attempt to connect to database failed";
            trigger_error($str,E_USER_ERROR);
            throw new \CmsException($str);
        }

        $dbinstance->SetFetchMode(ADODB_FETCH_ASSOC);
        if ($config['debug']) $dbinstance->debug = true;

        $p1 = [];
        if($config['set_names'] == true) $p1[] = "NAMES 'utf8'";
        if($config['set_db_timezone'] == true) {
            $dt = new DateTime();
            $dtz = new DateTimeZone($config['timezone']);
            $offset = timezone_offset_get($dtz,$dt);
            $symbol = ($offset < 0) ? '-' : '+';
            $hrs = abs((int)($offset / 3600));
            $mins = abs((int)($offset % 3600));
            $p1[] = sprintf("time_zone = '%s%d:%02d'",$symbol,$hrs,$mins);
        }
        if( $p1 ) $dbinstance->Execute('SET '.implode(',',$p1));
        return $dbinstance;
    }

    /**
     * A convenience function to get an adodb object that supports exceptions.
     * Note: This function creates a new database abstraction object.
     *
     * @return adodb object
     */
    public static function &get_db()
    {
        if( is_object(self::$_dbinstance) ) return self::$_dbinstance;

        $config = \cms_config::get_instance();

        if( version_compare(CMS_VERSION,'2.1.99') < 1 ) {
            $_error_handler = function($dbtype,$function_performed,$error_number,$error_message,$host,$database,&$db) {
                throw new \cg_sql_error($error_message.' -- '.$db->ErrorMsg(),$error_number);
            };
            self::$_dbinstance = self::_newAdodbConnection($config);
            self::$_dbinstance->raiseErrorFn = $_error_handler;
        } else {
            $_error_handler = function(\CMSMS\Database\Connection $conn,$errtype, $error_number, $error_message) {
                throw new \cg_sql_error($error_message.' -- '.$conn->ErrorMsg(),$error_number);
            };
            self::$_dbinstance = \CMSMS\Database\compatibility::init($config);
            self::$_dbinstance->SetErrorHandler($_error_handler);
        }
        return self::$_dbinstance;
    }

    /**
     * Convert the supplied unixtime into a database compatible datetime string
     *
     * @deprecated
     * @param int $unixtime
     * @param bool $trim Wether or not to trim quotes from the output
     * return string
     */
    public static function db_time($unixtime,$trim = true)
    {
        $db = self::get_db();
        $tmp = $db->DbTimeStamp($unixtime);
        if( $trim ) $tmp = trim($tmp,"'");
        return $tmp;
    }

    /**
     * Given a datatime string convert it to a unix time
     *
     * @param string $string The datetime string
     * @return int
     */
    public static function unix_time($string)
    {
        // snarfed from smarty.
        $string = trim($string);
        $time = '';
        if(empty($string)) {
            // use "now":
            $time = time();

        } elseif (preg_match('/^\d{14}$/', $string)) {
            // it is mysql timestamp format of YYYYMMDDHHMMSS?
            $time = mktime(substr($string, 8, 2),substr($string, 10, 2),substr($string, 12, 2),
                           substr($string, 4, 2),substr($string, 6, 2),substr($string, 0, 4));

        } elseif (preg_match("/(\d{4})-(\d{2})-(\d{2})\s(\d{2}):(\d{2}):(\d{2})/", $string, $dt)) {
            $time = mktime($dt[4],$dt[5],$dt[6],$dt[2],$dt[3],$dt[1]);
        } elseif (is_numeric($string)) {
            // it is a numeric string, we handle it as timestamp
            $time = (int)$string;
        } else {
            // strtotime should handle it
            $time = strtotime($string);
            if ($time == -1 || $time === false) {
                // strtotime() was not able to parse $string, use "now":
                // but try one more thing
                list($p1,$p2) = explode(' ',$string,2);

                $db = self::get_db();
                $time = $db->UnixTimeStamp($string);
                if( !$time ) {
                    $time = time();
                }
            }
        }

        return $time;
    }

    /**
     * A convenience method to return the list of allowed image extensions that a user is allowed to upload
     *
     * @deprecated
     * @return string
     */
    public static function get_image_extensions()
    {
        $cge = self::get_cge();
        return $cge->GetPreference('imageextensions');
    }

    /**
     * A quick wrapper around cms_utils::get_module that will try to use a module name saved in tmpdata
     * (the module name is stored in tmpdata in each request, for CGExtensions derived modules)
     *
     * @deprecated
     * @see cms_utils::get_module
     * @param string $module_name
     * @param string $version The desired module version
     * @return object The module object.  or null
     */
    public static function &get_module($module_name = '',$version = '')
    {
        if( empty($module_name) ) {
            $version = '';
            if( cge_tmpdata::exists('module') ) $module_name = cge_tmpdata::get('module');
        }
        $out = null;
        if( $module_name ) $out = cms_utils::get_module($module_name,$version);
        return $out;
    }

    /**
     * A convenience function to get the CGExtensions module object reference
     *
     * @see cge_utils::get_module
     * @return object The CGExtensions module object.
     */
    public static function &get_cge()
    {
        return self::get_module(MOD_CGEXTENSIONS);
    }

    /**
     * Given a file name, return it's mime type
     *
     * Requires the fileinfo php extension (which is included by default since PHP 5.3)
     * Throws an exception if the fileinfo extension is not available.
     *
     * @param string $filename - The file name.
     * @return string The returned mime type.
     */
    public static function get_mime_type($filename)
    {
        if( !function_exists('finfo_open') ) throw new \RuntimeException('Problem with host setup.  the finfo_open function does not exist');
        if( is_file($filename) && is_readable($filename) ) {
            $fh = finfo_open(FILEINFO_MIME_TYPE);
            if( $fh ) {
                $mime_type = finfo_file($fh,$filename);
                finfo_close($fh);
                return $mime_type;
            }
        }
    }

    /**
     * A convenience method to send a text file (like a CSV file) to the browser and exit
     * This is a convenience method.  It also handles clearing any data that has already been sent to output buffers.
     *
     * @param string $data The output data
     * @param string $content_type The output MIME type
     * @param string $filename The output filename
     */
    public static function send_data_and_exit($data,$content_type = 'text/plain',$filename = 'report.txt')
    {
        $handlers = ob_list_handlers();
        for ($cnt = 0; $cnt < sizeof($handlers); $cnt++) { ob_end_clean(); }

        header('Pragma: public');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Cache-Control: private',false);
        header('Content-Description: File Transfer');
        header('Content-Type: '.$content_type);
        header("Content-Disposition: attachment; filename=\"$filename\"" );
        header('Content-Transfer-Encoding: binary');
        //header('Content-Length: ' . count($data));

        // send the data
        print($data);

        // don't allow any further processing.
        exit();
    }

    /**
     * A convenience method to view a file in the browser.
     * This is a convenience method.  It also handles clearing any data that has already been sent to output buffers.
     *
     * @param string $file The absolute path to the output file
     * @param string $mime_type The output mime type
     * @param string $filename The output filename (suggested to the browser)
     */
    public static function view_file_and_exit($file,$mime_type = null,$filename = null)
    {
        if( !file_exists($file) ) return false;

        if( empty($mime_type) ) {
            $mime_type = self::get_mime_type($file);
            if( $mime_type == 'unknown' ) $mime_type = 'application/octet-stream';
        }
        if( empty($filename) ) $filename = $file;
        $filename = basename($filename);

        $handlers = ob_list_handlers();
        for ($cnt = 0; $cnt < sizeof($handlers); $cnt++) { ob_end_clean(); }

        header('Pragma: public');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Cache-Control: private',false);
        //header('Content-Description: File Transfer');
        header('Content-Type: '.$mime_type);
        header("Content-Disposition: inline; filename=\"$filename\"" );
        header('Content-Transfer-Encoding: binary');
        /*
          header('Accept-Ranges: bytes');
          header('Content-Length: ' . filesize($file));
        */

        $chunksize = 65535;
        $handle=fopen($file,'rb');
        $contents = '';
        do {
            $data = fread($handle,$chunksize);
            if( strlen($data) == 0 ) break;
            print($data);
        } while(true);
        fclose($handle);

        // don't allow any more processing
        exit();
    }

    /**
     * A convenience method to download a file to the browser, and then exit the current request
     * This method is useful when the user has requested to download a large file.
     * This is a convenience method.  It also handles clearing any data that has already been sent to output buffers.
     *
     * @param string $file The absolute path to the output file
     * @param int $chunksize The amount of data to read from the file at one time
     * @param string $mime_type The output mime type
     * @param string $filename The output filename (suggested to the browser)
     */
    public static function send_file_and_exit($file,$chunksize = 65535,$mime_type = '',$filename = '')
    {
        if( !file_exists($file) ) return false;

        if( empty($mime_type) ) {
            $mime_type = self::get_mime_type($file);
            if( $mime_type == 'unknown' ) $mime_type = 'application/octet-stream';
        }

        if( empty($filename) ) $filename = $file;
        $filename = basename($filename);

        $handlers = ob_list_handlers();
        for ($cnt = 0; $cnt < sizeof($handlers); $cnt++) { ob_end_clean(); }

        header('Pragma: public');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Cache-Control: private',false);
        header('Content-Description: File Transfer');
        header('Content-Type: '.$mime_type);
        header("Content-Disposition: attachment; filename=\"$filename\"" );
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . filesize($file));

        $handle=fopen($file,'rb');
        $contents = '';
        do {
            $data = fread($handle,$chunksize);
            if( strlen($data) == 0 ) break;
            print($data);
        } while(true);
        fclose($handle);

        // don't allow any more processing
        exit();
    }

    /**
     * Given an output array or object, encode it to json, and exit.
     * This is a convenience method.  It also handles clearing any data that has already been sent to output buffers.
     *
     * @param mixed $output
     */
    public static function send_ajax_and_exit($output)
    {
        $handlers = ob_list_handlers();
        for ($cnt = 0; $cnt < sizeof($handlers); $cnt++) { ob_end_clean(); }

        header('Pragma: public');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Cache-Control: private',false);
        header('Content-Type: application/json');
        $output = json_encode($output);
        echo $output;
        exit;
    }

    /**
     * Use various methods to return the users real IP address.
     * including when using a proxy server.
     *
     * @return string
     */
    public static function get_real_ip()
    {
        $ip = null;
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {   //check ip from share internet
            $ip=$_SERVER['HTTP_CLIENT_IP'];
        }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {   //to check ip is pass from proxy
            $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else {
            $ip=$_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    /**
     * Given a string input that theoretically represents a boolean value
     * return either true or false.
     *
     * @param mixed $in input value
     * @param boolean $strict Whether strict testing should be used.
     * @return bool
     */
    public static function to_bool($in,$strict = FALSE)
    {
        if( is_bool($in) && $in === TRUE ) return TRUE;
        if( is_bool($in) && $in === FALSE ) return FALSE;
        $in = strtolower($in);
        if( in_array($in,array('1','y','yes','true','t','on')) ) return TRUE;
        if( in_array($in,array('0','n','no','false','f','off')) ) return FALSE;
        if( $strict ) return null;
        return ($in?TRUE:FALSE);
    }

    /**
     * Get the singleton cge_browser object.
     *
     * @return cge_browser
     */
    public static function get_browser()
    {
        static $_browser = null;

        if( $_browser == null ) $_browser = new cge_browser();
        return $_browser;
    }

    /**
     * A platform independent fgets utility.
     * This method understands MAC (\r) as well as DOS/Unix line endings
     *
     * @see fgets
     * @param resource $fh
     * @return string
     */
    public static function fgets($fh)
    {
        if( !$fh || !is_resource($fh) ) return;
        $pos1 = ftell($fh);

        $line = fgets($fh);
        if( strpos($line,"\r") === FALSE ) return $line;

        // there are line endings in here
        // line is probably a crappy mac line.
        $len1 = strlen($line);
        $pos = strpos($line,"\r\n");
        if( $pos !== FALSE ) {
            $len = 2;
        }
        else {
            $pos = strpos($line,"\r");
            $len = 1;
        }

        $line = substr($line,0,$pos);
        fseek($fh,($len1 - $pos - $len ) * -1,SEEK_CUR);
        return $line;
    }

    /**
     * Return the first non null argument.
     * This method accepts a variable number of arguments.
     *
     * @return The first non null argument
     */
    public static function coalesce()
    {
        $args = func_get_args();
        if( !is_array($args) || count($args) == 0 ) return;

        for( $i = 0; $i < count($args); $i++ ) {
            if( !is_null($args[$i]) ) return $args[$i];
        }
    }

    /**
     * Given an associative array, extract the value of one key, with a default.
     * If the key does not exist in the array, or it's value is empty, then the default is used.
     *
     * @param hash $params The input associative array
     * @param string $key The input key to search for
     * @param mixed $dflt The default value
     * @return mixed The value of the element in the array, or the default
     */
    public static function get_param($params,$key,$dflt = null)
    {
        if( isset($params[$key]) ) {
            $tmp = $params[$key];
            if( is_string($tmp) ) $tmp = trim($tmp);
            return $tmp;
            //if( !empty($tmp) ) return $tmp;
        }
        return $dflt;
    }

    /**
     * Given a src specification attempt to resolve it into a filename on the server
     *
     * algorithm:
     *  1.  Check for an absolute filename
     *  2.  Test if the string starts with the uploads url
     *      - replace with uploads path
     *      - check if file exists
     *  3.  Test if the string starts with the root url
     *      - replace with root path
     *      - check if file exists
     *  4.  If string starts with /
     *      - prepend root path
     *      - check if file exists
     *  5.  assume string is relative to uploads path
     *      - checkk if file exists
     *  6.  Test if string starts with the ssl url
     *      - replace with root path
     *      - check if file exists
     *
     * @param string $src the source
     * @return string The filename (if possible).
     */
    public static function src_to_file($src)
    {
        $src = urldecode($src);
        $srcfile = null;
        $config = CmsApp::get_instance()->GetConfig();

        if( file_exists($src) ) $srcfile = $src; // user specified the complete path to the file.
        if( !$srcfile && startswith($src,$config['uploads_url']) ) {
            $tmp = str_replace($config['uploads_url'],$config['uploads_path'],$src);
            if( file_exists($tmp) ) $srcfile = $tmp;
        }
        if( !$srcfile && startswith($src,$config['root_url']) ) {
            $tmp = str_replace($config['root_url'],$config['root_path'],$src);
            if( file_exists($tmp) ) $srcfile = $tmp;
        }
        if( !$srcfile && startswith($src,'/') ) {
            $tmp = cms_join_path($config['root_path'],$src);
            if( file_exists($tmp) ) $srcfile = $tmp;
        }
        if( !$srcfile ) {
            $tmp = cms_join_path($config['uploads_path'],$src);
            if( file_exists($tmp) ) $srcfile = $tmp;
        }
        if( !$srcfile && isset($config['ssl_url']) && startswith($src,$config['ssl_url']) ) {
            $tmp = str_replace($config['ssl_url'],$config['root_path'],$src);
            if( file_exists($tmp) ) $srcfile = $tmp;
        }

        return $srcfile;
    }

    /**
     * Test if the current request is for a secure connection
     *
     * @return bool
     */
    public static function ssl_request()
    {
        if( !isset($_SERVER['HTTPS']) || empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == 'off' ) return FALSE;
        return TRUE;
    }

    /**
     * Convert a filename to a URL.
     * If an absolute path is specified tests are done to compare the input to the image uploads path, the uploads path or the root path of the system.
     * If a relative URL path  is passed a file relative to the root url is assumed.
     *
     * @param string $file the filename to convert to a URL
     * @param bool $force_ssl Force the output url to use HTTPS
     * @return string
     */
    public static function file_to_url($file,$force_ssl = FALSE)
    {
        $config = CmsApp::get_instance()->GetConfig();

        $url = null;
        if( !file_exists($file) ) return $url;

        if( startswith( $file, $config['image_uploads_path'] ) ) {
            $url = str_replace($config['image_uploads_path'],$config['image_uploads_url'],$file);
        }
        else if( startswith( $file, $config['uploads_path']) ) {
            if( self::ssl_request() || $force_ssl ) {
                $url = str_replace($config['uploads_path'],$config['ssl_uploads_url'],$file);
            }
            else {
                $url = str_replace($config['uploads_path'],$config['uploads_url'],$file);
            }
        }
        else if( startswith( $file, $config['root_path']) ) {
            if( self::ssl_request() || $force_ssl ) {
                $url = str_replace($config['root_path'],$config['ssl_url'],$file);
            }
            else {
                $url = str_replace($config['root_path'],$config['root_url'],$file);
            }
        }

        return $url;
    }

    /**
     * An experimental method that attempts to determine if there is enough available PHP memory for a given operation.
     *
     * @param int $needed_memory The estimated amount of memory required
     * @param float $fudge The fudge factor (multiplier) used to buffer available memory.
     * @return bool
     */
    static public function have_enough_memory($needed_memory,$fudge = 2.0)
    {
        $needed_memory = abs((int)$needed_memory);
        $fudge = min(10,max(1,abs((float)$fudge)));
        if( $needed_memory == 0 ) return;
        $needed_memory *= $fudge;

        $diff = self::get_available_memory() - $needed_memory;
        if( $diff > 0 ) return TRUE;
        return FALSE;
    }

    /**
     * An experimental method to determine the amount of available PHP memory remaining
     *
     * @return int
     */
    static public function get_available_memory()
    {
        $MB = 1048576;
        $memory_limit = ini_get('memory_limit');
        if( !$memory_limit ) $memory_limit = self::get_cge()->GetPreference('assume_memory_limit');
        $memory_limit = trim($memory_limit);
        if( !$memory_limit ) $memory_limit = '128M';
        $memory_limit = intval($memory_limit);
        $memory_limit = max(1,$memory_limit);
        $memory_limit *= $MB;

        return $memory_limit - memory_get_usage();
    }

    /**
     * Pretty up, sanitize, and clean user entered html code.
     *
     * @param string $html
     * @return string
     */
    static public function clean_input_html($html)
    {
        require_once(__DIR__.'/htmLawed.php');
        return htmLawed($html,array('safe'=>1,'keep_bad'=>0));
    }

    /**
     * a convenience method to convert a string representing a float value into a float
     *
     * @deprecated
     * @param string $floatString the input string
     * @param string $thousands_sep The thousands separator
     * @param string $decimal_pt The decimal point
     */
    static public function parse_float($floatString,$thousands_sep = null,$decimal_pt = null)
    {
        $LocaleInfo = localeconv();
        if( $thousands_sep == null ) $thousands_sep = $LocaleInfo['mon_thousands_sep'];
        if( !$thousands_sep ) $thousands_sep = $LocaleInfo['thousands_sep'];
        if( !$thousands_sep ) $thousands_sep = ',';
        if( $decimal_pt == null ) $decimal_pt = $LocaleInfo['mon_thousands_sep'];
        if( !$decimal_pt ) $decimal_pt = $LocaleInfo['decimal_point'];
        if( !$decimal_pt ) $decimal_pt = '.';
        $floatString = str_replace($thousands_sep , "", $floatString);
        $floatString = str_replace($decimal_pt , ".", $floatString);
        return (float) floatval($floatString);
    }

    /**
     * A utility function to encrypt parameters for passing through different URL's.
     *
     * This method accepts a parameter array, encrypts it, and returns a parameter array with a single element: _d.
     *
     * @param array $params an associative array
     * @return array
     */
    static public function encrypt_params($params)
    {
        $key = CMS_VERSION.__FILE__;
        $out = [];
        $out['_d'] = base64_encode(cge_encrypt::encrypt($key,serialize($params)));
        return $out;
    }

    /**
     * A utility function to decrypt previously encrypted parameters.
     *
     * This method accepts a parameter array (the output from it's companion method) and decrypts the input.
     *
     * @param array $params an encrypted associative array with at least one element: _d.
     * @return array
     */
    static public function decrypt_params($params)
    {
        $key = CMS_VERSION.__FILE__;
        if( !isset($params['_d']) ) return;

        $tmp = cge_encrypt::decrypt($key,base64_decode($params['_d']));
        $tmp = unserialize($tmp);
        unset($params['_d']);
        $tmp = array_merge($params,$tmp);
        return $tmp;
    }

    /**
     * A convenience function to assist in doing certain tasks only once per day.
     * This method will convert the key into a preference, and then check the value of that preference
     * if it is more than 24 hours since the last time this method was called for this preference
     * then the value of the preference is updated to the current time and FALSE is returned.
     * Otherwise TRUE is returned.
     *
     * @param string $key
     * @return bool
     */
    static public function done_today($key)
    {
        $key = md5(__METHOD__.$key);
        $val = \cms_siteprefs::get($key);
        if( time() - $val < 24 * 3600 ) return TRUE;
        \cms_siteprefs::set($key,time());
        return FALSE;
    }

    /**
     * Swap to variables.
     * Probably should not be used where cloning may be required.
     *
     * @param mixed $a
     * @param mixed $b
     */
    static public function swap(&$a,&$b)
    {
        $tmp = $a;
        $a = $b;
        $b = $tmp;
    }

    /**
     * Dump an exception to the error log.
     */
    static public function log_exception(\Exception $e)
    {
        $out = '-- EXCEPTION DUMP --'."\n";
        $out .= "TYPE: ".get_class($e)."\n";
        $out .= "MESSAGE: ".$e->getMessage()."\n";
        $out .= "FILE: ".$e->getFile().':'.$e->GetLine()."\n";
        $out .= "TREACE:\n";
        $out .= $e->getTraceAsString();
        debug_to_log($out,'-- '.__METHOD__.' --');
    }

    static public function create_guid()
    {
        if (function_exists('com_create_guid') === true) return trim(com_create_guid(), '{}');
        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }
} // class

#
# EOF
#
?>
