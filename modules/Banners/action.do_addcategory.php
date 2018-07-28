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
if( !isset($gCms) ) exit;
if (!$this->CheckPermission ('Banners Manager')) exit;

$this->SetCurrentTab('categories');

// are we cancelling
if (isset ($params['cancel']))
  {
    $this->RedirectToTab($id);
  }

    $error = false;

    // make sure we have something to work with
    if (!isset ($params['input_categoryname'])
	|| $params['input_categoryname'] == "")
      {
	$smarty->assign ('error', "1");
	$smarty->assign ('message', $this->Lang ("error_emptycategory"));
	$error = true;
      }
    else
      {
	// check if the category doesn't already exist
	$db = $this->GetDb();
	$query =
	  "SELECT * from ".cms_db_prefix ().
	  "module_banners_categories WHERE name = ?";
	$dbresult =
	  $db->Execute ($query, array ($params['input_categoryname']));

	// yep it does
	if ($dbresult->FetchRow ())
	  {
	    $smarty->assign ('error', "1");
	    $smarty->assign ('message',
				   $this->Lang ("error_categoryexists"));
	    $error = true;
	  }
	else
	  {
	    // we're clear to add (yahoo)
	    $catid =
	      $db->GenID (cms_db_prefix ()."module_banners_categories_seq");
	    $params['category_id'] = $catid;
	    $query =
	      "INSERT INTO ".cms_db_prefix ().
	      "module_banners_categories 
              (category_id,name,description,uploads_category_id,template,dflt_image,dflt_url) VALUES (?,?,?,?,?,?,?)";
	    $dbresult =
	      $db->Execute ($query,
			    array ($catid,
				   $params["input_categoryname"],
				   $params["input_categorydesc"],
				   $params["input_upload_category"],
				   $params['input_template'],
				   $params['dflt_image'],
				   $params['dflt_url']
				   ));
	    if (!$dbresult)
	      {
		$smarty->assign ('error', "1");
		$smarty->assign ('message',
				       $this->Lang ("error_dberror"));
		$error = true;
	      }
	  }
      }

    if ($error)
      {
	echo $this->ProcessTemplate ('addcategory.tpl');
      }
    else
      {
	$this->RedirectToTab($id);
      }

?>