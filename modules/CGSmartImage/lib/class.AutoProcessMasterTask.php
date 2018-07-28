<?php
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: CGSmartImage (c) 2015 by Robert Campbell (calguy1000@cmsmadesimple.org)
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

namespace CGSmartImage;

class AutoProcessMasterTask implements \CmsRegularTask
{
    const PREF_LASTRUN = 'autoprocess_lastrun';
    private $_prefs;
    private $_force;

    private function &get_prefs()
    {
        if( !$this->_prefs ) $this->_prefs = autoprocess_options::load();
        return $this->_prefs;
    }

    public function force()
    {
        $this->_force = true;
    }

    public function get_name()
    {
        return basename(get_class($this));
    }

    public function get_description()
    {
        $mod = \cms_utils::get_module(MOD_CGSMARTIMAGE);
        return $mod->Lang('autoprocesstask_description');
    }

    public function test($time = '')
    {
        if( !$time ) $time = time();

        $opts = $this->get_prefs();
        if( ! $opts->enabled ) return FALSE;
        if( $this->_force ) return TRUE;

        $mod = \cms_utils::get_module(MOD_CGSMARTIMAGE);
        $lastrun = $mod->GetPreference(self::PREF_LASTRUN);
        if( time() - $lastrun < 3600 * 6 ) return FALSE;
        return TRUE;
    }

    public function get_files($dir)
    {
        $prefs = $this->get_prefs();
        if( !$prefs->is_dir_scannable($dir) ) return;

        $out = array();
        $dh = opendir($dir);
        while( false !== ($file = readdir($dh)) ) {
            $filespec = $dir.'/'.$file;
            if( startswith($file,'.') ) continue;

            if( is_file($filespec) && $prefs->is_file_scannable($filespec) ) {
                $sizeinfo = getimagesize($filespec);
                if( !is_array($sizeinfo) || count($sizeinfo) < 2 ) continue;
                if( $sizeinfo[0] <= $prefs->max_size && $sizeinfo[1] <= $prefs->max_size ) continue;

                $out[] = $filespec;
            }
            else if( is_dir($filespec) ) {
                $tmp = $this->get_files($filespec);
                if( is_array($tmp) && count($tmp) ) $out = array_merge($out,$tmp);
            }
        }
        return $out;
    }

    public function on_success($time = '')
    {
        if( !$time ) $time = time();
        $mod = \cms_utils::get_module(MOD_CGSMARTIMAGE);
        $mod->SetPreference(self::PREF_LASTRUN,$time);
    }

    public function on_failure($time = '') {}

    public function scan_for_files()
    {
        $opts = $this->get_prefs();
        $inc = $opts->get_include_dirs();
        $config = \cms_config::get_instance();
        $out = array();
        if( count($inc) ) {
            foreach( $inc as $dir ) {
                $tmp = $this->get_files($config['uploads_path'],$dir);
                if( count($tmp) ) $out = array_merge($out,$tmp);
            }
        } else {
            $out = $this->get_files($config['uploads_path']);
        }
        return $out;
    }

    public function execute($time = '')
    {
        if( !$time ) $time = time();

        $files = $this->scan_for_files();
        if( count($files) ) {
            // devide the file list into chunks
            $chunk_size = 5; // todo: setting
            $chunks = array_chunk($files,$chunk_size);
            foreach( $chunks as $chunk ) {
                $msg = new AutoProcessMessage($chunk);
                $msg->save();
            }
        }
        return TRUE;
    }
}
