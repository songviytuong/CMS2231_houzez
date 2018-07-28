<?php
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: CGSmartImage (c) 2012 by Robert Campbell (calguy1000@cmsmadesimple.org)
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

class CGSIStopHereException extends \Exception {}

final class cgsi_utils
{
    protected function __construct() {}
    static private $_device_data;

    /**
     * Given a fairly loose image type identifier (either an extension, or a mime type that could be somewhat mis-spelled
     * attempt to return a reasonable mime type
     */
    private static function parse_type($str,$dflt = 'image/png')
    {
        $str = strtolower($str);
        while( startswith($str,'.') ) $str = substr($str,1);

        switch( $str ) {
        case 'image/jpeg':
        case 'image/png':
        case 'image/gif':
        case 'image/bmp':
        case 'image/webp':
            return $str;
        case 'image/x-windows-bmp':
        case 'image/x-ms-bmp':
            return 'image/bmp';
        case 'image/jpg':
        case 'jpeg':
        case 'jpg':
            return 'image/jpeg';
        case 'png':
            return 'image/png';
        case 'gif':
            return 'image/gif';
        case 'bmp':
            return 'image/bmp';
        case 'webp':
            return 'image/webp';
        default:
            return $dflt;
        }
    }

    /**
     * Given a mime type for or known image formats, return an extension
     */
    private static function get_extension($mime_type)
    {
        $map = array('image/jpeg'=>'.jpg',
                     'image/png'=>'.png',
                     'image/bmp'=>'.bmp',
                     'image/gif'=>'.gif');
        if( isset($map[$mime_type]) ) return $map[$mime_type];
    }

    /**
     * Return the options for a particular alias
     */
    private static function _get_alias_options($name)
    {
        static $aliases;
        if( !$aliases ) {
            $mod = cms_utils::get_module('CGSmartImage');
            $tmp = $mod->GetPreference('aliases');
            $aliases = 'FALSE';
            if( $tmp ) $aliases = unserialize($tmp);
        }
        if( is_array($aliases) ) {
            $keys = array_keys($aliases);
            for( $i = 0; $i < count($keys); $i++ ) {
                $key = $keys[$i];
                if( $aliases[$key]['name'] == $name ) return $aliases[$key]['options'];
            }
        }
    }

    private static function _expand_quoted_string($str)
    {
        $result = array();
        $col = '';
        $safe = '';
        $prev_char = '';
        for( $i = 0; $i < strlen($str); $i++ ) {
            switch( $str[$i] ) {
            case ' ':
                if( !$safe ) {
                    if( strpos($col,'=') !== FALSE ) {
                        list($k,$v) = explode('=',$col,2);
                        $result[$k] = $v;
                    }
                    $col = '';
                }
                else {
                    $col .= $str[$i];
                }
                break;

            case "'":
            case '"':
                if( $prev_char != '\\' ) {
                    if( $str[$i] == $safe ) {
                        $safe = null;
                    }
                    else {
                        $safe = $str[$i];
                    }
                }
            break;

            default:
                $col .= $str[$i];
                break;
            }

            $prev_char = $str[$i];
        }

        if( strlen($col) != 0 ) {
            if( strpos($col,'=') !== FALSE ) {
                list($k,$v) = explode('=',$col,2);
                $result[$k] = $v;
            }
        }

        return $result;
    }


    private static function _is_stylesheet()
    {
        $tmp = debug_backtrace();
        foreach( $tmp as $elem ) {
            if( isset($elem['function']) && $elem['function'] == 'smarty_cms_function_cms_stylesheet' ) return TRUE;
        }
        return FALSE;
    }

    private static function _min_not0(/* var args */)
    {
        $args = func_get_args();
        $val = $args[0];
        for( $i = 1; $i < count($args); $i++ ) {
            if( $args[$i] > 0 ) $val = min($val,$args[$i]);
        }
        return $val;
    }


    private static function _adjust_sizes_to_aspect_ratio($in_w,$in_h,$max_size)
    {
        // calculate new image size based on max size (for responsive stuff)
        // but never, ever allow upscaling.
        $new_w = $in_w;
        $new_h = $in_h;
        if( $in_w > $in_h && $max_size < $in_w ) {
            $new_w = $max_size;
            $new_h = (int)($new_w * $in_h / $in_w);
        }
        else if( $max_size < $in_h ) {
            $new_h = $max_size;
            $new_w = (int)($new_h * $in_w / $in_h);
        }
        return array($new_w,$new_h);
    }

    public static function color_to_rgb($str)
    {
        $str = trim($str);
        $res = array(0,0,0);

        if( startswith($str,'#') && strlen($str) == 4 ) {
            $r = substr($str,1,1); $r = $r.$r;
            $g = substr($str,2,1); $g = $g.$g;
            $b = substr($str,3,1); $b = $b.$b;
            $res[0] = hexdec($r);
            $res[1] = hexdec($g);
            $res[2] = hexdec($b);
            return $res;
        }

        if( startswith($str,'#') && strlen($str) == 7 ) {
            $res[0] = hexdec(substr($str,1,2));
            $res[1] = hexdec(substr($str,3,2));
            $res[2] = hexdec(substr($str,5,2));
            return $res;
        }

        $tmp = explode(':',$str,3);
        if( is_array($tmp) && count($tmp) == 3 && is_numeric($tmp[0]) && is_numeric($tmp[1]) && is_numeric($tmp[1]) ) {
            $res[0] = (int)$tmp[0];
            $res[1] = (int)$tmp[1];
            $res[2] = (int)$tmp[2];
            return $res;
        }

        // assume it's a color name.
        static $_colors;
        if( !is_array($_colors) ) {
            $fn = __DIR__.'/colors.dat';
            $data = file($fn);
            if( count($data) ) {
                $_colors = array();
                for( $i = 0; $i < count($data); $i++ ) {
                    list($rgb,$name) = explode('-',$data[$i],2);
                    if( !startswith($rgb,'#') || strlen($rgb) != 7 || $name == '' ) continue;

                    $tmp = array();
                    $tmp[0] = hexdec(substr($rgb,1,2));
                    $tmp[1] = hexdec(substr($rgb,3,2));
                    $tmp[2] = hexdec(substr($rgb,5,2));

                    $_colors[strtolower(trim($name))] = $tmp;
                }
            }
        }
        if( is_array($_colors) && isset($_colors[$str]) ) $res = $_colors[$str];
        return $res;
    }

    public static function &process_image($params)
    {
        $mod = cms_utils::get_module(MOD_CGSMARTIMAGE);
        $config = cmsms()->GetConfig();
        $want_transform = 0;
        $do_transform = 0;
        $have_transform = 0;
        $dest_fname = '';
        $dest_url = '';
        $img = '';
        $srcfile = '';
        $rel = 0;
        $outp = array();  // output params
        $outp['id'] = '';
        $outp['name'] = '';
        $outp['class'] = '';
        $outp['style'] = '';
        $outp['src'] = '';
        $outp['dest_file'] = '';
        $outp['width'] = '';
        $outp['height'] = '';
        $outp['error'] = '';
        $outp['output'] = null;
        $opp = array();  // operation params
        $opp['overwrite'] = 0;
        $opp['nobcache'] = 0;
        $opp['noremote'] = 0;
        $opp['noembed'] = 0;
        $opp['noauto'] = 0;
        $opp['noppradjust'] = 0;
        $opp['norotate'] = 0;
        $opp['notimecheck'] = 0;
        $opp['noautoscale'] = 0;
        $opp['notag'] = 0;
        $opp['noresponsive'] = 0;
        $opp['nodpradjust'] = 0;
        $opp['nobreakpoints'] = 0;
        $opp['max_width'] = 0;
        $opp['max_height'] = 0;
        $opp['d_max_width'] = 0;  // device calculated max width (including breakpoints)
        $opp['d_max_height'] = 0;   // device calculated max width (including breakpoints)
        $opp['src'] = '';
        $opp['quality'] = 75;
        $opp['filters'] = array();
        $opp['force_type'] = '';
        $opp['force_ext'] = $mod->GetPreference('force_extension',0);
        $opp['progressive'] = (int) $mod->GetPreference('progressive',0);
        $opp['autoscale_op'] = $mod->GetPreference('autoscale_op','croptofit');
        $cge = cms_utils::get_module(MOD_CGEXTENSIONS);
        $srcimgsize = ''; // src image size
        $lastfilter = null;

        try {
            $tmp = $mod->GetPreference('aliases');
            if( $tmp ) $aliases = unserialize($tmp);

            // first pass... expand aliases and build src
            $new_params = array();
            foreach( $params as $key => $value ) {
                if( startswith($key,'alias') ) {
                    // expand alias
                    $options = self::_get_alias_options($value);
                    if( $options ) {
                        // parse a string into an array of arguments.
                        $data = self::_expand_quoted_string($options);
                        if( is_array($data) ) {
                            foreach( $data as $key => $value ) {
                                $new_params[$key] = $value;
                            }
                        }
                        continue;
                    }
                }
                elseif( startswith($key,'src') && $key != 'src' ) {
                    // handle src1 through src99 arguments.
                    if( !isset($new_params['src']) ) $new_params['src'] = '';
                    if( !empty($new_params['src']) && !endswith($new_params['src'],'/') ) $new_params['src'] .= '/';
                    $new_params['src'] .= $value;
                    continue;
                }

                // everything else just gets added.
                $new_params[$key] = $value;
            }
            $params = $new_params;

            // second pass, build our arrays
            $parse_params = function($parms, $depth = 0) use( &$parse_params, &$opp, &$outp, &$mod ) {
                foreach( $parms as $key => $value ) {
                    $matches = array();
                    if( preg_match('/^filter_[0-9]._/',$key,$matches) ) {
                        $key = substr($key,strlen($matches[0]));
                        $filter = ucwords($key);
                        $args = explode(',',$value);
                        $classname = 'CGImage_'.$filter.'_Filter';
                        if( !class_exists($classname) ) throw new Exception($mod->Lang('error_unknownfilter',$filter));

                        // add it to the ops.
                        $opp['filters'][] = array($classname,$args);
                        // done.
                        continue;
                    }

                    if( startswith($key,'filter_') ) {
                        // handle filter argument.
                        $filter = ucwords(substr($key,strlen('filter_')));
                        $args = explode(',',$value);
                        $classname = 'CGImage_'.$filter.'_Filter';
                        if( !class_exists($classname) ) throw new Exception($mod->Lang('error_unknownfilter',$filter));

                        // add it to the ops.
                        $opp['filters'][] = array($classname,$args);
                        // done.
                        continue;
                    }

                    switch( $key ) {
                    case 'data':
                    if( $depth == 0 ) $parse_params($value,$depth+1);
                    break;

                    case 'class':
                    case 'id':
                    case 'style':
                    case 'name':
                    case 'alt':
                    case 'rel':
                    case 'title':
                    $outp[$key] = trim($value);
                    break;

                    case 'width':
                    case 'height':
                    $outp[$key] = (int)$value;
                    break;

                    case 'max_width':
                    case 'max_height':
                    $opp[$key] = (int)$value;
                    break;

                    case 'src':
                    case 'force_type':
                    case 'autoscale_op':
                    $opp[$key] = trim($value);
                    break;

                    case 'quality':
                    $opp['quality'] = (int)$value;
                    $opp['quality'] = min(100,max(0,$opp['quality']));
                    break;

                    case 'overwrite':
                    case 'notag':
                    case 'noremote':
                    case 'noresponsive':
                    case 'nodpradjust':
                    case 'nobreakpoints':
                    case 'nobcache':
                    case 'noembed':
                    case 'noauto':
                    case 'norotate':
                    case 'notimecheck':
                    case 'force_ext':
                    case 'progressive':
                    $opp[$key] = cge_utils::to_bool($value);
                    break;
                    }
                }
            };

            $parse_params($params);

            if( !$opp['src'] ) throw new Exception($mod->Lang('error_missingparam','src'));

            //
            // find the source image ... the actual filename
            // use some automagic intelligence to find it.
            //
            $relative_to = null;
            $src_decoded = urldecode($opp['src']);
            if( !$srcfile && startswith($src_decoded,$config['uploads_url']) ) {
                $tmp = str_replace($config['uploads_url'],$config['uploads_path'],$src_decoded);
                if( is_file($tmp) ) {
                    $relative_to = 'uploads';
                    $srcfile = $tmp;
                }
            }
            if( !$srcfile && startswith($src_decoded,$config['root_url']) ) {
                $tmp = str_replace($config['root_url'],$config['root_path'],$src_decoded);
                if( is_file($tmp) ) {
                    $relative_to = 'root';
                    $srcfile = $tmp;
                }
            }
            if( !$srcfile && isset($config['ssl_url']) && startswith($src_decoded,$config['ssl_url']) ) {
                $tmp = str_replace($config['ssl_url'],$config['root_path'],$src_decoded);
                if( is_file($tmp) ) {
                    $relative_to = 'root';
                    $srcfile = $tmp;
                }
            }
            if( !$srcfile && startswith($opp['src'],'/') ) {
                // treat as absolute filename
                $rp1 = realpath($config['root_path']);
                $rp2 = realpath($opp['src']);
                if( startswith($rp2,$rp1) && is_file($opp['src']) ) {
                    $relative_to = 'root';
                    $srcfile = $opp['src'];
                }
            }
            if( !$srcfile ) {
                // check relative path wrt the uploads dir.
                $tmp = cms_join_path($config['uploads_path'],$opp['src']);
                $rp1 = realpath($config['uploads_path']);
                $rp2 = realpath($tmp);
                if( startswith($rp2,$rp1) && is_file($tmp) ) {
                    $relative_to = 'uploads';
                    $srcfile = $tmp;
                }
            }
            if( !$srcfile ) {
                // check relative path wrt the root dir.
                $tmp = cms_join_path($config['root_path'],$opp['src']);
                $rp1 = realpath($config['root_path']);
                $rp2 = realpath($tmp);
                if( startswith($rp2,$rp1) && is_file($tmp) ) {
                    $relative_to = 'root';
                    $srcfile = $tmp;
                }
            }
            if( !$srcfile && $opp['noremote'] == 0 &&
                (startswith($opp['src'],'http:') || startswith($opp['src'],'https:') || startswith($opp['src'],'ftp:'))) {
                // okay, gotta assume that ths is a remote file
                // get it, and cache it.
		$src = html_entity_decode( $opp['src'] );
                $cachefile = TMP_CACHE_LOCATION.'/cgsi_'.md5($opp['src']).'.img';
                if( !is_file($cachefile) ) {
                    $data = @file_get_contents($src);
                    if( $data ) {
                        file_put_contents($cachefile,$data);
                        $srcfile = $cachefile;
                    }
                }
                else {
                    $srcfile = $cachefile;
                }
            }

            if( !$srcfile ) {
                throw new Exception($mod->Lang('error_srcnotfound',$opp['src']));
                return $outp;
            }

            // get the source image size
            $srcinfo = getimagesize($srcfile);
            if( !is_array($srcinfo) || count($srcinfo) < 2 ) {
                throw new Exception($mod->Lang('error_srcnotfound',$opp['src']));
            }
            else {
                $srcimgsize = array('width'=>$srcinfo[0],'height'=>$srcinfo[1]);
                $memory_needed = round( $srcinfo[0] * $srcinfo[1]
                                        * (isset($srcinfo['bits'])?$srcinfo['bits']:8)
                                        * (isset($srcinfo['channels'])?$srcinfo['channels']:3) / 8 + 65535 );
                if( $mod->GetPreference('checkmemory',1) && !cge_utils::have_enough_memory($memory_needed) ) {
                    throw new Exception($mod->Lang('error_insufficientmemory').': '.(int)($memory_needed/1024).'k');
                }
            }

            // are we automagically rotating?
            if( !$opp['norotate'] && function_exists('exif_read_data') ) {
                // if there is already a rotate filter in the list, we won't override that.
                $fn = 0;
                for( $f = 0; $f < count($opp['filters']); $f++ ) {
                    if( $opp['filters'][$f][0] == 'CGImage_Rotate_Filter' ) {
                        $fn = 1;
                        break;
                    }
                }

                if( $fn == 0 ) {
                    // we can try to read the exif information to find an orientation.
                    $exif = @exif_read_data($srcfile,0,TRUE);
                    if( is_array($exif) && isset($exif['IFD0']) && isset($exif['IFD0']['Orientation']) &&
                        is_int($exif['IFD0']['Orientation']) ) {

                        // found an orientation, now we gotta figure out what filters to add.
                        $orientation = (int)$exif['IFD0']['Orientation'];
                        $new_filters = array();
                        switch( $orientation ) {
                        case 1:
                            // nothing.
                            break;
                        case 2:
                            // horizontal flip.
                            $new_filters[] = array('CGImage_Flip_Filter',0);
                            break;
                        case 3:
                            // rotate 180
                            $new_filters[] = array('CGImage_Rotate_Filter',array(180));
                            break;
                        case 4:
                            $new_filters[] = array('CGImage_Flip_Filter',1);
                            break;
                        case 5:
                            $new_filters[] = array('CGImage_Flip_Filter',1);
                            $new_filters[] = array('CGImage_Rotate_Filter',array(90));
                            break;
                        case 6:
                            $new_filters[] = array('CGImage_Rotate_Filter',array(90));
                            break;
                        case 7:
                            $new_filters[] = array('CGImage_Flip_Filter',0);
                            $new_filters[] = array('CGImage_Rotate_Filter',array(90));
                            break;
                        case 8:
                            $new_filters[] = array('CGImage_Rotate_Filter',array(-90));
                            break;
                        }

                        $opp['filters'] = array_merge($new_filters,$opp['filters']);
                    }
                }
            }

            // doing responsive images... get device width and height.
            // set it into max_width and max_height
            $device_caps = null;
            if( !$opp['noresponsive'] ) {
                $device_caps = self::get_device_capabilities();

                if( !$device_caps && $mod->GetPreference('assume_responsive') ) {
                    // if assume responsive is enabled.  we are assuming that a cookie will be present providing device capabilities...
                    // if we could not find the cookie then output nothing so that we do not do redundant image processing.
                    // the next request will have the device capabilities (the javascript that generates the cookie forces a reload if it has to set the cookie)
                    $outp['output'] = '<!-- CGSmartImage processing stopped because of assume_responsive preference and no device capabilities found -->';
                    // this is way better than a goto.
                    throw new \CGSIStopHereException('force_responsive enabled');
                }

                if( is_array($device_caps) && isset($device_caps['width']) && isset($device_caps['height']) ) {
                    // we found device capabilities.
                    $dpr = max(1,\cge_param::get_int($device_caps,'dpr',1));

                    // we have to do auto-scaling now, responsive stuff trumps the setting.
                    $opp['noautoscale'] = 0;

                    // merge that data with any max_width and max_height that have already been supplied.
                    $opp['d_max_width'] = (int) $device_caps['width'];
                    $opp['d_max_height'] = (int) $device_caps['height'];

                    // experimental... check for breakpoints
                    // and if a breakpoint can be found, further adjust the max_width and max_height params
                    if( ($tmp = $mod->GetPreference('responsive_breakpoints'))  && !$opp['nobreakpoints'] ) {
                        $tmp = explode(',',$tmp);
                        $bp = array();
                        for( $i = 0; $i < count($tmp); $i++ ) {
                            $t1 = (int)trim($tmp[$i]);
                            if( $t1 > 0 ) $bp[] = $t1;
                        }

                        if( count($bp) ) {
                            // we have valid breakpoints.
                            // find the most suitable one given our max resolution.
                            asort($bp);
                            $lval = max($opp['d_max_width'],$opp['d_max_height']);
                            for( $i = count($bp)-1; $i > 0; $i-- ) {
                                if( $bp[$i] > $lval ) continue;
                                break;
                            }

                            list($max_w,$max_h) = self::_adjust_sizes_to_aspect_ratio($srcimgsize['width'],$srcimgsize['height'],$bp[$i]);
                            $opp['d_max_width'] = (int) $max_w;
                            $opp['d_max_height'] = (int) $max_h;
                        }
                    }
                }
            }

            if( !$opp['noautoscale'] ) {
                $destimgsize['width'] = self::_min_not0($srcimgsize['width'],$opp['max_width'],$opp['d_max_width'],$outp['width']);
                $destimgsize['height'] = self::_min_not0($srcimgsize['height'],$opp['max_height'],$opp['d_max_height'],$outp['height']);

                $dominant = null;
                if( $opp['max_width'] || $outp['width'] ) $dominant = ($dominant) ? 'b' : 'x';
                if( $opp['max_height'] || $outp['height'] ) $dominant = ($dominant) ? 'b' : 'y';
                if( $dominant == 'b' ) $dominant = ($destimgsize['width'] < $destimgsize['height']) ? 'x' : 'y';

                $aspect_ratio = $srcimgsize['width'] / $srcimgsize['height'];
                switch( $dominant ) {
                case 'x': /* x is dominant */
                    // adjust to x dimension, retain aspect ratio
                    $destimgsize['height'] = (int)($destimgsize['width'] / $aspect_ratio);
                    break;
                case 'y': /* y is dominant */
                    // adjust to y dimension, retain aspect ratio
                    $destimgsize['width'] = (int)($destimgsize['height'] * $aspect_ratio);
                    break;
                }

                if( $device_caps && !$opp['nodpradjust'] && isset($device_caps['dpr']) && $device_caps['dpr'] > 1 ) {
                    // this will adjust the destination width and height based on dpr
                    $tmp = $destimgsize;
                    $tmp['width'] *= $dpr;
                    $tmp['height'] *= $dpr;
                    if( $tmp['width'] <= $srcimgsize['width'] && $tmp['height'] <= $srcimgsize['height'] ) {
                        // retain the original size of the image in the width and height attributes of the img tag
                        // but for higher dpr devices generate a bigger image.
                        $outp['width'] = $destimgsize['width'];
                        $outp['height'] = $destimgsize['height'];
                        $opp['noauto'] = 1;
                        $destimgsize = $tmp;
                    }
                }

                // make sure we're actually doing something
                if( $destimgsize != $srcimgsize ) {
                    switch(strtolower($opp['autoscale_op'])) {
                    case 'resize':
                        $filter = 'CGImage_Resize_Filter';
                        $tmp = $destimgsize;
                        $tmp['resample'] = 1;
                        $lastfilter = array($filter,$tmp);
                        break;

                    case 'croptofit':
                    default:
                        $filter = 'CGImage_Croptofit_Filter';
                        $tmp = $destimgsize;
                        $tmp['loc'] = 'c';
                        $tmp['upscale'] = 0;
                        $lastfilter = array($filter,$tmp);
                        break;
                    }

                    if( !$opp['noauto'] ) {
                        // we are allowing auto tags... so we adjust the outp stuff to our finished resolution
                        $outp['width'] = $destimgsize['width'];
                        $outp['height'] = $destimgsize['height'];
                    }
                }
            }


            //
            // check if we are actually doing anything
            //

            // if we are forcing a type and that type is not the same as our current type.
            if( $opp['force_type'] ) {
                $tmp_a = self::parse_type($opp['force_type']);
                if( $tmp_a != $srcinfo['mime'] ) $want_transform = 1;
            }

            // if we got the image from a remote location, but there are no other filters, we will do a simple transform
            if( !$relative_to ) {
                $want_transform = 1;
                if( !count($opp['filters']) ) {
                    $filter = 'CGImage_NOOP_Filter';
                    $opp['filters'][] = array($filter,array());
                }
            }

            // if we have a last filter... add it.
            if( $lastfilter ) $opp['filters'][] = $lastfilter;

            // if there are any filters... then we have to transform this image
            if( count(array_keys($opp['filters'])) ) $want_transform = 1;


            //
            // end of smartness stuff... now begin the work
            //
            if( $want_transform ) {
                // calculate our destination name and url.
                $tmp = basename($srcfile);
                if( !isset($outp['alt']) ) $outp['alt'] = $tmp;
                $ext = strrchr($tmp,'.');
                $t2 = md5(serialize($opp));
                // $t2 .= '-'.munge_string_to_url($tmp); add filename stuff
                $destname = 'img-'.$t2;
                $t3 = self::parse_type(($opp['force_type'])?$opp['force_type']:$srcinfo['mime']);
                if( $opp['force_ext'] ) $destname .= self::get_extension($t3);

                $destdir = $mod->get_cache_path();
                if( !is_dir($destdir) ) {
                    @mkdir($destdir, 0777, true);
                    touch($destdir.'/index.html');
                }

                if( !is_dir($destdir) ) throw new Exception($mod->Lang('error_mkdir',$destdir));

                // see if it exists
                $dest_fname = $destdir.'/'.$destname;

                $dest_url = $mod->get_cached_image_url($destname);
                $t1 = filemtime($srcfile);
                $t2 = is_file($dest_fname) ? filemtime($dest_fname) : 0;
                if( !is_file($dest_fname) || (($t2 < $t1) && !$opp['notimecheck']) || $opp['overwrite']  ) $do_transform = 1;
            }
            else {
                // no transofmration... just use the src image
                // but make it into an absolute URL
                $dest_fname = $srcfile;
                switch( $relative_to ) {
                case 'root':
                    $_src = $srcfile;
                    if( startswith($_src,$config['root_path']) ) {
                        $_src = substr($_src,strlen($config['root_path']));
                    }
                    $dest_url = $config['root_url'].$_src;
                    break;
                case 'uploads':
                    $_src = $srcfile;
                    if( startswith($srcfile,$config['uploads_path']) ) {
                        $_src = substr($srcfile,strlen($config['uploads_path']));
                    }
                    $dest_url = $config['uploads_url'].$_src;
                    break;
                }
            }

            if( $do_transform ) {
                try {
                    // load the image.
                    $img = new CGImageBase($srcfile);

                    // process filters
                    $i = 0;
                    while( $i < count($opp['filters']) ) {
                        $filter = $opp['filters'][$i][0];
                        $filter_obj = new $filter($opp['filters'][$i][1]);
                        $img = $filter_obj->transform($img);
                        $img['dirty'] = 1; // force the image dirty, just so that we can save it.
                        $i++;
                    }

                    // check some stuff
                    if( $opp['noauto'] == 0 && (($outp['width'] && $img['width'] < $outp['width']) ||
                                                ($outp['height'] && $img['height'] < $outp['height'])) ) {
                        // user specified a width, and/or height...but they are smaller than the output of the filtering.
                        // this will ensure that the tag will match the image.
                        $outp['width'] = $img['width'];
                        $outp['height'] = $img['height'];
                    }

                    // and write the thing.
                    if( is_object($img) ) {
                        if( $opp['force_type'] ) $img['type'] = self::parse_type($opp['force_type']);
                        if( $img['dirty'] ) {
                            debug_to_log('saving image to '.$dest_fname);
                            $img->save($dest_fname,$opp['quality'],$opp['progressive']);
                            $outp['dest_file'] = $dest_fname;
                        }
                    }
                }
                catch( Exception $e ) {
                    audit('','CGSmartImage','Error encountered on '.$opp['src'].': '.$e->GetMessage());
                    throw $e;
                }
            } // if

            // now, we have a cached filename ... need to get its dimensions.
            // and make sure that we're never outputting anything bigger than the cached dimensions
            // unless noauto is set
            if( $opp['noauto'] == 0 ) {
                if( ($outp['width'] && $srcimgsize['width'] < $outp['width']) || ($outp['height'] && $srcimgsize['height'] < $outp['height']) ) {
                    $outp['width'] = $srcimgsize['width'];
                    $outp['height'] = $srcimgsize['height'];
                }
            }

            // at this point, we're ready to handle building the tag.
            if( $opp['nobcache'] ) $dest_url .= '?x='.time();

            if( !isset($outp['alt']) ) {
                if( $dest_fname ) {
                    $outp['alt'] = basename($dest_fname);
                }
                else if( $srcfile ) {
                    $outp['alt'] = basename($srcfile);
                }
                else {
                    $outp['alt'] = basename($opp['src']);
                }
            }

            // build the output.
            if( $opp['notag'] || self::_is_stylesheet() ) {
                $outp['src'] = $dest_url;
                if( !$opp['noembed'] && $mod->can_embed($dest_fname) ) {
                    $type = cge_utils::get_mime_type($dest_fname);
                    if( $type && $type != 'unknown' ) {
                        $tmp = base64_encode(file_get_contents($dest_fname));
                        $outp['src'] = 'data:'.$type.';base64,'.$tmp;
                        unset($tmp);
                    }
                }
                else {
                    $outp['src'] = $dest_url;
                }

                if( !isset($outp['output']) ) $outp['output'] = $outp['src'];
            }
            else {
                //
                // gotta build a tag.
                //
                // get the src first.
                if( !$opp['noembed'] && $mod->can_embed($dest_fname) ) {
                    $type = cge_utils::get_mime_type($dest_fname);
                    if( $type && $type != 'unknown' ) {
                        $tmp = base64_encode(file_get_contents($dest_fname));
                        $outp['src'] = 'data:'.$type.';base64,'.$tmp;
                        unset($tmp);
                    }
                }

                if( !isset($outp['src']) || !$outp['src'] ) {
                    // fallback to the destination url.
                    $outp['src'] = $dest_url;
                }

                if( $dest_fname && !$opp['noauto'] ) {
                    $details = getimagesize($dest_fname);
                    if( is_array($details) ) {
                        $outp['width']  = (int)$details[0];
                        $outp['height'] = (int)$details[1];
                    }
                }

                // now we can build the tag.
                $output = '<img';
                foreach( $outp as $key => $value ) {
                    if( !$value && $key != 'alt' ) continue; // empty alt is valid... stupid, but valid.
                    $output .= ' '.$key.'="'.$value.'"';
                }
                $output .= '/>';
                $outp['output'] = $output;
            }
        }
        catch( \CGSIStopHereException $e ) {
            // we were forced to stop
            if( !$outp['output'] ) $outp['error'] = 'No output from CGSIStopHereException';
        }
        catch( Exception $e ) {
            $outp['error'] = $e->GetMessage();
        }

        // here we're gonna return something
        return $outp;
    }


    public static function cgsi_convert($params,$content,&$smarty,$repeat)
    {
        if( !$content ) return;
        $max_width = -1;
        $max_height = -1;
        if( isset($params['max_height']) ) $max_height = max(0,(int)$params['max_height']);
        if( isset($params['max_width']) ) $max_width = max(0,(int)$params['max_width']);

        $did_modify = FALSE;
        $mod = cms_utils::get_module('CGSmartImage');
        $old_errorval = libxml_use_internal_errors(true);
        $dom = new DomDocument();
        $dom->strictErrorChecking = FALSE;
        $dom->validateOnParse = FALSE;
        if( function_exists('mb_convert_encoding') ) $content = mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8');
        $dom->loadHTML($content);

        $imgs = $dom->GetElementsByTagName('img');
        if( is_object($imgs) && $imgs->length ) {
            for( $i = 0; $i < $imgs->length; $i++ ) {
                $node = $imgs->item($i);
                $sxe = simplexml_import_dom($node);

                $parms = $params;
                $process = true;
                foreach( $sxe->attributes() as $name => $value ) {
                    $value = (string)$value;
                    if( $value == '' ) continue;

                    switch( $name ) {
                    case 'width':
                        if( $max_width > 0 ) $value = min($max_width,(int)$value);
                        break;

                    case 'height':
                        if( $max_height > 0 ) $value = min($max_height,(int)$value);
                        break;

                    case 'class':
                        $words = explode(' ',$value);
                        if( in_array('nocgsi',$words) ) $process = false;
                        break;
                    }
                    $parms[$name] = $value;
                }

                if( !$process ) continue; // found a reason not do to anything with this image.
                if( !isset($parms['src']) ) continue;
                if( startswith($parms['src'],'data:') ) continue;   // already embedded, can't do anything.

                $parms['notag'] = 1;
                $outp = self::process_image($parms);
                foreach( $outp as $key => $value ) {
                    $did_modify = TRUE;
                    switch( $key ) {
                    case 'width':
                    case 'height':
                        $value = trim($value);
                        if( $value ) {
                            $sxe[$key] = (int) $value;
                        }
                        else {
                            unset($sxe[$key]);
                        }
                        break;
                    case 'src':
                        $value = trim($value);
                        if( $value) $sxe[$key] = trim($value);
                        break;
                    default:
                        break;
                    }
                }
            } // for each image
        }

        // get the contents.
        if( $did_modify ) {
            // tags we do not want to self close if empty.
            $canselfclose = [ 'area', 'base', 'br', 'col', 'embed', 'hr', 'img', 'input', 'keygen', 'link', 'menuitem', 'meta', 'param', 'source', 'track', 'wbr' ];

            // get all empty nodes...
            $query = '//*[not(node())]';
            $nodes = (new DOMXPath($dom))->query($query);
            foreach( $nodes as $n ) {
                if( !in_array($n->nodeName,$canselfclose) ) $n->appendChild(new DOMComment('NOT_VOID'));
            }

            $tmp = $dom->getElementsByTagName('body');
            if( $tmp && $tmp->length == 1 ) {
                $node = $tmp->item(0);
                $content = null;
                foreach( $node->childNodes as $child ) {
                    $content .= $node->ownerDocument->saveXML($child);
                }
                $content = str_replace(chr(13),'',$content);
                $content = str_replace('&#13;','',$content);
                $content = str_replace('<!--NOT_VOID-->','',$content);
            }
        }
        return $content;
    }


    public static function get_device_capabilities()
    {
        $mod = \cms_utils::get_module(MOD_CGSMARTIMAGE);
        if( $mod->GetPreference('responsive') ) {
            $cookie_enc = cms_cookies::get(cgsi_utils::get_responsive_cookiename());
            if( $cookie_enc ) {
                $data = json_decode($cookie_enc,TRUE);
                return $data;
            }
        }
    }

    public static function trim_to_device($flag,$value)
    {
        $flag = strtolower($flag);
        if( $value > 0 && is_array(self::$_device_data) && isset(self::$_device_data[$flag]) ) {
            return min($value,self::$_device_data[$flag]);
        }
        return $value;
    }

    public static function get_transparent_color(CGImageBase $img)
    {
        if( $img['transparent'] != '' ) return $img['transparent'];
    }

    public static function find_unused_color(CGImageBase $img)
    {
        // dont have a transparency color... so guess one.
        // find a random unused color for transparency.
        $r = $g = $b = 255;
        $found = 0;
        while( $found < 100 ) {
            $r = rand(0,255);
            $g = rand(0,255);
            $b = rand(0,255);
            if( imagecolorexact($img['rsrc'],$r,$g,$b) != -1 ) break;
            $found++;
        }

        if( $found == 50 ) audit('','CGSmartImage','No unused color found');
        return array($r,$g,$b);
    }

    public static function get_responsive_cookiename()
    {
        return 'cc'.md5(__FILE__);
    }
}

#
# EOF
#
?>
