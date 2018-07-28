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
 * A class to define a javascript library.
 *
 * @property string $name The library name
 * @property callable $callback An optional callback of the form  function($name) to return javascript code.  Only one of the jsfile, jsurl, callback, or module properties must be specified.
 * @property string[] $depends An array of library names that this library depends upon.
 * @property string $jsfile The complete pathname to the javascript file for this library.  Only one of the jsfile, jsurl, callback, or module properties must be specified.
 * @property string $cssfile The complete pathname to a css file to associate with this libarary
 * @property string $jsurl A URL to a remote javascript library.  Only one of the jsfile, jsurl, callback, or module properties can be specified.
 * @property string $cssurl A complete URL to a remote CSS library.
 * @property string $module The name of a module to query to get javascript code.
 * @property bool   $js_nominify Prevent minifying of the library js code.
 * @property bool   $css_nominify Prevent minifying of the library css code.
 */
class libdefn
{
    /**
     * @ignore
     */
    private $_data = array();

    /**
     * Constructor
     *
     * @param string $name The name of the javascript library we are defiing (should not contain spaces or other characters that require encoding)
     */
    public function __construct($name)
    {
        $this->name = trim($name);
    }

    /**
     * @ignore
     */
    public function __get($key)
    {
        $key = strtolower($key);
        switch( $key ) {
        case 'name':
        case 'callback':
        case 'depends':
        case 'jsfile':
        case 'cssfile':
        case 'jsurl':
        case 'cssurl':
        case 'module':
        case 'js_nominify':
        case 'css_nominify':
            if( isset($this->_data[$key])) return $this->_data[$key];
            break;

        case 'minify_js':
            return !$this->js_nominify;

        case 'minify_css':
            return !$this->css_nominify;

        default:
            stack_trace(); die();
            throw new \CmsInvalidDataException($key.' is not a valid member of a '.__CLASS__.' object');
        }
    }

    /**
     * @ignore
     */
    public function __isset($key)
    {
        $key = strtolower($key);
        switch( $key ) {
        case 'name':
        case 'callback':
        case 'depends':
        case 'jsfile':
        case 'cssfile':
        case 'jsurl':
        case 'cssurl':
        case 'code':
        case 'cssname':
        case 'styles':
        case 'lib':
        case 'module':
        case 'js_nominify':
        case 'css_nominify':
            return isset($this->_data[$key]);

        default:
            throw new \CmsInvalidDataException($key.' is not a valid member of a '.__CLASS__.' object');
        }
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
     * @ignore
     */
    public function __set($key,$val)
    {
        $key = strtolower($key);
        switch( $key ) {
        case 'name':
            $val = strtolower(trim($val));
            if( !$val ) throw new \CmsInvalidDataException('name cannot be empty in a '.__CLASS__.' object');
            $this->_data[$key] = $val;
            break;

        case 'callback':
            if( is_string($val)) $val = trim($val);
            if( $val && !is_callable($val) ) throw new \CmsInvalidDataException('callback not callable for a '.__CLASS__.' object');
            $this->_data[$key] = $val;
            break;

        case 'cssfile':
            if( !$val ) throw new \CmsInvalidDataException('css value must be valid, if specified for a '.__CLASS__.' object');
            if( !is_array($val) ) $val = array($val);
            foreach( $val as $one ) {
                $one = self::_expand_filename($one);
                if( !is_file($one) ) throw new \CmsInvalidDataException('All CSS files must exist if specified for a '.__CLASS__.' object');
            }
            $this->_data[$key] = $val;
            break;

        case 'cssurl':
            if( !$val ) throw new \CmsInvalidDataException('css value must be valid, if specified for a '.__CLASS__.' object');
            if( !is_array($val) ) $val = array($val);
            foreach( $val as $one ) {
                $one = self::_expand_filename($one);
                if( !startswith($one,'http') && !startswith($one,'//') ) {
                    throw new \CmsInvalidDataException('All CSS files must exist if specified for a '.__CLASS__.' object');
                }
            }
            $this->_data[$key] = $val;
            break;

        case 'jsfile':
            if( !$val ) throw new \CmsInvalidDataException('js value must be valid, if specified for a '.__CLASS__.' object');
            if( !is_array($val) ) $val = array($val);
            foreach( $val as $one ) {
                $one = self::_expand_filename($one);
                if( !is_file($one) ) {
                    throw new \CmsInvalidDataException('All JS files must exist if specified for a '.__CLASS__.' object');
                }
            }
            $this->_data[$key] = $val;
            break;

        case 'jsurl':
            if( !$val ) throw new \CmsInvalidDataException('js value must be valid, if specified for a '.__CLASS__.' object');
            if( !is_array($val) ) $val = array($val);
            foreach( $val as $one ) {
                if( !startswith($one,'http') && !startswith($one,'//') ) {
                    throw new \CmsInvalidDataException('All CSS files must exist if specified for a '.__CLASS__.' object');
                }
            }
            $this->_data[$key] = $val;
            break;

        case 'js_nominify':
        case 'css_nominify':
            $this->_data[$key] = \cge_utils::to_bool($val);
            break;

        case 'depends':
            if( $val ) {
                if( !is_array($val) ) $val = explode(',',$val);
                $tmp = array();
                foreach( $val as $one ) {
                    $tmp[] = trim($one);
                }
                $this->_data[$key] = $tmp;
            }
            else {
                $this->_data[$key] = $val;
            }
            break;

        case 'module':
            $this->_data[$key] = trim($val);
            break;

        default:
            throw new \CmsInvalidDataException($key.' is not a valid member of a '.__CLASS__.' object');
        }
    }

    /**
     * Test if this object is valid.
     *
     * @return bool
     */
    public function valid()
    {
        if( $this->name == '' ) return FALSE;
        if( !$this->jsfile && !$this->callback && !$this->module ) return FALSE;
        return TRUE;
    }
} // end of class

?>
