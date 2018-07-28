<?php
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: CGSmartImage (c) 2011 by Robert Campbell (calguy1000@cmsmadesimple.org)
#
#  An addon module for CMS Made Simple to allow creating image tags in a smart
#  way to optimize performance.
#
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2005-2010 by Ted Kulp (wishy@cmsmadesimple.org)
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
if( !$this->CheckPermission('Modify Site Preferences') ) return;

$this->SetCurrentTab('general');
$config = cmsms()->GetConfig();

try {
    if( isset($params['submit']) ) {
        // validate the cache path.
        $cache_path = trim($params['cache_path']);
        if( $cache_path ) {
            $tp1 = $cache_path;
            if( !is_dir($tp1) ) $tp1 = $config['root_path'].'/'.$tp1;
            $p1 = realpath($tp1);
            $p2 = realpath($config['root_path']);
            if( $p1 == $p2 || !startswith($p1,$p2) ) throw new Exception($this->Lang('error_cachepath_invalid'));
        }

        $this->SetPreference('croptofit_default_loc',trim($params['croptofit_default_loc']));
        $this->SetPreference('cache_age',(int)$params['cache_age']);
        $this->SetPreference('cache_path',$cache_path);
        $this->SetPreference('image_url_prefix',trim($params['image_url_prefix']));
        $this->SetPreference('silent',(int)$params['silent']);
        $this->SetPreference('image_url_hascachedir',(isset($params['image_url_hascachedir']))?(int)$params['image_url_hascachedir']:0);
        $this->SetPreference('checkmemory',(int)$params['checkmemory']);
        $this->SetPreference('force_extension',(int)$params['force_extension']);
        $this->SetPreference('progressive',(int)$params['progressive']);
        $this->SetPreference('autoscale_op',\cge_param::get_string($params,'autoscale_op'));
        $this->SetMessage($this->Lang('msg_prefsupdated'));
    }
    else if( isset($params['clear_now']) ) {
        // clear all files from cache dir older than N days
        $this->SetPreference('cache_age',(int)$params['cache_age']);
        $n_removed = $this->clear_cached_files();
        $this->SetMessage($this->Lang('msg_cachecleaned',$n_removed));
        audit('',$this->GetName(),$n_removed.' files cleaned from cache directory');
    }
    else if( isset($params['clear_all']) ) {
        // just nuke the cache directory completely.
        $cache_path = $this->GetPreference('cache_path', cms_join_path('uploads', '_'.$this->GetName()));
        $dir = $cache_path;
        if( !startswith($dir,'/') ) $dir = $config['root_path'].'/'.$cache_path;
        $p1 = realpath($dir);
        $p2 = realpath($config['root_path']);
        if( !startswith($p1,$p2) || $p1 == $p2 ) throw new Exception($this->Lang('error_cachepath_invalid'));
        cge_dir::recursive_rmdir($dir);
        mkdir($dir);
        @touch($dir.'/index.html');
        $this->SetMessage($this->Lang('msg_cacheremoved'));
        audit('',$this->GetName(),'All cached files removed');
    }
}
catch( Exception $e ) {
    $this->SetError($e->getMessage());
}

$this->RedirectToTab($id);

#
# EOF
#
?>