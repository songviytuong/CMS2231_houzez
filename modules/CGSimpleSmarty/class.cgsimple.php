<?php
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: CGSimpleSmarty (c) 2008 by Robert Campbell
#         (calguy1000@cmsmadesimple.org)
#  An addon module for CMS Made Simple that provides simple smarty
#  methods and functions to ease developing CMS Made simple powered
#  websites.
#
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2005 by Ted Kulp (wishy@cmsmadesimple.org)
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

final class cgsimple
{
    private function __construct() {}

    /**
     * Get the current URL
     *
     * @return string
     */
    static public function self_url()
    {
        $s = (\cge_utils::ssl_request())  ? "s" : "";
        $p = strpos($_SERVER['SERVER_PROTOCOL'],'/');
        $protocol = strtolower(substr($_SERVER['SERVER_PROTOCOL'],0,$p)).$s;
        $port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);
        $s = $protocol."://".$_SERVER['SERVER_NAME'].$port;

        return $s.$_SERVER['REQUEST_URI'];
    }


    /**
     * Test if a module is installed, and active.
     *
     * @param string $module the module name
     * @return bool
     */
    static public function module_installed($module)
    {
        if( $module == '' ) return 0;
        $module = \cms_utils::get_module($module);

        $result = 0;
        if( is_object( $module ) ) $result = 1;
        return $result;
    }


    /**
     * Get the alias of the specified alias' parent. if any
     *
     * @param string $alias The optional alias.  If not specified, the current page is used.
     * @return string
     */
    static public function get_parent_alias($alias = '')
    {
        $gCms = \CmsApp::get_instance();
        $hm = $gCms->GetHierarchyManager();

        if( $alias == '' ) $alias = \cms_utils::get_current_alias();
        $node = $hm->find_by_tag('alias',$alias);
        if( !$node ) return;

        $alias = $node->getParent()->get_tag('alias');
        return $alias;
    }


    /**
     * Get the alias of the root page of the specified alias.
     *
     * @param string $alias The desired page alias.  If not specified, the current page alias is used.
     * @return string
     */
    static public function get_root_alias($alias = '')
    {
        $gCms = \CmsApp::get_instance();
        $hm = $gCms->GetHierarchyManager();

        if( $alias == '' ) $alias = \cms_utils::get_current_alias();

        $stack = array();
        $node = $hm->find_by_tag('alias',$alias);
        while( $node && $node->get_tag('id') > 0 ) {
            $stack[] = $node;
            $node = $node->getParent();
        }

        if( count($stack) == 0 ) return;
        $alias = $stack[count($stack)-1]->get_tag('alias');
        return $alias;
    }


    /**
     * Get the title of the specified page (by alias) or the current page.
     *
     * @param string $alias Optional alias
     * @return string
     */
    static public function get_page_title($alias = '')
    {
        $contentops = \ContentOperations::get_instance();

        if( $alias == '' ) $alias = \cms_utils::get_current_alias();
        $content = $contentops->LoadContentFromAlias($alias);
        if( !is_object($content) ) return '';
        return $content->Name();
    }


    /**
     * Get the menu text of the specified page (by alias) or the current page.
     *
     * @param string $alias Optional alias
     * @return string
     */
    static public function get_page_menutext($alias = '')
    {
        $contentops = \ContentOperations::get_instance();

        if( $alias == '' ) $alias = \cms_utils::get_current_alias();
        $content = $contentops->LoadContentFromAlias($alias);
        if( !is_object($content) ) return '';
        return $content->MenuText();
    }


    /**
     * Get the type of the specified page (by alias) or the current page.
     *
     * @param string $alias Optional alias
     * @return string
     */
    static public function get_page_type($alias = '')
    {
        $contentops = \ContentOperations::get_instance();

        if( $alias == '' ) $alias = \cms_utils::get_current_alias();
        $content = $contentops->LoadContentFromAlias($alias);
        if( !is_object($content) ) return '';
        return $content->Type();
    }


    /**
     * Test if the current page has children.
     * Does not test for hidden, or inactive children.
     *
     * @param string $alias Optional alias
     * @return bool
     */
    static public function has_children($alias = '')
    {
        $gCms = \CmsApp::get_instance();
        $hm = $gCms->GetHierarchyManager();
        if( $alias == '' ) $alias = \cms_utils::get_current_alias();
        $node = $hm->find_by_tag('alias',$alias);
        if( !$node ) return;
        return $node->has_children();
    }


    /**
     * Return an array containing the page ids of all of the specified page's children.
     *
     * @param string $alias Optional alias
     * @param bool $showall Wether to show inactive children.
     * @return array
     */
    static public function get_children($alias = '',$showall = false)
    {
        if( $alias == '' ) $alias = \cms_utils::get_current_alias();
        if( $alias == '' ) return;

        $hm = cmsms()->GetHierarchyManager();
        $parent = $hm->find_by_tag('alias',$alias);
        if( !$parent ) return;

        $child_nodes = $parent->getChildren(false,true);
        if( !is_array($child_nodes) || count($child_nodes) == 0 ) return;

        $results = array();
        foreach( $child_nodes as $node ) {
            $content = $node->getContent();
            if( !is_object($content) ) continue;
            if( !$content->Active() && !$showall ) continue;
            $row = array('alias'=>$content->Alias(),'id'=>$content->Id(),'title'=>$content->Name(),'menutext'=>$content->MenuText(),
                         'active'=>$content->Active(),'show_in_menu'=>$content->ShowInMenu(),'type'=>$content->Type());
            $results[] = $row;
        }
        if( count($results) ) return $results;
    }

    /**
     * Return a module's version
     *
     * @param string $name The module name
     * @return string
     */
    static public function module_version($name)
    {
        if( !empty($name) ) {
            $obj = \cms_utils::get_module($name);
            if( is_object($obj) ) return $obj->GetVersion();
        }
    }


    /**
     * Get page content (or any property value) for the current page or another page (by alias)
     *
     * @param string $alias Optional alias
     * @param string $block The property name.  If not specified, 'content_en' is assumed.
     * @return string
     */
    static public function get_page_content($alias = null,$block = null)
    {
        $content = null;
        $block = trim($block);

        if( !$block ) $block = 'content_en';
        if( !$alias ) {
            $content = CmsApp::get_instance()->get_content_object();
        }
        else {
            $contentops = \ContentOperations::get_instance();
            $content = $contentops->LoadContentFromAlias($alias);
        }
        if( is_object($content) ) return $content->GetPropertyValue($block);
    }


    /**
     * Get a sibling to the current page (if any)
     *
     * @param mixed $dir The direction (possible values are -1,prev,1,next)
     * @return string The alias of the specified page.
     */
    static public function get_sibling($dir,$alias)
    {
        $contentops = \ContentOperations::get_instance();

        if( empty($alias) ) $alias = \cms_utils::get_current_alias();
        // @todo: could use the tree here (find the node, get it's parent, the parent's childs are the sibling)
        $content = $contentops->LoadContentFromAlias($alias);
        if( !is_object($content) ) return false;

        // get the last item out of the hierarchy
        // and rebuild
        $query = 'SELECT content_alias FROM '.cms_db_prefix().'content
              WHERE parent_id = ? AND item_order %s ? AND active = 1 ORDER BY item_order %s LIMIT 1';

        switch(strtolower($dir)) {
        case '-1':
        case 'prev':
            $thechar = '<';
            $order = 'DESC';
            break;

        default:
            $thechar = '>';
            $order = 'ASC';
            break;
        }

        $db = \CmsApp::get_instance()->GetDb();
        $res = $db->GetOne(sprintf($query,$thechar,$order), array($content->ParentId(),$content->ItemOrder()));
        return $res;
    }

    /**
     * Get a file listing for a specified directory.
     *
     * @param string $dir The absolute directory.
     * @param string $excludeprefix Optionally exclude files with this prefix.
     * @return string[]
     */
    static public function get_file_listing($dir,$excludeprefix='')
    {
        $config = cms_config::get_instance();

        $fileprefix = '';
        if( !empty($excludeprefix) ) $fileprefix = $excludeprefix;
        if( startswith($dir,'/') ) return;
        $dir = cms_join_path($config['uploads_path'],$dir);
        $list = get_matching_files($dir,'',true,true,$fileprefix,1);
        return $list;
    }

    /**
     * Get a parallel content object given given a different root alias
     * i.e: if the current (or specified page alias) is at hierarchy level 4.1.1
     * and the 'new parent' alias is at hierarchy level 5
     * this function will return the page alias for hierarchy level 5.1.1 (if it exists).
     * useful for multi-lang sites.
     *
     * @param string $new_root The alias of the new root page (i.e: fr)
     * @param string $current_page An optional page alias.  If not specified the current page is used.
     * @return ContentBase the parallel content object.
     */
    static public function get_parallel_content($new_root,$current_page = null)
    {
        if( empty($new_root) ) return;
        $contentops = \ContentOperations::get_instance();
        if( empty($current_page) ) $current_page = \cms_utils::get_current_alias();

        $cur_content = $contentops->LoadContentFromAlias($current_page);
        if( !is_object($cur_content) ) return;

        $tmp = self::get_root_alias($new_root); // make sure we go to the root
        if( $tmp ) $new_root = $tmp;
        $new_root_content = $contentops->LoadContentFromAlias($new_root);
        if( !is_object($new_root_content) ) return;

        $hier1 = $cur_content->Hierarchy();
        $hier2 = $new_root_content->Hierarchy();
        if( !$hier1 || !$hier2 ) return;

        $a_hier1 = explode('.',$hier1);
        $a_hier2 = explode('.',$hier2);
        $a_hier1[0] = $a_hier2[0];
        $hier3 = implode('.',$a_hier1);

        // we have the new hierarchy... just gotta find the right page for it.
        $new_pageid = $contentops->GetPageIDFromHierarchy($hier3);
        if( !$new_pageid ) return;

        $newcontent = $contentops->LoadContentFromAlias($new_pageid);
        return $newcontent;
    }

    /**
     * Generate a URL to an anchor on the same page
     *
     * @param string $name The name of the anchor
     * @return string
     */
    static public function anchor_url($name)
    {
        if( !$name ) return;
        $name = trim($name);
        if( !$name ) return;
        $content_obj = \cms_utils::get_current_content();
        if( !is_object($content_obj) ) return;
        return $content_obj->GetURL().'#'.$name;
    }

    /**
     * Get a parallel page alias given a different root alias
     * i.e: if the current (or specified page alias) is at hierarchy level 4.1.1
     * and the 'new parent' alias is at hierarchy level 5
     * this function will return the page alias for hierarchy level 5.1.1 (if it exists).
     * useful for multi-lang sites.
     *
     * @param string $new_root The alias of the new root page (i.e: fr)
     * @param string $current_page An optional page alias.  If not specified the current page is used.
     * @return string the alias of the parallel page.
     */
    static public function get_parallel_page($new_root,$current_page = null)
    {
        $content = self::get_parallel_content($new_root,$current_page);
        if( $content ) return $content->Alias();
    }

    /**
     * Get the URL of a parallel page given a different root alias
     * i.e: if the current (or specified page alias) is at hierarchy level 4.1.1
     * and the 'new parent' alias is at hierarchy level 5
     * this function will return the page alias for hierarchy level 5.1.1 (if it exists).
     * useful for multi-lang sites.
     *
     * @param string $new_root The alias of the new root page (i.e: fr)
     * @param string $current_page An optional page alias.  If not specified the current page is used.
     * @return string the alias of the parallel page.
     */
    static public function get_parallel_url($new_root,$current_page = null)
    {
        $content = self::get_parallel_content($new_root,$current_page);
        if( $content ) return $content->GetUrl();
    }

};

// EOF
?>
