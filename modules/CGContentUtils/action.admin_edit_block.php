<?php
#BEGIN_LICENSE
#-------------------------------------------------------------------------
# Module: CGContentUtils (c) 2009 by Robert Campbell
#         (calguy1000@cmsmadesimple.org)
#  An addon module for CMS Made Simple to provide various additional utilities
#  for dealing with content pages.
#
#-------------------------------------------------------------------------
# CMS - CMS Made Simple is (c) 2005 by Ted Kulp (wishy@cmsmadesimple.org)
# This projects homepage is: http://www.cmsmadesimple.org
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

//
// initialization
//
$this->SetCurrentTab('blocks');
$blockid = '';
$data = array();
$data['name'] = '';
$data['prompt'] = '';
$data['type'] = 'textinput';
$data['value'] = '';
$data['attribs'] = array();
$data['attribs']['length'] = '80';
$data['attribs']['maxlength'] = '255';
$data['attribs']['rows'] = '8';
$data['attribs']['cols'] = '50';
$data['attribs']['wysiwyg'] = true;
$data['attribs']['options'] = '';
$data['attribs']['fieldtext'] = '';
$data['attribs']['storagedelimiter'] = ',';
$data['attribs']['value'] = 1;
$data['attribs']['udt'] = null;
$data['attribs']['adv_start'] = -1;
$data['attribs']['adv_navhidden'] = 0;
$data['attribs']['gcb_prefix'] = '';
$data['attribs']['sortable_maxitems'] = -1;

//
// setup
//
if( isset($params['blockid']) ) {
  $blockid = (int)$params['blockid'];
  $query = 'SELECT * FROM '.cms_db_prefix().'module_cgcontentutils WHERE id = ?';
  $row = $db->GetRow($query,array($blockid));
  if( $row ) {
    $row['attribs'] = unserialize($row['attribs']);
    $data = $row;
  }
}

//
// process form data
//
if( isset($params['cancel']) ) {
  $this->RedirectToTab($id);
}
else if( isset($params['submit']) ) {
    $data['name'] = munge_string_to_url(trim($params['name']));
    $data['prompt'] = cge_utils::get_param($params,'prompt',$data['name']);
    $data['type'] = $params['type'];
    $data['value'] = trim($params['dfltvalue']);

  switch( $data['type'] ) {
  case 'textinput':
    $data['attribs']['length'] = (int)$params['length'];
    $data['attribs']['maxlength'] = (int)$params['maxlength'];
    break;

  case 'textarea':
    $data['attribs']['rows'] = (int)$params['rows'];
    $data['attribs']['cols'] = (int)$params['cols'];
    $data['attribs']['wysiwyg'] = (bool)$params['wysiwyg'];
    break;

  case 'statictext':
      $data['attribs']['fieldtext'] = trim($params['fieldtext']);
      break;

  case 'dropdown':
    $data['attribs']['options'] = trim($params['options']);
    break;

  case 'dropdown_udt':
      $data['attribs']['udt'] = trim($params['dropdown_udt']);
      break;

  case 'gcb_selector':
      $data['attribs']['gcb_prefix'] = trim($params['gcb_prefix']);
      break;

  case 'multiselect':
    $data['attribs']['options'] = trim($params['multiselect']);
    $data['attribs']['storagedelimiter'] = trim($params['storagedelimiter']);
    break;

  case 'sortable_list':
      $data['attribs']['options'] = trim($params['sortable_list']);
      $data['attribs']['sortable_maxitems'] = (int) trim($params['sortable_maxitems']);
      break;

  case 'checkbox':
    $data['attribs']['value'] = trim($params['value']);
    break;

  case 'radiobuttons':
    $data['attribs']['options'] = trim($params['radiooptions']);
    break;

  case 'file_selector':
    if( $params['directory'] == '0' || $params['directory'] == '/' ) $params['directory'] = '';
    $data['attribs']['dir'] = trim($params['directory']);
    $data['attribs']['excludeprefix'] = trim($params['excludeprefix']);
    $data['attribs']['filetypes'] = trim($params['filetypes']);
    $data['attribs']['recurse'] = (int)$params['recurse'];
    $data['attribs']['sortfiles'] = (int)$params['sortfiles'];
    break;

  case 'advpageselector':
      $data['attribs']['adv_start'] = (int)$params['adv_start'];
      $data['attribs']['adv_navhidden'] = (int)$params['adv_navhidden'];
      break;
  }

  try {
      // validate
      switch( $data['type'] ) {
      case 'textinput':
          if( $data['attribs']['length'] < 1 || $data['attribs']['maxlength'] < 1 ) throw new Exception($this->Lang('error_missing_param'));
          break;

      case 'textarea':
          if( $data['attribs']['rows'] < 1 || $data['attribs']['cols'] < 1 ) throw new Exception($this->Lang('error_missing_param'));
          break;

      case 'statictext':
          if( $data['attribs']['fieldtext'] == '' ) throw new Exception($this->Lang('error_missing_param'));
          break;

      case 'dropdown':
          if( $data['attribs']['options'] == '' ) throw new Exception($this->Lang('error_missing_param'));
          break;

      case 'multiselect':
          if( $data['attribs']['options'] == '' ) throw new Exception($this->Lang('error_missing_param'));
          if( $data['attribs']['storagedelimiter'] == '' ) throw new Exception($this->Lang('error_missing_param'));
          break;

      case 'checkbox':
          if( $data['attribs']['value'] == '' ) throw new Exception($this->Lang('error_missing_param'));
          break;

      case 'radiobuttons':
          if( $data['attribs']['options'] == '' ) throw new Exception($this->Lang('error_missing_param'));
          break;

      case 'file_selector':
          // no checking (yet).
          break;
      }

    // validate it.
    if( $data['name'] == '' ) throw new Exception($this->Lang('error_namerequired'));
    if( $data['prompt'] == '' ) $data['prompt'] = $data['name'];

    // and store it.
    $now = $db->DbTimeStamp(time());
    $sattribs = serialize($data['attribs']);
    if( $blockid != '' ) {
      $query = 'SELECT id FROM '.cms_db_prefix().'module_cgcontentutils WHERE name = ? AND id != ?';
      $tmp = $db->GetOne($query,array($data['name'],$blockid));
      if( $tmp ) throw new Exception($this->Lang('error_nameexists'));

      // it's an update
      $query = 'UPDATE '.cms_db_prefix()."module_cgcontentutils
                SET name = ?, prompt = ?, value = ?, type = ?, attribs = ?, modified_date = $now
                WHERE id = ?";
      $dbr = $db->Execute($query, array($data['name'],$data['prompt'],$data['value'], $data['type'],$sattribs,$blockid));

      $this->SetMessage($this->Lang('msg_blockupdated'));
      $this->RedirectToTab($id);
    }
    else {
      // it's an insert
      // check for a duplicate name first
      $query = 'SELECT id FROM '.cms_db_prefix().'module_cgcontentutils WHERE name = ?';
      $tmp = $db->GetOne($query,array($data['name']));
      if( $tmp ) throw new Exception($this->Lang('error_nameexists'));

      $query = 'INSERT INTO '.cms_db_prefix()."module_cgcontentutils (name,prompt,value,type,attribs,create_date,modified_date)
                VALUES (?,?,?,?,?,$now,$now)";
      $dbr = $db->Execute($query, array($data['name'],$data['prompt'],$data['value'], $data['type'],$sattribs));

      $this->SetMessage($this->Lang('msg_blockadded'));
      $this->RedirectToTab($id);
    } // insert
  }
  catch( Exception $e ) {
    echo $this->ShowErrors($e->GetMessage());
  }
}

//
// give everything to smarty
//
$dirs = array('/'=>'/');
$tmp = glob($config['uploads_path'].'/*',GLOB_ONLYDIR);
if( is_array($tmp) ) {
  for( $i = 0; $i < count($tmp); $i++ ) {
      $tmps = str_replace($config['uploads_path'].'/','',$tmp[$i]);
      if( startswith($tmps,'_') || startswith($tmps,'.') ) continue;
      $dirs[$tmps] = $tmps;
  }
  $smarty->assign('directories',$dirs);
}
$smarty->assign('formstart',$this->CGCreateFormStart($id,'admin_edit_block',$returnid,$params));
$smarty->assign('formend',$this->CreateFormEnd());
$blocktypes = array('pageselector'=>$this->Lang('blocktype_pageselector'),
                    'advpageselector'=>$this->Lang('blocktype_advpageselector'),
                    'textinput'=>$this->Lang('blocktype_textinput'),
                    'textarea'=>$this->Lang('blocktype_textarea'),
                    'statictext'=>$this->Lang('blocktype_statictext'),
                    'multiselect'=>$this->Lang('blocktype_multiselect'),
                    'dropdown'=>$this->Lang('blocktype_dropdown'),
                    'checkbox'=>$this->Lang('blocktype_checkbox'),
                    'radiobuttons'=>$this->Lang('blocktype_radiobuttons'),
                    'dropdown_udt'=>$this->Lang('blocktype_dropdown_udt'),
                    'file_selector'=>$this->Lang('file_selector'),
                    'gcb_selector'=>$this->Lang('gcb_selector'),
                    'sortable_list'=>$this->Lang('blocktype_sortable_list'));

$usertags = UserTagOperations::get_instance()->ListUserTags();
$smarty->assign('usertags',$usertags);

$smarty->assign('blocktypes',$blocktypes);
$smarty->assign('one',$data);

//
// display the template
//
echo $this->ProcessTemplate('admin_edit_block.tpl');
#
# EOF
#
?>