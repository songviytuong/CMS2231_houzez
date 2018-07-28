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

//////////
// A simple function to generate a url to a module action
//////////
function module_action_url($params, &$tpl)
{
    $params['urlonly'] = 1;
    $assign = \cge_param::get_string($params,'assign');
    unset($params['imageonly'],$params['text'],$params['title'],$params['image'],$params['class'],$params['assign']);
    $out = module_action_link($params,$tpl);

    if( $assign ) {
        $tpl->assign($assign,$out);
        return;
    }
    return $out;
}

//////////
// A simple function to generate a link to a module action
//////////
function module_action_link($params, &$smarty)
{
    $gCms = CmsApp::get_instance();
    $mid = 'm1_';
    $inline = FALSE;

    $module = $smarty->get_template_vars('module');
    if( !$module ) $module = $smarty->get_template_vars('actionmodule');
    $module = get_parameter_value($params,'module',$module);
    if( !$module ) $module = $smarty->getTemplateVars('module');
    if( !$module ) $module = $smarty->getTemplateVars('actionmodule');
    if( !$module ) return;
    unset($params['module']);

    $obj = cms_utils::get_module($module);
    if( !is_object($obj) ) return;

    $text = $module;
    if( isset($params['text']) ) {
        $text = trim($params['text']);
        unset($params['text']);
    }

    $title = '';
    if( isset($params['title']) ) {
        $title = trim($params['title']);
        unset($params['title']);
    }

    $confmessage = '';
    if( isset($params['confmessage']) ) {
        $confmessage = trim($params['confmessage']);
        unset($params['confmessage']);
    }

    $image = '';
    if( isset($params['image']) ) {
        $image = trim($params['image']);
        unset($params['image']);
    }

    $class = 'systemicon';
    if( isset($params['class']) ) {
        $class = trim($params['class']);
        unset($params['class']);
    }

    $action = 'default';
    if( isset($params['action']) ) {
        $action = $params['action'];
        unset($params['action']);
    }

    if( isset($params['id']) ) {
        $mid = $params['id'];
        $inline = TRUE;
        unset($params['id']);
    }

    $imageonly = false;
    if( isset($params['imageonly']) ) {
        $imageonly = true;
        unset($params['imageonly']);
    }

    $pageid = cms_utils::get_current_pageid();
    if( isset($params['page']) ) {
        // convert the page alias to an id
        $manager = $gCms->GetHierarchyManager();
        $node = $manager->sureGetNodeByAlias($params['page']);
        if (isset($node)) {
            $content = $node->GetContent();
            if (isset($content)) $pageid = $content->Id();
        }
        else {
            $node = $manager->sureGetNodeById($params['page']);
            if (isset($node)) $pageid = $params['page'];
        }
        unset($params['page']);
    }

    $urlonly = cge_utils::to_bool(cge_utils::get_param($params,'urlonly',false));
    if( $urlonly ) {
        $urlonly = true;
        unset($params['urlonly']);
    }

    $jsfriendly = cge_utils::to_bool(cge_utils::get_param($params,'jsfriendly',false));
    if( $jsfriendly ) {
        $jsfriendly = true;
        $urlonly = true;
        unset($params['jsfriendly']);
    }

    $forjs = cge_utils::to_bool(cge_utils::get_param($params,'forjs',false));
    if( $forjs ) {
        $jsfriendly = true;
        $urlonly = true;
        unset($params['forjs']);
    }

    $forajax = cge_utils::to_bool(cge_utils::get_param($params,'forajax',false));
    $forajax = cge_utils::to_bool(cge_utils::get_param($params,'for_ajax',$forajax));
    if( $forajax ) {
        $jsfriendly = true;
        $urlonly = true;
        $forajax = true;
        unset($params['forajax']);
        unset($params['for_ajax']);
    }

    $assign = '';
    if( isset($params['assign']) ) {
        $assign = trim($params['assign']);
        unset($params['assign']);
    }

    $addtext = '';
    if( $title ) $addtext = 'title="'.$title.'"';

    if( !empty($image) && method_exists($obj,'CreateImageLink') && $urlonly == false ) {
        $output = $obj->CreateImageLink($mid,$action,$pageid,$text,$image,$params,$class,$confmessage,$imageonly,FALSE,$addtext);
    }
    else {
        $output = $obj->CreateLink($mid,$action,$pageid,$text,$params,$confmessage,$urlonly,$inline,$addtext);
        if( $urlonly && $jsfriendly ) {
            $output = str_replace('amp;','',$output);
        }
        if( $forajax ) {
            if( strpos($output,'?') === FALSE ) {
                $output .= '?showtemplate=false';
            }
            else {
                $output .= '&showtemplate=false';
            }
        }
    }

    // all done
    if( !empty($assign) ) {
        $smarty->assign($assign,$output);
        return;
    }
    return $output;
}

# EOF
