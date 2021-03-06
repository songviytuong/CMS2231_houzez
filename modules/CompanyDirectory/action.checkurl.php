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

$turl = '';
$tname = '';
$output = new StdClass();

if( isset($params['cd_name']) ) $tname = trim($params['cd_name']);
if( isset($params['cd_url']) ) $turl = trim($params['cd_url']);

if( $tname == '' )
  {
    $output->status = 'ERROR';
    $output->error = $this->Lang('error_invalidname');
    echo json_encode($output);
    exit();
  }

$tname = cms_html_entity_decode($tname);
$turl = cms_html_entity_decode($turl);

// if we have a url, we just check the one provided
// if we don't have a url, we calculate one.
if( !$turl ) $turl = cd_utils::generate_url($tname);
if( !$turl )
  {
	$output->status = 'ERROR';
	$output->error = $this->Lang('error_invalidname');
	echo json_encode($output);
	exit();
  }

$res = cd_utils::validate_url($turl);
if( !$res )
  {
	$output->status = 'ERROR';
	$output->error = $this->Lang('error_invalidurl');
	echo json_encode($output);
	exit();
  }

$output->status = 'OK';
$output->url = $turl;
echo json_encode($output);
exit();

#
# EOF
#
?>