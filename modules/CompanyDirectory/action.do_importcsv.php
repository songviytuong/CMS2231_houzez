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
if( !isset($gCms) ) exit;

#
# Cached data
#
$_hier_cache = null;
$_fielddef_cache = null;
$_category_cache = null;
$_error = '';
$_num_hier = 0;
set_time_limit(9999);

#
# Initialization
#
$delimiter = '|';
$enclosure = '"';
$do_fielddefs = 0;
$do_fieldvals = 0;
$do_categorydefs = 0;
$do_categoryvals = 0;
$do_hierarchydefs = 0;
$do_hierarchyvals = 0;
$do_lookup = 0;
$do_create_url = 0;
$check_duplicates = 'error';

#
# Get Form Data
#
$importer = new cd_ascii_importer($this);
if( isset($params['cancel']) ) $this->CGRedirect($id,'defaultadmin',$returnid);

$delimiter = cge_utils::get_param($params,'delimeter',$delimiter);
$importer->set_delimiter($delimiter);
$this->SetPreference('import_delimiter',$delimiter);

$enclosure = cge_utils::get_param($params,'enclosure',$enclosure);
$importer->set_enclosure($enclosure);
$this->SetPreference('import_enclosure',$enclosure);

$do_fielddefs = (int) cge_utils::get_param($params,'do_fielddefs',$do_fielddefs);
$importer->do_fielddefs($do_fielddefs);
$this->SetPreference('import_fielddefs',$do_fielddefs);

$do_fieldvals = (int) cge_utils::get_param($params,'do_fieldvals',$do_fieldvals);
$importer->do_fieldvals($do_fieldvals);
$this->SetPreference('import_fieldvals',$do_fieldvals);

$do_categorydefs = (int) cge_utils::get_param($params,'do_categorydefs',$do_categorydefs);
$importer->do_categorydefs($do_categorydefs);
$this->SetPreference('import_categorydefs',$do_categorydefs);

$do_categoryvals = (int) cge_utils::get_param($params,'do_categoryvals',$do_categoryvals);
$importer->do_categoryvals($do_categoryvals);
$this->SetPreference('import_categoryvals',$do_categoryvals);

$do_hierarchydefs = (int) cge_utils::get_param($params,'do_hierarchydefs',$do_hierarchydefs);
$importer->do_hierarchydefs($do_hierarchydefs);
$this->SetPreference('import_hierarchydefs',$do_hierarchydefs);

$do_hierarchyvals = (int) cge_utils::get_param($params,'do_hierarchyvals',$do_hierarchyvals);
$importer->do_hierarchyvals($do_hierarchyvals);
$this->SetPreference('import_hierarchyvals',$do_hierarchyvals);

$do_lookup = (int) cge_utils::get_param($params,'do_lookup',$do_lookup);
$importer->do_latlong_lookup($do_lookup);
$this->SetPreference('import_lookuplatlong',$do_lookup);

$do_create_url = (int) cge_utils::get_param($params,'do_create_url',$do_create_url);
$importer->create_url($do_create_url);
$this->SetPreference('import_create_url',$do_create_url);

$check_duplicates = trim(cge_utils::get_param($params,'check_duplicates'),$check_duplicates);
$importer->check_duplicate_companies($check_duplicates);
$this->SetPreference('import_checkduplicates',$check_duplicates);

if( $delimiter == '' ) {
  $this->SetError($this->Lang('error_missingparam'));
  $this->CGRedirect($id,'importcsv',$returnid);
}
else if( !isset($_FILES[$id.'csvfile']) || $_FILES[$id.'csvfile']['size'] == 0 ) {
  $this->SetError($this->Lang('error_missingupload'));
  $this->CGRedirect($id,'importcsv',$returnid);
}
else if( $_FILES[$id.'csvfile']['error'] != 0 ) {
  $this->SetError($this->Lang('error_badupload'));
  $this->CGRedirect($id,'importcsv',$returnid);
}
$filename = $_FILES[$id.'csvfile']['tmp_name'];

$res = $importer->import_file($filename);
$errors = $importer->get_errors();
if( count($errors) ) $smarty->assign('errors',$errors);
$results = $importer->get_results();
$smarty->assign('num_companies',$results['num_companies']);
$smarty->assign('num_categories',$results['num_categories']);
$smarty->assign('num_fielddefs',$results['num_fielddefs']);
$smarty->assign('num_hier',$results['num_hier']);
$smarty->assign('return_url',$this->CreateURL($id,'defaultadmin',$returnid));

if( $results['num_companies'] > 0 || $results['num_categories'] > 0 ||
	$results['num_fielddefs'] > 0 || $results['num_hier'] > 0 ) {
  audit('',$this->GetName(),
        sprintf('Imported data from CSV (%d companies, %d categories, %d field defs, %d hier)',
                $results['num_companies'], $results['num_categories'],
                $results['num_fielddefs'], $results['num_hier']));
}

echo $this->ProcessTemplate('do_importcsv.tpl');
#
# EOF
#
?>
