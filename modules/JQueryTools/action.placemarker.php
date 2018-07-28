<?php
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: JQueryTools (c) 2008 by Robert Campbell
#         (calguy1000@cmsmadesimple.org)
#  A toolbox of conveniences to provide dynamic javascripty functionality
#  for CMS modules and website designers.
#
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2005 by Ted Kulp (wishy@cmsmadesimple.org)
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
if( !isset($gCms) ) exit;

// check if there is anything to do.
if( (!is_array($this->_libs) || count($this->_libs) == 0) ) return;

// load all the libraries.
$basedir = $this->GetModulePath().'/lib';
$dirs = glob($basedir.'/*.lib');
$libraries = [];
if( is_array($dirs) && count($dirs) ) {
    foreach( $dirs as $one ) {
        if( !is_dir($one) ) continue;
        if( !file_exists($one.'/info.dat') ) continue;
        $bn = basename($one);
        $name = substr($bn,0,-4);
        include_once($one.'/info.dat');

        $info['base_dir'] = $one;
        $info['base_url'] = $this->GetModuleURLPath()."/lib/$bn";
        $libraries[$name] = $info;

        unset($info);
    }
}

// loop through the libraries
// find the ones with no dependencies

$baseurl = $config->smart_root_url().'/modules/'.$this->GetName().'/lib/';
$fmt = '<script type="text/javascript" src="%s"></script>'."\n";
$do_css = 1;
$do_cdn = 1;
$do_js = 1;
$excludes = array();
$do_jquery = 1;

if( !cmsms()->is_frontend_request() ) {
    $excludes[] = 'jquery';
    $excludes[] = 'ui';
    $excludes[] = 'fileupload';
}
if( isset($params['no_jquery']) ) $excludes[] = 'jquery';
if( isset($params['no_css']) ) $do_css = 0;
if( isset($params['no_js']) ) $do_js = 0;
if( isset($params['no_cdn']) ) $do_cdn = 0;

if( isset($params['exclude']) ) {
    $exclude = explode(',',$params['exclude']);
    $excludes = array_merge($excludes,$exclude);
}
$excludes = array_unique($excludes);

// assemble the list of libraries and css files.
$libs = array();
$css = array();
if( !function_exists('jquerytools_incjs') ) {
    function jquerytools_incjs($name,&$libraries,$excludes,&$libs,&$css,$do_js,$do_css,$do_cdn) {
        if( !isset($libraries[$name]) ) return;
        if( in_array($name,$excludes) ) return;

        $info =& $libraries[$name];
        if( isset($info['handled']) && $info['handled'] == 1 ) return;

        // do dependencies first
        if( isset($info['depends']) && $info['depends'] ) {
            if( !is_array($info['depends']) ) $info['depends'] = explode(',',$info['depends']);

            foreach( $info['depends'] as $dependency ) {
                jquerytools_incjs($dependency,$libraries,$excludes,$libs,$css,$do_js,$do_css,$do_cdn);
            }
        }

        // then this library
        if( $do_js && isset($info['js']) && $info['js'] ) {
            if( !is_array($info['js']) ) $info['js'] = explode(',',$info['js']);

            if( isset($info['cdn']) && cmsms()->is_frontend_request() && $do_cdn ) {
                // assume only one record.
                $bn = basename($info['cdn']);
                if( !isset($libs[$bn]) ) $libs[$bn] = $info['cdn'];
            }
            else {
                foreach( $info['js'] as $one_js ) {
                    $bn = basename($one_js);
                    if( !isset($libs[$bn]) ) $libs[$bn] = $info['base_url'].'/'.$one_js;
                }
            }
        }

        if( $do_css && isset($info['css']) && $info['css'] ) {
            if( !is_array($info['css']) ) $info['css'] = explode(',',$info['css']);

            foreach( $info['css'] as $one_css ) {
                $bn = basename($one_css);
                if( isset($css[$bn]) ) continue;

                $url = $info['base_url'].'/'.$one_css;
                $css[$bn] = $url;
            }
        }

        $info['handled'] = 1;
    }
}

if( !is_array($this->_libs) ) $this->_libs = array_keys($libraries);

foreach( $this->_libs as $one ) {
    jquerytools_incjs($one,$libraries,$excludes,$libs,$css,$do_js,$do_css,$do_cdn);
}

$libs = array_unique($libs);
$css = array_unique($css);

if( count($libs) && $do_js ) $smarty->assign('libs',$libs);
if( count($css) && $do_css ) $smarty->assign('css',$css);

if( count($css) || count($libs) ) {
    echo $this->ProcessTemplate('incjs.tpl');
    $ready = TRUE;
    if( isset($params['no_ready']) ) $ready = !cms_to_bool($params['no_ready']);
    if( $ready ) $this->DoAction('ready','jqtr',array());
}

#
# EOF
#
?>