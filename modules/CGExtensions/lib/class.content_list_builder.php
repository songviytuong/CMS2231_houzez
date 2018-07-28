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
 * This file defines the content_list_builder class.
 *
 * @package CGExtensions
 * @category Utilities
 * @author  calguy1000 <calguy1000@cmsmadesimple.org>
 * @copyright Copyright 2010 by Robert Campbell
 */

namespace CGExtensions;

/**
 * A utility class to build a set of options for a page dropdown.
 *
 * @property int|string $parent The page id or alias of the parent page for the output options.  Only descendents of this page will be shown.
 * @property int|string $current The page id or alias of the currently selected page.
 * @property bool $show_unlinkable Show content types (like separators etc) that do not have usable links.
 * @property bool $show_disabled Show disabled content pages.
 * @property bool $show_navhidden show content objects that are not shown in menu.
 * @property string $spacer The prefix before each option text to illustrate its relative depth.
 * @package CGExtensions
 */
class content_list_builder
{
    /**
     * @ignore
     */
    private $_data = array('parent'=>-1,'current'=>null,'show_unlinkable'=>FALSE,
                           'show_disabled'=>FALSE,'show_navhidden'=>FALSE,
                           'spacer'=>'&nbsp;&nbsp;&nbsp;');

    /**
     * @ignore
     */
    private $_start_id = -100;

    /**
     * @ignore
     */
    private $_start_level = -1;

    /**
     * Constructor
     *
     * @param array $params array of settings/properties for this object.
     */
    public function __construct($params = null)
    {
        if( is_null($params) ) $params = array();
        if( !is_array($params) ) throw new \LogicException('Invalid data passed to '.__METHOD__);

        foreach( $params as $key => $val ) {
            $this->$key = $val;
        }
    }

    /**
     * @ignore
     */
    public function __set($key,$val)
    {
        $key = trim((string) $key);
        switch( $key ) {
        case 'parent':
        case 'current':
            if( $val instanceof cms_tree ) {
                $val = (int) $val->get_tag('id');
                $this->_data[$key] = $val;
            }
            else if( !empty($val)) {
                $val = (string) $val;
                if( is_numeric($val) ) {
                    $val = (int) $val;
                }
                else {
                    $root = cmsms()->GetHierarchyManager();
                    $node = $root->sureGetNodeByAlias($val);
                    if( !$node ) throw new \LogicException('Could not find a content object with alias or id of '.$val);
                    $val = (int) $node->get_tag('id');
                }
                $this->_data[$key] = $val;
            }
            break;

        case 'spacer':
            $this->_data[$key] = trim( (string) $val );
            break;

        case 'show_unlinkable':
        case 'show_disabled':
        case 'show_navhidden':
            if( !empty($val) || is_numeric($val) ) {
                $val = \cge_utils::to_bool($val);
                $this->_data[$key] = $val;
            }
            break;
        }
    }

    /**
     * @ignore
     */
    public function __get($key)
    {
        if( !in_array($key,array_keys($this->_data)) ) throw new \LogicException("$key is not a valid member of ".__CLASS__);
        return $this->_data[$key];
    }

    /**
     * @ignore
     */
    public function __isset($key)
    {
        return isset($this->_data[$key]);
    }

    /**
     * @ignore
     */
    public function __unset($key)
    {
        unset($this->_data[$key]);
    }

    /**
     * @ignore
     */
    private function _get_parent_ids(\cms_content_tree $node)
    {
        $tmp = array();
        while( $node->getParent() ) {
            array_unshift($tmp,$node->get_tag('id'));
            $node = $node->getParent();
        }
        return $tmp;
    }

    /**
     * @ignore
     */
    private function _is_child_of_start(\cms_content_tree $node)
    {
        if( $this->parent < 1 ) return TRUE; // everything is a child of the parent
        $parents = $this->_get_parent_ids($node);
        if( in_array($node->get_tag('id'),$parents) ) return TRUE;
    }

    /**
     * @ignore
     */
    private function _add_node(\cms_content_tree $node,&$out)
    {
        $rec = array('val'=>null,'label'=>null,'title'=>null,'selected'=>FALSE,'disabled'=>FALSE,'depth'=>0);

        $content = $node->GetContent();
        if( !$content ) return;

        $rec['val'] = $content->Id();
        $rec['label'] = $content->Name();
        $rec['title'] = $content->TitleAttribute();
        $rec['depth'] = max(0,$node->get_level() - $this->_start_level);

        if( !$content->HasUsableLink() ) {
            // content has no usable link
            if( $this->show_unlinkable ) {
                // we still wanna show it, but it cannot be selectable
                $rec['disabled'] = TRUE;
            }
            else {
                return;
            }
        }

        if( !$content->Active() ) {
            // content is not active
            if( $this->show_disabled ) {
                // we still wanna show it, but it cannot be selectable
                $rec['disabled'] = TRUE;
            }
            else {
                return;
            }
        }

        if( !$content->ShowInMenu() ) {
            // content is not shown in menu
            if( !$this->show_navhidden ) return;
        }

        if( $content->Id() == $this->current ) $rec['selected'] = TRUE;

        // done
        $out[] = $rec;
    }

    /**
     * @ignore
     */
    private function _walk_nodes(\cms_content_tree $node,&$out)
    {
        if( $this->_is_child_of_start($node) ) {
            $this->_add_node($node,$out);
            if( !$node->has_children() ) return;
            $children = $node->get_children();
            foreach( $children as $child ) {
                $this->_walk_nodes($child,$out);
            }
        }
    }

    /**
     * Get a list of matching records.
     * This method returns an array of hashes.  Each row in the resultset
     * will have val,title,label,selected,disabled members.
     *
     * A consumer of this output can then parse these records and build a
     * suitable option list for a dropdown.
     *
     * @see content_list_builder::get_options()
     * @return array
     */
    public function get_content_list()
    {
        // initialize our start level
        $root = $tree = cmsms()->GetHierarchyManager();
        $this->_start_level = 0;
        if( $this->parent > 0 ) {
            $tree = $root->find_by_tag('id',$this->parent);
            if( !$tree ) throw new \CmsInvalidDataException('Page with id '.$this->parent.' not found');
            $this->_start_level = $tree->get_level() + 1;
        }

        // now that we have our paramters, start building our tree.
        $out = array();
        $allcontent = \ContentOperations::get_instance()->GetAllContent(FALSE);

        $out = array();
        if( !$tree->has_children() ) return;
        $children = $tree->get_children();
        foreach( $children as $child ) {
            $this->_walk_nodes($child,$out);
        }

        if( !count($out) ) return;
        return $out;
    }

    /**
     * Get html options suitable for use in a dropdown that
     * represent the pages that match the criteria specified.
     *
     * @return string
     */
    public function get_options()
    {
        $list = $this->get_content_list();
        if( !count($list) ) return;

        $_build_option = function($rec) {
            if( !$rec['label'] ) return;
            if( !$rec['val'] ) $rec['val'] = htmlentities($rec['label']);

            $out = '<option';
            $out .= ' value="'.$rec['val'].'"';
            if( $rec['title'] ) $out .= ' title="'.htmlentities($rec['title']).'"';
            if( $rec['disabled'] ) {
                $out .= ' disabled="disabled"';
            }
            else if( $rec['selected'] ) {
                $out .= ' selected="selected"';
            }
            $out .= '>'.str_repeat($this->spacer,$rec['depth']).htmlentities($rec['label']);
            $out .= '</option>';
            return $out;
        };

        $out = '';
        foreach( $list as $rec ) {
            $out .= $_build_option($rec);
        }
        return $out;
    }
} // end of class


#
# EOF
#
?>