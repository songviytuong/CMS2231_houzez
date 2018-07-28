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
 * This file defines a Link Definition Generator for core DataRefs.
 *
 * @package CGExtensions
 * @category Communications
 * @author  calguy1000 <calguy1000@cmsmadesimple.org>
 * @copyright Copyright 2014 by Robert Campbell
 */

namespace CGExtensions\LinkDefinition;

/**
 * A class for generating linkdefinition objects given datarefs that match are for the core
 * i.e: pages, stylesheets, etc
 */
class CoreLinkDefinitionGenerator
{
    /**
     * @ignore
     */
    private $_dataref;

    /**
     * Set the DataRef for this generator.
     *
     * @param DataRef $dataref
     */
    public function set_dataref(DataRef $dataref)
    {
        $this->_dataref = $dataref;
    }

    /**
     * Get a link definition for the provided dataref.
     *
     * @return LinkDefinition
     */
    public function get_linkdefinition()
    {
        if( !is_a($this->_dataref,'\CGExtensions\LinkDefinition\DataRef') ) {
            throw new \RuntimeException('Data passed to '.__CLASS__.' is not a DataRef');
        }

        $key2 = $this->_dataref->key2;
        $key3 = $this->_dataref->key3;
        if( (int) $key2 > 0 ) {
            $key3 = $key2;
            $key2 = 'page';
        }

        switch( strtolower($key2) ) {
        case 'page':
            // get the content object specified by key3
            $key3 = (int)$key3;
            if( $key3 < 1 ) throw new \RuntimeException('Invalid Core DataRef key3 does not represent a valid page id');
            $content = \ContentOperations::get_instance()->LoadContentFromId($key3);
            if( !is_object($content) )  throw new \RuntimeException('Could not find content object specified in DataRef object');

            // now, if this is a frontend request, obviously we should just export the proper URL for this content object
            if( cmsms()->is_frontend_request() ) {
                if( !$content->HasUsableLink() ) {
                    throw new \RuntimeException('Cannot create a LinkDefinition to a content type that has no usable link');
                }
                if( !$content->Active() ) {
                    throw new \RuntimeException('Cannot create a LinkDefinition to a content page that is inactive');
                }
                $linkdefn = new LinkDefinition();
                $linkdefn->href = $content->GetURL();
                $linkdefn->text = $content->Name();
                $linkdefn->title = $content->TitleAttribute();
                return $linkdefn;
            }
            else {
                // if it is an admin request we do not need to check if the page is active, or has a usable link
                // but we may need to know if the apge is editable by this user (do this later)
                if( version_compare(CMS_VERSION,'1.99') < 0 ) {
                    // 1.x uses admin/editcontent.php?content_id=##
                    $config = cmsms()->GetConfig();
                    $linkdefn = new LinkDefn();
                    $linkdefn->href = $config['admin_url'].'/editcontent.php?content_id='.$content->Id();
                    $linkdefn->text = $content->GetName();
                    return $linkdefn;
                }
                else {
                    // 2.x uses CmsContentManager, there is no abstracted method to get the edit url.
                    // so we get the content manager module
                    // and us it's create url method with the admin_editcontent action, and a content_id param
                    $mod = \cms_utils::get_module('CMSContentManager');
                    $linkdefn = new LinkDefn();
                    $linkdefn->href = $mod->create_url('m1_','admin_editcontent','',array('content_id'=>$key3));
                    $linkedfn->text = $content->GetName();
                    return $linkdefn;
                }
            }
            break;

        case 'stylesheet':
        case 'template':
            stack_trace();
            die('incomplete');
            break;

        default:
            throw new \RuntimeException(__CLASS__.' does not know how to handle core datarefs where key2 is '.$key2);
            break;
        }

    }
}
?>