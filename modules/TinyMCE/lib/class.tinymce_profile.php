<?php


class tinymce_profile
{
  // Fields and default values
  protected $_flds = array(
    'id_profile' => 0,
    'id_template' => -1,
    'name' => '',
    'priority' => 5,
    'resize' => true,
    'autoresize' => true,

    'plugins' => 'autolink anchor code fullscreen image link media paste table visualblocks',
    'enable_linker' => true,

    'show_menubar' => true,
    'menubar' => 'edit insert view format table tools',
    'use_advanced_menu' => false,
    'advanced_menu' => "{
        edit: {title: 'Edit', items: 'undo redo | cut copy paste pastetext | selectall'},
        insert: {title: 'Insert', items: 'link media | template hr'},
        view: {title: 'View', items: 'visualaid'},
        format: {title: 'Format', items: 'bold italic underline strikethrough superscript subscript | formats | removeformat'},
        table: {title: 'Table', items: 'inserttable tableprops deletetable | cell row column'},
        tools: {title: 'Tools', items: 'spellchecker code'}
    }",

    'show_toolbar' => true,
    'toolbar1' => 'undo redo | cut copy paste | formatselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist | cmsms_linker link unlink responsivefilemanager image template | fullscreen code',
    'toolbar2' => '',

    'use_custom_block_formats' => false,
    'block_formats' => 'Paragraph=p;Header 1=h1;Header 2=h2;Header 3=h3;Header 4=h4;Header 5=h5;Header 6=h6',

    'enable_contextmenu' => true,
    'contextmenu' => 'cmsms_linker link image | inserttable cell row column deletetable',

    'show_statusbar' => false,

    'enable_custom_dropdown' => false,
    'custom_dropdown_title' => 'Extensions',
    'custom_dropdown' => "Root url|{root_url}\nSite name|{sitename}",

    // FILEMANAGER
    'filemanager_use' => true,
    'filemanager_delete_files' => true,
    'filemanager_create_folders' => true,
    'filemanager_delete_folders' => true,
    'filemanager_upload_files' => true,
    'filemanager_rename_files' => true,
    'filemanager_rename_folders' => true,
    'filemanager_duplicate_files' => true,
    'filemanager_copy_cut_files' => true,
    'filemanager_copy_cut_dirs' => true,
    'filemanager_chmod_files' => false,
    'filemanager_chmod_dirs' => false,
    'filemanager_preview_text_files' => true,
    'filemanager_create_text_files' => false,
    'filemanager_edit_text_files' => false,
    'filemanager_image_resizing' => false,
    'filemanager_image_resizing_width' => 0,
    'filemanager_image_resizing_height' => 0,
    'filemanager_aviary_active' => 1,
    'filemanager_aviary_apiKey' => '2444282ef4344e3dacdedc7a78f8877d', // RFM demo data

    'enable_user_templates' => false,

    // CSS design
    'id_design' => 0,
    'link_classes' => '',
    'image_classes' => '',
    'style_formats' => '',

    // EXTRA CONFIG
    'extra_js' => "paste_as_text: true,\nimage_caption: true",
    'external_modules' => false,
    'external_modules_show_menutext' => true,

    'forced_root_block' => 1,
    'relative_urls' => 1,
    'image_advtab' => 0
  );

  public $usergroups_ids = array();
  public $usergroups = array(); // Groups objs if loaded (see self::load_groups_data()


  /* ********************************************************* */
  /* Assign default fields or load profile from database */
  /* ********************************************************* */
  /* $id_profile = (int) ID of the profile to load, false if new profile
     $do_load = (bool) If ID is providen, determine if we should load the entire profile from DB */
  public function __construct($id_profile = false, $do_load=true)
  {
    if ($id_profile)
    {
      if ($do_load)
        return $this->load_profile_from_db($id_profile);
      else
        $this->id_profile = (int)$id_profile;
    }
    else
      return $this->load_profile_from_array($this->_flds);

    return true;
  }


  // Clone
  public function __clone()
  {
    $mod = cms_utils::get_module('TinyMCE');

    $this->id_profile = false;
    $this->name = $this->name . ' (' . $mod->Lang('copy') . ')';
    $this->usergroups_ids = array();
    $this->usergroups = array();
  }


  /* ********************************************************* */
  /* Load profile from array */
  /* ********************************************************* */
  public function load_profile_from_array($profile_array = array())
  {
    if (empty($profile_array)) return false;

    // Default empty value - if external modules are enabled, it will be loaded, if not it stays empty
    $this->external_modules = '';

    foreach ($profile_array as $fld_name => $fld_value) {
      if (array_key_exists($fld_name, $this->_flds))
      {
        // String to array
        if (($fld_name == 'external_modules') && !is_array($fld_value))
        {
          if (!empty($fld_value))
          {
            $fld_value = explode(',', $fld_value);
            $fld_value = array_map('trim', $fld_value);
          }
        }

        $this->$fld_name = $fld_value;
      }
    }

    // Usergroups ?
    if (isset($profile_array['usergroups']) and !empty($profile_array['usergroups']))
      $this->usergroups_ids = $profile_array['usergroups'];

    return true;
  }



  /* ********************************************************* */
  /* Load profile from db : retrieve from db and put in an array */
  /* ********************************************************* */
  /* $id_profile = the ID of the profile to load */
  public function load_profile_from_db($id_profile)
  {
    if (!$id_profile) return false;

    $query = 'SELECT * FROM '.CMS_DB_PREFIX.TinyMCE::TINYMCE_PROFILES_TABLE.' WHERE id_profile=?';
    $profile_array = cmsms()->GetDb()->GetRow($query, array($id_profile));

    if (!$profile_array) return false;

    // Load the users groups
    $profile_array['usergroups'] = tinymce_utils::load_groups_from_profile($id_profile);

    return $this->load_profile_from_array($profile_array);
  }




  /* ********************************************************* */
  /* Load user groups data/names */
  /* ********************************************************* */
  /* $groups_array : an array of id / groups objs from the CMS - useful to not load it several times - for example, for the list of profiles */
  public function load_groups_data($groups_objs=false)
  {
    if (!is_array($this->usergroups_ids))
      return false;

    if (!$groups_objs) //Load the groups from the CMS
      $groups_objs = tinymce_utils::get_user_groups();

    foreach ($this->usergroups_ids as $group_id)
      $this->usergroups[$group_id] = $groups_objs[$group_id];

    return true;
  }



  /* ********************************************************* */
  /* Save profile to DB */
  /* ********************************************************* */
  public function save()
  {
    if ($this->id_profile) // Edit
      $this->delete_from_db(); // Delete before re-adding it

    $query = 'INSERT INTO '.CMS_DB_PREFIX.TinyMCE::TINYMCE_PROFILES_TABLE.' ';

    $db_flds = array_keys($this->_flds);

    // Generate values for the query
    $query_values = array();
    foreach ($db_flds as $fld)
    {
      // Array or string ?
      if (!is_array($this->$fld))
        $query_values[$fld] = $this->$fld;
      else
      {
        if (!empty($this->$fld))
          $query_values[$fld] = implode(',', $this->$fld);
        else
          $query_values[$fld] = ''; // Empty array, we don't want to store a simple comma
      }
      $query_mask[] = '?'; // This is for the (?,?,?) mask for the query
    }

    $query .= '(' . implode(',', $db_flds) . ') ';
    $query .= 'VALUES ('.implode(',', $query_mask).')';

    $db = cmsms()->GetDb();

    if (!$db->Execute($query, $query_values))
      return false;


    if (!$this->id_profile)
      $this->id_profile = $db->Insert_ID();

    // Save groups
    if (!empty($this->usergroups_ids))
      tinymce_utils::add_groups_to_profile($this->id_profile, $this->usergroups_ids);

    return true;
  }



  /* ********************************************************* */
  /* Remove profile from DB */
  /* ********************************************************* */
  /* $id_profile (int) the profile id */
  public function delete_from_db()
  {
    if (!isset($this->id_profile)) return false;

    if (tinymce_utils::delete_profilegroups_from_profile($this->id_profile))
    {
      $query = 'DELETE FROM '.CMS_DB_PREFIX.TinyMCE::TINYMCE_PROFILES_TABLE.' WHERE id_profile=?';
      return (cmsms()->GetDb()->Execute($query, array($this->id_profile)));
    }
  }





  /* ********************************************************* */
  /* Generate config : return the JS string */
  /* ********************************************************* */
  /* $dev_mode = if true, load from the templates/orig_js_template.tpl file instead of the DesignManager - only for development purpose */
  public function get_js_config($language, $selector = null, $cssname = null)
  {
    $mod = cms_utils::get_module('TinyMCE');
    $smarty = cmsms()->GetSmarty();

    // FROM MT
    $ajax_url = function($url) {
        return str_replace('&amp;','&',$url).'&showtemplate=false';
    };

    // Load the template
    if ($this->id_template > 0)
    {
      try {
        $tpl = CmsLayoutTemplate::load($this->id_template);
        $tpl_name = $tpl->get_name();
      }
      catch( Exception $e ) {
        if (!isset($tpl))
          $this->id_template = -1;
      }
    }
    elseif ($this->id_template == 0)
    {
      $tpl = CmsLayoutTemplate::load_dflt_by_type('TinyMCE::js'); // DEFAULT FROM DESIGN MANAGER
      $tpl_name = $tpl->get_name();
    }

    if ($this->id_template == -1)
      $tpl_name = 'orig_js_template.tpl';

    $tpl = $smarty->CreateTemplate($mod->GetTemplateResource($tpl_name), null, null, $smarty);
    // End template loading


    $assign['TinyMCE'] = $mod;
    $assign['profile'] = $this;
    $assign['language'] = $language;

    if ($selector)
      $assign['selector'] = $selector;

    // CSS
    if ($cssname && !empty($cssname))
    {
      $assign['content_css'] = smarty_cms_function_cms_stylesheet(['cssname'=>$cssname, 'nolinks'=>1], cmsms()->GetSmarty());
    }
    elseif ($this->id_design > 0)
    {
      if (function_exists('smarty_cms_function_cms_stylesheet'))
        $assign['content_css'] = smarty_cms_function_cms_stylesheet(['designid'=>$this->id_design, 'nolinks'=>1], cmsms()->GetSmarty());
      else
        $assign['content_css'] = $mod->ProcessTemplateFromData('{cms_stylesheet designid=' . $this->id_design . ' nolinks=1}');
    }


    // STYLES FORMATS
    if (!empty($this->style_formats))
    {
      $styles_res = array();
      $styles = explode(PHP_EOL, $this->style_formats);

      foreach ($styles as $style_format)
      {
        $styles_res[] = $style_format;
      }
      $assign['style_formats'] = $styles_res;
    }

    // LINK CLASSES
    if (!empty($this->link_classes))
    {
      $classes_res = array($mod->Lang('none') => '');
      $classes = explode(PHP_EOL, $this->link_classes);

      foreach ($classes as $class)
      {
        list($class_title, $class_names) = explode('=', $class);
        $classes_res[trim($class_title)] = $class_names;
      }
      $assign['link_classes'] = $classes_res;
    }

    // IMAGE CLASSES
    if (!empty($this->image_classes))
    {
      $classes_res = array($mod->Lang('none') => '');
      $classes = explode(PHP_EOL, $this->image_classes);

      foreach ($classes as $class)
      {
        list($class_title, $class_names) = explode('=', $class);
        $classes_res[trim($class_title)] = $class_names;
      }
      $assign['image_classes'] = $classes_res;
    }

    // Load the cmsms_linker plugin
    $assign['enable_linker'] = 0;
    if (!cmsms()->is_frontend_request() && $this->enable_linker)
    {
      $assign['enable_linker'] = 1;

      $url = $mod->create_url('m1_','linker');
      $assign['linker_url'] = $ajax_url($url);
      $url = $mod->create_url('m1_','ajax_getpages');
      $assign['getpages_url'] = $ajax_url($url);
    }

    // Load the file manager ?
    if (tinymce_utils::can_user_use_filemanager($this))
    {
      $assign['can_use_filemanager'] = 1;

      // Get the access key
      $salt = $mod->GetPreference('filemanager_salt');
      $userid = get_userid();
      $access_key = md5($userid.$salt);
      $assign['access_key'] = $access_key;
    }

    // Load user templates ?
    if ($this->enable_user_templates)
    {
      $user_templates = tinymce_utils::load_templates_by_type('usertemplate');
      if (!empty($user_templates))
        $assign['user_templates'] = $user_templates;
    }

    // Use custom dropdown ?
    if ($this->enable_custom_dropdown && !empty($this->custom_dropdown))
    {
      $custom_dropdown = explode("\n", $this->custom_dropdown);
      $custom_dropdown_array = false;
      $i = 0;

      foreach ($custom_dropdown as $entry)
      {
        @list($entry_title, $entry_value1, $entry_value2) = explode('|', $entry);
        $custom_dropdown_array[$i]['title'] = $entry_title;
        $custom_dropdown_array[$i]['value1'] = $entry_value1;
        if (!empty($entry_value2))
          $custom_dropdown_array[$i]['value2'] = $entry_value2;

        $i++;
      }

      $assign['custom_dropdown'] = $custom_dropdown_array;
    }

    // External modules
    $external_modules = false;
    if (!empty($this->external_modules))
    {
      foreach ($this->external_modules as $mod_name)
      {
        $ext_mod = cms_utils::get_module($mod_name);

        if ($ext_mod)
        {
          $btn_obj = $ext_mod->GetWYSIWYGBtn('TinyMCE');

          if ($btn_obj)
            $external_modules[$mod_name] = $btn_obj;
        }
      }
    }
    $assign['external_modules'] = $external_modules;

    $tpl->assign($assign);

    return $tpl->fetch();
  }


  /* ********************************************************* */
  // Load the filemanager config for responsivefilemanager
  /* ********************************************************* */
  public function get_filemanager_config($filemanager_config)
  {
    $mod = cms_utils::get_module('TinyMCE');

    // URL without protocol since 2.2
    $filemanager_config['base_url'] = '//'.$_SERVER['HTTP_HOST'];

    // We do this for websites that are in a subdirectory (ie www.mywebsite.com/cmsms/)
    // Get subdir
    $subdir = str_replace('/modules/TinyMCE/responsive_filemanager/filemanager/dialog.php', '', $_SERVER['PHP_SELF']);
    $filemanager_config['upload_dir'] = $subdir . '/uploads/';

    

    // ACCESS KEY
    $salt = $mod->GetPreference('filemanager_salt');
    $userid = get_userid();
    $access_key = md5($userid.$salt);
    $filemanager_config['access_keys'] = array($access_key);

    // CONFIGURATION
    $filemanager_options = array(
      'delete_files',
      'create_folders',
      'delete_folders',
      'upload_files',
      'rename_files',
      'rename_folders',
      'duplicate_files',
      'copy_cut_files',
      'copy_cut_dirs',
      'chmod_files',
      'chmod_dirs',
      'preview_text_files',
      'edit_text_files',
      'create_text_files',
      'aviary_active',
      'aviary_apiKey'
    );
    foreach ($filemanager_options as $opt) {
      $var = "filemanager_".$opt;
      $filemanager_config[$opt] = $this->$var;
    }

    // Configuration name error in RFM
    // image_resizing_width should be image_max_width
    // same for height
    // br #11344
    if ($this->filemanager_image_resizing)
    {
      $filemanager_config['image_max_width'] = $this->filemanager_image_resizing_width;
      $filemanager_config['image_max_height'] = $this->filemanager_image_resizing_height;
    }


    // Language
    $default_cms_language = cms_userprefs::get_for_user($userid, 'default_cms_language');

    if (!empty($default_cms_language) && ($default_cms_language != 'en_US'))
      $filemanager_config['default_language'] = $default_cms_language;

    // Aviary language
    $filemanager_config['aviary_language'] = substr($default_cms_language, 0, 2);

    return $filemanager_config;
  }
}
?>
