<?php  /* -*- Mode: PHP; tab-width: 4; c-basic-offset: 2 -*- */
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
if (!isset($gCms)) exit;
if( $_SERVER['REQUEST_METHOD'] != 'POST' ) exit;

$out = '';
if( isset($_POST['compid']) ) {
  $company = cd_utils::get_company((int)$_POST['compid']);
  if( is_object($company) ) {
	$out = $company->company_name;
  }
} // if isset compid
else if( isset($_POST['term']) ) {
  $addid = false;
  if( isset($_POST['addid']) ) $addid = cms_to_bool($_POST['addid']);

  $mode = 'startswith';
  if( isset($_POST['mode']) ) {
	$tmode = strtolower($_POST['mode']);
	switch( $tmode ) {
	case 'endswith':
	case 'any':
	case 'startswith':
	  $mode = $tmode;
	  break;
	}
  }
  $term = trim($_POST['term']);
  
  switch( $mode ) {
  case 'any':
	if( !startswith($term,'*') ) $term = '*'.$term;
	if( !endswith($term,'*') ) $term .= '*';
	break;
  case 'endswith':
	if( !startswith($term,'*') ) $term = '*'.$term;
	break;
  case 'startswith':
  default:
	if( !endswith($term,'*') ) $term .= '*';
	break;
  }
  //$term = '::'.$term;
  $filter = new cd_company_filter(array('name'=>$term,'pagelimit'=>25,'deep'=>false));
  $query = new cd_company_query($filter);

  $n = $query->get_result_count();
  if( $n == 0 ) exit;
  $out = array();
  while( !$query->EOF ) {
	$row = $query->fields;
	$label = $row['company_name'];
	if( $addid ) $label .= ' ('.$row['id'].')';
	$out[] = array('label'=>$label,'value'=>$row['id'],'title'=>'test');
	$query->MoveNext();
  }
} // if isset term

echo json_encode($out); 
exit;
#
# EOF
#
?>
