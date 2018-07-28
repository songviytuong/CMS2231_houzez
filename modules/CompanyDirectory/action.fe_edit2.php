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
if( !isset($gCms) ) exit;

$feu = $this->GetModuleInstance('FrontEndUsers');
if( !$feu ) {
    echo '<h3><font color="red">'.$this->Lang('error_nofeu')."</font></h3>\n";
    return;
}
else if( !$feu->LoggedIn() ) {
    echo '<h3><font color="red">'.$this->Lang('error_feu_loggedin')."</font></h3>\n";
    return;
}
$feu_uid = $feu->LoggedInId();

$thetemplate = 'frontendform_'.$this->GetPreference(COMPANYDIR_PREF_DFLTFRONTENDFORM_TEMPLATE);
if( isset($params['frontendformtemplate'] ) ) {
    $thetemplate = \cge_param::get_string($params,'frontendformtemplate');
    if( !endswith($thetemplate,'.tpl') ) $thetemplate = 'frontend_form_'.$thetemplate;
}

//
// Strip all params of the cd_ prefix
//
$p2 = array();
foreach( $params as $key => $value ) {
    $t = substr($key,0,3);
    if( $t == 'cd_' ) {
        $newkey = substr($key,3);
        $p2[$newkey] = $value;
    }
    else {
        $p2[$key] = $value;
    }
}
$params = $p2;

//
// initialization
//
$the_company = '';
$companyid = -1;
$uploader = null;
$tmp = cd_utils::get_fielddefs(false,true);
$fielddefs2 = array();
$have_album = null;
if( is_array($tmp) && count($tmp) ) {
    for( $i = 0; $i < count($tmp); $i++ ) {
        $rec = $tmp[$i];
        if( $rec['type'] == 'album' ) $have_album = $rec['id'];
        $fielddefs[$rec['id']] = cge_array::to_object($rec);
        $fielddefs2[$rec['name']] = cge_array::to_object($rec);
    }
}
$categories = $this->GetCategories();
$origname = '';
if( isset($params['companyid']) && (int)$params['companyid'] > 0 ) {
    $companyid = (int)$params['companyid'];
    $the_company = cd_company::load_by_id($companyid);
    if( $the_company->owner_id != $feu_uid ) {
        // this user does not have rights to this record...
        echo '<h3><font color="red">'.$this->Lang('error_feu_loggedin')."</font></h3>\n";
        return;
    }
    $origname = $the_company->company_name;
}
else {
    $the_company = new cd_company;
    $the_company->status = $this->GetPreference('frontend_newstatus','draft');
}


if( isset( $params['submit'] ) ) {
    //
    // handle form params
    //
    if (isset($params['origname'])) $origname = $params['origname'];

    $error = false;
    try {
        //
        // check file uploads for errors.
        //
        if( is_array($_FILES) && count($_FILES) ) {
            $uploader = new cd_upload_handler($id);
            foreach( $_FILES as $key => $data ) {
                $name = substr($key,strlen($id));
                $uploader->set_accepted_filetypes(); // set back to default file types.
                if( startswith($name,'cd_field_') ) {
                    $fid = (int)substr($name,strlen('cd_field_'));
                    $rec = $fielddefs[$fid]; // it had better exist..
                    if( ($rec->type == 'file' || $rec->type == 'image') && $rec->data ) $uploader->set_accepted_filetypes($rec->data);
                }

                if( !$uploader->check_upload($name,FALSE,FALSE) ) {
                    $res = $uploader->get_error();
                    if( $res != cg_fileupload::NOFILE ) throw new CompanyDirectoryException($this->GetUploadErrorMessage($res));
                }
            }
        }

        //
        // fill the company from params
        //
        if( $companyid == -1 ) {
            // it's a new company
            $the_company->setup_fields_and_cats();
        }
        else {
            // it's an edit
            $the_company->reset_categories();
        }

        foreach( $params as $key => $value ) {
            if( cd_company::is_valid_key($key,'rw') ) {
                switch( $key ) {
                case 'status':
                    if( $this->GetPreference('frontend_changestatus') ) $the_company->$key = $value;
                    break;

                default:
                    $the_company->$key = $value;
                    break;
                }
            }
            else if( $key == 'categories' && is_array($value) && count($value) ) {
                // handle selected categories.
                foreach( $value as $catid ) {
                    $the_company->set_category($catid);
                }
            }
            else if( startswith($key,'field_') ) {
                $k2 = substr($key,strlen('field_'));
                $the_company->set_field($k2,$value);
            }
        }

        //
        // error checking, fill in missing data.
        //
        $the_company->validate();

        if( $the_company->company_name != $origname && cd_utils::company_name_exists($the_company->company_name,$the_company->id) ) {
            throw new CompanyDirectoryException($this->Lang('error_companyname_inuse'));
        }

        if( !$the_company->id && $this->GetPreference('url_required',0) ) {
            $the_company->url = cd_utils::generate_url($company_name);
            if( !$the_company->url ) throw new CompanyDirectoryException($this->Lang('error_generateurl'));
        }

        // todo: need a company id here.
        $the_company->save();
        $destdir = cms_join_path($gCms->config['uploads_path'],'companydirectory','id'.$the_company->id);

        //
        // move logo and image now
        //
        if( is_object($uploader) ) {
            cge_dir::mkdirr($destdir);
            $uploader->set_dest_dir($destdir);
            $uploader->set_accepted_filetypes(); // set back to default file types.

            $uploader->set_current_value($the_company->logo_location);
            if( isset($params['deletelogo']) ) {
                $uploader->delete_uploads();
                $the_company->logo_location = '';
            }
            $res = $uploader->handle_upload('cd_logo');
            if( !$res ) {
                $err = $uploader->get_error();
                if( $err != cg_fileupload::NOFILE ) throw new CompanyDirectoryException($this->GetUploadErrorMessage($err));
            }
            else {
                $the_company->logo_location = $res;
            }
            $uploader->reset();

            $uploader->set_accepted_filetypes(); // set back to default file types.
            $uploader->set_current_value($the_company->picture_location);
            if( isset($params['deleteimage']) ) {
                $uploader->delete_uploads();
                $the_company->picture_location = '';
            }
            $res = $uploader->handle_upload('cd_image');
            if( !$res ) {
                $err = $uploader->get_error();
                if( $err != cg_fileupload::NOFILE ) throw new CompanyDirectoryException($this->GetUploadErrorMessage($err));
            }
            else {
                $the_company->picture_location = $res;
            }
            $uploader->reset();
        }


        //
        // move files from custom fields.
        //
        foreach( $fielddefs as $fid => $fielddef ) {
            if( $fielddef->type != 'file' && $fielddef->type != 'image' ) continue;
            $fld = $the_company->get_field($fielddef->id);
            if( isset($fld->value) && $fld->value ) $uploader->set_current_value($the_company->get_field($fielddef->id)->value);
            if( isset($params['deletefield_'.$fielddef->id]) ) {
                // handle deletions
                $uploader->delete_uploads();
                //$the_company->delete_field($fielddef->id);
                $the_company->set_field($fielddef->id,'');
            }
            if( $fielddef->data ) {
                $uploader->set_accepted_filetypes($fielddef->data);
            }
            else {
                $uploader->set_accepted_filetypes();
            }
            $res = $uploader->handle_upload('cd_field_'.$fielddef->id);
            if( $res ) $the_company->set_field($fielddef->id,$res);
            $uploader->reset();
        }

        //
        // save it..
        //
        $the_company->save();

        //
        // update search stuff
        //
        if( $the_company->status == 'published' ) {
            $module = cms_utils::get_search_module();
            if( $module ) $module->AddWords($this->GetName(), $the_company->id, 'company', $the_company->get_search_words() );
        }
        else {
            $module = cms_utils::get_search_module();
            if( $module ) $module->DeleteWords($this->GetName(), $the_company->id, 'company');
        }

        //
        // do email stuff
        //
        if( ($groupid = $this->GetPreference('frontend_emailgroup',-1)) > 0 ) {
            $addresses = array();
            $userops = $gCms->GetUserOperations();
            $users = $userops->LoadUsersInGroup($groupid);
            for( $i = 0; $i < count($users); $i++ ) {
                $user = $users[$i];
                if( !empty($user->email) ) $addresses[] = $user->email;
            }

            if( count($addresses) ) {
                if( ($behaviour == 'insert' && $this->GetPreference('frontend_emailonadd')) ||
                    ($behaviour == 'update' && $this->GetPreference('frontend_emailonedit')) ) {
                    // we can send something to somebody.
                    $vars = array('company_name','address','telephone','latitude','longitude',
                                  'fax','contact_email','website','details','feu_uid');
                    foreach( $vars as $one ) {
                        $smarty->assign($one,$$one);
                    }
                    if( count($fielddefs) ) $smarty->assign('fields',$fielddefs);
                    if( isset( $params['categories'] ) && count($categories) ) {
                        $cats = array();
                        foreach( $params['categories'] as $k => $v ) {
                            $cats[] = $v;
                        }

                        $catnames = array();
                        foreach( $categories as $onecat ) {
                            if( in_array($onecat->id,$cats) ) $catnames[] = $onecat->name;
                        }
                        $smarty->assign('categories',$catnames);
                    }

                    $feu = $this->GetModuleInstance('FrontEndUsers');
                    $res = $feu->GetUserInfo($feu_uid);
                    if( $res[0] == TRUE ) $smarty->assign('userinfo',$res[1]);

                    $body = $this->ProcessTemplateFromDatabase('admin_feedit_email_template');
                    $subject = $this->GetPreference('admin_feedit_email_subject');

                    $mailer = $this->GetModuleInstance('CMSMailer');
                    $mailer->reset();
                    $mailer->SetSubject($subject);
                    $mailer->IsHTML($this->GetPreference('admin_feedit_email_ishtml'));
                    $mailer->SetBody($body);
                    foreach( $addresses as $one ) {
                        $mailer->AddAddress($one);
                    }
                    $mailer->send();
                }
            }
        } // end of email stuff

        //
        // send the event
        //
        $the_company->set_readonly();
        $this->SendEvent('OnEditCompany',array('frontenduser'=>$feu_uid,'object'=>$the_company));

        audit($the_company->id,$this->GetName(),'Edited company '.$the_company->company_name.' via the frontend (FEU id = '.$feu_uid.')');

        //
        // redirect outa here
        //
        if( !empty($params['destpage']) ) {
            // assume it's a page alias or page id.
            $page_id = $this->resolve_alias_or_id($params['destpage']);
            if( $page_id ) $this->RedirectContent($page_id);
        }
        if( isset($params['referer']) ) {
            redirect($params['referer']);
        }

    }
    catch(CompanyDirectoryException $e) {
        if( $companyid == -1 ) {
            // do we really wanna delete the company? or go back into edit mode?
        }
        $smarty->assign('message',$e->getMessage());
        $error = true;
    }
} // submit

//
// Populate The Template
//
$tpl = $this->CreateSmartyTemplate($thetemplate);
$parms = array();
if( isset($_SERVER['HTTP_REFERER']) && !isset($params['cd_referer'])) $parms['cd_referer'] = $_SERVER['HTTP_REFERER'];
$parms['companyid'] = $companyid;
$parms['cd_owner_id'] = $feu_uid;
$parms['cd_origname'] = $origname;
if( isset($params['destpage']) ) $parms['cd_destpage'] = $params['destpage'];
$tpl->assign('startform',$this->CGCreateFormStart($id,'fe_edit2',$returnid, $parms,false,'post','multipart/form-data'));
$tpl->assign('endform',$this->CreateFormEnd());
$tpl->assign('the_company',$the_company);
if( $this->GetPreference('frontend_changestatus') ) {
    $statuses = array($this->Lang('published')=>'published',$this->Lang('draft')=>'draft');
    $tpl->assign('statuses',array_flip($statuses));
}
$tpl->assign('hierarchy_list',array_flip(cd_utils::get_hierarchy_list()));
if( is_array($categories) && count($categories) ) {
    $tpl->assign('categories',$categories);
    $catnames = $autocomplete_list = [];
    foreach( $categories as $onecat ) {
        $depth = count(explode('.',$onecat->hierarchy))-1;
        $catnames[$onecat->id] = str_repeat('&nbsp;&nbsp;',$depth).$onecat->name;
        $autocomplete_list[$onecat->id] = $onecat->long_name;
    }
    $tpl->assign('category_longnames',$autocomplete_list);
    $tpl->assign('catnames',$catnames);
    $tmp = $the_company->list_categories();
    $sel_categories = array();
    if( is_array($tmp) && count($tmp) ) {
        foreach( $tmp as $t ) {
            $t2 = $the_company->get_category($t);
            $sel_categories[] = $t2->id;
        }
    }
    $tpl->assign('sel_categories',$sel_categories);
}

if( is_array($fielddefs2) && count($fielddefs2) ) $tpl->assign('fielddefs',$fielddefs2);
if( $have_album ) $tpl->assign('album_id',$have_album);
$tpl->display();
