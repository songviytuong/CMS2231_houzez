<?php
#-------------------------------------------------------------------------
# LISE - List It Special Edition
# Version 1.2.2
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
* This class defines a new template resource
* and is basicaly based on the core own
* CMSModuleFileTemplateResource and CMS_Fixed_Resource_Custom
* CMS_Fixed_Resource_Custom fixes some weird stuff in smarty
* but as these are internal core classes, we just copy the code 
* and adapt it to our needs
* 
* Jo Morg 
*/
class LISETemplateResource extends Smarty_Resource_Custom
{
  /**
  * a fix to resolve an issue with smarty
  * 
  * @param Smarty_Template_Source $source
  * @param Smarty_Internal_Template $_template
  */
  public function populate(Smarty_Template_Source $source, Smarty_Internal_Template $_template = null)
  {
    $source->filepath = $source->type . ':' . $source->name;
    $source->uid = sha1($source->type . ':' . $source->name);

    $mtime = $this->fetchTimestamp($source->name);
    
    if ($mtime !== null)
    {
        $source->timestamp = $mtime;
    }
    else 
    {
        $this->fetch($source->name, $content, $timestamp);
        $source->timestamp = isset($timestamp) ? $timestamp : false;
        if( isset($content) ) $source->content = $content;
    }
    
    $source->exists = !!$source->timestamp;
  }
  
  /**
  * Our mechanism to deal with the templates
  * for the instances
  * 
  * @param mixed $name
  * @param mixed $source
  * @param mixed $mtime
  */
  public function fetch($name, &$source, &$mtime)
  {
    $source = null;
    $mtime = null;
    $params = preg_split('/;/', $name);

    $config = cmsms()->GetConfig();
    $files = array();
    
    switch ($params[0])
    {
      case 'instance':
        if( count($params) != 3 ) throw new \LISE\Exception('invalid LISE template resource: ' . $params[0]);
        $files[] = cms_join_path($config['root_path'], 'module_custom', $params[1], 'templates', $params[2]);
        $files[] = cms_join_path($config['root_path'], 'modules',$params[1], 'templates', $params[2]);
        $files[] = cms_join_path(LISE_TEMPLATE_PATH, $params[2]);
        break;
      
      case 'fielddefs':
        if( count($params) != 3 ) throw new \LISE\Exception('invalid LISE template resource: ' . $params[0]);
        $tmp = explode('.', $params[2]);
        $instance = cms_utils::get_module($params[1]);
        $fn =  cms_join_path($instance->GetModulePath(), 'lib', 'fielddefs', $tmp[1], $params[2]);
        $files[] = $fn;
        break;
      
      default:
        throw new \LISE\Exception('invalid LISE template resource: ' . $params[0]);
    }

    foreach( $files as $one ) 
    {
      if( file_exists($one) ) 
      {
        $source = @file_get_contents($one);
        $mtime = @filemtime($one);
        return;
      }
    }
  }
} // end of class
?>