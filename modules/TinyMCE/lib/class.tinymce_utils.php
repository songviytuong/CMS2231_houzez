<?php
#CMS - CMS Made Simple
#(c)2004 by Ted Kulp (ted@cmsmadesimple.org)
#Visit our homepage at: http://www.cmsmadesimple.org
#
#This program is free software; you can redistribute it and/or modify
#it under the terms of the GNU General Public License as published by
#the Free Software Foundation; either version 2 of the License, or
#(at your option) any later version.
#
#This program is distributed in the hope that it will be useful,
#but WITHOUT ANY WARRANTY; without even the implied warranty of
#MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#GNU General Public License for more details.
#You should have received a copy of the GNU General Public License
#along with this program; if not, write to the Free Software
#Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
#

class tinymce_utils
{
  /* ********************************************************* */
  /* Get the modules that can be included in the WYSIWYG */
  /* Returns an array of modules names */
  /* ********************************************************* */
  public static function get_wysiwygitems_modules()
  {
    $modules_res = false;
    $modules = module_meta::get_instance()->module_list_by_capability('WYSIWYGItems');

    if (count($modules) == 0) return $modules_res;

    foreach ($modules as $module_name)
    {
      $mod = cms_utils::get_module($module_name);
      if ($mod)
      {
        $modules_res[$module_name]['friendlyname'] = $mod->GetFriendlyName();
        $modules_res[$module_name]['button_name'] = $mod->GetWYSIWYGBtnName();
      }
    }

    return $modules_res;
  }



  /* ********************************************************* */
  /* Returns the best profile for the current user */
  /* Returns a profile object */
  /* ********************************************************* */
  public static function get_best_profile()
  {

    // Get the current user groups
    if (cmsms()->is_frontend_request())
      $current_user_groups = array(-1); // Frontend
    else
    {
      // Backend
      $userid = get_userid(false);
      $current_user_groups = UserOperations::get_instance()->GetMemberGroups($userid);
    }

    $query = 'SELECT p.id_profile FROM '.CMS_DB_PREFIX.TINYMCE::TINYMCE_PROFILES_TABLE.' p
    JOIN '.CMS_DB_PREFIX . TINYMCE::TINYMCE_PROFILEGROUP_TABLE . ' pg ON (p.id_profile=pg.id_profile) WHERE id_group IN ('.implode(',', $current_user_groups).') ORDER BY p.priority';

    $id_best_profile = cmsms()->GetDb()->GetOne($query);

    if (!$id_best_profile)
    {
      // Get the default one
      $mod = cms_utils::get_module('TinyMCE');
      $id_best_profile = $mod->GetPreference('id_default_profile');
    }

    $best_profile = new tinymce_profile($id_best_profile);

    return($best_profile);
  }


  /* Can the current user (backend) use the filemanager ? - Used by ResponsiveFileManager to give the access, or not */
  public static function can_user_use_filemanager($profile)
  {
    if (cmsms()->is_frontend_request())
      return false;

    if (!$profile)
      return false;

    // Check if the current loggedin user can use the filemanager
    $mod = cms_utils::get_module('TinyMCE');

    if (!$mod->CheckPermission('Modify Files'))
      return false;

    if (!$profile->filemanager_use)
      return false;

    return true;
  }





  /* $id_profile = the ID of the profile from which the groups have to be loaded */
  public static function load_groups_from_profile($id_profile)
  {
    $query = 'SELECT id_group FROM '.CMS_DB_PREFIX.TinyMCE::TINYMCE_PROFILEGROUP_TABLE.' WHERE id_profile=?';
    $userprofiles = cmsms()->GetDb()->GetCol($query, array($id_profile));

    return $userprofiles;
  }


  /* ********************************************************* */
  /* Add groups in DB for a profile */
  /* ********************************************************* */
  /* $id_profile : id profile we want to link groups to */
  /* $id_groups : array of groups, or single ID */
  public static function add_groups_to_profile($id_profile, $id_groups)
  {
    if (!$id_groups) return false;

    if (is_int($id_groups))
      $id_groups = array((int)$id_groups);


    // First remove other associations
    if (!self::delete_profilegroups_from_idgroups($id_groups)) return false;


    // And insert to DB
    $insert_query = 'INSERT INTO '.CMS_DB_PREFIX.TinyMCE::TINYMCE_PROFILEGROUP_TABLE.' (id_profile, id_group) VALUES (?,?)';
    $db = cmsms()->GetDb();

    foreach ($id_groups as $id_group)
      if (!$db->Execute($insert_query, array($id_profile, $id_group)))
        return false;

    return true;
  }



  /* ********************************************************* */
  /* Delete groups from DB for a profile */
  /* ********************************************************* */
  /* $id_profile = the ID of the profile from which the groups have to be deleted */
  public static function delete_profilegroups_from_profile($id_profile)
  {
    $query = 'DELETE FROM '.CMS_DB_PREFIX.TinyMCE::TINYMCE_PROFILEGROUP_TABLE.' WHERE id_profile=?';
    return (cmsms()->GetDb()->Execute($query, array($id_profile)));
  }



  /* ********************************************************* */
  /* Delete profilegroups from ID array */
  /* ********************************************************* */
  /* $id_groups = (array) groups to delete from the profilegroups associations */
  public static function delete_profilegroups_from_idgroups($id_groups)
  {
    if (!$id_groups) return false;

    $query = 'DELETE FROM '.CMS_DB_PREFIX.TinyMCE::TINYMCE_PROFILEGROUP_TABLE.' WHERE id_group IN ('.implode(',',$id_groups).')';
    return (cmsms()->GetDb()->Execute($query));
  }





  /* ********************************************************* */
  /* Load all the profiles objects */
  /* ********************************************************* */
  public static function get_all_profiles_for_admin_list()
  {
    $db = cmsms()->GetDb();

    $query = 'SELECT id_profile FROM '.CMS_DB_PREFIX.TinyMCE::TINYMCE_PROFILES_TABLE. ' ORDER BY priority';
    $profiles = $db->GetCol($query);

    if (!$profiles) return false;

    // Load all the user groups from the groups manager
    $groups_array = self::get_user_groups();

    $profile_objs = array();
    foreach ($profiles as $id_profile)
    {
      $profile_obj = new tinymce_profile($id_profile);

      // Load the admin groups names
      $profile_obj->load_groups_data($groups_array);

      $profile_objs[] = $profile_obj;
    }

    return $profile_objs;
  }



  /* ********************************************************* */
  /* Load the CMS user groups to an array with ID as key and the group as obj */
  /* ********************************************************* */
  /* $add_frontend = create a special group with ID -1 to define frontend */
  public static function get_user_groups($add_frontend=true)
  {
    $groups = GroupOperations::get_instance()->LoadGroups();
    $groups_objs = array();
    foreach ($groups as $group)
      $groups_objs[$group->id] = $group;

    if ($add_frontend)
    {
      $mod = cms_utils::get_module('TinyMCE');
      $fe_group = new stdclass;
      $fe_group->id = -1;
      $fe_group->name = $mod->Lang('group_frontend');
      $fe_group->active = 1;

      $groups_objs[-1] = $fe_group;
    }

    return $groups_objs;
  }




  /* ********************************************************* */
  /* Load the templates based on type */
  /* ********************************************************* */
  public static function load_templates_by_type($type='js')
  {
    $tplType = CmsLayoutTemplateType::load('TinyMCE::'.$type);
    $query = new CmsLayoutTemplateQuery('t:'.$tplType->get_id());
    $templates = $query->GetMatches();

    return $templates;
  }




  /* ********************************************************* */
  /* Clear the JS cache */
  /* ********************************************************* */
  public static function clear_tinymce_cache()
  {
    $path = PUBLIC_CACHE_LOCATION;

    $files = glob($path . '/tinymce_*.js');
    if (is_array($files) && count($files))
      foreach ($files as $file)
        unlink($file);
  }
}

?>
