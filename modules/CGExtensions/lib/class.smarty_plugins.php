<?php
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: CGExtensions (c) 2008-2014 by Robert Campbell
#         (calguy1000@cmsmadesimple.org)
#  An addon module for CMS Made Simple to provide useful functions
#  and commonly used gui capabilities to other modules.
#
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2005 by Ted Kulp (wishy@cmsmadesimple.org)
# Visit our homepage at: http://www.cmsmadesimple.org
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
namespace CGExtensions;
use \cms_utils;
use \cge_utils;
use \cge_param;
use \cge_url;

final class smarty_plugins
{
    protected function __construct() {}

    static private $_cge_cache_keys;
    static private $_in_tab;

    /**
     * @ignore
     */
    public static function init($smarty)
    {
        $smarty->register_function('cge_yesno_options',  '\\CGExtensions\\smarty_plugins::smarty_function_cge_yesno_options' );
        $smarty->register_function('cge_have_module', '\\CGExtensions\\smarty_plugins::plugin_have_module');

        $smarty->register_block('cgerror', [ '\\CGExtensions\\smarty_plugins', 'blockDisplayError' ]);
        $smarty->register_block('jsmin', [ '\\CGExtensions\\smarty_plugins', 'jsmin' ]);

        $smarty->register_function('cge_cached_url','\\CGExtensions\\smarty_plugins::cge_cached_url');
        $smarty->register_function('cgimage','\\CGExtensions\\smarty_plugins::smarty_function_cgimage');
        $smarty->register_function('cge_helptag','\\CGExtensions\\smarty_plugins::smarty_function_helptag');
        $smarty->register_function('cge_helphandler','\\CGExtensions\\smarty_plugins::smarty_function_helphandler');
        $smarty->register_function('cge_helpcontent','\\CGExtensions\\smarty_plugins::smarty_function_helpcontent');
        $smarty->register_function('cge_state_options', '\\CGExtensions\\smarty_plugins::smarty_function_cge_state_options');
        $smarty->register_function('cge_country_options', '\\CGExtensions\\smarty_plugins::smarty_function_cge_country_options');
        $smarty->register_function('cge_textarea', '\\CGExtensions\\smarty_plugins::smarty_function_cge_textarea');
        $smarty->register_function('get_current_url', '\\CGExtensions\\smarty_plugins::smarty_function_get_current_url');
        $smarty->register_function('cge_str_to_assoc','\\CGExtensions\\smarty_plugins::smarty_function_str_to_assoc');
        $smarty->register_modifier('rfc_date', '\\CGExtensions\\smarty_plugins::smarty_modifier_rfc_date');
        $smarty->register_modifier('time_fmt', '\\CGExtensions\\smarty_plugins::smarty_modifier_time_fmt');
        $smarty->register_modifier('as_num', '\\CGExtensions\\smarty_plugins::smarty_modifier_as_num');
        $smarty->register_modifier('cge_entity_decode', '\\CGExtensions\\smarty_plugins::smarty_modifier_cge_entity_decode');
        $smarty->register_compiler_function('cge_cache', ['\\CGExtensions\\smarty_plugins','cache_start']); // must be an array (smarty bug? )
        $smarty->register_compiler_function('cge_cacheclose',['\\CGExtensions\\smarty_plugins','cache_end' ] );
        $smarty->register_block('cge_cache_block', [ '\\CGExtensions\\smarty_plugins','cge_cache_block' ] );

        $smarty->register_function('cge_module_hint','\\CGExtensions\\smarty_plugins::cge_module_hint');
        $smarty->register_function('cge_file_list','\\CGExtensions\\smarty_plugins::cge_file_list');
        $smarty->register_function('cge_image_list','\\CGExtensions\\smarty_plugins::cge_image_list');
        $smarty->register_function('cge_array_set','\\CGExtensions\\smarty_plugins::cge_array_set');
        $smarty->register_function('cge_array_erase','\\CGExtensions\\smarty_plugins::cge_array_erase');
        $smarty->register_function('cge_array_get','\\CGExtensions\\smarty_plugins::cge_array_get');
        $smarty->register_function('cge_array_getall','\\CGExtensions\\smarty_plugins::cge_array_getall');
        $smarty->register_function('cge_array_copy','\\CGExtensions\\smarty_plugins::cge_array_copy');
        $smarty->register_function('cge_admin_error','\\CGExtensions\\smarty_plugins::cge_admin_error');
        $smarty->register_function('cge_wysiwyg','\\CGExtensions\\smarty_plugins::cge_wysiwyg');
        $smarty->register_modifier('cge_createurl','\\CGExtensions\\smarty_plugins::smarty_modifier_createurl');
        $smarty->register_function('cge_setlist','\\CGExtensions\\smarty_plugins::cge_setlist');
        $smarty->register_function('cge_unsetlist','\\CGExtensions\\smarty_plugins::cge_unsetlist');
        $smarty->register_function('cge_message','\\CGExtensions\\smarty_plugins::cge_message');

        $smarty->register_function('cge_isbot','\\CGExtensions\\smarty_plugins::cge_isbot');
        $smarty->register_function('cge_is_smartphone','\\CGExtensions\\smarty_plugins::cge_is_smartphone');
        $smarty->register_function('cge_getbrowser','\\CGExtensions\\smarty_plugins::cge_get_browser');
        $smarty->register_function('cge_isie','\\CGExtensions\\smarty_plugins::cge_isie');
        $smarty->register_function('cge_listfiles', '\\CGExtensions\\smarty_plugins::cge_listfiles' ); // new

        $smarty->register_function('cge_content_type','\\CGExtensions\\smarty_plugins::cge_content_type');
        $smarty->register_function('cge_start_tabs','\\CGExtensions\\smarty_plugins::cge_start_tabs');
        $smarty->register_function('cge_end_tabs','\\CGExtensions\\smarty_plugins::cge_end_tabs');
        $smarty->register_function('cge_tabheader','\\CGExtensions\\smarty_plugins::cge_tabheader');
        $smarty->register_function('cge_tabcontent_start','\\CGExtensions\\smarty_plugins::cge_tabcontent_start');
        $smarty->register_function('cge_tabcontent_end','\\CGExtensions\\smarty_plugins::cge_tabcontent_end');

        $smarty->register_function('cgjs_render','\\CGExtensions\\smarty_plugins::cgjs_render');
        $smarty->register_function('cgjs_require','\\CGExtensions\\smarty_plugins::cgjs_require');
        $smarty->register_block('cgjs_add',  [ '\\CGExtensions\\smarty_plugins','cgjs_add' ] );
        $smarty->register_block('cgcss_add', [ '\\CGExtensions\\smarty_plugins','cgcss_add' ] );

        // should be admin only
        $smarty->register_function('cge_pageoptions','\\CGExtensions\\smarty_plugins::cge_pageoptions');

        global $CMS_ADMIN_PAGE;
        if( !isset($CMS_ADMIN_PAGE) ) return;
        $smarty->register_function('cge_filepicker','\\CGExtensions\\smarty_plugins::cge_filepicker');
    }

    /***
     * A smarty function for creating a list of state options
     */
    public static function smarty_function_cge_state_options($params,$smarty)
    {
        $selected = \cge_utils::get_param($params,'selected');
        if( is_string($selected) ) $selected = explode(',',$selected);
        if( !is_array($selected) ) $selected = [];

        $db = \cge_utils::get_db();
        $obj = \cge_utils::get_module(MOD_CGEXTENSIONS);

        $query = 'SELECT * FROM '.CGEXTENSIONS_TABLE_STATES.' ORDER BY sorting ASC,name ASC';
        $tmp = $db->GetAll($query);
        $output = '';
        if( isset($params['selectone']) ) $output .= '<option value="">'.trim($params['selectone'])."</option>\n";
        foreach( $tmp as $row ) {
            $output .= "<option value=\"{$row['code']}\"";
            if( in_array($row['code'],$selected ) ) $output .= ' selected="selected"';
            $output .= ">{$row['name']}</option>\n";
        }
        return $output;
    }

    /***
     * A smarty function for creating a list of country options
     */
    public static function smarty_function_cge_country_options($params,$smarty)
    {
        $obj = \cge_utils::get_module(MOD_CGEXTENSIONS);

        $list = $obj->get_country_list();
        if( ( $str = cge_param::get_string($params,'selectone')) ) {
            $list = array_merge( [ [ 'id'=>0, 'code'=>'', 'name'=>$str, 'sorting'=>0 ] ], $list );
        }
        $selected = \cge_utils::get_param($params,'selected');
        if( is_string($selected) ) $selected = explode(',',$selected);
        if( !is_array($selected) ) $selected = [];

        $output = null;
        foreach($list as $row) {
            $output .= "<option value=\"{$row['code']}\"";
            if( in_array($row['code'],$selected) ) $output .= ' selected="selected"';
            $output .= ">{$row['name']}</option>\n";
        }
        return $output;
    }


    /*
     * A smarty plugin for displaying the current page url
     */
    public static function smarty_function_get_current_url($params, $smarty)
    {
        $url = cge_url::current_url();
        if( isset($params['assign']) ) {
            $smarty->assign($params['assign'],$url);
            return;
        }
        return $url;
    }


    /*
     * A smarty function to output a yes/no dropdown.
     */
    public static function smarty_function_cge_yesno_options($params,$smarty)
    {
        $mod = cge_utils::get_module(MOD_CGEXTENSIONS);
        $name = '';
        $prefix = '';
        $selected = '';
        $out = '';
        $seltxt = '';
        $id = trim(cge_utils::get_param($params,'id'));
        $class = trim(cge_utils::get_param($params,'class'));

        if( isset($params['prefix']) ) $prefix = trim($params['prefix']);
        if( isset($params['name']) ) $name = trim($params['name']);
        if( isset($params['selected']) ) $selected = trim($params['selected']);
        if( !empty($name) ) {
            $out .= "<select name=\"{$prefix}{$name}\"";
            if( !empty($id) ) $out .= " id=\"{$id}\"";
            if( !empty($class) ) $out .= " class=\"{$class}\"";
            $out .= '>';
        }
        if( $selected == 1 ) $seltxt = ' selected="selected"';

        $out .= '<option value="1"'.$seltxt.'>'.$mod->Lang('yes').'</option>';
        $seltxt = '';
        if( $selected == 0 ) $seltxt = ' selected="selected"';
        $out .= '<option value="0"'.$seltxt.'>'.$mod->Lang('no').'</option>';
        if( !empty($name) ) $out .= "</select>";

        if( isset($params['assign']) ) {
            $smarty->assign($params['assign'],$out);
            return;
        }
        return $out;
    }


    /*
     * A smarty plugin for testing if a module is available.
     */
    public static function plugin_have_module($params, $smarty)
    {
        $name = '';
        $trythis = array('module','mod','m');
        foreach( $trythis as $one ) {
            if( isset($params[$one]) ) {
                $name = trim($params[$one]);
                break;
            }
        }
        $res = 0;
        if( !empty($name) ) {
            $tmp = cge_utils::get_module($name);
            $res = (is_object($tmp))?1:0;
        }

        if( isset($params['assign']) ) {
            $smarty->assign($params['assign'],$res);
            return;
        }
        return $res;
    }


    /*
     * A smarty function for displaying an image
     */
    public static function smarty_function_cgimage($params, $smarty)
    {
        $obj = $smarty->get_template_vars('mod');
        if( !is_object($obj) )  $obj = cge_utils::get_module(MOD_CGEXTENSIONS);

        if( !isset($params['image']) ) return;

        $alt = trim($params['image']);
        if( isset($params['alt']) ) $alt = htmlentities(trim($params['alt']),ENT_QUOTES);
        $class = '';
        if( isset($params['class']) ) $class = trim($params['class']);
        $height = '';
        if( isset($params['width']) ) $width = trim($params['width']);
        $width = '';
        if( isset($params['height']) ) $height = trim($params['height']);

        //$obj->_load_main();
        $txt = $obj->DisplayImage(trim($params['image']),$alt,$class,$width,$height);

        if( isset($params['assign']) ) {
            $smarty->assign(trim($params['assign']),$txt);
        }
        else {
            return $txt;
        }
    }


  /*
   * A smarty function for displaying a help image
   */
  public static function smarty_function_helptag($params, $smarty)
  {
      $obj = cge_utils::get_module(MOD_CGEXTENSIONS);

      $image = 'icons/system/info.gif';
      $alt = $obj->Lang('whatsthis');
      $width = '';
      $height = '';
      $class = 'help';

      if( !isset($params['key']) ) return;
      $key = trim($params['key']);

      $image = 'icons/system/info.gif';
      $alt = $obj->Lang('whatsthis');
      $width = '';
      $height = '';
      $class = 'help';

      if( !isset($params['key']) ) return;
      $key = trim($params['key']);

      if( isset($params['alt']) ) $alt = trim($params['alt']);
      if( isset($params['class']) ) $class = trim($params['class']);

      $img = $obj->DisplayImage($image,$alt,'',$width,$height);
      $txt = '<a href="#'.$key.'" class="'.$class.'">'.$img.'</a>';

      if( isset($params['assign']) ) {
          $smarty->assign(trim($params['assign']),$txt);
          return;
      }
      return $txt;
  }

    /*
     * A smarty function for displaying a help image
     */
    public static function smarty_function_helphandler($params, $smarty)
    {
        $class = 'help';
        if( isset($params['class']) ) $class = trim($params['class']);

        $js = '<script type="text/javascript">$(document).ready(function(){
      $(\'a.'.$class.'\').click(function(){
        var v = $(this).attr(\'href\').substr(1);
        $(\'#\'+v).dialog({
          width: \'auto\'
        });
        return false;
      });
    })</script>';

        if( isset($params['assign']) ) {
            $smarty->assign($params['assign'],$js);
            return;
        }
        return $js;
    }

    /*
     * A smarty function for outputting help text.
     */
    public static function smarty_function_helpcontent($params, $smarty)
    {
        if( !isset($params['key']) ) return;
        if( !isset($params['text']) ) return;

        $mod = cge_utils::get_module(MOD_CGEXTENSIONS);
        $title = $mod->Lang('help');
        $key = trim($params['key']);
        $text = trim($params['text']);
        if( isset($params['title']) ) $title = trim($params['title']);

        $out = '<div id="'.$key.'" title="'.$title.'" class="helpcontent">'.$text.'</div>';

        if( isset($params['assign']) ) {
            $smarty->assign($params['assign'],$out);
            return;
        }
        return $out;
    }

    public static function smarty_modifier_time_fmt($val,$show_hours = TRUE,$show_minutes = TRUE,$show_seconds = FALSE,$delimiter = ':')
    {
        $val = (int)$val;
        $arr = [];
        if( $show_hours ) $arr[] = sprintf('%02s',floor($val / 3600)); // hours
        if( $show_minutes ) $arr[] = sprintf('%02s',floor($val % 3600 / 60)); // minutes
        if( $show_seconds ) $arr[] = sprintf('%02s',floor($val % 60)); // seconds.
        $out = implode($delimiter,$arr);
        return $out;
    }

    public static function smarty_modifier_as_num($val,$nd = 0, $dp = null,$ts = null)
    {
        $nd = max(0,(int) $nd);
        $lc = localeconv();
        if( is_null($dp) ) $dp = $lc['decimal_point'];
        if( is_null($ts) ) $ts = $lc['thousands_sep'];
        return number_format($val,$nd,$dp,$ts);
    }

    public static function smarty_modifier_rfc_date($string)
    {
        $make_timestamp = function($string) {
            if(empty($string)) {
                $time = time();
            } elseif (preg_match('/^\d{14}$/', $string)) {
                $time = mktime(substr($string, 8, 2),substr($string, 10, 2),substr($string, 12, 2),
                               substr($string, 4, 2),substr($string, 6, 2),substr($string, 0, 4));
            } elseif (is_numeric($string)) {
                $time = (int)$string;
            } else {
                $time = strtotime($string);
                if ($time == -1 || $time === false) {
                    // strtotime() was not able to parse $string, use "now":
                    $time = time();
                }
            }
            return $time;
        };

        $timestamp = '';
        if( $string != '' ) {
            $timestamp = $make_timestamp($string);
        }
        else {
            return;
        }

        $txt = date('r',$timestamp);
        return $txt;
    }


    public static function smarty_modifier_cge_entity_decode($string)
    {
        return html_entity_decode($string,ENT_QUOTES);
    }


    /*
     * A smarty block plugin for displaying an error using
     * a template.  i.e {error}blah blah blah{/error}
     *
     */
    public static function blockDisplayError($params,$content,$smarty,$repeat)
    {
        $txt = '';
        if( trim($content) != '' ) {
            $errorclass = 'error';
            if( isset( $params['errorclass'] ) ) $errorclass = trim($params['errorclass']);
            $obj = cge_utils::get_module(MOD_CGEXTENSIONS);
            $txt = $obj->DisplayErrorMessage($content,$errorclass);
        }

        if( isset( $params['assign'] ) ) {
            $smarty->assign($params['assign'],$txt);
            return '';
        }
        return $txt;
    }


    public static function jsmin($params,$content,$smarty,$repeat)
    {
        require_once(dirname(__FILE__).'/jsmin.php');
        $txt = '';
        if( $content != '' ) $txt = \JSMin::minify($content);

        if( isset( $params['assign'] ) ) {
            $smarty->assign($params['assign'],$txt);
            return;
        }
        return $txt;
    }


    /**
     * A smarty plugin to provide a text area
     */
    public static function smarty_function_cge_textarea($params, $smarty)
    {
        $name = '';
        $wysiwyg = false;
        $syntax = false;
        $content = '';
        $class= '';
        $id = '';
        $rows = 10;
        $cols = 80;
        $required = false;

        if( isset($params['prefix']) ) $name = trim($params['prefix']);
        if( isset($params['name']) ) $name .= trim($params['name']);
        if( isset($params['wysiwyg']) ) $wysiwyg = cge_utils::to_bool(cge_utils::get_param($params,'wysiwyg'));
        if( isset($params['syntax']) ) $syntax = cge_utils::to_bool(cge_utils::get_param($params,'syntax'));
        if( isset($params['required']) ) $required = cge_utils::to_bool(cge_utils::get_param($params,'required'));
        if( isset($params['value']) ) $content = $params['value'];
        if( isset($params['content']) ) $content = $params['content'];
        if( isset($params['class']) ) $class = trim($params['class']);
        if( $name == '' ) return;

        if( $wysiwyg ) $syntax = false; // no syntax and wysiwyg at the same time.

        $id = trim(cge_utils::get_param($params,'id',$id));
        $rows = (int) cge_utils::get_param($params,'rows',$rows);
        $rows = max(1,$rows);
        $cols = (int) cge_utils::get_param($params,'cols',$cols);
        $cols = max(1,$cols);

        $addtext = '';
        if( isset($params['required']) ) {
            $required = cge_utils::to_bool($params['required']);
            if( $required && !$wysiwyg ) $addtext .= ' required';
        }
        if( ($ph = cge_utils::get_param($params,'placeholder')) ) $addtext .= ' placeholder="'.$ph.'"';
        if( ($maxlen = (int) cge_utils::get_param($params,'maxlength')) ) $addtext .= ' placeholder="'.$maxlen.'"';

        $output = create_textarea($wysiwyg,$content,$name,$class,$id,'','',$cols,$rows,'',$syntax,$addtext);

        if( isset($params['assign']) ) {
            $smarty->assign(trim($params['assign']),$output);
            return;
        }
        return $output;
    }


    /*---------------------------------------------------------
      array_to_assoc
      ---------------------------------------------------------*/
    static function smarty_function_str_to_assoc($params,$smarty)
    {
        $input = '';
        $delim1 = ',';
        $delim2 = '=';
        if( isset($params['input']) ) $input = trim($params['input']);
        if( isset($params['delim1']) ) $delim1 = trim($params['delim1']);
        if( isset($params['delim2']) ) $delim2 = trim($params['delim2']);

        if( $input == '' ) return;
        $tmp = \cge_array::explode_with_key($input,$delim2,$delim1);

        if( isset($params['assign']) ) {
            $smarty->assign(trim($params['assign']),$tmp);
            return;
        }
        return $tmp;
    }


    public static function cge_cache_block($params,$content,&$smarty,&$repeat)
    {
        $lifetime = \cge_param::get_int($params,'expires',120);
        $lifetime = max(1,min(1440,$lifetime)); // minutes
        $lifetime *= 60; // seconds
        $config = \cms_config::get_instance();
        $cache_driver = null;

        if( get_userid(FALSE) || $config['debug'] ) return $content;
        $cache_driver = new \cms_filecache_driver([ 'lifetime'=>$lifetime, 'group'=>'cge_cache_block'] );

        // if content is null, it's the openin call
        //    if we have cached content, set repeat to false, get content, set repeat to false, return the content.
        // if content is not null, it's the closing call
        //    set repeat to false
        //    cache the content and return.
        if( is_null($content) ) {
            // opening tag
            $key = \cge_param::get_string($params,'key');
            if( !is_array(self::$_cge_cache_keys) ) self::$_cge_cache_keys = [];
            $lowentropy = \cge_param::get_bool($params,'lowentropy');

            if( !$key && !$lowentropy ) {
                // gotta generate a key.
                $key = 'c'.md5(__METHOD__);
            }
            if( !$key ) throw new \SmartyException("lowentropy specified, but no key specified in call to cge_cache_block");
            // add some entropy into the key.... the current url, and the page context.
            if( !\cge_param::get_bool($params,'lowentropy')) $key = 'c'.md5($key.\cms_utils::get_current_pageid().cge_url::current_url());
            self::$_cge_cache_keys[] = $key;
            if( $cache_driver->exists( $key ) ) {
                $content = $cache_driver->get( $key );
                $repeat = false;
            }
        } else {
            // closing call
            // if we got here, we're setting the cache.
            $repeat = false;
            $key = array_pop(self::$_cge_cache_keys);
            $cache_driver->set( $key, $content );
        }
        return $content;
    }


    public static function cache_start($tag_arg,$smarty)
    {
        $output = $key = '';
        $config = \cms_utils::get_config();
        if( !\cms_cache_handler::get_instance()->can_cache() ) {
            $output = '{';
        }
        else {
            if( !is_array(self::$_cge_cache_keys) ) self::$_cge_cache_keys = [];

            // initialize
            if( is_array($tag_arg) && isset($tag_arg['key']) ) {
                $key = trim($tag_arg['key']);
                $key = '__'.trim(trim($key,"'\""));
                $key .= count(self::$_cge_cache_keys);
            }
            // formulate a key from the backtrace.
            if( !$key ) {
                $nn = null;
                $bt = debug_backtrace();
                while( $nn < 100 ) {
                    $keyr = 'v'.md5(serialize($bt).\cms_utils::get_current_pageid().cge_url::current_url());
                    $key = $keyr.$nn;
                    if( !in_array($key,self::$_cge_cache_keys) ) break;
                    if( !$nn ) $nn = 1;
                    $nn = $nn++;
                }
            }

            if( ! $key ) return '{';
            self::$_cge_cache_keys[] = $key;

            $output = "\$$key=\cms_cache_handler::get_instance()->get('$key','cge_cache'); if(\$$key!=''){echo '<!--cge_cache-->'.\$$key;}else{ob_start();";
        }
        return '<?php '.$output.' ?>';
    }


    public static function cache_end($tag_arg,$smarty)
    {
        $output = '';
        if( !\cms_cache_handler::get_instance()->can_cache() ) {
            $output = '}';
        }
        else {
            if( !is_array(self::$_cge_cache_keys) || count(self::$_cge_cache_keys) == 0 ) {
                throw new Exception('in /cge_cache smarty tag without existing cache data');
            }
            $key = array_pop(self::$_cge_cache_keys);
            if( $key == '' ) throw new Exception('in /cge_cache with invalid key');

            $output = "\$$key=@ob_get_contents();@ob_end_clean();echo \$$key;\cms_cache_handler::get_instance()->set('$key',\$$key,'cge_cache');}";
        }
        return '<?php '.$output.' ?>';
    }

    public static function cge_array_copy($params,$smarty)
    {
        $name = \cge_param::get_string($params,'name');
        $in = \cge_utils::get_param($params,'in');
        if( !$name || !is_array($in) ) return;

        foreach( $in as $key => $value ) {
            self::cge_array_set([ 'array'=>$name, 'key'=>$key, 'value'=>$value ],$smarty);
        }
    }

    public static function cge_array_set($params,$smarty)
    {
        if( !(isset($params['array']) && isset($params['value'])) ) return; // no params, do nothing.
        $arr = get_parameter_value($params,'array');
        $key = get_parameter_value($params,'key');
        $val = get_parameter_value($params,'value');

        if( $arr == '' || $val == '' ) return;

        $data = [];
        if( \cge_tmpdata::exists($arr) ) $data = \cge_tmpdata::get($arr);
        if( !is_array($data) ) return;
        if( $key ) {
            $data[$key] = $val;
        }
        else {
            $data[] = $val;
        }
        \cge_tmpdata::set($arr,$data);
    }


    public static function cge_array_pop($params,$smarty)
    {
        if( !isset($params['array']) ) return;
        $arr = get_parameter_value($params,'array');
        if( !$arr ) return;
        if( !\cge_tmpdata::exists($arr) ) return;
        $data = \cge_array::get($arr);
        if( !is_array($data) ) return;

        $ret = array_pop($data);
        \cge_tmpdata::set($arr,$data);

        if( isset($params['assign']) ) {
            $smarty->assign(trim($params['assign']),$ret);
            return;
        }

        return $ret;
    }


    public static function cge_array_erase($params,$smarty)
    {
        if( !isset($params['array']) || !isset($params['key']) ) {
            // no params, do nothing.
            return;
        }

        $arr = trim($params['array']);
        $key = trim($params['key']);
        if( $arr == '' || $key == '' ) return;
        if( !\cge_tmpdata::exists($arr) ) return;

        $data = \cge_tmpdata::get($arr);
        if( isset($data[$key]) ) unset($data[$key]);
        if( count(array_keys($data)) == 0 ) {
            \cge_tmpdata::erase($arr);
            return;
        }
        \cge_tmpdata::set($arr,$data);
    }


    public static function cge_array_get($params,$smarty)
    {
        if( !isset($params['array']) || !isset($params['key']) ) return; // no params, do nothing.
        $arr = trim($params['array']);
        $key = trim($params['key']);
        if( $arr == '' || $key == '' ) return;
        if( !\cge_tmpdata::exists($arr) ) return;

        $data = \cge_tmpdata::get($arr);
        if( isset($data[$key]) ) {
            $val = $data[$key];

            if( isset($params['assign']) ) {
                $smarty->assign(trim($params['assign']),$val);
                return;
            }

            return $val;
        }
    }


    public static function cge_array_getall($params,$smarty)
    {
        if( !isset($params['array']) ) return;

        $arr = trim($params['array']);
        if( $arr == '' ) return;
        if( !\cge_tmpdata::exists($arr) ) return;
        $data = \cge_tmpdata::get($arr);
        if( isset($params['assign']) ) {
            $smarty->assign(trim($params['assign']),$data);
            return;
        }

        return $data;
    }


    public static function cge_admin_error($params,$smarty)
    {
        global $CMS_ADMIN_PAGE;
        if( !isset($CMS_ADMIN_PAGE) ) return;
        if( !isset($params['error']) ) return;

        $mod = \cge_utils::get_module(MOD_CGEXTENSIONS);
        $tmp = $mod->ShowErrors($params['error']);

        if( isset($params['assign']) ) {
            $smarty->assign($params['assign'],$tmp);
            return;
        }

        return $tmp;
    }


    public static function cge_isbot($params,$smarty)
    {
        $browser = \cge_utils::get_browser();
        $robot = $browser->isRobot();

        if( isset($params['assign']) ) {
            $smarty->assign($params['assign'],$robot);
            return;
        }
        return $robot;
    }


    public static function cge_get_browser($params,$smarty)
    {
        $browser = \cge_utils::get_browser();
        $res = $browser->getBrowser();

        if( isset($params['assign']) ) {
            $smarty->assign($params['assign'],$res);
            return;
        }
        return $res;
    }

    public static function cge_isie($params,$smarty)
    {
        $browser = \cge_utils::get_browser();
        $res = $browser->getBrowser();
        $res = ($res == \Browser::BROWSER_IE && !$browser->isMobile())?1:0;

        if( isset($params['assign']) ) {
            $smarty->assign($params['assign'],$res);
            return;
        }
        return $res;
    }


    public static function cge_is_smartphone($params,$smarty)
    {
        $browser = \cge_utils::get_browser();
        $smartphone = $browser->isMobile();

        if( isset($params['assign']) ) {
            $smarty->assign($params['assign'],$smartphone);
            return;
        }
        return $smartphone;
    }


    public static function cge_wysiwyg($params,$smarty)
    {
        if( !isset($params['wysiwyg']) ) $params['wysiwyg'] = 1;
        return self::smarty_function_cge_textarea($params,$smarty);
    }

    public static function smarty_modifier_createurl($input,$assume_root = TRUE)
    {
        $config = \CmsApp::get_instance()->GetConfig();
        $tmp = strtolower($input);
        if( startswith($tmp,'ftp') || startswith($tmp,'http') ) return $input;
        if( startswith($input,'/') && $assume_root ) {
            // relative url...
            return $config['root_url'].$input;
        }

        $hostpart = substr($input,0,strpos($input,'/'));
        if( strpos($input,'.') === FALSE ) {
            // no dots in host part... it's a path without a starting /
            return $config['root_url'].$input;
        }

        // we don't care about the path stuff.
        return '//'.$input;
    }

    public static function cge_setlist($params,$smarty)
    {
        $name = get_parameter_value($params,'array');
        $name = get_parameter_value($params,'name',$name);
        $key = get_parameter_value($params,'key');
        $val = get_parameter_value($params,'value');

        $name = trim($name);
        $key = trim($key);
        if( !$name || !isset($params['value']) ) return;

        $parts = explode('.',$name);
        $data = [];
        if( !is_array($parts) || count($parts) == 0 ) return;
        if( $key ) $parts[] = $key;

        $smarty = \CmsApp::get_instance()->GetSmarty();
        $name = $parts[0];
        $data = $smarty->get_template_vars($name);
        if( !$data ) $data = [];
        if( !is_array($data) ) $data = array($data);

        // {cge_setlist name='a.b.c.d' value='55'}
        $ref =& $data;
        $i = 0;
        for( $i = 1; $i < count($parts) - 1; $i++ ) {
            if( !isset($ref[$parts[$i]]) || !is_array($ref[$parts[$i]]) ) {
                if( $i < count($parts) - 1 ) $ref[$parts[$i]] = [];
            }
            $ref =& $ref[$parts[$i]];
        }

        // expect a list of values... may contain key/value pairs
        if( strpos($val,'::') === FALSE ) {
            $ref[$parts[$i]] = $val;
        }
        else {
            $tmp = \cge_array::smart_explode($val,'||');
            if( is_array($tmp) && count($tmp) ) {
                $ref[$parts[$i]] = [];
                for( $j = 0; $j < count($tmp); $j++ ) {
                    $k = '';
                    $v = $tmp[$j];
                    if( strpos($v,'::') !== FALSE ) list($k,$v) = explode('::',$tmp[$j],2);
                    if( $k ) $k = trim(trim($k,'"'));
                    if( $v ) $v = trim(trim($v,'"'));
                    if( $k ) {
                        $ref[$parts[$i]][$k] = $v;
                    }
                    else {
                        $ref[$parts[$i]][] = $v;
                    }
                }
            }
        }

        // put the data back
        $smarty->assign($name,$data);
        // done.
    }

    public static function cge_unsetlist($params,$smarty)
    {
        $name = get_parameter_value($params,'array');
        $name = get_parameter_value($params,'name',$name);
        $key = get_parameter_value($params,'key');

        if( !$name || !$key ) return;
        $data = $smarty->get_template_vars($name);
        if( !$data ) return;
        if( !is_array($data) ) return;

        if( !isset($data[$key]) ) return;
        unset($data[$key]);
        $smarty->assign($name,$data);
        // done.
    }

    public static function cge_module_hint($params,$smarty)
    {
        if( !isset($params['module']) ) return;

        $module = trim($params['module']);
        $modobj = cms_utils::get_module($module);
        if( !is_object($modobj) ) return;

        $data = cms_utils::get_app_data('__MODULE_HINT__'.$module);
        if( !$data ) $data = [];

        // warning, no check here if the module understands the parameter.
        foreach( $params as $key => $value ) {
            if( $key == 'module' ) continue;
            $data[$key] = $value;
        }
        cms_utils::set_app_data('__MODULE_HINT__'.$module,$data);
    }

    public static function cge_start_tabs($params,$smarty)
    {
        $mod = cms_utils::get_module(MOD_CGEXTENSIONS);
        $out = $mod->StartTabHeaders();
        if( isset($params['assign']) ) {
            $smarty->assign(trim($params['assign']),$out);
            return;
        }
        return $out;
    }

    public static function cge_end_tabs($params,$smarty)
    {
        $mod = cms_utils::get_module(MOD_CGEXTENSIONS);
        $out = '';
        if( self::$_in_tab ) {
            $out .= $mod->EndTab();
            self::$_in_tab = 0;
        }
        $out .= $mod->EndTabContent();
        if( isset($params['assign']) ) {
            $smarty->assign(trim($params['assign']),$out);
            return;
        }
        return $out;
    }

    public static function cge_tabheader($params,$smarty)
    {
        if( !isset($params['name']) ) return;

        $name = trim($params['name']);
        $label = $name;
        if( isset($params['label']) ) $label = trim($params['label']);

        $modname = $smarty->get_template_vars('actionmodule');
        if( !$modname ) $modname = MOD_CGEXTENSIONS;
        $mod = cms_utils::get_module($modname);
        $out = $mod->SetTabHeader($name,$label);

        if( isset($params['assign']) ) {
            $smarty->assign(trim($params['assign']),$out);
            return;
        }
        return $out;
    }

    public static function cge_tabcontent_start($params,$smarty)
    {
        static $endtabheaders_sent = 0;

        if( !isset($params['name']) ) return;
        $parms2 = $smarty->get_template_vars('actionparams');
        if( !is_array($parms2) ) $parms2 = [];
        $mod = cms_utils::get_module(MOD_CGEXTENSIONS);

        $out = '';
        if( !$endtabheaders_sent ) {
            $out .= $mod->EndTabHeaders();
            $out .= $mod->StartTabContent();
            $endtabheaders_sent = 1;
        }

        if( self::$_in_tab ) {
            $out .= $mod->EndTab();
            self::$_in_tab = 0;
        }

        $out .= $mod->StartTab($params['name'],$parms2);
        self::$_in_tab = 1;

        if( isset($params['assign']) ) {
            $smarty->assign(trim($params['assign']),$out);
            return;
        }
        return $out;
    }

    public static function cge_tabcontent_end($params,$smarty)
    {
        static $endheader_sent = 0;
        $mod = cms_utils::get_module(MOD_CGEXTENSIONS);
        $out = $mod->EndTab();
        self::$_in_tab = 0;

        if( isset($params['assign']) ) {
            $smarty->assign(trim($params['assign']),$out);
            return;
        }
        return $out;
    }


    public static function cge_filepicker($params,$smarty)
    {
        // this is a copy of the cms_filepicker plugin, with one change to fix an error encountered in 2.2
        $profile_name = trim(get_parameter_value($params,'profile'));
        $prefix = trim(get_parameter_value($params,'prefix'));
        $name = trim(get_parameter_value($params,'name'));
        $value = trim(get_parameter_value($params,'value'));
        $top = trim(get_parameter_value($params,'top'));
        $type = trim(get_parameter_value($params,'type'));
        $required = cms_to_bool(get_parameter_value($params,'required'));
        if( !$name ) return;

        $name = $prefix.$name;
        $filepicker = \cms_utils::get_filepicker_module();
        if( !$filepicker ) return;

        $profile = $filepicker->get_profile_or_default($profile_name);
        $parms = [];
        if( $top ) $parms['top'] = $top;
        if( $type ) $parms['type'] = $type;
        if( count($parms) ) {
            $profile = $profile->overrideWith( $parms );
        }

        // todo: something with required.
        $out = $filepicker->get_html( $name, $value, $profile, $required );
        if( isset($params['assign']) ) {
            $template->assign( $params['assign'], $out );
        } else {
            return $out;
        }
    }

    public static function cge_listfiles($params,$smarty)
    {
        $config = \CmsApp::get_instance()->GetConfig();
        $dir = $config['uploads_path'];

        $assign = \cge_param::get_string($params,'assign');
        $exclude_prefix = \cge_param::get_string($params,'exclude_prefix');
        $mask = \cge_param::get_string($params,'mask');
        $tmp = \cge_param::get_string($params,'dir');
        if( $tmp ) {
            $tmp = cms_join_path($dir,$tmp);
            if( is_dir($tmp) ) $dir = $tmp;
        }

        $str = $dir.'/'.$mask;
        $files = glob($str);
        $out = null;
        if( count($files) ) {
            $out = [];
            foreach( $files as $file ) {
                if( is_dir( $file) ) continue;
                $fn = basename($file);
                if( startswith($fn,'.') || startswith($fn,'_') ) continue;
                if( $exclude_prefix && startswith($fn,$exclude_prefix) ) continue;

                $out[] = $dir.'/'.$bn;
            }
        }

        if( $assign ) {
            $smarty->assign($assign,$out);
        } else {
            return $out;
        }
    }

    public static function cge_file_list($params,$smarty)
    {
        $config = \CmsApp::get_instance()->GetConfig();
        $dir = $config['uploads_path'];
        $maxdepth = -1;
        $pattern = '*';
        $excludes = array('_*','.??*');
        $absolute = FALSE;
        $options = FALSE;
        $selected = null;
        $novalue = '';

        // handle the dir param
        $tmp = \cge_param::get_string($params,'dir');
        if( $tmp ) {
            $tmp2 = cms_join_path($dir,$tmp);
            if( is_dir($tmp2) ) $dir = $tmp2;
        }

        // handle the pattern param
        if( isset($params['pattern']) ) {
            $tmp = trim($params['pattern']);
            $pattern = explode('||',$tmp);
        }

        // handle the excludes param
        if( isset($params['excludes']) ) {
            $tmp = trim($params['excludes']);
            $excludes = array_merge($excludes,explode('||',$tmp));
        }

        // handle the maxdepth param
        if( isset($params['maxdepth']) ) {
            $tmp = (int)$params['maxdepth'];
            if( $tmp > 0 ) $maxdepth = $tmp;
        }

        // handle the options param
        if( isset($params['options']) ) $options = \cge_utils::to_bool($params['options']);

        // handle the selected param
        if( isset($params['selected']) ) {
            $options = TRUE;
            $selected = trim($params['selected']);
        }

        // handle the 'novalue' param
        if( isset($params['novalue']) ) $novalue = trim($params['novalue']);;
        if( isset($params['absolute']) ) $absolute = cms_to_bool($params['absolute']);

        $files = \cge_dir::recursive_glob($dir,$pattern,'FILES',$excludes,$maxdepth);
        $out = null;
        if( count($files) ) {
            $out = [];
            foreach( $files as $one ) {
                if( $absolute ) {
                    $out[$one] = $one;
                }
                else {
                    $one = substr($one,strlen($dir));
                    if( startswith($one,'/') ) $one = substr($one,1);
                    $out[$one] = $one;
                }
            }

            if( $options ) {
                $tmp = $out;
                $out = '';
                if( $novalue != '' ) $out .= "<option value=\"\">".$novalue."</option>";
                foreach( $tmp as $k => $v ) {
                    if( $k == $selected ) {
                        $out .= "<option selected=\"selected\" value=\"$k\">$v</option>";
                    }
                    else {
                        $out .= "<option value=\"$k\">$v</option>";
                    }
                }
            }
        }

        if( isset($params['assign']) ) {
            $smarty->assign(trim($params['assign']),$out);
            return;
        }

        return $out;
    }


    public static function cge_image_list($params,$smarty)
    {
        $config = \cms_config::get_instance();
        $dir = $config['uploads_path'];
        $maxdepth = -1;
        $pattern = array('*.jpg','*.jpeg','*.bmp','*.gif','*.png','*.ico','*.svg','*.webp');
        $excludes = array('_*','.??*');
        $absolute = FALSE;
        $thumbs = FALSE;
        $options = FALSE;
        $selected = null;
        $novalue = '';

        // handle the dir param
        $tmp = \cge_param::get_string($params,'dir');
        if( $tmp ) {
            $tmp2 = cms_join_path($config['uploads_path'],$tmp);
            if( is_dir($tmp2) ) $dir = $tmp2;
        }

        // handle the extensions param
        if( isset($params['extensions']) ) {
            $tmp = trim($params['extensions']);
            $pattern = explode('||',$tmp);
        }

        if( isset($params['thumbs']) ) $thumbs = cms_to_bool($params['thumbs']);

        // handle the excludes param
        if( isset($params['excludes']) ) {
            $tmp = trim($params['excludes']);
            $excludes = array_merge($excludes,explode('||',$tmp));
        }

        // handle the maxdepth param
        if( isset($params['maxdepth']) ) {
            $tmp = (int)$params['maxdepth'];
            if( $tmp > 0 ) $maxdepth = $tmp;
        }

        if( isset($params['absolute']) ) $absolute = cms_to_bool($params['absolute']);

        // handle the options param
        if( isset($params['options']) ) $options = cms_to_bool($params['options']);

        // handle the selected param
        if( isset($params['selected']) ) {
            $options = TRUE;
            $selected = trim($params['selected']);
        }

        // handle the 'novalue' param
        if( isset($params['novalue']) ) $novalue = trim($params['novalue']);;
        if( !$thumbs ) $excludes[] = 'thumb_*';

        $files = \cge_dir::recursive_glob($dir,$pattern,'FILES',$excludes,$maxdepth);
        $out = null;

        if( count($files) ) {
            $out = [];
            foreach( $files as $one ) {
                if( $absolute ) {
                    $out[$one] = $one;
                }
                else {
                    $one = substr($one,strlen($dir));
                    if( startswith($one,'/') ) $one = substr($one,1);
                    $out[$one] = $one;
                }
            }

            if( $options ) {
                $tmp = $out;
                $out = '';
                if( $novalue != '' ) $out .= "<option value=\"\">".$novalue."</option>";
                foreach( $tmp as $k => $v ) {
                    if( $k == $selected ) {
                        $out .= "<option selected=\"selected\" value=\"$k\">$v</option>";
                    }
                    else {
                        $out .= "<option value=\"$k\">$v</option>";
                    }
                }
            }
        }

        if( isset($params['assign']) ) {
            $smarty->assign(trim($params['assign']),$out);
            return;
        }
        return $out;
    }

    public static function cge_content_type($params,$smarty)
    {
        $type = \cge_utils::get_param($params,'type');
        if( $type ) \CmsApp::get_instance()->set_content_type($type);
    }

    public static function cge_cached_url($params,$smarty)
    {
        $url = get_parameter_value($params,'url');
        $time = get_paremeter_value($params,'time',120);

        $obj = new cge_cached_remote_file($url,$time);
        $out = $obj->file_get_contents();
        if( isset($params['assign']) ) {
            $smarty->assign($params['assign'],$out);
            return;
        }
        return $out;
    }

    public static function cge_message($params,$smarty)
    {
        $key = get_parameter_value($params,'key');
        if( $key ) {
            if( isset($params['value']) ) {
                $val = trim($params['value']);
                \cge_message::set($key,$val);
            }
            else {
                $val = \cge_message::get($key);
                if( isset($params['assign']) ) {
                    $smarty->assign($params['assign'],$val);
                    return;
                }
                return $val;
            }
        }
    }

    public static function cgjs_require($params,$smarty)
    {
        $lib = trim(\cge_utils::get_param($params,'lib'));
        $cssname = trim(\cge_utils::get_param($params,'cssname'));
        $cssfile = trim(\cge_utils::get_param($params,'cssfile'));
        $cssurl = trim(\cge_utils::get_param($params,'cssurl'));
        $jsfile = trim(\cge_utils::get_param($params,'jsfile'));
        $jsurl = trim(\cge_utils::get_param($params,'jsurl'));
        $depends = \cge_utils::get_param($params,'depends');
        $nominify = cge_param::get_bool($params,'nominify');

        if( $lib ) {
            \CGExtensions\jsloader\jsloader::require_lib($lib,$nominify);
        }
        else if( $jsfile ) {
            \CGExtensions\jsloader\jsloader::add_jsfile($jsfile,$depends,$nominify);
        } else if( $jsurl ) {
            \CGExtensions\jsloader\jsloader::add_jsext($jsurl,$nominify);
        } else if( $cssfile ) {
            \CGExtensions\jsloader\jsloader::add_cssfile($cssfile,$depends,$nominify);
        } else if( $cssname ) {
            \CGExtensions\jsloader\jsloader::require_css($cssname,$depends,$nominify);
        } else if( $cssurl ) {
            \CGExtensions\jsloader\jsloader::add_cssext($cssurl,$nominify);
        }
    }

    public static function cgjs_add($params,$content,$smarty,$repeat)
    {
        if( $content == '' ) return;
        $depends = \cge_utils::get_param($params,'depends');
        $nominify = \cge_param::get_bool($params,'nominify');
        $append = \cge_param::get_bool($params,'append');
        \CGExtensions\jsloader\jsloader::add_js($content,$depends,$nominify,$append);
    }

    public static function cgcss_add($params,$content,$smarty,$repeat)
    {
        if( $content == '' ) return;
        $depends = \cge_utils::get_param($params,'depends');
        $nominify = cge_param::get_bool($params,'nominify');
        $append = \cge_param::get_bool($params,'append');
        \CGExtensions\jsloader\jsloader::add_css($content,$depends,$nominify,$append);
    }

    public static function cgjs_render($params,$smarty)
    {
        $out = \CGExtensions\jsloader\jsloader::render($params);
        if( isset($params['assign']) ) {
            $smarty->assign($params['assign'],$out);
            return;
        }
        return $out;
    }

    public static function cge_pageoptions($params,$smarty)
    {
        $current = trim(\cge_utils::get_param($params,'value'));
        $current = trim(\cge_utils::get_param($params,'selected'));
        $none = \cge_utils::to_bool(\cge_utils::get_param($params,'none'));

        $params['current'] = $current;
        unset($params['value'],$params['selected'],$params['none']);

        $builder = new \CGExtensions\content_list_builder($params);
        $tmp = null;
        if( $none ) {
            $mod = \cge_utils::get_module(MOD_CGEXTENSIONS);
            $tmp .= '<option value="">'.$mod->Lang('none').'</option>';
            $tmp .= '<option disabled="disabled">---</option>';
        }
        $tmp .= $builder->get_options();
        return $tmp;
    }

} // end of class

#
# EOF
#
