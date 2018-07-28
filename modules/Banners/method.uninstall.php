<?php
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: Banners (c) 2008 by Robert Campbell 
#         (calguy1000@cmsmadesimple.org)
#  An addon module for CMS Made Simple to allow management, display,
#  and tracking of banner images.
# 
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2005 by Ted Kulp (wishy@cmsmadesimple.org)
# This project's homepage is: http://www.cmsmadesimple.org
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

    $db = $this->GetDb();
  
    // remove the database table
    $dict = NewDataDictionary( $db );
    $sqlarray = $dict->DropTableSQL( cms_db_prefix()."module_banners" );
    $dict->ExecuteSQLArray($sqlarray);
    $sqlarray = $dict->DropTableSQL( cms_db_prefix()."module_banners_categories" );
    $dict->ExecuteSQLArray($sqlarray);
    $sqlarray = $dict->DropTableSQL( cms_db_prefix()."module_banners_hits" );
    $dict->ExecuteSQLArray($sqlarray);
    $sqlarray = $dict->DropTableSQL( cms_db_prefix()."module_banners_seq" );
    $dict->ExecuteSQLArray($sqlarray);
    $sqlarray = $dict->DropTableSQL( cms_db_prefix()."module_banners_categories_seq" );
    $dict->ExecuteSQLArray($sqlarray);
  
    // remove the sequence
    $db->DropSequence( cms_db_prefix()."module_consultant_seq" );
  
    // remove the permissions
    $this->RemovePermission('Banners Manager');

    // and the preferences
    $this->RemovePreference ("subnet_exclusions");
  
    // put mention into the admin log
    $this->Audit( 0, $this->Lang('friendlyname'), $this->Lang('uninstalled'));

?>