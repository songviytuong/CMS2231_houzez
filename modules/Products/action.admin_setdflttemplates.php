<?php  /* -*- Mode: PHP; c-set-style: linux; tab-width: 4; c-basic-offset: 4 -*- */
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: Products (c) 2008-2014 by Robert Campbell
#         (calguy1000@cmsmadesimple.org)
#  An addon module for CMS Made Simple to allow users to create, manage
#  and display products in a variety of ways.
#
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2005 by Ted Kulp (wishy@cmsmadesimple.org)
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

if( !isset($gCms) ) exit();
if( !$this->CheckPermission('Modify Templates') ) exit();

$this->SetCurrentTab('default_templates');

if( isset( $params['submit_summarytemplate'] ) ) {
  $this->SetPreference(PRODUCTS_PREF_NEWSUMMARY_TEMPLATE,trim($params['input_summarytemplate']));
}
else if( isset( $params['reset_summarytemplate'] ) ) {
  $fn = __DIR__.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'orig_summary_template.tpl';
  if( file_exists( $fn ) ) {
    $template = @file_get_contents($fn);
    $this->SetPreference(PRODUCTS_PREF_NEWSUMMARY_TEMPLATE,$template);
  }
}

if( isset( $params['submit_detailtemplate'] ) ) {
  $this->SetPreference(PRODUCTS_PREF_NEWDETAIL_TEMPLATE,trim($params['input_detailtemplate']));
}
else if( isset( $params['reset_detailtemplate'] ) ) {
  $fn = __DIR__.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'orig_detail_template.tpl';
  if( file_exists( $fn ) ) {
    $template = @file_get_contents($fn);
    $this->SetPreference(PRODUCTS_PREF_NEWDETAIL_TEMPLATE,$template);
  }
}


if( isset( $params['submit_byhierarchytemplate'] ) ) {
  $this->SetPreference(PRODUCTS_PREF_NEWBYHIERARCHY_TEMPLATE,trim($params['input_byhierarchytemplate']));
}
else if( isset( $params['reset_byhierarchytemplate'] ) ) {
  $fn = __DIR__.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'orig_byhierarchy_template.tpl';
  if( file_exists( $fn ) ) {
    $template = @file_get_contents($fn);
    $this->SetPreference(PRODUCTS_PREF_NEWBYHIERARCHY_TEMPLATE,$template);
  }
}


if( isset( $params['submit_categorylisttemplate'] ) ) {
  $this->SetPreference(PRODUCTS_PREF_NEWCATEGORYLIST_TEMPLATE,trim($params['input_categorylisttemplate']));
}
else if( isset( $params['reset_categorylisttemplate'] ) ) {
  $fn = __DIR__.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'orig_categorylist_template.tpl';
  if( file_exists( $fn ) ) {
    $template = @file_get_contents($fn);
    $this->SetPreference(PRODUCTS_PREF_NEWCATEGORYLIST_TEMPLATE,$template);
  }
}

if( isset( $params['submit_searchtemplate'] ) ) {
  $this->SetPreference(PRODUCTS_PREF_NEWSEARCH_TEMPLATE,trim($params['input_searchtemplate']));
}
else if( isset( $params['reset_searchtemplate'] ) ) {
  $fn = __DIR__.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'orig_search_template.tpl';
  if( file_exists( $fn ) ) {
    $template = @file_get_contents($fn);
    $this->SetPreference(PRODUCTS_PREF_NEWSEARCH_TEMPLATE,$template);
  }
}

$this->RedirectToTab($id);
// EOF
?>