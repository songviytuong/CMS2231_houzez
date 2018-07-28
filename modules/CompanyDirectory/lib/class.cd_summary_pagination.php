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

class cd_summary_pagination
{
  private static $_keys = array('pagecount','page','pagelimit');
  private $_inline_links = 0;
  private $_id = 'cd_';
  private $_action = 'default';
  private $_returnid;
  private $_filter;
  private $_query;
  private $_npages;
  private $_cb;
  private $_extraparms;

  public function __construct(cd_company_filter $filter, cd_company_query $query)
  {
	$this->_id = $filter['id'];
	global $CMS_ADMIN_PAGE;
	if( !isset($CMS_ADMIN_PAGE) ) {
	  $this->_returnid = (int)$filter['returnid'];
	}
	else {
	  $this->_id = 'm1_';
	}
    $this->_filter   = $filter;
    $this->_query    = $query;
  }

  public function set_action($action)
  {
	if( $action ) $this->_action = $action;
  }

  public function set_extraparams($params)
  {
	if( !is_array($params) ) return;

	if( !is_array($this->_extraparms) ) $this->_extraparms = array();
	foreach( $params as $key => $value ) {
	  if( is_numeric($key) ) continue;
	  if( is_object($value) || is_array($value) ) continue;
	  $this->_extraparms[$key] = $value;
	}
  }

  public function reset_extraparams()
  {
	$this->_extraparms = null;
  }

  public function set_inline_links($flag = TRUE)
  {
	$this->_inline_links = $flag;
  }

  public function get_page_count()
  {
    if( is_null($this->_npages) ) {
	  $nitems = $this->_query->get_total_matches();
	  $limit = $this->_filter['pagelimit'];

	  $npages = (int)($nitems / $limit);
	  if( $nitems % $limit ) $npages++;

	  $this->_npages = $npages;
	}
    return $this->_npages;
  }

  public function get_current_page()
  {
    return (int)($this->_filter['page']);
  }

  public function get_pagelimit()
  {
    return $this->_filter['pagelimit'];
  }

  public function get_firstpage_url()
  {
    return $this->get_page_url(1);
  }

  public function get_prevpage_url()
  {
    return $this->get_page_url($this->get_current_page()-1);
  }

  public function get_nextpage_url()
  {
    return $this->get_page_url($this->get_current_page()+1);
  }

  public function get_lastpage_url()
  {
    return $this->get_page_url($this->get_page_count());
  }

  public function get_page_url($pagenum)
  {
    $pagenum = (int)$pagenum;
    $pagenum = max(1,$pagenum);
    $pagenum = min($pagenum,$this->get_page_count());
    $parms = $this->_filter->get_params();
	if( is_array($this->_extraparms) ) $parms = array_merge($this->_extraparms,$parms);
    $parms['page'] = $pagenum;
	$parms2 = array();
	foreach( $parms as $key => $val ) {
	  //if( !startswith($key,'cd_') ) $key = 'cd_'.$key;
	  $parms2[$key] = $val;
	}
    $mod = cms_utils::get_module('CompanyDirectory');
	$mod->noprettyurl = 1;
    $url = $mod->create_url($this->_id,$this->_action,$this->_returnid,$parms2,$this->_inline_links);
	$mod->noprettyurl = 0;
    return $url;
  }

  public function get_page_link($pagenum,$text)
  {
    $pagenum = (int)$pagenum;
    $pagenum = max(1,$pagenum);
    $pagenum = min($pagenum,$this->get_page_count());
    $parms = $this->_filter->get_params();
	if( is_array($this->_extraparms) ) $parms = array_merge($this->_extraparms,$parms);
    $parms['page'] = $pagenum;
	$parms['nopretty']  = 1;

	$parms2 = array();
	foreach( $parms as $key => $val ) {
	  //if( !startswith($key,'cd_') ) $key = 'cd_'.$key;
	  $parms2[$key] = $val;
	}

    $mod = cms_utils::get_module('CompanyDirectory');
	$mod->noprettyurl = 1;
	$link = $mod->CreateLink($this->_id,$this->_action,$this->_returnid,$text,$parms2,'',false,$this->_inline_links);
	$mod->noprettyurl = 0;
	return $link;
  }

} // summary pagination

#
# EOF
#
?>