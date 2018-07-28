<?php
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: CGContentUtils (c) 2009 by Robert Campbell 
#         (calguy1000@cmsmadesimple.org)
#  An addon module for CMS Made Simple to provide various additional utilities
#  for dealing with content pages.
#
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2005 by Ted Kulp (wishy@cmsmadesimple.org)
# This project's homepage is: http://www.cmsmadesimple.org
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

class cgcu_utils
{
  private static $_module_template_names;
  private static $_gcb_names;
  private static $_udt_names;

  static private function get_module_templates($module)
  {
    if( !$module ) return FALSE;
    $mod = cge_utils::get_module('CGContentUtils');
    
    if( !is_array(self::$_module_template_names) )
      {
	self::$_module_template_names = array();
      }

    if( !isset(self::$_module_template_names[$module]) )
      {
	$list = $mod->ListTemplates($module);
	if( !is_array($list) || count($list) == 0 ) return FALSE;

	self::$_module_template_names[$module] = $list;
      }

    return TRUE;
  }


  static public function module_template_exists($module,$template)
  {
    self::get_module_templates($module);
    if( !isset(self::$_module_template_names[$module]) ) return FALSE;
    if( !in_array($template,self::$_module_template_names[$module]) ) return FALSE;
    return TRUE;
  }

  
  static public function module_template_newname($module,$template)
  {
    self::get_module_templates($module);

    $count = 1;
    $testname = $template;
    while( $count < 1000 )
      {
	if( !self::module_template_exists($module,$testname) ) 
	  {
	    return $testname;
	  }
	$count++;
	$testname = $template . $count;
      }

    return $testname;
  }


  static private function get_gcb_names()
  {
    if( is_array(self::$_gcb_names) ) return TRUE;

    $db = cmsms()->GetDb();
    $query = 'SELECT htmlblob_name FROM '.cms_db_prefix().'htmlblobs ORDER BY htmlblob_name';
    self::$_gcb_names = $db->GetCol($query);
  }

  static public function gcb_exists($gcb_name)
  {
    self::get_gcb_names();
    if( !in_array($gcb_name,self::$_gcb_names) ) return FALSE;
    return TRUE;
  }

  static public function gcb_newname($gcb_name)
  {
    $count = 1;
    $testname = $gcb_name;
    while( $count < 1000 )
      {
	if( !self::gcb_exists($testname) ) 
	  {
	    return $testname;
	  }
	$count++;
	$testname = $gcb_name . $count;
      }

    return $testname;
  }


  static private function get_udt_names()
  {
    if( is_array(self::$_udt_names) ) return TRUE;

    $db = cmsms()->GetDb();
    $query = 'SELECT userplugin_name FROM '.cms_db_prefix().'userplugins ORDER BY userplugin_name';
    self::$_udt_names = $db->GetCol($query);
    return TRUE;
  }


  static public function udt_exists($udt_name)
  {
    self::get_udt_names();
    if( !in_array($udt_name,self::$_udt_names) ) return FALSE;
    return TRUE;
  }


  static public function udt_newname($udt_name)
  {
    $count = 1;
    $testname = $udt_name;
    while( $count < 1000 )
      {
	if( !self::udt_exists($testname) ) 
	  {
	    return $testname;
	  }
	$count++;
	$testname = $udt_name . $count;
      }

    return $testname;
  }
}

#
# EOF
#
?>