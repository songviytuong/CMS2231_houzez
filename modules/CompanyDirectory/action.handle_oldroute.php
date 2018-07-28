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
if( !isset($params['action']) ) {
    // do a 404
    cge_redirect::redirect404();
}

if( !$this->GetPreference('url_redirectold',0) || !isset($params['companyid']) ) {
    // somehow we got here, even though the preference is off.
    // gotta redirect 404, cuz we don't know where we're supposed to go.
    cge_redirect::redirect404();
}

// we're redirecting to an item that should have a URL.
$db = cmsms()->GetDb();
$query = 'SELECT * FROM '.cms_db_prefix().'module_compdir_companies WHERE id = ? AND url != ?';
$rec = $db->GetRow($query,array($params['companyid'],''));

if( !$rec ) {
    // couldn't find the record, or it exists has an empty URL.
    // do the original action.
    if( !isset($params['origaction']) ) cge_redirect::redirect404();

    $params['action'] = $params['origaction'];
    unset($params['origaction']);
    return $this->DoAction($params['action'],$id,$params,$returnid);
}

cge_tmpdata::set('companydir_'.$rec['id'],$rec);
$detailpage = $this->GetPreference('detailpage',-1);
if( $detailpage == -1 ) {
    $contentops = ContentOperations::get_instance();
    $detailpage = $contentops->GetDefaultContent();
}

$url = $this->create_url($id,'details',$detailpage,$params);
cge_redirect::redirect_abs301($url);

#
# EOF
#
?>