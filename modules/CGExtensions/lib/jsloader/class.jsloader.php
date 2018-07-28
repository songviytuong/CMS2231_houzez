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
 * This file contains classes for defining a javascript library.
 *
 * @package CGExtensions
 * @category jsloader
 * @author  calguy1000 <calguy1000@cmsmadesimple.org>
 * @copyright Copyright 2014 by Robert Campbell
 */

namespace CGExtensions\jsloader;

/**
 * A utility class to manage loading and combining javascript libraries and associated stylesheets.
 */
final class jsloader
{
    /**
     * @ignore
     */
    static $_rlibs = array();

    /**
     * @ignore
     */
    static $_required = array();

    /**
     * @ignore
     */
    static $_cache;

    /**
     * @ignore
     */
    static $_resolved;

    /**
     * @ignore
     */
    private function __construct() {}

    /**
     * @ignore
     */
    private static function _load_cache()
    {
        class_exists('\CGExtensions\jsloader\libdefn');
        if( !is_array(self::$_cache) ) {
            $cache = array();
            $cache_key = 'c'.md5(__CLASS__);
            $tmp = \cms_siteprefs::get($cache_key);
            if( $tmp ) $cache = unserialize($tmp);
            self::$_cache = $cache;
        }
    }


    /**
     * @ignore
     */
    private static function _save_cache()
    {
        $cache_key = 'c'.md5(__CLASS__);
        \cms_siteprefs::set($cache_key,serialize(self::$_cache));
    }

    /**
     * @ignore
     */
    private static function _expand_filename($in)
    {
        $smarty = \Smarty_CMS::get_instance();
        $config = \cms_config::get_instance();
        $smarty->assign('root_url',$config['root_url']);
        $smarty->assign('root_path',$config['root_path']);
        return trim($smarty->fetch('string:'.$in));
    }

    /**
     * Register a library definition
     *
     * @param libdefn $rec The library definition to register.
     * @param bool $force Force the libdefn to be registered even if it already has been.
     */
    public static function register(libdefn $rec,$force = FALSE)
    {
        if( !$rec->valid() ) throw new \CmsInvalidDataException('attempt to register js lib with invalid libdefn object');

        $lib = self::_find_lib($rec->name);
        if( !$force && is_object($lib) && $lib == $rec ) {
            return; // nothing to do.
        }

        // add this item
        self::_load_cache();
        self::$_cache[$rec->name] = $rec;
        self::_save_cache();
    }

    /**
     * Unregister all javascript libraries associated with a module.
     *
     * @param string $module_name
     */
    public static function unregister_by_module($module_name)
    {
        self::_load_cache();
        $out = array();
        foreach( self::$_cache as $key => $rec ) {
            if( $rec->module != $module_name ) $out[$key] = $rec;
            return;
        }
        self::$_cache = $out;
        self::_save_cache();
    }

    /**
     * For this request, indicate that a javascript library is required.
     *
     * @param string $name
     * @param bool $nominify If true, the library code will not be minified.
     */
    public static function require_lib($name,$nominify = false)
    {
        if( !is_array($name) ) $name = explode(',',$name);
        foreach( $name as $one_name ) {
            $lib = self::_find_lib($one_name);
            if( !$lib ) throw new \Exception("Unknown required js lib $one_name");
            $obj = $lib;
            if( $nominify ) {
                $obj->js_nominify = true;
                $obj->css_nominify = true;
            }
            self::$_rlibs[] = $obj;
	    self::$_resolved = null;
        }
    }

    /**
     * Add an external javascript library.
     * [experimental]
     *
     * @param string $url
     * @param bool $nominify If true, the library code will not be minified.
     */
    public static function add_jsext($url,$nominify = false)
    {
        // externals cannot have dependencies...
        $obj = new \stdClass;
        $obj->jsurl = $url;
        if( $nominify ) $obj->js_nominify = true;
	self::$_resolved = null;
        self::$_required[] = $obj;
    }

    /**
     * For this request, add a specified javascript file.
     *
     * @param string $file The complete pathname to the javascript file.
     * @param null|string[] $depends array of library names (must already be registered) that this file depends upon.
     * @param bool $nominify If true, the library code will not be minified.
     */
    public static function add_jsfile($file,$depends = null,$nominify = false)
    {
        if( !$file || !is_string($file) ) return;

        // assume full path
        $tryfiles = array($file);

        // assume relative to module directory
        $module_name = \cge_tmpdata::get('module');
        if( $module_name ) {
            $mod = \cms_utils::get_module($module_name);
            if( $mod ) $tryfiles[] = $mod->GetModulePath()."/$file";
        }

        // assume relative to uploads path
        $config = cmsms()->GetConfig();
        $tryfiles[] = $config['uploads_path']."/$file";

        // assume relative to root path
        $tryfiles[] = $config['root_path']."/$file";

        $fnd = null;
        foreach( $tryfiles as $fn ) {
            if( file_exists($fn) ) {
                $fnd = $fn;
                break;
            }
        }
        if( !$fnd ) throw new \CmsInvalidDataException("could not find jsfile $file in any of the searched directories");

        $obj = new \StdClass;
        $obj->jsfile = $fnd;
        if( $depends ) {
            if( !is_array($depends) ) $depends = array($depends);
            $obj->depends = $depends;
        }
        if( $nominify ) $obj->js_nominify = true;
	self::$_resolved = null;
        self::$_required[] = $obj;
    }

    /**
     * Add javascript code to the output for this request.
     *
     * @param string $code The javascript code (script tags are not required)
     * @param null|string[] $depends Array of required javascript libraries.
     * @param bool $nominify If true, the library code will not be minified.
     * @param bool $append If true, this code will be appended after all other scripts.. otherwise included in order
     */
    public static function add_js($code,$depends = null,$nominify = true,$append = false)
    {
        if( !$code || !is_string($code) ) return;

        // todo: remove script tags
        $obj = new \StdClass;
        $obj->append = $append;
        $obj->code = $code;
        if( $depends ) {
            if( !is_array($depends) ) $depends = array($depends);
            $obj->depends = $depends;
        }
        if( $nominify ) $obj->js_nominify = true;
	self::$_resolved = null;
        self::$_required[] = $obj;
    }

    /**
     * @ignore
     */
    public static function require_css($name,$depends = null,$nominify = false)
    {
        $obj = new \stdClass;
        $obj->cssname = trim($name);
        if( $nominify ) $obj->css_nominify = true;
        if( $depends ) {
            if( !is_array($depends) ) $depends = array($depends);
            $obj->depends = $depends;
        }
	self::$_resolved = null;
        self::$_required[] = $obj;
    }

    /**
     * @ignore
     */
    public static function add_cssext($url,$nominify = false,$append = false)
    {
        // externals cannot have dependencies...
        $obj = new \stdClass;
        $obj->append = $append;
        $obj->cssurl = $url;
        $obj->css_nominify = true; // odds are external css is already minified
        if( $nominify ) $obj->css_nominify = true;
	self::$_resolved = null;
        self::$_required[] = $obj;
    }


    /**
     * Add a css file to the output.
     *
     * @param string $file The filename.  If not an absolute path, then search for the file within the current module directory (if any), the uploads path, and then the root path.
     * @param null|string[] $depends Array of libraries that this css file depends upon.
     * @param bool $nominify If true, the library code will not be minified.
     */
    public static function add_cssfile($file,$depends = null,$nominify = true)
    {
        if( !$file || !is_string($file) ) return;

        // assume full path
        $tryfiles = array($file);

        // assume relative to module directory
        $module_name = \cge_tmpdata::get('module');
        if( $module_name ) {
            $mod = \cms_utils::get_module($module_name);
            if( $mod ) $tryfiles[] = $mod->GetModulePath()."/$file";
        }

        // assume relative to uploads path
        $config = cmsms()->GetConfig();
        $tryfiles[] = $config['uploads_path']."/$file";
        $tryfiles[] = $config['root_path']."/$file";

        $fnd = null;
        foreach( $tryfiles as $fn ) {
            if( file_exists($fn) ) {
                $fnd = $fn;
                break;
            }
        }
        if( !$fnd ) throw new \CmsInvalidDataException("could not find jsfile $file in any of the searched directories");

        $obj = new \StdClass;
        $obj->cssfile = $fnd;
        if( $depends ) {
            if( !is_array($depends) ) $depends = array($depends);
            $obj->depends = $depends;
        }
        if( $nominify ) $obj->css_nominify = true;
	self::$_resolved = null;
        self::$_required[] = $obj;
    }

    /**
     * Add static css text to the output.
     *
     * @param string $styles The static CSS text (style tags are not needed).
     * @param array $depends A list of libraries that this css depends upon.
     * @param bool $nominify If true, the library code will not be minified.
     * @param bool $append If true, this code will be appended after all other scripts.. otherwise included in order
     */
    public static function add_css($styles,$depends = null,$nominify = true,$append = false)
    {
        if( !$styles || !is_string($styles) ) return;

        // todo: remove script tags
        $obj = new \StdClass;
        $obj->append = $append;
        $obj->styles = $styles;
        if( $depends ) {
            if( !is_array($depends) ) $depends = array($depends);
            $obj->depends = $depends;
        }
        if( $nominify ) $obj->css_nominify = true;
        self::$_resolved = null;
        self::$_required[] = $obj;
    }

    /**
     * @ignore
     */
    private static function _find_lib($name)
    {
        self::_load_cache();
        if( isset(self::$_cache[$name]) ) return self::$_cache[$name];
    }

    /**
     * @ignore
     */
    private static function _get_sorted_required()
    {
        $out = $append = [];
        foreach( self::$_required as $one ) {
            if( !isset($one->append) || !$one->append ) {
                $out[] = $one;
            } else {
                $append[] = $one;
            }
        }
        return array_merge( $out, $append );
    }

    /**
     * @ignore
     */
    private static function _resolve_dependencies($rec,&$out,$excludes)
    {
        self::_load_cache();
        if( isset($rec->lib) && in_array($rec->lib,$excludes) ) return;
        if( isset($rec->name) && in_array($rec->name,$excludes) ) return;
        if( $rec->module ) {
            $mod = \cms_utils::get_module($rec->module);
            if( !$mod ) throw new \Exception('Missing required module '.$rec->module);
        }

        // if this rec depends on something else
        if( isset($rec->depends) ) {
            $depends = $rec->depends;
            if( !is_array($depends) ) $depends = explode(',',$depends);
            foreach( $depends as $dependency ) {
                $dep = self::_find_lib($dependency);
                if( !$dep ) throw new \Exception('Missing js dependency: '.$dependency);
                self::_resolve_dependencies($dep,$out,$excludes);
            }
        }

        // now handle this item.
        $sig = md5(serialize($rec));
        if( !isset($out[$sig]) ) $out[$sig] = $rec;
    }

    /**
     * Render the output javascript and stylesheets into cachable files
     * and output the appropriate HTML tags.
     *
     * @param array $opts Options for this method (for further reference, see the {cgjs_render} smarty tag.
     * @return string HTML output code.
     */
    public static function render($opts = null)
    {
        if( count(self::$_rlibs) == 0 && count(self::$_required) == 0 ) return; // nothing to do.

        // process options
        $options = array();
        $options['excludes'] = array();
        if( !cmsms()->is_frontend_request() ) {
            // the cmsms admin console includes versions of these.
            $excludes = array();
            $excludes[] = 'jquery';
            $excludes[] = 'ui';
            if( version_compare(CMS_VERSION,'2.1.99') < 0 ) $excludes[] = 'fileupload';
            $options['excludes'] = $excludes;
        }
        if( is_array($opts) ) $options = array_merge_recursive($options,$opts);
        if( isset($options['no_jquery']) && !in_array('jquery',$options['excludes']) ) {
            $options['excludes'][] = 'jquery';
        }
        if( isset($options['excludes']) && count($options['excludes']) ) {
            // clean up the excludes
            $out = array();
            foreach( $options['excludes'] as &$str ) {
                $str = strtolower(trim($str));
                if( !$str ) continue;
                if( !in_array($str,$out) ) $out[] = $str;
            }
            $options['excludes'] = $out;
        }
        $options['lang'] = \CmsNlsOperations::get_current_language();

        // expand some options to simple variables.
        $config = \cms_config::get_instance();
        $cache_lifetime = (isset($options['cache_lifetime'])) ? (int)$options['cache_lifetime'] : 24;
        $tmp = (int)\cge_utils::get_param($config,'cgejs_cachelife') * 3600;
        if( $tmp ) $cache_lifetime = $tmp;
        $cache_lifetime = max($cache_lifetime,0);
        $nocache = (isset($options['no_cache']))?TRUE:FALSE;
        $nocache = \cge_utils::get_param($config,'cgejs_nocache',$nocache);
        $nominify = (isset($options['nominify']))?TRUE:FALSE;  // overrides anything in libs.
        $nominify = \cge_utils::get_param($config,'cgejs_nominify',$nominify);
        $nocsssmarty = (isset($options['nocsssmarty']) || $nominify)?TRUE:$nocache;
        $addkey = \cge_utils::get_param($options,'addkey','');
        $do_js = (isset($options['no_js']))?FALSE:TRUE;
        $do_css = (isset($options['no_css']))?FALSE:TRUE;
        $js_fmt = '<script type="text/javascript" src="%s"></script>';
        $css_fmt = '<link type="text/css" rel="stylesheet" href="%s"/>';
        if( $nocache ) $nominify = true;
        if( !$nominify ) require_once(dirname(__DIR__).'/jsmin.php');

        $get_relative_url = function($filename) {
            $config = \cms_config::get_instance();
            $relative_url = '';
            if( startswith($filename,$config['root_path']) ) {
                $relative_url = str_replace($config['root_path'],$config['root_url'],dirname($filename));
                if( !endswith($relative_url,'/') ) $relative_url .= '/';
                if( startswith($relative_url,'http:') ) $relative_url = substr($relative_url,5);
                if( startswith($relative_url,'https:') ) $relative_url = substr($relative_url,6);
            }
            return $relative_url;
        };

        $fix_css_urls = function($css,$url_prefix) {
            $css_search = '#url\(\s*[\'"]?(.*?)[\'"]?\s*\)#';
            $css_url_fix = function($matches) use ($url_prefix) {
                if( startswith($matches[1],'data:') ) return $matches[0];
                if( startswith($matches[1],'http:') ) return $matches[0];
                if( startswith($matches[1],'https:') ) return $matches[0];
                if( startswith($matches[1],'//') ) return $matches[0];
                //$str = substr($matches[1],0,-1);
                $str = $matches[1];
                return "url('{$url_prefix}{$str}')";
            };
            $out = preg_replace_callback($css_search,$css_url_fix,$css);
            return $out;
        };

        $get_code = function($rec,$type) use (&$get_relative_url,&$fix_css_urls) {
            $config = \cms_config::get_instance();
            if( $type == "js" ) {
                $js = null;
                if( isset($rec->jsfile) ) {
                    $jsfile = $rec->jsfile;
                    if( !is_array($jsfile) ) $jsfile = array($jsfile);
                    $js = null;
                    foreach( $jsfile as $one_file ) {
                        $one_file = self::_expand_filename($one_file);
                        $js .= "/* jsloader // javascript file $one_file */\n";
                        if( is_file($one_file) ) $js .= @file_get_contents($one_file);
                    }
                }
                else if( isset($rec->jsurl) ) {
                    // cache this for at least 24 hours
                    if( startswith($rec->jsurl,$config['root_url']) ) {
                        $fn = str_replace($config['root_url'],$config['root_path'],$rec->jsurl);
                        if( is_file($fn) ) {
                            if( !endswith($js,"\n") ) $js .= "\n";
                            $js .= "/* jsloader // javascript local file from url {$fn} */\n";
                            $js .= file_get_contents($fn);
                        }
                    } else {
                        $crf = new \cge_cached_remote_file($rec->jsurl,48*60);
                        if( $crf->size() ) {
                            if( !endswith($js,"\n") ) $js .= "\n";
                            $js .= "/* jsloader // javascript remote {$rec->jsurl} */\n";
                            $js .= $crf->file_get_contents();
                        }
                    }
                }
                else if( isset($rec->code) ) {
                    $js .= "/* jsloader // javascript inline code */\n";
                    $js .= $rec->code;
                }
                return $js;
            }
            else {
                // css
                $css = null;
                if( isset($rec->cssfile) ) {
                    $cssfile = $rec->cssfile;
                    if( !is_array($cssfile) ) $cssfile = array($cssfile);
                    foreach( $cssfile as $one_file ) {
                        $one_file = self::_expand_filename($one_file);
                        $tmp = file_get_contents($one_file);
                        $css .= "/* jsloader//css file: $one_file */\n";
                        $relative_url = $get_relative_url($one_file);
                        $tmp = $fix_css_urls($tmp,$relative_url);
                        $css .= $tmp;
                    }
                }
                else if( isset($rec->cssname) ) {
                    if( version_compare(CMS_VERSION,'1.99-alpha0') < 0 ) {
                        $query = 'SELECT css_id, css_name, css_text FROM '.cms_db_prefix().'css WHERE css_name = ?';
                        $db = CmsApp::get_instance()->GetDb();
                        $row = $db->GetRow($query,array($rec->cssname));
                        if( !is_array($row) ) return;
                        $css = trim($row['css_text']);
                    }
                    else {
                        $css = \CmsLayoutStylesheet::load($rec->cssname)->get_content();
                    }
                }
                else if( isset($rec->cssurl) ) {
                    if( startswith($rec->cssurl,$config['root_url']) ) {
                        $fn = str_replace($config['root_url'],$config['root_path'],$rec->cssurl);
                        if( is_file($fn) ) {
                            $relative_url = $get_relative_url($fn);
                            $tmp .= file_get_contents($fn);
                            $tmp = $fix_css_urls($tmp,$relative_url);
                            if( !endswith($css,"\n") ) $css .= "\n";
                            $css .= "/* jsloader //css local file from url {$fn} */\n";
                            $css .= $tmp;
                        }
                    } else {
                        $crf = new \cge_cached_remote_file($rec->cssurl,48*60);
                        if( $crf->size() ) {
                            if( !endswith($css,"\n") ) $css .= "\n";
                            $css .= "/* jsloader//css remote {$rec->cssurl} */\n";
                            $css .= $crf->file_get_contents();
                        }
                    }
                }
                else if( isset($rec->styles) ) {
                    $css .= "/* jsloader//css inline code */\n";
                    $css .= $rec->styles;
                }
                return $css;
            }
        };

        $get_minified_code = function($rec,$type) use (&$get_code) {
            /* check for a cached version of this code */
            $fn = PUBLIC_CACHE_LOCATION.'/cgejs_'.md5(__FILE__.serialize($rec).$type).'.cache';
            if( is_file($fn) ) return file_get_contents($fn);

            // not in cache
            // calculate a prefix to go on top of the cache file, and test if we are really minifying
            $code = $prefix = null;
            $do_minify = TRUE;
            if( $type == 'js' ) {
                if( isset($rec->js_nominify) && $rec->js_nominify ) $do_minify = FALSE;
                if( $do_minify && isset($rec->jsfile) ) {
                    $jsfile = $rec->jsfile;
                    if( !is_array($jsfile) ) $jsfile = array($jsfile);
                    foreach ( $jsfile as $one ) {
                        if( strpos($one,'.min') !== FALSE || strpos($one,'.pack') !== FALSE ) {
                            $do_minify = FALSE;
                            break;
                        }
                    }
                }
                if( $do_minify && isset($rec->jsurl) ) {
                    if( strpos($rec->jsurl,'.min') !== FALSE || strpos($rec->jsurl,'.pack') !== FALSE ) {
                        $do_minify = FALSE;
                    }
                }

                $prefix = "/* jsloader // cached javascript // ";
                if( isset($rec->name) ) {
                    $prefix .= $rec->name;
                }
                else if( isset($rec->jsfile) ) {
                    if( is_string($rec->jsfile) ) {
                        $prefix .= $rec->jsfile;
                    } else {
                        $prefix .= $rec->jsfile[0];
                    }
                }
                else if( isset($rec->code) ) {
                    $prefix .= 'inline code';
                }
                $prefix .= " */\n";
            }
            else {
                // CSS
                if( isset($rec->css_nominify) && $rec->css_nominify ) $do_minify = FALSE;
                if( $do_minify && isset($rec->cssfile) ) {
                    $cssfile = $rec->cssfile;
                    if( !is_array($cssfile) ) $cssfile = array($cssfile);
                    foreach ( $cssfile as $one ) {
                        if( strpos($one,'.min') !== FALSE || strpos($one,'.pack') !== FALSE ) {
                            $do_minify = FALSE;
                            break;
                        }
                    }
                }
                if( $do_minify && isset($rec->cssurl) ) {
                    if( strpos($rec->cssurl,'.min') !== FALSE || strpos($rec->cssurl,'.pack') !== FALSE ) {
                        $do_minify = FALSE;
                    }
                }

                $prefix = "/* jsloader // cached css // ";
                if( isset($rec->name) ) {
                    $prefix .= $rec->name;
                }
                else if( isset($rec->cssfile) ) {
                    if( is_string($rec->cssfile) ) {
                        $prefix .= $rec->cssfile;
                    } else {
                        $prefix .= $rec->cssfile[0];
                    }
                }
                else {
                    $prefix .= 'inline code';
                }
                $prefix .= " */\n";
            }

            // get the code.
            $code = $get_code($rec,$type);
            if( $code ) {
                // got code... are we minifying and caching it?
                if( $do_minify ) {
                    $code = \JSMin::minify($code);
                    $code = $prefix.$code;
                    file_put_contents($fn,$code);
                }
                return $code;
            }
        };

        // determine if we have to process all this cruft (which could potentially be very expensive)
        $sig = md5(serialize(self::$_rlibs).serialize(self::$_required).serialize($options).$nocache.$nominify.$cache_lifetime);
        $cache_js = PUBLIC_CACHE_LOCATION."/cgejs_{$sig}.js";
        $cache_css = PUBLIC_CACHE_LOCATION."/cgejs_{$sig}.css";
        $do_js_tag = $do_css_tag = FALSE;
        $do_js2 = $do_css2 = FALSE;
        $do_processing = TRUE;
        if( $nocache ) {
            // forced to rejenerate.
            $do_js2 = $do_css2 = TRUE;
        }
        else {
            /* we can cache */
            $etime = time() - $cache_lifetime * 3600;
            if( is_file($cache_js) ) {
                $mtime1 = @filemtime($cache_js);
                $do_js_tag = TRUE;
                if( $mtime1 < $etime ) {
                    // cache too olo, forced to rebuild
                    $do_js2 = FALSE;
                }
            } else {
                // no file, gotta process.
                $do_js2 = TRUE;
            }

            if( is_file($cache_css) ) {
                $mtime2 = @filemtime($cache_css);
                $do_css_tag = TRUE;
                if( $mtime2 < $etime ) {
                    // cache too old, forced to rebuild
                    $do_css2 = FALSE;
                }
            } else {
                // no file, gotta process.
                $do_css2 = TRUE;
            }
        }

        if( $do_js2 || $do_css2 ) {
            // okay, we have work to do.
            if( is_null(self::$_resolved) ) {
                // now expand all our dependencies.
                $list_0 = array();
                $required = array_merge(self::$_rlibs,self::_get_sorted_required());
                foreach( $required as $rec ) {
                    if( isset($rec->depends) ) {
                        self::_resolve_dependencies($rec,$list_0,$options['excludes']);
                    }
                    else {
                        $sig = md5(serialize($rec));
                        $list_0[$sig] = $rec;
                    }
                }

                // now check for callback items
                // and get their code... this may be an expensive process
                // note: may also have dependencies
                self::$_resolved = array();
                foreach( $list_0 as $rec ) {
                    if( isset($rec->callback) ) {
                        $tmp = call_user_func($rec->callback,$rec->name);
                        if( is_object($tmp) && (isset($tmp->code) || isset($tmp->styles)) ) {
                            self::$_resolved[] = $tmp;
                        }
                    }
                    else {
                        self::$_resolved[] = $rec;
                    }
                }
                unset($required,$list_0);
            }

            //
            // process js
            //
            if( $do_js && $do_js2 && self::$_resolved && count(self::$_resolved) ) {
                $txt = null;
                foreach( self::$_resolved as $rec ) {
                    if( $nominify ) {
                        $txt .= $get_code($rec,'js');
                    } else {
                        $txt .= $get_minified_code($rec,'js');
                    }
                }

                if( $txt ) {
                    $do_js_tag = TRUE;
                    file_put_contents($cache_js,$txt);
                }
            }

            //
            // process css
            //
            if( $do_css && $do_css2 && self::$_resolved && count(self::$_resolved) ) {
                $txt = null;
                foreach( self::$_resolved as $rec ) {
                    if( $nominify ) {
                        $txt .= $get_code($rec,'css');
                    } else {
                        $txt .= $get_minified_code($rec,'css');
                    }
                }

                if( $txt ) {
                    $do_css_tag = TRUE;
                    file_put_contents($cache_css,$txt);
                }

            } // do_css
        } // do processing

        // do the output.
        if( $nocache ) {
            $cache_js .= '?_t='.time();
            $cache_css .= '?_t='.time();
        }

        $out = null;
        if( $do_js_tag ) {
            $cache_url = $config['root_url'].'/tmp/cache/'.basename($cache_js);
            $out .= trim(sprintf($js_fmt,$cache_url))."\n";
        }

        if( $do_css_tag ) {
            $cache_url = $config['root_url'].'/tmp/cache/'.basename($cache_css);
            $out .= trim(sprintf($css_fmt,$cache_url))."\n";
        }

        // all freaking done
        return $out;
    }
}

?>
