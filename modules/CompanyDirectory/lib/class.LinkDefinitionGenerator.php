<?php
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: CompanyDirectory (c) 2004-6 by Ted Kulp (ted@cmsmadesimple.org)
#   Copyright 2006 - 2014 by Robert Campbell (calguy1000@cmsmadesimple.org)
#
#  An addon module for CMS Made Simple to allow management of and various ways to display
#  company information for use in directories etc.
#
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2005-2010 by Ted Kulp (wishy@cmsmadesimple.org)
# Visit the CMSMS homepage at: http://www.cmsmadesimple.org
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

namespace CompanyDirectory;
use \CGExtensions\LinkDefinition AS BASE;

class LinkDefinitionGenerator implements BASE\LinkDefinitionGenerator
{
    private $_dataref;

    public function set_dataref(BASE\DataRef $dataref)
    {
        $this->_dataref = $dataref;
    }

    public function get_linkdefinition()
    {
        $dr = $this->_dataref;
        $mod = \cms_utils::get_module(MOD_COMPANYDIRECTORY);
        if( $dr->key1 != $mod->GetName() ) throw new \RuntimeException(__CLASS__.' Does not know how to handle the provided DataRef');

        $pageid = \cms_utils::get_current_pageid();
        if( $pageid < 1 ) $pageid = \ContentOperations::get_instance()->GetDefaultContent();
        $tmp = (int) $mod->GetPreference('detailpage');
        if( $tmp > 0 ) $pageid = $tmp;

        $company = \cd_utils::get_company($dr->key2,$pageid,FALSE,TRUE);
        if( !is_object($company) ) throw new \RuntimeException(__CLASS__.' Company with id '.$dr->key2.' could not be read');
        $linkdefn = new BASE\LinkDefinition();
        $linkdefn->href = $company->canonical;
        $linkdefn->text = $company->company_name;
	$linkdefn->id = $dr->key2;

        if( !cmsms()->is_frontend_request() ) {
            // test if this user has the perm to edit this company.
            if( $mod->CheckPermission('Modify Company Directory') ) {
                $linkdefn->title = $mod->Lang('edit');
                $linkdefn->href = $mod->create_url('m1_','editcompany','',array('compid'=>$dr->key2));
            }
        }

        // for frontend actions we could link to the fesubmit stuff IF the user is the owner
        // AND we have a pageid...
        return $linkdefn;
    }
}

?>
