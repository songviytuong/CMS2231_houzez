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

class LISEHierarchyManager {
    #---------------------
    # Magic methods
    #--------------------- 

    private function __construct() {
        
    }

    #---------------------
    # Hierarchy methods
    #--------------------- 	
    // |- Useless	

    static public final function &FillNodeWithChild(LISE &$mod, $id, $returnid, &$node, &$nodelist, &$count, &$prevdepth, $origdepth, &$params) {
        // Grap current id_hierarchy
        $current_path = cms_utils::get_app_data('lise_id_hierarchy');
        $current_path_array = explode('.', $current_path);

        //$node->depth = count(explode('.', $node->hierarchy));
        $node->prevdepth = $prevdepth - ($origdepth - 1);
        if ($node->prevdepth == 0)
            $node->prevdepth = 1;
        $prevdepth = $node->depth + ($origdepth - 1);

        $linkparams = array();
        $linkparams['category'] = $node->alias;
        $linkparams['id_hierarchy'] = $node->id_hierarchy;

        $returnid = $mod->GetPreference('summarypage', $returnid);
        if (isset($params['summarypage'])) {

            if (is_numeric($params['summarypage'])) {
                $returnid = $params['summarypage'];
            } else {
                $hm = cmsms()->GetHierarchyManager();
                $returnid = $hm->sureGetNodeByAlias($params['summarypage'])->GetId();
            }
        }

        $linkparams = array_merge($linkparams, $params);

        $node->url = $mod->CreatePrettyLink($id, 'default', $returnid, '', $linkparams, '', true, false);
        $node->index = $count;
        $node->menutext = $node->name; // Alias for name, make compatibility with MenuManager possible
        $node->parent = false;
        $count++;

        if ($node->id_hierarchy === $current_path) {

            $node->current = true;
        } else {

            $node->current = false;

            if (in_array($node->category_id, $current_path_array)) {

                $node->parent = true;
            }
        }

        $nodelist[] = $node;

        return $node;
    }

    // |- Useless
    static public final function &FillNodeWithItem(LISE &$mod, $id, $returnid, &$node, &$item, &$nodelist, &$count, &$prevdepth, $origdepth, &$params) {
        // Grap current item
        $current_item = cms_utils::get_app_data('lise_item');

        $item->depth = $node->depth + 1;
        $item->prevdepth = $prevdepth - ($origdepth - 1);
        if ($item->prevdepth == 0)
            $item->prevdepth = 1;
        $prevdepth = $item->depth + ($origdepth - 1);

        $linkparams = array();
        $linkparams['item'] = $item->alias;
        $linkparams['category'] = $node->alias;
        $linkparams['id_hierarchy'] = $node->id_hierarchy;

        $returnid = $mod->GetPreference('detailpage', $returnid);
        if (isset($params['detailpage'])) {

            if (is_numeric($params['detailpage'])) {
                $returnid = $params['detailpage'];
            } else {
                $hm = cmsms()->GetHierarchyManager();
                $returnid = $hm->sureGetNodeByAlias($params['detailpage'])->GetId();
            }
        }

        $linkparams = array_merge($linkparams, $params);

        $item->url = $mod->CreatePrettyLink($id, 'detail', $returnid, '', $linkparams, '', true, false);
        $item->index = $count;
        $item->menutext = $item->title; // Alias for name, make compatibility with MenuManager possible
        $item->parent = false;
        $count++;

        $item->current = ($item->alias == $current_item) ? true : false;

        $nodelist[] = $item;

        return $item;
    }

    // |- Useless	
    static public final function GetChildNodes(LISE &$mod, $id, $returnid, &$id_list, &$nodelist, &$count, &$prevdepth, $origdepth, &$params, &$showparents, $mleblock) {
        if (!empty($id_list)) {

            foreach ($id_list as $one_id) {

                $onechild = $mod->LoadCategoryByIdentifier('category_id', $one_id, $mleblock);

                if (!is_object($onechild))
                    continue;

                // Fill categories
                $newnode = self::FillNodeWithChild($mod, $id, $returnid, $onechild, $nodelist, $count, $prevdepth, $origdepth, $params);

                if (!(isset($params['number_of_levels']) && $newnode->depth > ($params['number_of_levels']) - ($origdepth)) &&
                        (!isset($params['collapse']) || (count($showparents) > 0 && in_array($newnode->category_id, $showparents)))) {

                    self::GetChildNodes($mod, $id, $returnid, $newnode->children, $nodelist, $count, $prevdepth, $origdepth, $params, $showparents, $mleblock);

                    // Fill items for category
                    if (!empty($newnode->items) && isset($params['show_items'])) {

                        foreach ($newnode->items as $item_id) {

                            $item = $mod->LoadItemByIdentifier('item_id', $item_id);
                            self::FillNodeWithItem($mod, $id, $returnid, $newnode, $item, $nodelist, $count, $prevdepth, $origdepth, $params, '', $mleblock);
                        }
                    }
                }
            }
        }
    }

}
// end of class