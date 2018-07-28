<?php  /* -*- Mode: PHP; c-set-style: linux; tab-width: 4; c-basic-offset: 4 -*- */
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: Products (c) 2008-2014 by Robert Campbell
#         (calguy1000@cmsmadesimple.org)
#  An addon module for CMS Made Simple to allow users to create, manage
#  and display products in a variety of ways.
#
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2005 by Ted Kulp (wishy@cmsmadesimple.org)
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

class importImageHandler
{
  var $_module;
  var $_srcpath;
  var $_destpath;
  var $_unique_names;

  function importImageHandler(&$mod)
  {
    $this->_module = $mod;
    $this->_unique_names = 0;
  }


  function setUniqueNames($value = 1)
  {
    $this->_unique_names = (int)$value;
  }


  function setSourceLocation($path)
  {
    if( is_dir($path) )
      {
	$this->_srcpath = $path;
      }
  }


  function setDestinationBase($path)
  {
    $this->_destpath = $path;
  }


  function handleImage($product_id,$filename)
  {
    $destpath = cms_join_path($this->_destpath,'product_'.$product_id);
    $mod =& $this->_module;
    cge_dir::mkdirr($destpath);
    if( !is_dir($destpath) ) return FALSE;

    $ext = substr($filename, strrpos($filename, '.') + 1);
    $allowed = explode(',',$mod->GetPreference('allowed_imagetypes'));
    if( !in_array($ext,$allowed) ) return FALSE;

    $srcspec = cms_join_path($this->_srcpath,$filename);
    if( !file_exists($srcspec) ) return FALSE;

    $postfix = 0;
    $fname = substr($filename,0,strlen($filename)-strlen($ext));
    $destspec = cms_join_path($destpath,$filename);
    while( file_exists($destspec) && $this->_unique_names && ($postfix < 100) )
      {
	$postfix++;
	$destspec = cms_join_path($destpath,$fname.'_'.$postfix.$ext);
      }
    if( file_exists($destspec) ) return FALSE;

    // we have the source name, and destination name
    // copy the file
    @copy($srcspec,$destspec);
    if( !file_exists($destspec) ) return FALSE;
    return basename($destspec);
  }
} // end of class

#
# EOF
#
?>