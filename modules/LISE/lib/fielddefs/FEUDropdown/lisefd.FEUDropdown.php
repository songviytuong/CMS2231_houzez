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

class lisefd_FEUDropdown extends LISEFielddefBase
{
    public function __construct(&$db_info) 
    {   
        parent::__construct($db_info);
        
        $this->SetFriendlyType($this->ModLang('fielddef_'.$this->GetType()));
    }
    
    static public function GetModuleDeps() {
        
        return array(
            'FrontEndUsers' => '1.18.1',
            //'CMSMailer' => '1.73.9',
            'CGExtensions' => '1.29.1'    //??
        );
    }
    
    // get available groups from FEU module 
    public function GetFEUGroups() {
        
        $FEU = cmsms()->GetModuleInstance('FrontEndUsers');
        if(is_object($FEU)) {
            $groups = $FEU->GetGroupListFull();
            
            if($groups) {
                $options = array();
                foreach($groups as $option) {
                    $options[$option['id']] = $option['groupname'];
                }
            }
            
            return $options;
        }
    }
    
    // get list of users from FEU module based on selected group
    public function GetFEUUserList() {
        
        $FEU = cmsms()->GetModuleInstance('FrontEndUsers');
        if(is_object($FEU)) {
            
            // GetUsersInGroup() is deprecated but GetFullUsersInGroup() seems to have a bug, 
            // change this after FEU BR #8753 http://dev.cmsmadesimple.org/bug/view/8753 is confirmed and fixed 
            
            $users = $FEU->GetUsersInGroup($this->GetOptionValue('feu_options'));
            
            if($users) {
                $options = array_merge(array('' => $this->ModLang('select_one')));
                foreach($users as $option) {
                    $options[$option['id']] = $option['username'];
                }
            }
            
            return $options;
        }
    }
    
    // return username from id in item summary
    public function RenderForAdminListing($id, $returnid) {
        
        if(!$this->HasValue() && !is_numeric($this->GetValue()))
            return;
        
        $FEU = cmsms()->GetModuleInstance('FrontEndUsers');
        if(is_object($FEU)) {
            return $FEU->GetUserName($this->GetValue());
        }
    }
}// end of class
?>