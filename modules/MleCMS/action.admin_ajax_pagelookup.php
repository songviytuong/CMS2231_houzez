<?php

if( !isset($gCms) ) exit;

$out = array();
//
//if( isset($_REQUEST['term']) ) {
//  // find all pages with this text...
//  // that this user can edit.
//  $term = trim(strip_tags($_REQUEST['term']));
//
//  $pref = $this->GetPreference('list_namecolumn','title');
//  $field = 'content_name';
//  if( $pref != 'title' ) $field = 'menu_text';
//
//  $query = 'SELECT content_id,hierarchy,'.$field.' FROM '.CMS_DB_PREFIX.'content WHERE '.$field.' LIKE ?';
//  $parms = array('%'.$term.'%');
//
//  if( !$this->CheckPermission('Manage All Content') && !$this->CheckPermission('Modify Any Page') ) {
//    $pages = author_pages(get_userid(FALSE));
//    if( count($pages) == 0 ) return;
//
//    // query only these pages.
//    $query .= ' AND content_id IN ('.implode(',',$pages).')';
//  }
//
//  $list = $db->GetArray($query,$parms);
//  if( is_array($list) && count($list) ) {
//    $builder = new ContentListBuilder($this);
//    $builder->expand_all(); // it'd be cool to open all parents to each item.
//    $contentops = ContentOperations::get_instance();
//    foreach( $list as $row ) {
//      $label = $contentops->CreateFriendlyHierarchyPosition($row['hierarchy']);
//      $label = $row[$field]." ({$label})";
//      $out[] = array('label'=>$label,'value'=>$row['content_id']);
//    }
//  }
//}
$out[] = array('label'=>'Lee Peace','value'=>'Hello');
echo json_encode($out);
exit;

#
# EOF
#
?>