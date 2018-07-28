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
 * This file defines a Link Definition A factory for link definition generators.
 *
 * @package CGExtensions
 * @category Communications
 * @author  calguy1000 <calguy1000@cmsmadesimple.org>
 * @copyright Copyright 2014 by Robert Campbell
 */

namespace CGExtensions\LinkDefinition;

/**
 * This is a factory class that can generate a LinkDefinitionGenerator for a DataRef
 */
class LinkDefinitionGeneratorFactory
{
    /**
     * Given a dataref object, find and instantiate a LinkDefinitionGenerator
     * that can generate links for this type of dataref
     *
     * @param DataRef $dataref
     * @return LinkDefinitionGenerator
     */
    public function get_generator(DataRef $dataref)
    {
        if( strtolower($dataref->key1) == 'page' && (int) $dataref->key2 > 0 ) {
            $dataref->key3 = $dataref->key2;
            $dataref->key2 = 'Page';
            $dataref->key1 = 'Core';
        }

        if( in_array($dataref->key1,array('Core','core','CORE','CMSMS')) ) {
            $obj = new CoreLinkDefinitionGenerator;
            $obj->set_dataref($dataref);
            return $obj;
        }

        // assume key1 is a module name
        $mod = \cms_utils::get_module($dataref->key1);
        if( is_object($mod) ) {
            $str = $dataref->key1.'\LinkDefinitionGenerator';
            if( class_exists($str) ) {
                $obj = new $str;
                $obj->set_dataref($dataref);
                return $obj;
            }

            $str = $dataref->key1.'_LinkDefinitionGenerator';
            if( class_exists($str) ) {
                $obj = new $str;
                $obj->set_dataref($dataref);
                return $obj;
            }
        }

        throw new \RuntimeException('Could not find an appropriate link generator for data definitions of type '.$dataref->key1);
    }
}

?>