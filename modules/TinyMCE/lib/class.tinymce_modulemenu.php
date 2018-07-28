<?php

// Class that can be used by external modules to generate a dropdown menu with items

class tinymce_modulemenu
{
  public $module_name='';
  public $button_name=''; // Example : module_gallery
  public $title='';
  public $tooltip='';
  public $icon='sun';
  public $image='';
  public $menu_section='insert';
  public $menu_entries=array();


  // $menu_entries example :
  /*

  $menu_entries = array(
    array(
      'menu_text' => 'Gallery 1',
      'content' => "{Gallery dir='dir1'}",
      'childrens' => array(
        array(
          'menu_text' => 'SubGallery 1.1',
          'content' => "{Gallery dir='subdir11'}"
        ),
        array(
          'menu_text' => 'SubGallery 1.2',
          'content' => "{Gallery dir='subdir12'}"
        ),
        array(
          'menu_text' => 'SubGallery 1.3',
          'content' => "{Gallery dir='subdir13'}"
        )
      )
    ),
    array(
      'menu_text' => 'Gallery 2',
      'content' => "{Gallery dir='dir2'}",
      'childrens' => array(
        array(
          'menu_text' => 'SubGallery 2.1',
          'content' => "{Gallery dir='subdir21'}"
        ),
        array(
          'menu_text' => 'SubGallery 2.2',
          'content' => "{Gallery dir='subdir22'}"
        ),
        array(
          'menu_text' => 'SubGallery 2.3',
          'content' => "{Gallery dir='subdir23'}"
        )
      )
    )
  );

  */
}
?>
