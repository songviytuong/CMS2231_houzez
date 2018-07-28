<?php
#-------------------------------------------------------------------------
# LISE - List It Special Edition
# Version 1.2
# A fork of ListI2
# maintained by Fernando Morgado AKA Jo Morg
# since 2015
#-------------------------------------------------------------------------
#
# Original Author: Ben Malen, <ben@conceptfactory.com.au>
# Co-Maintainer: Simon Radford, <simon@conceptfactory.com.au>
# Web: www.conceptfactory.com.au
#
#-------------------------------------------------------------------------
#
# Maintainer since 2011 up to 2014: Jonathan Schmid, <hi@jonathanschmid.de>
# Web: www.jonathanschmid.de
#
#-------------------------------------------------------------------------
#
# Some wackos started destroying stuff since 2012 and stopped at 2014:
#
# Tapio Löytty, <tapsa@orange-media.fi>
# Web: www.orange-media.fi
#
# Goran Ilic, <uniqu3e@gmail.com>
# Web: www.ich-mach-das.at
#
#-------------------------------------------------------------------------
#
# LISE is a CMS Made Simple module that enables the web developer to create
# multiple lists throughout a site. It can be duplicated and given friendly
# names for easier client maintenance.
#
#-------------------------------------------------------------------------
# BEGIN_LICENSE
#-------------------------------------------------------------------------
# This file is part of LISE
# LISE program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation; either version 2 of the License, or
# (at your option) any later version.
#
# LISE program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
# You should have received a copy of the GNU General Public License
# along with this program; if not, write to the Free Software
# Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
# Or read it online: http://www.gnu.org/licenses/licenses.html#GPL
#
#-------------------------------------------------------------------------
# END_LICENSE
#-------------------------------------------------------------------------

/**
* based on CGBlog own action.ajax_geturl.php
*/
if( !defined('CMS_VERSION') ) exit;
$item_id = '';
if( isset($_REQUEST['itemid']) ) $item_id = (int)$_REQUEST['itemid'];

$prefix = $this->GetPreference( 'url_prefix', munge_string_to_url($this->GetName(), true) );
$template = $this->GetPreference('urltemplate', '{$prefix}/{$item_title}');
                                
$smarty->assign('item_title', munge_string_to_url( trim($_REQUEST['title']) ) );
$smarty->assign('prefix', $prefix);

$test = 0;
$url = '';
cms_route_manager::load_routes();
$url = $this->ProcessTemplateFromData('{strip}'.$template.'{/strip}');

while( $test < 100 ) 
{
  // generate a unique random url.
  if( $test > 1 ) $url .= '-'.$test;

  $url = trim($url," /\t\r\n\0\x08");
  $route = cms_route_manager::find_match($url);
  if($route) 
  {
    $dflts = $route->get_defaults();
    if( $route->is_content() || $route->get_dest() != $this->GetName() || !isset($dflts['articleid']) || $dflts['articleid'] != $item_id )
    {
      // route is used.
      $test++;
      continue;
    }
  }

  break;
}

echo $url;
?>